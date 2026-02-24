<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads_Premium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class AdsPremiumController extends Controller
{
    public function index(Request $request)
    {
        try {
            $params['data'] = [];

            if ($request->ajax()) {
                $input_search = $request['input_search'];

                $data = Ads_Premium::orderBy('id', 'DESC');
                if ($input_search != null && isset($input_search)) {
                    $data->where(function ($query) use ($input_search) {
                        $query->where('crea_name', 'LIKE', "%{$input_search}%")
                            ->orWhere('image_url', 'LIKE', "%{$input_search}%");
                    });
                }

                $data = $data->get();

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $delete = '<form onsubmit="return confirm(\'Are you sure !!! You want to Delete this Ads Premium ?\');" method="POST"  action="' . route('adspremium.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around" title="Edit">';
                        $btn .= '<a class="edit-delete-btn edit_ads_premium" title="Edit" data-toggle="modal" href="#EditModel" data-id="' . $row->id . '" data-crea_name="' . e($row->crea_name) . '" data-image_url="' . e($row->image_url) . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</a></div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('admin.ads_premium.index', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'crea_name' => 'required|min:2',
                'image_url' => 'required|url',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $data = Ads_Premium::updateOrCreate(['id' => $requestData['id']], $requestData);

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
                'crea_name' => 'required|min:2',
                'image_url' => 'required|url',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $requestData = $request->all();
            $data = Ads_Premium::updateOrCreate(['id' => $requestData['id']], $requestData);

            if (isset($data->id)) {
                return response()->json(array('status' => 200, 'success' => __('Label.data_edit_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('Label.data_not_updated')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        try {
            Ads_Premium::where('id', $id)->delete();
            return redirect()->route('adspremium.index')->with('success', __('Label.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
