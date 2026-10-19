<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Event_Join_User;
use Illuminate\Http\Request;
use Exception;

/**
 * "Live events" were merged into the video catalog (is_vod=1) — this
 * controller now only serves the "who purchased/joined this" report
 * (Event_Join_User has no is_vod constraint, so it already works for any
 * tbl_live_event row, video or not), reachable from the Video admin's
 * row actions instead of its own former CRUD screen.
 */
class LiveEventController extends Controller
{
    public $common;
    public function __construct()
    {
        $this->common = new Common;
    }

    // Join User
    public function LiveEventIndex($id, Request $request)
    {
        try {

            $params['data'] = [];
            $params['liveevent_id'] = $id;

            if ($request->ajax()) {

                $input_search = $request['input_search'];
                $input_type = $request['input_type'];

                if ($input_search != null && isset($input_search)) {

                    if ($input_type == "today") {

                        $data = Event_Join_User::with('user')
                            ->whereHas('user', function ($query) use ($input_search) {
                                $query->Where('full_name', 'LIKE', "%{$input_search}%");
                                $query->orWhere('email', 'LIKE', "%{$input_search}%");
                                $query->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                            ->orWhere('transaction_id', 'LIKE', "%{$input_search}%")->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))
                            ->whereYear('created_at', date('Y'))->latest()->get();
                    } else if ($input_type == "month") {

                        $data = Event_Join_User::with('user')
                            ->whereHas('user', function ($query) use ($input_search) {
                                $query->Where('full_name', 'LIKE', "%{$input_search}%");
                                $query->orWhere('email', 'LIKE', "%{$input_search}%");
                                $query->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                            ->orWhere('transaction_id', 'LIKE', "%{$input_search}%")->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                    } else if ($input_type == "year") {

                        $data = Event_Join_User::with('user')
                            ->whereHas('user', function ($query) use ($input_search) {
                                $query->Where('full_name', 'LIKE', "%{$input_search}%");
                                $query->orWhere('email', 'LIKE', "%{$input_search}%");
                                $query->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                            ->orWhere('transaction_id', 'LIKE', "%{$input_search}%")->whereYear('created_at', date('Y'))->latest()->get();
                    } else {

                        $data = Event_Join_User::with('user')
                            ->whereHas('user', function ($query) use ($input_search) {
                                $query->Where('full_name', 'LIKE', "%{$input_search}%");
                                $query->orWhere('email', 'LIKE', "%{$input_search}%");
                                $query->orWhere('mobile_number', 'LIKE', "%{$input_search}%");
                            })
                            ->orWhere('transaction_id', 'LIKE', "%{$input_search}%")->latest()->get();
                    }
                } else {

                    if ($input_type == "today") {
                        $data = Event_Join_User::where('live_event_id', $id)->with('user')->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                    } else if ($input_type == "month") {
                        $data = Event_Join_User::where('live_event_id', $id)->with('user')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get();
                    } else if ($input_type == "year") {
                        $data = Event_Join_User::where('live_event_id', $id)->with('user')->whereYear('created_at', date('Y'))->latest()->get();
                    } else {
                        $data = Event_Join_User::where('live_event_id', $id)->with('user')->latest()->get();
                    }
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) use ($id) {
                        $delete = '<form onsubmit="return confirm(\'Are you sure !!! You want to Delete this User ?\');" method="POST"  action="' . route('liveevent.user.delete', [$id, $row->id]) . '">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= $delete;
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->addColumn('date', function ($row) {
                        $date = date("Y-m-d", strtotime($row->created_at));
                        return $date;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.live_event.join_user', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function LiveEventDelete($liveevent_id, $id)
    {
        try {

            $data = Event_Join_User::where('id', $id)->first();
            if (isset($data)) {
                $data->delete();
            }
            return redirect()->route('liveevent.user.index', $liveevent_id)->with('success', __('Label.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}
