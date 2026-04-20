<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\PlatformSettings;

class AppSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => PlatformSettings::forget());
        static::deleted(fn () => PlatformSettings::forget());
    }
}
