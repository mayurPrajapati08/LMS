<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\OfflineCourse;
use App\Support\PlatformSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentCatalogController extends Controller
{
    public function browse(Request $request): View
    {
        $student = $request->user();
        $onlineCatalogEnabled = PlatformSettings::bool('student_catalog_enabled', false) && PlatformSettings::bool('catalog_online_enabled', false);
        $offlineCatalogEnabled = PlatformSettings::bool('catalog_offline_enabled', true);
        $defaultMode = PlatformSettings::string('catalog_default_mode', 'offline');
        $requestedMode = (string) $request->query('mode', $defaultMode);
        $catalogMode = in_array($requestedMode, ['online', 'offline'], true) ? $requestedMode : $defaultMode;

        if ($catalogMode === 'online' && ! $onlineCatalogEnabled) {
            $catalogMode = $offlineCatalogEnabled ? 'offline' : 'online';
        }

        $search = trim((string) $request->query('search', ''));
        $category = (string) $request->query('category', '');
        $level = (string) $request->query('level', '');
        $price = (string) $request->query('price', 'all');
        $sort = (string) $request->query('sort', 'relevant');

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
                ->paginate(9)
                ->withQueryString();

            $courseCards = $offlineCourses->through(fn (OfflineCourse $course) => [
                'id' => $course->id,
                'mode' => 'offline',
                'title' => $course->title,
                'details' => $course->summary,
                'thumbnail' => $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'category' => $course->category?->name ?? 'Offline Course',
                'level' => ucfirst((string) ($course->level ?: 'All levels')),
                'language' => $course->language ?: 'English',
                'rating' => 5,
                'reviews_count' => 0,
                'students_count' => 0,
                'sections_count' => 0,
                'instructor_name' => 'Campus Mentor Team',
                'instructor_avatar' => 'https://ui-avatars.com/api/?name=Campus+Mentor&background=EEF2FF&color=312E81&size=80',
                'is_wishlisted' => false,
                'is_in_cart' => false,
                'is_enrolled' => false,
                'details_url' => route('home.contact', ['topic' => 'offline-course', 'subject' => $course->title]),
                'player_url' => route('home.contact', ['topic' => 'offline-course', 'subject' => $course->title]),
                'checkout_url' => route('home.contact', ['topic' => 'offline-course', 'subject' => $course->title]),
                'campus' => $course->campus ?: 'Campus details on request',
                'schedule_label' => $course->schedule_label ?: 'Schedule shared by team',
                'duration_label' => $course->duration_label ?: 'Classroom schedule',
            ]);

            $featuredCourse = collect($courseCards->items())->first();

            return view('student.browse_course', [
                'student' => $student,
                'profileAvatar' => $student->avatarUrl(96),
                'courseCards' => $courseCards,
                'featuredCourse' => $featuredCourse,
                'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
                'search' => $search,
                'selectedCategory' => $category,
                'selectedLevel' => $level,
                'selectedPrice' => $price,
                'selectedSort' => $sort,
                'resultsCount' => $offlineCourses->total(),
                'catalogMode' => $catalogMode,
                'onlineCatalogEnabled' => $onlineCatalogEnabled,
                'offlineCatalogEnabled' => $offlineCatalogEnabled,
            ]);
        }

        $courses = Course::query()
            ->where('status', 'published')
            ->with([
                'category:id,name',
                'user:id,name,avatar_path',
            ])
            ->withCount([
                'reviews',
                'enrollments as students_count',
                'wishlists as wishlist_count',
                'sections',
            ])
            ->withAvg('reviews', 'rating')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%")
                        ->orWhere('language', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->where('category_id', (int) $category))
            ->when($level !== '', fn ($query) => $query->where('level', $level))
            ->when($price === 'free', fn ($query) => $query->where('price', '<=', 0))
            ->when($price === 'paid', fn ($query) => $query->where('price', '>', 0));

        $this->applyCourseSort($courses, $sort);

        /** @var LengthAwarePaginator $paginatedCourses */
        $paginatedCourses = $courses->paginate(9)->withQueryString();

        $wishlistCourseIds = $student->wishlists()
            ->pluck('course_id')
            ->map(fn ($id) => (int) $id)
            ->all();
        $cartCourseIds = $student->cartItems()
            ->pluck('course_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $enrolledCourseIds = $student->enrollments()
            ->pluck('course_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $courseCards = $paginatedCourses->through(function (Course $course) use ($wishlistCourseIds, $cartCourseIds, $enrolledCourseIds) {
            $rating = round((float) ($course->reviews_avg_rating ?? 0), 1);

            return [
                'id' => $course->id,
                'title' => $course->title,
                'details' => $course->details,
                'thumbnail' => $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'price' => (float) ($course->price ?? 0),
                'category' => $course->category?->name ?? 'General',
                'level' => ucfirst((string) ($course->level ?? 'all levels')),
                'language' => $course->language ?: 'English',
                'rating' => $rating > 0 ? $rating : 4.8,
                'reviews_count' => (int) $course->reviews_count,
                'students_count' => (int) $course->students_count,
                'sections_count' => (int) $course->sections_count,
                'instructor_name' => $course->user?->name ?? 'Instructor',
                'instructor_avatar' => $course->user?->avatarUrl(80) ?? 'https://ui-avatars.com/api/?name=Instructor&background=EEF2FF&color=312E81&size=80',
                'is_wishlisted' => in_array($course->id, $wishlistCourseIds, true),
                'is_in_cart' => in_array($course->id, $cartCourseIds, true),
                'is_enrolled' => in_array($course->id, $enrolledCourseIds, true),
                'details_url' => route('student.course-details', ['course' => $course->id]),
                'player_url' => route('student.course-player', ['course' => $course->id]),
                'checkout_url' => route('student.checkout', ['course' => $course->id]),
            ];
        });

        $featuredCourse = collect($courseCards->items())
            ->sortByDesc(fn (array $course) => ($course['students_count'] * 2) + $course['rating'])
            ->first();

        return view('student.browse_course', [
            'student' => $student,
            'profileAvatar' => $student->avatarUrl(96),
            'courseCards' => $courseCards,
            'featuredCourse' => $featuredCourse,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'search' => $search,
            'selectedCategory' => $category,
            'selectedLevel' => $level,
            'selectedPrice' => $price,
            'selectedSort' => $sort,
            'resultsCount' => $paginatedCourses->total(),
            'catalogMode' => $catalogMode,
            'onlineCatalogEnabled' => $onlineCatalogEnabled,
            'offlineCatalogEnabled' => $offlineCatalogEnabled,
        ]);
    }

    public function courseDetails(Request $request): RedirectResponse|View
    {
        if (! $request->user()) {
            $redirectTo = route('course.details', ['course' => (int) $request->query('course')], false);
            $request->session()->put('url.intended', $request->fullUrl());

            return redirect()->route('login', [
                'redirect_to' => $redirectTo,
            ])->with('status', 'Login or create an account to access course details.');
        }

        $detailData = $this->buildCourseDetailData($request);
        $gateContext = 'online-course-'.$detailData['course']->id;
        $granted = (array) $request->session()->get('content_gate_access', []);

        if (PlatformSettings::bool('public_lead_gate_enabled', true) && ! ($granted[$gateContext] ?? false)) {
            return redirect()
                ->route('home.courses', ['mode' => 'online'])
                ->with('status', 'Please unlock the course details from the course page first.');
        }

        return view('Home.course_detail', $detailData + [
            'browseUrl' => url('/course'),
        ]);
    }

    public function studentCourseDetails(Request $request): View
    {
        $detailData = $this->buildCourseDetailData($request);

        return view('student.course-details', $detailData + [
            'student' => $request->user(),
            'profileAvatar' => $request->user()->avatarUrl(96),
            'browseUrl' => route('student.browse-courses'),
        ]);
    }

    private function buildCourseDetailData(Request $request): array
    {
        $course = Course::query()
            ->where('status', 'published')
            ->with([
                'category:id,name',
                'user:id,name,bio,avatar_path',
                'sections' => fn ($query) => $query->orderBy('order_number'),
                'sections.videos' => fn ($query) => $query->orderBy('order_number'),
                'reviews' => fn ($query) => $query->latest()->limit(6),
                'reviews.user:id,name,avatar_path',
            ])
            ->withCount([
                'enrollments as students_count',
                'reviews',
            ])
            ->withAvg('reviews', 'rating')
            ->findOrFail((int) $request->query('course', Course::query()->where('status', 'published')->value('id')));

        $viewer = $request->user();
        $isAuthenticatedStudent = (bool) ($viewer && $viewer->role?->name === 'user');
        $isEnrolled = $isAuthenticatedStudent
            ? $viewer->enrollments()->where('course_id', $course->id)->exists()
            : false;
        $isWishlisted = $isAuthenticatedStudent
            ? $viewer->wishlists()->where('course_id', $course->id)->exists()
            : false;
        $isInCart = $isAuthenticatedStudent
            ? $viewer->cartItems()->where('course_id', $course->id)->exists()
            : false;

        $sections = $course->sections->map(function ($section) {
            return [
                'title' => $section->title,
                'lessons' => $section->videos->map(fn ($video) => [
                    'title' => $video->title,
                    'duration' => $this->formatDuration((int) ($video->duration ?? 0)),
                ]),
                'lessons_count' => $section->videos->count(),
            ];
        });

        $allVideos = $course->sections
            ->flatMap->videos
            ->sortBy('order_number')
            ->values();

        $previewVideo = $allVideos
            ->first(fn ($video) => (bool) ($video->is_preview) && filled($video->video_url))
            ?? $allVideos->first(fn ($video) => filled($video->video_url));

        $totalDurationSeconds = (int) $allVideos
            ->sum(fn ($video) => max(0, (int) ($video->duration ?? 0)));

        $learningTopics = collect($course->learning_topics ?? [])
            ->filter(fn ($topic) => is_string($topic) && trim($topic) !== '')
            ->values();

        $reviews = $course->reviews->map(function ($review) {
            return [
                'name' => $review->user?->name ?? 'Student',
                'avatar' => $review->user?->avatarUrl(96) ?? 'https://ui-avatars.com/api/?name=Student&background=EEF2FF&color=312E81&size=96',
                'rating' => (int) $review->rating,
                'comment' => $review->comment,
                'created_at' => optional($review->created_at)->format('d M Y'),
            ];
        });

        $relatedDetailsRoute = $isAuthenticatedStudent ? 'student.course-details' : 'course.details';

        $relatedCourses = Course::query()
            ->where('status', 'published')
            ->whereKeyNot($course->id)
            ->with(['user:id,name,avatar_path', 'category:id,name'])
            ->withCount(['reviews', 'enrollments as students_count'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->limit(3)
            ->get()
            ->map(fn (Course $relatedCourse) => [
                'id' => $relatedCourse->id,
                'title' => $relatedCourse->title,
                'thumbnail' => $relatedCourse->thumbnail ?: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=80',
                'category' => $relatedCourse->category?->name ?? 'General',
                'instructor_name' => $relatedCourse->user?->name ?? 'Instructor',
                'price' => (float) ($relatedCourse->price ?? 0),
                'rating' => round((float) ($relatedCourse->reviews_avg_rating ?? 0), 1),
                'students_count' => (int) $relatedCourse->students_count,
                'details_url' => route($relatedDetailsRoute, ['course' => $relatedCourse->id]),
            ]);

        return [
            'course' => $course,
            'heroThumbnail' => $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=80',
            'previewVideoUrl' => $previewVideo?->video_url,
            'previewLimitSeconds' => 40,
            'sections' => $sections,
            'reviews' => $reviews,
            'relatedCourses' => $relatedCourses,
            'learningTopics' => $learningTopics,
            'rating' => round((float) ($course->reviews_avg_rating ?? 0), 1),
            'studentsCount' => (int) $course->students_count,
            'reviewsCount' => (int) $course->reviews_count,
            'totalLessons' => $allVideos->count(),
            'totalSections' => $course->sections->count(),
            'formattedDuration' => $this->formatDuration($totalDurationSeconds),
            'isEnrolled' => $isEnrolled,
            'isWishlisted' => $isWishlisted,
            'isInCart' => $isInCart,
            'continueUrl' => route('student.course-player', ['course' => $course->id]),
            'checkoutUrl' => route('student.checkout', ['course' => $course->id]),
            'cartUrl' => route('student.cart'),
        ];
    }

    private function applyCourseSort($query, string $sort): void
    {
        match ($sort) {
            'rating' => $query->orderByDesc('reviews_avg_rating'),
            'newest' => $query->latest(),
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'popular' => $query->orderByDesc('students_count'),
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
}
