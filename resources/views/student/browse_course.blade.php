<x-student.layout title="Browse Courses | CodeInYourself">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Discovery</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">Browse Courses</p>
    </div>

    <x-slot:center>
        <form action="{{ route('student.browse-courses') }}">
            <input type="hidden" name="mode" value="{{ $catalogMode ?? 'offline' }}" />
            <label class="student-top-search">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input name="search" placeholder="Search skills, categories, mentors, campus" type="text" value="{{ $search }}" />
            </label>
        </form>
    </x-slot:center>

    <x-slot:right>
        @if (($catalogMode ?? 'offline') === 'online')
            <a class="student-pill-button student-pill-button--ghost hidden md:inline-flex" href="{{ route('student.wishlist') }}">Wishlist</a>
            <a class="student-pill-button student-pill-button--ghost hidden md:inline-flex" href="{{ route('student.cart') }}">Cart</a>
        @endif
        <img alt="{{ $student->name }} avatar" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $profileAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Course Catalog</p>
                <h1 class="student-page-title">Explore your next learning move</h1>
                <p class="student-page-copy">
                    {{ ($catalogMode ?? 'offline') === 'offline'
                        ? 'Browse classroom-first courses, campus schedules, and mentor-guided batches with a simpler offline-first catalog.'
                        : 'Browse the online catalog with cleaner discovery, sharper cards, and a lighter learning workspace feel.' }}
                </p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ number_format($resultsCount) }} results</span>
                <span class="student-chip">Personalized for {{ $student->name }}</span>
                <span class="student-chip">{{ ($catalogMode ?? 'offline') === 'offline' ? 'Offline classroom mode' : 'Online learning mode' }}</span>
            </div>
        </section>

        <section class="rounded-[1.2rem] bg-surface-container-lowest p-4">
            <div class="flex flex-wrap gap-3">
                @if (($offlineCatalogEnabled ?? true))
                    <a class="student-pill-button {{ ($catalogMode ?? 'offline') === 'offline' ? 'student-pill-button--primary' : 'student-pill-button--ghost' }}" href="{{ route('student.browse-courses', array_filter(['mode' => 'offline', 'search' => $search, 'category' => $selectedCategory ?: null])) }}">Offline Courses</a>
                @endif
                @if (($onlineCatalogEnabled ?? false))
                    <a class="student-pill-button {{ ($catalogMode ?? 'offline') === 'online' ? 'student-pill-button--primary' : 'student-pill-button--ghost' }}" href="{{ route('student.browse-courses', array_filter(['mode' => 'online', 'search' => $search, 'category' => $selectedCategory ?: null])) }}">Online Courses</a>
                @endif
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">Results</p>
                        <p class="student-stat-value">{{ number_format($resultsCount) }}</p>
                        <p class="student-stat-copy">Courses matching your view</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Filters</p>
                        <p class="student-stat-value">{{ ($selectedCategory || $selectedLevel || $selectedPrice !== 'all' || $selectedSort !== 'relevant') ? 'On' : 'Off' }}</p>
                        <p class="student-stat-copy">Adjust catalog precision</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Mode</p>
                        <p class="student-stat-value">{{ ($catalogMode ?? 'offline') === 'offline' ? 'Offline' : 'Online' }}</p>
                        <p class="student-stat-copy">{{ ($catalogMode ?? 'offline') === 'offline' ? 'Mentor-guided offline intake' : 'Enrollment-ready catalog' }}</p>
                    </div>
                </div>
            </div>

            <div class="student-side-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Featured This Week</p>
                <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface">{{ $featuredCourse['title'] ?? 'Build your next skill stack' }}</h2>
                <p class="mt-4 text-sm leading-7 text-on-surface-variant">
                    {{ \Illuminate\Support\Str::limit($featuredCourse['details'] ?? 'Browse the strongest classroom and online learning options from the current catalog.', 145) }}
                </p>
                <div class="mt-5 flex flex-wrap gap-3 text-sm text-on-surface-variant">
                    @if (($catalogMode ?? 'offline') === 'offline')
                        <span>{{ $featuredCourse['campus'] ?? 'Campus details' }}</span>
                        <span>{{ $featuredCourse['duration_label'] ?? 'Classroom schedule' }}</span>
                    @else
                        <span>{{ $featuredCourse['students_count'] ?? 0 }} students</span>
                        <span>{{ $featuredCourse['rating'] ?? '4.8' }} rating</span>
                    @endif
                </div>
                @if ($featuredCourse)
                    <div class="mt-8 flex gap-3">
                        <a class="student-pill-button student-pill-button--primary flex-1 justify-center" href="{{ $featuredCourse['details_url'] }}">{{ ($catalogMode ?? 'offline') === 'offline' ? 'Ask About Batch' : 'See Details' }}</a>
                        <a class="student-pill-button student-pill-button--ghost flex-1 justify-center" href="{{ $featuredCourse['is_enrolled'] ? $featuredCourse['player_url'] : $featuredCourse['details_url'] }}">
                            {{ ($catalogMode ?? 'offline') === 'offline' ? 'Talk To Team' : ($featuredCourse['is_enrolled'] ? 'Continue' : 'Preview') }}
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <div class="grid gap-8 xl:grid-cols-[300px_minmax(0,1fr)]">
            <aside id="browseFiltersPanel" class="fixed inset-y-0 left-0 z-[70] w-[88%] max-w-sm -translate-x-full overflow-y-auto bg-white p-6 shadow-2xl transition-transform duration-300 xl:static xl:z-auto xl:w-auto xl:max-w-none xl:translate-x-0 xl:overflow-visible xl:bg-transparent xl:p-0 xl:shadow-none">
                <div class="mb-6 flex items-center justify-between xl:hidden">
                    <h2 class="font-headline text-lg font-bold">Filters</h2>
                    <button class="flex h-9 w-9 items-center justify-center rounded-full bg-surface-container-low" onclick="toggleBrowseFilters(false)" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('student.browse-courses') }}" class="space-y-5 rounded-[1.2rem] bg-surface-container-lowest p-5">
                    <input name="mode" type="hidden" value="{{ $catalogMode ?? 'offline' }}" />
                    <input name="search" type="hidden" value="{{ $search }}" />
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Category</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="category">
                            <option value="">All categories</option>
                            @foreach ($categories as $categoryOption)
                                <option @selected((string) $categoryOption->id === (string) $selectedCategory) value="{{ $categoryOption->id }}">{{ $categoryOption->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Level</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="level">
                            <option value="">All levels</option>
                            <option @selected($selectedLevel === 'beginner') value="beginner">Beginner</option>
                            <option @selected($selectedLevel === 'intermediate') value="intermediate">Intermediate</option>
                            <option @selected($selectedLevel === 'advanced') value="advanced">Advanced</option>
                        </select>
                    </div>
                    @if (($catalogMode ?? 'offline') === 'online')
                        <div>
                            <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Price</label>
                            <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="price">
                                <option @selected($selectedPrice === 'all') value="all">All pricing</option>
                                <option @selected($selectedPrice === 'free') value="free">Free</option>
                                <option @selected($selectedPrice === 'paid') value="paid">Paid</option>
                            </select>
                        </div>
                    @endif
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Sort by</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="sort">
                            <option @selected($selectedSort === 'relevant') value="relevant">Most relevant</option>
                            <option @selected($selectedSort === 'popular') value="popular">Most popular</option>
                            <option @selected($selectedSort === 'rating') value="rating">Highest rated</option>
                            <option @selected($selectedSort === 'newest') value="newest">Newest</option>
                            @if (($catalogMode ?? 'offline') === 'online')
                                <option @selected($selectedSort === 'price_low') value="price_low">Price low to high</option>
                                <option @selected($selectedSort === 'price_high') value="price_high">Price high to low</option>
                            @endif
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button class="student-pill-button student-pill-button--primary flex-1 justify-center" type="submit">Apply</button>
                        <a class="student-pill-button student-pill-button--ghost flex-1 justify-center" href="{{ route('student.browse-courses', ['mode' => $catalogMode ?? 'offline']) }}">Reset</a>
                    </div>
                </form>
            </aside>

            <div id="browseFiltersOverlay" class="fixed inset-0 z-[65] hidden bg-black/40 xl:hidden" onclick="toggleBrowseFilters(false)"></div>

            <section class="space-y-6 min-w-0">
                <div class="flex flex-wrap items-center justify-between gap-4 rounded-[1.2rem] bg-surface-container-lowest p-4">
                    <div class="flex flex-wrap gap-3">
                        <span class="student-chip">Showing {{ number_format($resultsCount) }} courses</span>
                        @if ($selectedCategory || $selectedLevel || $selectedPrice !== 'all' || $selectedSort !== 'relevant')
                            <span class="student-chip">Filters active</span>
                        @endif
                    </div>
                    <button class="student-pill-button student-pill-button--ghost xl:hidden" onclick="toggleBrowseFilters(true)" type="button">Filters</button>
                </div>

                @if ($courseCards->count() === 0)
                    <div class="rounded-[1.3rem] bg-surface-container-lowest p-9 text-center">
                        <h3 class="font-headline text-[1.9rem] font-extrabold text-on-surface">No courses match this filter yet.</h3>
                        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant">Try widening the category or search term and the catalog will open up again.</p>
                        <a class="student-pill-button student-pill-button--primary mt-8" href="{{ route('student.browse-courses', ['mode' => $catalogMode ?? 'offline']) }}">Clear Filters</a>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 2xl:grid-cols-3">
                        @foreach ($courseCards as $courseCard)
                            <article class="group overflow-hidden rounded-[1.35rem] bg-surface-container-lowest">
                                <div class="relative aspect-[16/11] overflow-hidden">
                                    <img alt="{{ $courseCard['title'] }} thumbnail" class="h-full w-full object-cover object-top transition-transform duration-700 hover:scale-110" src="{{ $courseCard['thumbnail'] }}" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#221a3d]/25 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                                    <div class="absolute left-4 top-4 rounded-full bg-white/92 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-primary">
                                        {{ $courseCard['category'] }}
                                    </div>
                                    <div class="absolute right-4 top-4 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] {{ ($catalogMode ?? 'offline') === 'offline' ? 'bg-sky-100 text-sky-700' : ($courseCard['is_enrolled'] ? 'bg-emerald-100 text-emerald-700' : ($courseCard['is_wishlisted'] ? 'bg-amber-100 text-amber-700' : 'bg-white/90 text-on-surface')) }}">
                                        {{ ($catalogMode ?? 'offline') === 'offline' ? 'Offline' : ($courseCard['is_enrolled'] ? 'Enrolled' : ($courseCard['is_wishlisted'] ? 'Saved' : 'Published')) }}
                                    </div>
                                    @if (($catalogMode ?? 'offline') === 'online')
                                        <form action="{{ route('student.wishlist.toggle', ['course' => $courseCard['id']]) }}" class="absolute bottom-4 right-4" method="POST">
                                            @csrf
                                            <button class="flex h-11 w-11 items-center justify-center rounded-full bg-white/90 text-primary shadow-lg" type="submit">
                                                <span @class(['material-symbols-outlined text-[22px]','font-variation-settings-fill' => $courseCard['is_wishlisted']])>favorite</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-[0.16em] text-on-surface-variant">
                                        <span>{{ $courseCard['level'] }}</span>
                                        <span>{{ $courseCard['language'] }}</span>
                                    </div>
                                    <h3 class="mt-4 font-headline text-2xl font-extrabold text-on-surface">{{ $courseCard['title'] }}</h3>
                                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ \Illuminate\Support\Str::limit($courseCard['details'], 130) }}</p>

                                    <div class="mt-5 flex items-center gap-3">
                                        <img alt="{{ $courseCard['instructor_name'] }} avatar" class="h-11 w-11 rounded-full object-cover" src="{{ $courseCard['instructor_avatar'] }}" />
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-on-surface">{{ $courseCard['instructor_name'] }}</p>
                                            <p class="text-xs text-on-surface-variant">
                                                @if (($catalogMode ?? 'offline') === 'offline')
                                                    {{ $courseCard['campus'] ?? 'Campus details on request' }} • {{ $courseCard['duration_label'] ?? 'Classroom schedule' }}
                                                @else
                                                    {{ $courseCard['students_count'] }} students • {{ $courseCard['sections_count'] }} sections
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex items-end justify-between gap-4 border-t border-slate-100 pt-4">
                                        <div>
                                            @if (($catalogMode ?? 'offline') === 'offline')
                                                <p class="text-xs text-on-surface-variant">{{ $courseCard['schedule_label'] ?? 'Schedule shared by team' }}</p>
                                                <p class="mt-1 font-headline text-xl font-extrabold text-on-surface">Contact mentor or our team</p>
                                            @else
                                                <p class="text-xs text-on-surface-variant">{{ $courseCard['reviews_count'] }} reviews</p>
                                                <p class="mt-1 font-headline text-3xl font-extrabold text-on-surface">Rs. {{ number_format($courseCard['price'], 0) }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            @if (($catalogMode ?? 'offline') === 'offline')
                                                <p class="text-sm font-bold text-amber-500">{{ $courseCard['level'] }}</p>
                                                <p class="text-xs text-on-surface-variant">{{ $courseCard['language'] }}</p>
                                            @else
                                                <p class="text-sm font-bold text-amber-500">{{ number_format($courseCard['rating'], 1) }} / 5</p>
                                                <p class="text-xs text-on-surface-variant">Learner rating</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <a class="student-pill-button student-pill-button--ghost flex-1 justify-center" href="{{ $courseCard['details_url'] }}">{{ ($catalogMode ?? 'offline') === 'offline' ? 'Know Batch' : 'Details' }}</a>
                                        <a class="student-pill-button student-pill-button--primary flex-1 justify-center" href="{{ $courseCard['is_enrolled'] ? $courseCard['player_url'] : $courseCard['details_url'] }}">
                                            {{ ($catalogMode ?? 'offline') === 'offline' ? 'Talk To Team' : ($courseCard['is_enrolled'] ? 'Continue' : 'Open Course') }}
                                        </a>
                                        @if (($catalogMode ?? 'offline') === 'online')
                                            @unless ($courseCard['is_enrolled'])
                                                <form action="{{ route('student.cart.add', ['course' => $courseCard['id']]) }}" method="POST">
                                                    @csrf
                                                    <button class="student-pill-button student-pill-button--ghost" type="submit">
                                                        {{ $courseCard['is_in_cart'] ? 'In Cart' : 'Add to Cart' }}
                                                    </button>
                                                </form>
                                            @endunless
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="pt-4">
                        {{ $courseCards->links() }}
                    </div>
                @endif
            </section>
        </div>
    </div>
</main>

<script>
    if (!window.toggleBrowseFilters) {
        window.toggleBrowseFilters = function (forceOpen) {
            var panel = document.getElementById('browseFiltersPanel');
            var overlay = document.getElementById('browseFiltersOverlay');
            if (!panel || !overlay) return;

            if (window.innerWidth >= 1280) {
                panel.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                return;
            }

            var open = typeof forceOpen === 'boolean' ? forceOpen : panel.classList.contains('-translate-x-full');
            panel.classList.toggle('-translate-x-full', !open);
            overlay.classList.toggle('hidden', !open);
            document.body.classList.toggle('overflow-hidden', open);
        };

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1280) {
                window.toggleBrowseFilters(false);
            }
        });
    }
</script>
</x-student.layout>
