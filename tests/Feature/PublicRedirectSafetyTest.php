<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PublicRedirectSafetyTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function unlock_content_rejects_external_redirect_targets(): void
    {
        $response = $this->post(route('content.unlock'), [
            'name' => 'Lead User',
            'email' => 'lead@example.com',
            'context' => 'offline-course-1',
            'redirect_to' => 'https://evil.example/phish',
        ]);

        $response->assertRedirect(route('home.courses', absolute: false));
    }
}
