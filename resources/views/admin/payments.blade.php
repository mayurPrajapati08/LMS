<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself - Financial Transactions</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#6a3378",
                        "background": "#fcf9fe",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f5eef8",
                        "surface-container-high": "#efe5f4",
                        "surface-container-highest": "#e7dcef",
                        "on-surface": "#191c1d",
                        "outline-variant": "#dbcde4",
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        .admin-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
            padding-right: 3rem;
            min-width: 8.75rem;
        }
    </style>
</head>
<body class="bg-background text-on-surface antialiased">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
        <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-slate-50 border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-[#f5eef8]/20 outline-none transition-all" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="w-10 h-10 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-4 md:p-8 space-y-8">
            <section class="space-y-6">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight">Financial Transactions</h2>
                    <p class="text-slate-500 mt-1">Monitor global revenue, manage payouts, and track purchase health.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-primary text-white p-6 rounded-xl shadow-sm">
                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] opacity-80">Total Revenue</span>
                        <p class="text-4xl font-extrabold mt-2 tracking-tight">Rs. {{ number_format($totalRevenue, 0) }}</p>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Successful Payments</span>
                        <p class="text-4xl font-extrabold mt-2 tracking-tight">{{ number_format($successfulPayments) }}</p>
                        <p class="text-xs text-emerald-600 font-bold mt-2">{{ number_format($successRate, 1) }}% success rate</p>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Failure Rate</span>
                        <p class="text-4xl font-extrabold mt-2 tracking-tight">{{ number_format($refundRate, 1) }}%</p>
                    </div>
                </div>
            </section>

            <form class="bg-surface-container-low p-4 rounded-xl flex flex-wrap items-center gap-4" method="GET">
                <div class="relative">
                    <select class="admin-select bg-surface-container-lowest px-4 py-2 rounded-lg border border-outline-variant/10 text-xs font-semibold" name="status">
                        <option value="">All Statuses</option>
                        <option value="completed" @selected($filters['status'] === 'completed')>Completed</option>
                        <option value="pending" @selected($filters['status'] === 'pending')>Pending</option>
                        <option value="failed" @selected($filters['status'] === 'failed')>Failed</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                </div>
                <div class="relative">
                    <select class="admin-select bg-surface-container-lowest px-4 py-2 rounded-lg border border-outline-variant/10 text-xs font-semibold" name="gateway">
                        <option value="">All Gateways</option>
                        <option value="stripe" @selected($filters['gateway'] === 'stripe')>Stripe</option>
                        <option value="razorpay" @selected($filters['gateway'] === 'razorpay')>Razorpay</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                </div>
                <button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold" type="submit">Apply</button>
            </form>

            <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                <div class="px-4 md:px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-on-surface">Recent Activity</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Live Data</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-4 md:px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">User</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Course Purchased</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Amount</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Gateway</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Transaction Date</th>
                                <th class="px-4 md:px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 md:px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-bold text-xs">{{ \Illuminate\Support\Str::upper(substr($payment->user?->name ?? 'U', 0, 2)) }}</div>
                                            <div>
                                                <p class="text-sm font-bold text-on-surface">{{ $payment->user?->name ?: 'Student' }}</p>
                                                <p class="text-[11px] text-slate-400">{{ $payment->user?->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5"><span class="text-sm font-medium text-slate-600">{{ $payment->course?->title ?: 'Course unavailable' }}</span></td>
                                    <td class="px-6 py-5"><span class="text-sm font-extrabold text-on-surface">Rs. {{ number_format($payment->amount, 0) }}</span></td>
                                    <td class="px-6 py-5"><span class="text-[11px] font-bold text-slate-600 uppercase">{{ $payment->payment_getway }}</span></td>
                                    <td class="px-6 py-5"><span class="text-sm text-slate-500">{{ $payment->created_at?->format('M d, Y · H:i') }}</span></td>
                                    <td class="px-4 md:px-8 py-5">
                                        <span class="px-3 py-1 {{ $payment->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($payment->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-error-container text-on-error-container') }} text-[10px] font-bold rounded-full uppercase tracking-wider">{{ $payment->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-8 text-center text-sm text-slate-500" colspan="6">No payments found for this filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 md:px-8 py-6 bg-surface-container-low/30 flex items-center justify-between border-t border-slate-50">
                    <p class="text-xs text-slate-400">Showing <span class="font-bold text-slate-600">{{ $payments->firstItem() ?? 0 }} - {{ $payments->lastItem() ?? 0 }}</span> of <span class="font-bold text-slate-600">{{ $payments->total() }}</span> transactions</p>
                    <div class="flex items-center gap-2">
                        @for ($page = 1; $page <= min(3, $payments->lastPage()); $page++)
                            <a class="px-3 py-1 rounded-lg {{ $payments->currentPage() === $page ? 'bg-primary text-white text-xs font-bold' : 'bg-surface-container-lowest border border-outline-variant/10 text-xs font-bold text-slate-600 hover:bg-slate-50' }}" href="{{ $payments->url($page) }}">{{ $page }}</a>
                        @endfor
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>




