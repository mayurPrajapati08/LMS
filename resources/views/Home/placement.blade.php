@php
    $placementImagePool = [
        'https://randomuser.me/api/portraits/women/44.jpg',
        'https://randomuser.me/api/portraits/men/32.jpg',
        'https://randomuser.me/api/portraits/women/68.jpg',
        'https://randomuser.me/api/portraits/men/75.jpg',
    ];

    $placementStories = collect($placementStories ?? []);
    $placementHeroStories = collect($placementHeroStories ?? [])->take(7);

    if ($placementHeroStories->isEmpty()) {
        $placementHeroStories = $placementStories->take(6);
    }

    $placementHeroStories = $placementHeroStories->values()->map(function ($student, $index) use ($placementImagePool) {
        $student['avatar'] = $student['avatar'] ?? $placementImagePool[$index % count($placementImagePool)];
        $student['company'] = $student['company'] ?? 'Hiring Partner';
        $student['role'] = $student['role'] ?? 'Career-ready learner';
        $student['package'] = $student['package'] ?? 'Growth path';

        return $student;
    });

    $studentProfiles = $placementStories->take(9)->values()->map(function ($student, $index) use ($placementImagePool) {
        $student['avatar'] = $student['avatar'] ?? $placementImagePool[$index % count($placementImagePool)];
        $student['company'] = $student['company'] ?? 'Hiring Partner';
        $student['role'] = $student['role'] ?? 'Placed learner';
        $student['package'] = $student['package'] ?? 'Career growth';
        $student['shared_at'] = $student['shared_at'] ?? now()->format('M Y');

        return $student;
    });

    $placementSteps = [
        ['title' => 'Skill Build', 'copy' => 'Students train with practical assignments and role-focused roadmap clarity.'],
        ['title' => 'Profile Polish', 'copy' => 'Resumes, projects, and portfolio stories get stronger through mentor review.'],
        ['title' => 'Interview Ready', 'copy' => 'Mock sessions and guidance help learners explain real work with confidence.'],
    ];
@endphp

<x-home.marketing-layout title="Placements | CodeInYourself">
    
    <x-slot:head>
        <style>
            .placements-experience {
                background:
                    radial-gradient(circle at top left, rgba(255,255,255,0.06), transparent 22%),
                    linear-gradient(180deg, #f8f5ff 0%, #fff8f1 48%, #f7fbff 100%);
            }
            .placements-hero {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(circle at 12% 16%, rgba(255,255,255,0.12), transparent 18%),
                    radial-gradient(circle at 82% 18%, rgba(250,204,21,0.16), transparent 18%),
                    linear-gradient(135deg, #140622 0%, #2a0f4c 42%, #51349d 100%);
            }
            .placements-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
                background-size: 72px 72px;
                mask-image: radial-gradient(circle at center, black 34%, transparent 82%);
                pointer-events: none;
            }
            .placement-glass {
                border: 1px solid rgba(255,255,255,0.12);
                background: linear-gradient(180deg, rgba(255,255,255,0.11), rgba(255,255,255,0.04));
                backdrop-filter: blur(14px);
            }
            .hero-stack-shell {
                position: relative;
                min-height: 38rem;
                padding-top: .25rem;
                perspective: 1200px;
            }
            .hero-stack-card {
                position: absolute;
                left: 0;
                right: 0;
                margin: auto;
                width: min(100%, 27rem);
                min-height: 34rem;
                border-radius: 2rem;
                overflow: hidden;
                border: 1px solid rgba(255,255,255,0.46);
                background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(252,248,255,0.97));
                box-shadow: 0 32px 80px rgba(11, 5, 25, 0.28);
                transform-origin: center center;
                cursor: pointer;
                transition: transform .8s cubic-bezier(.16,1,.3,1), opacity .8s ease, filter .8s ease, box-shadow .8s ease;
            }
            .hero-stack-card::after {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: inherit;
                background: linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,0));
                pointer-events: none;
                transition: background .8s ease, opacity .8s ease;
            }
            .hero-stack-card.is-leaving {
                transform: translateX(-108%) rotate(-8deg) scale(.96) !important;
                opacity: 0;
                z-index: 7 !important;
            }
            .hero-stack-card[data-position="0"] {
                transform: translateX(0) translateY(0) scale(1);
                opacity: 1;
                z-index: 5;
                filter: none;
                box-shadow: 0 36px 86px rgba(11, 5, 25, 0.28);
            }
            .hero-stack-card[data-position="1"] {
                transform: translateX(1rem) translateY(1rem) scale(.97);
                opacity: .86;
                z-index: 4;
                filter: brightness(.96);
            }
            .hero-stack-card[data-position="2"] {
                transform: translateX(1.8rem) translateY(2rem) scale(.94);
                opacity: .64;
                z-index: 3;
                filter: brightness(.93);
            }
            .hero-stack-card[data-position="3"] {
                transform: translateX(2.5rem) translateY(3rem) scale(.91);
                opacity: .4;
                z-index: 2;
                filter: brightness(.9);
            }
            .hero-stack-card[data-position="4"] {
                transform: translateX(3rem) translateY(3.8rem) scale(.88);
                opacity: .2;
                z-index: 1;
                filter: brightness(.88);
            }
            .hero-stack-card[data-position="1"]::after {
                background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.18));
            }
            .hero-stack-card[data-position="2"]::after {
                background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.28));
            }
            .hero-stack-card[data-position="3"]::after,
            .hero-stack-card[data-position="4"]::after {
                background: linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.36));
            }
            .hero-card-layout {
                display: grid;
                grid-template-columns: 1fr;
                min-height: 34rem;
            }
            .hero-card-media {
                position: relative;
                background: linear-gradient(160deg, #6d28d9 0%, #8b5cf6 56%, #d946ef 100%);
                padding: 1rem;
            }
            .hero-card-media::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at top right, rgba(255,255,255,0.25), transparent 24%),
                    linear-gradient(45deg, rgba(255,255,255,0.14), transparent 32%);
            }
            .hero-card-media-frame {
                position: relative;
                z-index: 1;
                height: 15rem;
                overflow: hidden;
                border-radius: 1.45rem;
                background: rgba(255,255,255,0.14);
            }
            .hero-card-media-frame img,
            .hero-card-media-frame video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center 12%;
                display: block;
            }
            .hero-card-content {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 1.1rem;
                min-height: 19rem;
                padding: 1.35rem 1.4rem 1.45rem;
                color: #1f2937;
                position: relative;
                z-index: 1;
            }
            .hero-card-copy {
                display: -webkit-box;
                line-clamp: 4;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .hero-card-heading {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: .9rem;
            }
            .hero-card-meta {
                display: flex;
                flex-wrap: wrap;
                gap: .6rem;
            }
            .hero-card-metric {
                display: inline-flex;
                align-items: center;
                gap: .35rem;
                color: #6b7280;
                font-size: .72rem;
                font-weight: 800;
                letter-spacing: .08em;
                text-transform: uppercase;
            }
            .hero-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }
            .hero-card-avatar-chip {
                display: inline-flex;
                align-items: center;
                gap: .75rem;
                border-radius: 9999px;
                background: #f5efff;
                padding: .45rem .9rem .45rem .45rem;
            }
            .hero-card-avatar-chip img {
                height: 2.5rem;
                width: 2.5rem;
                border-radius: 9999px;
                object-fit: cover;
                object-position: center 12%;
                border: 2px solid rgba(255,255,255,0.9);
                box-shadow: 0 8px 18px rgba(109, 40, 217, 0.18);
            }
            .placement-path-card {
                border: 1px solid rgba(224, 213, 236, 0.9);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,245,252,0.95));
                box-shadow: 0 18px 44px rgba(57, 30, 86, 0.08);
            }
            .student-grid-card {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(228, 218, 238, 0.88);
                background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(252,248,253,0.96));
                box-shadow: 0 20px 52px rgba(57, 30, 86, 0.09);
                transition: transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s ease;
            }
            .student-grid-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 28px 72px rgba(57, 30, 86, 0.14);
            }
            .student-grid-card::after {
                content: "";
                position: absolute;
                inset: auto auto -20% -10%;
                width: 10rem;
                height: 10rem;
                border-radius: 9999px;
                background: radial-gradient(circle, rgba(250,204,21,0.14), transparent 72%);
                pointer-events: none;
            }
            .student-spotlight-media {
                aspect-ratio: 4 / 5;
                min-height: 19rem;
            }
            .student-spotlight-media img,
            .student-spotlight-media video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center 10%;
                display: block;
            }
            @media (max-width: 767px) {
                .hero-stack-shell { min-height: 33rem; }
                .hero-stack-card { width: min(100%, 20.25rem); min-height: 29.5rem; border-radius: 1.5rem; }
                .hero-card-layout { min-height: 29.5rem; }
                .hero-card-media { padding: .8rem; }
                .hero-card-media-frame { height: 11rem; border-radius: 1.2rem; }
                .hero-card-content { min-height: 17rem; padding: 1rem .95rem 1rem; }
                .hero-stack-card[data-position="1"] { transform: translateX(.7rem) translateY(.8rem) scale(.97); }
                .hero-stack-card[data-position="2"] { transform: translateX(1.3rem) translateY(1.6rem) scale(.94); }
                .hero-stack-card[data-position="3"] { transform: translateX(1.8rem) translateY(2.3rem) scale(.91); }
                .hero-stack-card[data-position="4"] { transform: translateX(2.2rem) translateY(3rem) scale(.88); }
                .hero-card-heading { flex-direction: column; align-items: flex-start; }
                .hero-card-footer { flex-direction: column; align-items: flex-start; }
                .student-spotlight-media { min-height: 16rem; }
            }
            @media (min-width: 768px) and (max-width: 1023px) {
                .hero-stack-shell { min-height: 36rem; }
                .hero-stack-card { width: min(100%, 23rem); min-height: 31rem; }
                .hero-card-layout { min-height: 31rem; }
            }
        </style>
    </x-slot:head>

    <main class="placements-experience overflow-x-hidden pb-24 pt-5">
        <section class="relative left-1/2 right-1/2 w-screen -translate-x-1/2">
            <div class="placements-hero px-5 pb-20 pt-10 text-white sm:px-8 lg:px-10">
                <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[minmax(0,1.02fr)_minmax(340px,0.98fr)] lg:items-center">
                    <div class="relative z-10">
                        <span class="placement-glass inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/84">
                            <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                            Placement Success
                        </span>
                        <h1 class="mt-6 max-w-4xl font-headline text-[2.3rem] font-extrabold leading-[0.95] sm:text-[3rem] lg:text-[3.2rem]">
                            Student outcomes should feel
                            <span class="block text-[#c6fff6]">credible, premium, and alive on the page.</span>
                        </h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-white/74">
                            This placement page now puts student stories first with a stronger visual hierarchy, smoother movement, and a hero stack that keeps rotating featured learners in front every few seconds.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('home.courses') }}" class="rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-[#2a0f4c]">Explore Training Programs</a>
                            <a href="{{ route('home.contact', ['topic' => 'mentorship', 'subject' => 'Placement guidance']) }}" class="placement-glass rounded-2xl px-6 py-3.5 text-sm font-bold text-white/88">Book Guidance</a>
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            <div class="placement-glass rounded-[1.6rem] p-5">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Learners</p>
                                <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['students']) }}+</p>
                            </div>
                            <div class="placement-glass rounded-[1.6rem] p-5">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Certificates</p>
                                <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['certificates']) }}+</p>
                            </div>
                            <div class="placement-glass rounded-[1.6rem] p-5">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Average Rating</p>
                                <p class="mt-3 font-headline text-3xl font-extrabold text-white">{{ number_format($siteStats['avg_rating'], 1) }}/5</p>
                            </div>
                        </div>
                    </div>

                    <div class="hero-stack-shell relative z-10" id="placementHeroStack" aria-label="Placement hero student cards">
                        @foreach ($placementHeroStories as $index => $student)
                            <article class="hero-stack-card" data-stack-card data-position="{{ min($index, 4) }}" tabindex="0" role="button" aria-label="Rotate placement hero card">
                                <div class="hero-card-layout">
                                    <div class="hero-card-media">
                                        <div class="hero-card-media-frame">
                                            @if (($student['media_type'] ?? 'image') === 'video')
                                                <video autoplay loop muted playsinline preload="metadata">
                                                    <source src="{{ $student['avatar'] }}" />
                                                </video>
                                            @else
                                                <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="hero-card-content">
                                        <div>
                                            <div class="hero-card-heading">
                                                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">Placement Spotlight</p>
                                                <span class="rounded-full bg-primary/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-primary">{{ $student['company'] }}</span>
                                            </div>
                                            <h2 class="mt-4 font-headline text-[1.9rem] font-extrabold leading-tight text-slate-900">{{ $student['name'] }}</h2>
                                            <p class="mt-3 text-base font-semibold text-slate-700">{{ $student['role'] }}</p>
                                            <p class="hero-card-copy mt-2 text-sm leading-7 text-slate-500">{{ \Illuminate\Support\Str::limit($student['comment'], 170) }}</p>
                                        </div>
                                        <div>
                                            <div class="hero-card-meta">
                                                <span class="hero-card-metric"><span class="material-symbols-outlined text-[16px]">school</span>{{ $student['course'] }}</span>
                                                <span class="hero-card-metric"><span class="material-symbols-outlined text-[16px]">workspace_premium</span>{{ $student['package'] }}</span>
                                            </div>
                                            <div class="hero-card-footer mt-6">
                                                <div class="hero-card-avatar-chip">
                                                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" />
                                                    <div>
                                                        <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Placed at</p>
                                                        <p class="text-sm font-bold text-slate-800">{{ $student['company'] }}</p>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center gap-2 text-sm font-bold text-primary">Next card <span class="material-symbols-outlined text-[18px]">west</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
            <div class="placement-path-card rounded-[2rem] p-6 md:p-7">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Placement Flow</p>
                        <h2 class="mt-2 font-headline text-3xl font-extrabold text-on-surface">A sharper way to explain how learners move toward real hiring outcomes.</h2>
                    </div>
                    <p class="max-w-2xl text-sm leading-7 text-on-surface-variant">The page now walks through preparation, profile-building, and interview readiness before moving into student outcomes, so the story feels intentional instead of random.</p>
                </div>
                <div class="mt-8 grid gap-5 lg:grid-cols-3">
                    @foreach ($placementSteps as $step)
                        <div class="rounded-[1.6rem] bg-surface-soft px-5 py-6">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary">Stage {{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}</p>
                            <h3 class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $step['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Student Spotlight</p>
                    <h2 class="mt-2 font-headline text-3xl font-extrabold text-on-surface">Redesigned student cards with clearer hierarchy and better credibility.</h2>
                </div>
                <p class="max-w-2xl text-sm leading-7 text-on-surface-variant">Each card now carries stronger visual balance: outcome, program, role, company, and the learner quote are easier to scan without the section feeling flat.</p>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ($studentProfiles as $student)
                    <article class="student-grid-card flex h-full flex-col rounded-[1.9rem]">
                        <div class="student-spotlight-media relative overflow-hidden rounded-t-[1.9rem]">
                            @if (($student['media_type'] ?? 'image') === 'video')
                                <video autoplay loop muted playsinline preload="metadata">
                                    <source src="{{ $student['avatar'] }}" />
                                </video>
                            @else
                                <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" />
                            @endif
                            <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-[#140622]/40 via-transparent to-transparent"></div>
                            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                <span class="rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#2a0f4c]">{{ $student['company'] }}</span>
                                <span class="rounded-full bg-[#2a0f4c]/82 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-white">{{ $student['shared_at'] }}</span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary">Placed Student</p>
                                    <h3 class="mt-2 font-headline text-[1.7rem] font-extrabold leading-tight text-on-surface">{{ $student['name'] }}</h3>
                                </div>
                                <span class="rounded-full bg-primary/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-primary">{{ $student['package'] }}</span>
                            </div>

                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-[1.1rem] bg-surface-soft px-4 py-3.5 text-sm font-medium text-on-surface-variant">{{ $student['company'] }}</div>
                                <div class="rounded-[1.1rem] bg-surface-soft px-4 py-3.5 text-sm font-medium text-on-surface-variant">{{ $student['role'] }}</div>
                            </div>

                            <p class="mt-5 text-sm leading-7 text-on-surface-variant">"{{ \Illuminate\Support\Str::limit($student['comment'], 180) }}"</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <script>
            (function () {
                var stack = document.getElementById('placementHeroStack');
                if (!stack) {
                    return;
                }

                var cards = Array.prototype.slice.call(stack.querySelectorAll('[data-stack-card]'));
                if (cards.length <= 1) {
                    return;
                }

                function render() {
                    cards.forEach(function (card, index) {
                        card.setAttribute('data-position', Math.min(index, 4));
                    });
                }

                var isAnimating = false;

                function rotateCards() {
                    if (isAnimating) {
                        return;
                    }

                    isAnimating = true;
                    var activeCard = cards[0];
                    activeCard.classList.add('is-leaving');

                    window.setTimeout(function () {
                        activeCard.classList.remove('is-leaving');
                        cards.push(cards.shift());
                        render();
                        isAnimating = false;
                    }, 200);
                }

                stack.addEventListener('click', rotateCards);
                stack.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        rotateCards();
                    }
                });

                setInterval(rotateCards, 3000);
            }());
        </script>
    </main>
</x-home.marketing-layout>
