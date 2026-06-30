@php
    $activeVideoProvider = old('video_provider', $founderMedia->video_provider ?? 'cloudinary');
    $activePosterProvider = old('poster_provider', $founderMedia->poster_provider ?? 'cloudinary');
    $activeVideoProvider = $activeVideoProvider === 'cloud' ? 'cloudflare' : $activeVideoProvider;
    $activePosterProvider = $activePosterProvider === 'cloud' ? 'cloudflare' : $activePosterProvider;
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Founder Media | HR Dashboard</title>
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
        .field-input, .field-select, .field-textarea { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.92); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(148,163,184,0.18); transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease; }
        .field-input, .field-select { min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 8rem; padding: 1rem; resize: vertical; }
        .field-input:focus, .field-select:focus, .field-textarea:focus { outline: none; background: #fff; border-color: rgba(14,116,144,0.24); box-shadow: 0 0 0 4px rgba(14,116,144,0.08), inset 0 0 0 1px rgba(14,116,144,0.12); }
        .field-file { width: 100%; border-radius: 1rem; border: 1px dashed rgba(14,116,144,0.26); background: linear-gradient(180deg, #f8fdff 0%, #eff8fd 100%); padding: 0.8rem; color: rgb(51 65 85); }
        .field-file::file-selector-button { margin-right: 0.75rem; border: 0; border-radius: 0.85rem; background: linear-gradient(135deg, rgb(14 116 144), rgb(59 130 246)); color: white; font-weight: 700; padding: 0.7rem 1rem; cursor: pointer; }
        .panel { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15,23,42,0.06); }
        .form-card { border: 1px solid rgb(214 228 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(238,247,255,0.94)); padding: 1.4rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 14px 30px rgba(15,23,42,0.045); }
        .form-card-head { display: flex; align-items: center; gap: 0.85rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(124,58,237,0.18); margin-bottom: 0.25rem; }
        .form-card-head .material-symbols-outlined { display: inline-flex; align-items: center; justify-content: center; height: 2.4rem; width: 2.4rem; border-radius: 0.85rem; background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(168,85,247,0.12)); color: rgb(124 58 237); font-size: 1.25rem; }
        [hidden] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-5xl space-y-8">
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif

        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#111827_0%,#312e81_58%,#7c3aed_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(49,46,129,0.20)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-violet-100/80">Founder Media</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div>
                    <h1 class="font-headline text-3xl font-extrabold md:text-4xl">Manage the founder video slot separately.</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-violet-50/85">This keeps the homepage founder card looking exactly the same while letting HR control the video and poster from here.</p>
                </div>
                <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Media Options</p>
                    <p class="mt-2 text-sm font-semibold text-white">Use direct URLs or upload to local storage, Cloudflare R2, or Cloudinary for both video and poster.</p>
                </div>
            </div>
        </section>

        <section class="panel p-6 md:p-7">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">Founder Slot</p>
                <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">Update founder homepage media</h2>
            </div>

            <form action="{{ route('hr.founder-media.update') }}" class="mt-7 space-y-6" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-card space-y-5">
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">badge</span>
                        <div>
                            <h3 class="font-headline text-lg font-extrabold text-slate-900">Founder Card Copy</h3>
                            <p class="text-xs text-slate-500">The eyebrow, title, and supporting text shown next to the video.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell">
                            <label class="field-label" for="founder_eyebrow">Eyebrow</label>
                            <input class="field-input" id="founder_eyebrow" name="eyebrow" type="text" maxlength="60" placeholder="e.g. Meet The Founder" value="{{ old('eyebrow', $founderMedia->eyebrow ?? '') }}" />
                            <p class="field-help">A short tag shown above the title.</p>
                        </div>
                        <div class="field-shell">
                            <label class="field-label" for="founder_badge">Badge</label>
                            <input class="field-input" id="founder_badge" name="badge" type="text" maxlength="40" placeholder="e.g. Founder Story" value="{{ old('badge', $founderMedia->badge ?? '') }}" />
                            <p class="field-help">Optional badge text shown on the video card.</p>
                        </div>
                        <div class="field-shell lg:col-span-2">
                            <label class="field-label" for="founder_title">Title</label>
                            <input class="field-input" id="founder_title" name="title" type="text" maxlength="120" placeholder="e.g. Building CYIS with a Student-First Mindset" value="{{ old('title', $founderMedia->title ?? '') }}" />
                        </div>
                        <div class="field-shell lg:col-span-2">
                            <label class="field-label" for="founder_description">Description</label>
                            <textarea class="field-textarea" id="founder_description" name="description" rows="4" maxlength="500" placeholder="A short paragraph introducing the founder and their story.">{{ old('description', $founderMedia->description ?? '') }}</textarea>
                            <p class="field-help">Visitors will read this next to the founder video.</p>
                        </div>
                    </div>
                </div>

                <div class="form-card space-y-5">
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">smart_display</span>
                        <div>
                            <h3 class="font-headline text-lg font-extrabold text-slate-900">Video Setup</h3>
                            <p class="text-xs text-slate-500">Choose the same media flow used elsewhere in HR: URL, local upload, Cloudflare R2, or Cloudinary.</p>
                        </div>
                    </div>
                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell">
                            <label class="field-label" for="founder_video_provider">Storage Option</label>
                            <select class="field-select" id="founder_video_provider" name="video_provider" data-provider-select="video">
                                <option value="" disabled @selected(is_null($activeVideoProvider))>— Choose storage —</option>
                                <option value="url" @selected($activeVideoProvider === 'url')>Use video URL</option>
                                <option value="local" @selected($activeVideoProvider === 'local')>Upload to local storage</option>
                                <option value="cloudflare" @selected($activeVideoProvider === 'cloudflare')>Upload to Cloudflare R2</option>
                                <option value="cloudinary" @selected($activeVideoProvider === 'cloudinary')>Upload to Cloudinary</option>
                            </select>
                            <p class="field-help">Pick <strong>URL</strong> to paste a hosted video link, or choose an upload option.</p>
                        </div>
                        <div class="field-shell" data-provider-mode="video" data-provider-view="file" @if ($activeVideoProvider === 'url') hidden @endif>
                            <label class="field-label" for="founder_video_file">Upload From Device</label>
                            <input class="field-file" id="founder_video_file" name="video_file" type="file" accept="video/mp4,video/webm,video/ogg,video/quicktime" />
                            <p class="field-help">Use MP4, WebM, OGG, or MOV. Leave empty to keep the current video.</p>
                        </div>
                        <div class="field-shell lg:col-span-2" data-provider-mode="video" data-provider-view="url" @if ($activeVideoProvider !== 'url') hidden @endif>
                            <label class="field-label" for="founder_video_url">Video URL</label>
                            <input class="field-input" id="founder_video_url" name="video_url" type="url" placeholder="https://res.cloudinary.com/.../founder.mp4" value="{{ old('video_url', $founderMedia->video_url ?? '') }}" />
                            <p class="field-help">Leave blank if you want the founder card to show only the poster image.</p>
                        </div>
                    </div>
                </div>

                <div class="form-card space-y-5">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined rounded-full bg-violet-100 p-2 text-violet-700">image</span>
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">image</span>
                        <div>
                            <h3 class="font-headline text-lg font-extrabold text-slate-900">Poster Setup</h3>
                            <p class="text-xs text-slate-500">Set the poster that appears before play and when no video is present.</p>
                        </div>
                    </div>
                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell">
                            <label class="field-label" for="founder_poster_provider">Storage Option</label>
                            <select class="field-select" id="founder_poster_provider" name="poster_provider" data-provider-select="poster">
                                <option value="" disabled @selected(is_null($activePosterProvider))>— Choose storage —</option>
                                <option value="url" @selected($activePosterProvider === 'url')>Use image URL</option>
                                <option value="local" @selected($activePosterProvider === 'local')>Upload to local storage</option>
                                <option value="cloudflare" @selected($activePosterProvider === 'cloudflare')>Upload to Cloudflare R2</option>
                                <option value="cloudinary" @selected($activePosterProvider === 'cloudinary')>Upload to Cloudinary</option>
                            </select>
                            <p class="field-help">Pick <strong>URL</strong> to paste a hosted image, or choose an upload option.</p>
                        </div>
                        <div class="field-shell" data-provider-mode="poster" data-provider-view="file" @if ($activePosterProvider === 'url') hidden @endif>
                            <label class="field-label" for="founder_poster_file">Upload From Device</label>
                            <input class="field-file" id="founder_poster_file" name="poster_file" type="file" accept="image/jpeg,image/png,image/webp,image/gif" />
                            <p class="field-help">Use JPG, PNG, WEBP, or GIF. Leave empty to keep the current poster.</p>
                        </div>
                        <div class="field-shell lg:col-span-2" data-provider-mode="poster" data-provider-view="url" @if ($activePosterProvider !== 'url') hidden @endif>
                            <label class="field-label" for="founder_poster_url">Poster Image URL</label>
                            <input class="field-input" id="founder_poster_url" name="poster_url" type="url" placeholder="https://res.cloudinary.com/.../founder-poster.jpg" value="{{ old('poster_url', $founderMedia->poster_url ?? '') }}" />
                            <p class="field-help">Paste a public poster image URL when <strong>URL</strong> storage is selected.</p>
                        </div>
                    </div>
                </div>

                <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $founderMedia->is_active ?? true)) />
                    <span>Show this founder media on the homepage</span>
                </label>

                <div class="flex flex-wrap gap-3">
                    <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(124,58,237,0.22)]" type="submit">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Save Founder Media
                    </button>
                </div>
            </form>
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



