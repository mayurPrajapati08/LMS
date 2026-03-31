<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'payment_getway',
        'payment_id',
        'amount',
        'status',
    ];

    // Payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Payment belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // One payment can create one enrollment
    public function enrollment()
    {
        return $this->hasOne(Enrollment::class, 'payment_table_id');
    }
}
