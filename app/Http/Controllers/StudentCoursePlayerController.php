<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\CourseProgress;
use App\Models\Enrollment;
use App\Models\Inquiry;
use App\Models\LessonNote;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class StudentCoursePlayerController extends Controller
{
    public function show(Request $request): View
    {
        $student = $request->user();
        $courseId = $request->integer('course');
        $lessonId = $request->integer('lesson');

        abort_if($courseId <= 0, 404);

        $enrollment = Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->with([
                'course' => fn ($query) => $query->with([
                    'user:id,name',
                    'sections' => fn ($sectionQuery) => $sectionQuery->orderBy('order_number'),
                    'sections.videos' => fn ($videoQuery) => $videoQuery->orderBy('order_number'),
                    'sections.videos.materials',
                ]),
            ])
            ->firstOrFail();

        $course = $enrollment->course;
        $sections = $course->sections->sortBy('order_number')->values();
        $lessons = $sections
            ->flatMap(fn ($section) => $section->videos->sortBy('order_number')->values())
            ->values();

        abort_if($lessons->isEmpty(), 404);

        $progressRows = CourseProgress::query()
            ->where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->get()
            ->keyBy('video_id');

        $currentLesson = $lessonId > 0
            ? $lessons->firstWhere('id', $lessonId)
            : $this->resolveCurrentLesson($lessons, $progressRows);

        $currentLesson ??= $lessons->first();

        $currentIndex = $lessons->search(fn ($lesson) => (int) $lesson->id === (int) $currentLesson->id);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        $previousLesson = $currentIndex > 0 ? $lessons->get($currentIndex - 1) : null;
        $nextLesson = $lessons->get($currentIndex + 1);
        $completedCount = $progressRows->where('is_completed', true)->count();
        $totalLessons = $lessons->count();
        $progressPercent = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;
        $emptySectionCount = $sections->filter(fn ($section) => $section->videos->isEmpty())->count();
        $courseContentComplete = ($course->content_status ?? 'pending') === 'completed';
        $comingSoonSectionsCount = $courseContentComplete ? 0 : max(1, $emptySectionCount);
        $courseFullyCompleted = $courseContentComplete && $totalLessons > 0 && $completedCount >= $totalLessons;
        $resourceItems = $currentLesson->materials ?? collect();
        $resourceCount = $resourceItems->count();
        $courseQuestions = Inquiry::query()
            ->where('course_id', $course->id)
            ->latest()
            ->get();
        $qaCount = $courseQuestions->count();
        $currentLessonNote = LessonNote::query()
            ->where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->where('video_id', $currentLesson->id)
            ->first();
        $notesCount = $currentLessonNote && filled($currentLessonNote->content) ? 1 : 0;
        $currentLessonProgress = $progressRows->get($currentLesson->id);
        $currentLessonDuration = max(0, (int) ($currentLesson->duration ?? 0));
        $watchedSeconds = max(0, (int) ($currentLessonProgress?->watched_durations ?? 0));
        $resumeSeconds = max(0, (int) ($currentLessonProgress?->last_watched_seconds ?? $watchedSeconds));
        $completionThreshold = $currentLessonDuration > 0 ? max(1, $currentLessonDuration - 3) : 1;
        $canMarkCurrentLessonComplete = $watchedSeconds >= $completionThreshold;

        if ($courseFullyCompleted) {
            $this->syncCertificateForCourse($student->id, $course->id);
        }

        $certificateExists = Certificate::query()
            ->where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->exists();

        $sectionCards = $sections->map(function ($section) use ($course, $progressRows, $currentLesson) {
            if ($section->videos->isEmpty()) {
                return [
                    'title' => $section->title,
                    'is_open' => false,
                    'is_completed' => false,
                    'completed_lessons' => 0,
                    'total_lessons' => 0,
                    'is_coming_soon' => true,
                    'coming_soon_text' => 'New videos coming soon',
                    'lessons' => collect(),
                ];
            }

            $sectionLessons = $section->videos->sortBy('order_number')->values()->map(function ($lesson, $index) use ($course, $progressRows, $currentLesson) {
                $progress = $progressRows->get($lesson->id);
                $isCurrent = (int) $lesson->id === (int) $currentLesson->id;
                $isCompleted = (bool) ($progress?->is_completed);

                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'duration' => $this->formatDuration((int) ($lesson->duration ?? 0)),
                    'url' => route('student.course-player', ['course' => $course->id, 'lesson' => $lesson->id]),
                    'is_current' => $isCurrent,
                    'is_completed' => $isCompleted,
                    'lesson_number' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'icon' => $isCompleted ? 'check_circle' : 'play_circle',
                    'icon_class' => $isCurrent || $isCompleted ? 'text-primary' : 'text-on-surface-variant',
                ];
            });

            $completedLessons = $sectionLessons->where('is_completed', true)->count();
            $sectionLessonCount = $sectionLessons->count();
            $containsCurrentLesson = $sectionLessons->contains(fn ($lesson) => $lesson['is_current']);

            return [
                'title' => $section->title,
                'is_open' => $containsCurrentLesson,
                'is_completed' => $sectionLessonCount > 0 && $completedLessons === $sectionLessonCount,
                'completed_lessons' => $completedLessons,
                'total_lessons' => $sectionLessonCount,
                'is_coming_soon' => false,
                'coming_soon_text' => null,
                'lessons' => $sectionLessons,
            ];
        });

        return view('student.course-player', [
            'studentAvatar' => $student->avatarUrl(96),
            'course' => $course,
            'currentLesson' => $currentLesson,
            'previousLessonUrl' => $previousLesson ? route('student.course-player', ['course' => $course->id, 'lesson' => $previousLesson->id]) : route('student.my-learning'),
            'nextLessonUrl' => $nextLesson ? route('student.course-player', ['course' => $course->id, 'lesson' => $nextLesson->id]) : null,
            'progressPercent' => $progressPercent,
            'completedCount' => $completedCount,
            'totalLessons' => $totalLessons,
            'sectionCards' => $sectionCards,
            'resourceItems' => $resourceItems,
            'resourceCount' => $resourceCount,
            'courseQuestions' => $courseQuestions,
            'qaCount' => $qaCount,
            'notesCount' => $notesCount,
            'currentLessonNote' => $currentLessonNote,
            'isCurrentLessonCompleted' => (bool) ($progressRows->get($currentLesson->id)?->is_completed),
            'canMarkCurrentLessonComplete' => $canMarkCurrentLessonComplete,
            'currentLessonDurationSeconds' => $currentLessonDuration,
            'currentLessonWatchedSeconds' => $watchedSeconds,
            'certificateRemaining' => max(0, $totalLessons - $completedCount),
            'courseContentComplete' => $courseContentComplete,
            'courseFullyCompleted' => $courseFullyCompleted,
            'certificateUnlocked' => $certificateExists || $courseFullyCompleted,
            'comingSoonSectionsCount' => $comingSoonSectionsCount,
            'resumeSeconds' => $resumeSeconds,
            'saveProgressUrl' => route('student.course-player.progress'),
        ]);
    }

    public function saveProgress(Request $request): JsonResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'course_id' => ['required', 'integer'],
            'lesson_id' => ['required', 'integer'],
            'watched_seconds' => ['required', 'numeric', 'min:0'],
            'duration_seconds' => ['nullable', 'numeric', 'min:0'],
        ]);

        $enrollment = Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->where('status', 'completed')
            ->firstOrFail();

        $lesson = Video::query()
            ->where('id', $validated['lesson_id'])
            ->whereHas('section', fn ($query) => $query->where('course_id', $enrollment->course_id))
            ->firstOrFail();

        $watchedSeconds = max(0, (int) round((float) $validated['watched_seconds']));
        $durationSeconds = max(0, (int) round((float) ($validated['duration_seconds'] ?? $lesson->duration ?? 0)));

        if ($durationSeconds > 0 && (int) ($lesson->duration ?? 0) !== $durationSeconds) {
            $lesson->duration = $durationSeconds;
            $lesson->save();
        }

        $existingProgress = CourseProgress::query()->firstOrNew([
            'user_id' => $student->id,
            'course_id' => $enrollment->course_id,
            'video_id' => $lesson->id,
        ]);

        $existingProgress->watched_durations = max((int) ($existingProgress->watched_durations ?? 0), $watchedSeconds);
        $existingProgress->last_watched_seconds = $durationSeconds > 0
            ? min($watchedSeconds, $durationSeconds)
            : $watchedSeconds;
        $existingProgress->is_completed = $existingProgress->is_completed
            || ($durationSeconds > 0 && $existingProgress->watched_durations >= max(1, $durationSeconds - 3));
        $existingProgress->save();
        $this->syncCertificateForCourse($student->id, $enrollment->course_id);

        return response()->json([
            'saved' => true,
            'watched_seconds' => (int) $existingProgress->watched_durations,
            'resume_seconds' => (int) $existingProgress->last_watched_seconds,
            'is_completed' => (bool) $existingProgress->is_completed,
        ]);
    }

    public function complete(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'course_id' => ['required', 'integer'],
            'lesson_id' => ['required', 'integer'],
        ]);

        $enrollment = Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->where('status', 'completed')
            ->firstOrFail();

        $lesson = Video::query()
            ->where('id', $validated['lesson_id'])
            ->whereHas('section', fn ($query) => $query->where('course_id', $enrollment->course_id))
            ->firstOrFail();

        $progress = CourseProgress::query()->firstOrNew([
            'user_id' => $student->id,
            'course_id' => $enrollment->course_id,
            'video_id' => $lesson->id,
        ]);

        $requiredDuration = max(1, max(0, (int) ($lesson->duration ?? 0)) - 3);

        if ((int) ($progress->watched_durations ?? 0) < $requiredDuration) {
            return back()->withErrors([
                'lesson_complete' => 'Finish the full video before marking this lesson complete.',
            ]);
        }

        CourseProgress::query()->updateOrCreate(
            [
                'user_id' => $student->id,
                'course_id' => $enrollment->course_id,
                'video_id' => $lesson->id,
            ],
            [
                'watched_durations' => max((int) ($lesson->duration ?? 0), 1),
                'last_watched_seconds' => max((int) ($lesson->duration ?? 0), 1),
                'is_completed' => true,
            ]
        );
        $this->syncCertificateForCourse($student->id, $enrollment->course_id);

        $allLessons = Video::query()
            ->whereHas('section', fn ($query) => $query->where('course_id', $enrollment->course_id))
            ->orderBy('section_id')
            ->orderBy('order_number')
            ->get();

        $currentIndex = $allLessons->search(fn ($item) => (int) $item->id === (int) $lesson->id);
        $nextLesson = $currentIndex !== false ? $allLessons->get($currentIndex + 1) : null;

        return redirect()->route('student.course-player', [
            'course' => $enrollment->course_id,
            'lesson' => $nextLesson?->id ?? $lesson->id,
        ])->with('status', 'Lesson marked as complete.');
    }

    public function storeQuestion(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'course_id' => ['required', 'integer'],
            'lesson_id' => ['nullable', 'integer'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->where('status', 'completed')
            ->firstOrFail();

        Inquiry::query()->create([
            'user_id' => $student->id,
            'course_id' => $validated['course_id'],
            'name' => $student->name,
            'email' => $student->email,
            'phone' => null,
            'message' => trim($validated['message']),
            'status' => 'pending',
            'admin_reply' => null,
        ]);

        return redirect()->route('student.course-player', [
            'course' => $validated['course_id'],
            'lesson' => $validated['lesson_id'] ?? null,
            'tab' => 'qa',
        ])->with('status', 'Your question has been sent to the instructor.');
    }

    public function storeNote(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'course_id' => ['required', 'integer'],
            'lesson_id' => ['required', 'integer'],
            'content' => ['nullable', 'string', 'max:10000'],
        ]);

        Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->where('status', 'completed')
            ->firstOrFail();

        $lesson = Video::query()
            ->where('id', $validated['lesson_id'])
            ->whereHas('section', fn ($query) => $query->where('course_id', $validated['course_id']))
            ->firstOrFail();

        $content = trim((string) ($validated['content'] ?? ''));

        if ($content === '') {
            LessonNote::query()
                ->where('user_id', $student->id)
                ->where('course_id', $validated['course_id'])
                ->where('video_id', $lesson->id)
                ->delete();

            return redirect()->route('student.course-player', [
                'course' => $validated['course_id'],
                'lesson' => $lesson->id,
                'tab' => 'notes',
            ])->with('status', 'Your note was cleared for this lesson.');
        }

        LessonNote::query()->updateOrCreate(
            [
                'user_id' => $student->id,
                'course_id' => $validated['course_id'],
                'video_id' => $lesson->id,
            ],
            [
                'content' => $content,
            ]
        );

        return redirect()->route('student.course-player', [
            'course' => $validated['course_id'],
            'lesson' => $lesson->id,
            'tab' => 'notes',
        ])->with('status', 'Your lesson note was saved.');
    }

    public function viewResource(Request $request, CourseMaterial $material): RedirectResponse
    {
        $student = $request->user();
        $material->loadMissing('video.section');

        $courseId = (int) optional(optional($material->video)->section)->course_id;

        Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->firstOrFail();

        return redirect()->away($material->file_url);
    }

    public function downloadResource(Request $request, CourseMaterial $material): RedirectResponse
    {
        $student = $request->user();
        $material->loadMissing('video.section');

        $courseId = (int) optional(optional($material->video)->section)->course_id;

        Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->firstOrFail();

        return redirect()->away($this->downloadUrlForResource($material));
    }

    private function resolveCurrentLesson(Collection $lessons, Collection $progressRows): ?Video
    {
        $lastTouchedLessonId = $progressRows
            ->sortByDesc(fn ($progress) => optional($progress->updated_at)->getTimestamp() ?? 0)
            ->keys()
            ->first();

        if ($lastTouchedLessonId) {
            $lastTouchedLesson = $lessons->firstWhere('id', (int) $lastTouchedLessonId);

            if ($lastTouchedLesson) {
                return $lastTouchedLesson;
            }
        }

        foreach ($lessons as $lesson) {
            if (! (bool) ($progressRows->get($lesson->id)?->is_completed)) {
                return $lesson;
            }
        }

        return $lessons->first();
    }

    private function formatDuration(int $seconds): string
    {
        if ($seconds <= 0) {
            return '00:00';
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
        }

        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }

    private function syncCertificateForCourse(int $studentId, int $courseId): void
    {
        $course = Course::query()
            ->with(['sections.videos:id,section_id'])
            ->find($courseId);

        if (! $course) {
            return;
        }

        if (($course->content_status ?? 'pending') !== 'completed') {
            return;
        }

        $sections = $course->sections;

        if ($sections->isEmpty() || $sections->contains(fn ($section) => $section->videos->isEmpty())) {
            return;
        }

        $lessonIds = $sections
            ->flatMap(fn ($section) => $section->videos->pluck('id'))
            ->filter()
            ->values();

        if ($lessonIds->isEmpty()) {
            return;
        }

        $completedLessons = CourseProgress::query()
            ->where('user_id', $studentId)
            ->where('course_id', $courseId)
            ->whereIn('video_id', $lessonIds)
            ->where('is_completed', true)
            ->count();

        if ($completedLessons < $lessonIds->count()) {
            return;
        }

        Certificate::query()->updateOrCreate(
            [
                'user_id' => $studentId,
                'course_id' => $courseId,
            ],
            [
                'certificate_url' => route('student.certificates').'#course-'.$courseId,
                'issued_at' => now(),
            ]
        );
    }

    private function resourceFilename(CourseMaterial $material): string
    {
        $base = trim(preg_replace('/[^A-Za-z0-9\-_ ]+/', '', $material->title)) ?: 'resource';
        $extension = strtolower((string) $material->type);

        return str_replace(' ', '-', $base).'.'.$extension;
    }

    private function downloadUrlForResource(CourseMaterial $material): string
    {
        $url = $material->file_url;

        if (str_contains($url, '/raw/upload/')) {
            return str_replace(
                '/raw/upload/',
                '/raw/upload/fl_attachment:'.$this->resourceFilename($material).'/',
                $url
            );
        }

        return $url;
    }
}
