<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);
        $routeName = (string) optional($request->route())->getName();

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(self), geolocation=(), browsing-topics=()');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-site');
        $response->headers->set('Origin-Agent-Cluster', '?1');
        $response->headers->set('X-Download-Options', 'noopen');
        $response->headers->set('Content-Security-Policy', "base-uri 'self'; form-action 'self'; frame-ancestors 'self'; object-src 'none'");

        if ($request->isSecure() || app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $isPrivateRoute = str_starts_with($routeName, 'admin.')
            || str_starts_with($routeName, 'hr.')
            || str_starts_with($routeName, 'student.')
            || str_starts_with($routeName, 'instructor.');

        if ($isPrivateRoute) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Mon, 01 Jan 1990 00:00:00 GMT');
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        } elseif (str_starts_with($routeName, 'login') || str_starts_with($routeName, 'register') || str_starts_with($routeName, 'password.') || str_starts_with($routeName, 'verification.') || str_starts_with($routeName, 'two-factor.')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
        }

        return $response;
    }
}
