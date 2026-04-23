@php
    $heroStats = [
        ['value' => '1:1', 'label' => 'personal guidance based on your background'],
        ['value' => 'Free', 'label' => 'no-cost discussion before choosing a program'],
        ['value' => '3 Steps', 'label' => 'book, talk, and move ahead with clarity'],
    ];

    $mentorshipBenefits = [
        ['icon' => 'school', 'title' => 'Right Program Selection', 'description' => 'Understand which course, workshop, or roadmap fits your current level and goal.'],
        ['icon' => 'forum', 'title' => 'Practical Doubt Solving', 'description' => 'Ask about skills, projects, internships, placements, or how to start from zero.'],
        ['icon' => 'meeting_room', 'title' => 'Clear Next Step', 'description' => 'Leave the session with a practical action plan instead of confusion.'],
    ];

    $mentorshipFlow = [
        ['step' => '01', 'title' => 'Book your slot', 'copy' => 'Share your basic details, preferred date, and preferred time for the mentorship discussion.'],
        ['step' => '02', 'title' => 'Speak with a mentor', 'copy' => 'Discuss your background, your doubts, your goal, and the areas where you need proper guidance.'],
        ['step' => '03', 'title' => 'Get the right direction', 'copy' => 'Receive clear advice on the right course, learning path, practice plan, or next move.'],
    ];

    $guidanceAreas = [
        'Which course is right for your background',
        'How to start from beginner level',
        'Placement and internship preparation',
        'Projects and portfolio improvement',
        'Technology or career path confusion',
        'Online or offline learning guidance',
    ];
@endphp

<x-home.marketing-layout title="Free Mentorship | CodeInYourself" bodyClass="mentorship-page">
    <x-slot:head>
        <style>
            .mentorship-hero {
                position: relative;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                overflow: hidden;
                background:
                    radial-gradient(circle at 12% 18%, rgba(255,255,255,0.18), transparent 20%),
                    radial-gradient(circle at 78% 12%, rgba(216,180,254,0.26), transparent 24%),
                    radial-gradient(circle at 72% 76%, rgba(255,255,255,0.12), transparent 20%),
                    linear-gradient(135deg, #06010f 0%, #17042e 24%, #39106f 56%, #6d28d9 84%, #c084fc 100%);
                isolation: isolate;
            }

            .mentorship-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 84px 84px;
                mask-image: radial-gradient(circle at center, black 28%, transparent 82%);
                opacity: 0.26;
                pointer-events: none;
            }

            .mentorship-hero::after {
                content: "";
                position: absolute;
                inset: auto 0 0;
                height: 8rem;
                background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(252,249,255,1) 100%);
                pointer-events: none;
                z-index: 1;
            }

            .mentorship-orb {
                position: absolute;
                border-radius: 9999px;
                filter: blur(14px);
                pointer-events: none;
            }

            .mentorship-orb.one {
                top: 4rem;
                left: -4rem;
                width: 15rem;
                height: 15rem;
                background: radial-gradient(circle, rgba(192,132,252,0.34), rgba(192,132,252,0));
                animation: float-aurora 16s ease-in-out infinite alternate;
            }

            .mentorship-orb.two {
                right: -4rem;
                bottom: 2rem;
                width: 16rem;
                height: 16rem;
                background: radial-gradient(circle, rgba(255,255,255,0.20), rgba(255,255,255,0));
                animation: float-aurora 18s ease-in-out infinite alternate;
            }

            .hero-shell {
                position: relative;
                z-index: 2;
            }

            .hero-mini-card {
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.10);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.08);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
            }

            .hero-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.7rem;
                border-radius: 9999px;
                border: 1px solid rgba(255,255,255,0.16);
                background: rgba(255,255,255,0.08);
                padding: 0.75rem 1.15rem;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
            }

            .hero-kicker::before {
                content: "";
                width: 0.55rem;
                height: 0.55rem;
                border-radius: 9999px;
                background: linear-gradient(135deg, #f9a8d4, #e9d5ff);
                box-shadow: 0 0 18px rgba(249,168,212,0.65);
            }

            .hero-visual-card {
                position: relative;
                overflow: hidden;
                min-height: 31rem;
                border-radius: 2rem;
                border: 1px solid rgba(255,255,255,0.12);
                background:
                    radial-gradient(circle at 20% 18%, rgba(255,255,255,0.12), transparent 18%),
                    linear-gradient(145deg, rgba(255,255,255,0.10), rgba(255,255,255,0.04)),
                    linear-gradient(160deg, rgba(17,6,35,0.80), rgba(91,33,182,0.64));
                box-shadow: 0 24px 60px rgba(10, 3, 26, 0.26);
            }

            .hero-visual-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 76% 20%, rgba(216,180,254,0.20), transparent 20%),
                    linear-gradient(180deg, rgba(255,255,255,0.08), transparent 36%, rgba(8,2,18,0.22) 100%);
                pointer-events: none;
            }

            .hero-visual-card::after {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 28% 38%, rgba(255,255,255,0.12), transparent 18%),
                    radial-gradient(circle at 65% 70%, rgba(196,181,253,0.18), transparent 22%);
                mix-blend-mode: screen;
                pointer-events: none;
            }

            .hero-grid {
                position: absolute;
                inset: 10% 8%;
                background-image:
                    linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
                background-size: 4.8rem 4.8rem;
                mask-image: radial-gradient(circle at center, black 34%, transparent 78%);
                opacity: 0.42;
                pointer-events: none;
            }

            .hero-word {
                position: absolute;
                top: 1.2rem;
                right: 1.2rem;
                font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
                font-size: clamp(3.2rem, 9vw, 6.4rem);
                font-weight: 800;
                line-height: 0.85;
                letter-spacing: -0.09em;
                color: rgba(255,255,255,0.08);
                text-transform: uppercase;
                pointer-events: none;
                user-select: none;
            }

            .hero-path {
                position: absolute;
                inset: 18% 14% 14% 14%;
                border-radius: 9999px;
                border: 1px dashed rgba(255,255,255,0.18);
                transform: rotate(-16deg);
                pointer-events: none;
            }

            .journey-line {
                position: absolute;
                inset: 4.5rem 3rem 4.5rem 3rem;
                border-radius: 9999px;
                border: 1px dashed rgba(255,255,255,0.18);
                pointer-events: none;
            }

            .journey-node {
                position: relative;
                z-index: 1;
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.12);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                box-shadow: 0 18px 42px rgba(9, 2, 24, 0.18);
            }

            .journey-node[data-parallax] {
                will-change: transform;
            }

            .hero-anchor-card {
                position: absolute;
                left: 1.5rem;
                bottom: 1.5rem;
                max-width: 15rem;
                border-radius: 1.5rem;
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.10);
                padding: 1rem 1.1rem;
                color: white;
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                box-shadow: 0 18px 42px rgba(9, 2, 24, 0.18);
            }

            .hero-glow-beam {
                position: absolute;
                right: -2rem;
                top: 18%;
                width: 16rem;
                height: 1px;
                background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,0.72), rgba(255,255,255,0));
                transform: rotate(-28deg);
                opacity: 0.8;
                pointer-events: none;
            }

            .hero-scroll-cue {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                color: rgba(255,255,255,0.68);
                font-size: 0.78rem;
                font-weight: 700;
                letter-spacing: 0.2em;
                text-transform: uppercase;
            }

            .hero-scroll-cue span:last-child {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.2rem;
                height: 2.2rem;
                border-radius: 9999px;
                border: 1px solid rgba(255,255,255,0.16);
                background: rgba(255,255,255,0.08);
                animation: bounce-soft 2.8s ease-in-out infinite;
            }

            .surface-card {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(220,205,246,0.78);
                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(248,243,255,0.92));
                box-shadow: 0 24px 56px rgba(88,28,135,0.10);
            }

            .surface-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at top right, rgba(168,85,247,0.08), transparent 24%),
                    radial-gradient(circle at bottom left, rgba(124,58,237,0.06), transparent 22%);
                pointer-events: none;
            }

            .feature-icon-shell {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 3.4rem;
                height: 3.4rem;
                border-radius: 1.1rem;
                background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(168,85,247,0.18));
                color: #6d28d9;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.82);
            }

            .timeline-row { position: relative; padding-left: 4.5rem; }
            .timeline-row::before {
                content: "";
                position: absolute;
                left: 1.45rem;
                top: 3.1rem;
                bottom: -1.8rem;
                width: 1px;
                background: linear-gradient(180deg, rgba(124,58,237,0.28), rgba(168,85,247,0));
            }
            .timeline-row:last-child::before { display: none; }

            .timeline-step {
                position: absolute;
                left: 0;
                top: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 3rem;
                height: 3rem;
                border-radius: 9999px;
                background: linear-gradient(135deg, #6d28d9, #a855f7);
                color: #fff;
                font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
                font-weight: 800;
                box-shadow: 0 16px 34px rgba(124,58,237,0.24);
            }

            .field-label {
                display: block;
                margin-bottom: 0.7rem;
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: #7c3aed;
            }

            .field-shell {
                position: relative;
                overflow: hidden;
                border-radius: 1.2rem;
                border: 1px solid rgba(220,205,246,0.9);
                background: rgba(255,255,255,0.94);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.78);
            }

            .premium-input, .premium-select, .premium-textarea {
                width: 100%;
                border: 0;
                background: transparent;
                padding: 1rem 1rem;
                color: #1a1330;
                font-size: 0.95rem;
            }

            .premium-input:focus, .premium-select:focus, .premium-textarea:focus {
                outline: none;
                box-shadow: inset 0 0 0 2px rgba(124,58,237,0.22);
            }

            .premium-textarea { min-height: 8rem; resize: vertical; }

            .choice-card {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                border-radius: 1.1rem;
                border: 1px solid rgba(220,205,246,0.9);
                background: rgba(255,255,255,0.92);
                padding: 0.95rem 1rem;
                font-size: 0.92rem;
                font-weight: 600;
                color: #1a1330;
                transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            }

            .choice-card:hover {
                transform: translateY(-1px);
                border-color: rgba(168,85,247,0.62);
                box-shadow: 0 14px 30px rgba(124,58,237,0.10);
            }

            .choice-card input { accent-color: #7c3aed; }
            .success-strip { border: 1px solid rgba(74,222,128,0.22); background: linear-gradient(135deg, rgba(240,253,244,0.96), rgba(220,252,231,0.88)); }
            .error-strip { border: 1px solid rgba(248,113,113,0.24); background: linear-gradient(135deg, rgba(254,242,242,0.96), rgba(255,228,230,0.88)); }

            .reveal-lift {
                opacity: 0;
                transform: translateY(40px) scale(0.98);
                transition:
                    opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal-lift.visible {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            @keyframes bounce-soft {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(6px); }
            }

            @media (max-width: 1024px) {
                .hero-visual-card { min-height: auto; }
                .journey-line { inset: 4rem 2rem; }
                .hero-path { inset: 16% 8% 14% 8%; }
                .hero-anchor-card {
                    position: static;
                    max-width: 100%;
                    margin-top: 1rem;
                }
            }
        </style>
    </x-slot:head>


    
    <main class="overflow-x-clip">
        <section class="mentorship-hero px-4 pb-24 pt-10 md:px-6 md:pb-28 md:pt-20">
            <div class="mentorship-orb one"></div>
            <div class="mentorship-orb two"></div>

            <div class="mx-auto max-w-6xl">
                <div class="hero-shell py-8 md:py-12 lg:py-16">
                    <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                        <div class="reveal-lift text-white">
                            <div class="hero-kicker text-[11px] font-bold uppercase tracking-[0.24em] text-[#e9d5ff]">
                                Free Mentorship Appointment
                            </div>
                            <h1 class="mt-6 font-headline text-4xl font-extrabold leading-[0.95] tracking-[-0.05em] md:text-[3.6rem]">
                                Book a free mentorship session and get clear guidance for your next step.
                            </h1>
                            <p class="mt-6 max-w-2xl text-base leading-8 text-white/74 md:text-[1.05rem]">
                                This mentorship session is for students who need real guidance before choosing a course, starting a career path, preparing for placements, or planning the right learning direction.
                            </p>
                            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                                @foreach ($heroStats as $stat)
                                    <div class="hero-mini-card rounded-[1.45rem] p-4">
                                        <p class="font-headline text-2xl font-extrabold text-white">{{ $stat['value'] }}</p>
                                        <p class="mt-2 text-sm leading-6 text-white/66">{{ $stat['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="#book-mentorship" class="cta-button inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-sm font-bold text-primary shadow-[0_18px_38px_rgba(255,255,255,0.14)]">
                                    <span class="material-symbols-outlined text-[18px]">event_available</span>
                                    Book Free Slot
                                </a>
                                <a href="#mentorship-flow" class="inline-flex items-center gap-2 rounded-full border border-white/18 bg-white/8 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-white/12">
                                    <span class="material-symbols-outlined text-[18px]">lan</span>
                                    See How It Works
                                </a>
                            </div>

                            <div class="mt-10 hero-scroll-cue">
                                <span>Scroll For Mentorship Details</span>
                                <span><span class="material-symbols-outlined text-[18px]">south</span></span>
                            </div>
                        </div>

                        <div class="reveal-lift stagger-1">
                            <div class="hero-visual-card p-5 md:p-6">
                                <div class="hero-grid"></div>
                                <div class="hero-word">Mentor</div>
                                <div class="hero-path"></div>
                                <div class="journey-line"></div>
                                <div class="hero-glow-beam"></div>
                                <div class="grid gap-4">
                                    <div class="journey-node ml-auto max-w-[15rem] rounded-[1.6rem] p-4 text-white" data-parallax data-speed="0.08">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/55">Step One</p>
                                        <p class="mt-2 font-headline text-2xl font-extrabold">Book Your Slot</p>
                                        <p class="mt-2 text-sm leading-7 text-white/72">Choose a suitable date, time, and mode for your free mentorship session.</p>
                                    </div>
                                    <div class="journey-node max-w-[16rem] rounded-[1.6rem] p-4 text-white" data-parallax data-speed="0.14">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/55">Step Two</p>
                                        <p class="mt-2 font-headline text-2xl font-extrabold">Mentor Discussion</p>
                                        <p class="mt-2 text-sm leading-7 text-white/72">Talk about your doubts, present level, learning goal, and career concerns.</p>
                                    </div>
                                    <div class="journey-node ml-auto max-w-[17rem] rounded-[1.6rem] p-4 text-white" data-parallax data-speed="0.1">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/55">Step Three</p>
                                        <p class="mt-2 font-headline text-2xl font-extrabold">Move With Clarity</p>
                                        <p class="mt-2 text-sm leading-7 text-white/72">Leave with a clearer decision about the right class, roadmap, or next action.</p>
                                    </div>
                                </div>
                                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                    <div class="hero-mini-card rounded-[1.3rem] p-4 text-white" data-parallax data-speed="0.06">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/55">What We Help With</p>
                                        <p class="mt-2 text-sm leading-7 text-white/72">Course selection, career confusion, projects, placements, and skill planning.</p>
                                    </div>
                                    <div class="hero-mini-card rounded-[1.3rem] p-4 text-white" data-parallax data-speed="0.12">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/55">Who It Is For</p>
                                        <p class="mt-2 text-sm leading-7 text-white/72">Beginners, college students, freshers, and learners who need proper direction.</p>
                                    </div>
                                </div>

                                <div class="hero-anchor-card" data-parallax data-speed="0.18">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/55">Outcome</p>
                                    <p class="mt-3 font-headline text-[1.45rem] font-extrabold">From confusion to a clear action plan.</p>
                                    <p class="mt-3 text-sm leading-7 text-white/72">Students leave the mentorship session knowing what to do next instead of guessing.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="mentorship-flow" class="px-4 pb-20 md:px-6 md:pb-24">
            <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[0.92fr_1.08fr]">
                <div class="surface-card reveal rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-primary">How It Works</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold leading-tight text-on-surface md:text-[2.5rem]">
                        A simple mentorship process that is easy to follow.
                    </h2>
                    <p class="mt-4 text-sm leading-8 text-on-surface-variant">
                        First you book a slot, then you speak with a mentor, and finally you get guidance that matches your level, your goal, and your next learning decision.
                    </p>

                    <div class="mt-8 space-y-6">
                        @foreach ($mentorshipFlow as $item)
                            <div class="timeline-row">
                                <div class="timeline-step">{{ $item['step'] }}</div>
                                <div>
                                    <h3 class="font-headline text-[1.35rem] font-extrabold text-on-surface">{{ $item['title'] }}</h3>
                                    <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $item['copy'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="surface-card reveal stagger-1 rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-primary">Common Topics</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold leading-tight text-on-surface md:text-[2.4rem]">
                        What students usually discuss in mentorship.
                    </h2>

                    <div class="mt-8 overflow-hidden rounded-[1.7rem] bg-[linear-gradient(180deg,rgba(124,58,237,0.08),rgba(255,255,255,0.96))] p-5">
                        <img src="{{ asset('images/live projects.jpeg') }}" alt="Students in an online mentorship or guidance session" class="h-56 w-full rounded-[1.3rem] object-cover" />
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ($guidanceAreas as $topic)
                            <div class="rounded-[1.2rem] border border-outline/70 bg-white/88 px-4 py-3 text-sm font-semibold leading-6 text-on-surface shadow-[0_14px_28px_rgba(124,58,237,0.06)]">
                                {{ $topic }}
                            </div>
                        @endforeach
                    </div>

                    <div class="soft-strip mt-8 rounded-[1.6rem] p-5 md:p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Best For</p>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">
                            Students who want clarity before choosing a course, planning a roadmap, or making their next learning move.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="book-mentorship" class="px-4 pb-20 md:px-6 md:pb-24">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                    <div class="surface-card reveal rounded-[2rem] p-6 md:p-8">
                        <p class="text-xs font-bold uppercase tracking-[0.28em] text-primary">Book Appointment</p>
                        <h2 class="mt-4 font-headline text-3xl font-extrabold leading-tight text-on-surface md:text-[2.4rem]">
                            Share your details and reserve your free mentorship session.
                        </h2>
                        <p class="mt-4 text-sm leading-8 text-on-surface-variant">
                            Fill in this form so the team can schedule your mentorship discussion and understand what kind of guidance you need before the session.
                        </p>

                        <div class="mt-8 overflow-hidden rounded-[1.7rem] bg-[linear-gradient(180deg,rgba(124,58,237,0.08),rgba(255,255,255,0.96))] p-5">
                            <img src="{{ asset('images/live projects.jpeg') }}" alt="Online mentorship support session" class="h-56 w-full rounded-[1.3rem] object-cover" />
                        </div>

                        <div class="mt-6 grid gap-4">
                            <div class="rounded-[1.4rem] border border-outline/70 bg-white/88 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">After Booking</p>
                                <p class="mt-3 text-sm leading-7 text-on-surface-variant">We review your details, confirm the slot, and prepare the discussion around your goals.</p>
                            </div>
                            <div class="rounded-[1.4rem] border border-outline/70 bg-white/88 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">During The Session</p>
                                <p class="mt-3 text-sm leading-7 text-on-surface-variant">You discuss your doubts, ask questions, and get guidance on the best next step for you.</p>
                            </div>
                        </div>
                    </div>

                    <div class="surface-card reveal stagger-1 rounded-[2rem] p-6 md:p-8">
                        @if (session('status'))
                            <div class="success-strip mb-6 rounded-[1.4rem] px-5 py-4 text-sm font-medium text-emerald-800">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="error-strip mb-6 rounded-[1.4rem] px-5 py-4 text-sm text-rose-800">
                                <p class="font-bold">Please correct the form details and try again.</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="text-xs font-bold uppercase tracking-[0.28em] text-primary" id="talktomentor">Student Form</p>
                        <h2 class="mt-4 font-headline text-3xl font-extrabold leading-tight text-on-surface md:text-[2.2rem]">
                            Book your free mentorship appointment now.
                        </h2>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">
                            Choose your preferred date, share your learning goal, and tell us what kind of guidance you want from the mentor.
                        </p>

                        <form action="{{ route('home.contact.submit') }}" method="POST"  class="mt-8 space-y-5">
                            @csrf
                            <input type="hidden" name="topic" value="mentorship" />
                            <input type="hidden" name="message" value="{{ old('message', 'Free mentorship appointment booking from mentorship page.') }}" />

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="field-label">Full Name</label>
                                    <div class="field-shell">
                                        <input class="premium-input" type="text" name="name" placeholder="Your full name" value="{{ old('name') }}" required />
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Email Address</label>
                                    <div class="field-shell">
                                        <input class="premium-input" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="field-label">Phone Number</label>
                                    <div class="field-shell">
                                        <input class="premium-input" type="tel" name="phone" placeholder="+91 98765 43210" value="{{ old('phone') }}" />
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">City</label>
                                    <div class="field-shell">
                                        <input class="premium-input" type="text" name="city" placeholder="Your city" value="{{ old('city') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="field-label">Learner Type</label>
                                    <div class="field-shell">
                                        <select class="premium-select" name="learner_type">
                                            <option value="">Select learner type</option>
                                            <option value="School Student" @selected(old('learner_type') === 'School Student')>School Student</option>
                                            <option value="College Student" @selected(old('learner_type') === 'College Student')>College Student</option>
                                            <option value="Fresher" @selected(old('learner_type') === 'Fresher')>Fresher</option>
                                            <option value="Working Professional" @selected(old('learner_type') === 'Working Professional')>Working Professional</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Experience Level</label>
                                    <div class="field-shell">
                                        <select class="premium-select" name="experience_level">
                                            <option value="">Select experience level</option>
                                            <option value="Beginner" @selected(old('experience_level') === 'Beginner')>Beginner</option>
                                            <option value="Intermediate" @selected(old('experience_level') === 'Intermediate')>Intermediate</option>
                                            <option value="Advanced" @selected(old('experience_level') === 'Advanced')>Advanced</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="field-label">Preferred Date</label>
                                    <div class="field-shell">
                                        <input class="premium-input" type="date" name="preferred_date" value="{{ old('preferred_date') }}" />
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Preferred Time Slot</label>
                                    <div class="field-shell">
                                        <select class="premium-select" name="preferred_time_slot">
                                            <option value="">Select time slot</option>
                                            <option value="10:00 AM - 12:00 PM" @selected(old('preferred_time_slot') === '10:00 AM - 12:00 PM')>10:00 AM - 12:00 PM</option>
                                            <option value="12:00 PM - 2:00 PM" @selected(old('preferred_time_slot') === '12:00 PM - 2:00 PM')>12:00 PM - 2:00 PM</option>
                                            <option value="3:00 PM - 5:00 PM" @selected(old('preferred_time_slot') === '3:00 PM - 5:00 PM')>3:00 PM - 5:00 PM</option>
                                            <option value="6:00 PM - 8:00 PM" @selected(old('preferred_time_slot') === '6:00 PM - 8:00 PM')>6:00 PM - 8:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="field-label">Preferred Mode</label>
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <label class="choice-card">
                                            <input type="radio" name="preferred_mode" value="Online" @checked(old('preferred_mode', 'Online') === 'Online') />
                                            <span>Online</span>
                                        </label>
                                        <label class="choice-card">
                                            <input type="radio" name="preferred_mode" value="Offline" @checked(old('preferred_mode') === 'Offline') />
                                            <span>Offline</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Need Class Visit Guidance?</label>
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <label class="choice-card">
                                            <input type="radio" name="class_visit_preference" value="Yes" @checked(old('class_visit_preference', 'Yes') === 'Yes') />
                                            <span>Yes</span>
                                        </label>
                                        <label class="choice-card">
                                            <input type="radio" name="class_visit_preference" value="No" @checked(old('class_visit_preference') === 'No') />
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">College Or Company</label>
                                <div class="field-shell">
                                    <input class="premium-input" type="text" name="organization" placeholder="Your college or company name" value="{{ old('organization') }}" />
                                </div>
                            </div>

                            <div>
                                <label class="field-label">What Guidance Do You Need?</label>
                                <div class="field-shell">
                                    <textarea class="premium-textarea" name="goals" placeholder="Tell us what you want help with, such as class selection, career confusion, placements, projects, or technology direction.">{{ old('goals') }}</textarea>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Questions Or Notes</label>
                                <div class="field-shell">
                                    <textarea class="premium-textarea" name="questions" placeholder="Add any extra details the mentor should know before your appointment.">{{ old('questions') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="cta-button inline-flex w-full items-center justify-center gap-3 rounded-[1.4rem] bg-[linear-gradient(135deg,#6d28d9_0%,#8b5cf6_52%,#c084fc_100%)] px-6 py-4 text-sm font-bold text-white shadow-[0_20px_42px_rgba(124,58,237,0.28)]">
                                Book Free Mentorship Appointment
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <x-slot:scripts>
        <script>
            (function () {
                var enhancedRevealEls = document.querySelectorAll('.reveal-lift');
                if (enhancedRevealEls.length && 'IntersectionObserver' in window) {
                    var enhancedRevealObserver = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (!entry.isIntersecting) return;
                            entry.target.classList.add('visible');
                            enhancedRevealObserver.unobserve(entry.target);
                        });
                    }, { threshold: 0.18, rootMargin: '0px 0px -60px 0px' });

                    enhancedRevealEls.forEach(function (el) {
                        enhancedRevealObserver.observe(el);
                    });
                } else {
                    enhancedRevealEls.forEach(function (el) {
                        el.classList.add('visible');
                    });
                }

                var parallaxEls = document.querySelectorAll('[data-parallax]');
                var hero = document.querySelector('.mentorship-hero');
                if (!parallaxEls.length || !hero) return;

                var ticking = false;

                function updateParallax() {
                    var rect = hero.getBoundingClientRect();
                    var offset = Math.max(Math.min((window.innerHeight - rect.top) * 0.12, 42), -24);

                    parallaxEls.forEach(function (el) {
                        var speed = parseFloat(el.getAttribute('data-speed') || '0.1');
                        var shift = offset * speed;
                        el.style.transform = 'translate3d(0,' + shift.toFixed(2) + 'px,0)';
                    });

                    ticking = false;
                }

                function requestParallax() {
                    if (ticking) return;
                    ticking = true;
                    window.requestAnimationFrame(updateParallax);
                }

                updateParallax();
                window.addEventListener('scroll', requestParallax, { passive: true });
                window.addEventListener('resize', requestParallax);
            })();
        </script>
    </x-slot:scripts>
</x-home.marketing-layout>
