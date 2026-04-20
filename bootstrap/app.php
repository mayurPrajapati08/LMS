<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
                | Request::HEADER_X_FORWARDED_PREFIX
        );

        $middleware->redirectGuestsTo(fn () => route('login', absolute: false));
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'feature' => \App\Http\Middleware\EnsurePlatformFeatureEnabled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $exception, Request $request) {
            $status = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

            if (in_array($status, [404, 500, 503], true)) {
                return response()->view('errors.'.$status, ['status' => $status], $status);
            }

            if ($status >= 500) {
                return response()->view('errors.500', ['status' => $status], $status);
            }

            return null;
        });

        $exceptions->report(function (\Throwable $exception) {
            if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() < 500) {
                return;
            }

            $recipient = \App\Support\PlatformSettings::string('exception_alert_email', (string) config('mail.from.address'));

            if ($recipient === '') {
                return;
            }

            try {
                Mail::to($recipient)->send(new \App\Mail\SystemExceptionAlertMail($exception, request()));
            } catch (\Throwable) {
                // Avoid exception-reporting loops when mail transport fails.
            }
        });
    })->create();
