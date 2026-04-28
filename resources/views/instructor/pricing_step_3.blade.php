<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pricing Setup - CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#b07ac3",
                        "outline-variant": "#dbcde4",
                        "secondary-container": "#eadcf1",
                        "background": "#fcf9fe",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#6d5a76",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#8f7a99",
                        "on-secondary-fixed-variant": "#755b83",
                        "on-primary-fixed-variant": "#8f52a3",
                        "surface-tint": "#b07ac3",
                        "on-primary-container": "#f5eef8",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f5fbff",
                        "primary": "#6a3378",
                        "surface-bright": "#fcf9fe",
                        "secondary-fixed": "#f0e6f4",
                        "primary-fixed-dim": "#e1cde8",
                        "primary-fixed": "#f0e6f4",
                        "error": "#ba1a1a",
                        "surface-variant": "#e7dcef",
                        "secondary-fixed-dim": "#e1cde8",
                        "surface": "#fcf9fe",
                        "on-error": "#ffffff",
                        "surface-container-high": "#efe5f4",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#e7dcef",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#f5eef8",
                        "secondary": "#3b5f8d",
                        "inverse-surface": "#563060",
                        "surface-container": "#f2e9f6",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#e1cde8",
                        "surface-dim": "#d4e3f8",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#715f7a",
                        "on-secondary-fixed": "#4b2356"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fcf9fe;
            color: #191c1d;
        }

        .editorial-shadow {
            box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05);
        }
    </style>
</head>

<body class="bg-surface text-on-background antialiased">
    @php
        $courseQuery = request()->query('course');
        $pricingCourse = $course ?? null;
        $selectedPricingModel = old('pricing_model', $pricingCourse?->pricing_model ?? 'one_time');
        $selectedSubscriptionCycle = old('subscription_cycle', $pricingCourse?->subscription_cycle);
        $selectedValidity = old('validity_in_days', $pricingCourse?->validity_in_days);
        $promotionalNote = old('promotional_note', $pricingCourse?->promotional_note);
    @endphp

    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 w-full pl-16 pr-4 md:px-8 py-4 bg-white/88 backdrop-blur-md border-b border-[#eadff1] flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-4">
                <span class="font-headline text-xl font-bold tracking-tight text-slate-900">Create New Course</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex gap-4">
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button"><span class="material-symbols-outlined">notifications</span></button>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button"><span class="material-symbols-outlined">chat_bubble</span></button>
                </div>
                <div class="h-10 w-10 rounded-full bg-primary-container overflow-hidden">
                    <img alt="Instructor Profile" class="h-full w-full object-cover" src="{{ auth()->user()?->avatarUrl(96) }}" />
                </div>
            </div>
        </header>

        <div class="max-w-6xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-10">
            <section class="rounded-[28px] bg-gradient-to-br from-slate-900 via-indigo-900 to-violet-800 text-white overflow-hidden editorial-shadow">
                <div class="grid gap-8 lg:grid-cols-[1.35fr_0.95fr] p-6 md:p-10">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#eadff1]">Step 3 of 4</div>
                        <div class="space-y-3">
                            <h1 class="font-headline text-4xl md:text-5xl font-bold leading-tight">Price the course so the offer feels clear and valuable.</h1>
                            <p class="max-w-2xl text-sm md:text-base text-[#eadff1]/90 leading-relaxed">Choose the access model, duration, and learner-facing pricing details. This is where your course becomes a product, not just content.</p>
                        </div>
                    </div>
                    <div class="rounded-[24px] border border-white/15 bg-white/10 p-5 md:p-6 backdrop-blur-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#eadff1]/80">Build Flow</p>
                        <div class="mt-5 space-y-4">
                            <div class="flex items-center gap-4 opacity-85"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">1</div><div><p class="text-sm font-bold text-white">Basic Info</p><p class="text-xs text-[#eadff1]/80">Completed</p></div></div>
                            <div class="flex items-center gap-4 opacity-85"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">2</div><div><p class="text-sm font-bold text-white">Curriculum</p><p class="text-xs text-[#eadff1]/80">Completed</p></div></div>
                            <div class="flex items-center gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">3</div><div><p class="text-sm font-bold text-white">Pricing</p><p class="text-xs text-[#eadff1]/80">Current step</p></div></div>
                            <div class="flex items-center gap-4 opacity-60"><div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/20 bg-white/5 font-bold text-[#eadff1]">4</div><div><p class="text-sm font-semibold text-[#f5fbff]">Review</p><p class="text-xs text-[#eadff1]/70">Final check</p></div></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                <div class="flex flex-wrap items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-3 opacity-70"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg border border-[#eadff1]">1</div><div><p class="text-sm font-bold text-slate-900">Basic Info</p><p class="text-xs text-slate-500">Done</p></div></div>
                    <div class="hidden md:block h-px flex-1 bg-slate-200"></div>
                    <div class="flex items-center gap-3 opacity-70"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg border border-[#eadff1]">2</div><div><p class="text-sm font-bold text-slate-900">Curriculum</p><p class="text-xs text-slate-500">Done</p></div></div>
                    <div class="flex items-center gap-3"><div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white font-bold shadow-lg shadow-indigo-200">3</div><div><p class="text-sm font-bold text-slate-900">Pricing</p><p class="text-xs text-slate-500">Current step</p></div></div>
                    <div class="flex items-center gap-3 opacity-45"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 font-bold">4</div><p class="text-sm font-semibold text-slate-600">Review</p></div>
                </div>
            </section>

            @if(session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('instructor.create-course.pricing.store', ['course' => $courseQuery]) }}" class="grid grid-cols-12 gap-8 items-start">
                @csrf
                <input type="hidden" name="course_id" value="{{ $pricingCourse?->id }}" />
                <div class="col-span-12 xl:col-span-8 space-y-8">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow space-y-8">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary mb-2">Monetization Setup</p>
                            <h2 class="font-headline text-2xl font-bold text-slate-900">Define access, value, and pricing confidence</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="rounded-[24px] {{ $selectedPricingModel === 'one_time' ? 'border-2 border-primary bg-[#f5eef8]' : 'border border-slate-200 bg-white hover:border-slate-300' }} p-5 cursor-pointer transition-colors">
                                <input class="sr-only pricing-model-input" name="pricing_model" type="radio" value="one_time" @checked($selectedPricingModel === 'one_time') />
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">One-time purchase</p>
                                        <p class="mt-2 text-xs leading-relaxed text-slate-600">Best for signature courses with full lifetime or long-term access.</p>
                                    </div>
                                    <div class="flex h-6 w-6 items-center justify-center rounded-full {{ $selectedPricingModel === 'one_time' ? 'bg-primary text-white' : 'border border-slate-300 text-transparent' }}">
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                                    </div>
                                </div>
                            </label>
                            <label class="rounded-[24px] {{ $selectedPricingModel === 'subscription' ? 'border-2 border-primary bg-[#f5eef8]' : 'border border-slate-200 bg-white hover:border-slate-300' }} p-5 cursor-pointer transition-colors">
                                <input class="sr-only pricing-model-input" name="pricing_model" type="radio" value="subscription" @checked($selectedPricingModel === 'subscription') />
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Subscription access</p>
                                        <p class="mt-2 text-xs leading-relaxed text-slate-600">Useful when your course is part of a continuously updated learning library.</p>
                                    </div>
                                    <div class="flex h-6 w-6 items-center justify-center rounded-full {{ $selectedPricingModel === 'subscription' ? 'bg-primary text-white' : 'border border-slate-300 text-transparent' }}">
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('pricing_model')
                            <p class="text-xs font-medium text-red-600 -mt-2">{{ $message }}</p>
                        @enderror

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Course Price</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 font-semibold">Rs.</span>
                                    <input class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('price') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-[#c79ad4] focus:ring-[#eadff1]' }} pl-16 pr-5 py-4 text-on-surface outline-none transition-all" name="price" placeholder="2999" type="number" min="0" step="0.01" value="{{ old('price', $pricingCourse?->price) }}" />
                                </div>
                                @error('price')
                                    <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-2 {{ $selectedPricingModel === 'subscription' ? 'hidden' : '' }}" id="validityField">
                                <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Validity</label>
                                <select class="w-full rounded-2xl bg-slate-50 border border-slate-200 px-5 py-4 text-on-surface outline-none transition-all focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1] appearance-none" name="validity_in_days">
                                    <option value="" @selected($selectedValidity === null)>Lifetime Access</option>
                                    <option value="30" @selected((string) $selectedValidity === '30')>30 Days</option>
                                    <option value="90" @selected((string) $selectedValidity === '90')>90 Days</option>
                                    <option value="365" @selected((string) $selectedValidity === '365')>365 Days</option>
                                </select>
                            </div>
                            <div class="space-y-2 {{ $selectedPricingModel === 'subscription' ? '' : 'hidden' }}" id="subscriptionCycleField">
                                <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Subscription Cycle</label>
                                <select class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('subscription_cycle') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-[#c79ad4] focus:ring-[#eadff1]' }} px-5 py-4 text-on-surface outline-none transition-all focus:ring-4 appearance-none" name="subscription_cycle">
                                    <option value="" @selected(blank($selectedSubscriptionCycle))>Choose billing cycle</option>
                                    <option value="monthly" @selected($selectedSubscriptionCycle === 'monthly')>Monthly</option>
                                    <option value="quarterly" @selected($selectedSubscriptionCycle === 'quarterly')>Quarterly</option>
                                    <option value="yearly" @selected($selectedSubscriptionCycle === 'yearly')>Yearly</option>
                                </select>
                                @error('subscription_cycle')
                                    <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Promotional Note</label>
                                <input class="w-full rounded-2xl bg-slate-50 border border-slate-200 px-5 py-4 text-on-surface outline-none transition-all focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1] placeholder:text-slate-400" name="promotional_note" placeholder="Optional line shown during launch, e.g. Early-bird pricing for the first 100 learners" type="text" value="{{ $promotionalNote }}" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <div class="grid gap-6 md:grid-cols-3">
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Anchor Value</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700">Learners should understand what outcomes justify this price point.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Access Promise</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700">Set clear expectations around validity, updates, and support window.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Launch Readiness</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700">A simple offer often converts better than too many pricing choices.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 space-y-8">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline text-xl font-bold text-slate-900">Pricing Snapshot</h3>
                            <span class="rounded-full bg-amber-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-amber-600">Draft</span>
                        </div>
                            <div class="rounded-[24px] bg-gradient-to-br from-primary to-primary-container p-6 text-white">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#eadff1]">Suggested Public Price</p>
                            <p class="mt-3 font-headline text-4xl font-bold">Rs. {{ number_format((float) old('price', $pricingCourse?->price ?? 0), 0) }}</p>
                            <p class="mt-2 text-sm text-[#eadff1]/85" id="pricingSnapshotMessage">
                                {{ $selectedPricingModel === 'subscription'
                                    ? 'Recurring access is active for your learning library offer.'
                                    : 'Strong mid-tier positioning for a premium guided course.' }}
                            </p>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-emerald-600 text-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <div><p class="text-sm font-semibold text-slate-900">Pricing model selected</p><p class="text-xs text-slate-500" id="pricingModelSummary">{{ $selectedPricingModel === 'subscription' ? 'Subscription access is set.' : 'One-time purchase is set.' }}</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined {{ filled($promotionalNote) ? 'text-emerald-600' : 'text-slate-300' }} text-lg">{{ filled($promotionalNote) ? 'check_circle' : 'radio_button_unchecked' }}</span>
                                <div><p class="text-sm font-semibold text-slate-900">{{ filled($promotionalNote) ? 'Launch note added' : 'Launch note pending' }}</p><p class="text-xs text-slate-500">{{ filled($promotionalNote) ? $promotionalNote : 'Optional, but helpful during promotion.' }}</p></div>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-slate-100 space-y-3">
                            <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-5 py-4 text-sm font-bold text-white editorial-shadow hover:opacity-90 active:scale-[0.99] transition-all" type="submit">
                                <span>Next: Review</span>
                                <span class="material-symbols-outlined text-[1.1rem]">arrow_forward</span>
                            </button>
                            <a class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-5 py-4 text-sm font-bold text-primary hover:bg-slate-200 transition-colors" href="{{ route('instructor.create-course.curriculum', ['course' => $courseQuery]) }}">
                                <span class="material-symbols-outlined text-[1.1rem]">arrow_back</span>
                                <span>Previous: Curriculum</span>
                            </a>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-gradient-to-br from-amber-500 to-orange-500 p-6 text-white shadow-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-100 mb-2">Pricing Tip</p>
                        <h3 class="font-headline text-xl font-bold">Use a price that reflects transformation, not just lesson count.</h3>
                        <p class="mt-3 text-sm leading-relaxed text-amber-50/90">If the course saves time, improves work quality, or helps learners earn more, the price should confidently communicate that value.</p>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        (function () {
            var pricingInputs = Array.from(document.querySelectorAll('.pricing-model-input'));
            var validityField = document.getElementById('validityField');
            var subscriptionCycleField = document.getElementById('subscriptionCycleField');
            var pricingModelSummary = document.getElementById('pricingModelSummary');
            var pricingSnapshotMessage = document.getElementById('pricingSnapshotMessage');

            function syncPricingMode() {
                var selected = pricingInputs.find(function (input) {
                    return input.checked;
                });
                var mode = selected ? selected.value : 'one_time';
                var isSubscription = mode === 'subscription';

                pricingInputs.forEach(function (input) {
                    var card = input.closest('label');

                    if (!card) {
                        return;
                    }

                    var isActive = input.checked;
                    card.classList.toggle('border-2', isActive);
                    card.classList.toggle('border-primary', isActive);
                    card.classList.toggle('bg-[#f5eef8]', isActive);
                    card.classList.toggle('border', !isActive);
                    card.classList.toggle('border-slate-200', !isActive);
                    card.classList.toggle('bg-white', !isActive);

                    var indicator = card.querySelector('.material-symbols-outlined');
                    var indicatorWrap = indicator ? indicator.parentElement : null;

                    if (indicatorWrap) {
                        indicatorWrap.classList.toggle('bg-primary', isActive);
                        indicatorWrap.classList.toggle('text-white', isActive);
                        indicatorWrap.classList.toggle('border', !isActive);
                        indicatorWrap.classList.toggle('border-slate-300', !isActive);
                        indicatorWrap.classList.toggle('text-transparent', !isActive);
                    }
                });

                if (validityField) {
                    validityField.classList.toggle('hidden', isSubscription);
                }

                if (subscriptionCycleField) {
                    subscriptionCycleField.classList.toggle('hidden', !isSubscription);
                }

                if (pricingModelSummary) {
                    pricingModelSummary.textContent = isSubscription ? 'Subscription access is set.' : 'One-time purchase is set.';
                }

                if (pricingSnapshotMessage) {
                    pricingSnapshotMessage.textContent = isSubscription
                        ? 'Recurring access is active for your learning library offer.'
                        : 'Strong mid-tier positioning for a premium guided course.';
                }
            }

            pricingInputs.forEach(function (input) {
                input.addEventListener('change', syncPricingMode);
            });

            syncPricingMode();
        })();
    </script>
</body>

</html>




