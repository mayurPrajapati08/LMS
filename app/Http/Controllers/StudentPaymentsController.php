<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentPaymentsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $search = trim((string) $request->query('search', ''));

        $payments = Payment::query()
            ->where('user_id', $student->id)
            ->with(['course:id,title,price'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nested) use ($search) {
                    $nested->where('payment_id', 'like', "%{$search}%")
                        ->orWhere('payment_getway', 'like', "%{$search}%")
                        ->orWhereHas('course', fn ($courseQuery) => $courseQuery->where('title', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $allPayments = Payment::query()->where('user_id', $student->id);
        $completedPayments = Payment::query()->where('user_id', $student->id)->where('status', 'completed');

        $lifetimeInvestment = (float) (clone $completedPayments)->sum('amount');
        $activeCourses = (clone $completedPayments)->distinct('course_id')->count('course_id');
        $pendingRenewals = (clone $allPayments)->where('status', 'pending')->count();
        $completedCount = (clone $completedPayments)->count();

        return view('student.payments', [
            'studentAvatar' => $student->avatarUrl(96),
            'search' => $search,
            'payments' => $payments,
            'lifetimeInvestment' => $this->formatCurrency($lifetimeInvestment),
            'activeCourses' => $activeCourses,
            'pendingRenewals' => $pendingRenewals,
            'completedCount' => $completedCount,
        ]);
    }

    private function formatCurrency(float $amount): string
    {
        return 'Rs. '.number_format($amount, 2);
    }
}
