<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Reviews</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#b07ac3",
                        "outline-variant": "#dbcde4",
                        "secondary-container": "#eadcf1",
                        "background": "#fcf9fe",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#6d5a76",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#8f7a99",
                        "on-secondary-fixed-variant": "#755b83",
                        "on-primary-fixed-variant": "#8f52a3",
                        "surface-tint": "#b07ac3",
                        "on-primary-container": "#f5eef8",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f5fbff",
                        "primary": "#6a3378",
                        "surface-bright": "#fcf9fe",
                        "secondary-fixed": "#f0e6f4",
                        "primary-fixed-dim": "#e1cde8",
                        "primary-fixed": "#f0e6f4",
                        "error": "#ba1a1a",
                        "surface-variant": "#e7dcef",
                        "secondary-fixed-dim": "#e1cde8",
                        "surface": "#fcf9fe",
                        "on-error": "#ffffff",
                        "surface-container-high": "#efe5f4",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#e7dcef",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#f5eef8",
                        "secondary": "#3b5f8d",
                        "inverse-surface": "#563060",
                        "surface-container": "#f2e9f6",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#e1cde8",
                        "surface-dim": "#d4e3f8",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#715f7a",
                        "on-secondary-fixed": "#4b2356"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; background: #fcf9fe; color: #191c1d; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .editorial-shadow { box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 w-full pl-16 pr-4 md:px-8 py-4 bg-white/88 backdrop-blur-md border-b border-[#eadff1] flex justify-between items-center shadow-sm">
            <div>
                <h1 class="font-headline text-3xl font-bold tracking-tight text-slate-900">Reviews</h1>
                <p class="mt-1 text-sm text-slate-500">See what students are saying about your published experience.</p>
            </div>
            <div class="flex items-center gap-6">
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <img alt="Instructor Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#eadff1]" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="max-w-6xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
            <section class="grid grid-cols-1 lg:grid-cols-[0.9fr_1.1fr] gap-6">
                <div class="rounded-[28px] bg-white p-6 md:p-8 border border-slate-200 editorial-shadow">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#6a3378]">Average Rating</p>
                    <div class="mt-4 flex items-end gap-3">
                        <p class="font-headline text-5xl font-bold text-slate-900">{{ $averageRating }}</p>
                        <p class="pb-2 text-sm font-medium text-slate-500">/ 5.0</p>
                    </div>
                    <div class="mt-4 flex gap-1 text-amber-500">
                        @for($star = 1; $star <= 5; $star++)
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">{{ $star <= round((float) $averageRating) ? 'star' : 'star_outline' }}</span>
                        @endfor
                    </div>
                    <p class="mt-5 text-sm leading-relaxed text-slate-500">Based on {{ $totalReviews }} student reviews across your instructor catalog.</p>
                </div>

                <div class="rounded-[28px] bg-gradient-to-br from-slate-950 via-[#4d255f] to-[#8f52a3] p-6 md:p-8 text-white editorial-shadow">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#eadff1]">Review Snapshot</p>
                    <div class="mt-6 grid grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-white/10 p-4">
                            <p class="text-2xl font-bold">{{ $fiveStarReviews }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#eadff1]/80">5-star</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <p class="text-2xl font-bold">{{ $recentReviews }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#eadff1]/80">Last 30 days</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <p class="text-2xl font-bold">{{ $totalReviews }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#eadff1]/80">Total</p>
                        </div>
                    </div>
                    <div class="mt-6 rounded-2xl bg-white/10 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#eadff1]/80">Most Reviewed Course</p>
                        <p class="mt-2 font-headline text-2xl font-bold">{{ $topReviewedCourse }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-[28px] bg-white border border-slate-200 overflow-hidden editorial-shadow">
                <div class="px-6 md:px-8 py-6 border-b border-slate-200 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex gap-3 flex-wrap">
                        <span class="rounded-full bg-[#f5eef8] px-4 py-2 text-sm font-semibold text-[#6a3378]">All Reviews {{ $totalReviews }}</span>
                        <span class="rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">5-Star {{ $fiveStarReviews }}</span>
                        <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">Recent {{ $recentReviews }}</span>
                    </div>
                    <p class="text-sm text-slate-500">Showing {{ $reviews->firstItem() ?? 0 }} - {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() }}</p>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    @forelse($reviews as $review)
                        <article class="rounded-[24px] border border-slate-200 bg-slate-50/60 p-6 hover:bg-slate-50 transition-colors">
                            <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                                <div class="flex items-center gap-4">
                                    <img alt="Student Avatar" class="w-14 h-14 rounded-2xl object-cover" src="{{ $review->user?->avatarUrl(112) }}" />
                                    <div>
                                        <h3 class="font-headline text-xl font-bold text-slate-900">{{ $review->user->name }}</h3>
                                        <p class="mt-1 text-sm text-slate-500">Course: <span class="font-semibold text-[#6a3378]">{{ $review->course->title }}</span></p>
                                        <p class="mt-1 text-xs text-slate-400">{{ $review->user->email ?? 'Student email unavailable' }}</p>
                                    </div>
                                </div>
                                <div class="md:text-right">
                                    <div class="flex gap-1 text-amber-500 md:justify-end">
                                        @for($star = 1; $star <= 5; $star++)
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">{{ $star <= $review->rating ? 'star' : 'star_outline' }}</span>
                                        @endfor
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-slate-500">{{ $review->created_at?->diffForHumans() }}</p>
                                </div>
                            </div>
                            <blockquote class="mt-6 text-sm leading-7 text-slate-600">
                                {{ $review->comment ?: 'This student left a rating without a written comment.' }}
                            </blockquote>
                        </article>
                    @empty
                        <div class="rounded-[24px] border border-slate-200 bg-slate-50 px-6 py-16 text-center text-sm text-slate-500">
                            No reviews have been submitted yet.
                        </div>
                    @endforelse
                </div>

                @if($reviews->hasPages())
                    <div class="flex items-center justify-between px-6 md:px-8 py-5 border-t border-slate-200 bg-slate-50/60">
                        <div class="text-sm text-slate-500">Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</div>
                        <div>{{ $reviews->onEachSide(1)->links() }}</div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</body>
</html>



