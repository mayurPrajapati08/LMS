<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentCartController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $cartItems = CartItem::query()
            ->where('user_id', $student->id)
            ->with([
                'course' => fn ($query) => $query
                    ->where('status', 'published')
                    ->with(['user:id,name,avatar_path', 'category:id,name'])
                    ->withAvg('reviews', 'rating')
                    ->withCount(['reviews', 'enrollments as students_count']),
            ])
            ->latest()
            ->get()
            ->filter(fn (CartItem $item) => $item->course !== null)
            ->values();

        $subtotal = (float) $cartItems->sum(fn (CartItem $item) => (float) ($item->course->price ?? 0));

        return view('student.cart', [
            'student' => $student,
            'profileAvatar' => $student->avatarUrl(96),
            'cartItems' => $cartItems,
            'cartCount' => $cartItems->count(),
            'cartSubtotal' => $subtotal,
            'cartTotal' => $subtotal,
            'checkoutUrl' => route('student.checkout', ['cart' => 1]),
            'browseUrl' => route('student.browse-courses'),
        ]);
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        abort_unless($course->status === 'published', 404);

        $student = $request->user();
        $alreadyEnrolled = $student->enrollments()
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('status', 'You already own this course.');
        }

        CartItem::query()->firstOrCreate([
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);

        return back()->with('status', 'Course added to cart.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $cartItem->delete();

        return back()->with('status', 'Course removed from cart.');
    }
}
