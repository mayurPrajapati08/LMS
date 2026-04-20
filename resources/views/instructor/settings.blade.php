<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Instructor Settings</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#b07ac3",
                        "outline-variant": "#dbcde4",
                        "secondary-container": "#eadcf1",
                        "background": "#fcf9fe",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#005523",
                        "tertiary-fixed": "#6bff8f",
                        "on-surface-variant": "#6d5a76",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#0f0069",
                        "outline": "#8f7a99",
                        "on-secondary-fixed-variant": "#755b83",
                        "on-primary-fixed-variant": "#8f52a3",
                        "surface-tint": "#b07ac3",
                        "on-primary-container": "#f5eef8",
                        "on-background": "#191c1d",
                        "on-tertiary-container": "#63f889",
                        "inverse-on-surface": "#f5fbff",
                        "primary": "#6a3378",
                        "surface-bright": "#fcf9fe",
                        "secondary-fixed": "#f0e6f4",
                        "primary-fixed-dim": "#e1cde8",
                        "primary-fixed": "#f0e6f4",
                        "error": "#ba1a1a",
                        "surface-variant": "#e7dcef",
                        "secondary-fixed-dim": "#e1cde8",
                        "surface": "#fcf9fe",
                        "on-error": "#ffffff",
                        "surface-container-high": "#efe5f4",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#4ae176",
                        "surface-container-highest": "#e7dcef",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-fixed-variant": "#005321",
                        "surface-container-low": "#f5eef8",
                        "secondary": "#3b5f8d",
                        "inverse-surface": "#563060",
                        "surface-container": "#f2e9f6",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#007030",
                        "on-surface": "#191c1d",
                        "inverse-primary": "#e1cde8",
                        "surface-dim": "#d4e3f8",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#715f7a",
                        "on-secondary-fixed": "#4b2356"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { font-family: 'Inter', sans-serif; background: #fcf9fe; color: #191c1d; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .editorial-shadow { box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.05); }
    </style>
</head>
<body class="bg-background text-on-background antialiased">
    <x-instructor.navbar />

    <main class="md:ml-64 min-h-screen">
        <header class="sticky top-0 z-40 bg-white/88 backdrop-blur-md border-b border-[#eadff1] flex justify-between items-center w-full pl-16 pr-4 md:px-8 py-4 shadow-sm">
            <div>
                <h1 class="font-headline text-3xl font-bold tracking-tight text-slate-900">Settings</h1>
                <p class="mt-1 text-sm text-slate-500">Manage your public profile, avatar, and account security.</p>
            </div>
            <img alt="Instructor Profile" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#eadff1]" src="{{ $profileAvatar }}" />
        </header>

        <div class="max-w-6xl mx-auto px-4 md:px-8 py-8 md:py-12">
            @if(session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-4 space-y-6">
                    <div class="rounded-[28px] bg-white p-6 md:p-8 border border-slate-200 editorial-shadow">
                        <div class="text-center">
                            <img alt="Profile Avatar" class="mx-auto h-32 w-32 rounded-full object-cover ring-4 ring-[#eadff1]" src="{{ $profileAvatar }}" />
                            <h2 class="mt-5 font-headline text-2xl font-bold text-slate-900">{{ $instructor->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $instructor->email }}</p>
                            <div class="mt-6 rounded-2xl bg-slate-50 px-4 py-4 text-left space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#6a3378]">Security Status</p>
                                <p class="text-sm text-slate-600">Two-step verification is <span class="font-semibold {{ $instructor->two_factor_enabled ? 'text-emerald-600' : 'text-slate-700' }}">{{ $instructor->two_factor_enabled ? 'enabled' : 'disabled' }}</span>.</p>
                                <p class="text-xs text-slate-500">When enabled, login will require your password and an email OTP.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-8">
                    <section class="rounded-[28px] bg-white p-6 md:p-8 border border-slate-200 editorial-shadow">
                        <h3 class="font-headline text-2xl font-bold text-slate-900 mb-6">Public Profile</h3>
                        <form method="POST" action="{{ route('instructor.settings.profile') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Full Name</label>
                                    <input class="mt-2 w-full rounded-2xl border {{ $errors->has('name') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-4 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="name" type="text" value="{{ old('name', $instructor->name) }}" />
                                    @error('name')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Email Address</label>
                                    <input class="mt-2 w-full rounded-2xl border {{ $errors->has('email') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-4 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="email" type="email" value="{{ old('email', $instructor->email) }}" />
                                    @error('email')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Avatar</label>
                                <div class="mt-2 flex flex-col gap-4 md:flex-row md:items-center">
                                    <img alt="Avatar Preview" class="h-20 w-20 rounded-2xl object-cover ring-2 ring-[#eadff1]" src="{{ $profileAvatar }}" />
                                    <div class="flex-1">
                                        <input class="block w-full rounded-2xl border {{ $errors->has('avatar') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-[#f5eef8] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#6a3378] hover:file:bg-[#eadff1]" name="avatar" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" />
                                        <p class="mt-2 text-xs text-slate-500">Upload JPG, PNG, or WEBP up to 5MB.</p>
                                        @error('avatar')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Professional Bio</label>
                                <textarea class="mt-2 w-full rounded-[24px] border {{ $errors->has('bio') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-5 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1] resize-none" name="bio" rows="5" placeholder="Tell students a little about your expertise and teaching style...">{{ old('bio', $instructor->bio) }}</textarea>
                                @error('bio')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Two-Step Verification</p>
                                        <p class="mt-2 text-sm leading-relaxed text-slate-500">Turn this on to require both your password and an email OTP every time you log in.</p>
                                    </div>
                                    <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                                        <input class="h-5 w-5 rounded border-slate-300 text-[#6a3378] focus:ring-[#f5eef8]0" type="checkbox" name="two_factor_enabled" value="1" {{ old('two_factor_enabled', $instructor->two_factor_enabled) ? 'checked' : '' }} />
                                        Enable
                                    </label>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-container px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200/50 hover:opacity-90 transition-all" type="submit">
                                    <span>Save Profile & Security</span>
                                    <span class="material-symbols-outlined text-[1.05rem]">save</span>
                                </button>
                            </div>
                        </form>
                    </section>

                    <section class="rounded-[28px] bg-white p-6 md:p-8 border border-slate-200 editorial-shadow">
                        <h3 class="font-headline text-2xl font-bold text-slate-900 mb-6">Password</h3>
                        <form method="POST" action="{{ route('instructor.settings.password') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Current Password</label>
                                <input class="mt-2 w-full rounded-2xl border {{ $errors->has('current_password') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-4 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="current_password" type="password" />
                                @error('current_password')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">New Password</label>
                                    <input class="mt-2 w-full rounded-2xl border {{ $errors->has('password') ? 'border-red-300' : 'border-slate-200' }} bg-slate-50 px-4 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="password" type="password" />
                                </div>
                                <div>
                                    <label class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Confirm Password</label>
                                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-700 focus:border-[#c79ad4] focus:ring-4 focus:ring-[#eadff1]" name="password_confirmation" type="password" />
                                </div>
                            </div>
                            @error('password')<p class="text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                            <div class="flex justify-end">
                                <button class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-sm font-bold text-white shadow-lg hover:opacity-90 transition-all" type="submit">
                                    <span>Update Password</span>
                                    <span class="material-symbols-outlined text-[1.05rem]">lock</span>
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>



