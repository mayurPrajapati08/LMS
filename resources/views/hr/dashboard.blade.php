@php
    $statCards = [
        ['label' => 'Active Slides', 'value' => $stats['slides'] ?? 0, 'icon' => 'slideshow', 'tone' => 'sky'],
        ['label' => 'Founder Media', 'value' => $stats['founder_media'] ?? 0, 'icon' => 'play_circle', 'tone' => 'sky'],
        ['label' => 'Active Stories', 'value' => $stats['stories'] ?? 0, 'icon' => 'auto_stories', 'tone' => 'cyan'],
        ['label' => 'Achievements', 'value' => $stats['achievements'] ?? 0, 'icon' => 'gallery_thumbnail', 'tone' => 'violet'],
        ['label' => 'Open Jobs', 'value' => $stats['jobs'] ?? 0, 'icon' => 'work', 'tone' => 'amber'],
        ['label' => 'Workshops', 'value' => $stats['workshops'] ?? 0, 'icon' => 'edit_calendar', 'tone' => 'rose'],
        ['label' => 'Offline Courses', 'value' => $stats['offline_courses'] ?? 0, 'icon' => 'menu_book', 'tone' => 'sky'],
        ['label' => 'Featured Faculty', 'value' => $stats['featured_faculty'] ?? 0, 'icon' => 'school', 'tone' => 'emerald'],
    ];

    $leadCards = [
        ['label' => 'New Inquiries', 'value' => $stats['new_inquiries'] ?? 0, 'icon' => 'mark_email_unread', 'tone' => 'sky'],
        ['label' => 'Workshop Leads', 'value' => $stats['workshop_leads'] ?? 0, 'icon' => 'event_available', 'tone' => 'violet'],
        ['label' => 'Career Leads', 'value' => $stats['career_leads'] ?? 0, 'icon' => 'badge', 'tone' => 'amber'],
        ['label' => 'Mentorship Leads', 'value' => $stats['mentorship_leads'] ?? 0, 'icon' => 'groups', 'tone' => 'emerald'],
    ];

    $contentTools = [
        ['title' => 'Manage Home Slides', 'copy' => 'Refresh the hero area and homepage visual flow.', 'route' => route('hr.slides'), 'icon' => 'slideshow', 'tone' => 'from-sky-500 to-cyan-400'],
        ['title' => 'Manage Founder Media', 'copy' => 'Control the founder video/image slot separately from slides.', 'route' => route('hr.founder-media'), 'icon' => 'play_circle', 'tone' => 'from-sky-600 to-indigo-500'],
        ['title' => 'Manage Stories', 'copy' => 'Update placement and success story sections with less clutter.', 'route' => route('hr.stories'), 'icon' => 'auto_stories', 'tone' => 'from-cyan-500 to-teal-400'],
        ['title' => 'Manage Achievements', 'copy' => 'Control gallery items and showcase cards clearly.', 'route' => route('hr.achievements'), 'icon' => 'gallery_thumbnail', 'tone' => 'from-violet-500 to-fuchsia-400'],
        ['title' => 'Manage Jobs', 'copy' => 'Keep openings, roles, and hiring pages current.', 'route' => route('hr.jobs'), 'icon' => 'work', 'tone' => 'from-amber-500 to-orange-400'],
        ['title' => 'Manage Faculty', 'copy' => 'Highlight the right instructors on the public site.', 'route' => route('hr.faculty'), 'icon' => 'school', 'tone' => 'from-emerald-500 to-teal-400'],
        ['title' => 'Manage Workshops', 'copy' => 'Organize workshop content and visibility faster.', 'route' => route('hr.workshops'), 'icon' => 'edit_calendar', 'tone' => 'from-rose-500 to-pink-400'],
        ['title' => 'Manage Offline Courses', 'copy' => 'Create and control classroom-first course cards for the public catalog.', 'route' => route('hr.offline-courses'), 'icon' => 'menu_book', 'tone' => 'from-sky-500 to-indigo-500'],
    ];

    $leadBoards = [
        ['title' => 'All Public Inquiries', 'copy' => 'See every incoming message in one place.', 'route' => route('hr.inquiries'), 'icon' => 'support_agent'],
        ['title' => 'Workshop Registrations', 'copy' => 'Follow up with event-driven leads quickly.', 'route' => route('hr.inquiries.workshops'), 'icon' => 'event_available'],
        ['title' => 'Career Inquiries', 'copy' => 'Track candidates and hiring-related messages.', 'route' => route('hr.inquiries.careers'), 'icon' => 'badge'],
        ['title' => 'Free Mentorship Leads', 'copy' => 'Review students asking for guidance and support.', 'route' => route('hr.mentorship'), 'icon' => 'groups'],
    ];

    $toneClasses = [
        'sky' => 'bg-sky-100 text-sky-700',
        'cyan' => 'bg-cyan-100 text-cyan-700',
        'violet' => 'bg-violet-100 text-violet-700',
        'amber' => 'bg-amber-100 text-amber-700',
        'rose' => 'bg-rose-100 text-rose-700',
        'emerald' => 'bg-emerald-100 text-emerald-700',
    ];
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>HR Dashboard | CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0284c7',
                        surface: '#f8fbff',
                        ink: '#0f172a',
                    },
                    fontFamily: {
                        headline: ['Manrope'],
                        body: ['Inter'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .dashboard-panel { border: 1px solid rgba(226, 232, 240, 0.92); border-radius: 1.7rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96)); box-shadow: 0 20px 50px rgba(15, 23, 42, 0.06); }
        .mesh-card::before { content: ""; position: absolute; inset: 0; background:
            radial-gradient(circle at top left, rgba(125,211,252,0.28), transparent 34%),
            radial-gradient(circle at bottom right, rgba(192,132,252,0.24), transparent 30%),
            radial-gradient(circle at 60% 20%, rgba(255,255,255,0.2), transparent 24%);
            pointer-events: none; }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f6fbff_0%,#eef4ff_48%,#f8fbff_100%)] text-ink">
    <x-hr.navbar />

    <main class="px-4 py-8 md:ml-64 md:px-8">
        <div class="mx-auto max-w-7xl space-y-8">
            <section class="mesh-card relative overflow-hidden rounded-[2.2rem] bg-[linear-gradient(135deg,#081f3a_0%,#0f4c81_45%,#22c1c3_100%)] px-6 py-7 text-white shadow-[0_32px_90px_rgba(8,31,58,0.28)] md:px-8 md:py-8">
                <div class="relative z-10 grid gap-6 xl:grid-cols-[1.15fr_0.85fr] xl:items-end">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-sky-100/80">HR Command Center</p>
                        <h1 class="mt-3 max-w-4xl font-headline text-3xl font-extrabold leading-tight md:text-[2.8rem]">A cleaner dashboard for content, leads, and follow-up work.</h1>
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-sky-50/82">This workspace is now structured to help the HR team see what needs attention, jump into the right admin tools quickly, and review public inquiries without the screen feeling flat or crowded.</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-sky-800 shadow-[0_12px_28px_rgba(255,255,255,0.18)]" href="{{ route('hr.inquiries') }}">Review Leads</a>
                            <a class="rounded-full border border-white/25 bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm" href="{{ route('hr.stories') }}">Manage Stories</a>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[1.6rem] border border-white/18 bg-white/10 p-4 backdrop-blur-md">
                            <div class="flex items-center gap-3">
                                <img alt="{{ $user->name }}" class="h-14 w-14 rounded-2xl border border-white/25 object-cover" src="{{ $profileAvatar }}" />
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-sky-100/72">Signed In</p>
                                    <p class="mt-1 text-lg uppercase font-extrabold text-white">{{ $user->name }}</p>
                                </div>
                            </div>
                            <p class="mt-4 text-sm leading-6 text-sky-50/78">Use this dashboard to update homepage content and stay responsive to incoming leads.</p>
                        </div>
                        <div class="rounded-[1.6rem] border border-white/18 bg-white/10 p-4 backdrop-blur-md">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-sky-100/72">Priority Snapshot</p>
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between rounded-2xl bg-black/10 px-3 py-3">
                                    <span class="text-sm font-semibold text-white/90">New inquiries</span>
                                    <span class="text-lg font-extrabold text-white">{{ $stats['new_inquiries'] ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-black/10 px-3 py-3">
                                    <span class="text-sm font-semibold text-white/90">Content items live</span>
                                    <span class="text-lg font-extrabold text-white">{{ ($stats['slides'] ?? 0) + ($stats['stories'] ?? 0) + ($stats['achievements'] ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="dashboard-panel p-6 md:p-7">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Content Health</p>
                        <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Public site content overview</h2>
                    </div>
                    <p class="text-sm text-slate-500">Everything visible on the homepage, placements, and showcase sections.</p>
                </div>
                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($statCards as $card)
                        <article class="rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-[0_14px_32px_rgba(15,23,42,0.04)]">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $card['label'] }}</p>
                                    <p class="mt-4 font-headline text-3xl font-extrabold text-slate-900">{{ $card['value'] }}</p>
                                </div>
                                <span class="rounded-2xl p-3 {{ $toneClasses[$card['tone']] ?? 'bg-slate-100 text-slate-700' }}">
                                    <span class="material-symbols-outlined">{{ $card['icon'] }}</span>
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
                <section class="dashboard-panel p-6 md:p-7">
                    <div class="flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">Lead Tracking</p>
                            <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Inquiry pipeline snapshot</h2>
                        </div>
                        <a class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white" href="{{ route('hr.inquiries') }}">Open Lead Boards</a>
                    </div>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        @foreach ($leadCards as $card)
                            <article class="rounded-[1.5rem] border border-slate-200 bg-[linear-gradient(180deg,#ffffff_0%,#f8fafc_100%)] p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="rounded-2xl p-3 {{ $toneClasses[$card['tone']] ?? 'bg-slate-100 text-slate-700' }}">
                                        <span class="material-symbols-outlined">{{ $card['icon'] }}</span>
                                    </span>
                                    <p class="font-headline text-3xl font-extrabold text-slate-900">{{ $card['value'] }}</p>
                                </div>
                                <p class="mt-4 text-sm font-semibold text-slate-700">{{ $card['label'] }}</p>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-6 grid gap-3">
                        @foreach ($leadBoards as $item)
                            <a class="group flex items-center justify-between rounded-[1.3rem] border border-slate-200 bg-slate-50 px-4 py-4 transition hover:border-sky-200 hover:bg-sky-50/60" href="{{ $item['route'] }}">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800">{{ $item['title'] }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $item['copy'] }}</p>
                                </div>
                                <span class="material-symbols-outlined text-slate-400 transition group-hover:text-sky-700">{{ $item['icon'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="dashboard-panel p-6 md:p-7">
                    <div class="flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-emerald-700">Content Tools</p>
                            <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Quick actions for the HR team</h2>
                        </div>
                        <p class="text-sm text-slate-500">Jump directly into the sections you update most often.</p>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        @foreach ($contentTools as $tool)
                            <a class="group overflow-hidden rounded-[1.55rem] border border-slate-200 bg-white p-5 shadow-[0_12px_28px_rgba(15,23,42,0.04)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_36px_rgba(15,23,42,0.08)]" href="{{ $tool['route'] }}">
                                <div class="flex items-start justify-between gap-4">
                                    <span class="rounded-2xl bg-gradient-to-br {{ $tool['tone'] }} p-3 text-white shadow-[0_10px_24px_rgba(15,23,42,0.12)]">
                                        <span class="material-symbols-outlined">{{ $tool['icon'] }}</span>
                                    </span>
                                    <span class="material-symbols-outlined text-slate-300 transition group-hover:text-slate-700">arrow_forward</span>
                                </div>
                                <h3 class="mt-5 font-headline text-xl font-extrabold text-slate-900">{{ $tool['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $tool['copy'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>

            <section class="dashboard-panel p-6 md:p-7">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Latest Leads</p>
                        <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Recent public inquiries</h2>
                    </div>
                    <a class="rounded-full bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(2,132,199,0.18)]" href="{{ route('hr.inquiries') }}">View All</a>
                </div>

                @if ($recentContacts->isNotEmpty())
                    <div class="mt-6 overflow-x-auto rounded-[1.5rem] border border-slate-200">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Contact</th>
                                    <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Topic</th>
                                    <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Message</th>
                                    <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentContacts as $contact)
                                    <tr class="border-t border-slate-200 bg-white">
                                        <td class="px-4 py-4 align-top">
                                            <p class="font-semibold text-slate-900">{{ $contact->name }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $contact->email }}</p>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <span class="rounded-full bg-sky-100 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.16em] text-sky-700">{{ $contact->topic ?: 'General' }}</span>
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($contact->subject ?: $contact->message, 120) }}</td>
                                        <td class="px-4 py-4 align-top text-sm font-medium text-slate-500">{{ $contact->created_at?->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 px-4 py-8 text-sm text-slate-500">No inquiries yet.</div>
                @endif
            </section>
        </div>
    </main>
</body>
</html>
