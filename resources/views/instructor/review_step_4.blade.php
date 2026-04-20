<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Review Course - CodeInYourself</title>
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
                        "background": "#fcf9fe",
                        "primary": "#6a3378",
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
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
<body class="bg-background text-slate-900 antialiased">
    @php
        $courseQuery = request()->query('course');
        $reviewCourse = $course ?? null;
        $reviewTopics = collect($reviewCourse?->learning_topics ?? []);
        $reviewDescription = $reviewCourse?->details ?: 'Your saved course description will appear here once step 1 is completed.';
        $reviewTitle = $reviewCourse?->title ?: 'Untitled Draft Course';
        $reviewCategory = $reviewCourse?->category?->name ?: 'Uncategorized';
        $reviewLevel = $reviewCourse?->level ? ucfirst($reviewCourse->level) : 'Not set';
        $reviewLanguage = $reviewCourse?->language ?: 'Not set';
        $reviewPrice = $reviewCourse ? 'Rs. '.number_format((float) $reviewCourse->price, 0) : 'Rs. 0';
        $reviewPricingModel = $reviewCourse?->pricing_model ?? 'one_time';
        $reviewSubscriptionCycle = $reviewCourse?->subscription_cycle ? ucfirst($reviewCourse->subscription_cycle) : null;
        $reviewPromotionalNote = $reviewCourse?->promotional_note;
        $reviewAccessLabel = $reviewPricingModel === 'subscription'
            ? (($reviewSubscriptionCycle ? $reviewSubscriptionCycle.' subscription' : 'Subscription access'))
            : ($reviewCourse?->validity_in_days ? $reviewCourse->validity_in_days.' Days' : 'Lifetime');
        $reviewSectionsCount = $reviewCourse?->sections?->count() ?? 0;
        $reviewLessonsCount = $reviewCourse?->sections?->sum(fn ($section) => $section->videos->count()) ?? 0;
        $reviewResourcesCount = $reviewCourse?->sections?->sum(fn ($section) => $section->videos->sum(fn ($video) => $video->materials->count())) ?? 0;
        $reviewThumbnail = $reviewCourse?->thumbnail;
        $reviewContentStatus = $reviewCourse?->content_status ?? 'pending';
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
            </div>
        </header>

        <div class="max-w-6xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-10">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            <section class="rounded-[28px] bg-gradient-to-br from-slate-950 via-[#452157] to-[#8f52a3] text-white overflow-hidden editorial-shadow">
                <div class="grid gap-8 lg:grid-cols-[1.35fr_0.95fr] p-6 md:p-10">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100">Step 4 of 4</div>
                        <div class="space-y-3">
                            <h1 class="font-headline text-4xl md:text-5xl font-bold leading-tight">Review everything before you publish with confidence.</h1>
                            <p class="max-w-2xl text-sm md:text-base text-emerald-100/90 leading-relaxed">This final pass helps you confirm the course feels complete, priced well, and ready for learners to discover.</p>
                        </div>
                    </div>
                    <div class="rounded-[24px] border border-white/15 bg-white/10 p-5 md:p-6 backdrop-blur-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-100/80">Build Flow</p>
                        <div class="mt-5 space-y-4">
                            <div class="flex items-center gap-4 opacity-85"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">1</div><div><p class="text-sm font-bold text-white">Basic Info</p><p class="text-xs text-emerald-100/80">Completed</p></div></div>
                            <div class="flex items-center gap-4 opacity-85"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">2</div><div><p class="text-sm font-bold text-white">Curriculum</p><p class="text-xs text-emerald-100/80">Completed</p></div></div>
                            <div class="flex items-center gap-4 opacity-85"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">3</div><div><p class="text-sm font-bold text-white">Pricing</p><p class="text-xs text-emerald-100/80">Completed</p></div></div>
                            <div class="flex items-center gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">4</div><div><p class="text-sm font-bold text-white">Review</p><p class="text-xs text-emerald-100/80">Current step</p></div></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                <div class="flex flex-wrap items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-3 opacity-70"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg border border-[#eadff1]">1</div><p class="text-sm font-semibold text-slate-700">Basic Info</p></div>
                    <div class="hidden md:block h-px flex-1 bg-slate-200"></div>
                    <div class="flex items-center gap-3 opacity-70"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg border border-[#eadff1]">2</div><p class="text-sm font-semibold text-slate-700">Curriculum</p></div>
                    <div class="flex items-center gap-3 opacity-70"><div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg border border-[#eadff1]">3</div><p class="text-sm font-semibold text-slate-700">Pricing</p></div>
                    <div class="flex items-center gap-3"><div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white font-bold shadow-lg shadow-indigo-200">4</div><div><p class="text-sm font-bold text-slate-900">Review</p><p class="text-xs text-slate-500">Final step</p></div></div>
                </div>
            </section>

            <section class="grid grid-cols-12 gap-8 items-start">
                <div class="col-span-12 xl:col-span-8 space-y-8">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <div class="flex items-start justify-between gap-6 mb-6">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary mb-2">Course Review</p>
                                <h2 class="font-headline text-2xl font-bold text-slate-900">A final preview of what learners will see</h2>
                            </div>
                            <span class="rounded-full {{ $reviewContentStatus === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em]">
                                {{ $reviewContentStatus === 'completed' ? 'Course Completed' : 'More Content Coming' }}
                            </span>
                        </div>

                        <div class="rounded-[26px] border border-slate-200 overflow-hidden">
                            @if($reviewThumbnail)
                                <div class="aspect-[16/7] bg-slate-100">
                                    <img alt="Course Thumbnail" class="h-full w-full object-cover" src="{{ $reviewThumbnail }}" />
                                </div>
                            @else
                                <div class="aspect-[16/7] bg-gradient-to-br from-slate-200 via-slate-100 to-indigo-100 flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-5xl text-[#76c6ff]">auto_stories</span>
                                        <p class="mt-3 text-sm font-semibold text-slate-600">Course thumbnail preview</p>
                                    </div>
                                </div>
                            @endif
                            <div class="p-6 md:p-8 space-y-6 bg-white">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">{{ $reviewCategory }} • {{ $reviewLevel }}</p>
                                    <h3 class="mt-3 font-headline text-3xl font-bold text-slate-900">{{ $reviewTitle }}</h3>
                                    <p class="mt-4 max-w-3xl text-sm leading-relaxed text-slate-600">{{ $reviewDescription }}</p>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-xs uppercase tracking-[0.16em] font-semibold text-slate-500">Price</p><p class="mt-2 text-xl font-bold text-slate-900">{{ $reviewPrice }}</p></div>
                                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-xs uppercase tracking-[0.16em] font-semibold text-slate-500">Access</p><p class="mt-2 text-xl font-bold text-slate-900">{{ $reviewAccessLabel }}</p></div>
                                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-xs uppercase tracking-[0.16em] font-semibold text-slate-500">Pricing Model</p><p class="mt-2 text-xl font-bold text-slate-900">{{ $reviewPricingModel === 'subscription' ? 'Subscription' : 'One-Time' }}</p></div>
                                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-xs uppercase tracking-[0.16em] font-semibold text-slate-500">Sections</p><p class="mt-2 text-xl font-bold text-slate-900">{{ $reviewSectionsCount }}</p></div>
                                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-xs uppercase tracking-[0.16em] font-semibold text-slate-500">Lessons</p><p class="mt-2 text-xl font-bold text-slate-900">{{ $reviewLessonsCount }}</p></div>
                                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-xs uppercase tracking-[0.16em] font-semibold text-slate-500">Resources</p><p class="mt-2 text-xl font-bold text-slate-900">{{ $reviewResourcesCount }}</p></div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">Language</p>
                                        <p class="mt-3 text-lg font-bold text-slate-900">{{ $reviewLanguage }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">Student Release</p>
                                        <p class="mt-3 text-sm font-medium text-slate-700">{{ $reviewContentStatus === 'completed' ? 'Students will see the course as complete and certificate-ready.' : 'Students will see that more sections or videos are coming soon.' }}</p>
                                    </div>
                                </div>
                                @if($reviewPromotionalNote)
                                    <div class="rounded-2xl border border-[#eadff1] bg-[#f5eef8]/70 p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">Promotional Note</p>
                                        <p class="mt-3 text-sm font-medium text-slate-700">{{ $reviewPromotionalNote }}</p>
                                    </div>
                                @endif
                                <div class="rounded-[24px] border border-slate-200 bg-slate-50/70 p-5">
                                    <div class="flex items-center justify-between gap-4 mb-4">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">Languages & Tools</p>
                                            <h4 class="mt-2 font-headline text-xl font-bold text-slate-900">What learners will build with</h4>
                                        </div>
                                        <span class="rounded-full bg-white border border-slate-200 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-slate-600">IT Track</span>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @forelse($reviewTopics as $topic)
                                            @php
                                                $cardStyles = match (strtolower($topic)) {
                                                    'html' => ['border-orange-100', 'bg-orange-50', 'text-orange-600', 'language', 'Semantic page structure'],
                                                    'css' => ['border-sky-100', 'bg-sky-50', 'text-sky-600', 'palette', 'Responsive UI styling'],
                                                    'javascript' => ['border-amber-100', 'bg-amber-50', 'text-amber-600', 'terminal', 'Interactive app logic'],
                                                    'react' => ['border-[#eadff1]', 'bg-[#f5eef8]', 'text-[#6a3378]', 'view_comfy', 'Modern component UI'],
                                                    'node.js', 'nodejs', 'node' => ['border-emerald-100', 'bg-emerald-50', 'text-emerald-600', 'hub', 'Backend foundations'],
                                                    'git' => ['border-slate-200', 'bg-slate-100', 'text-slate-700', 'source_branch', 'Version control workflow'],
                                                    default => ['border-violet-100', 'bg-violet-50', 'text-violet-600', 'deployed_code', 'Core project technology'],
                                                };
                                            @endphp
                                            <div class="rounded-2xl bg-white border {{ $cardStyles[0] }} p-4">
                                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $cardStyles[1] }} {{ $cardStyles[2] }}">
                                                    <span class="material-symbols-outlined">{{ $cardStyles[3] }}</span>
                                                </div>
                                                <p class="mt-4 text-sm font-bold text-slate-900">{{ $topic }}</p>
                                                <p class="mt-1 text-xs text-slate-500">{{ $cardStyles[4] }}</p>
                                            </div>
                                        @empty
                                            <div class="col-span-full rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-500">
                                                No technologies saved yet. Add them in step 1 to show the IT stack here.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <h3 class="font-headline text-xl font-bold text-slate-900 mb-5">Launch Checklist</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4"><p class="text-sm font-bold text-slate-900">Basic information looks complete</p><p class="mt-2 text-xs text-slate-600">Title, description, level, category, and language are loaded from your saved draft.</p></div>
                            <div class="rounded-2xl border {{ $reviewSectionsCount > 0 ? 'border-emerald-200 bg-emerald-50' : 'border-amber-200 bg-amber-50' }} p-4"><p class="text-sm font-bold text-slate-900">Curriculum structure is in place</p><p class="mt-2 text-xs text-slate-600">{{ $reviewSectionsCount > 0 ? 'Sections and lessons are arranged clearly for learners.' : 'Add at least one section and lesson before publishing.' }}</p></div>
                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4"><p class="text-sm font-bold text-slate-900">Pricing is configured</p><p class="mt-2 text-xs text-slate-600">The value proposition and access duration are aligned.</p></div>
                            <div class="rounded-2xl border {{ $reviewThumbnail ? 'border-emerald-200 bg-emerald-50' : 'border-amber-200 bg-amber-50' }} p-4"><p class="text-sm font-bold text-slate-900">{{ $reviewThumbnail ? 'Thumbnail is visible and ready' : 'Thumbnail can be improved later' }}</p><p class="mt-2 text-xs text-slate-600">{{ $reviewThumbnail ? 'Your uploaded course cover is now visible in the final review preview.' : 'The course is publishable, but a strong cover image will lift discoverability.' }}</p></div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 space-y-8">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline text-xl font-bold text-slate-900">Publish Panel</h3>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-emerald-600">Ready</span>
                        </div>
                        <div class="rounded-[24px] bg-gradient-to-br from-emerald-600 to-teal-600 p-6 text-white">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">Status</p>
                            <p class="mt-3 font-headline text-3xl font-bold">Publishable</p>
                            <p class="mt-2 text-sm text-emerald-50/90">Everything essential is in place for a confident first release.</p>
                        </div>
                        @error('publish')
                            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $message }}</div>
                        @enderror
                        <div class="space-y-3">
                            <form method="POST" action="{{ route('instructor.create-course.publish') }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $reviewCourse?->id }}" />
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-5 py-4 text-sm font-bold text-white editorial-shadow hover:opacity-90 active:scale-[0.99] transition-all" type="submit">
                                    <span>Publish Course</span>
                                    <span class="material-symbols-outlined text-[1.1rem]">rocket_launch</span>
                                </button>
                            </form>
                            <a class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-5 py-4 text-sm font-bold text-primary hover:bg-slate-200 transition-colors" href="{{ route('instructor.create-course', ['course' => $courseQuery]) }}">
                                <span class="material-symbols-outlined text-[1.1rem]">draft</span>
                                <span>Continue Editing Draft</span>
                            </a>
                            <a class="w-full inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors" href="{{ route('instructor.create-course.pricing', ['course' => $courseQuery]) }}">
                                <span class="material-symbols-outlined text-[1.1rem]">arrow_back</span>
                                <span>Back to Pricing</span>
                            </a>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-gradient-to-br from-slate-900 to-slate-700 p-6 text-white shadow-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-300 mb-2">Launch Note</p>
                        <h3 class="font-headline text-xl font-bold">Publishing is the start of iteration, not the end of creation.</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-200/90">Once live, you can keep improving the thumbnail, add more resources, and respond to student feedback without breaking the flow you built here.</p>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>




