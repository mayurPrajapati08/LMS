<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#3b5f8d",
                        "surface-tint": "#1570d8",
                        "inverse-on-surface": "#f5fbff",
                        "secondary-fixed": "#e8f3ff",
                        "on-primary-fixed": "#0f0069",
                        "error-container": "#ffdad6",
                        "tertiary": "#005523",
                        "tertiary-container": "#007030",
                        "on-secondary-fixed-variant": "#315b90",
                        "tertiary-fixed": "#6bff8f",
                        "secondary-fixed-dim": "#b9dcff",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#0a4b99",
                        "error": "#ba1a1a",
                        "surface-container-low": "#eef5ff",
                        "secondary-container": "#d7e9ff",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#b9dcff",
                        "outline-variant": "#d5e4ff",
                        "on-surface": "#191c1d",
                        "surface-dim": "#d4e3f8",
                        "on-secondary-fixed": "#072a60",
                        "inverse-primary": "#b9dcff",
                        "on-surface-variant": "#4f6178",
                        "tertiary-fixed-dim": "#4ae176",
                        "on-primary-container": "#edf5ff",
                        "inverse-surface": "#18345f",
                        "outline": "#7c8da7",
                        "primary-container": "#1570d8",
                        "on-background": "#191c1d",
                        "surface-container-high": "#e3eeff",
                        "surface-container": "#e9f2ff",
                        "on-tertiary-fixed-variant": "#005321",
                        "primary-fixed": "#e8f3ff",
                        "surface-bright": "#f4f9ff",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-container": "#63f889",
                        "surface-container-highest": "#dbe8ff",
                        "on-error-container": "#93000a",
                        "background": "#f4f9ff",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#0c4ea3",
                        "on-secondary-container": "#41648d",
                        "surface-variant": "#dbe8ff",
                        "on-secondary": "#ffffff",
                        "surface": "#f4f9ff"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
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
            background-color: #f4f9ff;
        }
    </style>
</head>

<body class="text-on-surface">
    <x-student.navbar />

    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 shadow-sm">
        <div class="flex items-center gap-4">
            <h1 class="font-headline font-bold text-xl text-on-surface">Messages &amp; Support</h1>
        </div>
        <div class="ml-auto flex items-center gap-4 md:gap-6">
            <form action="{{ route('student.support') }}" class="relative block group w-full max-w-[10rem] sm:max-w-[12rem] md:max-w-none" method="GET">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <span class="material-symbols-outlined text-lg">search</span>
                </span>
                <input class="pl-10 pr-3 md:pr-4 py-2 bg-surface-container-low border-none rounded-xl text-sm w-full md:w-64 focus:ring-2 focus:ring-primary/20 transition-all outline-none" name="search" placeholder="Search..." type="text" value="{{ $search }}" />
            </form>
            <div class="flex items-center gap-3">
                <button class="p-2 text-slate-500 hover:text-[#0c4ea3] transition-colors" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <img alt="Student Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#dcecff]" src="{{ $studentAvatar }}" />
            </div>
        </div>
    </header>

    <main class="md:ml-64 pt-16 min-h-screen lg:h-screen flex flex-col overflow-hidden bg-background">
        <div class="flex-1 flex flex-col lg:flex-row overflow-hidden p-4 md:p-6 gap-6">
            <section class="w-full lg:w-1/3 flex flex-col gap-4 bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                <div class="p-5 border-b border-surface-container">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-headline font-bold text-lg">Active Inquiries</h2>
                        <a class="flex items-center gap-1 text-xs font-bold text-primary px-3 py-1.5 bg-primary-fixed rounded-lg" href="#new-ticket">
                            <span class="material-symbols-outlined text-sm">add</span> NEW TICKET
                        </a>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <a @class([
                            'px-3 py-1 text-xs font-bold rounded-full',
                            'bg-primary-container text-white' => $statusFilter === 'all',
                            'bg-surface-container-high text-on-surface-variant' => $statusFilter !== 'all',
                        ]) href="{{ route('student.support', ['search' => $search, 'status' => 'all']) }}">All</a>
                        <a @class([
                            'px-3 py-1 text-xs font-bold rounded-full',
                            'bg-primary-container text-white' => $statusFilter === 'open',
                            'bg-surface-container-high text-on-surface-variant' => $statusFilter !== 'open',
                        ]) href="{{ route('student.support', ['search' => $search, 'status' => 'open']) }}">Open</a>
                        <a @class([
                            'px-3 py-1 text-xs font-bold rounded-full',
                            'bg-primary-container text-white' => $statusFilter === 'resolved',
                            'bg-surface-container-high text-on-surface-variant' => $statusFilter !== 'resolved',
                        ]) href="{{ route('student.support', ['search' => $search, 'status' => 'resolved']) }}">Resolved</a>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto px-2 space-y-2">
                    @forelse ($inquiries as $inquiry)
                        <a @class([
                            'block p-4 rounded-xl transition-all cursor-pointer',
                            'bg-surface-container-low border-l-4 border-primary' => $activeInquiry && $activeInquiry->id === $inquiry->id,
                            'hover:bg-surface-container-low' => ! ($activeInquiry && $activeInquiry->id === $inquiry->id),
                        ]) href="{{ route('student.support', ['inquiry' => $inquiry->id, 'search' => $search, 'status' => $statusFilter]) }}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold tracking-widest uppercase {{ $inquiry->status === 'pending' ? 'text-primary' : 'text-slate-400' }}">{{ $inquiry->course?->title ?: 'Support' }}</span>
                                <span @class([
                                    'px-2 py-0.5 text-[10px] font-bold rounded-md',
                                    'bg-tertiary/10 text-tertiary' => $inquiry->status === 'pending',
                                    'bg-slate-100 text-slate-500' => $inquiry->status === 'resolved',
                                ])>{{ strtoupper($inquiry->status === 'pending' ? 'OPEN' : 'RESOLVED') }}</span>
                            </div>
                            <h3 class="font-bold text-sm mb-1">{{ \Illuminate\Support\Str::limit($inquiry->message, 48) }}</h3>
                            <p class="text-xs text-on-surface-variant line-clamp-1 mb-3">{{ $inquiry->admin_reply ?: 'Waiting for support team reply.' }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <img class="w-6 h-6 rounded-full object-cover" src="{{ $studentAvatar }}" />
                                    <span class="text-[10px] text-slate-400">{{ $inquiry->name }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400">{{ optional($inquiry->created_at)->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-sm text-on-surface-variant">
                            No inquiries found yet.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="flex-1 flex flex-col bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden relative">
                @if ($activeInquiry)
                    <div class="px-6 py-4 flex items-center justify-between border-b border-surface-container">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary font-bold">
                                {{ collect(explode(' ', $activeInquiry->name))->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('') ?: 'SU' }}
                            </div>
                            <div>
                                <h2 class="font-headline font-bold text-sm">{{ \Illuminate\Support\Str::limit($activeInquiry->message, 60) }}</h2>
                                <p class="text-xs text-on-surface-variant">{{ $activeInquiry->name }} • Ticket #{{ $activeInquiry->id }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="p-2 hover:bg-surface-container-low rounded-lg text-slate-500" type="button">
                                <span class="material-symbols-outlined">flag</span>
                            </button>
                            <span @class([
                                'px-4 py-2 text-xs font-bold rounded-xl',
                                'text-tertiary border border-tertiary/20' => $activeInquiry->status === 'pending',
                                'text-slate-500 border border-slate-200' => $activeInquiry->status === 'resolved',
                            ])>
                                {{ $activeInquiry->status === 'pending' ? 'Open Ticket' : 'Resolved Ticket' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6 space-y-8">
                        <div class="flex gap-4 max-w-2xl">
                            <img class="w-8 h-8 rounded-lg object-cover" src="{{ $studentAvatar }}" />
                            <div>
                                <div class="flex items-baseline gap-3 mb-1">
                                    <span class="text-sm font-bold">{{ $activeInquiry->name }}</span>
                                    <span class="text-[10px] text-slate-400">{{ optional($activeInquiry->created_at)->format('h:i A') }}</span>
                                </div>
                                <div class="bg-surface-container-low p-4 rounded-r-xl rounded-bl-xl text-sm leading-relaxed text-on-surface">
                                    {{ $activeInquiry->message }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <span class="px-4 py-1 bg-surface-container text-[10px] font-bold text-on-surface-variant rounded-full tracking-wider uppercase">
                                {{ $activeInquiry->status === 'resolved' ? 'Ticket resolved by support team' : 'Support reviewing your inquiry' }}
                            </span>
                        </div>

                        @if ($activeInquiry->admin_reply)
                            <div class="flex gap-4 max-w-2xl ml-auto flex-row-reverse">
                                <div class="w-8 h-8 rounded-lg bg-[#0c4ea3] flex items-center justify-center text-white text-[10px] font-bold">TS</div>
                                <div class="text-right">
                                    <div class="flex items-baseline justify-end gap-3 mb-1">
                                        <span class="text-[10px] text-slate-400">{{ optional($activeInquiry->updated_at)->format('h:i A') }}</span>
                                        <span class="text-sm font-bold text-primary">Support Team</span>
                                    </div>
                                    <div class="bg-primary p-4 rounded-l-xl rounded-br-xl text-sm leading-relaxed text-white">
                                        {{ $activeInquiry->admin_reply }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center p-10 text-center">
                        <div>
                            <h2 class="font-headline text-2xl font-bold text-on-surface">No support conversation selected</h2>
                            <p class="mt-2 text-sm text-on-surface-variant">Create a ticket below and your message will appear here once submitted.</p>
                        </div>
                    </div>
                @endif

                <div class="p-6 bg-white border-t border-surface-container" id="new-ticket">
                    <form action="{{ route('student.support.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <select class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/10" name="course_id">
                                <option value="">Choose a course for this ticket</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="mt-2 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative bg-surface-container-low rounded-2xl p-2 focus-within:ring-2 focus-within:ring-primary/10 transition-all">
                            <textarea class="w-full bg-transparent border-none focus:ring-0 p-4 text-sm min-h-[100px] resize-none" name="message" placeholder="Type your support request here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="px-4 pb-2 text-xs text-error">{{ $message }}</p>
                            @enderror
                            <div class="flex items-center justify-between px-4 pb-2">
                                <div class="flex items-center gap-2">
                                    <button class="p-2 text-slate-500 hover:bg-white rounded-lg transition-all" type="button">
                                        <span class="material-symbols-outlined">attach_file</span>
                                    </button>
                                    <button class="p-2 text-slate-500 hover:bg-white rounded-lg transition-all" type="button">
                                        <span class="material-symbols-outlined">mood</span>
                                    </button>
                                    <button class="p-2 text-slate-500 hover:bg-white rounded-lg transition-all" type="button">
                                        <span class="material-symbols-outlined">image</span>
                                    </button>
                                </div>
                                <button class="bg-primary text-white px-6 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95" type="submit">
                                    Send Message
                                    <span class="material-symbols-outlined text-sm">send</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>

