<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\JobOpening;
use App\Models\OfflineCourse;
use App\Models\PublicContact;
use App\Models\Workshop;
use App\Support\PlatformSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class PublicChatbotController extends Controller
{
    public function health(): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'timestamp' => now()->toISOString(),
            'service' => 'cyi-lms-chatbot',
        ]);
    }

    public function context(): JsonResponse
    {
        $onlineCourses = Schema::hasTable('courses')
            ? Course::query()
                ->where('status', 'published')
                ->orderByDesc('id')
                ->limit(6)
                ->get(['id', 'title', 'price', 'level', 'language', 'total_duration'])
                ->map(fn (Course $course) => [
                    'id' => $course->id,
                    'title' => $course->title,
                    'price' => $course->price,
                    'level' => $course->level ?: 'Career focused',
                    'language' => $course->language ?: 'English',
                    'duration' => $course->total_duration ?: 'Duration shared on the training program page',
                    'url' => $this->safeRoute('course.details', ['course' => $course->id]),
                ])
                ->values()
                ->all()
            : [];

        $offlineCourses = Schema::hasTable('offline_courses')
            ? OfflineCourse::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->limit(6)
                ->get(['title', 'slug', 'campus', 'duration_label', 'schedule_label', 'audience'])
                ->map(fn (OfflineCourse $course) => [
                    'title' => $course->title,
                    'campus' => $course->campus ?: 'Campus details on request',
                    'duration' => $course->duration_label ?: 'Duration shared on the training program page',
                    'schedule' => $course->schedule_label ?: 'Schedule shared by the admissions team',
                    'audience' => $course->audience ?: 'Students and working professionals',
                    'url' => $this->safeRoute('offline-course.details', ['offlineCourse' => $course->slug]),
                ])
                ->values()
                ->all()
            : [];

        $workshops = Schema::hasTable('workshops')
            ? Workshop::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->limit(3)
                ->get(['title', 'date_label', 'time_label', 'format', 'venue', 'audience'])
                ->map(fn (Workshop $workshop) => [
                    'title' => $workshop->title,
                    'date' => $workshop->date_label ?: 'Upcoming',
                    'time' => $workshop->time_label ?: 'Time announced soon',
                    'format' => $workshop->format ?: 'Live workshop',
                    'venue' => $workshop->venue ?: 'Online / Offline',
                    'audience' => $workshop->audience ?: 'Students and professionals',
                ])
                ->values()
                ->all()
            : [];

        $jobs = Schema::hasTable('job_openings')
            ? JobOpening::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->limit(3)
                ->get(['title', 'employment_type', 'work_mode', 'location'])
                ->map(fn (JobOpening $job) => [
                    'title' => $job->title,
                    'type' => $job->employment_type ?: 'Full Time',
                    'mode' => $job->work_mode ?: 'On-site',
                    'location' => $job->location ?: 'Surat, Gujarat',
                ])
                ->values()
                ->all()
            : [];

        return response()->json([
            'brand' => [
                'name' => 'CodeInYourself',
                'tagline' => 'Career-focused LMS for practical learning, mentorship, workshops, and placement support.',
                'email' => 'codeinyourself@gmail.com',
                'phone' => '+91 90164 27165',
                'city' => 'Surat, Gujarat, India',
            ],
            'routes' => [
                'home' => $this->safeRoute('home'),
                'courses' => $this->safeRoute('home.courses'),
                'about' => $this->safeRoute('home.about'),
                'placement' => $this->safeRoute('home.placement'),
                'contact' => $this->safeRoute('home.contact'),
                'workshop' => $this->safeRoute('home.free_workshop'),
                'mentorship' => $this->safeRoute('home.mentorship'),
                'career_paths' => $this->safeRoute('home.career-paths'),
                'careers' => $this->safeRoute('home.career-with-us'),
                'corporate_training' => $this->safeRoute('home.corporate-training'),
                'login' => $this->safeRoute('login'),
                'register' => $this->safeRoute('register'),
            ],
            'feature_flags' => [
                'online_catalog_enabled' => PlatformSettings::bool('catalog_online_enabled', false),
                'offline_catalog_enabled' => PlatformSettings::bool('catalog_offline_enabled', true),
                'student_catalog_enabled' => PlatformSettings::bool('student_catalog_enabled', false),
                'student_checkout_enabled' => PlatformSettings::bool('student_checkout_enabled', false),
                'student_payments_enabled' => PlatformSettings::bool('student_payments_enabled', false),
            ],
            'quick_answers' => [
                'certificates' => 'Certificates are available inside the LMS after eligible training program completion. Logged-in learners can access their certificates from the student certificate area when the program requirements are completed.',
                'placement' => 'Placement support is a public focus area in this LMS. The placement page, success stories, and career guidance sections are the best places to explore current support details.',
                'mentorship' => 'Learners can request free mentorship guidance through the mentorship page, and the team can follow up for roadmap planning or admission support.',
                'support' => 'For serious admission, workshop, mentorship, or career questions, the chatbot can collect your details and send them into the LMS inquiry workflow for the HR or support team.',
            ],
            'online_courses' => $onlineCourses,
            'offline_courses' => $offlineCourses,
            'workshops' => $workshops,
            'jobs' => $jobs,
        ]);
    }

    public function storeInquiry(Request $request): JsonResponse
    {
        abort_unless(Schema::hasTable('public_contacts'), 503, 'Public inquiry storage is not available.');

        $courseRule = Schema::hasTable('courses')
            ? ['nullable', 'integer', Rule::exists('courses', 'id')]
            : ['nullable', 'integer'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'region' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:5000'],
            'topic' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'course_id' => $courseRule,
            'page_url' => ['nullable', 'string', 'max:2000'],
            'intent' => ['nullable', 'string', 'max:100'],
            'course_interest' => ['nullable', 'string', 'max:255'],
            'source_page' => ['nullable', 'string', 'max:255'],
            'inquiry_kind' => ['nullable', 'string', 'max:50'],
        ]);

        $phone = isset($validated['phone']) ? preg_replace('/\s+/', '', (string) $validated['phone']) : null;
        if (filled($phone) && ! preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
            return response()->json([
                'message' => 'Please insert the proper number with country code.',
            ], 422);
        }

        $inquiryKind = (string) ($validated['inquiry_kind'] ?? 'inquiry');
        if (! in_array($inquiryKind, ['profile', 'inquiry'], true)) {
            $inquiryKind = 'inquiry';
        }

        if ($inquiryKind === 'profile' && blank($phone)) {
            return response()->json([
                'message' => 'Phone number with country code is required.',
            ], 422);
        }

        $topic = (string) ($validated['topic'] ?? 'general');
        if (! in_array($topic, ['general', 'course', 'workshop', 'mentorship', 'career', 'placement', 'support'], true)) {
            $topic = 'general';
        }

        $message = $validated['message']
            ?? ($inquiryKind === 'profile'
                ? 'Visitor completed the chatbot profile form before starting a conversation.'
                : 'Chatbot inquiry');

        $contact = PublicContact::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $phone,
            'course_id' => $validated['course_id'] ?? null,
            'message' => $message,
            'topic' => $topic,
            'subject' => $validated['subject']
                ?? ($inquiryKind === 'profile'
                    ? 'Chatbot visitor profile'
                    : match ($topic) {
                    'course' => 'Chatbot training program inquiry',
                    'workshop' => 'Chatbot workshop inquiry',
                    'mentorship' => 'Chatbot mentorship request',
                    'career' => 'Chatbot career inquiry',
                    'placement' => 'Chatbot placement inquiry',
                    'support' => 'Chatbot support request',
                    default => 'Chatbot inquiry',
                }),
            'status' => 'new',
            'source_page' => $validated['source_page'] ?? 'chatbot-widget',
            'details' => array_filter([
                'intent' => $validated['intent'] ?? null,
                'page_url' => $validated['page_url'] ?? null,
                'course_interest' => $validated['course_interest'] ?? null,
                'region' => $validated['region'] ?? null,
                'inquiry_kind' => $inquiryKind,
                'submitted_at' => now()->toISOString(),
            ], fn ($value) => filled($value)),
        ]);

        return response()->json([
            'ok' => true,
            'message' => $inquiryKind === 'profile'
                ? 'Your details are saved. You can start chatting now.'
                : 'Your request has been sent to the CodeInYourself team.',
            'contact_id' => $contact->id,
        ]);
    }

    private function safeRoute(string $name, array $parameters = []): ?string
    {
        return Route::has($name) ? route($name, $parameters, false) : null;
    }
}
