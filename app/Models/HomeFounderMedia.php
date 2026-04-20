<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeFounderMedia extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'description',
        'badge',
        'video_provider',
        'video_url',
        'poster_provider',
        'poster_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
