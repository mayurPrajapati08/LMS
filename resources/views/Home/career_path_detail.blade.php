@php
    $outcomes = $careerPath['career_outcomes'] ?? [];
    $idealFor = $careerPath['ideal_for'] ?? [];
    $deliverables = $careerPath['deliverables'] ?? [];
    $hiringFocus = $careerPath['hiring_focus'] ?? [];
    $whyCourseItems = $careerPath['why_course_items'] ?? [];
    $benefits = $careerPath['benefits'] ?? [];
    $overviewTitle = $careerPath['overview_title'] ?? 'Program Overview';
    $overviewText = $careerPath['overview_text'] ?? ($careerPath['subtitle'] ?? '');
    $overviewHighlight = $careerPath['overview_highlight'] ?? ($careerPath['market_signal'] ?? '');
    $projectCount = count($careerPath['projects'] ?? []);
    $roadmapCount = count($careerPath['weeks'] ?? []);
    $supportCount = count($careerPath['placement_support'] ?? []);
    $toolCount = count($careerPath['skills'] ?? []);
    $roadmapStructureText = $roadmapCount > 0
        ? ($roadmapCount.' guided module'.($roadmapCount === 1 ? '' : 's').' with project checkpoints')
        : 'Guided module flow with project checkpoints';
    $roadmapFocusText = collect($careerPath['skills'] ?? [])->take(3)->implode(', ');
    $roadmapOutcomeText = collect($deliverables)->take(2)->implode(' and ');
    $heroThemes = [
        'data-analyst' => 'from-[#14314b] via-[#0f766e] to-[#7dd3c8]',
        'full-stack-developer' => 'from-[#1d1242] via-[#1d4ed8] to-[#2dd4bf]',
        'ai-engineer' => 'from-[#140d2e] via-[#5b21b6] to-[#f59e0b]',
    ];
    $heroGradient = $heroThemes[$careerPath['slug']] ?? 'from-[#140d2e] via-[#5b21b6] to-[#d946ef]';
    $thumbnailFitClass = match ($careerPath['thumbnail_fit'] ?? 'cover') {
        'contain' => 'object-contain',
        'fill' => 'object-fill',
        'none' => 'object-none',
        'scale-down' => 'object-scale-down',
        default => 'object-cover',
    };
    $thumbnailPositionClass = match ($careerPath['thumbnail_position'] ?? 'center') {
        'top' => 'object-top',
        'bottom' => 'object-bottom',
        'left' => 'object-left',
        'right' => 'object-right',
        default => 'object-center',
    };
@endphp

<x-home.marketing-layout :title="$careerPath['title'] . ' | CodeInYourself'">
    
    <x-slot:head>
        <style>
            .career-card {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(220, 205, 246, 0.78);
                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(248,244,255,0.92));
                box-shadow: 0 24px 64px rgba(76, 29, 149, 0.10);
            }
            .career-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top right, rgba(168,85,247,0.08), transparent 30%);
                pointer-events: none;
            }
            .career-chip {
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.10);
                backdrop-filter: blur(14px);
            }
            .career-tile {
                transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            }
            .career-tile:hover {
                transform: translateY(-6px);
                border-color: rgba(168,85,247,0.3);
                box-shadow: 0 26px 60px rgba(76, 29, 149, 0.12);
            }
            .career-roadmap::before {
                content: none;
            }
            .career-phase::before {
                content: none;
            }
            .career-module {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(226, 214, 248, 0.9);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(247,242,255,0.94));
                box-shadow: 0 24px 58px rgba(76, 29, 149, 0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            }
            .career-module:hover {
                transform: translateY(-6px);
                border-color: rgba(168,85,247,0.32);
                box-shadow: 0 30px 68px rgba(76, 29, 149, 0.12);
            }
            .career-module::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top right, rgba(168,85,247,0.08), transparent 28%);
                pointer-events: none;
            }
            .career-module-step {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 3rem;
                height: 3rem;
                border-radius: 9999px;
                background: linear-gradient(135deg, #7c3aed, #d946ef);
                color: white;
                box-shadow: 0 16px 34px rgba(124,58,237,0.24);
            }
            .career-module-item {
                border: 1px solid rgba(234, 223, 253, 0.95);
                background: rgba(255,255,255,0.96);
            }
            .career-month-shell {
                position: relative;
                overflow: hidden;
                border-radius: 1.9rem;
                border: 1px solid rgba(226, 214, 248, 0.92);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(247,242,255,0.95));
                box-shadow: 0 26px 62px rgba(76, 29, 149, 0.09);
            }
            .career-month-band {
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, #180b34 0%, #5b21b6 55%, #d946ef 100%);
                color: white;
            }
            .career-month-band::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 18% 24%, rgba(255,255,255,0.14), transparent 20%),
                    radial-gradient(circle at 82% 18%, rgba(255,255,255,0.12), transparent 22%);
                pointer-events: none;
            }
            .career-month-body {
                position: relative;
                z-index: 1;
            }
            .career-timeline {
                position: relative;
            }
            .career-timeline-line {
                position: absolute;
                left: 50%;
                top: 0;
                bottom: 0;
                width: 2px;
                transform: translateX(-50%);
                border-radius: 9999px;
                background: linear-gradient(180deg, rgba(124,58,237,0.08), rgba(124,58,237,0.24), rgba(124,58,237,0.08));
                overflow: hidden;
            }
            .career-timeline-progress {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 0;
                border-radius: inherit;
                background: linear-gradient(180deg, #7c3aed 0%, #a855f7 48%, #d946ef 100%);
                box-shadow: 0 0 22px rgba(168,85,247,0.4);
                transition: height 0.18s linear;
            }
            .career-timeline-row {
                position: relative;
                display: grid;
                grid-template-columns: minmax(0, 1fr) 88px minmax(0, 1fr);
                align-items: center;
                gap: 1.5rem;
            }
            .career-timeline-row::before {
                content: "";
                position: absolute;
                left: 50%;
                top: 50%;
                width: 1rem;
                height: 1rem;
                border-radius: 9999px;
                transform: translate(-50%, -50%);
                border: 4px solid #fff;
                background: linear-gradient(135deg, #c4b5fd, #e9d5ff);
                box-shadow: 0 0 0 10px rgba(124,58,237,0.08);
                transition: transform 0.28s ease, background 0.28s ease, box-shadow 0.28s ease, opacity 0.22s ease;
                z-index: 2;
            }
            .career-timeline-row::after {
                content: "done";
                position: absolute;
                left: 50%;
                top: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 9999px;
                transform: translate(-50%, -50%) scale(0.35) rotate(-14deg);
                background: linear-gradient(135deg, #7c3aed, #d946ef);
                box-shadow: 0 18px 38px rgba(124,58,237,0.26);
                font-family: 'Material Symbols Outlined';
                font-size: 1.45rem;
                font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;
                line-height: 1;
                color: #fff;
                opacity: 0;
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.24s ease;
                z-index: 3;
            }
            .career-timeline-row.is-active::before {
                transform: translate(-50%, -50%) scale(1.08);
                background: linear-gradient(135deg, #7c3aed, #d946ef);
                box-shadow: 0 0 0 12px rgba(124,58,237,0.12), 0 0 28px rgba(168,85,247,0.28);
            }
            .career-timeline-row.is-ticked::before {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.25);
            }
            .career-timeline-row.is-ticked::after {
                transform: translate(-50%, -50%) scale(1) rotate(0deg);
                opacity: 1;
                animation: career-tick-pop 0.42s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .career-timeline-row:nth-child(odd) .career-month-shell {
                grid-column: 1 / 2;
            }
            .career-timeline-row:nth-child(even) .career-month-shell {
                grid-column: 3 / 4;
            }
            .career-timeline-spacer {
                min-height: 1px;
            }
            .career-timeline-row.is-active .career-month-shell {
                border-color: rgba(168,85,247,0.34);
                box-shadow: 0 30px 74px rgba(76, 29, 149, 0.14);
            }
            .career-timeline-row.is-active .career-module-step {
                box-shadow: 0 20px 40px rgba(124,58,237,0.34);
            }
            .career-project img {
                transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .career-project {
                align-self: start;
                display: flex;
                height: 100%;
                flex-direction: column;
            }
            .career-project:hover img {
                transform: scale(1.06);
            }
            .career-project-body {
                display: flex;
                flex: 1;
                flex-direction: column;
            }
            .career-project-copy {
                min-height: 8.75rem;
            }
            .skill-coverage-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
                gap: 1rem;
            }
            .skill-coverage-card {
                position: relative;
                overflow: hidden;
                min-height: 148px;
                border: 1px solid rgba(226, 214, 248, 0.92);
                background:
                    radial-gradient(circle at top right, rgba(168,85,247,0.12), transparent 32%),
                    linear-gradient(180deg, rgba(255,255,255,0.98), rgba(247,242,255,0.95));
                box-shadow: 0 20px 50px rgba(76, 29, 149, 0.08);
            }
            .skill-coverage-card::before {
                content: "";
                position: absolute;
                left: 1.25rem;
                right: 1.25rem;
                bottom: 1rem;
                height: 1px;
                background: linear-gradient(90deg, rgba(168,85,247,0.24), transparent);
            }
            .skill-coverage-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.9rem;
                height: 2.9rem;
                border-radius: 1rem;
                background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(217,70,239,0.18));
                color: #7c3aed;
                box-shadow: inset 0 0 0 1px rgba(168,85,247,0.10);
            }
            .skill-coverage-label {
                display: inline-flex;
                align-items: center;
                gap: 0.38rem;
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: rgba(91, 33, 182, 0.72);
            }
            .skill-coverage-name {
                font-size: 1.1rem;
                font-weight: 800;
                line-height: 1.35;
                color: #1f1633;
                text-wrap: balance;
            }
            .career-float {
                transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease;
            }
            .career-float:hover {
                transform: translateY(-8px);
                box-shadow: 0 26px 68px rgba(15, 8, 34, 0.22);
            }
            @keyframes career-tick-pop {
                0% {
                    transform: translate(-50%, -50%) scale(0.35) rotate(-14deg);
                }
                68% {
                    transform: translate(-50%, -50%) scale(1.12) rotate(4deg);
                }
                100% {
                    transform: translate(-50%, -50%) scale(1) rotate(0deg);
                }
            }
            @media (max-width: 1023px) {
                .career-timeline-line {
                    left: 1rem;
                    transform: none;
                }
                .career-timeline-row {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                    padding-left: 2.5rem;
                }
                .career-timeline-row::before {
                    left: 1rem;
                    top: 2rem;
                    transform: translate(-50%, 0);
                }
                .career-timeline-row::after {
                    left: 1rem;
                    top: 2rem;
                    transform: translate(-50%, 0) scale(0);
                }
                .career-timeline-row.is-active::before {
                    transform: translate(-50%, 0) scale(1.08);
                }
                .career-timeline-row.is-ticked::after {
                    transform: translate(-50%, 0) scale(1) rotate(0deg);
                }
                .career-timeline-row:nth-child(odd) .career-month-shell,
                .career-timeline-row:nth-child(even) .career-month-shell {
                    grid-column: auto;
                }
            }
        </style>
    </x-slot:head>

    <main class="pb-24 pt-20">
        <section class="mx-auto max-w-7xl px-4 pb-6 pt-8 sm:px-6">
            <div class="hero-panel hero-stars reveal overflow-hidden rounded-[2.5rem] bg-gradient-to-br {{ $heroGradient }} text-white">
                <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.04fr_0.96fr] lg:p-10 xl:p-12">
                    <div class="relative z-10">
                        <a class="inline-flex items-center gap-2 text-sm font-semibold text-white/72 hover:text-white" href="{{ route('home.career-paths') }}">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            Back to Career Paths
                        </a>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="career-chip rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.24em] text-white/82">{{ $careerPath['role_label'] ?? 'Career Track' }}</span>
                            <span class="career-chip rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.24em] text-white/82">Premium Roadmap</span>
                        </div>

                        <h1 class="mt-7 max-w-4xl font-headline text-4xl font-extrabold leading-[0.96] md:text-[3.7rem]">
                            {{ $careerPath['title'] }}
                        </h1>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-white/78 md:text-base">
                            {{ $careerPath['subtitle'] }}
                        </p>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-white/62">
                            {{ $careerPath['market_signal'] ?? 'A project-led roadmap that turns learning into visible outcomes.' }}
                        </p>

                        <div class="mt-8 grid gap-3 sm:grid-cols-3">
                            <div class="hero-stat rounded-[1.4rem] px-4 py-4">
                                <p class="text-[0.7rem] font-bold uppercase tracking-[0.24em] text-white/56">Duration</p>
                                <p class="mt-3 font-headline text-2xl font-extrabold">{{ $careerPath['duration'] }}</p>
                            </div>
                            <div class="hero-stat rounded-[1.4rem] px-4 py-4">
                                <p class="text-[0.7rem] font-bold uppercase tracking-[0.24em] text-white/56">Projects</p>
                                <p class="mt-3 font-headline text-2xl font-extrabold">{{ $projectCount }} Capstones</p>
                            </div>
                            <div class="hero-stat rounded-[1.4rem] px-4 py-4">
                                <p class="text-[0.7rem] font-bold uppercase tracking-[0.24em] text-white/56">Support</p>
                                <p class="mt-3 font-headline text-2xl font-extrabold">{{ $supportCount }} Boosters</p>
                            </div>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3 text-sm font-semibold text-white/88">
                            <span class="career-chip inline-flex items-center gap-2 rounded-full px-4 py-2"><span class="material-symbols-outlined text-[16px]">desktop_windows</span>{{ $careerPath['mode'] }}</span>
                            <span class="career-chip inline-flex items-center gap-2 rounded-full px-4 py-2"><span class="material-symbols-outlined text-[16px]">verified</span>{{ $careerPath['access'] }}</span>
                            <span class="career-chip inline-flex items-center gap-2 rounded-full px-4 py-2"><span class="material-symbols-outlined text-[16px]">deployed_code</span>{{ $toolCount }} Core Tools</span>
                        </div>
                    </div>

                    <div class="hero-abstract">
                        <div class="hero-radial-bloom right-[10%] top-[8%] h-64 w-64"></div>
                        <div class="hero-giant-word right-0 top-6 text-[5.6rem] lg:text-[7rem]">CRAFT</div>
                        <div class="hero-giant-word right-12 top-32 text-[4.5rem] text-white/10 lg:text-[5.8rem]">DEPLOY</div>
                        <div class="hero-line horizontal left-0 top-16 w-40"></div>
                        <div class="hero-line vertical left-10 top-16 h-48"></div>
                        <div class="hero-dot left-[2.2rem] top-[3.7rem] h-3 w-3"></div>
                        <div class="hero-dot left-[2.2rem] top-[11rem] h-2.5 w-2.5 bg-[#d8b4fe]"></div>
                        <div class="hero-micro-label left-0 top-3">Career Brief</div>

                        <div class="career-float absolute right-0 top-6 w-full max-w-[27rem] rounded-[2rem] border border-white/16 bg-white/12 p-3 backdrop-blur-xl">
                            <div class="overflow-hidden rounded-[1.5rem]">
                                <img alt="{{ $careerPath['title'] }} roadmap" class="h-[18rem] w-full {{ $thumbnailFitClass }} {{ $thumbnailPositionClass }}" src="{{ $careerPath['thumbnail'] }}" />
                            </div>
                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-[1.25rem] border border-white/14 bg-white/10 px-4 py-4">
                                    <p class="text-[0.7rem] font-bold uppercase tracking-[0.22em] text-white/56">Outcomes</p>
                                    <p class="mt-2 text-sm font-semibold text-white">{{ implode(' / ', array_slice($outcomes, 0, 2)) }}</p>
                                </div>
                                <div class="rounded-[1.25rem] border border-white/14 bg-white/10 px-4 py-4">
                                    <p class="text-[0.7rem] font-bold uppercase tracking-[0.22em] text-white/56">Fee Details</p>
                                    <p class="mt-2 text-lg font-extrabold text-white">Contact team / mentor</p>
                                </div>
                            </div>
                        </div>

                        <div class="career-float absolute bottom-0 left-0 w-full max-w-[15.5rem] rounded-[1.5rem] border border-white/14 bg-white/10 p-5 backdrop-blur-xl">
                            <p class="text-[0.7rem] font-bold uppercase tracking-[0.22em] text-white/56">Career Outcomes</p>
                            <div class="mt-3 space-y-3">
                                @foreach (array_slice($outcomes, 0, 3) as $outcome)
                                    <div class="flex items-center gap-2 text-sm text-white/82">
                                        <span class="material-symbols-outlined text-[17px]">check_circle</span>
                                        <span>{{ $outcome }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 pt-4 sm:px-6">
            <div class="grid gap-5 lg:grid-cols-[0.96fr_1.04fr]">
                <div class="career-card reveal rounded-[2rem] p-6 md:p-8">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.26em] text-primary">{{ $overviewTitle }}</p>
                        <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-[2.35rem]">{{ $careerPath['title'] }}</h2>
                        <p class="mt-5 text-sm leading-7 text-on-surface-variant">{{ $overviewText }}</p>
                        @if ($overviewHighlight)
                            <p class="mt-5 rounded-[1.3rem] bg-primary-soft/80 px-4 py-4 text-sm leading-7 text-on-surface">{{ $overviewHighlight }}</p>
                        @endif

                        <div class="mt-7 grid gap-3 sm:grid-cols-3">
                            <div class="career-card rounded-[1.35rem] px-4 py-4">
                                <p class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Modules</p>
                                <p class="mt-2 font-headline text-2xl font-extrabold text-on-surface">{{ $roadmapCount }}</p>
                            </div>
                            <div class="career-card rounded-[1.35rem] px-4 py-4">
                                <p class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Delivery</p>
                                <p class="mt-2 text-sm font-bold text-on-surface">{{ $careerPath['mode'] }}</p>
                            </div>
                            <div class="career-card rounded-[1.35rem] px-4 py-4">
                                <p class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Access</p>
                                <p class="mt-2 text-sm font-bold text-on-surface">{{ $careerPath['access'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="career-card reveal rounded-[2rem] p-6 stagger-1">
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Why This Course?</p>
                            <div class="mt-5 space-y-3">
                                @foreach ($whyCourseItems ?: $idealFor as $item)
                                    <div class="career-tile rounded-[1.2rem] border border-[#eadffd] bg-white/90 px-4 py-4">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-primary-soft text-primary">
                                                <span class="material-symbols-outlined text-[18px]">stars</span>
                                            </span>
                                            <span class="font-semibold leading-7 text-on-surface">{{ $item }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="career-card reveal rounded-[2rem] p-6 stagger-2">
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Career Outcomes</p>
                            <div class="mt-5 space-y-4">
                                @foreach ($outcomes as $item)
                                    <div class="flex items-start gap-3">
                                        <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-primary-soft text-primary">
                                            <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                                        </span>
                                        <p class="text-sm leading-7 text-on-surface-variant">{{ $item }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
            <div class="section-panel reveal rounded-[2.2rem] p-6 md:p-8">
                <div class="relative z-10">
                    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.26em] text-primary">Roadmap</p>
                            <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-[2.5rem]">{{ $careerPath['title'] }} roadmap</h2>
                        </div>
                        <p class="max-w-xl text-sm leading-7 text-on-surface-variant">A guided sequence that takes you from fundamentals to project delivery, stronger portfolio work, and interview preparation.</p>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        <div class="career-card rounded-[1.4rem] px-5 py-5">
                            <p class="text-[0.72rem] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Structure</p>
                            <p class="mt-2 text-sm font-bold text-on-surface">{{ $roadmapStructureText }}</p>
                        </div>
                        <div class="career-card rounded-[1.4rem] px-5 py-5">
                            <p class="text-[0.72rem] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Focus</p>
                            <p class="mt-2 text-sm font-bold text-on-surface">{{ $roadmapFocusText !== '' ? $roadmapFocusText : 'Role-specific tools and practical delivery' }}</p>
                        </div>
                        <div class="career-card rounded-[1.4rem] px-5 py-5">
                            <p class="text-[0.72rem] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Outcome</p>
                            <p class="mt-2 text-sm font-bold text-on-surface">{{ $roadmapOutcomeText !== '' ? $roadmapOutcomeText : 'Portfolio output and job readiness' }}</p>
                        </div>
                    </div>

                    <div class="career-timeline mt-8" id="careerTimeline">
                        <div class="career-timeline-line">
                            <div class="career-timeline-progress" id="careerTimelineProgress"></div>
                        </div>

                        @foreach ($careerPath['weeks'] as $week)
                            <article @class([
                                'career-timeline-row reveal',
                                'stagger-1' => $loop->index === 0,
                                'stagger-2' => $loop->index === 1,
                                'stagger-3' => $loop->index === 2,
                                'stagger-4' => $loop->index >= 3,
                            ]) data-timeline-item>
                                <div class="career-timeline-spacer" aria-hidden="true"></div>

                                <div class="career-month-shell">
                                    <div class="career-month-band px-5 py-5 sm:px-7">
                                        <div class="relative z-10 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                            <div class="flex items-center gap-4">
                                                <span class="career-module-step text-sm font-extrabold">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                                <div>
                                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/68">{{ $week['label'] }}</p>
                                                    <h3 class="mt-1 font-headline text-2xl font-extrabold text-white md:text-[2rem]">{{ $week['title'] ?? 'Core learning and guided execution' }}</h3>
                                                </div>
                                            </div>
                                            <span class="w-fit rounded-full border border-white/14 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white/82">Roadmap Module</span>
                                        </div>
                                    </div>

                                    <div class="career-month-body px-5 py-5 sm:px-7 sm:py-7">
                                        <div class="grid gap-4 md:grid-cols-2">
                                            @foreach ($week['items'] as $item)
                                                <div class="career-module-item rounded-[1.25rem] px-4 py-4">
                                                    <div class="flex items-start gap-3">
                                                        <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-primary-soft text-primary">
                                                            <span class="material-symbols-outlined text-[18px]">done</span>
                                                        </span>
                                                        <div>
                                                            <p class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Learning Outcome</p>
                                                            <p class="mt-2 text-sm leading-7 text-on-surface">{{ $item }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if (!empty($week['project']))
                                            <div class="mt-5 rounded-[1.25rem] border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm font-semibold text-emerald-900">
                                                {{ $week['project'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="glass-card reveal rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Program Deliverables</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">What you leave with</h2>
                    <div class="mt-6 space-y-4">
                        @foreach ($deliverables as $item)
                            <div class="flex items-start gap-3 rounded-[1.25rem] bg-primary-soft/70 px-4 py-4">
                                <span class="material-symbols-outlined mt-0.5 text-primary" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                                <span class="text-sm leading-7 text-on-surface">{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="hero-panel reveal rounded-[2rem] p-6 text-white md:p-8">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/62">Career Support</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold">Structured placement guidance.</h2>
                        <div class="mt-6 space-y-3">
                            @foreach ($careerPath['placement_support'] as $support)
                                <div class="flex items-center gap-3 rounded-[1.15rem] border border-white/10 bg-white/10 px-4 py-4 backdrop-blur-sm">
                                    <span class="material-symbols-outlined text-[18px] text-white">verified</span>
                                    <span class="text-sm text-white/82">{{ $support }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (!empty($benefits))
            <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
                <div class="glass-card reveal rounded-[2.1rem] p-6 md:p-8">
                    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Benefits</p>
                            <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-[2.35rem]">Additional Benefits</h2>
                        </div>
                        <p class="max-w-md text-sm leading-7 text-on-surface-variant">Extra support that helps improve consistency, confidence, interview readiness, and project outcomes.</p>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($benefits as $benefit)
                            <div class="career-card career-tile reveal rounded-[1.5rem] p-5 stagger-1">
                                <div class="relative z-10 flex h-full flex-col gap-5">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-primary text-white shadow-[0_18px_34px_rgba(124,58,237,0.24)]">
                                        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">done</span>
                                    </span>
                                    <p class="text-sm leading-7 text-on-surface">{{ $benefit }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
            <div class="glass-card reveal rounded-[2.1rem] p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Toolkit + Portfolio</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-[2.35rem]">Tools, capstone work, and role-ready presentation.</h2>
                    </div>
                    <p class="max-w-md text-sm leading-7 text-on-surface-variant">This section brings together the core tools, project output, and hiring expectations learners should prepare for in this path.</p>
                </div>

                <div class="skill-coverage-grid mt-8">
                    @foreach ($careerPath['skills'] as $skill)
                        <div class="skill-coverage-card career-tile reveal rounded-[1.35rem] p-5 stagger-1">
                            <div class="relative z-10 flex h-full flex-col gap-5">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="skill-coverage-icon">
                                        <span class="material-symbols-outlined">deployed_code</span>
                                    </span>
                                    <span class="skill-coverage-label">
                                        <span class="material-symbols-outlined text-[14px]">bolt</span>
                                        Skill
                                    </span>
                                </div>
                                <div class="mt-auto">
                                    <p class="skill-coverage-name">{{ $skill }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
                    <div class="grid items-start gap-5 md:grid-cols-2">
                        @foreach ($careerPath['projects'] as $project)
                            <article class="career-project career-tile overflow-hidden rounded-[1.6rem] border border-outline bg-white shadow-sm">
                                <div class="relative h-56 overflow-hidden">
                                    <img alt="{{ $project['title'] }}" class="h-full w-full object-cover" src="{{ $project['image'] }}" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#120520]/70 via-[#120520]/12 to-transparent"></div>
                                    <span class="absolute bottom-4 left-4 rounded-full border border-white/14 bg-white/12 px-3 py-2 text-[0.7rem] font-bold uppercase tracking-[0.22em] text-white backdrop-blur-sm">Capstone Project</span>
                                </div>
                                <div class="career-project-body p-5">
                                    <div class="career-project-copy">
                                        <h3 class="font-headline text-2xl font-extrabold text-on-surface">{{ $project['title'] }}</h3>
                                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $project['subtitle'] }}</p>
                                    </div>
                                    <div class="mt-5 border-t border-outline/70 pt-4">
                                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary">Fee Details</p>
                                        <p class="mt-2 text-sm font-semibold text-on-surface">Contact team / mentor to know the current fee.</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="space-y-6">
                        <div class="career-card rounded-[1.9rem] p-6">
                            <div class="relative z-10">
                                <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Hiring Lens</p>
                                <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">What interviewers usually expect</h2>
                                <div class="mt-6 space-y-4">
                                    @foreach ($hiringFocus as $focus)
                                        <div class="rounded-[1.2rem] border border-[#eadffd] bg-white/92 px-4 py-4">
                                            <div class="flex items-start gap-3">
                                                <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-primary-soft text-primary">
                                                    <span class="material-symbols-outlined text-[18px]">insights</span>
                                                </span>
                                                <p class="text-sm leading-7 text-on-surface-variant">{{ $focus }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="hero-panel rounded-[1.9rem] p-6 text-white">
                            <div class="relative z-10">
                                <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/62">Admission</p>
                                <h2 class="mt-3 font-headline text-3xl font-extrabold">Premium track. Clear next step.</h2>
                                <div class="mt-6 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-white">Talk to a mentor or reserve your seat to get started.</p>
                                    </div>
                                    <span class="rounded-full bg-white/12 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em]">Limited Seats</span>
                                </div>
                                <p class="mt-5 text-sm leading-7 text-white/74">Talk with a mentor to understand fit, roadmap expectations, and the right starting point for your background.</p>
                                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                                    <a class="cta-button inline-flex flex-1 items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-bold uppercase tracking-[0.16em] text-primary" href="/mentorship#talktomentor">Talk to Mentor</a>
                                    <a class="cta-button inline-flex flex-1 items-center justify-center rounded-2xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-bold uppercase tracking-[0.16em] text-white" href="/mentorship#talktomentor">Reserve Your Seat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-slot:scripts>
        <script>
            (function () {
                var timeline = document.getElementById('careerTimeline');
                var progress = document.getElementById('careerTimelineProgress');
                if (!timeline || !progress) return;

                var items = timeline.querySelectorAll('[data-timeline-item]');
                if (!items.length) return;

                var updateTimeline = function () {
                    var rect = timeline.getBoundingClientRect();
                    var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
                    var start = viewportHeight * 0.22;
                    var end = rect.height - viewportHeight * 0.28;
                    var raw = start - rect.top;
                    var max = end > 0 ? end : rect.height;
                    var progressValue = Math.max(0, Math.min(raw / max, 1));
                    progress.style.height = (progressValue * 100) + '%';
                    var progressBottom = rect.top + (rect.height * progressValue);

                    items.forEach(function (item) {
                        var itemRect = item.getBoundingClientRect();
                        var itemCenter = itemRect.top + (itemRect.height / 2);
                        var isActive = itemCenter < viewportHeight * 0.62 && itemCenter > viewportHeight * 0.18;
                        var isTicked = progressBottom >= itemCenter;
                        item.classList.toggle('is-active', isActive);
                        item.classList.toggle('is-ticked', isTicked);
                    });
                };

                updateTimeline();
                window.addEventListener('scroll', updateTimeline, { passive: true });
                window.addEventListener('resize', updateTimeline);
            })();
        </script>
    </x-slot:scripts>
</x-home.marketing-layout>
