<?php

namespace Tests\Unit;

use App\Support\ExceptionReport;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

class ExceptionReportTest extends TestCase
{
    #[Test]
    public function it_builds_a_sanitized_exception_report(): void
    {
        $request = Request::create('/admin/settings', 'POST', [
            'name' => 'Platform',
            'password' => 'secret-value',
            'current_password' => 'top-secret',
            'webhook_secret' => 'hidden',
            'integration_webhook_secret' => 'integration-hidden',
        ]);

        $exception = new RuntimeException('Something failed badly.');
        $report = ExceptionReport::build($exception, $request);

        $this->assertSame('Something failed badly.', $report['exception']['message']);
        $this->assertSame('POST', $report['request']['method']);
        $this->assertArrayNotHasKey('password', $report['request']['input']);
        $this->assertArrayNotHasKey('current_password', $report['request']['input']);
        $this->assertSame('[redacted]', $report['request']['input']['webhook_secret']);
        $this->assertSame('[redacted]', $report['request']['input']['integration_webhook_secret']);
        $this->assertNotEmpty($report['trace']);
    }
}
