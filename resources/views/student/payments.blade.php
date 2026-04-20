<x-student.layout title="Payments | CodeInYourself">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Billing Archive</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">Payments</p>
    </div>
    <x-slot:center>
        <form action="{{ route('student.payments') }}" method="GET">
            <label class="student-top-search">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input name="search" placeholder="Search transactions or courses" type="text" value="{{ $search }}" />
            </label>
        </form>
    </x-slot:center>
    <x-slot:right>
        <img alt="Student Profile" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $studentAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Billing Archive</p>
                <h1 class="student-page-title">Payments</h1>
                <p class="student-page-copy">A clearer billing workspace with simpler scanning, cleaner receipt flow, and compact financial summaries.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $completedCount }} completed</span>
                <span class="student-chip">{{ $activeCourses }} active courses</span>
                <span class="student-chip">{{ $lifetimeInvestment }} lifetime spend</span>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">Completed</p>
                        <p class="student-stat-value">{{ $completedCount }}</p>
                        <p class="student-stat-copy">Successful payments</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Active Courses</p>
                        <p class="student-stat-value">{{ $activeCourses }}</p>
                        <p class="student-stat-copy">Currently unlocked</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Lifetime Spend</p>
                        <p class="student-stat-value">{{ $lifetimeInvestment }}</p>
                        <p class="student-stat-copy">Total investment</p>
                    </div>
                </div>
            </div>
            <div class="student-side-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Wallet Summary</p>
                <div class="mt-6 grid gap-4">
                    <div class="rounded-[1rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] p-5 text-white">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/60">Lifetime Investment</p>
                        <p class="mt-3 font-headline text-4xl font-extrabold">{{ $lifetimeInvestment }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-[1.3rem] bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Active</p>
                            <p class="mt-3 font-headline text-3xl font-extrabold">{{ $activeCourses }}</p>
                        </div>
                        <div class="rounded-[1.3rem] bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Renewals</p>
                            <p class="mt-3 font-headline text-3xl font-extrabold">{{ $pendingRenewals }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] bg-surface-container-lowest overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-outline-variant/15 px-5 py-5 md:px-8">
                <div>
                    <h2 class="font-headline text-2xl font-extrabold text-on-surface">Transactions</h2>
                    <p class="mt-1 text-sm text-on-surface-variant">Clear table view for course payments and receipts.</p>
                </div>
                <div class="flex gap-2">
                    <span class="student-chip">{{ $completedCount }} completed</span>
                    @if ($search !== '')
                        <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.payments') }}">Clear Search</a>
                    @endif
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant md:px-8">Course / Product</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant md:px-8">Amount</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant md:px-8">Date</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant md:px-8">Status</th>
                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant md:px-8">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse ($payments as $payment)
                            @php
                                $statusStyles = match ($payment->status) {
                                    'completed' => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
                                    'pending' => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                                    default => 'bg-error-container text-on-error-container',
                                };
                                $statusDot = match ($payment->status) {
                                    'completed' => 'bg-tertiary',
                                    'pending' => 'bg-secondary',
                                    default => 'bg-error',
                                };
                                $icon = match ($payment->payment_getway) {
                                    'razorpay' => 'payments',
                                    default => 'account_balance_wallet',
                                };
                            @endphp
                            <tr>
                                <td class="px-5 py-5 md:px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-[1rem] bg-primary-fixed text-primary">
                                            <span class="material-symbols-outlined">{{ $icon }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-on-surface">{{ $payment->course?->title ?: 'Course purchase' }}</p>
                                            <p class="mt-1 text-xs uppercase tracking-[0.1em] text-on-surface-variant">{{ $payment->payment_getway }} | {{ $payment->payment_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 text-sm font-semibold text-on-surface md:px-8">Rs. {{ number_format((float) $payment->amount, 2) }}</td>
                                <td class="px-5 py-5 text-sm text-on-surface-variant md:px-8">{{ optional($payment->created_at)->format('M d, Y') }}</td>
                                <td class="px-5 py-5 md:px-8">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold {{ $statusStyles }}"><span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>{{ ucfirst($payment->status) }}</span>
                                </td>
                                <td class="px-5 py-5 text-right md:px-8">
                                    <button @class([
                                        'rounded-lg p-2 transition-all',
                                        'text-primary hover:bg-primary-fixed' => $payment->status === 'completed',
                                        'cursor-not-allowed text-slate-300' => $payment->status !== 'completed',
                                    ]) type="button">
                                        <span class="material-symbols-outlined text-xl">{{ $payment->status === 'completed' ? 'description' : 'pending' }}</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-5 py-10 text-center text-on-surface-variant md:px-8" colspan="5">No payments found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t border-outline-variant/15 px-5 py-4 md:px-8">
                <p class="text-xs text-on-surface-variant">Showing {{ $payments->count() }} of {{ $payments->total() }} transactions</p>
                <div>{{ $payments->onEachSide(1)->links() }}</div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2">
            <div class="rounded-[1.75rem] bg-surface-container-lowest p-6">
                <h3 class="font-headline text-2xl font-extrabold text-on-surface">Payment Methods</h3>
                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between rounded-[1.25rem] bg-surface-container-low p-4">
                        <div class="flex items-center gap-4">
                            <div class="flex h-9 w-14 items-center justify-center rounded bg-on-surface text-[10px] font-bold italic text-white">UPI</div>
                            <div>
                                <p class="text-sm font-semibold text-on-surface">Primary checkout method</p>
                                <p class="text-[10px] uppercase tracking-[0.14em] text-on-surface-variant">Saved locally for demo flow</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-tertiary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-on-tertiary-fixed-variant">Default</span>
                    </div>
                    <div class="flex items-center justify-between rounded-[1.25rem] bg-surface-container-low p-4">
                        <div class="flex items-center gap-4">
                            <div class="flex h-9 w-14 items-center justify-center rounded bg-blue-600 text-[10px] font-bold italic text-white">CARD</div>
                            <div>
                                <p class="text-sm font-semibold text-on-surface">More methods coming next</p>
                                <p class="text-[10px] uppercase tracking-[0.14em] text-on-surface-variant">Stripe / Razorpay ready</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">schedule</span>
                    </div>
                </div>
            </div>

            <div class="student-side-card">
                <h3 class="font-headline text-2xl font-extrabold text-on-surface">Billing Question?</h3>
                <p class="mt-4 text-sm leading-7 text-on-surface-variant">Our student support team typically responds within 2 hours for payment-related inquiries.</p>
                <a class="student-pill-button student-pill-button--primary mt-8" href="{{ route('student.support') }}">Contact Billing Support</a>
            </div>
        </section>
    </div>
</main>
</x-student.layout>
