<x-student.layout title="Learning Workspace | CodeInYourself">
    <x-student.topbar>
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Learning Workspace</p>
            <p class="font-headline text-lg font-extrabold text-on-surface">Lesson Overview</p>
        </div>
        <x-slot:center>
            <label class="student-top-search">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input placeholder="Search lessons, notes, or resources" type="text" />
            </label>
        </x-slot:center>
        <x-slot:right>
            <a class="student-pill-button student-pill-button--ghost" href="{{ route('student.my-learning') }}">My Learning</a>
        </x-slot:right>
    </x-student.topbar>

    <main class="student-shell-main student-page">
        <div class="student-page-inner space-y-8">
            <section class="student-page-header">
                <div>
                    <p class="student-eyebrow">Learning Workspace</p>
                    <h1 class="student-page-title">Learning flow overview</h1>
                    <p class="student-page-copy">A cleaner workspace for lesson flow, notes, resources, and certificate progress without placeholder demo content.</p>
                </div>
                <div class="student-page-meta">
                    <span class="student-chip">Lesson progress</span>
                    <span class="student-chip">Resources ready</span>
                </div>
            </section>

            <section class="grid items-start gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                <div class="student-section">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="student-eyebrow">Now Playing</p>
                            <h2 class="mt-2 font-headline text-[1.8rem] font-bold tracking-[-0.04em] text-on-surface">Continue your active lesson flow</h2>
                        </div>
                        <a class="student-pill-button student-pill-button--primary" href="{{ route('student.my-learning') }}">Resume Learning</a>
                    </div>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant">A compact overview of the current lesson with cleaner structure, easier scanning, and no fake course records.</p>
                    <div class="mt-6 overflow-hidden rounded-[1.25rem] bg-[linear-gradient(135deg,#6f4ef6,#d16bf2)] p-[1px]">
                        <div class="relative aspect-video overflow-hidden rounded-[1.2rem] bg-[#221a3d]">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(209,107,242,0.28),transparent_34%),linear-gradient(180deg,#251a46_0%,#17122d_100%)]"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1f1638] via-transparent to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white/18 backdrop-blur-md">
                                    <span class="material-symbols-outlined text-4xl text-white" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-side-card">
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Quick Summary</p>
                    <div class="mt-5 grid gap-3">
                        <div class="rounded-[1rem] bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-on-surface-variant">Current lesson</p>
                            <p class="mt-2 text-sm font-semibold text-on-surface">Your next unlocked lesson appears here</p>
                        </div>
                        <div class="rounded-[1rem] bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-on-surface-variant">Resources</p>
                            <p class="mt-2 text-sm font-semibold text-on-surface">Downloads and notes stay in one place</p>
                        </div>
                        <div class="rounded-[1rem] bg-surface-container-low p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-on-surface-variant">Certificate goal</p>
                            <p class="mt-2 text-sm font-semibold text-on-surface">Completion progress updates automatically</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1fr_0.9fr_0.8fr]">
                <div class="student-side-card">
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Description</p>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Lesson summaries, key ideas, and next-step guidance can sit here without relying on static sample text.</p>
                </div>
                <div class="student-side-card">
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Resources</p>
                    <div class="mt-4 grid gap-3">
                        <div class="rounded-[0.95rem] bg-surface-container-low px-4 py-3 text-sm font-semibold text-on-surface">Lesson notes</div>
                        <div class="rounded-[0.95rem] bg-surface-container-low px-4 py-3 text-sm font-semibold text-on-surface">Supporting files</div>
                        <div class="rounded-[0.95rem] bg-surface-container-low px-4 py-3 text-sm font-semibold text-on-surface">Practice material</div>
                    </div>
                </div>
                <div class="student-side-card">
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Private Notes</p>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Save quick takeaways here while watching lessons from your real enrolled courses.</p>
                    <a class="student-pill-button student-pill-button--ghost mt-5 w-full justify-center" href="{{ route('student.my-learning') }}">Open My Learning</a>
                </div>
            </section>
        </div>
    </main>
</x-student.layout>
