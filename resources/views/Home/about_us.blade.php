@php
    $companyHighlights = [
        ['label' => 'Platform Type', 'value' => 'Career-focused learning platform'],
        ['label' => 'Core Delivery', 'value' => 'Mentor-guided project learning'],
        ['label' => 'Primary Audience', 'value' => 'Students, freshers, and professionals'],
        ['label' => 'Operating Style', 'value' => 'Professional brand with practical training'],
    ];

    $brandPillars = [
        [
            'icon' => 'workspace_premium',
            'title' => 'Professional experience',
            'description' => 'The public brand, learner journey, and platform experience are built to feel clear, trusted, and well organized.',
        ],
        [
            'icon' => 'terminal',
            'title' => 'Practical skill building',
            'description' => 'Programs focus on application, projects, and learning that feels closer to real work than passive course consumption.',
        ],
        [
            'icon' => 'groups',
            'title' => 'Mentor-backed progress',
            'description' => 'Learners are supported through feedback, guidance, and a delivery model that keeps momentum visible.',
        ],
        [
            'icon' => 'trending_up',
            'title' => 'Career-oriented outcomes',
            'description' => 'Courses, certificates, reviews, and placement readiness all contribute to a stronger outcome-driven academy identity.',
        ],
    ];

    $timeline = [
        [
            'step' => '01',
            'title' => 'Discover the direction',
            'description' => 'Learners first meet a clear company identity, structured guidance, and a platform that looks serious about their future.',
        ],
        [
            'step' => '02',
            'title' => 'Train with structure',
            'description' => 'Programs combine curriculum, mentors, projects, and visible platform movement instead of isolated learning screens.',
        ],
        [
            'step' => '03',
            'title' => 'Build confidence',
            'description' => 'Reviews, course progress, certificates, and enrollments make the learner journey feel active and credible.',
        ],
        [
            'step' => '04',
            'title' => 'Move toward outcomes',
            'description' => 'Placement support, career paths, and professional positioning help learning stay connected to opportunity.',
        ],
    ];
@endphp

<x-home.marketing-layout title="About | CodeInYourself">
    
    <x-slot:head>
        <style>
            .about-hero-shell {
                position: relative;
                overflow: hidden;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                background:
                    radial-gradient(circle at 14% 20%, rgba(255,255,255,0.16), transparent 20%),
                    radial-gradient(circle at 82% 18%, rgba(216,180,254,0.18), transparent 24%),
                    radial-gradient(circle at 78% 76%, rgba(255,255,255,0.10), transparent 24%),
                    linear-gradient(135deg, #0b0316 0%, #220942 28%, #4c1d95 62%, #8b5cf6 100%);
            }

            .about-hero-shell::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.04), transparent 24%),
                    linear-gradient(180deg, transparent 70%, rgba(11,3,22,0.30) 100%);
                pointer-events: none;
            }

            .about-hero-shell::after {
                content: "";
                position: absolute;
                inset: 0;
                background-image:
                    radial-gradient(1px 1px at 10% 18%, rgba(255,255,255,0.75) 0%, transparent 100%),
                    radial-gradient(1px 1px at 30% 11%, rgba(255,255,255,0.48) 0%, transparent 100%),
                    radial-gradient(1.5px 1.5px at 72% 16%, rgba(255,255,255,0.55) 0%, transparent 100%),
                    radial-gradient(1px 1px at 88% 46%, rgba(255,255,255,0.30) 0%, transparent 100%),
                    radial-gradient(1.3px 1.3px at 22% 76%, rgba(221,214,254,0.65) 0%, transparent 100%),
                    radial-gradient(1px 1px at 64% 73%, rgba(255,255,255,0.44) 0%, transparent 100%);
                opacity: 0.9;
                pointer-events: none;
            }

            .about-hero-grid {
                position: relative;
                z-index: 1;
            }

            .about-hero-frame {
                position: relative;
                overflow: hidden;
                border-radius: 2rem;
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.08);
                box-shadow: 0 28px 90px rgba(20, 6, 48, 0.26);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .about-hero-frame::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(255,255,255,0.10), transparent 26%, transparent 72%, rgba(11,3,22,0.18) 100%);
                pointer-events: none;
            }

            .about-hero-gridline {
                position: absolute;
                inset: 10% 8% 12% auto;
                width: 38%;
                background-image:
                    linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
                background-size: 2.5rem 2.5rem;
                mask-image: radial-gradient(circle at center, black 30%, transparent 78%);
                opacity: 0.55;
                pointer-events: none;
            }

            .about-floating-card {
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(255,255,255,0.10);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                box-shadow: 0 18px 44px rgba(21, 7, 50, 0.18);
            }

            .about-kicker {
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.24em;
                text-transform: uppercase;
            }

            .about-company-band {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(220, 205, 246, 0.72);
                background: linear-gradient(180deg, rgba(255,255,255,0.88), rgba(249,245,255,0.94));
                box-shadow: 0 24px 58px rgba(76, 29, 149, 0.10);
            }

            .about-company-band::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at top left, rgba(168,85,247,0.08), transparent 24%),
                    radial-gradient(circle at bottom right, rgba(124,58,237,0.07), transparent 26%);
                pointer-events: none;
            }

            .about-page-shell {
                overflow-x: clip;
            }

            @supports not (overflow: clip) {
                .about-page-shell {
                    overflow-x: hidden;
                }
            }
        </style>
    </x-slot:head>

    <main class="about-page-shell pb-24 pt-5">
        <section class="about-hero-shell reveal min-h-[calc(100vh-5rem)] px-4 pb-14 pt-10 text-white sm:px-6 md:px-8 md:pb-16 md:pt-12">
            <div class="about-hero-grid mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1.08fr_0.92fr] lg:items-center">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/14 bg-white/8 px-4 py-2 text-white/78 backdrop-blur-sm">
                        <span class="h-2 w-2 rounded-full bg-[#d8b4fe]"></span>
                        <span class="about-kicker">About CodeInYourself</span>
                    </span>

                    <h1 class="mt-7 max-w-3xl font-headline text-[1.8rem] font-extrabold leading-[1.04] sm:text-[2.05rem] md:text-[2.45rem] lg:text-[3rem]">
                        Building a learning company
                        <span class="block text-[#ead9ff]">where clear guidance supports practical career growth.</span>
                    </h1>

                    <p class="mt-5 max-w-xl text-[0.92rem] leading-7 text-white/68 md:text-[0.97rem]">
                        CodeInYourself is built as a modern education brand and learning ecosystem. We combine mentor-led delivery, project-focused learning, and learner support so the platform feels credible and growth-oriented.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('home.courses') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-primary">
                            Explore Programs
                            <span class="material-symbols-outlined text-[18px]">north_east</span>
                        </a>
                        <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-white/14 bg-white/10 px-6 py-4 text-sm font-bold text-white backdrop-blur-sm">
                            Talk To The Team
                        </a>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <div class="about-floating-card rounded-[1.6rem] p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">Learners</p>
                            <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['students']) }}+</p>
                        </div>
                        <div class="about-floating-card rounded-[1.6rem] p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">Programs</p>
                            <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['published_courses']) }}+</p>
                        </div>
                        <div class="about-floating-card rounded-[1.6rem] p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">Mentors</p>
                            <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['mentors']) }}+</p>
                        </div>
                    </div>
                </div>

                <div class="relative min-h-[27rem] lg:min-h-[36rem]">
                    <div class="about-hero-gridline"></div>

                    <div class="about-floating-card absolute left-0 top-0 max-w-[14rem] rounded-[1.6rem] p-4">
                        <p class="about-kicker text-white/50">Company Position</p>
                        <p class="mt-3 font-headline text-2xl font-extrabold leading-tight text-white">A learning platform built on clear delivery and practical value.</p>
                    </div>

                    <div class="about-hero-frame absolute right-0 top-16 w-full max-w-[22rem] p-3">
                        <div class="overflow-hidden rounded-[1.55rem] bg-[linear-gradient(180deg,rgba(29,10,57,0.78),rgba(102,45,188,0.68))] p-3">
                            <img src="{{ asset('images/owner 1.0.jpeg') }}" alt="Founder portrait" class="h-[26rem] w-full rounded-[1.35rem] object-cover object-top" />
                        </div>
                    </div>

                    <div class="about-floating-card absolute bottom-0 left-10 right-0 rounded-[1.7rem] p-5">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="about-kicker text-white/50">Brand Promise</p>
                                <p class="mt-3 max-w-md text-sm leading-7 text-white/76">A connected experience for discovery, enrollment, mentoring, learning progress, and career movement.</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <p class="font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['enrollments']) }}+</p>
                                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-white/50">Completed enrollments</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto -mt-8 max-w-7xl px-4 sm:px-6">
            <div class="about-company-band reveal rounded-[2rem] px-6 py-6 md:px-8">
                <div class="relative z-10 grid gap-4 md:grid-cols-4">
                    @foreach ($companyHighlights as $highlight)
                        <div class="rounded-[1.5rem] border border-white/70 bg-white/70 p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/70">{{ $highlight['label'] }}</p>
                            <p class="mt-3 text-sm font-semibold leading-7 text-on-surface">{{ $highlight['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[1.02fr_0.98fr]">
                <article class="glass-card premium-card reveal rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Who We Are</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">A modern learning company built around clarity, trust, and outcomes.</h2>
                    <div class="mt-5 space-y-4 text-sm leading-8 text-on-surface-variant md:text-base">
                        <p>CodeInYourself is not presented as a generic course page. It is shaped like a real company, with a defined identity, visible leadership, live learning activity, and a delivery model centered on practical capability.</p>
                        <p>The academy combines public brand storytelling with a structured LMS experience so learners can discover the platform, choose a path, learn with guidance, track progress, and move toward certificates or placement support in one flow.</p>
                        <p>That balance between visual polish and operational clarity is what makes the About page important. It should communicate trust, ambition, and professionalism without feeling overloaded or artificial.</p>
                    </div>
                </article>

                <article class="section-panel reveal rounded-[2rem] p-6 md:p-8">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">What Defines The Brand</p>
                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            @foreach ($brandPillars as $pillar)
                                <div class="soft-strip rounded-[1.5rem] p-4">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                        <span class="material-symbols-outlined">{{ $pillar['icon'] }}</span>
                                    </span>
                                    <h3 class="mt-4 font-headline text-xl font-extrabold text-on-surface">{{ $pillar['title'] }}</h3>
                                    <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $pillar['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[0.96fr_1.04fr]">
                <article class="glass-card premium-card reveal rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">How We Operate</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">A strong academy experience starts with clear structure and consistent support.</h2>

                    <div class="mt-6 space-y-4">
                        @foreach ($timeline as $item)
                            <div class="rounded-[1.5rem] border border-outline/70 bg-white/72 p-4">
                                <div class="flex items-start gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary/10 font-headline text-lg font-extrabold text-primary">{{ $item['step'] }}</span>
                                    <div>
                                        <h3 class="font-headline text-xl font-extrabold text-on-surface">{{ $item['title'] }}</h3>
                                        <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $item['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="hero-panel reveal rounded-[2rem] px-6 py-8 text-white md:px-8">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/62">Platform Snapshot</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">Live platform activity reinforces the company story with real signals.</h2>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <div class="hero-stat rounded-[1.5rem] p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/52">Certificates</p>
                                <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['certificates']) }}+</p>
                                <p class="mt-2 text-sm leading-7 text-white/72">Learner achievement is visible and documented through the platform.</p>
                            </div>

                            <div class="hero-stat rounded-[1.5rem] p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/52">Reviews</p>
                                <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['reviews_count']) }}+</p>
                                <p class="mt-2 text-sm leading-7 text-white/72">Feedback and learner response make the academy feel active and trusted.</p>
                            </div>

                            <div class="hero-stat rounded-[1.5rem] p-5 sm:col-span-2">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/52">Average Rating</p>
                                        <p class="mt-3 font-headline text-4xl font-extrabold text-white">{{ number_format($siteStats['avg_rating'], 1) }}/5</p>
                                    </div>
                                    <p class="max-w-md text-sm leading-7 text-white/72">Good brand experience matters more when it is supported by real learner movement, working mentors, and visible academic outcomes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="section-panel reveal rounded-[2.2rem] px-6 py-8 md:px-8">
                <div class="relative z-10 mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Mentor Network</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">The people who help turn the brand promise into an actual learning experience.</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-on-surface-variant">These cards are powered by live instructor data, so the About page reflects the real mentor presence behind the LMS.</p>
                </div>

                @if ($mentorCards->isNotEmpty())
                    <div class="relative z-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($mentorCards as $index => $mentor)
                            <article class="glass-card premium-card reveal stagger-{{ ($index % 4) + 1 }} rounded-[1.9rem] p-5">
                                <img alt="{{ $mentor['name'] }}" class="h-64 w-full rounded-[1.5rem] object-cover" src="{{ $mentor['avatar'] }}" />
                                <h3 class="mt-5 font-headline text-2xl font-extrabold text-on-surface">{{ $mentor['name'] }}</h3>
                                <p class="mt-2 text-sm font-bold uppercase tracking-[0.16em] text-primary">{{ $mentor['headline'] }}</p>
                                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $mentor['bio'] }}</p>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="relative z-10 rounded-[1.8rem] border border-dashed border-outline bg-white/70 p-8 text-center">
                        <h3 class="font-headline text-2xl font-extrabold text-on-surface">Mentor profiles will appear here</h3>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">Instructor profiles will appear here once mentor records are available.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="hero-panel reveal rounded-[2.2rem] px-6 py-10 text-white sm:px-8 md:px-10">
                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/62">Start With Confidence</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">Explore a platform built around clarity, guidance, and real learner progress.</h2>
                        <p class="mt-4 text-sm leading-7 text-white/76 md:text-base">From the first impression to the final milestone, the goal is to create an academy experience that stays professional and purposeful.</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold uppercase tracking-[0.16em] text-primary" href="{{ route('home.courses') }}">
                            Explore Programs
                            <span class="material-symbols-outlined text-[18px]">north_east</span>
                        </a>
                        <a class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl border border-white/14 bg-white/10 px-6 py-4 text-sm font-bold uppercase tracking-[0.16em] text-white backdrop-blur-sm" href="{{ route('home.contact') }}">
                            Contact The Team
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
