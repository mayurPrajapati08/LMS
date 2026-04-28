<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>503 | Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_10%_10%,#1a3e3f_0%,#13263a_42%,#060a11_100%)] text-white">
    <main class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-6 py-16">
        <section class="w-full rounded-[2rem] border border-white/15 bg-white/5 p-6 backdrop-blur-xl sm:p-10">
            <div class="grid items-center gap-10 lg:grid-cols-[1fr_1fr]">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.35em] text-emerald-200/80">Maintenance Mode</p>
                    <h1 class="mt-4 text-4xl font-black leading-tight sm:text-6xl">{{ $title ?? 'We are upgrading this section right now.' }}</h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-white/75">
                        {{ $message ?? 'The page is temporarily disabled while updates are being deployed and verified.' }}
                    </p>
                    <a href="/" class="mt-8 inline-flex rounded-2xl bg-white px-6 py-3 text-sm font-bold text-slate-900 transition hover:-translate-y-0.5">Back To Home</a>
                </div>

                <div class="relative h-[320px] rounded-[1.5rem] border border-emerald-200/20 bg-[linear-gradient(165deg,rgba(16,50,53,0.9),rgba(13,23,41,0.96))] p-6">
                    <div class="absolute left-10 top-8 h-6 w-6 animate-bounce rounded-full bg-emerald-300/75"></div>
                    <div class="absolute right-8 top-9 h-4 w-4 animate-pulse rounded-full bg-cyan-300/70"></div>

                    <div class="absolute bottom-8 left-8 right-8 rounded-xl border border-white/15 bg-black/25 p-4">
                        <div class="mx-auto mb-4 h-24 w-40 rounded-lg border border-white/15 bg-slate-900/80 p-2">
                            <div class="h-2 w-14 rounded-full bg-emerald-300/70"></div>
                            <div class="mt-2 h-1.5 w-full rounded-full bg-white/20"></div>
                            <div class="mt-2 h-1.5 w-4/5 rounded-full bg-white/15"></div>
                            <div class="mt-2 h-1.5 w-3/5 rounded-full bg-white/10"></div>
                        </div>
                        <div class="mx-auto h-10 w-28 rounded-b-2xl bg-slate-800/90"></div>
                        <p class="mt-4 text-center text-xs font-bold uppercase tracking-[0.2em] text-emerald-200/80">
                            Developer Working
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
