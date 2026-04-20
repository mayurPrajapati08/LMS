@php
    $courseCount = method_exists($offlineCourses, 'total') ? $offlineCourses->total() : $offlineCourses->count();
    $editingCurriculum = collect(old('curriculum_modules', $editingCourse->curriculum_modules ?? []))
        ->map(function ($module) {
            return [
                'title' => $module['title'] ?? '',
                'duration' => $module['duration'] ?? '',
                'topics' => is_array($module['topics'] ?? null) ? implode(PHP_EOL, $module['topics']) : ($module['topics'] ?? ''),
                'project' => $module['project'] ?? '',
            ];
        })
        ->values();

    if ($editingCurriculum->isEmpty()) {
        $editingCurriculum = collect([[
            'title' => '',
            'duration' => '',
            'topics' => '',
            'project' => '',
        ]]);
    }
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Offline Courses | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .panel {
            border: 1px solid rgba(214, 228, 240, 0.92);
            border-radius: 1.9rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,251,255,0.96));
            box-shadow: 0 24px 60px rgba(15,23,42,0.07);
        }
        .section-card {
            border: 1px solid rgba(221, 233, 245, 0.95);
            border-radius: 1.6rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(244,249,255,0.92));
            padding: 1.25rem;
        }
        .field {
            width: 100%;
            border-radius: 1.15rem;
            border: 1px solid rgb(207 223 236);
            background: linear-gradient(180deg, rgba(255,255,255,1), rgba(250,252,255,1));
            padding: .95rem 1rem;
            color: rgb(15 23 42);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.72);
        }
        .field:focus {
            outline: none;
            border-color: rgb(14 165 233);
            box-shadow: 0 0 0 4px rgba(14,165,233,0.12);
        }
        .label {
            display: block;
            margin-bottom: .55rem;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgb(14 116 144);
        }
        .helper {
            margin-top: .45rem;
            font-size: .82rem;
            line-height: 1.5;
            color: rgb(100 116 139);
        }
        .metric-tile {
            border: 1px solid rgba(255,255,255,0.16);
            border-radius: 1.4rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.16), rgba(255,255,255,0.08));
            padding: 1rem 1.1rem;
            backdrop-filter: blur(12px);
        }
        .curriculum-card {
            border: 1px solid rgba(191, 219, 254, 0.85);
            border-radius: 1.45rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(239,246,255,0.92));
            padding: 1rem;
        }
    </style>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,rgba(103,232,249,0.16),transparent_22%),linear-gradient(180deg,#f8fbff_0%,#eef6ff_54%,#f7fbff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
        @endif

        <section class="overflow-hidden rounded-[2.2rem] bg-[linear-gradient(135deg,#082f49_0%,#0f766e_48%,#67e8f9_100%)] px-6 py-8 text-white shadow-[0_28px_90px_rgba(8,47,73,0.22)] md:px-8">
            <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr] xl:items-end">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-cyan-100/80">Offline Course Studio</p>
                    <h1 class="mt-4 max-w-4xl font-headline text-3xl font-extrabold md:text-5xl">
                        {{ $editingCourse ? 'Refine the course brochure and keep every batch detail structured.' : 'Build brochure-style offline course entries that match your real PDF course sheets.' }}
                    </h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-cyan-50/84">
                        This form now supports course overview, validity, delivery mode, placement messaging, curriculum modules, projects, benefits, and learner notes so HR can enter offline course data exactly the way it appears in your brochure.
                    </p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="metric-tile">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-100/72">Managed Courses</p>
                        <p class="mt-3 font-headline text-4xl font-extrabold">{{ $courseCount }}</p>
                        <p class="mt-2 text-sm text-cyan-50/78">Offline course cards available in the HR panel.</p>
                    </div>
                    <div class="metric-tile">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-100/72">Brochure Ready</p>
                        <p class="mt-3 font-headline text-2xl font-extrabold">Structured Input</p>
                        <p class="mt-2 text-sm text-cyan-50/78">Modules, benefits, and learner notes can be added cleanly.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Platform Controls</p>
                    <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">Online and offline course switching</h2>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-500">Keep public visibility and student access under control while the offline catalog remains the primary entry point.</p>
                </div>
            </div>

            <form action="{{ route('hr.offline-courses.platform') }}" method="POST" class="mt-7 space-y-5">
                @csrf
                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label class="label" for="catalog_default_mode">Default Public Catalog</label>
                        <select id="catalog_default_mode" name="catalog_default_mode" class="field">
                            <option value="offline" @selected($platformSettings['catalog_default_mode'] === 'offline')>Offline first</option>
                            <option value="online" @selected($platformSettings['catalog_default_mode'] === 'online')>Online first</option>
                        </select>
                    </div>
                    <div>
                        <label class="label" for="online_student_access_mode">Online Student Access Mode</label>
                        <select id="online_student_access_mode" name="online_student_access_mode" class="field">
                            <option value="disabled" @selected($platformSettings['online_student_access_mode'] === 'disabled')>Disabled</option>
                            <option value="limited" @selected($platformSettings['online_student_access_mode'] === 'limited')>Limited</option>
                        </select>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        'catalog_offline_enabled' => 'Show offline public catalog',
                        'catalog_online_enabled' => 'Show online public catalog',
                        'student_catalog_enabled' => 'Allow student browse online courses',
                        'student_wishlist_enabled' => 'Allow wishlist access',
                        'student_cart_enabled' => 'Allow cart access',
                        'student_checkout_enabled' => 'Allow checkout access',
                        'student_payments_enabled' => 'Allow payments page',
                    ] as $key => $labelText)
                        <label class="rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700">
                            <span class="block leading-6">{{ $labelText }}</span>
                            <input class="mt-4 h-5 w-5 rounded border-slate-300 text-sky-600" name="{{ $key }}" type="checkbox" value="1" @checked($platformSettings[$key]) />
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(15,23,42,0.18)]">Save Course Controls</button>
            </form>
        </section>

        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">{{ $editingCourse ? 'Edit Offline Course' : 'New Offline Course' }}</p>
                    <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingCourse ? 'Update brochure-style course entry' : 'Create brochure-style course entry' }}</h2>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-500">Use the same structure as your offline course PDF so course management becomes much faster and less error-prone.</p>
                </div>
                @if ($editingCourse)
                    <a href="{{ route('hr.offline-courses') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700">Cancel Edit</a>
                @endif
            </div>

            <form action="{{ $editingCourse ? route('hr.offline-courses.update', $editingCourse) : route('hr.offline-courses.store') }}" method="POST" enctype="multipart/form-data" class="mt-7 space-y-6">
                @csrf
                @if ($editingCourse) @method('PUT') @endif

                <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                    <div class="space-y-6">
                        <section class="section-card">
                            <div class="mb-5">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Core Identity</p>
                                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Headline and positioning</h3>
                            </div>
                            <div class="grid gap-4 lg:grid-cols-2">
                                <div class="lg:col-span-2">
                                    <label class="label" for="title">Course Title</label>
                                    <input id="title" name="title" type="text" class="field" value="{{ old('title', $editingCourse->title ?? '') }}" required />
                                </div>
                                <div>
                                    <label class="label" for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="field">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected((string) old('category_id', $editingCourse->category_id ?? '') === (string) $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="label" for="audience">Audience</label>
                                    <input id="audience" name="audience" type="text" class="field" value="{{ old('audience', $editingCourse->audience ?? '') }}" placeholder="Freshers, working professionals, freelancers" />
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="label" for="summary">Course Overview</label>
                                    <textarea id="summary" name="summary" rows="5" class="field">{{ old('summary', $editingCourse->summary ?? '') }}</textarea>
                                    <p class="helper">Use this for the brochure overview paragraph.</p>
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="label" for="details">Extended Description</label>
                                    <textarea id="details" name="details" rows="5" class="field">{{ old('details', $editingCourse->details ?? '') }}</textarea>
                                    <p class="helper">Optional longer description for internal use or future public course detail pages.</p>
                                </div>
                            </div>
                        </section>

                        <section class="section-card">
                            <div class="mb-5">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Course Meta</p>
                                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Duration, mode, and learning format</h3>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                                <div>
                                    <label class="label" for="duration_label">Duration</label>
                                    <input id="duration_label" name="duration_label" type="text" class="field" value="{{ old('duration_label', $editingCourse->duration_label ?? '') }}" placeholder="6 Months" />
                                </div>
                                <div>
                                    <label class="label" for="validity_label">Validity</label>
                                    <input id="validity_label" name="validity_label" type="text" class="field" value="{{ old('validity_label', $editingCourse->validity_label ?? '') }}" placeholder="1 Year" />
                                </div>
                                <div>
                                    <label class="label" for="delivery_mode">Mode</label>
                                    <input id="delivery_mode" name="delivery_mode" type="text" class="field" value="{{ old('delivery_mode', $editingCourse->delivery_mode ?? '') }}" placeholder="Online & Offline" />
                                </div>
                                <div>
                                    <label class="label" for="placement_label">Placement Assurance</label>
                                    <input id="placement_label" name="placement_label" type="text" class="field" value="{{ old('placement_label', $editingCourse->placement_label ?? '') }}" placeholder="100% Job Placement Guarantee Assurance" />
                                </div>
                                <div>
                                    <label class="label" for="campus">Campus</label>
                                    <input id="campus" name="campus" type="text" class="field" value="{{ old('campus', $editingCourse->campus ?? '') }}" />
                                </div>
                                <div>
                                    <label class="label" for="schedule_label">Schedule</label>
                                    <input id="schedule_label" name="schedule_label" type="text" class="field" value="{{ old('schedule_label', $editingCourse->schedule_label ?? '') }}" />
                                </div>
                                <div>
                                    <label class="label" for="batch_size">Batch Size</label>
                                    <input id="batch_size" name="batch_size" type="text" class="field" value="{{ old('batch_size', $editingCourse->batch_size ?? '') }}" />
                                </div>
                                <div>
                                    <label class="label" for="language">Language</label>
                                    <input id="language" name="language" type="text" class="field" value="{{ old('language', $editingCourse->language ?? '') }}" />
                                </div>
                                <div>
                                    <label class="label" for="level">Level</label>
                                    <input id="level" name="level" type="text" class="field" value="{{ old('level', $editingCourse->level ?? '') }}" placeholder="Beginner to Advanced" />
                                </div>
                            </div>
                        </section>

                        <section class="section-card">
                            <div class="mb-5 flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Curriculum</p>
                                    <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Module-wise structure from the brochure</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-500">Add each section with duration, bullet topics, and the module project.</p>
                                </div>
                                <button type="button" id="addCurriculumModule" class="rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-[0_12px_26px_rgba(2,132,199,0.22)]">Add Module</button>
                            </div>

                            <div id="curriculumModules" class="space-y-4">
                                @foreach ($editingCurriculum as $index => $module)
                                    <div class="curriculum-card" data-module-card>
                                        <div class="mb-4 flex items-center justify-between gap-3">
                                            <p class="text-sm font-bold uppercase tracking-[0.18em] text-sky-700">Module <span data-module-number>{{ $index + 1 }}</span></p>
                                            <button type="button" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-bold uppercase tracking-[0.12em] text-rose-600" data-remove-module>Remove</button>
                                        </div>
                                        <div class="grid gap-4 lg:grid-cols-2">
                                            <div>
                                                <label class="label">Module Title</label>
                                                <input type="text" class="field" name="curriculum_modules[{{ $index }}][title]" value="{{ $module['title'] }}" placeholder="Excel & Google Sheets" />
                                            </div>
                                            <div>
                                                <label class="label">Module Duration</label>
                                                <input type="text" class="field" name="curriculum_modules[{{ $index }}][duration]" value="{{ $module['duration'] }}" placeholder="1 Month" />
                                            </div>
                                            <div class="lg:col-span-2">
                                                <label class="label">Topics</label>
                                                <textarea class="field" rows="6" name="curriculum_modules[{{ $index }}][topics]" placeholder="One topic per line">{{ $module['topics'] }}</textarea>
                                            </div>
                                            <div class="lg:col-span-2">
                                                <label class="label">Module Project</label>
                                                <input type="text" class="field" name="curriculum_modules[{{ $index }}][project]" value="{{ $module['project'] }}" placeholder="Executive Sales Dashboard" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="section-card">
                            <div class="mb-5">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Benefits</p>
                                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Highlights, benefits, and learner note</h3>
                            </div>
                            <div class="grid gap-4">
                                <div>
                                    <label class="label" for="highlights">Primary Highlights</label>
                                    <textarea id="highlights" name="highlights" rows="4" class="field" placeholder="One per line">{{ old('highlights', collect($editingCourse->highlights ?? [])->implode(PHP_EOL)) }}</textarea>
                                    <p class="helper">Use this for quick-scan values like real projects, BI tools, interview prep, and placement support.</p>
                                </div>
                                <div>
                                    <label class="label" for="additional_benefits">Additional Benefits</label>
                                    <textarea id="additional_benefits" name="additional_benefits" rows="6" class="field" placeholder="One benefit per line">{{ old('additional_benefits', collect($editingCourse->additional_benefits ?? [])->implode(PHP_EOL)) }}</textarea>
                                </div>
                                <div>
                                    <label class="label" for="learner_note">Note For Learners</label>
                                    <textarea id="learner_note" name="learner_note" rows="5" class="field">{{ old('learner_note', $editingCourse->learner_note ?? '') }}</textarea>
                                </div>
                            </div>
                        </section>
                    </div>

                    <aside class="space-y-6">
                        <section class="section-card">
                            <div class="mb-5">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Course Media</p>
                                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Thumbnail and publishing</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="label" for="thumbnail_provider">Thumbnail Source</label>
                                    <select id="thumbnail_provider" name="thumbnail_provider" class="field">
                                        <option value="url" @selected(old('thumbnail_provider', 'local') === 'url')>Use image URL</option>
                                        <option value="local" @selected(old('thumbnail_provider', 'local') === 'local')>Upload to local server</option>
                                        <option value="cloud" @selected(old('thumbnail_provider', 'local') === 'cloud')>Upload to cloud</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="label" for="thumbnail_file">Upload Thumbnail</label>
                                    <input id="thumbnail_file" name="thumbnail_file" type="file" class="field" />
                                </div>
                                <div>
                                    <label class="label" for="thumbnail">Thumbnail URL</label>
                                    <input id="thumbnail" name="thumbnail" type="text" class="field" value="{{ old('thumbnail', $editingCourse->thumbnail ?? '') }}" />
                                </div>
                                @if (old('thumbnail', $editingCourse->thumbnail ?? ''))
                                    <div class="overflow-hidden rounded-[1.25rem] border border-slate-200 bg-slate-50">
                                        <img src="{{ old('thumbnail', $editingCourse->thumbnail ?? '') }}" alt="Thumbnail preview" class="h-48 w-full object-cover" />
                                    </div>
                                @endif
                            </div>
                        </section>

                        <section class="section-card">
                            <div class="mb-5">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Publishing</p>
                                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Visibility and order</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="label" for="sort_order">Sort Order</label>
                                    <input id="sort_order" name="sort_order" type="number" class="field" value="{{ old('sort_order', $editingCourse->sort_order ?? 0) }}" />
                                </div>
                                <label class="flex items-start gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700">
                                    <input class="mt-1" name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingCourse->is_active ?? true)) />
                                    <span>
                                        <span class="block">Show this offline course on the public course page</span>
                                        <span class="mt-1 block text-xs font-medium text-slate-500">Turn this off if the batch is paused or not ready for marketing yet.</span>
                                    </span>
                                </label>
                            </div>
                        </section>

                        <section class="section-card">
                            <div class="mb-4">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">PDF Match Guide</p>
                                <h3 class="mt-2 font-headline text-xl font-extrabold text-slate-900">How the new form maps to your brochure</h3>
                            </div>
                            <div class="space-y-3 text-sm leading-6 text-slate-600">
                                <p><strong>Course Overview</strong> matches the intro paragraph from the PDF.</p>
                                <p><strong>Duration, Validity, Mode, Placement</strong> match the top metadata line.</p>
                                <p><strong>Curriculum Modules</strong> match each numbered section with topics and project.</p>
                                <p><strong>Additional Benefits</strong> match the checklist section at the end.</p>
                                <p><strong>Note For Learners</strong> matches the final closing note.</p>
                            </div>
                        </section>
                    </aside>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="rounded-xl bg-[linear-gradient(135deg,#0369a1_0%,#0f766e_100%)] px-6 py-3.5 text-sm font-semibold text-white shadow-[0_16px_34px_rgba(8,145,178,0.24)]">
                        {{ $editingCourse ? 'Update Offline Course' : 'Create Offline Course' }}
                    </button>
                    @if ($editingCourse)
                        <a href="{{ route('hr.offline-courses') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700">Cancel</a>
                    @endif
                </div>
            </form>
        </section>

        <section class="panel p-6 md:p-7" id="offline-courses-table">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Current Catalog</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Offline course cards</h2>
                </div>
                <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $courseCount }} items</div>
            </div>

            @if ($offlineCourses->isNotEmpty())
                <div class="mt-6 overflow-x-auto rounded-[1.4rem] border border-slate-200">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Title</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Mode</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Duration</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Status</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offlineCourses as $course)
                                <tr class="border-t border-slate-200 bg-white align-top">
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-slate-900">{{ $course->title }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $course->category?->name ?: 'Uncategorized' }}</p>
                                        <p class="mt-2 text-xs text-slate-400">{{ $course->audience ?: ($course->campus ?: 'Audience or campus not added') }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-600">{{ $course->delivery_mode ?: 'Not added' }}</td>
                                    <td class="px-4 py-4 text-sm text-slate-600">{{ $course->duration_label ?: 'Not added' }}</td>
                                    <td class="px-4 py-4">
                                        <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.16em] {{ $course->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $course->is_active ? 'Active' : 'Hidden' }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('hr.offline-courses', ['edit' => $course->id]) }}#offline-courses-table" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Edit</a>
                                            <form action="{{ route('hr.offline-courses.destroy', $course) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (method_exists($offlineCourses, 'links'))
                    <div class="mt-6">{{ $offlineCourses->links() }}</div>
                @endif
            @else
                <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No offline courses added yet.</div>
            @endif
        </section>
    </div>
</main>

<template id="curriculumModuleTemplate">
    <div class="curriculum-card" data-module-card>
        <div class="mb-4 flex items-center justify-between gap-3">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-sky-700">Module <span data-module-number></span></p>
            <button type="button" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-bold uppercase tracking-[0.12em] text-rose-600" data-remove-module>Remove</button>
        </div>
        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="label">Module Title</label>
                <input type="text" class="field" data-name="title" placeholder="Excel & Google Sheets" />
            </div>
            <div>
                <label class="label">Module Duration</label>
                <input type="text" class="field" data-name="duration" placeholder="1 Month" />
            </div>
            <div class="lg:col-span-2">
                <label class="label">Topics</label>
                <textarea class="field" rows="6" data-name="topics" placeholder="One topic per line"></textarea>
            </div>
            <div class="lg:col-span-2">
                <label class="label">Module Project</label>
                <input type="text" class="field" data-name="project" placeholder="Executive Sales Dashboard" />
            </div>
        </div>
    </div>
</template>

<script>
    (function () {
        var container = document.getElementById('curriculumModules');
        var template = document.getElementById('curriculumModuleTemplate');
        var addButton = document.getElementById('addCurriculumModule');
        if (!container || !template || !addButton) return;

        function syncModules() {
            var cards = container.querySelectorAll('[data-module-card]');
            cards.forEach(function (card, index) {
                var number = card.querySelector('[data-module-number]');
                if (number) number.textContent = String(index + 1);

                card.querySelectorAll('[data-name]').forEach(function (field) {
                    field.name = 'curriculum_modules[' + index + '][' + field.getAttribute('data-name') + ']';
                });

                card.querySelectorAll('input[name^="curriculum_modules["], textarea[name^="curriculum_modules["]').forEach(function (field) {
                    if (!field.hasAttribute('data-name')) {
                        var match = field.name.match(/\]\[(.+)\]$/);
                        if (match) {
                            field.name = 'curriculum_modules[' + index + '][' + match[1] + ']';
                        }
                    }
                });
            });
        }

        addButton.addEventListener('click', function () {
            var fragment = template.content.cloneNode(true);
            container.appendChild(fragment);
            syncModules();
        });

        container.addEventListener('click', function (event) {
            var button = event.target.closest('[data-remove-module]');
            if (!button) return;

            var cards = container.querySelectorAll('[data-module-card]');
            if (cards.length === 1) {
                cards[0].querySelectorAll('input, textarea').forEach(function (field) {
                    field.value = '';
                });
                return;
            }

            button.closest('[data-module-card]').remove();
            syncModules();
        });

        syncModules();
    })();
</script>
</body>
</html>
