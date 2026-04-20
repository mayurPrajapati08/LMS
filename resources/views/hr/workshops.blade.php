@php($workshopCount = method_exists($workshops, 'total') ? $workshops->total() : $workshops->count())
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Workshops | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .field-shell { border: 1px solid rgb(214 228 240); border-radius: 1.35rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(246,250,253,0.94)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 10px 24px rgba(15,23,42,0.035); }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(14 116 144); }
        .field-input, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.9); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(148,163,184,0.18); min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 8rem; resize: vertical; }
        .field-input:focus, .field-textarea:focus { outline: none; background: #fff; border-color: rgba(14,116,144,0.24); box-shadow: 0 0 0 4px rgba(14,116,144,0.08), inset 0 0 0 1px rgba(14,116,144,0.12); }
        .panel { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15,23,42,0.06); }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif
        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#083344_0%,#0f766e_58%,#5eead4_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(15,118,110,0.20)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-teal-100/80">Workshops Manager</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div><h1 class="font-headline text-3xl font-extrabold md:text-4xl">{{ $editingWorkshop ? 'Update workshop content.' : 'Create cleaner workshop entries.' }}</h1><p class="mt-4 max-w-3xl text-sm leading-7 text-teal-50/85">This page now uses the same proper HR layout with the workshop form first and the current workshops list below.</p></div>
                <div class="grid gap-3 sm:grid-cols-3"><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-100/70">Planning</p><p class="mt-2 text-sm font-semibold text-white">Date, time, mentor, venue</p></div><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-100/70">Highlights</p><p class="mt-2 text-sm font-semibold text-white">Show key talking points</p></div><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-100/70">Status</p><p class="mt-2 text-sm font-semibold text-white">Control visibility fast</p></div></div>
            </div>
        </section>
        <section class="panel p-6 md:p-7" id="workshops-table">
            <div><p class="text-xs font-bold uppercase tracking-[0.24em] text-teal-700">{{ $editingWorkshop ? 'Edit Workshop' : 'New Workshop' }}</p><h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingWorkshop ? 'Update workshop posting' : 'Create workshop posting' }}</h2></div>
            <form action="{{ $editingWorkshop ? route('hr.workshops.update', $editingWorkshop) : route('hr.workshops.store') }}" class="mt-7 space-y-5" method="POST">
                @csrf
                @if ($editingWorkshop) @method('PUT') @endif
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="field-shell"><label class="field-label">Badge</label><input class="field-input" name="badge" type="text" value="{{ old('badge', $editingWorkshop->badge ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Workshop Title</label><input class="field-input" name="title" type="text" value="{{ old('title', $editingWorkshop->title ?? '') }}" /></div>
                    <div class="field-shell lg:col-span-2"><label class="field-label">Subtitle</label><textarea class="field-textarea" name="subtitle" rows="3">{{ old('subtitle', $editingWorkshop->subtitle ?? '') }}</textarea></div>
                    <div class="field-shell"><label class="field-label">Date</label><input class="field-input" name="date_label" type="text" value="{{ old('date_label', $editingWorkshop->date_label ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Time</label><input class="field-input" name="time_label" type="text" value="{{ old('time_label', $editingWorkshop->time_label ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Format</label><input class="field-input" name="format" type="text" value="{{ old('format', $editingWorkshop->format ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Venue</label><input class="field-input" name="venue" type="text" value="{{ old('venue', $editingWorkshop->venue ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Audience</label><input class="field-input" name="audience" type="text" value="{{ old('audience', $editingWorkshop->audience ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Mentor</label><input class="field-input" name="mentor" type="text" value="{{ old('mentor', $editingWorkshop->mentor ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Seats Text</label><input class="field-input" name="seats" type="text" value="{{ old('seats', $editingWorkshop->seats ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Accent Classes</label><input class="field-input" name="accent" type="text" value="{{ old('accent', $editingWorkshop->accent ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Sort Order</label><input class="field-input" name="sort_order" type="number" value="{{ old('sort_order', $editingWorkshop->sort_order ?? 0) }}" /></div>
                    <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingWorkshop->is_active ?? true)) />Show this workshop on the public site</label>
                    <div class="field-shell lg:col-span-2"><label class="field-label">Highlights</label><textarea class="field-textarea" name="highlights" rows="4">{{ old('highlights', isset($editingWorkshop) ? implode(PHP_EOL, $editingWorkshop->highlights ?? []) : '') }}</textarea></div>
                </div>
                <div class="flex flex-wrap gap-3"><button class="rounded-xl bg-teal-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(13,148,136,0.22)]" type="submit">{{ $editingWorkshop ? 'Update Workshop' : 'Create Workshop' }}</button>@if ($editingWorkshop)<a class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.workshops') }}">Cancel</a>@endif</div>
            </form>
        </section>
        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.24em] text-teal-700">Current Content</p><h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Workshop items</h2></div><div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $workshopCount }} items</div></div>
            @if ($workshops->isNotEmpty())
                <div class="mt-6 overflow-x-auto rounded-[1.4rem] border border-slate-200">
                    <table class="min-w-full border-collapse">
                        <thead><tr class="bg-slate-50"><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Workshop</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Schedule</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Highlights</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Status</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Actions</th></tr></thead>
                        <tbody>
                            @foreach ($workshops as $workshop)
                                <tr class="border-t border-slate-200 bg-white">
                                    <td class="px-4 py-4 align-top"><p class="font-semibold text-slate-900">{{ $workshop->title }}</p><p class="mt-1 text-sm text-slate-500">{{ $workshop->badge ?: 'Workshop' }}</p><p class="mt-2 max-w-md text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($workshop->subtitle, 120) }}</p></td>
                                    <td class="px-4 py-4 align-top text-sm text-slate-600">{{ collect([$workshop->date_label, $workshop->time_label, $workshop->venue])->filter()->implode(' | ') ?: 'Not added' }}</td>
                                    <td class="px-4 py-4 align-top"><div class="flex max-w-xs flex-wrap gap-2">@foreach (($workshop->highlights ?? []) as $highlight)<span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700">{{ $highlight }}</span>@endforeach</div></td>
                                    <td class="px-4 py-4 align-top"><span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] {{ $workshop->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $workshop->is_active ? 'Active' : 'Hidden' }}</span></td>
                                    <td class="px-4 py-4 align-top"><div class="flex flex-wrap gap-2"><a class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" href="{{ route('hr.workshops', ['edit' => $workshop->id]) }}">Edit</a><form action="{{ route('hr.workshops.destroy', $workshop) }}" method="POST">@csrf @method('DELETE')<button class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600" type="submit">Delete</button></form></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (method_exists($workshops, 'links'))
                    <div class="mt-6">
                        {{ $workshops->links() }}
                    </div>
                @endif
            @else
                <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No workshops added yet.</div>
            @endif
        </section>
    </div>
</main>
</body>
</html>
