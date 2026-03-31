@php
    $isDashboard = request()->is('instructor/dashboard');
    $isMyCourse = request()->is('instructor/mycourse*');
    $isCreateCourse = request()->is('instructor/create-course*');
    $isEarnings = request()->is('instructor/earnings*');
    $isStudents = request()->is('instructor/students*');
    $isReviews = request()->is('instructor/reviews*');
    $isMessages = request()->is('instructor/messages*');
    $isSettings = request()->is('instructor/settings*');
    $user = auth()->user();
    $initials = collect(explode(' ', trim($user->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<x-shared.page-loader />

<button id="instructorSidebarToggle" type="button" class="md:hidden fixed top-2.5 left-3 z-[70] w-10 h-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-300 flex items-center justify-center shadow-sm transition-opacity duration-200" aria-label="Open instructor menu" onclick="toggleInstructorSidebar(true)">
    <span class="material-symbols-outlined">menu</span>
</button>

<div id="instructorSidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleInstructorSidebar(false)"></div>

<!-- SideNavBar (Shared Component) -->
<style>
    #instructorSidebar::-webkit-scrollbar {
        width: 6px;
    }

    #instructorSidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #instructorSidebar::-webkit-scrollbar-thumb {
        background: #d6d9dd;
        border-radius: 999px;
    }

    #instructorSidebar {
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

<aside id="instructorSidebar" class="h-[100dvh] w-64 fixed left-0 top-0 overflow-y-auto bg-slate-50 border-r border-slate-100 flex flex-col gap-1 p-6 pb-[calc(1.5rem+env(safe-area-inset-bottom))] z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="mb-8 px-4">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-sm" data-icon="auto_stories">auto_stories</span>
            </div>
            <h2 class="text-lg font-bold text-slate-900 font-['Manrope']">CodeInYourself</h2>
        </div>
        <p class="text-xs text-slate-500 font-medium">Instructor Portal</p>
    </div>

    <nav class="flex flex-col gap-1">
        <a href="/instructor/dashboard" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isDashboard,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isDashboard,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isDashboard,
            ]) data-icon="dashboard" @if($isDashboard) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isDashboard ? '' : 'font-medium' }}">Dashboard</span>
        </a>

        <a href="/instructor/mycourse" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isMyCourse,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isMyCourse,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isMyCourse,
            ]) data-icon="library_books" @if($isMyCourse) style="font-variation-settings: 'FILL' 1;" @endif>library_books</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isMyCourse ? '' : 'font-medium' }}">My Courses</span>
        </a>

        <a href="/instructor/create-course" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isCreateCourse,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isCreateCourse,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isCreateCourse,
            ]) data-icon="add_circle" @if($isCreateCourse) style="font-variation-settings: 'FILL' 1;" @endif>add_circle</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isCreateCourse ? '' : 'font-medium' }}">Create Course</span>
        </a>

        <a href="/instructor/earnings" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isEarnings,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isEarnings,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isEarnings,
            ]) data-icon="payments" @if($isEarnings) style="font-variation-settings: 'FILL' 1;" @endif>payments</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isEarnings ? '' : 'font-medium' }}">Earnings</span>
        </a>

        <a href="/instructor/students" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isStudents,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isStudents,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isStudents,
            ]) data-icon="group" @if($isStudents) style="font-variation-settings: 'FILL' 1;" @endif>group</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isStudents ? '' : 'font-medium' }}">Students</span>
        </a>

        <a href="/instructor/reviews" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isReviews,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isReviews,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isReviews,
            ]) data-icon="star" @if($isReviews) style="font-variation-settings: 'FILL' 1;" @endif>star</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isReviews ? '' : 'font-medium' }}">Reviews</span>
        </a>

        <a href="/instructor/messages" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isMessages,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isMessages,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isMessages,
            ]) data-icon="mail" @if($isMessages) style="font-variation-settings: 'FILL' 1;" @endif>mail</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isMessages ? '' : 'font-medium' }}">Messages</span>
        </a>

        <a href="/instructor/settings" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-indigo-700 bg-white shadow-sm font-semibold' => $isSettings,
            'text-slate-600 hover:text-indigo-600 hover:bg-slate-200/50 hover:translate-x-1' => !$isSettings,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-indigo-600' => $isSettings,
            ]) data-icon="settings" @if($isSettings) style="font-variation-settings: 'FILL' 1;" @endif>settings</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isSettings ? '' : 'font-medium' }}">Settings</span>
        </a>
    </nav>

    <div class="mt-auto pt-6 space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4">
            <div class="flex items-center gap-3">
                @if ($user?->avatar_path)
                    <img alt="{{ $user->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $user->avatarUrl(96) }}" />
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">{{ $initials ?: 'U' }}</div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-900">{{ $user->name }}</p>
                    <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <button class="w-full bg-gradient-to-r from-primary to-primary-container text-white py-3 rounded-xl font-semibold shadow-lg shadow-indigo-200/50 flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-95">
            <span class="material-symbols-outlined" data-icon="add">add</span>
            New Course
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition-colors hover:bg-red-50" type="submit">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    if (!window.toggleInstructorSidebar) {
        window.toggleInstructorSidebar = function (forceOpen) {
            var sidebar = document.getElementById('instructorSidebar');
            var overlay = document.getElementById('instructorSidebarOverlay');
            var toggle = document.getElementById('instructorSidebarToggle');
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
