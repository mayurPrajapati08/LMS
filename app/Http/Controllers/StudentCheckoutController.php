<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class StudentCheckoutController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $student = $request->user();
        $courseId = (int) $request->query('course');
        $useCart = $request->boolean('cart');
        $courses = $this->resolveCheckoutCourses($student->id, $courseId, $useCart);

        if ($courses->isEmpty()) {
            return redirect()
                ->route('student.cart')
                ->with('status', 'Your cart is empty right now.');
        }

        if ($courses->count() === 1) {
            $singleCourse = $courses->first();
            $alreadyEnrolled = Enrollment::query()
                ->where('user_id', $student->id)
                ->where('course_id', $singleCourse->id)
                ->where('status', 'completed')
                ->exists();

            if ($alreadyEnrolled) {
                return redirect()
                    ->route('student.course-player', ['course' => $singleCourse->id])
                    ->with('status', 'You already own this course.');
            }
        }

        $razorpayKey = (string) config('services.razorpay.key_id');
        $razorpayConfigured = $razorpayKey !== '' && (string) config('services.razorpay.key_secret') !== '';
        $checkoutAmount = (float) $courses->sum(fn (Course $course) => (float) $course->price);
        $orderPayload = null;
        $checkoutError = null;

        if ($razorpayConfigured && $checkoutAmount > 0) {
            try {
                $orderPayload = $this->createRazorpayOrder($student->id, $courses, $checkoutAmount);
            } catch (RuntimeException|RequestException $exception) {
                $checkoutError = $exception->getMessage();
            }
        }

        $primaryCourse = $courses->first();

        return view('student.checkout', [
            'student' => $student,
            'profileAvatar' => $student->avatarUrl(96),
            'course' => $primaryCourse,
            'checkoutCourses' => $courses,
            'isCartCheckout' => $useCart || $courses->count() > 1,
            'checkoutAmount' => $checkoutAmount,
            'checkoutAmountPaise' => (int) round($checkoutAmount * 100),
            'rating' => round((float) ($primaryCourse->reviews_avg_rating ?? 0), 1),
            'reviewsCount' => (int) $primaryCourse->reviews_count,
            'studentsCount' => (int) $primaryCourse->students_count,
            'razorpayKey' => $razorpayKey,
            'razorpayConfigured' => $razorpayConfigured,
            'razorpayOrder' => $orderPayload,
            'checkoutError' => $checkoutError,
            'successUrl' => route('student.checkout.verify'),
            'freeEnrollUrl' => route('student.checkout.free'),
            'courseIds' => $courses->pluck('id')->all(),
            'browseUrl' => route('student.browse-courses'),
            'cartUrl' => route('student.cart'),
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'course_ids' => ['required', 'array', 'min:1'],
            'course_ids.*' => ['integer'],
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        $courses = Course::query()
            ->whereIn('id', $validated['course_ids'])
            ->where('status', 'published')
            ->get();

        abort_if($courses->isEmpty(), 404);

        $secret = (string) config('services.razorpay.key_secret');
        abort_if($secret === '', 422, 'Razorpay is not configured.');

        $generatedSignature = hash_hmac(
            'sha256',
            $validated['razorpay_order_id'].'|'.$validated['razorpay_payment_id'],
            $secret
        );

        if (! hash_equals($generatedSignature, $validated['razorpay_signature'])) {
            return back()->withErrors([
                'checkout' => 'Payment verification failed. Please try again.',
            ]);
        }

        DB::transaction(function () use ($student, $courses, $validated) {
            foreach ($courses as $course) {
                $payment = Payment::query()->firstOrCreate(
                    ['payment_id' => $validated['razorpay_payment_id'].'-course-'.$course->id],
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                        'payment_getway' => 'razorpay',
                        'amount' => (float) $course->price,
                        'status' => 'completed',
                    ]
                );

                if ($payment->status !== 'completed') {
                    $payment->status = 'completed';
                    $payment->amount = (float) $course->price;
                    $payment->save();
                }

                Enrollment::query()->updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'payment_table_id' => $payment->id,
                        'amount' => (float) $course->price,
                        'status' => 'completed',
                        'enrolled_at' => now(),
                        'expiry_date' => $course->validity_in_days
                            ? now()->addDays((int) $course->validity_in_days)
                            : null,
                    ]
                );
            }

            CartItem::query()
                ->where('user_id', $student->id)
                ->whereIn('course_id', $courses->pluck('id'))
                ->delete();
        });

        return redirect()
            ->route('student.my-learning')
            ->with('status', $courses->count() > 1
                ? 'Payment successful. Your selected courses are now unlocked.'
                : 'Payment successful. Your course is now unlocked.');
    }

    public function freeEnroll(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'course_ids' => ['required', 'array', 'min:1'],
            'course_ids.*' => ['integer'],
        ]);

        $courses = Course::query()
            ->whereIn('id', $validated['course_ids'])
            ->where('status', 'published')
            ->get();

        abort_if($courses->isEmpty(), 404);
        abort_if($courses->contains(fn (Course $course) => (float) $course->price > 0), 422, 'One or more selected courses require payment before enrollment.');

        DB::transaction(function () use ($student, $courses) {
            foreach ($courses as $course) {
                $payment = Payment::query()->firstOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                        'payment_id' => 'free-course-'.$course->id.'-user-'.$student->id,
                    ],
                    [
                        'payment_getway' => 'razorpay',
                        'amount' => 0,
                        'status' => 'completed',
                    ]
                );

                Enrollment::query()->updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'payment_table_id' => $payment->id,
                        'amount' => 0,
                        'status' => 'completed',
                        'enrolled_at' => now(),
                        'expiry_date' => $course->validity_in_days
                            ? now()->addDays((int) $course->validity_in_days)
                            : null,
                    ]
                );
            }

            CartItem::query()
                ->where('user_id', $student->id)
                ->whereIn('course_id', $courses->pluck('id'))
                ->delete();
        });

        return redirect()
            ->route('student.my-learning')
            ->with('status', $courses->count() > 1 ? 'Selected free courses unlocked successfully.' : 'Course unlocked successfully.');
    }

    private function createRazorpayOrder(int $studentId, $courses, float $amount): array
    {
        $keyId = (string) config('services.razorpay.key_id');
        $keySecret = (string) config('services.razorpay.key_secret');

        if ($keyId === '' || $keySecret === '') {
            throw new RuntimeException('Razorpay keys are missing.');
        }

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->timeout(30)
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => (int) round($amount * 100),
                'currency' => 'INR',
                'receipt' => 'cart-user-'.$studentId.'-'.Str::lower(Str::random(6)),
                'notes' => [
                    'course_ids' => $courses->pluck('id')->implode(','),
                    'user_id' => (string) $studentId,
                ],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Unable to start Razorpay checkout right now. Please verify your Razorpay keys and try again.');
        }

        $payload = $response->json();

        if (! is_array($payload) || empty($payload['id'])) {
            throw new RuntimeException('Razorpay did not return a valid order.');
        }

        return $payload;
    }

    private function resolveCheckoutCourses(int $studentId, int $courseId, bool $useCart)
    {
        if ($useCart || $courseId <= 0) {
            $cartCourseIds = CartItem::query()
                ->where('user_id', $studentId)
                ->pluck('course_id');

            return Course::query()
                ->whereIn('id', $cartCourseIds)
                ->where('status', 'published')
                ->with(['user:id,name,avatar_path', 'category:id,name'])
                ->withCount(['reviews', 'enrollments as students_count'])
                ->withAvg('reviews', 'rating')
                ->get();
        }

        return Course::query()
            ->where('status', 'published')
            ->with(['user:id,name,avatar_path', 'category:id,name'])
            ->withCount(['reviews', 'enrollments as students_count'])
            ->withAvg('reviews', 'rating')
            ->whereKey($courseId)
            ->get();
    }
}
