
<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Course Player - CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
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
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .glass-effect { backdrop-filter: blur(12px); background-color: rgba(248, 249, 250, 0.8); }
        .player-stage { background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.26), transparent 32%), linear-gradient(180deg, #111827 0%, #0f172a 100%); }
        .player-range { -webkit-appearance: none; appearance: none; background: transparent; }
        .player-range::-webkit-slider-runnable-track { height: 6px; border-radius: 9999px; background: linear-gradient(90deg, #1570d8 var(--range-progress, 0%), rgba(255,255,255,0.16) var(--range-progress, 0%)); }
        .player-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; height: 16px; width: 16px; border-radius: 9999px; background: #ffffff; margin-top: -5px; box-shadow: 0 10px 24px rgba(12, 78, 163, 0.32); }
        .player-range::-moz-range-track { height: 6px; border-radius: 9999px; background: rgba(255,255,255,0.16); }
        .player-range::-moz-range-progress { height: 6px; border-radius: 9999px; background: #1570d8; }
        .player-range::-moz-range-thumb { height: 16px; width: 16px; border: none; border-radius: 9999px; background: #ffffff; }
        .player-interactive.is-idle { cursor: none; }
        .player-interactive.is-idle .player-fade { opacity: 0; transform: translateY(8px); }
        .player-interactive.is-idle .player-top { opacity: 0; transform: translateY(-8px); }
        .player-feedback {
            --feedback-x: -50%;
            opacity: 0;
            transform: translate(var(--feedback-x), -50%) scale(0.9);
            transition: opacity 180ms ease, transform 220ms ease;
        }
        .player-feedback.is-left {
            --feedback-x: calc(-50% - 132px);
        }
        .player-feedback.is-right {
            --feedback-x: calc(-50% + 132px);
        }
        .player-feedback.is-visible {
            opacity: 1;
            transform: translate(var(--feedback-x), -50%) scale(1);
        }
        @media (max-width: 640px) {
            .player-feedback.is-left {
                --feedback-x: calc(-50% - 88px);
            }
            .player-feedback.is-right {
                --feedback-x: calc(-50% + 88px);
            }
        }
        .player-stage:fullscreen,
        .player-stage:-webkit-full-screen {
            width: 100vw;
            height: 100vh;
            max-width: 100vw;
            max-height: 100vh;
            border-radius: 0;
            background: #020617;
        }
        .player-stage:fullscreen #playerInteractiveArea,
        .player-stage:-webkit-full-screen #playerInteractiveArea {
            height: 100vh;
            aspect-ratio: auto;
        }
        .player-stage:fullscreen video,
        .player-stage:-webkit-full-screen video {
            height: 100%;
        }
        @media (max-width: 768px) {
            #playerStage {
                border-radius: 1rem;
            }
            .player-top {
                left: 0.75rem;
                right: 0.75rem;
                top: 0.75rem;
                gap: 0.5rem;
            }
            .player-top > div:first-child {
                max-width: 70%;
                padding: 0.55rem 0.85rem;
            }
            .player-top > div:first-child p:last-child {
                font-size: 0.78rem;
                line-height: 1.1rem;
            }
            .player-top > div:last-child {
                padding: 0.5rem 0.8rem;
                font-size: 0.68rem;
            }
            .player-fade {
                padding: 0.55rem;
            }
            #playerControls {
                border-radius: 0.9rem;
                padding: 0.65rem;
            }
            #playerControls .mb-3 {
                margin-bottom: 0.55rem;
                gap: 0.45rem;
            }
            #currentTime,
            #durationTime {
                min-width: 34px;
                font-size: 9px;
            }
            #playerControls .flex-col.gap-3 {
                gap: 0.4rem;
            }
            #playerControls .flex-wrap.items-center.gap-2\.5 {
                gap: 0.35rem;
            }
            #playPauseButton {
                height: 2.15rem;
                width: 2.15rem;
            }
            #rewindButton,
            #forwardButton {
                min-width: 0;
                padding: 0.35rem 0.5rem;
                font-size: 9px;
                gap: 0.15rem;
                border-radius: 9999px;
            }
            #muteButton,
            #pictureInPictureButton,
            #fullscreenButton {
                height: 1.85rem;
                width: 1.85rem;
            }
            #volumeBar {
                width: 3rem;
            }
            #speedSelect {
                padding: 0.35rem 0.55rem;
                font-size: 9px;
            }
            #playPauseIcon {
                font-size: 18px;
            }
            #rewindButton .material-symbols-outlined,
            #forwardButton .material-symbols-outlined,
            #muteButton .material-symbols-outlined,
            #pictureInPictureButton .material-symbols-outlined,
            #fullscreenButton .material-symbols-outlined {
                font-size: 14px;
            }
        }
        @media (max-width: 520px) {
            .player-fade {
                padding: 0.35rem;
            }
            #playerControls {
                border-radius: 0.75rem;
                padding: 0.45rem;
            }
            #playerControls .mb-3 {
                margin-bottom: 0.35rem;
                gap: 0.3rem;
            }
            #playerControls .flex-col.gap-3 {
                display: grid;
                grid-template-columns: auto auto auto minmax(0, 1fr) auto auto auto auto;
                align-items: center;
                gap: 0.28rem;
            }
            #playerControls .flex-col.gap-3 > .flex-wrap.items-center.gap-2\.5 {
                display: contents;
            }
            #volumeBar {
                width: 100%;
                min-width: 0;
            }
            #rewindButton,
            #forwardButton {
                justify-content: center;
            }
            #speedSelect {
                min-width: 0;
                width: 100%;
            }
            .player-feedback {
                min-width: 96px;
                padding: 0.7rem 0.8rem;
            }
            .player-feedback .material-symbols-outlined {
                font-size: 1.5rem;
            }
            #playerControls .mb-3 {
                gap: 0.25rem;
            }
            #currentTime,
            #durationTime {
                min-width: 30px;
                font-size: 8px;
            }
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body antialiased">
    @php($activeTab = request()->query('tab', 'description'))
    @php($lessonVideoType = str_contains((string) $currentLesson->video_url, '.m3u8') ? 'application/vnd.apple.mpegurl' : 'video/mp4')
    <x-student.navbar />

    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 glass-effect z-40 flex items-center justify-between px-4 md:px-8">
        <div class="flex items-center gap-4">
            <a class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors" href="{{ route('student.my-learning') }}">
                <span class="material-symbols-outlined" data-icon="arrow_back">arrow_back</span>
                <span class="text-sm font-medium font-label">Back to My Learning</span>
            </a>
        </div>
        <div class="flex-1 max-w-xl mx-4 md:mx-12">
            <div class="flex flex-col gap-1">
                <div class="flex justify-between items-end">
                    <span class="text-[10px] font-bold text-primary uppercase tracking-tighter">Your Progress: {{ $progressPercent }}%</span>
                    <span class="text-[10px] font-medium text-on-surface-variant">{{ $completedCount }}/{{ $totalLessons }} Lessons</span>
                </div>
                <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
                    <div class="js-progress-fill h-full bg-gradient-to-r from-primary to-primary-container rounded-full" data-progress="{{ max(0, min(100, $progressPercent)) }}"></div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <button class="relative p-2 text-on-surface-variant hover:text-primary transition-colors" type="button">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-2 right-2 h-2 w-2 bg-error rounded-full border-2 border-white"></span>
            </button>
            <img alt="Student Profile" class="h-10 w-10 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $studentAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen flex flex-col xl:flex-row">
        <div class="flex-1 flex flex-col p-4 md:p-8 overflow-y-auto">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->has('lesson_complete'))
                <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-medium text-amber-700">
                    {{ $errors->first('lesson_complete') }}
                </div>
            @endif

            <div id="playerStage" class="player-stage rounded-xl overflow-hidden shadow-2xl transition-all duration-500">
                <div id="playerInteractiveArea" class="player-interactive relative aspect-video overflow-hidden">
                    @if ($currentLesson->video_url)
                        <video data-course-id="{{ $course->id }}" data-lesson-id="{{ $currentLesson->id }}" data-resume-seconds="{{ $resumeSeconds }}" data-save-progress-url="{{ $saveProgressUrl }}" data-completion-threshold="{{ max(1, $currentLessonDurationSeconds > 0 ? $currentLessonDurationSeconds - 3 : 1) }}" data-lesson-completed="{{ $isCurrentLessonCompleted ? '1' : '0' }}" id="lessonVideo" class="w-full h-full bg-black object-contain" poster="{{ $course->thumbnail ?: '' }}" preload="metadata">
                            <source src="{{ $currentLesson->video_url }}" type="{{ $lessonVideoType }}">
                            Your browser does not support the video tag.
                        </video>
                        <button id="playerPosterOverlay" class="absolute inset-0 z-[5] flex items-center justify-center bg-black/20 transition-opacity duration-200" type="button">
                            <img alt="{{ $course->title }} thumbnail" class="absolute inset-0 h-full w-full object-cover" src="{{ $course->thumbnail ?: '' }}" />
                            <span class="relative inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/90 text-slate-950 shadow-xl">
                                <span class="material-symbols-outlined text-[32px]">play_arrow</span>
                            </span>
                        </button>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-high text-on-surface-variant">Lesson video is not available yet.</div>
                    @endif

                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/20"></div>
                    <div id="playerFeedback" class="player-feedback pointer-events-none absolute left-1/2 top-1/2 z-20 flex min-w-[120px] -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center rounded-[1.5rem] bg-black/45 px-5 py-4 text-white shadow-2xl backdrop-blur-xl transition-all duration-200">
                        <span id="playerFeedbackIcon" class="material-symbols-outlined icon-filled text-[32px]">play_arrow</span>
                        <span id="playerFeedbackText" class="mt-2 text-xs font-bold uppercase tracking-[0.22em]">Play</span>
                    </div>

                    <div class="player-top absolute left-5 right-5 top-5 flex items-start justify-between gap-4 transition-all duration-300">
                        <div class="rounded-full bg-black/35 px-4 py-2 backdrop-blur-md">
                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#b9dcff]">{{ $course->title }}</p>
                            <p class="mt-1 text-sm font-semibold text-white">{{ $currentLesson->title }}</p>
                        </div>
                        <div class="rounded-full bg-black/35 px-4 py-2 text-xs font-semibold text-slate-200 backdrop-blur-md">{{ $completedCount }}/{{ $totalLessons }} completed</div>
                    </div>

                    <div class="player-fade absolute inset-x-0 bottom-0 p-3 md:p-4 transition-all duration-300">
                        <div id="playerControls" class="rounded-[1.1rem] border border-white/10 bg-black/45 p-3 shadow-2xl backdrop-blur-xl">
                            <div class="mb-3 flex items-center gap-2.5">
                                <span id="currentTime" class="min-w-[52px] text-xs font-semibold text-slate-200">00:00</span>
                                <input id="seekBar" class="player-range h-4 w-full" max="100" min="0" step="0.1" type="range" value="0" />
                                <span id="durationTime" class="min-w-[52px] text-right text-xs font-semibold text-slate-200">00:00</span>
                            </div>

                            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <button id="playPauseButton" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-950 shadow-lg transition hover:scale-105" type="button">
                                        <span id="playPauseIcon" class="material-symbols-outlined icon-filled text-[24px]">play_arrow</span>
                                    </button>
                                    <button id="rewindButton" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-white/15" type="button"><span class="material-symbols-outlined text-[18px]">replay_10</span>-10s</button>
                                    <button id="forwardButton" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-white/15" type="button">+10s<span class="material-symbols-outlined text-[18px]">forward_10</span></button>
                                </div>

                                <div class="flex flex-wrap items-center gap-2.5">
                                    <button id="muteButton" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span id="muteIcon" class="material-symbols-outlined text-[18px]">volume_up</span></button>
                                    <input id="volumeBar" class="player-range h-4 w-20" max="1" min="0" step="0.05" type="range" value="0.3" />
                                    <select id="speedSelect" class="rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white outline-none">
                                        <option class="text-slate-900" value="0.75">0.75x</option>
                                        <option class="text-slate-900" value="1" selected>1x</option>
                                        <option class="text-slate-900" value="1.25">1.25x</option>
                                        <option class="text-slate-900" value="1.5">1.5x</option>
                                        <option class="text-slate-900" value="2">2x</option>
                                    </select>
                                    <button id="pictureInPictureButton" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span class="material-symbols-outlined text-[18px]">picture_in_picture_alt</span></button>
                                    <button id="fullscreenButton" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15" type="button"><span id="fullscreenIcon" class="material-symbols-outlined text-[18px]">fullscreen</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex flex-col xl:flex-row xl:items-start xl:justify-between gap-8">
                <div class="max-w-2xl">
                    <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">{{ $currentLesson->title }}</h1>
                    <p class="mt-2 text-on-surface-variant font-medium">Part of: <span class="text-primary font-semibold">{{ $course->title }}</span> | Instructor: {{ $course->user?->name ?: 'Instructor' }}</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <a @class([
                        'flex items-center justify-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all',
                        'bg-surface-container-high text-primary hover:bg-surface-container-highest' => $nextLessonUrl,
                        'bg-amber-50 text-amber-700 border border-amber-200 cursor-default pointer-events-none' => ! $nextLessonUrl && ! $courseContentComplete,
                        'bg-surface-container text-on-surface-variant cursor-not-allowed pointer-events-none' => ! $nextLessonUrl && $courseContentComplete,
                    ]) href="{{ $nextLessonUrl ?: '#' }}">
                        <span class="material-symbols-outlined" data-icon="{{ ! $nextLessonUrl && ! $courseContentComplete ? 'schedule' : 'skip_next' }}">{{ ! $nextLessonUrl && ! $courseContentComplete ? 'schedule' : 'skip_next' }}</span>
                        @if ($nextLessonUrl)
                            Auto-Next ON
                        @elseif (! $courseContentComplete)
                            New Videos Coming Soon
                        @else
                            Course Finished
                        @endif
                    </a>
                    <form action="{{ route('student.course-player.complete') }}" method="POST">
                        @csrf
                        <input name="course_id" type="hidden" value="{{ $course->id }}" />
                        <input name="lesson_id" type="hidden" value="{{ $currentLesson->id }}" />
                        <button id="markCompleteButton" @class([
                            'px-8 py-3 font-bold rounded-lg shadow-lg transition-all scale-100',
                            'bg-surface-container-high text-primary hover:bg-surface-container-highest' => $isCurrentLessonCompleted,
                            'bg-gradient-to-r from-primary to-primary-container text-on-primary shadow-primary/20 hover:opacity-90 active:scale-95' => ! $isCurrentLessonCompleted && $canMarkCurrentLessonComplete,
                            'bg-surface-container text-on-surface-variant cursor-not-allowed' => ! $isCurrentLessonCompleted && ! $canMarkCurrentLessonComplete,
                        ]) @disabled(! $isCurrentLessonCompleted && ! $canMarkCurrentLessonComplete) type="submit">
                            {{ $isCurrentLessonCompleted ? 'Completed' : ($canMarkCurrentLessonComplete ? 'Mark as Complete' : 'Finish Video to Complete') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-12">
                <div class="flex gap-6 border-b border-surface-container-low mb-8 overflow-x-auto">
                    <button class="course-tab-button pb-4 font-semibold transition-all {{ $activeTab === 'description' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary' }}" data-tab-target="description" type="button">Description</button>
                    <button class="course-tab-button pb-4 font-semibold transition-all {{ $activeTab === 'resources' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary' }}" data-tab-target="resources" type="button">Resources ({{ $resourceCount }})</button>
                    <button class="course-tab-button pb-4 font-semibold transition-all {{ $activeTab === 'qa' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary' }}" data-tab-target="qa" type="button">Q&amp;A ({{ $qaCount }})</button>
                    <button class="course-tab-button pb-4 font-semibold transition-all {{ $activeTab === 'notes' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary' }}" data-tab-target="notes" type="button">Notes ({{ $notesCount }})</button>
                </div>
                <div class="grid grid-cols-12 gap-8">
                    <div class="col-span-12 xl:col-span-8 space-y-6">
                        @if (! $courseContentComplete)
                            <div class="rounded-3xl border border-amber-200 bg-gradient-to-r from-amber-50 to-white px-6 py-5">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                                        <span class="material-symbols-outlined icon-filled">schedule</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-headline font-bold text-slate-900">More content is on the way</h3>
                                        <p class="mt-1 text-sm text-slate-600">
                                            The instructor is still adding the remaining {{ $comingSoonSectionsCount }} section{{ $comingSoonSectionsCount === 1 ? '' : 's' }}.
                                            Finish the available lessons now, and we will unlock the final course completion once the new videos are published.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div @class(['course-tab-panel space-y-6', 'hidden' => $activeTab !== 'description']) data-tab-panel="description">
                            <div class="p-6 bg-surface-container-lowest rounded-xl">
                                <h3 class="text-lg font-headline font-bold mb-4">In this lesson...</h3>
                                <p class="text-on-surface-variant leading-relaxed">{{ $course->details }}</p>
                                <ul class="mt-4 space-y-2">
                                    <li class="flex items-center gap-2 text-on-surface-variant"><span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle">check_circle</span>Current lesson: {{ $currentLesson->title }}</li>
                                    <li class="flex items-center gap-2 text-on-surface-variant"><span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle">check_circle</span>Total lessons in course: {{ $totalLessons }}</li>
                                    <li class="flex items-center gap-2 text-on-surface-variant"><span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle">check_circle</span>Progress after this lesson: {{ $progressPercent }}%</li>
                                </ul>
                            </div>
                        </div>

                        <div @class(['course-tab-panel space-y-6', 'hidden' => $activeTab !== 'resources']) data-tab-panel="resources">
                            <div class="p-6 bg-surface-container-lowest rounded-xl">
                                <h3 class="text-lg font-headline font-bold mb-4">Resources</h3>
                                @if ($resourceItems->isNotEmpty())
                                    <div class="space-y-3">
                                        @foreach ($resourceItems as $resource)
                                            <div class="rounded-lg border border-surface-container-low px-4 py-3 bg-white">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <p class="font-semibold text-on-surface">{{ $resource->title }}</p>
                                                        <p class="text-xs text-on-surface-variant uppercase tracking-wide">{{ strtoupper($resource->type) }}{{ $resource->is_downloadable ? ' • Download allowed' : '' }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-2 shrink-0">
                                                        <a class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-200" href="{{ route('student.course-player.resource.view', $resource) }}" target="_blank" rel="noopener">
                                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                                            {{ $resource->type === 'pdf' ? 'View' : 'Open' }}
                                                        </a>
                                                        @if ($resource->is_downloadable)
                                                            <a class="inline-flex items-center gap-2 rounded-xl bg-primary px-3 py-2 text-xs font-bold text-white transition hover:opacity-90" href="{{ route('student.course-player.resource.download', $resource) }}" rel="noopener">
                                                                <span class="material-symbols-outlined text-sm">download</span>
                                                                Download
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-on-surface-variant">No resources attached to this lesson yet.</p>
                                @endif
                            </div>
                        </div>

                        <div @class(['course-tab-panel space-y-6', 'hidden' => $activeTab !== 'qa']) data-tab-panel="qa">
                            <div class="p-6 bg-surface-container-lowest rounded-xl">
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div>
                                        <h3 class="text-lg font-headline font-bold">Course Q&amp;A</h3>
                                        <p class="mt-1 text-sm text-on-surface-variant">Ask the instructor a question about this course or this lesson.</p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-primary">{{ $qaCount }} total</span>
                                </div>
                                <form action="{{ route('student.course-player.question') }}" class="space-y-3" method="POST">
                                    @csrf
                                    <input name="course_id" type="hidden" value="{{ $course->id }}" />
                                    <input name="lesson_id" type="hidden" value="{{ $currentLesson->id }}" />
                                    <textarea class="w-full min-h-[120px] rounded-2xl border border-surface-container-low bg-white px-4 py-3 text-sm text-on-surface outline-none focus:border-primary focus:ring-4 focus:ring-primary/10" name="message" placeholder="Ask about this lecture, the project, or any confusing concept..." required>{{ old('message') }}</textarea>
                                    <button class="inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-bold text-white transition hover:opacity-90" type="submit">
                                        <span class="material-symbols-outlined text-base">send</span>
                                        Send Question
                                    </button>
                                </form>
                            </div>
                            <div class="p-6 bg-surface-container-lowest rounded-xl">
                                <h4 class="text-base font-headline font-bold mb-4">Previous Questions</h4>
                                @forelse ($courseQuestions as $question)
                                    <div class="rounded-2xl border border-surface-container-low bg-white px-4 py-4 {{ ! $loop->first ? 'mt-3' : '' }}">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-bold text-on-surface">{{ $question->name }}</p>
                                                <p class="text-xs text-on-surface-variant">{{ $question->created_at?->diffForHumans() }}</p>
                                            </div>
                                            <span class="rounded-full px-3 py-1 text-[11px] font-bold {{ $question->status === 'resolved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ strtoupper($question->status) }}</span>
                                        </div>
                                        <p class="mt-3 text-sm leading-relaxed text-on-surface-variant">{{ $question->message }}</p>
                                        @if ($question->admin_reply)
                                            <div class="mt-3 rounded-2xl bg-slate-50 px-4 py-3">
                                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-primary">Instructor Reply</p>
                                                <p class="mt-2 text-sm text-slate-700">{{ $question->admin_reply }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-on-surface-variant">No questions yet. Ask the first one for this course.</p>
                                @endforelse
                            </div>
                        </div>

                        <div @class(['course-tab-panel space-y-6', 'hidden' => $activeTab !== 'notes']) data-tab-panel="notes">
                            <div class="p-6 bg-surface-container-lowest rounded-xl">
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div>
                                        <h3 class="text-lg font-headline font-bold">Private Notes</h3>
                                        <p class="mt-1 text-sm text-on-surface-variant">These notes are saved for you on this lesson and will be here when you come back.</p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-primary">{{ $notesCount > 0 ? 'Saved' : 'Empty' }}</span>
                                </div>
                                <form action="{{ route('student.course-player.note') }}" class="space-y-3" method="POST">
                                    @csrf
                                    <input name="course_id" type="hidden" value="{{ $course->id }}" />
                                    <input name="lesson_id" type="hidden" value="{{ $currentLesson->id }}" />
                                    <textarea class="w-full min-h-[180px] rounded-2xl border border-surface-container-low bg-white px-4 py-3 text-sm text-on-surface outline-none focus:border-primary focus:ring-4 focus:ring-primary/10" name="content" placeholder="Write your key takeaways, code reminders, or revision notes here...">{{ old('content', $currentLessonNote?->content ?? '') }}</textarea>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <button class="inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-bold text-white transition hover:opacity-90" type="submit">
                                            <span class="material-symbols-outlined text-base">save</span>
                                            Save Note
                                        </button>
                                        <p class="text-xs text-on-surface-variant">Leave the note empty and save if you want to clear it for this lesson.</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <div class="p-6 bg-primary-fixed border-l-4 border-primary rounded-xl">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary" data-icon="{{ $certificateUnlocked ? 'verified' : (! $courseContentComplete ? 'schedule' : 'lightbulb') }}">
                                    {{ $certificateUnlocked ? 'verified' : (! $courseContentComplete ? 'schedule' : 'lightbulb') }}
                                </span>
                                <div>
                                    <h4 class="font-bold text-on-primary-fixed leading-tight">
                                        @if (! $courseContentComplete)
                                            More Sections Coming Soon
                                        @elseif ($certificateUnlocked)
                                            Certificate Unlocked
                                        @else
                                            Certificate Goal
                                        @endif
                                    </h4>
                                    <p class="mt-1 text-sm text-on-primary-fixed-variant">
                                        @if (! $courseContentComplete)
                                            This course is still growing from the instructor side, so the remaining sections will appear here once they are uploaded.
                                        @elseif ($certificateUnlocked)
                                            You have completed every available lesson in this fully published course. Your certificate is ready in the certificates page.
                                        @else
                                            Complete every lesson in this finished course to unlock your certificate.
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if (! $courseContentComplete)
                                <div class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-white/70 px-4 py-3 text-sm font-semibold text-amber-700">
                                    <span class="material-symbols-outlined icon-filled">update</span>
                                    {{ $comingSoonSectionsCount }} section{{ $comingSoonSectionsCount === 1 ? '' : 's' }} pending
                                </div>
                            @elseif ($certificateUnlocked)
                                <a class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-bold text-primary transition hover:opacity-90" href="{{ route('student.certificates') }}#course-{{ $course->id }}">
                                    <span class="material-symbols-outlined icon-filled">workspace_premium</span>
                                    View Certificate
                                </a>
                            @else
                                <div class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-white/70 px-4 py-3 text-sm font-semibold text-primary">
                                    <span class="material-symbols-outlined icon-filled">workspace_premium</span>
                                    {{ $certificateRemaining }} lesson{{ $certificateRemaining === 1 ? '' : 's' }} left for certificate
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <aside class="w-full xl:w-96 bg-surface-container-low border-l-0 overflow-y-auto xl:h-[calc(100vh-4rem)] p-6 scrollbar-hide">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-headline font-bold text-on-surface">Course Content</h2>
                <span class="text-xs font-bold text-on-surface-variant bg-surface-container-high px-2 py-1 rounded">{{ $totalLessons }} Lessons</span>
            </div>
            @foreach ($sectionCards as $index => $section)
                <div class="mb-6">
                    <button class="course-section-toggle flex w-full items-center justify-between p-3 bg-surface-container-high rounded-lg mb-2 text-left" type="button" aria-expanded="{{ $section['is_open'] ? 'true' : 'false' }}">
                        <div class="min-w-0">
                            <span class="text-sm font-bold">{{ $index + 1 }}. {{ $section['title'] }}</span>
                            <div class="mt-1 text-[10px] uppercase tracking-wider {{ $section['is_completed'] ? 'text-tertiary' : 'text-on-surface-variant' }}">
                                @if ($section['is_coming_soon'])
                                    New videos coming soon
                                @else
                                    {{ $section['completed_lessons'] }}/{{ $section['total_lessons'] }} lessons completed
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($section['is_completed'])
                                <span class="material-symbols-outlined icon-filled text-tertiary">check_circle</span>
                            @endif
                            <span class="material-symbols-outlined course-section-toggle-icon {{ $section['is_open'] ? 'text-primary' : 'text-on-surface-variant' }}" data-icon="{{ $section['is_open'] ? 'expand_less' : 'expand_more' }}">{{ $section['is_open'] ? 'expand_less' : 'expand_more' }}</span>
                        </div>
                    </button>
                    <div class="course-section-body {{ $section['is_open'] ? '' : 'hidden' }}">
                    @if (! $section['is_coming_soon'])
                        <div class="space-y-1 pl-1">
                            @foreach ($section['lessons'] as $lesson)
                                <a @class([
                                    'group flex items-center gap-3 p-3 rounded-lg transition-all',
                                    'bg-surface-container-lowest border-l-4 border-primary shadow-sm' => $lesson['is_current'],
                                    'hover:bg-surface-container-highest cursor-pointer' => ! $lesson['is_current'],
                                ]) href="{{ $lesson['url'] }}">
                                    <span @class([
                                        'material-symbols-outlined text-xl',
                                        'icon-filled' => $lesson['is_current'] || $lesson['is_completed'],
                                        $lesson['icon_class'],
                                    ]) data-icon="{{ $lesson['icon'] }}">{{ $lesson['icon'] }}</span>
                                    <div class="flex-1">
                                        <div class="text-xs font-bold {{ $lesson['is_current'] ? 'text-primary' : 'text-on-surface-variant' }}">Lesson {{ $lesson['lesson_number'] }}</div>
                                        <div class="text-sm font-semibold text-on-surface leading-snug">{{ $lesson['title'] }}</div>
                                        <div class="text-[10px] text-on-surface-variant flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-[10px]" data-icon="schedule">schedule</span> <span data-lesson-duration="{{ $lesson['id'] }}">{{ $lesson['duration'] }}</span></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-amber-200 bg-amber-50/70 px-4 py-4 text-sm text-amber-700">
                            <div class="flex items-center gap-2 font-semibold">
                                <span class="material-symbols-outlined icon-filled text-base">update</span>
                                {{ $section['coming_soon_text'] }}
                            </div>
                            <p class="mt-2 text-xs text-amber-600">This section has been planned by the instructor, and its lessons will appear here after they are uploaded.</p>
                        </div>
                    @endif
                    </div>
                </div>
            @endforeach
            <div class="mt-auto p-4 bg-surface-container-highest rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl" data-icon="{{ $courseContentComplete ? 'workspace_premium' : 'schedule' }}">{{ $courseContentComplete ? 'workspace_premium' : 'schedule' }}</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-on-surface">{{ $courseContentComplete ? 'Certificate Goal' : 'Course Updates' }}</div>
                        <div class="text-[10px] text-on-surface-variant uppercase tracking-wider">
                            @if ($certificateUnlocked)
                                Certificate unlocked
                            @elseif (! $courseContentComplete)
                                More sections coming soon
                            @else
                                {{ $certificateRemaining }} lessons remaining
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </main>
    <script>
        (function () {
            document.querySelectorAll('.js-progress-fill').forEach(function (element) {
                var progress = Number(element.getAttribute('data-progress') || '0');
                element.style.width = Math.max(0, Math.min(100, progress)) + '%';
            });

            var video = document.getElementById('lessonVideo');
            if (!video) return;
            var sourceElement = video.querySelector('source');
            var sourceUrl = sourceElement ? sourceElement.getAttribute('src') || '' : '';
            var streamLoader = null;
            var playPauseButton = document.getElementById('playPauseButton');
            var playPauseIcon = document.getElementById('playPauseIcon');
            var rewindButton = document.getElementById('rewindButton');
            var forwardButton = document.getElementById('forwardButton');
            var muteButton = document.getElementById('muteButton');
            var muteIcon = document.getElementById('muteIcon');
            var seekBar = document.getElementById('seekBar');
            var volumeBar = document.getElementById('volumeBar');
            var speedSelect = document.getElementById('speedSelect');
            var fullscreenButton = document.getElementById('fullscreenButton');
            var fullscreenIcon = document.getElementById('fullscreenIcon');
            var pictureInPictureButton = document.getElementById('pictureInPictureButton');
            var currentTime = document.getElementById('currentTime');
            var durationTime = document.getElementById('durationTime');
            var playerFeedback = document.getElementById('playerFeedback');
            var playerFeedbackIcon = document.getElementById('playerFeedbackIcon');
            var playerFeedbackText = document.getElementById('playerFeedbackText');
            var playerPosterOverlay = document.getElementById('playerPosterOverlay');
            var markCompleteButton = document.getElementById('markCompleteButton');
            var playerInteractiveArea = document.getElementById('playerInteractiveArea');
            var playerControls = document.getElementById('playerControls');
            var playerStage = document.getElementById('playerStage');
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            var tabButtons = Array.from(document.querySelectorAll('.course-tab-button'));
            var tabPanels = Array.from(document.querySelectorAll('.course-tab-panel'));
            var saveProgressUrl = video.getAttribute('data-save-progress-url') || '';
            var courseId = video.getAttribute('data-course-id') || '';
            var lessonId = video.getAttribute('data-lesson-id') || '';
            var resumeSeconds = Number(video.getAttribute('data-resume-seconds') || '0');
            var completionThreshold = Number(video.getAttribute('data-completion-threshold') || '1');
            var lessonAlreadyCompleted = video.getAttribute('data-lesson-completed') === '1';
            var lastSavedSecond = resumeSeconds;
            var lastTrackedSecond = resumeSeconds;
            var saveInFlight = false;
            var pendingForceSave = false;
            var idleTimer = null;
            var feedbackTimer = null;
            var hasStartedPlayback = resumeSeconds > 0;
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

            function formatTime(time) {
                if (!isFinite(time) || time < 0) return '00:00';
                var hours = Math.floor(time / 3600);
                var minutes = Math.floor((time % 3600) / 60);
                var seconds = Math.floor(time % 60);
                if (hours > 0) return String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                return String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }

            function setRangeProgress(range) {
                var min = Number(range.min || 0);
                var max = Number(range.max || 100);
                var value = Number(range.value || 0);
                var percent = max > min ? ((value - min) / (max - min)) * 100 : 0;
                range.style.setProperty('--range-progress', percent + '%');
            }

            function updatePlayState() {
                playPauseIcon.textContent = (video.paused || video.ended) ? 'play_arrow' : 'pause';
                if (playerPosterOverlay) {
                    var canShowPoster = !hasStartedPlayback && (video.paused || video.ended || (video.currentTime || 0) <= 0);
                    playerPosterOverlay.style.opacity = canShowPoster ? '1' : '0';
                    playerPosterOverlay.style.pointerEvents = canShowPoster ? 'auto' : 'none';
                }
            }

            function updateMuteState() {
                if (video.muted || Number(volumeBar.value) === 0) muteIcon.textContent = 'volume_off';
                else if (Number(volumeBar.value) < 0.5) muteIcon.textContent = 'volume_down';
                else muteIcon.textContent = 'volume_up';
            }

            function updateTimeline() {
                var duration = video.duration || 0;
                var current = video.currentTime || 0;
                seekBar.value = duration > 0 ? (current / duration) * 100 : 0;
                currentTime.textContent = formatTime(current);
                durationTime.textContent = formatTime(duration);
                setRangeProgress(seekBar);
                updateCompletionButton();
            }

            function syncCurrentLessonDuration(duration) {
                var safeDuration = Math.max(0, Math.floor(Number(duration) || 0));

                if (safeDuration <= 0) {
                    return;
                }

                completionThreshold = Math.max(1, safeDuration - 3);
                document.querySelectorAll('[data-lesson-duration="' + lessonId + '"]').forEach(function (element) {
                    element.textContent = formatTime(safeDuration);
                });
            }

            function togglePlay() {
                if (video.paused || video.ended) video.play(); else video.pause();
            }

            function updateCompletionButton() {
                if (!markCompleteButton || lessonAlreadyCompleted) return;

                var canComplete = Math.floor(video.currentTime || 0) >= completionThreshold;

                markCompleteButton.disabled = !canComplete;
                markCompleteButton.textContent = canComplete ? 'Mark as Complete' : 'Finish Video to Complete';
                markCompleteButton.classList.toggle('bg-surface-container', !canComplete);
                markCompleteButton.classList.toggle('text-on-surface-variant', !canComplete);
                markCompleteButton.classList.toggle('cursor-not-allowed', !canComplete);
                markCompleteButton.classList.toggle('bg-gradient-to-r', canComplete);
                markCompleteButton.classList.toggle('from-primary', canComplete);
                markCompleteButton.classList.toggle('to-primary-container', canComplete);
                markCompleteButton.classList.toggle('text-on-primary', canComplete);
                markCompleteButton.classList.toggle('shadow-primary/20', canComplete);
                markCompleteButton.classList.toggle('hover:opacity-90', canComplete);
                markCompleteButton.classList.toggle('active:scale-95', canComplete);
            }

            function showFeedback(icon, text, position) {
                if (!playerFeedback || !playerFeedbackIcon || !playerFeedbackText) return;
                playerFeedback.classList.remove('is-left', 'is-right');
                if (position === 'left') playerFeedback.classList.add('is-left');
                else if (position === 'right') playerFeedback.classList.add('is-right');
                playerFeedbackIcon.textContent = icon;
                playerFeedbackText.textContent = text;
                playerFeedback.classList.add('is-visible');
                window.clearTimeout(feedbackTimer);
                feedbackTimer = window.setTimeout(function () {
                    playerFeedback.classList.remove('is-visible');
                }, 700);
            }

            function toggleFullscreen() {
                if (!playerStage) return;
                if (!document.fullscreenElement) {
                    var requestFullscreen = playerStage.requestFullscreen || playerStage.webkitRequestFullscreen;
                    if (requestFullscreen) {
                        var requestResult = requestFullscreen.call(playerStage);
                        if (requestResult && typeof requestResult.catch === 'function') {
                            requestResult.catch(function () {});
                        }
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
                        if (exitResult && typeof exitResult.catch === 'function') {
                            exitResult.catch(function () {});
                        }
                    }
                }
            }

            function sendProgressBeacon() {
                if (!saveProgressUrl || !courseId || !lessonId) return;
                if (!navigator.sendBeacon || !isFinite(video.currentTime) || video.currentTime <= 0) return;

                var payload = new FormData();
                payload.append('course_id', Number(courseId));
                payload.append('lesson_id', Number(lessonId));
                payload.append('watched_seconds', Math.floor(video.currentTime));
                payload.append('duration_seconds', Math.floor(video.duration || 0));
                payload.append('_token', csrfToken ? csrfToken.getAttribute('content') : '');

                navigator.sendBeacon(saveProgressUrl, payload);
            }

            function saveProgress(forceSave) {
                if (!saveProgressUrl || !courseId || !lessonId) return;
                if (!isFinite(video.currentTime)) return;
                if ((video.currentTime || 0) <= 0 && Math.floor(video.duration || 0) <= 0) return;
                if (!forceSave && Math.abs(video.currentTime - lastSavedSecond) < 2) return;
                if (saveInFlight) {
                    pendingForceSave = pendingForceSave || forceSave;
                    return;
                }
                saveInFlight = true;
                fetch(saveProgressUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        course_id: Number(courseId),
                        lesson_id: Number(lessonId),
                        watched_seconds: Math.floor(video.currentTime),
                        duration_seconds: Math.floor(video.duration || 0)
                    })
                }).then(function (response) {
                    if (!response.ok) throw new Error('save failed');
                    return response.json();
                }).then(function (payload) {
                    lastSavedSecond = Number(payload.resume_seconds || payload.watched_seconds || Math.floor(video.currentTime));
                }).catch(function () {
                }).finally(function () {
                    saveInFlight = false;
                    if (pendingForceSave) {
                        pendingForceSave = false;
                        saveProgress(true);
                    }
                });
            }

            function showPlayerChrome() {
                if (!playerInteractiveArea) return;
                playerInteractiveArea.classList.remove('is-idle');
            }

            function setActiveTab(tabName) {
                tabButtons.forEach(function (button) {
                    var isActive = button.getAttribute('data-tab-target') === tabName;
                    button.classList.toggle('text-primary', isActive);
                    button.classList.toggle('border-b-2', isActive);
                    button.classList.toggle('border-primary', isActive);
                    button.classList.toggle('font-bold', isActive);
                    button.classList.toggle('text-on-surface-variant', !isActive);
                });

                tabPanels.forEach(function (panel) {
                    panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== tabName);
                });
            }

            function bindCourseOutlineToggles() {
                document.querySelectorAll('.course-section-toggle').forEach(function (toggleButton) {
                    var sectionBody = toggleButton.nextElementSibling;
                    var toggleIcon = toggleButton.querySelector('.course-section-toggle-icon');

                    if (!sectionBody || !toggleIcon) {
                        return;
                    }

                    toggleButton.addEventListener('click', function () {
                        var isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
                        var nextExpanded = !isExpanded;

                        toggleButton.setAttribute('aria-expanded', nextExpanded ? 'true' : 'false');
                        sectionBody.classList.toggle('hidden', !nextExpanded);
                        toggleIcon.textContent = nextExpanded ? 'expand_less' : 'expand_more';
                        toggleIcon.classList.toggle('text-primary', nextExpanded);
                        toggleIcon.classList.toggle('text-on-surface-variant', !nextExpanded);
                    });
                });
            }

            function scheduleIdleState() {
                if (!playerInteractiveArea) return;
                window.clearTimeout(idleTimer);
                if (video.paused) {
                    playerInteractiveArea.classList.remove('is-idle');
                    return;
                }
                idleTimer = window.setTimeout(function () {
                    playerInteractiveArea.classList.add('is-idle');
                }, 2200);
            }

            playPauseButton.addEventListener('click', togglePlay);
            if (playerPosterOverlay) {
                playerPosterOverlay.addEventListener('click', function () {
                    video.currentTime = 0;
                    togglePlay();
                });
            }
            video.addEventListener('click', togglePlay);
            video.addEventListener('play', function () { hasStartedPlayback = true; updatePlayState(); scheduleIdleState(); showFeedback('play_arrow', 'Play', 'center'); });
            video.addEventListener('playing', function () { hasStartedPlayback = true; updatePlayState(); });
            video.addEventListener('pause', function () { updatePlayState(); showPlayerChrome(); saveProgress(true); showFeedback('pause', 'Pause', 'center'); });
            video.addEventListener('ended', function () { updatePlayState(); showPlayerChrome(); saveProgress(true); });
            rewindButton.addEventListener('click', function () { video.currentTime = Math.max(0, video.currentTime - 10); showFeedback('replay_10', 'Back 10s', 'left'); });
            forwardButton.addEventListener('click', function () { video.currentTime = Math.min(video.duration || 0, video.currentTime + 10); showFeedback('forward_10', 'Skip 10s', 'right'); });
            seekBar.addEventListener('input', function () {
                var duration = video.duration || 0;
                if (duration > 0) video.currentTime = (Number(seekBar.value) / 100) * duration;
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
            speedSelect.addEventListener('change', function () { video.playbackRate = Number(speedSelect.value); showFeedback('speed', speedSelect.value + 'x', 'center'); });
            fullscreenButton.addEventListener('click', function () {
                toggleFullscreen();
                showPlayerChrome();
                scheduleIdleState();
            });
            document.addEventListener('fullscreenchange', function () {
                fullscreenIcon.textContent = document.fullscreenElement ? 'fullscreen_exit' : 'fullscreen';
                if (!document.fullscreenElement && orientationLocked && screen.orientation && typeof screen.orientation.unlock === 'function') {
                    screen.orientation.unlock();
                    orientationLocked = false;
                }
            });
            pictureInPictureButton.addEventListener('click', async function () {
                if (!document.pictureInPictureEnabled || video.readyState === 0) return;
                try {
                    if (document.pictureInPictureElement) await document.exitPictureInPicture();
                    else await video.requestPictureInPicture();
                } catch (error) {}
            });
            [playerInteractiveArea, playerControls, video].forEach(function (element) {
                if (!element) return;
                ['mousemove', 'mouseenter', 'touchstart'].forEach(function (eventName) {
                    element.addEventListener(eventName, function () { showPlayerChrome(); scheduleIdleState(); });
                });
            });
            tabButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    setActiveTab(button.getAttribute('data-tab-target') || 'description');
                });
            });
            document.addEventListener('keydown', function (event) {
                var activeTag = document.activeElement ? document.activeElement.tagName : '';
                if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT') return;
                if (event.code === 'Space') { event.preventDefault(); togglePlay(); }
                else if (event.key === 'ArrowLeft') { event.preventDefault(); video.currentTime = Math.max(0, video.currentTime - 10); showFeedback('replay_10', 'Back 10s', 'left'); }
                else if (event.key === 'ArrowRight') { event.preventDefault(); video.currentTime = Math.min(video.duration || 0, video.currentTime + 10); showFeedback('forward_10', 'Skip 10s', 'right'); }
                else if (event.key.toLowerCase() === 'm') { event.preventDefault(); muteButton.click(); }
                else if (event.key.toLowerCase() === 'f') { event.preventDefault(); toggleFullscreen(); }
                showPlayerChrome();
                scheduleIdleState();
            });
            video.addEventListener('loadedmetadata', function () {
                syncCurrentLessonDuration(video.duration || 0);
                if (resumeSeconds > 0 && video.duration && resumeSeconds < video.duration - 2) video.currentTime = resumeSeconds;
                updateTimeline();
                saveProgress(true);
            });
            video.addEventListener('timeupdate', function () {
                updateTimeline();
                lastTrackedSecond = Math.floor(video.currentTime || 0);
                saveProgress(false);
            });
            video.addEventListener('seeked', function () { saveProgress(true); });
            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'hidden') {
                    sendProgressBeacon();
                }
            });
            window.addEventListener('pagehide', function () {
                sendProgressBeacon();
            });
            window.addEventListener('beforeunload', function () {
                sendProgressBeacon();
            });
            initializeVideoSource();
            video.volume = 0.3;
            volumeBar.value = 0.3;
            setRangeProgress(seekBar);
            setRangeProgress(volumeBar);
            updatePlayState();
            updateMuteState();
            updateCompletionButton();
            showPlayerChrome();
            bindCourseOutlineToggles();
            setActiveTab('{{ $activeTab }}');
        })();
    </script>
</body>

</html>


