<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Certificates | The Scholarly Editorial</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Manrope:wght@600;700;800&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#58579b",
                        "surface-tint": "#4d44e3",
                        "inverse-on-surface": "#f0f1f2",
                        "secondary-fixed": "#e2dfff",
                        "on-primary-fixed": "#0f0069",
                        "error-container": "#ffdad6",
                        "tertiary": "#005523",
                        "tertiary-container": "#007030",
                        "on-secondary-fixed-variant": "#413f82",
                        "tertiary-fixed": "#6bff8f",
                        "secondary-fixed-dim": "#c3c0ff",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#3323cc",
                        "error": "#ba1a1a",
                        "surface-container-low": "#f3f4f5",
                        "secondary-container": "#b6b4ff",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#c3c0ff",
                        "outline-variant": "#c7c4d8",
                        "on-surface": "#191c1d",
                        "surface-dim": "#d9dadb",
                        "on-secondary-fixed": "#140f54",
                        "inverse-primary": "#c3c0ff",
                        "on-surface-variant": "#464555",
                        "tertiary-fixed-dim": "#4ae176",
                        "on-primary-container": "#dad7ff",
                        "inverse-surface": "#2e3132",
                        "outline": "#777587",
                        "primary-container": "#4f46e5",
                        "on-background": "#191c1d",
                        "surface-container-high": "#e7e8e9",
                        "surface-container": "#edeeef",
                        "on-tertiary-fixed-variant": "#005321",
                        "primary-fixed": "#e2dfff",
                        "surface-bright": "#f8f9fa",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-container": "#63f889",
                        "surface-container-highest": "#e1e3e4",
                        "on-error-container": "#93000a",
                        "background": "#f8f9fa",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#3525cd",
                        "on-secondary-container": "#454386",
                        "surface-variant": "#e1e3e4",
                        "on-secondary": "#ffffff",
                        "surface": "#f8f9fa"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="bg-background text-on-surface">
    <x-student.navbar />

    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 shadow-sm dark:shadow-none">
        <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
            <form action="{{ route('student.certificates') }}" class="relative w-full md:max-w-md group" method="GET">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-lg pl-10 pr-3 md:pr-4 py-2 focus:ring-2 focus:ring-indigo-500/20 text-sm font-body" name="search" placeholder="Search..." type="text" value="{{ $search }}" />
            </form>
        </div>
        <div class="ml-auto flex items-center gap-3 md:pl-4 md:border-l md:border-slate-100">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold font-headline text-on-surface">Informed Curator</p>
                <p class="text-[10px] text-slate-500">Premium Member</p>
            </div>
            <img alt="Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $studentAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="max-w-7xl mx-auto p-12">
            <div class="mb-12">
                <p class="text-sm font-bold tracking-widest text-primary uppercase mb-3">Academic Achievements</p>
                <h1 class="text-6xl font-bold font-headline text-on-surface mb-4 leading-tight">Your Digital <br /><span class="text-primary-container">Credentials</span></h1>
                <p class="text-lg text-on-surface-variant max-w-2xl font-body leading-relaxed">
                    Verify and showcase your professional milestones. Every certificate here represents hours of dedicated research, practice, and informed curation.
                </p>
            </div>

            <div class="mb-8 p-6 bg-surface-container-lowest rounded-xl shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-center gap-8">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-1">Issued Credentials</p>
                        <p class="text-3xl font-bold font-headline text-primary">{{ $issuedCount }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-1">Pending Credentials</p>
                        <p class="text-3xl font-bold font-headline text-on-surface">{{ $pendingCount }}</p>
                    </div>
                </div>
                @if ($search !== '')
                    <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-surface-container-high text-primary font-semibold hover:bg-surface-container-highest transition-all" href="{{ route('student.certificates') }}">
                        <span class="material-symbols-outlined text-sm">close</span>
                        Clear Search
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($issuedCertificates as $certificate)
                    @php($course = $certificate->course)
                    <div class="group bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                        <div class="relative h-56 bg-surface-container-low overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480' }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                                <span class="bg-primary text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Verified</span>
                                <span class="text-white text-xs font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span> {{ optional($certificate->issued_at)->format('M Y') ?: optional($certificate->created_at)->format('M Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold font-headline mb-2 group-hover:text-primary transition-colors">{{ $course->title }}</h3>
                            <p class="text-sm text-on-surface-variant mb-3 line-clamp-2">{{ $course->details }}</p>
                            <p class="text-xs text-slate-500 mb-6">Instructor: {{ $course->user?->name ?: 'Instructor' }}</p>
                            <div class="mt-auto flex items-center gap-3">
                                <a class="flex-1 bg-primary text-white py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-95" href="{{ $certificate->certificate_url }}">
                                    <span class="material-symbols-outlined text-lg">download</span>
                                    Download PDF
                                </a>
                                <button class="w-12 h-12 flex items-center justify-center rounded-lg bg-surface-container-high text-primary hover:bg-primary hover:text-white transition-all" type="button">
                                    <span class="material-symbols-outlined">share</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-dashed border-outline-variant/30">
                        <h3 class="text-2xl font-bold font-headline text-on-surface">No issued certificates yet</h3>
                        <p class="mt-2 text-on-surface-variant">Complete a course and issue a certificate record to see it here.</p>
                    </div>
                @endforelse

                @foreach ($pendingCertificates->take(2) as $pending)
                    <div class="group bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col border border-dashed border-outline-variant/30">
                        <div class="relative h-56 bg-surface-container-low overflow-hidden">
                            <img class="w-full h-full object-cover grayscale opacity-60" src="{{ $pending['thumbnail'] }}" />
                            <div class="absolute inset-0 flex items-center justify-center flex-col bg-white/40 backdrop-blur-sm">
                                <div class="w-16 h-16 rounded-full border-4 border-primary border-t-transparent animate-spin-slow"></div>
                                <p class="mt-4 font-bold text-primary tracking-widest uppercase text-xs">{{ $pending['progress_percent'] }}% Complete</p>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col opacity-60">
                            <h3 class="text-xl font-bold font-headline mb-2">{{ $pending['title'] }}</h3>
                            <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">{{ $pending['details'] }}</p>
                            <div class="mt-auto">
                                <button class="w-full bg-surface-container-high text-on-surface-variant py-3 rounded-lg font-bold text-sm cursor-not-allowed" disabled="">
                                    {{ $pending['is_ready'] ? 'Ready to Issue' : 'Pending Completion' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="bg-primary-container text-white rounded-xl p-4 md:p-8 flex flex-col justify-center items-center text-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <span class="material-symbols-outlined text-5xl mb-6">workspace_premium</span>
                    <h3 class="text-2xl font-bold font-headline mb-4">Request a Transcript</h3>
                    <p class="text-on-primary-container text-sm mb-8">Need a formal document sent directly to an institution or employer?</p>
                    <button class="w-full bg-white text-primary py-4 rounded-lg font-extrabold text-sm tracking-widest uppercase hover:bg-primary-fixed transition-colors" type="button">
                        Send Official Record
                    </button>
                </div>
            </div>

            <div class="mt-16 p-4 md:p-8 bg-surface-container-low rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-l-4 border-primary">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                        <span class="material-symbols-outlined">lightbulb</span>
                    </div>
                    <div>
                        <h4 class="font-bold font-headline">Expand your expertise</h4>
                        <p class="text-sm text-on-surface-variant">You're {{ max(0, 2 - $issuedCount) }} courses away from the "Elite Curator" master badge.</p>
                    </div>
                </div>
                <a class="px-6 py-2 border-2 border-primary text-primary rounded-lg font-bold hover:bg-primary hover:text-white transition-all" href="/student/browse-courses">
                    View Pathway
                </a>
            </div>
        </div>
    </main>

    <a class="fixed bottom-8 right-8 w-16 h-16 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 group" href="/student/browse-courses">
        <span class="material-symbols-outlined text-3xl">add</span>
        <span class="absolute right-full mr-4 bg-on-surface text-white text-xs px-3 py-1 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">Add New Credential</span>
    </a>
</body>

</html>
