@php
    $isHome = url()->current() === url('/');
    $isCourse = request()->is('course') || request()->is('courseDetails');
    $isPlacement = request()->is('placement');
    $isAbout = request()->is('about');
    $isContact = request()->is('contact');
    $user = auth()->user();
    $roleName = strtolower($user?->role?->name ?? '');
    $dashboardUrl = match ($roleName) {
        'super admin', 'admin' => '/admin/dashboard',
        'instructor' => '/instructor/dashboard',
        default => '/student/dashboard',
    };
    $initials = collect(explode(' ', trim($user->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<x-shared.page-loader />

<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 border-b border-[#d5e4ff] bg-white/92 backdrop-blur-md shadow-[0_10px_30px_rgba(7,32,84,0.08)]">
    <div class="flex justify-between items-center px-4 md:px-6 py-4 max-w-7xl mx-auto">
        <a href="/" class="flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-white p-1.5 ring-1 ring-[#d5e4ff] shadow-[0_12px_28px_rgba(12,78,163,0.16)]">
                <img src="https://www.codeinyourself.com/assets/img/logo.webp" alt="CodeInYourself logo" class="h-full w-full object-contain" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
            </span>
            <span class="flex flex-col leading-none">
                <span class="text-[1.05rem] md:text-[1.18rem] font-extrabold tracking-[-0.03em] text-[#08275c] font-headline">CodeInYourself</span>
                <span class="text-[0.66rem] md:text-[0.7rem] font-bold uppercase tracking-[0.24em] text-[#1570d8]">Learn. Build. Launch.</span>
            </span>
        </a>

        <div class="hidden md:flex items-center gap-8 font-semibold text-sm tracking-tight">
            <a href="/" @class([
                'pb-1 transition-colors',
                'text-primary border-b-2 border-primary' => $isHome,
                'text-on-surface-variant hover:text-primary' => !$isHome,
            ])>Home</a>
            <a href="/course" @class([
                'pb-1 transition-colors',
                'text-primary border-b-2 border-primary' => $isCourse,
                'text-on-surface-variant hover:text-primary' => !$isCourse,
            ])>Courses</a>
            <a href="/placement" @class([
                'pb-1 transition-colors',
                'text-primary border-b-2 border-primary' => $isPlacement,
                'text-on-surface-variant hover:text-primary' => !$isPlacement,
            ])>Placements</a>
            <a href="/about" @class([
                'pb-1 transition-colors',
                'text-primary border-b-2 border-primary' => $isAbout,
                'text-on-surface-variant hover:text-primary' => !$isAbout,
            ])>About</a>
            <a href="/contact" @class([
                'pb-1 transition-colors',
                'text-primary border-b-2 border-primary' => $isContact,
                'text-on-surface-variant hover:text-primary' => !$isContact,
            ])>Contact</a>
        </div>

        <div class="flex items-center gap-3 md:gap-4">
            @auth
                <a href="{{ $dashboardUrl }}" class="hidden md:flex items-center gap-3 rounded-full border border-[#d7e6ff] bg-white px-2.5 py-2 shadow-[0_10px_24px_rgba(7,32,84,0.08)] transition-all hover:border-[#1570d8]/40 hover:shadow-[0_14px_28px_rgba(12,78,163,0.12)]">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">{{ $initials ?: 'U' }}</span>
                    <span class="max-w-[120px] truncate text-sm font-semibold text-on-surface">{{ $user->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button class="rounded-lg border border-surface-variant px-4 py-2 text-sm font-semibold text-on-surface transition-all hover:border-red-200 hover:bg-red-50 hover:text-red-600" type="submit">Logout</button>
                </form>
            @else
                <button class="hidden md:block text-on-surface font-semibold text-sm px-4 py-2 hover:bg-surface-variant rounded-lg transition-all" onclick="window.location.href='/login'">Login</button>
                <button class="hidden sm:block bg-gradient-to-r from-[#0c4ea3] via-[#1570d8] to-[#2dc7ff] text-white font-bold text-sm px-4 md:px-6 py-2.5 md:py-3 rounded-xl shadow-[0_14px_28px_rgba(12,78,163,0.2)] hover:brightness-110 active:scale-95 transition-all" onclick="window.location.href='/login'">Enroll Now</button>
            @endauth
            <button type="button" class="md:hidden w-10 h-10 rounded-xl border border-[#d5e4ff] bg-white text-[#0c4ea3] flex items-center justify-center shadow-sm" aria-label="Open menu" onclick="toggleHomeMobileMenu()">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <div id="homeMobileMenu" class="md:hidden hidden border-t border-[#d5e4ff] bg-white px-4 pb-5 pt-3 space-y-2 shadow-[0_16px_30px_rgba(7,32,84,0.08)]">
        <a href="/" onclick="toggleHomeMobileMenu(false)" @class([
            'block rounded-lg px-3 py-2.5 font-semibold text-sm',
            'text-primary bg-primary/10' => $isHome,
            'text-on-surface-variant hover:bg-surface' => !$isHome,
        ])>Home</a>
        <a href="/course" onclick="toggleHomeMobileMenu(false)" @class([
            'block rounded-lg px-3 py-2.5 font-semibold text-sm',
            'text-primary bg-primary/10' => $isCourse,
            'text-on-surface-variant hover:bg-surface' => !$isCourse,
        ])>Courses</a>
        <a href="/placement" onclick="toggleHomeMobileMenu(false)" @class([
            'block rounded-lg px-3 py-2.5 font-semibold text-sm',
            'text-primary bg-primary/10' => $isPlacement,
            'text-on-surface-variant hover:bg-surface' => !$isPlacement,
        ])>Placements</a>
        <a href="/about" onclick="toggleHomeMobileMenu(false)" @class([
            'block rounded-lg px-3 py-2.5 font-semibold text-sm',
            'text-primary bg-primary/10' => $isAbout,
            'text-on-surface-variant hover:bg-surface' => !$isAbout,
        ])>About</a>
        <a href="/contact" onclick="toggleHomeMobileMenu(false)" @class([
            'block rounded-lg px-3 py-2.5 font-semibold text-sm',
            'text-primary bg-primary/10' => $isContact,
            'text-on-surface-variant hover:bg-surface' => !$isContact,
        ])>Contact</a>

        @auth
            <div class="pt-3 space-y-2">
                <a href="{{ $dashboardUrl }}" class="flex w-full items-center gap-3 rounded-lg border border-surface-variant px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">{{ $initials ?: 'U' }}</span>
                    <span class="truncate text-sm font-semibold text-on-surface">{{ $user->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-lg border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-600" type="submit">Logout</button>
                </form>
            </div>
        @else
            <div class="pt-3 space-y-2">
                <button class="w-full text-on-surface font-semibold text-sm px-4 py-2.5 border border-surface-variant rounded-lg" onclick="window.location.href='/login'">Login</button>
                <button class="w-full bg-primary text-on-primary font-bold text-sm px-6 py-3 rounded-lg shadow-md" onclick="window.location.href='/login'">Enroll Now</button>
            </div>
        @endauth
    </div>
</nav>

<div id="homeMobileOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleHomeMobileMenu(false)"></div>

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
</script>
