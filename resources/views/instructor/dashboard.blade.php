<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Dashboard | CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
            vertical-align: middle;
        }

        .editorial-gradient {
            background: linear-gradient(135deg, #6a3378 0%, #b07ac3 100%);
        }

        .glass-panel {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.8);
        }

        .chart-peak-card {
            opacity: 0;
            transform: translateY(6px);
            transition: opacity 0.18s ease, transform 0.18s ease;
            pointer-events: none;
        }

        .chart-peak-trigger:hover + .chart-peak-card,
        .chart-peak-card.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #e7dcef;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface antialiased">
    @php
        $chartAreaPath = $chartPath.' L 800 200 L 0 200 Z';
        $trendClass = fn ($trend) => $trend['icon'] ? ($trend['positive'] ? 'text-tertiary' : 'text-rose-500') : 'text-slate-400';
        $reviewInitials = function ($name) {
            return collect(explode(' ', trim($name)))
                ->filter()
                ->take(2)
                ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                ->implode('');
        };
    @endphp

    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 bg-white/88 backdrop-blur-md border-b border-[#eadff1] flex justify-between items-center w-full pl-16 pr-4 md:px-8 py-4 shadow-sm">
            <div class="flex items-center gap-4 flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
                <div class="relative w-full md:max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                    <input class="w-full pl-10 pr-3 md:pr-4 py-2 bg-slate-100 border-none rounded-lg text-sm focus:ring-2 focus:ring-[#f5eef8]/20" placeholder="Search..." type="text" />
                </div>
            </div>
            <div class="ml-auto flex items-center gap-3 md:gap-6">
                <div class="hidden sm:flex items-center gap-4 text-slate-500">
                    <button class="hover:bg-slate-100 p-2 rounded-full transition-colors"><span class="material-symbols-outlined" data-icon="notifications">notifications</span></button>
                    <a class="hover:bg-slate-100 p-2 rounded-full transition-colors" href="{{ route('instructor.messages') }}"><span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span></a>
                    <a class="hover:bg-slate-100 p-2 rounded-full transition-colors" href="{{ route('instructor.settings') }}"><span class="material-symbols-outlined" data-icon="settings">settings</span></a>
                </div>
                <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-slate-100">
                    <img alt="Instructor Profile" class="w-full h-full object-cover" src="{{ $profileAvatar }}" />
                </div>
            </div>
        </header>
        <div class="p-4 md:p-8 space-y-8">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                <div class="space-y-2">
                    <p class="text-xs font-bold tracking-[0.2em] text-[#6a3378] uppercase font-label">Dashboard Overview</p>
                    <h2 class="text-3xl font-bold font-headline text-slate-900 leading-tight sm:text-4xl xl:text-5xl">Welcome back, <br />{{ $welcomeName }}.</h2>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a class="px-6 py-3 bg-white text-slate-700 font-semibold rounded-xl shadow-sm border border-slate-100 hover:bg-slate-50 transition-all inline-flex items-center justify-center" href="{{ route('instructor.mycourse') }}">Manage Courses</a>
                    <a class="px-6 py-3 editorial-gradient text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 transition-all hover:opacity-90 active:scale-95 inline-flex items-center justify-center" href="{{ route('instructor.create-course') }}">Create New Course</a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-1 bg-surface-container-lowest p-6 rounded-xl shadow-sm space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="p-3 bg-[#f5eef8] text-[#6a3378] rounded-lg">
                            <span class="material-symbols-outlined" data-icon="payments">payments</span>
                        </div>
                        <span class="{{ $trendClass($totalRevenueTrend) }} font-semibold text-xs flex items-center gap-1">
                            @if($totalRevenueTrend['icon'])
                                <span class="material-symbols-outlined text-[1rem]">{{ $totalRevenueTrend['icon'] }}</span>
                            @endif
                            {{ $totalRevenueTrend['label'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Revenue</p>
                        <h3 class="text-2xl font-bold font-headline">{{ $totalRevenue }}</h3>
                    </div>
                </div>
                <div class="md:col-span-1 bg-surface-container-lowest p-6 rounded-xl shadow-sm space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="p-3 bg-violet-50 text-violet-600 rounded-lg">
                            <span class="material-symbols-outlined" data-icon="group">group</span>
                        </div>
                        <span class="{{ $trendClass($totalStudentsTrend) }} font-semibold text-xs flex items-center gap-1">
                            @if($totalStudentsTrend['icon'])
                                <span class="material-symbols-outlined text-[1rem]">{{ $totalStudentsTrend['icon'] }}</span>
                            @endif
                            {{ $totalStudentsTrend['label'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Students</p>
                        <h3 class="text-2xl font-bold font-headline">{{ $totalStudents }}</h3>
                    </div>
                </div>
                <div class="md:col-span-1 bg-surface-container-lowest p-6 rounded-xl shadow-sm space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                            <span class="material-symbols-outlined" data-icon="library_books">library_books</span>
                        </div>
                        <span class="{{ $trendClass($totalCoursesTrend) }} font-semibold text-xs flex items-center gap-1">
                            @if($totalCoursesTrend['icon'])
                                <span class="material-symbols-outlined text-[1rem]">{{ $totalCoursesTrend['icon'] }}</span>
                            @endif
                            {{ $totalCoursesTrend['label'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Courses</p>
                        <h3 class="text-2xl font-bold font-headline">{{ $totalCourses }}</h3>
                    </div>
                </div>
                <div class="md:col-span-1 bg-surface-container-lowest p-6 rounded-xl shadow-sm space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                            <span class="material-symbols-outlined" data-icon="calendar_today">calendar_today</span>
                        </div>
                        <span class="{{ $trendClass($monthlyEarningsTrend) }} font-semibold text-xs flex items-center gap-1">
                            @if($monthlyEarningsTrend['icon'])
                                <span class="material-symbols-outlined text-[1rem]">{{ $monthlyEarningsTrend['icon'] }}</span>
                            @endif
                            {{ $monthlyEarningsTrend['label'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Monthly Earnings</p>
                        <h3 class="text-2xl font-bold font-headline">{{ $monthlyEarnings }}</h3>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h4 class="text-xl font-bold font-headline">Earnings Performance</h4>
                            <p class="text-slate-500 text-sm">Detailed revenue metrics over the last 30 days</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-surface-container-low rounded-lg text-xs font-semibold text-[#6a3378]">30 Days</button>
                            <button class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-lg transition-colors">90 Days</button>
                        </div>
                    </div>
                    <div class="h-64 w-full relative" id="earningsChartContainer">
                        <svg class="w-full h-full" viewbox="0 0 800 200">
                            <defs>
                                <lineargradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#6a3378" stop-opacity="0.2"></stop>
                                    <stop offset="100%" stop-color="#6a3378" stop-opacity="0"></stop>
                                </lineargradient>
                            </defs>
                            <path d="{{ $chartPath }}" fill="none" stroke="#6a3378" stroke-linecap="round" stroke-width="4"></path>
                            <path d="{{ $chartAreaPath }}" fill="url(#chartGradient)"></path>
                        </svg>
                        @if($peakPoint)
                            <button class="chart-peak-trigger absolute block h-8 w-8 -translate-x-1/2 -translate-y-1/2 rounded-full bg-transparent" data-left="{{ $peakPoint['x'] / 8 }}" data-top="{{ $peakPoint['y'] / 2 }}" type="button" aria-label="View peak sales details"></button>
                        @endif
                        <div id="earningsChartPeakCard" class="chart-peak-card absolute top-4 right-10 glass-panel border border-white p-4 rounded-xl shadow-xl max-w-[200px] transform hover:-translate-y-1 transition-transform">
                            <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-1">Peak Sales</p>
                            <p class="text-lg font-bold text-slate-900">{{ $peakRevenue }}</p>
                            <p class="text-[0.7rem] text-tertiary flex items-center gap-1 font-semibold mt-1">
                                <span class="material-symbols-outlined text-[0.8rem]">check_circle</span>
                                Course: {{ \Illuminate\Support\Str::limit($peakCourseTitle, 20) }}
                            </p>
                            <p class="text-[0.65rem] text-slate-400 mt-2">{{ $peakRevenueDateLabel }}</p>
                        </div>
                    </div>
                    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 border-t border-slate-50 pt-6">
                        <div class="text-center">
                            <p class="text-xs text-slate-400 font-medium">Average Order</p>
                            <p class="text-lg font-bold">{{ $averageOrderValue }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-400 font-medium">Refund Rate</p>
                            <p class="text-lg font-bold">{{ $refundRate }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-400 font-medium">Conversion</p>
                            <p class="text-lg font-bold">{{ $conversionRate }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-400 font-medium">Active Subs</p>
                            <p class="text-lg font-bold">{{ $activeSubscriptions }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-[#0a2f73] text-[#f5fbff] p-4 md:p-8 rounded-xl shadow-lg relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-[10rem]">trending_up</span>
                        </div>
                        <h4 class="text-lg font-bold mb-4 font-headline">Student Growth</h4>
                        <div class="space-y-4 relative z-10">
                            <div class="flex items-end gap-2">
                                <span class="text-4xl font-bold">{{ $studentGrowthCount }}</span>
                                <span class="text-emerald-400 text-sm font-bold mb-1">{{ $studentGrowthTrend['label'] }} {{ $studentGrowthTrend['suffix'] }}</span>
                            </div>
                            <div class="w-full bg-[#071c4a]/55 rounded-full h-2">
                                <div class="bg-emerald-400 h-2 rounded-full instructor-growth-bar" data-width="{{ $studentGrowthWidth }}"></div>
                            </div>
                            <p class="text-[#76c6ff] text-xs leading-relaxed">{{ $studentGrowthMessage }}</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-slate-100">
                        <h4 class="text-sm font-bold mb-4 text-slate-900">Recommended Actions</h4>
                        <div class="space-y-3">
                            @foreach($recommendedActions as $action)
                                <a class="flex items-start gap-3 p-3 hover:bg-slate-50 rounded-lg transition-colors cursor-pointer group" href="{{ $action['href'] }}">
                                    <div class="w-8 h-8 rounded-lg {{ $action['icon_bg'] }} {{ $action['icon_text'] }} flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-sm" data-icon="{{ $action['icon'] }}">{{ $action['icon'] }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $action['title'] }}</p>
                                        <p class="text-[0.7rem] text-slate-500">{{ $action['description'] }}</p>
                                    </div>
                                    <span class="material-symbols-outlined text-slate-300 ml-auto group-hover:text-[#6a3378] transition-colors">chevron_right</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <section class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-xl font-bold font-headline">New Enrollments</h4>
                        <a class="text-[#6a3378] text-xs font-bold hover:underline" href="{{ route('instructor.students') }}">View all</a>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="divide-y divide-slate-50">
                            @forelse($recentEnrollments as $enrollment)
                                <div class="flex items-center gap-4 p-5 hover:bg-slate-50 transition-colors">
                                    <img alt="Student Avatar" class="w-10 h-10 rounded-full object-cover" src="{{ $enrollment->user?->avatarUrl(80) }}" />
                                    <div class="flex-1">
                                        <p class="text-sm font-bold">{{ $enrollment->user->name }}</p>
                                        <p class="text-[0.7rem] text-slate-500">Enrolled in <span class="font-semibold text-[#6a3378]">{{ $enrollment->course->title }}</span></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold">Rs. {{ number_format($enrollment->payment?->amount ?? $enrollment->amount, 2) }}</p>
                                        <p class="text-[0.7rem] text-slate-400">{{ optional($enrollment->enrolled_at ?? $enrollment->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <p class="text-sm font-bold text-slate-900">No enrollments yet</p>
                                    <p class="text-xs text-slate-500 mt-1">Your latest student signups will appear here as soon as they happen.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
                <section class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-xl font-bold font-headline">Recent Reviews</h4>
                        <a class="text-[#6a3378] text-xs font-bold hover:underline" href="{{ route('instructor.reviews') }}">Manage</a>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        @forelse($recentReviews as $review)
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex gap-4">
                                <div class="shrink-0 flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600">{{ $reviewInitials($review->user->name) }}</div>
                                    <div class="mt-2 flex">
                                        @for($star = 1; $star <= 5; $star++)
                                            <span class="material-symbols-outlined text-[0.8rem] {{ $star <= $review->rating ? 'text-yellow-400' : 'text-slate-200' }}" data-weight="fill">star</span>
                                        @endfor
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h5 class="text-sm font-bold text-slate-900 mb-1">"{{ \Illuminate\Support\Str::limit($review->comment ?: 'Great learning experience.', 52) }}"</h5>
                                    <p class="text-xs text-slate-600 leading-relaxed italic">{{ \Illuminate\Support\Str::limit($review->comment ?: 'This course is already earning strong feedback from students.', 140) }}</p>
                                    <div class="mt-3 flex items-center justify-between gap-4">
                                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-tighter">{{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}</p>
                                        <a class="text-xs font-bold text-[#6a3378] flex items-center gap-1 shrink-0" href="{{ route('instructor.reviews') }}">Reply <span class="material-symbols-outlined text-sm">reply</span></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                                <p class="text-sm font-bold text-slate-900">No reviews yet</p>
                                <p class="text-xs text-slate-500 mt-1">Student feedback will appear here once learners start rating your courses.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
        <div id="instructorInsightToast" class="fixed bottom-8 right-8 glass-panel border border-white shadow-2xl p-4 rounded-xl flex items-center gap-4 animate-in fade-in slide-in-from-bottom-5 duration-700">
            <div class="w-1 h-full absolute left-0 top-0 bg-tertiary rounded-l-xl"></div>
            <div class="p-2 bg-emerald-50 text-tertiary rounded-lg">
                <span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-900">Course Insight</p>
                <p class="text-[0.7rem] text-slate-500">{{ $insightMessage }}</p>
            </div>
            <button id="closeInstructorInsightToast" class="text-slate-400 hover:text-slate-600" type="button"><span class="material-symbols-outlined text-sm">close</span></button>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.instructor-growth-bar').forEach(function (element) {
                var width = Number(element.dataset.width || 0);
                element.style.width = width + '%';
                element.style.boxShadow = '0 0 12px rgba(52, 211, 153, 0.5)';
            });

            document.querySelectorAll('.chart-peak-trigger').forEach(function (element) {
                var left = Number(element.dataset.left || 0);
                var top = Number(element.dataset.top || 0);
                element.style.left = left + '%';
                element.style.top = top + '%';
            });

            var insightToast = document.getElementById('instructorInsightToast');
            var insightCloseButton = document.getElementById('closeInstructorInsightToast');

            if (insightToast && insightCloseButton) {
                insightCloseButton.addEventListener('click', function () {
                    insightToast.classList.add('hidden');
                });
            }

        });
    </script>
</body>

</html>




