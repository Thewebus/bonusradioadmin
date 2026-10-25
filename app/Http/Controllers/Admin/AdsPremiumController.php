<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads_Premium;
use App\Models\Ads_Premium_Stat;
use App\Models\Common;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

// Ads shown in the app's radio-screen slideshow ("zone pub"): poster
// (uploaded, or an external image URL), display duration, optional
// click-through link, and daily view/click stats with a PDF export.
class AdsPremiumController extends Controller
{
    private $folder = "ads_premium";
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
                $input_search = $request['input_search'];

                $data = Ads_Premium::withSum('stats as total_views', 'views')
                    ->withSum('stats as total_clicks', 'clicks')
                    ->orderBy('id', 'DESC');
                if ($input_search != null && isset($input_search)) {
                    $data->where(function ($query) use ($input_search) {
                        $query->where('crea_name', 'LIKE', "%{$input_search}%")
                            ->orWhere('link_url', 'LIKE', "%{$input_search}%");
                    });
                }

                $data = $data->get();
                foreach ($data as $row) {
                    $row['image_preview'] = $this->imageUrl($row);
                }

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $delete = '<form onsubmit="return confirm(\'Are you sure !!! You want to Delete this Ads Premium ?\');" method="POST"  action="' . route('adspremium.destroy', [$row->id]) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="edit-delete-btn" style="outline: none;" title="Delete"><i class="fa-solid fa-trash-can fa-xl"></i></button></form>';

                        $btn = '<div class="d-flex justify-content-around">';
                        $btn .= '<a class="edit-delete-btn" title="Stats" href="' . route('adspremium.stats', ['ad_id' => $row->id]) . '"><i class="fa-solid fa-chart-column fa-xl"></i></a>';
                        $btn .= '<a class="edit-delete-btn edit_ads_premium" title="Edit" data-toggle="modal" href="#EditModel"'
                            . ' data-id="' . $row->id . '"'
                            . ' data-crea_name="' . e($row->crea_name) . '"'
                            . ' data-image_url="' . e($row->image ? '' : $row->image_url) . '"'
                            . ' data-image_preview="' . e($row->image_preview) . '"'
                            . ' data-link_url="' . e($row->link_url) . '"'
                            . ' data-display_duration="' . $row->display_duration . '"'
                            . ' data-status="' . $row->status . '">';
                        $btn .= '<i class="fa-solid fa-pen-to-square fa-xl"></i>';
                        $btn .= '</a>';
                        $btn .= $delete;
                        $btn .= '</div>';
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
            $validator = Validator::make($request->all(), $this->rules(true), $this->messages());
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $row = $this->payload($request);
            if ($request->hasFile('image')) {
                $row['image'] = $this->common->saveImage($request->file('image'), $this->folder, "ads_");
            }
            $data = Ads_Premium::create($row);

            if (isset($data->id)) {
                return response()->json(array('status' => 200, 'success' => __('Label.data_add_successfully')));
            } else {
                return response()->json(array('status' => 400, 'errors' => __('Label.data_not_added')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ad = Ads_Premium::find($id);
            if (!$ad) {
                return response()->json(array('status' => 400, 'errors' => __('Label.data_not_updated')));
            }

            $validator = Validator::make($request->all(), $this->rules(false, $ad), $this->messages());
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            }

            $row = $this->payload($request);
            if ($request->hasFile('image')) {
                $row['image'] = $this->common->saveImage($request->file('image'), $this->folder, "ads_");
                $row['image_url'] = null;
                $this->common->deleteImageToFolder($this->folder, $ad->image);
            } else if (!empty($row['image_url']) && $ad->image) {
                // Switched from an uploaded poster to an external URL.
                $this->common->deleteImageToFolder($this->folder, $ad->image);
                $row['image'] = null;
            }
            $ad->update($row);

            return response()->json(array('status' => 200, 'success' => __('Label.data_edit_successfully')));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        try {
            $ad = Ads_Premium::find($id);
            if ($ad) {
                $this->common->deleteImageToFolder($this->folder, $ad->image);
                $ad->delete(); // daily stats go with it (FK cascade)
            }
            return redirect()->route('adspremium.index')->with('success', __('Label.data_delete_successfully'));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Stats page: totals per ad over a period, or one ad's day-by-day detail.
    public function stats(Request $request)
    {
        try {
            $params = $this->statsData($request);
            $params['ads'] = Ads_Premium::orderBy('crea_name')->get(['id', 'crea_name']);
            return view('admin.ads_premium.stats', $params);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Same figures as the stats page, as a downloadable PDF report.
    public function statsPdf(Request $request)
    {
        try {
            $params = $this->statsData($request);
            $params['generated_at'] = Carbon::now()->format('d/m/Y H:i');

            $name = 'stats-pubs_' . $params['from']->format('Y-m-d') . '_' . $params['to']->format('Y-m-d');
            if ($params['ad']) {
                $name .= '_' . preg_replace('/[^A-Za-z0-9]+/', '-', $params['ad']->crea_name);
            }

            return Pdf::loadView('admin.ads_premium.stats_pdf', $params)
                ->setPaper('a4')
                ->download($name . '.pdf');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // Period defaults to the last 30 days; `ad_id` narrows to one ad and
    // adds its per-day breakdown.
    private function statsData(Request $request)
    {
        $to = $request->filled('to') ? Carbon::parse($request->to)->startOfDay() : Carbon::today();
        $from = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : $to->copy()->subDays(29);
        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        $ad = $request->filled('ad_id') ? Ads_Premium::find($request->ad_id) : null;

        $range = function ($query) use ($from, $to) {
            $query->whereBetween('date', [$from->toDateString(), $to->toDateString()]);
        };

        $adsQuery = Ads_Premium::withSum(['stats as views' => $range], 'views')
            ->withSum(['stats as clicks' => $range], 'clicks')
            ->orderBy('crea_name');
        if ($ad) {
            $adsQuery->where('id', $ad->id);
        }
        $rows = $adsQuery->get()->map(function ($row) {
            $row->views = (int) $row->views;
            $row->clicks = (int) $row->clicks;
            $row->ctr = $row->views > 0 ? round($row->clicks * 100 / $row->views, 2) : 0;
            return $row;
        });

        $daily = collect();
        if ($ad) {
            $daily = Ads_Premium_Stat::where('ads_premium_id', $ad->id)
                ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
                ->orderBy('date')
                ->get();
        }

        $totalViews = $rows->sum('views');
        $totalClicks = $rows->sum('clicks');

        return [
            'from' => $from,
            'to' => $to,
            'ad' => $ad,
            'rows' => $rows,
            'daily' => $daily,
            'total_views' => $totalViews,
            'total_clicks' => $totalClicks,
            'total_ctr' => $totalViews > 0 ? round($totalClicks * 100 / $totalViews, 2) : 0,
        ];
    }

    // Uploaded poster wins over the external URL.
    private function imageUrl($row)
    {
        if (!empty($row->image)) {
            return $this->common->Get_Image($this->folder, $row->image);
        }
        return $row->image_url ?: asset('assets/imgs/no_img.png');
    }

    private function rules($creating, $ad = null)
    {
        // A poster is required: a file, or an external URL, or (on edit)
        // the one already stored.
        $hasExisting = $ad && (!empty($ad->image) || !empty($ad->image_url));
        return [
            'crea_name' => 'required|min:2',
            'image' => ($creating || !$hasExisting ? 'required_without:image_url|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url' => 'nullable|url',
            'link_url' => 'nullable|url',
            'display_duration' => 'required|integer|min:3|max:120',
            'status' => 'nullable|in:0,1',
        ];
    }

    private function messages()
    {
        return [
            'image.required_without' => 'Upload a poster image or enter an image URL.',
        ];
    }

    private function payload(Request $request)
    {
        return [
            'crea_name' => $request->crea_name,
            'image_url' => $request->image_url ?: null,
            'link_url' => $request->link_url ?: null,
            'display_duration' => (int) $request->display_duration,
            'status' => $request->has('status') ? (int) $request->status : 1,
        ];
    }
}
