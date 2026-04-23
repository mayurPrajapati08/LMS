<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PublicChatbotTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function chatbot_context_endpoint_returns_project_context(): void
    {
        $response = $this->get(route('chatbot.context'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'brand' => ['name', 'email', 'phone', 'city'],
                'routes' => ['courses', 'contact', 'workshop', 'mentorship', 'placement'],
                'quick_answers' => ['certificates', 'placement', 'mentorship', 'support'],
                'online_courses',
                'offline_courses',
                'workshops',
                'jobs',
            ]);
    }

    #[Test]
    public function chatbot_inquiry_endpoint_persists_public_contact(): void
    {
        $response = $this->post(route('chatbot.inquiries'), [
            'name' => 'Mayur Sharma',
            'email' => 'mayur@example.com',
            'phone' => '+91 9876543210',
            'message' => 'I need help choosing the right course for placement preparation.',
            'topic' => 'course',
            'subject' => 'Chatbot admissions request',
            'intent' => 'course-guidance',
            'page_url' => '/course',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->assertDatabaseHas('public_contacts', [
            'email' => 'mayur@example.com',
            'topic' => 'course',
            'source_page' => 'chatbot-widget',
            'subject' => 'Chatbot admissions request',
        ]);
    }
}