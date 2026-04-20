@php($jobCount = method_exists($jobs, 'total') ? $jobs->total() : $jobs->count())
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Jobs | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .field-shell { border: 1px solid rgb(228 228 243); border-radius: 1.35rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,247,255,0.94)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 10px 24px rgba(15,23,42,0.035); }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(109 40 217); }
        .field-input, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.92); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(167,139,250,0.16); min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 8rem; resize: vertical; }
        .field-input:focus, .field-textarea:focus { outline: none; background: #fff; border-color: rgba(109,40,217,0.24); box-shadow: 0 0 0 4px rgba(109,40,217,0.08), inset 0 0 0 1px rgba(109,40,217,0.12); }
        .panel { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15,23,42,0.06); }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif
        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#1f1147_0%,#6d28d9_58%,#c084fc_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(109,40,217,0.20)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-violet-100/80">Jobs Manager</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div><h1 class="font-headline text-3xl font-extrabold md:text-4xl">{{ $editingJob ? 'Update job posting details.' : 'Create better structured job postings.' }}</h1><p class="mt-4 max-w-3xl text-sm leading-7 text-violet-50/85">This page now matches the newer HR layout with a clean form section on top and a compact jobs table below.</p></div>
                <div class="grid gap-3 sm:grid-cols-3"><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Roles</p><p class="mt-2 text-sm font-semibold text-white">Keep openings clearer</p></div><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Skills</p><p class="mt-2 text-sm font-semibold text-white">Quick skill visibility</p></div><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Status</p><p class="mt-2 text-sm font-semibold text-white">Active and hidden tracking</p></div></div>
            </div>
        </section>
        <section class="panel p-6 md:p-7" id="jobs-table">
            <div><p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">{{ $editingJob ? 'Edit Job' : 'New Job' }}</p><h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingJob ? 'Update job posting' : 'Create job posting' }}</h2></div>
            <form action="{{ $editingJob ? route('hr.jobs.update', $editingJob) : route('hr.jobs.store') }}" class="mt-7 space-y-5" method="POST">
                @csrf
                @if ($editingJob) @method('PUT') @endif
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="field-shell"><label class="field-label">Badge</label><input class="field-input" name="badge" type="text" value="{{ old('badge', $editingJob->badge ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Job Title</label><input class="field-input" name="title" type="text" value="{{ old('title', $editingJob->title ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Employment Type</label><input class="field-input" name="employment_type" type="text" value="{{ old('employment_type', $editingJob->employment_type ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Work Mode</label><input class="field-input" name="work_mode" type="text" value="{{ old('work_mode', $editingJob->work_mode ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Location</label><input class="field-input" name="location" type="text" value="{{ old('location', $editingJob->location ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Experience</label><input class="field-input" name="experience" type="text" value="{{ old('experience', $editingJob->experience ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Salary</label><input class="field-input" name="salary" type="text" value="{{ old('salary', $editingJob->salary ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Accent Classes</label><input class="field-input" name="color" type="text" value="{{ old('color', $editingJob->color ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Sort Order</label><input class="field-input" name="sort_order" type="number" value="{{ old('sort_order', $editingJob->sort_order ?? 0) }}" /></div>
                    <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingJob->is_active ?? true)) />Show this job on the public site</label>
                    <div class="field-shell lg:col-span-2"><label class="field-label">Summary</label><textarea class="field-textarea" name="summary" rows="4">{{ old('summary', $editingJob->summary ?? '') }}</textarea></div>
                    <div class="field-shell lg:col-span-2"><label class="field-label">Skills</label><textarea class="field-textarea" name="skills" rows="4">{{ old('skills', isset($editingJob) ? implode(PHP_EOL, $editingJob->skills ?? []) : '') }}</textarea></div>
                </div>
                <div class="flex flex-wrap gap-3"><button class="rounded-xl bg-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(124,58,237,0.24)]" type="submit">{{ $editingJob ? 'Update Job' : 'Create Job' }}</button>@if ($editingJob)<a class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.jobs') }}">Cancel</a>@endif</div>
            </form>
        </section>
        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">Current Content</p><h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Job postings</h2></div><div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $jobCount }} items</div></div>
            @if ($jobs->isNotEmpty())
                <div class="mt-6 overflow-x-auto rounded-[1.4rem] border border-slate-200">
                    <table class="min-w-full border-collapse">
                        <thead><tr class="bg-slate-50"><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Role</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Work Details</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Skills</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Status</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Actions</th></tr></thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr class="border-t border-slate-200 bg-white">
                                    <td class="px-4 py-4 align-top"><p class="font-semibold text-slate-900">{{ $job->title }}</p><p class="mt-1 text-sm text-slate-500">{{ $job->badge ?: 'Opening' }}</p><p class="mt-2 max-w-md text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($job->summary, 120) }}</p></td>
                                    <td class="px-4 py-4 align-top text-sm text-slate-600">{{ collect([$job->employment_type, $job->work_mode, $job->location, $job->salary])->filter()->implode(' | ') ?: 'Not added' }}</td>
                                    <td class="px-4 py-4 align-top"><div class="flex max-w-xs flex-wrap gap-2">@foreach (($job->skills ?? []) as $skill)<span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-700">{{ $skill }}</span>@endforeach</div></td>
                                    <td class="px-4 py-4 align-top"><span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] {{ $job->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $job->is_active ? 'Active' : 'Hidden' }}</span></td>
                                    <td class="px-4 py-4 align-top"><div class="flex flex-wrap gap-2"><a class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" href="{{ route('hr.jobs', ['edit' => $job->id]) }}">Edit</a><form action="{{ route('hr.jobs.destroy', $job) }}" method="POST">@csrf @method('DELETE')<button class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600" type="submit">Delete</button></form></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (method_exists($jobs, 'links'))
                    <div class="mt-6">
                        {{ $jobs->links() }}
                    </div>
                @endif
            @else
                <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No job postings added yet.</div>
            @endif
        </section>
    </div>
</main>
</body>
</html>
