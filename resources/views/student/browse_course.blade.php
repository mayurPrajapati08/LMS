<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3525cd",
                        "primary-container": "#4f46e5",
                        surface: "#f8f9fa",
                        "surface-container-low": "#f3f4f5",
                        "surface-container-high": "#e7e8e9",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#464555",
                        outline: "#777587",
                        tertiary: "#007030",
                        secondary: "#58579b"
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"]
                    }
                }
            }
        }
    </script>
    <style>
        .font-variation-settings-fill {
            font-variation-settings: 'FILL' 1;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased overflow-x-hidden">
    <x-student.navbar />

    <header class="fixed top-0 right-0 z-40 flex h-16 w-full items-center justify-between bg-white/85 px-4 shadow-sm backdrop-blur-md md:w-[calc(100%-16rem)] md:px-8">
        <form action="{{ route('student.browse-courses') }}" class="flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-2xl">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input class="w-full rounded-xl border-none bg-surface-container-low py-2.5 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-primary/20" name="search" placeholder="Search..." type="text" value="{{ $search }}" />
            </div>
        </form>
        <div class="ml-auto flex items-center gap-4">
            <a class="hidden rounded-full bg-surface-container-low px-4 py-2 text-sm font-semibold text-primary md:inline-flex" href="{{ route('student.cart') }}">
                Cart
            </a>
            <a class="hidden rounded-full bg-surface-container-low px-4 py-2 text-sm font-semibold text-primary md:inline-flex" href="{{ route('student.wishlist') }}">
                Wishlist
            </a>
            <img alt="{{ $student->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 px-4 pb-12 pt-24 md:px-8">
        @if (session('status'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <section class="mb-10 grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <div class="rounded-[2rem] bg-gradient-to-br from-slate-950 via-indigo-900 to-indigo-700 px-6 py-8 text-white md:px-8">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-indigo-200">Student Catalog</p>
                <h1 class="font-headline text-4xl font-extrabold tracking-tight md:text-5xl">
                    Discover courses that fit your next learning sprint.
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-indigo-100 md:text-base">
                    Real courses, real progress paths, and direct access to the same lessons you can continue inside your player once you enroll.
                </p>
                <div class="mt-6 flex flex-wrap gap-3 text-sm">
                    <span class="rounded-full bg-white/10 px-4 py-2">{{ number_format($resultsCount) }} live results</span>
                    <span class="rounded-full bg-white/10 px-4 py-2">Personalized for {{ $student->name }}</span>
                    <span class="rounded-full bg-white/10 px-4 py-2">Rupee pricing</span>
                </div>
            </div>

            <div class="rounded-[2rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-primary">This Week</p>
                <h2 class="mt-3 font-headline text-2xl font-extrabold">{{ $featuredCourse['title'] ?? 'Build your next skill stack' }}</h2>
                <p class="mt-3 text-sm leading-6 text-on-surface-variant">
                    {{ \Illuminate\Support\Str::limit($featuredCourse['details'] ?? 'Browse the best-performing published courses and jump back into the player whenever you are ready.', 140) }}
                </p>
                <div class="mt-5 flex items-center gap-3 text-sm text-on-surface-variant">
                    <span>{{ $featuredCourse['students_count'] ?? 0 }} students</span>
                    <span>&bull;</span>
                    <span>{{ $featuredCourse['rating'] ?? '4.8' }} rating</span>
                </div>
                @if ($featuredCourse)
                    <div class="mt-6 flex gap-3">
                        <a class="flex-1 rounded-xl bg-primary px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-indigo-500/20" href="{{ $featuredCourse['details_url'] }}">See details</a>
                        <a class="flex-1 rounded-xl bg-surface-container-low px-4 py-3 text-center text-sm font-bold text-primary" href="{{ $featuredCourse['is_enrolled'] ? $featuredCourse['player_url'] : $featuredCourse['details_url'] }}">
                            {{ $featuredCourse['is_enrolled'] ? 'Continue' : 'Preview' }}
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <div class="flex flex-col gap-8 xl:flex-row xl:items-start">
            <aside id="browseFiltersPanel" class="fixed inset-y-0 left-0 z-[70] w-[88%] max-w-sm -translate-x-full overflow-y-auto bg-white p-6 shadow-2xl transition-transform duration-300 xl:static xl:z-auto xl:w-80 xl:max-w-none xl:translate-x-0 xl:overflow-visible xl:bg-transparent xl:p-0 xl:shadow-none">
                <div class="mb-6 flex items-center justify-between xl:hidden">
                    <h2 class="font-headline text-lg font-bold">Filters</h2>
                    <button class="flex h-9 w-9 items-center justify-center rounded-full bg-surface-container-low" onclick="toggleBrowseFilters(false)" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
                <form action="{{ route('student.browse-courses') }}" class="space-y-6 rounded-[1.75rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70">
                    <input name="search" type="hidden" value="{{ $search }}" />
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Category</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="category">
                            <option value="">All categories</option>
                            @foreach ($categories as $categoryOption)
                                <option @selected((string) $categoryOption->id === (string) $selectedCategory) value="{{ $categoryOption->id }}">{{ $categoryOption->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Skill level</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="level">
                            <option value="">All levels</option>
                            <option @selected($selectedLevel === 'beginner') value="beginner">Beginner</option>
                            <option @selected($selectedLevel === 'intermediate') value="intermediate">Intermediate</option>
                            <option @selected($selectedLevel === 'advanced') value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Price</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="price">
                            <option @selected($selectedPrice === 'all') value="all">All pricing</option>
                            <option @selected($selectedPrice === 'free') value="free">Free</option>
                            <option @selected($selectedPrice === 'paid') value="paid">Paid</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Sort by</label>
                        <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="sort">
                            <option @selected($selectedSort === 'relevant') value="relevant">Most relevant</option>
                            <option @selected($selectedSort === 'popular') value="popular">Most popular</option>
                            <option @selected($selectedSort === 'rating') value="rating">Highest rated</option>
                            <option @selected($selectedSort === 'newest') value="newest">Newest</option>
                            <option @selected($selectedSort === 'price_low') value="price_low">Price low to high</option>
                            <option @selected($selectedSort === 'price_high') value="price_high">Price high to low</option>
                        </select>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button class="flex-1 rounded-xl bg-primary px-4 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/20" type="submit">Apply</button>
                        <a class="flex-1 rounded-xl bg-surface-container-low px-4 py-3 text-center text-sm font-bold text-on-surface-variant" href="{{ route('student.browse-courses') }}">Reset</a>
                    </div>
                </form>
            </aside>

            <div id="browseFiltersOverlay" class="fixed inset-0 z-[65] hidden bg-black/40 xl:hidden" onclick="toggleBrowseFilters(false)"></div>

            <section class="min-w-0 flex-1">
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-2xl bg-surface-container-lowest p-4 shadow-sm ring-1 ring-slate-200/70">
                    <p class="text-sm font-medium text-on-surface-variant">
                        Showing <span class="font-bold text-on-surface">{{ number_format($resultsCount) }}</span> courses
                    </p>
                    <button class="inline-flex items-center gap-2 rounded-lg bg-surface-container-low px-3 py-2 text-xs font-bold uppercase tracking-[0.2em] text-on-surface-variant xl:hidden" onclick="toggleBrowseFilters(true)" type="button">
                        <span class="material-symbols-outlined text-base">tune</span>
                        Filters
                    </button>
                </div>

                @if ($courseCards->count() === 0)
                    <div class="rounded-[2rem] bg-surface-container-lowest p-10 text-center shadow-sm ring-1 ring-slate-200/70">
                        <h3 class="font-headline text-2xl font-bold">No courses match this filter yet.</h3>
                        <p class="mt-3 text-sm text-on-surface-variant">Try widening the category, level, or pricing filters and you will see more published courses.</p>
                        <a class="mt-6 inline-flex rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white" href="{{ route('student.browse-courses') }}">Clear filters</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 2xl:grid-cols-3">
                        @foreach ($courseCards as $courseCard)
                            <article class="group overflow-hidden rounded-[1.75rem] bg-surface-container-lowest shadow-sm ring-1 ring-slate-200/70 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <div class="relative aspect-video overflow-hidden">
                                    <img alt="{{ $courseCard['title'] }} thumbnail" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $courseCard['thumbnail'] }}" />
                                    <div class="absolute left-4 top-4 rounded-full bg-white/85 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-primary shadow-sm">
                                        {{ $courseCard['category'] }}
                                    </div>
                                    <form action="{{ route('student.wishlist.toggle', ['course' => $courseCard['id']]) }}" class="absolute bottom-4 right-4" method="POST">
                                        @csrf
                                        <button class="flex h-11 w-11 items-center justify-center rounded-full bg-white/90 text-primary shadow-lg backdrop-blur transition hover:scale-105 {{ $courseCard['is_wishlisted'] ? 'bg-rose-50 text-rose-600' : '' }}" type="submit">
                                            <span @class(['material-symbols-outlined text-[22px]','font-variation-settings-fill' => $courseCard['is_wishlisted']])>favorite</span>
                                        </button>
                                    </form>
                                    <div class="absolute right-4 top-4 rounded-full px-3 py-1 text-[11px] font-semibold shadow-sm {{ $courseCard['is_enrolled'] ? 'bg-emerald-100 text-emerald-700' : ($courseCard['is_wishlisted'] ? 'bg-amber-100 text-amber-700' : 'bg-white/85 text-on-surface') }}">
                                        {{ $courseCard['is_enrolled'] ? 'Enrolled' : ($courseCard['is_wishlisted'] ? 'Saved' : 'Published') }}
                                    </div>
                                </div>
                                <div class="space-y-4 p-6">
                                    <div class="flex items-center justify-between text-xs font-semibold text-on-surface-variant">
                                        <span>{{ $courseCard['level'] }}</span>
                                        <span>{{ $courseCard['language'] }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-headline text-xl font-extrabold leading-snug text-on-surface">{{ $courseCard['title'] }}</h3>
                                        <p class="mt-2 text-sm leading-6 text-on-surface-variant">{{ \Illuminate\Support\Str::limit($courseCard['details'], 130) }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <img alt="{{ $courseCard['instructor_name'] }} avatar" class="h-10 w-10 rounded-full object-cover" src="{{ $courseCard['instructor_avatar'] }}" />
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold">{{ $courseCard['instructor_name'] }}</p>
                                            <p class="text-xs text-on-surface-variant">{{ $courseCard['students_count'] }} students • {{ $courseCard['sections_count'] }} sections</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                                        <div>
                                            <p class="text-xs text-on-surface-variant">{{ $courseCard['reviews_count'] }} reviews</p>
                                            <p class="font-headline text-2xl font-extrabold">Rs. {{ number_format($courseCard['price'], 0) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-amber-500">{{ number_format($courseCard['rating'], 1) }} / 5</p>
                                            <p class="text-xs text-on-surface-variant">Learner rating</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <a class="flex-1 rounded-xl bg-surface-container-low px-4 py-3 text-center text-sm font-bold text-primary" href="{{ $courseCard['details_url'] }}">See details</a>
                                        <a class="flex-1 rounded-xl bg-primary px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-indigo-500/20" href="{{ $courseCard['is_enrolled'] ? $courseCard['player_url'] : $courseCard['details_url'] }}">
                                            {{ $courseCard['is_enrolled'] ? 'Continue' : 'Open course' }}
                                        </a>
                                        @unless ($courseCard['is_enrolled'])
                                            <form action="{{ route('student.cart.add', ['course' => $courseCard['id']]) }}" method="POST">
                                                @csrf
                                                <button class="rounded-xl px-4 py-3 text-sm font-bold transition-all {{ $courseCard['is_in_cart'] ? 'bg-indigo-50 text-primary' : 'bg-surface-container-low text-primary hover:bg-surface-container-high' }}" type="submit">
                                                    {{ $courseCard['is_in_cart'] ? 'In Cart' : 'Add to Cart' }}
                                                </button>
                                            </form>
                                        @endunless
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $courseCards->links() }}
                    </div>
                @endif
            </section>
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
</body>
</html>
