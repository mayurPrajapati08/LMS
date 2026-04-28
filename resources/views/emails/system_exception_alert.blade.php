<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8">
    <title>System Exception Alert</title>
</head>
<body style="margin:0;padding:24px;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;line-height:1.6;">
    <div style="max-width:980px;margin:0 auto;background:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #e5e7eb;">
        <div style="padding:24px 28px;background:linear-gradient(135deg,#111827 0%,#1f2937 100%);color:#ffffff;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">{{ $report['app']['name'] ?? 'Application' }} · {{ strtoupper($report['app']['env'] ?? 'production') }}</p>
            <h1 style="margin:0;font-size:28px;line-height:1.2;">Unhandled Exception Alert</h1>
            <p style="margin:10px 0 0;color:#d1d5db;font-size:14px;">
                {{ $report['exception']['short_class'] ?? 'Exception' }} at {{ $report['exception']['file'] ?? 'unknown file' }}:{{ $report['exception']['line'] ?? '?' }}
            </p>
        </div>

        <div style="padding:28px;">
            <div style="margin-bottom:24px;padding:20px;border-radius:16px;background:#fef2f2;border:1px solid #fecaca;">
                <p style="margin:0 0 6px;font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#991b1b;">Main Error</p>
                <p style="margin:0;color:#111827;font-size:18px;font-weight:700;">{{ $report['exception']['message'] ?? '(no message)' }}</p>
                <p style="margin:10px 0 0;color:#4b5563;font-size:14px;">
                    {{ $report['exception']['class'] ?? '' }} · {{ $report['app']['occurred_at'] ?? '' }}
                </p>
            </div>

            <table style="width:100%;border-collapse:collapse;margin-bottom:24px;">
                <tr>
                    <td style="width:180px;padding:10px 0;color:#6b7280;font-weight:700;vertical-align:top;">File</td>
                    <td style="padding:10px 0;">{{ $report['exception']['full_file'] ?? $report['exception']['file'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0;color:#6b7280;font-weight:700;vertical-align:top;">Line</td>
                    <td style="padding:10px 0;">{{ $report['exception']['line'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0;color:#6b7280;font-weight:700;vertical-align:top;">App URL</td>
                    <td style="padding:10px 0;">{{ $report['app']['url'] ?? 'N/A' }}</td>
                </tr>
            </table>

            @if (! empty($report['request']))
                <div style="margin-bottom:24px;padding:20px;border-radius:16px;background:#f9fafb;border:1px solid #e5e7eb;">
                    <p style="margin:0 0 12px;font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#374151;">Request Context</p>
                    <table style="width:100%;border-collapse:collapse;">
                        <tr>
                            <td style="width:180px;padding:8px 0;color:#6b7280;font-weight:700;vertical-align:top;">Method</td>
                            <td style="padding:8px 0;">{{ $report['request']['method'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#6b7280;font-weight:700;vertical-align:top;">URL</td>
                            <td style="padding:8px 0;">{{ $report['request']['url'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#6b7280;font-weight:700;vertical-align:top;">Route</td>
                            <td style="padding:8px 0;">{{ $report['request']['route'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#6b7280;font-weight:700;vertical-align:top;">IP</td>
                            <td style="padding:8px 0;">{{ $report['request']['ip'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#6b7280;font-weight:700;vertical-align:top;">User</td>
                            <td style="padding:8px 0;">
                                @if (! empty($report['request']['user']))
                                    {{ $report['request']['user']['name'] ?? 'N/A' }} ({{ $report['request']['user']['email'] ?? 'N/A' }})
                                @else
                                    Guest
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            @endif

            @if (! empty($report['exception']['source_excerpt']))
                <div style="margin-bottom:24px;">
                    <p style="margin:0 0 12px;font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#374151;">Source Excerpt</p>
                    <div style="border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;background:#111827;">
                        @foreach ($report['exception']['source_excerpt'] as $excerpt)
                            <div style="display:flex;gap:16px;padding:10px 14px;background:{{ $excerpt['is_target'] ? '#2b1620' : '#111827' }};color:{{ $excerpt['is_target'] ? '#fecdd3' : '#e5e7eb' }};font-family:Consolas,Menlo,monospace;font-size:13px;">
                                <span style="width:40px;flex:0 0 40px;color:#9ca3af;">{{ $excerpt['line'] }}</span>
                                <span style="white-space:pre-wrap;word-break:break-word;">{{ $excerpt['code'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (! empty($report['exception']['previous']))
                <div style="margin-bottom:24px;padding:20px;border-radius:16px;background:#fff7ed;border:1px solid #fed7aa;">
                    <p style="margin:0 0 10px;font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#9a3412;">Previous Exceptions</p>
                    @foreach ($report['exception']['previous'] as $previous)
                        <p style="margin:0 0 10px;color:#7c2d12;font-size:14px;">
                            <strong>{{ $previous['class'] }}</strong>: {{ $previous['message'] }} at {{ $previous['file'] }}:{{ $previous['line'] }}
                        </p>
                    @endforeach
                </div>
            @endif

            @if (! empty($report['trace']))
                <div style="margin-bottom:24px;">
                    <p style="margin:0 0 12px;font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#374151;">Application Trace Preview</p>
                    <div style="border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
                        @foreach ($report['trace'] as $frame)
                            <div style="padding:12px 14px;border-top:{{ $loop->first ? '0' : '1px solid #e5e7eb' }};background:#ffffff;">
                                <p style="margin:0;color:#111827;font-size:14px;font-weight:700;">#{{ $frame['index'] }} {{ $frame['function'] }}</p>
                                <p style="margin:4px 0 0;color:#6b7280;font-size:13px;">{{ $frame['file'] }}@if($frame['line']) :{{ $frame['line'] }}@endif</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (! empty($report['request']['input']))
                <div style="margin-bottom:24px;">
                    <p style="margin:0 0 12px;font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#374151;">Request Input</p>
                    <pre style="margin:0;white-space:pre-wrap;word-break:break-word;background:#f9fafb;padding:16px;border-radius:16px;border:1px solid #e5e7eb;">{{ json_encode($report['request']['input'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
