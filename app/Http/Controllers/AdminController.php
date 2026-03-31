<?php

namespace App\Http\Controllers;

use App\Jobs\SendAccountCredentialsMail;
use App\Models\AppSetting;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Inquiry;
use App\Models\Payment;
use App\Models\PublicContact;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $admin = $request->user();
        $completedPayments = Payment::query()->where('status', 'completed');

        $months = collect(CarbonPeriod::create(
            now()->copy()->subMonths(11)->startOfMonth(),
            '1 month',
            now()->copy()->startOfMonth()
        ))->values();

        $revenueByMonth = (clone $completedPayments)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-01') as month_key, SUM(amount) as total")
            ->where('created_at', '>=', now()->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month_key')
            ->pluck('total', 'month_key');

        $maxRevenue = max(1, (float) $revenueByMonth->max());

        $monthlyRevenue = $months->map(function (Carbon $month) use ($revenueByMonth, $maxRevenue) {
            $monthKey = $month->format('Y-m-01');
            $amount = (float) ($revenueByMonth[$monthKey] ?? 0);

            return [
                'label' => $month->format('M y'),
                'amount' => $amount,
                'height' => max(16, (int) round(($amount / $maxRevenue) * 100)),
                'is_peak' => $amount === $maxRevenue && $amount > 0,
            ];
        });

        $enrollmentMonths = collect(CarbonPeriod::create(
            now()->copy()->subMonths(3)->startOfMonth(),
            '1 month',
            now()->copy()->startOfMonth()
        ))->values()
            ->map(function (Carbon $month) {
                $count = Enrollment::query()
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();

                return [
                    'label' => $month->format('M y'),
                    'count' => $count,
                ];
            });

        $maxEnrollments = max(1, (int) $enrollmentMonths->max('count'));
        $enrollmentMonths = $enrollmentMonths->map(fn (array $item) => $item + [
            'width' => max(16, (int) round(($item['count'] / $maxEnrollments) * 100)),
        ]);

        $topCourses = Course::query()
            ->with(['user:id,name'])
            ->withCount('enrollments')
            ->withSum(['payments as completed_revenue' => fn ($query) => $query->where('status', 'completed')], 'amount')
            ->orderByDesc('completed_revenue')
            ->take(3)
            ->get();

        $recentEnrollments = Enrollment::query()
            ->with(['user:id,name,email,avatar_path', 'course:id,title'])
            ->latest()
            ->take(3)
            ->get();

        $recentPayments = Payment::query()
            ->with('user:id,name')
            ->latest()
            ->take(3)
            ->get();

        $topCategory = Category::query()
            ->withCount('courses')
            ->get()
            ->map(function (Category $category) {
                $category->setAttribute(
                    'category_enrollment_count',
                    Enrollment::query()->whereIn('course_id', $category->courses()->pluck('id'))->count()
                );

                return $category;
            })
            ->sortByDesc('category_enrollment_count')
            ->first();

        return view('admin.dashboard', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'totalUsers' => User::query()->whereHas('role', fn ($query) => $query->where('name', 'user'))->count(),
            'totalInstructors' => User::query()->whereHas('role', fn ($query) => $query->where('name', 'instructor'))->count(),
            'totalCourses' => Course::count(),
            'totalRevenue' => (float) $completedPayments->sum('amount'),
            'monthlyRevenue' => $monthlyRevenue,
            'enrollmentMonths' => $enrollmentMonths,
            'topCourses' => $topCourses,
            'recentEnrollments' => $recentEnrollments,
            'recentPayments' => $recentPayments,
            'insightTitle' => $topCategory?->name ? 'Highest demand category' : 'Growth opportunity',
            'insightText' => $topCategory?->name
                ? "{$topCategory->name} is attracting the most student activity right now. Expanding mentor coverage there can reduce support load and speed up new launches."
                : 'Published-course activity is still building. Once more enrollments arrive, this panel will start surfacing the strongest growth opportunity.',
        ]);
    }

    public function courses(Request $request): View
    {
        $admin = $request->user();
        $search = trim((string) $request->query('search'));
        $status = trim((string) $request->query('status'));
        $categoryId = $request->integer('category');

        $courses = Course::query()
            ->with(['user:id,name', 'category:id,name'])
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->withSum(['payments as completed_revenue' => fn ($query) => $query->where('status', 'completed')], 'amount')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('id', $search);
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('admin.courses', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'courses' => $courses,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'filters' => compact('search', 'status', 'categoryId'),
            'inventoryCount' => Course::count(),
            'averageRating' => round((float) Review::query()->avg('rating'), 1),
            'revenueEstimate' => (float) Payment::query()->where('status', 'completed')->sum('amount'),
        ]);
    }

    public function users(Request $request): View
    {
        $admin = $request->user();
        $search = trim((string) $request->query('search'));
        $status = trim((string) $request->query('status'));
        $joined = trim((string) $request->query('joined', '30'));

        $studentQuery = User::query()
            ->whereHas('role', fn ($query) => $query->where('name', 'user'))
            ->withCount('enrollments')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('id', $search);
                });
            });

        if ($status === 'active') {
            $studentQuery->where(function ($query) {
                $query->where('updated_at', '>=', now()->subDays(60))
                    ->orWhereHas('enrollments');
            });
        } elseif ($status === 'inactive') {
            $studentQuery->where('updated_at', '<', now()->subDays(60))
                ->whereDoesntHave('enrollments');
        }

        if ($joined === '30') {
            $studentQuery->where('created_at', '>=', now()->subDays(30));
        } elseif ($joined === '180') {
            $studentQuery->where('created_at', '>=', now()->subDays(180));
        }

        $users = $studentQuery
            ->orderByDesc('created_at')
            ->paginate(8)
            ->withQueryString();

        $progressRows = DB::table('course_progress')
            ->selectRaw('user_id, AVG(CASE WHEN is_completed = 1 THEN 100 ELSE 0 END) as average_progress')
            ->groupBy('user_id')
            ->pluck('average_progress', 'user_id');

        $users->getCollection()->transform(function (User $user) use ($progressRows) {
            $progressAverage = round((float) ($progressRows[$user->id] ?? 0));
            $derivedStatus = ($user->updated_at && $user->updated_at->gte(now()->subDays(60))) || $user->enrollments_count > 0
                ? 'active'
                : 'inactive';

            $user->setAttribute('progress_average', $progressAverage);
            $user->setAttribute('derived_status', $derivedStatus);

            return $user;
        });

        $studentCount = User::query()->whereHas('role', fn ($query) => $query->where('name', 'user'))->count();
        $activeLearners = User::query()
            ->whereHas('role', fn ($query) => $query->where('name', 'user'))
            ->where('updated_at', '>=', now()->subDays(60))
            ->count();

        return view('admin.users', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'users' => $users,
            'filters' => compact('search', 'status', 'joined'),
            'studentCount' => $studentCount,
            'activeLearners' => $activeLearners,
            'completionRate' => round((float) DB::table('course_progress')->avg(DB::raw('CASE WHEN is_completed = 1 THEN 100 ELSE 0 END')), 1),
        ]);
    }

    public function instructors(Request $request): View
    {
        $admin = $request->user();
        $instructors = User::query()
            ->whereHas('role', fn ($query) => $query->where('name', 'instructor'))
            ->withCount('courses')
            ->withAvg('reviews as average_rating', 'rating')
            ->orderByDesc('created_at')
            ->paginate(8)
            ->withQueryString();

        $earnings = Payment::query()
            ->join('courses', 'courses.id', '=', 'payments.course_id')
            ->selectRaw('courses.user_id, SUM(payments.amount) as total')
            ->where('payments.status', 'completed')
            ->groupBy('courses.user_id')
            ->pluck('total', 'courses.user_id');

        $instructors->getCollection()->transform(function (User $instructor) use ($earnings) {
            $instructor->setAttribute('total_earnings', (float) ($earnings[$instructor->id] ?? 0));

            $status = 'pending';
            if ($instructor->courses_count > 0) {
                $publishedCourses = $instructor->courses()->where('status', 'published')->count();
                $status = $publishedCourses > 0 ? 'active' : 'pending';
            }

            $instructor->setAttribute('directory_status', $status);

            return $instructor;
        });

        $verificationRate = $instructors->total() > 0
            ? round(($instructors->getCollection()->where('directory_status', 'active')->count() / max(1, $instructors->count())) * 100, 1)
            : 0;

        return view('admin.instructors', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'instructors' => $instructors,
            'totalInstructors' => User::query()->whereHas('role', fn ($query) => $query->where('name', 'instructor'))->count(),
            'platformPayouts' => (float) Payment::query()->where('status', 'completed')->sum('amount'),
            'verificationRate' => $verificationRate,
            'showInvitePanel' => $request->boolean('invite') || session()->has('errors'),
        ]);
    }

    public function storeInstructor(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $role = Role::query()->where('name', 'instructor')->firstOrFail();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'bio' => $validated['bio'] ?? null,
            'role_id' => $role->id,
        ]);

        SendAccountCredentialsMail::dispatchAfterResponse(
            $validated['name'],
            $validated['email'],
            $validated['password'],
            'Instructor',
            route('login')
        );

        return redirect()
            ->route('admin.instructors')
            ->with('status', 'Instructor account created successfully.');
    }

    public function payments(Request $request): View
    {
        $admin = $request->user();
        $status = trim((string) $request->query('status'));
        $gateway = trim((string) $request->query('gateway'));

        $payments = Payment::query()
            ->with(['user:id,name,email', 'course:id,title'])
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($gateway !== '', fn ($query) => $query->where('payment_getway', $gateway))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $completed = Payment::query()->where('status', 'completed');
        $successCount = $completed->count();
        $allCount = max(1, Payment::count());

        return view('admin.payments', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'payments' => $payments,
            'filters' => compact('status', 'gateway'),
            'totalRevenue' => (float) $completed->sum('amount'),
            'successfulPayments' => $successCount,
            'successRate' => round(($successCount / $allCount) * 100, 1),
            'refundRate' => round((Payment::query()->where('status', 'failed')->count() / $allCount) * 100, 1),
        ]);
    }

    public function analytics(Request $request): View
    {
        $admin = $request->user();
        $completedPayments = Payment::query()->where('status', 'completed');
        $monthlyRevenue = (float) (clone $completedPayments)
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('amount');
        $lastMonthRevenue = (float) (clone $completedPayments)
            ->whereBetween('created_at', [now()->copy()->subMonth()->startOfMonth(), now()->copy()->subMonth()->endOfMonth()])
            ->sum('amount');

        $activeLearners = Enrollment::query()
            ->where('status', 'completed')
            ->distinct('user_id')
            ->count('user_id');

        $monthlyEnrollments = max(1, Enrollment::query()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count());
        $monthlyVisitors = max($monthlyEnrollments, Course::query()->where('status', 'published')->count() * 12);
        $conversionRate = round(($monthlyEnrollments / $monthlyVisitors) * 100, 2);

        $userRetention = round((Course::query()->where('status', 'published')->whereHas('enrollments')->count() / max(1, Course::where('status', 'published')->count())) * 100, 1);

        $categoryPerformance = Category::query()
            ->withCount(['courses as course_count'])
            ->get()
            ->map(function (Category $category) {
                $categoryCourseIds = $category->courses()->pluck('id');
                $enrollments = Enrollment::query()->whereIn('course_id', $categoryCourseIds)->count();
                $score = min(100, $enrollments > 0 ? round(($enrollments / max(1, $category->course_count * 5)) * 100) : 0);

                return [
                    'name' => $category->name,
                    'score' => $score,
                ];
            })
            ->sortByDesc('score')
            ->take(4)
            ->values();

        $topSellingCourses = Course::query()
            ->with('user:id,name')
            ->withCount('enrollments')
            ->withSum(['payments as completed_revenue' => fn ($query) => $query->where('status', 'completed')], 'amount')
            ->orderByDesc('completed_revenue')
            ->take(3)
            ->get();

        return view('admin.analytics', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'monthlyRevenue' => $monthlyRevenue,
            'revenueChange' => $lastMonthRevenue > 0 ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0,
            'activeLearners' => $activeLearners,
            'conversionRate' => $conversionRate,
            'userRetention' => $userRetention,
            'categoryPerformance' => $categoryPerformance,
            'topSellingCourses' => $topSellingCourses,
            'trafficSources' => [
                ['label' => 'Direct', 'value' => 45, 'class' => 'bg-primary'],
                ['label' => 'Organic Search', 'value' => 25, 'class' => 'bg-tertiary'],
                ['label' => 'Referrals', 'value' => 30, 'class' => 'bg-secondary'],
            ],
        ]);
    }

    public function reviews(Request $request): View
    {
        $admin = $request->user();
        $reviews = Review::query()
            ->with(['user:id,name,avatar_path', 'course:id,title'])
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $featuredReviewId = (int) Review::query()->orderByDesc('rating')->orderByDesc('created_at')->value('id');

        return view('admin.reviews', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'reviews' => $reviews,
            'totalReviews' => Review::count(),
            'averageRating' => round((float) Review::avg('rating'), 1),
            'ratingBreakdown' => collect([5, 4, 3, 2, 1])->mapWithKeys(fn (int $rating) => [$rating => Review::query()->where('rating', $rating)->count()]),
            'featuredReviewId' => $featuredReviewId,
        ]);
    }

    public function support(Request $request): View
    {
        $admin = $request->user();
        $ticketType = trim((string) $request->query('type'));
        $inquiries = Inquiry::query()
            ->with(['user:id,name,email,avatar_path', 'course:id,title'])
            ->when($ticketType === 'technical', fn ($query) => $query->where('message', 'like', '%video%')->orWhere('message', 'like', '%quiz%'))
            ->when($ticketType === 'billing', fn ($query) => $query->where('message', 'like', '%refund%')->orWhere('message', 'like', '%payment%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $activeInquiry = null;
        if ($request->filled('inquiry')) {
            $activeInquiry = Inquiry::query()
                ->with(['user:id,name,email,avatar_path', 'course:id,title'])
                ->find($request->integer('inquiry'));
        }

        if (! $activeInquiry) {
            $activeInquiry = Inquiry::query()
                ->with(['user:id,name,email,avatar_path', 'course:id,title'])
                ->latest()
                ->first();
        }

        return view('admin.support', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'inquiries' => $inquiries,
            'activeInquiry' => $activeInquiry,
            'openTickets' => Inquiry::query()->where('status', 'pending')->count(),
            'resolvedTickets' => Inquiry::query()->where('status', 'resolved')->where('updated_at', '>=', now()->subWeek())->count(),
            'avgResponseHours' => 2.4,
            'activeChats' => Inquiry::query()->where('status', 'pending')->count(),
        ]);
    }

    public function replySupport(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'max:5000'],
            'status' => ['nullable', 'in:pending,resolved'],
        ]);

        $inquiry->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => $validated['status'] ?? 'resolved',
        ]);

        return redirect()
            ->route('admin.support', ['inquiry' => $inquiry->id])
            ->with('status', 'Inquiry reply saved successfully.');
    }

    public function settings(Request $request): View
    {
        $storedSettings = AppSetting::query()
            ->pluck('value', 'key')
            ->all();

        $platformSettings = array_merge([
            'institution_name' => 'Code In Yourself',
            'institution_email' => 'support@codeinyourself.in',
            'institution_phone' => '+91 98765 43210',
            'institution_address' => 'Ahmedabad, Gujarat, India',
            'institution_timezone' => 'Asia/Calcutta',
            'institution_tagline' => 'Admin workspace synced with live platform data',
            'payment_currency' => 'INR',
            'payment_tax_rate' => '18',
            'payment_stripe_enabled' => '1',
            'payment_razorpay_enabled' => '1',
            'payment_manual_enabled' => '0',
            'email_from_name' => 'Code In Yourself',
            'email_from_address' => 'noreply@codeinyourself.in',
            'email_support_address' => 'support@codeinyourself.in',
            'notification_new_enrollment' => '1',
            'notification_new_review' => '1',
            'notification_support_alerts' => '1',
            'notification_daily_digest' => '0',
            'integration_cloudinary_folder' => (string) config('services.cloudinary.avatar_folder', 'lms/admin-avatars'),
            'integration_razorpay_key' => (string) config('services.razorpay.key_id', ''),
            'integration_app_url' => (string) config('app.url'),
            'integration_webhook_secret' => '',
        ], $storedSettings);

        return view('admin.settings', [
            'admin' => $request->user(),
            'profileAvatar' => $request->user()->avatarUrl(160),
            'platformSettings' => $platformSettings,
            'activeTab' => (string) $request->query('tab', 'profile'),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:5120'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'] ?? null,
            'two_factor_enabled' => $request->boolean('two_factor_enabled'),
        ];

        if ($request->hasFile('avatar')) {
            $payload['avatar_path'] = $this->uploadAvatarToCloudinary(
                $request->file('avatar'),
                $request->user()->id,
                $validated['name']
            );
        }

        $request->user()->update($payload);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Admin profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (! Hash::check($validated['current_password'], $request->user()->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Admin password updated successfully.');
    }

    public function updatePlatformSettings(Request $request): RedirectResponse
    {
        $section = (string) $request->input('section');

        $rules = match ($section) {
            'institution' => [
                'institution_name' => ['required', 'string', 'max:255'],
                'institution_email' => ['required', 'email', 'max:255'],
                'institution_phone' => ['nullable', 'string', 'max:50'],
                'institution_address' => ['nullable', 'string', 'max:255'],
                'institution_timezone' => ['required', 'string', 'max:100'],
                'institution_tagline' => ['nullable', 'string', 'max:255'],
            ],
            'payments' => [
                'payment_currency' => ['required', 'string', 'max:10'],
                'payment_tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'payment_stripe_enabled' => ['nullable', 'boolean'],
                'payment_razorpay_enabled' => ['nullable', 'boolean'],
                'payment_manual_enabled' => ['nullable', 'boolean'],
            ],
            'notifications' => [
                'email_from_name' => ['required', 'string', 'max:255'],
                'email_from_address' => ['required', 'email', 'max:255'],
                'email_support_address' => ['required', 'email', 'max:255'],
                'notification_new_enrollment' => ['nullable', 'boolean'],
                'notification_new_review' => ['nullable', 'boolean'],
                'notification_support_alerts' => ['nullable', 'boolean'],
                'notification_daily_digest' => ['nullable', 'boolean'],
            ],
            'integrations' => [
                'integration_cloudinary_folder' => ['nullable', 'string', 'max:255'],
                'integration_razorpay_key' => ['nullable', 'string', 'max:255'],
                'integration_app_url' => ['nullable', 'string', 'max:255'],
                'integration_webhook_secret' => ['nullable', 'string', 'max:255'],
            ],
            default => [],
        };

        abort_if($rules === [], 404);

        $validated = $request->validate($rules);
        $booleanFields = [
            'payment_stripe_enabled',
            'payment_razorpay_enabled',
            'payment_manual_enabled',
            'notification_new_enrollment',
            'notification_new_review',
            'notification_support_alerts',
            'notification_daily_digest',
        ];

        foreach ($rules as $key => $unused) {
            $value = in_array($key, $booleanFields, true)
                ? ($request->boolean($key) ? '1' : '0')
                : (string) ($validated[$key] ?? '');

            AppSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings', ['tab' => $section])
            ->with('status', 'Platform settings updated successfully.');
    }

    public function categories(Request $request): View
    {
        $admin = $request->user();
        $categories = Category::query()
            ->withCount('courses')
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $editingCategory = null;
        if ($request->filled('edit')) {
            $editingCategory = Category::find($request->integer('edit'));
        }

        return view('admin.categories', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'categories' => $categories,
            'activeCategoryCount' => Category::count(),
            'growthPercent' => 12,
            'editingCategory' => $editingCategory,
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        Category::create([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('status', 'Category created successfully.');
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$category->id],
        ]);

        $category->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('status', 'Category updated successfully.');
    }

    public function destroyCategory(Category $category): RedirectResponse
    {
        if ($category->courses()->exists()) {
            return redirect()
                ->route('admin.categories')
                ->withErrors(['category' => 'Delete or move the courses in this category before removing it.']);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories')
            ->with('status', 'Category removed successfully.');
    }

    public function admins(Request $request): View
    {
        abort_unless($request->user()->role?->name === 'super admin', 403);

        $admin = $request->user();
        $admins = User::query()
            ->whereHas('role', fn ($query) => $query->whereIn('name', ['super admin', 'admin']))
            ->with('role:id,name')
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $editingAdmin = null;
        if ($request->filled('edit')) {
            $editingAdmin = User::query()
                ->whereHas('role', fn ($query) => $query->whereIn('name', ['super admin', 'admin']))
                ->with('role:id,name')
                ->find($request->integer('edit'));
        }

        return view('admin.manage_admins', [
            'admin' => $admin,
            'profileAvatar' => $admin->avatarUrl(96),
            'admins' => $admins,
            'editingAdmin' => $editingAdmin,
            'adminCount' => User::query()->whereHas('role', fn ($query) => $query->where('name', 'admin'))->count(),
            'superAdminCount' => User::query()->whereHas('role', fn ($query) => $query->where('name', 'super admin'))->count(),
        ]);
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        abort_unless($request->user()->role?->name === 'super admin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:admin,super admin'],
        ]);

        $role = Role::query()->where('name', $validated['role'])->firstOrFail();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role_id' => $role->id,
        ]);

        SendAccountCredentialsMail::dispatchAfterResponse(
            $validated['name'],
            $validated['email'],
            $validated['password'],
            $validated['role'] === 'super admin' ? 'Super Admin' : 'Admin',
            route('login')
        );

        return redirect()
            ->route('admin.admins')
            ->with('status', 'New admin account created successfully.');
    }

    public function updateAdmin(Request $request, User $managedAdmin): RedirectResponse
    {
        abort_unless($request->user()->role?->name === 'super admin', 403);
        abort_unless(in_array($managedAdmin->role?->name, ['admin', 'super admin'], true), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$managedAdmin->id],
            'role' => ['required', 'in:admin,super admin'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $role = Role::query()->where('name', $validated['role'])->firstOrFail();

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $role->id,
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = $validated['password'];
        }

        $managedAdmin->update($payload);

        return redirect()
            ->route('admin.admins')
            ->with('status', 'Admin account updated successfully.');
    }

    public function destroyAdmin(Request $request, User $managedAdmin): RedirectResponse
    {
        abort_unless($request->user()->role?->name === 'super admin', 403);
        abort_unless(in_array($managedAdmin->role?->name, ['admin', 'super admin'], true), 404);

        if ($request->user()->is($managedAdmin)) {
            return redirect()
                ->route('admin.admins')
                ->withErrors(['admin' => 'You cannot remove the account you are currently using.']);
        }

        $managedAdmin->delete();

        return redirect()
            ->route('admin.admins')
            ->with('status', 'Admin account removed successfully.');
    }

    private function uploadAvatarToCloudinary($file, int $userId, string $name): string
    {
        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');
        $folder = (string) config('services.cloudinary.avatar_folder', 'lms/admin-avatars');

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary is not configured. Add Cloudinary credentials to continue.');
        }

        $timestamp = time();
        $publicId = 'admin-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar';
        $signature = sha1("folder={$folder}&public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");

        $response = Http::timeout(60)
            ->attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'folder' => $folder,
                'public_id' => $publicId,
                'signature' => $signature,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Avatar upload failed. Please try again.');
        }

        $secureUrl = $response->json('secure_url');

        if (! is_string($secureUrl) || $secureUrl === '') {
            throw new RuntimeException('Cloudinary did not return a valid avatar URL.');
        }

        return $secureUrl;
    }
}
