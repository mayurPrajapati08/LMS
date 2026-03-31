<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Video;

class Section extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'order_number',
    ];

    // Section belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Section has many videos (lessons)
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
