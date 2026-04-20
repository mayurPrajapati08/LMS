<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'highlight',
        'description',
        'badge',
        'accent',
        'stat_label',
        'stat_value',
        'media_type',
        'media_url',
        'poster_url',
        'image',
        'primary_url',
        'primary_label',
        'secondary_url',
        'secondary_label',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
