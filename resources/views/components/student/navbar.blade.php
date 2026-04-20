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
    $primaryItems = [
        ['href' => '/student/dashboard', 'label' => 'Dashboard', 'icon' => 'grid_view', 'active' => $isDashboard],
        ['href' => '/student/browse-courses', 'label' => 'Explore', 'icon' => 'travel_explore', 'active' => $isBrowseCourses],
        ['href' => '/student/my-learning', 'label' => 'Learning', 'icon' => 'play_circle', 'active' => $isMyLearning],
        ['href' => '/student/wishlist', 'label' => 'Wishlist', 'icon' => 'favorite', 'active' => $isWishlist],
    ];
    $secondaryItems = [
        ['href' => '/student/cart', 'label' => 'Cart', 'icon' => 'shopping_bag', 'active' => $isCart, 'badge' => $cartCount > 0 ? $cartCount : null],
        ['href' => '/student/certificate', 'label' => 'Certificates', 'icon' => 'workspace_premium', 'active' => $isCertificates],
        ['href' => '/student/payment', 'label' => 'Payments', 'icon' => 'receipt_long', 'active' => $isPayments],
        ['href' => '/student/messages-support', 'label' => 'Support', 'icon' => 'chat', 'active' => $isSupport],
        ['href' => '/student/seeting', 'label' => 'Settings', 'icon' => 'tune', 'active' => $isSettings],
    ];
@endphp

<x-shared.page-loader />

<button id="studentSidebarToggle" type="button" class="md:hidden fixed top-3 left-3 z-[70] flex h-11 w-11 items-center justify-center rounded-[1rem] border border-[#e9e2fb] bg-white/90 text-[#3f336f] shadow-[0_10px_24px_rgba(32,20,75,0.10)] backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5" aria-label="Open student menu" onclick="toggleStudentSidebar(true)">
    <span class="material-symbols-outlined text-[20px]">menu</span>
</button>

<div id="studentSidebarOverlay" class="fixed inset-0 z-40 hidden bg-[rgba(20,14,36,0.44)] backdrop-blur-[3px] md:hidden" onclick="toggleStudentSidebar(false)"></div>

<style>
    #studentSidebar::-webkit-scrollbar { width: 5px; }
    #studentSidebar::-webkit-scrollbar-thumb { background: rgba(95, 66, 234, 0.22); border-radius: 999px; }
    #studentSidebar { scrollbar-width: thin; scrollbar-color: rgba(95, 66, 234, 0.22) transparent; }

    @media (max-width: 767px) {
        body > header.fixed,
        main > header.fixed {
            padding-left: 4.75rem !important;
            padding-right: 0.875rem !important;
        }
    }
</style>

<aside id="studentSidebar" class="fixed left-0 top-0 z-50 flex h-[100dvh] w-[15.5rem] max-w-[88vw] -translate-x-full flex-col overflow-y-auto border-r border-[#e9e3f7] bg-[linear-gradient(180deg,#f5f1ff_0%,#f8f6ff_48%,#fcfbff_100%)] px-3 py-3 shadow-[0_22px_60px_rgba(32,20,75,0.10)] transition-transform duration-300 md:translate-x-0">
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-[1.1rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_28px_rgba(149,85,246,0.22)]">
                    <span class="text-sm font-bold tracking-[0.18em]">{{ $initials ?: 'CY' }}</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#7d6cab]">Student Hub</p>
                    <p class="text-sm font-semibold text-[#1c1730]">CodeInYourself</p>
                </div>
            </div>
            <span class="rounded-full border border-[#efdffd] bg-white/80 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#b445d7]">Live</span>
        </div>
    </div>

    <div class="mb-4 rounded-[1rem] border border-[#e7e0f8] bg-white/74 p-3">
        <div class="flex items-center gap-3">
            @if ($user?->avatar_path)
                <img alt="{{ $user->name }} avatar" class="h-12 w-12 rounded-[1rem] object-cover" src="{{ $user->avatarUrl(96) }}" />
            @else
                <div class="flex h-12 w-12 items-center justify-center rounded-[1rem] bg-[#ede8ff] text-sm font-bold text-[#4f3dd4]">{{ $initials ?: 'U' }}</div>
            @endif
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-[#1c1730]">{{ $user->name }}</p>
                <p class="truncate text-[11px] text-[#756b96]">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <p class="mb-2 px-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#8f83b5]">Workspace</p>
        <nav class="space-y-1">
            @foreach ($primaryItems as $item)
                <a href="{{ $item['href'] }}" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
                    'group flex items-center gap-2.5 rounded-[0.9rem] px-2.5 py-2.5 text-[13px] transition-all duration-200',
                    'bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_28px_rgba(149,85,246,0.22)]' => $item['active'],
                    'text-[#4f466d] hover:translate-x-1 hover:bg-white/78 hover:text-[#221a3d]' => ! $item['active'],
                ])>
                    <span @class([
                        'flex h-8 w-8 items-center justify-center rounded-[0.75rem]',
                        'bg-white/12 text-white' => $item['active'],
                        'bg-[#f7edff] text-[#b445d7]' => ! $item['active'],
                    ])>
                        <span class="material-symbols-outlined text-[17px]" @if($item['active']) style="font-variation-settings: 'FILL' 1;" @endif>{{ $item['icon'] }}</span>
                    </span>
                    <span class="font-semibold">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mb-3">
        <p class="mb-2 px-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#8f83b5]">Manage</p>
        <nav class="space-y-1">
            @foreach ($secondaryItems as $item)
                <a href="{{ $item['href'] }}" onclick="if (window.innerWidth < 768) toggleStudentSidebar(false)" @class([
                    'group flex items-center justify-between gap-2.5 rounded-[0.9rem] px-2.5 py-2.5 text-[13px] transition-all duration-200',
                    'bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_28px_rgba(149,85,246,0.22)]' => $item['active'],
                    'text-[#4f466d] hover:translate-x-1 hover:bg-white/78 hover:text-[#221a3d]' => ! $item['active'],
                ])>
                    <span class="flex min-w-0 items-center gap-3">
                        <span @class([
                            'flex h-8 w-8 items-center justify-center rounded-[0.75rem]',
                            'bg-white/12 text-white' => $item['active'],
                            'bg-[#f7edff] text-[#b445d7]' => ! $item['active'],
                        ])>
                            <span class="material-symbols-outlined text-[17px]" @if($item['active']) style="font-variation-settings: 'FILL' 1;" @endif>{{ $item['icon'] }}</span>
                        </span>
                        <span class="truncate font-semibold">{{ $item['label'] }}</span>
                    </span>
                    @if (!empty($item['badge']))
                        <span class="inline-flex min-w-6 items-center justify-center rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold text-[#4f3dd4]">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mt-auto rounded-[1rem] border border-[#e7e0f8] bg-white/78 p-3.5">
        <p class="text-[11px] font-semibold text-[#1c1730]">Keep moving through your learning flow.</p>
        <p class="mt-1 text-xs leading-6 text-[#766d95]">Your courses, billing, certificates, and support now live inside one cleaner workspace.</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="flex w-full items-center justify-center gap-2 rounded-[0.85rem] border border-[#eadce0] bg-[#fff6f7] px-4 py-2.5 text-sm font-semibold text-[#c43d4a] transition hover:bg-[#fff0f3]" type="submit">
                <span class="material-symbols-outlined text-[18px]">logout</span>
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
