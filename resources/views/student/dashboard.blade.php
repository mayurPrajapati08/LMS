<x-student.layout title="CodeInYourself | Student Dashboard">
@php
    $featuredCourseOne = $continueLearning->get(0);
    $featuredCourseTwo = $continueLearning->get(1);
    $curriculumCards = collect([$curriculumCourses->get(0), $curriculumCourses->get(1), $curriculumCourses->get(2)])->filter();
@endphp

<x-student.topbar>
    <div class="flex items-center gap-3">
        <span class="flex h-11 w-11 items-center justify-center rounded-[1rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_28px_rgba(149,85,246,0.22)]">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">space_dashboard</span>
        </span>
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Student Area</p>
            <p class="font-headline text-lg font-extrabold text-on-surface">Dashboard</p>
        </div>
    </div>

    <x-slot:center>
        <label class="student-top-search">
            <span class="material-symbols-outlined text-on-surface-variant">search</span>
            <input placeholder="Search lessons, courses, or notes" type="text" />
        </label>
    </x-slot:center>

    <x-slot:right>
        <a class="student-pill-button student-pill-button--ghost hidden md:inline-flex" href="{{ route('student.browse-courses') }}">Catalog</a>
        <button class="student-pill-button student-pill-button--ghost" type="button">
            <span class="material-symbols-outlined text-base">notifications</span>
            Alerts
        </button>
        <img alt="Student Profile" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $studentAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Overview</p>
                <h1 class="student-page-title">Welcome back, {{ $welcomeName }}</h1>
                <p class="student-page-copy">A cleaner student dashboard built around momentum, active courses, and fewer oversized UI distractions.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $stats['new_this_month'] }} new this month</span>
                <span class="student-chip">{{ $stats['graduation_rate'] }}% graduation rate</span>
            </div>
        </section>

        <section class="student-stats-strip">
            <div class="student-stat">
                <p class="student-stat-label">Courses</p>
                <p class="student-stat-value">{{ str_pad((string) $stats['enrolled_courses'], 2, '0', STR_PAD_LEFT) }}</p>
                <p class="student-stat-copy">Enrolled right now</p>
            </div>
            <div class="student-stat">
                <p class="student-stat-label">Completed</p>
                <p class="student-stat-value">{{ str_pad((string) $stats['completed_courses'], 2, '0', STR_PAD_LEFT) }}</p>
                <p class="student-stat-copy">Finished courses</p>
            </div>
            <div class="student-stat">
                <p class="student-stat-label">Learning Hours</p>
                <p class="student-stat-value">{{ $stats['learning_hours'] }}h</p>
                <p class="student-stat-copy">
                    @if ($stats['learning_months'] > 0)
                        Active for {{ $stats['learning_months'] }} month{{ $stats['learning_months'] === 1 ? '' : 's' }}
                    @else
                        Start your first streak
                    @endif
                </p>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="student-section">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="student-eyebrow">Focus Board</p>
                        <h2 class="mt-2 font-headline text-[1.8rem] font-bold tracking-[-0.04em] text-on-surface">Continue the work that matters most.</h2>
                    </div>
                    <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.my-learning') }}">Open Learning</a>
                </div>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant">Your active lessons, progress, and next moves sit together here so the page feels fast to scan and easy to use.</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="student-chip">{{ $activeCourseCount }} active courses</span>
                    <span class="student-chip">{{ $weeklyHours }}h this week</span>
                    <span class="student-chip">{{ $stats['completed_courses'] }} completed</span>
                </div>
            </div>

            <div class="student-side-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Focus Signal</p>
                <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface">{{ $dashboardInsight['title'] }}</h2>
                <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $dashboardInsight['message'] }}</p>

                <div class="mt-8 grid gap-4">
                    <div class="rounded-[1.35rem] bg-surface-container-low p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Weekly Hours</p>
                        <p class="mt-2 font-headline text-3xl font-extrabold text-on-surface">{{ $weeklyHours }}h</p>
                    </div>
                    <div class="rounded-[1.35rem] bg-surface-container-low p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Active Courses</p>
                        <p class="mt-2 font-headline text-3xl font-extrabold text-on-surface">{{ $activeCourseCount }}</p>
                    </div>
                </div>

                <a class="student-pill-button student-pill-button--primary mt-8 w-full justify-center" href="{{ $dashboardInsight['href'] }}">
                    {{ $dashboardInsight['button_label'] }}
                </a>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-side-card">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Resume Rail</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">Continue where the momentum is highest.</h2>
                    </div>
                    <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.my-learning') }}">Open Learning</a>
                </div>

                <div class="mt-8 grid gap-6">
                    @foreach ([$featuredCourseOne, $featuredCourseTwo] as $index => $course)
                        <article class="overflow-hidden rounded-[1.2rem] {{ $index === 0 ? 'bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white' : 'bg-white text-on-surface ring-1 ring-[#ede2fb]' }}">
                            <div class="grid gap-0 lg:grid-cols-[220px_minmax(0,1fr)]">
                                <img alt="{{ $course['title'] ?? 'Course preview' }}" class="h-full w-full object-cover" src="{{ $course['thumbnail'] ?? 'https://ui-avatars.com/api/?name=Course&background=E2E8F0&color=334155&size=320' }}" />
                                <div class="p-6">
                                    <div class="flex flex-wrap gap-2 text-[10px] font-bold uppercase tracking-[0.18em] {{ $index === 0 ? 'text-white/65' : 'text-on-surface-variant' }}">
                                        <span>{{ $course['level_label'] ?? 'Beginner' }}</span>
                                        <span>{{ $course['category_name'] ?? 'Course' }}</span>
                                    </div>
                                    <h3 class="mt-4 font-headline text-2xl font-extrabold">{{ $course['title'] ?? 'Choose a course' }}</h3>
                                    <p class="mt-3 text-sm leading-7 {{ $index === 0 ? 'text-white/72' : 'text-on-surface-variant' }}">{{ $course['next_lesson_label'] ?? 'Your next lesson will appear here.' }}</p>
                                    <div class="mt-5 h-2 overflow-hidden rounded-full {{ $index === 0 ? 'bg-white/15' : 'bg-surface-container-low' }}">
                                        <div class="{{ $course['accent']['progress'] ?? 'bg-gradient-to-r from-primary to-primary-container' }} js-progress-fill h-full rounded-full" data-progress="{{ $course['progress_percent'] ?? 0 }}"></div>
                                    </div>
                                    <div class="mt-5 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                                        <p class="text-sm font-semibold {{ $index === 0 ? 'text-white/84' : 'text-on-surface' }}">{{ $course['progress_label'] ?? '0% complete' }}</p>
                                        <a class="student-pill-button {{ $index === 0 ? 'student-pill-button--ghost bg-white text-primary' : 'student-pill-button--primary' }}" href="{{ $course['resume_url'] ?? route('student.browse-courses') }}">
                                            {{ $course['button_label'] ?? 'Open Course' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-5">
                <div class="student-side-card">
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Weekly Rhythm</p>
                    <h2 class="mt-3 font-headline text-2xl font-extrabold text-on-surface">Seven-day activity map</h2>
                    <div class="mt-6 flex items-end gap-2 sm:gap-3">
                        @foreach ($weeklyEngagement as $day)
                            <div class="flex-1 text-center">
                                <div class="mx-auto h-20 w-full max-w-[2rem] rounded-[1rem] bg-[linear-gradient(180deg,#6f4ef6,#d16bf2)] sm:h-24 sm:max-w-[2.5rem] {{ $day['opacity_class'] }}"></div>
                                <p class="mt-3 text-[10px] font-bold uppercase tracking-[0.14em] text-on-surface-variant">{{ $day['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-6 text-sm leading-7 text-on-surface-variant">
                        @if ($weeklyHours > 0)
                            You logged {{ $weeklyHours }}h this week across {{ $activeCourseCount }} active course{{ $activeCourseCount === 1 ? '' : 's' }}.
                        @else
                            Start a lesson this week and your activity rhythm will fill in here.
                        @endif
                    </p>
                </div>

                <div class="student-side-card">
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Quick Access</p>
                    <div class="mt-5 grid gap-3">
                        <a class="rounded-[1.2rem] bg-surface-container-low px-4 py-4 text-sm font-bold text-on-surface transition hover:bg-surface-container-high" href="{{ route('student.certificates') }}">Open Certificates</a>
                        <a class="rounded-[1.2rem] bg-surface-container-low px-4 py-4 text-sm font-bold text-on-surface transition hover:bg-surface-container-high" href="{{ route('student.wishlist') }}">Open Wishlist</a>
                        <a class="rounded-[1.2rem] bg-surface-container-low px-4 py-4 text-sm font-bold text-on-surface transition hover:bg-surface-container-high" href="{{ route('student.support') }}">Open Support</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Curriculum Stack</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">Your active courses, re-laid as a proper workspace.</h2>
                </div>
                <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.browse-courses') }}">Add More</a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($curriculumCards as $card)
                    <article class="rounded-[1.6rem] bg-surface-container-lowest p-5">
                        <div class="relative h-40 overflow-hidden rounded-[1.25rem]">
                            <img alt="{{ $card['title'] ?? 'Course card' }}" class="h-full w-full object-cover" src="{{ $card['thumbnail'] ?? 'https://ui-avatars.com/api/?name=Course&background=E2E8F0&color=334155&size=320' }}" />
                            <div class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-primary">
                                {{ $card['category_badge'] ?? 'Course' }}
                            </div>
                        </div>
                        <div class="mt-5">
                            <h3 class="font-headline text-lg font-extrabold text-on-surface">{{ $card['title'] ?? 'Course' }}</h3>
                            <p class="mt-2 text-xs text-on-surface-variant">Instructor: {{ $card['instructor_name'] ?? 'Instructor' }}</p>
                        </div>
                        <div class="mt-5">
                            <div class="mb-2 flex justify-between text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">
                                <span>Progress</span>
                                <span>{{ $card['progress_percent'] ?? 0 }}%</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-surface-container-low">
                                <div class="js-progress-fill h-full rounded-full bg-gradient-to-r from-primary to-primary-container" data-progress="{{ $card['progress_percent'] ?? 0 }}"></div>
                            </div>
                        </div>
                        <a class="student-pill-button student-pill-button--ghost mt-6 w-full justify-center" href="{{ $card['resume_url'] ?? route('student.browse-courses') }}">{{ $card['button_label'] ?? 'Open' }}</a>
                    </article>
                @endforeach

                <article class="rounded-[1.6rem] border border-dashed border-primary/25 bg-surface-container-lowest p-5 text-center">
                    <div class="flex h-40 items-center justify-center rounded-[1.25rem] bg-[#f4f0ff]">
                        <div>
                            <span class="material-symbols-outlined text-4xl text-primary">add_circle</span>
                            <p class="mt-3 text-[11px] font-bold uppercase tracking-[0.22em] text-primary">Expand Stack</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-on-surface-variant">Bring another course into rotation and keep the dashboard alive.</p>
                    <a class="student-pill-button student-pill-button--primary mt-6 w-full justify-center" href="{{ route('student.browse-courses') }}">Browse Catalog</a>
                </article>
            </div>
        </section>
    </div>
</main>

<a class="fixed bottom-8 right-8 z-50 flex h-16 w-16 items-center justify-center rounded-[1.2rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_18px_40px_rgba(149,85,246,0.24)] transition hover:scale-105" href="{{ route('student.support') }}">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat_bubble</span>
</a>

<script>
    document.querySelectorAll('.js-progress-fill').forEach(function (element) {
        var progress = Number(element.getAttribute('data-progress') || '0');
        element.style.width = Math.max(0, Math.min(100, progress)) + '%';
    });
</script>
</x-student.layout>
