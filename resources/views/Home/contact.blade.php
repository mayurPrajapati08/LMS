<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Contact Us | CodeInYourself</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#08275c",
            "on-primary": "#FFFFFF",
            "primary-container": "#dcecff",
            "on-primary-container": "#071c4a",
            secondary: "#565E71",
            "on-secondary": "#FFFFFF",
            "secondary-container": "#DAE2F9",
            "on-secondary-container": "#131C2C",
            tertiary: "#006B24",
            "on-tertiary": "#FFFFFF",
            "tertiary-container": "#9EF7A0",
            "on-tertiary-container": "#002106",
            surface: "#f4f9ff",
            background: "#f7fbff",
            "surface-variant": "#E1E2EC",
            "surface-container-low": "#f1f4f9",
            "surface-container-high": "#e5e8ee",
            "surface-container-lowest": "#ffffff",
            "on-surface": "#1A1C1E",
            "on-surface-variant": "#4f6178",
            outline: "#7c8da7",
            error: "#BA1A1A"
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Inter"]
          }
        }
      }
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
  </style>
</head>
<body class="bg-background font-body text-on-surface">
  <x-home.navbar />

  <main class="pt-24 pb-20">
    <section class="max-w-7xl mx-auto px-6 py-16 text-center md:text-left">
      <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest mb-6">
        Connect With Us
      </div>
      <h1 class="font-headline text-5xl md:text-6xl font-extrabold text-on-surface tracking-tight leading-tight max-w-3xl">
        Let's Engineer Your <span class="text-primary italic">Future.</span>
      </h1>
      <p class="mt-6 text-on-surface-variant text-lg max-w-2xl leading-relaxed">
        Ask about a course, admissions, pricing, or your learning roadmap. Your message is now saved directly into the project so the team can manage it properly.
      </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
      <div class="bg-surface-container-lowest p-8 md:p-12 rounded-xl shadow-sm border border-slate-200/70">
        @if (session('status'))
          <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            {{ $errors->first() }}
          </div>
        @endif

        <form action="{{ route('home.contact.submit') }}" class="space-y-6" method="POST">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-on-surface-variant ml-1">Full Name</label>
              <input class="w-full bg-surface-container-low border-transparent focus:border-primary focus:ring-0 rounded-lg px-4 py-3 transition-all placeholder:text-slate-400" name="name" placeholder="John Doe" type="text" value="{{ old('name') }}" />
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-on-surface-variant ml-1">Email Address</label>
              <input class="w-full bg-surface-container-low border-transparent focus:border-primary focus:ring-0 rounded-lg px-4 py-3 transition-all placeholder:text-slate-400" name="email" placeholder="john@example.com" type="email" value="{{ old('email') }}" />
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-on-surface-variant ml-1">Phone Number</label>
              <input class="w-full bg-surface-container-low border-transparent focus:border-primary focus:ring-0 rounded-lg px-4 py-3 transition-all placeholder:text-slate-400" name="phone" placeholder="+91 98765 43210" type="tel" value="{{ old('phone') }}" />
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-on-surface-variant ml-1">Interested Course</label>
              <select class="w-full bg-surface-container-low border-transparent focus:border-primary focus:ring-0 rounded-lg px-4 py-3 transition-all text-on-surface-variant" name="course_id">
                <option value="">Select a course</option>
                @foreach ($courseOptions as $course)
                  <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-on-surface-variant ml-1">Message</label>
            <textarea class="w-full bg-surface-container-low border-transparent focus:border-primary focus:ring-0 rounded-lg px-4 py-3 transition-all placeholder:text-slate-400" name="message" placeholder="How can our mentors help you?" rows="5">{{ old('message') }}</textarea>
          </div>
          <button class="w-full bg-tertiary text-white font-bold py-4 rounded-lg shadow-md hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
            <span>Send Message</span>
            <span class="material-symbols-outlined text-xl">send</span>
          </button>
        </form>
      </div>

      <div class="space-y-8">
        <div class="group flex gap-6 p-6 rounded-xl bg-surface-container-low hover:bg-surface-container-high transition-all">
          <div class="w-14 h-14 shrink-0 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-3xl">location_on</span>
          </div>
          <div>
            <h3 class="font-headline text-xl font-bold text-on-surface mb-2">Our Campus</h3>
            <p class="text-on-surface-variant leading-relaxed">Ahmedabad, Gujarat<br />India</p>
          </div>
        </div>
        <div class="group flex gap-6 p-6 rounded-xl bg-surface-container-low hover:bg-surface-container-high transition-all">
          <div class="w-14 h-14 shrink-0 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-3xl">schedule</span>
          </div>
          <div>
            <h3 class="font-headline text-xl font-bold text-on-surface mb-2">Office Hours</h3>
            <div class="space-y-1 text-on-surface-variant">
              <p class="flex justify-between gap-8"><span class="font-medium">Monday - Friday</span> <span>9 AM - 6 PM</span></p>
              <p class="flex justify-between gap-8"><span class="font-medium">Saturday</span> <span>10 AM - 2 PM</span></p>
            </div>
          </div>
        </div>
        <div class="group flex gap-6 p-6 rounded-xl bg-surface-container-low hover:bg-surface-container-high transition-all">
          <div class="w-14 h-14 shrink-0 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-3xl">alternate_email</span>
          </div>
          <div>
            <h3 class="font-headline text-xl font-bold text-on-surface mb-2">Email Us</h3>
            <div class="space-y-1">
              <a class="block text-primary font-medium hover:underline" href="mailto:admissions@codeinyourself.com">admissions@codeinyourself.com</a>
              <a class="block text-primary font-medium hover:underline" href="mailto:support@codeinyourself.com">support@codeinyourself.com</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <x-home.footer />
</body>
</html>


