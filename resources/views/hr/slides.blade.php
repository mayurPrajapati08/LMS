@php
    $slideCount = method_exists($slides, 'total') ? $slides->total() : $slides->count();
    $activeImageProvider = old('image_provider', 'url');
    $activeImageProvider = $activeImageProvider === 'cloud' ? 'cloudflare' : $activeImageProvider;
@endphp
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
        .panel { border: 1px solid rgb(226 232 240); border-radius: 1.7rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 20px 44px rgba(15,23,42,0.07); }
        .field-shell { border: 1px solid rgb(214 228 240); border-radius: 1.35rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(246,250,253,0.94)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 10px 24px rgba(15,23,42,0.035); }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(14 116 144); }
        .field-help { margin-top: 0.45rem; font-size: 0.78rem; line-height: 1.45; color: rgb(100 116 139); }
        .field-input, .field-select, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.92); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(148,163,184,0.18); transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease; }
        .field-input, .field-select { min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 8rem; padding: 1rem; resize: vertical; }
        .field-input:focus, .field-select:focus, .field-textarea:focus { outline: none; background: #fff; border-color: rgba(14,116,144,0.24); box-shadow: 0 0 0 4px rgba(14,116,144,0.08), inset 0 0 0 1px rgba(14,116,144,0.12); }
        .field-file { width: 100%; border-radius: 1rem; border: 1px dashed rgba(14,116,144,0.26); background: linear-gradient(180deg, #f8fdff 0%, #eff8fd 100%); padding: 0.8rem; color: rgb(51 65 85); }
        .field-file::file-selector-button { margin-right: 0.75rem; border: 0; border-radius: 0.85rem; background: linear-gradient(135deg, rgb(14 116 144), rgb(59 130 246)); color: white; font-weight: 700; padding: 0.7rem 1rem; cursor: pointer; }
        .slide-card { border: 1px solid rgba(226,232,240,0.9); border-radius: 1.45rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96)); box-shadow: 0 16px 36px rgba(15,23,42,0.05); }
        [hidden] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#edf7ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif

        <section class="overflow-hidden rounded-[2rem] bg-[radial-gradient(circle_at_top_left,#7dd3fc_0%,#0369a1_38%,#082f49_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(3,105,161,0.20)]">
            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-sky-100/80">Slides Manager</p>
                    <h1 class="mt-4 font-headline text-3xl font-extrabold md:text-4xl">{{ $editingSlide ? 'Update the homepage slideshow with confidence.' : 'Build a polished homepage slideshow.' }}</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-sky-50/85">Manage copy, slide order, CTA links, and image delivery from one clean place. Upload directly from your device or keep using image URLs when needed.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Uploads</p>
                        <p class="mt-2 text-sm font-semibold text-white">Local, Cloudflare R2, Cloudinary, or direct URL.</p>
                    </div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Preview</p>
                        <p class="mt-2 text-sm font-semibold text-white">See the current slide image before saving changes.</p>
                    </div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Status</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $slideCount }} total slide{{ $slideCount === 1 ? '' : 's' }} in rotation.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-8 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="panel p-6 md:p-7" id="slides-table">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">{{ $editingSlide ? 'Edit Slide' : 'New Slide' }}</p>
                    <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingSlide ? 'Update homepage slide' : 'Create homepage slide' }}</h2>
                </div>

                <form action="{{ $editingSlide ? route('hr.slides.update', $editingSlide) : route('hr.slides.store') }}" class="mt-7 space-y-5" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($editingSlide) @method('PUT') @endif

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell"><label class="field-label">Eyebrow</label><input class="field-input" name="eyebrow" type="text" value="{{ old('eyebrow', $editingSlide->eyebrow ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Title</label><input class="field-input" name="title" type="text" value="{{ old('title', $editingSlide->title ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Highlight</label><input class="field-input" name="highlight" type="text" value="{{ old('highlight', $editingSlide->highlight ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Badge</label><input class="field-input" name="badge" type="text" value="{{ old('badge', $editingSlide->badge ?? '') }}" /></div>
                        <div class="field-shell lg:col-span-2"><label class="field-label">Description</label><textarea class="field-textarea" name="description" rows="4">{{ old('description', $editingSlide->description ?? '') }}</textarea></div>
                        <div class="field-shell"><label class="field-label">Accent Gradient / Classes</label><input class="field-input" name="accent" type="text" value="{{ old('accent', $editingSlide->accent ?? '') }}" /><p class="field-help">Use the same accent string already supported by the homepage slider.</p></div>
                        <div class="field-shell"><label class="field-label">Sort Order</label><input class="field-input" name="sort_order" type="number" min="0" value="{{ old('sort_order', $editingSlide->sort_order ?? 0) }}" /></div>
                    </div>

                    <div class="rounded-[1.6rem] border border-sky-100 bg-[linear-gradient(180deg,#fcfeff_0%,#eff8ff_100%)] p-5">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined rounded-full bg-sky-100 p-2 text-sky-700">image</span>
                            <div>
                                <h3 class="font-headline text-xl font-extrabold text-slate-900">Slide Image</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Choose how this slide image should be provided. URL mode keeps the old flow, while uploads can go to local storage, Cloudflare R2, or Cloudinary.</p>
                            </div>
                        </div>
                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                            <div class="field-shell">
                                <label class="field-label" for="slide_image_provider">Storage Option</label>
                                <select class="field-select" id="slide_image_provider" name="image_provider" data-provider-select="slide-image">
                                    <option value="url" @selected($activeImageProvider === 'url')>Use image URL</option>
                                    <option value="local" @selected($activeImageProvider === 'local')>Upload to local storage</option>
                                    <option value="cloudflare" @selected($activeImageProvider === 'cloudflare')>Upload to Cloudflare R2</option>
                                    <option value="cloudinary" @selected($activeImageProvider === 'cloudinary')>Upload to Cloudinary</option>
                                </select>
                            </div>
                            <div class="field-shell" data-provider-mode="slide-image" data-provider-view="file" @if ($activeImageProvider === 'url') hidden @endif>
                                <label class="field-label" for="slide_image_file">Upload From Device</label>
                                <input class="field-file" id="slide_image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp,image/gif" />
                                <p class="field-help">Supported: JPG, PNG, WEBP, GIF. Leave empty while editing to keep the current image.</p>
                            </div>
                            <div class="field-shell lg:col-span-2" data-provider-mode="slide-image" data-provider-view="url" @if ($activeImageProvider !== 'url') hidden @endif>
                                <label class="field-label" for="slide_image_url">Image URL</label>
                                <input class="field-input" id="slide_image_url" name="image" type="text" value="{{ old('image', $editingSlide->image ?? '') }}" />
                                <p class="field-help">Paste a full image URL when you do not want to upload a file.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell"><label class="field-label">Stat Label</label><input class="field-input" name="stat_label" type="text" value="{{ old('stat_label', $editingSlide->stat_label ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Stat Value</label><input class="field-input" name="stat_value" type="text" value="{{ old('stat_value', $editingSlide->stat_value ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Primary Button Label</label><input class="field-input" name="primary_label" type="text" value="{{ old('primary_label', $editingSlide->primary_label ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Primary URL</label><input class="field-input" name="primary_url" type="text" value="{{ old('primary_url', $editingSlide->primary_url ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Secondary Button Label</label><input class="field-input" name="secondary_label" type="text" value="{{ old('secondary_label', $editingSlide->secondary_label ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label">Secondary URL</label><input class="field-input" name="secondary_url" type="text" value="{{ old('secondary_url', $editingSlide->secondary_url ?? '') }}" /></div>
                    </div>

                    <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingSlide->is_active ?? true)) />Show this slide on the public site</label>

                    <div class="flex flex-wrap gap-3">
                        <button class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(2,132,199,0.22)]" type="submit">{{ $editingSlide ? 'Update Slide' : 'Create Slide' }}</button>
                        @if ($editingSlide)
                            <a class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.slides') }}">Cancel</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <section class="panel p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Live Preview</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">{{ $editingSlide?->title ?: 'Next homepage slide' }}</h2>
                    <div class="mt-5 overflow-hidden rounded-[1.6rem] border border-slate-200 bg-slate-950">
                        @if ($editingSlide?->image)
                            <img src="{{ $editingSlide->image }}" alt="{{ $editingSlide->title ?: 'Slide preview' }}" class="h-64 w-full object-cover opacity-90" />
                        @else
                            <div class="flex h-64 items-center justify-center bg-[radial-gradient(circle_at_top,#38bdf8_0%,#0f172a_68%)] px-8 text-center text-sm font-semibold text-white/80">Upload or paste a slide image and it will appear here after save.</div>
                        @endif
                    </div>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="rounded-2xl bg-slate-50 px-4 py-3"><span class="font-semibold text-slate-900">Eyebrow:</span> {{ $editingSlide?->eyebrow ?: 'Homepage slide' }}</div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3"><span class="font-semibold text-slate-900">Buttons:</span> {{ collect([$editingSlide?->primary_label, $editingSlide?->secondary_label])->filter()->implode(' / ') ?: 'No button labels yet' }}</div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3"><span class="font-semibold text-slate-900">Visibility:</span> {{ ($editingSlide?->is_active ?? true) ? 'Active on homepage' : 'Hidden from homepage' }}</div>
                    </div>
                </section>

                <section class="panel p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Upload Notes</p>
                    <div class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">`URL` keeps the previous external-image workflow.</div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">`Cloudflare R2` and `Cloudinary` use the same media helpers already used elsewhere in HR.</div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">If cloud credentials are missing, the save action will show a clear validation-style error instead of silently failing.</div>
                    </div>
                </section>
            </div>
        </section>

        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Current Content</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Homepage slides</h2>
                </div>
                <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $slideCount }} items</div>
            </div>

            @if ($slides->isNotEmpty())
                <div class="mt-6 grid gap-4 xl:grid-cols-2">
                    @foreach ($slides as $slide)
                        <article class="slide-card overflow-hidden">
                            <div class="grid h-full md:grid-cols-[220px_1fr]">
                                <div class="bg-slate-100">
                                    @if ($slide->image)
                                        <img src="{{ $slide->image }}" alt="{{ $slide->title ?: 'Slide image' }}" class="h-full min-h-[220px] w-full object-cover" loading="lazy" />
                                    @else
                                        <div class="flex h-full min-h-[220px] items-center justify-center bg-[radial-gradient(circle_at_top,#bae6fd_0%,#e2e8f0_70%)] px-6 text-center text-sm font-semibold text-slate-500">No image attached</div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-sky-700">{{ $slide->eyebrow ?: 'Homepage slide' }}</p>
                                            <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">{{ $slide->title ?: 'Untitled slide' }}</h3>
                                        </div>
                                        <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] {{ $slide->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $slide->is_active ? 'Active' : 'Hidden' }}</span>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($slide->description, 140) ?: 'No slide description added yet.' }}</p>
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600"><span class="font-semibold text-slate-900">Buttons:</span> {{ collect([$slide->primary_label, $slide->secondary_label])->filter()->implode(' / ') ?: 'No button labels' }}</div>
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600"><span class="font-semibold text-slate-900">Order:</span> {{ $slide->sort_order }}</div>
                                    </div>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <a class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" href="{{ route('hr.slides', ['edit' => $slide->id]) }}">Edit</a>
                                        <form action="{{ route('hr.slides.destroy', $slide) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
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

<script>
    (function () {
        function toggleProviderFields(mode, value) {
            Array.prototype.slice.call(document.querySelectorAll('[data-provider-mode="' + mode + '"]')).forEach(function (field) {
                var isUrlView = field.getAttribute('data-provider-view') === 'url';
                field.hidden = value === 'url' ? !isUrlView : isUrlView;
            });
        }

        Array.prototype.slice.call(document.querySelectorAll('[data-provider-select]')).forEach(function (select) {
            var mode = select.getAttribute('data-provider-select');
            toggleProviderFields(mode, select.value);
            select.addEventListener('change', function () {
                toggleProviderFields(mode, select.value);
            });
        });
    }());
</script>
</body>
</html>
