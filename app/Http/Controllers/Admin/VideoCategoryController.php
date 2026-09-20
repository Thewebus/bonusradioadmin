<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Live_Event;
use App\Models\Video_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class VideoCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $params['data'] = [];

            if ($request->ajax()) {
                $input_search = $request['input_search'];

                $data = Video_Category::orderBy('id', 'DESC');
                if ($input_search != null && isset($input_search)) {
                    $data->where('name', 'LIKE', "%{$input_search}%");
                }

                $data = $data->get();

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1) {
                            return "<button type='button' style='background:#058f00; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>Active</button>";
                        } else {
                            return "<button type='button' style='background:#e3000b; font-weight:bold; border: none; color: white; padding: 5px 15px; outline: none;border-radius: 5px;cursor: pointer;'>Hidden</button>";
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $delete = '<form onsubmit="return confirm(\'Are you sure !!! You want to Delete this Video Category ?\');" method="POST"  action="' . route('videocategory.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around" title="Edit">';
                        $btn .= '<a class="edit-delete-btn edit_video_category" title="Edit" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-status="' . $row->status . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            return view('admin.video_category.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:255',
                'status' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return response()->json(array('status' => 400, 'errors' => $validator->errors()->all()));
            }

            $data = Video_Category::create($request->only(['name', 'status']));

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
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:tbl_video_category,id',
                'name' => 'required|min:2|max:255',
                'status' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return response()->json(array('status' => 400, 'errors' => $validator->errors()->all()));
            }

            Video_Category::where('id', $request->id)->update($request->only(['name', 'status']));

            return response()->json(array('status' => 200, 'success' => __('Label.data_edit_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        try {
            // Videos keep working without a category rather than pointing at a deleted one.
            Live_Event::where('is_vod', 1)->where('category_id', $id)->update(['category_id' => null]);
            Video_Category::where('id', $id)->delete();
            return redirect()->route('videocategory.index')->with('success', __('Label.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
