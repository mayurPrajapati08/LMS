
@php
    $heroStats = [
        ['value' => '12+', 'label' => 'active hiring tracks across tech, support, and academic delivery'],
        ['value' => '5 Days', 'label' => 'average first-response timeline for shortlisted applicants'],
        ['value' => '100%', 'label' => 'collaborative culture built around guided growth and ownership'],
    ];

    $openings = $openings ?? [
        [
            'badge' => 'Urgent Opening',
            'title' => 'Senior Laravel Developer',
            'type' => 'Full Time',
            'mode' => 'On-site / Hybrid',
            'location' => 'Surat, Gujarat',
            'experience' => '3+ years',
            'salary' => 'Best in industry',
            'summary' => 'Lead backend delivery for our LMS, improve performance, and shape product architecture with a practical engineering mindset.',
            'skills' => ['Laravel', 'MySQL', 'REST APIs', 'Performance tuning'],
            'color' => 'from-[#13041f] via-[#4c1d95] to-[#9d5cff]',
        ],
        [
            'badge' => 'New Role',
            'title' => 'Frontend UI Designer',
            'type' => 'Full Time',
            'mode' => 'On-site',
            'location' => 'Surat, Gujarat',
            'experience' => '2+ years',
            'salary' => 'Competitive package',
            'summary' => 'Design high-conversion landing pages, polished learning interfaces, and campaign creatives that feel intentional and well crafted.',
            'skills' => ['Figma', 'Tailwind CSS', 'UI systems', 'Creative direction'],
            'color' => 'from-[#190728] via-[#5b21b6] to-[#f472b6]',
        ],
        [
            'badge' => 'Faculty Role',
            'title' => 'Data Analytics Faculty',
            'type' => 'Full Time',
            'mode' => 'Classroom + Online',
            'location' => 'Surat, Gujarat',
            'experience' => '2+ years',
            'salary' => 'Mentor-led growth track',
            'summary' => 'Deliver practical training in Excel, SQL, Power BI, and dashboard thinking with strong student support and project reviews.',
            'skills' => ['Power BI', 'SQL', 'Excel', 'Teaching skills'],
            'color' => 'from-[#071a2d] via-[#0f766e] to-[#2dd4bf]',
        ],
        [
            'badge' => 'People Team',
            'title' => 'HR Executive',
            'type' => 'Full Time',
            'mode' => 'On-site',
            'location' => 'Surat, Gujarat',
            'experience' => '1-3 years',
            'salary' => 'Growth + incentives',
            'summary' => 'Support recruitment, onboarding, employee experience, and daily people operations with warmth, clarity, and ownership.',
            'skills' => ['Hiring coordination', 'Communication', 'Onboarding', 'Culture building'],
            'color' => 'from-[#1f0c05] via-[#c2410c] to-[#fb923c]',
        ],
    ];

    $teamMembers = [
        [
            'eyebrow' => 'Founder & Vision',
            'name' => 'Kajal Tiwari',
            'role' => 'Owner & Growth Architect',
            'bio' => 'Leads the company vision with a strong focus on career-first education, strong learning experiences, and team growth that scales with quality.',
            'highlights' => ['Product direction', 'Brand growth', 'Mentor culture'],
            'icon' => 'rocket_launch',
        ],
        [
            'eyebrow' => 'People & Culture',
            'name' => 'Riya Shah',
            'role' => 'HR Team Lead',
            'bio' => 'Shapes the hiring experience, onboarding flow, and employee support systems so every team member feels guided, valued, and clear about their path.',
            'highlights' => ['Talent acquisition', 'Onboarding systems', 'Team care'],
            'icon' => 'diversity_3',
        ],
        [
            'eyebrow' => 'Academic Delivery',
            'name' => 'Faculty Collective',
            'role' => 'Industry Mentors & Trainers',
            'bio' => 'Our current faculty includes mentors from development, analytics, AI, design, and communication domains who keep training practical and relevant.',
            'highlights' => ['Project-led teaching', 'Career guidance', 'Live doubt solving'],
            'icon' => 'school',
        ],
        [
            'eyebrow' => 'Knowledge Operations',
            'name' => 'Content & Curriculum Team',
            'role' => 'Learning Experience Builders',
            'bio' => 'Transforms domain knowledge into structured courses, workshop assets, recruiter-focused practice material, and polished learner journeys.',
            'highlights' => ['Curriculum design', 'Learning quality', 'Assessment flow'],
            'icon' => 'library_books',
        ],
    ];

    $culturePillars = [
        [
            'title' => 'Build with ownership',
            'copy' => 'We trust people to take responsibility, improve systems, and move ideas into real outcomes without waiting for constant instruction.',
            'icon' => 'workspace_premium',
        ],
        [
            'title' => 'Teach what is useful',
            'copy' => 'Our learning culture values practical industry relevance, strong explanation, and visible student transformation over empty presentation.',
            'icon' => 'lightbulb',
        ],
        [
            'title' => 'Care about the learner',
            'copy' => 'Every role here connects back to student confidence, clarity, and career momentum, whether you are in faculty, design, engineering, or HR.',
            'icon' => 'favorite',
        ],
    ];

    $knowledgeAreas = [
        ['label' => 'Engineering', 'items' => ['Laravel product delivery', 'Admin systems', 'Performance and scale']],
        ['label' => 'Training', 'items' => ['Career-aligned faculty tracks', 'Live workshop execution', 'Project review systems']],
        ['label' => 'Creative', 'items' => ['Premium UI design', 'Brand storytelling', 'Campaign presentation']],
        ['label' => 'People', 'items' => ['Hiring flow', 'Employee experience', 'Team communication']],
    ];
@endphp

<x-home.marketing-layout title="Career With Us | CodeInYourself" bodyClass="career-page-shell">
    <x-slot:head>
        <style>
            .career-page-shell {
                overflow-x: clip;
            }

            @supports not (overflow: clip) {
                .career-page-shell {
                    overflow-x: hidden;
                }
            }

            .career-hero {
                position: relative;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                overflow: hidden;
                background:
                    radial-gradient(circle at 14% 18%, rgba(255,255,255,0.18), transparent 18%),
                    radial-gradient(circle at 84% 15%, rgba(216,180,254,0.24), transparent 22%),
                    radial-gradient(circle at 78% 76%, rgba(255,255,255,0.10), transparent 20%),
                    linear-gradient(135deg, #080211 0%, #1a0633 24%, #4c1d95 60%, #a855f7 100%);
            }

            .career-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 92px 92px;
                mask-image: radial-gradient(circle at center, black 24%, transparent 84%);
                opacity: 0.24;
                pointer-events: none;
            }

            .career-orb {
                position: absolute;
                border-radius: 9999px;
                filter: blur(16px);
                pointer-events: none;
            }

            .career-orb.one {
                left: -5rem;
                top: 6rem;
                width: 18rem;
                height: 18rem;
                background: radial-gradient(circle, rgba(192,132,252,0.28), rgba(192,132,252,0));
            }

            .career-orb.two {
                right: -4rem;
                bottom: 5rem;
                width: 16rem;
                height: 16rem;
                background: radial-gradient(circle, rgba(255,255,255,0.24), rgba(255,255,255,0));
            }

            .career-hero-card {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255,255,255,0.14);
                background: linear-gradient(180deg, rgba(255,255,255,0.18), rgba(255,255,255,0.07));
                box-shadow: 0 24px 62px rgba(7, 2, 20, 0.28);
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
            }

            .career-hero-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(255,255,255,0.08), transparent 38%);
                pointer-events: none;
            }

            .career-role-card {
                position: relative;
                overflow: hidden;
                border-radius: 2rem;
                border: 1px solid rgba(221, 214, 254, 0.45);
                box-shadow: 0 26px 66px rgba(76, 29, 149, 0.12);
                transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.32s ease;
            }

            .career-role-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 30px 78px rgba(76, 29, 149, 0.18);
            }

            .career-role-card::after {
                content: "";
                position: absolute;
                inset: auto -2.5rem -2.5rem auto;
                width: 8rem;
                height: 8rem;
                border-radius: 9999px;
                background: radial-gradient(circle, rgba(255,255,255,0.18), rgba(255,255,255,0));
                pointer-events: none;
            }

            .team-spotlight-card {
                position: relative;
                overflow: hidden;
                border-radius: 2rem;
                border: 1px solid rgba(220, 205, 246, 0.78);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(247,240,255,0.94));
                box-shadow: 0 24px 60px rgba(76, 29, 149, 0.10);
            }

            .team-spotlight-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at top right, rgba(168,85,247,0.10), transparent 24%),
                    radial-gradient(circle at bottom left, rgba(124,58,237,0.08), transparent 20%);
                pointer-events: none;
            }

            .team-icon-shell {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 3.4rem;
                height: 3.4rem;
                border-radius: 1.15rem;
                background: linear-gradient(135deg, rgba(124,58,237,0.14), rgba(168,85,247,0.2));
                color: #6d28d9;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.76);
            }
            .knowledge-grid {
                background:
                    radial-gradient(circle at top left, rgba(255,255,255,0.12), transparent 26%),
                    linear-gradient(135deg, #10041d 0%, #34105f 42%, #5b21b6 100%);
            }

            .knowledge-card {
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(255,255,255,0.09);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.08);
            }
            .faculty-card {
                position: relative;
                overflow: hidden;
                border-radius: 1.9rem;
                box-shadow: 0 24px 60px rgba(76, 29, 149, 0.12);
            }
            .faculty-card::before {
                content: "";
                position: absolute;
                inset: 1px;
                border-radius: calc(1.9rem - 1px);
                background: linear-gradient(180deg, rgba(255,255,255,0.97), rgba(247,240,255,0.94));
                pointer-events: none;
            }

            .process-line {
                position: absolute;
                left: 1.2rem;
                top: 3rem;
                bottom: -2rem;
                width: 1px;
                background: linear-gradient(180deg, rgba(124,58,237,0.28), rgba(168,85,247,0));
            }

            @media (max-width: 768px) {
                .career-hero {
                    min-height: auto;
                }
            }
        </style>
    </x-slot:head>
    

    <main>
        <section class="career-hero px-4 pb-20 pt-28 text-white md:px-6 md:pb-24 md:pt-32">
            <div class="career-orb one"></div>
            <div class="career-orb two"></div>

            <div class="relative z-10 mx-auto max-w-6xl">
                <div class="grid gap-10 lg:grid-cols-[1.02fr_0.98fr] lg:items-center">
                    <div class="reveal">
                        <span class="inline-flex rounded-full border border-white/14 bg-white/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.28em] text-white/82 backdrop-blur-md">
                            Career With Us
                        </span>
                        <h1 class="mt-6 max-w-3xl font-headline text-[2.8rem] font-extrabold leading-[0.94] tracking-[-0.05em] sm:text-[3.6rem] md:text-[3.8rem]">
                            Join the team that is building stronger careers through practical learning experiences.
                        </h1>
                        <p class="mt-6 max-w-2xl text-sm leading-8 text-white/76 md:text-[15px]">
                            Explore current job openings, meet the people behind the company, and see how our faculty, owner, HR team, and knowledge units work together to create career-focused impact.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="#open-roles" class="cta-button inline-flex items-center gap-2 rounded-full bg-white px-7 py-4 text-sm font-bold text-primary shadow-[0_18px_42px_rgba(255,255,255,0.22)]">
                                <span class="material-symbols-outlined text-[18px]">work</span>
                                View Openings
                            </a>
                            <a href="{{ route('home.contact') }}" class="inline-flex items-center gap-2 rounded-full border border-white/18 bg-white/10 px-7 py-4 text-sm font-bold text-white backdrop-blur-md transition hover:bg-white/14">
                                <span class="material-symbols-outlined text-[18px]">mail</span>
                                Connect With HR
                            </a>
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            @foreach ($heroStats as $stat)
                                <div class="career-hero-card rounded-[1.6rem] p-5">
                                    <p class="font-headline text-[1.9rem] font-extrabold text-white">{{ $stat['value'] }}</p>
                                    <p class="mt-2 text-sm leading-6 text-white/70">{{ $stat['label'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="career-hero-card rounded-[2rem] p-5 md:p-6">
                            <div class="rounded-[1.7rem] border border-white/12 bg-[linear-gradient(180deg,rgba(10,3,22,0.5),rgba(255,255,255,0.04))] p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-white/50">Hiring Snapshot</p>
                                        <h2 class="mt-3 font-headline text-[2rem] font-extrabold leading-tight text-white">Current talent priorities</h2>
                                    </div>
                                    <span class="rounded-full border border-emerald-300/26 bg-emerald-400/14 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.22em] text-emerald-100">
                                        Applications Open
                                    </span>
                                </div>

                                <div class="mt-6 grid gap-4">
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-white/46">Tech & Product</p>
                                        <p class="mt-3 text-lg font-semibold text-white">Engineering, platform improvement, and modern UI execution.</p>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-white/46">Academic & Faculty</p>
                                        <p class="mt-3 text-lg font-semibold text-white">Faculty who can teach clearly, guide projects, and build student confidence.</p>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-white/46">People & Knowledge</p>
                                        <p class="mt-3 text-lg font-semibold text-white">HR, support, and curriculum roles that strengthen internal systems and learner journeys.</p>
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-wrap gap-2">
                                    <span class="rounded-full border border-white/12 bg-white/10 px-3 py-2 text-[11px] font-semibold text-white/82">Growth mindset</span>
                                    <span class="rounded-full border border-white/12 bg-white/10 px-3 py-2 text-[11px] font-semibold text-white/82">Strong communication</span>
                                    <span class="rounded-full border border-white/12 bg-white/10 px-3 py-2 text-[11px] font-semibold text-white/82">Practical ownership</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="open-roles" class="px-4 py-20 md:px-6 md:py-24">
            <div class="mx-auto max-w-6xl">
                <div class="reveal mb-10 text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.32em] text-primary">Open Positions</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-[2.8rem]">Current openings to grow with our company</h2>
                    <p class="mx-auto mt-4 max-w-3xl text-sm leading-8 text-on-surface-variant md:text-[15px]">
                        Every role is for people who want to contribute meaningfully, keep learning fast, and help build educational experiences that students genuinely value.
                    </p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    @foreach ($openings as $index => $opening)
                        <article class="career-role-card reveal stagger-{{ ($index % 4) + 1 }} bg-gradient-to-br {{ $opening['color'] }} p-[1px]">
                            <div class="h-full rounded-[calc(2rem-1px)] bg-[linear-gradient(180deg,rgba(255,255,255,0.97),rgba(247,240,255,0.94))] p-6 md:p-7">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <span class="rounded-full bg-primary/10 px-4 py-2 text-[10px] font-bold uppercase tracking-[0.26em] text-primary">{{ $opening['badge'] }}</span>
                                    <span class="text-sm font-semibold text-on-surface-variant">{{ $opening['type'] }}</span>
                                </div>

                                <h3 class="mt-5 font-headline text-[2rem] font-extrabold leading-tight text-on-surface">{{ $opening['title'] }}</h3>
                                <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $opening['summary'] }}</p>

                                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                    <div class="rounded-[1.25rem] bg-white px-4 py-3 shadow-soft">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">Mode</p>
                                        <p class="mt-2 text-sm font-semibold text-on-surface">{{ $opening['mode'] }}</p>
                                    </div>
                                    <div class="rounded-[1.25rem] bg-white px-4 py-3 shadow-soft">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">Location</p>
                                        <p class="mt-2 text-sm font-semibold text-on-surface">{{ $opening['location'] }}</p>
                                    </div>
                                    <div class="rounded-[1.25rem] bg-white px-4 py-3 shadow-soft">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">Experience</p>
                                        <p class="mt-2 text-sm font-semibold text-on-surface">{{ $opening['experience'] }}</p>
                                    </div>
                                    <div class="rounded-[1.25rem] bg-white px-4 py-3 shadow-soft">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">Compensation</p>
                                        <p class="mt-2 text-sm font-semibold text-on-surface">{{ $opening['salary'] }}</p>
                                    </div>
                                </div>
                                <div class="mt-6 flex flex-wrap gap-2">
                                    @foreach ($opening['skills'] as $skill)
                                        <span class="rounded-full border border-outline/60 bg-primary-soft px-3 py-2 text-[11px] font-bold uppercase tracking-[0.14em] text-primary">{{ $skill }}</span>
                                    @endforeach
                                </div>

                                <div class="mt-7 flex flex-wrap gap-3">
                                    <a href="{{ route('home.contact', ['topic' => 'career', 'subject' => $opening['title']]) }}" class="cta-button inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-bold text-white">
                                        <span class="material-symbols-outlined text-[18px]">send</span>
                                        Apply Now
                                    </a>
                                    <a href="{{ route('home.contact', ['topic' => 'career', 'subject' => $opening['title']]) }}" class="inline-flex items-center gap-2 rounded-full border border-outline bg-white px-6 py-3 text-sm font-bold text-on-surface transition hover:border-primary hover:text-primary">
                                        <span class="material-symbols-outlined text-[18px]">forum</span>
                                        Ask About Role
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="px-4 pb-20 md:px-6 md:pb-24">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-6 lg:grid-cols-[0.96fr_1.04fr]">
                    <div class="section-panel reveal rounded-[2rem] p-6 md:p-8">
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-primary">Why Join Us</p>
                        <h2 class="mt-4 font-headline text-[2.2rem] font-extrabold leading-tight text-on-surface">A workplace built around growth, guidance, and visible contribution</h2>
                        <div class="mt-8 space-y-4">
                            @foreach ($culturePillars as $pillar)
                                <div class="rounded-[1.5rem] border border-outline/70 bg-white/90 p-5 shadow-soft">
                                    <div class="flex items-start gap-4">
                                        <span class="team-icon-shell shrink-0">
                                            <span class="material-symbols-outlined text-[1.35rem]">{{ $pillar['icon'] }}</span>
                                        </span>
                                        <div>
                                            <h3 class="text-lg font-bold text-on-surface">{{ $pillar['title'] }}</h3>
                                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $pillar['copy'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-panel reveal rounded-[2rem] p-6 md:p-8">
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-primary">Hiring Journey</p>
                        <h2 class="mt-4 font-headline text-[2.2rem] font-extrabold leading-tight text-on-surface">Simple, clear, and respectful recruitment process</h2>
                        <div class="mt-8 space-y-7">
                            @foreach ([['step' => '01', 'title' => 'Profile review', 'copy' => 'We review your profile for role fit, communication quality, and practical relevance.'], ['step' => '02', 'title' => 'Conversation with HR', 'copy' => 'Our HR team connects to understand your goals, availability, and alignment with the company culture.'], ['step' => '03', 'title' => 'Skill round or demo', 'copy' => 'Depending on the role, we may ask for a practical discussion, portfolio review, or sample teaching / technical task.'], ['step' => '04', 'title' => 'Final discussion', 'copy' => 'You meet the decision-makers, align on expectations, and move into offer and onboarding steps.']] as $item)
                                <div class="relative pl-14">
                                    @if (!$loop->last)
                                        <span class="process-line"></span>
                                    @endif
                                    <span class="absolute left-0 top-0 inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-primary to-primary-light font-headline text-sm font-extrabold text-white shadow-[0_14px_30px_rgba(124,58,237,0.24)]">
                                        {{ $item['step'] }}
                                    </span>
                                    <h3 class="text-lg font-bold text-on-surface">{{ $item['title'] }}</h3>
                                    <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $item['copy'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-4 pb-20 md:px-6 md:pb-24">
            <div class="mx-auto max-w-6xl">
                <div class="reveal mb-10 text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.32em] text-primary">Our Team</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-[2.8rem]">Meet the owner, HR team, faculty, and knowledge experts</h2>
                    <p class="mx-auto mt-4 max-w-3xl text-sm leading-8 text-on-surface-variant md:text-[15px]">
                        This page is not only about hiring. It also introduces the people and departments that shape the learner experience and support the company every day.
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($teamMembers as $index => $member)
                        <article class="team-spotlight-card premium-card reveal stagger-{{ ($index % 4) + 1 }} p-6 md:p-7">
                            <div class="relative z-10">
                                <div class="flex items-start gap-4">
                                    <span class="team-icon-shell shrink-0">
                                        <span class="material-symbols-outlined text-[1.35rem]">{{ $member['icon'] }}</span>
                                    </span>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-primary">{{ $member['eyebrow'] }}</p>
                                        <h3 class="mt-3 font-headline text-[1.8rem] font-extrabold leading-tight text-on-surface">{{ $member['name'] }}</h3>
                                        <p class="mt-2 text-sm font-semibold text-on-surface-variant">{{ $member['role'] }}</p>
                                    </div>
                                </div>

                                <p class="mt-6 text-sm leading-8 text-on-surface-variant">{{ $member['bio'] }}</p>

                                <div class="mt-6 flex flex-wrap gap-2">
                                    @foreach ($member['highlights'] as $highlight)
                                        <span class="rounded-full border border-outline/70 bg-white px-3 py-2 text-[11px] font-bold uppercase tracking-[0.14em] text-primary">{{ $highlight }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="px-4 pb-20 md:px-6 md:pb-24">
            <div class="knowledge-grid reveal mx-auto max-w-6xl overflow-hidden rounded-[2.4rem] px-6 py-10 text-white shadow-[0_28px_80px_rgba(31,12,67,0.28)] md:px-8 md:py-12">
                <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.32em] text-white/52">Knowledge Ecosystem</p>
                        <h2 class="mt-4 font-headline text-[2.3rem] font-extrabold leading-tight md:text-[2.9rem]">More than a company team. This is a connected knowledge system.</h2>
                        <p class="mt-5 text-sm leading-8 text-white/72 md:text-[15px]">
                            Our engineering, faculty, creative, and people teams work as one ecosystem. That is how we maintain consistent quality in products, training, communication, and student support.
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($knowledgeAreas as $area)
                            <div class="knowledge-card rounded-[1.6rem] p-5">
                                <p class="text-[10px] font-bold uppercase tracking-[0.26em] text-white/54">{{ $area['label'] }}</p>
                                <div class="mt-4 space-y-3">
                                    @foreach ($area['items'] as $item)
                                        <div class="rounded-[1rem] border border-white/10 bg-white/8 px-4 py-3 text-sm font-semibold text-white/86">
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="px-4 pb-20 md:px-6 md:pb-24">
            <div class="mx-auto max-w-5xl">
                <div class="reveal rounded-[2.3rem] bg-[linear-gradient(135deg,#120520_0%,#4c1d95_52%,#a855f7_100%)] px-6 py-10 text-center text-white shadow-[0_30px_90px_rgba(76,29,149,0.28)] md:px-10 md:py-14">
                    <p class="text-xs font-bold uppercase tracking-[0.32em] text-white/54">Let�s Build Together</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold leading-tight md:text-[2.8rem]">See a role that fits you? Start the conversation with our team.</h2>
                    <p class="mx-auto mt-5 max-w-3xl text-sm leading-8 text-white/72 md:text-[15px]">
                        Send your profile, portfolio, teaching background, or hiring query through our contact page and the HR team will connect with you for the next steps.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center gap-2 rounded-full bg-white px-7 py-4 text-sm font-bold text-primary">
                            <span class="material-symbols-outlined text-[18px]">description</span>
                            Submit Your Profile
                        </a>
                        <a href="#open-roles" class="inline-flex items-center gap-2 rounded-full border border-white/16 bg-white/10 px-7 py-4 text-sm font-bold text-white backdrop-blur-md transition hover:bg-white/14">
                            <span class="material-symbols-outlined text-[18px]">arrow_upward</span>
                            Review Openings Again
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
