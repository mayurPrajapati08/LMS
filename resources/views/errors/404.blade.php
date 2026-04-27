<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_15%_10%,#173357_0%,#0d1221_42%,#06080e_100%)] text-white">
    <main class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-6 py-16">
        <section class="w-full rounded-[2rem] border border-white/15 bg-white/5 p-6 backdrop-blur-xl sm:p-10">
            <div class="grid items-center gap-10 lg:grid-cols-[1fr_0.9fr]">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.35em] text-cyan-200/80">Error 404</p>
                    <h1 class="mt-4 text-4xl font-black leading-tight sm:text-6xl">The page was not found.</h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-white/75">
                        This URL is no longer available or was typed incorrectly. Use the home page to continue safely.
                    </p>
                    <a href="/" class="mt-8 inline-flex rounded-2xl bg-white px-6 py-3 text-sm font-bold text-slate-900 transition hover:-translate-y-0.5">Back To Home</a>
                </div>

                <div class="relative h-[290px] overflow-hidden rounded-[1.5rem] border border-white/20 bg-[linear-gradient(165deg,rgba(23,44,78,0.95),rgba(10,14,22,0.96))]">
                    <div class="absolute left-8 right-8 top-8 h-3 rounded-full bg-white/15"></div>
                    <div class="absolute left-8 right-16 top-16 h-3 rounded-full bg-white/10"></div>
                    <div class="absolute bottom-7 left-7 right-7 rounded-[1rem] border border-white/15 bg-black/25 p-5">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200/80">Route Scanner</p>
                        <p class="mt-3 text-sm text-white/70">No matching route was found for this request.</p>
                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-white/10">
                            <div class="h-full w-[73%] animate-pulse rounded-full bg-cyan-300/80"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
