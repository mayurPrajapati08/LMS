<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Management | CodeInYourself</title>
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
                        "surface-container-highest": "#e7dcef",
                        "on-surface": "#191c1d",
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
        <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full pl-10 pr-3 md:pr-4 py-2 bg-slate-100 border-none rounded-full text-sm focus:ring-2 focus:ring-[#f5eef8]/20 outline-none" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-on-surface">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="w-8 h-8 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-4 md:p-8 max-w-7xl mx-auto">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Management Dashboard</span>
                    <h1 class="text-4xl font-extrabold font-headline tracking-tight">Instructor Management</h1>
                    <p class="text-sm text-slate-500">Invite new instructors and manage the existing teaching roster from one place.</p>
                </div>
                <a class="bg-gradient-to-br from-primary to-primary-container text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2 shadow-lg shadow-primary/20" href="{{ route('admin.instructors', ['invite' => 1]) }}">
                    <span class="material-symbols-outlined">person_add</span>
                    Invite Instructor
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-surface-container-lowest p-6 rounded-xl border-none">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Instructors</p>
                    <h2 class="text-3xl font-headline font-bold">{{ number_format($totalInstructors) }}</h2>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border-none">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Platform Payouts</p>
                    <h2 class="text-3xl font-headline font-bold">Rs. {{ number_format($platformPayouts, 0) }}</h2>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border-none">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Verification Rate</p>
                    <h2 class="text-3xl font-headline font-bold">{{ number_format($verificationRate, 1) }}%</h2>
                </div>
            </div>

            @if ($showInvitePanel)
                <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden mb-10">
                    <div class="bg-surface-container-highest/30 px-6 py-4 border-none flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-headline font-bold">Invite Instructor</h3>
                            <p class="text-sm text-slate-500 mt-1">Create a new instructor account without leaving the instructor management page.</p>
                        </div>
                        <a class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400 hover:text-primary" href="{{ route('admin.instructors') }}">Close</a>
                    </div>

                    <form action="{{ route('admin.instructors.store') }}" class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-5" method="POST">
                        @csrf

                        <div class="lg:col-span-2 rounded-2xl bg-slate-50 px-4 py-4 text-sm text-slate-600">
                            Instructor accounts are created without sending a password by email. The instructor will receive a secure setup email and create their own password through the recovery flow.
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Full Name</label>
                            <input class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none" name="name" type="text" value="{{ old('name') }}" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Email Address</label>
                            <input class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none" name="email" type="email" value="{{ old('email') }}" />
                        </div>

                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Bio</label>
                            <textarea class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none min-h-[110px]" name="bio" placeholder="Short introduction for the instructor profile.">{{ old('bio') }}</textarea>
                        </div>

                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Your Current Password</label>
                            <input class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none" name="current_password" type="password" />
                            <p class="text-xs text-slate-500">Required before a new instructor account can be provisioned.</p>
                        </div>

                        <div class="lg:col-span-2 flex items-center gap-3 pt-1">
                            <button class="bg-gradient-to-br from-primary to-primary-container text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2 shadow-lg shadow-primary/20" type="submit">
                                <span class="material-symbols-outlined">how_to_reg</span>
                                Create Instructor
                            </button>
                            <a class="px-5 py-3 rounded-xl bg-surface-container-low text-sm font-semibold text-slate-600" href="{{ route('admin.instructors') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                <div class="bg-surface-container-highest/30 px-6 py-4 border-none flex items-center justify-between">
                    <h3 class="text-lg font-headline font-bold">Instructor Directory</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ $instructors->total() }} records</span>
                        <a class="text-xs font-bold uppercase tracking-[0.15em] text-primary hover:text-primary-container" href="{{ route('admin.instructors', ['invite' => 1]) }}">Invite Instructor</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-slate-500 text-[10px] uppercase tracking-[0.15em]">
                                <th class="px-6 py-4 font-semibold">Instructor Profile</th>
                                <th class="px-6 py-4 font-semibold">Email</th>
                                <th class="px-6 py-4 font-semibold">Total Courses</th>
                                <th class="px-6 py-4 font-semibold">Total Earnings</th>
                                <th class="px-6 py-4 font-semibold">Rating</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/10">
                            @forelse ($instructors as $instructor)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <img alt="{{ $instructor->name }}" class="w-10 h-10 rounded-full object-cover" src="{{ $instructor->avatarUrl(80) }}" />
                                            <div>
                                                <p class="font-bold text-on-surface text-sm">{{ $instructor->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $instructor->directory_status_hint }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600">{{ $instructor->email }}</td>
                                    <td class="px-6 py-5 text-sm font-semibold text-on-surface">{{ number_format($instructor->courses_count) }}</td>
                                    <td class="px-6 py-5 font-bold text-on-surface text-sm">Rs. {{ number_format($instructor->total_earnings, 0) }}</td>
                                    <td class="px-6 py-5 text-sm font-bold">{{ number_format($instructor->average_rating ?? 0, 1) }}</td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $instructor->directory_status_classes }}">{{ $instructor->directory_status_label }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-8 text-center text-sm text-slate-500" colspan="6">No instructors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>




