<?php

namespace Tests\Feature;

use App\Models\PublicContact;
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

    #[Test]
    public function chatbot_profile_submission_saves_region_and_kind_details(): void
    {
        $response = $this->post(route('chatbot.inquiries'), [
            'name' => 'Anika Patel',
            'email' => 'anika@example.com',
            'region' => 'India',
            'phone' => '+91 9876543210',
            'topic' => 'general',
            'subject' => 'Chatbot visitor profile',
            'inquiry_kind' => 'profile',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('message', 'Your details are saved. You can start chatting now.');

        $contact = PublicContact::query()->where('email', 'anika@example.com')->first();

        $this->assertNotNull($contact);
        $this->assertSame('Chatbot visitor profile', $contact->subject);
        $this->assertSame('India', $contact->details['region'] ?? null);
        $this->assertSame('profile', $contact->details['inquiry_kind'] ?? null);
    }

    #[Test]
    public function chatbot_rejects_phone_without_country_code(): void
    {
        $response = $this->post(route('chatbot.inquiries'), [
            'name' => 'Anika Patel',
            'email' => 'anika@example.com',
            'region' => 'India',
            'phone' => '9876543210',
            'message' => 'Need mentorship support.',
            'inquiry_kind' => 'profile',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'Please insert the proper number with country code.');
    }
}
