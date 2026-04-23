<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Throwable;

class ExceptionReport
{
    public static function build(Throwable $exception, ?Request $request = null): array
    {
        return [
            'app' => [
                'name' => config('app.name'),
                'env' => app()->environment(),
                'url' => config('app.url'),
                'occurred_at' => now()->toDateTimeString(),
            ],
            'exception' => [
                'class' => $exception::class,
                'short_class' => class_basename($exception),
                'message' => $exception->getMessage() !== '' ? $exception->getMessage() : '(no exception message)',
                'file' => self::shortPath($exception->getFile()),
                'full_file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'source_excerpt' => self::sourceExcerpt($exception->getFile(), $exception->getLine()),
                'previous' => self::previousExceptions($exception),
            ],
            'request' => $request ? self::requestContext($request) : null,
            'trace' => self::tracePreview($exception),
        ];
    }

    private static function requestContext(Request $request): array
    {
        $user = $request->user();

        return [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'route' => optional($request->route())->getName(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user' => $user ? [
                'id' => $user->id ?? null,
                'email' => $user->email ?? null,
                'name' => $user->name ?? null,
                'role' => $user->role?->name ?? null,
            ] : null,
            'input' => self::sanitizeData($request->except([
                'password',
                'password_confirmation',
                'current_password',
                'token',
                '_token',
            ])),
            'headers' => Arr::only($request->headers->all(), [
                'host',
                'referer',
                'origin',
                'x-forwarded-for',
                'x-forwarded-proto',
            ]),
        ];
    }

    private static function tracePreview(Throwable $exception): array
    {
        return collect($exception->getTrace())
            ->map(function (array $frame, int $index) {
                $file = isset($frame['file']) ? self::shortPath((string) $frame['file']) : '[internal]';
                $line = isset($frame['line']) ? (int) $frame['line'] : null;
                $function = trim(sprintf(
                    '%s%s%s',
                    $frame['class'] ?? '',
                    $frame['type'] ?? '',
                    $frame['function'] ?? ''
                ), ':');

                return [
                    'index' => $index + 1,
                    'file' => $file,
                    'line' => $line,
                    'function' => $function !== '' ? $function : '[closure]',
                ];
            })
            ->filter(fn (array $frame) => $frame['file'] === '[internal]' || ! Str::contains($frame['file'], '/vendor/'))
            ->take(12)
            ->values()
            ->all();
    }

    private static function previousExceptions(Throwable $exception): array
    {
        $items = [];
        $previous = $exception->getPrevious();

        while ($previous) {
            $items[] = [
                'class' => $previous::class,
                'message' => $previous->getMessage(),
                'file' => self::shortPath($previous->getFile()),
                'line' => $previous->getLine(),
            ];

            $previous = $previous->getPrevious();
        }

        return $items;
    }

    private static function sanitizeData(array $data): array
    {
        return collect($data)
            ->map(function ($value, $key) {
                if (self::shouldRedactKey((string) $key)) {
                    return '[redacted]';
                }

                if (is_array($value)) {
                    return self::sanitizeData($value);
                }

                if (is_string($value) && mb_strlen($value) > 500) {
                    return mb_substr($value, 0, 500).'...';
                }

                return $value;
            })
            ->all();
    }

    private static function shouldRedactKey(string $key): bool
    {
        $normalized = Str::lower($key);

        foreach (['password', 'secret', 'token', 'api_key', 'api_secret'] as $sensitiveFragment) {
            if (Str::contains($normalized, $sensitiveFragment)) {
                return true;
            }
        }

        return false;
    }

    private static function sourceExcerpt(string $file, int $line): array
    {
        if ($file === '' || ! is_file($file) || ! is_readable($file)) {
            return [];
        }

        $lines = @file($file, FILE_IGNORE_NEW_LINES);

        if (! is_array($lines) || $lines === []) {
            return [];
        }

        $start = max(1, $line - 3);
        $end = min(count($lines), $line + 3);
        $excerpt = [];

        for ($current = $start; $current <= $end; $current++) {
            $excerpt[] = [
                'line' => $current,
                'code' => rtrim((string) ($lines[$current - 1] ?? '')),
                'is_target' => $current === $line,
            ];
        }

        return $excerpt;
    }

    private static function shortPath(string $path): string
    {
        $normalized = str_replace('\\', '/', $path);
        $basePath = str_replace('\\', '/', base_path()).'/';

        return Str::startsWith($normalized, $basePath)
            ? Str::replaceFirst($basePath, '', $normalized)
            : $normalized;
    }
}
