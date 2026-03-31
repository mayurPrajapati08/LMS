<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Academic Curator - Student Feedback & Reviews</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3525cd",
                        "background": "#f8f9fa",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f3f4f5",
                        "surface-container-high": "#e7e8e9",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#464555",
                        "outline-variant": "#c7c4d8",
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; display: inline-block; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)]">
        <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-semibold text-indigo-600">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="w-9 h-9 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-4 md:p-8 max-w-7xl mx-auto">
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h4 class="text-xs font-bold text-primary tracking-[0.1em] uppercase mb-2">Academic Insights</h4>
                    <h1 class="text-4xl font-extrabold tracking-tight">Student Feedback & Reviews</h1>
                    <p class="text-on-surface-variant mt-2 max-w-2xl leading-relaxed">Monitor platform quality and engage with student feedback across all active curriculum paths.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-8">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Reviews</p>
                        <p class="text-3xl font-bold">{{ number_format($totalReviews) }}</p>
                    </div>
                    <div class="text-right border-l border-slate-200 pl-8">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Avg. Rating</p>
                        <div class="flex items-center gap-2 justify-end">
                            <span class="text-3xl font-bold">{{ number_format($averageRating, 1) }}</span>
                            <span class="material-symbols-outlined text-amber-400" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 lg:col-span-3 space-y-6">
                    <div class="bg-surface-container-low rounded-xl p-6">
                        <h3 class="font-semibold text-sm uppercase tracking-wider text-slate-500 mb-4">Filter By Rating</h3>
                        <div class="space-y-3">
                            @foreach ($ratingBreakdown as $rating => $count)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center text-amber-500">
                                            <span class="text-sm font-medium text-on-surface mr-2">{{ $rating }} Stars</span>
                                            <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-400 font-mono">{{ number_format($count) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-9 space-y-4">
                    @forelse ($reviews as $review)
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col sm:flex-row border {{ $featuredReviewId === $review->id ? 'border-2 border-indigo-100 ring-4 ring-indigo-50' : 'border-outline-variant/10' }}">
                            <div class="p-6 flex-1">
                                @if ($featuredReviewId === $review->id)
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="material-symbols-outlined text-indigo-600 text-sm" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                                        <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Featured Review</span>
                                    </div>
                                @endif
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <img alt="{{ $review->user?->name }}" class="w-12 h-12 rounded-full border-2 border-surface-container-high object-cover" src="{{ $review->user?->avatarUrl(96) }}" />
                                        <div>
                                            <h4 class="font-bold text-on-surface">{{ $review->user?->name ?: 'Student' }}</h4>
                                            <p class="text-xs text-slate-500">{{ $review->course?->title ?: 'Course' }} • {{ $review->created_at?->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-amber-500">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <span class="material-symbols-outlined {{ $star <= $review->rating ? '' : 'text-slate-200' }}" style="font-variation-settings: 'FILL' {{ $star <= $review->rating ? 1 : 0 }};">star</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-on-surface-variant text-sm leading-relaxed mb-6">{{ $review->comment ?: 'No written comment was left with this review.' }}</p>
                            </div>
                            <div class="bg-surface-container-low px-6 py-4 sm:w-48 flex sm:flex-col justify-center gap-2 border-t sm:border-t-0 sm:border-l border-slate-100">
                                <span class="flex items-center justify-center gap-2 py-2 px-3 text-xs font-bold {{ $featuredReviewId === $review->id ? 'text-white bg-indigo-600 rounded-lg' : 'text-primary hover:bg-white rounded-lg' }}">
                                    <span class="material-symbols-outlined text-sm">{{ $featuredReviewId === $review->id ? 'check' : 'grade' }}</span>
                                    {{ $featuredReviewId === $review->id ? 'Featured' : 'Review' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="bg-surface-container-lowest rounded-xl p-8 text-sm text-slate-500">No course reviews are available yet.</div>
                    @endforelse

                    <div class="pt-10 flex items-center justify-between border-t border-slate-100 mt-8">
                        <span class="text-sm font-bold text-slate-400">Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</span>
                        <div class="flex gap-4">
                            @for ($page = 1; $page <= min(3, $reviews->lastPage()); $page++)
                                <a class="text-sm font-bold {{ $reviews->currentPage() === $page ? 'text-indigo-600 underline underline-offset-8' : 'text-slate-400 hover:text-on-surface' }}" href="{{ $reviews->url($page) }}">{{ str_pad((string) $page, 2, '0', STR_PAD_LEFT) }}</a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
