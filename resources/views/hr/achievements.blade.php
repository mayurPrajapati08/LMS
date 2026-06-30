@php
    $activeAchievementKind = old('kind', $editingAchievement->kind ?? ($achievementFilter ?? 'gallery'));
    $activeCategoryMode = old('category_mode', filled($editingAchievement->gallery_category ?? null) ? 'existing' : 'new');
    $activeCategoryOrder = old('gallery_category_order', $editingAchievement->gallery_category_order ?? 0);
    $achievementCount = method_exists($achievements, 'total') ? $achievements->total() : $achievements->count();
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Achievements | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .field-shell { border: 1px solid rgb(228 228 243); border-radius: 1.35rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,247,255,0.94)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 10px 24px rgba(15,23,42,0.035); }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(109 40 217); }
        .field-help { margin-top: 0.45rem; font-size: 0.78rem; line-height: 1.45; color: rgb(100 116 139); }
        .field-input, .field-select, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.92); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(167,139,250,0.16); transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease; }
        .field-input::placeholder, .field-textarea::placeholder { color: rgb(148 163 184); }
        .field-input, .field-select { min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 7.5rem; padding: 1rem; resize: vertical; }
        .field-input:focus, .field-select:focus, .field-textarea:focus { outline: none; background: #ffffff; border-color: rgba(109,40,217,0.24); box-shadow: 0 0 0 4px rgba(109,40,217,0.08), inset 0 0 0 1px rgba(109,40,217,0.12); }
        .field-file { width: 100%; border-radius: 1rem; border: 1px dashed rgba(109,40,217,0.24); background: linear-gradient(180deg, #fbf9ff 0%, #f4f1ff 100%); padding: 0.8rem; color: rgb(51 65 85); }
        .field-file::file-selector-button { margin-right: 0.75rem; border: 0; border-radius: 0.85rem; background: linear-gradient(135deg, rgb(109 40 217), rgb(168 85 247)); color: white; font-weight: 700; padding: 0.7rem 1rem; cursor: pointer; }
        .form-card { border: 1px solid rgb(228 228 243); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,247,255,0.94)); padding: 1.4rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 14px 30px rgba(15,23,42,0.045); }
        .form-card-head { display: flex; align-items: center; gap: 0.85rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(109,40,217,0.18); margin-bottom: 0.25rem; }
        .form-card-head .material-symbols-outlined { display: inline-flex; align-items: center; justify-content: center; height: 2.4rem; width: 2.4rem; border-radius: 0.85rem; background: linear-gradient(135deg, rgba(109,40,217,0.12), rgba(168,85,247,0.12)); color: rgb(109 40 217); font-size: 1.25rem; }
        .achievement-card { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); }
        .manager-tab { border: 1px solid rgb(226 232 240); border-radius: 999px; padding: 0.7rem 1rem; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(100 116 139); background: white; transition: all .18s ease; }
        .manager-tab.is-active { border-color: rgb(109 40 217); background: rgb(109 40 217); color: white; box-shadow: 0 12px 24px rgba(109,40,217,0.16); }
        .table-wrap { overflow-x: auto; border: 1px solid rgb(226 232 240); border-radius: 1.4rem; }
        .table-shell { width: 100%; min-width: 920px; border-collapse: separate; border-spacing: 0; }
        .table-shell thead th { position: sticky; top: 0; z-index: 1; background: rgb(248 250 252); padding: 1rem; text-align: left; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(100 116 139); }
        .table-shell tbody td { padding: 1rem; vertical-align: top; border-top: 1px solid rgb(226 232 240); color: rgb(51 65 85); font-size: 0.92rem; }
        .row-chip { display: inline-flex; align-items: center; border-radius: 999px; padding: 0.35rem 0.7rem; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; }
        .row-chip.kind-gallery { background: rgb(245 243 255); color: rgb(109 40 217); }
        .row-chip.kind-showcase { background: rgb(237 233 254); color: rgb(91 33 182); }
        .row-chip.status-active { background: rgb(220 252 231); color: rgb(21 128 61); }
        .row-chip.status-hidden { background: rgb(241 245 249); color: rgb(100 116 139); }
        [hidden] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
        @endif

        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#111827_0%,#4c1d95_54%,#c084fc_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(76,29,149,0.22)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-violet-100/80">Achievements Manager</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
                <div>
                    <h1 class="font-headline text-3xl font-extrabold md:text-4xl">{{ $editingAchievement ? 'Update achievement media with cleaner structure.' : 'Build a proper achievement gallery and showcase flow.' }}</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-violet-50/85">The achievement manager now uses 5-item pagination, lets HR decide which gallery category shows first, and supports a student reviews video category too.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Gallery</p><p class="mt-2 text-sm font-semibold text-white">Use existing or new categories</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Showcase</p><p class="mt-2 text-sm font-semibold text-white">Large highlighted cards</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Tables</p><p class="mt-2 text-sm font-semibold text-white">Only 5 rows visible per page</p></div>
                </div>
            </div>
        </section>

        <div class="space-y-6">
            <section class="achievement-card p-6 md:p-7" >
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">{{ $editingAchievement ? 'Edit Achievement' : 'New Achievement' }}</p>
                        <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingAchievement ? 'Update achievement details' : 'Create achievement details' }}</h2>
                    </div>
                    <div class="rounded-[1.2rem] border border-violet-100 bg-violet-50 px-4 py-3 text-sm text-slate-600">
                        Gallery items can now be attached to an existing category
                        <br />
                        or saved under a brand new category name.
                    </div>
                </div>

                <form action="{{ $editingAchievement ? route('hr.achievements.update', $editingAchievement) : route('hr.achievements.store') }}" class="mt-7 space-y-5" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($editingAchievement) @method('PUT') @endif

                    <div class="form-card space-y-5">
                        <div class="form-card-head">
                            <span class="material-symbols-outlined">inventory_2</span>
                            <div>
                                <h3 class="font-headline text-lg font-extrabold text-slate-900">Basic Details</h3>
                                <p class="text-xs text-slate-500">Start by telling us what this item is and how it should be ordered.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="field-shell">
                                <label class="field-label" for="achievement_kind">Content Type</label>
                                <select class="field-select" id="achievement_kind" name="kind" data-achievement-kind-select>
                                    <option value="" disabled @selected(is_null($activeAchievementKind))>Choose what this item is for</option>
                                    <option value="gallery" @selected($activeAchievementKind === 'gallery')>Gallery (image grid)</option>
                                    <option value="showcase" @selected($activeAchievementKind === 'showcase')>Showcase Card (large highlight)</option>
                                </select>
                                <p class="field-help">Pick <strong>Gallery</strong> for image grid items, <strong>Showcase</strong> for the bigger highlight cards below.</p>
                            </div>
                            <div class="field-shell">
                                <label class="field-label" for="achievement_sort_order">Sort Order</label>
                                <input class="field-input" id="achievement_sort_order" name="sort_order" type="number" min="0" placeholder="e.g. 0" value="{{ old('sort_order', $editingAchievement->sort_order ?? 0) }}" />
                                <p class="field-help">Lower numbers appear first. <code>0</code> shows at the top, <code>1</code> next, and so on.</p>
                            </div>
                            <div class="field-shell lg:col-span-2">
                                <label class="field-label" for="achievement_title">Title</label>
                                <input class="field-input" id="achievement_title" name="title" type="text" maxlength="120" placeholder="e.g. Annual Science Exhibition 2025" value="{{ old('title', $editingAchievement->title ?? '') }}" />
                                <p class="field-help">A short, clear heading used in both gallery and showcase views.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-card space-y-5" data-achievement-scope="gallery" @if ($activeAchievementKind !== 'gallery') hidden @endif>
                        <div class="form-card-head">
                            <span class="material-symbols-outlined">collections</span>
                            <div>
                                <h3 class="font-headline text-lg font-extrabold text-slate-900">Gallery Category</h3>
                                <p class="text-xs text-slate-500">Group gallery photos under a category like Seminar, Event, or Workshop.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="field-shell">
                                <label class="field-label" for="achievement_category_mode">Category Source</label>
                                <select class="field-select" id="achievement_category_mode" name="category_mode" data-achievement-category-mode @if ($activeAchievementKind !== 'gallery') disabled @endif>
                                    <option value="existing" @selected($activeCategoryMode === 'existing')>Use an existing category</option>
                                    <option value="new" @selected($activeCategoryMode === 'new')>Create a new category</option>
                                </select>
                                <p class="field-help">Pick <strong>existing</strong> to reuse a category, or <strong>new</strong> to add one.</p>
                            </div>
                            <div class="field-shell">
                                <label class="field-label" for="achievement_gallery_category_order">Category Display Order</label>
                                <input class="field-input" id="achievement_gallery_category_order" name="gallery_category_order" type="number" min="0" placeholder="e.g. 0" value="{{ $activeCategoryOrder }}" @if ($activeAchievementKind !== 'gallery') disabled @endif />
                                <p class="field-help">Use the same number for every photo inside one category. <code>0</code> shows first, larger numbers go lower.</p>
                            </div>
                            <div class="field-shell" data-category-input="existing" @if ($activeAchievementKind !== 'gallery' || $activeCategoryMode !== 'existing') hidden @endif>
                                <label class="field-label" for="achievement_existing_category">Existing Category</label>
                                <select class="field-select" id="achievement_existing_category" name="existing_category" @if ($activeAchievementKind !== 'gallery' || $activeCategoryMode !== 'existing') disabled @endif>
                                    <option value="">— Select a category —</option>
                                    @foreach ($achievementCategories as $category)
                                        <option value="{{ $category }}" @selected(old('existing_category', $editingAchievement->gallery_category ?? '') === $category)>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field-shell" data-category-input="new" @if ($activeAchievementKind !== 'gallery' || $activeCategoryMode !== 'new') hidden @endif>
                                <label class="field-label" for="achievement_new_category">New Category Name</label>
                                <input class="field-input" id="achievement_new_category" name="new_category" type="text" maxlength="60" placeholder="e.g. Award Ceremony" value="{{ old('new_category') }}" @if ($activeAchievementKind !== 'gallery' || $activeCategoryMode !== 'new') disabled @endif />
                                <p class="field-help">Give the new category a short, memorable name.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-card space-y-5" data-achievement-scope="showcase" @if ($activeAchievementKind !== 'showcase') hidden @endif>
                        <div class="form-card-head">
                            <span class="material-symbols-outlined">style</span>
                            <div>
                                <h3 class="font-headline text-lg font-extrabold text-slate-900">Showcase Card Details</h3>
                                <p class="text-xs text-slate-500">These details power the large highlight cards shown under the gallery.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="field-shell">
                                <label class="field-label" for="achievement_eyebrow">Eyebrow Label</label>
                                <input class="field-input" id="achievement_eyebrow" name="eyebrow" type="text" maxlength="40" placeholder="e.g. Student Achievement" value="{{ old('eyebrow', $editingAchievement->eyebrow ?? '') }}" @if ($activeAchievementKind !== 'showcase') disabled @endif />
                                <p class="field-help">A tiny tag shown above the title, like a category name.</p>
                            </div>
                            <div class="field-shell">
                                <label class="field-label" for="achievement_stat">Stat Label</label>
                                <input class="field-input" id="achievement_stat" name="stat" type="text" maxlength="20" placeholder="e.g. 120+" value="{{ old('stat', $editingAchievement->stat ?? '') }}" @if ($activeAchievementKind !== 'showcase') disabled @endif />
                                <p class="field-help">A short stat or number that appears on the card (for example, <code>120+</code> students).</p>
                            </div>
                            <div class="field-shell lg:col-span-2">
                                <label class="field-label" for="achievement_icon">Material Icon Name</label>
                                <input class="field-input" id="achievement_icon" name="icon" type="text" maxlength="40" placeholder="e.g. workspace_premium" value="{{ old('icon', $editingAchievement->icon ?? 'workspace_premium') }}" @if ($activeAchievementKind !== 'showcase') disabled @endif />
                                <p class="field-help">Type the icon name from Google Material Symbols. Examples: <code>workspace_premium</code>, <code>emoji_events</code>, <code>campaign</code>, <code>school</code>.</p>
                            </div>
                        </div>

                        <div class="field-shell">
                            <label class="field-label" for="achievement_copy">Description</label>
                            <textarea class="field-textarea" id="achievement_copy" name="copy" rows="4" maxlength="500" placeholder="Write 2-3 lines describing this achievement…" @if ($activeAchievementKind !== 'showcase') disabled @endif>{{ old('copy', $editingAchievement->copy ?? '') }}</textarea>
                            <p class="field-help">Keep it short and clear. Visitors will read this on the showcase card.</p>
                        </div>
                        <div class="field-shell">
                            <label class="field-label" for="achievement_points">Highlight Points</label>
                            <textarea class="field-textarea" id="achievement_points" name="points" rows="4" maxlength="400" placeholder="National-level winners&#10;Hands-on robotics workshop&#10;Guided by industry mentors" @if ($activeAchievementKind !== 'showcase') disabled @endif>{{ old('points', isset($editingAchievement) ? implode(PHP_EOL, $editingAchievement->points ?? []) : '') }}</textarea>
                            <p class="field-help">Add one bullet point per line. Each line becomes a separate point on the card.</p>
                        </div>
                    </div>

                    <div class="form-card space-y-5">
                        <div class="form-card-head">
                            <span class="material-symbols-outlined">gallery_thumbnail</span>
                            <div>
                                <h3 class="font-headline text-lg font-extrabold text-slate-900">Media Setup</h3>
                                <p class="text-xs text-slate-500">Choose where the photo or video is stored, and how it should be uploaded.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="field-shell">
                                <label class="field-label" for="achievement_media_provider">Storage Option</label>
                                <select class="field-select" id="achievement_media_provider" name="media_provider">
                                    <option value="" disabled @selected(is_null(old('media_provider', $editingAchievement->media_provider ?? null)))>— Choose storage —</option>
                                    <option value="url" @selected(old('media_provider', $editingAchievement->media_provider ?? 'cloudinary') === 'url')>Use a media URL</option>
                                    <option value="local" @selected(old('media_provider', $editingAchievement->media_provider ?? '') === 'local')>Upload to local storage</option>
                                    <option value="cloudflare" @selected(in_array(old('media_provider', $editingAchievement->media_provider ?? ''), ['cloud', 'cloudflare'], true))>Upload to Cloudflare R2</option>
                                    <option value="cloudinary" @selected(old('media_provider', $editingAchievement->media_provider ?? 'cloudinary') === 'cloudinary')>Upload to Cloudinary</option>
                                </select>
                                <p class="field-help">Pick <strong>URL</strong> to paste a link, or one of the upload options to store the file directly.</p>
                            </div>
                            <div class="field-shell">
                                <label class="field-label" for="achievement_media_type">Media Type</label>
                                <select class="field-select" id="achievement_media_type" name="media_type">
                                    <option value="" disabled @selected(is_null(old('media_type', $editingAchievement->media_type ?? null)))>— Choose media type —</option>
                                    <option value="image" @selected(old('media_type', $editingAchievement->media_type ?? 'image') === 'image')>Image (photo)</option>
                                    <option value="video" @selected(old('media_type', $editingAchievement->media_type ?? '') === 'video')>Video (mp4, etc.)</option>
                                </select>
                            </div>
                            <div class="field-shell lg:col-span-2">
                                <label class="field-label" for="achievement_media_file">Upload From Device</label>
                                <input class="field-file" id="achievement_media_file" name="media_file" type="file" accept="image/*,video/*" />
                                <p class="field-help">Use this when storing locally, in Cloudflare R2, or in Cloudinary. Max size depends on the storage option.</p>
                            </div>
                            <div class="field-shell lg:col-span-2">
                                <label class="field-label" for="achievement_media_url">Media URL</label>
                                <input class="field-input" id="achievement_media_url" name="media_url" type="url" placeholder="https://res.cloudinary.com/…/photo.jpg" value="{{ old('media_url', $editingAchievement->media_url ?? '') }}" />
                                <p class="field-help">Paste a public image or video URL when <strong>URL</strong> storage is selected above.</p>
                            </div>
                        </div>
                    </div>

                    <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700">
                        <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingAchievement->is_active ?? true)) />
                        <span>Show this achievement item on the public site</span>
                    </label>
                    <div class="flex flex-wrap gap-3">
                        <button class="rounded-xl bg-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(124,58,237,0.24)]" type="submit">{{ $editingAchievement ? 'Update Achievement' : 'Create Achievement' }}</button>
                        @if ($editingAchievement)
                            <a class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.achievements', ['kind' => $achievementFilter ?? 'gallery']) }}">Cancel</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="achievement-card p-6 md:p-7">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div><p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">Current Content</p><h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Achievement items</h2></div>
                    <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $achievementCount }} items</div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a class="manager-tab {{ ($achievementFilter ?? 'gallery') === 'gallery' ? 'is-active' : '' }}" href="{{ route('hr.achievements', ['kind' => 'gallery']) }}#achievements-table">Gallery</a>
                    <a class="manager-tab {{ ($achievementFilter ?? 'gallery') === 'showcase' ? 'is-active' : '' }}" href="{{ route('hr.achievements', ['kind' => 'showcase']) }}#achievements-table">Showcase</a>
                </div>

                @if ($achievements->isNotEmpty())
                    <div class="table-wrap mt-6" id="achievements-table">
                        <table class="table-shell">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Kind</th>
                                    <th>Media</th>
                                    <th>{{ ($achievementFilter ?? 'gallery') === 'gallery' ? 'Gallery Data' : 'Showcase Data' }}</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($achievements as $achievement)
                                    <tr>
                                        <td>
                                            <div class="font-semibold text-slate-900">{{ $achievement->title ?: 'Untitled item' }}</div>
                                            <div class="mt-2 text-xs text-slate-500">Sort {{ $achievement->sort_order }}</div>
                                        </td>
                                        <td><span class="row-chip kind-{{ $achievement->kind }}">{{ ucfirst($achievement->kind) }}</span></td>
                                        <td>
                                            <div class="font-medium text-slate-700">{{ strtoupper($achievement->media_type ?? 'image') }}</div>
                                            <div class="mt-2 text-xs text-slate-500">{{ match($achievement->media_provider) { 'cloud', 'cloudflare' => 'CLOUDFLARE R2', 'cloudinary' => 'CLOUDINARY', 'local' => 'LOCAL', default => 'URL' } }}</div>
                                        </td>
                                        <td>
                                            @if (($achievementFilter ?? 'gallery') === 'gallery')
                                                <div class="space-y-1 text-sm text-slate-600">
                                                    <div>{{ $achievement->gallery_category ?: 'No category yet' }}</div>
                                                    <div>Category order {{ $achievement->gallery_category_order ?? 0 }}</div>
                                                    <div>{{ $achievement->media_url ? 'Media added' : 'No media URL yet' }}</div>
                                                    <div>{{ $achievement->title ?: 'No gallery title yet' }}</div>
                                                </div>
                                            @else
                                                <div class="space-y-1 text-sm text-slate-600">
                                                    <div>{{ $achievement->eyebrow ?: 'No eyebrow' }}</div>
                                                    <div>{{ $achievement->stat ?: 'No stat label' }}</div>
                                                    <div>{{ $achievement->icon ?: 'No icon name' }}</div>
                                                </div>
                                            @endif
                                        </td>
                                        <td><span class="row-chip {{ $achievement->is_active ? 'status-active' : 'status-hidden' }}">{{ $achievement->is_active ? 'Active' : 'Hidden' }}</span></td>
                                        <td>
                                            <div class="flex flex-wrap gap-2">
                                                <a class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" href="{{ route('hr.achievements', ['edit' => $achievement->id, 'kind' => $achievementFilter ?? 'gallery']) }}">Edit</a>
                                                <form action="{{ route('hr.achievements.destroy', $achievement) }}" method="POST">@csrf @method('DELETE')<button class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600" type="submit">Delete</button></form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (method_exists($achievements, 'links'))
                        <div class="mt-6">
                            {{ $achievements->links() }}
                        </div>
                    @endif
                @else
                    <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No achievement items added yet.</div>
                @endif
            </section>
        </div>
    </div>
</main>
<script>
    (function () {
        var kindSelect = document.querySelector('[data-achievement-kind-select]');
        var scopedFields = Array.prototype.slice.call(document.querySelectorAll('[data-achievement-scope]'));
        var categoryMode = document.querySelector('[data-achievement-category-mode]');
        var categoryInputs = Array.prototype.slice.call(document.querySelectorAll('[data-category-input]'));

        function toggleCategoryInputs(activeMode) {
            categoryInputs.forEach(function (field) {
                var shouldShow = field.getAttribute('data-category-input') === activeMode;
                field.hidden = !shouldShow;
                Array.prototype.slice.call(field.querySelectorAll('input, select')).forEach(function (input) {
                    input.disabled = !shouldShow;
                });
            });
        }

        function toggleScopedFields(activeKind) {
            scopedFields.forEach(function (field) {
                var shouldShow = field.getAttribute('data-achievement-scope') === activeKind;
                field.hidden = !shouldShow;
                Array.prototype.slice.call(field.querySelectorAll('input, select, textarea')).forEach(function (input) {
                    input.disabled = !shouldShow;
                });
            });

            if (activeKind === 'gallery') {
                toggleCategoryInputs(categoryMode ? categoryMode.value : 'existing');
            } else {
                categoryInputs.forEach(function (field) {
                    field.hidden = true;
                    Array.prototype.slice.call(field.querySelectorAll('input, select')).forEach(function (input) {
                        input.disabled = true;
                    });
                });
            }
        }

        if (kindSelect) {
            toggleScopedFields(kindSelect.value);
            kindSelect.addEventListener('change', function () {
                toggleScopedFields(kindSelect.value);
            });
        }

        if (categoryMode) {
            categoryMode.addEventListener('change', function () {
                if (!kindSelect || kindSelect.value === 'gallery') {
                    toggleCategoryInputs(categoryMode.value);
                }
            });
        }
    }());
</script>
</body>
</html>


