<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Checkout | {{ $isCartCheckout ? 'Cart Purchase' : $course->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @if($razorpayConfigured && $razorpayOrder)
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @endif
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3525cd",
                        "primary-container": "#4f46e5",
                        background: "#f8f9fa",
                        surface: "#f8f9fa",
                        "surface-container-low": "#f3f4f5",
                        "surface-container-high": "#e7e8e9",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#464555",
                        tertiary: "#007030",
                        outline: "#777587",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-background text-on-surface">
    <x-student.navbar />

    <header class="fixed top-0 right-0 z-40 flex h-16 w-full items-center justify-between bg-white/80 px-4 shadow-sm backdrop-blur-md md:w-[calc(100%-16rem)] md:px-8">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-50 text-primary">
                <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-on-surface-variant">Secure Purchase</p>
                <h1 class="font-headline text-xl font-extrabold tracking-tight text-primary">{{ $isCartCheckout ? 'Cart Checkout' : 'Course Checkout' }}</h1>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a class="hidden rounded-full bg-surface-container-low px-4 py-2 text-sm font-semibold text-primary md:inline-flex" href="{{ $browseUrl }}">Browse courses</a>
            <img alt="{{ $student->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="min-h-screen px-4 pb-12 pt-24 md:ml-64 md:px-12">
        <div class="mx-auto max-w-6xl">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                <section class="space-y-6 lg:col-span-7">
                    <div class="rounded-[1.75rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70 md:p-8">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1, 'wght' 600, 'GRAD' 0, 'opsz' 24;">verified_user</span>
                                Razorpay secured
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-primary">
                                <span class="material-symbols-outlined text-[18px]">payments</span>
                                Instant enrollment after payment
                            </span>
                        </div>

                        <div class="mt-8 flex flex-col gap-6 md:flex-row">
                            <div class="w-full overflow-hidden rounded-[1.25rem] bg-surface-container-low md:w-56">
                                <img alt="{{ $course->title }} thumbnail" class="aspect-video h-full w-full object-cover md:aspect-[4/5]" src="{{ $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80' }}" />
                            </div>
                            <div class="flex-1 space-y-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-primary">{{ $course->category?->name ?? 'Course' }}</span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-emerald-700">{{ ucfirst($course->level ?: 'all levels') }}</span>
                                </div>
                                <div>
                                <h2 class="font-headline text-3xl font-extrabold leading-tight">{{ $isCartCheckout ? $checkoutCourses->count().' Courses Ready to Unlock' : $course->title }}</h2>
                                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $isCartCheckout ? 'You are checking out multiple published courses together in a single Razorpay payment.' : $course->details }}</p>
                                </div>
                                <div class="grid gap-3 sm:grid-cols-3">
                                    <div class="rounded-2xl bg-surface-container-low p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Rating</p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-amber-500" style="font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;">star</span>
                                            <span class="font-bold">{{ number_format($rating > 0 ? $rating : 4.8, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="rounded-2xl bg-surface-container-low p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Reviews</p>
                                        <p class="mt-2 font-bold">{{ number_format($reviewsCount) }}</p>
                                    </div>
                                    <div class="rounded-2xl bg-surface-container-low p-4">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Students</p>
                                        <p class="mt-2 font-bold">{{ number_format($studentsCount) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70 md:p-8">
                        <h3 class="font-headline text-lg font-bold">What you unlock</h3>
                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            <div class="rounded-2xl border border-slate-200 bg-surface-container-low p-5">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">smart_display</span>
                                    <p class="font-semibold">Full course player access</p>
                                </div>
                                <p class="mt-3 text-sm text-on-surface-variant">Watch every published lesson, keep resume progress, and revisit completed videos any time.</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-surface-container-low p-5">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">folder_zip</span>
                                    <p class="font-semibold">Resources and materials</p>
                                </div>
                                <p class="mt-3 text-sm text-on-surface-variant">Use attached notes, PDFs, and code files the instructor has released for your lessons.</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-surface-container-low p-5">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">forum</span>
                                    <p class="font-semibold">Q&amp;A and notes</p>
                                </div>
                                <p class="mt-3 text-sm text-on-surface-variant">Ask course questions, keep private notes per lesson, and continue exactly where you left off.</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-surface-container-low p-5">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">workspace_premium</span>
                                    <p class="font-semibold">Certificate eligibility</p>
                                </div>
                                <p class="mt-3 text-sm text-on-surface-variant">Complete the finished course content and unlock your certificate from the student dashboard.</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70 md:p-8">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="font-headline text-lg font-bold">{{ $isCartCheckout ? 'Courses in this order' : 'Course in this order' }}</h3>
                            <span class="rounded-full bg-indigo-50 px-4 py-2 text-[10px] font-bold uppercase tracking-[0.22em] text-primary">{{ $checkoutCourses->count() }} item{{ $checkoutCourses->count() === 1 ? '' : 's' }}</span>
                        </div>
                        <div class="mt-6 space-y-4">
                            @foreach ($checkoutCourses as $checkoutCourse)
                                <div class="flex items-center gap-4 rounded-2xl bg-surface-container-low p-4">
                                    <img alt="{{ $checkoutCourse->title }} thumbnail" class="h-16 w-20 rounded-xl object-cover" src="{{ $checkoutCourse->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80' }}" />
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-semibold text-on-surface">{{ $checkoutCourse->title }}</p>
                                        <p class="mt-1 text-xs text-on-surface-variant">{{ $checkoutCourse->category?->name ?? 'Course' }} • {{ ucfirst($checkoutCourse->level ?: 'all levels') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-on-surface">Rs. {{ number_format((float) $checkoutCourse->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <aside class="space-y-6 lg:col-span-5">
                    <div class="rounded-[1.75rem] bg-surface-container-lowest p-6 shadow-xl ring-1 ring-slate-200/70 md:p-8">
                        <div class="flex items-baseline justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Total amount</p>
                                <p class="mt-2 font-headline text-4xl font-extrabold text-on-surface">Rs. {{ number_format($checkoutAmount, 2) }}</p>
                            </div>
                            <div class="rounded-full bg-indigo-50 px-4 py-2 text-[10px] font-bold uppercase tracking-[0.22em] text-primary">One-time secure checkout</div>
                        </div>

                        <div class="mt-6 space-y-4 border-t border-surface-container-high pt-6">
                            <div class="flex items-center justify-between text-sm text-on-surface-variant">
                                <span>Course price</span>
                                <span>Rs. {{ number_format($checkoutAmount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm text-on-surface-variant">
                                <span>Processing fee</span>
                                <span>Rs. 0.00</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-surface-container-high pt-4 text-sm font-bold text-on-surface">
                                <span>Pay now</span>
                                <span>Rs. {{ number_format($checkoutAmount, 2) }}</span>
                            </div>
                        </div>

                        @if ($checkoutError)
                            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800">
                                {{ $checkoutError }}
                            </div>
                        @elseif (! $razorpayConfigured && $checkoutAmount > 0)
                            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800">
                                Add `RAZORPAY_KEY_ID` and `RAZORPAY_KEY_SECRET` in your `.env` to enable live Razorpay payments.
                            </div>
                        @endif

                        <form id="razorpayVerifyForm" action="{{ $successUrl }}" class="hidden" method="POST">
                            @csrf
                            @foreach ($courseIds as $courseId)
                                <input name="course_ids[]" type="hidden" value="{{ $courseId }}" />
                            @endforeach
                            <input id="razorpayPaymentIdInput" name="razorpay_payment_id" type="hidden" />
                            <input id="razorpayOrderIdInput" name="razorpay_order_id" type="hidden" />
                            <input id="razorpaySignatureInput" name="razorpay_signature" type="hidden" />
                        </form>

                        @if ($checkoutAmount <= 0)
                            <form action="{{ $freeEnrollUrl }}" class="mt-8" method="POST">
                                @csrf
                                @foreach ($courseIds as $courseId)
                                    <input name="course_ids[]" type="hidden" value="{{ $courseId }}" />
                                @endforeach
                                <button class="flex w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 transition hover:scale-[1.01] active:scale-[0.99]" type="submit">
                                    <span class="material-symbols-outlined text-[20px]">lock_open</span>
                                    {{ $isCartCheckout ? 'Unlock Free Courses' : 'Unlock Free Course' }}
                                </button>
                            </form>
                        @else
                            <button
                                @if ($razorpayConfigured && $razorpayOrder)
                                    data-amount="{{ $checkoutAmountPaise }}"
                                    data-course-title="{{ $course->title }}"
                                    data-customer-email="{{ $student->email }}"
                                    data-customer-name="{{ $student->name }}"
                                    data-key="{{ $razorpayKey }}"
                                    data-order-id="{{ $razorpayOrder['id'] }}"
                                    id="razorpayCheckoutButton"
                                @endif
                                class="mt-8 flex w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 transition hover:scale-[1.01] active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-60"
                                type="button"
                                @disabled(! $razorpayConfigured || ! $razorpayOrder)
                            >
                                <span class="material-symbols-outlined text-[20px]">credit_card</span>
                                <span>{{ $isCartCheckout ? 'Pay for Cart with Razorpay' : 'Pay with Razorpay' }}</span>
                            </button>
                        @endif

                        <a class="mt-4 flex w-full items-center justify-center rounded-2xl bg-surface-container-low px-6 py-4 text-sm font-bold text-primary transition hover:bg-surface-container-high" href="{{ $isCartCheckout ? $cartUrl : route('student.course-details', ['course' => $course->id]) }}">
                            {{ $isCartCheckout ? 'Back to Cart' : 'Back to Course Details' }}
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    @if($razorpayConfigured && $razorpayOrder)
        <script>
            (function () {
                var checkoutButton = document.getElementById('razorpayCheckoutButton');
                var verifyForm = document.getElementById('razorpayVerifyForm');
                var paymentIdInput = document.getElementById('razorpayPaymentIdInput');
                var orderIdInput = document.getElementById('razorpayOrderIdInput');
                var signatureInput = document.getElementById('razorpaySignatureInput');

                if (!checkoutButton || !verifyForm || typeof Razorpay === 'undefined') {
                    return;
                }

                checkoutButton.addEventListener('click', function () {
                    var options = {
                        key: checkoutButton.dataset.key,
                        amount: Number(checkoutButton.dataset.amount || '0'),
                        currency: 'INR',
                        name: 'The Scholarly Editorial',
                        description: checkoutButton.dataset.courseTitle,
                        order_id: checkoutButton.dataset.orderId,
                        handler: function (response) {
                            paymentIdInput.value = response.razorpay_payment_id || '';
                            orderIdInput.value = response.razorpay_order_id || '';
                            signatureInput.value = response.razorpay_signature || '';
                            verifyForm.submit();
                        },
                        prefill: {
                            name: checkoutButton.dataset.customerName || '',
                            email: checkoutButton.dataset.customerEmail || '',
                        },
                        theme: {
                            color: '#3525cd',
                        }
                    };

                    var razorpay = new Razorpay(options);
                    razorpay.open();
                });
            })();
        </script>
    @endif
</body>
</html>
