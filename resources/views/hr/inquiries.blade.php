@php
    $topicMeta = match ($filterTopic) {
        'career' => ['eyebrow' => 'Career Pipeline', 'title' => 'Career inquiries', 'pageTitle' => 'Career Leads'],
        'workshop' => ['eyebrow' => 'Workshop Pipeline', 'title' => 'Workshop registrations', 'pageTitle' => 'Workshop Leads'],
        'mentorship' => ['eyebrow' => 'Mentorship Team Queue', 'title' => 'Free mentorship leads', 'pageTitle' => 'Mentorship Leads'],
        'general' => ['eyebrow' => 'General Inquiries', 'title' => 'General public inquiries', 'pageTitle' => 'General Inquiries'],
        'offline_course_lead' => ['eyebrow' => 'Offline Course Leads', 'title' => 'Offline batch unlock requests', 'pageTitle' => 'Offline Course Leads'],
        'course_detail_lead' => ['eyebrow' => 'Online Course Leads', 'title' => 'Online course unlock requests', 'pageTitle' => 'Online Course Leads'],
        default => ['eyebrow' => 'Lead Management', 'title' => 'Student and public inquiries', 'pageTitle' => 'Public Inquiries'],
    };

    $visibleContacts = $contacts->getCollection();
    $newCount = $visibleContacts->where('status', 'new')->count();
    $followUpCount = $visibleContacts->where('status', 'follow_up')->count();
    $assignedCount = $visibleContacts->filter(fn ($contact) => filled($contact->assigned_to))->count();
    $displayTimezone = $displayTimezone ?? 'Asia/Calcutta';
    $rangeStart = $contacts->count() > 0 ? $contacts->firstItem() : 0;
    $rangeEnd = $contacts->count() > 0 ? $contacts->lastItem() : 0;
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $topicMeta['pageTitle'] }} | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .stat-card { border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 1.7rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96)); box-shadow: 0 18px 40px rgba(15, 23, 42, 0.055); }
        .lead-table { width: 100%; border-collapse: separate; border-spacing: 0 0.95rem; }
        .lead-table th { padding: 0 1.2rem 0.6rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.18em; text-transform: uppercase; color: rgb(100 116 139); text-align: left; }
        .lead-row td { padding: 1.15rem 1.2rem; background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(248,250,252,0.97)); border-top: 1px solid rgb(226 232 240); border-bottom: 1px solid rgb(226 232 240); }
        .lead-row td:first-child { border-left: 1px solid rgb(226 232 240); border-top-left-radius: 1.4rem; border-bottom-left-radius: 1.4rem; }
        .lead-row td:last-child { border-right: 1px solid rgb(226 232 240); border-top-right-radius: 1.4rem; border-bottom-right-radius: 1.4rem; }
        .lead-row { transition: transform 160ms ease, box-shadow 160ms ease; }
        .lead-row:hover { transform: translateY(-2px); }
        .status-chip { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 0.5rem 0.95rem; min-width: 8.5rem; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; }
        .status-new { background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); color: #0369a1; }
        .status-contacted { background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%); color: #15803d; }
        .status-follow_up { background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%); color: #b45309; }
        .status-closed { background: linear-gradient(135deg, #e2e8f0 0%, #f8fafc 100%); color: #475569; }
        .action-btn { display: inline-flex; align-items: center; gap: 0.5rem; border-radius: 999px; padding: 0.7rem 1rem; background: linear-gradient(135deg, #0f4c81 0%, #2563eb 100%); color: white; font-size: 0.78rem; font-weight: 700; box-shadow: 0 14px 28px rgba(37, 99, 235, 0.18); }
        .field-input, .field-select, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid rgb(203 213 225); background: white; font-size: 0.9rem; color: rgb(15 23 42); }
        .field-input, .field-select { padding: 0.78rem 0.95rem; }
        .field-textarea { min-height: 7rem; padding: 0.9rem 0.95rem; resize: vertical; }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(71 85 105); }
        .detail-card { border: 1px solid rgb(226 232 240); border-radius: 1.2rem; background: rgb(248 250 252); padding: 0.95rem 1rem; }
        .modal-shell[hidden] { display: none; }
        .modal-shell { position: fixed; inset: 0; z-index: 60; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .modal-backdrop { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.62); backdrop-filter: blur(4px); }
        .modal-panel { position: relative; width: min(100%, 72rem); max-height: calc(100vh - 2rem); overflow: auto; border-radius: 2rem; border: 1px solid rgba(226, 232, 240, 0.9); background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(248,250,252,0.98)); box-shadow: 0 30px 80px rgba(15, 23, 42, 0.24); }
        .modal-grid { display: grid; gap: 1.5rem; }
        @media (min-width: 1024px) { .modal-grid { grid-template-columns: minmax(0, 1fr) minmax(21rem, 24rem); } }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#f1f5f9_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-[92rem] space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
        @endif

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-[linear-gradient(135deg,#0b2540_0%,#114b7a_46%,#cfe4ff_220%)] shadow-[0_24px_60px_rgba(8,47,73,0.18)]">
            <div class="grid gap-8 px-6 py-7 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)] lg:px-8 lg:py-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.26em] text-sky-100/90">{{ $topicMeta['eyebrow'] }}</p>
                    <h1 class="mt-3 font-headline text-3xl font-extrabold text-white md:text-4xl">{{ $topicMeta['title'] }}</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-sky-50/85">A cleaner inquiry desk for HR. Keep the table compact, review only the essentials, and open the full lead record in one polished popup when you want to respond or update details.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/15 bg-white/10 p-5 backdrop-blur">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-100/80">Total</p>
                        <p class="mt-3 text-3xl font-extrabold text-white">{{ $contacts->total() }}</p>
                        <p class="mt-2 text-xs text-sky-100/75">Results for this filter.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/15 bg-white/10 p-5 backdrop-blur">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-100/80">New</p>
                        <p class="mt-3 text-3xl font-extrabold text-white">{{ $newCount }}</p>
                        <p class="mt-2 text-xs text-sky-100/75">Fresh inquiries waiting.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/15 bg-white/10 p-5 backdrop-blur">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-100/80">Assigned</p>
                        <p class="mt-3 text-3xl font-extrabold text-white">{{ $assignedCount }}</p>
                        <p class="mt-2 text-xs text-sky-100/75">Leads with owners.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="stat-card p-5">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-700">Follow Up Queue</p>
                <h2 class="mt-3 font-headline text-2xl font-extrabold text-slate-900">{{ $followUpCount }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Visible leads currently marked for follow-up.</p>
            </div>
            <div class="stat-card p-5">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-700">Visible Rows</p>
                <h2 class="mt-3 font-headline text-2xl font-extrabold text-slate-900">{{ $visibleContacts->count() }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Compact rows shown in the current page batch.</p>
            </div>
            <div class="stat-card p-5">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-700">HR Pool</p>
                <h2 class="mt-3 font-headline text-2xl font-extrabold text-slate-900">{{ $hrUsers->count() }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Available users for assignment from the edit modal.</p>
            </div>
        </section>

        <div class="flex flex-wrap gap-2">
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === '' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries') }}">All</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'general' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'general']) }}">General</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'offline_course_lead' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'offline_course_lead']) }}">Offline Courses</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'course_detail_lead' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'course_detail_lead']) }}">Online Courses</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'career' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'career']) }}">Career</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'workshop' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'workshop']) }}">Workshops</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'mentorship' ? 'bg-sky-600 text-white shadow-[0_14px_24px_rgba(2,132,199,0.2)]' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.mentorship') }}">Mentorship</a>
        </div>

        <section class="overflow-hidden rounded-[1.9rem] border border-slate-200 bg-white p-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)] md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Compact Desk</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Inquiry table</h2>
                </div>
                <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $contacts->total() }} total inquiries</div>
            </div>

            @if ($contacts->count() > 0)
                <div class="mt-6 overflow-x-auto rounded-[1.5rem] border border-slate-200/80">
                    <table class="lead-table min-w-[44rem]">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr class="lead-row">
                                    <td class="w-[55%]">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-[1.2rem] bg-[linear-gradient(135deg,#dbeafe_0%,#eff6ff_100%)] text-sm font-extrabold text-sky-700">
                                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($contact->name ?? 'L', 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="truncate text-[1rem] font-extrabold text-slate-900">{{ $contact->name ?: 'Unknown lead' }}</p>
                                                <p class="mt-1 text-xs font-medium tracking-[0.08em] text-slate-400">{{ $contact->created_at?->copy()->setTimezone($displayTimezone)->format('d M Y, h:i a') ?: 'No date' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-[25%]">
                                        <span class="status-chip status-{{ $contact->status }}">{{ str_replace('_', ' ', $contact->status) }}</span>
                                    </td>
                                    <td class="w-[20%] text-right">
                                        <button class="action-btn" type="button" data-modal-open="inquiry-modal-{{ $contact->id }}">
                                            <span class="material-symbols-outlined text-[18px]">edit_square</span>
                                            Edit / View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($contacts->hasPages())
                    <div class="mt-6 flex flex-col gap-4 rounded-[1.5rem] border border-slate-200 bg-slate-50/80 px-4 py-4 md:flex-row md:items-center md:justify-between md:px-5">
                        <p class="text-sm font-medium text-slate-600">
                            Showing {{ $rangeStart }} to {{ $rangeEnd }} of {{ $contacts->total() }} inquiries
                        </p>
                        <div class="hr-pagination">
                            {{ $contacts->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="px-2 py-12 text-center">
                    <div class="mx-auto max-w-md rounded-[1.7rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-10">
                        <p class="text-sm font-semibold text-slate-600">No inquiries found for this filter.</p>
                    </div>
                </div>
            @endif
        </section>
    </div>
</main>

@foreach ($contacts as $contact)
    <div class="modal-shell" hidden id="inquiry-modal-{{ $contact->id }}">
        <div class="modal-backdrop" data-modal-close></div>
        <div aria-modal="true" class="modal-panel" role="dialog">
            <div class="sticky top-0 z-10 flex items-center justify-between gap-4 border-b border-slate-200 bg-white/90 px-6 py-5 backdrop-blur">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Inquiry Profile</p>
                    <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">{{ $contact->name ?: 'Unknown lead' }}</h3>
                </div>
                <button class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600" type="button" data-modal-close>
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-6">
                <div class="modal-grid">
                    <div class="space-y-5">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Email</p>
                                <p class="mt-2 break-all text-sm font-semibold text-slate-800">{{ $contact->email ?: 'No email recorded' }}</p>
                            </div>
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Phone</p>
                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $contact->phone ?: 'No phone recorded' }}</p>
                            </div>
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Topic</p>
                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $contact->topic ?: 'general' }}</p>
                            </div>
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Source Page</p>
                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $contact->source_page ?: 'Not recorded' }}</p>
                            </div>
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Created</p>
                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $contact->created_at?->copy()->setTimezone($displayTimezone)->format('d M Y, h:i a') ?: 'No date' }}</p>
                            </div>
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Course</p>
                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $contact->course?->title ?: 'No mapped course' }}</p>
                            </div>
                        </div>

                        @if ($contact->subject)
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Subject</p>
                                <p class="mt-2 text-sm leading-7 text-slate-700">{{ $contact->subject }}</p>
                            </div>
                        @endif

                        <div class="detail-card">
                            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Inquiry Message</p>
                            <p class="mt-2 text-sm leading-7 text-slate-700">{{ $contact->message ?: 'No message body provided.' }}</p>
                        </div>

                        @if ($contact->access_context || $contact->contacted_at || $contact->follow_up_at)
                            <div class="grid gap-4 md:grid-cols-3">
                                @if ($contact->access_context)
                                    <div class="detail-card">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Access Context</p>
                                        <p class="mt-2 text-sm text-slate-700">{{ $contact->access_context }}</p>
                                    </div>
                                @endif
                                <div class="detail-card">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Contacted</p>
                                    <p class="mt-2 text-sm text-slate-700">{{ $contact->contacted_at?->copy()->setTimezone($displayTimezone)->format('d M Y, h:i a') ?: 'Not marked yet' }}</p>
                                </div>
                                <div class="detail-card">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Follow Up</p>
                                    <p class="mt-2 text-sm text-slate-700">{{ $contact->follow_up_at?->copy()->setTimezone($displayTimezone)->format('d M Y, h:i a') ?: 'Not scheduled' }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($contact->details)
                            <div class="space-y-3">
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Additional Data</p>
                                <div class="grid gap-3 md:grid-cols-2">
                                    @foreach ($contact->details as $label => $value)
                                        <div class="detail-card">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">{{ str_replace('_', ' ', $label) }}</p>
                                            <p class="mt-2 text-sm text-slate-700">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <form action="{{ route('hr.inquiries.update', $contact) }}" class="space-y-4 rounded-[1.6rem] border border-slate-200 bg-[linear-gradient(180deg,#ffffff_0%,#f8fbff_100%)] p-5 shadow-[0_18px_40px_rgba(15,23,42,0.05)]" method="POST">
                            @csrf
                            @method('PUT')
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Edit Inquiry</p>
                                <h4 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Update and respond</h4>
                            </div>
                            <div>
                                <label class="field-label" for="status-{{ $contact->id }}">Status</label>
                                <select class="field-select" id="status-{{ $contact->id }}" name="status">
                                    @foreach (['new' => 'New', 'contacted' => 'Contacted', 'follow_up' => 'Follow Up', 'closed' => 'Closed'] as $value => $label)
                                        <option value="{{ $value }}" @selected($contact->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="field-label" for="assigned-{{ $contact->id }}">Assign To</label>
                                <select class="field-select" id="assigned-{{ $contact->id }}" name="assigned_to">
                                    <option value="">Unassigned</option>
                                    @foreach ($hrUsers as $hrUser)
                                        <option value="{{ $hrUser->id }}" @selected($contact->assigned_to === $hrUser->id)>{{ $hrUser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="field-label" for="follow-up-{{ $contact->id }}">Follow-Up Time</label>
                                <input class="field-input" id="follow-up-{{ $contact->id }}" name="follow_up_at" type="datetime-local" value="{{ old('follow_up_at', optional($contact->follow_up_at)->format('Y-m-d\TH:i')) }}" />
                            </div>
                            <div>
                                <label class="field-label" for="notes-{{ $contact->id }}">Reply / Internal Notes</label>
                                <textarea class="field-textarea" id="notes-{{ $contact->id }}" name="internal_notes" rows="6" placeholder="Add the HR response, callback details, next step, or internal remarks">{{ old('internal_notes', $contact->internal_notes) }}</textarea>
                            </div>
                            <button class="inline-flex w-full items-center justify-center rounded-2xl bg-[linear-gradient(135deg,#0f4c81_0%,#2563eb_100%)] px-4 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(37,99,235,0.18)] transition hover:brightness-105" type="submit">Save Inquiry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    (function () {
        var activeModal = null;

        function closeModal(modal) {
            if (!modal) {
                return;
            }

            modal.hidden = true;
            document.body.classList.remove('overflow-hidden');
            activeModal = null;
        }

        function openModal(modal) {
            if (!modal) {
                return;
            }

            if (activeModal && activeModal !== modal) {
                closeModal(activeModal);
            }

            modal.hidden = false;
            document.body.classList.add('overflow-hidden');
            activeModal = modal;
        }

        document.querySelectorAll('[data-modal-open]').forEach(function (button) {
            button.addEventListener('click', function () {
                openModal(document.getElementById(button.getAttribute('data-modal-open')));
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(function (button) {
            button.addEventListener('click', function () {
                closeModal(button.closest('.modal-shell'));
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal(activeModal);
            }
        });
    })();
</script>
</body>
</html>
