<x-student.layout title="Support | CodeInYourself">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Help Desk</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">Messages &amp; Support</p>
    </div>
    <x-slot:center>
        <form action="{{ route('student.support') }}" method="GET">
            <label class="student-top-search">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input name="search" placeholder="Search support tickets" type="text" value="{{ $search }}" />
            </label>
        </form>
    </x-slot:center>
    <x-slot:right>
        <img alt="Student Profile" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $studentAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Help Desk</p>
                <h1 class="student-page-title">Messages &amp; Support</h1>
                <p class="student-page-copy">Support is now arranged as a cleaner split workspace so tickets and replies are easier to scan.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $inquiries->count() }} visible tickets</span>
                <span class="student-chip">{{ strtoupper($statusFilter) }} filter active</span>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">Open View</p>
                        <p class="student-stat-value">{{ $inquiries->count() }}</p>
                        <p class="student-stat-copy">Tickets in this filter</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Filter</p>
                        <p class="student-stat-value">{{ strtoupper($statusFilter) }}</p>
                        <p class="student-stat-copy">Current support state</p>
                    </div>
                </div>
            </div>
            <div class="student-side-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Create Ticket</p>
                <p class="mt-4 text-sm leading-7 text-on-surface-variant">Open a new support thread for one of your courses and keep the conversation visible in the same workspace.</p>
                <a class="student-pill-button student-pill-button--primary mt-8" href="#new-ticket">New Ticket</a>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[340px_minmax(0,1fr)]">
            <section class="rounded-[1.2rem] bg-surface-container-lowest p-4">
                <div class="border-b border-surface-container px-2 pb-4">
                    <h2 class="font-headline text-xl font-extrabold text-on-surface">Active Inquiries</h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a @class(['rounded-[0.9rem] px-4 py-2 text-xs font-bold transition-all','bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_26px_rgba(149,85,246,0.2)]' => $statusFilter === 'all','bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' => $statusFilter !== 'all']) href="{{ route('student.support', ['search' => $search, 'status' => 'all']) }}">All</a>
                        <a @class(['rounded-[0.9rem] px-4 py-2 text-xs font-bold transition-all','bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_26px_rgba(149,85,246,0.2)]' => $statusFilter === 'open','bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' => $statusFilter !== 'open']) href="{{ route('student.support', ['search' => $search, 'status' => 'open']) }}">Open</a>
                        <a @class(['rounded-[0.9rem] px-4 py-2 text-xs font-bold transition-all','bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] text-white shadow-[0_14px_26px_rgba(149,85,246,0.2)]' => $statusFilter === 'resolved','bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' => $statusFilter !== 'resolved']) href="{{ route('student.support', ['search' => $search, 'status' => 'resolved']) }}">Resolved</a>
                    </div>
                </div>
                <div class="max-h-[26rem] space-y-3 overflow-y-auto p-2 xl:max-h-[700px]">
                    @forelse ($inquiries as $inquiry)
                        <a @class([
                            'block rounded-[1.2rem] p-4 transition-all',
                            'bg-surface-container-low ring-1 ring-[#e8defb]' => $activeInquiry && $activeInquiry->id === $inquiry->id,
                            'hover:bg-surface-container-low' => !($activeInquiry && $activeInquiry->id === $inquiry->id),
                        ]) href="{{ route('student.support', ['inquiry' => $inquiry->id, 'search' => $search, 'status' => $statusFilter]) }}">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] {{ $inquiry->status === 'pending' ? 'text-primary' : 'text-on-surface-variant' }}">{{ $inquiry->course?->title ?: 'Support' }}</p>
                                    <h3 class="mt-2 text-sm font-bold text-on-surface">{{ \Illuminate\Support\Str::limit($inquiry->message, 48) }}</h3>
                                </div>
                                <span class="rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] {{ $inquiry->status === 'pending' ? 'bg-tertiary-fixed text-on-tertiary-fixed-variant' : 'bg-surface-container-high text-on-surface-variant' }}">{{ $inquiry->status === 'pending' ? 'Open' : 'Resolved' }}</span>
                            </div>
                            <p class="mt-3 text-xs text-on-surface-variant">{{ $inquiry->admin_reply ?: 'Waiting for support team reply.' }}</p>
                            <p class="mt-3 text-[10px] uppercase tracking-[0.14em] text-on-surface-variant">{{ optional($inquiry->created_at)->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="p-6 text-center text-sm text-on-surface-variant">No inquiries found yet.</div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-[1.2rem] bg-surface-container-lowest overflow-hidden">
                @if ($activeInquiry)
                    <div class="border-b border-surface-container px-6 py-5">
                        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-on-surface-variant">Ticket #{{ $activeInquiry->id }}</p>
                                <h2 class="mt-2 font-headline text-2xl font-extrabold text-on-surface">{{ \Illuminate\Support\Str::limit($activeInquiry->message, 60) }}</h2>
                            </div>
                            <span class="rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] {{ $activeInquiry->status === 'pending' ? 'bg-tertiary-fixed text-on-tertiary-fixed-variant' : 'bg-surface-container-high text-on-surface-variant' }}">{{ $activeInquiry->status === 'pending' ? 'Open Ticket' : 'Resolved Ticket' }}</span>
                        </div>
                    </div>
                    <div class="space-y-8 p-6">
                        <div class="max-w-2xl">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-on-surface-variant">{{ optional($activeInquiry->created_at)->format('M d, Y h:i A') }}</p>
                            <div class="mt-3 rounded-[1.4rem] bg-surface-container-low p-5 text-sm leading-7 text-on-surface">{{ $activeInquiry->message }}</div>
                        </div>
                        @if ($activeInquiry->admin_reply)
                            <div class="ml-auto max-w-2xl">
                                <p class="text-right text-xs font-bold uppercase tracking-[0.14em] text-on-surface-variant">{{ optional($activeInquiry->updated_at)->format('M d, Y h:i A') }}</p>
                                <div class="mt-3 rounded-[1.2rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] p-5 text-sm leading-7 text-white shadow-[0_16px_30px_rgba(149,85,246,0.2)]">{{ $activeInquiry->admin_reply }}</div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex min-h-[320px] items-center justify-center p-10 text-center">
                        <div>
                            <h2 class="font-headline text-[1.9rem] font-extrabold text-on-surface">No support conversation selected</h2>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">Create a ticket below and your message will appear here once submitted.</p>
                        </div>
                    </div>
                @endif

                <div class="border-t border-surface-container p-6" id="new-ticket">
                    <form action="{{ route('student.support.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="course_id">
                                <option value="">Choose a course for this ticket</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="mt-2 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="rounded-[1.5rem] bg-surface-container-low p-3">
                            <textarea class="min-h-[120px] w-full resize-none rounded-[1rem] border-none bg-transparent p-3 text-sm" name="message" placeholder="Type your support request here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="px-3 pb-2 text-xs text-error">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-end pt-2">
                                <button class="student-pill-button student-pill-button--primary" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>
</x-student.layout>
