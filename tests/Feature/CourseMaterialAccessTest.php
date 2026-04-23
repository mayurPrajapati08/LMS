<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CourseMaterialAccessTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function enrolled_student_cannot_download_a_non_downloadable_resource(): void
    {
        [$student, $material] = $this->buildLearningAccessFixture(false);

        $response = $this->actingAs($student)->get(route('student.course-player.resource.download', $material));

        $response->assertForbidden();
    }

    #[Test]
    public function enrolled_student_can_view_an_allowed_resource(): void
    {
        [$student, $material] = $this->buildLearningAccessFixture(true);

        $response = $this->actingAs($student)->get(route('student.course-player.resource.view', $material));

        $response->assertRedirect('https://cdn.example.com/lesson.pdf');
    }

    private function buildLearningAccessFixture(bool $downloadable): array
    {
        $studentRole = Role::query()->create(['name' => 'user']);
        $instructorRole = Role::query()->create(['name' => 'instructor']);

        $student = User::query()->create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => 'Secret123!!',
            'role_id' => $studentRole->id,
            'email_verified_at' => now(),
        ]);

        $instructor = User::query()->create([
            'name' => 'Instructor',
            'email' => 'teacher@example.com',
            'password' => 'Secret123!!',
            'role_id' => $instructorRole->id,
            'email_verified_at' => now(),
        ]);

        $category = Category::query()->create([
            'name' => 'Security',
        ]);

        $course = Course::query()->create([
            'category_id' => $category->id,
            'user_id' => $instructor->id,
            'title' => 'Secure Course',
            'slug' => 'secure-course',
            'status' => 'published',
            'details' => 'Security-first course',
            'price' => 999,
        ]);

        $section = Section::query()->create([
            'course_id' => $course->id,
            'title' => 'Section 1',
            'order_number' => 1,
        ]);

        $video = Video::query()->create([
            'section_id' => $section->id,
            'upload_by' => $instructor->id,
            'title' => 'Lesson 1',
            'video_url' => 'https://cdn.example.com/video.m3u8',
            'order_number' => 1,
            'duration' => 120,
        ]);

        $material = CourseMaterial::query()->create([
            'video_id' => $video->id,
            'title' => 'Notes',
            'file_url' => 'https://cdn.example.com/lesson.pdf',
            'type' => 'pdf',
            'is_downloadable' => $downloadable,
        ]);

        $payment = Payment::query()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'payment_getway' => 'stripe',
            'payment_id' => 'pay_001',
            'amount' => 999,
            'status' => 'completed',
        ]);

        Enrollment::query()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'payment_table_id' => $payment->id,
            'amount' => 999,
            'status' => 'completed',
        ]);

        return [$student, $material];
    }
}
