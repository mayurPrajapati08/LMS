<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeStory extends Model
{
    protected $fillable = [
        'type',
        'name',
        'course',
        'comment',
        'avatar',
        'media_type',
        'media_provider',
        'rating',
        'company',
        'role',
        'package',
        'shared_at',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'shared_at' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
