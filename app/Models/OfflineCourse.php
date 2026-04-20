<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineCourse extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'summary',
        'details',
        'thumbnail',
        'campus',
        'schedule_label',
        'duration_label',
        'validity_label',
        'delivery_mode',
        'placement_label',
        'audience',
        'batch_size',
        'language',
        'level',
        'highlights',
        'curriculum_modules',
        'additional_benefits',
        'learner_note',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'curriculum_modules' => 'array',
        'additional_benefits' => 'array',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
