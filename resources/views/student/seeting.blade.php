<x-student.layout title="Student Settings">
<x-student.topbar>
    <div>
        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Student Account</p>
        <p class="font-headline text-lg font-extrabold text-on-surface">Profile Settings</p>
    </div>
    <x-slot:right>
        <img alt="{{ $student->name }} avatar" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/80" src="{{ $profileAvatar }}" />
    </x-slot:right>
</x-student.topbar>

<main class="student-shell-main student-page bg-surface">
    <div class="student-page-inner space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif

        <section class="student-page-header">
            <div>
                <p class="student-eyebrow">Student Account</p>
                <h1 class="student-page-title">Profile settings</h1>
                <p class="student-page-copy">A lighter account page focused on profile editing, security, and cleaner form structure.</p>
            </div>
            <div class="student-page-meta">
                <span class="student-chip">{{ $learningStats['courses'] }} courses</span>
                <span class="student-chip">{{ $learningStats['completed'] }} completed</span>
            </div>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="student-section">
                <div class="student-stats-strip">
                    <div class="student-stat">
                        <p class="student-stat-label">Courses</p>
                        <p class="student-stat-value">{{ $learningStats['courses'] }}</p>
                        <p class="student-stat-copy">Enrolled in account</p>
                    </div>
                    <div class="student-stat">
                        <p class="student-stat-label">Completed</p>
                        <p class="student-stat-value">{{ $learningStats['completed'] }}</p>
                        <p class="student-stat-copy">Finished learning paths</p>
                    </div>
                </div>
            </div>

            <div class="student-side-card">
                <div class="flex items-center gap-4">
                    <img alt="{{ $student->name }} avatar" class="h-20 w-20 rounded-[1.4rem] object-cover" src="{{ $profileAvatar }}" />
                    <div class="min-w-0">
                        <h2 class="truncate font-headline text-2xl font-extrabold text-on-surface">{{ $student->name }}</h2>
                        <p class="mt-2 truncate text-sm text-on-surface-variant">{{ $student->email }}</p>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="rounded-[1.2rem] bg-surface-container-low p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Courses</p>
                        <p class="mt-3 font-headline text-3xl font-extrabold">{{ $learningStats['courses'] }}</p>
                    </div>
                    <div class="rounded-[1.2rem] bg-surface-container-low p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">Completed</p>
                        <p class="mt-3 font-headline text-3xl font-extrabold">{{ $learningStats['completed'] }}</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
            <form action="{{ route('student.settings.profile') }}" class="rounded-[1.3rem] bg-surface-container-lowest p-5 md:p-6" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-primary">Public Profile</p>
                        <h2 class="mt-3 font-headline text-[1.9rem] font-extrabold text-on-surface">Personal information</h2>
                    </div>
                    <span class="student-chip">Live on student pages</span>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2 rounded-[1.5rem] bg-surface-container-low p-4">
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Avatar</label>
                        <div class="flex flex-col gap-4 md:flex-row md:items-center">
                            <img alt="{{ $student->name }} avatar preview" class="h-20 w-20 rounded-[1.25rem] object-cover" src="{{ $profileAvatar }}" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-on-surface">Upload a new profile photo</p>
                                <p class="mt-1 text-xs text-on-surface-variant">This image is uploaded to Cloudflare R2 and shown across student pages.</p>
                            </div>
                            <input accept="image/*" class="w-full rounded-xl border-none bg-white px-4 py-3 text-sm md:max-w-xs" name="avatar" type="file" />
                        </div>
                    </div>

                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Full name</label>
                        <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="name" type="text" value="{{ old('name', $student->name) }}" />
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Email address</label>
                        <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="email" type="email" value="{{ old('email', $student->email) }}" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Bio</label>
                        <textarea class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm leading-7" name="bio" rows="4">{{ old('bio', $student->bio) }}</textarea>
                    </div>
                    <div class="md:col-span-2 rounded-[1.5rem] border border-[#eadff1] bg-[#f7f2ff] p-5">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div>
                                <p class="text-sm font-bold text-on-surface">Two-step verification</p>
                                <p class="mt-2 text-sm leading-7 text-on-surface-variant">When enabled, login requires your password and an email OTP challenge.</p>
                            </div>
                            <label class="inline-flex items-center gap-3 rounded-full bg-white px-4 py-3 shadow-sm">
                                <input @checked(old('two_factor_enabled', $student->two_factor_enabled)) class="rounded border-[#c79ad4] text-primary" name="two_factor_enabled" type="checkbox" value="1" />
                                <span class="text-sm font-semibold text-primary">Enable security step</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button class="student-pill-button student-pill-button--primary" type="submit">Save Profile</button>
                </div>
            </form>

            <form action="{{ route('student.settings.password') }}" class="rounded-[1.3rem] bg-surface-container-lowest p-5 md:p-6" method="POST">
                @csrf
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-[1.1rem] bg-red-50 text-error">
                        <span class="material-symbols-outlined">shield_lock</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-on-surface-variant">Security</p>
                        <h2 class="mt-3 font-headline text-[1.9rem] font-extrabold text-on-surface">Change password</h2>
                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">Use a strong password to protect your enrollments, certificates, and progress.</p>
                    </div>
                </div>

                <div class="mt-8 grid gap-6">
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Current password</label>
                        <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="current_password" type="password" />
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">New password</label>
                        <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="password" type="password" />
                    </div>
                    <div>
                        <label class="mb-3 block text-xs font-bold uppercase tracking-[0.24em] text-on-surface-variant">Confirm password</label>
                        <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm" name="password_confirmation" type="password" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button class="student-pill-button student-pill-button--ghost" type="submit">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</main>
</x-student.layout>
