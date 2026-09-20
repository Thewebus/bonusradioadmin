<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Live_Event;
use App\Models\Video_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;

/**
 * Video-on-demand catalogue. Rows live in tbl_live_event (is_vod = 1) so the
 * paid/free + join flow already used by live events keeps working; `date`
 * is the last day the video stays available (2099-12-31 = no expiry).
 */
class VideoController extends Controller
{
    private $folder = "live_event";
    private $video_folder = "video";
    private $no_expiry_date = "2099-12-31";
    private $video_extensions = ['mp4', 'webm', 'mov'];
    public $common;

    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {
            $params['data'] = [];
            $params['categories'] = Video_Category::where('status', 1)->orderBy('name')->get();

            if ($request->ajax()) {
                $input_search = $request['input_search'];

                $data = Live_Event::where('is_vod', 1)->latest();
                if ($input_search != null && isset($input_search)) {
                    $data->where('title', 'LIKE', "%{$input_search}%");
                }
                $data = $data->get();

                $category_names = Video_Category::pluck('name', 'id');

                $this->common->imageNameToUrl($data, 'portrait_img', $this->folder);
                $this->common->imageNameToUrl($data, 'landscape_img', $this->folder);

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function ($row) use ($category_names) {
                        return e($category_names[$row->category_id] ?? '-');
                    })
                    ->addColumn('available_until', function ($row) {
                        return $row->date >= $this->no_expiry_date ? 'Unlimited' : e($row->date);
                    })
                    ->addColumn('source', function ($row) {
                        return $row->video_source == 2 ? 'Uploaded file' : 'External link';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1) {
                            return "<button type='button' style='background:#058f00; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>Published</button>";
                        } else {
                            return "<button type='button' style='background:#e3000b; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>Hidden</button>";
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $delete = '<form onsubmit="return confirm(\'Are you sure !!! You want to Delete this Video ?\');" method="POST"  action="' . route('video.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $until = $row->date >= $this->no_expiry_date ? '' : $row->date;

                        $btn = '<div class="d-flex justify-content-around" title="Edit">';
                        $btn .= '<a class="edit-delete-btn edit_video" title="Edit" data-toggle="modal" href="#EditModel"'
                            . ' data-id="' . $row->id . '"'
                            . ' data-title="' . e($row->title) . '"'
                            . ' data-description="' . e($row->description) . '"'
                            . ' data-category_id="' . $row->category_id . '"'
                            . ' data-video_source="' . $row->video_source . '"'
                            . ' data-link="' . e($row->link) . '"'
                            . ' data-date="' . e($until) . '"'
                            . ' data-is_paid="' . $row->is_paid . '"'
                            . ' data-price="' . $row->price . '"'
                            . ' data-status="' . $row->status . '"'
                            . ' data-portrait_img="' . e($row->portrait_img) . '"'
                            . ' data-landscape_img="' . e($row->landscape_img) . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            return view('admin.video.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules($request, true));
            if ($validator->fails()) {
                return response()->json(array('status' => 400, 'errors' => $validator->errors()->all()));
            }
            if ($request->video_source == 2 && !Storage::disk('public')->exists($this->video_folder . '/' . $request->video_file)) {
                return response()->json(array('status' => 400, 'errors' => 'The uploaded video file was not found on the server.'));
            }

            $row = $this->payload($request);
            $row['portrait_img'] = $this->common->saveImage($request->file('portrait_img'), $this->folder, "live_event_");
            $row['landscape_img'] = $this->common->saveImage($request->file('landscape_img'), $this->folder, "live_event_");

            $data = Live_Event::create($row);

            if (isset($data->id)) {
                return response()->json(array('status' => 200, 'success' => __('Label.data_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('Label.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        try {
            $video = Live_Event::where('id', $request->id)->where('is_vod', 1)->first();
            if (!isset($video)) {
                return response()->json(array('status' => 400, 'errors' => __('Label.data_not_updated')));
            }

            $validator = Validator::make($request->all(), $this->rules($request, false));
            if ($validator->fails()) {
                return response()->json(array('status' => 400, 'errors' => $validator->errors()->all()));
            }
            if ($request->video_source == 2 && !Storage::disk('public')->exists($this->video_folder . '/' . $request->video_file)) {
                return response()->json(array('status' => 400, 'errors' => 'The uploaded video file was not found on the server.'));
            }

            $row = $this->payload($request);

            if ($request->hasFile('portrait_img')) {
                $row['portrait_img'] = $this->common->saveImage($request->file('portrait_img'), $this->folder, "live_event_");
                $this->common->deleteImageToFolder($this->folder, $video->portrait_img);
            }
            if ($request->hasFile('landscape_img')) {
                $row['landscape_img'] = $this->common->saveImage($request->file('landscape_img'), $this->folder, "live_event_");
                $this->common->deleteImageToFolder($this->folder, $video->landscape_img);
            }

            // The previous uploaded file is no longer referenced once the link/file changes.
            if ($video->video_source == 2 && $video->link != $row['link']) {
                $this->common->deleteImageToFolder($this->video_folder, $video->link);
            }

            $video->update($row);

            return response()->json(array('status' => 200, 'success' => __('Label.data_edit_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        try {
            $data = Live_Event::where('id', $id)->where('is_vod', 1)->first();

            if (isset($data)) {
                $this->common->deleteImageToFolder($this->folder, $data['portrait_img']);
                $this->common->deleteImageToFolder($this->folder, $data['landscape_img']);
                if ($data->video_source == 2) {
                    $this->common->deleteImageToFolder($this->video_folder, $data['link']);
                }
                $data->delete();
            }
            return redirect()->route('video.index')->with('success', __('Label.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    /**
     * Receives one plupload chunk of a video file. Sits inside the authadmin
     * group (unlike the older song/podcast chunk routes), only accepts a
     * whitelist of video extensions and never trusts the client-sent name
     * for anything but its extension and an alphanumeric temp token.
     */
    public function saveChunk(Request $request)
    {
        @set_time_limit(5 * 60);

        $file = $request->file('file');
        if (!$file || !$file->isValid()) {
            return $this->chunkError(103, 'Failed to receive the uploaded chunk.');
        }

        $name = (string) $request->input('name', '');
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($extension, $this->video_extensions)) {
            return $this->chunkError(104, 'Only mp4, webm and mov files are allowed.');
        }
        $token = preg_replace('/[^A-Za-z0-9]/', '', pathinfo($name, PATHINFO_FILENAME));
        if ($token === '') {
            return $this->chunkError(105, 'Invalid file name.');
        }

        $dir = storage_path('app/public/' . $this->video_folder);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        // Drop abandoned partial uploads older than 5 hours.
        foreach (glob($dir . DIRECTORY_SEPARATOR . '*.part') ?: [] as $stale) {
            if (filemtime($stale) < time() - 5 * 3600) {
                @unlink($stale);
            }
        }

        $chunk = (int) $request->input('chunk', 0);
        $chunks = (int) $request->input('chunks', 0);
        $part = $dir . DIRECTORY_SEPARATOR . $token . '.part';

        $out = @fopen($part, $chunk === 0 ? 'wb' : 'ab');
        $in = @fopen($file->getRealPath(), 'rb');
        if (!$out || !$in) {
            return $this->chunkError(102, 'Failed to open the output stream.');
        }
        stream_copy_to_stream($in, $out);
        fclose($in);
        fclose($out);

        if (!$chunks || $chunk == $chunks - 1) {
            $final = 'video_' . date('d_m_Y_') . rand(1111, 9999) . '.' . $extension;
            rename($part, $dir . DIRECTORY_SEPARATOR . $final);
            return response()->json(array('jsonrpc' => '2.0', 'result' => $final, 'id' => 'id'));
        }

        return response()->json(array('jsonrpc' => '2.0', 'result' => null, 'id' => 'id'));
    }

    private function chunkError($code, $message)
    {
        return response()->json(array('jsonrpc' => '2.0', 'error' => array('code' => $code, 'message' => $message), 'id' => 'id'), 400);
    }

    private function rules(Request $request, $is_store)
    {
        $rules = [
            'title' => 'required|min:2|max:255',
            'category_id' => 'required|exists:tbl_video_category,id',
            'video_source' => 'required|in:1,2',
            'is_paid' => 'required|in:0,1',
            'status' => 'required|in:0,1',
            'date' => 'nullable|date',
            'portrait_img' => ($is_store ? 'required|' : '') . 'image|mimes:jpeg,png,jpg|max:2048',
            'landscape_img' => ($is_store ? 'required|' : '') . 'image|mimes:jpeg,png,jpg|max:2048',
        ];
        if ($request->video_source == 1) {
            $rules['link'] = 'required|url|max:255';
        } else {
            $rules['video_file'] = ['required', 'regex:/^video_[0-9_]+\.(mp4|webm|mov)$/'];
        }
        if ($request->is_paid == 1) {
            $rules['price'] = 'required|integer|min:1';
        }
        return $rules;
    }

    private function payload(Request $request)
    {
        return [
            'title' => $request->title,
            'description' => $request->description ?? '',
            'category_id' => $request->category_id,
            'is_vod' => 1,
            'type' => 2,
            'video_source' => $request->video_source,
            'link' => $request->video_source == 2 ? $request->video_file : $request->link,
            'is_paid' => $request->is_paid,
            'price' => $request->is_paid == 1 ? $request->price : 0,
            'status' => $request->status,
            'date' => $request->date ?: $this->no_expiry_date,
            'start_time' => '00:00',
            'end_time' => '23:59',
        ];
    }
}
