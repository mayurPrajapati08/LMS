<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Video;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InstructorInsightsController extends Controller
{
    public function earnings(Request $request): View
    {
        $instructor = $request->user();
        $courseIds = $instructor->courses()->pluck('id');
        $now = now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = $lastMonthStart->copy()->endOfMonth();

        $completedPayments = Payment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed');

        $allPayments = Payment::query()->whereIn('course_id', $courseIds);
        $completedEnrollments = Enrollment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed');

        $totalRevenue = (float) (clone $completedPayments)->sum('amount');
        $monthlyRevenue = (float) (clone $completedPayments)
            ->whereBetween('created_at', [$currentMonthStart, $now])
            ->sum('amount');
        $previousMonthRevenue = (float) (clone $completedPayments)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');
        $activeStudents = (clone $completedEnrollments)->distinct('user_id')->count('user_id');
        $estimatedYearlyRevenue = $monthlyRevenue > 0 ? $monthlyRevenue * 12 : $totalRevenue;
        $averageOrderValue = (float) ((clone $completedPayments)->avg('amount') ?? 0);
        $completedTransactions = (clone $completedPayments)->count();
        $pendingTransactions = (clone $allPayments)->where('status', 'pending')->count();

        $monthlyRevenueData = $this->buildMonthlyRevenue($courseIds, $now->copy()->subMonths(5)->startOfMonth(), $now);
        $revenueChartPath = $this->generateChartPath(collect($monthlyRevenueData)->pluck('amount'), 640, 180, 132);

        $topCourse = Course::query()
            ->whereIn('id', $courseIds)
            ->withSum([
                'payments as completed_revenue' => fn ($query) => $query->where('status', 'completed'),
            ], 'amount')
            ->orderByDesc('completed_revenue')
            ->first();

        $transactions = Payment::query()
            ->whereIn('course_id', $courseIds)
            ->with(['course:id,title'])
            ->latest()
            ->limit(8)
            ->get();

        return view('instructor.earnings', [
            'profileAvatar' => $instructor->avatarUrl(96),
            'instructorName' => $instructor->name,
            'totalRevenue' => $this->formatCurrency($totalRevenue),
            'totalRevenueTrend' => $this->formatTrend($monthlyRevenue, $previousMonthRevenue),
            'monthlyRevenue' => $this->formatCurrency($monthlyRevenue),
            'availableToWithdraw' => $this->formatCurrency($monthlyRevenue),
            'activeStudents' => number_format($activeStudents),
            'estimatedYearlyRevenue' => $this->formatCurrency($estimatedYearlyRevenue),
            'averageOrderValue' => $this->formatCurrency($averageOrderValue),
            'completedTransactions' => number_format($completedTransactions),
            'pendingTransactions' => number_format($pendingTransactions),
            'topCourseTitle' => $topCourse?->title ?: 'No completed sales yet',
            'topCourseRevenue' => $this->formatCurrency((float) ($topCourse?->completed_revenue ?? 0)),
            'monthlyRevenueData' => $monthlyRevenueData,
            'revenueChartPath' => $revenueChartPath,
            'transactions' => $transactions,
        ]);
    }

    public function students(Request $request): View
    {
        $instructor = $request->user();
        $courseIds = $instructor->courses()->pluck('id');

        $enrollments = Enrollment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed')
            ->with(['user:id,name,email', 'course:id,title'])
            ->orderByDesc(DB::raw('COALESCE(enrolled_at, created_at)'))
            ->paginate(10)
            ->withQueryString();

        $courseVideoCounts = Video::query()
            ->join('sections', 'sections.id', '=', 'videos.section_id')
            ->whereIn('sections.course_id', $courseIds)
            ->selectRaw('sections.course_id, COUNT(videos.id) as total_videos')
            ->groupBy('sections.course_id')
            ->pluck('total_videos', 'sections.course_id');

        $progressMap = CourseProgress::query()
            ->whereIn('course_id', $courseIds)
            ->whereIn('user_id', $enrollments->pluck('user_id')->all())
            ->where('is_completed', true)
            ->selectRaw('user_id, course_id, COUNT(*) as completed_videos')
            ->groupBy('user_id', 'course_id')
            ->get()
            ->keyBy(fn ($item) => $item->user_id.'-'.$item->course_id);

        $studentRows = $enrollments->getCollection()->map(function ($enrollment) use ($courseVideoCounts, $progressMap) {
            $totalVideos = max(1, (int) ($courseVideoCounts[$enrollment->course_id] ?? 0));
            $completedVideos = (int) ($progressMap[$enrollment->user_id.'-'.$enrollment->course_id]->completed_videos ?? 0);
            $progressPercent = $totalVideos > 0 ? (int) min(100, round(($completedVideos / $totalVideos) * 100)) : 0;

            return [
                'enrollment' => $enrollment,
                'progress_percent' => $progressPercent,
                'status_label' => $progressPercent >= 85 ? 'High Potential' : ($progressPercent <= 35 ? 'At Risk' : 'On Track'),
            ];
        });

        $enrollments->setCollection($studentRows);

        $totalActiveStudents = Enrollment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed')
            ->distinct('user_id')
            ->count('user_id');

        $averageProgress = $studentRows->avg('progress_percent') ?? 0;
        $topCourse = Course::query()
            ->whereIn('id', $courseIds)
            ->withCount([
                'enrollments as completed_enrollments_count' => fn ($query) => $query->where('status', 'completed'),
            ])
            ->orderByDesc('completed_enrollments_count')
            ->first();

        $highPotentialCount = $studentRows->where('progress_percent', '>=', 85)->count();
        $atRiskCount = $studentRows->where('progress_percent', '<=', 35)->count();

        return view('instructor.students', [
            'profileAvatar' => $instructor->avatarUrl(96),
            'instructorName' => $instructor->name,
            'students' => $enrollments,
            'totalActiveStudents' => number_format($totalActiveStudents),
            'averageProgress' => number_format($averageProgress, 1).'%',
            'topCourseTitle' => $topCourse?->title ?: 'No active course yet',
            'topCourseStudents' => number_format((int) ($topCourse?->completed_enrollments_count ?? 0)),
            'highPotentialCount' => $highPotentialCount,
            'atRiskCount' => $atRiskCount,
        ]);
    }

    public function reviews(Request $request): View
    {
        $instructor = $request->user();
        $courseIds = $instructor->courses()->pluck('id');
        $reviews = Review::query()
            ->whereIn('course_id', $courseIds)
            ->with(['user:id,name,email', 'course:id,title'])
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $averageRating = round((float) Review::query()->whereIn('course_id', $courseIds)->avg('rating'), 1);
        $totalReviews = Review::query()->whereIn('course_id', $courseIds)->count();
        $fiveStarReviews = Review::query()->whereIn('course_id', $courseIds)->where('rating', 5)->count();
        $recentReviews = Review::query()
            ->whereIn('course_id', $courseIds)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
        $topReviewedCourse = Course::query()
            ->whereIn('id', $courseIds)
            ->withCount('reviews')
            ->orderByDesc('reviews_count')
            ->first();

        return view('instructor.reviews', [
            'profileAvatar' => $instructor->avatarUrl(96),
            'averageRating' => $averageRating > 0 ? number_format($averageRating, 1) : '0.0',
            'totalReviews' => number_format($totalReviews),
            'fiveStarReviews' => number_format($fiveStarReviews),
            'recentReviews' => number_format($recentReviews),
            'topReviewedCourse' => $topReviewedCourse?->title ?: 'No reviews yet',
            'reviews' => $reviews,
        ]);
    }

    private function buildMonthlyRevenue(Collection $courseIds, Carbon $start, Carbon $end): array
    {
        $grouped = Payment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-01') as revenue_month, SUM(amount) as total")
            ->groupBy('revenue_month')
            ->pluck('total', 'revenue_month');

        $points = [];

        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $monthKey = $month->format('Y-m-01');
            $points[] = [
                'label' => $month->format('M'),
                'amount' => (float) ($grouped[$monthKey] ?? 0),
            ];
        }

        return $points;
    }

    private function generateChartPath(Collection $values, int $width, int $baseY, int $height): string
    {
        if ($values->isEmpty() || $values->max() <= 0) {
            return "M0 {$baseY} L{$width} ".($baseY - 40);
        }

        $max = (float) $values->max();
        $count = max($values->count() - 1, 1);

        return $values->values()->map(function ($value, $index) use ($max, $count, $width, $baseY, $height) {
            $x = ($width / $count) * $index;
            $normalized = $max > 0 ? ($value / $max) : 0;
            $y = $baseY - ($normalized * $height);

            return ($index === 0 ? 'M' : 'L').round($x, 2).' '.round($y, 2);
        })->implode(' ');
    }

    private function formatTrend(float|int $current, float|int $previous): array
    {
        if ($current == 0 && $previous == 0) {
            return ['label' => 'New', 'positive' => false];
        }

        if ($previous <= 0) {
            return ['label' => '+100%', 'positive' => true];
        }

        $change = (($current - $previous) / $previous) * 100;

        if (abs($change) < 0.05) {
            return ['label' => 'Steady', 'positive' => false];
        }

        return [
            'label' => ($change > 0 ? '+' : '').round($change).'%',
            'positive' => $change >= 0,
        ];
    }

    private function formatCurrency(float $amount): string
    {
        return 'Rs. '.number_format($amount, 2);
    }

}


