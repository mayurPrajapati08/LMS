<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstructorDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $instructor = $request->user();
        $courseIds = $instructor->courses()->pluck('id');

        $now = now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $previousMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $previousMonthEnd = $previousMonthStart->copy()->endOfMonth();
        $last30DaysStart = $now->copy()->subDays(29)->startOfDay();

        $coursesQuery = Course::query()->where('user_id', $instructor->id);
        $paymentsQuery = Payment::query()->whereIn('course_id', $courseIds);
        $completedPaymentsQuery = Payment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed');
        $completedEnrollmentsQuery = Enrollment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed');
        $reviewsQuery = Review::query()->whereIn('course_id', $courseIds);
        $wishlistsQuery = Wishlist::query()->whereIn('course_id', $courseIds);

        $totalRevenue = (float) (clone $completedPaymentsQuery)->sum('amount');
        $previousRevenue = (float) (clone $completedPaymentsQuery)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('amount');
        $monthlyEarnings = (float) (clone $completedPaymentsQuery)
            ->whereBetween('created_at', [$currentMonthStart, $now])
            ->sum('amount');
        $previousMonthlyEarnings = (float) (clone $completedPaymentsQuery)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('amount');

        $totalStudents = (clone $completedEnrollmentsQuery)->distinct('user_id')->count('user_id');
        $currentMonthStudents = (clone $completedEnrollmentsQuery)
            ->whereBetween(DB::raw('COALESCE(enrolled_at, created_at)'), [$currentMonthStart, $now])
            ->distinct('user_id')
            ->count('user_id');
        $previousMonthStudents = (clone $completedEnrollmentsQuery)
            ->whereBetween(DB::raw('COALESCE(enrolled_at, created_at)'), [$previousMonthStart, $previousMonthEnd])
            ->distinct('user_id')
            ->count('user_id');

        $totalCourses = (clone $coursesQuery)->count();
        $publishedCourses = (clone $coursesQuery)->where('status', 'published')->count();
        $currentMonthCourses = (clone $coursesQuery)->whereBetween('created_at', [$currentMonthStart, $now])->count();
        $previousMonthCourses = (clone $coursesQuery)->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $completedPaymentsCount = (clone $completedPaymentsQuery)->count();
        $failedPaymentsCount = (clone $paymentsQuery)->where('status', 'failed')->count();
        $totalPaymentsCount = (clone $paymentsQuery)->count();
        $wishlistCount = (clone $wishlistsQuery)->count();
        $activeSubscriptions = (clone $completedEnrollmentsQuery)
            ->where(function ($query) use ($now) {
                $query->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>', $now);
            })
            ->count();

        $averageOrderValue = $completedPaymentsCount > 0 ? $totalRevenue / $completedPaymentsCount : 0;
        $refundRate = $totalPaymentsCount > 0 ? ($failedPaymentsCount / $totalPaymentsCount) * 100 : 0;
        $conversionRate = $wishlistCount > 0 ? min(100, ($totalStudents / $wishlistCount) * 100) : 0;

        $dailyRevenue = $this->buildDailyRevenue($courseIds, $last30DaysStart, $now);
        $peakRevenue = collect($dailyRevenue)->max('amount') ?? 0;
        $peakRevenueDay = collect($dailyRevenue)->firstWhere('amount', $peakRevenue);
        $peakCourse = Course::query()
            ->whereIn('id', $courseIds)
            ->withSum([
                'payments as recent_revenue' => fn ($query) => $query
                    ->where('status', 'completed')
                    ->whereBetween('created_at', [$last30DaysStart, $now]),
            ], 'amount')
            ->orderByDesc('recent_revenue')
            ->first();

        $chartValues = collect($dailyRevenue)->pluck('amount');
        $chartPoints = $this->buildChartPoints($dailyRevenue);
        $peakPoint = collect($chartPoints)->sortByDesc('amount')->first();
        $recentEnrollments = Enrollment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed')
            ->with(['user:id,name,email', 'course:id,title', 'payment:id,amount'])
            ->orderByDesc(DB::raw('COALESCE(enrolled_at, created_at)'))
            ->limit(3)
            ->get();

        $recentReviews = Review::query()
            ->whereIn('course_id', $courseIds)
            ->with(['user:id,name', 'course:id,title'])
            ->latest()
            ->limit(2)
            ->get();

        $draftCoursesCount = (clone $coursesQuery)->where('status', 'draft')->count();
        $unreviewedCoursesCount = (clone $coursesQuery)->whereDoesntHave('reviews')->count();

        $recommendedActions = collect([
            $draftCoursesCount > 0 ? [
                'icon' => 'campaign',
                'icon_bg' => 'bg-orange-100',
                'icon_text' => 'text-orange-700',
                'title' => 'Course Update',
                'description' => $draftCoursesCount === 1
                    ? '1 draft course is waiting to be published.'
                    : $draftCoursesCount.' draft courses are waiting to be published.',
                'href' => '/instructor/mycourse',
            ] : null,
            $recentReviews->count() > 0 ? [
                'icon' => 'star',
                'icon_bg' => 'bg-emerald-100',
                'icon_text' => 'text-emerald-700',
                'title' => 'Review latest feedback',
                'description' => $recentReviews->count().' recent student review'.($recentReviews->count() > 1 ? 's' : '').' need attention.',
                'href' => '/instructor/reviews',
            ] : null,
            $unreviewedCoursesCount > 0 ? [
                'icon' => 'library_books',
                'icon_bg' => 'bg-indigo-100',
                'icon_text' => 'text-indigo-700',
                'title' => 'Boost course engagement',
                'description' => $unreviewedCoursesCount.' course'.($unreviewedCoursesCount > 1 ? 's have' : ' has').' no reviews yet.',
                'href' => '/instructor/mycourse',
            ] : null,
        ])->filter()->take(2)->values();

        if ($recommendedActions->isEmpty()) {
            $recommendedActions = collect([
                [
                    'icon' => 'add_circle',
                    'icon_bg' => 'bg-indigo-100',
                    'icon_text' => 'text-indigo-700',
                    'title' => 'Create your next course',
                    'description' => 'Keep your catalog growing with a new publishing-ready course.',
                    'href' => '/instructor/create-course',
                ],
            ]);
        }

        $bestCourse = Course::query()
            ->whereIn('id', $courseIds)
            ->withCount([
                'enrollments as completed_enrollments_count' => fn ($query) => $query->where('status', 'completed'),
            ])
            ->orderByDesc('completed_enrollments_count')
            ->orderByDesc('created_at')
            ->first();

        return view('instructor.dashboard', [
            'instructor' => $instructor,
            'welcomeName' => Str::of($instructor->name)->trim()->explode(' ')->first() ?: 'Instructor',
            'profileAvatar' => $instructor->avatarUrl(96),
            'totalRevenue' => $this->formatCurrency($totalRevenue),
            'totalRevenueTrend' => $this->formatTrend($totalRevenue, $previousRevenue),
            'totalStudents' => $this->formatCompactNumber($totalStudents),
            'totalStudentsTrend' => $this->formatTrend($currentMonthStudents, $previousMonthStudents),
            'totalCourses' => $this->formatCompactNumber($totalCourses),
            'totalCoursesTrend' => $this->formatCourseTrend($currentMonthCourses, $previousMonthCourses, $publishedCourses),
            'monthlyEarnings' => $this->formatCurrency($monthlyEarnings),
            'monthlyEarningsTrend' => $this->formatTrend($monthlyEarnings, $previousMonthlyEarnings),
            'chartPath' => $this->generateChartPath($chartValues),
            'peakPoint' => $peakPoint,
            'peakRevenue' => $this->formatCurrency($peakRevenue),
            'peakCourseTitle' => $peakCourse?->title ?: 'No course sales yet',
            'averageOrderValue' => $this->formatCurrency($averageOrderValue),
            'refundRate' => number_format($refundRate, 1).'%',
            'conversionRate' => number_format($conversionRate, 1).'%',
            'activeSubscriptions' => $this->formatCompactNumber($activeSubscriptions),
            'studentGrowthCount' => $this->formatCompactNumber($currentMonthStudents),
            'studentGrowthTrend' => $this->formatTrend($currentMonthStudents, $previousMonthStudents, false, 'this month'),
            'studentGrowthWidth' => min(100, max(8, $totalStudents > 0 ? ($currentMonthStudents / max($totalStudents, 1)) * 100 : 12)),
            'studentGrowthMessage' => $totalStudents > 0
                ? 'Your courses are actively attracting students. Keep the momentum going with fresh updates.'
                : 'Your dashboard is ready. Publish and promote your courses to start building momentum.',
            'recommendedActions' => $recommendedActions,
            'recentEnrollments' => $recentEnrollments,
            'recentReviews' => $recentReviews,
            'insightMessage' => $bestCourse
                ? $bestCourse->title.' is leading your catalog with '.$bestCourse->completed_enrollments_count.' enrollment'.($bestCourse->completed_enrollments_count === 1 ? '' : 's').'.'
                : 'Publish your first course to begin tracking performance insights here.',
            'peakRevenueDateLabel' => $peakRevenueDay && $peakRevenue > 0
                ? Carbon::parse($peakRevenueDay['date'])->format('M d')
                : 'No peak day yet',
        ]);
    }

    private function buildDailyRevenue(Collection $courseIds, Carbon $start, Carbon $end): array
    {
        $grouped = Payment::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as payment_date, SUM(amount) as total')
            ->groupBy('payment_date')
            ->pluck('total', 'payment_date');

        $points = [];

        foreach (CarbonPeriod::create($start, '1 day', $end) as $day) {
            $date = $day->format('Y-m-d');
            $points[] = [
                'date' => $date,
                'amount' => (float) ($grouped[$date] ?? 0),
            ];
        }

        return $points;
    }

    private function generateChartPath(Collection $values): string
    {
        if ($values->isEmpty() || $values->max() <= 0) {
            return 'M0 160 L200 140 L400 110 L600 80 L800 60';
        }

        $max = (float) $values->max();
        $count = max($values->count() - 1, 1);

        return $values->values()->map(function ($value, $index) use ($max, $count) {
            $x = (800 / $count) * $index;
            $normalized = $max > 0 ? ($value / $max) : 0;
            $y = 160 - ($normalized * 120);

            return ($index === 0 ? 'M' : 'L').round($x, 2).' '.round($y, 2);
        })->implode(' ');
    }

    private function buildChartPoints(array $dailyRevenue): array
    {
        $values = collect($dailyRevenue)->pluck('amount')->values();

        if ($values->isEmpty()) {
            return [];
        }

        $max = (float) max($values->max(), 1);
        $count = max($values->count() - 1, 1);

        return collect($dailyRevenue)->values()->map(function (array $point, int $index) use ($max, $count) {
            $x = round((800 / $count) * $index, 2);
            $normalized = $max > 0 ? ($point['amount'] / $max) : 0;
            $y = round(160 - ($normalized * 120), 2);

            return [
                'x' => $x,
                'y' => $y,
                'amount' => $point['amount'],
                'amount_label' => $this->formatCurrency((float) $point['amount']),
                'date_label' => Carbon::parse($point['date'])->format('d M Y'),
            ];
        })->all();
    }

    private function formatCurrency(float $amount): string
    {
        return 'Rs. '.number_format($amount, 2);
    }

    private function formatCompactNumber(int|float $number): string
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1).'m';
        }

        if ($number >= 1000) {
            return number_format($number / 1000, 1).'k';
        }

        return (string) (int) $number;
    }

    private function formatTrend(float|int $current, float|int $previous, bool $showIcon = true, string $suffix = ''): array
    {
        if ($current == 0 && $previous == 0) {
            return [
                'label' => 'New',
                'positive' => false,
                'icon' => $showIcon ? 'trending_up' : null,
                'suffix' => $suffix,
            ];
        }

        if ($previous <= 0) {
            return [
                'label' => '+100%',
                'positive' => true,
                'icon' => $showIcon ? 'trending_up' : null,
                'suffix' => $suffix,
            ];
        }

        $change = (($current - $previous) / $previous) * 100;

        if (abs($change) < 0.05) {
            return [
                'label' => 'Steady',
                'positive' => false,
                'icon' => null,
                'suffix' => $suffix,
            ];
        }

        return [
            'label' => ($change > 0 ? '+' : '').round($change).'%',
            'positive' => $change >= 0,
            'icon' => $showIcon ? ($change >= 0 ? 'trending_up' : 'trending_down') : null,
            'suffix' => $suffix,
        ];
    }

    private function formatCourseTrend(int $currentMonthCourses, int $previousMonthCourses, int $publishedCourses): array
    {
        if ($currentMonthCourses === 0 && $previousMonthCourses === 0) {
            return [
                'label' => $publishedCourses > 0 ? $publishedCourses.' published' : 'Steady',
                'positive' => false,
                'icon' => null,
            ];
        }

        return $this->formatTrend($currentMonthCourses, $previousMonthCourses);
    }

}


