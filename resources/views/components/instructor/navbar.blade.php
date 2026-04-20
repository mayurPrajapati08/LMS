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
<x-shared.back-to-top />

<button id="instructorSidebarToggle" type="button" class="md:hidden fixed top-2.5 left-3 z-[70] flex h-10 w-10 items-center justify-center rounded-xl border border-[#dbcde4] bg-white text-[#6a3378] shadow-sm transition-opacity duration-200" aria-label="Open instructor menu" onclick="toggleInstructorSidebar(true)">
    <span class="material-symbols-outlined">menu</span>
</button>

<div id="instructorSidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleInstructorSidebar(false)"></div>

<!-- SideNavBar (Shared Component) -->
<style>
    html {
        scrollbar-gutter: stable;
        scrollbar-width: thin;
        scrollbar-color: rgba(143, 82, 163, 0.74) rgba(246, 238, 249, 0.96);
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        width: 12px;
    }

    html::-webkit-scrollbar-track,
    body::-webkit-scrollbar-track {
        background:
            linear-gradient(180deg, rgba(252, 248, 253, 0.98), rgba(240, 228, 245, 0.98));
        border-left: 1px solid rgba(229, 215, 236, 0.72);
    }

    html::-webkit-scrollbar-thumb,
    body::-webkit-scrollbar-thumb {
        background:
            linear-gradient(180deg, rgba(143, 82, 163, 0.90), rgba(106, 51, 120, 0.86));
        border: 2px solid rgba(252, 248, 253, 0.96);
        border-radius: 9999px;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,0.24),
            0 6px 16px rgba(106, 51, 120, 0.14);
    }

    html::-webkit-scrollbar-thumb:hover,
    body::-webkit-scrollbar-thumb:hover {
        background:
            linear-gradient(180deg, rgba(122, 61, 143, 0.94), rgba(90, 41, 104, 0.90));
    }

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

    main > header.sticky {
        border-bottom: 1px solid #eadff1 !important;
        background: rgba(255, 255, 255, 0.9) !important;
        box-shadow: 0 10px 30px rgba(106, 51, 120, 0.08) !important;
        backdrop-filter: blur(14px);
    }

    @media (max-width: 1023px) {
        main {
            overflow-x: hidden;
        }

        main > header.sticky {
            flex-wrap: wrap;
            row-gap: 0.75rem;
        }
    }
</style>

<aside id="instructorSidebar" class="fixed left-0 top-0 z-50 flex h-[100dvh] w-64 flex-col gap-1 overflow-y-auto border-r border-[#e7dcef] bg-[linear-gradient(180deg,#fcf9fe_0%,#f5eef8_100%)] p-6 pb-[calc(1.5rem+env(safe-area-inset-bottom))] transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    <div class="mb-6 px-4">
        <p class="font-['Manrope'] text-[1.05rem] font-extrabold tracking-[-0.03em] text-[#3f234a]">Instructor Portal</p>
        <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#8f52a3]">Teaching Workspace</p>
    </div>

    <nav class="flex flex-col gap-1">
        <a href="{{ url('/instructor/dashboard') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isDashboard,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isDashboard,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isDashboard,
            ]) data-icon="dashboard" @if($isDashboard) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isDashboard ? '' : 'font-medium' }}">Dashboard</span>
        </a>

        <a href="{{ route('instructor.mycourse') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isMyCourse,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isMyCourse,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isMyCourse,
            ]) data-icon="library_books" @if($isMyCourse) style="font-variation-settings: 'FILL' 1;" @endif>library_books</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isMyCourse ? '' : 'font-medium' }}">My Courses</span>
        </a>

        <a href="{{ route('instructor.create-course') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isCreateCourse,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isCreateCourse,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isCreateCourse,
            ]) data-icon="add_circle" @if($isCreateCourse) style="font-variation-settings: 'FILL' 1;" @endif>add_circle</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isCreateCourse ? '' : 'font-medium' }}">Create Course</span>
        </a>

        <a href="{{ route('instructor.earnings') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isEarnings,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isEarnings,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isEarnings,
            ]) data-icon="payments" @if($isEarnings) style="font-variation-settings: 'FILL' 1;" @endif>payments</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isEarnings ? '' : 'font-medium' }}">Earnings</span>
        </a>

        <a href="{{ route('instructor.students') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isStudents,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isStudents,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isStudents,
            ]) data-icon="group" @if($isStudents) style="font-variation-settings: 'FILL' 1;" @endif>group</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isStudents ? '' : 'font-medium' }}">Students</span>
        </a>

        <a href="{{ route('instructor.reviews') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isReviews,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isReviews,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isReviews,
            ]) data-icon="star" @if($isReviews) style="font-variation-settings: 'FILL' 1;" @endif>star</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isReviews ? '' : 'font-medium' }}">Reviews</span>
        </a>

        <a href="{{ route('instructor.messages') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isMessages,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isMessages,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isMessages,
            ]) data-icon="mail" @if($isMessages) style="font-variation-settings: 'FILL' 1;" @endif>mail</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isMessages ? '' : 'font-medium' }}">Messages</span>
        </a>

        <a href="{{ route('instructor.settings') }}" onclick="if (window.innerWidth < 768) toggleInstructorSidebar(false)" @class([
            'flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200',
            'text-[#6a3378] bg-white shadow-sm font-semibold' => $isSettings,
            'text-slate-600 hover:text-[#6a3378] hover:bg-[#f5eef8] hover:translate-x-1' => !$isSettings,
        ])>
            <span @class([
                'material-symbols-outlined',
                'text-[#8f52a3]' => $isSettings,
            ]) data-icon="settings" @if($isSettings) style="font-variation-settings: 'FILL' 1;" @endif>settings</span>
            <span class="font-['Inter'] text-[0.875rem] {{ $isSettings ? '' : 'font-medium' }}">Settings</span>
        </a>
    </nav>

    <div class="mt-auto pt-6 space-y-4">
        <div class="rounded-2xl border border-[#eadff1] bg-white px-4 py-4 shadow-[0_10px_24px_rgba(106,51,120,0.08)]">
            <div class="flex items-center gap-3">
                @if ($user?->avatar_path)
                    <img alt="{{ $user->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-[#eadff1]" src="{{ $user->avatarUrl(96) }}" />
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">{{ $initials ?: 'U' }}</div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-900">{{ $user->name }}</p>
                    <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <a class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#6a3378] via-[#8f52a3] to-[#c778b9] py-3 font-semibold text-white shadow-[0_16px_30px_rgba(106,51,120,0.2)] transition-all hover:opacity-90 active:scale-95" href="{{ route('instructor.create-course') }}">
            <span class="material-symbols-outlined" data-icon="add">add</span>
            New Course
        </a>
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
