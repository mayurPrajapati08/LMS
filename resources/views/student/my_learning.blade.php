<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
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
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .editorial-shadow {
            box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.04);
        }
    </style>
</head>

<body class="text-on-surface">
    <x-student.navbar />

    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 shadow-sm dark:shadow-none">
        <div class="flex items-center gap-4 flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
            <div class="relative w-full md:max-w-md group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-xl py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-indigo-500/20 transition-all font-body" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="flex items-center gap-6">
            <button class="relative text-slate-500 hover:text-indigo-500 transition-all" type="button">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <img alt="Student Profile" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $studentAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-24 px-4 md:px-10 pb-12 min-h-screen">
        <section class="mb-12 flex flex-col md:flex-row justify-between items-end gap-8">
            <div class="space-y-4 max-w-2xl">
                <h1 class="text-[3.5rem] font-bold font-headline leading-tight tracking-tight text-on-surface">
                    Your Learning <span class="text-primary italic">Journey.</span>
                </h1>
                <p class="text-on-surface-variant font-body text-lg leading-relaxed">
                    Continue where you left off. You have <span class="font-bold text-on-surface">{{ $hero['in_progress_count'] }} courses</span> in progress and have completed <span class="font-bold text-on-surface">{{ $hero['completed_lessons_this_week'] }} lessons</span> this week.
                </p>
            </div>
            <div class="bg-surface-container-lowest editorial-shadow rounded-xl p-6 w-full sm:w-72 relative -mb-4 z-10 border border-slate-50">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-primary-fixed p-2 rounded-lg">
                        <span class="material-symbols-outlined text-primary" data-icon="auto_stories" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                    </div>
                    <span class="text-[0.75rem] font-bold font-label uppercase tracking-widest text-slate-400">Week Target</span>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold font-headline text-on-surface">{{ $hero['target_percent'] }}% Reach</div>
                    <div class="w-full bg-surface-container-low h-1.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-primary to-primary-container h-full rounded-full js-progress-fill" data-progress="{{ $hero['target_percent'] }}"></div>
                    </div>
                </div>
            </div>
        </section>

        <div class="flex items-center gap-2 mb-8 bg-surface-container-low p-1.5 rounded-xl w-fit">
            <a @class([
                'px-6 py-2.5 rounded-lg text-sm font-label transition-all',
                'bg-surface-container-lowest text-primary font-bold editorial-shadow' => $activeTab === 'in-progress',
                'text-slate-500 font-semibold hover:text-indigo-500' => $activeTab !== 'in-progress',
            ]) href="{{ route('student.my-learning', ['tab' => 'in-progress']) }}">
                In Progress
            </a>
            <a @class([
                'px-6 py-2.5 rounded-lg text-sm font-label transition-all',
                'bg-surface-container-lowest text-primary font-bold editorial-shadow' => $activeTab === 'completed',
                'text-slate-500 font-semibold hover:text-indigo-500' => $activeTab !== 'completed',
            ]) href="{{ route('student.my-learning', ['tab' => 'completed']) }}">
                Completed
            </a>
            <a @class([
                'px-6 py-2.5 rounded-lg text-sm font-label transition-all',
                'bg-surface-container-lowest text-primary font-bold editorial-shadow' => $activeTab === 'archived',
                'text-slate-500 font-semibold hover:text-indigo-500' => $activeTab !== 'archived',
            ]) href="{{ route('student.my-learning', ['tab' => 'archived']) }}">
                Archived
            </a>
        </div>

        @if ($courses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($courses as $course)
                    <div class="group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow transition-all hover:-translate-y-1 flex flex-col">
                        <div class="h-48 relative overflow-hidden">
                            <img alt="{{ $course['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ $course['thumbnail'] }}" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[0.7rem] font-bold font-label text-primary shadow-sm">{{ $course['badge'] }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold font-headline text-on-surface mb-2 group-hover:text-primary transition-colors">{{ $course['title'] }}</h3>
                                <p class="text-sm text-on-surface-variant font-body mb-2 line-clamp-2">{{ $course['description'] }}</p>
                                <p class="text-xs text-slate-500 font-medium mb-6">Next: {{ $course['next_lesson'] }} | {{ $course['instructor_name'] }}</p>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-xs font-bold font-label uppercase tracking-wider">
                                    <span class="text-tertiary">{{ $course['progress_text'] }}</span>
                                    <span class="text-slate-400">{{ $course['lesson_text'] }}</span>
                                </div>
                                <div class="w-full bg-surface-container-low h-2 rounded-full overflow-hidden">
                                    <div class="{{ $course['accent_class'] }} h-full rounded-full js-progress-fill" data-progress="{{ $course['progress_percent'] }}"></div>
                                </div>
                                <a class="w-full bg-surface-container-high hover:bg-primary hover:text-white text-primary font-bold py-3 rounded-xl transition-all font-label text-sm flex items-center justify-center gap-2" href="{{ $course['cta_url'] }}">
                                    {{ $course['cta_label'] }}
                                    <span class="material-symbols-outlined text-[18px]">play_circle</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-surface-container-lowest editorial-shadow rounded-xl border border-dashed border-indigo-200 p-12 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center text-primary mb-4">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <h2 class="text-2xl font-bold font-headline text-on-surface">
                    @if ($activeTab === 'completed')
                        No completed courses yet
                    @elseif ($activeTab === 'archived')
                        No archived courses yet
                    @else
                        No active learning items yet
                    @endif
                </h2>
                <p class="mt-2 text-on-surface-variant max-w-xl mx-auto">
                    @if ($activeTab === 'completed')
                        Finish a course and it will appear here with its completed progress.
                    @elseif ($activeTab === 'archived')
                        Archived learning items will appear here once that workflow is added.
                    @else
                        Enroll in a course to start building your learning path and track your progress here.
                    @endif
                </p>
                <a class="inline-flex items-center gap-2 mt-6 bg-primary text-white px-5 py-3 rounded-xl font-semibold shadow-lg shadow-indigo-500/20" href="/student/browse-courses">
                    <span class="material-symbols-outlined text-sm">explore</span>
                    Browse Courses
                </a>
            </div>
        @endif

        <div class="h-12"></div>

        <div class="fixed bottom-10 right-10 z-50 bg-white/70 backdrop-blur-xl editorial-shadow rounded-xl p-5 border-l-4 border-tertiary flex items-center gap-4 max-w-sm">
            <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center">
                <span class="material-symbols-outlined text-tertiary text-[20px]">workspace_premium</span>
            </div>
            <div>
                <p class="text-xs font-bold font-label text-tertiary uppercase tracking-widest mb-0.5">Achievement Unlocked</p>
                <p class="text-sm font-body text-on-surface">
                    @if ($streakDays > 0)
                        Consistent Scholar: {{ $streakDays }} day learning streak!
                    @else
                        Start a lesson today to begin your learning streak.
                    @endif
                </p>
            </div>
            <button class="text-slate-400 hover:text-on-surface transition-all ml-2" onclick="this.parentElement.remove()" type="button">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    </main>

    <script>
        document.querySelectorAll('.js-progress-fill').forEach(function (element) {
            var progress = Number(element.getAttribute('data-progress') || '0');
            element.style.width = Math.max(0, Math.min(100, progress)) + '%';
        });
    </script>
</body>

</html>
