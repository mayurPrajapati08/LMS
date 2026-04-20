<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAchievement extends Model
{
    protected $fillable = [
        'kind',
        'gallery_category',
        'gallery_category_order',
        'eyebrow',
        'title',
        'copy',
        'stat',
        'icon',
        'points',
        'media_url',
        'media_type',
        'media_provider',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'array',
            'is_active' => 'boolean',
            'gallery_category_order' => 'integer',
        ];
    }
}
