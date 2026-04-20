@php
    $trainingSolutions = [
        [
            'title' => 'Role-Based Learning Paths',
            'description' => 'Separate tracks for developers, analysts, support teams, operations, and fresh campus hires so every group learns what matters to their work.',
            'points' => ['Frontend, backend, QA, data, AI, and product roles', 'Beginner to advanced cohorts', 'Aligned with your internal tools'],
        ],
        [
            'title' => 'Assigned Mentors And Reviewers',
            'description' => 'Each cohort gets dedicated mentor support for doubt-solving, live reviews, assignments, and delivery checkpoints.',
            'points' => ['Weekly mentor touchpoints', 'Assignment and lab reviews', 'Progress visibility for stakeholders'],
        ],
        [
            'title' => 'Project And Assessment Delivery',
            'description' => 'Training is structured around real exercises, capstone work, and measurable assessments so outcomes stay practical.',
            'points' => ['Hands-on labs and use cases', 'Project submissions', 'Outcome-based evaluation'],
        ],
    ];

    $engagementModels = [
        ['label' => 'New Joiner Bootcamps', 'copy' => 'Short, high-focus onboarding programs for fresh hires and early-career teams.'],
        ['label' => 'Team Upskilling Cohorts', 'copy' => 'Structured learning journeys for existing teams that need stronger execution quality.'],
        ['label' => 'Leadership Skill Tracks', 'copy' => 'Manager-approved plans with progress checkpoints and business-relevant reporting.'],
        ['label' => 'Weekend Or Hybrid Delivery', 'copy' => 'Flexible schedules that work around production timelines and active project commitments.'],
    ];

    $partnerCompanies = [
         ['name' => 'TCS', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Tata_Consultancy_Services_old_logo.svg.png', 'scale' => 1.08],
        ['name' => 'HCL', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/HCL_Technologies-Logo.wine.svg', 'scale' => 2.2],
        ['name' => 'Tech Mahindra', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Tech_Mahindra_New_Logo.svg.png', 'scale' => 1.08],
        ['name' => 'ICICI Bank', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/icici-bank-logo-vector.png', 'scale' => 2.6],
        ['name' => 'Bank of Baroda', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/BankOfBarodaLogo.svg.png', 'scale' => 1.18],
        ['name' => 'Kotak', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/kotak-mahindra-bank-logo-vector_logoshape.png', 'scale' => 2.6],
        ['name' => 'IBM', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/ibm-logo-png-transparent-svg-vector-bie-supply-3.png', 'scale' => 2.58],
        ['name' => 'Amazon', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Amazon_logo.svg.png', 'scale' => 1.08],
        ['name' => 'Infosys', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Infosys_logo.svg.png', 'scale' => 1.08],
        ['name' => 'Oracle', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Oracle_logo.svg.png', 'scale' => 1.08],
        ['name' => 'KPIT', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/KPIT_logo_CMYK_300dpi_150212.png', 'scale' => 1.12],
        ['name' => 'Cognizant', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Cognizant_logo_2022.svg.png', 'scale' => 1.06],
        ['name' => 'Capgemini', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Capgemini_201x_logo.svg.png', 'scale' => 1.08],
        ['name' => 'Deloitte', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Deloitte_old_blue_logo.svg.png', 'scale' => 1.14],
        ['name' => 'Persistent', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Persistent_Systems_Logo.svg.png', 'scale' => 1.12],
        ['name' => 'Zepto', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Zepto_Logo.svg.png', 'scale' => 1.12],
        ['name' => 'Zomato', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Zomato_Logo.svg.png', 'scale' => 1.12],
        ['name' => 'Accenture', 'logo' => 'https://www.codeinyourself.com/assets/img/Logos/Accenture_logo.svg.png', 'scale' => 1.08],
    ];

    $studentStories = [
        [
            'name' => 'Riya Sharma',
            'role' => 'Data Analyst Trainee',
            'company' => 'Assigned to TCS Analytics Team',
            'summary' => 'Improved reporting, SQL, and dashboard confidence through structured labs and mentor feedback.',
        ],
        [
            'name' => 'Aman Verma',
            'role' => 'Full Stack Trainee',
            'company' => 'Assigned to Infosys Digital Delivery',
            'summary' => 'Completed project-based frontend and backend training with better code review discipline.',
        ],
        [
            'name' => 'Sneha Patel',
            'role' => 'Python Automation Learner',
            'company' => 'Assigned to Accenture Operations Tech',
            'summary' => 'Built stronger scripting and automation workflows with guided assignments and weekly checkpoints.',
        ],
    ];

    $deliveryFlow = [
        ['step' => '01', 'title' => 'Requirement Discovery', 'description' => 'We understand your team size, target roles, current skill gaps, and desired business outcomes.'],
        ['step' => '02', 'title' => 'Program Architecture', 'description' => 'We shape the curriculum, delivery calendar, assignments, mentors, and review milestones around your company.'],
        ['step' => '03', 'title' => 'Training Delivery', 'description' => 'Your teams learn through live sessions, hands-on tasks, tracked progress, and feedback loops.'],
        ['step' => '04', 'title' => 'Outcome Reporting', 'description' => 'You get clear visibility into participation, completion, capability growth, and readiness signals.'],
    ];

    $impactSignals = [
        ['label' => 'Cohort design', 'value' => 'Custom by role and level'],
        ['label' => 'Delivery style', 'value' => 'Hybrid, live, workshop-ready'],
        ['label' => 'Reporting', 'value' => 'Manager-friendly checkpoints'],
    ];

    $experienceMoments = [
        [
            'title' => 'Interactive live sessions',
            'copy' => 'Sessions are built to keep teams involved with guided walkthroughs, practical questions, and hands-on execution moments.',
        ],
        [
            'title' => 'Assignment-based progression',
            'copy' => 'Learners move through clear task milestones instead of passive watching, which makes growth easier to measure.',
        ],
        [
            'title' => 'Mentor-led confidence building',
            'copy' => 'Dedicated support helps assigned students and teams ask better questions, improve faster, and apply skills with more confidence.',
        ],
    ];

    $heroMetrics = [
        ['value' => number_format($siteStats['published_courses']).'+', 'label' => 'learning modules and program blocks'],
        ['value' => number_format($siteStats['mentors']).'+', 'label' => 'mentor-led sessions and expert support'],
        ['value' => number_format(max(20, $siteStats['students'])).'+', 'label' => 'learners shaped through practical guidance'],
    ];
@endphp

<x-home.marketing-layout title="Corporate Training | CodeInYourself">
    
    <x-slot:head>
        <style>
            .enterprise-hero {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(circle at 10% 14%, rgba(255,255,255,0.18), transparent 20%),
                    radial-gradient(circle at 88% 12%, rgba(216,180,254,0.22), transparent 18%),
                    radial-gradient(circle at 72% 78%, rgba(167,139,250,0.26), transparent 22%),
                    linear-gradient(135deg, #11041d 0%, #220b42 30%, #4d1f87 62%, #7d47de 100%);
            }

            .enterprise-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
                background-size: 84px 84px;
                mask-image: radial-gradient(circle at center, black 32%, transparent 90%);
                opacity: 0.22;
                pointer-events: none;
            }

            .enterprise-hero::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(7, 2, 16, 0.10), rgba(7, 2, 16, 0.34));
                pointer-events: none;
            }

            .enterprise-orbit {
                position: absolute;
                border: 1px solid rgba(255,255,255,0.14);
                border-radius: 9999px;
                pointer-events: none;
            }

            .enterprise-glass {
                background: linear-gradient(180deg, rgba(255,255,255,0.16), rgba(255,255,255,0.08));
                border: 1px solid rgba(255,255,255,0.14);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.10), 0 22px 56px rgba(11, 3, 33, 0.22);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .enterprise-badge {
                background: rgba(255,255,255,0.10);
                border: 1px solid rgba(255,255,255,0.14);
                backdrop-filter: blur(12px);
            }

            .company-pill {
                border: 1px solid rgba(220, 205, 246, 0.75);
                background: rgba(255,255,255,0.82);
                box-shadow: 0 14px 36px rgba(76, 29, 149, 0.08);
            }

            .student-story-card {
                background:
                    radial-gradient(circle at top right, rgba(168,85,247,0.12), transparent 28%),
                    linear-gradient(180deg, rgba(255,255,255,0.96), rgba(248,243,255,0.92));
                border: 1px solid rgba(220, 205, 246, 0.82);
                box-shadow: 0 24px 52px rgba(88, 28, 135, 0.10);
            }

            .number-chip {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 3rem;
                height: 3rem;
                border-radius: 9999px;
                background: linear-gradient(135deg, #6d28d9, #a855f7);
                color: #fff;
                font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
                font-weight: 800;
                box-shadow: 0 16px 34px rgba(124, 58, 237, 0.26);
            }

            .hero-float-panel {
                background: linear-gradient(180deg, rgba(255,255,255,0.20), rgba(255,255,255,0.08));
                border: 1px solid rgba(255,255,255,0.16);
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                box-shadow: 0 22px 50px rgba(9, 2, 24, 0.24);
            }

            .hero-grid-overlay {
                position: absolute;
                inset: 10% 4% 12% auto;
                width: 46%;
                background-image:
                    linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
                background-size: 2.8rem 2.8rem;
                mask-image: radial-gradient(circle at center, black 34%, transparent 80%);
                opacity: 0.45;
                pointer-events: none;
            }

            .logo-showcase-shell {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(circle at 50% 0%, rgba(168,85,247,0.05), transparent 22%),
                    linear-gradient(180deg, rgba(255,255,255,0.72), rgba(252,249,255,0.9));
            }

            .logo-showcase-shell::before,
            .logo-showcase-shell::after {
                content: "";
                position: absolute;
                top: 0;
                bottom: 0;
                width: 5rem;
                z-index: 2;
                pointer-events: none;
            }

            .logo-showcase-shell::before {
                left: 0;
                background: linear-gradient(90deg, rgba(252,249,255,1), rgba(252,249,255,0));
            }

            .logo-showcase-shell::after {
                right: 0;
                background: linear-gradient(270deg, rgba(252,249,255,1), rgba(252,249,255,0));
            }

            .logo-slider {
                overflow: hidden;
            }

            .logo-slider-track {
                display: flex;
                gap: 1.75rem;
                width: max-content;
                animation: logo-slide 36s linear infinite;
                align-items: center;
            }

            .logo-slide {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 240px;
                min-width: 240px;
                height: 88px;
            }

            .logo-slide img {
                width: 82%;
                height: 68%;
                object-fit: contain;
                filter: grayscale(1) brightness(0.35) contrast(1.1);
                opacity: 0.9;
                transform: scale(var(--logo-scale, 1));
                transform-origin: center;
                transition: filter 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
            }

            .logo-slide:hover img {
                filter: grayscale(0) brightness(1) contrast(1);
                opacity: 1;
                transform: scale(var(--logo-scale, 1)) translateY(-2px);
            }

            .logo-placeholder {
                color: #a1a1aa;
                font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
                font-size: clamp(1.45rem, 1.7vw, 2.15rem);
                font-weight: 800;
                letter-spacing: -0.03em;
                text-align: center;
                line-height: 1.02;
                text-wrap: balance;
                width: 100%;
            }

            .logo-placeholder.is-wide {
                font-size: clamp(1.15rem, 1.35vw, 1.65rem);
            }

            .logo-placeholder.is-tight {
                letter-spacing: -0.05em;
            }

            @keyframes logo-slide {
                from { transform: translateX(0); }
                to { transform: translateX(calc(-50% - 0.5rem)); }
            }

            .insight-card {
                background:
                    radial-gradient(circle at top left, rgba(124,58,237,0.12), transparent 28%),
                    linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,243,255,0.94));
                border: 1px solid rgba(220, 205, 246, 0.78);
                box-shadow: 0 20px 48px rgba(88, 28, 135, 0.10);
            }

            @media (max-width: 1024px) {
                .hero-grid-overlay {
                    display: none;
                }
            }
        </style>
    </x-slot:head>

    <main class="overflow-hidden pb-24 pt-0">
        <section class="enterprise-hero relative w-full text-white">
            <div class="enterprise-orbit left-[-8rem] top-24 h-72 w-72"></div>
            <div class="enterprise-orbit right-[-5rem] top-20 h-56 w-56"></div>
            <div class="enterprise-orbit bottom-14 right-[20%] h-40 w-40"></div>

            <div class="relative z-10 mx-auto max-w-[1400px] px-4 pb-16 pt-28 sm:px-6 md:pb-20 md:pt-32 lg:px-8 lg:pb-24">
                <div class="grid gap-10 lg:grid-cols-[minmax(0,1.08fr)_minmax(320px,0.92fr)] lg:items-center">
                    <div class="reveal">
                        <span class="enterprise-badge inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.24em] text-white/80">
                            <span class="h-2 w-2 rounded-full bg-[#d8b4fe]"></span>
                            Corporate Training
                        </span>
                        <h1 class="mt-6 max-w-4xl font-headline text-4xl font-extrabold leading-[0.96] md:text-[4.6rem]">
                            Full-width enterprise training
                            <span class="block text-[#e9d5ff]">built around your company goals.</span>
                        </h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-white/76 md:text-lg">
                            We build structured corporate learning journeys for teams, fresh hires, and assigned learners with mentors, practical projects, company-focused tracks, and clear progress visibility from start to finish.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-7 py-4 text-sm font-bold text-primary">
                                Book A Corporate Discussion
                                <span class="material-symbols-outlined text-[18px]">north_east</span>
                            </a>
                            <a href="{{ route('home.courses') }}" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-white/15 bg-white/10 px-7 py-4 text-sm font-bold text-white">
                                View Learning Catalog
                            </a>
                        </div>
                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            @foreach ($heroMetrics as $metric)
                                <div class="enterprise-glass rounded-[1.6rem] px-5 py-5">
                                    <p class="font-headline text-3xl font-extrabold text-white">{{ $metric['value'] }}</p>
                                    <p class="mt-2 text-sm leading-6 text-white/70">{{ $metric['label'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="reveal relative">
                        <div class="hero-grid-overlay"></div>
                        <div class="enterprise-glass relative rounded-[2rem] p-5 md:p-6">
                            <div class="rounded-[1.7rem] border border-white/12 bg-[linear-gradient(180deg,rgba(255,255,255,0.08),rgba(255,255,255,0.03))] p-6">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.26em] text-white/50">Enterprise Delivery Board</p>
                                        <h2 class="mt-3 font-headline text-2xl font-extrabold text-white">What your company gets</h2>
                                    </div>
                                    <span class="rounded-full bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white/78">Live Plan</span>
                                </div>
                                <div class="mt-6 space-y-4">
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-sm font-bold text-white">Assigned learners and grouped batches</p>
                                        <p class="mt-2 text-sm leading-7 text-white/68">Organized learning for campus hires, internal teams, and role-based cohorts with clear reporting.</p>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-sm font-bold text-white">Mentor reviews and practical assignments</p>
                                        <p class="mt-2 text-sm leading-7 text-white/68">Weekly check-ins, project reviews, and implementation support to keep training actionable.</p>
                                    </div>
                                    <div class="rounded-[1.4rem] border border-white/10 bg-white/8 p-4">
                                        <p class="text-sm font-bold text-white">Company-aligned skills roadmap</p>
                                        <p class="mt-2 text-sm leading-7 text-white/68">Technology paths matched to business needs, delivery timelines, and role expectations.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                <div class="enterprise-badge rounded-[1.4rem] px-5 py-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/54">Mode</p>
                                    <p class="mt-2 text-sm font-semibold text-white">Offline, online, hybrid, weekend, and fast-track formats</p>
                                </div>
                                <div class="enterprise-badge rounded-[1.4rem] px-5 py-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/54">Focus</p>
                                    <p class="mt-2 text-sm font-semibold text-white">Job-readiness, productivity, project execution, and team confidence</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 grid gap-3 sm:grid-cols-3">
                            @foreach ($impactSignals as $signal)
                                <div class="hero-float-panel rounded-[1.3rem] px-4 py-4">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/50">{{ $signal['label'] }}</p>
                                    <p class="mt-2 text-sm font-semibold leading-6 text-white/88">{{ $signal['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto -mt-8 max-w-7xl px-4 sm:px-6">
            <div class="reveal glass-card rounded-[2rem] p-6 md:p-8">
                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">What We Provide</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">A corporate training setup that stays clear, professional, and outcome-focused.</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant md:text-base">
                            This page clearly explains the training offer: assigned learners, company-focused programs, mentor support, project delivery, reporting, and practical skill growth in one connected flow.
                        </p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($engagementModels as $item)
                            <div class="soft-strip rounded-[1.5rem] p-5">
                                <p class="font-headline text-xl font-extrabold">{{ $item['label'] }}</p>
                                <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $item['copy'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="logo-showcase-shell reveal rounded-[2rem] border border-outline/60 px-5 py-8 shadow-soft">
                <div class="relative z-10 text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.32em] text-on-surface-variant">Trusted For Corporate Learning</p>
                </div>

                <div class="logo-slider relative z-10 mt-8">
                    <div class="logo-slider-track">
                        @foreach (array_merge($partnerCompanies, $partnerCompanies) as $company)
                            @php
                                $name = $company['name'];
                                $placeholderClasses = 'logo-placeholder';
                                if (strlen($name) > 12) {
                                    $placeholderClasses .= ' is-wide';
                                }
                                if (in_array($name, ['IBM', 'KPIT', 'TCS', 'HCL', 'Oracle'])) {
                                    $placeholderClasses .= ' is-tight';
                                }
                            @endphp
                            <div class="logo-slide">
                                @if (!empty($company['logo']))
                                    <img alt="{{ $company['name'] }} logo" src="{{ $company['logo'] }}" style="--logo-scale: {{ $company['scale'] ?? 1 }};" />
                                @else
                                    <span class="{{ $placeholderClasses }}">{{ $company['name'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="reveal mb-10 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Training Solutions</p>
                <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">What companies and assigned students receive inside the program.</h2>
            </div>
            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($trainingSolutions as $index => $solution)
                    <article class="glass-card premium-card reveal stagger-{{ ($index % 4) + 1 }} rounded-[1.9rem] p-6">
                        <h3 class="font-headline text-2xl font-extrabold">{{ $solution['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $solution['description'] }}</p>
                        <div class="mt-5 space-y-3">
                            @foreach ($solution['points'] as $point)
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined mt-0.5 text-primary" style="font-variation-settings:'FILL' 1;">check_circle</span>
                                    <span class="text-sm leading-7 text-on-surface-variant">{{ $point }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[0.96fr_1.04fr]">
                <div class="hero-panel reveal rounded-[2rem] p-8 text-white md:p-10">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/58">Why This Feels Better</p>
                    <h2 class="mt-3 max-w-2xl font-headline text-3xl font-extrabold md:text-4xl">A strong corporate page should feel energetic, modern, and easy to trust.</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-white/74 md:text-base">
                        The page uses stronger hierarchy, clearer business messaging, and better storytelling so companies can understand the offer quickly.
                    </p>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($experienceMoments as $index => $moment)
                        <article class="insight-card reveal stagger-{{ ($index % 4) + 1 }} rounded-[1.8rem] p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary">Experience {{ $index + 1 }}</p>
                            <h3 class="mt-4 font-headline text-2xl font-extrabold text-on-surface">{{ $moment['title'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $moment['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="section-panel reveal rounded-[2.2rem] p-8 md:p-10">
                <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Assigned Companies And Team Alignment</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">Programs can be mapped to company expectations, internal roles, and deployment needs.</h2>
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-on-surface-variant md:text-base">
                            Whether you are training freshers for deployment, strengthening existing departments, or creating role-specific technical readiness, the program can be adjusted around your company stack, batch size, and schedule.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            @foreach ($partnerCompanies as $company)
                                <span class="company-pill rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-on-surface">{{ $company['name'] }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="hero-panel rounded-[2rem] p-6 text-white">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/58">Corporate Outcomes</p>
                        <div class="mt-5 space-y-4">
                            <div class="rounded-[1.4rem] border border-white/12 bg-white/8 px-5 py-4">
                                <p class="font-headline text-xl font-extrabold">Better team readiness</p>
                                <p class="mt-2 text-sm leading-7 text-white/74">Teams move from passive sessions to practical execution with structured assignments and review loops.</p>
                            </div>
                            <div class="rounded-[1.4rem] border border-white/12 bg-white/8 px-5 py-4">
                                <p class="font-headline text-xl font-extrabold">Clearer stakeholder visibility</p>
                                <p class="mt-2 text-sm leading-7 text-white/74">Managers can understand batch progress, participation, and capability growth more easily.</p>
                            </div>
                            <div class="rounded-[1.4rem] border border-white/12 bg-white/8 px-5 py-4">
                                <p class="font-headline text-xl font-extrabold">Stronger student and fresher confidence</p>
                                <p class="mt-2 text-sm leading-7 text-white/74">Assigned learners get guided support before joining live project environments or internal teams.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="reveal mb-10 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Student Details</p>
                <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">Assigned student profiles can be showcased clearly inside the corporate journey.</h2>
            </div>
            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($studentStories as $index => $student)
                    <article class="student-story-card reveal stagger-{{ ($index % 4) + 1 }} rounded-[2rem] p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary">Assigned Learner</p>
                                <h3 class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $student['name'] }}</h3>
                                <p class="mt-2 text-sm font-semibold text-on-surface-variant">{{ $student['role'] }}</p>
                            </div>
                            <span class="number-chip">{{ $index + 1 }}</span>
                        </div>
                        <div class="mt-6 rounded-[1.4rem] bg-white/80 px-5 py-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary">Company Mapping</p>
                            <p class="mt-2 text-sm font-semibold text-on-surface">{{ $student['company'] }}</p>
                        </div>
                        <p class="mt-5 text-sm leading-7 text-on-surface-variant">{{ $student['summary'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="glass-card reveal rounded-[2rem] p-8 md:p-10">
                <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Delivery Flow</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">A simple process that keeps the page clean and the service easy to understand.</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant md:text-base">
                            From discovery to reporting, each stage helps the corporate training offer stay organized, professional, and easy to trust.
                        </p>
                    </div>
                    <div class="space-y-4">
                        @foreach ($deliveryFlow as $item)
                            <div class="soft-strip rounded-[1.5rem] px-5 py-5">
                                <div class="flex items-start gap-4">
                                    <span class="number-chip h-12 min-w-[3rem] text-sm">{{ $item['step'] }}</span>
                                    <div>
                                        <p class="font-headline text-xl font-extrabold">{{ $item['title'] }}</p>
                                        <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $item['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="hero-panel reveal rounded-[2.2rem] px-6 py-10 text-white sm:px-8 md:px-10">
                <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/58">Corporate Inquiry</p>
                        <h2 class="mt-3 max-w-3xl font-headline text-3xl font-extrabold md:text-4xl">Looking for a corporate training partner with a stronger enterprise-ready offer?</h2>
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-white/74 md:text-base">
                            Explore the full training story through assigned learner details, company mapping, training solutions, and a business-ready delivery flow.
                        </p>
                    </div>
                    <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-7 py-4 text-sm font-bold uppercase tracking-[0.16em] text-primary">
                        Contact The Team
                        <span class="material-symbols-outlined text-[18px]">north_east</span>
                    </a>
                </div>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
