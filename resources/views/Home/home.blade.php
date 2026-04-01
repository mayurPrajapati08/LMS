<!DOCTYPE html>

<html class="scroll-smooth" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself - Engineering Professional Careers</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        // Scholar Navy Design System Tokens
                        "primary": "#08275c", // Scholar Navy
                        "on-primary": "#FFFFFF",
                        "primary-container": "#dcecff",
                        "on-primary-container": "#071c4a",
                        "secondary": "#565E71",
                        "on-secondary": "#FFFFFF",
                        "secondary-container": "#DAE2F9",
                        "on-secondary-container": "#131C2C",
                        "tertiary": "#006B24", // Success Green
                        "on-tertiary": "#FFFFFF",
                        "tertiary-container": "#9EF7A0",
                        "on-tertiary-container": "#002106",
                        "surface": "#f4f9ff",
                        "on-surface": "#1A1C1E",
                        "surface-variant": "#E1E2EC",
                        "on-surface-variant": "#4f6178",
                        "outline": "#7c8da7",
                        "background": "#f7fbff",
                        "error": "#BA1A1A"
                    },
                    fontFamily: {
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .hero-pattern {
            background-color: #f8faff;
            background-image: radial-gradient(#002d62 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            background-position: 0 0;
            opacity: 0.1;
        }

        .course-hero-overlay {
            background: linear-gradient(180deg, rgba(6, 18, 37, 0.05) 0%, rgba(6, 18, 37, 0.68) 100%);
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body selection:bg-primary/20">

    <!-- Navbar -->
    <x-home.navbar />
    
    <main class="pt-16">
        <!-- Hero Section -->
        <section class="relative overflow-hidden px-6 pt-20 pb-24 md:pt-32 md:pb-40">
            <div class="absolute inset-0 hero-pattern pointer-events-none"></div>
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary font-bold text-xs mb-8 uppercase tracking-widest border border-primary/20">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Admissions Open for 2024
                    </div>
                    <h1 class="text-5xl md:text-7xl font-extrabold font-headline leading-[1.05] text-on-surface mb-8 tracking-tight">
                        Transform Your IT Career with <span class="text-primary underline decoration-primary/20 underline-offset-8">100% Job Guarantee</span>
                    </h1>
                    <p class="text-lg md:text-xl text-on-surface-variant mb-12 max-w-xl leading-relaxed">
                        Learn Data Science, Full Stack Development, and DSA with AI-Powered Mentorship from industry veterans who've been there.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-14">
                        <a class="bg-primary text-on-primary px-8 py-5 rounded-xl font-bold text-lg shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all inline-flex items-center justify-center" href="{{ route('home.courses') }}">
                            Explore Courses
                        </a>
                        <a class="bg-white border-2 border-primary text-primary px-8 py-5 rounded-xl font-bold text-lg hover:bg-primary/5 transition-all inline-flex items-center justify-center" href="{{ route('home.contact') }}">
                            Talk to Advisor
                        </a>
                    </div>
                    <div class="flex flex-wrap items-center gap-8 py-6 border-t border-surface-variant">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-tertiary">verified</span>
                            <span class="font-bold text-sm text-on-surface">{{ number_format($siteStats['students']) }}+ Learners</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="font-bold text-sm text-on-surface">{{ number_format($siteStats['avg_rating'], 1) }} Student Rating</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">payments</span>
                            <span class="font-bold text-sm text-on-surface">{{ number_format($siteStats['published_courses']) }} Live Courses</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-[100px]"></div>
                    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-tertiary/10 rounded-full blur-[100px]"></div>
                    <div class="relative rounded-3xl overflow-hidden shadow-[0_32px_64px_-12px_rgba(0,45,98,0.25)] ring-1 ring-primary/10">
                        <img alt="Student Success" class="w-full aspect-[4/5] object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtbucZNDf-Cx5CuGIXaM9wVH4XZd1TLueQnOdT34Aa0cyZALzi8HtwCuRBBGgIIKvYmf89t6bVOIT-soVkIaPFrzutwM4Vnu1MyxnE9k8HxNadDT0kOmoGVIPOJC47-801uUk9mZmooMa961xzR7voCPcey8QW9jlCUajLfvi2NognCupDRDbHCg7Ys5Br63qzlAVGRUKUdtlPaeh3gsm-PiFeJUuRSMSsxOSs8F9cMQRi6AiZfA7nhT79Nt_nDU7g6UrUhXx4CG97" />
                        <div class="absolute bottom-8 left-8 right-8">
                            <div class="glass-panel p-5 rounded-2xl border border-white/40 shadow-xl flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white">code_blocks</span>
                                </div>
                                <div>
                                    <p class="text-primary font-bold text-sm">Live AI Coding Assistant</p>
                                    <p class="text-on-surface-variant text-xs font-medium">Available 24/7 for doubt solving</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Stats Banner -->
        <section class="bg-primary text-on-primary py-16 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                    <div class="space-y-2">
                        <h3 class="text-5xl font-extrabold font-headline">{{ number_format($siteStats['students']) }}+</h3>
                        <p class="text-primary-container text-xs font-bold uppercase tracking-[0.2em]">Active Learners</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-5xl font-extrabold font-headline">{{ number_format($siteStats['mentors']) }}+</h3>
                        <p class="text-primary-container text-xs font-bold uppercase tracking-[0.2em]">Industry Mentors</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-5xl font-extrabold font-headline">{{ number_format($siteStats['avg_rating'], 1) }}</h3>
                        <p class="text-primary-container text-xs font-bold uppercase tracking-[0.2em]">Average Rating</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Featured Courses Section -->
        <section class="py-24 px-6 bg-surface">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                    <div>
                        <h2 class="text-4xl font-extrabold font-headline mb-4 text-on-surface">Industry-Ready Courses</h2>
                        <p class="text-on-surface-variant max-w-lg text-lg">Our curriculums are designed by industry experts to ensure you meet the high standards of top tech firms.</p>
                    </div>
                    <a class="flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all group" href="{{ route('home.courses') }}">
                        View All Courses <span class="material-symbols-outlined transition-transform">arrow_forward</span>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach ($featuredCourses as $course)
                        <article class="bg-white rounded-[1.75rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all border border-surface-variant flex flex-col h-full group">
                            <div class="h-72 relative overflow-hidden bg-slate-950">
                                <img alt="{{ $course['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90" src="{{ $course['thumbnail'] }}" />
                                <div class="absolute inset-0 course-hero-overlay"></div>
                                <div class="absolute top-5 left-5 {{ $course['badge_class'] }} px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-[0.24em] shadow-lg">
                                    {{ $course['badge_label'] }}
                                </div>
                            </div>
                            <div class="p-8 flex flex-col flex-grow">
                                <div class="flex gap-3 mb-7 text-primary">
                                    <span class="material-symbols-outlined text-[22px]">{{ $course['icon_one'] }}</span>
                                    <span class="material-symbols-outlined text-[22px]">{{ $course['icon_two'] }}</span>
                                    <span class="material-symbols-outlined text-[22px]">{{ $course['icon_three'] }}</span>
                                </div>
                                <h3 class="text-2xl font-extrabold mb-3 font-headline text-on-surface">{{ $course['title'] }}</h3>
                                <p class="text-[1.02rem] text-on-surface-variant mb-8 line-clamp-3 leading-relaxed">{{ $course['details'] }}</p>
                                <div class="mt-auto pt-6 border-t border-surface-variant flex items-center justify-between">
                                    <div>
                                        <span class="text-[2rem] font-extrabold text-primary">₹{{ number_format($course['price'], 0) }}</span>
                                        <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-widest mt-1">Total Fee</p>
                                    </div>
                                    <a class="bg-primary/5 text-primary px-6 py-3 rounded-[1rem] font-bold text-sm hover:bg-primary hover:text-white transition-all" href="{{ $course['details_url'] }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="hidden grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Course Card 1 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all border border-surface-variant flex flex-col h-full group">
                        <div class="h-56 relative overflow-hidden">
                            <img alt="Data Science Mastery" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpMiwZ70JKD_Guawi87MGH4VNUbXpFqdlvXtmEkAhKcolvR9Dcox1tQraA8W_DJF_O6oqv2IO9d7kymFroYy27e6lxCXnjWRTA_n7kTeEsK_qe5JhIMfSqfaTeAOcmPZ0z0jVcAk48B-l_y1iTFPRnPNqyzGsb_rblJn2icyOiOlM-fTwU7thkN8kcFc2RyY936TCjGhvz4pfX12Z8D9uI4RNRQuND3fh51mj1sR5Mcn0UhTSo4zkpSax7GL3xCD83NxBSHxBY4OgM" />
                            <div class="absolute top-4 left-4 bg-tertiary text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                Job Guaranteed
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex gap-3 mb-6">
                                <span class="material-symbols-outlined text-primary text-xl">database</span>
                                <span class="material-symbols-outlined text-primary text-xl">terminal</span>
                                <span class="material-symbols-outlined text-primary text-xl">monitoring</span>
                            </div>
                            <h3 class="text-2xl font-extrabold mb-3 font-headline text-on-surface">Data Science Mastery</h3>
                            <p class="text-sm text-on-surface-variant mb-8 line-clamp-3 leading-relaxed">Master Python, SQL, Machine Learning, and Big Data with 10+ real-world industry capstone projects.</p>
                            <div class="mt-auto pt-6 border-t border-surface-variant flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-extrabold text-primary">₹49,999</span>
                                    <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-widest mt-1">Total Fee</p>
                                </div>
                                <button class="bg-primary/5 text-primary px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-primary hover:text-white transition-all">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Course Card 2 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all border border-surface-variant flex flex-col h-full group">
                        <div class="h-56 relative overflow-hidden">
                            <img alt="Full Stack Development" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB3YxRFKgnnHTHDEHMOte1AI6EejWtQqX8wF8KvbCOQ8VctLcp688_bDhe7nZZMIIFIBnrX2N8jJgG4N-KbrlYsgxGIPYckgN_vlgaDUaWF_c0xkPzqR6SsruihtnddUniLBeJ0JRRemnCT3fmSQmc28Gnz9SYRphHaPOKIdjjErOVmjm4tuZ--kewbbG_nBia8G5xIHvASvy3vUUlhUonfF4gliluTTAHRY1zX42e7qgHn3lacPNW51siHdpEaTXLd67d9LlKlpCFG" />
                            <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                Best Seller
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex gap-3 mb-6">
                                <span class="material-symbols-outlined text-primary text-xl">javascript</span>
                                <span class="material-symbols-outlined text-primary text-xl">storage</span>
                                <span class="material-symbols-outlined text-primary text-xl">cloud</span>
                            </div>
                            <h3 class="text-2xl font-extrabold mb-3 font-headline text-on-surface">Full Stack Mastery</h3>
                            <p class="text-sm text-on-surface-variant mb-8 line-clamp-3 leading-relaxed">Complete MERN stack training including Next.js, Docker, Kubernetes, and AWS Cloud architecture.</p>
                            <div class="mt-auto pt-6 border-t border-surface-variant flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-extrabold text-primary">₹44,999</span>
                                    <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-widest mt-1">Total Fee</p>
                                </div>
                                <button class="bg-primary/5 text-primary px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-primary hover:text-white transition-all">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Course Card 3 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all border border-surface-variant flex flex-col h-full group">
                        <div class="h-56 relative overflow-hidden">
                            <img alt="DSA Mastery" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtT3mTjmaykDWaPmyJUKKBwk_GdRkTZk0dZhoaRJhgD2N5V9HcYGLK6egsRfY2DSVIjz_RCnDZamM7YJPjH6Avga7pqV3YdcE_qclg02-Xh6XBsGWrxRv4rgPZYxsYIFb3MZHb8dg7KkFKGCWKrhhXY7_tL0o4OKLJTMw3uv-4es253Tjs51fDSP6Le45N92o7EnnaMGnAJBdbx6L-6H8rLE2f6lL89BMJkGoUqRWy8ztNM__GNcUDY9YmBpWAID5OO7UK3V8gRAds" />
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex gap-3 mb-6">
                                <span class="material-symbols-outlined text-primary text-xl">account_tree</span>
                                <span class="material-symbols-outlined text-primary text-xl">psychology</span>
                                <span class="material-symbols-outlined text-primary text-xl">speed</span>
                            </div>
                            <h3 class="text-2xl font-extrabold mb-3 font-headline text-on-surface">DSA Interview Prep</h3>
                            <p class="text-sm text-on-surface-variant mb-8 line-clamp-3 leading-relaxed">Intensive logic and problem-solving course designed specifically for MAANG technical interviews.</p>
                            <div class="mt-auto pt-6 border-t border-surface-variant flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-extrabold text-primary">₹24,999</span>
                                    <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-widest mt-1">Total Fee</p>
                                </div>
                                <button class="bg-primary/5 text-primary px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-primary hover:text-white transition-all">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Us -->
        <section class="py-24 px-6 bg-background">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold font-headline mb-4 text-on-surface">Why CodeInYourself?</h2>
                    <p class="text-on-surface-variant max-w-2xl mx-auto text-lg">We offer a unique ecosystem that combines technical depth with career support.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="p-8 rounded-2xl bg-white border border-surface-variant hover:border-primary transition-colors group">
                        <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">smart_toy</span>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-on-surface">AI-Powered</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed">Get instant debugging help and concept explanations from our custom-trained AI tutor.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-white border border-surface-variant hover:border-primary transition-colors group">
                        <div class="w-14 h-14 rounded-xl bg-tertiary/10 flex items-center justify-center text-tertiary mb-6 group-hover:bg-tertiary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">security</span>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-on-surface">Job Guarantee</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed">We back our training with a 100% money-back guarantee if you're not placed within 6 months.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-white border border-surface-variant hover:border-primary transition-colors group">
                        <div class="w-14 h-14 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container mb-6 group-hover:bg-secondary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">groups</span>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-on-surface">Live Mentorship</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed">Direct interaction with engineers from top-tier companies like Amazon and Google.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-white border border-surface-variant hover:border-primary transition-colors group">
                        <div class="w-14 h-14 rounded-xl bg-primary-container flex items-center justify-center text-on-primary-container mb-6 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">workspace_premium</span>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-on-surface">Global Certificates</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed">Our certification is recognized by over 500+ hiring partners globally for technical roles.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Job Guarantee Process -->
        <section class="py-24 px-6 bg-surface-variant/30 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="order-2 lg:order-1">
                        <span class="text-primary font-bold tracking-widest text-xs uppercase mb-4 block">Our Signature Promise</span>
                        <h2 class="text-4xl md:text-5xl font-extrabold font-headline mb-8 leading-tight text-on-surface">Your Career is Our Responsibility</h2>
                        <p class="text-on-surface-variant mb-12 text-lg leading-relaxed italic border-l-4 border-primary pl-6">
                            "We bridge the gap between academic learning and industry demands through a rigorous three-step placement pipeline."
                        </p>
                        <div class="space-y-10">
                            <div class="flex gap-6 items-start">
                                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0 shadow-lg shadow-primary/20">1</div>
                                <div>
                                    <h5 class="font-bold text-xl mb-2">Learn with AI</h5>
                                    <p class="text-on-surface-variant leading-relaxed">Adaptive learning paths that adjust to your pace with instant AI feedback on every line of code.</p>
                                </div>
                            </div>
                            <div class="flex gap-6 items-start">
                                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0 shadow-lg shadow-primary/20">2</div>
                                <div>
                                    <h5 class="font-bold text-xl mb-2">Build Real Projects</h5>
                                    <p class="text-on-surface-variant leading-relaxed">Construct enterprise-level applications used by real businesses to build a high-impact portfolio.</p>
                                </div>
                            </div>
                            <div class="flex gap-6 items-start">
                                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0 shadow-lg shadow-primary/20">3</div>
                                <div>
                                    <h5 class="font-bold text-xl mb-2">Secure Your Dream Job</h5>
                                    <p class="text-on-surface-variant leading-relaxed">Gain exclusive access to our 500+ hiring partners and personalized mock interview sessions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative order-1 lg:order-2">
                        <div class="bg-primary-container/30 rounded-3xl p-12 aspect-square flex items-center justify-center relative">
                            <div class="absolute inset-6 border-2 border-dashed border-primary/20 rounded-2xl"></div>
                            <div class="text-center z-10">
                                <span class="material-symbols-outlined text-[120px] text-primary opacity-20 mb-6 block">rocket_launch</span>
                                <p class="text-4xl font-extrabold font-headline text-primary">Career Lift</p>
                                <p class="text-on-surface-variant font-bold mt-3 text-lg">Guaranteed Success Path</p>
                            </div>
                            <!-- Floating Testimonial Card -->
                            <div class="absolute -bottom-8 -right-8 glass-panel p-8 rounded-2xl shadow-2xl border border-white/50 max-w-[320px] hidden md:block">
                                <div class="flex items-center gap-4 mb-5">
                                    <div class="w-12 h-12 rounded-full bg-tertiary-container flex items-center justify-center text-tertiary">
                                        <span class="material-symbols-outlined">work</span>
                                    </div>
                                    <p class="font-extrabold text-on-surface">Offer Received!</p>
                                </div>
                                <p class="text-sm text-on-surface-variant italic leading-relaxed">"Just signed my offer letter from Amazon. The mock interviews were the ultimate game changer!"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Success Stories -->
        <section class="py-24 px-6 bg-background">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-center text-4xl font-extrabold font-headline mb-16 text-on-surface">Alumni Success Stories</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-10 rounded-2xl shadow-sm border border-surface-variant">
                        <div class="flex items-center gap-5 mb-8">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-primary/10">
                                <img alt="Priya Sharma" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCGV4P9_MYzhFZ7fa4XYlA_YPGdQRzmPuZlLHivgA9AlncJJ7lk9sC1_o_Xch_7j-ss8bW6GH4K8tjj-0DCONXxSy6zlcWfmIUsHXcZZzspv3kr61suhVSOAqPmndVTmiuyX5VWRsLu4hMLV53Whp-70FdFWEWPHSeD51cJ7pCSd8Fp_wHD9SjdMZ_nZPvwq2c6wM9TiO6succwVMFMldjuvg3DpK_62sln-wG9bumMSyP6GdrvNBxrk6DvBS3JL-cl2Us3CF05RyNl" />
                            </div>
                            <div>
                                <h5 class="font-bold text-lg text-on-surface">Priya Sharma</h5>
                                <p class="text-xs text-primary font-bold uppercase tracking-wider mt-1">Accenture → 6 LPA</p>
                            </div>
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">"The transition from a non-tech background was seamless. The Job Guarantee program gave me the confidence to switch careers without fear."</p>
                    </div>
                    <div class="bg-white p-10 rounded-2xl shadow-sm border border-surface-variant">
                        <div class="flex items-center gap-5 mb-8">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-primary/10">
                                <img alt="Rahul Verma" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuARqAHjDAf91ADR3zauAZ39p9gOH8Lp82wEzfBYaM69PPD5bR16zVMmJPrtEONdTJUr048s8zgtpHz33o0UXDBKDhPHG9gaJqrYCuMFaoLc3kzYlww1gNKCO4YcVbkZyKVvNtQ4HfV3tv6HLcn1kQFn4e4-4tyci4guqec4U_mW2CUlG8czMF1_HQVOsa0EAVhD1RuV4SWUzDIgRWNXCrOSMl-iqTBFbSzChnxZghBy_H_9Xv2MPH-f9FPvtZ4hb01nAfrB8DJ-Ql8Z" />
                            </div>
                            <div>
                                <h5 class="font-bold text-lg text-on-surface">Rahul Verma</h5>
                                <p class="text-xs text-primary font-bold uppercase tracking-wider mt-1">TCS → 8.5 LPA</p>
                            </div>
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">"DSA Mastery course was intensive but exactly what I needed. The AI coding helper saved me hours of frustration during midnight coding sessions."</p>
                    </div>
                    <div class="bg-white p-10 rounded-2xl shadow-sm border border-surface-variant">
                        <div class="flex items-center gap-5 mb-8">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-primary/10">
                                <img alt="Anjali Nair" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRH7LauROfYm__dF3RdNOEO2mRkweKsHiP-ddgjAW-dVsVNma5ERJsgPwIncYJkRRsHgAgXgyNdP6dhuw1CSVNT3wLulwbMV7jvhpVB-PRjnie0kKeJKuB6vHpjDg3Xt4xfD-i_rDBQ10HQVfvSS24KOWJsdVHgeutV1mf5nmyXHjyCgTs2n9nR0X24qisOdG-flObtX6XtUE_2_1IdhZqBSKaf1NizuTPysOevo-ARzX49YGMvojqJ6tSxx_xqAueL7suOVTylDuH" />
                            </div>
                            <div>
                                <h5 class="font-bold text-lg text-on-surface">Anjali Nair</h5>
                                <p class="text-xs text-primary font-bold uppercase tracking-wider mt-1">Amazon → 15 LPA</p>
                            </div>
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">"From a service company to a product giant. CodeInYourself's ecosystem for Full Stack Development is truly unparalleled in India."</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- AI Demo Widget -->
        <section class="py-24 px-6 bg-surface overflow-hidden">
            <div class="max-w-5xl mx-auto">
                <div class="bg-primary rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
                    <div class="p-12 md:w-1/2 flex flex-col justify-center">
                        <h2 class="text-4xl font-extrabold font-headline text-white mb-6">Meet Your 24/7 AI Mentor</h2>
                        <p class="text-primary-container mb-10 text-lg leading-relaxed">Stuck on a bug at 2 AM? Our custom-trained AI understands your code context and helps you debug in real-time without just giving the answer.</p>
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                <div class="w-10 h-10 rounded-full bg-surface-variant border-2 border-primary"></div>
                                <div class="w-10 h-10 rounded-full bg-tertiary-container border-2 border-primary"></div>
                                <div class="w-10 h-10 rounded-full bg-white border-2 border-primary"></div>
                            </div>
                            <p class="text-xs font-bold text-primary-container uppercase tracking-widest">500+ Active Students Now</p>
                        </div>
                    </div>
                    <div class="md:w-1/2 p-4 bg-[#0A0E14]">
                        <div class="bg-[#151D29] rounded-2xl overflow-hidden shadow-inner h-96 flex flex-col border border-white/10">
                            <div class="p-4 border-b border-white/5 flex items-center justify-between bg-black/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                                    <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
                                    <span class="w-3 h-3 rounded-full bg-green-500/80"></span>
                                </div>
                                <span class="text-[10px] font-mono text-slate-500">CIY-AI-DEBUGGER.js</span>
                            </div>
                            <div class="p-8 font-mono text-xs space-y-6 overflow-y-auto">
                                <div class="flex gap-4">
                                    <span class="text-blue-400 font-bold">Student:</span>
                                    <span class="text-slate-300 italic">How do I fix this null pointer in my React hook?</span>
                                </div>
                                <div class="flex gap-4">
                                    <span class="text-tertiary font-bold">AI Mentor:</span>
                                    <div class="text-slate-300 leading-relaxed">
                                        Check your <span class="text-yellow-400">useEffect</span> dependencies. It looks like <span class="text-blue-300">userData</span> is accessed before the fetch completes. Try a guard clause:
                                        <pre class="mt-3 bg-black/40 p-4 rounded-lg text-pink-400 border border-white/5">if (!userData) return null;</pre>
                                    </div>
                                </div>
                                <div class="animate-pulse flex gap-2 items-center">
                                    <div class="w-2 h-2 bg-slate-600 rounded-full"></div>
                                    <span class="text-[10px] text-slate-600 italic">AI is typing...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Partner Logos -->
        <section class="py-20 px-6 border-t border-surface-variant">
            <div class="max-w-7xl mx-auto">
                <p class="text-center text-on-surface-variant font-bold text-xs uppercase tracking-[0.3em] mb-14">Empowering Students at Global Tech Giants</p>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 items-center gap-12 opacity-40 grayscale hover:grayscale-0 transition-all duration-700">
                    <div class="text-2xl font-black text-primary font-headline text-center">Accenture</div>
                    <div class="text-2xl font-black text-primary font-headline text-center">Infosys</div>
                    <div class="text-2xl font-black text-primary font-headline text-center">TCS</div>
                    <div class="text-2xl font-black text-primary font-headline text-center">Wipro</div>
                    <div class="text-2xl font-black text-primary font-headline text-center">Amazon</div>
                    <div class="text-2xl font-black text-primary font-headline text-center">Microsoft</div>
                </div>
            </div>
        </section>
        <!-- Final CTA -->
        <section class="py-24 px-6 bg-primary relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20 relative z-10 items-center">
                <div>
                    <h2 class="text-5xl md:text-6xl font-extrabold font-headline text-white mb-8 leading-tight">Start Your Career Journey Today</h2>
                    <p class="text-primary-container text-xl mb-12 max-w-lg leading-relaxed">Don't just wait for opportunities—engineer them. Join 10,000+ professionals who transformed their lives with CodeInYourself.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-white font-bold text-sm">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-tertiary-container">check_circle</span>
                            Free Career Guidance
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-tertiary-container">check_circle</span>
                            No Cost EMI
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-tertiary-container">check_circle</span>
                            Live Industry Projects
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-tertiary-container">check_circle</span>
                            100% Placement Support
                        </div>
                    </div>
                </div>
                <div class="bg-white p-10 md:p-14 rounded-3xl shadow-2xl">
                    <h4 class="text-2xl font-extrabold text-primary mb-8 font-headline">Book a Free Session</h4>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Full Name</label>
                                <input class="w-full bg-surface border-surface-variant rounded-xl focus:ring-2 focus:ring-primary p-4 text-sm" placeholder="John Doe" type="text" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Email Address</label>
                                <input class="w-full bg-surface border-surface-variant rounded-xl focus:ring-2 focus:ring-primary p-4 text-sm" placeholder="john@example.com" type="email" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Phone Number</label>
                            <input class="w-full bg-surface border-surface-variant rounded-xl focus:ring-2 focus:ring-primary p-4 text-sm" placeholder="+91 98765 43210" type="tel" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Interested Course</label>
                            <select class="w-full bg-surface border-surface-variant rounded-xl focus:ring-2 focus:ring-primary p-4 text-sm appearance-none">
                                <option>Select a course</option>
                                <option>Data Science Mastery</option>
                                <option>Full Stack Mastery</option>
                                <option>DSA Interview Prep</option>
                            </select>
                        </div>
                        <button class="w-full bg-primary text-white py-5 rounded-2xl font-extrabold text-lg hover:brightness-110 active:scale-[0.98] transition-all shadow-xl shadow-primary/30">
                            Book My Free Career Session
                        </button>
                        <p class="text-center text-[10px] text-on-surface-variant font-medium">By clicking, you agree to our Terms and Privacy Policy.</p>
                    </form>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    <x-home.footer />

</body>

</html>


