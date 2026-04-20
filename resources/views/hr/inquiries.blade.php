@php
    $topicMeta = match ($filterTopic) {
        'career' => ['eyebrow' => 'Career Pipeline', 'title' => 'Career inquiries', 'pageTitle' => 'Career Leads'],
        'workshop' => ['eyebrow' => 'Workshop Pipeline', 'title' => 'Workshop registrations', 'pageTitle' => 'Workshop Leads'],
        'mentorship' => ['eyebrow' => 'Mentorship Team Queue', 'title' => 'Free mentorship leads', 'pageTitle' => 'Mentorship Leads'],
        'general' => ['eyebrow' => 'General Inquiries', 'title' => 'General public inquiries', 'pageTitle' => 'General Inquiries'],
        default => ['eyebrow' => 'Lead Management', 'title' => 'Student and public inquiries', 'pageTitle' => 'Public Inquiries'],
    };
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
    <style>body{font-family:Inter,sans-serif} h1,h2,h3,.font-headline{font-family:Manrope,sans-serif} .material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 500,'GRAD' 0,'opsz' 24;}</style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))<div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif

        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">{{ $topicMeta['eyebrow'] }}</p>
                <h1 class="mt-2 font-headline text-3xl font-extrabold">{{ $topicMeta['title'] }}</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === '' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries') }}">All</a>
                <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'general' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'general']) }}">General</a>
                <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'career' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'career']) }}">Career</a>
                <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'workshop' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.inquiries', ['topic' => 'workshop']) }}">Workshops</a>
                <a class="rounded-xl px-4 py-2 text-sm font-semibold {{ $filterTopic === 'mentorship' ? 'bg-sky-600 text-white' : 'border border-slate-200 bg-white text-slate-600' }}" href="{{ route('hr.mentorship') }}">Mentorship</a>
            </div>
        </div>

        <div class="space-y-5">
            @forelse ($contacts as $contact)
                <div class="rounded-[1.8rem] bg-white p-6 shadow-sm">
                    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="rounded-full bg-sky-100 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-sky-700">{{ $contact->topic ?: 'general' }}</span>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-600">{{ $contact->status }}</span>
                            </div>
                            <h2 class="mt-4 text-xl font-bold text-slate-900">{{ $contact->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $contact->email }} @if($contact->phone) • {{ $contact->phone }} @endif</p>
                            @if ($contact->subject)<p class="mt-4 text-sm font-semibold text-slate-900">{{ $contact->subject }}</p>@endif
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $contact->message }}</p>
                            @if ($contact->details)
                                <div class="mt-4 grid gap-3 md:grid-cols-2">
                                    @foreach ($contact->details as $label => $value)
                                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">{{ $label }}</p>
                                            <p class="mt-2 text-sm text-slate-700">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div>
                            <form action="{{ route('hr.inquiries.update', $contact) }}" class="space-y-4" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-4 md:grid-cols-2">
                                    <select class="w-full rounded-xl border-slate-200" name="status">
                                        @foreach (['new' => 'New', 'contacted' => 'Contacted', 'follow_up' => 'Follow Up', 'closed' => 'Closed'] as $value => $label)
                                            <option value="{{ $value }}" @selected($contact->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <select class="w-full rounded-xl border-slate-200" name="assigned_to">
                                        <option value="">Unassigned</option>
                                        @foreach ($hrUsers as $hrUser)
                                            <option value="{{ $hrUser->id }}" @selected($contact->assigned_to === $hrUser->id)>{{ $hrUser->name }}</option>
                                        @endforeach
                                    </select>
                                    <input class="w-full rounded-xl border-slate-200 md:col-span-2" name="follow_up_at" type="datetime-local" value="{{ old('follow_up_at', optional($contact->follow_up_at)->format('Y-m-d\TH:i')) }}" />
                                </div>
                                <textarea class="w-full rounded-xl border-slate-200" name="internal_notes" placeholder="Internal notes for the HR team" rows="5">{{ old('internal_notes', $contact->internal_notes) }}</textarea>
                                <button class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white" type="submit">Save Inquiry</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-[1.8rem] border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm text-slate-500">No inquiries found for this filter.</div>
            @endforelse
        </div>

        {{ $contacts->links() }}
    </div>
</main>
</body>
</html>
