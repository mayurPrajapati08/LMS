<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login &amp; Signup | Code In Yourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline": "#717786",
                        "primary-fixed-dim": "#adc7ff",
                        "primary-fixed": "#d8e2ff",
                        "on-tertiary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "outline-variant": "#c1c6d7",
                        "background": "#f7f9ff",
                        "secondary-fixed": "#dae2ff",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#66df75",
                        "on-primary-fixed-variant": "#004493",
                        "on-primary-container": "#fefcff",
                        "on-primary": "#ffffff",
                        "tertiary-fixed": "#83fc8e",
                        "inverse-surface": "#2d3135",
                        "inverse-primary": "#adc7ff",
                        "surface-container-highest": "#e0e3e8",
                        "on-tertiary-fixed": "#002106",
                        "primary-container": "#0070ea",
                        "surface-tint": "#005bc0",
                        "on-tertiary-fixed-variant": "#00531a",
                        "surface-dim": "#d7dadf",
                        "secondary-fixed-dim": "#bec6e3",
                        "on-secondary-container": "#5a627b",
                        "surface-bright": "#f7f9ff",
                        "secondary-container": "#d7dffd",
                        "tertiary": "#006b24",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#3e465e",
                        "on-background": "#181c20",
                        "primary": "#0059bb",
                        "on-surface": "#181c20",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#f1f4f9",
                        "surface-container": "#ebeef3",
                        "tertiary-container": "#008730",
                        "on-error": "#ffffff",
                        "surface": "#f7f9ff",
                        "on-surface-variant": "#414754",
                        "on-tertiary-container": "#f7fff2",
                        "on-primary-fixed": "#001a41",
                        "secondary": "#565e77",
                        "surface-variant": "#e0e3e8",
                        "on-secondary-fixed": "#131b30",
                        "inverse-on-surface": "#eef1f6",
                        "surface-container-high": "#e5e8ee"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.56));
            backdrop-filter: blur(14px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.24);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface min-h-screen overflow-x-hidden selection:bg-primary-fixed selection:text-on-primary-fixed">
    @php
        $isSignup = request()->is('register');
        $isOtpVerification = request()->routeIs('verification.notice');
        $primaryError = $errors->first('email') ?: $errors->first('password') ?: $errors->first('otp') ?: $errors->first('first_name') ?: $errors->first('last_name') ?: $errors->first('terms');
    @endphp

    <main class="flex min-h-screen">
        <section class="hidden lg:flex lg:w-1/2 relative flex-col justify-center p-20 overflow-hidden bg-slate-900">
            <div class="absolute inset-0 z-0 opacity-40">
                <img class="w-full h-full object-cover" data-alt="Abstract futuristic digital circuit board pattern with glowing blue lines and data points on a dark background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCoELogDO6sM2n2QAcB2QZpmRcfPpJFNdlsfuvORIOqAJzKm7wxdHbTrZ54Vl1m9Q7QJCQn2QyNKQa6IGjjVsc8T-8p-CXeikLOWwG8Zr_AmCOj6IfVSKMkTew5zwPmXTRrP4QFIV2RzqQEPAKe-OkIfm4WQN_U0mZs9j2RF3xphe4CwK_DpRqDm2wJzwrnQiWnqb2gY13ipGACqcWs0J-I22vf2txyb_XORE8gYmiTd1ghABCEelyljHTPYKX5Hsbv9vrUQiaA7Lkz" />
            </div>
            <div class="absolute inset-0 z-10 bg-gradient-to-br from-primary/80 to-slate-900/90"></div>
            <div class="relative z-20 max-w-lg">
                <div class="mb-12">
                    <span class="text-white font-headline font-black text-3xl tracking-tighter">Code In Yourself</span>
                </div>
                <h1 class="font-headline text-5xl font-extrabold text-white leading-tight mb-6">
                    Engineering <span class="text-primary-fixed-dim">Next-Gen</span> Careers.
                </h1>
                <p class="text-primary-fixed text-lg leading-relaxed mb-10">
                    Join a community of professional developers. Master full-stack engineering with our production-grade curriculum and AI-powered mentorship.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-card p-6 rounded-xl border border-white/20">
                        <span class="material-symbols-outlined text-primary-fixed-dim block mb-2" data-icon="groups">groups</span>
                        <div class="text-white font-extrabold text-2xl tracking-tight">15k+</div>
                        <div class="text-white/80 text-sm font-medium">Active Students</div>
                    </div>
                    <div class="glass-card p-6 rounded-xl border border-white/20">
                        <span class="material-symbols-outlined text-primary-fixed-dim block mb-2" data-icon="rocket_launch">rocket_launch</span>
                        <div class="text-white font-extrabold text-2xl tracking-tight">94%</div>
                        <div class="text-white/80 text-sm font-medium">Placement Rate</div>
                    </div>
                </div>
                <div class="mt-12 flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" data-alt="Portrait of a young male professional smiling" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBdcnr3pI5SoHbVZ-Kg4CGE0BT_2hvQVlBDKPqZOm9uQTK3hIbjN6We5FGhtmfo7MuOBKycIixhrhUGFCa6-C0hAw-1H-elGMLxFlE4v7LeQNoQ9N_pgo5R6d9b-luDMz5gqVIl8ZooWn1-lP8PrtN2UCSehBmBeJgo4NSB_QfKmnU44Xsn3_iDvurD8QdOOo9YpKWs5XrVT1lUs7Nr_B3uzKQiRjVfhQIOqfDSNlIxpuVGBdD6xrYIPGcvPPNZXnog-pZ4eQG6OVnz" />
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" data-alt="Portrait of a female developer with glasses" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6wrEg_-apWY0feH5jrog363imAwvhKq1xHjk_ttSeoLa0y_3fxG9H_i-5ZFWmYFL7t93VoGO-RJVAzu9KMkI3pjgG0YJfjj9OxIIZMMdxPSAURd7-F2yFnzUoXVZUszIYF7p8taeocFN0WkqgfyBXtoA8EgqUaZEz4hkkzrjABcKXkBJkm1ZVKqp4Uas0mmMV3j3EVQ4XxYMXLV-qxRQXF0NN8Al4Jwd48J2XWLQwrj7aYBnbkY_IA-UlNXx0UXdzo-hm1KpV9Hg-" />
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" data-alt="Portrait of a tech lead in a modern office" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzj2hgZ1IeAPFJbeZ5iLiIFLzdKi9Mu-UciiR0E-vwftdGAgs0Vf0JfXc3lPQzaMv2TZrk8FW5emfKqY7-H7Amgotigg8ngn21uGwwxmlDqqcfm1FYuy7HKM0y-PTLDwkktjVI7y61rJm4Up0lun4fIOrMUjmvjPmB_NXmqBbNipDqA-DrMJeeBGQWZmAyicKJGlL1knA4Dsq_OdoYlDZhAbXtPxobCfCv_Lf0c4dCESOpmU07Eu0Q43pMvzlmJ88JzXy9FvvwaHqf" />
                    </div>
                    <p class="text-primary-fixed text-sm">Join 500+ students starting today</p>
                </div>
            </div>
        </section>

        <section class="w-full lg:w-1/2 flex flex-col items-center justify-center px-4 py-8 sm:px-6 md:p-16 lg:p-24 bg-surface">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8">
                    <span class="text-primary font-headline font-black text-2xl tracking-tighter">Code In Yourself</span>
                </div>

                <header class="mb-8">
                    <h2 class="text-3xl font-headline font-extrabold text-on-surface mb-2">
                        {{ $isOtpVerification ? 'Verify Your Email' : ($isSignup ? 'Create Your Account' : 'Welcome Back') }}
                    </h2>
                    <p class="text-on-surface-variant font-medium">
                        {{ $isOtpVerification ? 'Enter the 6-digit code sent to '.auth()->user()->email.' to finish verification.' : ($isSignup ? 'Start your learning journey with a new student account.' : 'Continue your learning journey today.') }}
                    </p>
                </header>

                @unless ($isOtpVerification)
                    <div class="bg-surface-container-low p-1.5 rounded-xl flex mb-8">
                        <a href="{{ route('login', absolute: false) }}"
                            class="flex-1 py-2.5 text-center text-sm font-semibold rounded-lg transition-all {{ $isSignup ? 'text-on-surface-variant hover:text-on-surface' : 'bg-surface-container-lowest text-primary shadow-sm' }}">
                            Login
                        </a>
                        <a href="{{ route('register', absolute: false) }}"
                            class="flex-1 py-2.5 text-center text-sm font-semibold rounded-lg transition-all {{ $isSignup ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                            Signup
                        </a>
                    </div>

                    <div class="space-y-4 mb-8">
                        <a href="{{ route('login.google.redirect', absolute: false) }}" class="w-full flex items-center justify-center gap-3 bg-surface-container-lowest border border-outline-variant py-3 px-4 rounded-xl font-semibold text-on-surface hover:bg-surface-container transition-colors active:scale-[0.98] duration-200">
                            <svg class="w-5 h-5" viewbox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                            </svg>
                            <span>{{ $isSignup ? 'Sign up with Google' : 'Continue with Google' }}</span>
                        </a>
                    </div>

                    <div class="relative mb-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-outline-variant/30"></div>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase tracking-widest font-label font-semibold">
                            <span class="bg-surface px-4 text-on-surface-variant">{{ $isSignup ? 'Or sign up with email' : 'Or login with email' }}</span>
                        </div>
                    </div>
                @endunless

                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold">
                            {{ $isOtpVerification ? 'Verification failed' : ($isSignup ? 'Signup could not be completed' : 'Login could not be completed') }}
                        </p>
                        @if ($primaryError)
                            <p class="mt-1">{{ $primaryError }}</p>
                        @endif
                    </div>
                @endif

                <form action="{{ $isOtpVerification ? route('verification.verify', absolute: false) : ($isSignup ? route('register.store', absolute: false) : route('login.attempt', absolute: false)) }}" method="POST" class="space-y-6">
                    @csrf
                    @if ($isOtpVerification)
                        <div class="space-y-2 rounded-2xl border border-outline-variant/30 bg-surface-container-low px-5 py-4">
                            <p class="text-sm font-semibold text-on-surface">Email Verification Code</p>
                            <p class="text-sm text-on-surface-variant">Check your inbox and enter the 6-digit OTP below.</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="otp">6-Digit OTP</label>
                            <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-4 text-center text-xl sm:text-2xl font-extrabold tracking-[0.25em] sm:tracking-[0.35em] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('otp') ? 'border-red-400' : 'border-outline-variant/50' }}" id="otp" name="otp" placeholder="000000" type="text" inputmode="numeric" maxlength="6" autocomplete="one-time-code" value="{{ old('otp') }}" />
                            @error('otp')
                                <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @elseif ($isSignup)
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="first_name">First Name</label>
                                <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('first_name') ? 'border-red-400' : 'border-outline-variant/50' }}" id="first_name" name="first_name" placeholder="First Name" type="text" maxlength="255" autocomplete="given-name" value="{{ old('first_name') }}" />
                                @error('first_name')
                                    <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="last_name">Last Name</label>
                                <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('last_name') ? 'border-red-400' : 'border-outline-variant/50' }}" id="last_name" name="last_name" placeholder="Last Name" type="text" maxlength="255" autocomplete="family-name" value="{{ old('last_name') }}" />
                                @error('last_name')
                                    <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @unless ($isOtpVerification)
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="email">
                                {{ $isSignup ? 'Email Address' : 'Work Email' }}
                            </label>
                            <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('email') ? 'border-red-400' : 'border-outline-variant/50' }}" id="email" name="email" placeholder="{{ $isSignup ? 'you@example.com' : 'name@company.com' }}" type="email" maxlength="255" autocomplete="email" autocapitalize="off" spellcheck="false" value="{{ old('email') }}" />
                            @error('email')
                                <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center ml-1">
                                <label class="block text-sm font-semibold text-on-surface-variant" for="password">Password</label>
                                @unless ($isSignup)
                                    <a class="text-xs font-bold text-primary hover:underline underline-offset-4" href="#">Forgot Password?</a>
                                @endunless
                            </div>
                                <div class="relative">
                                    <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('password') ? 'border-red-400' : 'border-outline-variant/50' }}" id="password" name="password" placeholder="........" type="password" autocomplete="{{ $isSignup ? 'new-password' : 'current-password' }}" />
                                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" data-password-toggle="password" aria-label="Show password">
                                        <span class="material-symbols-outlined text-sm" data-password-toggle-icon="password">visibility</span>
                                </button>
                            </div>
                            @if ($isSignup)
                                <div id="passwordStrengthPanel" class="hidden rounded-xl border border-outline-variant/30 bg-surface-container-low px-3 py-3">
                                    <div class="flex items-center gap-3">
                                        <p class="shrink-0 text-xs font-semibold uppercase tracking-wide text-on-surface-variant">Strength</p>
                                        <div class="grid flex-1 grid-cols-4 gap-1.5">
                                            <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                            <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                            <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                            <span class="h-1.5 rounded-full bg-surface-variant" data-strength-bar></span>
                                        </div>
                                        <span id="passwordStrengthLabel" class="shrink-0 text-xs font-bold uppercase tracking-wide text-on-surface-variant">Too weak</span>
                                    </div>
                                    <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs">
                                        <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="length">
                                            <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                            8+ chars
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="lower">
                                            <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                            lowercase
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="upper">
                                            <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                            uppercase
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="number">
                                            <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                            number
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-on-surface-variant" data-password-rule="symbol">
                                            <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                                            symbol
                                        </span>
                                    </div>
                                </div>
                            @endif
                            @error('password')
                                <p class="ml-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($isSignup)
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-on-surface-variant ml-1" for="confirm_password">Confirm Password</label>
                                <div class="relative">
                                    <input class="w-full bg-surface-container-lowest border rounded-xl px-4 py-3 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline {{ $errors->has('password') ? 'border-red-400' : 'border-outline-variant/50' }}" id="confirm_password" name="password_confirmation" placeholder="........" type="password" autocomplete="new-password" />
                                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" data-password-toggle="confirm_password" aria-label="Show confirm password">
                                        <span class="material-symbols-outlined text-sm" data-password-toggle-icon="confirm_password">visibility</span>
                                    </button>
                                </div>
                                @if ($errors->has('password'))
                                    <p class="ml-1 text-sm text-red-600">Confirm your password exactly the same.</p>
                                @endif
                            </div>
                        @endif

                        <div class="flex items-start gap-2 ml-1">
                            <input class="mt-1 w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container-lowest" id="{{ $isSignup ? 'terms' : 'remember' }}" name="{{ $isSignup ? 'terms' : 'remember' }}" type="checkbox" value="1" {{ old($isSignup ? 'terms' : 'remember') ? 'checked' : '' }} />
                            <label class="text-sm font-medium text-on-surface-variant" for="{{ $isSignup ? 'terms' : 'remember' }}">
                                {{ $isSignup ? 'I agree to the Terms of Service, Privacy Policy, and student community guidelines.' : 'Keep me logged in' }}
                            </label>
                        </div>
                        @if ($isSignup)
                            @error('terms')
                                <p class="ml-1 -mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        @endif
                    @endunless

                    <button class="w-full bg-primary-container text-on-primary-container font-headline font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:bg-primary transition-all active:scale-[0.98] duration-200 disabled:cursor-not-allowed disabled:opacity-70" type="submit" data-submit-button data-loading-text="{{ $isOtpVerification ? 'Verifying...' : ($isSignup ? 'Creating account and sending OTP...' : 'Signing in...') }}">
                        {{ $isOtpVerification ? 'Verify Email Address' : ($isSignup ? 'Create Student Account' : 'Sign In to Account') }}
                    </button>
                </form>

                @if ($isOtpVerification)
                    <form action="{{ route('verification.resend', absolute: false) }}" method="POST" class="mt-4">
                        @csrf
                        <button class="w-full bg-surface-container-lowest border border-outline-variant/50 text-on-surface font-semibold py-3 rounded-xl hover:bg-surface-container transition-all disabled:cursor-not-allowed disabled:opacity-70" type="submit" data-submit-button data-loading-text="Sending new OTP...">
                            Resend OTP
                        </button>
                    </form>
                @endif

                <footer class="mt-12 text-center">
                    @if ($isOtpVerification)
                        <p class="text-sm text-on-surface-variant">Need a different account?</p>
                        <form action="{{ route('logout') }}" method="POST" class="mt-3">
                            @csrf
                            <button class="text-on-surface font-semibold hover:underline" type="submit">Logout</button>
                        </form>
                    @else
                        <p class="text-sm text-on-surface-variant">
                        @if ($isSignup)
                            Already have an account?
                            <a class="text-on-surface font-semibold hover:underline" href="{{ route('login', absolute: false) }}">Sign in</a>
                        @else
                            By signing in, you agree to our
                            <a class="text-on-surface font-semibold hover:underline" href="#">Terms of Service</a>
                            and
                            <a class="text-on-surface font-semibold hover:underline" href="#">Privacy Policy</a>.
                        @endif
                        </p>
                    @endif
                </footer>
            </div>
        </section>
    </main>

    <div class="fixed bottom-4 right-4 z-50 sm:bottom-6 sm:right-6">
        <button class="bg-surface-container-lowest/80 backdrop-blur-md border border-outline-variant/20 p-3 rounded-full shadow-2xl flex items-center gap-2 pr-5 hover:bg-surface-container-lowest transition-all group">
            <div class="w-10 h-10 bg-tertiary-container rounded-full flex items-center justify-center text-on-tertiary-container">
                <span class="material-symbols-outlined" data-icon="support_agent">support_agent</span>
            </div>
            <div class="hidden sm:block text-left">
                <p class="text-[10px] uppercase tracking-tighter font-bold text-on-surface-variant">Help Center</p>
                <p class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">Talk to a Mentor</p>
            </div>
        </button>
    </div>
    <script>
        (function () {
            document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var targetId = button.getAttribute('data-password-toggle');
                    var input = document.getElementById(targetId);
                    var icon = document.querySelector('[data-password-toggle-icon="' + targetId + '"]');

                    if (!input) {
                        return;
                    }

                    var showing = input.type === 'text';
                    input.type = showing ? 'password' : 'text';

                    if (icon) {
                        icon.textContent = showing ? 'visibility' : 'visibility_off';
                    }

                    button.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                });
            });

            var passwordInput = document.getElementById('password');
            var strengthPanel = document.getElementById('passwordStrengthPanel');
            var strengthLabel = document.getElementById('passwordStrengthLabel');
            var bars = document.querySelectorAll('[data-strength-bar]');
            var ruleItems = document.querySelectorAll('[data-password-rule]');

            if (!passwordInput || !strengthPanel || !strengthLabel || !bars.length || !ruleItems.length) {
                return;
            }

            var palette = {
                weak: { text: 'Too weak', color: 'rgb(220 38 38)', bar: 'rgb(248 113 113)' },
                fair: { text: 'Fair', color: 'rgb(217 119 6)', bar: 'rgb(251 191 36)' },
                good: { text: 'Good', color: 'rgb(37 99 235)', bar: 'rgb(96 165 250)' },
                strong: { text: 'Strong', color: 'rgb(22 163 74)', bar: 'rgb(74 222 128)' }
            };

            function setRuleState(rule, passed) {
                var icon = rule.querySelector('.material-symbols-outlined');
                rule.style.color = passed ? 'rgb(22 163 74)' : 'rgb(65 71 84)';
                if (icon) {
                    icon.textContent = passed ? 'check_circle' : 'radio_button_unchecked';
                }
            }

            function updateStrength() {
                var value = passwordInput.value || '';
                var checks = {
                    length: value.length >= 8,
                    lower: /[a-z]/.test(value),
                    upper: /[A-Z]/.test(value),
                    number: /\d/.test(value),
                    symbol: /[^A-Za-z0-9]/.test(value)
                };

                ruleItems.forEach(function (rule) {
                    var key = rule.getAttribute('data-password-rule');
                    setRuleState(rule, !!checks[key]);
                });

                var score = Object.values(checks).filter(Boolean).length;
                var level = score <= 2 ? 'weak' : score === 3 ? 'fair' : score === 4 ? 'good' : 'strong';

                if (!value.length) {
                    strengthPanel.classList.add('hidden');
                    level = 'weak';
                } else {
                    strengthPanel.classList.remove('hidden');
                }

                strengthLabel.textContent = palette[level].text;
                strengthLabel.style.color = palette[level].color;

                var activeBars = value.length ? Math.max(1, Math.min(4, Math.ceil(score * 0.8))) : 1;
                bars.forEach(function (bar, index) {
                    bar.style.backgroundColor = index < activeBars ? palette[level].bar : 'rgb(224 227 232)';
                });
            }

            passwordInput.addEventListener('input', updateStrength);
            updateStrength();

            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', function () {
                    var submitButton = form.querySelector('[data-submit-button]');

                    if (!submitButton || submitButton.disabled) {
                        return;
                    }

                    submitButton.disabled = true;

                    if (!submitButton.dataset.originalText) {
                        submitButton.dataset.originalText = submitButton.innerHTML.trim();
                    }

                    var loadingText = submitButton.getAttribute('data-loading-text');

                    if (loadingText) {
                        submitButton.textContent = loadingText;
                    }
                });
            });
        })();
    </script>
</body>

</html>
