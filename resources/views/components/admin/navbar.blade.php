@php
    $isDashboard = request()->is('admin/dashboard');
    $isCategories = request()->is('admin/categories*');
    $isCourses = request()->is('admin/courses*');
    $isUsers = request()->is('admin/users*');
    $isInstructors = request()->is('admin/instructors*');
    $isPayments = request()->is('admin/payments*');
    $isAnalytics = request()->is('admin/analytics*');
    $isReviews = request()->is('admin/reviews*');
    $isSupport = request()->is('admin/support*');
    $isSettings = request()->is('admin/settings*');
    $isAdmins = request()->is('admin/admins*');
    $user = auth()->user();
    $isSuperAdmin = $user?->role?->name === 'super admin';
    $initials = collect(explode(' ', trim($user->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<x-shared.page-loader />
<x-shared.back-to-top />

<style>
    :root {
        --admin-sidebar-width: 15rem;
    }

    html {
        scrollbar-gutter: stable;
        scrollbar-width: thin;
        scrollbar-color: rgba(139, 92, 246, 0.76) rgba(247, 239, 251, 0.96);
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        width: 12px;
    }

    html::-webkit-scrollbar-track,
    body::-webkit-scrollbar-track {
        background:
            linear-gradient(180deg, rgba(252, 247, 254, 0.98), rgba(241, 230, 247, 0.98));
        border-left: 1px solid rgba(226, 211, 235, 0.72);
    }

    html::-webkit-scrollbar-thumb,
    body::-webkit-scrollbar-thumb {
        background:
            linear-gradient(180deg, rgba(139, 92, 246, 0.90), rgba(244, 114, 182, 0.82));
        border: 2px solid rgba(252, 247, 254, 0.96);
        border-radius: 9999px;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,0.26),
            0 6px 16px rgba(106, 51, 120, 0.14);
    }

    html::-webkit-scrollbar-thumb:hover,
    body::-webkit-scrollbar-thumb:hover {
        background:
            linear-gradient(180deg, rgba(124, 58, 237, 0.94), rgba(236, 72, 153, 0.86));
    }

    @keyframes adminFadeRise {
        0% {
            opacity: 0;
            transform: translateY(18px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes adminFloatGlow {
        0%, 100% {
            transform: translate3d(0, 0, 0);
            opacity: 0.45;
        }
        50% {
            transform: translate3d(0, -10px, 0);
            opacity: 0.8;
        }
    }

    #adminSidebar::-webkit-scrollbar {
        width: 6px;
    }

    #adminSidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #adminSidebar::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.35);
        border-radius: 999px;
    }

    #adminSidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(139, 92, 246, 0.35) transparent;
    }

    body {
        background:
            radial-gradient(circle at 10% 10%, rgba(232, 201, 250, 0.6), transparent 22rem),
            radial-gradient(circle at 88% 12%, rgba(255, 214, 232, 0.42), transparent 20rem),
            linear-gradient(180deg, #fcf9fe 0%, #f7f0fa 45%, #fdfbfd 100%) !important;
        scrollbar-width: thin;
        scrollbar-color: rgba(139, 92, 246, 0.76) rgba(247, 239, 251, 0.96);
    }

    body::before,
    body::after {
        content: "";
        position: fixed;
        pointer-events: none;
        border-radius: 999px;
        filter: blur(80px);
        z-index: 0;
        animation: adminFloatGlow 10s ease-in-out infinite;
    }

    body::before {
        width: 14rem;
        height: 14rem;
        left: -3rem;
        top: 3rem;
        background: rgba(192, 132, 252, 0.18);
    }

    body::after {
        width: 16rem;
        height: 16rem;
        right: -4rem;
        top: 7rem;
        background: rgba(244, 114, 182, 0.14);
        animation-delay: 1.5s;
    }

    main,
    header,
    aside {
        position: relative;
        z-index: 1;
    }

    body > header.fixed,
    main > header.fixed {
        background:
            linear-gradient(135deg, rgba(255, 255, 255, 0.92), rgba(250, 242, 255, 0.9)) !important;
        border-bottom: 1px solid rgba(219, 205, 228, 0.92) !important;
        box-shadow: 0 14px 35px rgba(106, 51, 120, 0.08);
        backdrop-filter: blur(16px);
    }

    body > header.fixed::before,
    main > header.fixed::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 1px;
        background: linear-gradient(180deg, rgba(192, 132, 252, 0.45), rgba(244, 114, 182, 0.18));
    }

    main .bg-surface-container-lowest,
    main .bg-surface-container-low,
    main .editorial-shadow,
    main .rounded-2xl,
    main .rounded-3xl,
    main .rounded-\[2rem\] {
        transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
        animation: adminFadeRise 0.55s ease-out both;
    }

    main .bg-surface-container-lowest:hover,
    main .bg-surface-container-low:hover,
    main .editorial-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(106, 51, 120, 0.10);
    }

    main a,
    main button {
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, opacity 0.2s ease;
    }

    main a:hover,
    main button:hover {
        transform: translateY(-1px);
    }

    @media (min-width: 768px) {
        body > header.fixed,
        main > header.fixed {
            left: var(--admin-sidebar-width) !important;
            width: calc(100% - var(--admin-sidebar-width)) !important;
            right: 0 !important;
            border-left: 1px solid rgba(231, 216, 241, 0.82);
        }
    }

    @media (max-width: 767px) {
        body > header.fixed,
        main > header.fixed {
            padding-left: 5rem !important;
            padding-right: 0.875rem !important;
            min-height: 4.5rem;
            height: auto !important;
            flex-wrap: wrap;
            row-gap: 0.75rem;
            align-items: center;
        }

        body > header.fixed .text-sm.font-medium,
        main > header.fixed .text-sm.font-medium {
            display: none !important;
        }
    }

    @media (max-width: 1023px) {
        main {
            overflow-x: hidden;
        }

        main > div,
        main section,
        main article {
            min-width: 0;
        }
    }
</style>

<button id="adminSidebarToggle" type="button" class="md:hidden fixed top-2.5 left-3 z-[70] flex h-11 w-11 items-center justify-center rounded-2xl border border-white/60 bg-white/85 text-[#6a3378] shadow-[0_18px_40px_rgba(106,51,120,0.18)] backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_22px_50px_rgba(106,51,120,0.24)]" aria-label="Open admin menu" onclick="toggleAdminSidebar(true)">
    <span class="absolute inset-0 rounded-2xl bg-[linear-gradient(135deg,rgba(255,255,255,0.75),rgba(244,232,255,0.4))]"></span>
    <span class="material-symbols-outlined relative z-10 text-[22px]">menu</span>
</button>

<div id="adminSidebarOverlay" class="fixed inset-0 bg-[rgba(18,6,33,0.58)] backdrop-blur-[2px] z-40 hidden md:hidden" onclick="toggleAdminSidebar(false)"></div>

<!-- SideNavBar Anchor -->
<aside id="adminSidebar" class="fixed left-0 top-0 z-50 flex h-[100dvh] w-60 max-w-[80vw] -translate-x-full flex-col overflow-y-auto border-r border-white/35 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.92),rgba(244,231,255,0.92)_24%,rgba(236,220,250,0.9)_58%,rgba(228,212,247,0.88)_100%)] px-4 py-4 pb-[calc(1.25rem+env(safe-area-inset-bottom))] shadow-[0_30px_80px_rgba(106,51,120,0.18)] backdrop-blur-2xl transform transition-transform duration-300 md:translate-x-0">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-12 top-0 h-28 w-28 rounded-full bg-[#c084fc]/30 blur-3xl animate-pulse"></div>
        <div class="absolute right-0 top-32 h-32 w-32 rounded-full bg-[#f472b6]/20 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-8 h-24 w-24 rounded-full bg-white/35 blur-2xl animate-pulse"></div>
    </div>

    <div class="relative mb-5 rounded-[24px] border border-white/55 bg-white/60 px-3.5 py-3.5 shadow-[0_16px_40px_rgba(106,51,120,0.12)] backdrop-blur-xl">
        <div class="absolute inset-x-4 top-0 h-px bg-gradient-to-r from-transparent via-white/90 to-transparent"></div>
        <div class="mb-3 flex items-center justify-center">
            <img src="https://www.codeinyourself.com/assets/img/logo.webp" alt="CodeInYourself logo" class="h-9 w-auto max-w-[7rem] object-contain" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
        </div>
    </div>

    <nav class="relative flex-1 space-y-1">
        <a href="{{ route('admin.dashboard') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isDashboard,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isDashboard,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="dashboard" @if($isDashboard) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Dashboard</span>
        </a>

        <a href="{{ route('admin.categories') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isCategories,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isCategories,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="category" @if($isCategories) style="font-variation-settings: 'FILL' 1;" @endif>category</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Categories</span>
        </a>

        <a href="{{ route('admin.courses') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isCourses,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isCourses,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="school" @if($isCourses) style="font-variation-settings: 'FILL' 1;" @endif>school</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Courses</span>
        </a>

        <a href="{{ route('admin.users') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isUsers,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isUsers,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="group" @if($isUsers) style="font-variation-settings: 'FILL' 1;" @endif>group</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Users</span>
        </a>

        <a href="{{ route('admin.instructors') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isInstructors,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isInstructors,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="badge" @if($isInstructors) style="font-variation-settings: 'FILL' 1;" @endif>badge</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Instructors</span>
        </a>

        <a href="{{ route('admin.payments') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isPayments,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isPayments,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="payments" @if($isPayments) style="font-variation-settings: 'FILL' 1;" @endif>payments</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Payments</span>
        </a>

        <a href="{{ route('admin.analytics') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isAnalytics,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isAnalytics,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="analytics" @if($isAnalytics) style="font-variation-settings: 'FILL' 1;" @endif>analytics</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Analytics</span>
        </a>

        <a href="{{ route('admin.reviews') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isReviews,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isReviews,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="reviews" @if($isReviews) style="font-variation-settings: 'FILL' 1;" @endif>reviews</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Reviews</span>
        </a>

        <a href="{{ route('admin.support') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isSupport,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isSupport,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="support_agent" @if($isSupport) style="font-variation-settings: 'FILL' 1;" @endif>support_agent</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Support</span>
        </a>

        <a href="{{ route('admin.settings') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
            'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isSettings,
            'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isSettings,
        ])>
            <span class="material-symbols-outlined text-[19px]" data-icon="settings" @if($isSettings) style="font-variation-settings: 'FILL' 1;" @endif>settings</span>
            <span class="text-[12px] font-semibold uppercase tracking-[0.16em]">Settings</span>
        </a>

        @if ($isSuperAdmin)
            <a href="{{ route('admin.admins') }}" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
                'group flex items-center gap-2.5 px-3 py-2.5 rounded-xl active:scale-[0.99] duration-200',
                'text-[#7c4190] dark:text-[#d6b8e0] font-semibold border border-white/70 bg-white/95 dark:bg-slate-800 shadow-[0_10px_24px_rgba(106,51,120,0.10)]' => $isAdmins,
                'text-slate-500 dark:text-slate-400 hover:text-[#6a3378] dark:hover:text-[#d6b8e0] transition-colors hover:bg-white/65 dark:hover:bg-slate-800/50' => !$isAdmins,
            ])>
                <span class="material-symbols-outlined text-[19px]" data-icon="admin_panel_settings" @if($isAdmins) style="font-variation-settings: 'FILL' 1;" @endif>admin_panel_settings</span>
                <span class="text-[11px] font-semibold uppercase tracking-[0.14em]">Manage Admins</span>
            </a>
        @endif
    </nav>

        <div class="mt-auto rounded-2xl border border-[#e6d6f5] bg-white/80 px-3.5 py-3.5 shadow-[0_10px_24px_rgba(75,35,86,0.08)]">
        <div class="flex items-center gap-3">
            @if ($user?->avatar_path)
                <img src="{{ $user->avatarUrl(80) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-white/80" />
            @else
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">{{ $initials ?: 'U' }}</div>
            @endif
            <div class="min-w-0">
                <p class="text-xs font-bold text-on-surface truncate">{{ $user->name }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ $user->role?->name ?? $user->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition-colors hover:bg-red-50" type="submit">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    if (!window.toggleAdminSidebar) {
        window.toggleAdminSidebar = function (forceOpen) {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminSidebarOverlay');
            var toggle = document.getElementById('adminSidebarToggle');
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
