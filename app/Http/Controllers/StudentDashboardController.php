<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\CourseProgress;
use App\Models\Enrollment;
use App\Models\Wishlist;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $now = now();
        $currentMonthStart = $now->copy()->startOfMonth();

        $enrollments = Enrollment::query()
            ->where('user_id', $student->id)
            ->where('status', 'completed')
            ->with([
                'course' => fn ($query) => $query->with([
                    'user:id,name',
                    'category:id,name',
                    'sections' => fn ($sectionQuery) => $sectionQuery->orderBy('order_number'),
                    'sections.videos' => fn ($videoQuery) => $videoQuery->orderBy('order_number'),
                ]),
            ])
            ->orderByDesc('enrolled_at')
            ->get();

        $courseIds = $enrollments->pluck('course_id')->filter()->values();
        $progressRows = CourseProgress::query()
            ->where('user_id', $student->id)
            ->when(
                $courseIds->isNotEmpty(),
                fn ($query) => $query->whereIn('course_id', $courseIds),
                fn ($query) => $query->whereRaw('1 = 0')
            )
            ->get()
            ->groupBy('course_id');

        $courseSummaries = $this->buildCourseSummaries($enrollments, $progressRows);
        $completedCourses = $courseSummaries->where('is_completed', true)->count();
        $watchedSeconds = (int) $courseSummaries->sum('watched_seconds');
        $learningHours = round($watchedSeconds / 3600);
        $firstEnrollmentAt = $enrollments->pluck('enrolled_at')->filter()->map(fn ($date) => Carbon::parse($date))->sort()->first();
        $learningMonths = $firstEnrollmentAt
            ? max(1, (int) floor($firstEnrollmentAt->diffInDays($now) / 30) + 1)
            : 0;
        $newThisMonth = $enrollments
            ->filter(fn ($enrollment) => $enrollment->enrolled_at && Carbon::parse($enrollment->enrolled_at)->greaterThanOrEqualTo($currentMonthStart))
            ->count();
        $graduationRate = $courseSummaries->isNotEmpty()
            ? (int) round(($completedCourses / $courseSummaries->count()) * 100)
            : 0;

        $continueLearning = $courseSummaries
            ->where('progress_percent', '>', 0)
            ->where('is_completed', false)
            ->sortByDesc(fn (array $course) => ($course['last_activity_at']?->timestamp ?? 0) * 1000 + $course['progress_percent'])
            ->take(2)
            ->values();

        if ($continueLearning->isEmpty()) {
            $continueLearning = $courseSummaries->take(2)->values();
        }

        $curriculumCourses = $courseSummaries->take(3)->values();
        $weeklyEngagement = $this->buildWeeklyEngagement($student->id, $now);
        $weeklyHours = round($weeklyEngagement->sum('seconds') / 3600, 1);
        $certificateCount = Certificate::query()->where('user_id', $student->id)->count();
        $wishlistCount = Wishlist::query()->where('user_id', $student->id)->count();
        $dashboardInsight = $this->buildDashboardInsight($courseSummaries, $certificateCount, $wishlistCount);

        return view('student.dashboard', [
            'studentAvatar' => $student->avatarUrl(96),
            'welcomeName' => str($student->name)->trim()->explode(' ')->first() ?: 'Learner',
            'stats' => [
                'enrolled_courses' => $courseSummaries->count(),
                'new_this_month' => $newThisMonth,
                'completed_courses' => $completedCourses,
                'graduation_rate' => $graduationRate,
                'learning_hours' => $learningHours,
                'learning_months' => (int) $learningMonths,
            ],
            'continueLearning' => $continueLearning,
            'curriculumCourses' => $curriculumCourses,
            'weeklyEngagement' => $weeklyEngagement,
            'weeklyHours' => $weeklyHours,
            'activeCourseCount' => $courseSummaries->where('progress_percent', '>', 0)->where('is_completed', false)->count(),
            'dashboardInsight' => $dashboardInsight,
        ]);
    }

    private function buildCourseSummaries(Collection $enrollments, Collection $progressRows): Collection
    {
        return $enrollments
            ->map(function ($enrollment) use ($progressRows) {
                $course = $enrollment->course;

                if (! $course) {
                    return null;
                }

                $videos = $course->sections
                    ->sortBy('order_number')
                    ->flatMap(fn ($section) => $section->videos->sortBy('order_number')->values())
                    ->values();

                $courseProgress = $progressRows->get($course->id, collect());
                $completedVideoIds = $courseProgress
                    ->where('is_completed', true)
                    ->pluck('video_id')
                    ->map(fn ($id) => (int) $id)
                    ->all();

                $totalVideos = $videos->count();
                $completedVideos = count(array_unique($completedVideoIds));
                $progressPercent = $totalVideos > 0 ? (int) round(($completedVideos / $totalVideos) * 100) : 0;
                $watchedSeconds = (int) $courseProgress->sum('watched_durations');
                $lastActivityAt = $courseProgress->max('updated_at');
                $nextVideo = $videos->first(fn ($video) => ! in_array((int) $video->id, $completedVideoIds, true));
                $categoryName = $course->category?->name ?: 'Course';

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'thumbnail' => $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=320',
                    'instructor_name' => $course->user?->name ?: 'Instructor',
                    'category_name' => $categoryName,
                    'category_badge' => $this->abbreviateLabel($categoryName),
                    'level_label' => ucfirst($course->level ?: 'All Levels'),
                    'progress_percent' => $progressPercent,
                    'progress_label' => $progressPercent.'% complete',
                    'next_lesson_label' => $nextVideo?->title ? 'Next lesson: '.$nextVideo->title : ($totalVideos > 0 ? 'Course completed' : 'Curriculum will appear soon'),
                    'button_label' => $progressPercent >= 100 ? 'Review Course' : 'Resume',
                    'resume_url' => route('student.course-player', ['course' => $course->id]),
                    'is_completed' => $totalVideos > 0 && $completedVideos >= $totalVideos,
                    'watched_seconds' => $watchedSeconds,
                    'last_activity_at' => $lastActivityAt ? Carbon::parse($lastActivityAt) : null,
                    'accent' => $this->courseAccent($categoryName, $progressPercent),
                ];
            })
            ->filter()
            ->values();
    }

    private function buildWeeklyEngagement(int $studentId, Carbon $now): Collection
    {
        $start = $now->copy()->subDays(6)->startOfDay();
        $activityByDate = CourseProgress::query()
            ->where('user_id', $studentId)
            ->where('updated_at', '>=', $start)
            ->selectRaw('DATE(updated_at) as activity_date, SUM(watched_durations) as watched_seconds')
            ->groupBy('activity_date')
            ->pluck('watched_seconds', 'activity_date');

        $maxSeconds = max(1, (int) collect($activityByDate)->max());

        return collect(CarbonPeriod::create($start, '1 day', $now))
            ->map(function (Carbon $day) use ($activityByDate, $maxSeconds) {
                $key = $day->format('Y-m-d');
                $seconds = (int) ($activityByDate[$key] ?? 0);
                $intensity = $seconds / $maxSeconds;

                return [
                    'label' => $day->format('D'),
                    'seconds' => $seconds,
                    'opacity_class' => $this->opacityClass($intensity),
                ];
            });
    }

    private function buildDashboardInsight(Collection $courseSummaries, int $certificateCount, int $wishlistCount): array
    {
        $closestCourse = $courseSummaries
            ->where('is_completed', false)
            ->sortByDesc('progress_percent')
            ->first();

        if ($closestCourse) {
            return [
                'title' => 'Momentum Insight',
                'message' => $closestCourse['title'].' is your strongest active course at '.$closestCourse['progress_percent'].'%. A focused session now can push you closer to completion.',
                'button_label' => 'Resume Learning',
                'href' => $closestCourse['resume_url'],
            ];
        }

        if ($certificateCount > 0) {
            return [
                'title' => 'Achievement Insight',
                'message' => 'You already have '.$certificateCount.' certificate'.($certificateCount === 1 ? '' : 's').'. Keep that momentum going with your next course milestone.',
                'button_label' => 'View Certificates',
                'href' => '/student/certificate',
            ];
        }

        if ($wishlistCount > 0) {
            return [
                'title' => 'Curator Insight',
                'message' => 'You still have '.$wishlistCount.' saved course'.($wishlistCount === 1 ? '' : 's').' waiting in your wishlist. Picking one up can keep your learning streak fresh.',
                'button_label' => 'Open Wishlist',
                'href' => '/student/wishlist',
            ];
        }

        return [
            'title' => 'Curator Insight',
            'message' => 'Your dashboard is ready. Enroll in a course and your learning progress, hours, and milestones will start showing up here.',
            'button_label' => 'Browse Courses',
            'href' => '/student/browse-courses',
        ];
    }

    private function abbreviateLabel(string $value): string
    {
        $words = collect(preg_split('/\s+/', trim($value)) ?: [])
            ->filter()
            ->values();

        if ($words->count() >= 2) {
            return $words
                ->take(3)
                ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                ->implode('');
        }

        return strtoupper(substr($value, 0, 4));
    }

    private function courseAccent(string $categoryName, int $progressPercent): array
    {
        $key = strtolower($categoryName);

        if (str_contains($key, 'data')) {
            return [
                'badge' => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
                'button' => 'bg-surface-container-high text-primary hover:bg-surface-container-highest',
                'progress' => 'bg-gradient-to-r from-primary to-primary-container',
            ];
        }

        if ($progressPercent >= 80) {
            return [
                'badge' => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                'button' => 'bg-primary text-on-primary hover:bg-primary-container',
                'progress' => 'bg-gradient-to-r from-primary to-primary-container',
            ];
        }

        return [
            'badge' => 'bg-secondary-fixed text-on-secondary-fixed-variant',
            'button' => 'bg-surface-container-high text-primary hover:bg-surface-container-highest',
            'progress' => 'bg-gradient-to-r from-primary to-primary-container',
        ];
    }

    private function opacityClass(float $intensity): string
    {
        return match (true) {
            $intensity >= 0.85 => 'opacity-90',
            $intensity >= 0.65 => 'opacity-80',
            $intensity >= 0.45 => 'opacity-60',
            $intensity >= 0.25 => 'opacity-40',
            $intensity > 0 => 'opacity-20',
            default => 'opacity-10',
        };
    }
}
