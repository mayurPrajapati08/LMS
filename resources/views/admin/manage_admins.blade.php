<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Admins | CodeInYourself</title>
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
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "primary-fixed": "#f0e6f4",
                        "on-primary-fixed-variant": "#8f52a3",
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
        .admin-select { appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 2.75rem; background-image: none; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)]">
        <div class="flex items-center flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-[#f5eef8]/20 outline-none" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="w-9 h-9 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:ml-64 pt-24 px-4 md:px-8 pb-10">
        <div class="max-w-7xl mx-auto space-y-8">
            @if (session('status'))
                <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl bg-error-container px-4 py-3 text-sm text-on-error-container">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.15em] text-primary">Super Admin Controls</span>
                    <h1 class="text-4xl font-extrabold font-headline tracking-tight">Manage Admins</h1>
                    <p class="text-on-surface-variant mt-2">Create, update, and manage platform admin access without leaving the dashboard.</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-surface-container-lowest rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Admins</p>
                        <p class="text-3xl font-extrabold font-headline">{{ number_format($adminCount) }}</p>
                    </div>
                    <div class="bg-surface-container-lowest rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Super Admins</p>
                        <p class="text-3xl font-extrabold font-headline">{{ number_format($superAdminCount) }}</p>
                    </div>
                    <div class="bg-surface-container-lowest rounded-2xl px-5 py-4 shadow-sm col-span-2">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">HR Team</p>
                        <p class="text-3xl font-extrabold font-headline">{{ number_format($hrTeamCount) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <section class="xl:col-span-2 bg-surface-container-lowest rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-outline-variant/20 flex items-center justify-between">
                        <h2 class="text-lg font-bold font-headline">Admin Directory</h2>
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ number_format($admins->total()) }} total</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-surface-container-low/50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Admin</th>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Role</th>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Joined</th>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse ($admins as $managedAdmin)
                                    <tr class="hover:bg-surface-container-low/40 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <img alt="{{ $managedAdmin->name }}" class="w-10 h-10 rounded-full object-cover" src="{{ $managedAdmin->avatarUrl(80) }}" />
                                                <div>
                                                    <p class="text-sm font-bold">{{ $managedAdmin->name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $managedAdmin->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest {{ $managedAdmin->role?->name === 'super admin' ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $managedAdmin->role?->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-slate-500">{{ $managedAdmin->created_at?->format('M d, Y') }}</td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center justify-end gap-2">
                                                <a class="px-3 py-2 text-xs font-bold text-primary hover:bg-primary/5 rounded-lg" href="{{ route('admin.admins', ['edit' => $managedAdmin->id]) }}">Edit</a>
                                                @if (! $admin->is($managedAdmin))
                                                    <form action="{{ route('admin.admins.destroy', $managedAdmin) }}" class="admin-delete-form" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="current_password" />
                                                        <button class="px-3 py-2 text-xs font-bold text-error hover:bg-error-container/60 rounded-lg" type="submit">Remove</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-sm text-slate-500 text-center" colspan="4">No admin accounts found yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-outline-variant/10 flex items-center justify-between">
                        <p class="text-xs text-slate-500">Showing {{ $admins->firstItem() ?? 0 }} to {{ $admins->lastItem() ?? 0 }} of {{ $admins->total() }} admins</p>
                        <div class="flex items-center gap-2">
                            @for ($page = 1; $page <= min(3, $admins->lastPage()); $page++)
                                <a class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold {{ $admins->currentPage() === $page ? 'bg-primary text-white' : 'bg-surface-container-low text-slate-600' }}" href="{{ $admins->url($page) }}">{{ $page }}</a>
                            @endfor
                        </div>
                    </div>
                </section>

                <section class="bg-surface-container-lowest rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-outline-variant/20">
                        <h2 class="text-lg font-bold font-headline">{{ $editingAdmin ? 'Edit Admin Account' : 'Add New Admin' }}</h2>
                    </div>

                    <form class="p-6 space-y-5" method="POST" action="{{ $editingAdmin ? route('admin.admins.update', $editingAdmin) : route('admin.admins.store') }}">
                        @csrf
                        @if ($editingAdmin)
                            @method('PUT')
                        @endif

                        <div class="rounded-2xl border border-outline-variant/30 bg-primary-fixed/40 px-4 py-4 text-sm text-slate-600">
                            New privileged accounts are now provisioned securely. No password will be emailed; the user will set their own password through the recovery flow.
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-slate-400">Full Name</label>
                            <input class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="name" type="text" value="{{ old('name', $editingAdmin->name ?? '') }}" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-slate-400">Email Address</label>
                            <input class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="email" type="email" value="{{ old('email', $editingAdmin->email ?? '') }}" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-slate-400">Role</label>
                            <div class="relative">
                                <select class="admin-select w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="role">
                                    <option value="admin" @selected(old('role', $editingAdmin?->role?->name ?? 'admin') === 'admin')>Admin</option>
                                    <option value="hr team" @selected(old('role', $editingAdmin?->role?->name) === 'hr team')>HR Team</option>
                                    <option value="super admin" @selected(old('role', $editingAdmin?->role?->name) === 'super admin')>Super Admin</option>
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-slate-400">Your Current Password</label>
                            <input class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="current_password" type="password" />
                            <p class="text-xs text-slate-500">Required to create, update, or remove privileged accounts.</p>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button class="flex-1 rounded-xl bg-gradient-to-br from-primary to-primary-container px-4 py-3 text-sm font-bold text-white shadow-lg shadow-primary/20" type="submit">
                                {{ $editingAdmin ? 'Save Changes' : 'Create Admin' }}
                            </button>
                            @if ($editingAdmin)
                                <a class="rounded-xl bg-surface-container-low px-4 py-3 text-sm font-bold text-slate-600" href="{{ route('admin.admins') }}">Cancel</a>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll('.admin-delete-form').forEach((form) => {
            form.addEventListener('submit', (event) => {
                const password = window.prompt('Enter your current password to remove this admin account.');

                if (!password) {
                    event.preventDefault();
                    return;
                }

                const input = form.querySelector('input[name="current_password"]');

                if (input) {
                    input.value = password;
                }
            });
        });
    </script>
</body>
</html>




