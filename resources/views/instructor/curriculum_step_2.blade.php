<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Curriculum Builder - CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/tus-js-client@latest/dist/tus.min.js"></script>
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
                        "primary": "#6a3378",
                        "surface-container-high": "#efe5f4",
                        "surface-container-low": "#f5eef8",
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; background-color: #fcf9fe; color: #191c1d; }
        .editorial-shadow { box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05); }
    </style>
</head>
<body class="bg-surface text-on-background antialiased">
    @php
        $courseQuery = request()->query('course');
        $curriculumCourse = $course ?? null;
        $baseSections = old('sections');
        $contentStatus = old('content_status', $curriculumCourse?->content_status ?? 'pending');

        if (! is_array($baseSections)) {
            $baseSections = $curriculumCourse?->sections?->map(function ($section) {
                return [
                    'id' => $section->id,
                    'title' => $section->title,
                    'lessons' => $section->videos->map(function ($video) {
                        return [
                            'id' => $video->id,
                            'title' => $video->title,
                            'existing_video_url' => $video->video_url,
                            'existing_video_duration' => (int) ($video->duration ?? 0),
                            'is_preview' => (bool) $video->is_preview,
                            'materials' => $video->materials->map(function ($material) {
                                return [
                                    'id' => $material->id,
                                    'title' => $material->title,
                                    'file_url' => $material->file_url,
                                    'type' => $material->type,
                                    'is_downloadable' => (bool) $material->is_downloadable,
                                ];
                            })->values()->all(),
                        ];
                    })->values()->all(),
                ];
            })->values()->all();
        }

        if (empty($baseSections)) {
            $baseSections = [[
                'id' => null,
                'title' => '',
                'lessons' => [[
                    'id' => null,
                    'title' => '',
                    'existing_video_url' => '',
                    'existing_video_duration' => 0,
                    'is_preview' => false,
                    'materials' => [],
                ]],
            ]];
        }

        $totalLessons = collect($baseSections)->sum(fn ($section) => count($section['lessons'] ?? []));
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

            <section class="rounded-[28px] bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-800 text-white overflow-hidden editorial-shadow">
                <div class="grid gap-8 lg:grid-cols-[1.35fr_0.95fr] p-6 md:p-10">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#eadff1]">Step 2 of 4</div>
                        <div class="space-y-3">
                            <h1 class="font-headline text-4xl md:text-5xl font-bold leading-tight">Build a curriculum that feels deliberate and easy to follow.</h1>
                            <p class="max-w-2xl text-sm md:text-base text-[#eadff1]/90 leading-relaxed">Add structured sections, attach lesson videos when available, and mark preview content that students can sample before enrolling.</p>
                        </div>
                    </div>
                    <div class="rounded-[24px] border border-white/15 bg-white/10 p-5 md:p-6 backdrop-blur-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#eadff1]/80">Draft Summary</p>
                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ count($baseSections) }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-[#eadff1]/80">Sections</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-2xl font-bold">{{ $totalLessons }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-[#eadff1]/80">Lessons</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <form id="curriculumForm" method="POST" action="{{ route('instructor.create-course.curriculum.store', ['course' => $courseQuery], false) }}" data-video-signature-url="{{ route('instructor.create-course.curriculum.video-signature', ['course' => $courseQuery], false) }}" data-material-signature-url="{{ route('instructor.create-course.curriculum.material-signature', ['course' => $courseQuery], false) }}" class="grid grid-cols-12 gap-8 items-start">
                @csrf
                <input type="hidden" name="course_id" value="{{ $curriculumCourse?->id }}" />

                <div class="col-span-12 xl:col-span-8 space-y-6">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <div class="flex items-start justify-between gap-6 mb-6">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary mb-2">Curriculum Editor</p>
                                <h2 class="font-headline text-2xl font-bold text-slate-900">Arrange the learning journey section by section</h2>
                            </div>
                            <button id="addSectionButton" class="hidden md:inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-primary hover:bg-slate-200 transition-colors" type="button">
                                <span class="material-symbols-outlined text-base">playlist_add</span>
                                Add Section
                            </button>
                        </div>

                        @error('sections')
                            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $message }}</div>
                        @enderror

                        <div class="mb-6 rounded-[24px] border border-slate-200 bg-slate-50/80 p-5">
                            <div class="grid gap-4 md:grid-cols-[1fr_220px] md:items-end">
                                <div>
                                    <label class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Student Release Status</label>
                                    <p class="mt-2 text-sm text-slate-600">Choose whether students should see this course as finished or still receiving more sections and videos. Lessons can now be saved even if a video is not uploaded yet.</p>
                                </div>
                                <select class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="content_status">
                                    <option value="pending" @selected($contentStatus === 'pending')>Pending More Content</option>
                                    <option value="completed" @selected($contentStatus === 'completed')>Course Completed</option>
                                </select>
                            </div>
                        </div>

                        <div id="sectionsContainer" class="space-y-5">
                            @foreach($baseSections as $sectionIndex => $section)
                                <div class="section-card overflow-hidden rounded-[24px] border border-[#eadff1] bg-gradient-to-br from-[#f5eef8]/80 via-white to-slate-50" data-section-index="{{ $sectionIndex }}">
                                    <input type="hidden" name="sections[{{ $sectionIndex }}][id]" value="{{ $section['id'] ?? '' }}" />
                                    <div class="flex items-center justify-between gap-4 border-b border-[#eadff1] bg-[#f5eef8]/70 px-5 py-5">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <span class="material-symbols-outlined text-[#76c6ff] cursor-grab">drag_indicator</span>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-3">
                                                    <span class="inline-flex items-center rounded-full bg-[#6a3378] px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-white">Course Section {{ $sectionIndex + 1 }}</span>
                                                    <label class="text-xs font-semibold uppercase tracking-[0.18em] text-[#6a3378]/80">Section Title</label>
                                                </div>
                                                <input class="mt-3 w-full rounded-xl border {{ $errors->has('sections.'.$sectionIndex.'.title') ? 'border-red-300' : 'border-[#eadff1]' }} bg-white px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="sections[{{ $sectionIndex }}][title]" placeholder="e.g. Introduction to Web Fundamentals" type="text" value="{{ $section['title'] ?? '' }}" />
                                                @error('sections.'.$sectionIndex.'.title')
                                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button class="section-toggle p-2 rounded-full hover:bg-white/80 transition-colors" type="button" aria-expanded="{{ $sectionIndex === 0 ? 'true' : 'false' }}">
                                                <span class="material-symbols-outlined text-[#6a3378] section-toggle-icon">{{ $sectionIndex === 0 ? 'expand_less' : 'expand_more' }}</span>
                                            </button>
                                            <button class="remove-section p-2 rounded-full hover:bg-red-50 hover:text-red-600 transition-colors" type="button">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="section-body {{ $sectionIndex === 0 ? '' : 'hidden' }}">
                                    <div class="p-5 space-y-4 lessons-container">
                                        @foreach(($section['lessons'] ?? []) as $lessonIndex => $lesson)
                                            <div class="lesson-card rounded-2xl border border-slate-200 bg-white px-4 py-4" data-lesson-index="{{ $lessonIndex }}">
                                                <input type="hidden" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][id]" value="{{ $lesson['id'] ?? '' }}" />
                                                <div class="flex flex-col gap-4">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div class="flex-1 space-y-2">
                                                            <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Lesson Title</label>
                                                            <input class="w-full rounded-xl border {{ $errors->has('sections.'.$sectionIndex.'.lessons.'.$lessonIndex.'.title') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][title]" placeholder="e.g. HTML Foundations" type="text" value="{{ $lesson['title'] ?? '' }}" />
                                                            @error('sections.'.$sectionIndex.'.lessons.'.$lessonIndex.'.title')
                                                                <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <button class="remove-lesson p-2 rounded-full hover:bg-red-50 hover:text-red-600 transition-colors" type="button">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </button>
                                                    </div>

                                                    <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                                                        <div class="space-y-2">
                                                            <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Video Upload</label>
                                                            <div class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 video-upload-panel">
                                                                <input class="video-file-input block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-[#f5eef8] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#6a3378] hover:file:bg-[#eadff1]" type="file" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-matroska,video/webm" />
                                                                <input class="existing-video-url" type="hidden" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][existing_video_url]" value="{{ $lesson['existing_video_url'] ?? '' }}" />
                                                                <input class="existing-video-duration" type="hidden" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][existing_video_duration]" value="{{ (int) ($lesson['existing_video_duration'] ?? 0) }}" />

                                                                <div class="rounded-2xl bg-white px-4 py-3 text-sm text-slate-600 video-upload-status">
                                                                    @if(!empty($lesson['existing_video_url']))
                                                                        Video already uploaded and ready.
                                                                    @else
                                                                        Video upload is optional. Add one now or continue building the curriculum first.
                                                                    @endif
                                                                </div>

                                                                <div class="video-progress-wrapper {{ !empty($lesson['existing_video_url']) ? '' : 'hidden' }}">
                                                                    <div class="h-2 overflow-hidden rounded-full bg-slate-200">
                                                                        <div class="video-progress-bar h-full rounded-full bg-gradient-to-r from-indigo-600 to-sky-500 transition-all duration-300" style="width: {{ !empty($lesson['existing_video_url']) ? '100%' : '0%' }}"></div>
                                                                    </div>
                                                                    <div class="mt-2 flex items-center justify-between gap-3 text-xs font-semibold text-slate-500">
                                                                        <span class="video-progress-label">{{ !empty($lesson['existing_video_url']) ? 'Upload complete' : 'Waiting to upload' }}</span>
                                                                        <span class="video-progress-speed">{{ !empty($lesson['existing_video_url']) ? 'Done' : '0 KB/s' }}</span>
                                                                        <span class="video-progress-percent">{{ !empty($lesson['existing_video_url']) ? '100%' : '0%' }}</span>
                                                                    </div>
                                                                </div>

                                                                <a class="uploaded-video-link {{ !empty($lesson['existing_video_url']) ? 'inline-flex' : 'hidden' }} items-center gap-2 text-xs font-semibold text-[#6a3378] hover:underline" href="{{ $lesson['existing_video_url'] ?? '#' }}" target="_blank">
                                                                    <span class="material-symbols-outlined text-sm">play_circle</span>
                                                                    View uploaded video
                                                                </a>

                                                                <p class="video-upload-error hidden text-xs font-medium text-red-600"></p>
                                                            </div>
                                                            @error('sections.'.$sectionIndex.'.lessons.'.$lessonIndex.'.existing_video_url')
                                                                <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <label class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                                                            <input class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][is_preview]" type="checkbox" value="1" @checked(!empty($lesson['is_preview'])) />
                                                            Preview lesson
                                                        </label>
                                                    </div>

                                                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 space-y-4 materials-panel">
                                                        <div class="flex items-center justify-between gap-4">
                                                            <div>
                                                                <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Lesson Resources</label>
                                                                <p class="mt-1 text-sm text-slate-600">Upload PDFs, code ZIPs, or DOCX notes that students can access under this lesson.</p>
                                                            </div>
                                                            <button class="add-material inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-primary border border-slate-200 hover:bg-slate-100 transition-colors" type="button">
                                                                <span class="material-symbols-outlined text-base">attach_file_add</span>
                                                                Add Resource
                                                            </button>
                                                        </div>

                                                        <div class="materials-container space-y-3">
                                                            @foreach(($lesson['materials'] ?? []) as $materialIndex => $material)
                                                                <div class="material-card rounded-2xl border border-slate-200 bg-white p-4 space-y-3" data-material-index="{{ $materialIndex }}">
                                                                    <input type="hidden" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][materials][{{ $materialIndex }}][id]" value="{{ $material['id'] ?? '' }}" />
                                                                    <div class="grid gap-3 md:grid-cols-[1.1fr_0.75fr_auto]">
                                                                        <input class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][materials][{{ $materialIndex }}][title]" placeholder="e.g. SQL Cheatsheet" type="text" value="{{ $material['title'] ?? '' }}" />
                                                                        <select class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1] material-type-select" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][materials][{{ $materialIndex }}][type]">
                                                                            <option value="">Select type</option>
                                                                            <option value="pdf" @selected(($material['type'] ?? '') === 'pdf')>PDF</option>
                                                                            <option value="zip" @selected(($material['type'] ?? '') === 'zip')>ZIP</option>
                                                                            <option value="docx" @selected(($material['type'] ?? '') === 'docx')>DOCX</option>
                                                                        </select>
                                                                        <button class="remove-material inline-flex items-center justify-center rounded-full p-2 text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors" type="button">
                                                                            <span class="material-symbols-outlined">delete</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 material-upload-panel">
                                                                        <input class="material-file-input block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-[#f5eef8] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#6a3378] hover:file:bg-[#eadff1]" type="file" accept=".pdf,.zip,.docx,application/pdf,application/zip,application/x-zip-compressed,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                                                        <input class="existing-material-url" type="hidden" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][materials][{{ $materialIndex }}][file_url]" value="{{ $material['file_url'] ?? '' }}" />
                                                                        <div class="rounded-2xl bg-white px-4 py-3 text-sm text-slate-600 material-upload-status">
                                                                            @if(!empty($material['file_url']))
                                                                                Resource already uploaded and ready.
                                                                            @else
                                                                                Select a PDF, ZIP, or DOCX file to upload it for students.
                                                                            @endif
                                                                        </div>
                                                                        <div class="material-progress-wrapper {{ !empty($material['file_url']) ? '' : 'hidden' }}">
                                                                            <div class="h-2 overflow-hidden rounded-full bg-slate-200">
                                                                                <div class="material-progress-bar h-full rounded-full bg-gradient-to-r from-emerald-600 to-sky-500 transition-all duration-300" style="width: {{ !empty($material['file_url']) ? '100%' : '0%' }}"></div>
                                                                            </div>
                                                            <div class="mt-2 flex items-center justify-between gap-3 text-xs font-semibold text-slate-500">
                                                                <span class="material-progress-label">{{ !empty($material['file_url']) ? 'Upload complete' : 'Waiting to upload' }}</span>
                                                                <span class="material-progress-speed">{{ !empty($material['file_url']) ? 'Done' : '0 KB/s' }}</span>
                                                                <span class="material-progress-percent">{{ !empty($material['file_url']) ? '100%' : '0%' }}</span>
                                                            </div>
                                                                        </div>
                                                                        <a class="uploaded-material-link {{ !empty($material['file_url']) ? 'inline-flex' : 'hidden' }} items-center gap-2 text-xs font-semibold text-[#6a3378] hover:underline" href="{{ $material['file_url'] ?? '#' }}" target="_blank">
                                                                            <span class="material-symbols-outlined text-sm">description</span>
                                                                            View uploaded resource
                                                                        </a>
                                                                        <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                                                                            <input class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" name="sections[{{ $sectionIndex }}][lessons][{{ $lessonIndex }}][materials][{{ $materialIndex }}][is_downloadable]" type="checkbox" value="1" @checked(!empty($material['is_downloadable'])) />
                                                                            Allow student download
                                                                        </label>
                                                                        <p class="material-upload-error hidden text-xs font-medium text-red-600"></p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="px-5 pb-5">
                                        <button class="add-lesson w-full rounded-2xl border-2 border-dashed border-slate-300 px-4 py-4 text-sm font-semibold text-slate-600 hover:border-[#c79ad4] hover:text-primary transition-all" type="button">
                                            <span class="material-symbols-outlined mr-2 text-base">add_circle</span>
                                            Add New Lesson
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button id="addSectionButtonMobile" class="mt-5 w-full rounded-[24px] border border-[#c7e0ff] bg-[#f5eef8]/70 px-6 py-5 text-center hover:bg-[#f5eef8] transition-colors" type="button">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-indigo-200">
                                <span class="material-symbols-outlined">add</span>
                            </div>
                            <p class="mt-4 text-sm font-bold text-primary">Create New Section</p>
                        </button>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 space-y-6">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-headline text-xl font-bold text-slate-900">Curriculum Health</h3>
                            <span class="rounded-full bg-[#f5eef8] px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-[#6a3378]">{{ count($baseSections) > 0 ? 'Healthy' : 'Empty' }}</span>
                        </div>
                        <div class="space-y-5">
                            <div>
                                <div class="mb-2 flex items-center justify-between text-xs font-semibold text-slate-600">
                                    <span>Content Depth</span>
                                    <span class="text-primary">{{ min(100, max(15, count($baseSections) * 25 + $totalLessons * 8)) }}%</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full rounded-full bg-primary" style="width: {{ min(100, max(15, count($baseSections) * 25 + $totalLessons * 8)) }}%"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-2xl font-bold text-slate-900">{{ $totalLessons }}</p><p class="mt-1 text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-slate-500">Lessons</p></div>
                                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4"><p class="text-2xl font-bold text-slate-900">{{ count($baseSections) }}</p><p class="mt-1 text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-slate-500">Sections</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-gradient-to-br from-emerald-700 to-emerald-600 p-6 text-white shadow-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-100 mb-2">Upload Note</p>
                        <h3 class="font-headline text-xl font-bold">Lesson videos use Cloudflare Stream when you upload them.</h3>
                        <p class="mt-3 text-sm leading-relaxed text-emerald-50/90">You can now continue without uploading a lesson video. When you do upload one, it still uses resumable Cloudflare Stream while resources stay on Cloudflare R2.</p>
                        <div id="uploadQueueNotice" class="mt-4 hidden rounded-2xl bg-white/10 px-4 py-3 text-sm font-medium text-emerald-50"></div>
                    </div>

                    <div class="rounded-[28px] bg-white p-6 md:p-8 editorial-shadow space-y-4">
                        <div class="pt-2 border-t border-slate-100 space-y-3">
                            <button id="saveCurriculumButton" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-5 py-4 text-sm font-bold text-white editorial-shadow hover:opacity-90 active:scale-[0.99] transition-all disabled:cursor-not-allowed disabled:opacity-70" type="submit">
                                <span id="saveCurriculumLabel">Save Curriculum & Continue</span>
                                <span class="material-symbols-outlined text-[1.1rem]">arrow_forward</span>
                            </button>
                            <a class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-5 py-4 text-sm font-bold text-primary hover:bg-slate-200 transition-colors" href="{{ route('instructor.create-course', ['course' => $courseQuery]) }}">
                                <span class="material-symbols-outlined text-[1.1rem]">arrow_back</span>
                                <span>Previous: Course Info</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <template id="sectionTemplate">
        <div class="section-card overflow-hidden rounded-[24px] border border-[#eadff1] bg-gradient-to-br from-[#f5eef8]/80 via-white to-slate-50" data-section-index="__SECTION_INDEX__">
            <input type="hidden" name="sections[__SECTION_INDEX__][id]" value="" />
            <div class="flex items-center justify-between gap-4 border-b border-[#eadff1] bg-[#f5eef8]/70 px-5 py-5">
                <div class="flex items-center gap-4 min-w-0">
                    <span class="material-symbols-outlined text-[#76c6ff] cursor-grab">drag_indicator</span>
                    <div class="min-w-0">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center rounded-full bg-[#6a3378] px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-white">Course Section __SECTION_NUMBER__</span>
                            <label class="text-xs font-semibold uppercase tracking-[0.18em] text-[#6a3378]/80">Section Title</label>
                        </div>
                        <input class="mt-3 w-full rounded-xl border border-[#eadff1] bg-white px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="sections[__SECTION_INDEX__][title]" placeholder="e.g. Introduction to Web Fundamentals" type="text" />
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="section-toggle p-2 rounded-full hover:bg-white/80 transition-colors" type="button" aria-expanded="true"><span class="material-symbols-outlined text-[#6a3378] section-toggle-icon">expand_less</span></button>
                    <button class="remove-section p-2 rounded-full hover:bg-red-50 hover:text-red-600 transition-colors" type="button"><span class="material-symbols-outlined">delete</span></button>
                </div>
            </div>
            <div class="section-body">
            <div class="p-5 space-y-4 lessons-container"></div>
            <div class="px-5 pb-5">
                <button class="add-lesson w-full rounded-2xl border-2 border-dashed border-slate-300 px-4 py-4 text-sm font-semibold text-slate-600 hover:border-[#c79ad4] hover:text-primary transition-all" type="button"><span class="material-symbols-outlined mr-2 text-base">add_circle</span>Add New Lesson</button>
            </div>
            </div>
        </div>
    </template>

    <template id="lessonTemplate">
        <div class="lesson-card rounded-2xl border border-slate-200 bg-white px-4 py-4" data-lesson-index="__LESSON_INDEX__">
            <input type="hidden" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][id]" value="" />
            <div class="flex flex-col gap-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Lesson Title</label>
                        <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][title]" placeholder="e.g. HTML Foundations" type="text" />
                    </div>
                    <button class="remove-lesson p-2 rounded-full hover:bg-red-50 hover:text-red-600 transition-colors" type="button"><span class="material-symbols-outlined">delete</span></button>
                </div>
                <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Video Upload</label>
                        <div class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 video-upload-panel">
                            <input class="video-file-input block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-[#f5eef8] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#6a3378] hover:file:bg-[#eadff1]" type="file" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-matroska,video/webm" />
                            <input class="existing-video-url" type="hidden" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][existing_video_url]" value="" />
                            <input class="existing-video-duration" type="hidden" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][existing_video_duration]" value="0" />
                            <div class="rounded-2xl bg-white px-4 py-3 text-sm text-slate-600 video-upload-status">Video upload is optional. Add a lesson video now or continue building first.</div>
                            <div class="video-progress-wrapper hidden">
                                <div class="h-2 overflow-hidden rounded-full bg-slate-200">
                                    <div class="video-progress-bar h-full rounded-full bg-gradient-to-r from-indigo-600 to-sky-500 transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <div class="mt-2 flex items-center justify-between gap-3 text-xs font-semibold text-slate-500">
                                    <span class="video-progress-label">Waiting to upload</span>
                                    <span class="video-progress-speed">0 KB/s</span>
                                    <span class="video-progress-percent">0%</span>
                                </div>
                            </div>
                            <a class="uploaded-video-link hidden items-center gap-2 text-xs font-semibold text-[#6a3378] hover:underline" href="#" target="_blank">
                                <span class="material-symbols-outlined text-sm">play_circle</span>
                                View uploaded video
                            </a>
                            <p class="video-upload-error hidden text-xs font-medium text-red-600"></p>
                        </div>
                    </div>
                    <label class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                        <input class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][is_preview]" type="checkbox" value="1" />
                        Preview lesson
                    </label>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 space-y-4 materials-panel">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Lesson Resources</label>
                            <p class="mt-1 text-sm text-slate-600">Upload PDFs, code ZIPs, or DOCX notes for this lesson.</p>
                        </div>
                        <button class="add-material inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-primary border border-slate-200 hover:bg-slate-100 transition-colors" type="button">
                            <span class="material-symbols-outlined text-base">attach_file_add</span>
                            Add Resource
                        </button>
                    </div>
                    <div class="materials-container space-y-3"></div>
                </div>
            </div>
        </div>
    </template>

    <template id="materialTemplate">
        <div class="material-card rounded-2xl border border-slate-200 bg-white p-4 space-y-3" data-material-index="__MATERIAL_INDEX__">
            <input type="hidden" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][materials][__MATERIAL_INDEX__][id]" value="" />
            <div class="grid gap-3 md:grid-cols-[1.1fr_0.75fr_auto]">
                <input class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][materials][__MATERIAL_INDEX__][title]" placeholder="e.g. SQL Cheatsheet" type="text" />
                <select class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1] material-type-select" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][materials][__MATERIAL_INDEX__][type]">
                    <option value="">Select type</option>
                    <option value="pdf">PDF</option>
                    <option value="zip">ZIP</option>
                    <option value="docx">DOCX</option>
                </select>
                <button class="remove-material inline-flex items-center justify-center rounded-full p-2 text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors" type="button">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </div>
            <div class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 material-upload-panel">
                <input class="material-file-input block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-[#f5eef8] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#6a3378] hover:file:bg-[#eadff1]" type="file" accept=".pdf,.zip,.docx,application/pdf,application/zip,application/x-zip-compressed,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                <input class="existing-material-url" type="hidden" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][materials][__MATERIAL_INDEX__][file_url]" value="" />
                <div class="rounded-2xl bg-white px-4 py-3 text-sm text-slate-600 material-upload-status">Select a PDF, ZIP, or DOCX file to upload it for students.</div>
                <div class="material-progress-wrapper hidden">
                    <div class="h-2 overflow-hidden rounded-full bg-slate-200">
                        <div class="material-progress-bar h-full rounded-full bg-gradient-to-r from-emerald-600 to-sky-500 transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <div class="mt-2 flex items-center justify-between gap-3 text-xs font-semibold text-slate-500">
                        <span class="material-progress-label">Waiting to upload</span>
                        <span class="material-progress-speed">0 KB/s</span>
                        <span class="material-progress-percent">0%</span>
                    </div>
                </div>
                <a class="uploaded-material-link hidden items-center gap-2 text-xs font-semibold text-[#6a3378] hover:underline" href="#" target="_blank">
                    <span class="material-symbols-outlined text-sm">description</span>
                    View uploaded resource
                </a>
                <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                    <input class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" name="sections[__SECTION_INDEX__][lessons][__LESSON_INDEX__][materials][__MATERIAL_INDEX__][is_downloadable]" type="checkbox" value="1" />
                    Allow student download
                </label>
                <p class="material-upload-error hidden text-xs font-medium text-red-600"></p>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var curriculumForm = document.getElementById('curriculumForm');
            var sectionsContainer = document.getElementById('sectionsContainer');
            var sectionTemplate = document.getElementById('sectionTemplate');
            var lessonTemplate = document.getElementById('lessonTemplate');
            var materialTemplate = document.getElementById('materialTemplate');
            var addSectionButtons = [document.getElementById('addSectionButton'), document.getElementById('addSectionButtonMobile')].filter(Boolean);
            var saveCurriculumButton = document.getElementById('saveCurriculumButton');
            var saveCurriculumLabel = document.getElementById('saveCurriculumLabel');
            var uploadQueueNotice = document.getElementById('uploadQueueNotice');
            var csrfToken = curriculumForm.querySelector('input[name="_token"]').value;
            var courseIdInput = curriculumForm.querySelector('input[name="course_id"]');
            var videoSignatureUrl = curriculumForm.dataset.videoSignatureUrl;
            var materialSignatureUrl = curriculumForm.dataset.materialSignatureUrl;
            var isSubmitting = false;
            var isUploading = false;
            var activeUploads = 0;

            function lessonMarkup(sectionIndex, lessonIndex) {
                return lessonTemplate.innerHTML
                    .replaceAll('__SECTION_INDEX__', sectionIndex)
                    .replaceAll('__LESSON_INDEX__', lessonIndex);
            }

            function sectionMarkup(sectionIndex) {
                return sectionTemplate.innerHTML
                    .replaceAll('__SECTION_INDEX__', sectionIndex)
                    .replaceAll('__SECTION_NUMBER__', sectionIndex + 1);
            }

            function materialMarkup(sectionIndex, lessonIndex, materialIndex) {
                return materialTemplate.innerHTML
                    .replaceAll('__SECTION_INDEX__', sectionIndex)
                    .replaceAll('__LESSON_INDEX__', lessonIndex)
                    .replaceAll('__MATERIAL_INDEX__', materialIndex);
            }

            function getUploadElements(lessonCard) {
                return {
                    fileInput: lessonCard.querySelector('.video-file-input'),
                    hiddenInput: lessonCard.querySelector('.existing-video-url'),
                    durationInput: lessonCard.querySelector('.existing-video-duration'),
                    status: lessonCard.querySelector('.video-upload-status'),
                    progressWrapper: lessonCard.querySelector('.video-progress-wrapper'),
                    progressBar: lessonCard.querySelector('.video-progress-bar'),
                    progressLabel: lessonCard.querySelector('.video-progress-label'),
                    progressSpeed: lessonCard.querySelector('.video-progress-speed'),
                    progressPercent: lessonCard.querySelector('.video-progress-percent'),
                    error: lessonCard.querySelector('.video-upload-error'),
                    link: lessonCard.querySelector('.uploaded-video-link'),
                    titleInput: lessonCard.querySelector('input[type="text"]'),
                };
            }

            function getMaterialUploadElements(materialCard) {
                return {
                    fileInput: materialCard.querySelector('.material-file-input'),
                    hiddenInput: materialCard.querySelector('.existing-material-url'),
                    status: materialCard.querySelector('.material-upload-status'),
                    progressWrapper: materialCard.querySelector('.material-progress-wrapper'),
                    progressBar: materialCard.querySelector('.material-progress-bar'),
                    progressLabel: materialCard.querySelector('.material-progress-label'),
                    progressSpeed: materialCard.querySelector('.material-progress-speed'),
                    progressPercent: materialCard.querySelector('.material-progress-percent'),
                    error: materialCard.querySelector('.material-upload-error'),
                    link: materialCard.querySelector('.uploaded-material-link'),
                    titleInput: materialCard.querySelector('input[type="text"]'),
                    typeInput: materialCard.querySelector('.material-type-select'),
                };
            }

            function setLessonError(lessonCard, message) {
                var upload = getUploadElements(lessonCard);
                upload.error.textContent = message;
                upload.error.classList.remove('hidden');
            }

            function clearLessonError(lessonCard) {
                var upload = getUploadElements(lessonCard);
                upload.error.textContent = '';
                upload.error.classList.add('hidden');
            }

            function setMaterialError(materialCard, message) {
                var upload = getMaterialUploadElements(materialCard);
                upload.error.textContent = message;
                upload.error.classList.remove('hidden');
            }

            function clearMaterialError(materialCard) {
                var upload = getMaterialUploadElements(materialCard);
                upload.error.textContent = '';
                upload.error.classList.add('hidden');
            }

            function formatUploadSpeed(bytesPerSecond) {
                var safeBytes = Math.max(0, Number(bytesPerSecond) || 0);

                if (safeBytes >= 1024 * 1024) {
                    return (safeBytes / (1024 * 1024)).toFixed(2) + ' MB/s';
                }

                if (safeBytes >= 1024) {
                    return Math.max(0.1, safeBytes / 1024).toFixed(1) + ' KB/s';
                }

                return Math.round(safeBytes) + ' B/s';
            }

            function updateUploadDisplay(lessonCard, state, message, percent, speedText) {
                var upload = getUploadElements(lessonCard);
                var safePercent = Math.max(0, Math.min(100, percent || 0));

                clearLessonError(lessonCard);
                upload.status.textContent = message;

                if (state === 'idle') {
                    upload.progressWrapper.classList.add('hidden');
                    upload.progressBar.style.width = '0%';
                    upload.progressLabel.textContent = 'Waiting to upload';
                    upload.progressSpeed.textContent = '0 KB/s';
                    upload.progressPercent.textContent = '0%';
                    return;
                }

                upload.progressWrapper.classList.remove('hidden');
                upload.progressBar.style.width = safePercent + '%';
                    upload.progressLabel.textContent = state === 'uploaded' ? 'Upload complete' : 'Uploading to Cloudflare Stream';
                upload.progressSpeed.textContent = state === 'uploaded' ? 'Done' : (speedText || '0 KB/s');
                upload.progressPercent.textContent = safePercent + '%';
            }

            function setUploadedLink(lessonCard, url) {
                var upload = getUploadElements(lessonCard);

                if (url) {
                    upload.link.href = url;
                    upload.link.classList.remove('hidden');
                    upload.link.classList.add('inline-flex');
                } else {
                    upload.link.href = '#';
                    upload.link.classList.add('hidden');
                    upload.link.classList.remove('inline-flex');
                }
            }

            function updateMaterialUploadDisplay(materialCard, state, message, percent, speedText) {
                var upload = getMaterialUploadElements(materialCard);
                var safePercent = Math.max(0, Math.min(100, percent || 0));

                clearMaterialError(materialCard);
                upload.status.textContent = message;

                if (state === 'idle') {
                    upload.progressWrapper.classList.add('hidden');
                    upload.progressBar.style.width = '0%';
                    upload.progressLabel.textContent = 'Waiting to upload';
                    upload.progressSpeed.textContent = '0 KB/s';
                    upload.progressPercent.textContent = '0%';
                    return;
                }

                upload.progressWrapper.classList.remove('hidden');
                upload.progressBar.style.width = safePercent + '%';
                upload.progressLabel.textContent = state === 'uploaded' ? 'Upload complete' : 'Uploading resource';
                upload.progressSpeed.textContent = state === 'uploaded' ? 'Done' : (speedText || '0 KB/s');
                upload.progressPercent.textContent = safePercent + '%';
            }

            function setUploadedMaterialLink(materialCard, url) {
                var upload = getMaterialUploadElements(materialCard);

                if (url) {
                    upload.link.href = url;
                    upload.link.classList.remove('hidden');
                    upload.link.classList.add('inline-flex');
                } else {
                    upload.link.href = '#';
                    upload.link.classList.add('hidden');
                    upload.link.classList.remove('inline-flex');
                }
            }

            function updateQueueNotice(message, hidden) {
                if (!uploadQueueNotice) {
                    return;
                }

                uploadQueueNotice.textContent = message || '';
                uploadQueueNotice.classList.toggle('hidden', !!hidden);
            }

            function beginActiveUpload(message) {
                activeUploads += 1;
                isUploading = true;
                saveCurriculumButton.disabled = true;
                saveCurriculumLabel.textContent = 'Uploading course files...';
                updateQueueNotice(message || 'Uploading course files. Please keep this tab open.', false);
            }

            function finishActiveUpload() {
                activeUploads = Math.max(0, activeUploads - 1);

                if (activeUploads === 0 && !isSubmitting) {
                    isUploading = false;
                    saveCurriculumButton.disabled = false;
                    saveCurriculumLabel.textContent = 'Save Curriculum & Continue';
                    updateQueueNotice('Upload complete. You can continue to pricing now.', false);
                }
            }

            function markLessonPending(lessonCard) {
                var upload = getUploadElements(lessonCard);
                var file = upload.fileInput.files[0];

                if (!file) {
                    if (upload.hiddenInput.value) {
                        updateUploadDisplay(lessonCard, 'uploaded', 'Video already uploaded and ready.', 100);
                    } else {
                        updateUploadDisplay(lessonCard, 'idle', 'Select a lesson video to start the secure Cloudflare Stream upload.', 0);
                    }
                    return;
                }

                upload.hiddenInput.value = '';
                if (upload.durationInput) {
                    upload.durationInput.value = '0';
                }
                updateUploadDisplay(lessonCard, 'pending', file.name + ' selected. Upload will begin when you continue.', 0);
                setUploadedLink(lessonCard, '');
            }

            function markMaterialPending(materialCard) {
                var upload = getMaterialUploadElements(materialCard);
                var file = upload.fileInput.files[0];

                if (!file) {
                    if (upload.hiddenInput.value) {
                        updateMaterialUploadDisplay(materialCard, 'uploaded', 'Resource already uploaded and ready.', 100);
                    } else {
                        updateMaterialUploadDisplay(materialCard, 'idle', 'Select a PDF, ZIP, or DOCX file to upload it for students.', 0);
                    }
                    return;
                }

                upload.hiddenInput.value = '';
                updateMaterialUploadDisplay(materialCard, 'pending', file.name + ' selected. Upload will begin when you continue.', 0);
                setUploadedMaterialLink(materialCard, '');
            }

            function requestVideoSignature(sectionIndex, lessonIndex, lessonTitle, fileName, contentType) {
                var url = new URL(videoSignatureUrl, window.location.origin);
                url.searchParams.set('course_id', courseIdInput.value);
                url.searchParams.set('section_index', sectionIndex);
                url.searchParams.set('lesson_index', lessonIndex);
                url.searchParams.set('lesson_title', lessonTitle || '');
                url.searchParams.set('_token', csrfToken);
                return url.toString();
            }

            function requestMaterialSignature(sectionIndex, lessonIndex, materialIndex, materialTitle, fileName) {
                var payload = new FormData();
                payload.append('course_id', courseIdInput.value);
                payload.append('section_index', sectionIndex);
                payload.append('lesson_index', lessonIndex);
                payload.append('material_index', materialIndex);
                payload.append('material_title', materialTitle || '');
                payload.append('file_name', fileName || '');

                return fetch(materialSignatureUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: payload,
                }).then(async function (response) {
                    var data = await response.json().catch(function () {
                        return {};
                    });

                    if (!response.ok) {
                        throw new Error(data.message || 'Unable to prepare the resource upload.');
                    }

                    return data;
                });
            }

            function readVideoDuration(file) {
                return new Promise(function (resolve) {
                    var probe = document.createElement('video');
                    var objectUrl = URL.createObjectURL(file);

                    probe.preload = 'metadata';
                    probe.src = objectUrl;

                    function cleanup() {
                        URL.revokeObjectURL(objectUrl);
                        probe.removeAttribute('src');
                        probe.load();
                    }

                    probe.onloadedmetadata = function () {
                        var seconds = Math.max(0, Math.round(Number(probe.duration || 0)));
                        cleanup();
                        resolve(seconds);
                    };

                    probe.onerror = function () {
                        cleanup();
                        resolve(0);
                    };
                });
            }

            function uploadFileToDirectUrl(uploadUrl, file, progressCallback, timeoutMs) {
                return new Promise(function (resolve, reject) {
                    var xhr = new XMLHttpRequest();
                    var uploadStartedAt = Date.now();

                    xhr.open('POST', uploadUrl, true);
                    xhr.timeout = timeoutMs;
                    var formData = new FormData();
                    formData.append('file', file);

                    xhr.upload.addEventListener('progress', function (event) {
                        if (!event.lengthComputable) {
                            return;
                        }

                        var percent = Math.round((event.loaded / event.total) * 100);
                        var elapsedSeconds = Math.max((Date.now() - uploadStartedAt) / 1000, 0.25);
                        var speedText = formatUploadSpeed(event.loaded / elapsedSeconds);
                        progressCallback(percent, speedText);
                    });

                    xhr.addEventListener('load', function () {
                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject(new Error('Upload failed. Please try again.'));
                            return;
                        }

                        resolve();
                    });

                    xhr.addEventListener('error', function () {
                        reject(new Error('Upload failed because the connection was interrupted.'));
                    });

                    xhr.addEventListener('timeout', function () {
                        reject(new Error('Upload took too long. Please try again with a stable connection.'));
                    });

                    xhr.send(formData);
                });
            }

            function uploadVideoToCloudflareStream(lessonCard) {
                var upload = getUploadElements(lessonCard);
                var file = upload.fileInput.files[0];

                if (!file) {
                    return Promise.resolve();
                }

                var sectionCard = lessonCard.closest('.section-card');
                var sectionIndex = Number(sectionCard.dataset.sectionIndex || 0);
                var lessonIndex = Number(lessonCard.dataset.lessonIndex || 0);
                var lessonTitle = upload.titleInput ? upload.titleInput.value : '';

                if (!window.tus || !window.tus.Upload) {
                    var missingTusError = new Error('The resumable upload client failed to load. Refresh the page and try again.');
                    missingTusError.lessonCard = lessonCard;
                    return Promise.reject(missingTusError);
                }

                updateUploadDisplay(lessonCard, 'uploading', 'Preparing resumable upload...', 4);

                return readVideoDuration(file).then(function (durationSeconds) {
                    return new Promise(function (resolve, reject) {
                        var streamPlaybackUrl = '';
                        var streamMediaId = '';

                        var tusUpload = new window.tus.Upload(file, {
                            endpoint: requestVideoSignature(sectionIndex, lessonIndex, lessonTitle, file.name, file.type),
                            chunkSize: 8 * 1024 * 1024,
                            retryDelays: [0, 3000, 5000, 10000, 20000],
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            metadata: {
                                name: file.name,
                                filetype: file.type || 'video/mp4',
                            },
                            onAfterResponse: function (req, res) {
                                streamMediaId = res.getHeader('stream-media-id') || streamMediaId;
                                streamPlaybackUrl = res.getHeader('x-stream-playback-url') || streamPlaybackUrl;
                            },
                            onError: function (error) {
                                var failedError = new Error(error && error.message ? error.message : 'Video upload failed. Please try again.');
                                failedError.lessonCard = lessonCard;
                                reject(failedError);
                            },
                            onProgress: function (bytesUploaded, bytesTotal) {
                                var percent = bytesTotal > 0 ? Math.round((bytesUploaded / bytesTotal) * 100) : 0;
                                var elapsedSeconds = Math.max((Date.now() - (tusUpload._startedAt || Date.now())) / 1000, 0.25);
                                var speedText = formatUploadSpeed(bytesUploaded / elapsedSeconds);
                                updateUploadDisplay(lessonCard, 'uploading', 'Uploading "' + file.name + '"...', percent, speedText);
                            },
                            onSuccess: function () {
                                var finalUrl = streamPlaybackUrl;

                                if (!finalUrl && streamMediaId) {
                                    finalUrl = 'https://customer-' + '{{ config('services.cloudflare_stream.customer_code') }}' + '.cloudflarestream.com/' + streamMediaId + '/manifest/video.m3u8';
                                }

                                if (!finalUrl) {
                                    var missingUrlError = new Error('Video upload finished, but playback URL was not returned.');
                                    missingUrlError.lessonCard = lessonCard;
                                    reject(missingUrlError);
                                    return;
                                }

                                upload.hiddenInput.value = finalUrl;
                                if (upload.durationInput) {
                                    upload.durationInput.value = String(durationSeconds);
                                }
                                upload.fileInput.value = '';
                                setUploadedLink(lessonCard, finalUrl);
                                updateUploadDisplay(lessonCard, 'uploaded', 'Upload complete. This lesson is ready for students.', 100);
                                resolve(finalUrl);
                            }
                        });

                        tusUpload._startedAt = Date.now();
                        tusUpload.start();
                    });
                }).catch(function (error) {
                    error.lessonCard = lessonCard;
                    throw error;
                });
            }

            function uploadMaterialToCloudflareR2(materialCard) {
                var upload = getMaterialUploadElements(materialCard);
                var file = upload.fileInput.files[0];

                if (!file) {
                    return Promise.resolve();
                }

                if (!upload.typeInput.value) {
                    var missingTypeError = new Error('Choose the resource type before uploading the file.');
                    missingTypeError.materialCard = materialCard;
                    return Promise.reject(missingTypeError);
                }

                if (!upload.titleInput.value.trim()) {
                    var missingTitleError = new Error('Add a resource title before uploading the file.');
                    missingTitleError.materialCard = materialCard;
                    return Promise.reject(missingTitleError);
                }

                var lessonCard = materialCard.closest('.lesson-card');
                var sectionCard = materialCard.closest('.section-card');
                var sectionIndex = Number(sectionCard.dataset.sectionIndex || 0);
                var lessonIndex = Number(lessonCard.dataset.lessonIndex || 0);
                var materialIndex = Number(materialCard.dataset.materialIndex || 0);

                updateMaterialUploadDisplay(materialCard, 'uploading', 'Preparing secure upload...', 4);

                return requestMaterialSignature(sectionIndex, lessonIndex, materialIndex, upload.titleInput.value, file.name).then(function (signature) {
                    return uploadFileToDirectUrl(
                        signature.upload_url,
                        file,
                        function (percent, speedText) {
                            updateMaterialUploadDisplay(materialCard, 'uploading', 'Uploading "' + file.name + '"...', percent, speedText);
                        },
                        1000 * 60 * 15
                    ).then(function () {
                        upload.hiddenInput.value = signature.file_url;
                        upload.fileInput.value = '';
                        setUploadedMaterialLink(materialCard, signature.file_url);
                        updateMaterialUploadDisplay(materialCard, 'uploaded', 'Upload complete. This resource is ready for students.', 100);
                        return signature.file_url;
                    });
                }).catch(function (error) {
                    error.materialCard = materialCard;
                    throw error;
                });
            }

            function syncSectionIndices() {
                Array.from(sectionsContainer.querySelectorAll('.section-card')).forEach(function (sectionCard, sectionIndex) {
                    sectionCard.dataset.sectionIndex = sectionIndex;
                    sectionCard.querySelectorAll('input, select, textarea').forEach(function (input) {
                        if (input.name) {
                            input.name = input.name.replace(/sections\[\d+\]/, 'sections[' + sectionIndex + ']');
                        }
                    });

                    Array.from(sectionCard.querySelectorAll('.lesson-card')).forEach(function (lessonCard, lessonIndex) {
                        lessonCard.dataset.lessonIndex = lessonIndex;
                        lessonCard.querySelectorAll('input, select, textarea').forEach(function (input) {
                            if (input.name) {
                                input.name = input.name
                                    .replace(/sections\[\d+\]/, 'sections[' + sectionIndex + ']')
                                    .replace(/lessons\[\d+\]/, 'lessons[' + lessonIndex + ']');
                            }
                        });

                        Array.from(lessonCard.querySelectorAll('.material-card')).forEach(function (materialCard, materialIndex) {
                            materialCard.dataset.materialIndex = materialIndex;
                            materialCard.querySelectorAll('input, select, textarea').forEach(function (input) {
                                if (input.name) {
                                    input.name = input.name
                                        .replace(/sections\[\d+\]/, 'sections[' + sectionIndex + ']')
                                        .replace(/lessons\[\d+\]/, 'lessons[' + lessonIndex + ']')
                                        .replace(/materials\[\d+\]/, 'materials[' + materialIndex + ']');
                                }
                            });
                        });
                    });
                });
            }

            function bindSection(sectionCard) {
                var lessonsContainer = sectionCard.querySelector('.lessons-container');
                var addLessonButton = sectionCard.querySelector('.add-lesson');
                var removeSectionButton = sectionCard.querySelector('.remove-section');
                var toggleButton = sectionCard.querySelector('.section-toggle');
                var toggleIcon = sectionCard.querySelector('.section-toggle-icon');
                var sectionBody = sectionCard.querySelector('.section-body');

                function setSectionOpenState(isOpen) {
                    if (!sectionBody || !toggleButton || !toggleIcon) {
                        return;
                    }

                    sectionBody.classList.toggle('hidden', !isOpen);
                    toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    toggleIcon.textContent = isOpen ? 'expand_less' : 'expand_more';
                }

                if (toggleButton) {
                    toggleButton.addEventListener('click', function () {
                        setSectionOpenState(toggleButton.getAttribute('aria-expanded') !== 'true');
                    });
                }

                addLessonButton.addEventListener('click', function () {
                    var sectionIndex = Array.from(sectionsContainer.querySelectorAll('.section-card')).indexOf(sectionCard);
                    var lessonIndex = lessonsContainer.querySelectorAll('.lesson-card').length;
                    lessonsContainer.insertAdjacentHTML('beforeend', lessonMarkup(sectionIndex, lessonIndex));
                    bindLesson(lessonsContainer.lastElementChild);
                    setSectionOpenState(true);
                    syncSectionIndices();
                });

                removeSectionButton.addEventListener('click', function () {
                    if (sectionsContainer.querySelectorAll('.section-card').length === 1) {
                        return;
                    }
                    sectionCard.remove();
                    syncSectionIndices();
                });

                sectionCard.querySelectorAll('.lesson-card').forEach(bindLesson);
            }

            function bindLesson(lessonCard) {
                var removeLessonButton = lessonCard.querySelector('.remove-lesson');
                var upload = getUploadElements(lessonCard);
                var materialsContainer = lessonCard.querySelector('.materials-container');
                var addMaterialButton = lessonCard.querySelector('.add-material');

                if (upload.fileInput) {
                    upload.fileInput.addEventListener('change', function () {
                        markLessonPending(lessonCard);

                        if (!upload.fileInput.files || upload.fileInput.files.length === 0) {
                            return;
                        }

                        clearLessonError(lessonCard);
                        beginActiveUpload('Uploading selected lesson video...');

                        uploadVideoToCloudflareStream(lessonCard)
                            .catch(function (error) {
                                setLessonError(lessonCard, error.message || 'Video upload failed. Please try again.');
                            })
                            .finally(function () {
                                finishActiveUpload();
                            });
                    });
                }

                removeLessonButton.addEventListener('click', function () {
                    var lessonsContainer = lessonCard.closest('.lessons-container');
                    if (lessonsContainer.querySelectorAll('.lesson-card').length === 1) {
                        return;
                    }
                    lessonCard.remove();
                    syncSectionIndices();
                });

                if (upload.hiddenInput && upload.hiddenInput.value) {
                    updateUploadDisplay(lessonCard, 'uploaded', 'Video already uploaded and ready.', 100);
                    setUploadedLink(lessonCard, upload.hiddenInput.value);
                } else {
                    updateUploadDisplay(lessonCard, 'idle', 'Select a lesson video to start the secure Cloudflare Stream upload.', 0);
                }

                function bindMaterial(materialCard) {
                    var materialUpload = getMaterialUploadElements(materialCard);
                    var removeMaterialButton = materialCard.querySelector('.remove-material');

                    if (materialUpload.fileInput) {
                        materialUpload.fileInput.addEventListener('change', function () {
                            markMaterialPending(materialCard);

                            if (!materialUpload.fileInput.files || materialUpload.fileInput.files.length === 0) {
                                return;
                            }

                            clearMaterialError(materialCard);
                            beginActiveUpload('Uploading selected lesson resource...');

                            uploadMaterialToCloudflareR2(materialCard)
                                .catch(function (error) {
                                    setMaterialError(materialCard, error.message || 'Resource upload failed. Please try again.');
                                })
                                .finally(function () {
                                    finishActiveUpload();
                                });
                        });
                    }

                    removeMaterialButton.addEventListener('click', function () {
                        materialCard.remove();
                        syncSectionIndices();
                    });

                    if (materialUpload.hiddenInput && materialUpload.hiddenInput.value) {
                        updateMaterialUploadDisplay(materialCard, 'uploaded', 'Resource already uploaded and ready.', 100);
                        setUploadedMaterialLink(materialCard, materialUpload.hiddenInput.value);
                    } else {
                        updateMaterialUploadDisplay(materialCard, 'idle', 'Select a PDF, ZIP, or DOCX file to upload it for students.', 0);
                    }
                }

                if (addMaterialButton) {
                    addMaterialButton.addEventListener('click', function () {
                        var sectionCard = lessonCard.closest('.section-card');
                        var sectionIndex = Number(sectionCard.dataset.sectionIndex || 0);
                        var lessonIndex = Number(lessonCard.dataset.lessonIndex || 0);
                        var materialIndex = materialsContainer.querySelectorAll('.material-card').length;
                        materialsContainer.insertAdjacentHTML('beforeend', materialMarkup(sectionIndex, lessonIndex, materialIndex));
                        bindMaterial(materialsContainer.lastElementChild);
                        syncSectionIndices();
                    });
                }

                lessonCard.querySelectorAll('.material-card').forEach(bindMaterial);
            }

            addSectionButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var sectionIndex = sectionsContainer.querySelectorAll('.section-card').length;
                    sectionsContainer.insertAdjacentHTML('beforeend', sectionMarkup(sectionIndex));
                    var newSection = sectionsContainer.lastElementChild;
                    var lessonsContainer = newSection.querySelector('.lessons-container');
                    lessonsContainer.insertAdjacentHTML('beforeend', lessonMarkup(sectionIndex, 0));
                    bindSection(newSection);
                    syncSectionIndices();
                });
            });

            sectionsContainer.querySelectorAll('.section-card').forEach(bindSection);
            syncSectionIndices();

            window.addEventListener('beforeunload', function (event) {
                if (!isUploading) {
                    return;
                }

                event.preventDefault();
                event.returnValue = '';
            });

            curriculumForm.addEventListener('submit', async function (event) {
                if (isSubmitting) {
                    event.preventDefault();
                    return;
                }

                event.preventDefault();

                if (activeUploads > 0) {
                    updateQueueNotice('Please wait for the current upload to finish before continuing.', false);
                    return;
                }

                var lessonCards = Array.from(sectionsContainer.querySelectorAll('.lesson-card'));
                var cardsToUpload = lessonCards.filter(function (lessonCard) {
                    var upload = getUploadElements(lessonCard);
                    return upload.fileInput && upload.fileInput.files && upload.fileInput.files.length > 0;
                });
                var materialCardsToUpload = Array.from(sectionsContainer.querySelectorAll('.material-card')).filter(function (materialCard) {
                    var upload = getMaterialUploadElements(materialCard);
                    return upload.fileInput && upload.fileInput.files && upload.fileInput.files.length > 0;
                });

                if (cardsToUpload.length === 0 && materialCardsToUpload.length === 0) {
                    isSubmitting = true;
                    curriculumForm.submit();
                    return;
                }

                isSubmitting = true;
                isUploading = cardsToUpload.length > 0 || materialCardsToUpload.length > 0;
                saveCurriculumButton.disabled = true;
                saveCurriculumLabel.textContent = isUploading ? 'Uploading course files...' : 'Saving curriculum...';

                var totalUploads = cardsToUpload.length + materialCardsToUpload.length;

                if (totalUploads > 0) {
                    updateQueueNotice('Preparing ' + totalUploads + ' upload' + (totalUploads > 1 ? 's' : '') + ' before moving to pricing.', false);
                } else {
                    updateQueueNotice('', true);
                }

                try {
                    for (var index = 0; index < cardsToUpload.length; index += 1) {
                        clearLessonError(cardsToUpload[index]);
                        updateQueueNotice('Uploading lesson video ' + (index + 1) + ' of ' + totalUploads + '. Please keep this tab open.', false);
                        await uploadVideoToCloudflareStream(cardsToUpload[index]);
                    }

                    for (var materialIndex = 0; materialIndex < materialCardsToUpload.length; materialIndex += 1) {
                        clearMaterialError(materialCardsToUpload[materialIndex]);
                        updateQueueNotice('Uploading lesson resource ' + (cardsToUpload.length + materialIndex + 1) + ' of ' + totalUploads + '. Please keep this tab open.', false);
                        await uploadMaterialToCloudflareR2(materialCardsToUpload[materialIndex]);
                    }

                    isUploading = false;
                    updateQueueNotice('All course files are uploaded. Saving curriculum and moving to pricing...', false);
                    saveCurriculumLabel.textContent = 'Saving curriculum...';
                    curriculumForm.submit();
                } catch (error) {
                    var activeCard = error.lessonCard || null;
                    var activeMaterialCard = error.materialCard || null;

                    if (activeCard) {
                        setLessonError(activeCard, error.message || 'Video upload failed. Please try again.');
                    }

                    if (activeMaterialCard) {
                        setMaterialError(activeMaterialCard, error.message || 'Resource upload failed. Please try again.');
                    }

                    isUploading = false;
                    updateQueueNotice('One of the lesson uploads failed. Fix that item and continue again.', false);
                    saveCurriculumButton.disabled = false;
                    saveCurriculumLabel.textContent = 'Save Curriculum & Continue';
                    isSubmitting = false;
                }
            });
        });
    </script>
</body>
</html>




