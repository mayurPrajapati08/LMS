<?php

namespace App\Http\Middleware;

use App\Support\PlatformSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsurePlatformFeatureEnabled
{
    public function handle(Request $request, Closure $next, string $feature, string $mode = 'enabled'): Response
    {
        $enabled = PlatformSettings::bool($feature, false);
        $blocked = $mode === 'disabled' ? $enabled : ! $enabled;

        if ($blocked) {
            $title = match ($feature) {
                'catalog_online_enabled', 'student_catalog_enabled' => 'Courses Are Coming Soon',
                'student_wishlist_enabled' => 'Wishlist Is Coming Soon',
                'student_cart_enabled' => 'Cart Access Is Coming Soon',
                'student_checkout_enabled' => 'Checkout Is Coming Soon',
                'student_payments_enabled' => 'Payments Area Is Coming Soon',
                default => 'This Section Is Coming Soon',
            };

            $message = match ($feature) {
                'catalog_online_enabled', 'student_catalog_enabled' => 'The online learning flow is currently paused while the offline-first launch is being prioritized.',
                default => 'This feature is temporarily unavailable right now. Our team is still preparing it for a smoother launch.',
            };

            $payload = [
                'title' => $title,
                'message' => $message,
                'feature' => Str::headline(str_replace('_', ' ', $feature)),
            ];

            if ($request->is('student/*')) {
                return response()->view('student.feature-locked', $payload, 503);
            }

            return response()->view('errors.503', $payload, 503);
        }

        return $next($request);
    }
}
