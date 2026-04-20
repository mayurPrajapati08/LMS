<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Two-Step Verification | CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "background": "#fcf9fe",
                        "surface": "#fcf9fe",
                        "surface-container-low": "#f5eef8",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#dbcde4",
                        "on-surface": "#181c20",
                        "on-surface-variant": "#6d5a76",
                        "primary": "#6a3378",
                        "primary-container": "#8f52a3",
                        "on-primary-container": "#fefcff"
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scrollbar-gutter: stable;
            scrollbar-width: thin;
            scrollbar-color: rgba(106, 51, 120, 0.76) rgba(243, 236, 247, 0.96);
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            width: 12px;
        }

        html::-webkit-scrollbar-track,
        body::-webkit-scrollbar-track {
            background:
                linear-gradient(180deg, rgba(252, 247, 254, 0.98), rgba(240, 231, 245, 0.98));
            border-left: 1px solid rgba(219, 205, 228, 0.72);
        }

        html::-webkit-scrollbar-thumb,
        body::-webkit-scrollbar-thumb {
            background:
                linear-gradient(180deg, rgba(106, 51, 120, 0.90), rgba(143, 82, 163, 0.84));
            border: 2px solid rgba(252, 247, 254, 0.96);
            border-radius: 9999px;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.24),
                0 6px 16px rgba(106, 51, 120, 0.14);
        }

        html::-webkit-scrollbar-thumb:hover,
        body::-webkit-scrollbar-thumb:hover {
            background:
                linear-gradient(180deg, rgba(90, 41, 104, 0.94), rgba(122, 61, 143, 0.88));
        }
    </style>
</head>
<body class="bg-surface font-['Inter'] text-on-surface min-h-screen antialiased">
    <x-shared.back-to-top />
    <main class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md rounded-[32px] border border-outline-variant/40 bg-surface-container-lowest p-8 shadow-2xl shadow-slate-200/70">
            <div class="mb-8 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Two-Step Verification</p>
                <h1 class="mt-3 font-['Manrope'] text-3xl font-extrabold text-on-surface">Verify your sign in</h1>
                <p class="mt-3 text-sm leading-relaxed text-on-surface-variant">Enter the 6-digit OTP sent to <span class="font-semibold text-on-surface">{{ $email }}</span> to complete your login.</p>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Verification failed</p>
                    <p class="mt-1">{{ $errors->first('otp') }}</p>
                </div>
            @endif

            <form action="{{ route('two-factor.verify', absolute: false) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-on-surface-variant" for="otp">6-Digit OTP</label>
                    <input class="w-full rounded-2xl border border-outline-variant/50 bg-surface-container-low px-4 py-4 text-center text-2xl font-extrabold tracking-[0.35em] text-on-surface focus:border-transparent focus:outline-none focus:ring-2 focus:ring-primary" id="otp" name="otp" type="text" inputmode="numeric" maxlength="6" placeholder="000000" value="{{ old('otp') }}" />
                </div>
                <button class="w-full rounded-2xl bg-primary-container py-4 font-['Manrope'] text-sm font-bold text-on-primary-container shadow-lg shadow-[#b07ac3]/30 transition-all hover:opacity-90" type="submit">Verify And Sign In</button>
            </form>

            <form action="{{ route('two-factor.resend', absolute: false) }}" method="POST" class="mt-4">
                @csrf
                <button class="w-full rounded-2xl border border-outline-variant/50 bg-surface-container-low py-3 text-sm font-semibold text-on-surface transition-all hover:bg-white" type="submit">Resend OTP</button>
            </form>

            <form action="{{ route('login', absolute: false) }}" method="GET" class="mt-4 text-center">
                <button class="text-sm font-semibold text-on-surface-variant hover:text-on-surface" type="submit">Back to login</button>
            </form>
        </div>
    </main>
</body>
</html>


