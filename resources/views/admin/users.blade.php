<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>User Management - CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#6a3378",
                        "primary-container": "#b07ac3",
                        "background": "#fcf9fe",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f5eef8",
                        "surface-container-high": "#efe5f4",
                        "surface-container-highest": "#e7dcef",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#6d5a76",
                        "outline-variant": "#dbcde4",
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
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .admin-select { appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 2.5rem; background-image: none; }
    </style>
</head>
<body class="bg-background text-on-surface">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)]">
        <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-[#f5eef8]0/20 outline-none" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="w-9 h-9 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-24 p-4 md:p-8 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-1">
                    <span class="font-label text-xs font-bold uppercase tracking-[0.15em] text-primary">Administration</span>
                    <h2 class="text-4xl font-extrabold tracking-tight font-headline">User Management</h2>
                    <p class="text-on-surface-variant max-w-lg">Manage student records, track academic progress, and review platform participation.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-surface-container-high text-on-surface font-semibold rounded-xl" href="{{ route('admin.users') }}">Refresh</a>
                </div>
            </div>

            <form class="grid grid-cols-1 lg:grid-cols-4 gap-4" method="GET">
                <div class="lg:col-span-2 bg-surface-container-lowest p-4 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="flex-1 relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">filter_list</span>
                        <input class="w-full bg-surface-container-low border-none rounded-xl py-3 pl-11 pr-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none" name="search" placeholder="Filter by Name, ID or Email..." type="text" value="{{ $filters['search'] }}" />
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-2xl shadow-sm flex items-center gap-3">
                    <span class="material-symbols-outlined text-on-surface-variant">event</span>
                    <div class="relative w-full">
                        <select class="admin-select w-full bg-transparent border-none text-sm font-semibold focus:ring-0 p-0 text-on-surface cursor-pointer" name="joined">
                            <option value="30" @selected($filters['joined'] === '30')>Joined: Last 30 Days</option>
                            <option value="180" @selected($filters['joined'] === '180')>Joined: Last 6 Months</option>
                            <option value="all" @selected($filters['joined'] === 'all')>Joined: All Time</option>
                        </select>
                        <span class="material-symbols-outlined pointer-events-none absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-2xl shadow-sm flex items-center gap-3">
                    <span class="material-symbols-outlined text-on-surface-variant">bolt</span>
                    <div class="flex items-center gap-3 w-full">
                        <div class="relative w-full">
                            <select class="admin-select w-full bg-transparent border-none text-sm font-semibold focus:ring-0 p-0 text-on-surface cursor-pointer" name="status">
                                <option value="" @selected($filters['status'] === '')>Status: All Users</option>
                                <option value="active" @selected($filters['status'] === 'active')>Status: Active</option>
                                <option value="inactive" @selected($filters['status'] === 'inactive')>Status: Inactive</option>
                            </select>
                            <span class="material-symbols-outlined pointer-events-none absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                        </div>
                        <button class="px-3 py-2 rounded-lg bg-primary text-white text-xs font-bold" type="submit">Apply</button>
                    </div>
                </div>
            </form>

            <div class="bg-surface-container-lowest rounded-3xl overflow-x-auto shadow-sm border border-outline-variant/10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-highest/30">
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/10">Avatar/Name</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/10">Email</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/10">Joined Date</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/10">Enrollments</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/10">Progress Avg</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/10">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse ($users as $user)
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" src="{{ $user->avatarUrl(80) }}" />
                                        <div>
                                            <p class="text-sm font-bold text-on-surface">{{ $user->name }}</p>
                                            <p class="text-[10px] text-on-surface-variant">ID: #ST-{{ str_pad((string) $user->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><span class="text-sm text-on-surface-variant font-medium">{{ $user->email }}</span></td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $user->created_at?->format('M d, Y') }}</td>
                                <td class="px-6 py-4"><span class="text-sm font-bold text-on-surface">{{ number_format($user->enrollments_count) }}</span></td>
                                <td class="px-6 py-4">
                                    <div class="w-32">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[10px] font-bold text-primary">{{ $user->progress_average }}%</span>
                                        </div>
                                        <div class="w-full h-1 bg-surface-container-high overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-[#6a3378] to-[#b07ac3]" style="width: {{ max(4, $user->progress_average) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full {{ $user->derived_status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }} text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 {{ $user->derived_status === 'active' ? 'bg-emerald-500' : 'bg-slate-400' }} rounded-full"></span>
                                        {{ $user->derived_status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-8 text-center text-sm text-slate-500" colspan="6">No student accounts matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-6 bg-surface-container-low/30 flex items-center justify-between border-t border-outline-variant/5">
                    <p class="text-xs font-medium text-on-surface-variant">Showing <span class="font-bold text-on-surface">{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</span> of <span class="font-bold text-on-surface">{{ $users->total() }}</span> students</p>
                    <div class="flex items-center gap-1">
                        @for ($page = 1; $page <= min(3, $users->lastPage()); $page++)
                            <a class="w-8 h-8 rounded-lg flex items-center justify-center {{ $users->currentPage() === $page ? 'bg-primary text-white text-xs font-bold shadow-md shadow-primary/20' : 'hover:bg-surface-container-high text-xs font-bold transition-all' }}" href="{{ $users->url($page) }}">{{ $page }}</a>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#6a3378] rounded-3xl p-6 text-white">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#e1cde8]">Total Database</p>
                    <h3 class="text-5xl font-extrabold font-headline">{{ number_format($studentCount) }}</h3>
                </div>
                <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/10 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Active Learners</p>
                    <h3 class="text-5xl font-extrabold font-headline text-on-surface">{{ number_format($activeLearners) }}</h3>
                </div>
                <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/10 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Completion Rate</p>
                    <h3 class="text-5xl font-extrabold font-headline text-on-surface">{{ number_format($completionRate, 1) }}%</h3>
                </div>
            </div>
        </div>
    </main>
</body>
</html>





