<x-student.layout title='Wishlist | CodeInYourself'>
<x-student.topbar>
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.26em] text-on-surface-variant">Saved Picks</p>
            <p class="font-headline text-lg font-extrabold text-on-surface">Wishlist</p>
        </div>
        <x-slot:center>
            <form action="{{ route('student.wishlist') }}" method="GET">
                <label class="student-top-search">
                    <span class="material-symbols-outlined text-on-surface-variant">search</span>
                    <input name="search" placeholder="Search your saved courses" type="text" value="{{ $search }}" />
                </label>
            </form>
        </x-slot:center>
        <x-slot:right>
            <a class="student-pill-button student-pill-button--ghost hidden md:inline-flex" href="{{ route('student.cart') }}">Cart</a>
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
                <p class="student-eyebrow">Saved Picks</p>
                <h1 class="student-page-title">Wishlist</h1>
                <p class="student-page-copy">A simple shortlist of courses worth revisiting when you are ready to buy.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $wishlistCount }} courses saved</span>
                <span class="student-chip">{{ $wishlistValue }} total value</span>
                @if ($topCategory)
                    <span class="student-chip">{{ $topCategory }} leads your list</span>
                @endif
            </div>
        </section>

        <section class="student-stats-strip">
            <div class="student-stat">
                <p class="student-stat-label">Saved</p>
                <p class="student-stat-value">{{ $wishlistCount }}</p>
                <p class="student-stat-copy">Courses bookmarked</p>
            </div>
            <div class="student-stat">
                <p class="student-stat-label">Value</p>
                <p class="student-stat-value">{{ $wishlistValue }}</p>
                <p class="student-stat-copy">Combined wishlist total</p>
            </div>
            @if ($topCategory)
                <div class="student-stat">
                    <p class="student-stat-label">Top Category</p>
                    <p class="student-stat-value">{{ $topCategory }}</p>
                    <p class="student-stat-copy">Most saved topic</p>
                </div>
            @endif
        </section>

        <section class="student-side-card flex flex-wrap items-center justify-between gap-6 mb-8">
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
                    <article class="group bg-surface-container-lowest rounded-[1.3rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full">
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
                                    <button class="w-full px-4 py-3 bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-on-primary font-bold text-sm rounded-xl hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-2" type="submit">
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
            <div class="bg-surface-container-lowest rounded-[1.2rem] shadow-sm border border-dashed border-[#e7d8ee] p-9 text-center">
                <div class="mx-auto w-16 h-16 rounded-[1rem] bg-primary-fixed flex items-center justify-center text-primary mb-4">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h2 class="text-[1.9rem] font-bold font-headline text-on-surface">Your wishlist is empty</h2>
                <p class="mt-2 text-on-surface-variant max-w-xl mx-auto">
                    @if ($search !== '')
                        No wishlist items matched your search. Try another keyword or clear the search.
                    @else
                        Save courses you love and they will appear here for quick access and future checkout.
                    @endif
                </p>
                <a class="inline-flex items-center gap-2 mt-6 bg-primary text-white px-5 py-3 rounded-xl font-semibold shadow-lg shadow-[#b07ac3]/20" href="{{ route('student.browse-courses') }}">
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
                <a class="text-sm font-bold text-on-surface hover:text-primary transition-all flex items-center gap-2" href="{{ route('student.browse-courses') }}">
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
        </div>
    </main>

    <div class="fixed bottom-8 right-8 z-50 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="bg-white/82 backdrop-blur-xl p-4 rounded-[1.1rem] shadow-2xl border border-[#e9e2fb] flex items-start gap-4 max-w-xs">
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
</x-student.layout>

