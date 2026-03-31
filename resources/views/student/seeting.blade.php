<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Student Settings</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3525cd",
                        "primary-container": "#4f46e5",
                        surface: "#f8f9fa",
                        "surface-container-low": "#f3f4f5",
                        "surface-container-high": "#e7e8e9",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#464555",
                        outline: "#777587",
                        tertiary: "#007030",
                        error: "#ba1a1a"
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface font-body text-on-surface antialiased selection:bg-indigo-100">
    <x-student.navbar />

    <header class="fixed top-0 right-0 z-40 flex h-16 w-full items-center justify-between bg-white/85 px-4 shadow-sm backdrop-blur-md md:w-[calc(100%-16rem)] md:px-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-outline">Student Account</p>
            <h1 class="font-headline text-xl font-extrabold">Profile settings</h1>
        </div>
        <img alt="{{ $student->name }} avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ $profileAvatar }}" />
    </header>

    <main class="min-h-screen bg-surface px-4 pb-12 pt-24 md:ml-64 md:px-8">
        <div class="mx-auto max-w-6xl">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="mb-8 grid gap-6 xl:grid-cols-[300px_minmax(0,1fr)] xl:items-start">
                <div class="rounded-[2rem] bg-gradient-to-br from-slate-950 via-indigo-900 to-indigo-700 p-5 text-white shadow-xl xl:sticky xl:top-24">
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-indigo-200">Your account</p>
                    <div class="mt-5 flex items-center gap-3">
                        <img alt="{{ $student->name }} avatar" class="h-20 w-20 rounded-[1.25rem] object-cover ring-4 ring-white/10" src="{{ $profileAvatar }}" />
                        <div class="min-w-0">
                            <h2 class="truncate font-headline text-xl font-extrabold">{{ $student->name }}</h2>
                            <p class="mt-1 truncate text-xs text-indigo-100">{{ $student->email }}</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-6 text-indigo-100">
                        Keep your profile fresh, update your avatar, and secure your learning account with password plus email OTP verification.
                    </p>
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-white/10 p-3">
                            <p class="text-xs uppercase tracking-[0.2em] text-indigo-200">Courses</p>
                            <p class="mt-1 text-2xl font-black">{{ $learningStats['courses'] }}</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-3">
                            <p class="text-xs uppercase tracking-[0.2em] text-indigo-200">Completed</p>
                            <p class="mt-1 text-2xl font-black">{{ $learningStats['completed'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6">
                    <form action="{{ route('student.settings.profile') }}" class="rounded-[2rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70 md:p-8" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="mb-8 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.28em] text-primary">Public profile</p>
                                <h3 class="mt-2 font-headline text-3xl font-extrabold">Personal information</h3>
                            </div>
                            <span class="rounded-full bg-indigo-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-primary">Live on student pages</span>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Avatar</label>
                                <div class="flex flex-col gap-4 rounded-2xl bg-surface-container-low p-4 md:flex-row md:items-center">
                                    <img alt="{{ $student->name }} avatar preview" class="h-20 w-20 rounded-[1.25rem] object-cover" src="{{ $profileAvatar }}" />
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold">Upload a new profile photo</p>
                                        <p class="mt-1 text-xs text-on-surface-variant">This image is uploaded to Cloudinary and shown across student pages.</p>
                                    </div>
                                    <input accept="image/*" class="w-full rounded-xl border-none bg-white px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 md:max-w-xs" name="avatar" type="file" />
                                </div>
                            </div>

                            <div>
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Full name</label>
                                <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="name" type="text" value="{{ old('name', $student->name) }}" />
                            </div>

                            <div>
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Email address</label>
                                <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="email" type="email" value="{{ old('email', $student->email) }}" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Bio</label>
                                <textarea class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm leading-6 focus:ring-2 focus:ring-primary/20" name="bio" rows="4">{{ old('bio', $student->bio) }}</textarea>
                            </div>

                            <div class="md:col-span-2 rounded-2xl border border-indigo-100 bg-indigo-50/60 p-5">
                                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                    <div>
                                        <p class="text-sm font-bold text-on-surface">Two-step verification</p>
                                        <p class="mt-1 text-sm text-on-surface-variant">
                                            When enabled, login requires your password and an email OTP challenge.
                                        </p>
                                    </div>
                                    <label class="inline-flex items-center gap-3 rounded-full bg-white px-4 py-3 shadow-sm">
                                        <input @checked(old('two_factor_enabled', $student->two_factor_enabled)) class="rounded border-indigo-300 text-primary focus:ring-primary/20" name="two_factor_enabled" type="checkbox" value="1" />
                                        <span class="text-sm font-semibold text-primary">Enable security step</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button class="rounded-xl bg-primary px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/20" type="submit">Save profile</button>
                        </div>
                    </form>

                    <form action="{{ route('student.settings.password') }}" class="rounded-[2rem] bg-surface-container-lowest p-6 shadow-sm ring-1 ring-slate-200/70 md:p-8" method="POST">
                        @csrf
                        <div class="mb-8 flex items-start gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-error">
                                <span class="material-symbols-outlined">shield_lock</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.28em] text-outline">Security</p>
                                <h3 class="mt-2 font-headline text-3xl font-extrabold">Change password</h3>
                                <p class="mt-2 text-sm text-on-surface-variant">Use a strong password to protect your enrollments, certificates, and progress.</p>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-3">
                            <div>
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Current password</label>
                                <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="current_password" type="password" />
                            </div>
                            <div>
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">New password</label>
                                <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="password" type="password" />
                            </div>
                            <div>
                                <label class="mb-3 block text-xs font-bold uppercase tracking-[0.28em] text-outline">Confirm password</label>
                                <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" name="password_confirmation" type="password" />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button class="rounded-xl bg-surface-container-high px-6 py-3 text-sm font-bold text-primary" type="submit">Update password</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
