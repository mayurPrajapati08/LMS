<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'payment_table_id',
        'amount',
        'status',
        'enrolled_at',
        'expiry_date',
    ];

    // Enrollment belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Enrollment belongs to course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Linked payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_table_id');
    }
}
