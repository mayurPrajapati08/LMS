<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\DeleteAdminRequest;
use App\Http\Requests\Admin\ReplyInquiryRequest;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\StoreInstructorRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\UpdatePlatformSettingsRequest;
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
use App\Support\AuditLogger;
use App\Support\CloudflareR2Storage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
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
            $statusMeta = $this->resolveInstructorDirectoryStatus($instructor);
            $instructor->setAttribute('directory_status', $statusMeta['key']);
            $instructor->setAttribute('directory_status_label', $statusMeta['label']);
            $instructor->setAttribute('directory_status_classes', $statusMeta['classes']);
            $instructor->setAttribute('directory_status_hint', $statusMeta['hint']);

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

    public function storeInstructor(StoreInstructorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $role = Role::query()->firstOrCreate(['name' => 'instructor']);
        $temporaryPassword = $this->provisionedPassword();

        $instructor = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $temporaryPassword,
            'bio' => $validated['bio'] ?? null,
            'role_id' => $role->id,
        ]);

        SendAccountCredentialsMail::dispatchAfterResponse(
            $validated['name'],
            $validated['email'],
            'Instructor',
            route('login'),
            route('password.request')
        );

        Log::info('Instructor account created by admin', [
            'admin_id' => $request->user()->id,
            'admin_email' => $request->user()->email,
            'instructor_email' => $validated['email'],
        ]);
        AuditLogger::record('instructor.created', $request, $instructor, [
            'email' => $instructor->email,
        ]);

        return redirect()
            ->route('admin.instructors')
            ->with('status', 'Instructor account created successfully. A secure setup email has been sent.');
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

    public function replySupport(ReplyInquiryRequest $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validated();

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
            'catalog_default_mode' => 'offline',
            'catalog_online_enabled' => '0',
            'catalog_offline_enabled' => '1',
            'online_student_access_mode' => 'disabled',
            'student_catalog_enabled' => '0',
            'student_wishlist_enabled' => '0',
            'student_cart_enabled' => '0',
            'student_checkout_enabled' => '0',
            'student_payments_enabled' => '0',
            'public_lead_gate_enabled' => '1',
            'workshop_lead_gate_enabled' => '1',
            'email_from_name' => 'Code In Yourself',
            'email_from_address' => 'noreply@codeinyourself.in',
            'email_support_address' => 'support@codeinyourself.in',
            'exception_alert_email' => 'support@codeinyourself.in',
            'notification_new_enrollment' => '1',
            'notification_new_review' => '1',
            'notification_support_alerts' => '1',
            'notification_daily_digest' => '0',
                'integration_cloudinary_folder' => (string) config('services.cloudflare_r2.avatar_folder', 'lms/avatars'),
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
        $adminUser = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$adminUser->id],
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
            $payload['avatar_path'] = $this->uploadAvatarToR2(
                $request->file('avatar'),
                $adminUser->id,
                $validated['name']
            );
        }

        $adminUser->update($payload);

        Log::info('Admin profile updated', [
            'admin_id' => $adminUser->id,
            'admin_email' => $adminUser->email,
            'two_factor_enabled' => $payload['two_factor_enabled'],
        ]);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Admin profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $adminUser = $request->user();
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', $this->passwordRule()],
        ]);

        if (! Hash::check($validated['current_password'], $adminUser->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $adminUser->update([
            'password' => $validated['password'],
        ]);

        Log::warning('Admin password updated', [
            'admin_id' => $adminUser->id,
            'admin_email' => $adminUser->email,
        ]);

        return redirect()
            ->route('admin.settings')
            ->with('status', 'Admin password updated successfully.');
    }

    public function updatePlatformSettings(UpdatePlatformSettingsRequest $request): RedirectResponse
    {
        $section = (string) $request->input('section');
        $rules = $request->rules();
        abort_if($rules === [], 404);
        $validated = $request->validated();
        $settingKeys = array_values(array_diff(array_keys($rules), ['current_password']));
        $booleanFields = [
            'payment_stripe_enabled',
            'payment_razorpay_enabled',
            'payment_manual_enabled',
            'catalog_online_enabled',
            'catalog_offline_enabled',
            'student_catalog_enabled',
            'student_wishlist_enabled',
            'student_cart_enabled',
            'student_checkout_enabled',
            'student_payments_enabled',
            'public_lead_gate_enabled',
            'workshop_lead_gate_enabled',
            'notification_new_enrollment',
            'notification_new_review',
            'notification_support_alerts',
            'notification_daily_digest',
        ];

        if ($section === 'catalog' && ! $request->boolean('catalog_online_enabled') && ($validated['online_student_access_mode'] ?? 'disabled') === 'disabled') {
            $validated['student_catalog_enabled'] = false;
            $validated['student_wishlist_enabled'] = false;
            $validated['student_cart_enabled'] = false;
            $validated['student_checkout_enabled'] = false;
            $validated['student_payments_enabled'] = false;
        }

        foreach ($settingKeys as $key) {
            $value = in_array($key, $booleanFields, true)
                ? ($request->boolean($key) ? '1' : '0')
                : (string) ($validated[$key] ?? '');

            AppSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Log::info('Platform settings updated', [
            'section' => $section,
            'admin_id' => $request->user()->id,
            'admin_email' => $request->user()->email,
        ]);
        AuditLogger::record('platform.settings.updated', $request, AppSetting::class, [
            'section' => $section,
            'keys' => $settingKeys,
        ]);

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
            ->whereHas('role', fn ($query) => $query->whereIn('name', ['super admin', 'admin', 'hr team']))
            ->with('role:id,name')
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $editingAdmin = null;
        if ($request->filled('edit')) {
            $editingAdmin = User::query()
                ->whereHas('role', fn ($query) => $query->whereIn('name', ['super admin', 'admin', 'hr team']))
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
            'hrTeamCount' => User::query()->whereHas('role', fn ($query) => $query->where('name', 'hr team'))->count(),
        ]);
    }

    public function storeAdmin(StoreAdminRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $role = Role::query()->firstOrCreate(['name' => $validated['role']]);
        $temporaryPassword = $this->provisionedPassword();

        $createdAdmin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $temporaryPassword,
            'role_id' => $role->id,
        ]);

        SendAccountCredentialsMail::dispatchAfterResponse(
            $validated['name'],
            $validated['email'],
            match ($validated['role']) {
                'super admin' => 'Super Admin',
                'hr team' => 'HR Team',
                default => 'Admin',
            },
            route('login'),
            route('password.request')
        );

        Log::warning('Privileged account created', [
            'created_by_id' => $request->user()->id,
            'created_by_email' => $request->user()->email,
            'role' => $validated['role'],
            'account_email' => $validated['email'],
        ]);
        AuditLogger::record('admin.created', $request, $createdAdmin, [
            'role' => $validated['role'],
            'email' => $createdAdmin->email,
        ]);

        return redirect()
            ->route('admin.admins')
            ->with('status', 'New admin account created successfully. A secure setup email has been sent.');
    }

    public function updateAdmin(UpdateAdminRequest $request, User $managedAdmin): RedirectResponse
    {
        $validated = $request->validated();

        $role = Role::query()->firstOrCreate(['name' => $validated['role']]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $role->id,
        ];

        $managedAdmin->update($payload);

        Log::warning('Privileged account updated', [
            'updated_by_id' => $request->user()->id,
            'updated_by_email' => $request->user()->email,
            'account_id' => $managedAdmin->id,
            'account_email' => $managedAdmin->email,
            'role' => $validated['role'],
        ]);
        AuditLogger::record('admin.updated', $request, $managedAdmin, [
            'role' => $validated['role'],
            'email' => $managedAdmin->email,
        ]);

        return redirect()
            ->route('admin.admins')
            ->with('status', 'Admin account updated successfully.');
    }

    public function destroyAdmin(DeleteAdminRequest $request, User $managedAdmin): RedirectResponse
    {
        Log::warning('Privileged account removed', [
            'removed_by_id' => $request->user()->id,
            'removed_by_email' => $request->user()->email,
            'account_id' => $managedAdmin->id,
            'account_email' => $managedAdmin->email,
            'role' => $managedAdmin->role?->name,
        ]);
        AuditLogger::record('admin.deleted', $request, $managedAdmin, [
            'role' => $managedAdmin->role?->name,
            'email' => $managedAdmin->email,
        ]);

        $managedAdmin->delete();

        return redirect()
            ->route('admin.admins')
            ->with('status', 'Admin account removed successfully.');
    }

    private function uploadAvatarToR2($file, int $userId, string $name): string
    {
        $folder = trim((string) config('services.cloudflare_r2.avatar_folder', 'lms/avatars'), '/');
        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: 'jpg'));
        $path = $folder.'/admin-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar.'.$extension;

        return CloudflareR2Storage::uploadPublicFile($file, $path, [
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
            'allowed_mime_types' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
            'max_bytes' => 5 * 1024 * 1024,
        ]);
    }

    private function provisionedPassword(): string
    {
        return Str::password(32);
    }

    private function passwordRule(): Password
    {
        return Password::min(10)
            ->mixedCase()
            ->numbers()
            ->symbols();
    }

    private function resolveInstructorDirectoryStatus(User $instructor): array
    {
        if (! $instructor->last_login_at) {
            return [
                'key' => 'pending',
                'label' => 'Pending',
                'classes' => 'bg-amber-50 text-amber-700',
                'hint' => 'Has not logged in yet',
            ];
        }

        $daysSinceLogin = (int) $instructor->last_login_at->diffInDays(now());

        if ($daysSinceLogin <= 30) {
            return [
                'key' => 'active',
                'label' => 'Active',
                'classes' => 'bg-emerald-50 text-emerald-700',
                'hint' => 'Recently active',
            ];
        }

        if ($daysSinceLogin <= 60) {
            return [
                'key' => 'inactive',
                'label' => 'Inactive',
                'classes' => 'bg-slate-100 text-slate-700',
                'hint' => 'No login in the last 30 days',
            ];
        }

        return [
            'key' => 'unavailable',
            'label' => 'Unavailable',
            'classes' => 'bg-rose-50 text-rose-700',
            'hint' => 'No login in more than 60 days',
        ];
    }
}
