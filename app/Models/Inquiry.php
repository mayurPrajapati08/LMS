<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;

class Inquiry extends Model
{
    protected $table = 'course_inquiries';

    protected $fillable = [
        'user_id',
        'course_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'admin_reply',
    ];

    // Belongs to user (nullable)
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
