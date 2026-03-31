<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Courses | Code In Yourself</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#002D62",
                        "on-primary": "#FFFFFF",
                        "primary-container": "#D6E3FF",
                        "on-primary-container": "#001B3E",
                        secondary: "#565E71",
                        "on-secondary": "#FFFFFF",
                        "secondary-container": "#DAE2F9",
                        "on-secondary-container": "#131C2C",
                        tertiary: "#006B24",
                        "on-tertiary": "#FFFFFF",
                        "tertiary-container": "#9EF7A0",
                        "on-tertiary-container": "#002106",
                        surface: "#F8FAFF",
                        background: "#FDFBFF",
                        "surface-variant": "#E1E2EC",
                        "surface-container": "#e9eef8",
                        "surface-container-low": "#f1f4f9",
                        "surface-container-high": "#e5e8ee",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#1A1C1E",
                        "on-surface-variant": "#44474F",
                        outline: "#74777F",
                        error: "#BA1A1A",
                    },
                    fontFamily: {
                        headline: ["Manrope", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    },
                    boxShadow: {
                        card: "0 16px 36px -22px rgba(15, 23, 42, 0.22)",
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body antialiased">
    <x-home.navbar />

    <main class="pt-20 pb-20">
        <section class="max-w-7xl mx-auto px-6 pt-8 pb-10">
            <div class="max-w-4xl">
                <h1 class="font-headline text-[3.4rem] font-extrabold leading-[1.05] tracking-[-0.04em] text-on-surface md:text-[4rem]">
                    Explore Our <span class="text-primary">Industry-Ready</span><br />
                    Courses
                </h1>
                <p class="mt-6 max-w-2xl text-[1.08rem] leading-8 text-on-surface-variant">
                    Master the most in-demand technical skills with our structured curriculum designed by engineering experts. Your journey to a premium tech career starts here.
                </p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 mb-12">
            <form action="{{ route('home.courses') }}" class="overflow-hidden rounded-[1.6rem] border border-slate-200/70 bg-white shadow-[0_24px_60px_-40px_rgba(15,23,42,0.32)]" method="GET">
                <div class="border-b border-slate-200/70 bg-[linear-gradient(135deg,#f8fbff_0%,#eef4ff_100%)] px-5 py-5 md:px-6">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.24em] text-primary/75">Course Finder</p>
                            <h2 class="mt-1 font-headline text-xl font-extrabold text-on-surface">Refine your learning path</h2>
                        </div>
                        <div class="relative w-full xl:max-w-[320px]">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                            <input class="w-full rounded-[1.1rem] border border-white/70 bg-white/95 py-3.5 pl-11 pr-4 text-sm text-on-surface placeholder:text-slate-400 shadow-sm focus:border-primary/20 focus:ring-2 focus:ring-primary/10" name="search" placeholder="Search courses, tools, or skills..." type="text" value="{{ $search }}" />
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 px-5 py-5 md:px-6 xl:grid-cols-[minmax(0,1fr)_240px] xl:items-start">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <span class="material-symbols-outlined text-[17px]">tune</span>
                            </span>
                            <span class="text-[11px] font-extrabold uppercase tracking-[0.22em] text-on-surface-variant">Browse by category</span>
                        </div>
                        <div class="flex flex-wrap gap-2.5">
                            <a @class([
                                'rounded-full px-4 py-2.5 text-xs font-semibold transition-all',
                                'bg-primary text-white shadow-sm shadow-primary/20' => $selectedCategory === '',
                                'bg-surface-container-low text-on-surface ring-1 ring-slate-200/70 hover:-translate-y-0.5 hover:bg-white hover:shadow-sm' => $selectedCategory !== '',
                            ]) href="{{ route('home.courses', array_filter(['search' => $search, 'sort' => $selectedSort])) }}">
                                All Courses
                            </a>
                            @foreach ($categories as $category)
                                <a @class([
                                    'rounded-full px-4 py-2.5 text-xs font-semibold transition-all',
                                    'bg-primary text-white shadow-sm shadow-primary/20' => $selectedCategory === (string) $category->id,
                                    'bg-surface-container-low text-on-surface ring-1 ring-slate-200/70 hover:-translate-y-0.5 hover:bg-white hover:shadow-sm' => $selectedCategory !== (string) $category->id,
                                ]) href="{{ route('home.courses', array_filter(['search' => $search, 'category' => $category->id, 'sort' => $selectedSort])) }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-[1.2rem] border border-slate-200/70 bg-surface-container-low p-4">
                        <label class="mb-2 block text-[11px] font-extrabold uppercase tracking-[0.22em] text-on-surface-variant">Sort Results</label>
                        <div class="flex items-center gap-3 rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-200/70">
                            <span class="material-symbols-outlined text-outline text-[18px]">sort</span>
                            <select class="w-full border-0 bg-transparent py-0 pr-8 text-sm font-semibold text-on-surface focus:ring-0" name="sort" onchange="this.form.submit()">
                                <option value="newest" @selected($selectedSort === 'newest')>Newest First</option>
                                <option value="popular" @selected($selectedSort === 'popular')>Popularity</option>
                                <option value="rating" @selected($selectedSort === 'rating')>Top Rated</option>
                                <option value="price_low" @selected($selectedSort === 'price_low')>Price: Low to High</option>
                                <option value="price_high" @selected($selectedSort === 'price_high')>Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <section class="max-w-7xl mx-auto px-6">
            @if ($courseCards->count() > 0)
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($courseCards as $course)
                        <article class="overflow-hidden rounded-[1.35rem] border border-slate-200/70 bg-surface-container-lowest shadow-card transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative h-[230px] overflow-hidden">
                                <img alt="{{ $course['title'] }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.03]" src="{{ $course['thumbnail'] }}" />
                                <div class="absolute left-4 top-4">
                                    <span @class([
                                        'rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.2em] text-white shadow-lg',
                                        'bg-primary' => $course['badge_label'] === 'Best Seller',
                                        'bg-tertiary' => $course['badge_label'] !== 'Best Seller',
                                    ])>
                                        {{ $course['badge_label'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <div class="flex items-center gap-1 text-[12px] text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[14px] text-amber-500" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="font-semibold text-on-surface">{{ number_format($course['rating'], 1) }}</span>
                                    <span>({{ number_format($course['reviews_count']) }} Reviews)</span>
                                </div>

                                <h2 class="mt-3 font-headline text-[1.9rem] font-extrabold leading-tight tracking-[-0.03em] text-on-surface">
                                    {{ $course['title'] }}
                                </h2>

                                <div class="mt-4 flex flex-wrap items-center gap-4 text-[12px] font-medium text-on-surface-variant">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">schedule</span>
                                        {{ $course['duration'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">school</span>
                                        {{ $course['level'] }}
                                    </span>
                                </div>

                                <div class="mt-5 flex gap-2 text-primary">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">{{ $course['icon_one'] }}</span>
                                    </span>
                                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">{{ $course['icon_two'] }}</span>
                                    </span>
                                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">{{ $course['icon_three'] }}</span>
                                    </span>
                                </div>

                                <p class="mt-5 min-h-[92px] text-[1rem] leading-8 text-on-surface-variant">
                                    {{ \Illuminate\Support\Str::limit($course['details'], 115) }}
                                </p>

                                <div class="mt-6 flex items-end justify-between border-t border-slate-200/70 pt-5">
                                    <div>
                                        <p class="text-[11px] text-on-surface-variant">Starting at</p>
                                        <p class="text-[2rem] font-extrabold leading-none text-on-surface">
                                            ₹{{ number_format($course['price'], 0) }}<span class="text-[12px] font-medium text-on-surface-variant">/mo</span>
                                        </p>
                                    </div>
                                    <a class="rounded-xl bg-surface-container-low px-5 py-3 text-[12px] font-bold text-primary transition-all hover:bg-primary hover:text-white" href="{{ $course['details_url'] }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $courseCards->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-surface-container-lowest px-6 py-16 text-center">
                    <h2 class="font-headline text-2xl font-extrabold text-on-surface">No courses matched your filters</h2>
                    <p class="mt-3 text-sm text-on-surface-variant">Try a different keyword or reset the filters to browse all published courses.</p>
                    <a class="mt-6 inline-flex rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white" href="{{ route('home.courses') }}">Browse All Courses</a>
                </div>
            @endif
        </section>
    </main>

    <x-home.footer />
</body>
</html>
