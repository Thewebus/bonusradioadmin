<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video_Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_video_category';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'integer',
    ];
}
