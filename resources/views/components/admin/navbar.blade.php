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

<style>
    #adminSidebar::-webkit-scrollbar {
        width: 6px;
    }

    #adminSidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #adminSidebar::-webkit-scrollbar-thumb {
        background: #d6d9dd;
        border-radius: 999px;
    }

    #adminSidebar {
        scrollbar-width: thin;
        scrollbar-color: #d6d9dd transparent;
    }

    @media (max-width: 767px) {
        body > header.fixed,
        main > header.fixed {
            padding-left: 5rem !important;
            padding-right: 0.875rem !important;
        }

        body > header.fixed .text-sm.font-medium,
        main > header.fixed .text-sm.font-medium {
            display: none !important;
        }
    }
</style>

<button id="adminSidebarToggle" type="button" class="md:hidden fixed top-2.5 left-3 z-[70] w-10 h-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-300 flex items-center justify-center shadow-sm transition-opacity duration-200" aria-label="Open admin menu" onclick="toggleAdminSidebar(true)">
    <span class="material-symbols-outlined">menu</span>
</button>

<div id="adminSidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleAdminSidebar(false)"></div>

<!-- SideNavBar Anchor -->
<aside id="adminSidebar" class="h-[100dvh] w-64 fixed left-0 top-0 overflow-y-auto bg-slate-50 dark:bg-slate-900 flex flex-col py-6 px-4 pb-[calc(1.5rem+env(safe-area-inset-bottom))] z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="mb-10 px-4">
        <h1 class="text-xl font-bold tracking-tight text-indigo-700 dark:text-indigo-300">CodeInYourself</h1>
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mt-1">Admin Panel</p>
    </div>

    <nav class="flex-1 space-y-1">
        <a href="/admin/dashboard" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isDashboard,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isDashboard,
        ])>
            <span class="material-symbols-outlined" data-icon="dashboard" @if($isDashboard) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
            <span class="text-sm font-bold uppercase tracking-wider">Dashboard</span>
        </a>

        <a href="/admin/categories" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isCategories,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isCategories,
        ])>
            <span class="material-symbols-outlined" data-icon="category" @if($isCategories) style="font-variation-settings: 'FILL' 1;" @endif>category</span>
            <span class="text-sm font-bold uppercase tracking-wider">Categories</span>
        </a>

        <a href="/admin/courses" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isCourses,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isCourses,
        ])>
            <span class="material-symbols-outlined" data-icon="school" @if($isCourses) style="font-variation-settings: 'FILL' 1;" @endif>school</span>
            <span class="text-sm font-bold uppercase tracking-wider">Courses</span>
        </a>

        <a href="/admin/users" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isUsers,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isUsers,
        ])>
            <span class="material-symbols-outlined" data-icon="group" @if($isUsers) style="font-variation-settings: 'FILL' 1;" @endif>group</span>
            <span class="text-sm font-bold uppercase tracking-wider">Users</span>
        </a>

        <a href="/admin/instructors" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isInstructors,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isInstructors,
        ])>
            <span class="material-symbols-outlined" data-icon="badge" @if($isInstructors) style="font-variation-settings: 'FILL' 1;" @endif>badge</span>
            <span class="text-sm font-bold uppercase tracking-wider">Instructors</span>
        </a>

        <a href="/admin/payments" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isPayments,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isPayments,
        ])>
            <span class="material-symbols-outlined" data-icon="payments" @if($isPayments) style="font-variation-settings: 'FILL' 1;" @endif>payments</span>
            <span class="text-sm font-bold uppercase tracking-wider">Payments</span>
        </a>

        <a href="/admin/analytics" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isAnalytics,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isAnalytics,
        ])>
            <span class="material-symbols-outlined" data-icon="analytics" @if($isAnalytics) style="font-variation-settings: 'FILL' 1;" @endif>analytics</span>
            <span class="text-sm font-bold uppercase tracking-wider">Analytics</span>
        </a>

        <a href="/admin/reviews" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isReviews,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isReviews,
        ])>
            <span class="material-symbols-outlined" data-icon="reviews" @if($isReviews) style="font-variation-settings: 'FILL' 1;" @endif>reviews</span>
            <span class="text-sm font-bold uppercase tracking-wider">Reviews</span>
        </a>

        <a href="/admin/support" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isSupport,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isSupport,
        ])>
            <span class="material-symbols-outlined" data-icon="support_agent" @if($isSupport) style="font-variation-settings: 'FILL' 1;" @endif>support_agent</span>
            <span class="text-sm font-bold uppercase tracking-wider">Support</span>
        </a>

        <a href="/admin/settings" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
            'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isSettings,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isSettings,
        ])>
            <span class="material-symbols-outlined" data-icon="settings" @if($isSettings) style="font-variation-settings: 'FILL' 1;" @endif>settings</span>
            <span class="text-sm font-bold uppercase tracking-wider">Settings</span>
        </a>

        @if ($isSuperAdmin)
            <a href="/admin/admins" onclick="if (window.innerWidth < 768) toggleAdminSidebar(false)" @class([
                'flex items-center gap-3 px-4 py-3 rounded-lg active:scale-[0.98] duration-150',
                'text-indigo-700 dark:text-indigo-300 font-semibold bg-white dark:bg-slate-800 shadow-sm' => $isAdmins,
                'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors hover:bg-slate-200/50 dark:hover:bg-slate-800/50' => !$isAdmins,
            ])>
                <span class="material-symbols-outlined" data-icon="admin_panel_settings" @if($isAdmins) style="font-variation-settings: 'FILL' 1;" @endif>admin_panel_settings</span>
                <span class="text-sm font-bold uppercase tracking-wider">Manage Admins</span>
            </a>
        @endif
    </nav>

    <div class="mt-auto px-4 py-4 bg-slate-100 dark:bg-slate-800 rounded-xl">
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
            <button class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition-colors hover:bg-red-50 dark:bg-slate-900" type="submit">
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
