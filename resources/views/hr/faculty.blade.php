<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Faculty | HR Dashboard</title>
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
        .field-textarea { min-height: 7rem; resize: vertical; }
        .field-input:focus, .field-textarea:focus { outline: none; background: #fff; border-color: rgba(109,40,217,0.24); box-shadow: 0 0 0 4px rgba(109,40,217,0.08), inset 0 0 0 1px rgba(109,40,217,0.12); }
        .field-input::placeholder, .field-textarea::placeholder { color: rgb(148 163 184); }
        .field-select { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.92); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(167,139,250,0.16); min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-select:focus { outline: none; background: #fff; border-color: rgba(109,40,217,0.24); box-shadow: 0 0 0 4px rgba(109,40,217,0.08), inset 0 0 0 1px rgba(109,40,217,0.12); }
        .field-help { margin-top: 0.45rem; font-size: 0.78rem; line-height: 1.45; color: rgb(100 116 139); }
        .form-card { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); padding: 1.4rem; box-shadow: 0 18px 40px rgba(15,23,42,0.06); }
        .form-card-head { display: flex; align-items: center; gap: 0.9rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(124,58,237,0.18); margin-bottom: 0.25rem; }
        .panel { border: 1px solid rgb(226 232 240); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 40px rgba(15,23,42,0.06); }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>@endif
        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#111827_0%,#4c1d95_54%,#c084fc_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(76,29,149,0.22)]">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-violet-100/80">Faculty Manager</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div><h1 class="font-headline text-3xl font-extrabold md:text-4xl">Manage homepage faculty cards with a cleaner editing flow.</h1><p class="mt-4 max-w-3xl text-sm leading-7 text-violet-50/85">Faculty members are now shown in a more organized management layout so it is easier to scan, edit, and save homepage card details.</p></div>
                <div class="grid gap-3 sm:grid-cols-3"><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Visibility</p><p class="mt-2 text-sm font-semibold text-white">Control homepage display</p></div><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Headline</p><p class="mt-2 text-sm font-semibold text-white">Refine faculty card title</p></div><div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Order</p><p class="mt-2 text-sm font-semibold text-white">Set display sequence</p></div></div>
            </div>
        </section>
        <section class="panel p-6 md:p-7">
            <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">Faculty Cards</p><h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Faculty homepage management</h2></div><div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $facultyMembers->count() }} members</div></div>
            <div class="mt-6 space-y-5">
                @foreach ($facultyMembers as $member)
                    <form action="{{ route('hr.faculty.update', $member) }}" class="form-card space-y-5" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-card-head">
                            <img alt="{{ $member->name }}" class="h-12 w-12 rounded-2xl object-cover" src="{{ $member->avatarUrl(160) }}" />
                            <div>
                                <h3 class="font-headline text-lg font-extrabold text-slate-900">{{ $member->name }}</h3>
                                <p class="text-xs text-slate-500">{{ $member->courses_count }} published courses</p>
                            </div>
                        </div>

                        <div class="grid gap-5 xl:grid-cols-[1fr_1.2fr]">
                            <div class="grid gap-4">
                                <label class="flex items-center gap-3 rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700">
                                    <input name="show_on_homepage" type="checkbox" value="1" @checked(old('show_on_homepage', $member->show_on_homepage)) />
                                    <span>Show this faculty card on public pages</span>
                                </label>
                                <div class="field-shell">
                                    <label class="field-label" for="faculty_sort_order_{{ $member->id }}">Sort Order</label>
                                    <input class="field-input" id="faculty_sort_order_{{ $member->id }}" name="faculty_sort_order" type="number" min="0" placeholder="e.g. 0" value="{{ old('faculty_sort_order', $member->faculty_sort_order) }}" />
                                    <p class="field-help">Lower numbers appear first on the homepage (0 = top).</p>
                                </div>
                                <div class="field-shell">
                                    <label class="field-label" for="faculty_headline_{{ $member->id }}">Card Headline</label>
                                    <input class="field-input" id="faculty_headline_{{ $member->id }}" name="faculty_headline" type="text" maxlength="120" placeholder="e.g. Robotics Mentor with 10+ Years of Experience" value="{{ old('faculty_headline', $member->faculty_headline) }}" />
                                    <p class="field-help">Shown under the faculty name on the public homepage.</p>
                                </div>
                            </div>
                            <div class="grid gap-4">
                                <div class="field-shell">
                                    <label class="field-label" for="bio_{{ $member->id }}">Faculty Bio</label>
                                    <textarea class="field-textarea" id="bio_{{ $member->id }}" name="bio" rows="5" maxlength="600" placeholder="A short biography shown on the public homepage. Keep it to 2-3 lines.">{{ old('bio', $member->bio) }}</textarea>
                                    <p class="field-help">Visitors see this on the homepage card. Mention specialty and years of experience.</p>
                                </div>
                                <div class="flex justify-end">
                                    <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(124,58,237,0.24)]" type="submit">
                                        <span class="material-symbols-outlined text-[18px]">save</span>
                                        Save Faculty Card
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </section>
    </div>
</main>
</body>
</html>


