<?php

namespace App\Support;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class PlatformSettings
{
    private const CACHE_KEY = 'platform_settings.map';

    public static function all(): array
    {
        if (! Schema::hasTable('app_settings')) {
            return [];
        }

        return Cache::remember(self::CACHE_KEY, now()->addMinutes(10), fn () => AppSetting::query()->pluck('value', 'key')->all());
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        return filter_var(self::get($key, $default ? '1' : '0'), FILTER_VALIDATE_BOOL);
    }

    public static function string(string $key, string $default = ''): string
    {
        return (string) self::get($key, $default);
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
