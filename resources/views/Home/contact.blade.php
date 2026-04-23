@php
    $officeAddress = '2nd floor, Choksi Building, Police Station, Udhana - Magdalla Road, above Kia showrooms, opp. Khatodara, Laxmi Nagar, Udhana, Surat, Gujarat 395002, India';
    $officeEmail = 'Codeinyourself@gmail.com';
    $officePhone = '+91 90164 27165';
    $officeHours = [
        ['label' => 'Admissions Desk', 'value' => 'Monday to Saturday · 9:00 AM to 6:00 PM'],
        ['label' => 'Campus Visits', 'value' => 'By scheduled appointment'],
        ['label' => 'Response Window', 'value' => 'Priority replies during business hours'],
    ];
    $contactPoints = [
        [
            'icon' => 'location_on',
            'title' => 'Office Address',
            'value' => $officeAddress,
            'meta' => 'Official business location',
        ],
        [
            'icon' => 'mail',
            'title' => 'Email',
            'value' => $officeEmail,
            'meta' => 'Admissions, support, and business inquiries',
        ],
        [
            'icon' => 'call',
            'title' => 'Phone',
            'value' => $officePhone,
            'meta' => 'Call for direct assistance',
        ],
        [
            'icon' => 'schedule',
            'title' => 'Working Hours',
            'value' => 'Mon - Sat, 9 AM to 6 PM',
            'meta' => 'Platform support schedule',
        ],
    ];
    $mapEmbedUrl = 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7441.078347515685!2d72.8346707!3d21.1707299!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4f6c268f61f4c3b%3A0x30b784cc161e9dcc!2sCode%20in%20yourself%20%7C%20Best%20IT%20Institute%20for%20Data%20Science%2C%20Digital%20Marketing%2C%20Cloud%20Computing%2C...%7C%20100%25%20Job%20Guarantee*21!5e0!3m2!1sen!2sin!4v1776421835774!5m2!1sen!2sin';
    
@endphp

<x-home.marketing-layout title="Contact | CodeInYourself">
    <x-slot:head>
        <style>
            .contact-hero-shell {
                position: relative;
                overflow: hidden;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                background:
                    radial-gradient(circle at 15% 18%, rgba(255,255,255,0.16), transparent 22%),
                    radial-gradient(circle at 82% 20%, rgba(216,180,254,0.18), transparent 24%),
                    linear-gradient(135deg, #0a0315 0%, #20073c 30%, #4c1d95 68%, #7c3aed 100%);
            }

            .contact-hero-shell::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.05), transparent 24%),
                    linear-gradient(180deg, transparent 70%, rgba(10,3,21,0.24) 100%);
                pointer-events: none;
            }

            .contact-hero-shell::after {
                content: "";
                position: absolute;
                inset: 0;
                background-image:
                    radial-gradient(1px 1px at 14% 16%, rgba(255,255,255,0.72) 0%, transparent 100%),
                    radial-gradient(1px 1px at 28% 10%, rgba(255,255,255,0.45) 0%, transparent 100%),
                    radial-gradient(1.4px 1.4px at 70% 14%, rgba(255,255,255,0.56) 0%, transparent 100%),
                    radial-gradient(1px 1px at 86% 46%, rgba(255,255,255,0.32) 0%, transparent 100%),
                    radial-gradient(1.4px 1.4px at 24% 76%, rgba(221,214,254,0.62) 0%, transparent 100%);
                opacity: 0.85;
                pointer-events: none;
            }

            .contact-shell {
                overflow-x: clip;
            }

            @supports not (overflow: clip) {
                .contact-shell {
                    overflow-x: hidden;
                }
            }

            .contact-floating-card {
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(255,255,255,0.10);
                box-shadow: 0 18px 46px rgba(20, 6, 48, 0.18);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .contact-kicker {
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.24em;
                text-transform: uppercase;
            }

            .contact-map-frame {
                overflow: hidden;
                border: 1px solid rgba(220, 205, 246, 0.76);
                background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(250,246,255,0.96));
                box-shadow: 0 24px 62px rgba(76, 29, 149, 0.11);
            }
        </style>
    </x-slot:head>
    

    <main class="contact-shell pb-24 pt-5">
        <section class="contact-hero-shell reveal px-4 pb-14 pt-10 text-white sm:px-6 md:px-8 md:pb-16 md:pt-12">
            <div class="relative z-10 mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/14 bg-white/8 px-4 py-2 text-white/78 backdrop-blur-sm">
                        <span class="h-2 w-2 rounded-full bg-[#d8b4fe]"></span>
                        <span class="contact-kicker">Contact CodeInYourself</span>
                    </span>

                    <h1 class="mt-7 max-w-3xl font-headline text-[1.8rem] font-extrabold leading-[1.04] sm:text-[2.05rem] md:text-[2.45rem] lg:text-[3rem]">
                        Reach the team behind the platform
                        <span class="block text-[#ead9ff]">through a clear and dependable contact experience.</span>
                    </h1>

                    <p class="mt-5 max-w-xl text-[0.92rem] leading-7 text-white/68 md:text-[0.97rem]">
                        Contact us for admissions, mentor guidance, training program selection, business training, or platform support. This page brings together office details, timing, map access, and a smooth inquiry flow in one place.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="mailto:{{ $officeEmail }}" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-primary">
                            {{ $officeEmail }}
                        </a>
                        <a href="#contact-form" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-white/14 bg-white/10 px-6 py-4 text-sm font-bold text-white backdrop-blur-sm">
                            Send Inquiry
                        </a>
                    </div>
                </div>

                <div class="grid gap-4">
                    @foreach ($contactPoints as $point)
                        <article class="contact-floating-card rounded-[1.7rem] p-5">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/12 text-white">
                                    <span class="material-symbols-outlined">{{ $point['icon'] }}</span>
                                </span>
                                <div class="min-w-0">
                                    <p class="contact-kicker text-white/50">{{ $point['title'] }}</p>
                                    <h2 class="mt-3 max-w-[26rem] break-words font-headline text-[1rem] font-semibold leading-[1.5] text-white">{{ $point['value'] }}</h2>
                                    <p class="mt-2 text-[0.88rem] leading-6 text-white/68">{{ $point['meta'] }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto mt-4 max-w-7xl px-4 sm:px-6">
            <div class="section-panel reveal rounded-[2rem] px-6 py-6 md:px-8">
                <div class="relative z-10 grid gap-4 md:grid-cols-3">
                    @foreach ($officeHours as $hour)
                        <div class="rounded-[1.45rem] border border-[#914fd1e0]  p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/72">{{ $hour['label'] }}</p>
                            <p class="mt-3 text-sm font-semibold leading-7 text-on-surface">{{ $hour['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[1.02fr_0.98fr]">
                <article class="glass-card premium-card reveal rounded-[2rem] p-6 md:p-8" id="contact-form">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Send A Message</p>
                    <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Tell us what you need and the right team can respond quickly.</h2>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">Use the form for admissions, guidance, business training, or help choosing the right training program path. It stays integrated with the platform workflow you already have.</p>

                    <div class="mt-6 rounded-[1.8rem] border border-outline/70 bg-white/72 p-5">
                        @if (session('status'))
                            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('home.contact.submit') }}" class="space-y-5" method="POST">
                            @csrf
                            <input name="topic" type="hidden" value="{{ old('topic', $initialTopic ?? '') }}" />
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Full Name</label>
                                    <input class="w-full rounded-2xl border border-outline bg-white px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-primary/20" name="name" placeholder="John Doe" type="text" value="{{ old('name') }}" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Email Address</label>
                                    <input class="w-full rounded-2xl border border-outline bg-white px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-primary/20" name="email" placeholder="john@example.com" type="email" value="{{ old('email') }}" />
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Phone Number</label>
                                    <input class="w-full rounded-2xl border border-outline bg-white px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-primary/20" name="phone" placeholder="+91 98765 43210" type="tel" value="{{ old('phone') }}" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Interested Training Program</label>
                                    <select class="w-full rounded-2xl border border-outline bg-white px-4 py-3 text-sm font-medium text-on-surface focus:border-primary focus:ring-primary/20" name="course_id">
                                        <option value="">Select a training program</option>
                                        @foreach ($courseOptions as $course)
                                            <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Subject</label>
                                <input class="w-full rounded-2xl border border-outline bg-white px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-primary/20" name="subject" placeholder="What do you want help with?" type="text" value="{{ old('subject', $initialSubject ?? '') }}" />
                            </div>

                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.22em] text-on-surface-variant">Your Message</label>
                                <textarea class="w-full rounded-[1.4rem] border border-outline bg-white px-4 py-3 text-sm leading-7 text-on-surface placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-primary/20" name="message" placeholder="Tell us what you need help with..." rows="6">{{ old('message') }}</textarea>
                            </div>

                            <button class="cta-button inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#6f3381_0%,#ad83ff_100%)] px-6 py-4 text-sm font-bold uppercase tracking-[0.18em] text-white" type="submit">
                                Send Message
                                <span class="material-symbols-outlined text-[18px]">send</span>
                            </button>
                        </form>
                    </div>
                </article>

                <div class="grid gap-6">
                    <article class="contact-map-frame reveal rounded-[2rem] p-3">
                        <div class="overflow-hidden rounded-[1.65rem]">
                            <iframe
                                title="CodeInYourself office location map"
                                src="{{ $mapEmbedUrl }}"
                                class="h-[25rem] w-full border-0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </article>

                    <article class="section-panel reveal rounded-[2rem] p-6 md:p-8">
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Visit The Office</p>
                            <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface">Direct company location and support details in one place.</h2>
                            <div class="mt-5 space-y-4 text-sm leading-8 text-on-surface-variant">
                                <p><span class="font-semibold text-on-surface">Address:</span> {{ $officeAddress }}</p>
                                <p><span class="font-semibold text-on-surface">Email:</span> {{ $officeEmail }}</p>
                                <p><span class="font-semibold text-on-surface">Phone:</span> {{ $officePhone }}</p>
                                <p><span class="font-semibold text-on-surface">Office timing:</span> Monday to Saturday, 9:00 AM to 6:00 PM</p>
                                <p><span class="font-semibold text-on-surface">Map access:</span> Use the embedded map above for direct navigation to the office location.</p>
                            </div>

                            <div class="mt-6 flex flex-wrap gap-4">
                                <a href="mailto:{{ $officeEmail }}" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-bold text-white">
                                    Email Now
                                </a>
                                <a href="tel:{{ preg_replace('/\s+/', '', $officePhone) }}" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-outline bg-white px-5 py-3 text-sm font-bold text-on-surface">
                                    Call Now
                                </a>
                                <a href="https://maps.app.goo.gl/i34T1uhTnJGk4zg56" target="_blank" rel="noopener noreferrer" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-outline bg-white px-5 py-3 text-sm font-bold text-on-surface">
                                    Open In Maps
                                    <span class="material-symbols-outlined text-[18px]">north_east</span>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>
</x-home.marketing-layout>
