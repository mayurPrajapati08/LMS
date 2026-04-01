<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $course->title }} | Student Course Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0c4ea3",
                        "primary-container": "#1570d8",
                        surface: "#f4f9ff",
                        "surface-container-low": "#eef5ff",
                        "surface-container-high": "#e3eeff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#4f6178",
                        outline: "#7c8da7",
                        tertiary: "#007030",
                        secondary: "#3b5f8d"
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
        .player-stage { background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.26), transparent 32%), linear-gradient(180deg, #111827 0%, #0f172a 100%); }
        .player-range { -webkit-appearance: none; appearance: none; background: transparent; }
        .player-range::-webkit-slider-runnable-track { height: 6px; border-radius: 9999px; background: linear-gradient(90deg, #1570d8 var(--range-progress, 0%), rgba(255,255,255,0.16) var(--range-progress, 0%)); }
        .player-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; height: 16px; width: 16px; border-radius: 9999px; background: #ffffff; margin-top: -5px; box-shadow: 0 10px 24px rgba(12, 78, 163, 0.32); }
        .player-range::-moz-range-track { height: 6px; border-radius: 9999px; background: rgba(255,255,255,0.16); }
        .player-range::-moz-range-progress { height: 6px; border-radius: 9999px; background: #1570d8; }
        .player-range::-moz-range-thumb { height: 16px; width: 16px; border: none; border-radius: 9999px; background: #ffffff; }
        .player-feedback {
            --feedback-x: -50%;
            opacity: 0;
            transform: translate(var(--feedback-x), -50%) scale(0.9);
            transition: opacity 180ms ease, transform 220ms ease;
        }
        .player-feedback.is-left { --feedback-x: calc(-50% - 132px); }
        .player-feedback.is-right { --feedback-x: calc(-50% + 132px); }
        .player-feedback.is-visible { opacity: 1; transform: translate(var(--feedback-x), -50%) scale(1); }
        .player-stage:fullscreen,
        .player-stage:-webkit-full-screen {
            width: 100vw;
            height: 100vh;
            max-width: 100vw;
            max-height: 100vh;
            border-radius: 0;
        }
        .player-stage:fullscreen .player-preview-area,
        .player-stage:-webkit-full-screen .player-preview-area {
            height: 100vh;
            aspect-ratio: auto;
        }
        .player-stage:fullscreen video,
        .player-stage:-webkit-full-screen video {
            height: 100%;
        }
        @media (max-width: 768px) {
            #previewPlayerStage {
                border-radius: 1rem;
            }
            #previewFeedback {
                min-width: 96px;
                padding: 0.7rem 0.8rem;
                border-radius: 1rem;
            }
            #previewFeedbackIcon {
                font-size: 1.5rem;
            }
            #previewControls {
                border-radius: 0.9rem;
                padding: 0.65rem;
            }
            #previewControls .mb-3 {
                margin-bottom: 0.5rem;
                gap: 0.4rem;
            }
            #previewCurrentTime,
            #previewDurationTime {
                min-width: 34px;
                font-size: 9px;
            }
            #previewPlayPauseButton {
                height: 2.15rem;
                width: 2.15rem;
            }
            #previewRewindButton,
            #previewForwardButton {
                padding: 0.35rem 0.5rem;
                font-size: 9px;
                gap: 0.15rem;
            }
            #previewMuteButton,
            #previewFullscreenButton {
                height: 1.85rem;
                width: 1.85rem;
            }
            #previewVolumeBar {
                width: 3rem;
            }
            #previewSpeedSelect {
                padding: 0.35rem 0.55rem;
                font-size: 9px;
            }
            #previewPlayPauseIcon {
                font-size: 18px;
            }
        }
        @media (max-width: 520px) {
            #previewControls {
                border-radius: 0.75rem;
                padding: 0.45rem;
            }
            #previewControls .flex-col.gap-2\.5 {
                display: grid;
                grid-template-columns: auto auto auto minmax(0, 1fr) auto auto auto;
                align-items: center;
                gap: 0.28rem;
            }
            #previewControls .flex-col.gap-2\.5 > .flex-wrap.items-center.gap-2 {
                display: contents;
            }
            #previewVolumeBar {
                width: 100%;
                min-width: 0;
            }
            #previewRewindButton,
            #previewForwardButton {
                justify-content: center;
            }
            #previewSpeedSelect {
                min-width: 0;
                width: 100%;
            }
            #previewCurrentTime,
            #previewDurationTime {
                min-width: 30px;
                font-size: 8px;
            }
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
    @php($previewVideoType = str_contains((string) $previewVideoUrl, '.m3u8') ? 'application/vnd.apple.mpegurl' : 'video/mp4')
    <x-student.navbar />

    <header class="fixed top-0 right-0 z-40 flex h-16 w-full items-center justify-between bg-white/80 px-4 shadow-sm backdrop-blur-md md:w-[calc(100%-16rem)] md:px-8">
        <div class="flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input class="w-full rounded-xl border-none bg-surface-container-low py-2.5 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-4">
            <a class="hidden rounded-full bg-surface-container-low px-4 py-2 text-sm font-semibold text-primary md:inline-flex" href="{{ $browseUrl }}">
                Browse courses
            </a>
            <img alt="{{ $student->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="min-h-screen p-4 pt-24 md:ml-64 md:p-8 md:pt-24">
        @if (session('status'))
            <div class="mx-auto mb-6 max-w-7xl rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="mx-auto flex max-w-7xl flex-col gap-8 xl:flex-row">
            <div class="flex-1 space-y-8">
                <section class="space-y-6">
                    <nav class="flex items-center gap-2 text-sm text-on-surface-variant">
                        <a class="hover:text-primary" href="{{ route('student.dashboard') }}">Dashboard</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <a class="hover:text-primary" href="{{ $browseUrl }}">Browse Courses</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <span class="font-medium text-primary">{{ $course->title }}</span>
                    </nav>

                    <div class="space-y-3">
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full bg-[#dcecff] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-primary">{{ $course->category?->name ?? 'Course' }}</span>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-emerald-700">{{ ucfirst($course->level ?: 'all levels') }}</span>
                            @if ($isEnrolled)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-amber-700">Enrolled</span>
                            @endif
                        </div>
                        <h1 class="font-headline text-4xl font-extrabold tracking-tight leading-[1.1] md:text-5xl">{{ $course->title }}</h1>
                        <p class="max-w-3xl text-lg text-on-surface-variant">{{ $course->details }}</p>
                    </div>

                    <div id="previewPlayerStage" class="player-stage overflow-hidden rounded-[1.5rem] shadow-xl">
                        @if ($previewVideoUrl)
                            <div class="player-preview-area relative aspect-video overflow-hidden">
                                <video id="coursePreviewVideo" class="h-full w-full bg-black object-contain" controlsList="nodownload noplaybackrate" data-preview-limit="{{ $previewLimitSeconds ?? 40 }}" poster="{{ $heroThumbnail }}" preload="metadata">
                                    <source src="{{ $previewVideoUrl }}" type="{{ $previewVideoType }}" />
                                </video>
                                <button id="previewPosterOverlay" class="absolute inset-0 z-[5] flex items-center justify-center bg-black/20 transition-opacity duration-200" type="button">
                                    <img alt="{{ $course->title }} thumbnail" class="absolute inset-0 h-full w-full object-cover" src="{{ $heroThumbnail }}" />
                                    <span class="relative inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/90 text-slate-950 shadow-xl">
                                        <span class="material-symbols-outlined text-[32px]">play_arrow</span>
                                    </span>
                                </button>
                                <div id="previewFeedback" class="player-feedback pointer-events-none absolute left-1/2 top-1/2 z-20 flex min-w-[120px] -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center rounded-[1.5rem] bg-black/45 px-5 py-4 text-white shadow-2xl backdrop-blur-xl transition-all duration-200">
                                    <span id="previewFeedbackIcon" class="material-symbols-outlined text-[32px]">play_arrow</span>
                                    <span id="previewFeedbackText" class="mt-2 text-xs font-bold uppercase tracking-[0.22em]">Play</span>
                                </div>
                                <div class="pointer-events-none absolute inset-x-0 top-0 z-10 p-4">
                                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/40 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-white backdrop-blur-xl">
                                        <span class="material-symbols-outlined text-sm">smart_display</span>
                                        Preview 00:{{ str_pad((string) ($previewLimitSeconds ?? 40), 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 z-10 p-3 md:p-4">
                                    <div id="previewControls" class="rounded-[1.1rem] border border-white/10 bg-black/45 p-3 shadow-2xl backdrop-blur-xl">
                                        <div class="mb-3 flex items-center gap-2.5">
                                            <span id="previewCurrentTime" class="min-w-[52px] text-xs font-semibold text-slate-200">00:00</span>
                                            <input id="previewSeekBar" class="player-range h-4 w-full" max="100" min="0" step="0.1" type="range" value="0" />
                                            <span id="previewDurationTime" class="min-w-[52px] text-right text-xs font-semibold text-slate-200">00:{{ str_pad((string) ($previewLimitSeconds ?? 40), 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                                            <div class="flex flex-wrap items-center gap-2.5">
                                                <button id="previewPlayPauseButton" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-950 shadow-lg transition hover:scale-105" type="button">
                                                    <span id="previewPlayPauseIcon" class="material-symbols-outlined text-[24px]">play_arrow</span>
                                                </button>
                                                <button id="previewRewindButton" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-white/15" type="button"><span class="material-symbols-outlined text-[18px]">replay_10</span>-10s</button>
                                                <button id="previewForwardButton" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-white/15" type="button">+10s<span class="material-symbols-outlined text-[18px]">forward_10</span></button>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2.5">
                                                <button id="previewMuteButton" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span id="previewMuteIcon" class="material-symbols-outlined text-[18px]">volume_up</span></button>
                                                <input id="previewVolumeBar" class="player-range h-4 w-20" max="1" min="0" step="0.05" type="range" value="0.3" />
                                                <select id="previewSpeedSelect" class="rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white outline-none">
                                                    <option class="text-slate-900" value="0.75">0.75x</option>
                                                    <option class="text-slate-900" value="1" selected>1x</option>
                                                    <option class="text-slate-900" value="1.25">1.25x</option>
                                                    <option class="text-slate-900" value="1.5">1.5x</option>
                                                </select>
                                                <button id="previewFullscreenButton" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span id="previewFullscreenIcon" class="material-symbols-outlined text-[18px]">fullscreen</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <img alt="{{ $course->title }} thumbnail" class="h-full w-full object-cover" src="{{ $heroThumbnail }}" />
                        @endif
                    </div>
                </section>

                <section class="space-y-8">
                    <div class="flex flex-wrap gap-4 border-b border-surface-container-high font-headline text-sm font-bold uppercase tracking-[0.22em]">
                        <a class="border-b-2 border-primary pb-4 text-primary" href="#overview">Overview</a>
                        <a class="pb-4 text-on-surface-variant hover:text-on-surface" href="#curriculum">Curriculum</a>
                        <a class="pb-4 text-on-surface-variant hover:text-on-surface" href="#reviews">Reviews</a>
                    </div>

                    <section class="grid gap-8 md:grid-cols-3" id="overview">
                        <div class="space-y-6 md:col-span-2">
                            <div>
                                <h2 class="font-headline text-2xl font-bold">About this course</h2>
                                <p class="mt-4 leading-7 text-on-surface-variant">{{ $course->details }}</p>
                            </div>

                            @if ($learningTopics->isNotEmpty())
                                <div>
                                    <h3 class="font-headline text-lg font-bold">What you'll learn</h3>
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        @foreach ($learningTopics as $topic)
                                            <div class="flex items-start gap-3 rounded-xl bg-surface-container-low px-4 py-3 text-sm text-on-surface-variant">
                                                <span class="material-symbols-outlined text-tertiary">check_circle</span>
                                                <span>{{ $topic }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="rounded-[1.5rem] bg-surface-container-low p-6">
                            <h3 class="font-headline text-sm font-bold uppercase tracking-[0.22em] text-on-surface-variant">Highlights</h3>
                            <div class="mt-5 space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">schedule</span>
                                    <span class="text-sm font-medium">{{ $formattedDuration }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">menu_book</span>
                                    <span class="text-sm font-medium">{{ $totalLessons }} lessons</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">language</span>
                                    <span class="text-sm font-medium">{{ $course->language ?: 'English' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">group</span>
                                    <span class="text-sm font-medium">{{ number_format($studentsCount) }} students</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-4" id="curriculum">
                        <h2 class="font-headline text-2xl font-bold">Course curriculum</h2>
                        @foreach ($sections as $index => $section)
                            <div class="overflow-hidden rounded-[1.25rem] bg-surface-container-low">
                                <div class="flex items-center justify-between px-5 py-4 font-bold">
                                    <div class="flex items-center gap-4">
                                        <span class="text-primary">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        <span>{{ $section['title'] }}</span>
                                    </div>
                                    <span class="text-xs text-on-surface-variant">{{ $section['lessons_count'] }} lessons</span>
                                </div>
                                <div class="space-y-3 px-5 pb-5">
                                    @foreach ($section['lessons'] as $lesson)
                                        <div class="flex items-center justify-between rounded-lg bg-white px-4 py-3 text-sm">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-slate-400 text-base">play_circle</span>
                                                <span>{{ $lesson['title'] }}</span>
                                            </div>
                                            <span class="text-on-surface-variant">{{ $lesson['duration'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </section>

                    <section class="space-y-5" id="reviews">
                        <div class="flex items-center justify-between">
                            <h2 class="font-headline text-2xl font-bold">Reviews</h2>
                            <div class="rounded-full bg-surface-container-low px-4 py-2 text-sm font-bold text-primary">{{ number_format($rating > 0 ? $rating : 4.8, 1) }}/5</div>
                        </div>
                        @forelse ($reviews as $review)
                            <article class="rounded-[1.25rem] border border-slate-200/70 bg-white p-6 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <img alt="{{ $review['name'] }} avatar" class="h-12 w-12 rounded-full object-cover" src="{{ $review['avatar'] }}" />
                                    <div>
                                        <p class="font-bold">{{ $review['name'] }}</p>
                                        <p class="text-xs text-on-surface-variant">{{ $review['created_at'] }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex text-amber-500">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $star <= $review['rating'] ? 1 : 0 }};">star</span>
                                    @endfor
                                </div>
                                <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $review['comment'] }}</p>
                            </article>
                        @empty
                            <div class="rounded-[1.25rem] bg-surface-container-low p-6 text-sm text-on-surface-variant">Reviews will appear here as students rate the course.</div>
                        @endforelse
                    </section>
                </section>
            </div>

            <div class="w-full xl:w-96">
                <div class="sticky top-24 space-y-6">
                    <div class="rounded-[1.5rem] border border-surface-container-low bg-white p-6 shadow-xl">
                        <div class="flex items-baseline gap-2">
                            <span class="font-headline text-4xl font-extrabold text-on-surface">Rs. {{ number_format((float) $course->price, 0) }}</span>
                            @if ($isWishlisted)
                                <span class="ml-auto rounded-full bg-amber-100 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-amber-700">Saved</span>
                            @endif
                        </div>
                        <div class="mt-6 space-y-3">
                            @if ($isEnrolled)
                                <a class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-primary to-primary-container px-6 py-4 text-sm font-bold text-white shadow-lg shadow-primary/20" href="{{ $continueUrl }}">
                                    Continue Learning
                                </a>
                            @else
                                <a class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-primary to-primary-container px-6 py-4 text-sm font-bold text-white shadow-lg shadow-primary/20" href="{{ $checkoutUrl }}">
                                    Buy Now
                                </a>
                            @endif
                            <a class="flex w-full items-center justify-center rounded-xl bg-surface-container-high px-6 py-4 text-sm font-bold text-primary" href="{{ $browseUrl }}">
                                Back to Browse
                            </a>
                            @unless ($isEnrolled)
                                <form action="{{ route('student.cart.add', ['course' => $course->id]) }}" method="POST">
                                    @csrf
                                    <button class="flex w-full items-center justify-center gap-2 rounded-xl border border-primary/15 px-6 py-4 text-sm font-bold transition-all {{ $isInCart ? 'bg-[#edf5ff] text-primary' : 'bg-white text-on-surface-variant hover:bg-[#edf5ff] hover:text-primary' }}" type="submit">
                                        <span class="material-symbols-outlined" @if($isInCart) style="font-variation-settings: 'FILL' 1;" @endif>shopping_cart</span>
                                        {{ $isInCart ? 'Already in Cart' : 'Add to Cart' }}
                                    </button>
                                </form>
                                @if ($isInCart)
                                    <a class="flex w-full items-center justify-center rounded-xl bg-surface-container-low px-6 py-4 text-sm font-bold text-primary" href="{{ $cartUrl }}">
                                        Open Cart
                                    </a>
                                @endif
                            @endunless
                            <form action="{{ route('student.wishlist.toggle', ['course' => $course->id]) }}" method="POST">
                                @csrf
                                <button class="flex w-full items-center justify-center gap-2 rounded-xl border border-rose-200 px-6 py-4 text-sm font-bold transition-all {{ $isWishlisted ? 'bg-rose-50 text-rose-600' : 'bg-white text-on-surface-variant hover:bg-rose-50 hover:text-rose-600' }}" type="submit">
                                    <span @class([
                                        'material-symbols-outlined',
                                        'font-variation-settings-fill' => $isWishlisted,
                                    ])>favorite</span>
                                    {{ $isWishlisted ? 'Saved to Wishlist' : 'Save to Wishlist' }}
                                </button>
                            </form>
                        </div>
                        <div class="mt-6 border-t border-surface-container-low pt-6">
                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">This course includes</p>
                            <div class="mt-4 space-y-3 text-sm text-on-surface-variant">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">all_inclusive</span>
                                    <span>{{ $course->validity_in_days ? $course->validity_in_days.' days access' : 'Lifetime access' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">workspace_premium</span>
                                    <span>Certificate eligibility after completion</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">smart_display</span>
                                    <span>Real player playback after enrollment</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[1.5rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70">
                        <div class="flex items-center gap-4">
                            <img alt="{{ $course->user?->name }} avatar" class="h-16 w-16 rounded-full object-cover" src="{{ $course->user?->avatarUrl(96) }}" />
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary">Instructor</p>
                                <p class="font-headline font-bold">{{ $course->user?->name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $course->category?->name ?? 'Course mentor' }}</p>
                            </div>
                        </div>
                        @if ($course->user?->bio)
                            <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $course->user->bio }}</p>
                        @endif
                    </div>

                    @if (collect($relatedCourses)->isNotEmpty())
                        <section class="space-y-4">
                            <h3 class="font-headline text-xl font-bold">Related courses</h3>
                            @foreach ($relatedCourses as $relatedCourse)
                                <a class="block overflow-hidden rounded-[1.25rem] bg-surface-container-lowest shadow-sm ring-1 ring-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg" href="{{ $relatedCourse['details_url'] }}">
                                    <img alt="{{ $relatedCourse['title'] }} thumbnail" class="aspect-video w-full object-cover" src="{{ $relatedCourse['thumbnail'] }}" />
                                    <div class="space-y-2 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">{{ $relatedCourse['category'] }}</p>
                                        <h4 class="font-bold">{{ $relatedCourse['title'] }}</h4>
                                        <div class="flex items-center justify-between text-xs text-on-surface-variant">
                                            <span>{{ $relatedCourse['instructor_name'] }}</span>
                                            <span>Rs. {{ number_format($relatedCourse['price'], 0) }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <script>
        (function () {
            var video = document.getElementById('coursePreviewVideo');
            if (!video) return;

            var sourceElement = video.querySelector('source');
            var sourceUrl = sourceElement ? sourceElement.getAttribute('src') || '' : '';
            var streamLoader = null;
            var playerStage = document.getElementById('previewPlayerStage');
            var posterOverlay = document.getElementById('previewPosterOverlay');
            var playPauseButton = document.getElementById('previewPlayPauseButton');
            var playPauseIcon = document.getElementById('previewPlayPauseIcon');
            var rewindButton = document.getElementById('previewRewindButton');
            var forwardButton = document.getElementById('previewForwardButton');
            var muteButton = document.getElementById('previewMuteButton');
            var muteIcon = document.getElementById('previewMuteIcon');
            var seekBar = document.getElementById('previewSeekBar');
            var volumeBar = document.getElementById('previewVolumeBar');
            var speedSelect = document.getElementById('previewSpeedSelect');
            var fullscreenButton = document.getElementById('previewFullscreenButton');
            var fullscreenIcon = document.getElementById('previewFullscreenIcon');
            var currentTime = document.getElementById('previewCurrentTime');
            var durationTime = document.getElementById('previewDurationTime');
            var feedback = document.getElementById('previewFeedback');
            var feedbackIcon = document.getElementById('previewFeedbackIcon');
            var feedbackText = document.getElementById('previewFeedbackText');
            var previewLimit = Math.max(1, Number(video.getAttribute('data-preview-limit') || '40'));
            var feedbackTimer = null;
            var hasStartedPlayback = false;
            var orientationLocked = false;

            function initializeVideoSource() {
                if (!sourceUrl) {
                    return;
                }

                if (!/\.m3u8($|\?)/i.test(sourceUrl)) {
                    if (!video.getAttribute('src')) {
                        video.src = sourceUrl;
                    }
                    return;
                }

                if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = sourceUrl;
                    return;
                }

                if (window.Hls && window.Hls.isSupported()) {
                    streamLoader = new window.Hls();
                    streamLoader.loadSource(sourceUrl);
                    streamLoader.attachMedia(video);
                }
            }

            function formatTime(seconds) {
                var safeSeconds = Math.max(0, Math.floor(Number(seconds) || 0));
                var minutes = Math.floor(safeSeconds / 60);
                var remainder = safeSeconds % 60;
                return String(minutes).padStart(2, '0') + ':' + String(remainder).padStart(2, '0');
            }

            function setRangeProgress(input) {
                if (!input) return;
                var min = Number(input.min || 0);
                var max = Number(input.max || 100);
                var value = Number(input.value || 0);
                var progress = max > min ? ((value - min) / (max - min)) * 100 : 0;
                input.style.setProperty('--range-progress', progress + '%');
            }

            function showFeedback(icon, text, position) {
                if (!feedback || !feedbackIcon || !feedbackText) return;
                feedback.classList.remove('is-left', 'is-right');
                if (position === 'left') feedback.classList.add('is-left');
                else if (position === 'right') feedback.classList.add('is-right');
                feedbackIcon.textContent = icon;
                feedbackText.textContent = text;
                feedback.classList.add('is-visible');
                window.clearTimeout(feedbackTimer);
                feedbackTimer = window.setTimeout(function () {
                    feedback.classList.remove('is-visible');
                }, 700);
            }

            function updatePlayState() {
                playPauseIcon.textContent = (video.paused || video.ended) ? 'play_arrow' : 'pause';
            }

            function setPosterVisibility(shouldShowPoster) {
                if (posterOverlay) {
                    var canShowPoster = !hasStartedPlayback && shouldShowPoster;
                    posterOverlay.style.opacity = canShowPoster ? '1' : '0';
                    posterOverlay.style.pointerEvents = canShowPoster ? 'auto' : 'none';
                }
            }

            function updateMuteState() {
                muteIcon.textContent = video.muted || Number(volumeBar.value) === 0 ? 'volume_off' : 'volume_up';
            }

            function updateTimeline() {
                var cappedCurrent = Math.min(video.currentTime || 0, previewLimit);
                seekBar.value = previewLimit > 0 ? (cappedCurrent / previewLimit) * 100 : 0;
                currentTime.textContent = formatTime(cappedCurrent);
                durationTime.textContent = formatTime(previewLimit);
                setRangeProgress(seekBar);
            }

            function stopAtPreviewLimit() {
                if ((video.currentTime || 0) < previewLimit) {
                    return;
                }

                video.pause();
                video.currentTime = 0;
                updateTimeline();
            }

            function togglePlay() {
                if (video.paused || video.ended) video.play();
                else video.pause();
            }

            function toggleFullscreen() {
                if (!playerStage) return;
                if (!document.fullscreenElement) {
                    var requestFullscreen = playerStage.requestFullscreen || playerStage.webkitRequestFullscreen;
                    if (requestFullscreen) {
                        var requestResult = requestFullscreen.call(playerStage);
                        if (requestResult && typeof requestResult.catch === 'function') requestResult.catch(function () {});
                    }
                    if (window.innerWidth < 900 && screen.orientation && typeof screen.orientation.lock === 'function') {
                        screen.orientation.lock('landscape').then(function () {
                            orientationLocked = true;
                        }).catch(function () {});
                    }
                } else {
                    var exitFullscreen = document.exitFullscreen || document.webkitExitFullscreen;
                    if (exitFullscreen) {
                        var exitResult = exitFullscreen.call(document);
                        if (exitResult && typeof exitResult.catch === 'function') exitResult.catch(function () {});
                    }
                }
            }

            playPauseButton.addEventListener('click', togglePlay);
            if (posterOverlay) {
                posterOverlay.addEventListener('click', function () {
                    video.currentTime = 0;
                    setPosterVisibility(false);
                    togglePlay();
                });
            }
            video.addEventListener('click', togglePlay);
            video.addEventListener('play', function () { hasStartedPlayback = true; setPosterVisibility(false); updatePlayState(); showFeedback('play_arrow', 'Play', 'center'); });
            video.addEventListener('playing', function () { hasStartedPlayback = true; setPosterVisibility(false); updatePlayState(); });
            video.addEventListener('pause', function () { setPosterVisibility(false); updatePlayState(); showFeedback('pause', 'Pause', 'center'); });
            video.addEventListener('ended', function () { setPosterVisibility(false); updatePlayState(); });
            rewindButton.addEventListener('click', function () {
                video.currentTime = Math.max(0, (video.currentTime || 0) - 10);
                updateTimeline();
                showFeedback('replay_10', 'Back 10s', 'left');
            });
            forwardButton.addEventListener('click', function () {
                video.currentTime = Math.min(previewLimit, (video.currentTime || 0) + 10);
                updateTimeline();
                showFeedback('forward_10', 'Skip 10s', 'right');
            });
            seekBar.addEventListener('input', function () {
                video.currentTime = (Number(seekBar.value) / 100) * previewLimit;
                updateTimeline();
                setRangeProgress(seekBar);
            });
            volumeBar.addEventListener('input', function () {
                video.volume = Number(volumeBar.value);
                video.muted = Number(volumeBar.value) === 0;
                updateMuteState();
                setRangeProgress(volumeBar);
            });
            muteButton.addEventListener('click', function () {
                video.muted = !video.muted;
                if (!video.muted && Number(volumeBar.value) === 0) {
                    volumeBar.value = 0.5;
                    video.volume = 0.5;
                }
                updateMuteState();
                setRangeProgress(volumeBar);
                showFeedback(video.muted ? 'volume_off' : 'volume_up', video.muted ? 'Muted' : 'Volume On', 'center');
            });
            speedSelect.addEventListener('change', function () {
                video.playbackRate = Number(speedSelect.value);
                showFeedback('speed', speedSelect.value + 'x', 'center');
            });
            fullscreenButton.addEventListener('click', toggleFullscreen);
            document.addEventListener('fullscreenchange', function () {
                if (fullscreenIcon) {
                    fullscreenIcon.textContent = document.fullscreenElement ? 'fullscreen_exit' : 'fullscreen';
                }
                if (!document.fullscreenElement && orientationLocked && screen.orientation && typeof screen.orientation.unlock === 'function') {
                    screen.orientation.unlock();
                    orientationLocked = false;
                }
            });
            document.addEventListener('keydown', function (event) {
                var activeTag = document.activeElement ? document.activeElement.tagName : '';
                if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT') return;
                if (event.code === 'Space') { event.preventDefault(); togglePlay(); }
                else if (event.key === 'ArrowLeft') { event.preventDefault(); rewindButton.click(); }
                else if (event.key === 'ArrowRight') { event.preventDefault(); forwardButton.click(); }
                else if (event.key.toLowerCase() === 'm') { event.preventDefault(); muteButton.click(); }
                else if (event.key.toLowerCase() === 'f') { event.preventDefault(); toggleFullscreen(); }
            });
            video.addEventListener('loadedmetadata', function () {
                video.currentTime = 0;
                setPosterVisibility(true);
                updateTimeline();
            });
            video.addEventListener('timeupdate', function () {
                stopAtPreviewLimit();
                updateTimeline();
            });
            video.addEventListener('seeking', function () {
                if ((video.currentTime || 0) > previewLimit) {
                    video.currentTime = previewLimit;
                }
                updateTimeline();
            });

            initializeVideoSource();
            video.volume = 0.3;
            volumeBar.value = 0.3;
            setRangeProgress(seekBar);
            setRangeProgress(volumeBar);
            setPosterVisibility(true);
            updatePlayState();
            updateMuteState();
            updateTimeline();
        })();
    </script>
</body>
</html>


