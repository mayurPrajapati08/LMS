@php
    $employmentOptions = ['Full Time', 'Part Time', 'Contract', 'Internship', 'Freelance'];
    $workModeOptions = ['On-site', 'Remote', 'Hybrid'];
    $accentOptions = [
        'from-[#13041f] via-[#4c1d95] to-[#9d5cff]',
        'from-[#1d1242] via-[#1d4ed8] to-[#2dd4bf]',
        'from-[#140d2e] via-[#5b21b6] to-[#f59e0b]',
        'from-[#14314b] via-[#0f766e] to-[#7dd3c8]',
        'from-[#1f1147] via-[#6d28d9] to-[#c084fc]',
    ];
    $gradientToCss = static function (string $gradient): string {
        $normalized = str_replace(['from-[', ' via-[', ' to-['], '|', $gradient);
        $normalized = str_replace(']', '', $normalized);
        $colors = array_values(array_filter(array_map('trim', explode('|', $normalized))));
        return implode(', ', $colors);
    };
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Jobs | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }

        .job-chip { display: inline-flex; align-items: center; gap: 0.4rem; border-radius: 999px; padding: 0.3rem 0.7rem; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; }
        .job-chip__dot { height: 0.45rem; width: 0.45rem; border-radius: 999px; }
        .job-chip--active { background: rgba(16, 185, 129, 0.12); color: rgb(6 95 70); }
        .job-chip--active .job-chip__dot { background: rgb(16 185 129); }
        .job-chip--hidden { background: rgba(100, 116, 139, 0.16); color: rgb(71 85 105); }
        .job-chip--hidden .job-chip__dot { background: rgb(100 116 139); }

        .jh-field { position: relative; display: flex; flex-direction: column; gap: 0.4rem; min-width: 0; }
        .jh-field__head { display: flex; align-items: baseline; justify-content: space-between; gap: 0.6rem; padding: 0 0.2rem; }
        .jh-field__label { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.18em; text-transform: uppercase; color: rgb(71 85 105); }
        .jh-field__icon { display: inline-flex; align-items: center; justify-content: center; width: 1.4rem; height: 1.4rem; border-radius: 0.55rem; background: rgba(124, 58, 237, 0.12); color: rgb(109 40 217); font-size: 14px; }
        .jh-field__hint { font-size: 0.7rem; font-weight: 600; color: rgb(100 116 139); }
        .jh-input, .jh-textarea, .jh-select { width: 100%; border-radius: 1.05rem; border: 1px solid rgba(124, 58, 237, 0.18); background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.92)); color: rgb(15 23 42); min-height: 3.1rem; padding: 0.85rem 1.05rem; font-size: 0.92rem; font-weight: 600; box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.9); transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease; }
        .jh-textarea { min-height: 8.5rem; line-height: 1.55; resize: vertical; }
        .jh-select { appearance: none; -webkit-appearance: none; background-image: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.92)), url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'><path fill='%237c3aed' d='M6 8 0 0h12z'/></svg>"); background-repeat: no-repeat, no-repeat; background-position: 0 0, right 1rem center; background-size: 100% 100%, 12px 8px; padding-right: 2.6rem; }
        .jh-input::placeholder, .jh-textarea::placeholder { color: rgb(148 163 184); font-weight: 500; }
        .jh-input:hover, .jh-textarea:hover, .jh-select:hover { border-color: rgba(124, 58, 237, 0.32); }
        .jh-input:focus, .jh-textarea:focus, .jh-select:focus { outline: none; border-color: rgba(124, 58, 237, 0.55); background: #fff; box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.10), 0 12px 28px rgba(15, 23, 42, 0.06); }

        .form-card { border: 1px solid rgba(124, 58, 237, 0.18); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(245,243,255,0.94)); padding: 1.4rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 14px 30px rgba(15,23,42,0.045); }
        .form-card-head { display: flex; align-items: center; gap: 0.85rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(124,58,237,0.18); margin-bottom: 0.25rem; }
        .form-card-head .material-symbols-outlined { display: inline-flex; align-items: center; justify-content: center; height: 2.4rem; width: 2.4rem; border-radius: 0.85rem; background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(168,85,247,0.12)); color: rgb(124 58 237); font-size: 1.25rem; }
        .jh-toggle { display: flex; align-items: center; gap: 0.85rem; padding: 0.9rem 1rem; border-radius: 1.05rem; border: 1px solid rgba(124, 58, 237, 0.18); background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.92)); cursor: pointer; user-select: none; }
        .jh-toggle input { display: none; }
        .jh-toggle__track { position: relative; width: 2.6rem; height: 1.4rem; border-radius: 999px; background: rgba(124, 58, 237, 0.18); transition: background 0.18s ease; flex: 0 0 auto; }
        .jh-toggle__thumb { position: absolute; top: 2px; left: 2px; width: 1.1rem; height: 1.1rem; border-radius: 999px; background: #fff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2); transition: transform 0.18s ease; }
        .jh-toggle input:checked + .jh-toggle__track { background: rgb(16 185 129); }
        .jh-toggle input:checked + .jh-toggle__track .jh-toggle__thumb { transform: translateX(1.2rem); }
        .jh-toggle__text { display: flex; flex-direction: column; gap: 0.15rem; font-size: 0.85rem; font-weight: 700; color: rgb(15 23 42); }
        .jh-toggle__text small { font-size: 0.7rem; font-weight: 600; color: rgb(100 116 139); letter-spacing: 0.02em; }

        .accent-swatches { display: flex; flex-wrap: wrap; gap: 0.55rem; }
        .accent-swatch { position: relative; width: 3.4rem; height: 2.2rem; border-radius: 0.65rem; cursor: pointer; border: 2px solid transparent; transition: transform 0.18s ease, border-color 0.18s ease; }
        .accent-swatch:hover { transform: translateY(-2px); }
        .accent-swatch input { display: none; }
        .accent-swatch input:checked + .accent-swatch__bg { border-color: rgb(124 58 237); box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.18); }
        .accent-swatch__bg { position: absolute; inset: 0; border-radius: 0.55rem; border: 2px solid transparent; }

        .job-card { position: relative; display: grid; grid-template-columns: 1fr auto; gap: 1.25rem; padding: 1.25rem 1.4rem; border-radius: 1.4rem; border: 1px solid rgb(226 232 240); background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(248,250,252,0.96)); box-shadow: 0 14px 34px rgba(15, 23, 42, 0.04); transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease; }
        .job-card:hover { border-color: rgba(124, 58, 237, 0.32); box-shadow: 0 22px 50px rgba(124, 58, 237, 0.10); transform: translateY(-1px); }
        .job-card__gradient { position: absolute; inset: 0; border-radius: inherit; pointer-events: none; opacity: 0.06; }
        .job-card__title { display: flex; flex-wrap: wrap; align-items: center; gap: 0.6rem; font-family: Manrope, sans-serif; font-size: 1.05rem; font-weight: 800; color: rgb(15 23 42); }
        .job-card__meta { display: flex; flex-wrap: wrap; gap: 0.45rem; margin-top: 0.55rem; font-size: 0.75rem; font-weight: 700; color: rgb(71 85 105); letter-spacing: 0.04em; }
        .job-card__meta span { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.25rem 0.55rem; border-radius: 999px; background: rgb(241 245 249); color: rgb(51 65 85); }
        .job-card__summary { margin-top: 0.55rem; font-size: 0.85rem; line-height: 1.55; color: rgb(71 85 105); }
        .job-card__skills { margin-top: 0.65rem; display: flex; flex-wrap: wrap; gap: 0.35rem; }
        .job-card__skill { padding: 0.25rem 0.6rem; border-radius: 999px; background: rgba(124, 58, 237, 0.10); color: rgb(91 33 182); font-size: 0.72rem; font-weight: 700; }
        .job-card__actions { display: flex; align-items: center; gap: 0.5rem; align-self: center; }
        .job-icon-btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; min-height: 2.6rem; padding: 0 0.95rem; border-radius: 0.85rem; font-size: 0.82rem; font-weight: 700; transition: background 0.18s ease, color 0.18s ease, border-color 0.18s ease, transform 0.18s ease; }
        .job-icon-btn:hover { transform: translateY(-1px); }
        .job-icon-btn--edit { background: rgba(124, 58, 237, 0.10); color: rgb(91 33 182); border: 1px solid rgba(124, 58, 237, 0.18); }
        .job-icon-btn--edit:hover { background: rgb(124 58 237); color: #fff; }
        .job-icon-btn--delete { background: rgba(244, 63, 94, 0.10); color: rgb(190 18 60); border: 1px solid rgba(244, 63, 94, 0.18); }
        .job-icon-btn--delete:hover { background: rgb(244 63 94); color: #fff; }

        .jh-modal[hidden] { display: none; }
        .jh-modal { position: fixed; inset: 0; z-index: 70; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .jh-modal__backdrop { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.62); backdrop-filter: blur(4px); }
        .jh-modal__panel { position: relative; width: min(100%, 28rem); padding: 1.6rem; border-radius: 1.6rem; background: white; box-shadow: 0 30px 80px rgba(15, 23, 42, 0.24); }
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

        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#1f1147_0%,#6d28d9_58%,#c084fc_100%)] px-6 py-8 text-white shadow-[0_28px_80px_rgba(109,40,217,0.20)] md:px-8">
            <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-violet-100/80">Jobs Manager</p>
                    <h1 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">{{ $editingJob ? 'Update job posting details.' : 'Create better structured job postings.' }}</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-violet-50/85">Keep openings current with a clean form, helpful placeholders, and a card list with quick edit and delete actions.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Total roles</p><p class="mt-2 text-3xl font-extrabold">{{ $jobCount }}</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Active</p><p class="mt-2 text-3xl font-extrabold">{{ $activeJobs ?? 0 }}</p></div>
                    <div class="rounded-[1.3rem] border border-white/20 bg-white/10 p-4 backdrop-blur-md"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-violet-100/70">Hidden</p><p class="mt-2 text-3xl font-extrabold">{{ $hiddenJobs ?? 0 }}</p></div>
                </div>
            </div>
        </section>

        <section class="rounded-[1.8rem] border border-slate-200 bg-white p-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)] md:p-7" id="jobs-form">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">{{ $editingJob ? 'Edit Job' : 'New Job' }}</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">{{ $editingJob ? 'Update job posting' : 'Create job posting' }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $editingJob ? 'Refine the details below and save to publish changes.' : 'Fill in the essentials - leave the rest to smart defaults.' }}</p>
                </div>
                @if ($editingJob)
                    <a class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-violet-200 hover:text-violet-700" href="{{ route('hr.jobs') }}">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                        Cancel edit
                    </a>
                @endif
            </div>

            <form action="{{ $editingJob ? route('hr.jobs.update', $editingJob) : route('hr.jobs.store') }}" class="mt-6 space-y-6" method="POST">
                @csrf
                @if ($editingJob) @method('PUT') @endif

                <div class="form-card space-y-5">
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">badge</span>
                        <div>
                            <h3 class="font-headline text-lg font-extrabold text-slate-900">Role Snapshot</h3>
                            <p class="text-xs text-slate-500">The headline, badge, and basic role details candidates see first.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="jh-field md:col-span-2">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">badge</span>Job title</span>
                                <span class="jh-field__hint">Required</span>
                            </div>
                            <input class="jh-input" name="title" type="text" maxlength="120" value="{{ old('title', $editingJob->title ?? '') }}" placeholder="e.g. Senior AI Engineer" required>
                            <p class="jh-field__hint mt-1">The headline shown on the public jobs page and search results.</p>
                        </div>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">label</span>Badge</span>
                                <span class="jh-field__hint">Optional</span>
                            </div>
                            <input class="jh-input" name="badge" type="text" maxlength="40" value="{{ old('badge', $editingJob->badge ?? '') }}" placeholder="e.g. Most Popular, Trending Offer">
                            <p class="jh-field__hint mt-1">A small label shown next to the job title (for example <strong>Trending</strong>).</p>
                        </div>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">schedule</span>Employment type</span>
                                <span class="jh-field__hint">Choose one</span>
                            </div>
                            <select class="jh-select" name="employment_type">
                                <option value="">— Select employment type —</option>
                                @foreach ($employmentOptions as $option)
                                    <option value="{{ $option }}" @selected(old('employment_type', $editingJob->employment_type ?? '') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                            <p class="jh-field__hint mt-1">Pick the closest match, for example <strong>Full Time</strong>, <strong>Internship</strong>, or <strong>Contract</strong>.</p>
                        </div>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">location_on</span>Location</span>
                                <span class="jh-field__hint">City or remote</span>
                            </div>
                            <input class="jh-input" name="location" type="text" maxlength="120" value="{{ old('location', $editingJob->location ?? '') }}" placeholder="e.g. Surat, Gujarat or Remote">
                            <p class="jh-field__hint mt-1">City and state, or mention <strong>Remote</strong> when the role is fully remote.</p>
                        </div>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">business_center</span>Work mode</span>
                                <span class="jh-field__hint">Choose one</span>
                            </div>
                            <select class="jh-select" name="work_mode">
                                <option value="">— Select work mode —</option>
                                @foreach ($workModeOptions as $option)
                                    <option value="{{ $option }}" @selected(old('work_mode', $editingJob->work_mode ?? '') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                            <p class="jh-field__hint mt-1">Determines whether the role is <strong>On-site</strong>, <strong>Remote</strong>, or <strong>Hybrid</strong>.</p>
                        </div>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">workspace_premium</span>Experience</span>
                                <span class="jh-field__hint">Optional</span>
                            </div>
                            <input class="jh-input" name="experience" type="text" maxlength="80" value="{{ old('experience', $editingJob->experience ?? '') }}" placeholder="e.g. 2-4 years, Fresher friendly">
                            <p class="jh-field__hint mt-1">Required experience shown next to the role.</p>
                        </div>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">payments</span>Salary</span>
                                <span class="jh-field__hint">Range or note</span>
                            </div>
                            <input class="jh-input" name="salary" type="text" maxlength="80" value="{{ old('salary', $editingJob->salary ?? '') }}" placeholder="e.g. 6-9 LPA or Competitive package">
                            <p class="jh-field__hint mt-1">Salary range, or use <strong>Competitive</strong> when confidential.</p>
                        </div>
                    </div>
                </div>

                <div class="form-card space-y-5">
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">description</span>
                        <div>
                            <h3 class="font-headline text-lg font-extrabold text-slate-900">Role Details</h3>
                            <p class="text-xs text-slate-500">Skills, summary, and the look that ties it to the public site.</p>
                        </div>
                    </div>

                    <div class="jh-field">
                        <div class="jh-field__head">
                            <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">star</span>Skills</span>
                            <span class="jh-field__hint">One skill per line</span>
                        </div>
                        <textarea class="jh-textarea" name="skills" rows="4" maxlength="600" placeholder="e.g.&#10;Python&#10;TensorFlow&#10;LLM evaluation&#10;AWS">{{ old('skills', isset($editingJob) ? implode(PHP_EOL, $editingJob->skills ?? []) : '') }}</textarea>
                        <p class="jh-field__hint mt-1">Each line becomes a separate skill tag on the public card (for example <code>Python</code>, <code>TensorFlow</code>).</p>
                    </div>

                    <div class="jh-field">
                        <div class="jh-field__head">
                            <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">description</span>Summary</span>
                            <span class="jh-field__hint">Public description</span>
                        </div>
                        <textarea class="jh-textarea" name="summary" rows="4" maxlength="1200" placeholder="A short pitch for candidates: what the role is about, who it fits, and what they will work on.">{{ old('summary', $editingJob->summary ?? '') }}</textarea>
                        <p class="jh-field__hint mt-1">Visitors read this on the public job card. Mention the team, scope, and what makes the role exciting.</p>
                    </div>

                    <div class="jh-field">
                        <div class="jh-field__head">
                            <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">palette</span>Accent gradient</span>
                            <span class="jh-field__hint">Card color on the public site</span>
                        </div>
                        <div class="accent-swatches">
                            @foreach ($accentOptions as $gradient)
                                @php $cssColors = $gradientToCss($gradient); @endphp
                                <label class="accent-swatch" title="Accent gradient">
                                    <input type="radio" name="color" value="{{ $gradient }}" @checked(old('color', $editingJob->color ?? $accentOptions[0]) === $gradient)>
                                    <span class="accent-swatch__bg" style="background: linear-gradient(135deg, {{ $cssColors }});"></span>
                                </label>
                            @endforeach
                        </div>
                        <p class="jh-field__hint mt-1">Pick the gradient that best matches the role's team or seniority.</p>
                    </div>
                </div>

                <div class="form-card space-y-5">
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">tune</span>
                        <div>
                            <h3 class="font-headline text-lg font-extrabold text-slate-900">Visibility and Order</h3>
                            <p class="text-xs text-slate-500">Decide whether the role is public and where it appears in the list.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="jh-toggle">
                            <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingJob->is_active ?? true))>
                            <span class="jh-toggle__track"><span class="jh-toggle__thumb"></span></span>
                            <span class="jh-toggle__text">
                                Show on public site
                                <small>When off, the job is hidden from candidates but stays in HR records.</small>
                            </span>
                        </label>

                        <div class="jh-field">
                            <div class="jh-field__head">
                                <span class="jh-field__label"><span class="jh-field__icon material-symbols-outlined">sort</span>Sort order</span>
                                <span class="jh-field__hint">Lower numbers first</span>
                            </div>
                            <input class="jh-input" name="sort_order" type="number" min="0" value="{{ old('sort_order', $editingJob->sort_order ?? 0) }}" placeholder="e.g. 0, 1, 2">
                            <p class="jh-field__hint mt-1">Use <code>0</code> for the most important role, then <code>1</code>, <code>2</code>, and so on.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <button class="inline-flex items-center gap-2 rounded-2xl bg-violet-600 px-6 py-3 text-sm font-bold text-white shadow-[0_18px_36px_rgba(124,58,237,0.24)] transition hover:-translate-y-0.5" type="submit">
                        <span class="material-symbols-outlined text-[18px]">{{ $editingJob ? 'save' : 'add' }}</span>
                        {{ $editingJob ? 'Update job' : 'Create job' }}
                    </button>
                    @if ($editingJob)
                        <a class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-violet-200 hover:text-violet-700" href="{{ route('hr.jobs') }}">Cancel</a>
                    @endif
                    <span class="ml-auto text-xs text-slate-400">All changes are saved immediately.</span>
                </div>
            </form>
        </section>

        <section class="rounded-[1.8rem] border border-slate-200 bg-white p-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)] md:p-7" id="jobs-table">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-violet-700">Current content</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Job postings</h2>
                </div>
                <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $jobCount }} items</div>
            </div>

            @if (($jobItems ?? collect())->count() > 0)
                <div class="mt-6 grid gap-4">
                    @foreach ($jobItems ?? [] as $job)
                        @php
                            $gradient = $job->color ?: $accentOptions[0];
                            $cssColors = $gradientToCss($gradient);
                            $meta = collect(array_filter([
                                $job->employment_type,
                                $job->work_mode,
                                $job->location,
                                $job->experience,
                            ]));
                        @endphp
                        <div class="job-card">
                            <div class="job-card__gradient" style="background: linear-gradient(135deg, {{ $cssColors }});"></div>
                            <div class="relative">
                                <div class="job-card__title">
                                    <span>{{ $job->title }}</span>
                                    @if ($job->badge)
                                        <span class="rounded-full bg-violet-50 px-2.5 py-1 text-[11px] font-bold uppercase tracking-[0.16em] text-violet-700">{{ $job->badge }}</span>
                                    @endif
                                    @if ($job->is_active)
                                        <span class="job-chip job-chip--active"><span class="job-chip__dot"></span>Active</span>
                                    @else
                                        <span class="job-chip job-chip--hidden"><span class="job-chip__dot"></span>Hidden</span>
                                    @endif
                                </div>
                                <div class="job-card__meta">
                                    @foreach ($meta as $item)
                                        <span>{{ $item }}</span>
                                    @endforeach
                                    @if ($job->salary)
                                        <span>Salary: {{ $job->salary }}</span>
                                    @endif
                                </div>
                                @if ($job->summary)
                                    <p class="job-card__summary">{{ \Illuminate\Support\Str::limit($job->summary, 180) }}</p>
                                @endif
                                @if (! empty($job->skills))
                                    <div class="job-card__skills">
                                        @foreach (($job->skills ?? []) as $skill)
                                            <span class="job-card__skill">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="job-card__actions relative">
                                <a class="job-icon-btn job-icon-btn--edit" href="{{ route('hr.jobs', ['edit' => $job->id]) }}#jobs-form">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </a>
                                <button class="job-icon-btn job-icon-btn--delete" type="button" data-delete-job="{{ $job->id }}" data-job-title="{{ $job->title }}" data-delete-action="{{ route('hr.jobs.destroy', $job) }}">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (method_exists($jobs, 'hasPages') && $jobs->hasPages())
                    <div class="mt-6 flex flex-col gap-3 rounded-[1.4rem] border border-slate-200 bg-slate-50 px-4 py-4 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-600">Showing {{ $jobs->firstItem() }} to {{ $jobs->lastItem() }} of {{ $jobs->total() }} roles</p>
                        <div>{{ $jobs->onEachSide(1)->links() }}</div>
                    </div>
                @endif
            @else
                <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center text-sm font-semibold text-slate-500">No job postings added yet. Use the form above to create your first role.</div>
            @endif
        </section>
    </div>
</main>

<div class="jh-modal" data-confirm-modal hidden>
    <div class="jh-modal__backdrop" data-modal-close></div>
    <div class="jh-modal__panel" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined rounded-2xl bg-rose-100 p-2 text-rose-600" style="font-size: 28px;">delete</span>
            <div class="min-w-0">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-rose-600">Delete job posting</p>
                <h3 class="mt-2 font-headline text-xl font-extrabold text-slate-900" id="confirm-title">Are you sure?</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600" data-confirm-copy>This action will permanently remove the job posting and all its applications.</p>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap justify-end gap-2">
            <button class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-violet-200 hover:text-violet-700" type="button" data-modal-close>Cancel</button>
            <form action="" method="POST" data-confirm-form>
                @csrf
                @method('DELETE')
                <button class="inline-flex items-center gap-2 rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(244,63,94,0.22)] transition hover:-translate-y-0.5" type="submit">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                    Delete job
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        var modal = document.querySelector('[data-confirm-modal]');
        var confirmForm = document.querySelector('[data-confirm-form]');
        var confirmCopy = document.querySelector('[data-confirm-copy]');

        function openModal(action, title) {
            if (!modal || !confirmForm) return;
            confirmForm.setAttribute('action', action);
            if (confirmCopy) {
                confirmCopy.textContent = 'This will permanently delete "' + title + '" and remove all of its applications.';
            }
            modal.hidden = false;
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            if (!modal) return;
            modal.hidden = true;
            document.body.classList.remove('overflow-hidden');
        }

        document.querySelectorAll('[data-delete-job]').forEach(function (button) {
            button.addEventListener('click', function () {
                openModal(button.getAttribute('data-delete-action'), button.getAttribute('data-job-title'));
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(function (element) {
            element.addEventListener('click', closeModal);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeModal();
        });
    })();
</script>
</body>
</html>



