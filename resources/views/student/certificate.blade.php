<x-student.layout title="Certificates | CodeInYourself">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Achievement Vault</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">Certificates</p>
    </div>
    <x-slot:center>
        <form action="{{ route('student.certificates') }}" method="GET">
            <label class="student-top-search">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input name="search" placeholder="Search your credentials" type="text" value="{{ $search }}" />
            </label>
        </form>
    </x-slot:center>
    <x-slot:right>
        <img alt="Profile" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $studentAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page">
    <div class="student-page-inner space-y-8">
        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Achievement Vault</p>
                <h1 class="student-page-title">Certificates</h1>
                <p class="student-page-copy">A more minimal credential archive with cleaner scanning and sharper certificate cards.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $issuedCount }} issued</span>
                <span class="student-chip">{{ $pendingCount }} pending</span>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">Issued</p>
                        <p class="student-stat-value">{{ $issuedCount }}</p>
                        <p class="student-stat-copy">Ready to download</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Pending</p>
                        <p class="student-stat-value">{{ $pendingCount }}</p>
                        <p class="student-stat-copy">Completing soon</p>
                    </div>
                </div>
            </div>
            <div class="student-side-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-on-surface-variant">Recognition Status</p>
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="rounded-[1.3rem] bg-surface-container-low p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Issued</p>
                        <p class="mt-3 font-headline text-3xl font-extrabold text-on-surface">{{ $issuedCount }}</p>
                    </div>
                    <div class="rounded-[1.3rem] bg-surface-container-low p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Pending</p>
                        <p class="mt-3 font-headline text-3xl font-extrabold text-on-surface">{{ $pendingCount }}</p>
                    </div>
                </div>
                @if ($search !== '')
                    <a class="student-pill-button student-pill-button--ghost mt-8" href="{{ route('student.certificates') }}">Clear Search</a>
                @endif
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($issuedCertificates as $certificate)
                @php($course = $certificate->course)
                <article class="overflow-hidden rounded-[1.3rem] bg-surface-container-lowest">
                    <div class="relative h-56 overflow-hidden">
                        <img alt="{{ $course->title }}" class="h-full w-full object-cover" src="{{ $course->thumbnail ?: 'https://ui-avatars.com/api/?name='.urlencode($course->title).'&background=E2E8F0&color=334155&size=480' }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between gap-3 text-white">
                            <span class="rounded-full bg-white/14 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em]">Verified</span>
                            <span class="text-xs font-semibold">{{ optional($certificate->issued_at)->format('M Y') ?: optional($certificate->created_at)->format('M Y') }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-headline text-2xl font-extrabold text-on-surface">{{ $course->title }}</h3>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ \Illuminate\Support\Str::limit($course->details, 120) }}</p>
                        <p class="mt-4 text-xs text-on-surface-variant">Instructor: {{ $course->user?->name ?: 'Instructor' }}</p>
                        <div class="mt-6 flex gap-3">
                            <a class="student-pill-button student-pill-button--primary flex-1 justify-center" href="{{ $certificate->certificate_url }}">Download</a>
                            <button class="student-pill-button student-pill-button--ghost flex-1 justify-center" type="button">Share</button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[1.3rem] bg-surface-container-lowest p-8 text-center md:col-span-2 xl:col-span-2">
                    <h3 class="font-headline text-[1.9rem] font-extrabold text-on-surface">No issued certificates yet</h3>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Complete a course and issue a certificate record to see it here.</p>
                </div>
            @endforelse

            @foreach ($pendingCertificates->take(2) as $pending)
                <article class="overflow-hidden rounded-[1.3rem] border border-dashed border-outline-variant/30 bg-surface-container-lowest">
                    <div class="relative h-56 overflow-hidden">
                        <img alt="{{ $pending['title'] }}" class="h-full w-full object-cover grayscale opacity-60" src="{{ $pending['thumbnail'] }}" />
                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/45 backdrop-blur-sm">
                            <div class="h-16 w-16 animate-spin rounded-full border-4 border-primary border-t-transparent"></div>
                            <p class="mt-4 text-xs font-bold uppercase tracking-[0.18em] text-primary">{{ $pending['progress_percent'] }}% Complete</p>
                        </div>
                    </div>
                    <div class="p-6 opacity-70">
                        <h3 class="font-headline text-2xl font-extrabold text-on-surface">{{ $pending['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ \Illuminate\Support\Str::limit($pending['details'], 110) }}</p>
                    </div>
                </article>
            @endforeach
        </section>
    </div>
</main>
</x-student.layout>
