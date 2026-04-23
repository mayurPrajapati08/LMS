<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself Admin - Executive Dashboard</title>
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
                        "primary-container": "#b07ac3",
                        "background": "#fcf9fe",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f5eef8",
                        "surface-container-high": "#efe5f4",
                        "surface-container-highest": "#e7dcef",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#6d5a76",
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
        .editorial-gradient { background: linear-gradient(135deg, #6a3378 0%, #b07ac3 100%); }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-background text-on-surface flex min-h-screen">
    <x-admin.navbar />

    <main class="md:ml-64 flex-1 flex flex-col">
        <header class="fixed top-0 right-0 left-0 md:left-64 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
            <div class="flex items-center gap-2 bg-surface-container-low px-3 py-2 rounded-full w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none md:px-4 md:gap-4 md:w-96 focus-within:ring-2 focus-within:ring-[#f5eef8]/20 transition-all">
                <span class="material-symbols-outlined text-slate-400">search</span>
                <input class="bg-transparent border-none text-sm focus:ring-0 w-full placeholder:text-slate-400" placeholder="Search..." type="text" />
            </div>
            <div class="ml-auto flex items-center gap-3 md:gap-6">
                <div class="hidden md:block h-8 w-[1px] bg-slate-200"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-on-surface leading-tight">{{ $admin->name }}</p>
                        <p class="text-[10px] text-primary font-bold uppercase tracking-tighter">{{ strtoupper($admin->role?->name ?? 'ADMIN') }}</p>
                    </div>
                    <img alt="{{ $admin->name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-primary-container" src="{{ $profileAvatar }}" />
                </div>
            </div>
        </header>

        <div class="mt-20 p-4 md:p-8 space-y-8 max-w-[1600px] mx-auto w-full">
            <div class="flex flex-col justify-between gap-4 pb-4 md:flex-row md:items-end">
                <div>
                    <span class="text-[0.75rem] font-bold uppercase tracking-[0.1em] text-primary mb-2 block">System Overview</span>
                    <h2 class="text-4xl font-extrabold tracking-tight">Executive Dashboard</h2>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a class="px-6 py-3 rounded-xl bg-surface-container-high text-on-surface font-semibold text-sm text-center" href="{{ route('admin.analytics') }}">Download Report</a>
                    <a class="px-6 py-3 rounded-xl editorial-gradient text-white font-bold text-sm text-center shadow-lg shadow-primary/20" href="{{ route('admin.courses') }}">Manage Courses</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Users</p>
                    <h3 class="text-3xl font-extrabold tracking-tight">{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Instructors</p>
                    <h3 class="text-3xl font-extrabold tracking-tight">{{ number_format($totalInstructors) }}</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Courses</p>
                    <h3 class="text-3xl font-extrabold tracking-tight">{{ number_format($totalCourses) }}</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Revenue</p>
                    <h3 class="text-3xl font-extrabold tracking-tight">Rs. {{ number_format($totalRevenue, 0) }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-4 md:p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-xl font-bold tracking-tight">Revenue Stream</h3>
                            <p class="text-sm text-slate-500">Earnings performance over the last 12 months</p>
                        </div>
                    </div>
                    <div class="relative h-64 w-full">
                        <div class="absolute bottom-0 left-0 w-full h-[1px] bg-slate-100"></div>
                        <div class="flex items-end justify-between h-full px-4 gap-4">
                            @foreach ($monthlyRevenue as $month)
                                <div class="flex-1 {{ $month['is_peak'] ? 'bg-primary ring-4 ring-primary/10' : 'bg-primary/5 hover:bg-primary/20' }} rounded-t-lg group relative transition-all js-dashboard-height-bar" data-height="{{ $month['height'] }}">
                                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-on-surface text-white text-[10px] px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Rs. {{ number_format($month['amount'], 0) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between mt-4 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        @foreach ($monthlyRevenue as $month)
                            <span>{{ $month['label'] }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-3xl p-4 md:p-8 shadow-sm flex flex-col">
                    <h3 class="text-xl font-bold tracking-tight mb-2">User Enrollment</h3>
                    <p class="text-sm text-slate-500 mb-8">Monthly new student acquisition</p>
                    <div class="space-y-6 flex-1">
                        @foreach ($enrollmentMonths as $month)
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                                    <span>{{ $month['label'] }}</span>
                                    <span>{{ number_format($month['count']) }}</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                    <div class="editorial-gradient h-full js-dashboard-width-bar" data-width="{{ $month['width'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="w-full mt-6 py-3 text-primary text-xs font-bold uppercase tracking-widest border-t border-slate-50 pt-6 text-center" href="{{ route('admin.users') }}">View Detailed Demographics</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-surface-container-lowest rounded-3xl p-4 md:p-8 shadow-sm">
                    <h3 class="text-xl font-bold tracking-tight mb-6">Top Selling Courses</h3>
                    <div class="space-y-6">
                        @forelse ($topCourses as $course)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                    <img alt="{{ $course->title }}" class="w-full h-full object-cover" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=F3E8FF&color=6B21A8&size=320' }}" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold line-clamp-1">{{ $course->title }}</h4>
                                    <p class="text-xs text-slate-500">{{ number_format($course->enrollments_count) }} sales</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm">Rs. {{ number_format($course->completed_revenue ?? 0, 0) }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Top courses will appear here when purchases come in.</p>
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-4 md:p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold tracking-tight">Recent Enrollments</h3>
                        <a class="text-xs font-bold text-primary uppercase tracking-widest hover:underline" href="{{ route('admin.users') }}">View All Students</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="text-[10px] font-bold uppercase tracking-widest text-slate-400 border-b border-slate-50">
                                <tr>
                                    <th class="pb-4">Student</th>
                                    <th class="pb-4">Course</th>
                                    <th class="pb-4">Enrollment Time</th>
                                    <th class="pb-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse ($recentEnrollments as $enrollment)
                                    <tr class="group hover:bg-slate-50 transition-colors">
                                        <td class="py-4 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 overflow-hidden">
                                                <img alt="{{ $enrollment->user?->name }}" class="w-full h-full object-cover" src="{{ $enrollment->user?->avatarUrl(48) }}" />
                                            </div>
                                            <span class="font-semibold">{{ $enrollment->user?->name ?: 'Student' }}</span>
                                        </td>
                                        <td class="py-4 text-slate-600">{{ $enrollment->course?->title ?: 'Course unavailable' }}</td>
                                        <td class="py-4 text-slate-500">{{ $enrollment->created_at?->diffForHumans() }}</td>
                                        <td class="py-4"><span class="bg-[#f5eef8] text-[#6a3378] text-[10px] font-bold uppercase px-2 py-1 rounded-full">{{ $enrollment->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-6 text-slate-500" colspan="4">Recent enrollments will appear here.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
                <div class="bg-surface-container-lowest rounded-3xl p-4 md:p-8 shadow-sm lg:col-span-1">
                    <h3 class="text-xl font-bold tracking-tight mb-6">Recent Payments</h3>
                    <div class="space-y-4">
                        @forelse ($recentPayments as $payment)
                            <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 {{ $payment->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : ($payment->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }} rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-sm">{{ $payment->status === 'completed' ? 'check' : ($payment->status === 'pending' ? 'pending' : 'close') }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $payment->user?->name ?: 'Student' }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase tracking-tighter">Transaction #{{ $payment->payment_id ?: $payment->id }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-sm">Rs. {{ number_format($payment->amount, 0) }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Recent payments will appear here.</p>
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-2 bg-[#0a2f73] rounded-3xl p-4 md:p-8 relative overflow-hidden group">
                    <div class="relative z-10 h-full flex flex-col justify-center">
                        <span class="text-[#d6b8e0] text-xs font-bold uppercase tracking-[0.2em] mb-2">Curator Intelligence</span>
                        <h3 class="text-3xl font-bold text-white mb-4 leading-tight">{{ $insightTitle }}</h3>
                        <p class="text-[#e1cde8]/70 max-w-md text-sm mb-6">{{ $insightText }}</p>
                        <a class="bg-white text-[#6a3378] px-6 py-3 rounded-xl font-bold text-sm self-start" href="{{ route('admin.analytics') }}">Explore AI Forecast</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll('.js-dashboard-height-bar').forEach((element) => {
            const height = Number(element.dataset.height || 0);
            element.style.height = `${Math.max(0, Math.min(100, height))}%`;
        });

        document.querySelectorAll('.js-dashboard-width-bar').forEach((element) => {
            const width = Number(element.dataset.width || 0);
            element.style.width = `${Math.max(0, Math.min(100, width))}%`;
        });
    </script>
</body>
</html>




