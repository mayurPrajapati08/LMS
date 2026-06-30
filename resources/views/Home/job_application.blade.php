@php
    $skills = $job->skills ?? [];
    $detailCards = [
        ['label' => 'Employment', 'value' => $job->employment_type ?: 'Full Time', 'icon' => 'badge'],
        ['label' => 'Work Mode', 'value' => $job->work_mode ?: 'On-site', 'icon' => 'business_center'],
        ['label' => 'Location', 'value' => $job->location ?: 'Surat, Gujarat', 'icon' => 'location_on'],
        ['label' => 'Experience', 'value' => $job->experience ?: 'Experience required', 'icon' => 'workspace_premium'],
        ['label' => 'Salary', 'value' => $job->salary ?: 'Competitive package', 'icon' => 'payments'],
    ];
@endphp

<x-home.marketing-layout title="{{ $job->title }} Application | CodeInYourself" bodyClass="job-apply-shell">
    <x-slot:head>
        <style>
            .job-apply-shell { overflow-x: clip; }
            .job-hero {
                position: relative;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                background:
                    radial-gradient(circle at 15% 12%, rgba(20,184,166,0.18), transparent 22%),
                    radial-gradient(circle at 86% 18%, rgba(168,85,247,0.24), transparent 24%),
                    linear-gradient(135deg, #07111f 0%, #12304a 46%, #5b21b6 100%);
            }
            .apply-panel {
                border: 1px solid rgba(226, 232, 240, 0.92);
                border-radius: 1.6rem;
                background: linear-gradient(180deg, rgba(255,255,255,0.99), rgba(248,250,252,0.98));
                box-shadow: 0 22px 55px rgba(15,23,42,0.08);
            }
            .apply-field label {
                display: block;
                margin-bottom: 0.5rem;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: rgb(79 70 229);
            }
            .apply-field input,
            .apply-field textarea {
                width: 100%;
                border-radius: 1rem;
                border: 1px solid rgb(203 213 225);
                background: white;
                color: rgb(15 23 42);
                padding: 0.9rem 1rem;
            }
            .apply-field textarea { min-height: 8rem; resize: vertical; }
            .apply-field input:focus,
            .apply-field textarea:focus {
                outline: none;
                border-color: rgba(79,70,229,0.45);
                box-shadow: 0 0 0 4px rgba(79,70,229,0.10);
            }
            .success-modal {
                position: fixed;
                inset: 0;
                z-index: 80;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                background: rgba(15, 23, 42, 0.58);
                backdrop-filter: blur(5px);
                -webkit-backdrop-filter: blur(5px);
            }
            .success-modal[hidden] { display: none; }
            .success-card {
                width: min(100%, 30rem);
                border-radius: 1.8rem;
                border: 1px solid rgba(187, 247, 208, 0.9);
                background: linear-gradient(180deg, #ffffff 0%, #f7fef9 100%);
                box-shadow: 0 30px 90px rgba(15, 23, 42, 0.28);
                transform: translateY(10px) scale(0.96);
                animation: successPop 420ms cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            .success-ring {
                position: relative;
                display: inline-flex;
                height: 5.5rem;
                width: 5.5rem;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
                color: #15803d;
                box-shadow: 0 18px 38px rgba(22, 163, 74, 0.22);
            }
            .success-ring::before {
                content: "";
                position: absolute;
                inset: -0.55rem;
                border-radius: inherit;
                border: 1px solid rgba(34, 197, 94, 0.28);
                animation: successPulse 1.4s ease-out infinite;
            }
            .success-check {
                font-size: 3rem;
                transform: scale(0.4);
                opacity: 0;
                animation: successCheck 360ms ease 180ms forwards;
            }
            @keyframes successPop {
                to { transform: translateY(0) scale(1); }
            }
            @keyframes successCheck {
                to { transform: scale(1); opacity: 1; }
            }
            @keyframes successPulse {
                0% { transform: scale(0.9); opacity: 0.75; }
                100% { transform: scale(1.28); opacity: 0; }
            }
        </style>
    </x-slot:head>

    <main>
        <section class="job-hero px-4 pb-16 pt-28 text-white md:px-6 md:pb-20 md:pt-32">
            <div class="mx-auto max-w-6xl">
                <a href="{{ route('home.career-with-us') }}#open-roles" class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white/80">
                    <span class="material-symbols-outlined text-[17px]">arrow_back</span>
                    Back to openings
                </a>
                <div class="mt-8 grid gap-8 lg:grid-cols-[1.08fr_0.92fr] lg:items-end">
                    <div>
                        <span class="inline-flex rounded-full bg-white/12 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.26em] text-white/78">{{ $job->badge ?: 'Open Role' }}</span>
                        <h1 class="mt-5 font-headline text-[2.8rem] font-extrabold leading-[0.96] md:text-[4rem]">{{ $job->title }}</h1>
                        <p class="mt-5 max-w-3xl text-sm leading-8 text-white/76 md:text-[15px]">{{ $job->summary ?: 'Role details will be shared by the HR team.' }}</p>
                    </div>
                    <div class="rounded-[1.7rem] border border-white/14 bg-white/10 p-5 backdrop-blur-md">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/60">Application Checklist</p>
                        <div class="mt-4 space-y-3 text-sm font-semibold text-white/86">
                            <p class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">check_circle</span> Basic contact details</p>
                            <p class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">check_circle</span> Experience and salary details</p>
                            <p class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">check_circle</span> Resume in PDF, DOC, or DOCX</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="job-details" class="px-4 py-16 md:px-6 md:py-20">
            <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[0.86fr_1.14fr]">
                <aside class="space-y-5">
                    <div class="apply-panel p-6">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-indigo-700">Job Details</p>
                        <div class="mt-5 grid gap-3">
                            @foreach ($detailCards as $card)
                                <div class="rounded-[1.1rem] border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined mt-0.5 text-[19px] text-indigo-700">{{ $card['icon'] }}</span>
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-slate-500">{{ $card['label'] }}</p>
                                            <p class="mt-1 text-sm font-bold text-slate-900">{{ $card['value'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if (count($skills) > 0)
                        <div class="apply-panel p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-indigo-700">Preferred Skills</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($skills as $skill)
                                    <span class="rounded-full border border-indigo-100 bg-indigo-50 px-3 py-2 text-[11px] font-bold uppercase tracking-[0.12em] text-indigo-700">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>

                <section class="apply-panel p-6 md:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-indigo-700">Apply Now</p>
                            <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">Submit your application</h2>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">HR Review</span>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('home.career-with-us.apply.submit', $job) }}" class="mt-7 grid gap-5 md:grid-cols-2" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="apply-field"><label for="name">Full Name</label><input id="name" name="name" type="text" value="{{ old('name') }}" required></div>
                        <div class="apply-field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required></div>
                        <div class="apply-field"><label for="phone">Phone No.</label><input id="phone" name="phone" type="text" value="{{ old('phone') }}" required></div>
                        <div class="apply-field"><label for="experience">Experience</label><input id="experience" name="experience" type="text" value="{{ old('experience') }}" placeholder="e.g. 2 years / Fresher" required></div>
                        <div class="apply-field"><label for="current_ctc">Current CTC</label><input id="current_ctc" name="current_ctc" type="text" value="{{ old('current_ctc') }}" placeholder="e.g. 4.5 LPA"></div>
                        <div class="apply-field"><label for="expected_salary">Expected Salary</label><input id="expected_salary" name="expected_salary" type="text" value="{{ old('expected_salary') }}" placeholder="e.g. 6 LPA" required></div>
                        <div class="apply-field"><label for="notice_period">Notice Period</label><input id="notice_period" name="notice_period" type="text" value="{{ old('notice_period') }}" placeholder="Immediate / 30 days"></div>
                        <div class="apply-field"><label for="current_location">Current Location</label><input id="current_location" name="current_location" type="text" value="{{ old('current_location') }}"></div>
                        <div class="apply-field md:col-span-2"><label for="portfolio_url">Portfolio / LinkedIn URL</label><input id="portfolio_url" name="portfolio_url" type="url" value="{{ old('portfolio_url') }}" placeholder="https://"></div>
                        <div class="apply-field md:col-span-2"><label for="resume">Resume</label><input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" required><p class="mt-2 text-xs font-semibold text-slate-500">Accepted formats: PDF, DOC, DOCX. Maximum size: 5 MB.</p></div>
                        <div class="apply-field md:col-span-2"><label for="cover_note">Short Note</label><textarea id="cover_note" name="cover_note" rows="5" placeholder="Tell HR why this role fits you.">{{ old('cover_note') }}</textarea></div>
                        <div class="md:col-span-2">
                            <button class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-700 px-6 py-4 text-sm font-bold text-white shadow-[0_18px_36px_rgba(67,56,202,0.22)] transition hover:bg-indigo-800 md:w-auto" type="submit">
                                <span class="material-symbols-outlined text-[18px]">send</span>
                                Submit Application
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </section>
    </main>

    @if (session('status'))
        <div class="success-modal" id="jobSuccessModal" role="dialog" aria-modal="true" aria-labelledby="jobSuccessTitle">
            <div class="success-card px-6 py-8 text-center md:px-8">
                <div class="success-ring mx-auto">
                    <span class="material-symbols-outlined success-check">check</span>
                </div>
                <p class="mt-6 text-xs font-bold uppercase tracking-[0.24em] text-emerald-700">Application Sent</p>
                <h2 id="jobSuccessTitle" class="mt-3 font-headline text-3xl font-extrabold leading-tight text-slate-900">Your job application has been successfully sent.</h2>
                <p class="mx-auto mt-3 max-w-sm text-sm leading-7 text-slate-600">{{ session('status') }}</p>
                <button class="mt-6 inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-[0_16px_32px_rgba(22,163,74,0.22)] transition hover:bg-emerald-700" type="button" data-success-close>
                    Done
                </button>
            </div>
        </div>

        <script>
            (function () {
                var modal = document.getElementById('jobSuccessModal');
                if (!modal) {
                    return;
                }

                document.body.classList.add('overflow-hidden');

                function closeSuccessModal() {
                    modal.hidden = true;
                    document.body.classList.remove('overflow-hidden');
                }

                modal.querySelector('[data-success-close]').addEventListener('click', closeSuccessModal);
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeSuccessModal();
                    }
                });
                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeSuccessModal();
                    }
                });

                window.setTimeout(closeSuccessModal, 6500);
            })();
        </script>
    @endif
</x-home.marketing-layout>
