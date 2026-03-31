<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;

class CourseProgress extends Model
{
    protected $table = 'course_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'video_id',
        'watched_durations',
        'last_watched_seconds',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'watched_durations' => 'integer',
        'last_watched_seconds' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
