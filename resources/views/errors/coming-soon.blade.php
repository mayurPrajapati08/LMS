<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Coming Soon' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[linear-gradient(160deg,#0f172a_0%,#312e81_50%,#0f766e_100%)] text-white">
    <main class="mx-auto flex min-h-screen max-w-5xl flex-col items-center justify-center px-6 py-16 text-center">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-white/60">Coming Soon</p>
        <h1 class="mt-4 text-4xl font-black sm:text-6xl">{{ $title ?? 'This section is coming soon.' }}</h1>
        <p class="mt-5 max-w-2xl text-base leading-8 text-white/74">{{ $message ?? 'We are still preparing this experience and will make it available as soon as it is ready.' }}</p>
        @if (!empty($feature))
            <p class="mt-3 text-sm font-semibold uppercase tracking-[0.2em] text-teal-200">{{ $feature }}</p>
        @endif
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="/" class="rounded-2xl bg-white px-6 py-3 text-sm font-bold text-slate-900">Back To Home</a>
            <a href="/contact" class="rounded-2xl border border-white/20 px-6 py-3 text-sm font-bold text-white">Talk To Our Team</a>
        </div>
    </main>
</body>
</html>
