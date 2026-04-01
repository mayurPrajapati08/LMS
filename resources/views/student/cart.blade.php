<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Cart | CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0c4ea3",
                        "primary-container": "#1570d8",
                        surface: "#f4f9ff",
                        "surface-container-low": "#eef5ff",
                        "surface-container-high": "#e3eeff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#4f6178",
                        outline: "#7c8da7",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
    <x-student.navbar />

    <header class="fixed top-0 right-0 z-40 flex h-16 w-full items-center justify-between bg-white/80 px-4 shadow-sm backdrop-blur-md md:w-[calc(100%-16rem)] md:px-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-on-surface-variant">Purchase Queue</p>
            <h1 class="font-headline text-xl font-extrabold tracking-tight text-primary">Your Cart</h1>
        </div>
        <div class="flex items-center gap-4">
            <a class="hidden rounded-full bg-surface-container-low px-4 py-2 text-sm font-semibold text-primary md:inline-flex" href="{{ $browseUrl }}">Browse courses</a>
            <img alt="{{ $student->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="min-h-screen px-4 pb-12 pt-24 md:ml-64 md:px-12">
        @if (session('status'))
            <div class="mx-auto mb-6 max-w-6xl rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 lg:grid-cols-12">
            <section class="space-y-5 lg:col-span-8">
                <div class="rounded-[1.5rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Selected courses</p>
                            <h2 class="mt-2 font-headline text-3xl font-extrabold">{{ $cartCount }} item{{ $cartCount === 1 ? '' : 's' }}</h2>
                        </div>
                        <div class="rounded-full bg-[#edf5ff] px-4 py-2 text-xs font-bold uppercase tracking-[0.22em] text-primary">Ready for one payment</div>
                    </div>
                </div>

                @forelse ($cartItems as $item)
                    @php($course = $item->course)
                    <article class="rounded-[1.5rem] bg-surface-container-lowest p-5 shadow-sm ring-1 ring-slate-200/70">
                        <div class="flex flex-col gap-5 md:flex-row">
                            <img alt="{{ $course->title }} thumbnail" class="h-40 w-full rounded-[1.25rem] object-cover md:w-60" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480' }}" />
                            <div class="flex-1">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="rounded-full bg-[#dcecff] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-primary">{{ $course->category?->name ?? 'Course' }}</span>
                                            <span class="rounded-full bg-surface-container-low px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">{{ ucfirst($course->level ?: 'All Levels') }}</span>
                                        </div>
                                        <h3 class="mt-3 font-headline text-2xl font-extrabold leading-tight">{{ $course->title }}</h3>
                                        <p class="mt-3 max-w-2xl text-sm leading-7 text-on-surface-variant">{{ $course->details }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Price</p>
                                        <p class="mt-2 font-headline text-2xl font-extrabold text-on-surface">Rs. {{ number_format((float) $course->price, 2) }}</p>
                                    </div>
                                </div>

                                <div class="mt-5 flex flex-wrap items-center gap-4 text-sm text-on-surface-variant">
                                    <span class="inline-flex items-center gap-2"><span class="material-symbols-outlined text-base text-amber-500" style="font-variation-settings: 'FILL' 1;">star</span>{{ number_format((float) ($course->reviews_avg_rating ?? 0), 1) ?: '4.8' }}</span>
                                    <span class="inline-flex items-center gap-2"><span class="material-symbols-outlined text-base text-primary">group</span>{{ number_format((int) $course->students_count) }} students</span>
                                    <span class="inline-flex items-center gap-2"><span class="material-symbols-outlined text-base text-primary">person</span>{{ $course->user?->name ?? 'Instructor' }}</span>
                                </div>

                                <div class="mt-6 flex flex-wrap gap-3">
                                    <a class="rounded-xl bg-surface-container-low px-5 py-3 text-sm font-bold text-primary" href="{{ route('student.course-details', ['course' => $course->id]) }}">View details</a>
                                    <form action="{{ route('student.cart.remove', $item) }}" method="POST">
                                        @csrf
                                        <button class="rounded-xl border border-rose-200 px-5 py-3 text-sm font-bold text-rose-600 transition hover:bg-rose-50" type="submit">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[1.5rem] border border-dashed border-[#c7e0ff] bg-surface-container-lowest p-12 text-center shadow-sm">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#edf5ff] text-primary">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                        <h2 class="mt-5 font-headline text-2xl font-extrabold">Your cart is empty</h2>
                        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-on-surface-variant">Add published courses from the catalog and then pay for all of them together in one Razorpay checkout.</p>
                        <a class="mt-6 inline-flex rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/20" href="{{ $browseUrl }}">Browse courses</a>
                    </div>
                @endforelse
            </section>

            <aside class="lg:col-span-4">
                <div class="sticky top-24 rounded-[1.5rem] bg-surface-container-lowest p-6 shadow-xl ring-1 ring-slate-200/70">
                    <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Order Summary</p>
                    <div class="mt-5 space-y-4">
                        <div class="flex items-center justify-between text-sm text-on-surface-variant">
                            <span>Courses</span>
                            <span>{{ $cartCount }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-on-surface-variant">
                            <span>Subtotal</span>
                            <span>Rs. {{ number_format($cartSubtotal, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-on-surface-variant">
                            <span>Processing fee</span>
                            <span>Rs. 0.00</span>
                        </div>
                        <div class="flex items-center justify-between border-t border-surface-container-high pt-4">
                            <span class="font-bold text-on-surface">Total</span>
                            <span class="font-headline text-2xl font-extrabold text-on-surface">Rs. {{ number_format($cartTotal, 2) }}</span>
                        </div>
                    </div>

                    <a class="mt-8 flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-primary to-primary-container px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 transition hover:scale-[1.01] active:scale-[0.99] {{ $cartCount === 0 ? 'pointer-events-none opacity-60' : '' }}" href="{{ $checkoutUrl }}">
                        Checkout {{ $cartCount > 0 ? $cartCount.' Course'.($cartCount === 1 ? '' : 's') : '' }}
                    </a>
                    <a class="mt-4 flex w-full items-center justify-center rounded-2xl bg-surface-container-low px-6 py-4 text-sm font-bold text-primary" href="{{ $browseUrl }}">Add more courses</a>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>


