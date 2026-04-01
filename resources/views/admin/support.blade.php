<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Inquiries Dashboard - CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0c4ea3",
                        "primary-container": "#1570d8",
                        "background": "#f4f9ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eef5ff",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#4f6178",
                        "outline-variant": "#d5e4ff",
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
        h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
        .admin-select { appearance: none; -webkit-appearance: none; -moz-appearance: none; padding-right: 2.75rem; background-image: none; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">
    <x-admin.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="bg-white/80 backdrop-blur-md fixed top-0 right-0 left-0 md:left-64 h-16 z-40 flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
            <div class="flex items-center gap-4 flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
                <div class="relative w-full md:max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-3 md:pr-4 text-sm focus:ring-2 focus:ring-[#edf5ff]0/20 outline-none transition-all" placeholder="Search..." type="text" />
                </div>
            </div>
            <div class="ml-auto flex items-center gap-3">
                <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $admin->name }}</span>
                <img alt="{{ $admin->name }}" class="w-9 h-9 rounded-full object-cover" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="pt-24 px-4 md:px-8 pb-12">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-error-container px-4 py-3 text-sm text-on-error-container">{{ $errors->first() }}</div>
            @endif

            <div class="grid grid-cols-12 gap-6 mb-8">
                <div class="col-span-12 lg:col-span-7">
                    <h2 class="text-4xl font-extrabold font-headline tracking-tight mb-2">Inquiries Dashboard</h2>
                    <p class="text-slate-500 max-w-xl text-lg">Manage student support tickets and academic inquiries across the Curator platform.</p>
                </div>
                <div class="col-span-6 lg:col-span-2 bg-surface-container-lowest p-6 rounded-xl shadow-sm border-l-4 border-primary">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Open Tickets</p>
                    <p class="text-4xl font-bold font-headline text-primary">{{ number_format($openTickets) }}</p>
                    <p class="text-xs text-error mt-2">Live platform queue</p>
                </div>
                <div class="col-span-6 lg:col-span-3 bg-surface-container-lowest p-6 rounded-xl shadow-sm border-l-4 border-[#c7e0ff]">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Resolved this week</p>
                    <p class="text-4xl font-bold font-headline text-[#08275c]">{{ number_format($resolvedTickets) }}</p>
                    <p class="text-xs text-primary mt-2">Avg response {{ $avgResponseHours }} hours</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <section class="xl:col-span-2 bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-surface-container-low flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <h3 class="font-headline font-bold text-lg text-on-surface">Recent Submissions</h3>
                            <div class="flex gap-2">
                                <a class="px-3 py-1 {{ request('type') ? 'hover:bg-slate-200/50 text-slate-500' : 'bg-primary-container/10 text-primary' }} text-xs font-bold rounded-full transition-colors" href="{{ route('admin.support') }}">All</a>
                                <a class="px-3 py-1 {{ request('type') === 'technical' ? 'bg-primary-container/10 text-primary' : 'hover:bg-slate-200/50 text-slate-500' }} text-xs font-bold rounded-full transition-colors" href="{{ route('admin.support', ['type' => 'technical']) }}">Technical</a>
                                <a class="px-3 py-1 {{ request('type') === 'billing' ? 'bg-primary-container/10 text-primary' : 'hover:bg-slate-200/50 text-slate-500' }} text-xs font-bold rounded-full transition-colors" href="{{ route('admin.support', ['type' => 'billing']) }}">Billing</a>
                            </div>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ $inquiries->total() }} items</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low/50 border-b border-outline-variant/10">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">User</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Subject/Message</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Category</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Date</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse ($inquiries as $inquiry)
                                    @php
                                        $category = str_contains(strtolower($inquiry->message ?? ''), 'refund') || str_contains(strtolower($inquiry->message ?? ''), 'payment') ? 'Billing' : 'Technical';
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <img alt="{{ $inquiry->name }}" class="w-8 h-8 rounded-full object-cover bg-slate-100" src="{{ $inquiry->user?->avatarUrl(48) ?? 'https://placehold.co/48x48/e2e8f0/64748b?text=U' }}" />
                                                <div>
                                                    <p class="text-sm font-bold text-on-surface">{{ $inquiry->name }}</p>
                                                    <p class="text-xs text-slate-400">{{ $inquiry->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="max-w-xs">
                                                <p class="text-sm font-semibold text-on-surface truncate">{{ $inquiry->course?->title ?: 'General inquiry' }}</p>
                                                <p class="text-xs text-slate-400 truncate">{{ $inquiry->message }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5"><span class="text-xs font-medium px-2.5 py-1 rounded bg-slate-100 text-slate-600">{{ $category }}</span></td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1 rounded-full {{ $inquiry->status === 'resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-primary/10 text-primary' }} text-xs font-bold">{{ ucfirst($inquiry->status) }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-xs text-slate-500">{{ $inquiry->created_at?->format('M d, h:i A') }}</td>
                                        <td class="px-6 py-5 text-right">
                                            <a class="bg-gradient-to-br from-primary to-primary-container text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm hover:opacity-90 transition-all" href="{{ route('admin.support', ['inquiry' => $inquiry->id]) }}">Reply</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-sm text-slate-500" colspan="6">No inquiries found for this filter yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="space-y-6">
                    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-outline-variant/10">
                            <h3 class="font-headline font-bold text-lg">{{ $activeInquiry ? 'Reply to Inquiry' : 'No Inquiry Selected' }}</h3>
                        </div>
                        <div class="p-6">
                            @if ($activeInquiry)
                                <div class="mb-5">
                                    <p class="text-sm font-bold">{{ $activeInquiry->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $activeInquiry->email }}</p>
                                    <p class="text-xs text-slate-400 mt-2">{{ $activeInquiry->course?->title ?: 'General inquiry' }}</p>
                                    <p class="text-sm text-on-surface-variant mt-4 leading-relaxed">{{ $activeInquiry->message }}</p>
                                </div>

                                <form action="{{ route('admin.support.reply', $activeInquiry) }}" class="space-y-4" method="POST">
                                    @csrf
                                    <textarea class="w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="admin_reply" rows="6" placeholder="Write your reply...">{{ old('admin_reply', $activeInquiry->admin_reply) }}</textarea>
                                    <div class="relative">
                                        <select class="admin-select w-full rounded-xl bg-surface-container-low border-none px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="status">
                                            <option value="pending" @selected(old('status', $activeInquiry->status) === 'pending')>Keep Open</option>
                                            <option value="resolved" @selected(old('status', $activeInquiry->status) === 'resolved')>Mark Resolved</option>
                                        </select>
                                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                                    </div>
                                    <button class="w-full bg-gradient-to-br from-primary to-primary-container text-white px-4 py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20" type="submit">Send Reply</button>
                                </form>
                            @else
                                <p class="text-sm text-slate-500">Pick a ticket from the list to reply.</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="bg-surface-container-low p-5 rounded-xl flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#dcecff] rounded-lg flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">timer</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Avg Response Time</p>
                                <p class="text-xl font-bold font-headline text-on-surface">{{ $avgResponseHours }} Hours</p>
                            </div>
                        </div>
                        <div class="bg-surface-container-low p-5 rounded-xl flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined">forum</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Chats</p>
                                <p class="text-xl font-bold font-headline text-on-surface">{{ number_format($activeChats) }} Live</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>


