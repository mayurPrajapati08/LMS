<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Payments | The Scholarly Editorial</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#58579b",
                        "surface-tint": "#4d44e3",
                        "inverse-on-surface": "#f0f1f2",
                        "secondary-fixed": "#e2dfff",
                        "on-primary-fixed": "#0f0069",
                        "error-container": "#ffdad6",
                        "tertiary": "#005523",
                        "tertiary-container": "#007030",
                        "on-secondary-fixed-variant": "#413f82",
                        "tertiary-fixed": "#6bff8f",
                        "secondary-fixed-dim": "#c3c0ff",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#3323cc",
                        "error": "#ba1a1a",
                        "surface-container-low": "#f3f4f5",
                        "secondary-container": "#b6b4ff",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#c3c0ff",
                        "outline-variant": "#c7c4d8",
                        "on-surface": "#191c1d",
                        "surface-dim": "#d9dadb",
                        "on-secondary-fixed": "#140f54",
                        "inverse-primary": "#c3c0ff",
                        "on-surface-variant": "#464555",
                        "tertiary-fixed-dim": "#4ae176",
                        "on-primary-container": "#dad7ff",
                        "inverse-surface": "#2e3132",
                        "outline": "#777587",
                        "primary-container": "#4f46e5",
                        "on-background": "#191c1d",
                        "surface-container-high": "#e7e8e9",
                        "surface-container": "#edeeef",
                        "on-tertiary-fixed-variant": "#005321",
                        "primary-fixed": "#e2dfff",
                        "surface-bright": "#f8f9fa",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-container": "#63f889",
                        "surface-container-highest": "#e1e3e4",
                        "on-error-container": "#93000a",
                        "background": "#f8f9fa",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#3525cd",
                        "on-secondary-container": "#454386",
                        "surface-variant": "#e1e3e4",
                        "on-secondary": "#ffffff",
                        "surface": "#f8f9fa"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3 {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>

<body class="bg-background text-on-surface">
    <x-student.navbar />

    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 shadow-sm dark:shadow-none">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-headline font-bold text-on-surface">Payment History</h2>
        </div>
        <div class="ml-auto flex items-center gap-4 md:gap-6">
            <form action="{{ route('student.payments') }}" class="relative flex items-center bg-surface-container-low px-3 md:px-4 py-2 rounded-xl focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none md:w-auto" method="GET">
                <span class="material-symbols-outlined text-slate-400 text-sm mr-2" data-icon="search">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-sm w-full md:w-64 text-on-surface" name="search" placeholder="Search..." type="text" value="{{ $search }}" />
            </form>
            <button class="p-2 text-slate-500 hover:bg-surface-container-high rounded-full transition-all relative" type="button">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <img alt="Student Profile" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $studentAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-24 md:pt-24 p-4 md:p-8 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-8">
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 md:col-span-7 bg-primary-container text-on-primary-container p-4 md:p-8 rounded-xl shadow-lg relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="relative z-10">
                        <p class="font-label text-sm opacity-80 uppercase tracking-widest mb-1">Lifetime Investment</p>
                        <h3 class="text-4xl font-headline font-extrabold">{{ $lifetimeInvestment }}</h3>
                    </div>
                    <div class="relative z-10 flex gap-4 mt-8">
                        <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg">
                            <p class="text-[10px] opacity-70 uppercase tracking-tighter">Active Courses</p>
                            <p class="font-bold">{{ $activeCourses }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg">
                            <p class="text-[10px] opacity-70 uppercase tracking-tighter">Pending Renewals</p>
                            <p class="font-bold">{{ $pendingRenewals }}</p>
                        </div>
                    </div>
                    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute right-8 top-8 opacity-20">
                        <span class="material-symbols-outlined text-8xl" data-icon="account_balance_wallet">account_balance_wallet</span>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-5 bg-surface-container-lowest p-4 md:p-8 rounded-xl flex flex-col justify-center space-y-4">
                    <h4 class="font-headline font-bold text-on-surface">Need a receipt?</h4>
                    <p class="text-on-surface-variant text-sm leading-relaxed">Download detailed tax invoices for all your completed transactions in one click.</p>
                    <button class="bg-surface-container-high text-primary font-semibold py-3 px-6 rounded-xl hover:bg-surface-container-highest transition-all flex items-center justify-center gap-2" type="button">
                        <span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                        Bulk Download PDF
                    </button>
                </div>
            </div>

            <section class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
                <div class="px-4 md:px-8 py-6 border-b border-outline-variant/15 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-headline font-bold text-on-surface">Recent Transactions</h3>
                        <p class="text-xs text-on-surface-variant mt-1">Showing history from your account</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="bg-surface-container-low text-on-surface-variant text-xs font-semibold px-4 py-2 rounded-lg">{{ $completedCount }} completed</span>
                        @if ($search !== '')
                            <a class="bg-surface-container-low text-on-surface-variant text-xs font-semibold px-4 py-2 rounded-lg hover:border-outline-variant/30 transition-all" href="{{ route('student.payments') }}">Clear Search</a>
                        @endif
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-4 md:px-8 py-4 text-xs font-label font-bold text-on-surface-variant uppercase tracking-wider">Course / Product</th>
                                <th class="px-4 md:px-8 py-4 text-xs font-label font-bold text-on-surface-variant uppercase tracking-wider">Amount</th>
                                <th class="px-4 md:px-8 py-4 text-xs font-label font-bold text-on-surface-variant uppercase tracking-wider">Date</th>
                                <th class="px-4 md:px-8 py-4 text-xs font-label font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                                <th class="px-4 md:px-8 py-4 text-xs font-label font-bold text-on-surface-variant uppercase tracking-wider text-right">Invoice</th>
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
                                <tr class="hover:bg-surface-container-low/30 transition-colors group">
                                    <td class="px-4 md:px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-primary">
                                                <span class="material-symbols-outlined" data-icon="{{ $icon }}">{{ $icon }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-on-surface">{{ $payment->course?->title ?: 'Course purchase' }}</p>
                                                <p class="text-xs text-on-surface-variant uppercase">{{ $payment->payment_getway }} | {{ $payment->payment_id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 md:px-8 py-5 text-sm font-medium text-on-surface">Rs. {{ number_format((float) $payment->amount, 2) }}</td>
                                    <td class="px-4 md:px-8 py-5 text-sm text-on-surface-variant">{{ optional($payment->created_at)->format('M d, Y') }}</td>
                                    <td class="px-4 md:px-8 py-5">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold {{ $statusStyles }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 md:px-8 py-5 text-right">
                                        <button @class([
                                            'p-2 rounded-lg transition-all',
                                            'text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50' => $payment->status === 'completed',
                                            'text-slate-300 cursor-not-allowed' => $payment->status !== 'completed',
                                        ]) type="button">
                                            <span class="material-symbols-outlined text-xl" data-icon="{{ $payment->status === 'completed' ? 'description' : 'pending' }}">{{ $payment->status === 'completed' ? 'description' : 'pending' }}</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 md:px-8 py-10 text-center text-on-surface-variant" colspan="5">
                                        No payments found yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 md:px-8 py-4 bg-surface-container-low/20 flex items-center justify-between border-t border-outline-variant/15">
                    <p class="text-xs text-on-surface-variant">Showing {{ $payments->count() }} of {{ $payments->total() }} transactions</p>
                    <div>
                        {{ $payments->onEachSide(1)->links() }}
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-surface-container-lowest p-4 md:p-8 rounded-xl space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-headline font-bold text-on-surface">Payment Methods</h3>
                        <button class="text-primary text-sm font-bold flex items-center gap-1" type="button">
                            <span class="material-symbols-outlined text-lg" data-icon="add_circle">add_circle</span>
                            Add New
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl border border-outline-variant/10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-8 bg-on-surface rounded flex items-center justify-center text-white font-bold italic text-[10px]">UPI</div>
                                <div>
                                    <p class="text-sm font-semibold text-on-surface">Primary checkout method</p>
                                    <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter">Saved locally for demo flow</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-tertiary-container text-on-tertiary-container text-[10px] font-bold">DEFAULT</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-surface-container-low/50 rounded-xl border border-outline-variant/5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold italic text-[10px]">CARD</div>
                                <div>
                                    <p class="text-sm font-semibold text-on-surface">More methods coming next</p>
                                    <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter">Stripe / Razorpay ready</p>
                                </div>
                            </div>
                            <span class="text-slate-400">
                                <span class="material-symbols-outlined text-sm" data-icon="schedule">schedule</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/10 p-4 md:p-8 rounded-xl flex items-start gap-6 border-l-4 border-indigo-500">
                    <div class="bg-indigo-100 dark:bg-indigo-800 p-3 rounded-xl text-indigo-600 dark:text-indigo-300">
                        <span class="material-symbols-outlined text-2xl" data-icon="live_help">live_help</span>
                    </div>
                    <div>
                        <h4 class="font-headline font-bold text-on-surface mb-2">Billing Question?</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed mb-4">Our dedicated student support team typically responds within 2 hours for payment-related inquiries.</p>
                        <a class="text-primary font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all" href="/student/messages-support">
                            Contact Billing Support
                            <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-8 right-8 max-w-sm bg-white/80 dark:bg-slate-900/80 backdrop-blur-md p-4 rounded-xl shadow-2xl flex gap-4 border-l-4 border-tertiary z-50">
        <div class="text-tertiary">
            <span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
        </div>
        <div>
            <p class="text-xs font-bold text-on-surface">Payment Snapshot</p>
            <p class="text-[11px] text-on-surface-variant">You have {{ $completedCount }} completed transaction{{ $completedCount === 1 ? '' : 's' }} in your account history.</p>
        </div>
        <button class="ml-auto text-slate-400" onclick="this.parentElement.remove()" type="button">
            <span class="material-symbols-outlined text-sm" data-icon="close">close</span>
        </button>
    </div>
</body>

</html>
