<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Common;
use App\Models\Live_Event;
use App\Models\Video_Series;
use App\Models\Podcast;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class BannerController extends Controller
{
    private $folder_song = "song";
    private $folder_podcast = "podcast";
    private $folder_live_event = "live_event";
    private $folder_video_series = "video_series";
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    public function index(Request $request)
    {
        try {
            $params['data'] = [];

            if ($request->ajax()) {
                $data = Banner::with('song', 'podcast', 'video', 'series')->orderBy('sort_order')->orderBy('id', 'desc')->get()->toArray();

                $result = [];
                foreach ($data as $key => $value) {

                    if ($value['type'] == 2 && $value['podcast'] != null) {
                        
                        if($value['podcast']['status'] == 1){
                            $value['image'] = $this->common->Get_Image($this->folder_podcast, $value['podcast']['portrait_img']);
                            $value['title'] = $value['podcast']['title'];
                            $value['type'] =  'Podcast';
                            unset($value['podcast'], $value['song']);
                            $result[] = $value;
                        }
                    } elseif ($value['type'] == 1 && $value['song'] != null) {

                        $value['image'] = $this->common->Get_Image($this->folder_song, $value['song']['image']);
                        $value['title'] = $value['song']['name'];
                        $value['type'] =  'Radio Station';
                        unset($value['podcast'], $value['song']);
                        $result[] = $value;
                    } elseif ($value['type'] == 3 && $value['video'] != null) {
                        $value['image'] = $this->common->Get_Image($this->folder_live_event, $value['video']['portrait_img']);
                        $value['title'] = $value['video']['title'];
                        $value['type'] = __('Label.banner_video');
                        $result[] = $value;
                    } elseif ($value['type'] == 4 && $value['series'] != null) {
                        $value['image'] = $this->common->Get_Image($this->folder_video_series, $value['series']['portrait_img']);
                        $value['title'] = $value['series']['title'];
                        $value['type'] = __('Label.banner_series');
                        $result[] = $value;
                    }
                    unset($value['video'], $value['series']);
                }

                return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully'), 'result' => $result));
            }

            return view('admin.banner.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'content_id' => 'required|numeric',
                'type' => 'required'
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $check = Banner::where('type', $request->type)->where('content_id', $request->content_id)->first();
            if (isset($check) && $check != null) {
                return response()->json(array('status' => 400, 'errors' => "This Banner Already Added."));
            }

            $insert = new Banner();
            $insert->content_id = $request->content_id;
            $insert->type = $request->type;
            // New banners go last; the order is changed from the list.
            $insert->sort_order = (Banner::max('sort_order') ?? 0) + 1;

            if ($insert->save()) {
                return response()->json(array('status' => 200, 'success' => __('Label.banner_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('Label.banner_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function show($id)
    {
        try {

            Banner::where('id', $id)->delete();
            return response()->json(array('status' => 200, 'success' => __('Label.data_delete_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function getcontent(Request $request)
    {
        try {
            $content_type = $request->content_type;
            $content = [];

            if ($content_type == 1) {
                $content = Song::where('status', 1)->get();
            } elseif ($content_type == 2) {
                $content = Podcast::where('status', 1)->get();
            } elseif ($content_type == 3) {
                // Standalone videos only — an episode is promoted through its series.
                $content = Live_Event::where('status', 1)->whereNull('video_series_id')->orderBy('title')->get(['id', 'title']);
            } elseif ($content_type == 4) {
                $content = Video_Series::where('status', 1)->orderBy('title')->get(['id', 'title']);
            }
            return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully'), 'content' => $content));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Saves the display order: "ids" = banner ids, first shown first.
    public function sort(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (!is_array($ids)) {
                return response()->json(array('status' => 400, 'errors' => 'Invalid order'));
            }
            foreach (array_values($ids) as $i => $id) {
                Banner::where('id', (int) $id)->update(['sort_order' => $i + 1]);
            }
            return response()->json(array('status' => 200, 'success' => __('Label.banner_order_saved')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
