<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_url',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    // Belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
