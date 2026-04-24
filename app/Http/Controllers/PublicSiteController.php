<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\HomeAchievement;
use App\Models\HomeFounderMedia;
use App\Models\HomeSlide;
use App\Models\HomeStory;
use App\Models\JobOpening;
use App\Models\OfflineCourse;
use App\Models\PublicContact;
use App\Models\Review;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use App\Support\PlatformSettings;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        $siteStats = $this->siteStats();
        $featuredCourses = Schema::hasTable('courses')
            ? $this->publishedCoursesBaseQuery()
                ->limit(4)
                ->get()
                ->map(fn (Course $course) => $this->mapCourseCard($course))
            : collect();

        $aboutHighlights = [
            ['icon' => 'groups', 'title' => '20+', 'subtitle' => 'Students Placed'],
            ['icon' => 'task_alt', 'title' => 'Hands-On', 'subtitle' => 'Projects'],
            ['icon' => 'headset_mic', 'title' => 'Online &', 'subtitle' => 'Offline Learning'],
            ['icon' => 'workspace_premium', 'title' => 'Expert', 'subtitle' => 'Mentorship'],
            ['icon' => 'deployed_code', 'title' => 'Digital', 'subtitle' => 'Marketer'],
        ];

        $corporateHighlights = [
            ['icon' => 'tune', 'title' => 'Tailored Training', 'description' => 'Programs are aligned to learner goals, current skill level, and the role outcomes each batch is working toward.', 'result' => 'A focused learning plan that stays relevant from the first class to the final placement push.'],
            ['icon' => 'forum', 'title' => 'Live Projects', 'description' => 'Students build through guided assignments, portfolio tasks, and practical delivery work instead of passively watching lessons.', 'result' => 'Stronger hands-on confidence, clearer proof of skill, and better interview conversations.'],
            ['icon' => 'school', 'title' => 'Career-Focused Learning', 'description' => 'Every roadmap is structured to support role readiness, portfolio quality, interview preparation, and long-term growth.', 'result' => 'Learners finish with job-relevant projects, clearer direction, and a more professional profile.'],
            ['icon' => 'shield_person', 'title' => 'Industry Experts', 'description' => 'Mentors explain tools, workflows, and industry expectations in a practical way that connects theory to day-to-day work.', 'result' => 'More clarity during learning and better preparation for real project environments.'],
            ['icon' => 'diversity_3', 'title' => 'Supportive Community', 'description' => 'Small-batch interaction, regular feedback, and approachable mentor support help learners stay consistent and keep improving.', 'result' => 'A more accountable journey with faster doubt resolution and stronger momentum.'],
        ];

        $achievementGallery = $this->achievementGallery();
        $achievementShowcaseItems = $this->achievementShowcaseItems();

        $promoSlides = $this->homeSlides();

        $popularRoadmaps = collect($this->careerPathLibrary())
            ->whereIn('slug', ['data-science-with-ai', 'data-analytics', 'generative-ai'])
            ->sortBy(fn (array $path) => array_search($path['slug'], ['data-science-with-ai', 'data-analytics', 'generative-ai'], true))
            ->values()
            ->map(fn (array $path) => [
                'slug' => $path['slug'],
                'title' => $path['title'],
                'subtitle' => $path['subtitle'],
                'duration' => $path['duration'],
                'price' => $path['price'],
                'thumbnail' => $path['thumbnail'],
                'skills' => collect($path['skills'] ?? [])->take(3)->values()->all(),
                'has_more_skills' => collect($path['skills'] ?? [])->count() > 3,
                'label' => match ($path['slug']) {
                    'data-science-with-ai' => 'Most Popular Data Science Roadmap',
                    'data-analytics-with-ai' => 'Most Popular Analytics Roadmap',
                    default => 'Most Popular AI Roadmap',
                },
                'cta_url' => route('home.career-paths.show', ['path' => $path['slug']]),
            ]);

        $allPlacementStories = collect($this->homeStories('placement'))->values();
        $preferredPlacementStories = $allPlacementStories
            ->reject(fn (array $story) => $this->isGeneratedPlacementPlaceholder($story))
            ->values();

        if ($preferredPlacementStories->isEmpty()) {
            $preferredPlacementStories = $allPlacementStories;
        }

        $homePlacementStudents = $preferredPlacementStories
            ->filter(fn (array $story) => (bool) ($story['show_in_placement_hero'] ?? false))
            ->values();

        if ($homePlacementStudents->isEmpty()) {
            $homePlacementStudents = $preferredPlacementStories->take(9)->values();
        }
        $homeSuccessStories = collect($this->homeStories('success_story', 3));

        $homeFacultyCards = Schema::hasTable('users') && Schema::hasTable('roles')
            ? User::query()
                ->whereHas('role', fn ($query) => $query->where('name', 'instructor'))
                ->withCount(['courses' => fn ($query) => $query->where('status', 'published')])
                ->orderByDesc('courses_count')
                ->limit(4)
                ->get()
                ->map(fn (User $mentor) => [
                    'name' => $mentor->name,
                    'avatar' => $mentor->avatarUrl(320),
                    'role' => $mentor->courses_count > 0
                        ? 'Lead Mentor - '.$mentor->courses_count.' course'.($mentor->courses_count === 1 ? '' : 's')
                        : 'Industry Mentor',
                    'bio' => $mentor->bio ?: 'Supports learners with practical guidance, project feedback, and a clear path toward industry readiness.',
                ])
            : collect();

        $homeFacultyCards = $this->featuredFacultyCards();
        $workingProfessionalCourses = $this->homeAudienceCourseShowcase('working-professional');
        $collegeStudentCourses = $this->homeAudienceCourseShowcase('college-student');

        return view('Home.home', [
            'siteStats' => $siteStats,
            'featuredCourses' => $featuredCourses,
            'aboutHighlights' => $aboutHighlights,
            'corporateHighlights' => $corporateHighlights,
            'featuredWorkshops' => $this->workshopListings(),
            'achievementGallery' => $achievementGallery,
            'achievementShowcaseItems' => $achievementShowcaseItems,
            'promoSlides' => $promoSlides,
            'homeFounderVideo' => $this->homeFounderVideo(),
            'popularRoadmaps' => $popularRoadmaps,
            'homePlacementStudents' => $homePlacementStudents,
            'homeSuccessStories' => $homeSuccessStories,
            'homeFacultyCards' => $homeFacultyCards,
            'workingProfessionalCourses' => $workingProfessionalCourses,
            'collegeStudentCourses' => $collegeStudentCourses,
        ]);
    }

    public function courses(Request $request): View
    {
        $onlineCatalogEnabled = PlatformSettings::bool('catalog_online_enabled', false);
        $offlineCatalogEnabled = PlatformSettings::bool('catalog_offline_enabled', true);
        $defaultMode = PlatformSettings::string('catalog_default_mode', 'offline');
        $search = trim((string) $request->query('search', ''));
        $category = (string) $request->query('category', '');
        $sort = (string) $request->query('sort', 'popular');
        $audience = (string) $request->query('audience', '');
        $requestedMode = (string) $request->query('mode', $defaultMode);
        $catalogMode = in_array($requestedMode, ['online', 'offline'], true) ? $requestedMode : $defaultMode;
        $selectedAudience = in_array($audience, ['working-professional', 'college-student'], true) ? $audience : '';

        if ($catalogMode === 'online' && ! $onlineCatalogEnabled) {
            $catalogMode = $offlineCatalogEnabled ? 'offline' : 'online';
        }

        if ($catalogMode === 'offline' && ! $offlineCatalogEnabled) {
            $catalogMode = $onlineCatalogEnabled ? 'online' : 'offline';
        }

        if ($catalogMode === 'offline') {
            $offlineCourses = OfflineCourse::query()
                ->where('is_active', true)
                ->with('category:id,name')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($nestedQuery) use ($search) {
                        $nestedQuery
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('summary', 'like', "%{$search}%")
                            ->orWhere('campus', 'like', "%{$search}%");
                    });
                })
                ->when($category !== '', fn ($query) => $query->where('category_id', (int) $category))
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get()
                ->filter(fn (OfflineCourse $course) => $selectedAudience === '' || $this->offlineCourseAudienceSegment($course) === $selectedAudience)
                ->values();

            $paginatedOfflineCourses = $this->paginateCollection($offlineCourses, 9, $request);

            return view('Home.course', [
                'search' => $search,
                'selectedCategory' => $category,
                'selectedSort' => $sort,
                'selectedAudience' => $selectedAudience,
                'catalogMode' => $catalogMode,
                'onlineCatalogEnabled' => $onlineCatalogEnabled,
                'offlineCatalogEnabled' => $offlineCatalogEnabled,
                'publicLeadGateEnabled' => PlatformSettings::bool('public_lead_gate_enabled', true),
                'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
                'resultsCount' => $offlineCourses->count(),
                'courseCards' => $paginatedOfflineCourses->through(fn (OfflineCourse $course) => $this->mapOfflineCourseCard($course)),
            ]);
        }

        $courses = $this->publishedCoursesBaseQuery()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%")
                        ->orWhere('language', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->where('category_id', (int) $category));

        $this->applySort($courses, $sort);

        $onlineCourses = $courses
            ->get()
            ->filter(fn (Course $course) => $selectedAudience === '' || $this->courseAudienceSegment($course) === $selectedAudience)
            ->values();

        $paginatedCourses = $this->paginateCollection($onlineCourses, 9, $request);

        return view('Home.course', [
            'search' => $search,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
            'selectedAudience' => $selectedAudience,
            'catalogMode' => $catalogMode,
            'onlineCatalogEnabled' => $onlineCatalogEnabled,
            'offlineCatalogEnabled' => $offlineCatalogEnabled,
            'publicLeadGateEnabled' => PlatformSettings::bool('public_lead_gate_enabled', true),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'resultsCount' => $onlineCourses->count(),
            'courseCards' => $paginatedCourses->through(fn (Course $course) => $this->mapCourseCard($course)),
        ]);
    }

    public function offlineCourseDetail(Request $request, OfflineCourse $offlineCourse): RedirectResponse|View
    {
        abort_unless($offlineCourse->is_active, 404);

        $gateContext = 'offline-course-'.$offlineCourse->id;
        $granted = (array) $request->session()->get('content_gate_access', []);

        if (PlatformSettings::bool('public_lead_gate_enabled', true) && ! ($granted[$gateContext] ?? false)) {
            return redirect()
                ->route('home.courses', [
                    'mode' => 'offline',
                    'audience' => $this->offlineCourseAudienceSegment($offlineCourse) ?: null,
                ])
                ->with('status', 'Please unlock the batch details from the training program page first.');
        }

        return view('Home.offline_course_detail', [
            'course' => $offlineCourse->load('category:id,name'),
            'browseUrl' => route('home.courses', [
                'mode' => 'offline',
                'audience' => $this->offlineCourseAudienceSegment($offlineCourse) ?: null,
            ]),
            'audienceLabel' => $this->audienceLabel($this->offlineCourseAudienceSegment($offlineCourse)),
        ]);
    }

    public function careerPaths(): View
    {
        $tracks = collect($this->careerPathLibrary())
            ->map(fn (array $path) => Arr::only($path, [
                'slug',
                'title',
                'subtitle',
                'duration',
                'mode',
                'access',
                'price',
                'thumbnail',
                'thumbnail_fit',
                'thumbnail_position',
                'thumbnail_backdrop',
                'skills',
            ]) + [
                'details_url' => route('home.career-paths.show', ['path' => $path['slug']]),
            ]);

        return view('Home.career_paths', [
            'siteStats' => $this->siteStats(),
            'careerTracks' => $tracks,
        ]);
    }

    public function careerPathDetail(Request $request, string $path): RedirectResponse|View
    {
        if (! $request->user()) {
            $request->session()->put('url.intended', $request->fullUrl());

            return redirect()->route('login', [
                'redirect_to' => '/career-paths/'.$path,
            ]);
        }

        $careerPath = collect($this->careerPathLibrary())
            ->firstWhere('slug', $path);

        abort_if(!$careerPath, 404);

        return view('Home.career_path_detail', [
            'careerPath' => $careerPath,
        ]);
    }

    public function corporateTraining(): View
    {
        return view('Home.corporate_training', [
            'siteStats' => $this->siteStats(),
            'programHighlights' => [
                ['icon' => 'corporate_fare', 'title' => 'Custom Team Tracks', 'description' => 'Role-based training plans for engineering, analytics, AI, and product teams.'],
                ['icon' => 'schedule', 'title' => 'Flexible Delivery', 'description' => 'Weekend, cohort, and hybrid schedules designed around business calendars.'],
                ['icon' => 'lab_profile', 'title' => 'Project Workshops', 'description' => 'Applied labs and live capstone exercises aligned with your company stack.'],
                ['icon' => 'groups_3', 'title' => 'Mentor Access', 'description' => 'Hands-on sessions with industry practitioners for review, feedback, and support.'],
            ],
        ]);
    }

    public function careerWithUs(): View
    {
        return view('Home.carrer_with_us', [
            'openings' => $this->careerOpenings(),
        ]);
    }

    public function workshop(): View
    {
        return view('Home.workshop', [
            'featuredWorkshops' => $this->workshopListings(),
            'workshopLeadGateEnabled' => PlatformSettings::bool('workshop_lead_gate_enabled', true),
            'workshopRazorpayConfigured' => (string) config('services.razorpay.key_id') !== '' && (string) config('services.razorpay.key_secret') !== '',
        ]);
    }

    public function submitWorkshopRegistration(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('workshops') && Schema::hasTable('workshop_registrations'), 503, 'Run migrations to enable workshop registration.');

        $validated = $this->validateWorkshopRegistrationPayload($request);

        /** @var Workshop $workshop */
        $workshop = Workshop::query()
            ->where('is_active', true)
            ->findOrFail($validated['workshop_id']);

        if ((float) $workshop->price > 0) {
            return back()
                ->withInput()
                ->withErrors(['workshop' => 'Please complete the Razorpay payment to reserve this paid workshop seat.']);
        }

        $registration = WorkshopRegistration::query()->create([
            'workshop_id' => $workshop->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'organization' => $validated['organization'] ?? null,
            'learner_type' => $validated['learner_type'] ?? null,
            'experience_level' => $validated['experience_level'] ?? null,
            'attendance_mode' => $validated['attendance_mode'] ?? null,
            'goals' => $validated['goals'] ?? null,
            'questions' => $validated['questions'] ?? null,
            'payment_amount' => (float) $workshop->price,
            'currency' => $workshop->currency ?: 'INR',
            'payment_reference' => null,
            'payment_screenshot_path' => null,
            'payment_status' => 'not_required',
            'registration_status' => 'pending',
            'source' => 'public-workshop-page',
        ]);

        $statusMessage = $registration->registration_status === 'confirmed'
            ? 'Workshop registration completed successfully.'
            : 'Your seat request has been submitted successfully. Our team will review it and contact you shortly.';

        return redirect()
            ->route('home.free_workshop')
            ->with('status', $statusMessage);
    }

    public function createWorkshopPaymentOrder(Request $request): JsonResponse
    {
        abort_unless(Schema::hasTable('workshops'), 503, 'Run migrations to enable workshop registration.');

        $validated = $this->validateWorkshopRegistrationPayload($request);

        /** @var Workshop $workshop */
        $workshop = Workshop::query()
            ->where('is_active', true)
            ->findOrFail($validated['workshop_id']);

        if ((float) $workshop->price <= 0) {
            return response()->json([
                'message' => 'This workshop does not require payment.',
            ], 422);
        }

        try {
            $orderPayload = $this->createWorkshopRazorpayOrder($workshop, $validated);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }

        return response()->json([
            'key' => (string) config('services.razorpay.key_id'),
            'amount' => (int) round(((float) $workshop->price) * 100),
            'currency' => $workshop->currency ?: 'INR',
            'workshop' => [
                'id' => $workshop->id,
                'title' => $workshop->title,
            ],
            'customer' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'contact' => $validated['phone'] ?? '',
            ],
            'order' => $orderPayload,
        ]);
    }

    public function verifyWorkshopPayment(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('workshops') && Schema::hasTable('workshop_registrations'), 503, 'Run migrations to enable workshop registration.');

        $validated = $this->validateWorkshopRegistrationPayload($request, true);

        /** @var Workshop $workshop */
        $workshop = Workshop::query()
            ->where('is_active', true)
            ->findOrFail($validated['workshop_id']);

        if ((float) $workshop->price <= 0) {
            return back()
                ->withInput()
                ->withErrors(['workshop' => 'This workshop does not require payment.']);
        }

        $secret = (string) config('services.razorpay.key_secret');

        if ($secret === '') {
            return back()
                ->withInput()
                ->withErrors(['workshop' => 'Razorpay is not configured right now.']);
        }

        $generatedSignature = hash_hmac(
            'sha256',
            $validated['razorpay_order_id'].'|'.$validated['razorpay_payment_id'],
            $secret
        );

        if (! hash_equals($generatedSignature, $validated['razorpay_signature'])) {
            return back()
                ->withInput()
                ->withErrors(['workshop' => 'Payment verification failed. Please try again.']);
        }

        DB::transaction(function () use ($validated, $workshop): void {
            WorkshopRegistration::query()->firstOrCreate(
                [
                    'workshop_id' => $workshop->id,
                    'payment_reference' => $validated['razorpay_payment_id'],
                ],
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'organization' => $validated['organization'] ?? null,
                    'learner_type' => $validated['learner_type'] ?? null,
                    'experience_level' => $validated['experience_level'] ?? null,
                    'attendance_mode' => $validated['attendance_mode'] ?? null,
                    'goals' => $validated['goals'] ?? null,
                    'questions' => $validated['questions'] ?? null,
                    'payment_amount' => (float) $workshop->price,
                    'currency' => $workshop->currency ?: 'INR',
                    'payment_screenshot_path' => null,
                    'payment_status' => 'verified',
                    'registration_status' => 'confirmed',
                    'source' => 'public-workshop-razorpay',
                ]
            );
        });

        return redirect()
            ->route('home.free_workshop')
            ->with('status', 'Payment successful. Your workshop seat has been reserved.');
    }

    public function mentorship(): View
    {
        return view('Home.free_mentorship');
    }

    public function about(): View
    {
        $siteStats = $this->siteStats();
        $mentorCards = collect($this->featuredFacultyCards())
            ->map(fn (array $card) => [
                'name' => $card['name'],
                'avatar' => $card['avatar'],
                'bio' => $card['bio'],
                'headline' => $card['role'],
            ]);

        return view('Home.about_us', [
            'siteStats' => $siteStats,
            'mentorCards' => $mentorCards,
            'achievementGallery' => $this->achievementGallery(),
        ]);
    }

    public function contact(Request $request): View
    {
        return view('Home.contact', [
            'initialTopic' => (string) $request->query('topic', ''),
            'initialSubject' => (string) $request->query('subject', ''),
            'courseOptions' => Course::query()
                ->where('status', 'published')
                ->orderBy('title')
                ->get(['id', 'title']),
        ]);
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'message' => ['required', 'string', 'max:5000'],
            'topic' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'workshop_title' => ['nullable', 'string', 'max:255'],
            'workshop_date' => ['nullable', 'string', 'max:255'],
            'workshop_time' => ['nullable', 'string', 'max:255'],
            'attendance_mode' => ['nullable', 'string', 'max:50'],
            'learner_type' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'organization' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'preferred_date' => ['nullable', 'date'],
            'preferred_time_slot' => ['nullable', 'string', 'max:100'],
            'preferred_mode' => ['nullable', 'string', 'max:50'],
            'class_visit_preference' => ['nullable', 'string', 'max:20'],
            'goals' => ['nullable', 'string', 'max:2000'],
            'questions' => ['nullable', 'string', 'max:2000'],
        ]);

        $topic = (string) ($validated['topic'] ?? 'general');

        $details = match ($topic) {
            'workshop' => array_filter([
                'Workshop' => $validated['workshop_title'] ?? null,
                'Date' => $validated['workshop_date'] ?? null,
                'Time' => $validated['workshop_time'] ?? null,
                'Attendance Mode' => $validated['attendance_mode'] ?? null,
                'Learner Type' => $validated['learner_type'] ?? null,
                'City' => $validated['city'] ?? null,
                'College / Company' => $validated['organization'] ?? null,
                'Experience Level' => $validated['experience_level'] ?? null,
                'Goals' => $validated['goals'] ?? null,
                'Questions' => $validated['questions'] ?? null,
            ], fn ($value) => filled($value)),
            'mentorship' => array_filter([
                'Preferred Date' => $validated['preferred_date'] ?? null,
                'Preferred Time Slot' => $validated['preferred_time_slot'] ?? null,
                'Preferred Mode' => $validated['preferred_mode'] ?? null,
                'Need Class Visit Guidance' => $validated['class_visit_preference'] ?? null,
                'Learner Type' => $validated['learner_type'] ?? null,
                'City' => $validated['city'] ?? null,
                'College / Company' => $validated['organization'] ?? null,
                'Experience Level' => $validated['experience_level'] ?? null,
                'Guidance Needed' => $validated['goals'] ?? null,
                'Questions' => $validated['questions'] ?? null,
            ], fn ($value) => filled($value)),
            'career' => array_filter([
                'Job Role' => $validated['subject'] ?? null,
                'City' => $validated['city'] ?? null,
                'Experience Level' => $validated['experience_level'] ?? null,
            ], fn ($value) => filled($value)),
            default => array_filter([
                'Learner Type' => $validated['learner_type'] ?? null,
                'City' => $validated['city'] ?? null,
                'College / Company' => $validated['organization'] ?? null,
                'Questions' => $validated['questions'] ?? null,
            ], fn ($value) => filled($value)),
        };

        PublicContact::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'message' => $validated['message'],
            'topic' => $topic,
            'subject' => $validated['subject']
                ?? ($validated['workshop_title'] ?? null)
                ?? ($topic === 'mentorship' ? 'Free Mentorship Appointment' : null),
            'source_page' => $topic === 'workshop'
                ? 'workshop'
                : ($topic === 'mentorship'
                    ? 'mentorship'
                    : ($topic === 'career' ? 'career-with-us' : 'contact')),
            'details' => $details,
            'status' => 'new',
        ]);

        return back()->with('status', 'Your message has been sent successfully. Our team will contact you soon.');
    }

    public function placement(): View
    {
        $siteStats = $this->siteStats();
        $stories = collect($this->homeStories('placement'))->values();

        return view('Home.placement', [
            'siteStats' => $siteStats,
            'placementStories' => $stories->all(),
            'placementHeroStories' => $stories
                ->filter(fn (array $story) => (bool) ($story['show_in_placement_hero'] ?? false))
                ->values()
                ->all(),
        ]);
    }

    public function unlockContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'context' => ['required', 'string', 'max:255'],
            'topic' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'audience' => ['nullable', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:2000'],
            'redirect_to' => ['required', 'string', 'max:2000'],
        ]);
        $safeRedirect = $this->sanitizeInternalRedirect(
            $validated['redirect_to'],
            route('home.courses', absolute: false)
        );

        PublicContact::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'message' => $validated['message'] ?? 'Requested access to gated public content.',
            'topic' => $validated['topic'] ?? 'lead_gate',
            'subject' => $validated['subject'] ?? 'Content access request',
            'status' => 'new',
            'source_page' => 'course-catalog',
            'access_context' => $validated['context'],
            'access_granted_at' => now(),
            'details' => [
                'redirect_to' => $safeRedirect,
                'context' => $validated['context'],
                'topic' => $validated['topic'] ?? 'lead_gate',
                'audience_segment' => $validated['audience'] ?? null,
            ],
        ]);

        $granted = $request->session()->get('content_gate_access', []);
        $granted[$validated['context']] = true;
        $request->session()->put('content_gate_access', $granted);

        return redirect($safeRedirect)->with('status', 'Thanks. Full details are now unlocked for you.');
    }

    private function sanitizeInternalRedirect(string $redirectTo, string $fallback): string
    {
        $redirectTo = trim($redirectTo);

        if ($redirectTo === '' || str_contains($redirectTo, '\\')) {
            return $fallback;
        }

        if (! str_starts_with($redirectTo, '/') || str_starts_with($redirectTo, '//')) {
            return $fallback;
        }

        $parts = parse_url($redirectTo);

        if ($parts === false || isset($parts['scheme']) || isset($parts['host'])) {
            return $fallback;
        }

        return $redirectTo;
    }

    private function publishedCoursesBaseQuery()
    {
        return Course::query()
            ->where('status', 'published')
            ->with(['category:id,name', 'user:id,name,avatar_path', 'sections.videos'])
            ->withCount(['reviews', 'enrollments as students_count'])
            ->withAvg('reviews', 'rating');
    }

    private function siteStats(): array
    {
        if (! Schema::hasTable('courses') || ! Schema::hasTable('users')) {
            return [
                'published_courses' => 0,
                'students' => 0,
                'mentors' => 0,
                'certificates' => 0,
                'reviews_count' => 0,
                'avg_rating' => 4.8,
                'enrollments' => 0,
            ];
        }

        $publishedCourses = Course::query()->where('status', 'published')->count();
        $students = User::query()->whereHas('role', fn ($query) => $query->where('name', 'user'))->count();
        $mentors = User::query()->whereHas('role', fn ($query) => $query->where('name', 'instructor'))->count();
        $certificates = \App\Models\Certificate::query()->count();
        $reviewsCount = Review::query()->count();
        $avgRating = (float) (Review::query()->avg('rating') ?? 0);
        $enrollments = \App\Models\Enrollment::query()->where('status', 'completed')->count();

        return [
            'published_courses' => $publishedCourses,
            'students' => $students,
            'mentors' => $mentors,
            'certificates' => $certificates,
            'reviews_count' => $reviewsCount,
            'avg_rating' => $avgRating > 0 ? round($avgRating, 1) : 4.8,
            'enrollments' => $enrollments,
        ];
    }

    private function mapCourseCard(Course $course): array
    {
        $durationSeconds = (int) $course->sections->flatMap->videos->sum(fn ($video) => (int) ($video->duration ?? 0));
        $rating = round((float) ($course->reviews_avg_rating ?? 0), 1) ?: 4.8;
        $studentsCount = (int) $course->students_count;
        $lessonCount = (int) $course->sections->sum(fn ($section) => $section->videos->count());
        $iconSet = $this->courseIconSet($course);
        $badge = $studentsCount >= 20
            ? ['label' => 'Best Seller', 'class' => 'bg-primary text-white']
            : ($rating >= 4.8
                ? ['label' => 'Top Rated', 'class' => 'bg-tertiary text-white']
                : ['label' => $course->category?->name ?? 'Published', 'class' => 'bg-slate-900/85 text-white']);

        return [
            'id' => $course->id,
            'title' => $course->title,
            'details' => $course->details,
            'thumbnail' => $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
            'price' => (float) ($course->price ?? 0),
            'mode' => 'online',
            'category' => $course->category?->name ?? 'Course',
            'level' => ucfirst((string) ($course->level ?: 'All Levels')),
            'language' => $course->language ?: 'English',
            'rating' => $rating,
            'reviews_count' => (int) $course->reviews_count,
            'students_count' => $studentsCount,
            'lesson_count' => $lessonCount,
            'duration' => $this->formatDuration($durationSeconds),
            'mentor' => $course->user?->name ?: 'Mentor-led program',
            'validity_label' => $course->validity_in_days ? $course->validity_in_days.' days access' : 'Lifetime access',
            'audience_segment' => $this->courseAudienceSegment($course),
            'audience_label' => $this->audienceLabel($this->courseAudienceSegment($course)),
            'details_url' => route('course.details', ['course' => $course->id]),
            'badge_label' => $badge['label'],
            'badge_class' => $badge['class'],
            'icon_one' => $iconSet[0],
            'icon_two' => $iconSet[1],
            'icon_three' => $iconSet[2],
        ];
    }

    private function mapOfflineCourseCard(OfflineCourse $course): array
    {
        $highlights = collect($course->highlights ?? [])->filter()->take(3)->values()->all();

        return [
            'id' => $course->id,
            'title' => $course->title,
            'details' => $course->summary,
            'thumbnail' => $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
            'price' => null,
            'mode' => 'offline',
            'category' => $course->category?->name ?? 'Offline Course',
            'level' => ucfirst((string) ($course->level ?: 'All Levels')),
            'language' => $course->language ?: 'English',
            'rating' => 5,
            'reviews_count' => 0,
            'students_count' => 0,
            'duration' => $course->duration_label ?: 'Classroom schedule',
            'details_url' => route('offline-course.details', ['offlineCourse' => $course->slug]),
            'badge_label' => 'Offline Classroom',
            'badge_class' => 'bg-primary text-white',
            'icon_one' => 'apartment',
            'icon_two' => 'groups',
            'icon_three' => 'support_agent',
            'campus' => $course->campus ?: 'Campus details on request',
            'schedule_label' => $course->schedule_label ?: 'Batch timing shared by mentor',
            'batch_size' => $course->batch_size ?: 'Limited seats',
            'audience' => $course->audience ?: 'Students and working professionals',
            'placement_label' => $course->placement_label ?: 'Placement-focused guidance',
            'delivery_mode' => $course->delivery_mode ?: 'Offline classroom',
            'validity_label' => $course->validity_label ?: 'Access shared by team',
            'learner_note' => $course->learner_note ?: 'Talk to the team to match the right batch, schedule, and mentor support.',
            'audience_segment' => $this->offlineCourseAudienceSegment($course),
            'audience_label' => $this->audienceLabel($this->offlineCourseAudienceSegment($course)),
            'highlights' => $highlights,
        ];
    }

    private function homeAudienceCourseShowcase(string $segment): Collection
    {
        $offline = OfflineCourse::query()
            ->where('is_active', true)
            ->with('category:id,name')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->filter(fn (OfflineCourse $course) => $this->offlineCourseAudienceSegment($course) === $segment)
            ->map(fn (OfflineCourse $course) => $this->mapOfflineCourseCard($course));

        $online = $this->publishedCoursesBaseQuery()
            ->limit(12)
            ->get()
            ->filter(fn (Course $course) => $this->courseAudienceSegment($course) === $segment)
            ->map(fn (Course $course) => $this->mapCourseCard($course));

        return $offline
            ->concat($online)
            ->take(3)
            ->values();
    }

    private function courseAudienceSegment(Course $course): ?string
    {
        return $this->detectAudienceSegment(
            implode(' ', array_filter([
                $course->title,
                $course->details,
                $course->category?->name,
                $course->level,
            ]))
        );
    }

    private function offlineCourseAudienceSegment(OfflineCourse $course): ?string
    {
        return $this->detectAudienceSegment(
            implode(' ', array_filter([
                $course->audience,
                $course->title,
                $course->summary,
                $course->details,
                $course->level,
            ]))
        );
    }

    private function detectAudienceSegment(?string $value): ?string
    {
        $text = strtolower((string) $value);

        if ($text === '') {
            return null;
        }

        if (
            str_contains($text, 'working')
            || str_contains($text, 'professional')
            || str_contains($text, 'upskill')
            || str_contains($text, 'career switch')
            || str_contains($text, 'employee')
        ) {
            return 'working-professional';
        }

        if (
            str_contains($text, 'college')
            || str_contains($text, 'student')
            || str_contains($text, 'fresher')
            || str_contains($text, 'beginner')
            || str_contains($text, 'campus')
        ) {
            return 'college-student';
        }

        return null;
    }

    private function audienceLabel(?string $segment): ?string
    {
        return match ($segment) {
            'working-professional' => 'Working Professional',
            'college-student' => 'College Student',
            default => null,
        };
    }

    private function paginateCollection(Collection $items, int $perPage, Request $request): LengthAwarePaginator
    {
        $page = max(1, (int) $request->query('page', 1));

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }

    private function courseIconSet(Course $course): array
    {
        $category = strtolower((string) ($course->category?->name ?? ''));
        $title = strtolower($course->title);

        if (str_contains($category, 'data') || str_contains($title, 'data')) {
            return ['database', 'terminal', 'monitoring'];
        }

        if (str_contains($category, 'stack') || str_contains($title, 'stack') || str_contains($title, 'web')) {
            return ['javascript', 'dns', 'cloud'];
        }

        if (str_contains($title, 'dsa') || str_contains($title, 'interview')) {
            return ['account_tree', 'psychology', 'speed'];
        }

        return ['school', 'workspace_premium', 'rocket_launch'];
    }

    private function applySort($query, string $sort): void
    {
        match ($sort) {
            'newest' => $query->latest(),
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'rating' => $query->orderByDesc('reviews_avg_rating'),
            default => $query->orderByDesc('students_count')->orderByDesc('reviews_avg_rating'),
        };
    }

    private function formatDuration(int $seconds): string
    {
        if ($seconds <= 0) {
            return 'Self-paced';
        }

        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        if ($hours > 0) {
            return trim($hours.' hr '.($minutes > 0 ? $minutes.' min' : ''));
        }

        return max(1, $minutes).' min';
    }

    private function careerPathLibrary(): array
    {
        return [
            $this->buildCareerPath([
                'slug' => 'sql-development',
                'title' => 'SQL Development - Professional Certification',
                'subtitle' => 'Master SQL for data management, analytics, database design, queries, and optimization with real datasets.',
                'role_label' => 'SQL Developer, Database Administrator, Data Analyst, BI Developer, ETL Developer',
                'duration' => '3 Months',
                'price' => 40000,
                'thumbnail' => asset('images/carrer%20paths/sql%20development.jpeg'),
                'skills' => ['SQL', 'Database Design', 'Joins', 'Optimization', 'ETL Basics'],
                'market_signal' => 'Companies still need people who can write fast queries and structure reliable reporting data.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This program distils everything hiring managers expect from SQL developers and data engineers. From schema design to window functions and optimisation, you will ship production-quality SQL assets.',
                'overview_highlight' => 'Every assignment mirrors real company requests: create marts, fix performance issues, enforce governance, and collaborate with analysts.',
                'career_outcomes' => ['SQL Developer', 'Database Administrator (Junior)', 'Data Analyst', 'BI Developer', 'ETL Developer'],
                'why_course_items' => [
                    'Master SQL for data management, analytics, and application development',
                    'Learn database design, normalisation, indexing, and transactions',
                    'Hands-on optimisation using EXPLAIN plans and tuning techniques',
                    'Build project-ready stored procedures, ETL scripts, and BI views',
                ],
                'ideal_for' => ['Beginners entering data roles', 'Excel users moving into SQL work', 'Learners targeting analyst jobs'],
                'deliverables' => ['SQL query portfolio', 'Schema design project', 'Reporting case study', 'SQL operations handbook'],
                'hiring_focus' => ['Query writing', 'Schema planning', 'Performance optimisation', 'Business reporting logic'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'A fast path for learners who want practical SQL skills they can show in interviews.',
                'weeks' => [
                    [
                        'label' => 'Weeks 1-3',
                        'title' => 'SQL Foundations & Query Mastery',
                        'items' => [
                            'SQL syntax, filtering, joins, grouping, subqueries, and set operations',
                            'Relational concepts, keys, constraints, and schema-reading practice',
                            'Business reporting queries with aggregations and reusable logic',
                            'Hands-on practice on real datasets for analyst-style problem solving',
                        ],
                        'project' => 'Project: Query workbook for sales, customer, and inventory reporting.',
                    ],
                    [
                        'label' => 'Weeks 4-6',
                        'title' => 'Database Design & Applied SQL Engineering',
                        'items' => [
                            'Database design, normalisation, indexing, and transactions',
                            'Views, CTEs, window functions, and reusable SQL patterns',
                            'Stored procedures, BI views, and ETL-ready transformation logic',
                            'Schema planning for reliable analytics and application use cases',
                        ],
                        'project' => 'Project: Design a reporting mart with production-ready SQL assets.',
                    ],
                    [
                        'label' => 'Weeks 7-9',
                        'title' => 'Performance & Automation',
                        'items' => [
                            'Indexing strategies, covered indexes, columnstore, partitioning',
                            'Query execution plans, cost-based optimisation, troubleshooting',
                            'Stored procedures, functions, triggers, scheduling (SQL Agent/cron)',
                            'Integration with ETL tools and Python scripts',
                        ],
                        'project' => 'Project: Performance lab + automation scripts for nightly refresh.',
                    ],
                    [
                        'label' => 'Weeks 10-12',
                        'title' => 'Governance & Career Toolkit',
                        'items' => [
                            'Data quality checks, lineage documentation, change management',
                            'Disaster recovery, backups, HA/DR patterns, migration checklists',
                            'Collaboration with BI & app teams, API exposure of SQL assets',
                            'Interview prep: SQL whiteboards, scenario-based questions',
                        ],
                        'project' => 'Project: SQL operations handbook with SOPs and monitoring dashboards.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Retail Analytics Database', 'subtitle' => 'Build a normalized schema and reporting queries for sales and inventory.', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'BI Query Pack', 'subtitle' => 'Create reusable SQL scripts for KPIs, validation, and dashboards.', 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume workshops with SQL-focused positioning',
                    'Mock interviews for query writing and optimisation rounds',
                    'Portfolio review for SQL, BI, and ETL project presentation',
                    'Mentor guidance on analyst, BI, and database role applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'full-stack-developer',
                'title' => 'Full Stack Developer - Master Certification',
                'subtitle' => 'Learn front-end, back-end, and databases, build real-world projects, and gain job-ready coding skills.',
                'role_label' => 'Full Stack Developer, Front-End Developer, Back-End Developer, Software Engineer, Application Architect',
                'duration' => '1 Year',
                'mode' => 'Online Cohort + Projects',
                'price' => 120000,
                'thumbnail' => asset('images/carrer%20paths/full%20stack.jpeg'),
                'skills' => ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js', 'Databases'],
                'market_signal' => 'Hiring teams value developers who can build interfaces, APIs, and deployments end to end.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This master certification mirrors the lifecycle of modern product engineering. You start with core web technologies, build complex front-ends, design resilient APIs, and finally automate deployments with CI/CD and cloud services.',
                'overview_highlight' => 'Weekly demos, code reviews, and pairing sessions keep you consistent, while hiring prep modules ensure you articulate design decisions confidently.',
                'career_outcomes' => ['Full Stack Developer', 'Front-End Developer', 'Back-End Developer', 'Software Engineer', 'Application Architect'],
                'why_course_items' => [
                    'Learn front-end, back-end, databases, and DevOps in one roadmap',
                    'Ship production-grade projects using modern frameworks and tooling',
                    'Master collaborative workflows: Git, testing, reviews, agile ceremonies',
                    'Graduate with a portfolio that proves coding depth and breadth',
                ],
                'ideal_for' => ['Beginners aiming for software jobs', 'Career switchers moving into development', 'Students building a serious portfolio'],
                'deliverables' => ['Deployed applications', 'GitHub portfolio', 'Interview-ready projects'],
                'hiring_focus' => ['Responsive UI', 'API design', 'Testing and collaboration', 'Deployment and architecture'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'This roadmap emphasizes shipping real products, not just completing tutorials.',
                'weeks' => [
                    [
                        'label' => 'Months 1-3',
                        'title' => 'Frontend Foundations',
                        'items' => [
                            'HTML5, CSS3, responsive layouts, accessibility, design systems',
                            'Modern JavaScript (ESNext), TypeScript essentials, testing with Jest',
                            'React + Next.js, hooks, state machines, performance optimisation',
                            'UI component libraries, storybook, design handoff best practices',
                        ],
                        'project' => 'Project: Multi-page SaaS UI with design system and testing coverage.',
                    ],
                    [
                        'label' => 'Months 4-6',
                        'title' => 'Backend & APIs',
                        'items' => [
                            'Node.js, Express/Fastify, REST vs GraphQL, WebSockets',
                            'Authentication, authorisation, JWT, OAuth, RBAC',
                            'SQL (PostgreSQL) & NoSQL (MongoDB) modelling, indexing, transactions',
                            'Background jobs, queues, caching with Redis',
                        ],
                        'project' => 'Project: Production-ready API with documentation and monitoring.',
                    ],
                    [
                        'label' => 'Months 7-9',
                        'title' => 'Quality, DevOps & Cloud',
                        'items' => [
                            'Automated testing pyramid, contract tests, loaders, feature flags',
                            'CI/CD pipelines using GitHub Actions, containerisation with Docker',
                            'Deployments on AWS/GCP/Azure, serverless functions, CDN strategy',
                            'Observability: logging, metrics, tracing, alerting',
                        ],
                        'project' => 'Project: Full-stack app deployed with CI/CD and observability dash.',
                    ],
                    [
                        'label' => 'Months 10-12',
                        'title' => 'Product Engineering & Career Sprint',
                        'items' => [
                            'Agile ceremonies, backlog grooming, estimation, documentation',
                            'System design fundamentals, scaling strategies, trade-off analysis',
                            'Open-source contributions, hackathons, freelancing pathways',
                            'DSA for interviews plus behavioural storytelling workshop',
                        ],
                        'project' => 'Project: Capstone product with public roadmap, docs, and launch video.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Learning Platform App', 'subtitle' => 'Authentication, dashboards, training programs, and admin flows in one product.', 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Service Marketplace', 'subtitle' => 'Build APIs, bookings, dashboards, and a deployable web app.', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'GitHub portfolio review and launch feedback',
                    'Resume and LinkedIn refinement for product engineering roles',
                    'Mock coding interviews with system design discussion',
                    'Project presentation mentoring and hiring prep',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'cloud-computing',
                'title' => 'Cloud Computing - Professional Certification',
                'subtitle' => 'Master AWS and Azure, learn cloud deployment, security, scalability, and industry tools.',
                'role_label' => 'Cloud Engineer, AWS/Azure Administrator, Cloud Solutions Architect, Cloud Security Specialist',
                'duration' => '6 Months',
                'price' => 60000,
                'thumbnail' => asset('images/carrer%20paths/cloud%20computing.jpeg'),
                'skills' => ['AWS', 'Azure', 'Linux', 'Networking', 'Security', 'Monitoring'],
                'market_signal' => 'Cloud teams need engineers who can launch secure, scalable systems, not just local apps.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'The Cloud Computing professional track focuses on the most requested job skills across AWS and Azure ecosystems. From VPC design to IaC automation, you learn by deploying workloads that matter to hiring managers.',
                'overview_highlight' => 'You will run infra cost audits, implement zero-downtime rollouts, and document architecture decisions to demonstrate end-to-end ownership.',
                'career_outcomes' => ['Cloud Engineer / Cloud Administrator', 'Site Reliability Engineer', 'DevOps Engineer', 'Cloud Solutions Architect', 'Cloud Security Specialist'],
                'why_course_items' => [
                    'Master AWS & Azure fundamentals to advanced services',
                    'Design secure, scalable, and cost-effective cloud infrastructures',
                    'Automate deployments with CI/CD, IaC, and monitoring stacks',
                    'Build a multi-cloud portfolio to target high-paying cloud roles',
                ],
                'ideal_for' => ['Support engineers moving into cloud', 'Developers learning deployment', 'Learners targeting cloud jobs'],
                'deliverables' => ['Cloud architecture portfolio', 'Deployment labs', 'Security case studies'],
                'hiring_focus' => ['Core cloud services', 'Secure deployment', 'Monitoring and reliability', 'Security and governance'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'Built to connect cloud theory with the daily tasks companies actually hire for.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Cloud Foundations & Networking',
                        'items' => [
                            'AWS & Azure core services, identity, and access management',
                            'VPC/VNet design, routing, load balancing, hybrid connectivity',
                            'Storage tiers, lifecycle policies, CDN optimisation',
                            'Hands-on labs using AWS Console, Azure Portal, and CLI',
                        ],
                        'project' => 'Project: Multi-tier network blueprint serving a demo web stack.',
                    ],
                    [
                        'label' => 'Months 2-3',
                        'title' => 'Compute, Containers & Serverless',
                        'items' => [
                            'EC2/VM scale sets, autoscaling strategies, capacity planning',
                            'Docker fundamentals, EKS/AKS orchestration, service mesh basics',
                            'Serverless patterns with Lambda, Event Grid, Step Functions',
                            'Observability: CloudWatch, Azure Monitor, distributed tracing',
                        ],
                        'project' => 'Project: Containerised services with autoscaling & blue/green deploys.',
                    ],
                    [
                        'label' => 'Month 4',
                        'title' => 'Security, Compliance & FinOps',
                        'items' => [
                            'Identity federation, secrets management, encryption strategies',
                            'WAF, Shield, Defender for Cloud, security baselines automation',
                            'Cost governance dashboards, savings plans, right-sizing playbooks',
                            'Compliance mapping (SOC2, ISO 27001) and audit evidence prep',
                        ],
                        'project' => 'Project: Cloud security posture report plus remediation tracker.',
                    ],
                    [
                        'label' => 'Months 5-6',
                        'title' => 'Automation & Migration Capstone',
                        'items' => [
                            'Infrastructure as Code with Terraform/Bicep, GitOps workflows',
                            'CI/CD pipelines (GitHub Actions, Azure DevOps, CodePipeline)',
                            'Lift-and-shift vs refactor migration decision frameworks',
                            'Stakeholder documentation, architecture runbooks, HADR drills',
                        ],
                        'project' => 'Project: Legacy app migration with IaC repo and operations handbook.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Scalable Web Deployment', 'subtitle' => 'Deploy a production-style app with secure access and monitoring.', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Multi-Cloud Design Case', 'subtitle' => 'Plan AWS and Azure solutions for availability, security, and cost.', 'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for cloud, DevOps, and SRE role positioning',
                    'Mock interviews around architecture, incident scenarios, and operations',
                    'Portfolio review for AWS, Azure, IaC, and monitoring projects',
                    'Mentor guidance for certification-aligned job applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'cyber-security-ethical-hacking',
                'title' => 'Cyber Security & Ethical Hacking - Professional Certification',
                'subtitle' => 'Learn ethical hacking and defense with industry tools, real-world labs, and guided security projects.',
                'role_label' => 'Ethical Hacker, Cyber Security Analyst, Network Security Engineer',
                'duration' => '6 Months',
                'price' => 60000,
                'thumbnail' => asset('images/carrer%20paths/cyber%20security.jpeg'),
                'skills' => ['Networking', 'Ethical Hacking', 'Vulnerability Assessment', 'Linux', 'Web Security'],
                'market_signal' => 'Security hiring favors candidates who understand both attack methods and practical defense.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This professional certification mirrors the workflows inside modern SOC and red-team units. You will jump between reconnaissance, exploitation, forensics, and remediation activities using the same toolchain adopted in enterprise environments.',
                'overview_highlight' => 'Every milestone concludes with a blue-team plus red-team simulation so you can speak about measurable impact during interviews.',
                'career_outcomes' => ['Ethical Hacker / Penetration Tester', 'Cyber Security Analyst', 'Network Security Engineer', 'SOC Analyst', 'Security Automation Specialist'],
                'why_course_items' => [
                    'Master ethical hacking and defensive security in one track',
                    'Hands-on labs with Kali Linux, Burp Suite, Wireshark, Metasploit, and more',
                    'Real-world projects simulating ransomware, phishing, and insider threats',
                    'Future-proof skills demanded by security operations centres',
                ],
                'ideal_for' => ['Learners interested in cyber defense', 'Networking students moving into security', 'Beginners who want lab-based training'],
                'deliverables' => ['Security lab portfolio', 'Vulnerability reports', 'Hardening exercises'],
                'hiring_focus' => ['Vulnerability analysis', 'System hardening', 'Security reporting', 'SOC operations and automation'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'The learning stays practical and defensive so your projects remain credible and safe.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Offensive Security Foundations',
                        'items' => [
                            'Linux essentials, networking, TCP/IP deep dives',
                            'Reconnaissance, enumeration, vulnerability scanning',
                            'Password attacks, exploitation fundamentals, privilege escalation',
                            'Reporting templates for vulnerability disclosures',
                        ],
                        'project' => 'Project: Red-team assessment for a mock fintech stack.',
                    ],
                    [
                        'label' => 'Months 2-3',
                        'title' => 'Web, Cloud & Wireless Security',
                        'items' => [
                            'OWASP Top 10 exploitation labs with Burp Suite',
                            'API security testing, JWT attacks, GraphQL abuse patterns',
                            'Cloud misconfiguration hunting on AWS/Azure labs',
                            'Wireless cracking, rogue AP detection, secure configurations',
                        ],
                        'project' => 'Project: Offensive + defensive hardening report for a SaaS product.',
                    ],
                    [
                        'label' => 'Month 4',
                        'title' => 'Defensive Security & SOC Automation',
                        'items' => [
                            'SIEM setup (Splunk/ELK), log correlation, threat hunting',
                            'Endpoint detection & response workflows',
                            'Incident response runbooks, chain-of-custody, forensics basics',
                            'Automating playbooks using Python and SOAR concepts',
                        ],
                        'project' => 'Project: SOC dashboard with automated alert triage scripts.',
                    ],
                    [
                        'label' => 'Months 5-6',
                        'title' => 'Certification Prep & Capstone',
                        'items' => [
                            'CEH, CompTIA Security+, AZ-500 style question banks',
                            'Purple-team exercises covering reconnaissance to remediation',
                            'Interview simulations for security analyst roles',
                            'Personal brand building: GitHub PoCs, blogs, LinkedIn writeups',
                        ],
                        'project' => 'Project: Purple-team war-game with executive debrief pack.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Network Security Audit', 'subtitle' => 'Assess a sample network and recommend remediations.', 'image' => 'https://images.unsplash.com/photo-1510511459019-5dda7724fd87?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Web App Security Lab', 'subtitle' => 'Test common vulnerabilities and document secure fixes.', 'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for SOC, analyst, and penetration testing roles',
                    'Mock interviews around incident response, exploitation, and reporting',
                    'Portfolio review for labs, PoCs, and security documentation',
                    'Mentor guidance for certification-aligned and operations-focused applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'data-science-with-ai',
                'title' => 'Data Science with AI - Advanced Certification',
                'subtitle' => 'End-to-end AI and data science mastery with hands-on projects, real tools, frameworks, and career preparation.',
                'role_label' => 'Data Scientist, ML Engineer, AI Specialist, NLP Engineer, BI Analyst',
                'duration' => '7 Months',
                'price' => 120000,
                'thumbnail' => asset('images/carrer%20paths/data%20science%20with%20ai.jpeg'),
                'skills' => ['Python', 'SQL', 'Machine Learning', 'Deep Learning', 'NLP'],
                'market_signal' => 'AI and analytics teams need people who can clean data, train models, and explain outcomes clearly.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'The Data Science with AI - Advanced Certification compresses 12+ months of industry learning into a high-intensity 7-month journey. Learners advance from statistics and Python fundamentals to production-grade ML ops workflows while consistently building portfolio-grade solutions.',
                'overview_highlight' => 'Weekly mentor guidance, resume reviews, and interview simulations ensure you graduate with employer-ready deliverables plus the confidence to present them.',
                'career_outcomes' => ['Data Scientist', 'Machine Learning Engineer', 'AI Specialist / NLP Engineer', 'Business Intelligence Analyst', 'Product Data Consultant'],
                'why_course_items' => [
                    'End-to-end AI & Data Science mastery using real frameworks',
                    'Hands-on projects spanning notebooks, APIs, and dashboards',
                    'Expert guidance with resume, GitHub grooming, and mock interviews',
                    'Dedicated placement cell focused on high-paying data careers',
                ],
                'ideal_for' => ['Students targeting AI careers', 'Analysts upgrading into ML work', 'Working professionals moving into data science'],
                'deliverables' => ['Advanced ML portfolio', 'Capstone case study', 'Interview-ready projects'],
                'hiring_focus' => ['Preprocessing and feature engineering', 'Model evaluation', 'MLOps readiness', 'Business communication'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'This path combines tool depth with visible project work so your profile feels stronger than a course-only resume.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Python, Statistics & Data Engineering',
                        'items' => [
                            'Python foundations, object-oriented design, scripting best practices',
                            'Exploratory data analysis with pandas, NumPy, Matplotlib, Seaborn',
                            'Statistics for analytics: probability, hypothesis testing, experiment design',
                            'SQL + NoSQL pipelines to land curated datasets in analytics-ready layers',
                        ],
                        'project' => 'Project: Automated KPI data mart (Python + SQL) with quality checks.',
                    ],
                    [
                        'label' => 'Months 2-3',
                        'title' => 'Machine Learning Foundations',
                        'items' => [
                            'Feature engineering, scaling, encoding, class imbalance resolution',
                            'Supervised learning: regression, tree ensembles, gradient boosting',
                            'Unsupervised learning: clustering, PCA/UMAP, anomaly detection',
                            'Model evaluation dashboards with cross-validation and SHAP insights',
                        ],
                        'project' => 'Project: Customer lifecycle prediction with explainable ML playbook.',
                    ],
                    [
                        'label' => 'Months 4-5',
                        'title' => 'Deep Learning & Applied AI',
                        'items' => [
                            'Neural network basics, CNNs for vision, RNN/LSTM/Transformers for sequences',
                            'Transfer learning, prompt engineering, and retrieval-augmented generation (RAG)',
                            'LLM fine-tuning, embeddings search, and conversational AI design',
                            'Responsible AI: fairness audits, monitoring, human-in-loop controls',
                        ],
                        'project' => 'Project: Multi-modal AI assistant (text + image) with FastAPI endpoint.',
                    ],
                    [
                        'label' => 'Months 6-7',
                        'title' => 'MLOps & Career Sprint',
                        'items' => [
                            'Model packaging with Docker, CI/CD pipelines, and cloud deployment (AWS/GCP)',
                            'Scheduling with Airflow, experiment tracking via MLflow, data versioning',
                            'Job simulations: whiteboard rounds, case study storytelling',
                            'Portfolio polish: GitHub curation, LinkedIn branding, resume narratives',
                        ],
                        'project' => 'Project: Production-ready ML workflow with monitoring & rollback strategy.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Customer Churn Prediction', 'subtitle' => 'Forecast attrition and recommend retention actions from business data.', 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'NLP Review Intelligence', 'subtitle' => 'Classify and summarize product reviews for real decision-making insights.', 'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume reviews and profile positioning for AI, ML, and analytics roles',
                    'Mock interviews covering ML concepts, case studies, and storytelling rounds',
                    'Portfolio review for notebooks, APIs, dashboards, and deployment projects',
                    'Mentor guidance for high-paying data and AI role applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'data-analytics',
                'title' => 'Data Analytics - Professional Certification',
                'subtitle' => 'Learn analytics and Python, SQL, Power BI, Tableau, dashboards, and predictive models.',
                'role_label' => 'Data Analyst, BI Analyst, Predictive Analytics Specialist, Reporting Analyst, Junior Data Scientist',
                'duration' => '4 Months',
                'price' => 60000,
                'thumbnail' => asset('images/carrer%20paths/data%20analytics%20with%20ai.jpeg'),
                'skills' => ['Excel', 'Python', 'SQL', 'Power BI', 'Tableau'],
                'market_signal' => 'Entry-level analytics hiring often centers on SQL, dashboards, and strong business storytelling.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'The Data Analytics with AI certification is designed for freshers and upskillers who need a compact yet outcome-driven learning path. You will cover Excel, SQL, Python, and BI tooling while layering AI assistants that speed up reporting, analysis, and communication.',
                'overview_highlight' => 'Each module is tied to a sprint project so you can demonstrate measurable proof of work during interviews.',
                'career_outcomes' => ['Data Analyst / Reporting Analyst', 'Business Intelligence Analyst', 'Predictive Analytics Specialist', 'Operations / Marketing Analyst', 'Junior Data Scientist'],
                'why_course_items' => [
                    'Learn analytics plus AI fundamentals without filler content',
                    'Hands-on practice across Excel, SQL, Python, Power BI, and Tableau',
                    'AI copilots for faster data cleaning, visualization, and narratives',
                    'Become job-ready for analyst roles in just 4 months',
                ],
                'ideal_for' => ['Beginners who want a fast analyst roadmap', 'Students from non-coding backgrounds', 'Working professionals moving into BI'],
                'deliverables' => ['Dashboard portfolio', 'Analytics case studies', 'Predictive mini-projects'],
                'hiring_focus' => ['KPI analysis', 'Dashboard building', 'Practical SQL and Python use', 'Business storytelling'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'A shorter path designed for learners who want visible analyst skills in a few months.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Spreadsheet Intelligence',
                        'items' => [
                            'Advanced Excel & Google Sheets with dynamic arrays and automation',
                            'Data cleaning playbook (Power Query, macros, AI fill tools)',
                            'Executive dashboards with KPI stories, slicers, and alerts',
                            'Prompting Copilot/Gemini to document and QA spreadsheets',
                        ],
                        'project' => 'Project: Auto-refresh sales control tower delivered as Excel + Sheets.',
                    ],
                    [
                        'label' => 'Month 2',
                        'title' => 'SQL & Databases',
                        'items' => [
                            'MySQL querying from basics to window functions & optimisation',
                            'Working with semi-structured data using MongoDB aggregation pipelines',
                            'dbt-style modelling patterns: facts, dimensions, slowly changing entities',
                            'Using Python + SQLAlchemy to operationalise queries',
                        ],
                        'project' => 'Project: Customer segmentation warehouse powering downstream BI.',
                    ],
                    [
                        'label' => 'Month 3',
                        'title' => 'Python Analytics & Predictive Insights',
                        'items' => [
                            'pandas pipelines, feature engineering, and automated reports',
                            'Exploratory data analysis co-piloted with AI summarisation tools',
                            'Intro ML: regression, classification, clustering with scikit-learn',
                            'Communicating insights via narrated notebooks and HTML exports',
                        ],
                        'project' => 'Project: Predictive demand model with automated stakeholder brief.',
                    ],
                    [
                        'label' => 'Month 4',
                        'title' => 'Business Intelligence & Storytelling',
                        'items' => [
                            'Power BI modeling, DAX, Row-Level Security, scheduled refresh',
                            'Tableau Prep + Viz best practices, parameter-driven dashboards',
                            'Looker Studio for lightweight, shareable exec scorecards',
                            'Storytelling frameworks, KPI writing, and video walkthroughs',
                        ],
                        'project' => 'Project: End-to-end performance cockpit with AI-generated talking points.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Executive KPI Dashboard', 'subtitle' => 'Design a clean dashboard for sales, churn, and growth trends.', 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Forecasting Insights Pack', 'subtitle' => 'Combine SQL, Python, and BI visuals into a business-ready report.', 'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for analyst, BI, and reporting role applications',
                    'Mock interviews around SQL, dashboards, KPIs, and business questions',
                    'Portfolio review for spreadsheets, BI dashboards, and Python analysis work',
                    'Mentor guidance for fresher and upskilling pathways into analytics jobs',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'mobile-application-development',
                'title' => 'Mobile Application Development - Professional Certification',
                'subtitle' => 'Learn iOS and Android development, UI/UX, Swift, Kotlin, and cross-platform tools through real app projects.',
                'role_label' => 'Mobile App Developer, UI/UX Designer, Application Consultant',
                'duration' => '6 Months',
                'price' => 70000,
                'thumbnail' => asset('images/carrer%20paths/mobile%20application.jpeg'),
                'skills' => ['Android', 'iOS', 'Kotlin', 'Swift', 'UI/UX', 'Cross-Platform'],
                'market_signal' => 'Mobile-first products still create strong demand for developers who can ship usable, polished apps.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This program mirrors the lifecycle of successful mobile teams. You start with design foundations, move into native iOS and Android development, then explore Flutter for cross-platform delivery.',
                'overview_highlight' => 'Release engineering, analytics, monetisation, and optimisation are covered so you can operate apps post-launch.',
                'career_outcomes' => ['Mobile App Developer', 'Flutter Developer', 'iOS Developer', 'Android Developer', 'Application Consultant'],
                'why_course_items' => [
                    'Learn iOS (SwiftUI) and Android (Kotlin) fundamentals plus Flutter',
                    'Master UI/UX design for mobile, usability testing, design handoff',
                    'Build production-ready apps with APIs, notifications, offline storage',
                    'Gain deployment, monetisation, and analytics experience',
                ],
                'ideal_for' => ['Learners interested in Android and iOS', 'Web developers expanding into mobile', 'Students who enjoy app UI work'],
                'deliverables' => ['Mobile app prototypes', 'UI portfolio', 'Capstone app project'],
                'hiring_focus' => ['Mobile UI quality', 'API integration', 'App testing and delivery', 'Release and analytics readiness'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'The track blends app coding with product thinking so your work feels more complete.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Mobile UI/UX Foundations',
                        'items' => [
                            'Design systems for mobile, platform guidelines, accessibility',
                            'Prototyping with Figma, usability testing, animation basics',
                            'Handoff best practices, collaborating with product & QA',
                            'App architecture patterns overview (MVVM, Redux, Clean)',
                        ],
                        'project' => 'Project: UX case study for a multi-screen consumer app.',
                    ],
                    [
                        'label' => 'Months 2-3',
                        'title' => 'Native iOS & Android Development',
                        'items' => [
                            'Swift + SwiftUI, Combine, Core Data, networking, Swift Package Manager',
                            'Kotlin + Jetpack Compose, coroutines, Room, Hilt, WorkManager',
                            'Platform services: camera, location, biometrics, background tasks',
                            'Testing strategies: unit, UI, instrumentation, snapshot testing',
                        ],
                        'project' => 'Project: Feature-parity native apps consuming the same API.',
                    ],
                    [
                        'label' => 'Month 4',
                        'title' => 'Cross-Platform & Backend Integration',
                        'items' => [
                            'Flutter widgets, state management (Bloc/Provider), theming',
                            'API integration, GraphQL, gRPC, offline-first patterns',
                            'Realtime features with Firebase, push notifications, analytics',
                            'App security, encryption, secure storage',
                        ],
                        'project' => 'Project: Flutter super-app with modular architecture.',
                    ],
                    [
                        'label' => 'Months 5-6',
                        'title' => 'Release Engineering & Career Sprint',
                        'items' => [
                            'CI/CD with Fastlane, Codemagic, Bitrise: automated testing pipelines',
                            'Play Store & App Store submission, ASO, crash monitoring (Firebase Crashlytics)',
                            'Monetisation strategies, in-app purchases, subscriptions, ads',
                            'Consulting toolkit: project scoping, estimations, freelance readiness',
                        ],
                        'project' => 'Project: Store-ready app launch with growth & analytics playbook.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Food Ordering App', 'subtitle' => 'Create ordering, cart, login, and checkout-ready mobile flows.', 'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Fitness Tracker App', 'subtitle' => 'Build reminders, dashboards, and profile-driven mobile screens.', 'image' => 'https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for iOS, Android, Flutter, and mobile product roles',
                    'Mock interviews around mobile architecture, APIs, and release workflows',
                    'Portfolio review for app case studies, native builds, and Flutter projects',
                    'Mentor guidance for app publishing, freelancing, and job applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'web-development-full-stack',
                'title' => 'Web Development - Full Stack Certification',
                'subtitle' => 'Master front-end, back-end, and databases with React, Node.js, SQL/NoSQL, APIs, and real-world projects.',
                'role_label' => 'Front-End Developer, Back-End Developer, Full-Stack Developer, Web Application Developer',
                'duration' => '6 Months',
                'price' => 70000,
                'thumbnail' => asset('images/carrer%20paths/web%20development.jpeg'),
                'skills' => ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js', 'SQL/NoSQL'],
                'market_signal' => 'A faster path for learners who want strong web skills without a one-year program.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This certification accelerates your journey into full-stack web engineering. In six months you will ship responsive interfaces, secure APIs, and production deployments with confidence.',
                'overview_highlight' => 'The curriculum emphasises rapid iteration, code reviews, and practical assignments so you build the habit of delivering features continuously.',
                'career_outcomes' => ['Front-End Developer', 'Back-End Developer', 'Full Stack Developer', 'Web Application Developer', 'Product Engineer'],
                'why_course_items' => [
                    'Master front-end, back-end, and database fundamentals together',
                    'Learn React, Node.js, Express, REST, and real-time APIs',
                    'Work on real-world full-stack web projects from sprint zero to release',
                    'Gain job-ready skills for modern product and agency teams',
                ],
                'ideal_for' => ['Students wanting a shorter development roadmap', 'Beginners building web product skills', 'Learners targeting internships'],
                'deliverables' => ['Responsive portfolio', 'API-backed projects', 'Deployment-ready capstone'],
                'hiring_focus' => ['Frontend polish', 'Backend logic', 'Database usage and deployment', 'Production release readiness'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'The stack stays focused and practical so learners move quickly from basics to portfolio work.',
                'weeks' => [
                    [
                        'label' => 'Months 1-2',
                        'title' => 'Front-End Production Skills',
                        'items' => [
                            'Semantic HTML, CSS architecture, Tailwind/SCSS workflows',
                            'JavaScript mastery, browser APIs, state management patterns',
                            'React fundamentals, hooks, context, routing, suspense',
                            'Testing UI flows with React Testing Library and Cypress',
                        ],
                        'project' => 'Project: Responsive marketplace UI with reusable component library.',
                    ],
                    [
                        'label' => 'Months 3-4',
                        'title' => 'Back-End APIs & Databases',
                        'items' => [
                            'Node.js + Express APIs, authentication, validation, error handling',
                            'REST vs GraphQL, uploading, streaming, WebSocket real-time features',
                            'MongoDB & PostgreSQL data modelling, migrations, seeders',
                            'Caching, rate limiting, security hardening',
                        ],
                        'project' => 'Project: API-first service powering the front-end application.',
                    ],
                    [
                        'label' => 'Month 5',
                        'title' => 'DevOps & Deployment',
                        'items' => [
                            'Git workflows, code reviews, CI/CD with GitHub Actions',
                            'Dockerising services, environment management, secrets handling',
                            'Cloud deployment on Vercel, Render, AWS, or Azure',
                            'Monitoring, logging, and performance tuning',
                        ],
                        'project' => 'Project: Production deployment with pipeline and observability.',
                    ],
                    [
                        'label' => 'Month 6',
                        'title' => 'Career Sprint & Capstone',
                        'items' => [
                            'Agile teamwork, project tracking, documentation best practices',
                            'Capstone build with user auth, payments, notifications',
                            'Open-source contributions and hackathon simulations',
                            'Interview readiness: DSA refresh, system design primers',
                        ],
                        'project' => 'Project: Full-stack capstone with public demo and tech blog.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Portfolio + Blog Platform', 'subtitle' => 'Combine content management, auth, and responsive UI in one product.', 'image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Job Board Web App', 'subtitle' => 'Build search, posting flows, dashboards, and backend APIs.', 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for front-end, back-end, and full-stack role applications',
                    'Mock interviews around React, Node.js, APIs, and deployment workflows',
                    'Portfolio review for UI systems, APIs, and production-ready capstones',
                    'Mentor guidance for internships, product teams, and agency roles',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'advance-digital-marketing',
                'title' => 'Advance Digital Marketing - Professional Certification',
                'subtitle' => 'Master SEO, SEM, social media, content marketing, Google Ads, Meta Ads, analytics, and real project execution.',
                'role_label' => 'Digital Marketing Specialist, SEO/SEM Manager, Social Media Strategist, Content Marketer',
                'duration' => '7 Months',
                'price' => 120000,
                'thumbnail' => asset('images/carrer%20paths/advanced%20digital%20marketing.jpeg'),
                'skills' => ['SEO', 'SEM', 'Google Ads', 'Meta Ads', 'Analytics', 'Content Strategy'],
                'market_signal' => 'Brands hire marketers who can connect traffic, campaigns, content, and reporting into one growth system.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'Our Advance Digital Marketing certification simulates agency life: briefs, brainstorming, execution, optimisation, and reporting. You will drive multi-channel campaigns, work with Google Ads and Meta Ads, and master analytics to prove ROI.',
                'overview_highlight' => 'Leadership modules on stakeholder management, freelancing, and pitching ensure you can hold conversations with clients and hiring managers alike.',
                'career_outcomes' => ['Digital Marketing Specialist', 'SEO/SEM Manager', 'Performance Marketer', 'Social Media Strategist', 'Content Marketing Lead'],
                'why_course_items' => [
                    'Master SEO, SEM, Social Media, Content, and Automation in one program',
                    'Hands-on practice with Google Ads, Meta Ads, Analytics, Tag Manager & CRM stacks',
                    'Work on real brands, case studies, and performance dashboards',
                    'Graduate with campaign narratives that prove marketing ROI',
                ],
                'ideal_for' => ['Students entering marketing roles', 'Business owners learning digital growth', 'Creatives moving into performance marketing'],
                'deliverables' => ['Campaign portfolio', 'SEO and ads reports', 'Live case studies'],
                'hiring_focus' => ['Campaign execution', 'Audience targeting', 'Reporting and optimization', 'Client communication'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'The course is designed to make your marketing skills measurable and employer-friendly.',
                'weeks' => [
                    [
                        'label' => 'Months 1-2',
                        'title' => 'Organic Growth Engine',
                        'items' => [
                            'Advanced SEO: technical audits, schema, Core Web Vitals, E-E-A-T',
                            'Content strategy, topic clusters, AI-assisted content workflows',
                            'App store optimisation, YouTube SEO, podcast discoverability',
                            'Social media playbooks across Meta, LinkedIn, Instagram, X',
                        ],
                        'project' => 'Project: Organic growth roadmap with 90-day execution calendar.',
                    ],
                    [
                        'label' => 'Months 3-4',
                        'title' => 'Performance Marketing Lab',
                        'items' => [
                            'Google Ads search/shopping/video campaigns with conversion tracking',
                            'Meta Ads funnel design, creative testing, incrementality measurement',
                            'Analytics 4 + Tag Manager mastery, server-side tracking basics',
                            'Budget pacing, ROAS optimisation, stakeholder reporting decks',
                        ],
                        'project' => 'Project: Multi-channel paid media sprint with live dashboards.',
                    ],
                    [
                        'label' => 'Month 5',
                        'title' => 'Automation & CRM Journeys',
                        'items' => [
                            'Email/SMS/push journeys using Customer.io, HubSpot, or Zoho',
                            'Lead scoring, lifecycle automation, retention campaigns',
                            'No-code automation with Zapier/Make for marketing ops',
                            'Attribution models: first touch, multi-touch, MMM introduction',
                        ],
                        'project' => 'Project: Retention automation blueprint tied to revenue targets.',
                    ],
                    [
                        'label' => 'Months 6-7',
                        'title' => 'Consulting & Career Sprint',
                        'items' => [
                            'Pitch decks, proposal writing, pricing strategies, contract basics',
                            'Client handling role-plays, objection management, QBR demos',
                            'Freelancing platforms, personal brand & authority content',
                            'Mock interviews for agency, brand, and consulting roles',
                        ],
                        'project' => 'Project: Full-funnel campaign case study with ROI storytelling.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Brand Growth Campaign', 'subtitle' => 'Plan SEO, paid ads, content, and reporting for a product launch.', 'image' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Performance Dashboard Pack', 'subtitle' => 'Present campaign KPIs, conversions, and optimization recommendations.', 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for SEO, performance marketing, content, and social roles',
                    'Mock interviews around ads strategy, analytics, SEO, and client communication',
                    'Portfolio review for campaign audits, dashboards, and ROI case studies',
                    'Mentor guidance for agency, freelance, and in-house marketing applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'graphic-designing',
                'title' => 'Graphic Designing - Creative Certification',
                'subtitle' => 'Learn top design tools, design and UI/UX basics, build a professional portfolio, and develop job and freelancing skills.',
                'role_label' => 'Graphic Designer, UI/UX Designer, Visual Branding Specialist, Social Media Designer',
                'duration' => '4 Months',
                'price' => 50000,
                'thumbnail' => asset('images/carrer%20paths/garphic%20designing.jpeg'),
                'skills' => ['Photoshop', 'Illustrator', 'Branding', 'Layout Design', 'UI/UX Basics'],
                'market_signal' => 'Design hiring rewards portfolios that show strong branding, layout quality, and digital asset work.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This creative certification helps you master visual storytelling while building a portfolio that speaks to agencies, startups, and freelance clients. You will work with Adobe Photoshop, Illustrator, InDesign, and Figma alongside branding strategy assignments.',
                'overview_highlight' => 'Soft skills such as pitching, brief decoding, and revisions management are baked into every project so you can handle real client expectations.',
                'career_outcomes' => ['Graphic Designer', 'UI/UX Designer (Foundational Level)', 'Visual Branding Specialist', 'Social Media Designer', 'Freelance Creative Partner'],
                'why_course_items' => [
                    'Learn top design tools across print, digital, and UI/UX surfaces',
                    'Master visual strategy, typography, colour psychology, and layout systems',
                    'Create a publication-ready portfolio with mock client briefs',
                    'Gain freelancing and job-search playbooks tailored to creatives',
                ],
                'ideal_for' => ['Creative students building a portfolio', 'Freelancers wanting stronger design skills', 'Beginners entering branding work'],
                'deliverables' => ['Portfolio showcase', 'Brand identity case study', 'Social asset collection'],
                'hiring_focus' => ['Design fundamentals', 'Brand consistency', 'Professional presentation', 'Client-ready communication'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'The path is built around visible output so learners leave with work they can actually show.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Design Foundations & Tooling',
                        'items' => [
                            'Design principles, gestalt, grids, colour theory, typography systems',
                            'Photoshop for compositing, retouching, social assets, mockups',
                            'Illustrator for logos, iconography, vector illustration workflows',
                            'Rapid ideation and moodboard techniques',
                        ],
                        'project' => 'Project: Brand identity kit for a lifestyle startup.',
                    ],
                    [
                        'label' => 'Month 2',
                        'title' => 'Publishing & Marketing Collateral',
                        'items' => [
                            'InDesign layouts, brochure & magazine design, print production basics',
                            'Canva & Figma for collaborative marketing assets',
                            'Campaign storytelling, copy integration, CTA design',
                            'Accessibility guidelines for digital creatives',
                        ],
                        'project' => 'Project: Omnichannel launch campaign with print + digital deliverables.',
                    ],
                    [
                        'label' => 'Month 3',
                        'title' => 'UI/UX Essentials',
                        'items' => [
                            'Figma interface design, components, auto-layout, design systems',
                            'Wireframing, prototyping, usability heuristics, micro-interactions',
                            'Handoff-ready specs for developers (Zeplin/Figma inspect)',
                            'Collaborating with product managers and developers',
                        ],
                        'project' => 'Project: Responsive landing page UI kit with prototype walkthrough.',
                    ],
                    [
                        'label' => 'Month 4',
                        'title' => 'Career & Freelance Lab',
                        'items' => [
                            'Portfolio storytelling, case study writing, Behance/Dribbble strategy',
                            'Pricing projects, contracts, scope management, client communication',
                            'Marketplace playbooks for Upwork, Fiverr, Freelancer',
                            'Mock interviews and live feedback on presentation skills',
                        ],
                        'project' => 'Project: Personal brand + portfolio microsite ready for outreach.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Brand Identity System', 'subtitle' => 'Create logo, color, typography, and brand collateral for a business.', 'image' => 'https://images.unsplash.com/photo-1522542550221-31fd19575a2d?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Social Campaign Design Kit', 'subtitle' => 'Produce coordinated creative assets for posts, banners, and ads.', 'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume and portfolio support for design, branding, and social media roles',
                    'Mock interviews around design rationale, client briefs, and presentation skills',
                    'Portfolio review for branding systems, collateral, and UI case studies',
                    'Mentor guidance for freelance outreach, agencies, and startup applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'power-bi-tableau-development',
                'title' => 'Power BI / Tableau Development - Certification',
                'subtitle' => 'Master Power BI and Tableau for interactive dashboards, actionable insights, and job-ready visualization skills.',
                'role_label' => 'Power BI Developer, Tableau Developer, Data Visualization Specialist, Reporting Analyst',
                'duration' => '3 Months',
                'price' => 35000,
                'thumbnail' => asset('images/carrer%20paths/power%20bi.jpeg'),
                'skills' => ['Power BI', 'Tableau', 'Data Modeling', 'DAX', 'Dashboards'],
                'market_signal' => 'Companies want analysts who can create dashboards leaders actually use, not just static reports.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This focused certification is for professionals who want to specialise in BI engineering and storytelling. You will architect models, craft visuals, and deploy dashboards with governance baked in.',
                'overview_highlight' => 'By pairing Power BI depth with Tableau flexibility, you can support the BI stack used across startups and enterprises alike.',
                'career_outcomes' => ['Power BI Developer', 'Tableau Developer', 'Data Visualization Specialist', 'Reporting Analyst', 'BI Consultant'],
                'why_course_items' => [
                    'Master both Power BI and Tableau for interactive dashboarding',
                    'Transform raw tables into governed semantic models',
                    'Publish, secure, and automate dashboards for enterprise consumption',
                    'Build job-ready BI & data visualization skills with portfolio artifacts',
                ],
                'ideal_for' => ['Analysts improving dashboard skills', 'Students entering BI roles', 'Professionals upgrading reporting work'],
                'deliverables' => ['Interactive dashboard portfolio', 'KPI visualization pack', 'Case-study presentation'],
                'hiring_focus' => ['Dashboard usability', 'Calculated metrics', 'Business storytelling', 'Governance and enablement'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'This shorter path is tuned for learners who want fast, visible BI outputs.',
                'weeks' => [
                    [
                        'label' => 'Month 1',
                        'title' => 'Data Modelling & Prep',
                        'items' => [
                            'Data prep with Power Query, Tableau Prep, and Python helpers',
                            'Star schema design, slowly changing dimensions, calculation groups',
                            'Performance tuning: query folding, incremental refresh, partitions',
                            'Version control and documentation for BI assets',
                        ],
                        'project' => 'Project: Sales & inventory semantic model powering both tools.',
                    ],
                    [
                        'label' => 'Weeks 5-8',
                        'title' => 'Power BI Delivery',
                        'items' => [
                            'DAX patterns for KPIs, time intelligence, segmented insights',
                            'Bookmarks, drill-through, decomposition trees, field parameters',
                            'Row-Level Security, deployment pipelines, mobile layout optimisation',
                            'Power BI Service governance, workspace strategies, app packaging',
                        ],
                        'project' => 'Project: Executive Power BI app with security matrix & user guide.',
                    ],
                    [
                        'label' => 'Weeks 9-10',
                        'title' => 'Tableau Storytelling',
                        'items' => [
                            'LOD expressions, table calculations, parameter actions',
                            'Interactive stories, navigation design, viz-in-tooltip techniques',
                            'Tableau Server/Cloud publishing, permissions, subscriptions',
                            'Embedding dashboards inside portals and products',
                        ],
                        'project' => 'Project: Self-service Tableau hub with guided analytics journeys.',
                    ],
                    [
                        'label' => 'Weeks 11-12',
                        'title' => 'Automation & Enablement',
                        'items' => [
                            'Refresh orchestration via dataflows, APIs, and Azure/AWS schedulers',
                            'Alerting, KPI narratives, and Teams/Slack integrations',
                            'User adoption programs, documentation, center-of-excellence tips',
                            'Certification prep for PL-300 & Tableau Desktop Specialist',
                        ],
                        'project' => 'Project: BI enablement toolkit with SOPs, training deck, and chatbot FAQ.',
                    ],
                ],
                'projects' => [
                    ['title' => 'Sales & Profit Dashboard', 'subtitle' => 'Design an interactive report with drilldowns and KPI summaries.', 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Operations Tracker', 'subtitle' => 'Turn raw operational data into a clean leadership dashboard.', 'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for BI, dashboarding, and data visualization roles',
                    'Mock interviews around DAX, Tableau logic, modelling, and storytelling',
                    'Portfolio review for semantic models, dashboards, and BI case studies',
                    'Mentor guidance for BI consultant, reporting, and analytics applications',
                ],
            ]),
            $this->buildCareerPath([
                'slug' => 'generative-ai',
                'title' => 'Generative AI - Future Skills Certification',
                'subtitle' => 'Learn Generative AI and LLMs, prompt engineering, automation, and hands-on AI projects for future-ready skills.',
                'role_label' => 'Generative AI Specialist, Prompt Engineer, AI Automation Expert, AI Content Strategist',
                'duration' => '2 Months',
                'price' => 20000,
                'thumbnail' => asset('images/carrer%20paths/genrative%20ai.jpeg'),
                'skills' => ['LLMs', 'Prompt Engineering', 'AI Automation', 'Workflow Design', 'AI Tools'],
                'market_signal' => 'Practical LLM and automation skills are becoming highly visible across content, support, and operations roles.',
                'overview_title' => 'Course Overview',
                'overview_text' => 'This fast-track program is perfect for professionals who want to add GenAI skills to their toolkit. You will explore foundation models, prompt design, toolchains, and ethics through rapid-build assignments.',
                'overview_highlight' => 'By the end you can scope, prototype, and deliver AI automations that save time or unlock new customer experiences.',
                'career_outcomes' => ['Generative AI Specialist', 'AI Prompt Engineer', 'Automation Strategist', 'AI Content & Marketing Strategist', 'Innovation Consultant'],
                'why_course_items' => [
                    'Learn Generative AI and LLM fundamentals without heavy math',
                    'Master prompt engineering, chaining, and evaluation frameworks',
                    'Build hands-on AI automation projects for content, code, and ops',
                    'Gain future-ready skills that complement any functional expertise',
                ],
                'ideal_for' => ['Students exploring AI quickly', 'Marketers and operators learning automation', 'Professionals building AI workflows'],
                'deliverables' => ['Prompt portfolio', 'Automation demos', 'AI workflow case studies'],
                'hiring_focus' => ['Prompt design', 'Workflow automation', 'Useful AI application design', 'Evaluation and adoption readiness'],
                'benefits' => [
                    'Regular live classes (2 hrs daily) with doubt-clearing support',
                    'Personalised training plans with 1:1 mentorship',
                    'Weekend personality development & communication labs',
                    '20+ real projects and domain case studies',
                    '20+ industry-level mock interviews and feedback loops',
                    'Interview preparation, resume workshops, and ATS-friendly templates',
                    'Portfolio management with LinkedIn optimisation & GitHub reviews',
                    'Mental health & confidence coaching to stay job-ready',
                    'Internship certification plus globally recognised course credential',
                    'Small interactive batches for peer learning and accountability',
                ],
                'mentor_note' => 'This path is intentionally compact and practical so learners can build useful AI workflows fast.',
                'weeks' => [
                    [
                        'label' => 'Weeks 1-2',
                        'title' => 'LLM Foundations & Prompt Design',
                        'items' => [
                            'Transformer basics, model families, tokenisation, context windows',
                            'Prompt patterns: zero/few-shot, chain-of-thought, ReAct, evaluator prompts',
                            'Tool selection: OpenAI, Anthropic, Gemini, open-source models',
                            'Safety, bias, hallucination mitigation strategies',
                        ],
                        'project' => 'Project: Prompt playbook for research, ideation, and QA workflows.',
                    ],
                    [
                        'label' => 'Weeks 3-4',
                        'title' => 'Automation & Agents',
                        'items' => [
                            'Function calling, structured outputs, grounding with vector databases',
                            'Agent frameworks (LangChain, LlamaIndex) for workflow orchestration',
                            'Connecting LLMs to Zapier/Make, spreadsheets, CRMs, and APIs',
                            'Evaluation metrics: faithfulness, latency, cost controls',
                        ],
                        'project' => 'Project: LLM-powered assistant that summarises and routes support tickets.',
                    ],
                    [
                        'label' => 'Week 5',
                        'title' => 'Domain Use Cases',
                        'items' => [
                            'Marketing + sales copy generation, personalization at scale',
                            'Coding copilots, test case generation, documentation automation',
                            'Data analysis assistants built on top of SQL/BI outputs',
                            'Legal, HR, and finance guardrails for GenAI deployment',
                        ],
                        'project' => 'Project: Cross-functional GenAI backlog with ROI estimates.',
                    ],
                    [
                        'label' => 'Week 6-8',
                        'title' => 'Capstone & Career Toolkit',
                        'items' => [
                            'Scoping template for AI pilots, stakeholder alignment, adoption plans',
                            'Integration patterns with FastAPI, Slack, Google Workspace, Teams',
                            'Building demo videos, one-pagers, and executive FAQ documents',
                            'Career positioning: communicating GenAI wins, freelancing gigs',
                        ],
                        'project' => 'Project: End-to-end GenAI automation from idea to deployed proof-of-value.',
                    ],
                ],
                'projects' => [
                    ['title' => 'AI Content Workflow', 'subtitle' => 'Design a prompt system for briefs, drafts, and revisions.', 'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=900&q=80'],
                    ['title' => 'Support Automation Assistant', 'subtitle' => 'Build a workflow for repetitive support and internal knowledge tasks.', 'image' => 'https://images.unsplash.com/photo-1674027444485-cec3da58eef4?auto=format&fit=crop&w=900&q=80'],
                ],
                'placement_support' => [
                    'Resume support for GenAI, prompt engineering, automation, and innovation roles',
                    'Mock interviews around prompting, AI workflows, guardrails, and business impact',
                    'Portfolio review for automation demos, prompt systems, and AI use-case projects',
                    'Mentor guidance for freelance, internal innovation, and AI-adjacent job applications',
                ],
            ]),
        ];
    }

    private function homeSlides(): array
    {
        if (! Schema::hasTable('home_slides')) {
            return [
                [
                    'eyebrow' => 'Hot Right Now',
                    'title' => 'Full Stack Developer Career Track',
                    'highlight' => 'Portfolio-first roadmap',
                    'description' => 'Build production-style frontend, backend, database, and deployment skills with guided capstone delivery.',
                    'badge' => 'Most Popular',
                    'accent' => 'from-[#16092f] via-[#312e81] to-[#14b8a6]',
                    'stat_label' => 'Duration',
                    'stat_value' => '6-8 Months',
                    'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
                    'primary_url' => route('home.career-paths.show', ['path' => 'full-stack-developer']),
                    'primary_label' => 'Explore Track',
                    'secondary_url' => route('home.contact'),
                    'secondary_label' => 'Talk to Mentor',
                ],
                [
                    'eyebrow' => 'New Spotlight',
                    'title' => 'AI Engineer Premium Path',
                    'highlight' => 'GenAI to deployment',
                    'description' => 'Move from Python and model foundations into practical AI apps, evaluation workflows, and deployment-ready projects.',
                    'badge' => 'Trending Offer',
                    'accent' => 'from-[#140a2d] via-[#5b21b6] to-[#f59e0b]',
                    'stat_label' => 'Access',
                    'stat_value' => 'Lifetime',
                    'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=1200&q=80',
                    'primary_url' => route('home.career-paths.show', ['path' => 'ai-engineer']),
                    'primary_label' => 'View Program',
                    'secondary_url' => route('home.courses'),
                    'secondary_label' => 'Browse Training Programs',
                ],
                [
                    'eyebrow' => 'Career Launch',
                    'title' => 'Data Analyst Special Batch',
                    'highlight' => 'Dashboard + SQL mastery',
                    'description' => 'Learn the tools companies ask for most in entry-level analytics roles with real dashboards and business case studies.',
                    'badge' => 'Popular Choice',
                    'accent' => 'from-[#14314b] via-[#0f766e] to-[#7dd3c8]',
                    'stat_label' => 'Placement',
                    'stat_value' => 'Guided Support',
                    'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                    'primary_url' => route('home.career-paths.show', ['path' => 'data-analyst']),
                    'primary_label' => 'See Details',
                    'secondary_url' => route('home.contact'),
                    'secondary_label' => 'Book Free Call',
                ],
            ];
        }

        $slides = HomeSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(array_values(array_filter([
                'eyebrow',
                'title',
                'highlight',
                'description',
                'badge',
                'accent',
                'stat_label',
                'stat_value',
                'image',
                'primary_url',
                'primary_label',
                'secondary_url',
                'secondary_label',
            ])))
            ->map(function (HomeSlide $slide) {
                $payload = $slide->toArray();
                $payload['eyebrow'] = $slide->eyebrow ?: 'Featured Update';
                $payload['title'] = $slide->title ?: 'New learning spotlight';
                $payload['highlight'] = $slide->highlight ?: 'Fresh program update';
                $payload['description'] = $slide->description ?: 'Explore the latest learning track, student milestone, or institute update highlighted by the team.';
                $payload['badge'] = $slide->badge ?: 'Now Live';
                $payload['stat_label'] = $slide->stat_label ?: 'Spotlight';
                $payload['stat_value'] = $slide->stat_value ?: 'Featured';
                $payload['image'] = $slide->image ?: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80';
                $payload['primary_url'] = $slide->primary_url ?: route('home.contact');
                $payload['primary_label'] = $slide->primary_label ?: 'Learn More';
                $payload['secondary_url'] = $slide->secondary_url ?: route('home.courses');
                $payload['secondary_label'] = $slide->secondary_label ?: 'Browse Training Programs';
                $payload['accent_style'] = $this->resolveGradientStyle($slide->accent, '90deg');

                return $payload;
            })
            ->all();

        if ($slides !== []) {
            return $slides;
        }

        return [
            [
                'eyebrow' => 'Hot Right Now',
                'title' => 'Full Stack Developer Career Track',
                'highlight' => 'Portfolio-first roadmap',
                'description' => 'Build production-style frontend, backend, database, and deployment skills with guided capstone delivery.',
                'badge' => 'Most Popular',
                'accent' => 'from-[#16092f] via-[#312e81] to-[#14b8a6]',
                'stat_label' => 'Duration',
                'stat_value' => '6-8 Months',
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
                'primary_url' => route('home.career-paths.show', ['path' => 'full-stack-developer']),
                'primary_label' => 'Explore Track',
                'secondary_url' => route('home.contact'),
                'secondary_label' => 'Talk to Mentor',
                'accent_style' => 'linear-gradient(90deg, #16092f 0%, #312e81 50%, #14b8a6 100%)',
            ],
            [
                'eyebrow' => 'New Spotlight',
                'title' => 'AI Engineer Premium Path',
                'highlight' => 'GenAI to deployment',
                'description' => 'Move from Python and model foundations into practical AI apps, evaluation workflows, and deployment-ready projects.',
                'badge' => 'Trending Offer',
                'accent' => 'from-[#140a2d] via-[#5b21b6] to-[#f59e0b]',
                'stat_label' => 'Access',
                'stat_value' => 'Lifetime',
                'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=1200&q=80',
                'primary_url' => route('home.career-paths.show', ['path' => 'ai-engineer']),
                'primary_label' => 'View Program',
                'secondary_url' => route('home.courses'),
                'secondary_label' => 'Browse Training Programs',
                'accent_style' => 'linear-gradient(90deg, #140a2d 0%, #5b21b6 50%, #f59e0b 100%)',
            ],
            [
                'eyebrow' => 'Career Launch',
                'title' => 'Data Analyst Special Batch',
                'highlight' => 'Dashboard + SQL mastery',
                'description' => 'Learn the tools companies ask for most in entry-level analytics roles with real dashboards and business case studies.',
                'badge' => 'Popular Choice',
                'accent' => 'from-[#14314b] via-[#0f766e] to-[#7dd3c8]',
                'stat_label' => 'Placement',
                'stat_value' => 'Guided Support',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'primary_url' => route('home.career-paths.show', ['path' => 'data-analyst']),
                'primary_label' => 'See Details',
                'secondary_url' => route('home.contact'),
                'secondary_label' => 'Book Free Call',
                'accent_style' => 'linear-gradient(90deg, #14314b 0%, #0f766e 50%, #7dd3c8 100%)',
            ],
        ];
    }

    private function homeFounderVideo(): ?array
    {
        if (Schema::hasTable('home_founder_media')) {
            $record = HomeFounderMedia::query()
                ->where('is_active', true)
                ->latest('id')
                ->first();

            if ($record) {
                return [
                    'eyebrow' => $record->eyebrow ?: 'Founder Message',
                    'title' => $record->title ?: 'Hear the vision behind CodeInYourself and how we prepare learners for real technology careers.',
                    'description' => $record->description ?: 'Founder insights on mentorship, practical training, and career-focused learning.',
                    'video_url' => $record->video_url ?: null,
                    'poster_url' => $record->poster_url ?: asset('images/owner 1.0.jpeg'),
                    'badge' => $record->badge ?: 'Founder',
                    'meta' => 'Managed from HR Founder Media',
                ];
            }
        }

        return [
            'eyebrow' => 'Founder Message',
            'title' => 'Hear the vision behind CodeInYourself and how we prepare learners for real technology careers.',
            'description' => 'Founder insights on mentorship, practical training, and career-focused learning.',
            'video_url' => null,
            'poster_url' => asset('images/owner 1.0.jpeg'),
            'badge' => 'Founder',
            'meta' => 'Managed from HR Founder Media',
        ];
    }

    private function homeStories(string $type, ?int $limit = null): array
    {
        if (Schema::hasTable('home_stories')) {
            $storiesQuery = HomeStory::query()
                ->where('type', $type)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->latest('id');

            if ($limit !== null) {
                $storiesQuery->limit($limit);
            }

            $stories = $storiesQuery
                ->get()
                ->map(fn (HomeStory $story) => [
                    'name' => $story->name,
                    'avatar' => $story->avatar ?: $this->storyAvatarFallback($story->name, $type === 'placement' ? 180 : 240),
                    'media_type' => $story->media_type ?: 'image',
                    'show_in_placement_hero' => (bool) ($story->show_in_placement_hero ?? false),
                    'course' => $story->course ?: ($type === 'placement' ? 'Career Roadmap' : 'Career Track'),
                    'comment' => $story->comment ?: ($type === 'placement'
                        ? 'Placement guidance and mentor support helped me present my work with more confidence and approach interviews with a clearer plan.'
                        : 'The learning experience felt structured, practical, and supportive from the first class to the final project.'),
                    'rating' => max(1, min(5, (int) ($story->rating ?? 5))),
                    'company' => $story->company,
                    'role' => $story->role,
                    'package' => $story->package,
                    'shared_at' => optional($story->shared_at)->format('M Y') ?: optional($story->updated_at)->format('M Y'),
                ])
                ->all();

            if ($stories !== []) {
                return $stories;
            }
        }

        return $type === 'placement'
            ? array_slice([
                [
                    'name' => 'Aarav Sharma',
                    'avatar' => $this->storyAvatarFallback('Aarav Sharma', 180),
                    'media_type' => 'image',
                    'course' => 'Data Science with AI',
                    'show_in_placement_hero' => true,
                    'comment' => 'The mentorship and portfolio projects helped me feel job-ready, and I was able to present my work more confidently in interviews.',
                    'rating' => 5,
                    'company' => 'TCS',
                    'role' => 'AI Analyst',
                    'package' => '8.4 LPA',
                    'shared_at' => now()->format('M Y'),
                ],
                [
                    'name' => 'Priya Nair',
                    'avatar' => $this->storyAvatarFallback('Priya Nair', 180),
                    'media_type' => 'image',
                    'course' => 'Generative AI Roadmap',
                    'show_in_placement_hero' => true,
                    'comment' => 'The structured roadmap helped me move into a more technical role with much more clarity and confidence.',
                    'rating' => 5,
                    'company' => 'Infosys',
                    'role' => 'Data Associate',
                    'package' => '7.2 LPA',
                    'shared_at' => now()->format('M Y'),
                ],
                [
                    'name' => 'Rohan Verma',
                    'avatar' => $this->storyAvatarFallback('Rohan Verma', 180),
                    'media_type' => 'image',
                    'course' => 'Data Analytics with AI',
                    'show_in_placement_hero' => true,
                    'comment' => 'Support sessions and mock interview guidance gave me much more clarity on what companies were actually expecting.',
                    'rating' => 5,
                    'company' => 'Wipro',
                    'role' => 'Analytics Engineer',
                    'package' => '6.8 LPA',
                    'shared_at' => now()->format('M Y'),
                ],
                [
                    'name' => 'Neel Desai',
                    'avatar' => $this->storyAvatarFallback('Neel Desai', 180),
                    'media_type' => 'image',
                    'course' => 'Full Stack with AI Tools',
                    'comment' => 'The project feedback loop helped me turn my practice work into stronger interview conversations and a much better profile.',
                    'rating' => 5,
                    'company' => 'Capgemini',
                    'role' => 'Software Engineer',
                    'package' => '6.2 LPA',
                    'shared_at' => now()->format('M Y'),
                ],
            ], 0, $limit ?? 3)
            : array_slice([
                [
                    'name' => 'Neha Kapoor',
                    'avatar' => $this->storyAvatarFallback('Neha Kapoor', 240),
                    'media_type' => 'image',
                    'course' => 'Data Analytics with AI',
                    'comment' => 'The classes felt personal and practical. I always knew what to work on next, and the mentor feedback kept me consistent.',
                    'rating' => 5,
                    'shared_at' => now()->format('M Y'),
                ],
                [
                    'name' => 'Arjun Mehta',
                    'avatar' => $this->storyAvatarFallback('Arjun Mehta', 240),
                    'media_type' => 'image',
                    'course' => 'Generative AI',
                    'comment' => 'It felt more like a serious learning community than a normal course. The support made a big difference while building my portfolio.',
                    'rating' => 5,
                    'shared_at' => now()->format('M Y'),
                ],
                [
                    'name' => 'Sana Ali',
                    'avatar' => $this->storyAvatarFallback('Sana Ali', 240),
                    'media_type' => 'image',
                    'course' => 'Data Science with AI',
                    'comment' => 'I liked how easy it was to ask questions, get direction, and keep improving without feeling lost during the roadmap.',
                    'rating' => 5,
                    'shared_at' => now()->format('M Y'),
                ],
            ], 0, $limit ?? 3);
    }

    private function storyAvatarFallback(string $name, int $size = 180): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=F3E8FF&color=6B21A8&size='.$size;
    }

    private function isGeneratedPlacementPlaceholder(array $story): bool
    {
        $avatar = (string) ($story['avatar'] ?? '');

        return $avatar !== '' && Str::contains($avatar, 'ui-avatars.com/api/');
    }

    private function achievementGallery(): array
    {
        if (Schema::hasTable('home_achievements')) {
            $hasCategoryOrderColumn = Schema::hasColumn('home_achievements', 'gallery_category_order');
            $items = HomeAchievement::query()
                ->where('kind', 'gallery')
                ->where('is_active', true)
                ->when($hasCategoryOrderColumn, fn ($query) => $query->orderBy('gallery_category_order'))
                ->orderBy('sort_order')
                ->latest('id')
                ->get()
                ->map(fn (HomeAchievement $item) => [
                    'media_url' => $item->media_url,
                    'media_type' => $item->media_type ?: 'image',
                    'title' => $item->title ?: 'CodeInYourself achievement',
                    'category' => $item->gallery_category ?: 'General',
                    'category_order' => $hasCategoryOrderColumn ? (int) ($item->gallery_category_order ?? 0) : 0,
                ])
                ->filter(fn (array $item) => filled($item['media_url']))
                ->values()
                ->all();

            if ($items !== []) {
                return $items;
            }
        }

        return [
            ['media_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80', 'media_type' => 'image', 'title' => 'Workshop excellence'],
            ['media_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80', 'media_type' => 'image', 'title' => 'Seminar moments'],
            ['media_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80', 'media_type' => 'image', 'title' => 'Team achievements'],
            ['media_url' => 'https://images.unsplash.com/photo-1515169067868-5387ec356754?auto=format&fit=crop&w=900&q=80', 'media_type' => 'image', 'title' => 'Recognition ceremony'],
        ];
    }

    private function achievementShowcaseItems(): array
    {
        if (Schema::hasTable('home_achievements')) {
            $items = HomeAchievement::query()
                ->where('kind', 'showcase')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->latest('id')
                ->get()
                ->map(fn (HomeAchievement $item) => [
                    'eyebrow' => $item->eyebrow ?: 'Achievement Spotlight',
                    'title' => $item->title ?: 'Institute achievement showcase',
                    'copy' => $item->copy ?: 'Highlight meaningful institute achievements through clear, professional visual storytelling.',
                    'points' => $item->points ?: ['Showcase item', 'Strong presentation', 'Flexible layout'],
                    'stat' => $item->stat ?: 'Featured achievement',
                    'icon' => $item->icon ?: 'workspace_premium',
                    'media_url' => $item->media_url,
                    'media_type' => $item->media_type ?: 'image',
                ])
                ->filter(fn (array $item) => filled($item['media_url']))
                ->values()
                ->all();

            if ($items !== []) {
                return $items;
            }
        }

        return [
            [
                'eyebrow' => 'Workshop Gallery',
                'title' => 'Practical workshops presented with strong visual storytelling',
                'copy' => 'Showcase practical sessions, coding activities, and classroom experiences with a strong visual-first layout.',
                'points' => ['Hands-on learning', 'Mentor-led sessions', 'Classroom energy'],
                'stat' => 'Workshop showcase',
                'icon' => 'rocket_launch',
                'media_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80',
                'media_type' => 'image',
            ],
            [
                'eyebrow' => 'Seminar Highlights',
                'title' => 'Seminars and speaker events that reflect a current academic culture',
                'copy' => 'Use this for guest sessions, technology briefings, and presentation-led events that keep the institute current and industry connected.',
                'points' => ['Expert speakers', 'Career direction', 'Technology insights'],
                'stat' => 'Clear seminar presentation',
                'icon' => 'campaign',
                'media_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=900&q=80',
                'media_type' => 'image',
            ],
            [
                'eyebrow' => 'Achievement Gallery',
                'title' => 'Company visits, recognitions, and milestone events showcased with clarity',
                'copy' => 'Present certificates, company interactions, campus events, and recognition moments in a clean professional way.',
                'points' => ['Company visits', 'Recognition moments', 'Certificate highlights'],
                'stat' => 'Elegant achievement presentation',
                'icon' => 'workspace_premium',
                'media_url' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=900&q=80',
                'media_type' => 'image',
            ],
        ];
    }

    private function resolveGradientStyle(?string $value, string $direction = '90deg'): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return 'linear-gradient('.$direction.', #16092f 0%, #312e81 50%, #14b8a6 100%)';
        }

        if (str_contains($value, 'gradient(')) {
            return $value;
        }

        preg_match('/from-\[(#[0-9A-Fa-f]{3,8})\]/', $value, $fromMatch);
        preg_match('/via-\[(#[0-9A-Fa-f]{3,8})\]/', $value, $viaMatch);
        preg_match('/to-\[(#[0-9A-Fa-f]{3,8})\]/', $value, $toMatch);

        $from = $fromMatch[1] ?? null;
        $via = $viaMatch[1] ?? null;
        $to = $toMatch[1] ?? null;

        if ($from && $via && $to) {
            return 'linear-gradient('.$direction.', '.$from.' 0%, '.$via.' 50%, '.$to.' 100%)';
        }

        if ($from && $to) {
            return 'linear-gradient('.$direction.', '.$from.' 0%, '.$to.' 100%)';
        }

        return $value;
    }

    private function featuredFacultyCards(): array
    {
        if (! Schema::hasTable('users') || ! Schema::hasTable('roles')) {
            return [];
        }

        $query = User::query()
            ->whereHas('role', fn ($builder) => $builder->where('name', 'instructor'))
            ->withCount(['courses' => fn ($builder) => $builder->where('status', 'published')]);

        $featured = Schema::hasColumn('users', 'show_on_homepage') && Schema::hasColumn('users', 'faculty_sort_order')
            ? (clone $query)
                ->where('show_on_homepage', true)
                ->orderBy('faculty_sort_order')
                ->orderByDesc('courses_count')
                ->limit(4)
                ->get()
            : collect();

        $faculty = ($featured->isNotEmpty() ? $featured : $query->orderByDesc('courses_count')->limit(4)->get())
            ->map(fn (User $mentor) => [
                'name' => $mentor->name,
                'avatar' => $mentor->avatarUrl(320),
                'role' => (Schema::hasColumn('users', 'faculty_headline') ? $mentor->faculty_headline : null)
                    ?: ($mentor->courses_count > 0
                        ? 'Lead Mentor - '.$mentor->courses_count.' course'.($mentor->courses_count === 1 ? '' : 's')
                        : 'Industry Mentor'),
                'bio' => $mentor->bio ?: 'Supports learners with practical guidance, project reviews, and consistent industry-focused mentorship.',
            ])
            ->all();

        return $faculty;
    }

    private function careerOpenings(): array
    {
        if (! Schema::hasTable('job_openings')) {
            return [
                [
                    'badge' => 'Urgent Opening',
                    'title' => 'Senior Laravel Developer',
                    'type' => 'Full Time',
                    'mode' => 'On-site / Hybrid',
                    'location' => 'Surat, Gujarat',
                    'experience' => '3+ years',
                    'salary' => 'Best in industry',
                    'summary' => 'Lead backend delivery for our LMS, improve performance, and shape product architecture with a practical engineering mindset.',
                    'skills' => ['Laravel', 'MySQL', 'REST APIs', 'Performance tuning'],
                    'color' => 'from-[#13041f] via-[#4c1d95] to-[#9d5cff]',
                ],
                [
                    'badge' => 'People Team',
                    'title' => 'HR Executive',
                    'type' => 'Full Time',
                    'mode' => 'On-site',
                    'location' => 'Surat, Gujarat',
                    'experience' => '1-3 years',
                    'salary' => 'Growth + incentives',
                    'summary' => 'Support recruitment, onboarding, employee experience, and daily people operations with warmth, clarity, and ownership.',
                    'skills' => ['Hiring coordination', 'Communication', 'Onboarding', 'Culture building'],
                    'color' => 'from-[#1f0c05] via-[#c2410c] to-[#fb923c]',
                ],
            ];
        }

        $jobs = JobOpening::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (JobOpening $job) => [
                'badge' => $job->badge ?: 'Open Role',
                'title' => $job->title,
                'type' => $job->employment_type ?: 'Full Time',
                'mode' => $job->work_mode ?: 'On-site',
                'location' => $job->location ?: 'Surat, Gujarat',
                'experience' => $job->experience ?: 'Experience required',
                'salary' => $job->salary ?: 'Competitive package',
                'summary' => $job->summary ?: 'Role details will be shared by the HR team.',
                'skills' => $job->skills ?: [],
                'color' => $job->color ?: 'from-[#13041f] via-[#4c1d95] to-[#9d5cff]',
            ])
            ->all();

        if ($jobs !== []) {
            return $jobs;
        }

        return [
            [
                'badge' => 'Urgent Opening',
                'title' => 'Senior Laravel Developer',
                'type' => 'Full Time',
                'mode' => 'On-site / Hybrid',
                'location' => 'Surat, Gujarat',
                'experience' => '3+ years',
                'salary' => 'Best in industry',
                'summary' => 'Lead backend delivery for our LMS, improve performance, and shape product architecture with a practical engineering mindset.',
                'skills' => ['Laravel', 'MySQL', 'REST APIs', 'Performance tuning'],
                'color' => 'from-[#13041f] via-[#4c1d95] to-[#9d5cff]',
            ],
            [
                'badge' => 'People Team',
                'title' => 'HR Executive',
                'type' => 'Full Time',
                'mode' => 'On-site',
                'location' => 'Surat, Gujarat',
                'experience' => '1-3 years',
                'salary' => 'Growth + incentives',
                'summary' => 'Support recruitment, onboarding, employee experience, and daily people operations with warmth, clarity, and ownership.',
                'skills' => ['Hiring coordination', 'Communication', 'Onboarding', 'Culture building'],
                'color' => 'from-[#1f0c05] via-[#c2410c] to-[#fb923c]',
            ],
        ];
    }

    private function workshopListings(): array
    {
        if (! Schema::hasTable('workshops')) {
            return [
                [
                    'id' => 0,
                    'badge' => 'Ongoing',
                    'title' => 'Generative AI Build Lab',
                    'subtitle' => 'Prompt systems, AI tools, automation demos, and guided project framing',
                    'date' => 'April 20, 2026',
                    'time' => '7:00 PM to 9:30 PM IST',
                    'format' => 'Live online intensive',
                    'venue' => 'Online live studio',
                    'audience' => 'Students, freshers, and working professionals',
                    'mentor' => 'Lead AI mentor panel',
                    'seats' => '38 seats left',
                    'price' => 499,
                    'currency' => 'INR',
                    'price_label' => 'INR 499',
                    'payment_enabled' => false,
                    'payment_qr_code' => null,
                    'payment_instructions' => 'Registration details will be shared by the workshop team.',
                    'accent' => 'from-[#13041f] via-[#4d1f87] to-[#9d5cff]',
                    'highlights' => ['Prompt design frameworks', 'Hands-on AI workflow build', 'Post-workshop practice kit'],
                ],
                [
                    'id' => 0,
                    'badge' => 'Upcoming',
                    'title' => 'Full Stack API Sprint',
                    'subtitle' => 'Build a modern backend flow with API design, auth, testing, and deployment thinking',
                    'date' => 'April 27, 2026',
                    'time' => '11:00 AM to 2:00 PM IST',
                    'format' => 'Weekend live workshop',
                    'venue' => 'Surat campus and online hybrid',
                    'audience' => 'Developers and career-switch learners',
                    'mentor' => 'Engineering mentors',
                    'seats' => '52 seats left',
                    'price' => 699,
                    'currency' => 'INR',
                    'price_label' => 'INR 699',
                    'payment_enabled' => false,
                    'payment_qr_code' => null,
                    'payment_instructions' => 'Registration details will be shared by the workshop team.',
                    'accent' => 'from-[#1a062d] via-[#5b21b6] to-[#c084fc]',
                    'highlights' => ['REST architecture walkthrough', 'Auth and middleware patterns', 'Deployment checklist'],
                ],
            ];
        }

        $workshops = Workshop::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Workshop $workshop) => [
                'id' => $workshop->id,
                'badge' => $workshop->badge ?: 'Upcoming',
                'title' => $workshop->title,
                'subtitle' => $workshop->subtitle ?: 'Join a practical session built around current tools, guided exercises, and clear next steps.',
                'date' => $workshop->date_label ?: 'Coming soon',
                'time' => $workshop->time_label ?: 'Time will be shared',
                'format' => $workshop->format ?: 'Live workshop',
                'venue' => $workshop->venue ?: 'Online / Offline',
                'audience' => $workshop->audience ?: 'Students and professionals',
                'mentor' => $workshop->mentor ?: 'Mentor team',
                'seats' => $workshop->seats ?: 'Limited seats',
                'price' => (float) $workshop->price,
                'currency' => $workshop->currency ?: 'INR',
                'price_label' => ($workshop->currency ?: 'INR').' '.number_format((float) $workshop->price, ((float) $workshop->price === floor((float) $workshop->price)) ? 0 : 2),
                'payment_enabled' => (bool) $workshop->payment_enabled,
                'payment_qr_code' => $workshop->payment_qr_code,
                'payment_instructions' => $workshop->payment_instructions ?: 'Registration details will be shared by the workshop team.',
                'accent' => $workshop->accent ?: 'from-[#13041f] via-[#4d1f87] to-[#9d5cff]',
                'highlights' => $workshop->highlights ?: [],
            ])
            ->all();

        if ($workshops !== []) {
            return $workshops;
        }

        return [
            [
                'id' => 0,
                'badge' => 'Ongoing',
                'title' => 'Generative AI Build Lab',
                'subtitle' => 'Prompt systems, AI tools, automation demos, and guided project framing',
                'date' => 'April 20, 2026',
                'time' => '7:00 PM to 9:30 PM IST',
                'format' => 'Live online intensive',
                'venue' => 'Online live studio',
                'audience' => 'Students, freshers, and working professionals',
                'mentor' => 'Lead AI mentor panel',
                'seats' => '38 seats left',
                'price' => 499,
                'currency' => 'INR',
                'price_label' => 'INR 499',
                'payment_enabled' => false,
                'payment_qr_code' => null,
                'payment_instructions' => 'Registration details will be shared by the workshop team.',
                'accent' => 'from-[#13041f] via-[#4d1f87] to-[#9d5cff]',
                'highlights' => ['Prompt design frameworks', 'Hands-on AI workflow build', 'Post-workshop practice kit'],
            ],
            [
                'id' => 0,
                'badge' => 'Upcoming',
                'title' => 'Full Stack API Sprint',
                'subtitle' => 'Build a modern backend flow with API design, auth, testing, and deployment thinking',
                'date' => 'April 27, 2026',
                'time' => '11:00 AM to 2:00 PM IST',
                'format' => 'Weekend live workshop',
                'venue' => 'Surat campus and online hybrid',
                'audience' => 'Developers and career-switch learners',
                'mentor' => 'Engineering mentors',
                'seats' => '52 seats left',
                'price' => 699,
                'currency' => 'INR',
                'price_label' => 'INR 699',
                'payment_enabled' => false,
                'payment_qr_code' => null,
                'payment_instructions' => 'Registration details will be shared by the workshop team.',
                'accent' => 'from-[#1a062d] via-[#5b21b6] to-[#c084fc]',
                'highlights' => ['REST architecture walkthrough', 'Auth and middleware patterns', 'Deployment checklist'],
            ],
        ];
    }

    private function validateWorkshopRegistrationPayload(Request $request, bool $withPaymentProof = false): array
    {
        $rules = [
            'workshop_id' => ['required', 'integer', 'exists:workshops,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
            'organization' => ['nullable', 'string', 'max:255'],
            'learner_type' => ['nullable', 'string', 'max:100'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'attendance_mode' => ['nullable', 'string', 'max:50'],
            'goals' => ['nullable', 'string', 'max:2000'],
            'questions' => ['nullable', 'string', 'max:2000'],
        ];

        if ($withPaymentProof) {
            $rules['razorpay_payment_id'] = ['required', 'string', 'max:255'];
            $rules['razorpay_order_id'] = ['required', 'string', 'max:255'];
            $rules['razorpay_signature'] = ['required', 'string', 'max:255'];
        }

        return $request->validate($rules);
    }

    private function createWorkshopRazorpayOrder(Workshop $workshop, array $registrationPayload): array
    {
        $keyId = (string) config('services.razorpay.key_id');
        $keySecret = (string) config('services.razorpay.key_secret');

        if ($keyId === '' || $keySecret === '') {
            throw new RuntimeException('Razorpay keys are missing. Add them in your .env file first.');
        }

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->timeout(30)
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => (int) round(((float) $workshop->price) * 100),
                'currency' => $workshop->currency ?: 'INR',
                'receipt' => 'workshop-'.$workshop->id.'-'.Str::lower(Str::random(6)),
                'notes' => [
                    'workshop_id' => (string) $workshop->id,
                    'workshop_title' => $workshop->title,
                    'name' => $registrationPayload['name'],
                    'email' => $registrationPayload['email'],
                ],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Unable to start Razorpay checkout right now. Please verify your Razorpay keys and try again.');
        }

        $payload = $response->json();

        if (! is_array($payload) || empty($payload['id'])) {
            throw new RuntimeException('Razorpay did not return a valid workshop payment order.');
        }

        return $payload;
    }

    private function buildCareerPath(array $path): array
    {
        return array_merge([
            'mode' => 'Offline & Online Learning',
            'access' => 'Lifetime Access',
            'placement_support' => [
                'Resume building and career positioning',
                'Mock interview preparation',
                'Portfolio and project review',
                'Placement-oriented mentoring',
            ],
            'thumbnail_fit' => 'contain',
            'thumbnail_position' => 'center',
            'thumbnail_backdrop' => 'linear-gradient(135deg, rgba(37,16,58,0.92), rgba(108,57,168,0.84))',
        ], $path);
    }
}
