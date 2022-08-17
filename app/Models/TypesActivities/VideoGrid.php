<?php

namespace App\Models\TypesActivities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGrid extends Model
{
    //use HasFactory;

    protected $table = 'video_grids';

    protected $fillable = ['videos'];

    protected $casts = [
        'videos' => 'array'
    ];

    const COMPONENT = 'VIDEO_GRID';
}
