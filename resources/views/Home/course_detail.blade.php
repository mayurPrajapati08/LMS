<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $course->title }} | CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#08275c",
                        "on-primary": "#FFFFFF",
                        "primary-container": "#dcecff",
                        "on-primary-container": "#071c4a",
                        secondary: "#565E71",
                        "on-secondary": "#FFFFFF",
                        "secondary-container": "#DAE2F9",
                        "on-secondary-container": "#131C2C",
                        tertiary: "#006B24",
                        "on-tertiary": "#FFFFFF",
                        "tertiary-container": "#9EF7A0",
                        "on-tertiary-container": "#002106",
                        surface: "#f4f9ff",
                        background: "#f7fbff",
                        "surface-variant": "#E1E2EC",
                        "surface-container-low": "#f1f4f9",
                        "surface-container-high": "#e5e8ee",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#1A1C1E",
                        "on-surface-variant": "#4f6178",
                        outline: "#7c8da7",
                        error: "#BA1A1A"
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
        .player-preview-area {
            cursor: default;
        }
        .player-preview-area.player-ui-idle {
            cursor: none;
        }
        .player-preview-area.player-ui-idle #previewControls {
            opacity: 0;
            transform: translateY(8px);
            pointer-events: none;
        }
        #previewControls {
            transition: opacity 180ms ease, transform 220ms ease;
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
            #previewControls .mb-2\.5 {
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
<body class="bg-surface font-body text-on-surface">
    @php($previewVideoType = str_contains((string) $previewVideoUrl, '.m3u8') ? 'application/vnd.apple.mpegurl' : 'video/mp4')
    <x-home.navbar />

    <main class="pb-20 pt-24">
        <section class="mx-auto mb-16 max-w-7xl px-6">
            <nav class="mb-8 flex items-center space-x-2 text-sm text-on-surface-variant">
                <span>Home</span>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <a class="hover:text-primary" href="{{ $browseUrl }}">Courses</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="font-medium text-primary">{{ $course->title }}</span>
            </nav>

            <div class="grid gap-12 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-7">
                    <p class="mb-3 inline-flex rounded-full bg-primary/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-primary">
                        {{ $course->category?->name ?? 'Course' }}
                    </p>
                    <h1 class="font-headline text-4xl font-extrabold tracking-tight text-on-surface lg:text-6xl">
                        {{ $course->title }}
                    </h1>
                    <p class="mt-5 max-w-3xl text-lg leading-8 text-on-surface-variant">
                        {{ $course->details }}
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4 text-sm">
                        <div class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 font-bold text-emerald-700">
                            <span class="material-symbols-outlined mr-2 text-base" style="font-variation-settings: 'FILL' 1;">star</span>
                            {{ number_format($rating > 0 ? $rating : 4.8, 1) }}
                        </div>
                        <span class="text-on-surface-variant">({{ number_format($reviewsCount) }} reviews)</span>
                        <span class="text-on-surface-variant">{{ number_format($studentsCount) }} students</span>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div class="rounded-2xl bg-surface-container-low p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-on-surface-variant">Duration</p>
                            <p class="mt-2 font-bold">{{ $formattedDuration }}</p>
                        </div>
                        <div class="rounded-2xl bg-surface-container-low p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-on-surface-variant">Level</p>
                            <p class="mt-2 font-bold">{{ ucfirst($course->level ?: 'All levels') }}</p>
                        </div>
                        <div class="rounded-2xl bg-surface-container-low p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-on-surface-variant">Lessons</p>
                            <p class="mt-2 font-bold">{{ $totalLessons }}</p>
                        </div>
                        <div class="rounded-2xl bg-surface-container-low p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-on-surface-variant">Language</p>
                            <p class="mt-2 font-bold">{{ $course->language ?: 'English' }}</p>
                        </div>
                    </div>

                    @if ($learningTopics->isNotEmpty())
                        <div class="mt-10">
                            <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-on-surface-variant">Tools you will learn</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($learningTopics as $topic)
                                    <span class="rounded-2xl bg-surface-container-lowest px-4 py-3 text-sm font-semibold shadow-sm ring-1 ring-slate-200/70">{{ $topic }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                        @auth
                            @if ($isEnrolled)
                                <a class="inline-flex items-center justify-center rounded-xl bg-tertiary px-8 py-4 text-lg font-bold text-white shadow-lg" href="{{ $continueUrl }}">
                                    Continue Learning
                                </a>
                            @else
                                <a class="inline-flex items-center justify-center rounded-xl bg-primary-container px-8 py-4 text-lg font-bold text-white shadow-lg" href="{{ route('student.browse-courses') }}">
                                    Continue to Enroll
                                </a>
                            @endif
                        @else
                            <a class="inline-flex items-center justify-center rounded-xl bg-primary-container px-8 py-4 text-lg font-bold text-white shadow-lg" href="{{ route('login') }}">
                                Login to Enroll
                            </a>
                        @endauth
                        <a class="inline-flex items-center justify-center rounded-xl border-2 border-slate-200 bg-surface-container-lowest px-8 py-4 text-lg font-bold text-on-surface-variant" href="{{ $browseUrl }}">
                            Browse More Courses
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div id="previewPlayerStage" class="player-stage relative overflow-hidden rounded-[2rem] shadow-2xl">
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
                                <div id="previewFeedback" class="player-feedback pointer-events-none absolute left-1/2 top-1/2 z-20 flex min-w-[104px] -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center rounded-[1.2rem] bg-black/45 px-4 py-3 text-white shadow-2xl backdrop-blur-xl transition-all duration-200">
                                    <span id="previewFeedbackIcon" class="material-symbols-outlined text-[32px]">play_arrow</span>
                                    <span id="previewFeedbackText" class="mt-2 text-xs font-bold uppercase tracking-[0.22em]">Play</span>
                                </div>
                                <div class="pointer-events-none absolute inset-x-0 top-0 z-10 p-4">
                                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/40 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-white backdrop-blur-xl">
                                        <span class="material-symbols-outlined text-sm">smart_display</span>
                                        Preview 00:{{ str_pad((string) ($previewLimitSeconds ?? 40), 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 z-10 p-2.5 md:p-3">
                                    <div id="previewControls" class="rounded-[0.95rem] border border-white/10 bg-black/45 p-2.5 shadow-2xl backdrop-blur-xl">
                                        <div class="mb-2.5 flex items-center gap-2">
                                            <span id="previewCurrentTime" class="min-w-[44px] text-[11px] font-semibold text-slate-200">00:00</span>
                                            <input id="previewSeekBar" class="player-range h-4 w-full" max="100" min="0" step="0.1" type="range" value="0" />
                                            <span id="previewDurationTime" class="min-w-[44px] text-right text-[11px] font-semibold text-slate-200">00:{{ str_pad((string) ($previewLimitSeconds ?? 40), 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div class="flex flex-col gap-2.5 lg:flex-row lg:items-center lg:justify-between">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <button id="previewPlayPauseButton" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-slate-950 shadow-lg transition hover:scale-105" type="button">
                                                    <span id="previewPlayPauseIcon" class="material-symbols-outlined text-[22px]">play_arrow</span>
                                                </button>
                                                <button id="previewRewindButton" class="inline-flex items-center gap-1 rounded-full bg-white/10 px-3 py-1.5 text-[11px] font-semibold text-white transition hover:bg-white/15" type="button"><span class="material-symbols-outlined text-[16px]">replay_10</span>-10s</button>
                                                <button id="previewForwardButton" class="inline-flex items-center gap-1 rounded-full bg-white/10 px-3 py-1.5 text-[11px] font-semibold text-white transition hover:bg-white/15" type="button">+10s<span class="material-symbols-outlined text-[16px]">forward_10</span></button>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <button id="previewMuteButton" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span id="previewMuteIcon" class="material-symbols-outlined text-[16px]">volume_up</span></button>
                                                <input id="previewVolumeBar" class="player-range h-4 w-16 md:w-20" max="1" min="0" step="0.05" type="range" value="0.3" />
                                                <select id="previewSpeedSelect" class="rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[11px] font-semibold text-white outline-none">
                                                    <option class="text-slate-900" value="0.75">0.75x</option>
                                                    <option class="text-slate-900" value="1" selected>1x</option>
                                                    <option class="text-slate-900" value="1.25">1.25x</option>
                                                    <option class="text-slate-900" value="1.5">1.5x</option>
                                                </select>
                                                <button id="previewFullscreenButton" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span id="previewFullscreenIcon" class="material-symbols-outlined text-[16px]">fullscreen</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <img alt="{{ $course->title }} thumbnail" class="aspect-video w-full object-cover opacity-85" src="{{ $heroThumbnail }}" />
                        @endif
                        <div class="space-y-5 bg-surface-container-lowest p-8 text-on-surface">
                            <div class="flex items-end justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-on-surface-variant">Current fee</p>
                                    <p class="mt-2 font-headline text-4xl font-extrabold">Rs. {{ number_format((float) $course->price, 0) }}</p>
                                </div>
                                @if ($isWishlisted)
                                    <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-amber-700">Saved in wishlist</span>
                                @endif
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-on-surface-variant">Sections</span>
                                    <span class="font-bold">{{ $totalSections }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-on-surface-variant">Students</span>
                                    <span class="font-bold">{{ number_format($studentsCount) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-on-surface-variant">Validity</span>
                                    <span class="font-bold">{{ $course->validity_in_days ? $course->validity_in_days.' days' : 'Lifetime access' }}</span>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-primary/5 p-5">
                                <div class="flex items-center gap-3">
                                    <img alt="{{ $course->user?->name }} avatar" class="h-12 w-12 rounded-full object-cover" src="{{ $course->user?->avatarUrl(96) }}" />
                                    <div>
                                        <p class="font-bold">{{ $course->user?->name }}</p>
                                        <p class="text-xs text-on-surface-variant">Instructor</p>
                                    </div>
                                </div>
                                @if ($course->user?->bio)
                                    <p class="mt-4 text-sm leading-6 text-on-surface-variant">{{ $course->user->bio }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="sticky top-[72px] z-40 border-y border-slate-200/70 bg-white/95 shadow-sm backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl gap-10 overflow-x-auto px-6">
                <a class="whitespace-nowrap border-b-2 border-primary py-5 text-sm font-bold text-primary" href="#overview">Overview</a>
                <a class="whitespace-nowrap py-5 text-sm font-bold text-on-surface-variant hover:text-primary" href="#curriculum">Curriculum</a>
                <a class="whitespace-nowrap py-5 text-sm font-bold text-on-surface-variant hover:text-primary" href="#reviews">Reviews</a>
                <a class="whitespace-nowrap py-5 text-sm font-bold text-on-surface-variant hover:text-primary" href="#related">Related</a>
            </div>
        </div>

        <div class="mx-auto mt-12 grid max-w-7xl gap-12 px-6 lg:grid-cols-12">
            <div class="space-y-16 lg:col-span-8">
                <section class="scroll-mt-32" id="overview">
                    <h2 class="font-headline text-3xl font-extrabold">Course overview</h2>
                    <p class="mt-5 text-lg leading-8 text-on-surface-variant">{{ $course->details }}</p>
                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <div class="rounded-2xl bg-surface-container-low p-6">
                            <span class="material-symbols-outlined text-primary">workspace_premium</span>
                            <h3 class="mt-4 text-xl font-bold">Practical learning path</h3>
                            <p class="mt-3 text-sm leading-6 text-on-surface-variant">Every published section and lesson is pulled from the real course builder, so students see the same content structure instructors create.</p>
                        </div>
                        <div class="rounded-2xl bg-surface-container-low p-6">
                            <span class="material-symbols-outlined text-primary">play_circle</span>
                            <h3 class="mt-4 text-xl font-bold">Player-ready content</h3>
                            <p class="mt-3 text-sm leading-6 text-on-surface-variant">Once enrolled, this course opens directly in the student player with real lesson progress and Cloudflare Stream video playback support.</p>
                        </div>
                    </div>
                </section>

                <section class="scroll-mt-32" id="curriculum">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <h2 class="font-headline text-3xl font-extrabold">Curriculum</h2>
                            <p class="mt-2 text-sm text-on-surface-variant">{{ $totalSections }} sections • {{ $totalLessons }} lessons</p>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        @foreach ($sections as $index => $section)
                            <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-surface-container-lowest shadow-sm">
                                <div class="flex items-center justify-between bg-surface-container-low/70 px-5 py-4">
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm font-bold text-primary">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        <div>
                                            <h3 class="font-bold">{{ $section['title'] }}</h3>
                                            <p class="text-xs text-on-surface-variant">{{ $section['lessons_count'] }} lessons</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-3 px-6 py-5">
                                    @foreach ($section['lessons'] as $lesson)
                                        <div class="flex items-center justify-between rounded-xl bg-surface-container-low px-4 py-3 text-sm">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-secondary">play_circle</span>
                                                <span>{{ $lesson['title'] }}</span>
                                            </div>
                                            <span class="text-on-surface-variant">{{ $lesson['duration'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="scroll-mt-32" id="reviews">
                    <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                        <div class="rounded-[2rem] bg-surface-container-low p-8 text-center">
                            <p class="font-headline text-6xl font-black">{{ number_format($rating > 0 ? $rating : 4.8, 1) }}</p>
                            <div class="mt-3 flex justify-center text-amber-500">
                                @for ($star = 1; $star <= 5; $star++)
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                @endfor
                            </div>
                            <p class="mt-3 text-sm text-on-surface-variant">{{ number_format($reviewsCount) }} verified reviews</p>
                        </div>
                        <div class="space-y-5">
                            @forelse ($reviews as $review)
                                <article class="rounded-2xl border border-slate-200/70 bg-surface-container-lowest p-6 shadow-sm">
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
                                <div class="rounded-2xl bg-surface-container-low p-8 text-sm text-on-surface-variant">Reviews will appear here as students rate the course.</div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>

            <aside class="space-y-6 lg:col-span-4">
                <div class="sticky top-[150px] space-y-6">
                    <div class="rounded-[2rem] bg-surface-container-lowest p-8 shadow-xl ring-1 ring-slate-200/70">
                        <h3 class="font-headline text-2xl font-extrabold">Why this course works</h3>
                        <div class="mt-6 space-y-4 text-sm">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined mt-0.5 text-tertiary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>Published lessons and sections come directly from the instructor workflow.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined mt-0.5 text-tertiary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>Student progress and player navigation continue from the same saved course structure.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined mt-0.5 text-tertiary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>Course reviews, enrolled counts, and lesson totals are all live database values.</span>
                            </div>
                        </div>
                    </div>

                    <section class="scroll-mt-32" id="related">
                        <h3 class="font-headline text-2xl font-extrabold">Related courses</h3>
                        <div class="mt-5 space-y-4">
                            @foreach ($relatedCourses as $relatedCourse)
                                <a class="block overflow-hidden rounded-2xl bg-surface-container-lowest shadow-sm ring-1 ring-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg" href="{{ $relatedCourse['details_url'] }}">
                                    <img alt="{{ $relatedCourse['title'] }} thumbnail" class="aspect-video w-full object-cover" src="{{ $relatedCourse['thumbnail'] }}" />
                                    <div class="space-y-3 p-5">
                                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">{{ $relatedCourse['category'] }}</p>
                                        <h4 class="font-bold">{{ $relatedCourse['title'] }}</h4>
                                        <div class="flex items-center justify-between text-xs text-on-surface-variant">
                                            <span>{{ $relatedCourse['instructor_name'] }}</span>
                                            <span>{{ number_format($relatedCourse['rating'] > 0 ? $relatedCourse['rating'] : 4.8, 1) }} rating</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-headline text-xl font-extrabold">Rs. {{ number_format($relatedCourse['price'], 0) }}</span>
                                            <span class="text-xs text-on-surface-variant">{{ number_format($relatedCourse['students_count']) }} students</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </main>

    <x-home.footer />
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
            var controls = document.getElementById('previewControls');
            var previewArea = video.closest('.player-preview-area');
            var previewLimit = Math.max(1, Number(video.getAttribute('data-preview-limit') || '40'));
            var feedbackTimer = null;
            var hasStartedPlayback = false;
            var idleTimer = null;
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
                if ((video.currentTime || 0) < previewLimit) return;
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

            function setControlsVisible(visible) {
                if (!previewArea || !controls) return;
                previewArea.classList.toggle('player-ui-idle', !visible);
            }

            function scheduleControlsHide() {
                window.clearTimeout(idleTimer);
                if (video.paused || video.ended) {
                    setControlsVisible(true);
                    return;
                }
                idleTimer = window.setTimeout(function () {
                    setControlsVisible(false);
                }, 1800);
            }

            function wakeControls() {
                setControlsVisible(true);
                scheduleControlsHide();
            }

            playPauseButton.addEventListener('click', function () {
                wakeControls();
                togglePlay();
            });
            if (posterOverlay) {
                posterOverlay.addEventListener('click', function () {
                    video.currentTime = 0;
                    setPosterVisibility(false);
                    wakeControls();
                    togglePlay();
                });
            }
            video.addEventListener('click', function () {
                wakeControls();
                togglePlay();
            });
            video.addEventListener('play', function () { hasStartedPlayback = true; setPosterVisibility(false); updatePlayState(); showFeedback('play_arrow', 'Play', 'center'); scheduleControlsHide(); });
            video.addEventListener('playing', function () { hasStartedPlayback = true; setPosterVisibility(false); updatePlayState(); scheduleControlsHide(); });
            video.addEventListener('pause', function () { setPosterVisibility(false); updatePlayState(); showFeedback('pause', 'Pause', 'center'); setControlsVisible(true); window.clearTimeout(idleTimer); });
            video.addEventListener('ended', function () { setPosterVisibility(false); updatePlayState(); setControlsVisible(true); window.clearTimeout(idleTimer); });
            rewindButton.addEventListener('click', function () {
                video.currentTime = Math.max(0, (video.currentTime || 0) - 10);
                updateTimeline();
                showFeedback('replay_10', 'Back 10s', 'left');
                wakeControls();
            });
            forwardButton.addEventListener('click', function () {
                video.currentTime = Math.min(previewLimit, (video.currentTime || 0) + 10);
                updateTimeline();
                showFeedback('forward_10', 'Skip 10s', 'right');
                wakeControls();
            });
            seekBar.addEventListener('input', function () {
                video.currentTime = (Number(seekBar.value) / 100) * previewLimit;
                updateTimeline();
                setRangeProgress(seekBar);
                wakeControls();
            });
            volumeBar.addEventListener('input', function () {
                video.volume = Number(volumeBar.value);
                video.muted = Number(volumeBar.value) === 0;
                updateMuteState();
                setRangeProgress(volumeBar);
                wakeControls();
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
                wakeControls();
            });
            speedSelect.addEventListener('change', function () {
                video.playbackRate = Number(speedSelect.value);
                showFeedback('speed', speedSelect.value + 'x', 'center');
                wakeControls();
            });
            fullscreenButton.addEventListener('click', function () {
                wakeControls();
                toggleFullscreen();
            });
            document.addEventListener('fullscreenchange', function () {
                if (fullscreenIcon) fullscreenIcon.textContent = document.fullscreenElement ? 'fullscreen_exit' : 'fullscreen';
                if (!document.fullscreenElement && orientationLocked && screen.orientation && typeof screen.orientation.unlock === 'function') {
                    screen.orientation.unlock();
                    orientationLocked = false;
                }
            });
            document.addEventListener('keydown', function (event) {
                var activeTag = document.activeElement ? document.activeElement.tagName : '';
                if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT') return;
                wakeControls();
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
            ['mousemove', 'mouseenter', 'touchstart', 'touchmove'].forEach(function (eventName) {
                if (previewArea) {
                    previewArea.addEventListener(eventName, wakeControls, { passive: true });
                }
            });

            initializeVideoSource();
            video.volume = 0.3;
            volumeBar.value = 0.3;
            setRangeProgress(seekBar);
            setRangeProgress(volumeBar);
            setPosterVisibility(true);
            setControlsVisible(true);
            updatePlayState();
            updateMuteState();
            updateTimeline();
        })();
    </script>
</body>
</html>


