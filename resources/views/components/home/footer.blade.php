@php
    $catalogUrl             = route('home.courses');
    $aboutUrl               = route('home.about');
    $placementUrl           = route('home.placement');
    $contactUrl             = route('home.contact');
    $loginUrl               = route('login');
    $careerPathsUrl         = route('home.career-paths');
    $corporateTrainingUrl   = route('home.corporate-training');
    $workshopUrl            = route('home.free_workshop');
    $mentorshipUrl          = route('home.mentorship');
    $careerWithUsUrl        = route('home.career-with-us');
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<footer class="relative overflow-hidden" style="background: linear-gradient(160deg,#0e0622 0%,#1e0840 50%,#0a0418 100%);">

    <!-- Subtle top glow -->
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_40%_at_50%_0%,rgba(124,58,237,0.18),transparent_65%)]"></div>

    <!-- Top border -->
    <div class="absolute left-0 right-0 top-0 h-px bg-gradient-to-r from-transparent via-[rgba(168,85,247,0.4)] to-transparent"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 pb-10 pt-16 sm:px-6">

        <!-- Main grid -->
        <div class="grid grid-cols-1 gap-12 md:gap-16 lg:grid-cols-4 mb-16">

            <!-- Brand -->
            <div class="space-y-6">
                <a href="/" class="inline-flex items-center rounded-2xl border border-white/60 bg-white px-4 py-2.5 shadow-[0_12px_28px_rgba(124,58,237,0.08)] backdrop-blur-sm">
                    <img src="https://res.cloudinary.com/dqxg5hhfi/image/upload/v1777111055/cyis_logo_4_ikcbhi.png" alt="CodeInYourself logo" class="h-14 w-auto max-w-[10rem] object-contain sm:h-16 sm:max-w-[11rem]" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
                </a>
                <p class="max-w-xs text-sm leading-relaxed text-white">
                    Engineering professional careers through high-impact technical training and dedicated placement support ecosystem.
                </p>
                <!-- <div class="flex gap-3">
                    <a href="{{ $catalogUrl }}"
                       aria-label="Browse training programs"
                       class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/60 transition hover:border-[#a855f7]/40 hover:bg-[#a855f7]/10 hover:text-[#c084fc]">
                        <span class="material-symbols-outlined text-[18px]">public</span>
                    </a>
                    <a href="{{ $contactUrl }}"
                       aria-label="Contact us"
                       class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/60 transition hover:border-[#a855f7]/40 hover:bg-[#a855f7]/10 hover:text-[#c084fc]">
                        <span class="material-symbols-outlined text-[18px]">share</span>
                    </a>
                    <a href="mailto:support@codeinyourself.com"
                       aria-label="Email us"
                       class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/60 transition hover:border-[#a855f7]/40 hover:bg-[#a855f7]/10 hover:text-[#c084fc]">
                        <span class="material-symbols-outlined text-[18px]">mail</span>
                    </a>
                </div> -->
                <div class="flex flex-wrap gap-4">
    <!-- Facebook -->
    <a href="https://www.facebook.com/people/Codeinyourself/61563547451902/"
       target="_blank"
       aria-label="Facebook"
       class="group relative flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white transition-all duration-300 hover:-translate-y-1 hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-400 hover:shadow-lg hover:shadow-blue-500/20">
        <span class="absolute inset-0 rounded-2xl opacity-0 transition duration-300 group-hover:opacity-100 group-hover:animate-pulse bg-blue-500/10"></span>
        <i class="fab fa-facebook-f relative text-lg transition-transform duration-300 group-hover:scale-125"></i>
    </a>

    <!-- Instagram -->
    <a href="https://www.instagram.com/codeinyourself/"
       target="_blank"
       aria-label="Instagram"
       class="group relative flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white transition-all duration-300 hover:-translate-y-1 hover:border-pink-500/50 hover:bg-pink-500/10 hover:text-pink-400 hover:shadow-lg hover:shadow-pink-500/20">
        <span class="absolute inset-0 rounded-2xl opacity-0 transition duration-300 group-hover:opacity-100 group-hover:animate-pulse bg-pink-500/10"></span>
        <i class="fab fa-instagram relative text-lg transition-transform duration-300 group-hover:scale-125"></i>
    </a>

    <!-- WhatsApp -->
    <a href="https://wa.me/+919016427165"
       target="_blank"
       aria-label="WhatsApp"
       class="group relative flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white transition-all duration-300 hover:-translate-y-1 hover:border-green-500/50 hover:bg-green-500/10 hover:text-green-400 hover:shadow-lg hover:shadow-green-500/20">
        <span class="absolute inset-0 rounded-2xl opacity-0 transition duration-300 group-hover:opacity-100 group-hover:animate-pulse bg-green-500/10"></span>
        <i class="fab fa-whatsapp relative text-lg transition-transform duration-300 group-hover:scale-125"></i>
    </a>

    <!-- Email -->
    <a href="mailto:codeinyourself@gmail.com"
       aria-label="Email"
       class="group relative flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white transition-all duration-300 hover:-translate-y-1 hover:border-purple-500/50 hover:bg-purple-500/10 hover:text-purple-400 hover:shadow-lg hover:shadow-purple-500/20">
        <span class="absolute inset-0 rounded-2xl opacity-0 transition duration-300 group-hover:opacity-100 group-hover:animate-pulse bg-purple-500/10"></span>
        <i class="fas fa-envelope relative text-lg transition-transform duration-300 group-hover:scale-125"></i>
    </a>
</div>
            </div>

            <!-- Nav cols -->
            <div class="lg:col-span-2 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <div class="space-y-5">
                    <h6 class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#c084fc]">Training Programs</h6>
                    <ul class="space-y-3 text-sm text-white/55">
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $catalogUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> All Training Programs
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $catalogUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Online Training Programs
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $catalogUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Offline Training Programs
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $careerPathsUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Career Paths
                        </a></li>
                    </ul>
                </div>
                <div class="space-y-5">
                    <h6 class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#c084fc]">Quick Links</h6>
                    <ul class="space-y-3 text-sm text-white/55">
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $aboutUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> About Us
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $placementUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Placement Cell
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $workshopUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Free Workshop
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $mentorshipUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Free Mentorship
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $careerWithUsUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Career With Us
                        </a></li>
                    </ul>
                </div>
                <div class="space-y-5">
                    <h6 class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#c084fc]">Services</h6>
                    <ul class="space-y-3 text-sm text-white/55">
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ route('home.contact', ['topic' => 'service', 'subject' => 'Data Analysis Service']) }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Data Analysis
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ route('home.contact', ['topic' => 'service', 'subject' => 'Web Development Service']) }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Web Development
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ route('home.contact', ['topic' => 'service', 'subject' => 'Full Stack Development Service']) }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Full Stack Development
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ route('home.contact', ['topic' => 'service', 'subject' => 'Software Testing Service']) }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Software Testing
                        </a></li>
                        <li><a class="flex items-center gap-2 text-white transition-colors hover:text-[#c084fc]" href="{{ $contactUrl }}">
                            <span class="h-1 w-1 rounded-full bg-white"></span> Contact Us
                        </a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact -->
            <div class="space-y-5">
                <h6 class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#c084fc]">Connect</h6>
                <div class="space-y-4">
                    <a class="flex items-start gap-3 text-sm text-white transition-colors hover:text-[#c084fc]" href="mailto:codeinyourself@gmail.com">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/5 text-[#a855f7]">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                        </span>
                        Codeinyourself@gmail.com
                    </a>
                    <a class="flex items-start gap-3 text-sm text-white transition-colors hover:text-[#c084fc]" href="tel:+919016427165">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/5 text-[#a855f7]">
                            <span class="material-symbols-outlined text-[16px]">call</span>
                        </span>
                        +91 90164 27165
                    </a>
                    <a class="flex items-start gap-3 text-sm text-white transition-colors hover:text-[#c084fc]" href="https://maps.app.goo.gl/i34T1uhTnJGk4zg56" target="_blank" rel="noopener noreferrer">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/5 text-[#a855f7]">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                        </span>
                        Surat, Gujarat, India
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="flex flex-col items-center justify-between gap-4 border-t border-white/8 pt-8 text-center md:flex-row md:text-left">
            <p class="text-[10px] font-bold uppercase tracking-widest text-white">
                &copy; {{ date('Y') }} CodeInYourself. Engineering professional careers.
            </p>
            <div class="flex flex-wrap justify-center gap-6 text-[10px] font-bold uppercase tracking-widest text-white">
                <a class="transition-colors hover:text-[#c084fc]" href="{{ $contactUrl }}">Privacy Policy</a>
                <a class="transition-colors hover:text-[#c084fc]" href="{{ $loginUrl }}">Terms of Service</a>
                <a class="transition-colors hover:text-[#c084fc]" href="{{ $catalogUrl }}">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
<link rel="stylesheet" href="{{ '/chatbot/chatbot.css?v=' . filemtime(public_path('chatbot/chatbot.css')) }}">
<div
    id="cyi-chatbot-root"
    data-health-url="/api/chatbot/health"
    data-context-url="/api/chatbot/context"
    data-message-url="/api/chatbot/messages"
    data-inquiry-url="/api/chatbot/inquiries"
    data-csrf-token="{{ csrf_token() }}"
    data-owner-avatar="/images/owner 1.0.jpeg"
    data-owner-name="CodeInYourself Guide"
></div>
<script src="{{ '/chatbot/chatbot.js?v=' . filemtime(public_path('chatbot/chatbot.js')) }}" defer></script>
