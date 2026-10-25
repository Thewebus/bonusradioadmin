<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video_Series extends Model
{
    use HasFactory;

    protected $table = 'tbl_video_series';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'portrait_img' => 'string',
        'landscape_img' => 'string',
        'category_id' => 'integer',
        'status' => 'integer',
    ];

    public function episodes()
    {
        return $this->hasMany(Live_Event::class, 'video_series_id');
    }
}
