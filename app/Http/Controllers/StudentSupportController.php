<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentSupportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $search = trim((string) $request->query('search', ''));
        $status = match ($request->query('status')) {
            'resolved' => 'resolved',
            'open' => 'pending',
            default => 'all',
        };

        $inquiries = Inquiry::query()
            ->where('user_id', $student->id)
            ->with('course:id,title')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nested) use ($search) {
                    $nested->where('message', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhereHas('course', fn ($courseQuery) => $courseQuery->where('title', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->get();

        $activeInquiry = $inquiries->firstWhere('id', $request->integer('inquiry'));

        if (! $activeInquiry) {
            $activeInquiry = $inquiries->first();
        }

        $courses = Course::query()
            ->whereHas('enrollments', fn ($query) => $query->where('user_id', $student->id)->where('status', 'completed'))
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('student.support', [
            'studentAvatar' => $student->avatarUrl(96),
            'search' => $search,
            'statusFilter' => $request->query('status', 'all'),
            'inquiries' => $inquiries,
            'activeInquiry' => $activeInquiry,
            'courses' => $courses,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $student = $request->user();

        $validated = $request->validate([
            'course_id' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'course_id.required' => 'Choose a course for this ticket.',
            'message.required' => 'Write your support message before sending.',
        ]);

        $ownedCourse = Course::query()
            ->where('id', $validated['course_id'])
            ->whereHas('enrollments', fn ($query) => $query->where('user_id', $student->id)->where('status', 'completed'))
            ->exists();

        abort_unless($ownedCourse, 403);

        $inquiry = Inquiry::create([
            'user_id' => $student->id,
            'course_id' => $validated['course_id'],
            'name' => $student->name,
            'email' => $student->email,
            'phone' => null,
            'message' => $validated['message'],
            'status' => 'pending',
            'admin_reply' => null,
        ]);

        return redirect()
            ->route('student.support', ['inquiry' => $inquiry->id])
            ->with('status', 'Support ticket created successfully.');
    }
}
