<x-student.layout :title="($title ?? 'Coming Soon').' | Student Area'" bodyClass="feature-locked-shell">
    <x-student.topbar>
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Student Workspace</p>
            <p class="font-headline text-lg font-extrabold text-on-surface">{{ $feature ?? 'Section' }}</p>
        </div>
        <x-slot:right>
            <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.dashboard') }}">Dashboard</a>
            <img
                alt="{{ auth()->user()?->name ?? 'Student' }} avatar"
                class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80"
                src="{{ auth()->user()?->avatarUrl(96) ?: 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()?->name ?: 'Student').'&background=EDE8FF&color=4F3DD4&size=128' }}"
            />
        </x-slot:right>
    </x-student.topbar>

    <main class="student-shell-main student-page">
        <div class="student-page-inner">
            <section class="lock-frame">
                <div class="lock-frame__label">Restricted Access</div>
                <div class="lock-frame__canvas" aria-hidden="true">
                    <div class="lock-frame__sidebar"></div>
                    <div class="lock-frame__preview">
                        <div class="lock-frame__line lock-frame__line--lg"></div>
                        <div class="lock-frame__line"></div>
                        <div class="lock-frame__line lock-frame__line--short"></div>
                        <div class="lock-frame__cards">
                            <div class="lock-frame__card"></div>
                            <div class="lock-frame__card"></div>
                            <div class="lock-frame__card"></div>
                        </div>
                    </div>
                </div>

                <div class="lock-modal">
                    <p class="lock-modal__eyebrow">Coming Soon</p>
                    <h1 class="lock-modal__title">{{ $title ?? 'This section is coming soon' }}</h1>
                    <p class="lock-modal__copy">{{ $message ?? 'This section is currently disabled while our team prepares the final release.' }}</p>
                    <a class="student-pill-button student-pill-button--primary" href="{{ route('student.dashboard') }}">Back To Home</a>
                </div>
            </section>
        </div>
    </main>

    <style>
        .feature-locked-shell main,
        .feature-locked-shell aside,
        .feature-locked-shell header {
            user-select: none;
        }

        .lock-frame {
            position: relative;
            min-height: calc(100vh - 9rem);
            border-radius: 1.5rem;
            border: 1px solid rgba(219, 210, 245, 0.96);
            background: linear-gradient(160deg, rgba(255,255,255,0.9), rgba(244,236,255,0.84));
            box-shadow: 0 26px 64px rgba(43, 26, 96, 0.12);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            isolation: isolate;
        }

        .lock-frame::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 82% 18%, rgba(111, 78, 246, 0.18), transparent 38%);
            z-index: -1;
        }

        .lock-frame__label {
            position: absolute;
            top: 1.1rem;
            left: 1.2rem;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #5b3be0;
            background: rgba(237, 232, 255, 0.95);
            border: 1px solid rgba(208, 195, 247, 0.94);
        }

        .lock-frame__canvas {
            width: min(1100px, 100%);
            height: min(580px, calc(100vh - 15rem));
            border-radius: 1.25rem;
            border: 1px solid rgba(214, 202, 245, 0.95);
            background: rgba(255, 255, 255, 0.88);
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr);
            gap: 1rem;
            padding: 1rem;
            filter: blur(7px) saturate(0.82);
            opacity: 0.75;
            pointer-events: none;
        }

        .lock-frame__sidebar {
            border-radius: 1rem;
            border: 1px solid rgba(223, 214, 247, 0.98);
            background: linear-gradient(180deg, rgba(243,238,255,0.92), rgba(254,252,255,0.95));
        }

        .lock-frame__preview {
            border-radius: 1rem;
            border: 1px solid rgba(223, 214, 247, 0.98);
            background: linear-gradient(180deg, rgba(249,246,255,0.92), rgba(255,255,255,0.94));
            padding: 1rem;
        }

        .lock-frame__line {
            height: 0.72rem;
            border-radius: 999px;
            background: rgba(188, 171, 235, 0.72);
            margin-bottom: 0.9rem;
            width: 70%;
        }

        .lock-frame__line--lg {
            height: 1rem;
            width: 84%;
        }

        .lock-frame__line--short {
            width: 45%;
        }

        .lock-frame__cards {
            margin-top: 1.4rem;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .lock-frame__card {
            height: 180px;
            border-radius: 1rem;
            border: 1px solid rgba(223, 214, 247, 0.98);
            background: linear-gradient(180deg, rgba(240,233,255,0.8), rgba(255,255,255,0.9));
        }

        .lock-modal {
            position: absolute;
            inset: 50% auto auto 50%;
            transform: translate(-50%, -50%);
            width: min(620px, calc(100% - 2rem));
            border-radius: 1.25rem;
            border: 1px solid rgba(216, 202, 247, 0.98);
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 28px 60px rgba(43, 26, 96, 0.2);
            padding: 1.65rem;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        .lock-modal__eyebrow {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #7a4de2;
        }

        .lock-modal__title {
            margin-top: 0.8rem;
            font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
            font-weight: 800;
            letter-spacing: -0.04em;
            font-size: clamp(1.5rem, 1.1rem + 1.2vw, 2.4rem);
            color: #1d1533;
        }

        .lock-modal__copy {
            margin: 0.8rem auto 1.4rem;
            max-width: 44ch;
            font-size: 0.93rem;
            line-height: 1.7;
            color: #665c83;
        }

        @media (max-width: 900px) {
            .lock-frame {
                min-height: calc(100vh - 8rem);
                padding: 1rem;
            }

            .lock-frame__canvas {
                grid-template-columns: 120px minmax(0, 1fr);
                gap: 0.75rem;
            }

            .lock-frame__cards {
                grid-template-columns: 1fr;
            }

            .lock-frame__card {
                height: 120px;
            }
        }
    </style>
</x-student.layout>
