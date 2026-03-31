<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;

class CourseMaterial extends Model
{
    protected $fillable = [
        'video_id',
        'title',
        'file_url',
        'type',
        'is_downloadable',
    ];

    protected $casts = [
        'is_downloadable' => 'boolean',
    ];

    // Belongs to video
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
