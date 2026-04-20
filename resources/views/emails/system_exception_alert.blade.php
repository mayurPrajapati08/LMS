<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>System Exception Alert</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <h2 style="margin-bottom: 8px;">System Exception Alert</h2>
    <p style="margin-top: 0;">An exception was reported by the website.</p>

    <p><strong>Type:</strong> {{ get_class($exception) }}</p>
    <p><strong>Message:</strong> {{ $exception->getMessage() }}</p>
    <p><strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}</p>

    @if ($requestData)
        <p><strong>URL:</strong> {{ $requestData->fullUrl() }}</p>
        <p><strong>Method:</strong> {{ $requestData->method() }}</p>
        <p><strong>IP:</strong> {{ $requestData->ip() }}</p>
        <p><strong>User Agent:</strong> {{ $requestData->userAgent() }}</p>
        <p><strong>User:</strong> {{ optional($requestData->user())->email ?: 'Guest' }}</p>
    @endif

    <pre style="white-space: pre-wrap; background: #f3f4f6; padding: 16px; border-radius: 8px;">{{ $exception->getTraceAsString() }}</pre>
</body>
</html>
