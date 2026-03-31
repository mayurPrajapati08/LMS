<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>My Courses | Scholarly Editorial</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#4f46e5",
                        "background": "#f8f9fa",
                        "primary": "#3525cd",
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #191c1d;
        }

        .editorial-shadow {
            box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05);
        }
    </style>
</head>
<body class="bg-background text-slate-900 antialiased">
    @php
        $totalCourses = $summary['totalCourses'] ?? 0;
        $publishedCourses = $summary['publishedCourses'] ?? 0;
        $activeLearners = $summary['activeLearners'] ?? 0;
        $monthlyEarnings = $summary['monthlyEarnings'] ?? 0;
        $averageRating = $summary['averageRating'] ?? 0;
        $totalReviews = $summary['totalReviews'] ?? 0;
    @endphp

    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 w-full pl-16 pr-4 md:px-8 py-4 bg-white/80 backdrop-blur-md flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-2 md:gap-4 bg-slate-100 px-3 md:px-4 py-2 rounded-full w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none md:w-96">
                <span class="material-symbols-outlined text-slate-400">search</span>
                <input class="bg-transparent border-none outline-none w-full text-slate-600 focus:ring-0" placeholder="Search..." type="text" />
            </div>
            <div class="ml-auto flex items-center gap-4 md:gap-6">
                <div class="flex items-center gap-4">
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                        <span class="material-symbols-outlined">chat_bubble</span>
                    </button>
                </div>
                <div class="h-10 w-px bg-slate-200"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="font-semibold text-slate-900 leading-none">{{ $instructorName }}</p>
                        <p class="text-xs text-slate-500 mt-1">Instructor</p>
                    </div>
                    <img alt="Instructor Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $profileAvatar }}" />
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            <section class="rounded-[28px] bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-800 text-white overflow-hidden editorial-shadow">
                <div class="grid gap-8 lg:grid-cols-[1.3fr_0.95fr] p-6 md:p-10">
                    <div class="space-y-5">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-indigo-100">Instructor Library</div>
                        <div class="space-y-3">
                            <h1 class="font-headline text-4xl md:text-5xl font-bold leading-tight">Manage every draft, launch, and update from one place.</h1>
                            <p class="max-w-2xl text-sm md:text-base text-indigo-100/90 leading-relaxed">Track live course performance, revisit drafts, and jump back into editing without breaking the design flow you already built.</p>
                        </div>
                        <a class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-primary hover:bg-slate-100 transition-colors" href="{{ route('instructor.create-course') }}">
                            <span class="material-symbols-outlined text-[1.1rem]">add_circle</span>
                            <span>Create New Course</span>
                        </a>
                    </div>
                    <div class="rounded-[24px] border border-white/15 bg-white/10 p-5 md:p-6 backdrop-blur-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-indigo-100/80">Publishing Snapshot</p>
                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ $totalCourses }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-indigo-100/80">Total Courses</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ $publishedCourses }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-indigo-100/80">Published</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ number_format($activeLearners) }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-indigo-100/80">Learners</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">Rs. {{ number_format((float) $monthlyEarnings, 0) }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-indigo-100/80">This Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <span class="rounded-full bg-indigo-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-indigo-600">{{ $publishedCourses }} live</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Total Courses</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">{{ $totalCourses }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-emerald-600">active</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Active Learners</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">{{ number_format($activeLearners) }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">monetization_on</span>
                        </div>
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-amber-700">current month</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Monthly Earnings</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">Rs. {{ number_format((float) $monthlyEarnings, 0) }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-slate-600">{{ $totalReviews }} reviews</span>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Average Rating</p>
                    <p class="mt-2 font-headline text-3xl font-bold text-slate-900">{{ number_format((float) $averageRating, 1) }}</p>
                </div>
            </section>

            <section class="rounded-[28px] bg-white border border-slate-200 overflow-hidden editorial-shadow">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between px-6 md:px-8 py-6 border-b border-slate-200">
                    <div>
                        <h2 class="font-headline text-2xl font-bold text-slate-900">My Courses</h2>
                        <p class="mt-2 text-sm text-slate-500">Showing {{ $courses->firstItem() ?? 0 }} - {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }} courses</p>
                    </div>
                    <a class="inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-primary hover:bg-slate-200 transition-colors" href="{{ route('instructor.create-course') }}">
                        <span class="material-symbols-outlined text-[1.1rem]">add</span>
                        <span>New Course</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[980px] text-left">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 md:px-8 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Course</th>
                                <th class="px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Status</th>
                                <th class="px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 text-center">Students</th>
                                <th class="px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 text-center">Sections</th>
                                <th class="px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Rating</th>
                                <th class="px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Earnings</th>
                                <th class="px-6 md:px-8 py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($courses as $courseItem)
                                @php
                                    $statusStyles = match ($courseItem->status) {
                                        'published' => 'bg-emerald-50 text-emerald-700',
                                        'archived' => 'bg-slate-100 text-slate-600',
                                        default => 'bg-amber-50 text-amber-700',
                                    };
                                    $statusDot = match ($courseItem->status) {
                                        'published' => 'bg-emerald-500',
                                        'archived' => 'bg-slate-400',
                                        default => 'bg-amber-500',
                                    };
                                    $courseThumbnail = $courseItem->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($courseItem->title).'&background=E2E8F0&color=334155&size=160';
                                    $courseRating = $courseItem->reviews_avg_rating ? number_format((float) $courseItem->reviews_avg_rating, 1) : '0.0';
                                    $courseRevenue = (float) ($courseItem->completed_payments_sum ?? 0);
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 md:px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 flex-shrink-0">
                                                <img alt="Course Thumbnail" class="w-full h-full object-cover" src="{{ $courseThumbnail }}" />
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 truncate">{{ $courseItem->title }}</p>
                                                <p class="mt-1 text-xs text-slate-500">{{ $courseItem->category?->name ?? 'Uncategorized' }} • {{ ucfirst($courseItem->level ?? 'not set') }}</p>
                                                <p class="mt-1 text-xs text-slate-400">Last edited {{ $courseItem->updated_at?->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] {{ $statusStyles }}">
                                            <span class="w-2 h-2 rounded-full {{ $statusDot }}"></span>
                                            {{ ucfirst($courseItem->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="font-semibold text-slate-700">{{ number_format((int) $courseItem->completed_enrollments_count) }}</span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="font-semibold text-slate-700">{{ $courseItem->sections_count }}</span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                            <span class="material-symbols-outlined text-amber-500 text-[1.05rem]">star</span>
                                            <span>{{ $courseRating }}</span>
                                            <span class="text-slate-400">({{ $courseItem->reviews_count }})</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="font-bold text-slate-900">Rs. {{ number_format($courseRevenue, 0) }}</span>
                                    </td>
                                    <td class="px-6 md:px-8 py-6">
                                        <div class="flex items-center justify-end gap-2">
                                            <a class="inline-flex items-center justify-center rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-primary transition-colors" href="{{ route('instructor.create-course.review', ['course' => $courseItem->id]) }}" title="Review Course">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </a>
                                            <a class="inline-flex items-center justify-center rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-primary transition-colors" href="{{ route('instructor.create-course', ['course' => $courseItem->id]) }}" title="Edit Course">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 md:px-8 py-16 text-center" colspan="7">
                                        <div class="max-w-md mx-auto">
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-indigo-50 text-primary">
                                                <span class="material-symbols-outlined text-3xl">library_books</span>
                                            </div>
                                            <h3 class="mt-5 font-headline text-2xl font-bold text-slate-900">No courses yet</h3>
                                            <p class="mt-3 text-sm leading-relaxed text-slate-500">Your drafts and published courses will appear here as soon as you start building them.</p>
                                            <a class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-bold text-white hover:opacity-90 transition-opacity" href="{{ route('instructor.create-course') }}">
                                                <span class="material-symbols-outlined text-[1.1rem]">add_circle</span>
                                                <span>Create Your First Course</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($courses->hasPages())
                    <div class="flex items-center justify-between px-6 md:px-8 py-5 border-t border-slate-200 bg-slate-50/60">
                        <div class="text-sm text-slate-500">
                            Page {{ $courses->currentPage() }} of {{ $courses->lastPage() }}
                        </div>
                        <div>
                            {{ $courses->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</body>
</html>
