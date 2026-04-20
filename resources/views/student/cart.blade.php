<x-student.layout title="Cart | CodeInYourself">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Purchase Queue</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">Your Cart</p>
    </div>
    <x-slot:right>
        <a class="student-pill-button student-pill-button--ghost" href="{{ $browseUrl }}">Browse courses</a>
        <img alt="{{ $student->name }} avatar" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $profileAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
        @endif

        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Purchase Queue</p>
                <h1 class="student-page-title">Your cart</h1>
                <p class="student-page-copy">A minimal cart focused on selected courses, clear pricing, and the fastest route to checkout.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $cartCount }} item{{ $cartCount === 1 ? '' : 's' }}</span>
                <span class="student-chip">Rs. {{ number_format($cartTotal, 2) }} total</span>
                <span class="student-chip">One payment flow</span>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">Items</p>
                        <p class="student-stat-value">{{ $cartCount }}</p>
                        <p class="student-stat-copy">Courses selected</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Subtotal</p>
                        <p class="student-stat-value">Rs. {{ number_format($cartSubtotal, 0) }}</p>
                        <p class="student-stat-copy">Before checkout</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Checkout</p>
                        <p class="student-stat-value">Ready</p>
                        <p class="student-stat-copy">Instant enrollment after payment</p>
                    </div>
                </div>
            </div>

            <div class="student-side-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Order Summary</p>
                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between text-sm text-on-surface-variant"><span>Courses</span><span>{{ $cartCount }}</span></div>
                    <div class="flex items-center justify-between text-sm text-on-surface-variant"><span>Subtotal</span><span>Rs. {{ number_format($cartSubtotal, 2) }}</span></div>
                    <div class="flex items-center justify-between text-sm text-on-surface-variant"><span>Processing fee</span><span>Rs. 0.00</span></div>
                    <div class="flex items-center justify-between border-t border-surface-container-high pt-4"><span class="font-bold text-on-surface">Total</span><span class="font-headline text-3xl font-extrabold text-on-surface">Rs. {{ number_format($cartTotal, 2) }}</span></div>
                </div>
                <a class="student-pill-button student-pill-button--primary mt-8 w-full justify-center {{ $cartCount === 0 ? 'pointer-events-none opacity-60' : '' }}" href="{{ $checkoutUrl }}">Checkout {{ $cartCount > 0 ? $cartCount.' Course'.($cartCount === 1 ? '' : 's') : '' }}</a>
                <a class="student-pill-button student-pill-button--ghost mt-4 w-full justify-center" href="{{ $browseUrl }}">Add More Courses</a>
            </div>
        </section>

        @forelse ($cartItems as $item)
            @php($course = $item->course)
            <article class="rounded-[1.3rem] bg-surface-container-lowest p-4 md:p-5">
                <div class="grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
                    <img alt="{{ $course->title }} thumbnail" class="h-full w-full rounded-[1.35rem] object-cover" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480' }}" />
                    <div>
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full bg-primary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-primary">{{ $course->category?->name ?? 'Course' }}</span>
                                    <span class="rounded-full bg-surface-container-low px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ ucfirst($course->level ?: 'All Levels') }}</span>
                                </div>
                                <h2 class="mt-4 font-headline text-[1.7rem] font-extrabold text-on-surface">{{ $course->title }}</h2>
                            </div>
                            <div class="rounded-[1.2rem] bg-surface-container-low px-4 py-3 text-right">
                                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Price</p>
                                <p class="mt-2 font-headline text-2xl font-extrabold text-on-surface">Rs. {{ number_format((float) $course->price, 2) }}</p>
                            </div>
                        </div>

                        <p class="mt-4 max-w-3xl text-sm leading-7 text-on-surface-variant">{{ $course->details }}</p>

                        <div class="mt-5 flex flex-wrap gap-4 text-sm text-on-surface-variant">
                            <span class="inline-flex items-center gap-2"><span class="material-symbols-outlined text-base text-amber-500" style="font-variation-settings: 'FILL' 1;">star</span>{{ number_format((float) ($course->reviews_avg_rating ?? 0), 1) ?: '4.8' }}</span>
                            <span class="inline-flex items-center gap-2"><span class="material-symbols-outlined text-base text-primary">group</span>{{ number_format((int) $course->students_count) }} students</span>
                            <span class="inline-flex items-center gap-2"><span class="material-symbols-outlined text-base text-primary">person</span>{{ $course->user?->name ?? 'Instructor' }}</span>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.course-details', ['course' => $course->id]) }}">View Details</a>
                            <form action="{{ route('student.cart.remove', $item) }}" method="POST">
                                @csrf
                                <button class="rounded-full border border-rose-200 px-5 py-3 text-sm font-bold text-rose-600 transition hover:bg-rose-50" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <section class="rounded-[1.3rem] bg-surface-container-lowest p-9 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.1rem] bg-[linear-gradient(135deg,rgba(111,78,246,0.12),rgba(209,107,242,0.12))] text-primary">
                    <span class="material-symbols-outlined text-4xl">shopping_cart</span>
                </div>
                <h2 class="mt-5 font-headline text-[1.9rem] font-extrabold text-on-surface">Your cart is empty</h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant">Add published courses from the catalog, then unlock them together in one checkout.</p>
                <a class="student-pill-button student-pill-button--primary mt-8" href="{{ $browseUrl }}">Browse Courses</a>
            </section>
        @endforelse
    </div>
</main>
</x-student.layout>
