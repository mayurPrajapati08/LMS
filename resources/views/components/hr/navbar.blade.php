@php
    $user = auth()->user();
    $items = [
        ['route' => 'hr.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
        ['route' => 'hr.inquiries', 'label' => 'All Inquiries', 'icon' => 'support_agent'],
        ['route' => 'hr.mentorship', 'label' => 'Mentorship', 'icon' => 'groups'],
        ['route' => 'hr.slides', 'label' => 'Slides', 'icon' => 'slideshow'],
        ['route' => 'hr.founder-media', 'label' => 'Founder Media', 'icon' => 'play_circle'],
        ['route' => 'hr.stories', 'label' => 'Stories', 'icon' => 'auto_stories'],
        ['route' => 'hr.achievements', 'label' => 'Achievements', 'icon' => 'gallery_thumbnail'],
        ['route' => 'hr.jobs', 'label' => 'Jobs', 'icon' => 'work'],
        ['route' => 'hr.faculty', 'label' => 'Faculty', 'icon' => 'school'],
        ['route' => 'hr.workshops', 'label' => 'Workshops', 'icon' => 'edit_calendar'],
        ['route' => 'hr.offline-courses', 'label' => 'Course Management', 'icon' => 'menu_book'],
    ];
@endphp

<style>
    .hr-sidebar-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(14, 116, 144, 0.32) transparent;
    }
    .hr-sidebar-scroll::-webkit-scrollbar {
        width: 7px;
    }
    .hr-sidebar-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, rgba(14,116,144,0.36), rgba(2,132,199,0.52));
        border-radius: 999px;
    }
    .hr-sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
</style>

<button id="hrSidebarToggle" type="button" class="fixed left-3 top-3 z-[70] flex h-11 w-11 items-center justify-center rounded-2xl border border-white/70 bg-white/90 text-sky-700 shadow-[0_18px_42px_rgba(2,132,199,0.16)] backdrop-blur-xl md:hidden" onclick="toggleHrSidebar(true)" aria-label="Open HR menu">
    <span class="material-symbols-outlined text-[22px]">menu</span>
</button>

<div id="hrSidebarOverlay" class="fixed inset-0 z-40 hidden bg-[rgba(15,23,42,0.46)] backdrop-blur-[2px] md:hidden" onclick="toggleHrSidebar(false)"></div>

<aside id="hrSidebar" class="hr-sidebar-scroll fixed inset-y-0 left-0 z-50 flex w-64 max-w-[84vw] -translate-x-full flex-col overflow-y-auto border-r border-white/60 bg-[linear-gradient(180deg,rgba(255,255,255,0.94),rgba(245,250,255,0.94))] px-4 py-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] transition-transform duration-300 md:translate-x-0">
    <div class="mb-8 rounded-[1.6rem] border border-white/70 bg-white/80 px-4 py-4 shadow-sm">
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-sky-700">HR Workspace</p>
        <h2 class="mt-2 font-headline text-xl font-extrabold text-slate-900">People & Leads</h2>
        <p class="mt-2 text-sm text-slate-500">Manage public content, workshop interest, and student follow-up in one place.</p>
    </div>

    <nav class="space-y-2">
        @foreach ($items as $item)
            <a href="{{ route($item['route']) }}" @class([
                'flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition',
                'bg-sky-600 text-white shadow-[0_16px_32px_rgba(2,132,199,0.22)]' => request()->routeIs($item['route']),
                'text-slate-600 hover:bg-white hover:text-slate-900' => !request()->routeIs($item['route']),
            ]) onclick="if (window.innerWidth < 768) toggleHrSidebar(false)">
                <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-2 pt-8 rounded-[1.4rem] border border-slate-200 bg-white/80 p-4">
        <p class="text-sm uppercase font-semibold text-slate-900">{{ $user?->name }}</p>
        <p class="mt-1 text-xs tracking-[0.18em] text-slate-500">{{ $user?->email }}</p>
        <form action="{{ route('logout') }}" class="mt-4" method="POST">
            @csrf
            <button class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-600" type="submit">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    if (!window.toggleHrSidebar) {
        window.toggleHrSidebar = function (forceOpen) {
            var sidebar = document.getElementById('hrSidebar');
            var overlay = document.getElementById('hrSidebarOverlay');
            var toggle = document.getElementById('hrSidebarToggle');
            if (!sidebar || !overlay) return;

            var open = typeof forceOpen === 'boolean' ? forceOpen : sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', !open);
            overlay.classList.toggle('hidden', !open);
            document.body.classList.toggle('overflow-hidden', open);

            if (toggle) {
                toggle.classList.toggle('opacity-0', open);
                toggle.classList.toggle('pointer-events-none', open);
            }
        };
    }
</script>
