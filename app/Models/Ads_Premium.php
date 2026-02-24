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
        'image_url' => 'string',
        'status' => 'integer',
    ];
}
