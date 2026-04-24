@php
    $pendingCount = $registrations->getCollection()->where('registration_status', 'pending')->count();
    $confirmedCount = $registrations->getCollection()->where('registration_status', 'confirmed')->count();
    $rejectedCount = $registrations->getCollection()->where('registration_status', 'rejected')->count();
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Workshop Payments | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .panel { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15,23,42,0.06); }
        .field-input, .field-select, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid rgb(203 213 225); background: white; color: rgb(15 23 42); }
        .field-input, .field-select { padding: 0.78rem 0.95rem; }
        .field-textarea { min-height: 7rem; padding: 0.9rem 0.95rem; resize: vertical; }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(14 116 144); }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif

        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#0f172a_0%,#155e75_52%,#67e8f9_140%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(8,47,73,0.18)]">
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-cyan-100/80">Workshop Payments Desk</p>
                    <h1 class="mt-4 font-headline text-3xl font-extrabold md:text-4xl">Review QR payments and confirm registrations.</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-cyan-50/85">This page lets HR verify payment proof, approve or reject registrations, and keep confirmed workshop enrollments visible in one proper workflow.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-100/70">Pending</p><p class="mt-2 text-sm font-semibold text-white">{{ $pendingCount }}</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-100/70">Confirmed</p><p class="mt-2 text-sm font-semibold text-white">{{ $confirmedCount }}</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-100/70">Rejected</p><p class="mt-2 text-sm font-semibold text-white">{{ $rejectedCount }}</p></div>
                </div>
            </div>
        </section>

        <div class="flex flex-wrap gap-2">
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $statusFilter === '' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.workshop-registrations') }}">All</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $statusFilter === 'pending' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.workshop-registrations', ['status' => 'pending']) }}">Pending</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $statusFilter === 'confirmed' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.workshop-registrations', ['status' => 'confirmed']) }}">Confirmed</a>
            <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $statusFilter === 'rejected' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.workshop-registrations', ['status' => 'rejected']) }}">Rejected</a>
        </div>

        <section class="space-y-5">
            @forelse ($registrations as $registration)
                <article class="panel p-6">
                    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                        <div class="space-y-5">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">{{ $registration->workshop?->title ?: 'Workshop registration' }}</p>
                                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">{{ $registration->name }}</h2>
                                    <p class="mt-2 text-sm text-slate-500">{{ $registration->email }}{{ $registration->phone ? ' | '.$registration->phone : '' }}</p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] {{ $registration->payment_status === 'verified' ? 'bg-emerald-100 text-emerald-700' : ($registration->payment_status === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">{{ str_replace('_', ' ', $registration->payment_status) }}</span>
                                    <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] {{ $registration->registration_status === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : ($registration->registration_status === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600') }}">{{ $registration->registration_status }}</span>
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Schedule</p><p class="mt-2 text-sm font-semibold text-slate-800">{{ collect([$registration->workshop?->date_label, $registration->workshop?->time_label])->filter()->implode(' | ') ?: 'Not added' }}</p></div>
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Amount</p><p class="mt-2 text-sm font-semibold text-slate-800">{{ $registration->currency }} {{ number_format((float) $registration->payment_amount, ((float) $registration->payment_amount === floor((float) $registration->payment_amount)) ? 0 : 2) }}</p></div>
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Payment Reference</p><p class="mt-2 text-sm font-semibold text-slate-800">{{ $registration->payment_reference ?: 'Not submitted' }}</p></div>
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Attendance</p><p class="mt-2 text-sm font-semibold text-slate-800">{{ $registration->attendance_mode ?: 'Not selected' }}</p></div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Learner Type</p><p class="mt-2 text-sm text-slate-700">{{ $registration->learner_type ?: 'Not shared' }}</p></div>
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Experience</p><p class="mt-2 text-sm text-slate-700">{{ $registration->experience_level ?: 'Not shared' }}</p></div>
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">City</p><p class="mt-2 text-sm text-slate-700">{{ $registration->city ?: 'Not shared' }}</p></div>
                                <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Organization</p><p class="mt-2 text-sm text-slate-700">{{ $registration->organization ?: 'Not shared' }}</p></div>
                            </div>

                            @if ($registration->goals || $registration->questions)
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Goals</p><p class="mt-2 text-sm leading-7 text-slate-700">{{ $registration->goals ?: 'No goals shared' }}</p></div>
                                    <div class="rounded-[1.2rem] border border-slate-200 bg-slate-50 p-4"><p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Questions</p><p class="mt-2 text-sm leading-7 text-slate-700">{{ $registration->questions ?: 'No questions shared' }}</p></div>
                                </div>
                            @endif

                            @if ($registration->reviewer || $registration->reviewed_at)
                                <p class="text-xs text-slate-500">Last reviewed by {{ $registration->reviewer?->name ?: 'HR team' }}{{ $registration->reviewed_at ? ' on '.$registration->reviewed_at->format('d M Y, h:i a') : '' }}.</p>
                            @endif
                        </div>

                        <div class="space-y-5">
                            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Payment Proof</p>
                                @if ($registration->payment_screenshot_path)
                                    <a class="mt-4 inline-flex text-sm font-semibold text-sky-700 underline underline-offset-4" href="{{ $registration->payment_screenshot_path }}" target="_blank" rel="noreferrer">Open uploaded screenshot / PDF</a>
                                    @if (\Illuminate\Support\Str::contains($registration->payment_screenshot_path, ['.jpg', '.jpeg', '.png', '.webp']))
                                        <img class="mt-4 w-full rounded-[1.2rem] border border-slate-200 bg-white object-cover" src="{{ $registration->payment_screenshot_path }}" alt="Payment proof for {{ $registration->name }}" />
                                    @endif
                                @else
                                    <p class="mt-3 text-sm text-slate-500">No proof uploaded.</p>
                                @endif
                            </div>

                            <form action="{{ route('hr.workshop-registrations.update', $registration) }}" method="POST" class="rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-[0_18px_40px_rgba(15,23,42,0.05)]">
                                @csrf
                                @method('PUT')
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Review Registration</p>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="field-label">Payment Status</label>
                                        <select class="field-select" name="payment_status">
                                            @foreach (['pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected', 'not_required' => 'Not Required'] as $value => $label)
                                                <option value="{{ $value }}" @selected($registration->payment_status === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="field-label">Registration Status</label>
                                        <select class="field-select" name="registration_status">
                                            @foreach (['pending' => 'Pending', 'confirmed' => 'Confirmed', 'rejected' => 'Rejected'] as $value => $label)
                                                <option value="{{ $value }}" @selected($registration->registration_status === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="field-label">HR Notes</label>
                                        <textarea class="field-textarea" name="hr_notes" rows="5" placeholder="Add payment review notes, callback details, or rejection reason">{{ old('hr_notes', $registration->hr_notes) }}</textarea>
                                    </div>
                                    <button class="inline-flex w-full items-center justify-center rounded-2xl bg-[linear-gradient(135deg,#0f4c81_0%,#2563eb_100%)] px-4 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(37,99,235,0.18)]" type="submit">Save Decision</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="panel px-6 py-12 text-center text-sm text-slate-500">No workshop registrations found for this filter.</div>
            @endforelse
        </section>

        @if (method_exists($registrations, 'links'))
            <div class="panel px-5 py-4">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</main>
</body>
</html>
