<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Create Course - Scholarly Editorial</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#4f46e5",
                        "outline-variant": "#c7c4d8",
                        "secondary-container": "#b6b4ff",
                        "background": "#f8f9fa",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#464555",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#777587",
                        "on-secondary-fixed-variant": "#413f82",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface-tint": "#4d44e3",
                        "on-primary-container": "#dad7ff",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f0f1f2",
                        "primary": "#3525cd",
                        "surface-bright": "#f8f9fa",
                        "secondary-fixed": "#e2dfff",
                        "primary-fixed-dim": "#c3c0ff",
                        "primary-fixed": "#e2dfff",
                        "error": "#ba1a1a",
                        "surface-variant": "#e1e3e4",
                        "secondary-fixed-dim": "#c3c0ff",
                        "surface": "#f8f9fa",
                        "on-error": "#ffffff",
                        "surface-container-high": "#e7e8e9",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#e1e3e4",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#f3f4f5",
                        "secondary": "#58579b",
                        "inverse-surface": "#2e3132",
                        "surface-container": "#edeeef",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#c3c0ff",
                        "surface-dim": "#d9dadb",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#454386",
                        "on-secondary-fixed": "#140f54"
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
            background-color: #f8f9fa;
            color: #191c1d;
        }

        .editorial-shadow {
            box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05);
        }
    </style>
</head>

<body class="bg-surface text-on-background antialiased">
    @php
        $selectedCourse = $course ?? null;
        $selectedCourseId = $selectedCourse?->id;
        $selectedTopics = old('learning_topics', $learningTopicsText ?? '');
        $topicChips = collect(explode(',', $selectedTopics))
            ->map(fn ($topic) => trim($topic))
            ->filter()
            ->values();
    @endphp

    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 w-full pl-16 pr-4 md:px-8 py-4 bg-white/80 backdrop-blur-md flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-4">
                <span class="font-headline text-xl font-bold tracking-tight text-slate-900">Create New Course</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex gap-4">
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                        <span class="material-symbols-outlined">chat_bubble</span>
                    </button>
                </div>
                <div class="h-10 w-10 rounded-full bg-primary-container overflow-hidden">
                    <img alt="Instructor Profile" class="h-full w-full object-cover" src="{{ auth()->user()?->avatarUrl(96) }}" />
                </div>
            </div>
        </header>

        <div class="max-w-6xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-10">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <section class="rounded-[28px] bg-gradient-to-br from-slate-900 via-indigo-900 to-indigo-700 text-white overflow-hidden editorial-shadow">
                <div class="grid gap-8 lg:grid-cols-[1.35fr_0.95fr] p-6 md:p-10">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-indigo-100">
                            Step 1 of 4
                        </div>
                        <div class="space-y-3">
                            <h1 class="font-headline text-4xl md:text-5xl font-bold leading-tight">Shape the course before you build the lessons.</h1>
                            <p class="max-w-2xl text-sm md:text-base text-indigo-100/90 leading-relaxed">Set the title, positioning, and learning identity for your course. This first step gives the rest of the builder a clear structure and keeps every later step aligned.</p>
                        </div>
                    </div>
                    <div class="rounded-[24px] border border-white/15 bg-white/10 p-5 md:p-6 backdrop-blur-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-indigo-100/80">Build Flow</p>
                        <div class="mt-5 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-primary font-bold shadow-lg">1</div>
                                <div>
                                    <p class="text-sm font-bold text-white">Basic Info</p>
                                    <p class="text-xs text-indigo-100/80">Define the course identity</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 opacity-80">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/20 bg-white/5 font-bold text-indigo-100">2</div>
                                <div>
                                    <p class="text-sm font-semibold text-indigo-50">Curriculum</p>
                                    <p class="text-xs text-indigo-100/70">Organize sections and lessons</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 opacity-70">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/20 bg-white/5 font-bold text-indigo-100">3</div>
                                <div>
                                    <p class="text-sm font-semibold text-indigo-50">Pricing</p>
                                    <p class="text-xs text-indigo-100/70">Set value and access</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 opacity-60">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/20 bg-white/5 font-bold text-indigo-100">4</div>
                                <div>
                                    <p class="text-sm font-semibold text-indigo-50">Review</p>
                                    <p class="text-xs text-indigo-100/70">Polish before publishing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                <div class="flex flex-wrap items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white font-bold shadow-lg shadow-indigo-200">1</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Basic Info</p>
                            <p class="text-xs text-slate-500">Current step</p>
                        </div>
                    </div>
                    <div class="hidden md:block h-px flex-1 bg-slate-200"></div>
                    <div class="flex items-center gap-3 opacity-70">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 font-bold">2</div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Curriculum</p>
                            <p class="text-xs text-slate-500">Next step</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 opacity-50">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 font-bold">3</div>
                        <p class="text-sm font-semibold text-slate-600">Pricing</p>
                    </div>
                    <div class="flex items-center gap-3 opacity-40">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 font-bold">4</div>
                        <p class="text-sm font-semibold text-slate-600">Review</p>
                    </div>
                </div>
            </section>

            <form method="POST" action="{{ route('instructor.create-course.store') }}" class="grid grid-cols-12 gap-8 items-start" enctype="multipart/form-data">
                @csrf
                @if($selectedCourseId)
                    <input type="hidden" name="course_id" value="{{ $selectedCourseId }}" />
                @endif
                <div class="col-span-12 xl:col-span-8 space-y-8">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow space-y-8">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary mb-2">Course Fundamentals</p>
                                <h2 class="font-headline text-2xl font-bold text-slate-900">Set the story and positioning of your course</h2>
                            </div>
                            <div class="hidden md:flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-600">
                                <span class="material-symbols-outlined text-sm">offline_pin</span>
                                Auto-save enabled
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Course Title</label>
                                <input class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('title') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-indigo-300 focus:ring-indigo-100' }} px-5 py-4 text-on-surface outline-none transition-all placeholder:text-slate-400" name="title" placeholder="e.g. Advanced Editorial Design & Composition" type="text" value="{{ old('title', $selectedCourse?->title) }}" />
                                <p class="text-[0.72rem] text-on-surface-variant/80">Aim for a title that is specific, searchable, and outcome-focused.</p>
                                @error('title')
                                    <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Description</label>
                                <textarea class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('details') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-indigo-300 focus:ring-indigo-100' }} px-5 py-4 text-on-surface outline-none transition-all placeholder:text-slate-400" name="details" placeholder="Describe the transformation students will experience by the end of this course..." rows="7">{{ old('details', $selectedCourse?->details) }}</textarea>
                                @error('details')
                                    <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Category</label>
                                    <select class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('category_id') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-indigo-300 focus:ring-indigo-100' }} px-5 py-4 text-on-surface outline-none transition-all appearance-none" name="category_id">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected((string) old('category_id', $selectedCourse?->category_id) === (string) $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Difficulty Level</label>
                                    <select class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('level') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-indigo-300 focus:ring-indigo-100' }} px-5 py-4 text-on-surface outline-none transition-all appearance-none" name="level">
                                        <option value="">Select level</option>
                                        <option value="beginner" @selected(old('level', $selectedCourse?->level) === 'beginner')>Beginner</option>
                                        <option value="intermediate" @selected(old('level', $selectedCourse?->level) === 'intermediate')>Intermediate</option>
                                        <option value="advanced" @selected(old('level', $selectedCourse?->level) === 'advanced')>Advanced</option>
                                    </select>
                                    @error('level')
                                        <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Instruction Language</label>
                                    <select class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('language') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-indigo-300 focus:ring-indigo-100' }} px-5 py-4 text-on-surface outline-none transition-all appearance-none" name="language">
                                        <option value="">Select language</option>
                                        <option value="English" @selected(old('language', $selectedCourse?->language) === 'English')>English</option>
                                        <option value="Hindi" @selected(old('language', $selectedCourse?->language) === 'Hindi')>Hindi</option>
                                        <option value="Gujarati" @selected(old('language', $selectedCourse?->language) === 'Gujarati')>Gujarati</option>
                                    </select>
                                    @error('language')
                                        <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-3 md:col-span-2">
                                    <label class="text-[0.75rem] font-bold text-primary uppercase tracking-wider font-label">Languages & Tools Students Will Learn</label>
                                    <input class="w-full rounded-2xl bg-slate-50 border {{ $errors->has('learning_topics') ? 'border-red-300 focus:border-red-300 focus:ring-red-100' : 'border-slate-200 focus:border-indigo-300 focus:ring-indigo-100' }} px-5 py-4 text-on-surface outline-none transition-all placeholder:text-slate-400" name="learning_topics" placeholder="e.g. HTML, CSS, JavaScript, React, Node.js, Git" type="text" value="{{ $selectedTopics }}" />
                                    <div class="flex flex-wrap gap-3">
                                        @forelse($topicChips as $topic)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 border border-indigo-100 px-4 py-2 text-xs font-semibold text-indigo-700">
                                                <span class="material-symbols-outlined text-sm">terminal</span>
                                                {{ $topic }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center gap-2 rounded-full bg-orange-50 border border-orange-100 px-4 py-2 text-xs font-semibold text-orange-700">
                                                <span class="material-symbols-outlined text-sm">language</span>
                                                HTML
                                            </span>
                                            <span class="inline-flex items-center gap-2 rounded-full bg-sky-50 border border-sky-100 px-4 py-2 text-xs font-semibold text-sky-700">
                                                <span class="material-symbols-outlined text-sm">palette</span>
                                                CSS
                                            </span>
                                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 border border-amber-100 px-4 py-2 text-xs font-semibold text-amber-700">
                                                <span class="material-symbols-outlined text-sm">terminal</span>
                                                JavaScript
                                            </span>
                                        @endforelse
                                    </div>
                                    <p class="text-[0.72rem] text-on-surface-variant/80">Add the core technologies, languages, and frameworks learners will confidently use after finishing the course.</p>
                                    @error('learning_topics')
                                        <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <div class="grid gap-6 md:grid-cols-3">
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Target Outcome</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700">Students should know exactly what practical result they will get from your course.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Audience Fit</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700">Keep the level aligned with who the course is for so later lessons feel coherent.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Catalog Readiness</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700">A strong thumbnail and concise summary will help this course stand out in the listing.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 space-y-8">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary mb-2">Thumbnail</p>
                                <h3 class="font-headline text-xl font-bold text-slate-900">Cover preview</h3>
                            </div>
                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-indigo-600">16:9</span>
                        </div>
                        <label class="aspect-video rounded-[22px] bg-gradient-to-br from-slate-100 via-slate-50 to-indigo-50 border border-dashed {{ $errors->has('thumbnail') ? 'border-red-300' : 'border-slate-300 hover:border-indigo-300' }} flex flex-col items-center justify-center p-6 text-center group cursor-pointer transition-all overflow-hidden relative">
                            @if($selectedCourse?->thumbnail)
                                <img alt="Course Thumbnail Preview" class="absolute inset-0 h-full w-full object-cover" src="{{ $selectedCourse->thumbnail }}" />
                                <div class="absolute inset-0 bg-slate-900/35"></div>
                            @endif
                            <div class="relative z-10">
                                <span class="material-symbols-outlined text-5xl {{ $selectedCourse?->thumbnail ? 'text-white' : 'text-indigo-300' }} mb-4 group-hover:scale-110 transition-transform">add_photo_alternate</span>
                                <p class="text-sm font-semibold {{ $selectedCourse?->thumbnail ? 'text-white' : 'text-slate-700' }}">{{ $selectedCourse?->thumbnail ? 'Replace uploaded thumbnail' : 'Click to upload or drag and drop' }}</p>
                                <p class="text-[0.7rem] {{ $selectedCourse?->thumbnail ? 'text-indigo-100' : 'text-slate-500' }} mt-2 uppercase tracking-[0.18em]">PNG or JPG up to 10MB</p>
                            </div>
                            <input class="hidden" name="thumbnail" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" />
                        </label>
                        @error('thumbnail')
                            <p class="mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-5 rounded-2xl bg-indigo-50 border border-indigo-100 p-4">
                            <p class="text-xs leading-relaxed text-indigo-900"><span class="font-bold">Editorial Tip:</span> Use a bold focal image with clear contrast so the course feels premium at first glance.</p>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline text-xl font-bold text-slate-900">Step 1 Checklist</h3>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-emerald-600">In Progress</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-emerald-600 text-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Course title drafted</p>
                                    <p class="text-xs text-slate-500">Keep it benefit-led and easy to scan.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-emerald-600 text-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Audience and level aligned</p>
                                    <p class="text-xs text-slate-500">This keeps your curriculum focused in step 2.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-slate-300 text-lg">radio_button_unchecked</span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Thumbnail still needed</p>
                                    <p class="text-xs text-slate-500">Upload before final review for a complete listing.</p>
                                </div>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-slate-100 space-y-3">
                            <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-5 py-4 text-sm font-bold text-white editorial-shadow hover:opacity-90 active:scale-[0.99] transition-all" type="submit">
                                <span>Continue to Curriculum</span>
                                <span class="material-symbols-outlined text-[1.1rem]">arrow_forward</span>
                            </button>
                            <button class="w-full rounded-2xl bg-slate-100 px-5 py-4 text-sm font-bold text-primary hover:bg-slate-200 transition-colors" type="submit">
                                Save Draft
                            </button>
                            <p class="text-center text-[0.72rem] font-medium text-slate-500">Auto-saved 2 minutes ago</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
