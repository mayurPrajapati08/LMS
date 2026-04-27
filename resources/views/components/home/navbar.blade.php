@php
    $isHome = true;
    $isCareer = request()->is('career-paths') || request()->is('career-paths/*');
    $isAbout = request()->is('about');
    $isContact = request()->is('contact');
    $navAudience = (string) request()->query('audience', '');
    $navTopic = (string) request()->query('topic', '');
    $aboutUrl = route('home.about');
    $workingProfessionalUrl = route('home.career-paths', ['audience' => 'working-professional']);
    $collegeStudentUrl = route('home.career-paths', ['audience' => 'college-student']);
    $dataScienceUrl = route('home.career-paths.show', ['path' => 'data-science-with-ai']);
    $dataAnalyticsUrl = route('home.career-paths.show', ['path' => 'data-analytics-with-ai']);
    $fullStackWebUrl = route('home.career-paths.show', ['path' => 'web-development-full-stack']);
    $fullStackMasterUrl = route('home.career-paths.show', ['path' => 'full-stack-developer']);
    $generativeAiUrl = route('home.career-paths.show', ['path' => 'generative-ai']);
    $powerBiUrl = route('home.career-paths.show', ['path' => 'power-bi-tableau-development']);
    $mobileAppUrl = route('home.career-paths.show', ['path' => 'mobile-application-development']);
    $workshopUrl = route('home.free_workshop');
    $freeMentorshipUrl = route('home.mentorship');
    $careerWithUsUrl = route('home.career-with-us');
    $isWorkingProfessional = $isCareer && $navAudience === 'working-professional';
    $isCollegeStudent = $isCareer && $navAudience === 'college-student';
    $isWorkshop = request()->routeIs('home.free_workshop') || ($isContact && $navTopic === 'workshop');
    $isFreeMentorship = request()->routeIs('home.mentorship');
    $isCareerWithUs = request()->routeIs('home.career-with-us');
    $isPlainContact = $isContact && $navTopic === '';
    $user = auth()->user();
    $roleName = strtolower($user?->role?->name ?? '');
    $dashboardUrl = match ($roleName) {
        'super admin', 'admin' => route('admin.dashboard'),
        'hr team' => route('hr.dashboard'),
        'instructor' => url('/instructor/dashboard'),
        default => route('student.dashboard'),
    };
    $initials = collect(explode(' ', trim($user->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
    $navbarAvatar = $user?->avatarUrl(96);
    $navbarAvatarFallback = 'https://ui-avatars.com/api/?name='.urlencode($user?->name ?? 'User').'&background=EEF2FF&color=312E81&size=96';
    $workingProfessionalMenu = [
        [
            'key' => 'data-science',
            'label' => 'Data Science',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Advanced certification for professionals',
                    'title' => 'Data Science with AI',
                    'description' => 'Python, machine learning, deep learning, NLP, and portfolio-ready AI projects for serious career growth.',
                    'href' => $dataScienceUrl,
                    'icon' => 'dataset',
                    'badge' => 'Top demand',
                ],
            ],
        ],
        [
            'key' => 'data-analytics',
            'label' => 'Data Analytics',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Business analytics certification',
                    'title' => 'Data Analytics with AI',
                    'description' => 'Excel, SQL, Python, Power BI, Tableau, dashboards, and AI-assisted reporting for analytics roles.',
                    'href' => $dataAnalyticsUrl,
                    'icon' => 'query_stats',
                    'badge' => 'Job focused',
                ],
            ],
        ],
        [
            'key' => 'full-stack-development',
            'label' => 'Full Stack Development',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Role upgrade certification',
                    'title' => 'Full Stack Developer Master Certification',
                    'description' => 'Front-end, back-end, APIs, databases, and deployment skills for professionals growing into stronger engineering roles.',
                    'href' => $fullStackMasterUrl,
                    'icon' => 'deployed_code',
                    'badge' => 'Career upgrade',
                ],
            ],
        ],
        [
            'key' => 'generative-ai',
            'label' => 'Generative AI',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Future skills certification',
                    'title' => 'Generative AI Certification',
                    'description' => 'Prompt engineering, AI workflows, automation, and practical LLM use cases built for working professionals.',
                    'href' => $generativeAiUrl,
                    'icon' => 'auto_awesome',
                    'badge' => 'Trending now',
                ],
            ],
        ],
    ];
    $collegeStudentMenu = [
        [
            'key' => 'full-stack-development',
            'label' => 'Full Stack Development',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Placement-focused student certification',
                    'title' => 'Web Development Full Stack Certification',
                    'description' => 'Build real projects with React, Node.js, APIs, and databases while preparing for internships and placements.',
                    'href' => $fullStackWebUrl,
                    'icon' => 'code_blocks',
                    'badge' => 'Most popular',
                ],
            ],
        ],
        [
            'key' => 'data-analytics',
            'label' => 'Data Analytics',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Student-friendly analytics path',
                    'title' => 'Data Analytics with AI',
                    'description' => 'Learn Excel, SQL, Python, Power BI, and Tableau with project work that strengthens your placement profile.',
                    'href' => $dataAnalyticsUrl,
                    'icon' => 'analytics',
                    'badge' => 'Portfolio ready',
                ],
            ],
        ],
        [
            'key' => 'mobile-app-development',
            'label' => 'Mobile App Development',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'App development certification',
                    'title' => 'Mobile Application Development',
                    'description' => 'Start building Android and iOS projects with modern tools and practical app development workflows.',
                    'href' => $mobileAppUrl,
                    'icon' => 'smartphone',
                    'badge' => 'Hands-on',
                ],
            ],
        ],
        [
            'key' => 'business-intelligence',
            'label' => 'Power BI & Tableau',
            'items' => [
                [
                    'provider' => 'CodeInYourself',
                    'provider_subtitle' => 'Visualization certification',
                    'title' => 'Power BI / Tableau Development',
                    'description' => 'Learn dashboard building, data storytelling, and reporting skills that support analytics and placement roles.',
                    'href' => $powerBiUrl,
                    'icon' => 'monitoring',
                    'badge' => 'Industry tools',
                ],
            ],
        ],
    ];
    $defaultWorkingProfessionalKey = $workingProfessionalMenu[0]['key'];
    $defaultCollegeStudentKey = $collegeStudentMenu[0]['key'];
    $desktopDropdownTriggerBase = 'relative inline-flex items-center gap-2 rounded-full border border-transparent px-5 py-2.5 leading-none transition-[color,background-color,border-color,box-shadow,transform] duration-300 hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 focus-visible:ring-offset-2 focus-visible:ring-offset-[#1b0f2b]';
    $desktopNavLinkBase = 'inline-flex items-center rounded-full border border-transparent px-4 py-2.5 leading-none transition-[color,background-color,border-color,box-shadow,transform] duration-300 hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 focus-visible:ring-offset-2 focus-visible:ring-offset-[#1b0f2b]';
    $desktopNavHomeIdle = 'text-white/85 hover:border-white/12 hover:bg-white/10 hover:text-white hover:shadow-[0_14px_30px_rgba(8,2,20,0.18)]';
    $desktopNavDefaultIdle = 'text-on-surface-variant hover:border-primary/15 hover:bg-primary/5 hover:text-primary hover:shadow-[0_12px_26px_rgba(124,58,237,0.08)]';
@endphp

<x-shared.page-loader />

<!-- TopNavBar -->
<nav @class([
    'fixed top-0 w-full isolate z-[120] transition-all duration-300',
    'border-b border-white/10 bg-[#090314]/55 backdrop-blur-2xl shadow-[0_18px_50px_rgba(6,2,18,0.28)]' => $isHome,
    'border-b border-[#e8dcf7]/80 bg-white/82 backdrop-blur-2xl shadow-[0_16px_40px_rgba(124,58,237,0.12)]' => !$isHome,
])>
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>
    <div @class([
        'pointer-events-none absolute inset-0 opacity-100',
        'bg-[radial-gradient(circle_at_top_left,rgba(192,132,252,0.18),transparent_32%),radial-gradient(circle_at_top_right,rgba(124,58,237,0.14),transparent_30%)]' => $isHome,
        'bg-[radial-gradient(circle_at_top_left,rgba(168,85,247,0.12),transparent_32%),radial-gradient(circle_at_top_right,rgba(124,58,237,0.08),transparent_30%)]' => !$isHome,
    ])></div>

    <div class="relative z-10 flex justify-between items-center px-1 md:px-1 py-3.5 max-w-7xl mx-auto">
        <a href="/" class="group flex items-center">
            @if ($isHome)
             
                <div class="rounded-2xl border border-white/60 bg-white px-4 py-2 shadow-[0_12px_28px_rgba(124,58,237,0.08)] transition-all duration-300 group-hover:-translate-y-0.5 group-hover:shadow-[0_18px_36px_rgba(124,58,237,0.14)]">
                    <img src="https://res.cloudinary.com/dqxg5hhfi/image/upload/v1777111055/cyis_logo_4_ikcbhi.png" alt="CodeInYourself logo" class="h-9 md:h-10 w-auto max-w-[7.2rem] md:max-w-[8.4rem] object-contain" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
                </div>
                @else
                <span class="font-headline text-base font-extrabold tracking-tight text-white md:text-lg transition-transform duration-300 group-hover:scale-[1.02] mr-1">codeinyourself<span class="bg-gradient-to-r from-[#c084fc] via-[#a855f7] to-[#f0abfc] bg-clip-text text-transparent">.</span></span>
           
            @endif
        </a>

        <div class="hidden xl:flex items-center gap-2 rounded-full border px-3 py-2 text-[13px] font-medium tracking-tight shadow-[0_12px_34px_rgba(124,58,237,0.10)] backdrop-blur-xl @if($isHome) border-white/10 bg-white/5 text-white @else border-[#ebdef7] bg-white/75 text-on-surface @endif">
            <div class="group relative">
                <button type="button" @class([
                    $desktopDropdownTriggerBase,
                    'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.32),0_14px_30px_rgba(8,2,20,0.24)] backdrop-blur-xl' => $isHome && $isWorkingProfessional,
                    $desktopNavHomeIdle => $isHome && !$isWorkingProfessional,
                    'text-primary border border-primary/15 bg-primary/10 shadow-[0_10px_22px_rgba(124,58,237,0.12)]' => !$isHome && $isWorkingProfessional,
                    $desktopNavDefaultIdle => !$isHome && !$isWorkingProfessional,
                ])>
                    <span>Working Professional</span>
                    <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:rotate-180 group-focus-within:rotate-180">expand_more</span>
                </button>

                <div class="pointer-events-none invisible absolute left-0 top-full z-50 w-[44rem] translate-y-2 pt-2 opacity-0 transition-all duration-200 group-hover:pointer-events-auto group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:pointer-events-auto group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    <div class="absolute inset-x-0 top-0 h-4"></div>
                    <div @class([
                        'overflow-hidden rounded-[2rem] border shadow-[0_30px_70px_rgba(16,6,38,0.20)]',
                        'border-white/10 bg-[radial-gradient(circle_at_top_right,rgba(216,180,254,0.22),transparent_22%),linear-gradient(180deg,rgba(255,255,255,0.97),rgba(247,241,252,0.98))]' => $isHome,
                        'border-[#eadcf8] bg-[radial-gradient(circle_at_top_right,rgba(216,180,254,0.16),transparent_22%),linear-gradient(180deg,rgba(255,255,255,0.99),rgba(250,245,255,0.98))]' => !$isHome,
                    ])>
                        <div class="grid min-h-[20rem] grid-cols-[250px_minmax(0,1fr)]">
                            <div class="border-r border-[#efe6f8] bg-[linear-gradient(180deg,#fffaf3_0%,#f7f1ff_100%)] px-4 py-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">Working Professional</p>
                                <p class="mt-2 text-[13px] leading-5 text-[#6f6480]">Choose a high-value track built for role growth and practical outcomes.</p>
                                <div class="mt-4 space-y-2">
                                    @foreach ($workingProfessionalMenu as $domain)
                                        <button
                                            type="button"
                                            class="flex w-full items-center justify-between rounded-[1.1rem] border border-transparent px-4 py-3.5 text-left text-[14px] font-semibold text-[#3c3250] transition-all duration-200 hover:border-[#e7d7f6] hover:bg-white/75"
                                            data-desktop-domain-tab="working-professional"
                                            data-domain-key="{{ $domain['key'] }}"
                                        >
                                            <span>{{ $domain['label'] }}</span>
                                            <span class="material-symbols-outlined text-[18px] text-[#3c3250]">chevron_right</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-white/70 px-5 py-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">Featured Programs</p>
                                @foreach ($workingProfessionalMenu as $domain)
                                    <div data-desktop-domain-panel="working-professional" data-domain-key="{{ $domain['key'] }}" @class(['mt-4 space-y-2.5', 'hidden' => $domain['key'] !== $defaultWorkingProfessionalKey])>
                                        @foreach ($domain['items'] as $item)
                                            <a href="{{ $item['href'] }}" class="block rounded-[1.45rem] border border-[#efe4f8] bg-[radial-gradient(circle_at_top_right,rgba(250,204,21,0.14),transparent_18%),linear-gradient(180deg,#ffffff_0%,#fcf8ff_100%)] px-5 py-5 transition-all duration-300 hover:-translate-y-1 hover:border-[#d9bfef] hover:shadow-[0_18px_36px_rgba(124,58,237,0.10)]">
                                                <div class="flex items-start gap-4">
                                                    <span class="mt-0.5 flex h-14 w-14 items-center justify-center rounded-[1.15rem] border border-[#efe4f8] bg-white text-[#8f67b8] shadow-[0_10px_24px_rgba(124,58,237,0.08)]">
                                                        <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                                                    </span>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="flex items-start justify-between gap-3">
                                                            <div class="min-w-0">
                                                                <p class="text-[0.98rem] font-bold leading-6 text-[#4f3ca0]">{{ $item['provider'] }}</p>
                                                                <p class="text-[12px] leading-5 text-[#8a7a9b]">{{ $item['provider_subtitle'] }}</p>
                                                            </div>
                                                            <span class="shrink-0 rounded-full bg-[linear-gradient(135deg,#2b153f_0%,#7c3aed_100%)] px-3 py-1 text-[11px] font-semibold text-white shadow-[0_8px_18px_rgba(124,58,237,0.16)]">{{ $item['badge'] }}</span>
                                                        </div>
                                                        <p class="mt-2 text-[1.08rem] font-semibold leading-7 text-[#221a2d]">{{ $item['title'] }}</p>
                                                        <p class="mt-1 text-[13px] leading-6 text-[#6e6478]">{{ $item['description'] }}</p>
                                                        <div class="mt-4 inline-flex items-center gap-2 text-[12px] font-bold uppercase tracking-[0.18em] text-[#6b3fc8]">
                                                            View Program
                                                            <span class="material-symbols-outlined text-[16px]">north_east</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative">
                <button type="button" @class([
                    $desktopDropdownTriggerBase,
                    'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.32),0_14px_30px_rgba(8,2,20,0.24)] backdrop-blur-xl' => $isHome && $isCollegeStudent,
                    $desktopNavHomeIdle => $isHome && !$isCollegeStudent,
                    'text-primary border border-primary/15 bg-primary/10 shadow-[0_10px_22px_rgba(124,58,237,0.12)]' => !$isHome && $isCollegeStudent,
                    $desktopNavDefaultIdle => !$isHome && !$isCollegeStudent,
                ])>
                    <span>College Student</span>
                    <span class="material-symbols-outlined text-[16px] transition-transform duration-300 group-hover:rotate-180 group-focus-within:rotate-180">expand_more</span>
                </button>

                <div class="pointer-events-none invisible absolute left-0 top-full z-50 w-[44rem] translate-y-2 pt-2 opacity-0 transition-all duration-200 group-hover:pointer-events-auto group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:pointer-events-auto group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    <div class="absolute inset-x-0 top-0 h-4"></div>
                    <div @class([
                        'overflow-hidden rounded-[2rem] border shadow-[0_30px_70px_rgba(16,6,38,0.20)]',
                        'border-white/10 bg-[radial-gradient(circle_at_top_right,rgba(216,180,254,0.22),transparent_22%),linear-gradient(180deg,rgba(255,255,255,0.97),rgba(247,241,252,0.98))]' => $isHome,
                        'border-[#eadcf8] bg-[radial-gradient(circle_at_top_right,rgba(216,180,254,0.16),transparent_22%),linear-gradient(180deg,rgba(255,255,255,0.99),rgba(250,245,255,0.98))]' => !$isHome,
                    ])>
                        <div class="grid min-h-[20rem] grid-cols-[250px_minmax(0,1fr)]">
                            <div class="border-r border-[#efe6f8] bg-[linear-gradient(180deg,#fffaf3_0%,#f7f1ff_100%)] px-4 py-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">College Student</p>
                                <p class="mt-2 text-[13px] leading-5 text-[#6f6480]">Explore practical programs built for internships, projects, and placements.</p>
                                <div class="mt-4 space-y-2">
                                    @foreach ($collegeStudentMenu as $domain)
                                        <button
                                            type="button"
                                            class="flex w-full items-center justify-between rounded-[1.1rem] border border-transparent px-4 py-3.5 text-left text-[14px] font-semibold text-[#3c3250] transition-all duration-200 hover:border-[#e7d7f6] hover:bg-white/75"
                                            data-desktop-domain-tab="college-student"
                                            data-domain-key="{{ $domain['key'] }}"
                                        >
                                            <span>{{ $domain['label'] }}</span>
                                            <span class="material-symbols-outlined text-[18px] text-[#3c3250]">chevron_right</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-white/70 px-5 py-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">Featured Programs</p>
                                @foreach ($collegeStudentMenu as $domain)
                                    <div data-desktop-domain-panel="college-student" data-domain-key="{{ $domain['key'] }}" @class(['mt-4 space-y-2.5', 'hidden' => $domain['key'] !== $defaultCollegeStudentKey])>
                                        @foreach ($domain['items'] as $item)
                                            <a href="{{ $item['href'] }}" class="block rounded-[1.45rem] border border-[#efe4f8] bg-[radial-gradient(circle_at_top_right,rgba(250,204,21,0.14),transparent_18%),linear-gradient(180deg,#ffffff_0%,#fcf8ff_100%)] px-5 py-5 transition-all duration-300 hover:-translate-y-1 hover:border-[#d9bfef] hover:shadow-[0_18px_36px_rgba(124,58,237,0.10)]">
                                                <div class="flex items-start gap-4">
                                                    <span class="mt-0.5 flex h-14 w-14 items-center justify-center rounded-[1.15rem] border border-[#efe4f8] bg-white text-[#8f67b8] shadow-[0_10px_24px_rgba(124,58,237,0.08)]">
                                                        <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                                                    </span>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="flex items-start justify-between gap-3">
                                                            <div class="min-w-0">
                                                                <p class="text-[0.98rem] font-bold leading-6 text-[#4f3ca0]">{{ $item['provider'] }}</p>
                                                                <p class="text-[12px] leading-5 text-[#8a7a9b]">{{ $item['provider_subtitle'] }}</p>
                                                            </div>
                                                            <span class="shrink-0 rounded-full bg-[linear-gradient(135deg,#2b153f_0%,#7c3aed_100%)] px-3 py-1 text-[11px] font-semibold text-white shadow-[0_8px_18px_rgba(124,58,237,0.16)]">{{ $item['badge'] }}</span>
                                                        </div>
                                                        <p class="mt-2 text-[1.08rem] font-semibold leading-7 text-[#221a2d]">{{ $item['title'] }}</p>
                                                        <p class="mt-1 text-[13px] leading-6 text-[#6e6478]">{{ $item['description'] }}</p>
                                                        <div class="mt-4 inline-flex items-center gap-2 text-[12px] font-bold uppercase tracking-[0.18em] text-[#6b3fc8]">
                                                            View Program
                                                            <span class="material-symbols-outlined text-[16px]">north_east</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ $workshopUrl }}" @class([
                $desktopNavLinkBase,
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.32),0_14px_30px_rgba(8,2,20,0.24)] backdrop-blur-xl' => $isHome && $isWorkshop,
                $desktopNavHomeIdle => $isHome && !$isWorkshop,
                'text-primary border border-primary/15 bg-primary/10 shadow-[0_10px_22px_rgba(124,58,237,0.12)]' => !$isHome && $isWorkshop,
                $desktopNavDefaultIdle => !$isHome && !$isWorkshop,
            ])>Workshop</a>

            <a href="{{ $freeMentorshipUrl }}" @class([
                $desktopNavLinkBase,
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.32),0_14px_30px_rgba(8,2,20,0.24)] backdrop-blur-xl' => $isHome && $isFreeMentorship,
                $desktopNavHomeIdle => $isHome && !$isFreeMentorship,
                'text-primary border border-primary/15 bg-primary/10 shadow-[0_10px_22px_rgba(124,58,237,0.12)]' => !$isHome && $isFreeMentorship,
                $desktopNavDefaultIdle => !$isHome && !$isFreeMentorship,
            ])>Free Mentorship</a>

            <a href="{{ $careerWithUsUrl }}" @class([
                $desktopNavLinkBase,
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.32),0_14px_30px_rgba(8,2,20,0.24)] backdrop-blur-xl' => $isHome && $isCareerWithUs,
                $desktopNavHomeIdle => $isHome && !$isCareerWithUs,
                'text-primary border border-primary/15 bg-primary/10 shadow-[0_10px_22px_rgba(124,58,237,0.12)]' => !$isHome && $isCareerWithUs,
                $desktopNavDefaultIdle => !$isHome && !$isCareerWithUs,
            ])>Career With Us</a>

            <a href="{{ $aboutUrl }}" @class([
                $desktopNavLinkBase,
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.32),0_14px_30px_rgba(8,2,20,0.24)] backdrop-blur-xl' => $isHome && $isAbout,
                $desktopNavHomeIdle => $isHome && !$isAbout,
                'text-primary border border-primary/15 bg-primary/10 shadow-[0_10px_22px_rgba(124,58,237,0.12)]' => !$isHome && $isAbout,
                $desktopNavDefaultIdle => !$isHome && !$isAbout,
            ])>About Us</a>
        </div>

        <div class="flex items-center gap-3 md:gap-4">
            @auth
                <a href="{{ $dashboardUrl }}" @class([
                    'hidden md:flex items-center gap-3 rounded-full px-2.5 py-2 transition-all duration-300',
                    'border border-white/15 bg-white/10 text-white shadow-[0_14px_34px_rgba(6,2,18,0.2)] backdrop-blur-xl hover:-translate-y-0.5 hover:bg-white/14 hover:shadow-[0_20px_44px_rgba(6,2,18,0.28)]' => $isHome,
                    'border border-[#eadcf8] bg-white/85 shadow-[0_14px_32px_rgba(124,58,237,0.10)] hover:-translate-y-0.5 hover:border-[#c084fc]/40 hover:shadow-[0_20px_40px_rgba(124,58,237,0.16)]' => !$isHome,
                ])>
                    <img alt="{{ $user->name }} avatar" class="h-10 w-10 rounded-full object-cover shadow-[0_12px_24px_rgba(124,58,237,0.35)]" src="{{ $navbarAvatar }}" onerror="this.onerror=null;this.src='{{ $navbarAvatarFallback }}';" />
                    <!-- <span class="flex min-w-0 flex-col pr-1 leading-tight">
                        <span @class([
                            'max-w-[120px] truncate text-sm font-semibold',
                            'text-white' => $isHome,
                            'text-on-surface' => !$isHome,
                        ])>{{ $user->name }}</span>
                        <span @class([
                            'text-[10px] font-semibold uppercase tracking-[0.18em]',
                            'text-white/55' => $isHome,
                            'text-primary/70' => !$isHome,
                        ])>Dashboard</span>
                    </span> -->
                </a>
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button @class([
                        'rounded-full px-4 py-2.5 text-sm font-semibold transition-all duration-300',
                        'border border-white/15 bg-white/8 text-white hover:-translate-y-0.5 hover:bg-white/12' => $isHome,
                        'border border-[#eddff8] bg-white/80 text-on-surface hover:-translate-y-0.5 hover:border-red-200 hover:bg-red-50 hover:text-red-600' => !$isHome,
                    ]) type="submit">Logout</button>
                </form>
            @else
                <button @class([
                    'hidden md:block rounded-full font-semibold text-sm px-4 py-2.5 transition-all duration-300',
                    'border border-transparent text-white/90 hover:bg-white/10 hover:text-white' => $isHome,
                    'text-on-surface hover:bg-primary/5 hover:text-primary' => !$isHome,
                ]) onclick="window.location.href='/login'">Login</button>
                <button @class([
                    'hidden sm:block font-bold text-sm px-4 md:px-6 py-3 rounded-full transition-all duration-300',
                    'border border-white/30 bg-[linear-gradient(180deg,rgba(255,255,255,0.92),rgba(243,232,255,0.72))] text-primary shadow-[inset_0_1px_0_rgba(255,255,255,0.9),0_18px_40px_rgba(255,255,255,0.18)] backdrop-blur-xl' => $isHome && $isPlainContact,
                    'bg-gradient-to-r from-white via-[#faf5ff] to-[#f3e8ff] text-primary shadow-[0_18px_40px_rgba(255,255,255,0.16)] hover:-translate-y-0.5 hover:shadow-[0_24px_48px_rgba(255,255,255,0.2)]' => $isHome && !$isPlainContact,
                    'bg-gradient-to-r from-[#6a3378] via-[#8f52a3] to-[#c79ad4] text-white shadow-[0_18px_40px_rgba(106,51,120,0.24)] hover:-translate-y-0.5 hover:brightness-110 hover:shadow-[0_24px_52px_rgba(106,51,120,0.28)]' => !$isHome,
                ]) onclick="window.location.href='/contact'">Contact Us</button>
            @endauth

            <button type="button" @class([
                'xl:hidden relative w-11 h-11 rounded-2xl flex items-center justify-center shadow-[0_14px_30px_rgba(124,58,237,0.16)] transition-all duration-300',
                'border border-white/15 bg-white/10 text-white backdrop-blur-xl hover:bg-white/15' => $isHome,
                'border border-[#eadcf8] bg-white/85 text-[#6a3378] hover:border-[#c084fc]/40 hover:bg-white' => !$isHome,
            ]) aria-label="Open menu" onclick="toggleHomeMobileMenu()">
                <span class="absolute inset-x-2 top-0 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent"></span>
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <div id="homeMobileMenu" @class([
        'xl:hidden hidden px-4 pb-5 pt-3 shadow-[0_24px_48px_rgba(58,19,96,0.18)]',
        'border-t border-white/10 bg-[#12081f]/96 backdrop-blur-2xl' => $isHome,
        'border-t border-[#eadcf8] bg-white/92 backdrop-blur-2xl' => !$isHome,
    ])>
        <div @class([
            'space-y-2 rounded-[1.6rem] border p-3',
            'border-white/10 bg-white/5' => $isHome,
            'border-[#eee2fa] bg-gradient-to-br from-white via-[#fcf9ff] to-[#f8f1ff]' => !$isHome,
        ])>
            <div @class([
                'rounded-[1.2rem] p-2',
                'border border-white/10 bg-white/5' => $isHome,
                'border border-[#ece1f8] bg-white/80 shadow-[0_10px_24px_rgba(124,58,237,0.05)]' => !$isHome,
            ])>
                <button type="button" onclick="toggleHomeAudienceMenu('workingProfessional')" @class([
                    'flex w-full items-center justify-between rounded-xl px-3.5 py-3 text-sm font-semibold transition-all duration-300',
                    'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isWorkingProfessional,
                    'text-white hover:bg-white/10' => $isHome && !$isWorkingProfessional,
                    'text-primary bg-primary/10' => !$isHome && $isWorkingProfessional,
                    'text-on-surface-variant hover:bg-surface hover:text-primary' => !$isHome && !$isWorkingProfessional,
                ])>
                    <span>Working Professional</span>
                    <span id="workingProfessionalMenuIcon" class="material-symbols-outlined text-[18px] transition-transform duration-300">expand_more</span>
                </button>

                <div id="workingProfessionalMenu" class="hidden space-y-2 px-2 pb-1 pt-2">
                    @foreach ($workingProfessionalMenu as $domain)
                        <div @class([
                            'rounded-[1rem] p-2',
                            'border border-white/10 bg-white/5' => $isHome,
                            'border border-[#f0e6f8] bg-white/80' => !$isHome,
                        ])>
                            <p @class([
                                'px-3 py-2 text-[11px] font-bold uppercase tracking-[0.18em]',
                                'text-[#d8b4fe]' => $isHome,
                                'text-primary/70' => !$isHome,
                            ])>{{ $domain['label'] }}</p>
                            @foreach ($domain['items'] as $item)
                                <a href="{{ $item['href'] }}" onclick="toggleHomeMobileMenu(false)" @class([
                                    'flex items-start gap-3 rounded-xl px-3 py-3 transition-all duration-300',
                                    'text-white hover:bg-white/10' => $isHome,
                                    'text-on-surface hover:bg-white hover:text-primary' => !$isHome,
                                ])>
                                    <span @class([
                                        'mt-0.5 flex h-9 w-9 items-center justify-center rounded-2xl',
                                        'bg-white/10 text-[#d8b4fe]' => $isHome,
                                        'bg-primary/10 text-primary' => !$isHome,
                                    ])><span class="material-symbols-outlined text-[18px]">{{ $item['icon'] }}</span></span>
                                    <span class="flex-1">
                                        <span class="block text-sm font-semibold">{{ $item['title'] }}</span>
                                        <span @class([
                                            'mt-1 block text-xs leading-5',
                                            'text-white/65' => $isHome,
                                            'text-on-surface-variant' => !$isHome,
                                        ])>{{ $item['description'] }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div @class([
                'rounded-[1.2rem] p-2',
                'border border-white/10 bg-white/5' => $isHome,
                'border border-[#ece1f8] bg-white/80 shadow-[0_10px_24px_rgba(124,58,237,0.05)]' => !$isHome,
            ])>
                <button type="button" onclick="toggleHomeAudienceMenu('collegeStudent')" @class([
                    'flex w-full items-center justify-between rounded-xl px-3.5 py-3 text-sm font-semibold transition-all duration-300',
                    'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isCollegeStudent,
                    'text-white hover:bg-white/10' => $isHome && !$isCollegeStudent,
                    'text-primary bg-primary/10' => !$isHome && $isCollegeStudent,
                    'text-on-surface-variant hover:bg-surface hover:text-primary' => !$isHome && !$isCollegeStudent,
                ])>
                    <span>College Student</span>
                    <span id="collegeStudentMenuIcon" class="material-symbols-outlined text-[18px] transition-transform duration-300">expand_more</span>
                </button>

                <div id="collegeStudentMenu" class="hidden space-y-2 px-2 pb-1 pt-2">
                    @foreach ($collegeStudentMenu as $domain)
                        <div @class([
                            'rounded-[1rem] p-2',
                            'border border-white/10 bg-white/5' => $isHome,
                            'border border-[#f0e6f8] bg-white/80' => !$isHome,
                        ])>
                            <p @class([
                                'px-3 py-2 text-[11px] font-bold uppercase tracking-[0.18em]',
                                'text-[#d8b4fe]' => $isHome,
                                'text-primary/70' => !$isHome,
                            ])>{{ $domain['label'] }}</p>
                            @foreach ($domain['items'] as $item)
                                <a href="{{ $item['href'] }}" onclick="toggleHomeMobileMenu(false)" @class([
                                    'flex items-start gap-3 rounded-xl px-3 py-3 transition-all duration-300',
                                    'text-white hover:bg-white/10' => $isHome,
                                    'text-on-surface hover:bg-white hover:text-primary' => !$isHome,
                                ])>
                                    <span @class([
                                        'mt-0.5 flex h-9 w-9 items-center justify-center rounded-2xl',
                                        'bg-white/10 text-[#d8b4fe]' => $isHome,
                                        'bg-primary/10 text-primary' => !$isHome,
                                    ])><span class="material-symbols-outlined text-[18px]">{{ $item['icon'] }}</span></span>
                                    <span class="flex-1">
                                        <span class="block text-sm font-semibold">{{ $item['title'] }}</span>
                                        <span @class([
                                            'mt-1 block text-xs leading-5',
                                            'text-white/65' => $isHome,
                                            'text-on-surface-variant' => !$isHome,
                                        ])>{{ $item['description'] }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <a href="{{ $workshopUrl }}" onclick="toggleHomeMobileMenu(false)" @class([
                'block rounded-xl px-3.5 py-3 font-semibold text-sm transition-all duration-300',
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isWorkshop,
                'text-white hover:bg-white/10' => $isHome && !$isWorkshop,
                'text-primary bg-primary/10' => !$isHome && $isWorkshop,
                'text-on-surface-variant hover:bg-white hover:text-primary' => !$isHome && !$isWorkshop,
            ])>Workshop</a>

            <a href="{{ $freeMentorshipUrl }}" onclick="toggleHomeMobileMenu(false)" @class([
                'block rounded-xl px-3.5 py-3 font-semibold text-sm transition-all duration-300',
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isFreeMentorship,
                'text-white hover:bg-white/10' => $isHome && !$isFreeMentorship,
                'text-primary bg-primary/10' => !$isHome && $isFreeMentorship,
                'text-on-surface-variant hover:bg-white hover:text-primary' => !$isHome && !$isFreeMentorship,
            ])>Free Mentorship</a>

            <a href="{{ $careerWithUsUrl }}" onclick="toggleHomeMobileMenu(false)" @class([
                'block rounded-xl px-3.5 py-3 font-semibold text-sm transition-all duration-300',
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isCareerWithUs,
                'text-white hover:bg-white/10' => $isHome && !$isCareerWithUs,
                'text-primary bg-primary/10' => !$isHome && $isCareerWithUs,
                'text-on-surface-variant hover:bg-white hover:text-primary' => !$isHome && !$isCareerWithUs,
            ])>Career With Us</a>

            <a href="{{ $aboutUrl }}" onclick="toggleHomeMobileMenu(false)" @class([
                'block rounded-xl px-3.5 py-3 font-semibold text-sm transition-all duration-300',
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isAbout,
                'text-white hover:bg-white/10' => $isHome && !$isAbout,
                'text-primary bg-primary/10' => !$isHome && $isAbout,
                'text-on-surface-variant hover:bg-white hover:text-primary' => !$isHome && !$isAbout,
            ])>About Us</a>

            <a href="/contact" onclick="toggleHomeMobileMenu(false)" @class([
                'block rounded-xl px-3.5 py-3 font-semibold text-sm transition-all duration-300',
                'border border-white/25 bg-[linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0.10))] text-[#d8b4fe] shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_12px_26px_rgba(8,2,20,0.22)] backdrop-blur-xl' => $isHome && $isPlainContact,
                'text-white hover:bg-white/10' => $isHome && !$isPlainContact,
                'text-primary bg-primary/10' => !$isHome && $isPlainContact,
                'text-on-surface-variant hover:bg-white hover:text-primary' => !$isHome && !$isPlainContact,
            ])>Contact Us</a>

            @auth
                <div class="pt-3 space-y-2">
                    <a href="{{ $dashboardUrl }}" @class([
                        'flex w-full items-center gap-3 rounded-[1.2rem] border px-4 py-3.5 transition-all duration-300',
                        'border-white/10 bg-white/8 text-white' => $isHome,
                        'border-[#ece0f8] bg-white shadow-[0_12px_28px_rgba(124,58,237,0.06)]' => !$isHome,
                    ])>
                        <img alt="{{ $user->name }} avatar" class="h-10 w-10 rounded-full object-cover shadow-[0_10px_22px_rgba(124,58,237,0.28)]" src="{{ $navbarAvatar }}" onerror="this.onerror=null;this.src='{{ $navbarAvatarFallback }}';" />
                        <span class="min-w-0 flex-1">
                            <span @class([
                                'block truncate text-sm font-semibold',
                                'text-white' => $isHome,
                                'text-on-surface' => !$isHome,
                            ])>{{ $user->name }}</span>
                            <span @class([
                                'block text-[10px] font-semibold uppercase tracking-[0.18em]',
                                'text-white/55' => $isHome,
                                'text-primary/70' => !$isHome,
                            ])>Dashboard</span>
                        </span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button @class([
                            'w-full rounded-[1rem] border px-4 py-3 text-sm font-semibold transition-all duration-300',
                            'border-white/10 bg-white/8 text-white hover:bg-white/12' => $isHome,
                            'border-red-200 bg-red-50 text-red-600 hover:bg-red-100' => !$isHome,
                        ]) type="submit">Logout</button>
                    </form>
                </div>
            @else
                <div class="pt-3 space-y-2">
                    <button @class([
                        'w-full rounded-[1rem] text-sm px-4 py-3 font-semibold transition-all duration-300',
                        'border border-white/15 bg-white/8 text-white hover:bg-white/12' => $isHome,
                        'border border-[#eadcf8] bg-white text-on-surface hover:bg-primary/5 hover:text-primary' => !$isHome,
                    ]) onclick="window.location.href='/login'">Login</button>
                    <button @class([
                        'w-full rounded-[1rem] text-sm px-6 py-3.5 font-bold transition-all duration-300',
                        'bg-gradient-to-r from-white via-[#faf5ff] to-[#f3e8ff] text-primary shadow-[0_16px_36px_rgba(255,255,255,0.16)]' => $isHome,
                        'bg-gradient-to-r from-[#6a3378] via-[#8f52a3] to-[#c79ad4] text-white shadow-[0_16px_36px_rgba(106,51,120,0.2)]' => !$isHome,
                    ]) onclick="window.location.href='/login'">Enroll Now</button>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    (function () {
        var navbar = document.querySelector('nav');
        if (!navbar) return;

        function syncNavbarScrollState() {
            navbar.classList.toggle('nav-scrolled', window.scrollY > 60);
        }

        syncNavbarScrollState();
        window.addEventListener('scroll', syncNavbarScrollState, { passive: true });
    })();
</script>

<style>
    nav.nav-scrolled {
        background: rgba(14, 6, 34, 0.88) !important;
        border-bottom-color: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3) !important;
    }
</style>

<div id="homeMobileOverlay" class="fixed inset-0 bg-[#12081f]/55 backdrop-blur-[2px] z-40 hidden xl:hidden" onclick="toggleHomeMobileMenu(false)"></div>

<script>
    if (!window.toggleHomeMobileMenu) {
        window.toggleHomeMobileMenu = function (forceOpen) {
            var menu = document.getElementById('homeMobileMenu');
            var overlay = document.getElementById('homeMobileOverlay');
            if (!menu || !overlay) return;

            var open = typeof forceOpen === 'boolean' ? forceOpen : menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !open);
            overlay.classList.toggle('hidden', !open);
            document.body.classList.toggle('overflow-hidden', open);
        };
    }

    if (!window.toggleHomeAudienceMenu) {
        window.toggleHomeAudienceMenu = function (menuKey) {
            var menuMap = {
                workingProfessional: {
                    menu: document.getElementById('workingProfessionalMenu'),
                    icon: document.getElementById('workingProfessionalMenuIcon'),
                },
                collegeStudent: {
                    menu: document.getElementById('collegeStudentMenu'),
                    icon: document.getElementById('collegeStudentMenuIcon'),
                },
            };

            Object.keys(menuMap).forEach(function (key) {
                var item = menuMap[key];
                if (!item.menu) return;

                var shouldOpen = key === menuKey ? item.menu.classList.contains('hidden') : false;
                item.menu.classList.toggle('hidden', !shouldOpen);

                if (item.icon) {
                    item.icon.style.transform = shouldOpen ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            });
        };
    }

    if (!window.setDesktopAudienceDomain) {
        window.setDesktopAudienceDomain = function (menuKey, domainKey) {
            document.querySelectorAll('[data-desktop-domain-tab="' + menuKey + '"]').forEach(function (tab) {
                var active = tab.getAttribute('data-domain-key') === domainKey;
                tab.classList.toggle('bg-white', active);
                tab.classList.toggle('border-[#e7d7f6]', active);
                tab.classList.toggle('text-[#2f263a]', active);
                tab.classList.toggle('shadow-[0_12px_24px_rgba(124,58,237,0.10)]', active);
            });

            document.querySelectorAll('[data-desktop-domain-panel="' + menuKey + '"]').forEach(function (panel) {
                panel.classList.toggle('hidden', panel.getAttribute('data-domain-key') !== domainKey);
            });
        };
    }

    (function () {
        document.querySelectorAll('[data-desktop-domain-tab="working-professional"]').forEach(function (tab) {
            tab.addEventListener('mouseenter', function () {
                window.setDesktopAudienceDomain('working-professional', tab.getAttribute('data-domain-key'));
            });
            tab.addEventListener('click', function () {
                window.setDesktopAudienceDomain('working-professional', tab.getAttribute('data-domain-key'));
            });
        });

        document.querySelectorAll('[data-desktop-domain-tab="college-student"]').forEach(function (tab) {
            tab.addEventListener('mouseenter', function () {
                window.setDesktopAudienceDomain('college-student', tab.getAttribute('data-domain-key'));
            });
            tab.addEventListener('click', function () {
                window.setDesktopAudienceDomain('college-student', tab.getAttribute('data-domain-key'));
            });
        });

        window.setDesktopAudienceDomain('working-professional', '{{ $defaultWorkingProfessionalKey }}');
        window.setDesktopAudienceDomain('college-student', '{{ $defaultCollegeStudentKey }}');
    })();
</script>
