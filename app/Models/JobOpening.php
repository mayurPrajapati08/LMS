<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'employment_type',
        'work_mode',
        'location',
        'experience',
        'salary',
        'summary',
        'skills',
        'color',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
