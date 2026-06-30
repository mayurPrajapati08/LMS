<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    protected $fillable = [
        'job_opening_id',
        'name',
        'email',
        'phone',
        'experience',
        'current_ctc',
        'expected_salary',
        'notice_period',
        'current_location',
        'portfolio_url',
        'cover_note',
        'resume_path',
        'resume_original_name',
        'status',
        'reviewed_by',
        'reviewed_at',
        'hr_notes',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function jobOpening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function resumeUrl(): ?string
    {
        return $this->resume_path ? Storage::disk('public')->url($this->resume_path) : null;
    }
}
