<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'subtitle',
        'date_label',
        'time_label',
        'format',
        'venue',
        'audience',
        'mentor',
        'seats',
        'accent',
        'highlights',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
