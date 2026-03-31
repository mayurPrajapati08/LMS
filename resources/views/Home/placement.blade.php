<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Placement | Code In Yourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#002D62",
                        "on-primary": "#FFFFFF",
                        "primary-container": "#D6E3FF",
                        "on-primary-container": "#001B3E",
                        secondary: "#565E71",
                        "on-secondary": "#FFFFFF",
                        "secondary-container": "#DAE2F9",
                        "on-secondary-container": "#131C2C",
                        tertiary: "#006B24",
                        "on-tertiary": "#FFFFFF",
                        "tertiary-container": "#9EF7A0",
                        "on-tertiary-container": "#002106",
                        surface: "#F8FAFF",
                        background: "#FDFBFF",
                        "surface-variant": "#E1E2EC",
                        "surface-container-low": "#f1f4f9",
                        "surface-container-high": "#e5e8ee",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#1A1C1E",
                        "on-surface-variant": "#44474F",
                        outline: "#74777F",
                        error: "#BA1A1A",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body">
    <x-home.navbar />

    <main class="pt-24 pb-20">
        <section class="relative px-6 py-20 lg:py-28 max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-tertiary/10 text-tertiary text-xs font-bold tracking-wider uppercase">
                        Outcome Driven
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-headline font-extrabold tracking-tight text-on-surface leading-[1.1]">
                        Learning outcomes backed by <span class="text-primary">real student progress</span>
                    </h1>
                    <p class="text-lg text-on-surface-variant max-w-xl leading-relaxed">
                        This page now reflects live platform numbers instead of static promises, so visitors can see how many learners, certificates, reviews, and mentors are actually active in the system.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a class="px-8 py-4 bg-tertiary text-white font-bold rounded-xl flex items-center gap-2 hover:brightness-110 transition-all" href="{{ route('home.courses') }}">
                            Browse Courses <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a class="px-8 py-4 bg-white border border-slate-200 text-primary font-bold rounded-xl" href="{{ route('home.contact') }}">
                            Talk to Admissions
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div class="rounded-3xl bg-surface-container-lowest p-8 shadow-sm border border-slate-200/70">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-on-surface-variant">Learners</p>
                        <p class="mt-4 text-4xl font-headline font-extrabold text-primary">{{ number_format($siteStats['students']) }}+</p>
                    </div>
                    <div class="rounded-3xl bg-surface-container-lowest p-8 shadow-sm border border-slate-200/70">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-on-surface-variant">Certificates</p>
                        <p class="mt-4 text-4xl font-headline font-extrabold text-primary">{{ number_format($siteStats['certificates']) }}+</p>
                    </div>
                    <div class="rounded-3xl bg-surface-container-lowest p-8 shadow-sm border border-slate-200/70">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-on-surface-variant">Mentors</p>
                        <p class="mt-4 text-4xl font-headline font-extrabold text-primary">{{ number_format($siteStats['mentors']) }}+</p>
                    </div>
                    <div class="rounded-3xl bg-surface-container-lowest p-8 shadow-sm border border-slate-200/70">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-on-surface-variant">Avg Rating</p>
                        <p class="mt-4 text-4xl font-headline font-extrabold text-primary">{{ number_format($siteStats['avg_rating'], 1) }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-surface-container-low py-24">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-headline font-extrabold mb-4">Success Stories from Real Reviews</h2>
                    <p class="text-on-surface-variant">Recent learner feedback pulled from the live review data already in your database.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($successStories as $story)
                        <article class="bg-surface-container-lowest p-6 rounded-2xl border border-slate-200/70 hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-200">
                                    <img alt="{{ $story['name'] }}" class="w-full h-full object-cover" src="{{ $story['avatar'] }}" />
                                </div>
                                <div>
                                    <h3 class="font-bold font-headline">{{ $story['name'] }}</h3>
                                    <p class="text-xs text-on-surface-variant">{{ $story['course'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-4 py-3 bg-surface-container-low rounded-xl mb-4">
                                <span class="text-xs font-medium text-on-surface-variant">Rating</span>
                                <span class="font-bold text-primary">{{ $story['rating'] }}/5</span>
                            </div>
                            <p class="text-sm italic leading-relaxed text-on-surface-variant">"{{ $story['comment'] }}"</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <x-home.footer />
</body>
</html>
