@php
    $isDashboard = request()->is('student/dashboard');
    $isBrowseCourses = request()->is('student/browse-courses*') || request()->is('student/course-details*');
    $isMyLearning = request()->is('student/my-learning*') || request()->is('student/learning*') || request()->is('student/course-player*');
    $isWishlist = request()->is('student/wishlist*');
    $isCart = request()->is('student/cart*') || request()->is('student/checkout*');
    $isCertificates = request()->is('student/certificate*');
    $isPayments = request()->is('student/payment*') || request()->is('student/payments*');
    $isSupport = request()->is('student/messages-support*') || request()->is('student/support*');
    $isSettings = request()->is('student/seeting*') || request()->is('student/setting*');
    $user = auth()->user();
    $cartCount = $user?->cartItems()->count() ?? 0;
    $initials = collect(explode(' ', trim($user->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<x-shared.page-loader />

<button id="studentSidebarToggle" type="button" class="md:hidden fixed top-2.5 left-3 z-[70] w-10 h-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-300 flex items-center justify-center shadow-sm transition-opacity duration-200" aria-label="Open student menu" onclick="toggleStudentSidebar(true)">
    <span class="material-symbols-outlined">menu</span>
</button>

<div id="studentSidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleStudentSidebar(false)"></div>

<!-- SideNavBar -->
<style>
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

<aside id="studentSidebar" class="h-[100dvh] w-64 fixed left-0 top-0 border-r-0 flex flex-col p-6 pb-[calc(1.5rem+env(safe-area-inset-bottom))] bg-white dark:bg-slate-900 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto">
    <div class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-8 font-headline">
        CodeInYourself
    </div>

    <nav class="flex-1 space-y-1">
        <a href="/student/dashboard" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-all font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isDashboard,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isDashboard,
        ])>
            <span class="material-symbols-outlined" data-icon="dashboard" @if($isDashboard) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
            Dashboard
        </a>

        <a href="/student/browse-courses" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isBrowseCourses,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isBrowseCourses,
        ])>
            <span class="material-symbols-outlined" data-icon="explore" @if($isBrowseCourses) style="font-variation-settings: 'FILL' 1;" @endif>explore</span>
            Browse Courses
        </a>

        <a href="/student/my-learning" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isMyLearning,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isMyLearning,
        ])>
            <span class="material-symbols-outlined" data-icon="school" @if($isMyLearning) style="font-variation-settings: 'FILL' 1;" @endif>school</span>
            My Learning
        </a>

        <a href="/student/wishlist" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isWishlist,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isWishlist,
        ])>
            <span class="material-symbols-outlined" data-icon="favorite" @if($isWishlist) style="font-variation-settings: 'FILL' 1;" @endif>favorite</span>
            Wishlist
        </a>

        <a href="/student/cart" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center justify-between gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isCart,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isCart,
        ])>
            <span class="flex items-center gap-3">
                <span class="material-symbols-outlined" data-icon="shopping_cart" @if($isCart) style="font-variation-settings: 'FILL' 1;" @endif>shopping_cart</span>
                Cart
            </span>
            @if ($cartCount > 0)
                <span class="inline-flex min-w-6 items-center justify-center rounded-full bg-primary px-2 py-0.5 text-[10px] font-bold text-white">{{ $cartCount }}</span>
            @endif
        </a>

        <a href="/student/certificate" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isCertificates,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isCertificates,
        ])>
            <span class="material-symbols-outlined" data-icon="workspace_premium" @if($isCertificates) style="font-variation-settings: 'FILL' 1;" @endif>workspace_premium</span>
            Certificates
        </a>

        <div class="my-6 border-t border-surface-container-low opacity-20"></div>

        <a href="/student/payment" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isPayments,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isPayments,
        ])>
            <span class="material-symbols-outlined" data-icon="payments" @if($isPayments) style="font-variation-settings: 'FILL' 1;" @endif>payments</span>
            Payments
        </a>

        <a href="/student/messages-support" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isSupport,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isSupport,
        ])>
            <span class="material-symbols-outlined" data-icon="support_agent" @if($isSupport) style="font-variation-settings: 'FILL' 1;" @endif>support_agent</span>
            Messages / Support
        </a>

        <a href="/student/seeting" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
            "flex items-center gap-3 px-4 py-3 transition-colors duration-200 font-['Manrope'] text-sm tracking-tight",
            'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800 font-bold border-r-4 border-indigo-600' => $isSettings,
            'text-slate-500 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-800' => !$isSettings,
        ])>
            <span class="material-symbols-outlined" data-icon="settings" @if($isSettings) style="font-variation-settings: 'FILL' 1;" @endif>settings</span>
            Profile Settings
        </a>
    </nav>

    <div class="mt-auto pt-6 border-t border-surface-container-low">
        <div class="flex items-center gap-3">
            @if ($user?->avatar_path)
                <img alt="{{ $user->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $user->avatarUrl(96) }}" />
            @else
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">{{ $initials ?: 'U' }}</div>
            @endif
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate">{{ $user->name }}</p>
                <p class="text-xs text-on-surface-variant truncate">{{ $user->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 px-4 py-3 text-sm font-semibold text-red-600 transition-colors hover:bg-red-50" type="submit">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    if (!window.toggleStudentSidebar) {
        window.toggleStudentSidebar = function (forceOpen) {
            var sidebar = document.getElementById('studentSidebar');
            var overlay = document.getElementById('studentSidebarOverlay');
            var toggle = document.getElementById('studentSidebarToggle');
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
