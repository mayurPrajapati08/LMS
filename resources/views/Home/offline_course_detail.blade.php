@php
    $curriculumModules = collect($course->curriculum_modules ?? [])->map(function ($module) {
        $topics = collect($module['topics'] ?? [])->map(function ($topic) {
            if (is_array($topic)) {
                return [
                    'title' => $topic['title'] ?? '',
                    'details' => $topic['details'] ?? '',
                ];
            }

            return [
                'title' => (string) $topic,
                'details' => '',
            ];
        })->filter(fn ($topic) => filled($topic['title']) || filled($topic['details']))->values();

        return [
            'title' => $module['title'] ?? 'Module',
            'duration' => $module['duration'] ?? '',
            'topics' => $topics,
            'project' => $module['project'] ?? '',
        ];
    })->values();
@endphp

<x-home.marketing-layout :title="$course->title.' | CodeInYourself'">
    <x-slot:head>
        <style>
            .offline-detail-page {
                background:
                    radial-gradient(circle at top left, rgba(240, 181, 82, 0.10), transparent 22%),
                    radial-gradient(circle at top right, rgba(15, 118, 110, 0.10), transparent 22%),
                    linear-gradient(180deg, #fffdf8 0%, #f8f3ff 52%, #f5fbff 100%);
            }
            .detail-fade-up {
                opacity: 0;
                transform: translateY(26px);
                animation: detailFadeUp .75s cubic-bezier(.16,1,.3,1) forwards;
            }
            .detail-delay-1 { animation-delay: .08s; }
            .detail-delay-2 { animation-delay: .16s; }
            .detail-delay-3 { animation-delay: .24s; }
            .detail-delay-4 { animation-delay: .32s; }
            @keyframes detailFadeUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .detail-hero {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(circle at top left, rgba(255,255,255,0.16), transparent 22%),
                    linear-gradient(135deg, #082032 0%, #113a5c 42%, #5b2c83 100%);
            }
            .detail-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 64px 64px;
                mask-image: radial-gradient(circle at center, black 26%, transparent 82%);
                pointer-events: none;
            }
            .detail-shell {
                border: 1px solid rgba(255,255,255,0.12);
                background: linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.05));
                backdrop-filter: blur(14px);
            }
            .detail-media-card {
                border: 1px solid rgba(255,255,255,0.12);
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.05));
                box-shadow: 0 32px 76px rgba(10, 18, 38, 0.24);
                backdrop-filter: blur(18px);
            }
            .detail-preview {
                position: relative;
                overflow: hidden;
                min-height: 100%;
                background:
                    radial-gradient(circle at 18% 16%, rgba(255,255,255,0.08), transparent 18%),
                    radial-gradient(circle at 82% 24%, rgba(74, 219, 255, 0.18), transparent 18%),
                    linear-gradient(145deg, #0b1026 0%, #101938 48%, #151d3e 100%);
            }
            .detail-preview::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
                background-size: 48px 48px;
                mask-image: linear-gradient(180deg, rgba(0,0,0,0.55), rgba(0,0,0,0.1));
                pointer-events: none;
            }
            .detail-preview::after {
                content: "";
                position: absolute;
                inset: auto -8% -18% auto;
                width: 56%;
                height: 56%;
                border-radius: 9999px;
                background: radial-gradient(circle, rgba(104, 83, 255, 0.32) 0%, rgba(48, 189, 255, 0.18) 34%, rgba(48, 189, 255, 0) 72%);
                filter: blur(28px);
                pointer-events: none;
            }
            .detail-preview-badge {
                position: absolute;
                left: 1.1rem;
                top: 1.1rem;
                z-index: 2;
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(8, 18, 42, 0.62);
                backdrop-filter: blur(10px);
            }
            .detail-preview-caption {
                position: absolute;
                left: 1.25rem;
                right: 1.25rem;
                bottom: 1.25rem;
                z-index: 2;
                border: 1px solid rgba(255,255,255,0.12);
                background: linear-gradient(180deg, rgba(7,16,36,0.78), rgba(7,16,36,0.62));
                box-shadow: 0 14px 30px rgba(6, 12, 24, 0.28);
                backdrop-filter: blur(10px);
            }
            .detail-preview img {
                position: relative;
                z-index: 1;
                width: 100%;
                height: 100%;
                object-fit: contain;
                object-position: center;
                padding: 1.7rem 1.7rem 4.8rem;
                filter: drop-shadow(0 22px 40px rgba(9, 12, 26, 0.44));
                transition: transform .8s cubic-bezier(.16,1,.3,1), filter .8s cubic-bezier(.16,1,.3,1);
            }
            .detail-preview:hover img {
                transform: scale(1.03);
                filter: drop-shadow(0 28px 44px rgba(9, 12, 26, 0.5));
            }
            .detail-media-facts {
                border-top: 1px solid rgba(255,255,255,0.08);
                background: linear-gradient(180deg, rgba(8,17,37,0.32), rgba(8,17,37,0.16));
            }
            .detail-media-fact {
                border: 1px solid rgba(255,255,255,0.10);
                background: rgba(255,255,255,0.06);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
            }
            .detail-stat,
            .detail-panel,
            .detail-topic,
            .detail-benefit {
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,245,252,0.96));
                box-shadow: 0 22px 54px rgba(51, 34, 74, 0.08);
            }
            .detail-topic {
                position: relative;
                overflow: hidden;
            }
            .detail-topic::before {
                content: "";
                position: absolute;
                left: 0;
                top: 1.1rem;
                bottom: 1.1rem;
                width: 3px;
                border-radius: 9999px;
                background: linear-gradient(180deg, #f0b552, #7b4fa6);
            }
            .offline-fee-card {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(circle at top left, rgba(255,255,255,0.18), transparent 26%),
                    linear-gradient(135deg, #082032 0%, #113a5c 46%, #5b2c83 100%);
            }
            .offline-fee-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 64px 64px;
                mask-image: radial-gradient(circle at top left, black 12%, transparent 70%);
                pointer-events: none;
            }
            .offline-fee-chip {
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.10);
                backdrop-filter: blur(10px);
            }
            .offline-fee-stat {
                border: 1px solid rgba(255,255,255,0.12);
                background: linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.06));
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
            }
        </style>
    </x-slot:head>

    <main class="offline-detail-page overflow-x-hidden pb-24 pt-5">
        <section class="relative left-1/2 right-1/2 w-screen -translate-x-1/2">
            <div class="detail-hero px-5 pb-20 pt-14 text-white sm:px-8 lg:px-10">
                <div class="mx-auto grid max-w-7xl gap-10 xl:grid-cols-[minmax(0,1.02fr)_minmax(360px,0.98fr)] xl:items-center">
                    <div class="relative z-10 detail-fade-up">
                        <span class="detail-shell inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/84">
                            <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                            Offline Batch Details
                        </span>
                        <p class="mt-6 text-[11px] font-bold uppercase tracking-[0.22em] text-white/62">{{ $course->category?->name ?? 'Offline Course' }}</p>
                        <h1 class="mt-4 max-w-4xl font-headline text-[2.45rem] font-extrabold leading-[0.96] sm:text-[3rem] lg:text-[4.2rem]">{{ $course->title }}</h1>
                        <p class="mt-6 max-w-3xl text-[15px] leading-8 text-white/76">{{ $course->summary }}</p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @if ($audienceLabel)
                                <span class="detail-shell rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white">{{ $audienceLabel }}</span>
                            @endif
                            <span class="detail-shell rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white">{{ $course->delivery_mode ?: 'Offline classroom' }}</span>
                            <span class="detail-shell rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white">{{ $course->language ?: 'English' }}</span>
                        </div>

                        <div class="mt-10 flex flex-wrap gap-3">
                            <a href="{{ route('home.contact', ['topic' => 'offline-course', 'subject' => $course->title]) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-[#113a5c] shadow-[0_18px_34px_rgba(255,255,255,0.12)] transition hover:-translate-y-0.5">
                                Talk To Our Team
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a href="{{ $browseUrl }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/18 px-6 py-4 text-sm font-bold text-white/88 transition hover:bg-white/8">
                                Back To Training Programs
                                <span class="material-symbols-outlined text-[18px]">west</span>
                            </a>
                        </div>
                    </div>

                    <div class="relative z-10 detail-fade-up detail-delay-1">
                        <div class="detail-media-card overflow-hidden rounded-[2rem] p-4 sm:p-5">
                            <div class="overflow-hidden rounded-[1.7rem] border border-white/10 bg-black/10">
                                <div class="detail-preview aspect-[16/11]" style="--detail-image: url('{{ $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=80' }}');">
                                    <div class="detail-preview-badge rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.24em] text-white/88">
                                        {{ $course->delivery_mode ?: 'Offline classroom' }}
                                    </div>
                                    <img src="{{ $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=80' }}" alt="{{ $course->title }}" />
                                    <!-- <div class="detail-preview-caption rounded-[1.2rem] px-4 py-3">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/56">{{ $course->category?->name ?? 'Offline Course' }}</p>
                                        <p class="mt-2 text-sm font-semibold text-white">{{ $course->title }}</p>
                                    </div> -->
                                </div>
                                <div class="detail-media-facts grid gap-3 p-5 sm:grid-cols-2">
                                    <div class="detail-media-fact rounded-[1.2rem] p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Duration</p>
                                        <p class="mt-2 text-sm font-semibold text-white">{{ $course->duration_label ?: 'Shared with your batch plan' }}</p>
                                    </div>
                                    <div class="detail-media-fact rounded-[1.2rem] p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Campus</p>
                                        <p class="mt-2 text-sm font-semibold text-white">{{ $course->campus ?: 'Campus details shared by team' }}</p>
                                    </div>
                                    <div class="detail-media-fact rounded-[1.2rem] p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Schedule</p>
                                        <p class="mt-2 text-sm font-semibold text-white">{{ $course->schedule_label ?: 'Batch timing shared by mentor' }}</p>
                                    </div>
                                    <div class="detail-media-fact rounded-[1.2rem] p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/56">Batch Size</p>
                                        <p class="mt-2 text-sm font-semibold text-white">{{ $course->batch_size ?: 'Limited seats' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto -mt-12 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="detail-stat detail-fade-up detail-delay-1 rounded-[1.8rem] p-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Validity</p>
                    <p class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $course->validity_label ?: 'Shared by team' }}</p>
                </div>
                <div class="detail-stat detail-fade-up detail-delay-2 rounded-[1.8rem] p-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Placement Focus</p>
                    <p class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $course->placement_label ?: 'Placement guidance' }}</p>
                </div>
                <div class="detail-stat detail-fade-up detail-delay-3 rounded-[1.8rem] p-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Audience</p>
                    <p class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $audienceLabel ?: ($course->audience ?: 'Open batch') }}</p>
                </div>
                <div class="detail-stat detail-fade-up detail-delay-4 rounded-[1.8rem] p-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">Learning Mode</p>
                    <p class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $course->delivery_mode ?: 'Offline classroom' }}</p>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1.1fr)_minmax(320px,0.9fr)] lg:items-start">
                <div class="space-y-8">
                    <div class="detail-panel detail-fade-up detail-delay-1 rounded-[2rem] p-7 md:p-8">
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Program Overview</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">A clearer look at what this course covers</h2>
                        <p class="mt-5 text-[15px] leading-8 text-on-surface-variant">{{ $course->details ?: $course->summary }}</p>
                    </div>

                    @if ($curriculumModules->isNotEmpty())
                        <div class="detail-panel detail-fade-up detail-delay-2 rounded-[2rem] p-7 md:p-8">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Curriculum Structure</p>
                            <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">Module-by-module learning path</h2>

                            <div class="mt-8 space-y-6">
                                @foreach ($curriculumModules as $moduleIndex => $module)
                                    <article class="rounded-[1.75rem] border border-outline/60 bg-[#fcfbff] p-5 md:p-6">
                                        <div class="flex flex-wrap items-start justify-between gap-3">
                                            <div>
                                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary">Module {{ $moduleIndex + 1 }}</p>
                                                <h3 class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $module['title'] }}</h3>
                                            </div>
                                            @if ($module['duration'])
                                                <span class="rounded-full bg-[#f3ecfc] px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#7b4fa6]">{{ $module['duration'] }}</span>
                                            @endif
                                        </div>

                                        @if ($module['topics']->isNotEmpty())
                                            <div class="mt-6 space-y-4">
                                                @foreach ($module['topics'] as $topic)
                                                    <div class="detail-topic rounded-[1.45rem] border border-outline/60 px-5 py-5 pl-8">
                                                        <h4 class="font-headline text-xl font-extrabold text-on-surface">{{ $topic['title'] ?: 'Topic' }}</h4>
                                                        @if ($topic['details'])
                                                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $topic['details'] }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if ($module['project'])
                                            <div class="mt-6 rounded-[1.3rem] bg-[linear-gradient(135deg,#fff5dc_0%,#fffaf0_100%)] px-5 py-4">
                                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8a6517]">Module Project</p>
                                                <p class="mt-2 text-sm font-semibold leading-7 text-on-surface">{{ $module['project'] }}</p>
                                            </div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <aside class="space-y-6 lg:self-start">
                    <div class="lg:sticky lg:top-[132px] space-y-6">
                       

                        <div class="detail-fade-up detail-delay-4 overflow-hidden rounded-[2rem] shadow-[0_28px_70px_rgba(44,29,78,0.16)]">
                            <div class="offline-fee-card p-6 text-white sm:p-7">
                                <div class="relative z-10">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="space-y-3">
                                            <span class="offline-fee-chip inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/88">
                                                <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                                                Fee Access
                                            </span>
                                            <h3 class="font-headline text-[1.75rem] font-extrabold leading-[1.05] text-white sm:text-[1.95rem]">Unlock your offline batch details</h3>
                                        </div>
                                        <div class="offline-fee-chip flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl">
                                            <span class="material-symbols-outlined text-[22px] text-white">payments</span>
                                        </div>
                                    </div>

                                    <p class="mt-4 text-sm leading-7 text-white/78">{{ $course->learner_note ?: 'Talk to our team for the latest fee, upcoming batch timing, campus details, and seat availability before you enroll.' }}</p>

                                    <div class="mt-6 grid gap-3 grid-cols-1 sm:grid-cols-2">
                                        <div class="offline-fee-stat rounded-[1.25rem] p-4">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/56">Campus</p>
                                            <p class="mt-2 text-sm font-semibold leading-6 text-white">{{ $course->campus ?: 'Shared by team' }}</p>
                                        </div>
                                        <div class="offline-fee-stat rounded-[1.25rem] p-4">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/56">Schedule</p>
                                            <p class="mt-2 text-sm font-semibold leading-6 text-white">{{ $course->schedule_label ?: 'Batch timing shared' }}</p>
                                        </div>
                                        <div class="offline-fee-stat rounded-[1.25rem] p-4 sm:col-span-2">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/56">Batch Size</p>
                                            <p class="mt-2 text-sm font-semibold leading-6 text-white">{{ $course->batch_size ?: 'Limited seats with mentor support' }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 rounded-[1.3rem] border border-white/10 bg-white/10 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/58">Quick Guidance</p>
                                        <p class="mt-2 text-sm leading-6 text-white/82">Best for learners who want mentor-led offline training with a clear batch plan and admission support.</p>
                                    </div>

                                    <a href="{{ route('home.contact', ['topic' => 'offline-course', 'subject' => $course->title]) }}" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-[#113a5c] shadow-[0_18px_34px_rgba(6,12,24,0.18)] transition hover:-translate-y-0.5">
                                        Unlock Batch Details
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if (!empty($course->highlights))
                            <div class="detail-panel detail-fade-up detail-delay-2 rounded-[2rem] p-7">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Highlights</p>
                                <div class="mt-5 space-y-3">
                                    @foreach ($course->highlights as $highlight)
                                        <div class="detail-benefit flex items-start gap-3 rounded-[1.25rem] p-4">
                                            <span class="material-symbols-outlined mt-0.5 text-primary">task_alt</span>
                                            <p class="text-sm leading-7 text-on-surface-variant">{{ $highlight }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($course->additional_benefits))
                            <div class="detail-panel detail-fade-up detail-delay-3 rounded-[2rem] p-7">
                                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Additional Benefits</p>
                                <div class="mt-5 space-y-3">
                                    @foreach ($course->additional_benefits as $benefit)
                                        <div class="detail-benefit flex items-start gap-3 rounded-[1.25rem] p-4">
                                            <span class="material-symbols-outlined mt-0.5 text-primary">workspace_premium</span>
                                            <p class="text-sm leading-7 text-on-surface-variant">{{ $benefit }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
