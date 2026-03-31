<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\CourseProgress;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class StudentCertificatesController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $search = trim((string) $request->query('search', ''));

        $issuedCertificates = Certificate::query()
            ->where('user_id', $student->id)
            ->with(['course' => fn ($query) => $query->with('user:id,name')])
            ->when($search !== '', fn ($query) => $query->whereHas('course', fn ($courseQuery) => $courseQuery->where('title', 'like', "%{$search}%")))
            ->latest('issued_at')
            ->get()
            ->filter(fn ($certificate) => $certificate->course !== null)
            ->values();

        $issuedCourseIds = $issuedCertificates->pluck('course_id')->all();
        $enrollments = Enrollment::query()
            ->where('user_id', $student->id)
            ->where('status', 'completed')
            ->whereNotIn('course_id', $issuedCourseIds)
            ->with([
                'course' => fn ($query) => $query->with([
                    'user:id,name',
                    'sections' => fn ($sectionQuery) => $sectionQuery->orderBy('order_number'),
                    'sections.videos' => fn ($videoQuery) => $videoQuery->orderBy('order_number'),
                ]),
            ])
            ->get();

        $courseIds = $enrollments->pluck('course_id')->values();
        $progressRows = CourseProgress::query()
            ->where('user_id', $student->id)
            ->when(
                $courseIds->isNotEmpty(),
                fn ($query) => $query->whereIn('course_id', $courseIds),
                fn ($query) => $query->whereRaw('1 = 0')
            )
            ->get()
            ->groupBy('course_id');

        $pendingCertificates = $this->buildPendingCertificates($enrollments, $progressRows, $search);

        return view('student.certificate', [
            'studentAvatar' => $student->avatarUrl(96),
            'search' => $search,
            'issuedCertificates' => $issuedCertificates,
            'pendingCertificates' => $pendingCertificates,
            'issuedCount' => $issuedCertificates->count(),
            'pendingCount' => $pendingCertificates->count(),
        ]);
    }

    private function buildPendingCertificates(Collection $enrollments, Collection $progressRows, string $search): Collection
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

                $totalLessons = $videos->count();
                if ($totalLessons < 1) {
                    return null;
                }

                $completedLessons = $progressRows
                    ->get($course->id, collect())
                    ->where('is_completed', true)
                    ->pluck('video_id')
                    ->unique()
                    ->count();

                $progressPercent = (int) round(($completedLessons / $totalLessons) * 100);

                return [
                    'course_id' => $course->id,
                    'title' => $course->title,
                    'details' => $course->details,
                    'thumbnail' => $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480',
                    'progress_percent' => $progressPercent,
                    'completed_lessons' => $completedLessons,
                    'total_lessons' => $totalLessons,
                    'is_ready' => $progressPercent >= 100,
                ];
            })
            ->filter()
            ->filter(function (array $item) use ($search) {
                if ($search === '') {
                    return true;
                }

                return str_contains(strtolower($item['title']), strtolower($search));
            })
            ->sortByDesc('progress_percent')
            ->values();
    }
}
