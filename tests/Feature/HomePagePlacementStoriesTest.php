<?php

namespace Tests\Feature;

use App\Models\HomeStory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HomePagePlacementStoriesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function home_page_prefers_uploaded_placement_stories_over_generated_placeholder_cards(): void
    {
        HomeStory::query()->create([
            'type' => 'placement',
            'name' => 'Aarav Sharma',
            'course' => 'Data Science with AI',
            'comment' => 'Placeholder placement card',
            'avatar' => 'https://ui-avatars.com/api/?name=Aarav+Sharma&background=F3E8FF&color=6B21A8&size=240',
            'media_type' => 'image',
            'rating' => 5,
            'company' => 'TCS',
            'role' => 'AI Analyst',
            'package' => '8.4 LPA',
            'is_active' => true,
            'show_in_placement_hero' => true,
            'sort_order' => 0,
        ]);

        HomeStory::query()->create([
            'type' => 'placement',
            'name' => 'Vivek Mali',
            'course' => 'Power BI',
            'comment' => 'Real learner placement story',
            'avatar' => 'https://res.cloudinary.com/demo/image/upload/home/stories/vivek-mali.jpg',
            'media_type' => 'image',
            'rating' => 5,
            'company' => 'Luthar Group',
            'role' => 'Analyst',
            'package' => '5.2 LPA',
            'is_active' => true,
            'show_in_placement_hero' => false,
            'sort_order' => 1,
        ]);

        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSee('Vivek Mali')
            ->assertDontSee('Aarav Sharma');
    }
}
