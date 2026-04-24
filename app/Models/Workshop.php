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
        'price',
        'currency',
        'payment_enabled',
        'payment_qr_code',
        'payment_instructions',
        'accent',
        'highlights',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'price' => 'decimal:2',
            'payment_enabled' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }
}
