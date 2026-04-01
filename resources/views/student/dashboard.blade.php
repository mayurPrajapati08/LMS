<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself | Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#3b5f8d",
                        "surface-tint": "#1570d8",
                        "inverse-on-surface": "#f5fbff",
                        "secondary-fixed": "#e8f3ff",
                        "on-primary-fixed": "#0f0069",
                        "error-container": "#ffdad6",
                        "tertiary": "#005523",
                        "tertiary-container": "#007030",
                        "on-secondary-fixed-variant": "#315b90",
                        "tertiary-fixed": "#6bff8f",
                        "secondary-fixed-dim": "#b9dcff",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#0a4b99",
                        "error": "#ba1a1a",
                        "surface-container-low": "#eef5ff",
                        "secondary-container": "#d7e9ff",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#b9dcff",
                        "outline-variant": "#d5e4ff",
                        "on-surface": "#191c1d",
                        "surface-dim": "#d4e3f8",
                        "on-secondary-fixed": "#072a60",
                        "inverse-primary": "#b9dcff",
                        "on-surface-variant": "#4f6178",
                        "tertiary-fixed-dim": "#4ae176",
                        "on-primary-container": "#edf5ff",
                        "inverse-surface": "#18345f",
                        "outline": "#7c8da7",
                        "primary-container": "#1570d8",
                        "on-background": "#191c1d",
                        "surface-container-high": "#e3eeff",
                        "surface-container": "#e9f2ff",
                        "on-tertiary-fixed-variant": "#005321",
                        "primary-fixed": "#e8f3ff",
                        "surface-bright": "#f4f9ff",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-container": "#63f889",
                        "surface-container-highest": "#dbe8ff",
                        "on-error-container": "#93000a",
                        "background": "#f4f9ff",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#0c4ea3",
                        "on-secondary-container": "#41648d",
                        "surface-variant": "#dbe8ff",
                        "on-secondary": "#ffffff",
                        "surface": "#f4f9ff"
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
            background-color: #f4f9ff;
            color: #191c1d;
        }

        .asymmetric-header {
            margin-left: -2rem;
        }
    </style>
</head>

<body class="font-body selection:bg-primary-fixed-dim selection:text-on-primary-fixed">
    @php
        $featuredCourseOne = $continueLearning->get(0);
        $featuredCourseTwo = $continueLearning->get(1);
        $curriculumOne = $curriculumCourses->get(0);
        $curriculumTwo = $curriculumCourses->get(1);
        $curriculumThree = $curriculumCourses->get(2);
    @endphp
    
    <!-- // Side Navigation -->
    <x-student.navbar />

    <!-- Main Content Area -->
    <main class="md:ml-64 min-h-screen">
        <!-- TopNavBar -->
        <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 shadow-sm dark:shadow-none">
            <div class="flex items-center gap-2 text-[#0c4ea3] font-bold font-['Inter'] text-sm">
                <span class="material-symbols-outlined" data-icon="school">school</span>
                Learning Workspace
            </div>
            <div class="ml-auto flex items-center gap-4 md:gap-6">
                <div class="relative group w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
                    <input class="bg-surface-container-low border-none rounded-xl px-4 py-2 text-sm w-full md:w-64 focus:ring-2 focus:ring-[#edf5ff]0/20 transition-all outline-none" placeholder="Search..." type="text" />
                    <span class="material-symbols-outlined absolute right-3 top-2 text-slate-400 text-lg" data-icon="search">search</span>
                </div>
                <div class="flex items-center gap-4 text-slate-500">
                    <button class="hover:text-[#1570d8] transition-all flex items-center justify-center">
                        <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                    </a>
                    <img alt="Student Profile" class="h-10 w-10 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $studentAvatar }}" />
                </div>
            </div>
        </header>
        <!-- Canvas -->
        <div class="pt-24 px-4 md:px-12 pb-12 max-w-7xl mx-auto space-y-12">
            <!-- Welcome Section -->
            <section class="relative">
                <div class="asymmetric-header pl-8 space-y-2">
                    <p class="text-label-md font-label uppercase tracking-widest text-primary font-semibold">Dashboard Overview</p>
                    <h1 class="font-headline text-5xl md:text-6xl font-extrabold tracking-tight text-on-surface leading-tight">
                        Welcome back,<br /><span class="text-primary italic">{{ $welcomeName }}.</span>
                    </h1>
                </div>
                <!-- Quick Stats Bento -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                    <div class="bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm border-l-4 border-indigo-500 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-5 scale-150">
                            <span class="material-symbols-outlined text-8xl" data-icon="auto_stories">auto_stories</span>
                        </div>
                        <p class="text-sm font-semibold text-on-surface-variant font-label mb-1">Enrolled Courses</p>
                        <h3 class="text-4xl font-bold font-headline">{{ str_pad((string) $stats['enrolled_courses'], 2, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-xs text-tertiary mt-2 flex items-center gap-1 font-medium">
                            <span class="material-symbols-outlined text-xs" data-icon="trending_up">trending_up</span>
                            {{ $stats['new_this_month'] }} new this month
                        </p>
                    </div>
                    <div class="bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm border-l-4 border-emerald-500 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-5 scale-150">
                            <span class="material-symbols-outlined text-8xl" data-icon="workspace_premium">workspace_premium</span>
                        </div>
                        <p class="text-sm font-semibold text-on-surface-variant font-label mb-1">Completed Courses</p>
                        <h3 class="text-4xl font-bold font-headline">{{ str_pad((string) $stats['completed_courses'], 2, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs" data-icon="check_circle">check_circle</span>
                            {{ $stats['graduation_rate'] }}% Graduation rate
                        </p>
                    </div>
                    <div class="bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm border-l-4 border-amber-500 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-5 scale-150">
                            <span class="material-symbols-outlined text-8xl" data-icon="history">history</span>
                        </div>
                        <p class="text-sm font-semibold text-on-surface-variant font-label mb-1">Learning Hours</p>
                        <h3 class="text-4xl font-bold font-headline">{{ $stats['learning_hours'] }}<span class="text-xl font-normal text-slate-400">h</span></h3>
                        <p class="text-xs text-slate-400 mt-2">
                            @if ($stats['learning_months'] > 0)
                                Active learner for {{ $stats['learning_months'] }} month{{ $stats['learning_months'] === 1 ? '' : 's' }}
                            @else
                                Start your first course to build momentum
                            @endif
                        </p>
                    </div>
                </div>
            </section>
            <!-- Continue Learning Section -->
            <section class="space-y-6">
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="text-headline-md font-headline font-bold text-on-surface">Continue Learning</h2>
                        <p class="text-on-surface-variant text-sm mt-1">Pick up right where you left off.</p>
                    </div>
                    <a class="text-primary font-semibold text-sm hover:underline" href="/student/my-learning">View All Active</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Featured Horizontal Card -->
                    <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm flex flex-col md:flex-row group transition-all hover:scale-[1.01]">
                        <div class="md:w-48 h-48 md:h-auto overflow-hidden">
                            <img alt="{{ $featuredCourseOne['title'] ?? 'Course preview' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $featuredCourseOne['thumbnail'] ?? 'https://ui-avatars.com/api/?name=New+Course&background=E2E8F0&color=334155&size=320' }}" />
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2 py-1 {{ $featuredCourseOne['accent']['badge'] ?? 'bg-secondary-fixed text-on-secondary-fixed-variant' }} text-[10px] font-bold uppercase rounded tracking-wider">{{ $featuredCourseOne['level_label'] ?? 'Beginner' }}</span>
                                    <span class="text-xs text-slate-400">{{ $featuredCourseOne['category_name'] ?? 'Start Learning' }}</span>
                                </div>
                                <h4 class="font-headline font-bold text-xl mb-2 group-hover:text-primary transition-colors">{{ $featuredCourseOne['title'] ?? 'Choose your first course' }}</h4>
                                <div class="w-full bg-surface-container-low h-1.5 rounded-full mt-4 overflow-hidden">
                                    <div class="{{ $featuredCourseOne['accent']['progress'] ?? 'bg-gradient-to-r from-primary to-primary-container' }} h-full js-progress-fill" data-progress="{{ $featuredCourseOne['progress_percent'] ?? 0 }}"></div>
                                </div>
                                <p class="text-xs text-on-surface-variant mt-2">{{ $featuredCourseOne['progress_label'] ?? '0% complete' }} &bull; {{ $featuredCourseOne['next_lesson_label'] ?? 'Enroll to unlock your next lesson' }}</p>
                            </div>
                            <a class="mt-6 flex items-center justify-center gap-2 {{ $featuredCourseOne['accent']['button'] ?? 'bg-primary text-on-primary hover:bg-primary-container' }} px-4 py-2.5 rounded-xl font-semibold text-sm transition-all" href="{{ $featuredCourseOne['resume_url'] ?? '/student/browse-courses' }}">
                                <span class="material-symbols-outlined text-sm" data-icon="play_circle">play_circle</span>
                                {{ $featuredCourseOne['button_label'] ?? 'Start Learning' }}
                            </a>
                        </div>
                    </div>
                    <!-- Featured Horizontal Card 2 -->
                    <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm flex flex-col md:flex-row group transition-all hover:scale-[1.01]">
                        <div class="md:w-48 h-48 md:h-auto overflow-hidden">
                            <img alt="{{ $featuredCourseTwo['title'] ?? 'Course preview' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $featuredCourseTwo['thumbnail'] ?? 'https://ui-avatars.com/api/?name=Browse+Courses&background=E2E8F0&color=334155&size=320' }}" />
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2 py-1 {{ $featuredCourseTwo['accent']['badge'] ?? 'bg-tertiary-fixed text-on-tertiary-fixed-variant' }} text-[10px] font-bold uppercase rounded tracking-wider">{{ $featuredCourseTwo['level_label'] ?? 'New' }}</span>
                                    <span class="text-xs text-slate-400">{{ $featuredCourseTwo['category_name'] ?? 'Keep exploring' }}</span>
                                </div>
                                <h4 class="font-headline font-bold text-xl mb-2 group-hover:text-primary transition-colors">{{ $featuredCourseTwo['title'] ?? 'Find another course to continue' }}</h4>
                                <div class="w-full bg-surface-container-low h-1.5 rounded-full mt-4 overflow-hidden">
                                    <div class="{{ $featuredCourseTwo['accent']['progress'] ?? 'bg-gradient-to-r from-primary to-primary-container' }} h-full js-progress-fill" data-progress="{{ $featuredCourseTwo['progress_percent'] ?? 0 }}"></div>
                                </div>
                                <p class="text-xs text-on-surface-variant mt-2">{{ $featuredCourseTwo['progress_label'] ?? '0% complete' }} &bull; {{ $featuredCourseTwo['next_lesson_label'] ?? 'Browse your next lesson' }}</p>
                            </div>
                            <a class="mt-6 flex items-center justify-center gap-2 {{ $featuredCourseTwo['accent']['button'] ?? 'bg-surface-container-high text-primary hover:bg-surface-container-highest' }} px-4 py-2.5 rounded-xl font-semibold text-sm transition-all" href="{{ $featuredCourseTwo['resume_url'] ?? '/student/browse-courses' }}">
                                <span class="material-symbols-outlined text-sm" data-icon="play_circle">play_circle</span>
                                {{ $featuredCourseTwo['button_label'] ?? 'Browse Courses' }}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Enrolled Courses Grid -->
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-headline-md font-headline font-bold text-on-surface">Your Curriculum</h2>
                    <div class="flex gap-2">
                        <button class="w-8 h-8 rounded-full bg-surface-container-lowest flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors" type="button">
                            <span class="material-symbols-outlined text-sm" data-icon="grid_view">grid_view</span>
                        </button>
                        <button class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:bg-surface-container-high transition-colors" type="button">
                            <span class="material-symbols-outlined text-sm" data-icon="list">list</span>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Course Card 1 -->
                    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-sm space-y-4 flex flex-col transition-all hover:-translate-y-1">
                        <div class="h-32 bg-surface-container-low rounded-lg overflow-hidden relative">
                            <img alt="{{ $curriculumOne['title'] ?? 'Course card' }}" class="w-full h-full object-cover" src="{{ $curriculumOne['thumbnail'] ?? 'https://ui-avatars.com/api/?name=Course&background=E2E8F0&color=334155&size=320' }}" />
                            <div class="absolute top-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur text-[10px] font-bold rounded">{{ $curriculumOne['category_badge'] ?? 'NEW' }}</div>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h5 class="font-bold text-sm leading-tight">{{ $curriculumOne['title'] ?? 'Your first enrolled course' }}</h5>
                            <p class="text-xs text-slate-500">Instructor: {{ $curriculumOne['instructor_name'] ?? 'Instructor' }}</p>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-[10px] font-bold text-on-surface-variant">
                                <span>PROGRESS</span>
                                <span>{{ $curriculumOne['progress_percent'] ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-surface-container-low h-1 rounded-full overflow-hidden">
                                <div class="bg-[#edf5ff]0 h-full js-progress-fill" data-progress="{{ $curriculumOne['progress_percent'] ?? 0 }}"></div>
                            </div>
                        </div>
                        <a class="w-full py-2 bg-surface-container-low text-[#0c4ea3] rounded-lg text-xs font-bold hover:bg-[#edf5ff] transition-colors text-center" href="{{ $curriculumOne['resume_url'] ?? '/student/browse-courses' }}">{{ $curriculumOne['button_label'] ?? 'Browse' }}</a>
                    </div>
                    <!-- Course Card 2 -->
                    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-sm space-y-4 flex flex-col transition-all hover:-translate-y-1">
                        <div class="h-32 bg-surface-container-low rounded-lg overflow-hidden relative">
                            <img alt="{{ $curriculumTwo['title'] ?? 'Course card' }}" class="w-full h-full object-cover" src="{{ $curriculumTwo['thumbnail'] ?? 'https://ui-avatars.com/api/?name=Course&background=E2E8F0&color=334155&size=320' }}" />
                            <div class="absolute top-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur text-[10px] font-bold rounded">{{ $curriculumTwo['category_badge'] ?? 'NEW' }}</div>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h5 class="font-bold text-sm leading-tight">{{ $curriculumTwo['title'] ?? 'Add another course' }}</h5>
                            <p class="text-xs text-slate-500">Instructor: {{ $curriculumTwo['instructor_name'] ?? 'Instructor' }}</p>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-[10px] font-bold text-on-surface-variant">
                                <span>PROGRESS</span>
                                <span>{{ $curriculumTwo['progress_percent'] ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-surface-container-low h-1 rounded-full overflow-hidden">
                                <div class="bg-[#edf5ff]0 h-full js-progress-fill" data-progress="{{ $curriculumTwo['progress_percent'] ?? 0 }}"></div>
                            </div>
                        </div>
                        <a class="w-full py-2 bg-surface-container-low text-[#0c4ea3] rounded-lg text-xs font-bold hover:bg-[#edf5ff] transition-colors text-center" href="{{ $curriculumTwo['resume_url'] ?? '/student/browse-courses' }}">{{ $curriculumTwo['button_label'] ?? 'Browse' }}</a>
                    </div>
                    <!-- Course Card 3 -->
                    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-sm space-y-4 flex flex-col transition-all hover:-translate-y-1">
                        <div class="h-32 bg-surface-container-low rounded-lg overflow-hidden relative">
                            <img alt="{{ $curriculumThree['title'] ?? 'Course card' }}" class="w-full h-full object-cover" src="{{ $curriculumThree['thumbnail'] ?? 'https://ui-avatars.com/api/?name=Course&background=E2E8F0&color=334155&size=320' }}" />
                            <div class="absolute top-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur text-[10px] font-bold rounded">{{ $curriculumThree['category_badge'] ?? 'NEW' }}</div>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h5 class="font-bold text-sm leading-tight">{{ $curriculumThree['title'] ?? 'Keep building your curriculum' }}</h5>
                            <p class="text-xs text-slate-500">Instructor: {{ $curriculumThree['instructor_name'] ?? 'Instructor' }}</p>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-[10px] font-bold text-on-surface-variant">
                                <span>PROGRESS</span>
                                <span>{{ $curriculumThree['progress_percent'] ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-surface-container-low h-1 rounded-full overflow-hidden">
                                <div class="bg-[#edf5ff]0 h-full js-progress-fill" data-progress="{{ $curriculumThree['progress_percent'] ?? 0 }}"></div>
                            </div>
                        </div>
                        <a class="w-full py-2 bg-surface-container-low text-[#0c4ea3] rounded-lg text-xs font-bold hover:bg-[#edf5ff] transition-colors text-center" href="{{ $curriculumThree['resume_url'] ?? '/student/browse-courses' }}">{{ $curriculumThree['button_label'] ?? 'Browse' }}</a>
                    </div>
                    <!-- Course Card 4 -->
                    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-sm space-y-4 flex flex-col transition-all hover:-translate-y-1 border border-primary/10">
                        <div class="h-32 bg-[#edf5ff] rounded-lg flex flex-col items-center justify-center text-center p-4">
                            <span class="material-symbols-outlined text-primary text-3xl mb-2" data-icon="add_circle">add_circle</span>
                            <p class="text-[10px] font-bold text-primary tracking-widest uppercase">Explore More</p>
                        </div>
                        <div class="flex-1 flex items-center">
                            <p class="text-xs text-slate-500 text-center w-full italic">Unlock a new world of knowledge today.</p>
                        </div>
                        <a class="w-full py-2 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-indigo-500/20 text-center" href="/student/browse-courses">Browse Catalog</a>
                    </div>
                </div>
            </section>
            <!-- Learning Insights Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Activity Heatmap Mockup -->
                <div class="lg:col-span-2 bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-headline font-bold text-lg">Weekly Engagement</h3>
                        <div class="flex items-center gap-4 text-[10px] font-bold text-on-surface-variant">
                            <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-primary-fixed"></span> Lighter</div>
                            <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-primary"></span> Intense</div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="flex gap-2 h-8">
                            @foreach ($weeklyEngagement as $day)
                                <div class="flex-1 bg-primary rounded-md {{ $day['opacity_class'] }}"></div>
                            @endforeach
                        </div>
                        <div class="flex justify-between text-[10px] font-bold text-slate-400 px-1 uppercase tracking-widest">
                            @foreach ($weeklyEngagement as $day)
                                <span>{{ $day['label'] }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-4 border-t border-surface-container-low flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                        <p class="text-sm text-on-surface-variant">
                            @if ($weeklyHours > 0)
                                You've logged <span class="text-[#0c4ea3] font-bold">{{ $weeklyHours }}h</span> this week across {{ $activeCourseCount }} active course{{ $activeCourseCount === 1 ? '' : 's' }}.
                            @else
                                Start a lesson this week and your engagement streak will appear here.
                            @endif
                        </p>
                        <a class="text-primary text-sm font-bold flex items-center gap-1" href="/student/my-learning">
                            View My Learning <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <!-- Instructor Insight Toast -->
                <div class="bg-surface p-6 rounded-xl shadow-sm border-l-4 border-tertiary flex flex-col gap-4 relative overflow-hidden backdrop-blur-md bg-white/60">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                            <span class="material-symbols-outlined" data-icon="lightbulb">lightbulb</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">{{ $dashboardInsight['title'] }}</h4>
                            <p class="text-xs text-on-surface-variant leading-relaxed mt-1">
                                {{ $dashboardInsight['message'] }}
                            </p>
                        </div>
                    </div>
                    <a class="mt-auto py-2 bg-tertiary-container/10 text-tertiary text-xs font-bold rounded-lg hover:bg-tertiary-container/20 transition-colors text-center" href="{{ $dashboardInsight['href'] }}">
                        {{ $dashboardInsight['button_label'] }}
                    </a>
                </div>
            </div>
        </div>
    </main>
    <!-- Contextual FAB -->
    <a class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-on-primary rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50" href="/student/messages-support">
        <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
    </a>
    <script>
        document.querySelectorAll('.js-progress-fill').forEach(function (element) {
            var progress = Number(element.getAttribute('data-progress') || '0');
            element.style.width = Math.max(0, Math.min(100, progress)) + '%';
        });
    </script>
</body>

</html>







