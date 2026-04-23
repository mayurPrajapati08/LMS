@php
    $heroCourse = $courseCards->first();
    $grantedAccess = (array) session('content_gate_access', []);
    $selectedCategoryName = $selectedCategory !== ''
        ? optional($categories->firstWhere('id', (int) $selectedCategory))->name
        : null;
    $selectedAudienceLabel = match ($selectedAudience ?? '') {
        'working-professional' => 'Working Professional',
        'college-student' => 'College Student',
        default => null,
    };
    $modeLabel = $catalogMode === 'offline' ? 'Offline Classroom Tracks' : 'Online Mentor-Led Programs';
@endphp

<x-home.marketing-layout title="Training Programs | CodeInYourself">
    <x-slot:head>
        <style>
            .course-experience {
                background:
                    radial-gradient(circle at top left, rgba(237, 130, 55, 0.08), transparent 18%),
                    radial-gradient(circle at top right, rgba(15, 118, 110, 0.08), transparent 18%),
                    linear-gradient(180deg, #fffaf4 0%, #f6f1ff 52%, #f8fbff 100%);
            }
            .catalog-hero {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(circle at 14% 18%, rgba(255,255,255,0.12), transparent 18%),
                    radial-gradient(circle at 84% 12%, rgba(251,191,36,0.18), transparent 18%),
                    linear-gradient(135deg, #082032 0%, #113a5c 42%, #5b2c83 100%);
            }
            .catalog-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 72px 72px;
                mask-image: radial-gradient(circle at center, black 28%, transparent 82%);
                pointer-events: none;
            }
            .catalog-shell {
                border: 1px solid rgba(255,255,255,0.12);
                background: linear-gradient(180deg, rgba(255,255,255,0.11), rgba(255,255,255,0.04));
                backdrop-filter: blur(14px);
            }
            .mode-pill {
                transition: transform .25s ease, box-shadow .25s ease, background-color .25s ease;
            }
            .mode-pill:hover { transform: translateY(-2px); }
            .catalog-panel {
                background:
                    radial-gradient(circle at top right, rgba(189,250,241,0.26), transparent 22%),
                    linear-gradient(180deg, rgba(255,255,255,0.99), rgba(250,246,255,0.98));
                box-shadow: 0 30px 90px rgba(50, 27, 78, 0.08);
            }
            .catalog-filter {
                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,245,252,0.92));
                box-shadow: 0 20px 54px rgba(50, 27, 78, 0.07);
            }
            .catalog-card {
                position: relative;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                height: 100%;
                background:
                    linear-gradient(180deg, rgba(255,255,255,1), rgba(251,247,253,0.97));
                box-shadow: 0 24px 60px rgba(50, 27, 78, 0.11);
                transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease, border-color .35s ease;
            }
            .catalog-card:hover {
                transform: translateY(-12px);
                box-shadow: 0 34px 86px rgba(50, 27, 78, 0.16);
            }
            .catalog-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,0.02) 50%, rgba(91,44,131,0.03));
                pointer-events: none;
            }
            .catalog-card::after {
                content: "";
                position: absolute;
                inset: auto -12% -18% auto;
                width: 11rem;
                height: 11rem;
                border-radius: 9999px;
                background: radial-gradient(circle, rgba(251,191,36,0.14), transparent 72%);
                pointer-events: none;
            }
            .catalog-card-media::after {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(180deg, rgba(8,32,50,0.02), rgba(8,32,50,0.12) 42%, rgba(8,32,50,0.86) 100%),
                    linear-gradient(135deg, rgba(255,255,255,0.02), rgba(91,44,131,0.22));
            }
            .catalog-card-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            .catalog-card-media::before {
                content: "";
                position: absolute;
                inset: auto 0 0 0;
                height: 38%;
                background: linear-gradient(180deg, transparent 0%, rgba(7, 21, 34, 0.72) 100%);
                z-index: 1;
            }
            .catalog-chip {
                background: rgba(255,255,255,0.84);
                box-shadow: inset 0 0 0 1px rgba(220, 208, 232, 0.72);
            }
            .catalog-kicker {
                background: linear-gradient(180deg, rgba(250,246,255,0.95), rgba(255,255,255,0.98));
                box-shadow: inset 0 0 0 1px rgba(217, 205, 230, 0.65);
            }
            .catalog-metric {
                background: linear-gradient(180deg, #ffffff 0%, #f8f4fb 100%);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.75), inset 0 0 0 1px rgba(226, 215, 236, 0.72);
            }
            .catalog-metric-label {
                font-size: 10px;
                letter-spacing: .2em;
                text-transform: uppercase;
                color: rgba(67, 56, 89, 0.68);
            }
            .catalog-detail-list {
                display: grid;
                gap: .75rem;
            }
            .catalog-detail-item {
                display: flex;
                align-items: flex-start;
                gap: .75rem;
                background: rgba(255,255,255,0.72);
                box-shadow: inset 0 0 0 1px rgba(230, 220, 239, 0.72);
            }
            .catalog-card-body {
                display: flex;
                flex: 1 1 auto;
                flex-direction: column;
                min-width: 0;
            }
            .catalog-kicker {
                gap: 1rem;
            }
            .catalog-kicker-copy,
            .catalog-kicker-icons,
            .catalog-price-copy {
                min-width: 0;
            }
            .catalog-kicker-icons {
                flex-shrink: 0;
                flex-wrap: wrap;
                justify-content: flex-end;
            }
            .catalog-title {
                overflow-wrap: anywhere;
            }
            .catalog-card-summary,
            .catalog-price-copy p,
            .catalog-detail-item p {
                overflow-wrap: anywhere;
            }
            .catalog-card-footer {
                margin-top: auto;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .catalog-card-footer .catalog-price-copy {
                max-width: 100%;
            }
            .catalog-card-footer .catalog-cta {
                width: 100%;
                justify-content: center;
                text-align: center;
                flex-shrink: 0;
            }
            @media (max-width: 767px) {
                .catalog-kicker {
                    flex-direction: column;
                    align-items: flex-start;
                }
                .catalog-kicker-icons {
                    justify-content: flex-start;
                }
            }
            .catalog-cta {
                position: relative;
                overflow: hidden;
                transition: transform .22s ease, box-shadow .22s ease;
            }
            .catalog-cta:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 40px rgba(91, 44, 131, 0.2);
            }
            .lead-gate-backdrop[hidden] { display: none !important; }
            .lead-gate-backdrop {
                position: fixed;
                inset: 0;
                z-index: 80;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                background: rgba(4, 10, 22, 0.62);
                backdrop-filter: blur(8px);
            }
            .lead-gate-dialog {
                width: min(100%, 38rem);
                border-radius: 2rem;
                background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(250,246,252,0.98));
                box-shadow: 0 30px 90px rgba(12, 18, 32, 0.28);
            }
            @media (max-width: 767px) {
                .catalog-hero { padding-bottom: 5rem; }
            }
        </style>
    </x-slot:head>

    
    <main class="course-experience overflow-x-hidden pb-24 pt-5">
        <section class="relative left-1/2 right-1/2 w-screen -translate-x-1/2">
            <div class="catalog-hero px-5 pb-20 pt-14 text-white sm:px-8 lg:px-10">
                <div class="mx-auto grid max-w-7xl gap-10 xl:grid-cols-[minmax(0,1.05fr)_minmax(320px,0.95fr)] xl:items-center">
                    <div class="relative z-10">
                        <span class="catalog-shell inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/84">
                            <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                            Training Program Experience
                        </span>
                        <h1 class="mt-6 max-w-4xl font-headline text-[2.25rem] font-extrabold leading-[0.96] sm:text-[2.9rem] lg:text-[4rem]">
                            Learn in the format that fits your pace,
                            <span class="block text-[#bdfaf1]">starting with offline-first clarity.</span>
                        </h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-white/76">
                            Explore classroom batches and mentor-led learning paths through a cleaner catalog. Prices stay off the page so the conversation stays focused on fit, timing, and the right mentor guidance.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('home.contact', ['topic' => 'mentorship', 'subject' => 'Need help choosing a training program']) }}" class="catalog-cta rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-[#113a5c]">Talk To Our Team</a>
                            <a href="#catalog-results" class="catalog-cta rounded-2xl border border-white/18 px-6 py-3.5 text-sm font-bold text-white/88">Browse Catalog</a>
                        </div>

                        <div class="mt-10 flex flex-wrap gap-3">
                            <a href="{{ route('home.courses', array_filter(['mode' => 'offline', 'search' => $search, 'category' => $selectedCategory ?: null, 'audience' => $selectedAudience ?: null])) }}#catalog-results"
                               @class([
                                   'mode-pill rounded-full px-5 py-3 text-xs font-bold uppercase tracking-[0.18em]',
                                   'bg-white text-[#113a5c] shadow-[0_16px_34px_rgba(255,255,255,0.18)]' => $catalogMode === 'offline',
                                   'catalog-shell text-white/82' => $catalogMode !== 'offline',
                               ])>
                                Offline Training Programs
                            </a>
                            @if ($onlineCatalogEnabled)
                                <a href="{{ route('home.courses', array_filter(['mode' => 'online', 'search' => $search, 'category' => $selectedCategory ?: null, 'sort' => $selectedSort, 'audience' => $selectedAudience ?: null])) }}#catalog-results"
                                   @class([
                                       'mode-pill rounded-full px-5 py-3 text-xs font-bold uppercase tracking-[0.18em]',
                                       'bg-[#bdfaf1] text-[#082032] shadow-[0_16px_34px_rgba(189,250,241,0.2)]' => $catalogMode === 'online',
                                       'catalog-shell text-white/82' => $catalogMode !== 'online',
                                   ])>
                                    Online Training Programs
                                </a>
                            @else
                                <span class="catalog-shell rounded-full px-5 py-3 text-xs font-bold uppercase tracking-[0.18em] text-white/56">Online training programs currently disabled</span>
                            @endif
                        </div>
                    </div>

                    <div class="relative z-10">
                        <div class="catalog-shell rounded-[2rem] p-5">
                            <div class="rounded-[1.6rem] border border-white/10 bg-black/12 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-white/56">Now Showing</p>
                                <h2 class="mt-3 font-headline text-3xl font-extrabold text-white">{{ $modeLabel }}</h2>
                                <p class="mt-3 text-sm leading-7 text-white/72">
                                    {{ $catalogMode === 'offline' ? 'Campus-led batches, mentor interaction, seat-based intake, and contact-first enrollment.' : 'Instructor-published learning paths with structured online lessons and guided outcomes.' }}
                                </p>

                                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/10 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/54">Results</p>
                                        <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($resultsCount) }}</p>
                                        <p class="mt-2 text-sm text-white/64">{{ $selectedCategoryName ?: 'All categories' }}</p>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/10 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/54">Enrollment Style</p>
                                        <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ $catalogMode === 'offline' ? 'Contact' : 'Guided' }}</p>
                                        <p class="mt-2 text-sm text-white/64">{{ $catalogMode === 'offline' ? 'Seats shared by team' : 'Details unlocked by team' }}</p>
                                    </div>
                                </div>

                                @if ($heroCourse)
                                    <div class="mt-6 rounded-[1.5rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/54">Featured {{ ucfirst($catalogMode) }} Pick</p>
                                        <p class="mt-3 font-headline text-2xl font-extrabold text-white">{{ $heroCourse['title'] }}</p>
                                        <p class="mt-3 text-sm leading-7 text-white/70">{{ \Illuminate\Support\Str::limit($heroCourse['details'], 130) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="catalog-results" class="mx-auto mt-10 max-w-[88rem] px-4 sm:px-6 lg:px-8">
            <div class="catalog-panel rounded-[2.35rem] p-6 md:p-8 xl:p-10">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Catalog Snapshot</p>
                        <h2 class="mt-2 font-headline text-3xl font-extrabold text-on-surface">Training programs ready to access</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-on-surface-variant">
                            {{ $catalogMode === 'offline' ? 'Offline stays the default focus right now, with each card designed to answer schedule and classroom-fit questions faster.' : 'Online catalog is still available, but every card now pushes learners toward guidance first instead of price-first decisions.' }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="catalog-chip rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ $selectedCategoryName ?: 'All categories' }}</span>
                        @if ($selectedAudienceLabel)
                            <span class="catalog-chip rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ $selectedAudienceLabel }}</span>
                        @endif
                        @if ($search !== '')
                            <span class="catalog-chip rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Search: {{ $search }}</span>
                        @endif
                        <span class="catalog-chip rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ ucfirst($catalogMode) }} mode</span>
                    </div>
                </div>

                <form action="{{ route('home.courses') }}#catalog-results" method="GET" class="catalog-filter mt-7 rounded-[1.6rem] p-5">
                    <input type="hidden" name="mode" value="{{ $catalogMode }}" />
                    <div class="grid gap-4 lg:grid-cols-[1.1fr_0.8fr_0.8fr_0.85fr_auto]">
                        <label class="block">
                            <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Search</span>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search by title, campus, language or skill..." class="w-full rounded-[1.1rem] border-0 bg-white px-4 py-3.5 text-sm text-on-surface ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20" />
                        </label>
                        <label class="block">
                            <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Category</span>
                            <select name="category" class="w-full rounded-[1.1rem] border-0 bg-white px-4 py-3.5 text-sm text-on-surface ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($selectedCategory === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Sort</span>
                            <select name="sort" class="w-full rounded-[1.1rem] border-0 bg-white px-4 py-3.5 text-sm text-on-surface ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20">
                                <option value="popular" @selected($selectedSort === 'popular')>Most Popular</option>
                                <option value="newest" @selected($selectedSort === 'newest')>Newest First</option>
                                <option value="rating" @selected($selectedSort === 'rating')>Top Rated</option>
                                @if ($catalogMode === 'online')
                                    <option value="price_low" @selected($selectedSort === 'price_low')>Fee Low To High</option>
                                    <option value="price_high" @selected($selectedSort === 'price_high')>Fee High To Low</option>
                                @endif
                            </select>
                        </label>
                        <label class="block">
                            <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Audience</span>
                            <select name="audience" class="w-full rounded-[1.1rem] border-0 bg-white px-4 py-3.5 text-sm text-on-surface ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20">
                                <option value="">All Learners</option>
                                <option value="working-professional" @selected(($selectedAudience ?? '') === 'working-professional')>Working Professional</option>
                                <option value="college-student" @selected(($selectedAudience ?? '') === 'college-student')>College Student</option>
                            </select>
                        </label>
                        <div class="flex items-end">
                            <button type="submit" class="catalog-cta w-full rounded-[1.1rem] bg-[linear-gradient(135deg,#5b2c83_0%,#10748b_100%)] px-6 py-3.5 text-sm font-bold text-white">Apply Filters</button>
                        </div>
                    </div>
                </form>

                @if ($courseCards->count() > 0)
                    <div class="mt-10 grid gap-8 lg:grid-cols-2 2xl:grid-cols-3">
                        @foreach ($courseCards as $course)
                            @php
                                $gateContext = $course['mode'] === 'offline'
                                    ? 'offline-course-'.$course['id']
                                    : 'online-course-'.$course['id'];
                                $courseUnlocked = (bool) ($grantedAccess[$gateContext] ?? false);
                            @endphp
                            <article class="catalog-card rounded-[2rem]">
                                <div class="catalog-card-media relative overflow-hidden rounded-t-[1.8rem]">
                                    <img src="{{ $course['thumbnail'] }}" alt="{{ $course['title'] }}" class="h-72 w-full transition duration-700 hover:scale-[1.05]" loading="lazy" />
                                    <div class="absolute left-4 top-4 z-10 flex flex-wrap gap-2">
                                        <span class="rounded-full bg-white/18 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-white backdrop-blur-sm">{{ $course['category'] }}</span>
                                        <span class="rounded-full bg-[#bdfaf1]/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#082032]">{{ $course['badge_label'] }}</span>
                                    </div>
                                    <div class="absolute bottom-4 left-4 right-4 z-10 flex flex-wrap gap-2">
                                        <span class="rounded-full bg-black/28 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-white backdrop-blur-sm">{{ $course['level'] }}</span>
                                        <!-- <span class="rounded-full bg-black/28 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-white backdrop-blur-sm">{{ $course['language'] }}</span> -->
                                        @if (!empty($course['audience_label']))
                                            <span class="rounded-full bg-[#f7d88a]/90 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-[#4f3506] backdrop-blur-sm">{{ $course['audience_label'] }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="catalog-card-body relative p-7">
                                    <div class="catalog-kicker flex items-center justify-between rounded-[1.2rem] px-4 py-3">
                                        <div class="catalog-kicker-copy">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Program Format</p>
                                            <p class="mt-1 text-sm font-semibold text-on-surface">{{ $catalogMode === 'offline' ? ($course['delivery_mode'] ?? 'Offline classroom') : ($course['mentor'] ?? 'Mentor-led program') }}</p>
                                        </div>
                                        <div class="catalog-kicker-icons flex gap-2 text-primary">
                                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10"><span class="material-symbols-outlined text-[18px]">{{ $course['icon_one'] }}</span></span>
                                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10"><span class="material-symbols-outlined text-[18px]">{{ $course['icon_two'] }}</span></span>
                                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10"><span class="material-symbols-outlined text-[18px]">{{ $course['icon_three'] }}</span></span>
                                        </div>
                                    </div>

                                    <h3 class="catalog-title mt-6 font-headline text-[1.9rem] font-extrabold leading-tight text-on-surface">{{ $course['title'] }}</h3>
                                    <p class="catalog-card-summary mt-3 line-clamp-3 text-[15px] leading-7 text-on-surface-variant">{{ \Illuminate\Support\Str::limit($course['details'], 165) }}</p>

                                    <div class="mt-7 grid grid-cols-2 gap-3.5">
                                        <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                            <p class="catalog-metric-label">Duration</p>
                                            <p class="mt-2 text-sm font-semibold text-on-surface">{{ $course['duration'] }}</p>
                                        </div>
                                        @if ($catalogMode === 'offline')
                                            <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                                <p class="catalog-metric-label">Campus</p>
                                                <p class="mt-2 text-sm font-semibold text-on-surface">{{ $course['campus'] }}</p>
                                            </div>
                                            <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                                <p class="catalog-metric-label">Schedule</p>
                                                <p class="mt-2 text-sm font-semibold text-on-surface">{{ $course['schedule_label'] }}</p>
                                            </div>
                                            <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                                <p class="catalog-metric-label">Batch Size</p>
                                                <p class="mt-2 text-sm font-semibold text-on-surface">{{ $course['batch_size'] }}</p>
                                            </div>
                                        @else
                                            <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                                <p class="catalog-metric-label">Learners</p>
                                                <p class="mt-2 text-sm font-semibold text-on-surface">{{ number_format($course['students_count']) }} enrolled</p>
                                            </div>
                                            <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                                <p class="catalog-metric-label">Lessons</p>
                                                <p class="mt-2 text-sm font-semibold text-on-surface">{{ number_format($course['lesson_count'] ?? 0) }} structured lessons</p>
                                            </div>
                                            <div class="catalog-metric rounded-[1.15rem] px-4 py-3.5">
                                                <p class="catalog-metric-label">Rating</p>
                                                <p class="mt-2 text-sm font-semibold text-on-surface">{{ number_format($course['rating'], 1) }} / 5</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="catalog-detail-list mt-6">
                                        @if ($catalogMode === 'offline')
                                            <div class="catalog-detail-item rounded-[1.15rem] p-4">
                                                <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                                    <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                                                </span>
                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Outcome Focus</p>
                                                    <p class="mt-2 text-sm leading-6 text-on-surface">{{ $course['placement_label'] ?? 'Placement-focused guidance' }}</p>
                                                </div>
                                            </div>
                                            <div class="catalog-detail-item rounded-[1.15rem] p-4">
                                                <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                                    <span class="material-symbols-outlined text-[18px]">groups</span>
                                                </span>
                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Best Fit</p>
                                                    <p class="mt-2 text-sm leading-6 text-on-surface">{{ $course['audience'] ?? 'Students and working professionals' }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="catalog-detail-item rounded-[1.15rem] p-4">
                                                <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                                    <span class="material-symbols-outlined text-[18px]">person_play</span>
                                                </span>
                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Mentor</p>
                                                    <p class="mt-2 text-sm leading-6 text-on-surface">{{ $course['mentor'] ?? 'Mentor-led program' }}</p>
                                                </div>
                                            </div>
                                            <div class="catalog-detail-item rounded-[1.15rem] p-4">
                                                <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                                    <span class="material-symbols-outlined text-[18px]">verified</span>
                                                </span>
                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Access Window</p>
                                                    <p class="mt-2 text-sm leading-6 text-on-surface">{{ $course['validity_label'] ?? 'Lifetime access' }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- @if ($catalogMode === 'offline' && !empty($course['highlights']))
                                        <div class="mt-5 flex flex-wrap gap-2">
                                            @foreach ($course['highlights'] as $highlight)
                                                <span class="catalog-chip rounded-full px-3 py-2 text-[11px] font-bold text-on-surface-variant">{{ $highlight }}</span>
                                            @endforeach
                                        </div>
                                    @endif -->

                                    <div class="my-7 h-px bg-gradient-to-r from-transparent via-primary/20 to-transparent"></div>

                                    <div class="catalog-card-footer">
                                        <div class="catalog-price-copy max-w-[22rem]">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Fee Access</p>
                                            <p class="mt-2 font-headline text-[1.65rem] font-extrabold leading-none text-primary">Contact mentor or our team</p>
                                            <p class="mt-2 text-xs leading-6 text-on-surface-variant">{{ $catalogMode === 'offline' ? ($course['learner_note'] ?? 'We will help you choose the right batch timing and campus fit.') : 'Unlock the details to review the full structure with guidance from our team.' }}</p>
                                        </div>
                                        @if ($courseUnlocked)
                                            <a href="{{ $course['details_url'] }}" class="catalog-cta inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#5b2c83_0%,#10748b_100%)] px-5 py-3 text-[12px] font-bold text-white">
                                                {{ $catalogMode === 'offline' ? 'View Batch Details' : 'View Training Program Details' }}
                                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                            </a>
                                        @elseif ($catalogMode === 'online' && !auth()->check())
                                            <button
                                                type="button"
                                                class="catalog-cta inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#5b2c83_0%,#10748b_100%)] px-5 py-3 text-[12px] font-bold text-white"
                                                data-auth-required
                                                data-auth-redirect="{{ $course['details_url'] }}"
                                                data-auth-title="Login to access training program details"
                                                data-auth-copy="Create your account or log in first to open the full training program details page."
                                            >
                                                Unlock Training Program Details
                                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                            </button>
                                        @elseif ($publicLeadGateEnabled)
                                            <button
                                                type="button"
                                                class="catalog-cta inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#5b2c83_0%,#10748b_100%)] px-5 py-3 text-[12px] font-bold text-white"
                                                data-lead-gate-open
                                                data-target-url="{{ $course['details_url'] }}"
                                                data-context="{{ $gateContext }}"
                                                data-topic="{{ $catalogMode === 'offline' ? 'offline_course_lead' : 'course_detail_lead' }}"
                                                data-title="{{ $course['title'] }}"
                                                data-subject="{{ ($course['audience_label'] ? $course['audience_label'].' inquiry: ' : '').($catalogMode === 'offline' ? 'Offline batch inquiry - '.$course['title'] : 'Training program unlock request - '.$course['title']) }}"
                                                data-audience="{{ $course['audience_label'] ?? '' }}"
                                                data-course-id="{{ $catalogMode === 'online' ? $course['id'] : '' }}"
                                            >
                                                {{ $catalogMode === 'offline' ? 'Unlock Batch Details' : 'Unlock Training Program Details' }}
                                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                            </button>
                                        @else
                                            <a href="{{ $course['details_url'] }}" class="catalog-cta inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#5b2c83_0%,#10748b_100%)] px-5 py-3 text-[12px] font-bold text-white">
                                                {{ $catalogMode === 'offline' ? 'Know More' : 'View Details' }}
                                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-10">{{ $courseCards->links() }}</div>
                @else
                    <div class="mt-8 rounded-[1.8rem] border border-dashed border-outline px-6 py-14 text-center">
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">No Match Found</p>
                        <h3 class="mt-4 font-headline text-3xl font-extrabold text-on-surface">No training programs matched the current filters</h3>
                        <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-on-surface-variant">Try changing the keyword, switching the mode, or clearing the category to see more options.</p>
                    </div>
                @endif
            </div>
        </section>

        @if ($publicLeadGateEnabled && auth()->check())
            <div class="lead-gate-backdrop" id="courseLeadGate" hidden>
                <div class="lead-gate-dialog p-6 sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary">Unlock Details</p>
                            <h3 class="mt-2 font-headline text-3xl font-extrabold text-on-surface" id="leadGateTitle">Share your details once</h3>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">After this quick form, we will open the full details and our team can guide you on the right batch or mentor path.</p>
                        </div>
                        <button type="button" class="rounded-full bg-surface-soft p-2 text-on-surface-variant" data-lead-gate-close>
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form action="{{ route('content.unlock') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <input type="hidden" name="course_id" id="leadGateCourseId" />
                        <input type="hidden" name="context" id="leadGateContext" />
                        <input type="hidden" name="topic" id="leadGateTopic" />
                        <input type="hidden" name="subject" id="leadGateSubject" />
                        <input type="hidden" name="audience" id="leadGateAudience" />
                        <input type="hidden" name="redirect_to" id="leadGateRedirect" />
                        <div class="grid gap-4 sm:grid-cols-2">
                            <input type="text" name="name" placeholder="Your name" required class="w-full rounded-[1rem] border-0 bg-surface-soft px-4 py-3.5 text-sm ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20" />
                            <input type="email" name="email" placeholder="Email address" required class="w-full rounded-[1rem] border-0 bg-surface-soft px-4 py-3.5 text-sm ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20" />
                        </div>
                        <input type="text" name="phone" placeholder="Phone number" class="w-full rounded-[1rem] border-0 bg-surface-soft px-4 py-3.5 text-sm ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20" />
                        <textarea name="message" rows="4" class="w-full rounded-[1rem] border-0 bg-surface-soft px-4 py-3.5 text-sm ring-1 ring-outline/70 focus:ring-2 focus:ring-primary/20" placeholder="Tell us what you want to learn, preferred batch timing, or what kind of guidance you need."></textarea>
                        <button type="submit" class="catalog-cta inline-flex w-full items-center justify-center gap-2 rounded-[1rem] bg-[linear-gradient(135deg,#5b2c83_0%,#10748b_100%)] px-6 py-3.5 text-sm font-bold text-white">
                            Unlock Now
                            <span class="material-symbols-outlined text-[16px]">north_east</span>
                        </button>
                    </form>
                </div>
            </div>

            <script>
                (function () {
                    var backdrop = document.getElementById('courseLeadGate');
                    if (!backdrop) {
                        return;
                    }

                    var title = document.getElementById('leadGateTitle');
                    var courseIdInput = document.getElementById('leadGateCourseId');
                    var contextInput = document.getElementById('leadGateContext');
                    var topicInput = document.getElementById('leadGateTopic');
                    var subjectInput = document.getElementById('leadGateSubject');
                    var audienceInput = document.getElementById('leadGateAudience');
                    var redirectInput = document.getElementById('leadGateRedirect');
                    var openButtons = document.querySelectorAll('[data-lead-gate-open]');
                    var closeButtons = backdrop.querySelectorAll('[data-lead-gate-close]');

                    function closeGate() {
                        backdrop.hidden = true;
                        document.body.classList.remove('overflow-hidden');
                    }

                    openButtons.forEach(function (button) {
                        button.addEventListener('click', function () {
                            title.textContent = 'Unlock details for ' + (button.getAttribute('data-title') || 'this course');
                            courseIdInput.value = button.getAttribute('data-course-id') || '';
                            contextInput.value = button.getAttribute('data-context') || '';
                            topicInput.value = button.getAttribute('data-topic') || 'lead_gate';
                            subjectInput.value = button.getAttribute('data-subject') || 'Content access request';
                            audienceInput.value = button.getAttribute('data-audience') || '';
                            redirectInput.value = button.getAttribute('data-target-url') || window.location.href;
                            backdrop.hidden = false;
                            document.body.classList.add('overflow-hidden');
                        });
                    });

                    closeButtons.forEach(function (button) {
                        button.addEventListener('click', closeGate);
                    });

                    backdrop.addEventListener('click', function (event) {
                        if (event.target === backdrop) {
                            closeGate();
                        }
                    });
                }());
            </script>
        @endif
    </main>
</x-home.marketing-layout>
