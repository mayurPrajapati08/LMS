@php
    $catalogUrl = route('home.courses');
    $aboutUrl = route('home.about');
    $placementUrl = route('home.placement');
    $contactUrl = route('home.contact');
    $loginUrl = route('login');
@endphp

<!-- Footer -->
    <footer class="w-full border-t border-[#d5e4ff] bg-[linear-gradient(180deg,#f7fbff_0%,#ffffff_100%)] pt-16 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 md:gap-16 mb-16 md:mb-20">
                <div class="space-y-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-white p-1.5 ring-1 ring-[#d5e4ff] shadow-[0_12px_26px_rgba(12,78,163,0.16)]">
                            <img src="https://www.codeinyourself.com/assets/img/logo.webp" alt="CodeInYourself logo" class="h-full w-full object-contain" loading="lazy" decoding="async" referrerpolicy="no-referrer" />
                        </span>
                        <div>
                            <div class="text-2xl font-extrabold text-[#08275c] font-headline tracking-tighter">CodeInYourself</div>
                            <div class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#1570d8]">Engineering Career Growth</div>
                        </div>
                    </div>
                    <p class="text-on-surface-variant leading-relaxed text-sm max-w-xs">
                        Engineering professional careers through high-impact technical training and dedicated placement support ecosystem.
                    </p>
                    <div class="flex gap-4">
                        <a class="w-12 h-12 rounded-full border border-[#d5e4ff] bg-white flex items-center justify-center text-[#0c4ea3] hover:bg-[#0c4ea3] hover:text-white transition-all shadow-sm" href="{{ $catalogUrl }}" aria-label="Browse courses">
                            <span class="material-symbols-outlined">public</span>
                        </a>
                        <a class="w-12 h-12 rounded-full border border-[#d5e4ff] bg-white flex items-center justify-center text-[#0c4ea3] hover:bg-[#0c4ea3] hover:text-white transition-all shadow-sm" href="{{ $contactUrl }}" aria-label="Contact us">
                            <span class="material-symbols-outlined">share</span>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <h6 class="font-bold text-xs text-on-surface uppercase tracking-[0.2em]">Courses</h6>
                        <ul class="space-y-4 text-sm text-on-surface-variant">
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $catalogUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> Data Science</a></li>
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $catalogUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> Full Stack Mastery</a></li>
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $catalogUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> DSA Prep</a></li>
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $catalogUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> Cloud Architecture</a></li>
                        </ul>
                    </div>
                    <div class="space-y-6">
                        <h6 class="font-bold text-xs text-on-surface uppercase tracking-[0.2em]">Quick Links</h6>
                        <ul class="space-y-4 text-sm text-on-surface-variant">
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $aboutUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> About Us</a></li>
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $placementUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> Placement Cell</a></li>
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $placementUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> Success Stories</a></li>
                            <li><a class="hover:text-primary transition-all flex items-center gap-2" href="{{ $contactUrl }}"><span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="space-y-6">
                    <h6 class="font-bold text-xs text-on-surface uppercase tracking-[0.2em]">Connect with Us</h6>
                    <div class="space-y-5">
                        <a class="flex items-center gap-4 text-sm text-on-surface-variant hover:text-primary transition-colors" href="mailto:support@codeinyourself.com">
                            <span class="material-symbols-outlined text-primary">mail</span>
                            support@codeinyourself.com
                        </a>
                        <a class="flex items-center gap-4 text-sm text-on-surface-variant hover:text-primary transition-colors" href="tel:+9118001234567">
                            <span class="material-symbols-outlined text-primary">call</span>
                            +91 1800-123-4567
                        </a>
                        <a class="flex items-center gap-4 text-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ $contactUrl }}">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            Cyber City, Gurgaon, India
                        </a>
                    </div>
                </div>
            </div>
            <div class="pt-10 border-t border-surface-variant flex flex-col md:flex-row justify-between items-center gap-4 md:gap-6 text-center md:text-left">
                <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest">
                    &copy; 2024 CodeInYourself. Engineering professional careers.
                </p>
                <div class="flex flex-wrap justify-center gap-4 sm:gap-8 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">
                    <a class="hover:text-primary" href="{{ $contactUrl }}">Privacy Policy</a>
                    <a class="hover:text-primary" href="{{ $loginUrl }}">Terms of Service</a>
                    <a class="hover:text-primary" href="{{ $catalogUrl }}">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>
