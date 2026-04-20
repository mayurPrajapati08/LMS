@php($slideCount = method_exists($slides, 'total') ? $slides->total() : $slides->count())
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Slides | HR Dashboard</title>
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
        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#082f49_0%,#0369a1_58%,#7dd3fc_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(3,105,161,0.20)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-sky-100/80">Slides Manager</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div>
                    <h1 class="font-headline text-3xl font-extrabold md:text-4xl">{{ $editingSlide ? 'Update homepage slide content.' : 'Create clean and ordered homepage slides.' }}</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-sky-50/85">This page manages only the top homepage slideshow. Founder video management is now separate so the slider stays clean.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Order</p><p class="mt-2 text-sm font-semibold text-white">Keep homepage slide sequence clear</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Actions</p><p class="mt-2 text-sm font-semibold text-white">Edit and remove from one place</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Status</p><p class="mt-2 text-sm font-semibold text-white">Active and hidden clearly visible</p></div>
                </div>
            </div>
        </section>
        <section class="panel p-6 md:p-7" id="slides-table">
            <div><p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">{{ $editingSlide ? 'Edit Slide' : 'New Slide' }}</p><h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingSlide ? 'Update homepage slide' : 'Create homepage slide' }}</h2></div>
            <form action="{{ $editingSlide ? route('hr.slides.update', $editingSlide) : route('hr.slides.store') }}" class="mt-7 space-y-5" method="POST">
                @csrf
                @if ($editingSlide) @method('PUT') @endif
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="field-shell"><label class="field-label">Eyebrow</label><input class="field-input" name="eyebrow" type="text" value="{{ old('eyebrow', $editingSlide->eyebrow ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Title</label><input class="field-input" name="title" type="text" value="{{ old('title', $editingSlide->title ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Highlight</label><input class="field-input" name="highlight" type="text" value="{{ old('highlight', $editingSlide->highlight ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Badge</label><input class="field-input" name="badge" type="text" value="{{ old('badge', $editingSlide->badge ?? '') }}" /></div>
                    <div class="field-shell lg:col-span-2"><label class="field-label">Description</label><textarea class="field-textarea" name="description" rows="4">{{ old('description', $editingSlide->description ?? '') }}</textarea></div>
                    <div class="field-shell"><label class="field-label">Accent Classes</label><input class="field-input" name="accent" type="text" value="{{ old('accent', $editingSlide->accent ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Image URL</label><input class="field-input" name="image" type="text" value="{{ old('image', $editingSlide->image ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Stat Label</label><input class="field-input" name="stat_label" type="text" value="{{ old('stat_label', $editingSlide->stat_label ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Stat Value</label><input class="field-input" name="stat_value" type="text" value="{{ old('stat_value', $editingSlide->stat_value ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Primary Button Label</label><input class="field-input" name="primary_label" type="text" value="{{ old('primary_label', $editingSlide->primary_label ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Secondary Button Label</label><input class="field-input" name="secondary_label" type="text" value="{{ old('secondary_label', $editingSlide->secondary_label ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Primary URL</label><input class="field-input" name="primary_url" type="text" value="{{ old('primary_url', $editingSlide->primary_url ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Secondary URL</label><input class="field-input" name="secondary_url" type="text" value="{{ old('secondary_url', $editingSlide->secondary_url ?? '') }}" /></div>
                    <div class="field-shell"><label class="field-label">Sort Order</label><input class="field-input" name="sort_order" type="number" value="{{ old('sort_order', $editingSlide->sort_order ?? 0) }}" /></div>
                    <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingSlide->is_active ?? true)) />Show this slide on the public site</label>
                </div>
                <div class="flex flex-wrap gap-3"><button class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(2,132,199,0.22)]" type="submit">{{ $editingSlide ? 'Update Slide' : 'Create Slide' }}</button>@if ($editingSlide)<a class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.slides') }}">Cancel</a>@endif</div>
            </form>
        </section>
        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Current Content</p><h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Homepage slides</h2></div><div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $slideCount }} items</div></div>
            @if ($slides->isNotEmpty())
                <div class="mt-6 overflow-x-auto rounded-[1.4rem] border border-slate-200">
                    <table class="min-w-full border-collapse">
                        <thead><tr class="bg-slate-50"><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Slide</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Buttons</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Order</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Status</th><th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Actions</th></tr></thead>
                        <tbody>
                            @foreach ($slides as $slide)
                                <tr class="border-t border-slate-200 bg-white">
                                    <td class="px-4 py-4 align-top"><p class="font-semibold text-slate-900">{{ $slide->title ?: 'Untitled slide' }}</p><p class="mt-1 text-sm text-slate-500">{{ $slide->eyebrow ?: 'Homepage slide' }}</p><p class="mt-2 max-w-md text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($slide->description, 120) }}</p></td>
                                    <td class="px-4 py-4 align-top text-sm text-slate-600">{{ collect([$slide->primary_label, $slide->secondary_label])->filter()->implode(' / ') ?: 'No button labels' }}</td>
                                    <td class="px-4 py-4 align-top text-sm font-medium text-slate-600">{{ $slide->sort_order }}</td>
                                    <td class="px-4 py-4 align-top"><span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] {{ $slide->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $slide->is_active ? 'Active' : 'Hidden' }}</span></td>
                                    <td class="px-4 py-4 align-top"><div class="flex flex-wrap gap-2"><a class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" href="{{ route('hr.slides', ['edit' => $slide->id]) }}">Edit</a><form action="{{ route('hr.slides.destroy', $slide) }}" method="POST">@csrf @method('DELETE')<button class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600" type="submit">Delete</button></form></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (method_exists($slides, 'links'))
                    <div class="mt-6">
                        {{ $slides->links() }}
                    </div>
                @endif
            @else
                <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No slides added yet.</div>
            @endif
        </section>
    </div>
</main>
</body>
</html>
