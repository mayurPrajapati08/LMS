@php
    $statusOptions = [
        '' => 'All Status',
        'new' => 'New',
        'shortlisted' => 'Shortlisted',
        'interview' => 'Interview',
        'hired' => 'Hired',
        'rejected' => 'Rejected',
    ];
    $statusClasses = [
        'new' => 'bg-blue-100 text-blue-700',
        'shortlisted' => 'bg-violet-100 text-violet-700',
        'interview' => 'bg-amber-100 text-amber-700',
        'hired' => 'bg-emerald-100 text-emerald-700',
        'rejected' => 'bg-rose-100 text-rose-700',
    ];
    $visibleApplications = $applications->getCollection();
    $newCount = $visibleApplications->where('status', 'new')->count();
    $shortlistedCount = $visibleApplications->where('status', 'shortlisted')->count();
    $rangeStart = $applications->count() > 0 ? $applications->firstItem() : 0;
    $rangeEnd = $applications->count() > 0 ? $applications->lastItem() : 0;
    $selectedJobLabel = $jobFilter > 0
        ? optional($jobs->firstWhere('id', $jobFilter))->title
        : 'All Jobs';
    $selectedJobLabel = $selectedJobLabel ?: 'All Jobs';
@endphp
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Job Applications | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .field { width: 100%; border-radius: 1rem; border: 1px solid rgb(203 213 225); background: white; padding: 0.78rem 0.95rem; font-size: 0.9rem; color: rgb(15 23 42); }
        .field-textarea { min-height: 7rem; resize: vertical; }
        .job-select { position: relative; }
        .job-select__trigger {
            display: flex;
            min-height: 3.15rem;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            border-radius: 1.1rem;
            border: 1px solid rgba(20, 184, 166, 0.24);
            background:
                linear-gradient(135deg, rgba(240, 253, 250, 0.92), rgba(255, 255, 255, 0.98)),
                #fff;
            padding: 0.54rem 0.64rem 0.54rem 0.72rem;
            color: rgb(15 23 42);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }
        .job-select__trigger:hover {
            border-color: rgba(13, 148, 136, 0.42);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1), 0 0 0 4px rgba(20, 184, 166, 0.08);
        }
        .job-select__trigger:focus-visible {
            outline: none;
            border-color: rgba(13, 148, 136, 0.68);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1), 0 0 0 4px rgba(20, 184, 166, 0.16);
        }
        .job-select__icon {
            display: inline-flex;
            height: 2.05rem;
            width: 2.05rem;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border-radius: 0.85rem;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            box-shadow: 0 10px 20px rgba(13, 148, 136, 0.22);
        }
        .job-select__content { min-width: 0; text-align: left; }
        .job-select__eyebrow {
            display: block;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            line-height: 1;
            text-transform: uppercase;
            color: rgb(13 148 136);
        }
        .job-select__value {
            margin-top: 0.28rem;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 0.92rem;
            font-weight: 800;
            color: rgb(15 23 42);
        }
        .job-select__chevron {
            flex: 0 0 auto;
            border-radius: 999px;
            color: rgb(15 118 110);
            transition: transform 0.18s ease, background-color 0.18s ease;
        }
        .job-select[data-open="true"] .job-select__chevron {
            transform: rotate(180deg);
            background: rgba(20, 184, 166, 0.12);
        }
        .job-select__menu {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 0.55rem);
            z-index: 30;
            max-height: 17rem;
            overflow: auto;
            border-radius: 1.15rem;
            border: 1px solid rgba(203, 213, 225, 0.9);
            background: rgba(255, 255, 255, 0.98);
            padding: 0.42rem;
            box-shadow: 0 24px 55px rgba(15, 23, 42, 0.18);
            transform-origin: top;
        }
        .job-select__menu[hidden] { display: none; }
        .job-select__option {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 0.72rem;
            border-radius: 0.85rem;
            padding: 0.72rem 0.78rem;
            text-align: left;
            font-size: 0.9rem;
            font-weight: 700;
            color: rgb(51 65 85);
            transition: background-color 0.16s ease, color 0.16s ease, transform 0.16s ease;
        }
        .job-select__option:hover,
        .job-select__option:focus-visible {
            outline: none;
            background: rgb(240 253 250);
            color: rgb(15 118 110);
            transform: translateX(2px);
        }
        .job-select__option[aria-selected="true"] {
            background: linear-gradient(135deg, rgb(15 118 110), rgb(20 184 166));
            color: white;
            box-shadow: 0 12px 22px rgba(13, 148, 136, 0.2);
        }
        .job-select__option-mark {
            display: inline-flex;
            height: 1.35rem;
            width: 1.35rem;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: rgba(15, 118, 110, 0.1);
            color: rgb(15 118 110);
        }
        .job-select__option[aria-selected="true"] .job-select__option-mark {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .modal-shell[hidden] { display: none; }
        .form-card { border: 1px solid rgba(13, 148, 136, 0.18); border-radius: 1.55rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(240,253,250,0.94)); padding: 1.4rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 14px 30px rgba(15,23,42,0.045); }
        .form-card-head { display: flex; align-items: flex-start; gap: 0.85rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(13,148,136,0.22); margin-bottom: 0.25rem; }
        .form-card-head .material-symbols-outlined { display: inline-flex; align-items: center; justify-content: center; height: 2.4rem; width: 2.4rem; border-radius: 0.85rem; background: linear-gradient(135deg, rgba(13,148,136,0.16), rgba(20,184,166,0.16)); color: rgb(13 148 136); font-size: 1.25rem; }
        .modal-shell { position: fixed; inset: 0; z-index: 60; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .modal-backdrop { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.62); backdrop-filter: blur(4px); }
        .modal-panel { position: relative; width: min(100%, 74rem); max-height: calc(100vh - 2rem); overflow: auto; border-radius: 2rem; background: white; box-shadow: 0 30px 80px rgba(15, 23, 42, 0.24); }
        .detail-card { border: 1px solid rgb(226 232 240); border-radius: 1.15rem; background: rgb(248 250 252); padding: 0.95rem 1rem; }

        /* Status dropdown - indigo/violet accent so it reads as a different filter than the job picker */
        .status-select__trigger {
            border-color: rgba(124, 58, 237, 0.26);
            background:
                linear-gradient(135deg, rgba(245, 243, 255, 0.94), rgba(255, 255, 255, 0.98)),
                #fff;
            box-shadow: 0 14px 34px rgba(76, 29, 149, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        .status-select__trigger:hover {
            border-color: rgba(109, 40, 217, 0.45);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1), 0 0 0 4px rgba(167, 139, 250, 0.12);
        }
        .status-select__trigger:focus-visible {
            border-color: rgba(109, 40, 217, 0.7);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1), 0 0 0 4px rgba(167, 139, 250, 0.2);
        }
        .status-select__icon {
            background: linear-gradient(135deg, #4c1d95, #7c3aed);
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.28);
        }
        .status-select__eyebrow { color: rgb(109 40 217); }
        .status-select__chevron { color: rgb(109 40 217); }
        .status-select[data-open="true"] .status-select__chevron {
            background: rgba(167, 139, 250, 0.16);
        }
        .status-select__menu {
            border-color: rgba(196, 181, 253, 0.55);
        }
        .status-select__option:hover,
        .status-select__option:focus-visible {
            background: rgb(245 243 255);
            color: rgb(76 29 150);
        }
        .status-select__option[aria-selected="true"] {
            background: linear-gradient(135deg, rgb(76 29 150), rgb(124 58 237));
            color: white;
            box-shadow: 0 12px 22px rgba(109, 40, 217, 0.22);
        }
        .status-select__option-mark {
            background: rgba(124, 58, 237, 0.12);
            color: rgb(109 40 217);
        }
        .status-select__option[aria-selected="true"] .status-select__option-mark {
            background: rgba(255, 255, 255, 0.22);
            color: white;
        }

        /* Status pill dot that matches the chip palette, shown in the trigger when a status is selected */
        .status-select__dot {
            display: inline-block;
            height: 0.55rem;
            width: 0.55rem;
            border-radius: 999px;
            margin-right: 0.45rem;
            vertical-align: middle;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.6);
        }
        .status-select__dot--all { background: linear-gradient(135deg, #94a3b8, #cbd5e1); }
        .status-select__dot--new { background: #2563eb; }
        .status-select__dot--shortlisted { background: #7c3aed; }
        .status-select__dot--interview { background: #d97706; }
        .status-select__dot--hired { background: #059669; }
        .status-select__dot--rejected { background: #e11d48; }

        /* Search field - matches the dropdown trigger chrome */
        .filter-search {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 3.15rem;
            border-radius: 1.1rem;
            border: 1px solid rgba(20, 184, 166, 0.24);
            background:
                linear-gradient(135deg, rgba(240, 253, 250, 0.92), rgba(255, 255, 255, 0.98)),
                #fff;
            padding: 0.5rem 3rem 0.5rem 3.4rem;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }
        .filter-search,
        .filter-search *,
        .filter-search *:focus,
        .filter-search *:focus-visible,
        .filter-search *:focus-within {
            outline: none !important;
        }
        input.filter-search__input::-webkit-contacts-auto-fill-button,
        input.filter-search__input::-webkit-search-cancel-button,
        input.filter-search__input::-webkit-search-decoration { display: none !important; }
        .filter-search:hover {
            border-color: rgba(13, 148, 136, 0.42);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1), 0 0 0 4px rgba(20, 184, 166, 0.08);
        }
        .filter-search:focus-within {
            border-color: rgba(20, 184, 166, 0.24);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        .filter-search__icon {
            position: absolute;
            left: 0.95rem;
            color: rgb(13 148 136);
            pointer-events: none;
        }
        .filter-search__input {
            width: 100%;
            border: 0;
            background: transparent;
            font-size: 0.92rem;
            font-weight: 700;
            color: rgb(15 23 42);
            padding: 0;
            outline: none;
            box-shadow: none;
            -webkit-appearance: none;
            appearance: none;
        }
        .filter-search__input:focus,
        .filter-search__input:focus-visible,
        .filter-search__input:-webkit-autofill,
        .filter-search__input:-webkit-autofill:hover,
        .filter-search__input:-webkit-autofill:focus {
            outline: none !important;
            box-shadow: none !important;
            border: 0 !important;
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            box-shadow: 0 0 0 1000px transparent inset !important;
            -webkit-text-fill-color: rgb(15 23 42) !important;
        }
        .filter-search__input::placeholder {
            color: rgb(100 116 139);
            font-weight: 600;
        }
        .filter-search__input::-webkit-search-cancel-button { display: none; }
        .filter-search__kbd {
            position: absolute;
            right: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 1.5rem;
            height: 1.5rem;
            padding: 0 0.4rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(20, 184, 166, 0.28);
            background: rgba(20, 184, 166, 0.08);
            font-size: 0.7rem;
            font-weight: 800;
            color: rgb(13 148 136);
            transition: opacity 0.18s ease;
        }
        .filter-search__input:not(:placeholder-shown) ~ .filter-search__kbd { opacity: 0; pointer-events: none; }
        .filter-search__clear {
            position: absolute;
            right: 0.6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 1.85rem;
            width: 1.85rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.06);
            color: rgb(71 85 105);
            transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }
        .filter-search__clear:hover {
            background: rgb(244 63 94);
            color: white;
            transform: scale(1.05);
        }
        .filter-search__clear[hidden] { display: none; }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f8fbff_0%,#f1f5f9_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-[92rem] space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
        @endif

        <section class="overflow-hidden rounded-[2rem] bg-[linear-gradient(135deg,#152033_0%,#315f72_48%,#14b8a6_150%)] px-6 py-8 text-white shadow-[0_24px_60px_rgba(21,94,117,0.18)] md:px-8">
            <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-teal-100/80">Hiring Pipeline</p>
                    <h1 class="mt-3 font-headline text-3xl font-extrabold md:text-4xl">Job applications</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-teal-50/85">Review candidates by role, filter by status, open resumes, and keep HR notes updated from one clean workspace.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.4rem] border border-white/15 bg-white/10 p-4 backdrop-blur"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70">Total</p><p class="mt-2 text-3xl font-extrabold">{{ $applications->total() }}</p></div>
                    <div class="rounded-[1.4rem] border border-white/15 bg-white/10 p-4 backdrop-blur"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70">New</p><p class="mt-2 text-3xl font-extrabold">{{ $newCount }}</p></div>
                    <div class="rounded-[1.4rem] border border-white/15 bg-white/10 p-4 backdrop-blur"><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70">Shortlisted</p><p class="mt-2 text-3xl font-extrabold">{{ $shortlistedCount }}</p></div>
                </div>
            </div>
        </section>

        <section class="rounded-[1.8rem] border border-slate-200 bg-white p-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)]">
            @php
                $hasActiveFilters = ($search !== '') || $jobFilter > 0 || ($statusFilter !== '' && $statusFilter !== null);
            @endphp
            <form class="form-card space-y-4" method="GET" action="{{ route('hr.job-applications') }}" data-filter-form data-filter-auto-submit>
                <div class="form-card-head">
                    <span class="material-symbols-outlined">filter_alt</span>
                    <div>
                        <h3 class="font-headline text-lg font-extrabold text-slate-900">Filter Applications</h3>
                        <p class="text-xs text-slate-500">Search by candidate name, email or phone number, then narrow by job or hiring status.</p>
                    </div>
                </div>
                <div class="grid gap-4 lg:grid-cols-[1.25fr_1fr_1fr]">
                    <label class="filter-search group">
                        <span class="jh-field__label"><span class="filter-search__icon material-symbols-outlined text-[19px]">search</span>Search candidates</span>
                        <input
                            class="filter-search__input"
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="e.g. Riya Sharma or riya@example.com"
                            autocomplete="off"
                            data-filter-search
                        >
                        <button
                            class="filter-search__clear"
                            type="button"
                            aria-label="Clear search"
                            data-filter-clear-search
                            @if ($search === '') hidden @endif
                        >
                            <span class="material-symbols-outlined text-[16px]">close</span>
                        </button>
                        <span class="filter-search__kbd" aria-hidden="true">/</span>
                    </label>

                    <div class="job-select" data-job-select>
                        <input type="hidden" name="job" value="{{ $jobFilter > 0 ? $jobFilter : '' }}" data-job-select-input>
                        <button class="job-select__trigger" type="button" aria-haspopup="listbox" aria-expanded="false" data-job-select-trigger>
                            <span class="job-select__icon material-symbols-outlined text-[19px]">work</span>
                            <span class="job-select__content">
                                <span class="job-select__eyebrow">Job role</span>
                                <span class="job-select__value" data-job-select-value>{{ $selectedJobLabel }}</span>
                            </span>
                            <span class="job-select__chevron material-symbols-outlined text-[21px]">expand_more</span>
                        </button>
                        <div class="job-select__menu" role="listbox" tabindex="-1" hidden data-job-select-menu>
                            <button class="job-select__option" type="button" role="option" aria-selected="{{ $jobFilter > 0 ? 'false' : 'true' }}" data-value="" data-label="All Jobs">
                                <span class="job-select__option-mark material-symbols-outlined text-[15px]">{{ $jobFilter > 0 ? 'work_outline' : 'check' }}</span>
                                <span>All Jobs</span>
                            </button>
                            @foreach ($jobs as $job)
                                <button class="job-select__option" type="button" role="option" aria-selected="{{ (int) $jobFilter === $job->id ? 'true' : 'false' }}" data-value="{{ $job->id }}" data-label="{{ $job->title }}">
                                    <span class="job-select__option-mark material-symbols-outlined text-[15px]">{{ (int) $jobFilter === $job->id ? 'check' : 'work_outline' }}</span>
                                    <span class="truncate">{{ $job->title }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="status-select job-select" data-job-select data-status-select="true">
                        <input type="hidden" name="status" value="{{ $statusFilter }}" data-job-select-input>
                        <button class="job-select__trigger status-select__trigger" type="button" aria-haspopup="listbox" aria-expanded="false" data-job-select-trigger>
                            <span class="job-select__icon status-select__icon material-symbols-outlined text-[19px]">flag</span>
                            <span class="job-select__content">
                                <span class="job-select__eyebrow status-select__eyebrow">Status</span>
                                @php $statusLabelMap = ['' => 'All Status', 'new' => 'New', 'shortlisted' => 'Shortlisted', 'interview' => 'Interview', 'hired' => 'Hired', 'rejected' => 'Rejected']; @endphp
                                <span class="job-select__value" data-job-select-value data-status-select-value><span class="status-select__dot status-select__dot--{{ $statusFilter ?: 'all' }}" data-status-select-dot></span><span data-status-select-label>{{ $statusLabelMap[$statusFilter] ?? 'All Status' }}</span></span>
                            </span>
                            <span class="job-select__chevron status-select__chevron material-symbols-outlined text-[21px]">expand_more</span>
                        </button>
                        <div class="job-select__menu status-select__menu" role="listbox" tabindex="-1" hidden data-job-select-menu>
                            @php $statusDotMap = ['' => 'all', 'new' => 'new', 'shortlisted' => 'shortlisted', 'interview' => 'interview', 'hired' => 'hired', 'rejected' => 'rejected']; @endphp
                            @foreach ($statusOptions as $value => $label)
                                <button class="job-select__option status-select__option" type="button" role="option" aria-selected="{{ $statusFilter === $value ? 'true' : 'false' }}" data-value="{{ $value }}" data-label="{{ $label }}" data-dot-class="status-select__dot--{{ $statusDotMap[$value] ?? 'all' }}">
                                    <span class="job-select__option-mark status-select__option-mark material-symbols-outlined text-[15px]">{{ $statusFilter === $value ? 'check' : 'flag' }}</span>
                                    <span class="status-select__dot status-select__dot--{{ $statusDotMap[$value] ?? 'all' }}"></span>
                                    <span>{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <span class="font-bold uppercase tracking-[0.18em] text-slate-400">Live results</span>
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-teal-100 bg-teal-50 px-2.5 py-1 font-bold text-teal-700" data-filter-summary>
                            <span class="material-symbols-outlined text-[14px]">auto_awesome</span>
                            {{ $applications->total() }} match{{ $applications->total() === 1 ? '' : 'es' }}
                        </span>
                        <span class="text-slate-400">|</span>
                        <span class="text-slate-500">Results update as you type or change a filter.</span>
                    </div>
                    <a
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600 {{ $hasActiveFilters ? '' : 'pointer-events-none opacity-40' }}"
                        href="{{ route('hr.job-applications') }}"
                        data-filter-clear-all
                        @if (! $hasActiveFilters) aria-disabled="true" tabindex="-1" @endif
                    >
                        <span class="material-symbols-outlined text-[15px]">restart_alt</span>
                        Clear all filters
                    </a>
                </div>
            </form>
        </section>

        <section class="overflow-hidden rounded-[1.9rem] border border-slate-200 bg-white p-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)] md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-teal-700">Application Desk</p>
                    <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Candidate list</h2>
                </div>
                <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $applications->total() }} applications</div>
            </div>

            @if ($applications->count() > 0)
                <div class="mt-6 overflow-x-auto rounded-[1.5rem] border border-slate-200">
                    <table class="min-w-[68rem] w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Candidate</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Job</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Salary</th>
                                <th class="px-4 py-4 text-left text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Status</th>
                                <th class="px-4 py-4 text-right text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-slate-500">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr class="border-t border-slate-200">
                                    <td class="px-4 py-4 align-top">
                                        <p class="font-extrabold text-slate-900">{{ $application->name }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $application->email }} | {{ $application->phone ?: 'No phone' }}</p>
                                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">{{ $application->created_at?->format('d M Y, h:i a') }}</p>
                                    </td>
                                    <td class="px-4 py-4 align-top">
                                        <p class="font-semibold text-slate-900">{{ $application->jobOpening?->title ?: 'Deleted job' }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ collect([$application->jobOpening?->employment_type, $application->jobOpening?->location])->filter()->implode(' | ') ?: 'No job details' }}</p>
                                    </td>
                                    <td class="px-4 py-4 align-top text-sm text-slate-600">
                                        <p><span class="font-bold text-slate-800">Current:</span> {{ $application->current_ctc ?: 'NA' }}</p>
                                        <p class="mt-1"><span class="font-bold text-slate-800">Expected:</span> {{ $application->expected_salary ?: 'NA' }}</p>
                                    </td>
                                    <td class="px-4 py-4 align-top">
                                        <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.16em] {{ $statusClasses[$application->status] ?? 'bg-slate-100 text-slate-600' }}">{{ str_replace('_', ' ', $application->status) }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-right align-top">
                                        <button class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white" type="button" data-modal-open="application-modal-{{ $application->id }}">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($applications->hasPages())
                    <div class="mt-6 flex flex-col gap-4 rounded-[1.5rem] border border-slate-200 bg-slate-50/80 px-4 py-4 md:flex-row md:items-center md:justify-between md:px-5">
                        <p class="text-sm font-medium text-slate-600">Showing {{ $rangeStart }} to {{ $rangeEnd }} of {{ $applications->total() }} applications</p>
                        <div>{{ $applications->onEachSide(1)->links() }}</div>
                    </div>
                @endif
            @else
                <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center text-sm font-semibold text-slate-500">No job applications found for this filter.</div>
            @endif
        </section>
    </div>
</main>

@foreach ($applications as $application)
    <div class="modal-shell" hidden id="application-modal-{{ $application->id }}">
        <div class="modal-backdrop" data-modal-close></div>
        <div aria-modal="true" class="modal-panel" role="dialog">
            <div class="sticky top-0 z-10 flex items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-6 py-5 backdrop-blur">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-teal-700">Candidate Profile</p>
                    <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">{{ $application->name }}</h3>
                </div>
                <button class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600" type="button" data-modal-close>
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="grid gap-6 p-6 lg:grid-cols-[1fr_24rem]">
                <div class="space-y-5">
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ([
                            'Email' => $application->email,
                            'Phone' => $application->phone,
                            'Applied Job' => $application->jobOpening?->title,
                            'Experience' => $application->experience,
                            'Current CTC' => $application->current_ctc,
                            'Expected Salary' => $application->expected_salary,
                            'Notice Period' => $application->notice_period,
                            'Current Location' => $application->current_location,
                        ] as $label => $value)
                            <div class="detail-card">
                                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">{{ $label }}</p>
                                <p class="mt-2 break-words text-sm font-semibold text-slate-800">{{ $value ?: 'Not provided' }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="detail-card">
                            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Resume</p>
                            @if ($application->resume_path)
                                <a class="mt-2 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white" href="{{ route('hr.job-applications.resume', $application) }}">
                                    <span class="material-symbols-outlined text-[18px]">download</span>
                                    {{ $application->resume_original_name ?: 'Open resume' }}
                                </a>
                            @else
                                <p class="mt-2 text-sm text-slate-600">No resume uploaded.</p>
                            @endif
                        </div>
                        <div class="detail-card">
                            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Portfolio / LinkedIn</p>
                            @if ($application->portfolio_url)
                                <a class="mt-2 inline-flex break-all text-sm font-semibold text-teal-700" href="{{ $application->portfolio_url }}" target="_blank" rel="noopener">{{ $application->portfolio_url }}</a>
                            @else
                                <p class="mt-2 text-sm text-slate-600">Not provided.</p>
                            @endif
                        </div>
                    </div>

                    <div class="detail-card">
                        <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Candidate Note</p>
                        <p class="mt-2 text-sm leading-7 text-slate-700">{{ $application->cover_note ?: 'No note added by candidate.' }}</p>
                    </div>
                </div>

                <form action="{{ route('hr.job-applications.update', $application) }}" class="form-card space-y-4" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-card-head">
                        <span class="material-symbols-outlined">task_alt</span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-teal-700">HR Action</p>
                            <h4 class="mt-1 font-headline text-xl font-extrabold text-slate-900">Update status</h4>
                            <p class="text-xs text-slate-500">Move this candidate along the hiring pipeline. The status below is also shown in the public candidate report.</p>
                        </div>
                    </div>
                    <div>
                        <span class="mb-2 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500"><span class="material-symbols-outlined text-[16px]">flag</span>Status</span>
                        <div class="status-select job-select" data-job-select data-status-select="true">
                            <input type="hidden" name="status" value="{{ $application->status }}" data-job-select-input>
                            <button class="job-select__trigger status-select__trigger" type="button" aria-haspopup="listbox" aria-expanded="false" data-job-select-trigger>
                                <span class="job-select__icon status-select__icon material-symbols-outlined text-[19px]">flag</span>
                                <span class="job-select__content">
                                    <span class="job-select__eyebrow status-select__eyebrow">Set status</span>
                                    <span class="job-select__value" data-job-select-value data-status-select-value><span class="status-select__dot status-select__dot--{{ $application->status }}" data-status-select-dot></span><span data-status-select-label>{{ $statusOptions[$application->status] ?? ucfirst($application->status) }}</span></span>
                                </span>
                                <span class="job-select__chevron status-select__chevron material-symbols-outlined text-[21px]">expand_more</span>
                            </button>
                            <div class="job-select__menu status-select__menu" role="listbox" tabindex="-1" hidden data-job-select-menu>
                                @foreach (array_filter($statusOptions, fn ($label, $value) => $value !== '', ARRAY_FILTER_USE_BOTH) as $value => $label)
                                    <button class="job-select__option status-select__option" type="button" role="option" aria-selected="{{ $application->status === $value ? 'true' : 'false' }}" data-value="{{ $value }}" data-label="{{ $label }}" data-dot-class="status-select__dot--{{ $value }}">
                                        <span class="job-select__option-mark status-select__option-mark material-symbols-outlined text-[15px]">{{ $application->status === $value ? 'check' : 'flag' }}</span>
                                        <span class="status-select__dot status-select__dot--{{ $value }}"></span>
                                        <span>{{ $label }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500" for="notes-{{ $application->id }}">HR Notes</label>
                        <textarea class="field field-textarea" id="notes-{{ $application->id }}" name="hr_notes" rows="6" placeholder="Interview date, feedback, next step, or internal note">{{ old('hr_notes', $application->hr_notes) }}</textarea>
                    </div>
                    @if ($application->reviewer)
                        <p class="text-xs font-semibold leading-6 text-slate-500">Last reviewed by {{ $application->reviewer->name }} {{ $application->reviewed_at ? 'on '.$application->reviewed_at->format('d M Y, h:i a') : '' }}.</p>
                    @endif
                    <button class="inline-flex w-full items-center justify-center rounded-2xl bg-teal-700 px-4 py-3 text-sm font-semibold text-white" type="submit">Save Application</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    (function () {
        var activeModal = null;
        var activeJobSelect = null;

        function closeJobSelect(select) {
            if (!select) return;
            var trigger = select.querySelector('[data-job-select-trigger]');
            var menu = select.querySelector('[data-job-select-menu]');

            select.dataset.open = 'false';
            if (trigger) trigger.setAttribute('aria-expanded', 'false');
            if (menu) menu.hidden = true;
            if (activeJobSelect === select) activeJobSelect = null;
        }

        function openJobSelect(select) {
            if (!select) return;
            if (activeJobSelect && activeJobSelect !== select) closeJobSelect(activeJobSelect);

            var trigger = select.querySelector('[data-job-select-trigger]');
            var menu = select.querySelector('[data-job-select-menu]');

            select.dataset.open = 'true';
            if (trigger) trigger.setAttribute('aria-expanded', 'true');
            if (menu) menu.hidden = false;
            activeJobSelect = select;
        }

        function syncJobSelectOption(select, option) {
            var input = select.querySelector('[data-job-select-input]');
            var value = select.querySelector('[data-job-select-value]');
            var dot = select.querySelector('[data-status-select-dot]');

            if (input) input.value = option.dataset.value || '';
            if (value) {
                value.textContent = option.dataset.label || option.textContent.trim();
                if (dot) {
                    var dotClass = option.dataset.dotClass || '';
                    dot.className = 'status-select__dot ' + (dotClass || 'status-select__dot--all');
                }
            }

            select.querySelectorAll('[data-value]').forEach(function (item) {
                var isSelected = item === option;
                var mark = item.querySelector('.job-select__option-mark');

                item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
                if (mark) mark.textContent = isSelected ? 'check' : (select.dataset.statusSelect === 'true' ? 'flag' : 'work_outline');
            });
        }

        document.querySelectorAll('[data-job-select]').forEach(function (select) {
            var trigger = select.querySelector('[data-job-select-trigger]');
            var menu = select.querySelector('[data-job-select-menu]');
            var options = Array.prototype.slice.call(select.querySelectorAll('[data-value]'));

            if (!trigger || !menu) return;

            trigger.addEventListener('click', function () {
                if (select.dataset.open === 'true') {
                    closeJobSelect(select);
                } else {
                    openJobSelect(select);
                }
            });

            trigger.addEventListener('keydown', function (event) {
                if (event.key === 'ArrowDown' || event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openJobSelect(select);
                    (options.find(function (option) {
                        return option.getAttribute('aria-selected') === 'true';
                    }) || options[0])?.focus();
                }
            });

            options.forEach(function (option, index) {
                option.addEventListener('click', function () {
                    syncJobSelectOption(select, option);
                    closeJobSelect(select);
                    trigger.focus();
                    var form = select.closest('[data-filter-form]');
                    if (form && form.dataset.filterAutoSubmit !== undefined) {
                        window.setTimeout(function () { form.requestSubmit ? form.requestSubmit() : form.submit(); }, 120);
                    }
                });

                option.addEventListener('keydown', function (event) {
                    if (event.key === 'ArrowDown') {
                        event.preventDefault();
                        (options[index + 1] || options[0]).focus();
                    }

                    if (event.key === 'ArrowUp') {
                        event.preventDefault();
                        (options[index - 1] || options[options.length - 1]).focus();
                    }

                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        option.click();
                    }

                    if (event.key === 'Escape') {
                        event.preventDefault();
                        closeJobSelect(select);
                        trigger.focus();
                    }
                });
            });
        });

        function closeModal(modal) {
            if (!modal) return;
            modal.hidden = true;
            document.body.classList.remove('overflow-hidden');
            activeModal = null;
        }

        function openModal(modal) {
            if (!modal) return;
            if (activeModal && activeModal !== modal) closeModal(activeModal);
            modal.hidden = false;
            document.body.classList.add('overflow-hidden');
            activeModal = modal;
        }

        document.querySelectorAll('[data-modal-open]').forEach(function (button) {
            button.addEventListener('click', function () {
                openModal(document.getElementById(button.getAttribute('data-modal-open')));
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(function (button) {
            button.addEventListener('click', function () {
                closeModal(button.closest('.modal-shell'));
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeJobSelect(activeJobSelect);
            if (event.key === 'Escape') closeModal(activeModal);
        });

        document.addEventListener('click', function (event) {
            if (activeJobSelect && !activeJobSelect.contains(event.target)) {
                closeJobSelect(activeJobSelect);
            }
        });

        // Live filter: debounced search + auto-submit on dropdown change + clear button + '/' focus
        (function () {
            var form = document.querySelector('[data-filter-form]');
            if (!form) return;

            var searchInput = form.querySelector('[data-filter-search]');
            var clearButton = form.querySelector('[data-filter-clear-search]');
            var debounceTimer = null;
            var SEARCH_DEBOUNCE_MS = 350;

            function submitForm() {
                if (form.requestSubmit) {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }

            function syncClearButton() {
                if (!clearButton) return;
                var hasValue = !!(searchInput && searchInput.value.trim() !== '');
                if (hasValue) {
                    clearButton.hidden = false;
                } else {
                    clearButton.hidden = true;
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    syncClearButton();
                    window.clearTimeout(debounceTimer);
                    debounceTimer = window.setTimeout(submitForm, SEARCH_DEBOUNCE_MS);
                });
                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        searchInput.value = '';
                        syncClearButton();
                        window.clearTimeout(debounceTimer);
                        submitForm();
                    }
                });
                syncClearButton();
            }

            if (clearButton && searchInput) {
                clearButton.addEventListener('click', function () {
                    searchInput.value = '';
                    syncClearButton();
                    searchInput.focus();
                    window.clearTimeout(debounceTimer);
                    submitForm();
                });
            }

            // "/" focuses search, like GitHub-style quick search
            document.addEventListener('keydown', function (event) {
                if (event.key !== '/' || event.metaKey || event.ctrlKey || event.altKey) return;
                var tag = (document.activeElement && document.activeElement.tagName) || '';
                if (tag === 'INPUT' || tag === 'TEXTAREA' || (document.activeElement && document.activeElement.isContentEditable)) return;
                if (!searchInput) return;
                event.preventDefault();
                searchInput.focus();
                searchInput.select();
            });
        })();
    })();
</script>
</body>
</html>



