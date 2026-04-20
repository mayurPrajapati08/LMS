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
        'topic',
        'subject',
        'status',
        'source_page',
        'access_context',
        'access_granted_at',
        'details',
        'assigned_to',
        'contacted_at',
        'follow_up_at',
        'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'access_granted_at' => 'datetime',
            'contacted_at' => 'datetime',
            'follow_up_at' => 'datetime',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
