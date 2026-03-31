<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Categories Management | Academic Curator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3525cd",
                        "primary-container": "#4f46e5",
                        "background": "#f8f9fa",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f3f4f5",
                        "surface-container-high": "#e7e8e9",
                        "surface-container-highest": "#e1e3e4",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#464555",
                        "outline-variant": "#c7c4d8",
                        "primary-fixed": "#e2dfff",
                        "on-primary-fixed-variant": "#3323cc",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .primary-gradient { background: linear-gradient(135deg, #3525cd 0%, #4f46e5 100%); }
    </style>
</head>
<body class="bg-background font-body text-on-surface">
    <x-admin.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)]">
            <div class="flex items-center bg-surface-container-low rounded-full px-3 md:px-4 py-1.5 w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none md:w-96">
                <span class="material-symbols-outlined text-slate-400 text-sm">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-400 font-body" placeholder="Search..." type="text" />
            </div>
            <div class="ml-auto flex items-center gap-3">
                <span class="hidden sm:block text-sm font-semibold text-indigo-600">{{ $admin->name }}</span>
                <img alt="{{ $admin->name }}" class="w-9 h-9 rounded-full object-cover" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="pt-24 px-10 pb-12">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-error-container px-4 py-3 text-sm text-on-error-container">{{ $errors->first() }}</div>
            @endif

            <div class="flex justify-between items-end mb-10 gap-6">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary">System Hierarchy</span>
                    <h2 class="text-4xl font-extrabold font-headline tracking-tight">Categories Management</h2>
                    <p class="text-on-surface-variant max-w-lg">Organize and curate academic paths. Manage course clustering and faculty assignment levels.</p>
                </div>
                <a class="primary-gradient text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-primary/20 flex items-center gap-2 active:scale-95 transition-transform" href="#category-form">
                    <span class="material-symbols-outlined">add</span>
                    {{ $editingCategory ? 'Edit Category' : 'Add New Category' }}
                </a>
            </div>

            <div class="grid grid-cols-12 gap-6 mb-8">
                <div class="col-span-12 md:col-span-4 bg-surface-container-lowest p-6 rounded-xl shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Active Categories</p>
                        <h3 class="text-3xl font-extrabold font-headline">{{ number_format($activeCategoryCount) }}</h3>
                    </div>
                    <div class="p-3 bg-primary/5 rounded-full text-primary">
                        <span class="material-symbols-outlined">category</span>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8 bg-surface-container-lowest p-6 rounded-xl shadow-sm overflow-hidden relative">
                    <div class="flex justify-between items-center relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Growth Forecast</p>
                            <h3 class="text-3xl font-extrabold font-headline">+{{ $growthPercent }}% <span class="text-sm font-medium text-primary">vs last semester</span></h3>
                        </div>
                        <div class="flex gap-1 h-12 items-end">
                            <div class="w-2 bg-primary/20 rounded-t-sm h-6"></div>
                            <div class="w-2 bg-primary/30 rounded-t-sm h-8"></div>
                            <div class="w-2 bg-primary/40 rounded-t-sm h-10"></div>
                            <div class="w-2 bg-primary/60 rounded-t-sm h-7"></div>
                            <div class="w-2 bg-primary rounded-t-sm h-12"></div>
                        </div>
                    </div>
                    <div class="absolute right-[-10%] bottom-[-20%] font-headline font-black text-surface-container opacity-50 select-none pointer-events-none text-9xl">CURATE</div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <section class="xl:col-span-2 bg-surface-container-lowest rounded-xl shadow-sm overflow-x-auto">
                    <div class="p-6 flex items-center justify-between border-b border-outline-variant/10">
                        <h4 class="font-bold text-lg font-headline">All Categories</h4>
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ $categories->total() }} records</span>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low/50 border-b border-outline-variant/10">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Category Name</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Description</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Total Courses</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Created Date</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-surface-container-low/30 transition-colors group">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                                <span class="material-symbols-outlined">category</span>
                                            </div>
                                            <span class="font-semibold text-on-surface font-headline">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm text-on-surface-variant line-clamp-1 max-w-xs">{{ $category->courses_count > 0 ? $category->courses_count.' course'.($category->courses_count > 1 ? 's' : '').' currently mapped to this learning path.' : 'No courses are assigned to this category yet.' }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-fixed text-on-primary-fixed-variant">{{ $category->courses_count }} courses</span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-500">{{ $category->created_at?->format('M d, Y') }}</td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a class="p-2 text-primary hover:bg-primary/5 rounded-lg" href="{{ route('admin.categories', ['edit' => $category->id]) }}">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="p-2 text-error hover:bg-error/5 rounded-lg" type="submit">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-8 text-center text-sm text-slate-500" colspan="5">No categories found yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-6 bg-surface-container-low/30 flex items-center justify-between border-t border-outline-variant/10">
                        <span class="text-xs font-medium text-slate-500">Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories</span>
                        <div class="flex gap-2">
                            @for ($page = 1; $page <= min(3, $categories->lastPage()); $page++)
                                <a class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold {{ $categories->currentPage() === $page ? 'bg-primary text-white' : 'bg-white border border-outline-variant/20 text-slate-600' }}" href="{{ $categories->url($page) }}">{{ $page }}</a>
                            @endfor
                        </div>
                    </div>
                </section>

                <section class="bg-surface-container-lowest rounded-xl shadow-sm p-6" id="category-form">
                    <div class="mb-6">
                        <h4 class="font-bold text-lg font-headline">{{ $editingCategory ? 'Update Category' : 'Create Category' }}</h4>
                        <p class="text-sm text-on-surface-variant mt-1">Keep the naming consistent so instructors can organize courses cleanly.</p>
                    </div>

                    <form action="{{ $editingCategory ? route('admin.categories.update', $editingCategory) : route('admin.categories.store') }}" class="space-y-5" method="POST">
                        @csrf
                        @if ($editingCategory)
                            @method('PUT')
                        @endif
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400">Category Name</label>
                            <input class="w-full bg-surface-container-low border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20" name="name" type="text" value="{{ old('name', $editingCategory->name ?? '') }}" />
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="flex-1 primary-gradient text-white px-4 py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20" type="submit">{{ $editingCategory ? 'Save Changes' : 'Add Category' }}</button>
                            @if ($editingCategory)
                                <a class="px-4 py-3 rounded-xl bg-surface-container-low text-sm font-bold text-slate-600" href="{{ route('admin.categories') }}">Cancel</a>
                            @endif
                        </div>
                    </form>

                    <div class="mt-8 bg-slate-900 text-white p-6 rounded-xl shadow-xl">
                        <h5 class="font-bold font-headline mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined">auto_awesome</span>
                            Admin Tips
                        </h5>
                        <ul class="text-xs space-y-3 opacity-80">
                            <li>Categories with no courses can be safely removed.</li>
                            <li>Renaming a category updates it everywhere without touching course design.</li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
