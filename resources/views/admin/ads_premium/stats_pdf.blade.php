<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Statistiques publicités</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .muted { color: #777; }
        .header { border-bottom: 2px solid #E3352B; padding-bottom: 8px; margin-bottom: 14px; }
        .kpis { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin: 0 -8px 16px; }
        .kpis td { background: #F6F6F8; border-radius: 6px; padding: 10px; text-align: center; width: 25%; }
        .kpis .value { font-size: 18px; font-weight: bold; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.data th { background: #F9FAFF; text-align: left; padding: 6px; border-bottom: 1px solid #ddd; }
        table.data td { padding: 6px; border-bottom: 1px solid #eee; }
        table.data .num { text-align: right; }
        table.data tfoot td { font-weight: bold; border-top: 2px solid #ccc; }
        .bar { background: #E3352B; height: 8px; border-radius: 4px; }
        h2 { font-size: 13px; margin: 18px 0 6px; }
        .footer { position: fixed; bottom: -10px; left: 0; right: 0; font-size: 9px; color: #999; text-align: center; }
    </style>
</head>
<body>
    @php $maxDaily = max(1, (int) $daily->max('views')); @endphp

    <div class="header">
        <h1>Statistiques publicités — myBonus</h1>
        <div>{{ $ad ? 'Publicité : ' . $ad->crea_name : 'Toutes les publicités' }}</div>
        <div class="muted">Période du {{ $from->format('d/m/Y') }} au {{ $to->format('d/m/Y') }}</div>
    </div>

    <table class="kpis">
        <tr>
            <td><div class="muted">Impressions</div><div class="value">{{ number_format($total_views, 0, ',', ' ') }}</div></td>
            <td><div class="muted">Utilisateurs uniques</div><div class="value">{{ number_format($total_uniques, 0, ',', ' ') }}</div><div class="muted">{{ number_format($total_frequency, 1, ',', ' ') }} impr. / utilisateur</div></td>
            <td><div class="muted">Clics</div><div class="value">{{ number_format($total_clicks, 0, ',', ' ') }}</div></td>
            <td><div class="muted">Taux de clic</div><div class="value">{{ number_format($total_ctr, 2, ',', ' ') }} %</div></td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Publicité</th>
                <th>Statut</th>
                <th class="num">Impressions</th>
                <th class="num">Uniques</th>
                <th class="num">Impr./util.</th>
                <th class="num">Clics</th>
                <th class="num">Taux de clic</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    <td>{{ $row->crea_name }}</td>
                    <td>{{ $row->status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td class="num">{{ number_format($row->views, 0, ',', ' ') }}</td>
                    <td class="num">{{ number_format($row->uniques, 0, ',', ' ') }}</td>
                    <td class="num">{{ number_format($row->frequency, 1, ',', ' ') }}</td>
                    <td class="num">{{ number_format($row->clicks, 0, ',', ' ') }}</td>
                    <td class="num">{{ number_format($row->ctr, 2, ',', ' ') }} %</td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">Aucune vue enregistrée sur cette période.</td></tr>
            @endforelse
        </tbody>
        @if ($rows->count() > 1)
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td class="num">{{ number_format($total_views, 0, ',', ' ') }}</td>
                    <td class="num">{{ number_format($total_uniques, 0, ',', ' ') }}</td>
                    <td class="num">{{ number_format($total_frequency, 1, ',', ' ') }}</td>
                    <td class="num">{{ number_format($total_clicks, 0, ',', ' ') }}</td>
                    <td class="num">{{ number_format($total_ctr, 2, ',', ' ') }} %</td>
                </tr>
            </tfoot>
        @endif
    </table>

    @if ($ad)
        <h2>Détail jour par jour</h2>
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 80px;">Date</th>
                    <th class="num" style="width: 70px;">Impressions</th>
                    <th class="num" style="width: 60px;">Uniques</th>
                    <th class="num" style="width: 50px;">Clics</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daily as $day)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                        <td class="num">{{ number_format($day->views, 0, ',', ' ') }}</td>
                        <td class="num">{{ number_format($day->uniques, 0, ',', ' ') }}</td>
                        <td class="num">{{ number_format($day->clicks, 0, ',', ' ') }}</td>
                        <td><div class="bar" style="width: {{ max(1, round($day->views * 100 / $maxDaily)) }}%;"></div></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="muted">Aucune vue enregistrée sur cette période.</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">Généré le {{ $generated_at }} — Impression = 1 affichage de l'affiche à l'écran. Utilisateur unique = 1 téléphone distinct sur toute la période.</div>
</body>
</html>
