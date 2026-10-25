@extends('admin.layout.page-app')
@section('page_title', __('Label.ads_stats'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <h1 class="page-title-sm">{{ __('Label.ads_stats') }}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Label.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('adspremium.index') }}">{{ __('Label.ads_premium') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Label.ads_stats') }}</li>
                    </ol>
                </div>
            </div>

            @php
                $query = array_filter([
                    'ad_id' => $ad->id ?? null,
                    'from' => $from->toDateString(),
                    'to' => $to->toDateString(),
                ]);
                $maxDaily = max(1, (int) $daily->max('views'));
            @endphp

            <div class="card custom-border-card mt-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('adspremium.stats') }}" class="form-row align-items-end">
                        <div class="col-md-4 form-group">
                            <label>{{ __('Label.ads_premium') }}</label>
                            <select name="ad_id" class="form-control">
                                <option value="">{{ __('Label.ads_all') }}</option>
                                @foreach ($ads as $item)
                                    <option value="{{ $item->id }}" {{ ($ad->id ?? null) == $item->id ? 'selected' : '' }}>{{ $item->crea_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>{{ __('Label.ads_period_from') }}</label>
                            <input type="date" name="from" class="form-control" value="{{ $from->toDateString() }}">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>{{ __('Label.ads_period_to') }}</label>
                            <input type="date" name="to" class="form-control" value="{{ $to->toDateString() }}">
                        </div>
                        <div class="col-md-4 form-group text-right">
                            <button type="submit" class="btn btn-default mw-120">{{ __('Label.ads_filter') }}</button>
                            <a href="{{ route('adspremium.stats.pdf', $query) }}" class="btn btn-default mw-120"><i class="fa-solid fa-file-pdf mr-2"></i>{{ __('Label.ads_export_pdf') }}</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card custom-border-card text-center p-3">
                        <div class="text-gray">{{ __('Label.ads_views') }}</div>
                        <h3 class="mb-0">{{ number_format($total_views, 0, ',', ' ') }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card custom-border-card text-center p-3">
                        <div class="text-gray">{{ __('Label.ads_clicks') }}</div>
                        <h3 class="mb-0">{{ number_format($total_clicks, 0, ',', ' ') }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card custom-border-card text-center p-3">
                        <div class="text-gray">{{ __('Label.ads_ctr') }}</div>
                        <h3 class="mb-0">{{ number_format($total_ctr, 2, ',', ' ') }} %</h3>
                    </div>
                </div>
            </div>

            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{ $ad ? $ad->crea_name : __('Label.ads_all') }} — {{ $from->format('d/m/Y') }} → {{ $to->format('d/m/Y') }}</h5>
                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{ __('Label.nom_crea') }}</th>
                                <th>{{ __('Label.Status') }}</th>
                                <th>{{ __('Label.ads_views') }}</th>
                                <th>{{ __('Label.ads_clicks') }}</th>
                                <th>{{ __('Label.ads_ctr') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    <td class="text-left">{{ $row->crea_name }}</td>
                                    <td>
                                        @if ($row->status == 1)
                                            <span class="badge badge-success">{{ __('Label.Active') }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ __('Label.ads_inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($row->views, 0, ',', ' ') }}</td>
                                    <td>{{ number_format($row->clicks, 0, ',', ' ') }}</td>
                                    <td>{{ number_format($row->ctr, 2, ',', ' ') }} %</td>
                                    <td>
                                        @unless ($ad)
                                            <a href="{{ route('adspremium.stats', ['ad_id' => $row->id, 'from' => $from->toDateString(), 'to' => $to->toDateString()]) }}" title="{{ __('Label.ads_daily_detail') }}"><i class="fa-solid fa-magnifying-glass-chart fa-lg"></i></a>
                                        @endunless
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">{{ __('Label.ads_no_data') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($ad)
                <div class="card custom-border-card mt-3">
                    <h5 class="card-header">{{ __('Label.ads_daily_detail') }}</h5>
                    <div class="table-responsive table">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="background: #F9FAFF;">
                                    <th style="width: 130px;">{{ __('Label.ads_date') }}</th>
                                    <th style="width: 110px;" class="text-center">{{ __('Label.ads_views') }}</th>
                                    <th style="width: 110px;" class="text-center">{{ __('Label.ads_clicks') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daily as $day)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ number_format($day->views, 0, ',', ' ') }}</td>
                                        <td class="text-center">{{ number_format($day->clicks, 0, ',', ' ') }}</td>
                                        <td>
                                            <div style="background: #E3352B; height: 12px; border-radius: 6px; width: {{ max(1, round($day->views * 100 / $maxDaily)) }}%;"></div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center">{{ __('Label.ads_no_data') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
