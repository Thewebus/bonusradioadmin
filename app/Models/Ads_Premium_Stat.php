<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// Daily view/click counters for one ad (see tbl_ads_premium_stat).
class Ads_Premium_Stat extends Model
{
    protected $table = 'tbl_ads_premium_stat';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'ads_premium_id' => 'integer',
        'views' => 'integer',
        'clicks' => 'integer',
    ];

    // Adds 1 to today's `views` or `clicks` for the ad, creating the day's
    // row on first hit — a single atomic statement, safe under concurrency.
    public static function track(int $adId, string $counter): void
    {
        if (!in_array($counter, ['views', 'clicks'], true)) {
            return;
        }
        DB::statement(
            "INSERT INTO tbl_ads_premium_stat (ads_premium_id, date, {$counter}, created_at, updated_at)
             VALUES (?, CURDATE(), 1, NOW(), NOW())
             ON DUPLICATE KEY UPDATE {$counter} = {$counter} + 1, updated_at = NOW()",
            [$adId]
        );
    }
}
