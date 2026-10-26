<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'tbl_banner';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'type' => 'integer',
        'content_id' => 'integer',
        'sort_order' => 'integer',
        'status' => 'integer',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class, 'content_id');
    }
    public function podcast()
    {
        return $this->belongsTo(Podcast::class, 'content_id');
    }
    // type 3: a standalone video (film)
    public function video()
    {
        return $this->belongsTo(Live_Event::class, 'content_id');
    }
    // type 4: a whole series
    public function series()
    {
        return $this->belongsTo(Video_Series::class, 'content_id');
    }
}
