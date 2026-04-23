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
                        primary: "#8b6a34",
                        "on-primary": "#FFFFFF",
                        "primary-container": "#e9dbc5",
                        "on-primary-container": "#43311b",
                        secondary: "#64584c",
                        "on-secondary": "#FFFFFF",
                        "secondary-container": "#ece3d7",
                        "on-secondary-container": "#2b241d",
                        tertiary: "#2d4a45",
                        "on-tertiary": "#FFFFFF",
                        "tertiary-container": "#dce8e5",
                        "on-tertiary-container": "#11211d",
                        surface: "#f8f2e9",
                        background: "#f8f2e9",
                        "surface-variant": "#e4d8c8",
                        "surface-container-low": "#fcf8f2",
                        "surface-container-high": "#f1e8dc",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#1f1a16",
                        "on-surface-variant": "#6f6254",
                        outline: "#cbbba4",
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
        html {
            scrollbar-gutter: stable;
            scrollbar-width: thin;
            scrollbar-color: rgba(109, 40, 217, 0.68) rgba(244, 237, 228, 0.92);
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            width: 12px;
        }
        html::-webkit-scrollbar-track,
        body::-webkit-scrollbar-track {
            background:
                linear-gradient(180deg, rgba(250, 245, 238, 0.98), rgba(239, 229, 214, 0.98));
            border-left: 1px solid rgba(215, 197, 171, 0.72);
        }
        html::-webkit-scrollbar-thumb,
        body::-webkit-scrollbar-thumb {
            background:
                linear-gradient(180deg, rgba(139, 106, 52, 0.92), rgba(109, 40, 217, 0.76));
            border: 2px solid rgba(250, 245, 238, 0.96);
            border-radius: 9999px;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.25),
                0 6px 16px rgba(57, 34, 10, 0.12);
        }
        html::-webkit-scrollbar-thumb:hover,
        body::-webkit-scrollbar-thumb:hover {
            background:
                linear-gradient(180deg, rgba(120, 90, 42, 0.96), rgba(91, 33, 182, 0.82));
        }
        body {
            scrollbar-width: thin;
            scrollbar-color: rgba(109, 40, 217, 0.68) rgba(244, 237, 228, 0.92);
        }
        .page-shell {
            position: relative;
            isolation: isolate;
            background:
                radial-gradient(circle at top left, rgba(212, 175, 55, 0.08), transparent 16%),
                radial-gradient(circle at top right, rgba(124, 58, 237, 0.08), transparent 22%),
                radial-gradient(circle at bottom right, rgba(183, 140, 71, 0.08), transparent 20%),
                linear-gradient(180deg, #fcfbff 0%, #f5f0fb 52%, #f7f3ee 100%);
        }
        .page-shell::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 22rem;
            background:
                radial-gradient(circle at 16% 18%, rgba(214, 175, 84, 0.12), transparent 18%),
                radial-gradient(circle at 84% 14%, rgba(167, 139, 250, 0.14), transparent 18%),
                linear-gradient(180deg, rgba(255,255,255,0.72), rgba(255,255,255,0));
            pointer-events: none;
            z-index: -1;
        }
        .page-shell::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255,255,255,0.16) 1px, transparent 1px),
                linear-gradient(rgba(255,255,255,0.14) 1px, transparent 1px);
            background-size: 5rem 5rem;
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.12), transparent 35%);
            pointer-events: none;
            z-index: -1;
        }
        .glass-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(251,247,255,0.9));
            border: 1px solid rgba(225, 214, 240, 0.82);
            box-shadow: 0 22px 54px rgba(76, 29, 149, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .hero-glow {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.08);
            background:
                radial-gradient(circle at 14% 18%, rgba(214, 176, 103, 0.16), transparent 24%),
                radial-gradient(circle at 82% 20%, rgba(255,255,255,0.08), transparent 18%),
                linear-gradient(135deg, #111111 0%, #181512 38%, #241f1a 72%, #332a22 100%);
            box-shadow: 0 40px 110px rgba(29, 23, 18, 0.34);
        }
        .hero-glow::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 4rem 4rem;
            mask-image: radial-gradient(circle at center, black 28%, transparent 82%);
            pointer-events: none;
            opacity: 0.45;
        }
        .hero-outline {
            position: relative;
        }
        .hero-outline::before {
            content: "";
            position: absolute;
            inset: 1rem;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1.75rem;
            pointer-events: none;
        }
        .premium-label {
            border: 1px solid rgba(212, 175, 55, 0.18);
            background: rgba(255,255,255,0.72);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.7);
        }
        .editorial-divider {
            height: 1px;
            width: 100%;
            background: linear-gradient(90deg, rgba(124, 58, 237, 0), rgba(124, 58, 237, 0.18), rgba(212, 175, 55, 0.24), rgba(124, 58, 237, 0));
        }
        .detail-stat {
            border: 1px solid rgba(227, 218, 238, 0.78);
            background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(250,246,252,0.88));
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.62);
        }
        .soft-panel {
            border: 1px solid rgba(220, 205, 246, 0.72);
            background:
                radial-gradient(circle at top right, rgba(212, 175, 55, 0.08), transparent 22%),
                radial-gradient(circle at bottom left, rgba(124, 58, 237, 0.06), transparent 24%),
                linear-gradient(180deg, rgba(255,255,255,0.96), rgba(250,246,255,0.9));
            box-shadow: 0 22px 48px rgba(76, 29, 149, 0.08);
        }
        .hero-surface {
            border-color: rgba(220, 205, 246, 0.68);
            background:
                radial-gradient(circle at top left, rgba(212, 175, 55, 0.10), transparent 20%),
                radial-gradient(circle at top right, rgba(124, 58, 237, 0.08), transparent 18%),
                linear-gradient(180deg, rgba(255,255,255,0.97), rgba(249,244,255,0.9));
            box-shadow:
                0 24px 56px rgba(76, 29, 149, 0.09),
                0 1px 0 rgba(255,255,255,0.28) inset;
        }
        .curriculum-row {
            border: 1px solid rgba(227, 218, 238, 0.72);
            background: linear-gradient(180deg, rgba(255,255,255,0.82), rgba(248,244,251,0.74));
        }
        .related-card {
            border: 1px solid rgba(227, 218, 238, 0.82);
            background: linear-gradient(180deg, rgba(255,255,255,0.97), rgba(250,246,252,0.92));
            box-shadow: 0 18px 42px rgba(76, 29, 149, 0.08);
            transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
        }
        .related-card:hover {
            transform: translateY(-4px);
            border-color: rgba(180, 146, 68, 0.26);
            box-shadow: 0 26px 56px rgba(76, 29, 149, 0.12);
        }
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #7d5b2f, #b78c47, #ead7a7);
            transition: width 0.08s linear;
        }
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .75s cubic-bezier(.16,1,.3,1), transform .75s cubic-bezier(.16,1,.3,1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .font-variation-settings-fill {
            font-variation-settings: 'FILL' 1;
        }
        .player-stage { background: radial-gradient(circle at top right, rgba(183, 140, 71, 0.22), transparent 30%), linear-gradient(180deg, #111111 0%, #1b1712 100%); }
        .player-range { -webkit-appearance: none; appearance: none; background: transparent; }
        .player-range::-webkit-slider-runnable-track { height: 6px; border-radius: 9999px; background: linear-gradient(90deg, #d2b172 var(--range-progress, 0%), rgba(255,255,255,0.16) var(--range-progress, 0%)); }
        .player-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; height: 16px; width: 16px; border-radius: 9999px; background: #ffffff; margin-top: -5px; box-shadow: 0 10px 24px rgba(39, 29, 21, 0.3); }
        .player-range::-moz-range-track { height: 6px; border-radius: 9999px; background: rgba(255,255,255,0.16); }
        .player-range::-moz-range-progress { height: 6px; border-radius: 9999px; background: #d2b172; }
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
<body class="page-shell bg-surface font-body text-on-surface">
    <div id="scroll-progress"></div>
    <x-shared.back-to-top />
    @php($previewVideoType = str_contains((string) $previewVideoUrl, '.m3u8') ? 'application/vnd.apple.mpegurl' : 'video/mp4')
    @php($displayRating = $rating > 0 ? $rating : 4.8)
    @php($courseLevel = ucfirst($course->level ?: 'All levels'))
    @php($courseLanguage = $course->language ?: 'English')
    @php($courseValidity = $course->validity_in_days ? $course->validity_in_days.' days' : 'Lifetime access')
    @php($previewSeconds = $previewLimitSeconds ?? 40)
    

    <main class="pb-24 pt-5">
        <section class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="soft-panel hero-surface reveal overflow-hidden rounded-[2.5rem] p-5 sm:p-8 lg:p-10">
                <nav class="flex flex-wrap items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant/80">
                    <span>Home</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <a class="transition hover:text-primary" href="{{ $browseUrl }}">Training Programs</a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-primary">{{ $course->title }}</span>
                </nav>

                <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1.1fr)_minmax(360px,0.9fr)] lg:items-start">
                    <div class="reveal">
                        <span class="premium-label inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-primary">
                            <span class="h-2 w-2 rounded-full bg-[#b78c47]"></span>
                            {{ $course->category?->name ?? 'Course' }}
                        </span>
                        <h1 class="mt-6 max-w-4xl font-headline text-[2.5rem] font-extrabold leading-[0.98] tracking-[-0.04em] text-on-surface sm:text-[3.2rem] lg:text-[3.5rem]">
                            {{ $course->title }}
                        </h1>
                        <p class="mt-6 max-w-3xl text-base leading-8 text-on-surface-variant sm:text-md">
                            {{ $course->details }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm">
                            <div class="premium-label inline-flex items-center rounded-full px-4 py-2.5 font-bold text-on-surface">
                                <span class="material-symbols-outlined mr-2 text-base text-[#b78c47]" style="font-variation-settings: 'FILL' 1;">star</span>
                                {{ number_format($displayRating, 1) }}
                            </div>
                            <span class="text-on-surface-variant">{{ number_format($reviewsCount) }} reviews</span>
                            <span class="h-1 w-1 rounded-full bg-[#c9b89d]"></span>
                            <span class="text-on-surface-variant">{{ number_format($studentsCount) }} learners</span>
                            <span class="h-1 w-1 rounded-full bg-[#c9b89d]"></span>
                            <span class="text-on-surface-variant">{{ $courseLevel }}</span>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            <div class="detail-stat rounded-[1.5rem] p-4">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Duration</p>
                                <p class="mt-3 text-lg font-bold text-on-surface">{{ $formattedDuration }}</p>
                            </div>
                            <div class="detail-stat rounded-[1.5rem] p-4">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Lessons</p>
                                <p class="mt-3 text-lg font-bold text-on-surface">{{ $totalLessons }}</p>
                            </div>
                            <div class="detail-stat rounded-[1.5rem] p-4">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Language</p>
                                <p class="mt-3 text-lg font-bold text-on-surface">{{ $courseLanguage }}</p>
                            </div>
                            <div class="detail-stat rounded-[1.5rem] p-4">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Access</p>
                                <p class="mt-3 text-lg font-bold text-on-surface">{{ $courseValidity }}</p>
                            </div>
                        </div>

                        @if ($learningTopics->isNotEmpty())
                            <div class="mt-8">
                                <p class="mb-4 text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">What you will work with</p>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($learningTopics as $topic)
                                        <span class="premium-label rounded-full px-4 py-2.5 text-sm font-semibold text-on-surface">{{ $topic }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="my-10 editorial-divider"></div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="detail-stat rounded-[1.6rem] p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Instructor</p>
                                <div class="mt-4 flex items-center gap-3">
                                    <img alt="{{ $course->user?->name }} avatar" class="h-12 w-12 rounded-full object-cover ring-1 ring-[#cbbba4]" src="{{ $course->user?->avatarUrl(96) }}" />
                                    <div>
                                        <p class="font-bold text-on-surface">{{ $course->user?->name }}</p>
                                        <p class="text-sm text-on-surface-variant">Mentor-led experience</p>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-stat rounded-[1.6rem] p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Course Format</p>
                                <p class="mt-4 font-headline text-2xl font-extrabold text-on-surface">Structured and outcome-focused</p>
                                <p class="mt-2 text-sm leading-6 text-on-surface-variant">Built for guided progress with clear sections, lessons, and measurable outcomes.</p>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            @auth
                                @if ($isEnrolled)
                                    <a class="inline-flex items-center justify-center rounded-[1.2rem] bg-[linear-gradient(135deg,#8b6a34_0%,#b78c47_100%)] px-8 py-4 text-base font-bold text-white shadow-[0_20px_40px_rgba(94,72,40,0.18)]" href="{{ $continueUrl }}">
                                        Continue Learning
                                    </a>
                                @else
                                    <a class="inline-flex items-center justify-center rounded-[1.2rem] bg-[linear-gradient(135deg,#8b6a34_0%,#b78c47_100%)] px-8 py-4 text-base font-bold text-white shadow-[0_20px_40px_rgba(94,72,40,0.18)]" href="{{ route('student.browse-courses') }}">
                                        Continue to Enroll
                                    </a>
                                @endif
                            @else
                                <a class="inline-flex items-center justify-center rounded-[1.2rem] bg-[linear-gradient(135deg,#8b6a34_0%,#b78c47_100%)] px-8 py-4 text-base font-bold text-white shadow-[0_20px_40px_rgba(94,72,40,0.18)]" href="{{ route('login') }}">
                                    Login to Enroll
                                </a>
                            @endauth
                            <a class="inline-flex items-center justify-center rounded-[1.2rem] border border-[#cbbba4] bg-white/70 px-8 py-4 text-base font-bold text-on-surface-variant" href="{{ $browseUrl }}">
                                Browse More Training Programs
                            </a>
                        </div>
                    </div>

                    <div class="reveal">
                        <div id="previewPlayerStage" class="hero-glow hero-outline player-stage relative overflow-hidden rounded-[2rem]">
                        @if ($previewVideoUrl)
                            <div class="player-preview-area relative aspect-video overflow-hidden">
                                <video id="coursePreviewVideo" class="h-full w-full bg-black object-contain" controlsList="nodownload noplaybackrate" data-preview-limit="{{ $previewSeconds }}" poster="{{ $heroThumbnail }}" preload="metadata">
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
                                        Preview 00:{{ str_pad((string) $previewSeconds, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 z-10 p-2.5 md:p-3">
                                    <div id="previewControls" class="rounded-[0.95rem] border border-white/10 bg-black/45 p-2.5 shadow-2xl backdrop-blur-xl">
                                        <div class="mb-2.5 flex items-center gap-2">
                                            <span id="previewCurrentTime" class="min-w-[44px] text-[11px] font-semibold text-slate-200">00:00</span>
                                            <input id="previewSeekBar" class="player-range h-4 w-full" max="100" min="0" step="0.1" type="range" value="0" />
                                            <span id="previewDurationTime" class="min-w-[44px] text-right text-[11px] font-semibold text-slate-200">00:{{ str_pad((string) $previewSeconds, 2, '0', STR_PAD_LEFT) }}</span>
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
                        <div class="glass-card rounded-b-[2rem] p-6 sm:p-7 text-on-surface">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Fee details</p>
                                    <p class="mt-3 font-headline text-[1.8rem] font-extrabold leading-tight text-on-surface">Contact mentor or our team to know the current fee.</p>
                                </div>
                                @if ($isWishlisted)
                                    <span class="premium-label rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-[#8b6a34]">Saved</span>
                                @endif
                            </div>
                            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                <div class="detail-stat rounded-[1.2rem] p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Sections</p>
                                    <p class="mt-2 text-base font-bold text-on-surface">{{ $totalSections }}</p>
                                </div>
                                <div class="detail-stat rounded-[1.2rem] p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Students</p>
                                    <p class="mt-2 text-base font-bold text-on-surface">{{ number_format($studentsCount) }}</p>
                                </div>
                                <div class="detail-stat rounded-[1.2rem] p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Preview</p>
                                    <p class="mt-2 text-base font-bold text-on-surface">00:{{ str_pad((string) $previewSeconds, 2, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            @if ($course->user?->bio)
                                <div class="mt-5 rounded-[1.25rem] border border-[#d6cab8] bg-white/65 p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Instructor note</p>
                                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $course->user->bio }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="sticky top-[72px] z-40 mt-8 border-y border-[#ded3c5] bg-[#f9f4ec]/90 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl gap-8 overflow-x-auto px-4 sm:px-6">
                <a class="whitespace-nowrap border-b-2 border-[#8b6a34] py-4 text-[12px] font-bold uppercase tracking-[0.18em] text-[#8b6a34]" href="#overview">Overview</a>
                <a class="whitespace-nowrap py-4 text-[12px] font-bold uppercase tracking-[0.18em] text-on-surface-variant transition hover:text-[#8b6a34]" href="#curriculum">Curriculum</a>
                <a class="whitespace-nowrap py-4 text-[12px] font-bold uppercase tracking-[0.18em] text-on-surface-variant transition hover:text-[#8b6a34]" href="#reviews">Reviews</a>
                <a class="whitespace-nowrap py-4 text-[12px] font-bold uppercase tracking-[0.18em] text-on-surface-variant transition hover:text-[#8b6a34]" href="#related">Related</a>
            </div>
        </div>

        <div class="mx-auto mt-10 grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-12">
            <div class="space-y-8 lg:col-span-8">
                <section class="soft-panel reveal scroll-mt-32 rounded-[1.8rem] p-6 sm:p-7" id="overview">
                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#8b6a34]">Course Overview</p>
                    <h2 class="mt-3 font-headline text-[1.9rem] font-extrabold tracking-[-0.03em] text-on-surface">A clear path from interest to mastery</h2>
                    <p class="mt-5 text-[15px] leading-8 text-on-surface-variant">{{ $course->details }}</p>
                    <div class="mt-7 grid gap-4 md:grid-cols-2">
                        <div class="detail-stat rounded-[1.4rem] p-5">
                            <span class="material-symbols-outlined text-[#8b6a34]">workspace_premium</span>
                            <h3 class="mt-3 text-lg font-bold text-on-surface">Practical learning path</h3>
                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">Each section moves from foundations into applied execution so the course stays structured and easy to follow.</p>
                        </div>
                        <div class="detail-stat rounded-[1.4rem] p-5">
                            <span class="material-symbols-outlined text-[#8b6a34]">play_circle</span>
                            <h3 class="mt-3 text-lg font-bold text-on-surface">Player-ready experience</h3>
                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">Students can preview instantly and continue into the full course flow with saved lesson progress after enrollment.</p>
                        </div>
                    </div>
                </section>

                <section class="soft-panel reveal scroll-mt-32 rounded-[1.8rem] p-6 sm:p-7" id="curriculum">
                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#8b6a34]">Curriculum</p>
                    <h2 class="mt-3 font-headline text-[1.9rem] font-extrabold tracking-[-0.03em] text-on-surface">Structured section by section</h2>
                    <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $totalSections }} sections • {{ $totalLessons }} lessons</p>
                    <div class="mt-7 space-y-4">
                        @foreach ($sections as $index => $section)
                            <div class="glass-card overflow-hidden rounded-[1.5rem]">
                                <div class="flex items-center justify-between border-b border-[#eadfce] px-5 py-4">
                                    <div class="flex items-center gap-4">
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#f4ead7] text-sm font-bold text-[#8b6a34]">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        <div>
                                            <h3 class="font-bold text-on-surface">{{ $section['title'] }}</h3>
                                            <p class="text-xs uppercase tracking-[0.14em] text-on-surface-variant">{{ $section['lessons_count'] }} lessons</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-3 px-5 py-5">
                                    @foreach ($section['lessons'] as $lesson)
                                        <div class="curriculum-row flex items-center justify-between rounded-[1rem] px-4 py-3 text-sm">
                                            <div class="flex min-w-0 items-center gap-3">
                                                <span class="material-symbols-outlined shrink-0 text-[#8b6a34]">play_circle</span>
                                                <span class="block text-on-surface">{{ $lesson['title'] }}</span>
                                            </div>
                                            <span class="shrink-0 text-on-surface-variant">{{ $lesson['duration'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="soft-panel reveal scroll-mt-32 rounded-[1.8rem] p-6 sm:p-7" id="reviews">
                    <div class="grid gap-6 lg:grid-cols-[220px_minmax(0,1fr)]">
                        <div class="detail-stat rounded-[1.5rem] p-6 text-center">
                            <p class="font-headline text-5xl font-black text-on-surface">{{ number_format($displayRating, 1) }}</p>
                            <div class="mt-3 flex justify-center text-[#b78c47]">
                                @for ($star = 1; $star <= 5; $star++)
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                @endfor
                            </div>
                            <p class="mt-3 text-sm text-on-surface-variant">{{ number_format($reviewsCount) }} verified reviews</p>
                        </div>
                        <div class="space-y-4">
                            @forelse ($reviews as $review)
                                <article class="detail-stat rounded-[1.4rem] p-5">
                                    <div class="flex items-center gap-4">
                                        <img alt="{{ $review['name'] }} avatar" class="h-11 w-11 rounded-full object-cover ring-1 ring-[#d6cab8]" src="{{ $review['avatar'] }}" />
                                        <div>
                                            <p class="font-bold text-on-surface">{{ $review['name'] }}</p>
                                            <p class="text-xs uppercase tracking-[0.14em] text-on-surface-variant">{{ $review['created_at'] }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex text-[#b78c47]">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $star <= $review['rating'] ? 1 : 0 }};">star</span>
                                        @endfor
                                    </div>
                                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $review['comment'] }}</p>
                                </article>
                            @empty
                                <div class="detail-stat rounded-[1.4rem] p-6 text-sm text-on-surface-variant">Reviews will appear here as students rate the course.</div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>

            <aside class="space-y-6 lg:col-span-4">
                <div class="sticky top-[132px] space-y-6">
                    <div class="soft-panel reveal rounded-[1.8rem] p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#8b6a34]">Why This Course Works</p>
                        <div class="mt-5 space-y-4 text-sm leading-7 text-on-surface-variant">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined mt-0.5 text-[#8b6a34]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>Published lessons and sections come directly from the live instructor workflow.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined mt-0.5 text-[#8b6a34]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>The preview player mirrors the real learning experience students get after enrollment.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined mt-0.5 text-[#8b6a34]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>Ratings, lesson totals, and student counts all come from live course data.</span>
                            </div>
                        </div>
                    </div>

                    <section class="reveal scroll-mt-32" id="related">
                        <div class="soft-panel rounded-[1.8rem] p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#8b6a34]">Related Training Programs</p>
                            <h3 class="mt-3 font-headline text-[1.6rem] font-extrabold text-on-surface">Continue exploring</h3>
                            <div class="mt-5 space-y-4">
                            @foreach ($relatedCourses as $relatedCourse)
                                <a class="related-card block overflow-hidden rounded-[1.4rem]" href="{{ $relatedCourse['details_url'] }}">
                                    <img alt="{{ $relatedCourse['title'] }} thumbnail" class="aspect-video w-full object-cover" src="{{ $relatedCourse['thumbnail'] }}" />
                                    <div class="space-y-3 p-4">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#8b6a34]">{{ $relatedCourse['category'] }}</p>
                                        <h4 class="font-bold leading-6 text-on-surface">{{ $relatedCourse['title'] }}</h4>
                                        <div class="flex items-center justify-between gap-3 text-xs text-on-surface-variant">
                                            <span class="truncate">{{ $relatedCourse['instructor_name'] }}</span>
                                            <span class="shrink-0">{{ number_format($relatedCourse['rating'] > 0 ? $relatedCourse['rating'] : 4.8, 1) }} rating</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-3">
                                            <span class="font-headline text-sm font-extrabold uppercase tracking-[0.18em] text-on-surface">Contact for fee</span>
                                            <span class="text-xs text-on-surface-variant">{{ number_format($relatedCourse['students_count']) }} students</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </main>

    <x-home.footer />
    <script>
        (function () {
            var progressBar = document.getElementById('scroll-progress');
            window.addEventListener('scroll', function () {
                var doc = document.documentElement;
                var total = doc.scrollHeight - doc.clientHeight;
                var value = total > 0 ? (doc.scrollTop / total) * 100 : 0;
                if (progressBar) progressBar.style.width = value + '%';
            }, { passive: true });

            var items = document.querySelectorAll('.reveal');
            if (!items.length) {
                return;
            }

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -36px 0px' });

            items.forEach(function (item) {
                observer.observe(item);
            });
        })();
    </script>
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



