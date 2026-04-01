<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Students</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#1570d8",
                        "outline-variant": "#d5e4ff",
                        "secondary-container": "#d7e9ff",
                        "background": "#f4f9ff",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#4f6178",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#7c8da7",
                        "on-secondary-fixed-variant": "#315b90",
                        "on-primary-fixed-variant": "#0a4b99",
                        "surface-tint": "#1570d8",
                        "on-primary-container": "#edf5ff",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f5fbff",
                        "primary": "#0c4ea3",
                        "surface-bright": "#f4f9ff",
                        "secondary-fixed": "#e8f3ff",
                        "primary-fixed-dim": "#b9dcff",
                        "primary-fixed": "#e8f3ff",
                        "error": "#ba1a1a",
                        "surface-variant": "#dbe8ff",
                        "secondary-fixed-dim": "#b9dcff",
                        "surface": "#f4f9ff",
                        "on-error": "#ffffff",
                        "surface-container-high": "#e3eeff",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#dbe8ff",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#eef5ff",
                        "secondary": "#3b5f8d",
                        "inverse-surface": "#18345f",
                        "surface-container": "#e9f2ff",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#b9dcff",
                        "surface-dim": "#d4e3f8",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#41648d",
                        "on-secondary-fixed": "#072a60"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; background: #f4f9ff; color: #191c1d; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .editorial-shadow { box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 w-full pl-16 pr-4 md:px-8 py-4 bg-white/80 backdrop-blur-md flex justify-between items-center shadow-sm">
            <div>
                <h1 class="font-headline text-3xl font-bold tracking-tight text-slate-900">Student Directory</h1>
                <p class="mt-1 text-sm text-slate-500">Track enrollment progress and see who needs attention next.</p>
            </div>
            <div class="flex items-center gap-6">
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <img alt="Instructor Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
            <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Total Active</p>
                    <p class="mt-3 font-headline text-3xl font-bold text-slate-900">{{ $totalActiveStudents }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Avg. Progress</p>
                    <p class="mt-3 font-headline text-3xl font-bold text-slate-900">{{ $averageProgress }}</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 border border-slate-200 editorial-shadow">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">High Potential</p>
                    <p class="mt-3 font-headline text-3xl font-bold text-emerald-600">{{ $highPotentialCount }}</p>
                </div>
                <div class="rounded-[24px] bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-800 p-6 text-white editorial-shadow">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#dcecff]">Top Course</p>
                    <p class="mt-3 font-headline text-2xl font-bold">{{ $topCourseTitle }}</p>
                    <p class="mt-2 text-sm text-[#dcecff]/85">{{ $topCourseStudents }} enrolled students</p>
                </div>
            </section>

            <section class="rounded-[28px] bg-white border border-slate-200 overflow-hidden editorial-shadow">
                <div class="px-6 md:px-8 py-6 border-b border-slate-200 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex gap-3 flex-wrap">
                        <span class="rounded-full bg-[#edf5ff] px-4 py-2 text-sm font-semibold text-[#0b3f88]">All Students {{ $students->total() }}</span>
                        <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">High Potential {{ $highPotentialCount }}</span>
                        <span class="rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">At Risk {{ $atRiskCount }}</span>
                    </div>
                    <p class="text-sm text-slate-500">Showing {{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }} of {{ $students->total() }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[980px] text-left">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 md:px-8 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Student</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Course</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Progress</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Status</th>
                                <th class="px-6 md:px-8 py-4 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Enrollment Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($students as $studentRow)
                                @php
                                    $enrollment = $studentRow['enrollment'];
                                    $progressPercent = $studentRow['progress_percent'];
                                    $progressClass = $progressPercent >= 85 ? 'bg-emerald-500' : ($progressPercent <= 35 ? 'bg-amber-500' : 'bg-[#edf5ff]0');
                                    $statusClass = $progressPercent >= 85 ? 'bg-emerald-50 text-emerald-700' : ($progressPercent <= 35 ? 'bg-amber-50 text-amber-700' : 'bg-[#edf5ff] text-[#0b3f88]');
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 md:px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <img alt="Student Avatar" class="w-11 h-11 rounded-2xl object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($enrollment->user->name) }}&background=E2E8F0&color=334155&size=96" />
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $enrollment->user->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $enrollment->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-700">{{ $enrollment->course->title }}</td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-40 h-2 rounded-full bg-slate-100 overflow-hidden">
                                                <div class="h-full {{ $progressClass }}" style="width: {{ $progressPercent }}%"></div>
                                            </div>
                                            <span class="text-sm font-bold text-slate-700">{{ $progressPercent }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] {{ $statusClass }}">{{ $studentRow['status_label'] }}</span>
                                    </td>
                                    <td class="px-6 md:px-8 py-5 text-sm text-slate-500">{{ \Carbon\Carbon::parse($enrollment->enrolled_at ?? $enrollment->created_at)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 md:px-8 py-16 text-center text-sm text-slate-500" colspan="5">No enrolled students found yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                    <div class="flex items-center justify-between px-6 md:px-8 py-5 border-t border-slate-200 bg-slate-50/60">
                        <div class="text-sm text-slate-500">Page {{ $students->currentPage() }} of {{ $students->lastPage() }}</div>
                        <div>{{ $students->onEachSide(1)->links() }}</div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</body>
</html>


