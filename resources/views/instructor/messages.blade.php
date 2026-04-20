<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Messages</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#b07ac3",
                        "outline-variant": "#dbcde4",
                        "secondary-container": "#eadcf1",
                        "background": "#fcf9fe",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#6d5a76",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#8f7a99",
                        "on-secondary-fixed-variant": "#755b83",
                        "on-primary-fixed-variant": "#8f52a3",
                        "surface-tint": "#b07ac3",
                        "on-primary-container": "#f5eef8",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f5fbff",
                        "primary": "#6a3378",
                        "surface-bright": "#fcf9fe",
                        "secondary-fixed": "#f0e6f4",
                        "primary-fixed-dim": "#e1cde8",
                        "primary-fixed": "#f0e6f4",
                        "error": "#ba1a1a",
                        "surface-variant": "#e7dcef",
                        "secondary-fixed-dim": "#e1cde8",
                        "surface": "#fcf9fe",
                        "on-error": "#ffffff",
                        "surface-container-high": "#efe5f4",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#e7dcef",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#f5eef8",
                        "secondary": "#3b5f8d",
                        "inverse-surface": "#563060",
                        "surface-container": "#f2e9f6",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#e1cde8",
                        "surface-dim": "#d4e3f8",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#715f7a",
                        "on-secondary-fixed": "#4b2356"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; background: #fcf9fe; color: #191c1d; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d7dbe1; border-radius: 999px; }
    </style>
</head>
<body class="bg-background text-on-background antialiased">
    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen flex flex-col">
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md pl-16 pr-4 md:px-8 py-4 shadow-sm flex justify-between items-center">
            <div>
                <h1 class="font-headline text-3xl font-bold tracking-tight text-slate-900">Messages</h1>
                <p class="mt-1 text-sm text-slate-500">Student inquiries across your courses.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:block rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">{{ $openCount }} open</div>
                <img alt="Instructor Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#eadff1]" src="{{ $profileAvatar }}" />
            </div>
        </header>

        <div class="flex-1 p-4 md:p-8 flex flex-col xl:flex-row gap-6">
            <section class="w-full xl:w-[24rem] rounded-[28px] bg-white border border-slate-200 editorial-shadow overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h2 class="font-headline text-2xl font-bold text-slate-900">Inbox</h2>
                        <span class="rounded-full bg-[#f5eef8] px-3 py-1 text-xs font-semibold text-[#6a3378]">{{ $inquiries->count() }}</span>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Open {{ $openCount }}</span>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Resolved {{ $resolvedCount }}</span>
                    </div>
                </div>

                <div class="max-h-[28rem] overflow-y-auto custom-scrollbar p-4 space-y-3 xl:max-h-[calc(100vh-15rem)]">
                    @forelse($inquiries as $inquiry)
                        <a class="block rounded-2xl border px-4 py-4 transition-all {{ $activeInquiry && $activeInquiry->id === $inquiry->id ? 'border-[#c7e0ff] bg-[#f5eef8]/70' : 'border-slate-200 bg-slate-50/60 hover:bg-slate-50' }}" href="{{ route('instructor.messages', ['inquiry' => $inquiry->id]) }}">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#6a3378]">{{ $inquiry->course?->title ?? 'Unknown Course' }}</p>
                                    <p class="mt-2 font-semibold text-slate-900">{{ $inquiry->name }}</p>
                                    <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-slate-500">{{ $inquiry->message ?: 'No message body provided.' }}</p>
                                </div>
                                <span class="rounded-full px-2 py-1 text-[0.65rem] font-bold uppercase {{ $inquiry->status === 'resolved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($inquiry->status) }}</span>
                            </div>
                            <p class="mt-3 text-[0.7rem] font-medium text-slate-400">{{ $inquiry->created_at?->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-16 text-center text-sm text-slate-500">No inquiries yet.</div>
                    @endforelse
                </div>
            </section>

            <section class="flex-1 rounded-[32px] bg-white border border-slate-200 editorial-shadow overflow-hidden">
                @if(session('status'))
                    <div class="mx-6 mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
                @endif

                @if($activeInquiry)
                    <div class="px-6 md:px-8 py-6 border-b border-slate-200 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex min-w-0 items-center gap-4">
                            <img alt="Student Avatar" class="w-12 h-12 rounded-full object-cover" src="{{ $activeInquiry->user?->avatarUrl(96) ?? 'https://ui-avatars.com/api/?name='.urlencode($activeInquiry->name).'&background=E2E8F0&color=334155&size=96' }}" />
                            <div class="min-w-0">
                                <h3 class="font-headline text-2xl font-bold text-slate-900">{{ $activeInquiry->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ $activeInquiry->email }} • {{ $activeInquiry->course?->title ?? 'Unknown Course' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] {{ $activeInquiry->status === 'resolved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($activeInquiry->status) }}</span>
                    </div>

                    <div class="p-6 md:p-8 space-y-8">
                        <div class="rounded-[24px] bg-slate-50 border border-slate-200 p-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#6a3378]">Student Message</p>
                            <p class="mt-4 text-sm leading-7 text-slate-600">{{ $activeInquiry->message ?: 'No message body provided.' }}</p>
                            <p class="mt-4 text-xs font-medium text-slate-400">{{ $activeInquiry->created_at?->format('M d, Y h:i A') }}</p>
                        </div>

                        @if($activeInquiry->admin_reply)
                            <div class="rounded-[24px] bg-[#f5eef8] border border-[#eadff1] p-6">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#6a3378]">Your Reply</p>
                                <p class="mt-4 text-sm leading-7 text-slate-700">{{ $activeInquiry->admin_reply }}</p>
                                <p class="mt-4 text-xs font-medium text-slate-400">Status: {{ ucfirst($activeInquiry->status) }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('instructor.messages.reply', $activeInquiry) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Reply</label>
                                <textarea class="mt-2 w-full rounded-[24px] border {{ $errors->has('admin_reply') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-5 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1] resize-none" name="admin_reply" rows="6" placeholder="Write a clear response for the student...">{{ old('admin_reply', $activeInquiry->admin_reply) }}</textarea>
                                @error('admin_reply')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                                    <input class="h-4 w-4 rounded border-slate-300 text-[#6a3378] focus:ring-[#f5eef8]0" type="checkbox" name="status" value="resolved" {{ old('status', $activeInquiry->status) === 'resolved' ? 'checked' : '' }} />
                                    Mark this inquiry as resolved
                                </label>
                                <button class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200/50 hover:opacity-90 transition-all" type="submit">
                                    <span>Send Reply</span>
                                    <span class="material-symbols-outlined text-[1.05rem]">send</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-10 text-center text-sm text-slate-500">No inquiry selected yet.</div>
                @endif
            </section>
        </div>
    </main>
</body>
</html>



