<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temporary Issue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[linear-gradient(160deg,#1f0a14_0%,#3b1b68_55%,#155e75_100%)] text-white">
    <main class="mx-auto flex min-h-screen max-w-5xl flex-col items-center justify-center px-6 py-16 text-center">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-white/60">System Issue</p>
        <h1 class="mt-4 text-4xl font-black sm:text-6xl">We’re fixing this as quickly as possible.</h1>
        <p class="mt-5 max-w-2xl text-base leading-8 text-white/74">The page is temporarily unavailable. Our developers have been notified automatically with the error details so the issue can be investigated fast.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="/" class="rounded-2xl bg-white px-6 py-3 text-sm font-bold text-slate-900">Back To Home</a>
            <a href="mailto:{{ \App\Support\PlatformSettings::string('exception_alert_email', 'support@codeinyourself.in') }}" class="rounded-2xl border border-white/20 px-6 py-3 text-sm font-bold text-white">Email Developers</a>
        </div>
    </main>
</body>
</html>
