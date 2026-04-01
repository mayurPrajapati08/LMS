<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Wishlist | CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Manrope:wght@600;700;800&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
            background-color: #f4f9ff;
            color: #191c1d;
        }

        .asymmetric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }
    </style>
</head>

<body class="font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
    <x-student.navbar />

    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 shadow-sm dark:shadow-none">
        <div class="flex items-center gap-4 flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <form action="{{ route('student.wishlist') }}" class="relative w-full group" method="GET">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
                <input class="w-full pl-10 pr-3 md:pr-4 py-2 bg-surface-container-low border-none rounded-xl text-sm focus:ring-2 focus:ring-[#edf5ff]0/20 transition-all font-body" name="search" placeholder="Search..." type="text" value="{{ $search }}" />
            </form>
        </div>
        <div class="ml-auto flex items-center gap-4 md:ml-6">
            <a class="hidden rounded-full bg-surface-container-low px-4 py-2 text-sm font-semibold text-primary md:inline-flex" href="{{ route('student.cart') }}">
                Cart
            </a>
            <button class="p-2 text-on-surface-variant hover:text-primary transition-all relative" type="button">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 p-1 pl-3 bg-surface-container-low rounded-full">
                <span class="text-xs font-semibold text-on-surface-variant">Account</span>
                <img alt="Student Profile" class="h-8 w-8 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $studentAvatar }}" />
            </div>
        </div>
    </header>

    <main class="md:ml-64 pt-24 pb-12 px-4 md:px-12 min-h-screen">
        <header class="mb-12 relative">
            <div class="max-w-3xl">
                <h1 class="text-[3.5rem] font-bold font-headline leading-tight tracking-tighter text-on-surface mb-2">
                    Your Curated <br />Selection
                </h1>
                <p class="text-lg text-on-surface-variant font-body opacity-80 max-w-xl">
                    A collection of knowledge hand-picked for your growth. These insights are waiting to be transformed into mastery.
                </p>
            </div>
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>
        </header>

        <section class="flex flex-wrap items-center justify-between gap-6 mb-8 p-6 bg-surface-container-lowest rounded-xl shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-8">
                <div>
                    <span class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Items Saved</span>
                    <span class="text-2xl font-bold font-headline text-primary">{{ $wishlistCount }} Courses</span>
                </div>
                <div class="w-px h-8 bg-surface-container-high hidden sm:block"></div>
                <div>
                    <span class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Total Value</span>
                    <span class="text-2xl font-bold font-headline text-on-surface">{{ $wishlistValue }}</span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 items-center">
                @if ($topCategory)
                    <span class="px-4 py-2 bg-secondary-fixed text-on-secondary-fixed-variant rounded-full text-xs font-semibold">{{ $topCategory }}</span>
                @endif
                @if ($search !== '')
                    <a class="px-4 py-2 bg-surface-container-high text-on-surface-variant rounded-full text-xs font-semibold hover:bg-surface-container-highest transition-all" href="{{ route('student.wishlist') }}">
                        Clear Search
                    </a>
                @endif
                <span class="ml-2 text-sm font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-base" data-icon="favorite">favorite</span>
                    Curated for you
                </span>
            </div>
        </section>

        @if ($wishlistItems->isNotEmpty())
            <div class="asymmetric-grid">
                @foreach ($wishlistItems as $item)
                    @php($course = $item->course)
                    <article class="group bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                        <div class="relative h-48 overflow-hidden">
                            <img alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480' }}" />
                            <div class="absolute top-4 right-4 z-10">
                                <form action="{{ route('student.wishlist.remove', $item) }}" method="POST">
                                    @csrf
                                    <button class="w-10 h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-error hover:bg-error hover:text-white transition-all shadow-lg" type="submit">
                                        <span class="material-symbols-outlined text-xl" data-icon="delete">delete</span>
                                    </button>
                                </form>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span class="px-3 py-1 bg-primary/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg">{{ ucfirst($course->level ?: 'Course') }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex justify-between items-start gap-4 mb-4">
                                <h3 class="text-lg font-bold font-headline leading-snug text-on-surface group-hover:text-primary transition-colors">{{ $course->title }}</h3>
                                <span class="text-lg font-bold text-on-surface">Rs. {{ number_format((float) $course->price, 2) }}</span>
                            </div>
                            <p class="text-sm text-on-surface-variant mb-4 line-clamp-2">{{ $course->details }}</p>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex text-amber-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">{{ ($course->reviews_avg_rating ?? 0) >= $i ? 'star' : 'star_outline' }}</span>
                                    @endfor
                                </div>
                                <span class="text-[11px] font-bold text-on-surface-variant">({{ number_format((float) ($course->reviews_avg_rating ?? 0), 1) }} • {{ $course->reviews_count }})</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-6">Instructor: {{ $course->user?->name ?: 'Instructor' }}</p>
                            <div class="mt-auto pt-6 border-t border-surface-container-low flex gap-3">
                                <a class="flex-1 px-4 py-3 bg-surface-container-high text-primary font-bold text-sm rounded-xl hover:bg-surface-container-highest transition-all text-center" href="{{ route('student.course-details', ['course' => $course->id]) }}">
                                    See Details
                                </a>
                                <form action="{{ route('student.cart.add', ['course' => $course->id]) }}" class="flex-1" method="POST">
                                    @csrf
                                    <button class="w-full px-4 py-3 bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold text-sm rounded-xl hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-2" type="submit">
                                        <span class="material-symbols-outlined text-lg" data-icon="shopping_cart">shopping_cart</span>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-dashed border-[#c7e0ff] p-12 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center text-primary mb-4">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h2 class="text-2xl font-bold font-headline text-on-surface">Your wishlist is empty</h2>
                <p class="mt-2 text-on-surface-variant max-w-xl mx-auto">
                    @if ($search !== '')
                        No wishlist items matched your search. Try another keyword or clear the search.
                    @else
                        Save courses you love and they will appear here for quick access and future checkout.
                    @endif
                </p>
                <a class="inline-flex items-center gap-2 mt-6 bg-primary text-white px-5 py-3 rounded-xl font-semibold shadow-lg shadow-indigo-500/20" href="/student/browse-courses">
                    <span class="material-symbols-outlined text-sm">explore</span>
                    Browse Courses
                </a>
            </div>
        @endif

        <section class="mt-20">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-[10px] font-extrabold text-primary uppercase tracking-[0.2em]">The Curator's Note</span>
                    <h2 class="text-3xl font-bold font-headline text-on-surface mt-2">Recommended for your collection</h2>
                </div>
                <a class="text-sm font-bold text-on-surface hover:text-primary transition-all flex items-center gap-2" href="/student/browse-courses">
                    View all recommendations
                    <span class="material-symbols-outlined text-base" data-icon="arrow_forward">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($recommendations as $course)
                    <div class="relative group h-64 rounded-xl overflow-hidden">
                        <img alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480' }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-on-surface via-transparent to-transparent opacity-70"></div>
                        <div class="absolute bottom-8 left-8 text-white">
                            <span class="text-[10px] font-bold uppercase tracking-widest bg-tertiary px-2 py-1 rounded mb-3 inline-block">{{ ucfirst($course->level ?: 'Featured') }}</span>
                            <h4 class="text-2xl font-bold font-headline mb-2">{{ $course->title }}</h4>
                            <p class="text-sm opacity-80 mb-4 max-w-xs font-body">{{ \Illuminate\Support\Str::limit($course->details, 110) }}</p>
                            <a class="px-6 py-2 bg-white text-on-surface font-bold rounded-lg text-sm hover:bg-primary hover:text-white transition-all inline-block" href="{{ route('student.course-details', ['course' => $course->id]) }}">See Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <div class="fixed bottom-8 right-8 z-50 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="bg-white/80 backdrop-blur-xl p-4 rounded-xl shadow-2xl border-l-4 border-tertiary flex items-start gap-4 max-w-xs">
            <div class="p-2 bg-tertiary-container/20 rounded-lg text-tertiary">
                <span class="material-symbols-outlined" data-icon="bolt">bolt</span>
            </div>
            <div>
                <p class="text-xs font-bold text-on-surface mb-1">Scholar Insight</p>
                <p class="text-[11px] text-on-surface-variant leading-relaxed">
                    @if ($wishlistCount > 0)
                        You currently have {{ $wishlistCount }} saved course{{ $wishlistCount === 1 ? '' : 's' }} waiting for your next learning move.
                    @else
                        Start curating your next learning path by saving courses from the catalog.
                    @endif
                </p>
            </div>
            <button class="text-on-surface-variant hover:text-on-surface" onclick="this.closest('.fixed').remove()" type="button">
                <span class="material-symbols-outlined text-base" data-icon="close">close</span>
            </button>
        </div>
    </div>
</body>

</html>


