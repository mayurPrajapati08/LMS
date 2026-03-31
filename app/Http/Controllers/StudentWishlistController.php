<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentWishlistController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $search = trim((string) $request->query('search', ''));

        $wishlistItems = Wishlist::query()
            ->where('user_id', $student->id)
            ->with([
                'course' => fn ($query) => $query
                    ->with(['user:id,name'])
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->when($search !== '', function ($courseQuery) use ($search) {
                        $courseQuery->where(function ($nested) use ($search) {
                            $nested->where('title', 'like', "%{$search}%")
                                ->orWhere('details', 'like', "%{$search}%")
                                ->orWhere('language', 'like', "%{$search}%")
                                ->orWhere('level', 'like', "%{$search}%");
                        });
                    }),
            ])
            ->latest()
            ->get()
            ->filter(fn ($wishlist) => $wishlist->course !== null)
            ->values();

        $wishlistCourseIds = $wishlistItems->pluck('course_id')->all();
        $recommendations = Course::query()
            ->where('status', 'published')
            ->whereNotIn('id', $wishlistCourseIds)
            ->with(['user:id,name'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest('updated_at')
            ->limit(2)
            ->get();

        $totalValue = $wishlistItems->sum(fn ($item) => (float) ($item->course->price ?? 0));
        $topCategory = $wishlistItems
            ->map(fn ($item) => $item->course->category?->name)
            ->filter()
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first();

        return view('student.wishlist', [
            'studentAvatar' => $student->avatarUrl(96),
            'search' => $search,
            'wishlistItems' => $wishlistItems,
            'wishlistCount' => $wishlistItems->count(),
            'wishlistValue' => $this->formatCurrency($totalValue),
            'topCategory' => $topCategory,
            'recommendations' => $recommendations,
        ]);
    }

    public function destroy(Request $request, Wishlist $wishlist): RedirectResponse
    {
        abort_unless($wishlist->user_id === $request->user()->id, 403);

        $wishlist->delete();

        return back()->with('status', 'Course removed from wishlist.');
    }

    public function toggle(Request $request, Course $course): RedirectResponse
    {
        abort_unless($course->status === 'published', 404);

        $existingWishlist = Wishlist::query()
            ->where('user_id', $request->user()->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingWishlist) {
            $existingWishlist->delete();

            return back()->with('status', 'Course removed from wishlist.');
        }

        $wishlist = new Wishlist();
        $wishlist->user_id = $request->user()->id;
        $wishlist->course_id = $course->id;
        $wishlist->save();

        return back()->with('status', 'Course saved to wishlist.');
    }

    private function formatCurrency(float $amount): string
    {
        return 'Rs. '.number_format($amount, 2);
    }
}
