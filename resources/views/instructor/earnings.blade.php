<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Earnings</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#b07ac3",
                        "outline-variant": "#dbcde4",
                        "secondary-container": "#eadcf1",
                        "background": "#fcf9fe",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#6d5a76",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#8f7a99",
                        "on-secondary-fixed-variant": "#755b83",
                        "on-primary-fixed-variant": "#8f52a3",
                        "surface-tint": "#b07ac3",
                        "on-primary-container": "#f5eef8",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f5fbff",
                        "primary": "#6a3378",
                        "surface-bright": "#fcf9fe",
                        "secondary-fixed": "#f0e6f4",
                        "primary-fixed-dim": "#e1cde8",
                        "primary-fixed": "#f0e6f4",
                        "error": "#ba1a1a",
                        "surface-variant": "#e7dcef",
                        "secondary-fixed-dim": "#e1cde8",
                        "surface": "#fcf9fe",
                        "on-error": "#ffffff",
                        "surface-container-high": "#efe5f4",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#e7dcef",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#f5eef8",
                        "secondary": "#3b5f8d",
                        "inverse-surface": "#563060",
                        "surface-container": "#f2e9f6",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#e1cde8",
                        "surface-dim": "#d4e3f8",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#715f7a",
                        "on-secondary-fixed": "#4b2356"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; background: #fcf9fe; color: #191c1d; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .editorial-shadow { box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 w-full pl-16 pr-4 md:px-8 py-4 bg-white/88 backdrop-blur-md border-b border-[#eadff1] flex justify-between items-center shadow-sm">
            <div>
                <h1 class="font-headline text-3xl font-bold tracking-tight text-slate-900">Earnings</h1>
                <p class="mt-1 text-sm text-slate-500">Revenue, transactions, and payout-ready performance.</p>
            </div>
            <div class="flex items-center gap-6">
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <img alt="Instructor Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#eadff1]" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
            <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f5eef8] text-[#6a3378]">
                            <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                        <span class="text-sm font-semibold {{ $totalRevenueTrend['positive'] ? 'text-emerald-600' : 'text-slate-500' }}">{{ $totalRevenueTrend['label'] }}</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-[0.16em]">Total Revenue</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">{{ $totalRevenue }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">This month</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-[0.16em]">Available to Withdraw</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">{{ $availableToWithdraw }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">students</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-[0.16em]">Active Students</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">{{ $activeStudents }}</p>
                </div>
                <div class="rounded-[24px] bg-gradient-to-br from-slate-950 via-[#4d255f] to-[#8f52a3] p-6 text-white editorial-shadow">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                        <span class="material-symbols-outlined">auto_graph</span>
                    </div>
                    <p class="mt-5 text-sm font-medium uppercase tracking-[0.16em] text-[#eadff1]">Estimated Yearly</p>
                    <p class="mt-2 font-headline text-3xl font-bold">{{ $estimatedYearlyRevenue }}</p>
                </div>
            </section>

            <section class="grid gap-8 xl:grid-cols-[1.35fr_0.85fr]">
                <div class="rounded-[28px] bg-white p-6 md:p-8 border border-slate-200 editorial-shadow">
                    <div class="flex items-start justify-between gap-6 mb-8">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#6a3378]">Revenue Performance</p>
                            <h2 class="mt-2 font-headline text-2xl font-bold text-slate-900">Last 6 months</h2>
                        </div>
                        <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700">
                            Avg order: {{ $averageOrderValue }}
                        </div>
                    </div>
                    <div class="relative">
                        <svg class="w-full h-64" viewBox="0 0 640 220" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="earningsGradient" x1="0%" x2="0%" y1="0%" y2="100%">
                                    <stop offset="0%" stop-color="rgba(79,70,229,0.22)"></stop>
                                    <stop offset="100%" stop-color="rgba(79,70,229,0)"></stop>
                                </linearGradient>
                            </defs>
                            <path d="{{ $revenueChartPath }} L640 220 L0 220 Z" fill="url(#earningsGradient)"></path>
                            <path d="{{ $revenueChartPath }}" fill="none" stroke="#6a3378" stroke-linecap="round" stroke-width="4"></path>
                        </svg>
                        <div class="mt-4 grid grid-cols-6 gap-2 text-center text-xs font-semibold text-slate-500">
                            @foreach($monthlyRevenueData as $point)
                                <span>{{ $point['label'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 border border-slate-200 editorial-shadow">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#6a3378]">Top Earner</p>
                        <h3 class="mt-3 font-headline text-2xl font-bold text-slate-900">{{ $topCourseTitle }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">This is currently your best-performing course by completed revenue.</p>
                        <div class="mt-6 rounded-2xl bg-[#f5eef8] px-5 py-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#6a3378]">Revenue</p>
                            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $topCourseRevenue }}</p>
                        </div>
                    </div>
                    <div class="rounded-[28px] bg-gradient-to-br from-emerald-700 to-emerald-600 p-6 text-white shadow-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-100">Transaction Health</p>
                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ $completedTransactions }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.16em] text-emerald-100/80">Completed</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ $pendingTransactions }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.16em] text-emerald-100/80">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[28px] bg-white border border-slate-200 overflow-hidden editorial-shadow">
                <div class="px-6 md:px-8 py-6 border-b border-slate-200">
                    <h3 class="font-headline text-2xl font-bold text-slate-900">Recent Transactions</h3>
                    <p class="mt-2 text-sm text-slate-500">Latest instructor-side payments across your courses.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[840px] text-left">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 md:px-8 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Course</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Date</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Amount</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Gateway</th>
                                <th class="px-6 md:px-8 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 md:px-8 py-5 font-semibold text-slate-900">{{ $transaction->course?->title ?? 'Deleted course' }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-500">{{ $transaction->created_at?->format('M d, Y') }}</td>
                                    <td class="px-6 py-5 font-bold text-slate-900">Rs. {{ number_format((float) $transaction->amount, 2) }}</td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600">{{ ucfirst($transaction->payment_getway) }}</td>
                                    <td class="px-6 md:px-8 py-5">
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] {{ $transaction->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                            <span class="w-2 h-2 rounded-full {{ $transaction->status === 'completed' ? 'bg-emerald-500' : ($transaction->status === 'pending' ? 'bg-amber-500' : 'bg-red-500') }}"></span>
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 md:px-8 py-16 text-center text-sm text-slate-500" colspan="5">No transactions available yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>



