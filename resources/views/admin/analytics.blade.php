<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Analytics Hub | Academic Curator</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3525cd",
                        "secondary": "#58579b",
                        "tertiary": "#7e3000",
                        "background": "#f8f9fa",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f3f4f5",
                        "surface-container-high": "#e7e8e9",
                        "on-surface": "#191c1d",
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
        .primary-gradient { background: linear-gradient(135deg, #3525cd 0%, #4f46e5 100%); }
    </style>
</head>
<body class="bg-surface text-on-surface">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
        <div class="flex items-center gap-4 w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none md:w-1/3">
            <div class="relative w-full md:max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="h-8 w-8 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-4 md:p-8 max-w-[1600px] mx-auto space-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span class="text-xs uppercase tracking-widest text-primary font-bold">System Performance</span>
                    <h2 class="text-4xl font-headline font-bold mt-1">Analytics Hub</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-slate-500 uppercase tracking-wider">Monthly Revenue</p>
                    <h3 class="text-3xl font-headline font-bold mt-1">Rs. {{ number_format($monthlyRevenue, 0) }}</h3>
                    <p class="text-xs mt-3 {{ $revenueChange >= 0 ? 'text-emerald-600' : 'text-red-600' }}">{{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}% vs last month</p>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-slate-500 uppercase tracking-wider">Active Learners</p>
                    <h3 class="text-3xl font-headline font-bold mt-1">{{ number_format($activeLearners) }}</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-slate-500 uppercase tracking-wider">Conversion Rate</p>
                    <h3 class="text-3xl font-headline font-bold mt-1">{{ number_format($conversionRate, 2) }}%</h3>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-slate-500 uppercase tracking-wider">User Retention</p>
                    <h3 class="text-3xl font-headline font-bold mt-1">{{ number_format($userRetention, 1) }}%</h3>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 lg:col-span-6 bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-headline font-bold mb-8">Performance by Category</h3>
                    <div class="space-y-6">
                        @forelse ($categoryPerformance as $category)
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm font-medium">
                                    <span>{{ $category['name'] }}</span>
                                    <span class="text-slate-500">{{ $category['score'] }}%</span>
                                </div>
                                <div class="h-3 bg-slate-100 rounded-full">
                                    <div class="h-full primary-gradient rounded-full" style="width: {{ max(4, $category['score']) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Category performance data will appear here.</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-6 bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-headline font-bold">Top Selling Courses</h3>
                        <a class="text-sm text-primary font-bold hover:underline" href="{{ route('admin.courses') }}">View All</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($topSellingCourses as $course)
                            <div class="py-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-lg overflow-hidden bg-slate-100">
                                        <img alt="{{ $course->title }}" class="h-full w-full object-cover" src="{{ $course->thumbnail ?: 'https://placehold.co/96x96/e5e7eb/64748b?text=Course' }}" />
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm">{{ $course->title }}</p>
                                        <p class="text-xs text-slate-500">Instructor: {{ $course->user?->name ?: 'Instructor' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm">Rs. {{ number_format($course->completed_revenue ?? 0, 0) }}</p>
                                    <p class="text-xs text-emerald-600 font-medium">{{ number_format($course->enrollments_count) }} Sales</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No course sales data yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4 bg-surface-container-lowest p-4 md:p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-headline font-bold mb-6">Traffic Sources</h3>
                    <div class="space-y-4">
                        @foreach ($trafficSources as $source)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full {{ $source['class'] }}"></span>
                                    {{ $source['label'] }}
                                </div>
                                <span class="font-bold">{{ $source['value'] }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
