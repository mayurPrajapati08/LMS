@php
    $activeStoryType = old('type', $editingStory->type ?? ($storyFilter ?? 'placement'));
    $storyCount = method_exists($stories, 'total') ? $stories->total() : $stories->count();
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Stories | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .field-shell { border: 1px solid rgb(214 228 240); border-radius: 1.35rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(246,250,253,0.94)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 10px 24px rgba(15,23,42,0.035); }
        .field-label { display: block; margin-bottom: 0.45rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(14 116 144); }
        .field-help { margin-top: 0.45rem; font-size: 0.78rem; line-height: 1.45; color: rgb(100 116 139); }
        .field-input, .field-select, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.9); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(148,163,184,0.18); transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease; }
        .field-input::placeholder, .field-textarea::placeholder { color: rgb(148 163 184); }
        .field-input, .field-select { min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 8.5rem; padding: 1rem; resize: vertical; }
        .field-input:focus, .field-select:focus, .field-textarea:focus { outline: none; background: #ffffff; border-color: rgba(14,116,144,0.24); box-shadow: 0 0 0 4px rgba(14,116,144,0.08), inset 0 0 0 1px rgba(14,116,144,0.12); }
        .field-file { width: 100%; border-radius: 1rem; border: 1px dashed rgba(14,116,144,0.24); background: linear-gradient(180deg, #f8fbfd 0%, #f1f7fb 100%); padding: 0.8rem; color: rgb(51 65 85); }
        .field-file::file-selector-button { margin-right: 0.75rem; border: 0; border-radius: 0.85rem; background: linear-gradient(135deg, rgb(14 116 144), rgb(2 132 199)); color: white; font-weight: 700; padding: 0.7rem 1rem; cursor: pointer; }
        .story-card { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); }
        .manager-tab { border: 1px solid rgb(226 232 240); border-radius: 999px; padding: 0.7rem 1rem; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(100 116 139); background: white; transition: all .18s ease; }
        .manager-tab.is-active { border-color: rgb(14 116 144); background: rgb(14 116 144); color: white; box-shadow: 0 12px 24px rgba(14,116,144,0.16); }
        .table-wrap { overflow-x: auto; border: 1px solid rgb(226 232 240); border-radius: 1.4rem; }
        .table-shell { width: 100%; min-width: 920px; border-collapse: separate; border-spacing: 0; }
        .table-shell thead th { position: sticky; top: 0; z-index: 1; background: rgb(248 250 252); padding: 1rem; text-align: left; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(100 116 139); }
        .table-shell tbody td { padding: 1rem; vertical-align: top; border-top: 1px solid rgb(226 232 240); color: rgb(51 65 85); font-size: 0.92rem; }
        .row-chip { display: inline-flex; align-items: center; border-radius: 999px; padding: 0.35rem 0.7rem; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; }
        .row-chip.type-placement { background: rgb(224 242 254); color: rgb(3 105 161); }
        .row-chip.type-success_story { background: rgb(240 253 250); color: rgb(13 148 136); }
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

        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#082f49_0%,#0369a1_58%,#7dd3fc_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(3,105,161,0.20)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-sky-100/80">Stories Manager</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div>
                    <h1 class="font-headline text-3xl font-extrabold md:text-4xl">{{ $editingStory ? 'Update homepage story content cleanly.' : 'Create polished placement and success story cards.' }}</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-sky-50/85">The list is now compact and tabular, while the form only shows the fields that matter for the selected story type.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Layout</p><p class="mt-2 text-sm font-semibold text-white">Compact table instead of long card scroll</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Switching</p><p class="mt-2 text-sm font-semibold text-white">Placement and success story tabs</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-100/70">Forms</p><p class="mt-2 text-sm font-semibold text-white">Only relevant inputs stay visible</p></div>
                </div>
            </div>
        </section>

        <div class="space-y-6">
            <section class="story-card p-6 md:p-7">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">{{ $editingStory ? 'Edit Story' : 'New Story' }}</p>
                        <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingStory ? 'Update story details' : 'Create story details' }}</h2>
                    </div>
                    <div class="rounded-[1.2rem] border border-sky-100 bg-sky-50 px-4 py-3 text-sm text-slate-600">
                        Placement shows company, role, package, and placement date.
                        <br />
                        Success Story keeps only the general learner story fields.
                    </div>
                </div>

                <form action="{{ $editingStory ? route('hr.stories.update', $editingStory) : route('hr.stories.store') }}" class="mt-7 space-y-5" method="POST" enctype="multipart/form-data" data-story-form>
                    @csrf
                    @if ($editingStory) @method('PUT') @endif

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell lg:col-span-2">
                            <label class="field-label" for="story_type">Story Type</label>
                            <select class="field-select" id="story_type" name="type" data-story-type-select>
                                <option value="placement" @selected($activeStoryType === 'placement')>Placement</option>
                                <option value="success_story" @selected($activeStoryType === 'success_story')>Success Story</option>
                            </select>
                            <p class="field-help">Choose where this item should appear on the public site.</p>
                        </div>

                        <div class="field-shell"><label class="field-label" for="story_name">Student Name</label><input class="field-input" id="story_name" name="name" type="text" value="{{ old('name', $editingStory->name ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label" for="story_course">Course Or Track</label><input class="field-input" id="story_course" name="course" type="text" value="{{ old('course', $editingStory->course ?? '') }}" /></div>
                        <div class="field-shell"><label class="field-label" for="story_rating">Rating</label><input class="field-input" id="story_rating" max="5" min="1" name="rating" type="number" value="{{ old('rating', $editingStory->rating ?? 5) }}" /><p class="field-help">Use a value from 1 to 5.</p></div>
                        <div class="field-shell" data-story-scope="placement" @if ($activeStoryType !== 'placement') hidden @endif>
                            <label class="field-label" for="story_shared_at">Placement Date</label>
                            <input class="field-input" id="story_shared_at" name="shared_at" type="date" value="{{ old('shared_at', optional($editingStory->shared_at ?? null)->format('Y-m-d')) }}" @if ($activeStoryType !== 'placement') disabled @endif />
                            <p class="field-help">Only visible for placement entries.</p>
                        </div>
                        <div class="field-shell" data-story-scope="placement" @if ($activeStoryType !== 'placement') hidden @endif>
                            <label class="field-label" for="story_company">Placed Company</label>
                            <input class="field-input" id="story_company" name="company" type="text" value="{{ old('company', $editingStory->company ?? '') }}" @if ($activeStoryType !== 'placement') disabled @endif />
                        </div>
                        <div class="field-shell" data-story-scope="placement" @if ($activeStoryType !== 'placement') hidden @endif>
                            <label class="field-label" for="story_role">Job Role</label>
                            <input class="field-input" id="story_role" name="role" type="text" value="{{ old('role', $editingStory->role ?? '') }}" @if ($activeStoryType !== 'placement') disabled @endif />
                        </div>
                        <div class="field-shell" data-story-scope="placement" @if ($activeStoryType !== 'placement') hidden @endif>
                            <label class="field-label" for="story_package">Package</label>
                            <input class="field-input" id="story_package" name="package" type="text" value="{{ old('package', $editingStory->package ?? '') }}" @if ($activeStoryType !== 'placement') disabled @endif />
                        </div>
                        <div class="field-shell" data-story-scope="placement" @if ($activeStoryType !== 'placement') hidden @endif>
                            <label class="field-label" for="show_in_placement_hero">Placement Hero Card</label>
                            <label class="flex items-center gap-3 rounded-[1rem] border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700">
                                <input id="show_in_placement_hero" name="show_in_placement_hero" type="checkbox" value="1" @checked(old('show_in_placement_hero', $editingStory->show_in_placement_hero ?? false)) @if ($activeStoryType !== 'placement') disabled @endif />
                                Show this student inside the animated placement hero stack
                            </label>
                            <p class="field-help">Only checked students appear in the public placement hero animation.</p>
                        </div>
                        <div class="field-shell"><label class="field-label" for="story_sort_order">Sort Order</label><input class="field-input" id="story_sort_order" name="sort_order" type="number" value="{{ old('sort_order', $editingStory->sort_order ?? 0) }}" /><p class="field-help">`0` shows first, `1` shows second, and so on.</p></div>
                    </div>

                    <div class="rounded-[1.6rem] border border-sky-100 bg-[linear-gradient(180deg,#f8fdff_0%,#eff8ff_100%)] p-5">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined rounded-full bg-sky-100 p-2 text-sky-700">perm_media</span>
                            <div>
                                <h3 class="font-headline text-xl font-extrabold text-slate-900">Media Source</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Paste a direct media URL or upload a file from the device.</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-4 lg:grid-cols-[1fr_1fr]">
                            <div class="field-shell"><label class="field-label" for="story_media_provider">Storage Option</label><select class="field-select" id="story_media_provider" name="media_provider"><option value="url" @selected(old('media_provider', $editingStory->media_provider ?? 'url') === 'url')>Use media URL</option><option value="local" @selected(old('media_provider', $editingStory->media_provider ?? '') === 'local')>Upload to local storage</option><option value="cloud" @selected(old('media_provider', $editingStory->media_provider ?? '') === 'cloud')>Upload to cloud storage</option></select></div>
                            <div class="field-shell"><label class="field-label" for="story_media_type">Media Type</label><select class="field-select" id="story_media_type" name="media_type"><option value="image" @selected(old('media_type', $editingStory->media_type ?? 'image') === 'image')>Image</option><option value="video" @selected(old('media_type', $editingStory->media_type ?? '') === 'video')>Video</option></select></div>
                            <div class="field-shell lg:col-span-2"><label class="field-label" for="story_media_file">Upload From Device</label><input class="field-file" id="story_media_file" name="media_file" type="file" /><p class="field-help">Choose a file only when using local or cloud upload.</p></div>
                            <div class="field-shell lg:col-span-2"><label class="field-label" for="story_avatar">Media URL</label><input class="field-input" id="story_avatar" name="avatar" type="text" value="{{ old('avatar', $editingStory->avatar ?? '') }}" /><p class="field-help">Paste a public image or video URL when `Use media URL` is selected.</p></div>
                        </div>
                    </div>

                    <div class="field-shell"><label class="field-label" for="story_comment">{{ $activeStoryType === 'placement' ? 'Placement Story' : 'Success Story' }}</label><textarea class="field-textarea" id="story_comment" name="comment" rows="6">{{ old('comment', $editingStory->comment ?? '') }}</textarea><p class="field-help">Write a clean learner quote or story in a natural tone.</p></div>

                    <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingStory->is_active ?? true)) />Show this story on the public site</label>

                    <div class="flex flex-wrap gap-3">
                        <button class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(2,132,199,0.22)]" type="submit">{{ $editingStory ? 'Update Story' : 'Create Story' }}</button>
                        @if ($editingStory)
                            <a class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.stories') }}">Cancel</a>
                        @endif
                    </div>
                </form>
            </section>

            <section class="story-card p-6 md:p-7" data-story-list id="stories-table">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-sky-700">Current Content</p>
                        <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Homepage stories</h2>
                    </div>
                    <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $storyCount }} items</div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a class="manager-tab {{ ($storyFilter ?? 'placement') === 'placement' ? 'is-active' : '' }}" href="{{ route('hr.stories', ['type' => 'placement']) }}#stories-table">Placements</a>
                    <a class="manager-tab {{ ($storyFilter ?? 'placement') === 'success_story' ? 'is-active' : '' }}" href="{{ route('hr.stories', ['type' => 'success_story']) }}#stories-table">Success Stories</a>
                </div>

                @if ($stories->isNotEmpty())
                    <div class="table-wrap mt-6">
                        <table class="table-shell">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Track</th>
                                    @if (($storyFilter ?? 'placement') === 'placement')
                                        <th>Placement Data</th>
                                    @else
                                        <th>Story Data</th>
                                    @endif
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stories as $story)
                                    <tr>
                                        <td>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-slate-900">{{ $story->name }}</div>
                                                <div class="mt-2">
                                                    <span class="row-chip type-{{ $story->type }}">{{ $story->type === 'placement' ? 'Placement' : 'Success Story' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-medium text-slate-700">{{ $story->course ?: 'Not added' }}</div>
                                            <div class="mt-2 text-xs text-slate-500">Sort {{ $story->sort_order }}</div>
                                        </td>
                                        <td>
                                            @if (($storyFilter ?? 'placement') === 'placement')
                                                <div class="space-y-1">
                                                    <div>{{ $story->company ?: 'Company not added' }}</div>
                                                    <div class="text-sm text-slate-500">{{ $story->role ?: 'Role not added' }}</div>
                                                    <div class="text-sm text-slate-500">{{ $story->package ?: 'Package not added' }}</div>
                                                    <div class="text-sm font-medium text-sky-700">{{ optional($story->shared_at)->format('d M Y') ?: 'Date not added' }}</div>
                                                </div>
                                            @else
                                                <div class="max-w-[18rem] text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($story->comment, 140) }}</div>
                                            @endif
                                        </td>
                                        <td><span class="font-semibold text-slate-900">{{ $story->rating ?? 5 }}/5</span></td>
                                        <td><span class="row-chip {{ $story->is_active ? 'status-active' : 'status-hidden' }}">{{ $story->is_active ? 'Active' : 'Hidden' }}</span></td>
                                        <td>
                                            <div class="flex flex-wrap gap-2">
                                                <a class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700" href="{{ route('hr.stories', ['edit' => $story->id]) }}">Edit</a>
                                                <form action="{{ route('hr.stories.destroy', $story) }}" method="POST">@csrf @method('DELETE')<button class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600" type="submit">Delete</button></form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (method_exists($stories, 'links'))
                        <div class="mt-6">
                            {{ $stories->links() }}
                        </div>
                    @endif
                @else
                    <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No stories added yet.</div>
                @endif
            </section>
        </div>
    </div>
</main>
<script>
    (function () {
        var typeSelect = document.querySelector('[data-story-type-select]');
        var commentLabel = document.querySelector('label[for="story_comment"]');
        var scopedFields = Array.prototype.slice.call(document.querySelectorAll('[data-story-scope]'));

        function toggleScopedFields(activeType) {
            scopedFields.forEach(function (field) {
                var shouldShow = field.getAttribute('data-story-scope') === activeType;
                field.hidden = !shouldShow;
                Array.prototype.slice.call(field.querySelectorAll('input, select, textarea')).forEach(function (input) {
                    input.disabled = !shouldShow;
                });
            });

            if (commentLabel) {
                commentLabel.textContent = activeType === 'placement' ? 'Placement Story' : 'Success Story';
            }
        }

        if (typeSelect) {
            toggleScopedFields(typeSelect.value);
            typeSelect.addEventListener('change', function () {
                toggleScopedFields(typeSelect.value);
            });
        }
    }());
</script>
</body>
</html>
