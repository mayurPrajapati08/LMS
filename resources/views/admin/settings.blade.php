<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself - Platform Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#6a3378",
                        "primary-container": "#b07ac3",
                        "background": "#fcf9fe",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f5eef8",
                        "surface-container-high": "#efe5f4",
                        "surface-container-highest": "#e7dcef",
                        "on-surface": "#191c1d",
                        "on-surface-variant": "#6d5a76",
                        "outline-variant": "#dbcde4",
                        "primary-fixed": "#f0e6f4",
                        "on-primary-fixed-variant": "#8f52a3",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; background-color: #fcf9fe; color: #191c1d; }
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; }
        .editorial-shadow { box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.04); }
        .primary-gradient { background: linear-gradient(135deg, #6a3378 0%, #b07ac3 100%); }
        .tab-panel[hidden] { display: none !important; }
        .admin-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2.75rem;
            background-image: none;
        }
    </style>
</head>
<body class="bg-background text-on-surface antialiased">
    <x-admin.navbar />

    <header class="fixed top-0 right-0 left-0 md:left-64 h-16 z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 md:px-8 w-full md:w-[calc(100%-16rem)] border-b border-slate-100">
        <div class="flex items-center gap-4 flex-1 max-w-[10rem] sm:max-w-[12rem] md:max-w-none">
            <div class="relative w-full md:max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
                <input class="w-full pl-10 pr-3 md:pr-4 py-2 bg-surface-container-low border-none rounded-full text-sm focus:ring-2 focus:ring-[#f5eef8]/20 outline-none transition-all" placeholder="Search..." type="text" />
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            <span class="hidden sm:block text-sm font-medium text-on-surface-variant px-2">{{ $admin->name }}</span>
            <img alt="{{ $admin->name }}" class="w-10 h-10 rounded-full object-cover" src="{{ $profileAvatar }}" />
        </div>
    </header>

    <main class="md:pl-64 pt-16 min-h-screen">
        <div class="p-4 md:p-8 max-w-6xl mx-auto">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-error-container px-4 py-3 text-sm text-on-error-container">{{ $errors->first() }}</div>
            @endif

            <header class="mb-12">
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-2">System Configuration</p>
                <h1 class="text-4xl font-bold tracking-tight">Platform Settings</h1>
            </header>

            <div class="grid grid-cols-12 gap-6 md:gap-8">
                <nav class="col-span-12 md:col-span-3">
                    <div class="grid grid-cols-2 md:grid-cols-1 gap-2">
                        @php
                            $settingTabs = [
                                'profile' => 'Admin Profile',
                                'institution' => 'Institution Settings',
                                'payments' => 'Payment Gateways',
                                'catalog' => 'Catalog & Access',
                                'notifications' => 'Email & Notifications',
                                'integrations' => 'API & Integrations',
                            ];
                        @endphp
                        @foreach ($settingTabs as $tabKey => $tabLabel)
                            <button
                                class="settings-tab w-full text-left px-4 py-3 rounded-xl font-semibold transition-colors {{ $activeTab === $tabKey ? 'bg-white text-primary editorial-shadow' : 'text-on-surface-variant hover:bg-surface-container-high' }}"
                                data-target="{{ $tabKey }}"
                                type="button"
                            >
                                {{ $tabLabel }}
                            </button>
                        @endforeach
                    </div>
                </nav>

                <div class="col-span-12 md:col-span-9 space-y-8">
                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="profile" @if($activeTab !== 'profile') hidden @endif>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">Personal Information</h2>
                        </div>

                        <form action="{{ route('admin.settings.profile') }}" class="p-4 md:p-8 space-y-8" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="flex flex-col sm:flex-row sm:items-center gap-6 md:gap-8">
                                <div class="relative">
                                    <img alt="{{ $admin->name }}" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-white shadow-md" src="{{ $profileAvatar }}" />
                                    <label class="absolute -bottom-2 -right-2 bg-primary text-white p-2 rounded-lg shadow-lg hover:scale-105 transition-transform cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">photo_camera</span>
                                        <input class="hidden" name="avatar" type="file" accept="image/*" />
                                    </label>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-on-surface">Profile Picture</h3>
                                    <p class="text-sm text-on-surface-variant mt-1">PNG, JPG or GIF. Max 5MB.</p>
                                    <div class="mt-3 flex items-center gap-3">
                                        <label class="text-xs font-bold uppercase tracking-wider text-primary cursor-pointer">Upload New<input class="hidden" name="avatar" type="file" accept="image/*" /></label>
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $admin->avatar_path ? 'R2 linked' : 'Using fallback avatar' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Full Name</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="name" type="text" value="{{ old('name', $admin->name) }}" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Email Address</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="email" type="email" value="{{ old('email', $admin->email) }}" />
                                </div>
                                <div class="space-y-2 col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Administrative Role</label>
                                    <div class="w-full bg-surface-container-low rounded-lg px-4 py-3 text-sm flex justify-between items-center opacity-70 cursor-not-allowed">
                                        <span>{{ \Illuminate\Support\Str::title($admin->role?->name ?? 'Admin') }}</span>
                                        <span class="material-symbols-outlined text-lg">lock</span>
                                    </div>
                                </div>
                                <div class="space-y-2 col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Bio</label>
                                    <textarea class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="bio" rows="4">{{ old('bio', $admin->bio) }}</textarea>
                                </div>
                                <div class="col-span-2 flex items-center justify-between rounded-xl bg-surface-container-low px-4 py-4">
                                    <div>
                                        <p class="font-semibold">Two-Factor Authentication</p>
                                        <p class="text-sm text-on-surface-variant">Require password plus email OTP for every admin sign in.</p>
                                    </div>
                                    <label class="inline-flex items-center gap-3">
                                        <input @checked(old('two_factor_enabled', $admin->two_factor_enabled)) class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary/20" name="two_factor_enabled" type="checkbox" value="1" />
                                        <span class="text-sm font-medium">{{ $admin->two_factor_enabled ? 'Enabled' : 'Disabled' }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button class="px-10 py-3 text-sm font-bold uppercase tracking-widest text-white primary-gradient rounded-xl shadow-lg hover:shadow-[#b07ac3]/20 active:scale-[0.98] transition-all" type="submit">Save Configuration</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="institution" @if($activeTab !== 'institution') hidden @endif>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">Institution Settings</h2>
                        </div>
                        <form action="{{ route('admin.settings.platform') }}" class="p-4 md:p-8 space-y-6" method="POST">
                            @csrf
                            <input name="section" type="hidden" value="institution" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Institution Name</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="institution_name" type="text" value="{{ old('institution_name', $platformSettings['institution_name']) }}" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Support Email</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="institution_email" type="email" value="{{ old('institution_email', $platformSettings['institution_email']) }}" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Phone</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="institution_phone" type="text" value="{{ old('institution_phone', $platformSettings['institution_phone']) }}" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Timezone</label>
                                    <div class="relative">
                                        <select class="admin-select w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="institution_timezone">
                                            @foreach (['Asia/Calcutta', 'UTC', 'Asia/Dubai', 'Europe/London', 'America/New_York'] as $timezone)
                                                <option value="{{ $timezone }}" @selected(old('institution_timezone', $platformSettings['institution_timezone']) === $timezone)>{{ $timezone }}</option>
                                            @endforeach
                                        </select>
                                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                                    </div>
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Address</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="institution_address" type="text" value="{{ old('institution_address', $platformSettings['institution_address']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Platform Tagline</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="institution_tagline" type="text" value="{{ old('institution_tagline', $platformSettings['institution_tagline']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Your Current Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="current_password" type="password" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-6 py-3 text-sm font-bold text-white primary-gradient rounded-xl shadow-lg" type="submit">Save Institution Settings</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="payments" @if($activeTab !== 'payments') hidden @endif>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">Payment Gateways</h2>
                        </div>
                        <form action="{{ route('admin.settings.platform') }}" class="p-4 md:p-8 space-y-6" method="POST">
                            @csrf
                            <input name="section" type="hidden" value="payments" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Default Currency</label>
                                    <div class="relative">
                                        <select class="admin-select w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="payment_currency">
                                            @foreach (['INR', 'USD', 'AED'] as $currency)
                                                <option value="{{ $currency }}" @selected(old('payment_currency', $platformSettings['payment_currency']) === $currency)>{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Tax Rate (%)</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="payment_tax_rate" step="0.01" type="number" value="{{ old('payment_tax_rate', $platformSettings['payment_tax_rate']) }}" />
                                </div>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    @foreach ([
                                        'payment_stripe_enabled' => 'Stripe',
                                        'payment_razorpay_enabled' => 'Razorpay',
                                        'payment_manual_enabled' => 'Manual Transfer',
                                    ] as $key => $label)
                                        <label class="rounded-xl bg-surface-container-low px-4 py-4 flex items-center justify-between gap-4">
                                            <div>
                                                <p class="font-semibold">{{ $label }}</p>
                                                <p class="text-xs text-on-surface-variant">Toggle gateway availability</p>
                                            </div>
                                            <input @checked(old($key, $platformSettings[$key]) === '1') class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary/20" name="{{ $key }}" type="checkbox" value="1" />
                                        </label>
                                    @endforeach
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Your Current Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="current_password" type="password" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-6 py-3 text-sm font-bold text-white primary-gradient rounded-xl shadow-lg" type="submit">Save Payment Settings</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="catalog" @if($activeTab !== 'catalog') hidden @endif>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">Catalog & Access Control</h2>
                        </div>
                        <form action="{{ route('admin.settings.platform') }}" class="p-4 md:p-8 space-y-6" method="POST">
                            @csrf
                            <input name="section" type="hidden" value="catalog" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Default Public Catalog</label>
                                    <div class="relative">
                                        <select class="admin-select w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="catalog_default_mode">
                                            <option value="offline" @selected(old('catalog_default_mode', $platformSettings['catalog_default_mode']) === 'offline')>Offline first</option>
                                            <option value="online" @selected(old('catalog_default_mode', $platformSettings['catalog_default_mode']) === 'online')>Online first</option>
                                        </select>
                                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Online Student Access Mode</label>
                                    <div class="relative">
                                        <select class="admin-select w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="online_student_access_mode">
                                            <option value="disabled" @selected(old('online_student_access_mode', $platformSettings['online_student_access_mode']) === 'disabled')>Disabled</option>
                                            <option value="limited" @selected(old('online_student_access_mode', $platformSettings['online_student_access_mode']) === 'limited')>Limited</option>
                                        </select>
                                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">expand_more</span>
                                    </div>
                                </div>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach ([
                                        'catalog_offline_enabled' => 'Show offline public catalog',
                                        'catalog_online_enabled' => 'Show online public catalog',
                                        'public_lead_gate_enabled' => 'Require lead form before course details',
                                        'workshop_lead_gate_enabled' => 'Require lead form before workshop details',
                                    ] as $key => $label)
                                        <label class="rounded-xl bg-surface-container-low px-4 py-4 flex items-center justify-between gap-4">
                                            <span class="font-semibold">{{ $label }}</span>
                                            <input @checked(old($key, $platformSettings[$key]) === '1') class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary/20" name="{{ $key }}" type="checkbox" value="1" />
                                        </label>
                                    @endforeach
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-3">Student Online Features</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach ([
                                            'student_catalog_enabled' => 'Browse online courses',
                                            'student_wishlist_enabled' => 'Wishlist access',
                                            'student_cart_enabled' => 'Cart access',
                                            'student_checkout_enabled' => 'Checkout and payments',
                                            'student_payments_enabled' => 'Payments history',
                                        ] as $key => $label)
                                            <label class="rounded-xl bg-surface-container-low px-4 py-4 flex items-center justify-between gap-4">
                                                <span class="font-semibold">{{ $label }}</span>
                                                <input @checked(old($key, $platformSettings[$key]) === '1') class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary/20" name="{{ $key }}" type="checkbox" value="1" />
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Your Current Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="current_password" type="password" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-6 py-3 text-sm font-bold text-white primary-gradient rounded-xl shadow-lg" type="submit">Save Catalog Settings</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="notifications" @if($activeTab !== 'notifications') hidden @endif>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">Email & Notifications</h2>
                        </div>
                        <form action="{{ route('admin.settings.platform') }}" class="p-4 md:p-8 space-y-6" method="POST">
                            @csrf
                            <input name="section" type="hidden" value="notifications" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">From Name</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="email_from_name" type="text" value="{{ old('email_from_name', $platformSettings['email_from_name']) }}" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">From Address</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="email_from_address" type="email" value="{{ old('email_from_address', $platformSettings['email_from_address']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Support Inbox</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="email_support_address" type="email" value="{{ old('email_support_address', $platformSettings['email_support_address']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Exception Alert Inbox</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="exception_alert_email" type="email" value="{{ old('exception_alert_email', $platformSettings['exception_alert_email']) }}" />
                                </div>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach ([
                                        'notification_new_enrollment' => 'New enrollment alerts',
                                        'notification_new_review' => 'New review alerts',
                                        'notification_support_alerts' => 'Support escalation alerts',
                                        'notification_daily_digest' => 'Daily admin digest',
                                    ] as $key => $label)
                                        <label class="rounded-xl bg-surface-container-low px-4 py-4 flex items-center justify-between gap-4">
                                            <span class="font-semibold">{{ $label }}</span>
                                            <input @checked(old($key, $platformSettings[$key]) === '1') class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary/20" name="{{ $key }}" type="checkbox" value="1" />
                                        </label>
                                    @endforeach
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Your Current Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="current_password" type="password" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-6 py-3 text-sm font-bold text-white primary-gradient rounded-xl shadow-lg" type="submit">Save Notification Settings</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="integrations" @if($activeTab !== 'integrations') hidden @endif>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">API & Integrations</h2>
                        </div>
                        <form action="{{ route('admin.settings.platform') }}" class="p-4 md:p-8 space-y-6" method="POST">
                            @csrf
                            <input name="section" type="hidden" value="integrations" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">R2 Folder</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="integration_cloudinary_folder" type="text" value="{{ old('integration_cloudinary_folder', $platformSettings['integration_cloudinary_folder']) }}" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Razorpay Key</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="integration_razorpay_key" type="text" value="{{ old('integration_razorpay_key', $platformSettings['integration_razorpay_key']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Application URL</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="integration_app_url" type="text" value="{{ old('integration_app_url', $platformSettings['integration_app_url']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Webhook Secret</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="integration_webhook_secret" type="text" value="{{ old('integration_webhook_secret', $platformSettings['integration_webhook_secret']) }}" />
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Your Current Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="current_password" type="password" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-6 py-3 text-sm font-bold text-white primary-gradient rounded-xl shadow-lg" type="submit">Save Integration Settings</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden" data-panel="password" hidden>
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5">
                            <h2 class="text-lg font-bold">Security Credentials</h2>
                        </div>
                        <form action="{{ route('admin.settings.password') }}" class="p-4 md:p-8 space-y-6" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Current Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="current_password" type="password" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">New Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="password" type="password" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Confirm Password</label>
                                    <input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all" name="password_confirmation" type="password" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-5 py-2.5 bg-surface-container-high text-on-surface rounded-lg font-semibold text-sm hover:bg-surface-container-highest transition-colors" type="submit">Change Password</button>
                            </div>
                        </form>
                    </section>

                    <section class="tab-panel grid grid-cols-1 md:grid-cols-2 gap-8" data-panel="summary" hidden>
                        <div class="bg-surface-container-lowest p-4 md:p-8 rounded-xl editorial-shadow space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-bold">Institution Details</h2>
                                <span class="material-symbols-outlined text-primary">account_balance</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-3xl">apartment</span>
                                </div>
                                <div>
                                    <p class="font-bold">CodeInYourself</p>
                                    <p class="text-xs text-on-surface-variant">Admin workspace synced with live platform data</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-4 md:p-8 rounded-xl editorial-shadow space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-bold">Security Snapshot</h2>
                                <span class="material-symbols-outlined text-primary">verified_user</span>
                            </div>
                            <div class="space-y-2 text-sm text-on-surface-variant">
                                <p>Role: <span class="font-semibold text-on-surface">{{ \Illuminate\Support\Str::title($admin->role?->name ?? 'Admin') }}</span></p>
                                <p>Two-step verification: <span class="font-semibold text-on-surface">{{ $admin->two_factor_enabled ? 'Enabled' : 'Disabled' }}</span></p>
                                <p>Account created: <span class="font-semibold text-on-surface">{{ $admin->created_at?->format('M d, Y') }}</span></p>
                            </div>
                        </div>
                    </section>

                    <section class="bg-surface-container-lowest rounded-xl editorial-shadow overflow-hidden">
                        <div class="bg-surface-container-highest px-4 md:px-8 py-5 flex items-center justify-between gap-4">
                            <h2 class="text-lg font-bold">Security Credentials</h2>
                            <button class="settings-tab text-sm font-semibold text-primary" data-target="password" type="button">Open Password Panel</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <script>
        (function () {
            var tabs = Array.from(document.querySelectorAll('.settings-tab'));
            var panels = Array.from(document.querySelectorAll('.tab-panel'));

            function activateTab(target) {
                tabs.forEach(function (tab) {
                    var active = tab.getAttribute('data-target') === target;
                    tab.classList.toggle('bg-white', active);
                    tab.classList.toggle('text-primary', active);
                    tab.classList.toggle('editorial-shadow', active);
                    tab.classList.toggle('text-on-surface-variant', !active);
                    tab.classList.toggle('hover:bg-surface-container-high', !active);
                });

                panels.forEach(function (panel) {
                    panel.hidden = panel.getAttribute('data-panel') !== target;
                });
            }

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    activateTab(tab.getAttribute('data-target'));
                });
            });
        })();
    </script>
</body>
</html>






