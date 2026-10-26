<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Live_Event;
use App\Models\Category;
use App\Models\Video_Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class VideoSeriesController extends Controller
{
    private $folder = "video_series";
    public $common;

    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {
            $params['data'] = [];
            $params['categories'] = Category::where('status', 1)->orderBy('name')->get();

            if ($request->ajax()) {
                $input_search = $request['input_search'];

                $data = Video_Series::latest();
                if ($input_search != null && isset($input_search)) {
                    $data->where('title', 'LIKE', "%{$input_search}%");
                }
                $data = $data->get();

                $this->common->imageNameToUrl($data, 'portrait_img', $this->folder);
                $this->common->imageNameToUrl($data, 'landscape_img', $this->folder);

                $episode_counts = Live_Event::query()
                    ->whereNotNull('video_series_id')
                    ->selectRaw('video_series_id, count(*) as total')
                    ->groupBy('video_series_id')
                    ->pluck('total', 'video_series_id');

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('episode_count', function ($row) use ($episode_counts) {
                        return $episode_counts[$row->id] ?? 0;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1) {
                            return "<button type='button' style='background:#058f00; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>Published</button>";
                        } else {
                            return "<button type='button' style='background:#e3000b; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>Hidden</button>";
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $delete = '<form onsubmit="return confirm(\'Are you sure !!! You want to Delete this Series ? Its episodes will become standalone videos.\');" method="POST"  action="' . route('videoseries.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around" title="Edit">';
                        $btn .= '<a class="edit-delete-btn" title="' . __('Label.episodes') . '" href="' . route('video.index', ['series_id' => $row->id]) . '"><i class="fa-solid fa-list-ol fa-xl"></i></a>';
                        $btn .= '<a class="edit-delete-btn edit_video_series" title="Edit" data-toggle="modal" href="#EditModel"'
                            . ' data-id="' . $row->id . '"'
                            . ' data-title="' . e($row->title) . '"'
                            . ' data-description="' . e($row->description) . '"'
                            . ' data-category_id="' . $row->category_id . '"'
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

            return view('admin.video_series.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules(true));
            if ($validator->fails()) {
                return response()->json(array('status' => 400, 'errors' => $validator->errors()->all()));
            }

            $row = $request->only(['title', 'description', 'category_id', 'status']);
            $row['category_id'] = $row['category_id'] ?: null;
            $row['portrait_img'] = $this->common->saveImage($request->file('portrait_img'), $this->folder, "video_series_");
            $row['landscape_img'] = $this->common->saveImage($request->file('landscape_img'), $this->folder, "video_series_");

            $data = Video_Series::create($row);

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
            $series = Video_Series::where('id', $request->id)->first();
            if (!isset($series)) {
                return response()->json(array('status' => 400, 'errors' => __('Label.data_not_updated')));
            }

            $validator = Validator::make($request->all(), $this->rules(false));
            if ($validator->fails()) {
                return response()->json(array('status' => 400, 'errors' => $validator->errors()->all()));
            }

            $row = $request->only(['title', 'description', 'category_id', 'status']);
            $row['category_id'] = $row['category_id'] ?: null;

            if ($request->hasFile('portrait_img')) {
                $row['portrait_img'] = $this->common->saveImage($request->file('portrait_img'), $this->folder, "video_series_");
                $this->common->deleteImageToFolder($this->folder, $series->portrait_img);
            }
            if ($request->hasFile('landscape_img')) {
                $row['landscape_img'] = $this->common->saveImage($request->file('landscape_img'), $this->folder, "video_series_");
                $this->common->deleteImageToFolder($this->folder, $series->landscape_img);
            }

            $series->update($row);

            return response()->json(array('status' => 200, 'success' => __('Label.data_edit_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        try {
            $data = Video_Series::where('id', $id)->first();

            if (isset($data)) {
                // Episodes keep existing as standalone videos rather than being deleted.
                Live_Event::where('video_series_id', $id)->update(['video_series_id' => null, 'episode_number' => null]);
                $this->common->deleteImageToFolder($this->folder, $data['portrait_img']);
                $this->common->deleteImageToFolder($this->folder, $data['landscape_img']);
                $data->delete();
            }
            return redirect()->route('videoseries.index')->with('success', __('Label.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    private function rules($is_store)
    {
        return [
            'title' => 'required|min:2|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:tbl_category,id',
            'status' => 'required|in:0,1',
            'portrait_img' => ($is_store ? 'required|' : '') . 'image|mimes:jpeg,png,jpg|max:2048',
            'landscape_img' => ($is_store ? 'required|' : '') . 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
