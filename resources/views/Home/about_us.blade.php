<!DOCTYPE html>

<html class="scroll-smooth" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>About Us | CodeInYourself</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "tertiary-container": "#008730",
            "secondary-container": "#d7dffd",
            "inverse-on-surface": "#eef1f6",
            "surface-container-lowest": "#ffffff",
            "primary-fixed": "#d8e2ff",
            "tertiary-fixed": "#83fc8e",
            "on-background": "#181c20",
            "surface-container-highest": "#e0e3e8",
            "surface-tint": "#005bc0",
            "secondary-fixed": "#dae2ff",
            "on-error": "#ffffff",
            "surface": "#f7f9ff",
            "outline-variant": "#c1c6d7",
            "tertiary-fixed-dim": "#66df75",
            "surface-dim": "#d7dadf",
            "inverse-primary": "#adc7ff",
            "on-surface": "#181c20",
            "primary-fixed-dim": "#adc7ff",
            "tertiary": "#006b24",
            "outline": "#717786",
            "surface-variant": "#e0e3e8",
            "primary": "#0059bb",
            "on-surface-variant": "#414754",
            "on-tertiary-fixed": "#002106",
            "surface-container-low": "#f1f4f9",
            "on-secondary-fixed": "#131b30",
            "error": "#ba1a1a",
            "surface-container-high": "#e5e8ee",
            "on-secondary-container": "#5a627b",
            "on-secondary-fixed-variant": "#3e465e",
            "inverse-surface": "#2d3135",
            "surface-container": "#ebeef3",
            "on-tertiary-container": "#f7fff2",
            "secondary-fixed-dim": "#bec6e3",
            "on-tertiary-fixed-variant": "#00531a",
            "background": "#f7f9ff",
            "on-tertiary": "#ffffff",
            "primary-container": "#0070ea",
            "on-primary-fixed": "#001a41",
            "error-container": "#ffdad6",
            "secondary": "#565e77",
            "on-error-container": "#93000a",
            "surface-bright": "#f7f9ff",
            "on-primary": "#ffffff",
            "on-primary-fixed-variant": "#004493",
            "on-primary-container": "#fefcff",
            "on-secondary": "#ffffff"
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

    .glass-header {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(12px);
    }
  </style>
</head>

<body class="bg-background text-on-background font-body">

  <!-- Navbar -->
  <x-home.navbar />
  
  <main class="pt-20">
    <!-- Hero Section -->
    <section class="relative min-h-[716px] flex items-center overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img alt="Office Background" class="w-full h-full object-cover brightness-[0.4]" data-alt="Modern spacious tech office with glass walls, ergonomic furniture, and soft natural sunlight filtering through large windows at midday" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCs1lJmqNV49u7kS5ruuPPJ_Qj38DT52DSEdnYydtP5BddpPat5HzJ5skTYy-jS7z-hxsoE6VZsELOu1lzFTyYpXb-kgKGpzlRH424V_fm9mrCJ9Kepd8pBT7SaQP_46NIhqgoCsOxlWcE3kPfrh-KS98tu8bQmy7av3IkXvQl3dmQoIOK3hxrc-yasPe_ZFYq5Au5UWUZ7kS_hx_O9odVMx2hmD6fh9PBL9fc-B4RT95KA1lY0qK8bfOYkvRx1jUDJta7cXcoOepnh" />
      </div>
      <div class="relative z-10 max-w-7xl mx-auto px-6 py-24">
        <div class="max-w-3xl">
          <span class="inline-block py-1 px-3 rounded-full bg-primary/20 text-primary-fixed border border-primary/30 text-xs font-bold uppercase tracking-widest mb-6">Our Mission</span>
          <h1 class="font-headline text-5xl md:text-7xl font-extrabold text-white leading-[1.1] tracking-tight mb-8">
            Transforming Aspiring Individuals into <span class="text-primary-fixed">Industry-Ready</span> Professionals
          </h1>
          <p class="text-lg md:text-xl text-slate-300 mb-10 max-w-2xl leading-relaxed">
            We bridge the gap between academic theory and corporate reality through immersive, mentor-led engineering bootcamps.
          </p>
          <div class="flex flex-wrap gap-4">
            <button class="bg-primary text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-primary-container transition-all shadow-xl shadow-primary/20">Explore Our Story</button>
            <button class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition-all">View Milestones</button>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Story Section -->
    <section class="py-32 bg-surface">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-20 items-center">
          <div class="order-2 md:order-1">
            <div class="relative group">
              <div class="absolute -inset-4 bg-primary/10 rounded-[2rem] transform rotate-3 transition-transform group-hover:rotate-1"></div>
              <img alt="Students and Mentors" class="relative rounded-[1.5rem] shadow-2xl object-cover aspect-[4/5] w-full" data-alt="A group of diverse young tech students collaborating around a laptop with a professional mentor in a bright modern classroom" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUzN8jOdiNI40TtpbcxuInIE-UlQyN_4c2QFUTf2P7xRuBM66u5_DGoqIleAzTUdPLajRtXTRCj5P13dABy6O8lAn-ME8fKAaHVYKmvozWIn3_XLJU3Ms3vJz79nrlAuwN5HmYfG71BgjjsFlUhXpV1v6zCAqsBbY31te7577TaTiUPxdObyjArOQa1BV0J3pgWFqCPxenbSKwgGeqTzvnIpMciWrgDDA_VVv_bkbg_s6jmeytsSiOacy894olUm6ASB4MAMGs3HDf" />
              <div class="absolute -bottom-8 -right-8 bg-white p-6 rounded-2xl shadow-xl hidden lg:block border border-slate-100">
                <p class="font-headline font-bold text-4xl text-primary">{{ number_format($siteStats['students']) }}+</p>
                <p class="text-secondary text-sm font-medium">Learners Guided</p>
              </div>
            </div>
          </div>
          <div class="order-1 md:order-2">
            <h2 class="font-headline text-4xl md:text-5xl font-extrabold text-on-surface mb-8 leading-tight">
              Engineering Futures, One Coder at a Time.
            </h2>
            <div class="space-y-6 text-on-surface-variant text-lg leading-relaxed">
              <p>
                Founded in 2020, CodeInYourself began with a singular observation: traditional education was failing to keep pace with the hyper-evolved tech landscape.
              </p>
              <p>
                We didn't want to build another tutorial platform. We wanted to build a career forge. Our approach combines rigorous technical training with the soft skills and real-world project experience that top-tier companies actually demand.
              </p>
              <p>
                Today, we are a community of mentors, engineers, and dreamers dedicated to the philosophy that anyone can "code in themselves" the mindset of a professional.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Values Section (Bento Style) -->
    <section class="py-32 bg-surface-container-low">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
          <h2 class="font-headline text-4xl font-extrabold text-on-surface mb-4">The Values That Drive Us</h2>
          <p class="text-on-surface-variant max-w-2xl mx-auto">The core principles that guide every curriculum decision and student interaction.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <!-- Value 1 -->
          <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-primary/10 text-primary flex items-center justify-center rounded-lg mb-6">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
            </div>
            <h3 class="font-headline font-bold text-xl mb-3">Innovation</h3>
            <p class="text-on-surface-variant text-sm leading-relaxed">Constantly evolving our curriculum to match the cutting edge of AI, Cloud, and Software Engineering.</p>
          </div>
          <!-- Value 2 -->
          <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-tertiary/10 text-tertiary flex items-center justify-center rounded-lg mb-6">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            </div>
            <h3 class="font-headline font-bold text-xl mb-3">Integrity</h3>
            <p class="text-on-surface-variant text-sm leading-relaxed">Honest career guidance and realistic job expectations. We value your trust above all else.</p>
          </div>
          <!-- Value 3 -->
          <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-secondary/10 text-secondary flex items-center justify-center rounded-lg mb-6">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person_pin</span>
            </div>
            <h3 class="font-headline font-bold text-xl mb-3">Student-First</h3>
            <p class="text-on-surface-variant text-sm leading-relaxed">Every student is a unique project. Personalized mentorship is the cornerstone of our success.</p>
          </div>
          <!-- Value 4 -->
          <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-primary/10 text-primary flex items-center justify-center rounded-lg mb-6">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
            </div>
            <h3 class="font-headline font-bold text-xl mb-3">Excellence</h3>
            <p class="text-on-surface-variant text-sm leading-relaxed">Good enough isn't enough. We strive for excellence in code quality and professional ethics.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Team Section -->
    <section class="py-32 bg-surface">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
          <div class="max-w-xl">
            <h2 class="font-headline text-4xl font-extrabold text-on-surface mb-4">Meet the Mentors</h2>
            <p class="text-on-surface-variant">Industry veterans from Fortune 500 companies dedicated to your growth.</p>
          </div>
          <a class="text-primary font-bold flex items-center gap-2 hover:gap-3 transition-all" href="{{ route('home.contact') }}">
            Connect with mentors <span class="material-symbols-outlined">arrow_forward</span>
          </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          @foreach ($mentorCards as $mentor)
            <div class="group">
              <div class="relative overflow-hidden rounded-2xl mb-4 aspect-square">
                <img alt="{{ $mentor['name'] }}" class="w-full h-full object-cover transition-all duration-500 scale-100 group-hover:scale-105" src="{{ $mentor['avatar'] }}" />
              </div>
              <h4 class="font-headline font-bold text-lg text-on-surface">{{ $mentor['name'] }}</h4>
              <p class="text-primary font-medium text-sm mb-2">{{ $mentor['headline'] }}</p>
              <p class="text-on-surface-variant text-xs leading-relaxed">{{ $mentor['bio'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- Milestones Section -->
    <section class="py-32 bg-surface-container-highest/30">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-24">
          <h2 class="font-headline text-4xl font-extrabold text-on-surface mb-4">Our Growth Story</h2>
          <p class="text-on-surface-variant">A timeline of how we became a leader in tech education.</p>
        </div>
        <div class="relative">
          <!-- Vertical Line -->
          <div class="absolute left-1/2 -translate-x-1/2 h-full w-px bg-outline-variant/50 hidden md:block"></div>
          <div class="space-y-24">
            <!-- 2020 -->
            <div class="relative flex flex-col md:flex-row items-center justify-between">
              <div class="md:w-[45%] mb-8 md:mb-0 text-right pr-0 md:pr-12">
                <h4 class="font-headline text-3xl font-extrabold text-primary mb-2">2020</h4>
                <h5 class="text-xl font-bold text-on-surface mb-4">The Spark</h5>
                <p class="text-on-surface-variant leading-relaxed">CodeInYourself launches with its first batch of 20 students in a small home office, focusing purely on Full-Stack Development.</p>
              </div>
              <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-primary border-4 border-white z-10 hidden md:block"></div>
              <div class="md:w-[45%] pl-0 md:pl-12 opacity-40">
                <img alt="2020" class="rounded-xl grayscale" data-alt="Close up of computer screens with lines of code in a dimly lit, cozy home office environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIIpQEgesyPe1fa6CuQeBOicoGxahuADsRQrsfQS6MJNuSC0_rCiYq6Svd2cTSj-eCJxnLwrLxhw0Z-6GEQAS8jOHHd28dlWrtiN4l3BgbjPW07nD7ZkOOSG_6gg7ycvA5KbYeiFV7RCGtiJJLpYVNc5yLhgNGBagD15EukXqT5WOQu4IviPy8phxO5o2cxEke7PBdbL67D0Z64hfYXLawZzhhefHyuLWTzm24rJ7W5MzkqzfabVESUc5cO1vVcLYZBdNDq33lD-xe" />
              </div>
            </div>
            <!-- 2022 -->
            <div class="relative flex flex-col md:flex-row-reverse items-center justify-between">
              <div class="md:w-[45%] mb-8 md:mb-0 text-left pl-0 md:pl-12">
                <h4 class="font-headline text-3xl font-extrabold text-primary mb-2">2022</h4>
                <h5 class="text-xl font-bold text-on-surface mb-4">Scaling Up</h5>
                <p class="text-on-surface-variant leading-relaxed">Expansion into AI and Cloud Engineering. Our student base grows to 1,000+, and we establish partnerships with 50+ tech giants.</p>
              </div>
              <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-primary border-4 border-white z-10 hidden md:block"></div>
              <div class="md:w-[45%] pr-0 md:pr-12 opacity-40">
                <img alt="2022" class="rounded-xl grayscale" data-alt="A professional handshake between two people in a glass-walled meeting room representing business growth and partnership" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPyHeQRTfIpiV89NwCPdGeUORepnmtl-akAIIbEMrJhRhRk2ng0j_J3Ha0TrusiQ5POaCgemKUuxeVUG6x9JswJIcp1gt0lZAGsJhScdBYejhVuWsFCN_ttl2f143ejJ77xer8Xy-u4uiAue-AHdx7sCZaovYi69OTPcwZpZrFNuYE2jeVKnDQm-Ex_N4MPvWQCgx88RQpRXEfcAWDww6OHQGt75IJFsKg4s9pZn68a43RZqmmQF91d5pxkTH4iTZjB-TUjZfckjO7" />
              </div>
            </div>
            <!-- 2024 -->
            <div class="relative flex flex-col md:flex-row items-center justify-between">
              <div class="md:w-[45%] mb-8 md:mb-0 text-right pr-0 md:pr-12">
                <h4 class="font-headline text-3xl font-extrabold text-primary mb-2">Now</h4>
                <h5 class="text-xl font-bold text-on-surface mb-4">Industry Leader</h5>
                <p class="text-on-surface-variant leading-relaxed">Named the #1 Bootcamp for Engineering Excellence. Launching our global virtual campus connecting students worldwide.</p>
              </div>
              <div class="absolute left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-primary border-4 border-white z-10 hidden md:block shadow-lg shadow-primary/40"></div>
              <div class="md:w-[45%] pl-0 md:pl-12">
                <img alt="Now" class="rounded-xl shadow-xl" data-alt="Modern high-tech auditorium filled with diverse students at a graduation ceremony, with bright stage lights" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCcf8naAvM6JDVfAXANDPjODxLP0kkXu0O9lS39YNNpsrrepG1csX7bgZSTVqLwPkxdFnASpCJcZC95TN09EAFXBNY1gKcITC6LqbFXliiNp7HME8FInQblyMsReT8VlJ5W2VjM7mnHaJ9YIS8IRyABCaSmCK2MN7jwkt_GcNz-blIxK0p4GVWH9K6Jmqcbjz-zCZbIKyZfp0-ef19C8zixAO3FxPzyaHPIM309fC-bNjbKsgrjCFP3ml2fXEZgypcoo2wz1U_9uc-E" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

    <!-- Footer -->
    <x-home.footer />
  
</body>

</html>

