@php
    $aboutPoints = [
        [
            'icon' => 'school',
            'title' => 'Practical Learning',
            'copy' => 'Classes stay focused on projects, clarity, and real skill growth.',
        ],
        [
            'icon' => 'groups',
            'title' => 'Mentor Support',
            'copy' => 'Learners get guidance that feels personal, direct, and useful.',
        ],
        [
            'icon' => 'rocket_launch',
            'title' => 'Career Direction',
            'copy' => 'Training is designed to help students move toward strong outcomes.',
        ],
    ];

    $aboutMoments = [
        ['label' => 'Learn', 'title' => 'Structured classes', 'copy' => 'Clear teaching, guided practice, and focused progress.'],
        ['label' => 'Build', 'title' => 'Portfolio-ready work', 'copy' => 'Projects and tasks that help learners show what they can do.'],
        ['label' => 'Grow', 'title' => 'Career confidence', 'copy' => 'Reviews, certificates, and mentor support that keep momentum high.'],
    ];

    $aboutStats = [
        ['label' => 'Certificates', 'value' => number_format($siteStats['certificates']).'+'],
        ['label' => 'Student Reviews', 'value' => number_format($siteStats['reviews_count']).'+'],
        ['label' => 'Average Rating', 'value' => number_format($siteStats['avg_rating'], 1).'/5'],
    ];

    $achievementGalleryItems = collect($achievementGallery ?? [])
        ->sortBy(fn ($item) => sprintf(
            '%05d|%s|%s',
            (int) ($item['category_order'] ?? 0),
            strtolower((string) ($item['category'] ?? 'General')),
            strtolower((string) ($item['title'] ?? ''))
        ))
        ->values();

    $achievementItems = $achievementGalleryItems
        ->filter(fn ($item) => ($item['media_type'] ?? 'image') === 'image')
        ->values();

    $studentReviewVideos = $achievementGalleryItems
        ->filter(function ($item) {
            $category = strtolower((string) ($item['category'] ?? ''));

            return ($item['media_type'] ?? 'image') === 'video'
                && str_contains($category, 'review');
        })
        ->values();

    $videoEmbedUrl = static function (?string $url): ?string {
        if (! filled($url)) {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/)([^&?/]+)~i', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~i', $url, $matches)) {
            return 'https://player.vimeo.com/video/'.$matches[1];
        }

        return null;
    };
@endphp

<x-home.marketing-layout title="About | CodeInYourself">
    <x-slot:head>
        <style>
            .about-page-shell {
                overflow-x: clip;
            }

            @supports not (overflow: clip) {
                .about-page-shell {
                    overflow-x: hidden;
                }
            }

            .about-hero-shell {
                position: relative;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                overflow: hidden;
                background:
                    radial-gradient(circle at 12% 18%, rgba(255,255,255,0.16), transparent 18%),
                    radial-gradient(circle at 82% 14%, rgba(216,180,254,0.18), transparent 22%),
                    linear-gradient(135deg, #0a0315 0%, #220942 32%, #4c1d95 66%, #8b5cf6 100%);
            }

            .about-hero-shell::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 92px 92px;
                mask-image: radial-gradient(circle at center, black 28%, transparent 80%);
                opacity: 0.22;
                pointer-events: none;
            }

            .about-glass {
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(255,255,255,0.10);
                box-shadow: 0 24px 60px rgba(10, 3, 24, 0.24);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .about-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.7rem;
                border-radius: 9999px;
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.08);
                padding: 0.75rem 1.15rem;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.24em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.82);
            }

            .about-kicker::before {
                content: "";
                width: 0.55rem;
                height: 0.55rem;
                border-radius: 9999px;
                background: #e9d5ff;
                box-shadow: 0 0 16px rgba(233,213,255,0.8);
            }

            .about-founder-image,
            .about-gallery-grid img {
                width: 100%;
                object-fit: cover;
            }

            .about-founder-image {
                height: 31rem;
                object-position: top;
            }

            .about-section-card {
                border: 1px solid rgba(230, 222, 244, 0.9);
                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,245,255,0.96));
                box-shadow: 0 20px 50px rgba(76, 29, 149, 0.08);
            }

            .about-point-card {
                border: 1px solid rgba(228, 216, 244, 0.88);
                background: rgba(255,255,255,0.88);
            }

            .about-gallery-grid {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .about-gallery-card {
                overflow: hidden;
                border-radius: 1.6rem;
                border: 1px solid rgba(228, 216, 244, 0.9);
                background: #fff;
                box-shadow: 0 18px 40px rgba(76, 29, 149, 0.08);
            }

            .about-gallery-card img {
                height: 14rem;
            }

            .about-stat-card {
                border: 1px solid rgba(255,255,255,0.1);
                background: rgba(255,255,255,0.09);
            }

            .about-achievement-grid {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .about-achievement-thumb {
                display: block;
                width: 100%;
                height: 13rem;
                object-fit: cover;
            }

            .about-video-grid {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .about-video-card {
                overflow: hidden;
                border-radius: 1.6rem;
                border: 1px solid rgba(228, 216, 244, 0.9);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,243,255,0.95));
                box-shadow: 0 18px 40px rgba(76, 29, 149, 0.08);
            }

            .about-video-frame {
                aspect-ratio: 16 / 9;
                width: 100%;
                background: #11081f;
            }

            .about-video-frame iframe,
            .about-video-frame video {
                width: 100%;
                height: 100%;
                border: 0;
                display: block;
                object-fit: cover;
            }

            @media (max-width: 1024px) {
                .about-gallery-grid,
                .about-achievement-grid,
                .about-video-grid {
                    grid-template-columns: 1fr;
                }

                .about-founder-image {
                    height: 24rem;
                }
            }
        </style>
    </x-slot:head>

    <main class="about-page-shell pb-24 pt-5">
        <section class="about-hero-shell px-4 pb-16 pt-12 text-white sm:px-6 md:px-8">
            <div class="relative z-10 mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1fr_1.02fr] lg:items-center">
                <div class="reveal">
                    <span class="about-kicker">About CodeInYourself</span>
                    <h1 class="mt-6 max-w-3xl font-headline text-[2.2rem] font-extrabold leading-[0.98] sm:text-[2.8rem] md:text-[3.5rem]">
                        A cleaner learning experience
                        <span class="block text-[#ead9ff]">built around mentorship, projects, and career growth.</span>
                    </h1>
                    <p class="mt-5 max-w-2xl text-sm leading-8 text-white/74 md:text-base">
                        CodeInYourself is designed to feel professional, supportive, and practical. We help students learn with clarity, build confidence with mentors, and move toward stronger real-world outcomes.
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        @foreach ($aboutStats as $stat)
                            <div class="about-stat-card rounded-[1.5rem] p-4">
                                <p class="font-headline text-3xl font-extrabold text-white">{{ $stat['value'] }}</p>
                                <p class="mt-2 text-sm leading-6 text-white/66">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('home.courses') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-primary">
                            Explore Programs
                            <span class="material-symbols-outlined text-[18px]">north_east</span>
                        </a>
                        <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-white/14 bg-white/10 px-6 py-4 text-sm font-bold text-white">
                            Contact The Team
                        </a>
                    </div>
                </div>

                <div class="reveal stagger-1">
                    <div class="about-glass rounded-[2rem] p-4 md:p-5">
                        <img src="{{ asset('images/owner 1.0.jpeg') }}" alt="Founder of CodeInYourself" class="about-founder-image rounded-[1.7rem]" />

                        <div class="mt-4 rounded-[1.4rem] border border-white/12 bg-white/10 p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/56">Founder</p>
                            <p class="mt-2 font-headline text-2xl font-extrabold text-white">Kajal Tiwari</p>
                            <p class="mt-2 text-sm leading-7 text-white/72">Founder of CodeInYourself, focused on making tech learning more approachable, guided, and career-oriented for students who want practical growth.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[0.92fr_1.08fr]">
                <article class="about-section-card reveal rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Why Students Choose Us</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Built for serious learning with the right support.</h2>
                    <p class="mt-4 max-w-xl text-sm leading-8 text-on-surface-variant">
                        CodeInYourself combines guided teaching, practical work, and mentor attention so students can grow with more clarity and confidence.
                    </p>

                    <div class="mt-8 grid gap-4">
                        @foreach ($aboutPoints as $point)
                            <div class="about-point-card rounded-[1.5rem] p-5">
                                <div class="flex gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                        <span class="material-symbols-outlined">{{ $point['icon'] }}</span>
                                    </span>
                                    <div>
                                        <h3 class="font-headline text-xl font-extrabold text-on-surface">{{ $point['title'] }}</h3>
                                        <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $point['copy'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="about-section-card reveal rounded-[2rem] p-6 md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Our Learning Journey</p>
                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        @foreach ($aboutMoments as $moment)
                            <div class="rounded-[1.6rem] bg-[linear-gradient(180deg,rgba(124,58,237,0.07),rgba(255,255,255,0.92))] p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary/70">{{ $moment['label'] }}</p>
                                <h3 class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $moment['title'] }}</h3>
                                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $moment['copy'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 overflow-hidden rounded-[1.8rem]">
                        <img src="{{ asset('images/tailored training.jpeg') }}" alt="CodeInYourself training environment" class="h-[20rem] w-full object-cover" />
                    </div>
                </article>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="about-section-card reveal rounded-[2rem] p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Our Achievements</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">A fuller showcase of events, milestones, and student moments.</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-on-surface-variant">
                        This section now shows more achievement visuals from the gallery, while keeping video content limited to student reviews only.
                    </p>
                </div>

                @if ($achievementItems->isNotEmpty())
                    <div class="about-achievement-grid mt-8">
                        @foreach ($achievementItems as $item)
                            <article class="about-gallery-card reveal {{ $loop->iteration > 1 ? 'stagger-' . min($loop->iteration, 4) : '' }}">
                                <img src="{{ $item['media_url'] }}" alt="{{ $item['title'] ?? 'Achievement image' }}" class="about-achievement-thumb" />
                                <div class="p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary/70">{{ $item['category'] ?? 'Achievement' }}</p>
                                    <h3 class="mt-2 font-headline text-xl font-extrabold text-on-surface">{{ $item['title'] ?? 'CodeInYourself achievement' }}</h3>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-[1.8rem] border border-dashed border-outline bg-white/70 p-8 text-center">
                        <h3 class="font-headline text-2xl font-extrabold text-on-surface">Achievement visuals will appear here</h3>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">Add gallery items from the HR achievements panel to populate this section.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="about-section-card reveal rounded-[2rem] p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Student Review Videos</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Real student voices only.</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-on-surface-variant">
                        Only student review videos are shown here so the About page feels more focused, trustworthy, and clean.
                    </p>
                </div>

                @if ($studentReviewVideos->isNotEmpty())
                    <div class="about-video-grid mt-8">
                        @foreach ($studentReviewVideos as $item)
                            @php
                                $embedUrl = $videoEmbedUrl($item['media_url'] ?? '');
                                $isDirectVideo = preg_match('/\.(mp4|webm|ogg|mov)(\?.*)?$/i', (string) ($item['media_url'] ?? ''));
                            @endphp
                            <article class="about-video-card reveal {{ $loop->iteration > 1 ? 'stagger-' . min($loop->iteration, 4) : '' }}">
                                <div class="about-video-frame">
                                    @if ($embedUrl)
                                        <iframe
                                            src="{{ $embedUrl }}"
                                            title="{{ $item['title'] ?? 'Student review video' }}"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                        ></iframe>
                                    @elseif ($isDirectVideo)
                                        <video controls preload="metadata">
                                            <source src="{{ $item['media_url'] }}" />
                                        </video>
                                    @else
                                        <div class="flex h-full items-center justify-center p-6 text-center">
                                            <a href="{{ $item['media_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-bold text-white">
                                                Watch Review Video
                                                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary/70">{{ $item['category'] ?? 'Student Reviews' }}</p>
                                    <h3 class="mt-2 font-headline text-xl font-extrabold text-on-surface">{{ $item['title'] ?? 'Student review' }}</h3>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-[1.8rem] border border-dashed border-outline bg-white/70 p-8 text-center">
                        <h3 class="font-headline text-2xl font-extrabold text-on-surface">Student review videos will appear here</h3>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">Add achievement gallery items with category `Student Reviews` and media type `Video` to populate this section.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="hero-panel reveal rounded-[2.2rem] px-6 py-10 text-white sm:px-8 md:px-10">
                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/62">Start With Confidence</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">Explore a platform that now looks cleaner, sharper, and more welcoming.</h2>
                        <p class="mt-4 text-sm leading-7 text-white/76 md:text-base">The About page now puts the brand, achievement visuals, and mentor presence forward without overwhelming the visitor.</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold uppercase tracking-[0.16em] text-primary" href="{{ route('home.courses') }}">
                            Explore Programs
                            <span class="material-symbols-outlined text-[18px]">north_east</span>
                        </a>
                        <a class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl border border-white/14 bg-white/10 px-6 py-4 text-sm font-bold uppercase tracking-[0.16em] text-white" href="{{ route('home.contact') }}">
                            Contact The Team
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
