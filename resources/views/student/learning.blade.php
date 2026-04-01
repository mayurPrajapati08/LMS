<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Course Player - CodeInYourself</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#3b5f8d",
                        "surface-tint": "#1570d8",
                        "inverse-on-surface": "#f5fbff",
                        "secondary-fixed": "#e8f3ff",
                        "on-primary-fixed": "#0f0069",
                        "error-container": "#ffdad6",
                        "tertiary": "#005523",
                        "tertiary-container": "#007030",
                        "on-secondary-fixed-variant": "#315b90",
                        "tertiary-fixed": "#6bff8f",
                        "secondary-fixed-dim": "#b9dcff",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#0a4b99",
                        "error": "#ba1a1a",
                        "surface-container-low": "#eef5ff",
                        "secondary-container": "#d7e9ff",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#b9dcff",
                        "outline-variant": "#d5e4ff",
                        "on-surface": "#191c1d",
                        "surface-dim": "#d4e3f8",
                        "on-secondary-fixed": "#072a60",
                        "inverse-primary": "#b9dcff",
                        "on-surface-variant": "#4f6178",
                        "tertiary-fixed-dim": "#4ae176",
                        "on-primary-container": "#edf5ff",
                        "inverse-surface": "#18345f",
                        "outline": "#7c8da7",
                        "primary-container": "#1570d8",
                        "on-background": "#191c1d",
                        "surface-container-high": "#e3eeff",
                        "surface-container": "#e9f2ff",
                        "on-tertiary-fixed-variant": "#005321",
                        "primary-fixed": "#e8f3ff",
                        "surface-bright": "#f4f9ff",
                        "on-tertiary-fixed": "#002109",
                        "on-tertiary-container": "#63f889",
                        "surface-container-highest": "#dbe8ff",
                        "on-error-container": "#93000a",
                        "background": "#f4f9ff",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#0c4ea3",
                        "on-secondary-container": "#41648d",
                        "surface-variant": "#dbe8ff",
                        "on-secondary": "#ffffff",
                        "surface": "#f4f9ff"
                    },
                    fontFamily: {
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
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

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .glass-effect {
            backdrop-filter: blur(12px);
            background-color: rgba(248, 249, 250, 0.8);
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body antialiased">

    <!-- // Side Navigation -->
    <x-student.navbar />
    
    <!-- TopNavBar -->
    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 glass-effect z-40 flex items-center justify-between px-4 md:px-8">
        <div class="flex items-center gap-4">
            <button class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined" data-icon="arrow_back">arrow_back</span>
                <span class="text-sm font-medium font-label">Back to Course Details</span>
            </button>
        </div>
        <div class="flex-1 max-w-xl mx-12">
            <div class="flex flex-col gap-1">
                <div class="flex justify-between items-end">
                    <span class="text-[10px] font-bold text-primary uppercase tracking-tighter">Your Progress: 64%</span>
                    <span class="text-[10px] font-medium text-on-surface-variant">12/18 Lessons</span>
                </div>
                <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-primary to-primary-container w-[64%] rounded-full"></div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <button class="relative p-2 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-2 right-2 h-2 w-2 bg-error rounded-full border-2 border-white"></span>
            </button>
            <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined" data-icon="account_circle">account_circle</span>
            </button>
        </div>
    </header>
    <!-- Main Content Layout -->
    <main class="md:ml-64 pt-16 min-h-screen flex flex-col xl:flex-row">
        <!-- Center Content Area: Video Player & Tabs -->
        <div class="flex-1 flex flex-col p-4 md:p-8 overflow-y-auto">
            <!-- Video Stage -->
            <div class="relative group aspect-video bg-on-surface rounded-xl overflow-hidden shadow-2xl transition-all duration-500">
                <img alt="Video Placeholder" class="w-full h-full object-cover opacity-60" data-alt="high quality video still of a clean workspace with a macbook showing code, warm cinematic lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBMN_dndYpcSiNZfqvbH0ipRcifS3r8l_6-r9spvk88zmSPMRyj-QLkyCO7Vhdo6DCewT4KnAih56dmGQeXv8TfSaO-PtWJGtp7vutL4_CtY9uVOuPIJyxTJnJzVywx6NF2et0BVR8LFru3Q__3Kf5QcSNLZO8pEJ5CXOP7ZVb42O-MSEbs_dllV8veyBSPKD6yAbg1jZitXeoB6qL9v-ZncEJj2xTGxnNo8GL25jHUMUnBeZE2voe7Y7U30zlv4OM2LsBS7osAuC1N" />
                <!-- Overlay UI -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <button class="h-20 w-20 flex items-center justify-center bg-white/20 backdrop-blur-md rounded-full text-white scale-100 hover:scale-110 transition-transform group-hover:bg-primary/80">
                        <span class="material-symbols-outlined text-5xl" data-icon="play_arrow" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                    </button>
                </div>
                <!-- Bottom Controls (Simplified Simulation) -->
                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="flex items-center gap-4 text-white">
                        <span class="material-symbols-outlined cursor-pointer" data-icon="pause">pause</span>
                        <div class="flex-1 h-1 bg-white/30 rounded-full relative">
                            <div class="absolute inset-y-0 left-0 w-full lg:w-1/3 bg-primary rounded-full"></div>
                        </div>
                        <span class="text-xs font-mono">12:45 / 38:20</span>
                        <span class="material-symbols-outlined cursor-pointer" data-icon="volume_up">volume_up</span>
                        <span class="material-symbols-outlined cursor-pointer" data-icon="settings">settings</span>
                        <span class="material-symbols-outlined cursor-pointer" data-icon="fullscreen">fullscreen</span>
                    </div>
                </div>
            </div>
            <!-- Header Info & CTA -->
            <div class="mt-8 flex flex-col lg:flex-row items-start justify-between gap-6 md:gap-8">
                <div class="max-w-2xl">
                    <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Module 4: The Art of Visual Hierarchy</h1>
                    <p class="mt-2 text-on-surface-variant font-medium">Part of: <span class="text-primary font-semibold">The Editorial Design Masterclass</span> • Instructor: Dr. Helena Vance</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="flex items-center gap-2 px-6 py-3 bg-surface-container-high text-primary font-semibold rounded-lg hover:bg-surface-container-highest transition-all">
                        <span class="material-symbols-outlined" data-icon="skip_next">skip_next</span>
                        Auto-Next ON
                    </button>
                    <button class="px-4 md:px-8 py-3 bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold rounded-lg shadow-lg shadow-primary/20 hover:opacity-90 transition-all scale-100 active:scale-95">
                        Mark as Complete
                    </button>
                </div>
            </div>
            <!-- Content Tabs Section -->
            <div class="mt-12">
                <div class="flex gap-10 border-b border-surface-container-low mb-8">
                    <button class="pb-4 text-primary font-bold border-b-2 border-primary transition-all">Description</button>
                    <button class="pb-4 text-on-surface-variant font-semibold hover:text-primary transition-all">Resources (4)</button>
                    <button class="pb-4 text-on-surface-variant font-semibold hover:text-primary transition-all">Q&amp;A (12)</button>
                    <button class="pb-4 text-on-surface-variant font-semibold hover:text-primary transition-all">Notes</button>
                </div>
                <div class="grid grid-cols-12 gap-8">
                    <!-- Tab Content - Description Example -->
                    <div class="col-span-8 space-y-6">
                        <div class="p-6 bg-surface-container-lowest rounded-xl">
                            <h3 class="text-lg font-headline font-bold mb-4">In this lesson...</h3>
                            <p class="text-on-surface-variant leading-relaxed">In this module, we delve deep into the psychological principles of visual hierarchy. You will learn how to guide the user's eye through intentional use of typography weights, color dominance, and asymmetrical white space. We break away from the 'grid-locked' mindset and explore editorial patterns that make information feel curated and premium.</p>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle">check_circle</span>
                                    Understanding Focal Points
                                </li>
                                <li class="flex items-center gap-2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle">check_circle</span>
                                    The Rule of Proximity in Editorial UI
                                </li>
                                <li class="flex items-center gap-2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle">check_circle</span>
                                    Breaking the Grid for Impact
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Insight Toast / Sidebar Context -->
                    <div class="col-span-4">
                        <div class="p-6 bg-primary-fixed border-l-4 border-primary rounded-xl">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary" data-icon="lightbulb">lightbulb</span>
                                <div>
                                    <h4 class="font-bold text-on-primary-fixed leading-tight">Pro Tip</h4>
                                    <p class="mt-1 text-sm text-on-primary-fixed-variant">Try applying the 'Asymmetry Rule' to your next dashboard footer to instantly increase its premium feel.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Panel: Course Curriculum Accordion -->
        <aside class="w-full lg:w-96 bg-surface-container-low border-l-0 overflow-y-auto h-auto lg:h-[calc(100vh-4rem)] p-4 md:p-6 scrollbar-hide">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-headline font-bold text-on-surface">Course Content</h2>
                <span class="text-xs font-bold text-on-surface-variant bg-surface-container-high px-2 py-1 rounded">18 Lessons</span>
            </div>
            <!-- Curriculum Section 1 -->
            <div class="mb-6">
                <div class="flex items-center justify-between p-3 bg-surface-container-high rounded-lg mb-2 cursor-pointer">
                    <span class="text-sm font-bold">1. Foundations of UI</span>
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="expand_more">expand_more</span>
                </div>
                <!-- Lessons (Collapsed/Hidden) -->
            </div>
            <!-- Curriculum Section 2 (Active Section) -->
            <div class="mb-6">
                <div class="flex items-center justify-between p-3 bg-surface-container-high rounded-lg mb-2 cursor-pointer">
                    <span class="text-sm font-bold">2. The Editorial Shift</span>
                    <span class="material-symbols-outlined text-primary" data-icon="expand_less">expand_less</span>
                </div>
                <div class="space-y-1 pl-1">
                    <div class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border-l-4 border-primary shadow-sm">
                        <span class="material-symbols-outlined text-primary text-xl" data-icon="play_circle" style="font-variation-settings: 'FILL' 1;">play_circle</span>
                        <div class="flex-1">
                            <div class="text-xs font-bold text-primary">Lesson 04</div>
                            <div class="text-sm font-semibold text-on-surface leading-snug">The Art of Visual Hierarchy</div>
                            <div class="text-[10px] text-on-surface-variant flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[10px]" data-icon="schedule">schedule</span> 12:45
                            </div>
                        </div>
                    </div>
                    <div class="group flex items-center gap-3 p-3 hover:bg-surface-container-highest rounded-lg transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-on-surface-variant text-xl" data-icon="play_circle">play_circle</span>
                        <div class="flex-1">
                            <div class="text-xs font-bold text-on-surface-variant">Lesson 05</div>
                            <div class="text-sm font-semibold text-on-surface leading-snug">Whitespace as a Curator</div>
                            <div class="text-[10px] text-on-surface-variant flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[10px]" data-icon="schedule">schedule</span> 18:20
                            </div>
                        </div>
                    </div>
                    <div class="group flex items-center gap-3 p-3 hover:bg-surface-container-highest rounded-lg transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-on-surface-variant text-xl" data-icon="description">description</span>
                        <div class="flex-1">
                            <div class="text-xs font-bold text-on-surface-variant">Exercise</div>
                            <div class="text-sm font-semibold text-on-surface leading-snug">Practice: Asymmetric Layouts</div>
                            <div class="text-[10px] text-on-surface-variant flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[10px]" data-icon="attachment">attachment</span> PDF Resource
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Curriculum Section 3 (Locked) -->
            <div class="mb-6 opacity-60">
                <div class="flex items-center justify-between p-3 bg-surface-container-high rounded-lg mb-2">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm" data-icon="lock">lock</span>
                        <span class="text-sm font-bold">3. Advanced Typography</span>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="chevron_right">chevron_right</span>
                </div>
            </div>
            <div class="mt-auto p-4 bg-surface-container-highest rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl" data-icon="workspace_premium">workspace_premium</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-on-surface">Certificate Goal</div>
                        <div class="text-[10px] text-on-surface-variant uppercase tracking-wider">6 lessons remaining</div>
                    </div>
                </div>
            </div>
        </aside>
    </main>
</body>

</html>

