@php
    $featuredTrack = $careerTracks->first();
    $allSkills = $careerTracks
        ->pluck('skills')
        ->flatten()
        ->unique()
        ->values();
    $startingPrice = $careerTracks->min('price');
    $learningPoints = [
        [
            'title' => 'Choose by role, not by confusion',
            'description' => 'Each path is arranged around a job direction so learners know what to study next and why it matters.',
        ],
        [
            'title' => 'Build projects while learning',
            'description' => 'The roadmap is designed to turn theory into visible portfolio work, not just notes and recorded classes.',
        ],
        [
            'title' => 'Move with placement intent',
            'description' => 'Practice, review, and mentor-led guidance keep the path aligned with actual hiring expectations.',
        ],
    ];
    $pagePrinciples = [
        ['label' => 'Curated tracks', 'value' => 'Not random course lists'],
        ['label' => 'Mentor-guided', 'value' => 'Clear next-step direction'],
        ['label' => 'Portfolio-backed', 'value' => 'Projects that show readiness'],
    ];
@endphp

<x-home.marketing-layout title="Career Paths | CodeInYourself">
    
    <x-slot:head>
        <style>
            .career-premium-shell .premium-tag {
                color: #8a6a18;
                letter-spacing: 0.24em;
            }

            .career-premium-shell .premium-surface {
                border: 1px solid rgba(207, 180, 112, 0.22);
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.96), rgba(252,247,239,0.92));
                box-shadow:
                    0 24px 70px rgba(57, 25, 90, 0.10),
                    inset 0 1px 0 rgba(255,255,255,0.65);
            }

            .career-premium-shell .premium-line {
                border-color: rgba(207, 180, 112, 0.18);
            }

            .career-premium-shell .premium-pill {
                border: 1px solid rgba(207, 180, 112, 0.24);
                background: rgba(255, 248, 233, 0.9);
                color: #5d4720;
            }

            .career-premium-shell .premium-dark {
                border: 1px solid rgba(255,255,255,0.10);
                background:
                    radial-gradient(circle at top right, rgba(248, 231, 179, 0.12), transparent 22%),
                    linear-gradient(180deg, rgba(26, 10, 43, 0.96), rgba(57, 21, 91, 0.95));
                box-shadow: 0 28px 80px rgba(29, 8, 54, 0.28);
            }

            .career-premium-shell .premium-card-quiet {
                border: 1px solid rgba(207, 180, 112, 0.18);
                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(250,244,236,0.9));
            }

            .career-premium-shell .track-card {
                border: 1px solid rgba(207, 180, 112, 0.18);
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.97), rgba(251,246,239,0.94));
                box-shadow: 0 22px 56px rgba(45, 18, 73, 0.10);
            }

            .career-premium-shell .track-media {
                position: relative;
                overflow: hidden;
                aspect-ratio: 16 / 10;
            }

            .career-premium-shell .track-media img {
                width: 100%;
                height: 100%;
                object-fit: var(--track-image-fit, cover);
                object-position: var(--track-image-position, center);
                transition: transform 0.6s ease;
            }

            .career-premium-shell .track-card:hover .track-media img {
                transform: scale(1.05);
            }

            .career-premium-shell .track-meta {
                border: 1px solid rgba(207, 180, 112, 0.16);
                background: rgba(255, 250, 240, 0.88);
            }
        </style>
    </x-slot:head>
    <main class="career-premium-shell pb-24 pt-5">
        <section class="career-hero relative overflow-hidden px-4 pb-8 pt-4 sm:px-6 md:px-8">
            <div class="absolute inset-x-0 top-0 h-full bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.12),transparent_24%),radial-gradient(circle_at_82%_18%,rgba(251,191,36,0.14),transparent_18%),radial-gradient(circle_at_78%_78%,rgba(216,180,254,0.18),transparent_24%),linear-gradient(135deg,#13061f_0%,#261038_38%,#5d239d_72%,#9b63f6_100%)]"></div>
            <div class="absolute inset-0 opacity-45" style="background-image: linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 5.2rem 5.2rem; mask-image: linear-gradient(180deg, rgba(0,0,0,0.75), rgba(0,0,0,0.22));"></div>
            <div class="absolute left-0 top-10 h-48 w-48 rounded-full bg-white/8 blur-3xl"></div>
            <div class="absolute bottom-4 right-8 h-64 w-64 rounded-full bg-[#f5d0fe]/16 blur-3xl"></div>
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-b from-transparent to-[#f7f0ff]"></div>

            <div class="relative mx-auto max-w-7xl text-white">
                <div class="reveal grid gap-8 py-6 xl:grid-cols-[minmax(0,1.12fr)_minmax(280px,0.82fr)] xl:items-center lg:py-8">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/8 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/78 backdrop-blur-sm">
                            <span class="h-2 w-2 rounded-full bg-[#facc15]"></span>
                            Career Paths
                        </span>
                        <h1 class="mt-4 max-w-4xl font-headline text-[2.2rem] font-extrabold leading-[1] sm:text-[2.5rem] md:text-[3rem] xl:text-[3.7rem]">
                            Career growth should feel
                            <span class="block text-[#f8e7b3]">guided, professional, and role-focused.</span>
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-white/78 md:text-[15px]">
                            Explore structured learning paths in analytics, development, and AI with strong project work and mentor-backed guidance from day one.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-primary">
                                Book Career Guidance
                                <span class="material-symbols-outlined text-[18px]">north_east</span>
                            </a>
                            <a href="#paths-grid" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white/10 px-6 py-4 text-sm font-bold text-white backdrop-blur-sm">
                                Explore Paths
                                <span class="material-symbols-outlined text-[18px]">south</span>
                            </a>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-[1.45rem] border border-white/10 bg-black/10 p-4 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-white/54">Available paths</p>
                                <p class="mt-2 font-headline text-[1.35rem] font-extrabold text-white">{{ number_format($careerTracks->count()) }}</p>
                                <p class="mt-2 text-sm leading-6 text-white/68">Focused roadmaps built around specific job outcomes.</p>
                            </div>
                            <div class="rounded-[1.45rem] border border-white/10 bg-black/10 p-4 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-white/54">Starting investment</p>
                                <p class="mt-2 font-headline text-[1.35rem] font-extrabold text-white">Rs. {{ number_format($startingPrice, 0) }}</p>
                                <p class="mt-2 text-sm leading-6 text-white/68">Clear pricing for learners who want direction without guesswork.</p>
                            </div>
                            <div class="rounded-[1.45rem] border border-white/10 bg-black/10 p-4 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-white/54">Learning model</p>
                                <p class="mt-2 font-headline text-[1.35rem] font-extrabold text-white">Projects first</p>
                                <p class="mt-2 text-sm leading-6 text-white/68">Skills, portfolio proof, and placement-minded preparation together.</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            @foreach ($pagePrinciples as $item)
                                <div class="rounded-[1.2rem] border border-white/10 bg-black/10 px-4 py-3 backdrop-blur-sm">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/46">{{ $item['label'] }}</p>
                                    <p class="mt-2 text-sm font-semibold text-white/88">{{ $item['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative lg:pl-2">
                        <div class="relative overflow-hidden rounded-[1.7rem] border border-white/14 bg-[linear-gradient(180deg,rgba(255,255,255,0.18),rgba(255,255,255,0.08))] p-5 shadow-hero backdrop-blur-md">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_26%),radial-gradient(circle_at_bottom_left,rgba(250,204,21,0.1),transparent_24%),linear-gradient(180deg,transparent,rgba(8,2,21,0.18))]"></div>
                            <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-white/8 blur-3xl"></div>

                            <div class="relative flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#f8e7b3]/82">Featured path</p>
                                    <h2 class="mt-2 max-w-xs font-headline text-[1.35rem] font-extrabold leading-tight sm:text-[1.55rem]">
                                        {{ $featuredTrack['title'] }}
                                    </h2>
                                </div>
                                <span class="rounded-full border border-white/10 bg-black/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white/80">
                                    {{ $featuredTrack['duration'] }}
                                </span>
                            </div>

                            <p class="relative mt-3 max-w-md text-sm leading-6 text-white/74">
                                {{ $featuredTrack['subtitle'] }}
                            </p>

                            <div class="relative mt-4 flex flex-wrap gap-2">
                                @foreach ($featuredTrack['skills'] as $skill)
                                    <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[11px] font-semibold text-white/88">{{ $skill }}</span>
                                @endforeach
                            </div>

                            <div class="relative mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-[1.2rem] border border-white/10 bg-[#12071f]/34 p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">Format</p>
                                    <p class="mt-2 font-headline text-[1rem] font-extrabold text-white">{{ $featuredTrack['mode'] }}</p>
                                    <p class="mt-2 text-xs leading-5 text-white/66">Designed for learners who want flexibility with structure.</p>
                                </div>
                                <div class="rounded-[1.2rem] border border-white/10 bg-[#12071f]/34 p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">Access</p>
                                    <p class="mt-2 font-headline text-[1rem] font-extrabold text-white">{{ $featuredTrack['access'] }}</p>
                                    <p class="mt-2 text-xs leading-5 text-white/66">Return anytime to revise, rebuild, and sharpen your work.</p>
                                </div>
                            </div>

                            <div class="relative mt-5 flex flex-col gap-3 border-t border-white/12 pt-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="rounded-[1.15rem] bg-white/8 px-4 py-2.5">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">Starting at</p>
                                    <p class="mt-1 font-headline text-[1.35rem] font-extrabold text-white">Rs. {{ number_format($featuredTrack['price'], 0) }}</p>
                                </div>
                                <a href="{{ $featuredTrack['details_url'] }}"
                                   @guest
                                   data-auth-required
                                   data-auth-redirect="{{ $featuredTrack['details_url'] }}"
                                   data-auth-title="Login to access roadmap details"
                                   data-auth-copy="Sign in first to view the full career roadmap and detailed curriculum."
                                   @endguest
                                   class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-bold text-primary">
                                    View Roadmap
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>

                            <div class="relative mt-4 grid gap-3 border-t border-white/10 pt-4 text-xs text-white/70 sm:grid-cols-3">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/48">Outcome</p>
                                    <p class="mt-2">Role-oriented roadmap</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/48">Style</p>
                                    <p class="mt-2">Structured practical learning</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/48">Goal</p>
                                    <p class="mt-2">Portfolio and interview readiness</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="premium-surface reveal rounded-[2rem] p-6 md:p-8">
                    <p class="premium-tag text-[11px] font-bold uppercase">Path philosophy</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">A clear page for important career decisions.</h2>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-on-surface-variant">
                        This page focuses on clarity, trust, and direction by showing what matters most: the role, the tools, the structure, and the value behind each path.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach ($learningPoints as $index => $point)
                        <article class="premium-card-quiet premium-card reveal stagger-{{ ($index % 4) + 1 }} rounded-[1.8rem] p-6">
                            <p class="premium-tag text-[11px] font-bold uppercase">0{{ $index + 1 }}</p>
                            <h3 class="mt-4 font-headline text-2xl font-extrabold text-on-surface">{{ $point['title'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $point['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="paths-grid" class="mx-auto max-w-7xl px-4 py-4 sm:px-6">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="reveal">
                    <p class="premium-tag text-[11px] font-bold uppercase">All paths</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Role-focused tracks built to feel complete.</h2>
                </div>
                <p class="reveal max-w-2xl text-sm leading-7 text-on-surface-variant">
                    Every track includes a clear duration, practical tools, a defined learning mode, and a visible entry point for learners who want a roadmap instead of more noise.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($careerTracks as $index => $track)
                    <article class="track-card premium-card reveal stagger-{{ ($index % 4) + 1 }} overflow-hidden rounded-[1.9rem]">
                        <div class="track-media" style="--track-image-fit: {{ $track['thumbnail_fit'] ?? 'cover' }}; --track-image-position: {{ $track['thumbnail_position'] ?? 'center' }};">
                            <img alt="{{ $track['title'] }}" src="{{ $track['thumbnail'] }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#16071f]/82 via-[#16071f]/18 to-transparent"></div>
                            <div class="absolute bottom-5 left-5 right-5 flex items-end justify-between gap-4">
                                <span class="rounded-full bg-[#fff5dc] px-3 py-1.5 text-[11px] font-bold uppercase tracking-[0.18em] text-[#6e5317]">{{ $track['duration'] }}</span>
                                <span class="rounded-full border border-white/12 bg-black/25 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur-sm">{{ $track['mode'] }}</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h2 class="font-headline text-2xl font-extrabold text-on-surface">{{ $track['title'] }}</h2>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $track['subtitle'] }}</p>

                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($track['skills'] as $skill)
                                    <span class="premium-pill rounded-full px-3 py-2 text-xs font-semibold">{{ $skill }}</span>
                                @endforeach
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <div class="track-meta rounded-[1.2rem] p-4">
                                    <p class="premium-tag text-[11px] font-bold uppercase">Access</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $track['access'] }}</p>
                                </div>
                                <div class="track-meta rounded-[1.2rem] p-4">
                                    <p class="premium-tag text-[11px] font-bold uppercase">Best for</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ implode(' / ', collect($track['skills'])->take(2)->all()) }}</p>
                                </div>
                            </div>

                            <div class="premium-line mt-6 flex items-center justify-between gap-4 border-t pt-5">
                                <div>
                                    <p class="premium-tag text-[11px] font-bold uppercase">Price</p>
                                    <p class="mt-1 font-headline text-2xl font-extrabold text-[#6a39a8]">Rs. {{ number_format($track['price'], 0) }}</p>
                                </div>
                                <a class="cta-button inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#2a112f_0%,#7040aa_52%,#c6a34d_100%)] px-5 py-3 text-[12px] font-bold text-white"
                                   href="{{ $track['details_url'] }}"
                                   @guest
                                   data-auth-required
                                   data-auth-redirect="{{ $track['details_url'] }}"
                                   data-auth-title="Login to access roadmap details"
                                   data-auth-copy="Sign in first to view the full career roadmap and detailed curriculum."
                                   @endguest>
                                    View Roadmap
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[1fr_1.05fr]">
                <div class="premium-surface reveal rounded-[2rem] p-6 md:p-8">
                    <p class="premium-tag text-[11px] font-bold uppercase">What learners need</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">A path that reduces confusion and builds confidence.</h2>
                    <div class="mt-8 space-y-4">
                        <div class="premium-card-quiet rounded-[1.5rem] p-5">
                            <p class="font-headline text-xl font-extrabold text-on-surface">Step 1. Build fundamentals properly</p>
                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">Start with the tools and concepts that remove confusion early, so your learning feels steady instead of scattered.</p>
                        </div>
                        <div class="premium-card-quiet rounded-[1.5rem] p-5">
                            <p class="font-headline text-xl font-extrabold text-on-surface">Step 2. Practice with real tools</p>
                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">Use the same skill stack employers expect to see in portfolios, assignments, and project walkthroughs.</p>
                        </div>
                        <div class="premium-card-quiet rounded-[1.5rem] p-5">
                            <p class="font-headline text-xl font-extrabold text-on-surface">Step 3. Move toward interviews</p>
                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">Turn your learning into visible proof with projects, review cycles, and placement-oriented preparation support.</p>
                        </div>
                    </div>
                </div>

                <div class="premium-dark reveal rounded-[2rem] p-6 text-white md:p-8">
                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-white/58">Skill coverage</p>
                    <h2 class="mt-3 max-w-lg font-headline text-3xl font-extrabold md:text-4xl">A stronger stack across analytics, development, and AI.</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-white/72">
                        These are the tools and capabilities learners repeatedly see across high-value career tracks, which makes the page feel more credible and better connected to outcomes.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @foreach ($allSkills as $index => $skill)
                            <span class="rounded-full border border-white/12 bg-white/8 px-4 py-3 text-sm font-semibold text-[#f8e7b3] backdrop-blur-sm">{{ $skill }}</span>
                        @endforeach
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/8 p-5 backdrop-blur-sm">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/54">Analytics</p>
                            <p class="mt-3 font-headline text-2xl font-extrabold text-white">Dashboards</p>
                            <p class="mt-2 text-sm leading-6 text-white/68">Excel, SQL, reporting, and decision-friendly visuals.</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/8 p-5 backdrop-blur-sm">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/54">Development</p>
                            <p class="mt-3 font-headline text-2xl font-extrabold text-white">Products</p>
                            <p class="mt-2 text-sm leading-6 text-white/68">Frontend, backend, APIs, databases, and deployment.</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/8 p-5 backdrop-blur-sm">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/54">AI</p>
                            <p class="mt-3 font-headline text-2xl font-extrabold text-white">Workflows</p>
                            <p class="mt-2 text-sm leading-6 text-white/68">Python, ML, GenAI, and production-style experiments.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6">
            <div class="premium-surface reveal rounded-[2rem] p-6 md:p-8 lg:p-10">
                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
                    <div>
                        <p class="premium-tag text-[11px] font-bold uppercase">Decision support</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Choose the path that fits your background and goal.</h2>
                        <p class="mt-4 max-w-xl text-sm leading-7 text-on-surface-variant">
                            If you are deciding between data, full stack, or AI, our team can help you compare direction, timeline, and fit before you commit.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row lg:justify-end">
                        <a class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#281126_0%,#6d3aa7_52%,#c8a34b_100%)] px-6 py-4 text-sm font-bold uppercase tracking-[0.16em] text-white" href="/mentorship#talktomentor">
                            Speak to Mentor
                            <span class="material-symbols-outlined text-[18px]">call_made</span>
                        </a>
                        <a class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl border border-[rgba(207,180,112,0.24)] bg-white px-6 py-4 text-sm font-bold uppercase tracking-[0.16em] text-on-surface" href="{{ route('home.courses') }}">
                            Browse Courses
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
