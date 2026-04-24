<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopRegistration extends Model
{
    protected $fillable = [
        'workshop_id',
        'name',
        'email',
        'phone',
        'city',
        'organization',
        'learner_type',
        'experience_level',
        'attendance_mode',
        'goals',
        'questions',
        'payment_amount',
        'currency',
        'payment_reference',
        'payment_screenshot_path',
        'payment_status',
        'registration_status',
        'reviewed_by',
        'reviewed_at',
        'hr_notes',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'payment_amount' => 'decimal:2',
            'reviewed_at' => 'datetime',
        ];
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
