<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;

class Wishlist extends Model
{
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
