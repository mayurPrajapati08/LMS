<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'course_id',
        'message',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
