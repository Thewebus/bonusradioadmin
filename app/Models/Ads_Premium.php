<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads_Premium extends Model
{
    use HasFactory;

    protected $table = 'tbl_ads_premium';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'crea_name' => 'string',
        'image' => 'string',
        'image_url' => 'string',
        'link_url' => 'string',
        'display_duration' => 'integer',
        'status' => 'integer',
    ];

    public function stats()
    {
        return $this->hasMany(Ads_Premium_Stat::class, 'ads_premium_id');
    }
}
