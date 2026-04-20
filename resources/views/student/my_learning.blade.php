<x-student.layout title="My Learning | CodeInYourself">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Learning Flow</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">My Learning</p>
    </div>

    <x-slot:center>
        <label class="student-top-search">
            <span class="material-symbols-outlined text-on-surface-variant">search</span>
            <input placeholder="Search enrolled courses" type="text" />
        </label>
    </x-slot:center>

    <x-slot:right>
        <a class="student-pill-button student-pill-button--ghost hidden md:inline-flex" href="{{ route('student.dashboard') }}">Dashboard</a>
        <img alt="Student Profile" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $studentAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Learning Flow</p>
                <h1 class="student-page-title">Keep the streak alive</h1>
                <p class="student-page-copy">{{ $hero['in_progress_count'] }} courses in progress, {{ $hero['completed_lessons_this_week'] }} lessons completed this week, and a tighter learning workspace around active work.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $courseCount }} visible course{{ $courseCount === 1 ? '' : 's' }}</span>
                <span class="student-chip">{{ $streakDays }} day streak</span>
                <span class="student-chip">{{ $hero['target_percent'] }}% weekly target</span>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">In Progress</p>
                        <p class="student-stat-value">{{ $hero['in_progress_count'] }}</p>
                        <p class="student-stat-copy">Courses moving forward</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Lessons This Week</p>
                        <p class="student-stat-value">{{ $hero['completed_lessons_this_week'] }}</p>
                        <p class="student-stat-copy">Completed sessions</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Target</p>
                        <p class="student-stat-value">{{ $hero['target_percent'] }}%</p>
                        <p class="student-stat-copy">Weekly completion goal</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-1">
                <div class="rounded-[1.2rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] p-5 text-white shadow-[0_16px_34px_rgba(149,85,246,0.22)]">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/60">Week Target</p>
                    <p class="mt-4 font-headline text-4xl font-extrabold">{{ $hero['target_percent'] }}%</p>
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-white/15">
                        <div class="js-progress-fill h-full rounded-full bg-gradient-to-r from-white via-[#d8ceff] to-[#a855f7]" data-progress="{{ $hero['target_percent'] }}"></div>
                    </div>
                </div>

                <div class="rounded-[1.6rem] bg-surface-container-lowest p-6">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Achievement</p>
                    <p class="mt-4 font-headline text-2xl font-extrabold text-on-surface">
                        @if ($streakDays > 0)
                            {{ $streakDays }} day consistency streak
                        @else
                            Start your next streak today
                        @endif
                    </p>
                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">A steadier rhythm leads to faster completions and stronger retention.</p>
                </div>
            </div>
        </section>

        <section class="rounded-[1.6rem] bg-surface-container-lowest p-3 sm:p-4">
            <div class="flex flex-wrap gap-2">
                <a @class([
                    'rounded-[1rem] px-5 py-3 text-sm font-bold transition-all',
                    'bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_26px_rgba(149,85,246,0.2)]' => $activeTab === 'in-progress',
                    'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' => $activeTab !== 'in-progress',
                ]) href="{{ route('student.my-learning', ['tab' => 'in-progress']) }}">In Progress</a>
                <a @class([
                    'rounded-[1rem] px-5 py-3 text-sm font-bold transition-all',
                    'bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_26px_rgba(149,85,246,0.2)]' => $activeTab === 'completed',
                    'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' => $activeTab !== 'completed',
                ]) href="{{ route('student.my-learning', ['tab' => 'completed']) }}">Completed</a>
                <a @class([
                    'rounded-[1rem] px-5 py-3 text-sm font-bold transition-all',
                    'bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_26px_rgba(149,85,246,0.2)]' => $activeTab === 'archived',
                    'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' => $activeTab !== 'archived',
                ]) href="{{ route('student.my-learning', ['tab' => 'archived']) }}">Archived</a>
            </div>
        </section>

        @if ($courses->isNotEmpty())
            <section class="grid gap-6 md:grid-cols-2 2xl:grid-cols-3">
                @foreach ($courses as $course)
                    <article class="overflow-hidden rounded-[1.75rem] bg-surface-container-lowest">
                        <div class="relative h-56 overflow-hidden">
                            <img alt="{{ $course['title'] }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ $course['thumbnail'] }}" />
                            <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-black/65 to-transparent"></div>
                            <div class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-primary">{{ $course['badge'] }}</div>
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between gap-3 text-white">
                                <div>
                                    <h3 class="font-headline text-xl font-extrabold">{{ $course['title'] }}</h3>
                                    <p class="mt-1 text-xs text-white/70">{{ $course['instructor_name'] }}</p>
                                </div>
                                <span class="rounded-full bg-white/14 px-3 py-2 text-xs font-bold">{{ $course['lesson_text'] }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm leading-7 text-on-surface-variant">{{ \Illuminate\Support\Str::limit($course['description'], 135) }}</p>
                            <div class="mt-5">
                                <div class="mb-2 flex items-center justify-between text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">
                                    <span>{{ $course['progress_text'] }}</span>
                                    <span>{{ $course['progress_percent'] }}%</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-surface-container-low">
                                    <div class="{{ $course['accent_class'] }} js-progress-fill h-full rounded-full" data-progress="{{ $course['progress_percent'] }}"></div>
                                </div>
                            </div>
                            <div class="mt-5 flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Next Lesson</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $course['next_lesson'] }}</p>
                                </div>
                                <a class="student-pill-button student-pill-button--primary" href="{{ $course['cta_url'] }}">{{ $course['cta_label'] }}</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>
        @else
            <section class="rounded-[1.3rem] bg-surface-container-lowest p-9 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1rem] bg-[#f0ebff] text-primary">
                    <span class="material-symbols-outlined text-4xl">school</span>
                </div>
                <h2 class="mt-5 font-headline text-[1.9rem] font-extrabold text-on-surface">
                    @if ($activeTab === 'completed')
                        No completed courses yet
                    @elseif ($activeTab === 'archived')
                        No archived courses yet
                    @else
                        No active learning items yet
                    @endif
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant">
                    @if ($activeTab === 'completed')
                        Finish a course and it will appear here with completion status and polished progress summaries.
                    @elseif ($activeTab === 'archived')
                        Archived learning items will appear here once that workflow is added.
                    @else
                        Enroll in a course to start building your learning path and track your progress here.
                    @endif
                </p>
                <a class="student-pill-button student-pill-button--primary mt-8" href="{{ route('student.browse-courses') }}">Browse Courses</a>
            </section>
        @endif
    </div>
</main>

<script>
    document.querySelectorAll('.js-progress-fill').forEach(function (element) {
        var progress = Number(element.getAttribute('data-progress') || '0');
        element.style.width = Math.max(0, Math.min(100, progress)) + '%';
    });
</script>
</x-student.layout>
