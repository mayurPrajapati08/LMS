<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\PublicContact;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        $siteStats = $this->siteStats();
        $featuredCourses = $this->publishedCoursesBaseQuery()
            ->limit(6)
            ->get()
            ->map(fn (Course $course) => $this->mapCourseCard($course));

        return view('Home.home', [
            'siteStats' => $siteStats,
            'featuredCourses' => $featuredCourses,
        ]);
    }

    public function courses(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $category = (string) $request->query('category', '');
        $sort = (string) $request->query('sort', 'popular');

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

        /** @var LengthAwarePaginator $paginatedCourses */
        $paginatedCourses = $courses->paginate(9)->withQueryString();

        return view('Home.course', [
            'search' => $search,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'resultsCount' => $paginatedCourses->total(),
            'courseCards' => $paginatedCourses->through(fn (Course $course) => $this->mapCourseCard($course)),
        ]);
    }

    public function about(): View
    {
        $siteStats = $this->siteStats();
        $mentorCards = User::query()
            ->whereHas('role', fn ($query) => $query->where('name', 'instructor'))
            ->withCount(['courses' => fn ($query) => $query->where('status', 'published')])
            ->orderByDesc('courses_count')
            ->limit(4)
            ->get()
            ->map(fn (User $mentor) => [
                'name' => $mentor->name,
                'avatar' => $mentor->avatarUrl(320),
                'bio' => $mentor->bio ?: 'Industry mentor guiding students with practical, project-driven learning.',
                'headline' => $mentor->courses_count > 0
                    ? $mentor->courses_count.' published course'.($mentor->courses_count === 1 ? '' : 's')
                    : 'Industry mentor',
            ]);

        return view('Home.about_us', [
            'siteStats' => $siteStats,
            'mentorCards' => $mentorCards,
        ]);
    }

    public function contact(): View
    {
        return view('Home.contact', [
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
        ]);

        PublicContact::query()->create($validated);

        return back()->with('status', 'Your message has been sent successfully. Our team will contact you soon.');
    }

    public function placement(): View
    {
        $siteStats = $this->siteStats();
        $successStories = Review::query()
            ->with(['user:id,name,avatar_path', 'course:id,title'])
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->latest()
            ->limit(3)
            ->get()
            ->map(fn (Review $review) => [
                'name' => $review->user?->name ?? 'Student',
                'avatar' => $review->user?->avatarUrl(180) ?? 'https://ui-avatars.com/api/?name=Student&background=EEF2FF&color=312E81&size=180',
                'course' => $review->course?->title ?? 'Career Track',
                'comment' => $review->comment,
                'rating' => (int) $review->rating,
            ]);

        return view('Home.placement', [
            'siteStats' => $siteStats,
            'successStories' => $successStories,
        ]);
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
            'category' => $course->category?->name ?? 'Course',
            'level' => ucfirst((string) ($course->level ?: 'All Levels')),
            'language' => $course->language ?: 'English',
            'rating' => $rating,
            'reviews_count' => (int) $course->reviews_count,
            'students_count' => $studentsCount,
            'duration' => $this->formatDuration($durationSeconds),
            'details_url' => route('course.details', ['course' => $course->id]),
            'badge_label' => $badge['label'],
            'badge_class' => $badge['class'],
            'icon_one' => $iconSet[0],
            'icon_two' => $iconSet[1],
            'icon_three' => $iconSet[2],
        ];
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
}
