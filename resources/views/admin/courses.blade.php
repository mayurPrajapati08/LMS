<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself - Course Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .admin-select { appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 2.75rem; background-image: none; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">
    <x-admin.navbar />

    <main class="md:ml-64 min-h-screen flex flex-col">
        <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
            <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
                <div class="relative w-full md:max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input class="w-full bg-slate-100 border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-[#f5eef8]/20 outline-none transition-all" placeholder="Search..." type="text" />
                </div>
            </div>
            <div class="ml-auto flex items-center gap-3">
                <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $admin->name }}</span>
                <img alt="{{ $admin->name }}" class="h-9 w-9 rounded-full object-cover" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="mt-16 p-4 md:p-8 flex-1">
            <div class="flex items-end justify-between mb-10 gap-6">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#6a3378] mb-2 block">Academy Inventory</span>
                    <h2 class="text-4xl font-extrabold tracking-tight font-headline leading-none">Course Management</h2>
                </div>
                <a class="bg-gradient-to-br from-primary to-primary-container text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-primary/20 flex items-center gap-2" href="{{ route('admin.courses') }}">
                    <span class="material-symbols-outlined text-xl">add_circle</span>
                    Course Library
                </a>
            </div>

            <div class="bg-surface-container-low rounded-[2rem] p-6 space-y-6">
                <form class="bg-surface-container-lowest rounded-2xl p-4 flex flex-wrap items-center gap-4" method="GET">
                    <div class="flex-1 min-w-[200px] relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">filter_list</span>
                        <input class="w-full bg-surface-container-low border-none rounded-xl py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/10" name="search" placeholder="Search courses by name or ID..." type="text" value="{{ $filters['search'] }}" />
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <select class="admin-select bg-surface-container-low border-none rounded-xl py-2.5 pl-4 pr-11 text-sm font-medium text-on-surface-variant focus:ring-2 focus:ring-primary/10 cursor-pointer" name="category">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($filters['categoryId'] === $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                        </div>
                        <div class="relative">
                            <select class="admin-select bg-surface-container-low border-none rounded-xl py-2.5 pl-4 pr-11 text-sm font-medium text-on-surface-variant focus:ring-2 focus:ring-primary/10 cursor-pointer" name="status">
                                <option value="">All Status</option>
                                <option value="published" @selected($filters['status'] === 'published')>Published</option>
                                <option value="draft" @selected($filters['status'] === 'draft')>Draft</option>
                                <option value="archived" @selected($filters['status'] === 'archived')>Archived</option>
                            </select>
                            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                        </div>
                        <button class="px-4 py-2.5 rounded-xl bg-primary text-white text-sm font-bold" type="submit">Apply</button>
                    </div>
                </form>

                <div class="bg-surface-container-lowest rounded-3xl overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-highest/50">
                                <th class="py-5 px-6 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Thumbnail & Course</th>
                                <th class="py-5 px-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Instructor</th>
                                <th class="py-5 px-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Category</th>
                                <th class="py-5 px-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Enrolled</th>
                                <th class="py-5 px-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Price</th>
                                <th class="py-5 px-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            @forelse ($courses as $course)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-4">
                                            <div class="h-14 w-20 rounded-lg bg-surface-container-high overflow-hidden shrink-0">
                                                <img alt="{{ $course->title }}" class="w-full h-full object-cover" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=F3E8FF&color=6B21A8&size=320' }}" />
                                            </div>
                                            <div>
                                                <div class="font-bold text-on-surface text-base">{{ $course->title }}</div>
                                                <div class="text-xs text-on-surface-variant">ID: CRS-{{ str_pad((string) $course->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-4 text-sm font-medium">{{ $course->user?->name ?: 'Instructor' }}</td>
                                    <td class="py-5 px-4"><span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 px-2 py-1 rounded-md text-slate-600">{{ $course->category?->name ?: 'General' }}</span></td>
                                    <td class="py-5 px-4 text-sm font-medium">{{ number_format($course->enrollments_count) }}</td>
                                    <td class="py-5 px-4 text-sm font-bold">Rs. {{ number_format($course->price, 0) }}</td>
                                    <td class="py-5 px-4 text-center">
                                        <span class="inline-flex items-center rounded-full {{ $course->status === 'published' ? 'bg-[#eadff1] text-[#7c4190]' : ($course->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-600') }} px-3 py-1 text-[10px] font-bold uppercase tracking-wider">
                                            {{ $course->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-8 px-6 text-center text-sm text-slate-500" colspan="6">No courses matched the current filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-6 py-4 flex items-center justify-between bg-surface-container-lowest border-t border-outline-variant/10">
                        <p class="text-xs text-on-surface-variant font-medium">Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }} results</p>
                        <div class="flex items-center gap-2">
                            @for ($page = 1; $page <= min(3, $courses->lastPage()); $page++)
                                <a class="h-8 w-8 rounded-lg flex items-center justify-center {{ $courses->currentPage() === $page ? 'bg-primary text-white' : 'hover:bg-surface-container-high text-xs font-medium' }}" href="{{ $courses->url($page) }}">{{ $page }}</a>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-primary/5 rounded-[2rem] p-4 md:p-8">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-primary mb-4">Total Inventory</h4>
                        <div class="text-5xl font-extrabold font-headline text-primary">{{ number_format($inventoryCount) }}</div>
                    </div>
                    <div class="bg-surface-container-lowest rounded-[2rem] p-4 md:p-8 border border-outline-variant/5">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-4">Average Rating</h4>
                        <div class="text-5xl font-extrabold font-headline text-on-surface">{{ number_format($averageRating, 1) }}</div>
                    </div>
                    <div class="bg-surface-container-lowest rounded-[2rem] p-4 md:p-8 border border-outline-variant/5">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-4">Revenue Estimate</h4>
                        <div class="text-5xl font-extrabold font-headline text-on-surface">Rs. {{ number_format($revenueEstimate, 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>




