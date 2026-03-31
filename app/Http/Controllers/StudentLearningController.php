<?php

namespace App\Http\Controllers;

use App\Models\CourseProgress;
use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class StudentLearningController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $activeTab = match ($request->query('tab')) {
            'completed' => 'completed',
            'archived' => 'archived',
            default => 'in-progress',
        };

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
            ->latest('enrolled_at')
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

        $courseCards = $this->buildCourseCards($enrollments, $progressRows);
        $filteredCards = match ($activeTab) {
            'completed' => $courseCards->where('is_completed', true)->values(),
            'archived' => collect(),
            default => $courseCards->where('is_completed', false)->values(),
        };

        $weekStart = now()->startOfWeek();
        $completedLessonsThisWeek = CourseProgress::query()
            ->where('user_id', $student->id)
            ->where('is_completed', true)
            ->where('updated_at', '>=', $weekStart)
            ->distinct('video_id')
            ->count('video_id');

        $inProgressCount = $courseCards->where('is_completed', false)->count();
        $targetPercent = min(100, max(0, (int) round(($completedLessonsThisWeek / 10) * 100)));
        $streakDays = $this->calculateLearningStreak($student->id);

        return view('student.my_learning', [
            'studentAvatar' => $student->avatarUrl(96),
            'activeTab' => $activeTab,
            'hero' => [
                'in_progress_count' => $inProgressCount,
                'completed_lessons_this_week' => $completedLessonsThisWeek,
                'target_percent' => $targetPercent,
            ],
            'courses' => $filteredCards,
            'courseCount' => $filteredCards->count(),
            'streakDays' => $streakDays,
        ]);
    }

    private function buildCourseCards(Collection $enrollments, Collection $progressRows): Collection
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
                $completedIds = $courseProgress
                    ->where('is_completed', true)
                    ->pluck('video_id')
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values();

                $completedLessons = $completedIds->count();
                $totalLessons = $videos->count();
                $progressPercent = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;
                $isCompleted = $totalLessons > 0 && $completedLessons >= $totalLessons;
                $nextLesson = $videos->first(fn ($video) => ! $completedIds->contains((int) $video->id));
                $categoryName = $course->category?->name ?: 'Course';

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->details,
                    'thumbnail' => $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480',
                    'badge' => strtoupper($categoryName),
                    'progress_percent' => $progressPercent,
                    'completed_lessons' => $completedLessons,
                    'total_lessons' => $totalLessons,
                    'progress_text' => $progressPercent.'% Progress',
                    'lesson_text' => $completedLessons.' / '.$totalLessons.' Lessons',
                    'cta_label' => $isCompleted ? 'Review Course' : 'Resume Lesson',
                    'cta_url' => route('student.course-player', ['course' => $course->id]),
                    'is_completed' => $isCompleted,
                    'accent_class' => $this->accentClass($progressPercent),
                    'next_lesson' => $nextLesson?->title ?: 'Course completed',
                    'instructor_name' => $course->user?->name ?: 'Instructor',
                ];
            })
            ->filter()
            ->values();
    }

    private function accentClass(int $progressPercent): string
    {
        if ($progressPercent >= 85) {
            return 'bg-emerald-500';
        }

        if ($progressPercent >= 45) {
            return 'bg-tertiary';
        }

        return 'bg-primary';
    }

    private function calculateLearningStreak(int $studentId): int
    {
        $dates = CourseProgress::query()
            ->where('user_id', $studentId)
            ->selectRaw('DATE(updated_at) as activity_date')
            ->groupBy('activity_date')
            ->orderByDesc('activity_date')
            ->pluck('activity_date')
            ->map(fn ($date) => Carbon::parse($date)->startOfDay())
            ->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $cursor = now()->startOfDay();

        foreach ($dates as $date) {
            if ($date->equalTo($cursor)) {
                $streak++;
                $cursor = $cursor->copy()->subDay();
                continue;
            }

            if ($streak === 0 && $date->equalTo($cursor->copy()->subDay())) {
                $streak++;
                $cursor = $date->copy()->subDay();
                continue;
            }

            if (! $date->equalTo($cursor)) {
                break;
            }
        }

        return $streak;
    }
}
