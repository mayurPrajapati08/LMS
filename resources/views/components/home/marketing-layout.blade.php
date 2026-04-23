@props([
    'title' => 'CodeInYourself',
    'bodyClass' => '',
])

<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#7c3aed",
                        "primary-light": "#a855f7",
                        "primary-dark": "#5b21b6",
                        "primary-soft": "#f3ebff",
                        "primary-muted": "#ede9fe",
                        surface: "#fcf9ff",
                        background: "#fcf9ff",
                        "surface-soft": "#f7f2ff",
                        "surface-strong": "#ece3ff",
                        "on-surface": "#1a1330",
                        "on-surface-variant": "#6d5d89",
                        outline: "#dccdf6",
                    },
                    fontFamily: {
                        headline: ["Space Grotesk", "ui-sans-serif", "system-ui", "sans-serif"],
                        body: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                    },
                    boxShadow: {
                        hero: "0 34px 90px rgba(88, 28, 135, 0.26)",
                        soft: "0 18px 48px rgba(124, 58, 237, 0.12)",
                        glow: "0 0 42px rgba(168, 85, 247, 0.32)",
                        card: "0 24px 68px rgba(88, 28, 135, 0.14)",
                    },
                },
            },
        };
    </script>

    {{ $head ?? '' }}

    <style>
        * { box-sizing: border-box; }

        html {
            scrollbar-gutter: stable;
            scrollbar-width: thin;
            scrollbar-color: rgba(109, 40, 217, 0.72) rgba(243, 232, 255, 0.9);
        }

        html::-webkit-scrollbar,
        body.marketing-shell::-webkit-scrollbar {
            width: 12px;
        }

        html::-webkit-scrollbar-track,
        body.marketing-shell::-webkit-scrollbar-track {
            background:
                linear-gradient(180deg, rgba(250, 245, 255, 0.98), rgba(238, 228, 252, 0.98));
            border-left: 1px solid rgba(220, 205, 246, 0.72);
        }

        html::-webkit-scrollbar-thumb,
        body.marketing-shell::-webkit-scrollbar-thumb {
            background:
                linear-gradient(180deg, rgba(91, 33, 182, 0.88), rgba(139, 92, 246, 0.88));
            border: 2px solid rgba(248, 242, 255, 0.95);
            border-radius: 9999px;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.28),
                0 6px 16px rgba(76, 29, 149, 0.18);
        }

        html::-webkit-scrollbar-thumb:hover,
        body.marketing-shell::-webkit-scrollbar-thumb:hover {
            background:
                linear-gradient(180deg, rgba(76, 29, 149, 0.94), rgba(124, 58, 237, 0.94));
        }

        body.marketing-shell {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(168, 85, 247, 0.18), transparent 22%),
                radial-gradient(circle at top right, rgba(124, 58, 237, 0.12), transparent 26%),
                radial-gradient(circle at bottom center, rgba(168, 85, 247, 0.08), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, #fcf9ff 38%, #f7f0ff 100%);
            scrollbar-width: thin;
            scrollbar-color: rgba(109, 40, 217, 0.72) rgba(243, 232, 255, 0.9);
            overflow-x: hidden;
        }

        body.marketing-shell,
        body.marketing-shell main,
        body.marketing-shell section,
        body.marketing-shell article,
        body.marketing-shell div {
            min-width: 0;
        }

        body.marketing-shell img,
        body.marketing-shell video,
        body.marketing-shell iframe {
            max-width: 100%;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        .page-aurora {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .page-aurora::before,
        .page-aurora::after {
            content: "";
            position: absolute;
            border-radius: 9999px;
            filter: blur(20px);
            opacity: 0.6;
            animation: float-aurora 16s ease-in-out infinite alternate;
        }

        .page-aurora::before {
            top: 4rem;
            left: -7rem;
            width: 20rem;
            height: 20rem;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.24), rgba(124, 58, 237, 0));
        }

        .page-aurora::after {
            right: -5rem;
            top: 20rem;
            width: 18rem;
            height: 18rem;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.20), rgba(168, 85, 247, 0));
            animation-duration: 20s;
        }

        .page-shell {
            position: relative;
            z-index: 1;
        }

        .hero-panel {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background:
                radial-gradient(circle at 12% 18%, rgba(255, 255, 255, 0.18), transparent 24%),
                radial-gradient(circle at 82% 22%, rgba(216, 180, 254, 0.16), transparent 22%),
                linear-gradient(135deg, #120520 0%, #33105f 34%, #5a21b5 72%, #9d5cff 100%);
            box-shadow: 0 38px 100px rgba(76, 29, 149, 0.28);
        }

        .hero-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 78% 80%, rgba(255, 255, 255, 0.10), transparent 24%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.03), transparent 44%);
            pointer-events: none;
        }

        .hero-stars::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 16% 22%, rgba(255,255,255,0.70) 0%, transparent 100%),
                radial-gradient(1px 1px at 32% 14%, rgba(255,255,255,0.50) 0%, transparent 100%),
                radial-gradient(1.6px 1.6px at 74% 18%, rgba(255,255,255,0.50) 0%, transparent 100%),
                radial-gradient(1px 1px at 88% 54%, rgba(255,255,255,0.38) 0%, transparent 100%),
                radial-gradient(1.6px 1.6px at 24% 76%, rgba(221,214,254,0.70) 0%, transparent 100%),
                radial-gradient(1px 1px at 68% 72%, rgba(255,255,255,0.42) 0%, transparent 100%);
            opacity: 0.8;
            pointer-events: none;
        }

        .hero-stat,
        .glass-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.94), rgba(255,255,255,0.84));
            border: 1px solid rgba(220, 205, 246, 0.84);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 22px 56px rgba(76, 29, 149, 0.11);
        }

        .hero-stat {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.16);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.08), 0 20px 54px rgba(35, 11, 79, 0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .hero-visual {
            position: relative;
            min-height: 18rem;
        }

        .hero-showcase {
            position: relative;
            min-height: 20rem;
            overflow: hidden;
        }

        .hero-abstract {
            position: relative;
            min-height: 24rem;
            overflow: hidden;
        }

        .hero-grid-fade {
            position: absolute;
            inset: 12% 6% 10% auto;
            width: 44%;
            background-image:
                linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 2.8rem 2.8rem;
            mask-image: radial-gradient(circle at center, black 32%, transparent 78%);
            opacity: 0.5;
            pointer-events: none;
        }

        .hero-giant-word {
            position: absolute;
            font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
            font-weight: 800;
            line-height: 0.88;
            letter-spacing: -0.08em;
            color: rgba(255,255,255,0.10);
            pointer-events: none;
            user-select: none;
        }

        .hero-radial-bloom {
            position: absolute;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(216,180,254,0.34), rgba(216,180,254,0));
            filter: blur(26px);
            pointer-events: none;
        }

        @media (max-width: 1023px) {
            body.marketing-shell nav .group .absolute.w-\[42rem\] {
                width: min(100vw - 2rem, 34rem) !important;
            }
        }

        @media (max-width: 767px) {
            body.marketing-shell {
                background:
                    radial-gradient(circle at top left, rgba(168, 85, 247, 0.12), transparent 18%),
                    linear-gradient(180deg, #ffffff 0%, #fcf9ff 42%, #f7f0ff 100%);
            }

            .page-aurora::before {
                width: 12rem;
                height: 12rem;
                left: -4rem;
            }

            .page-aurora::after {
                width: 11rem;
                height: 11rem;
                right: -3rem;
                top: 14rem;
            }

            .hero-panel {
                border-radius: 1.6rem;
                box-shadow: 0 24px 64px rgba(76, 29, 149, 0.2);
            }
        }

        .hero-line {
            position: absolute;
            background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,0.78), rgba(255,255,255,0));
            pointer-events: none;
        }

        .hero-line.horizontal {
            height: 1px;
        }

        .hero-line.vertical {
            width: 1px;
            background: linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,0.78), rgba(255,255,255,0));
        }

        .hero-dot {
            position: absolute;
            border-radius: 9999px;
            background: rgba(255,255,255,0.82);
            box-shadow: 0 0 18px rgba(255,255,255,0.45);
            pointer-events: none;
        }

        .hero-note {
            position: absolute;
            max-width: 14rem;
            font-size: 0.94rem;
            line-height: 1.75;
            color: rgba(255,255,255,0.70);
        }

        .hero-micro-label {
            position: absolute;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.48);
        }

        .hero-spotlight {
            position: absolute;
            inset: auto auto 8% 12%;
            width: 15rem;
            height: 15rem;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(255,255,255,0.18), rgba(255,255,255,0));
            filter: blur(10px);
            pointer-events: none;
        }

        .hero-ring {
            position: absolute;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.16);
            pointer-events: none;
        }

        .hero-ring-lg {
            top: 1rem;
            right: 1.2rem;
            width: 16rem;
            height: 16rem;
        }

        .hero-ring-md {
            top: 3.5rem;
            right: 3.7rem;
            width: 10.8rem;
            height: 10.8rem;
            border-color: rgba(255,255,255,0.12);
        }

        .hero-glow-line {
            position: absolute;
            inset: auto 0 2.5rem auto;
            width: 16rem;
            height: 1px;
            background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,0.72), rgba(255,255,255,0));
            transform: rotate(-18deg);
            transform-origin: right center;
            opacity: 0.7;
        }

        .hero-label-stack {
            position: absolute;
            top: 1.75rem;
            left: 0;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
            max-width: 11rem;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            width: fit-content;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.10);
            padding: 0.58rem 0.9rem;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .hero-label::before {
            content: "";
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 9999px;
            background: rgba(255,255,255,0.78);
            box-shadow: 0 0 16px rgba(255,255,255,0.55);
        }

        .hero-center-copy {
            position: absolute;
            top: 50%;
            right: 4rem;
            transform: translateY(-50%);
            width: min(100%, 12rem);
            text-align: right;
        }

        .hero-center-copy p:first-child {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.54);
        }

        .hero-center-copy p:last-child {
            margin-top: 0.8rem;
            font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
            font-size: 1.7rem;
            line-height: 1.15;
            font-weight: 800;
            color: white;
        }

        .hero-footer-note {
            position: absolute;
            left: 1.5rem;
            bottom: 1.5rem;
            max-width: 14rem;
            font-size: 0.86rem;
            line-height: 1.6;
            color: rgba(255,255,255,0.72);
        }

        .hero-orbit-dot {
            position: absolute;
            border-radius: 9999px;
            background: rgba(255,255,255,0.82);
            box-shadow: 0 0 18px rgba(255,255,255,0.55);
            pointer-events: none;
        }

        .hero-orbit-dot.one {
            top: 2.7rem;
            right: 9rem;
            width: 0.55rem;
            height: 0.55rem;
        }

        .hero-orbit-dot.two {
            bottom: 4.5rem;
            right: 4.4rem;
            width: 0.42rem;
            height: 0.42rem;
            background: rgba(221,214,254,0.92);
        }

        .hero-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(8px);
            opacity: 0.85;
            pointer-events: none;
        }

        .hero-orb-one {
            top: 1rem;
            right: 2rem;
            width: 9rem;
            height: 9rem;
            background: radial-gradient(circle, rgba(255,255,255,0.28), rgba(255,255,255,0));
        }

        .hero-orb-two {
            bottom: 0.5rem;
            left: 1rem;
            width: 11rem;
            height: 11rem;
            background: radial-gradient(circle, rgba(216,180,254,0.32), rgba(216,180,254,0));
        }

        .hero-float-card {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.11);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.08), 0 18px 44px rgba(35, 11, 79, 0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .hero-float-card.primary {
            top: 0;
            right: 0;
            width: min(100%, 18rem);
            padding: 1.2rem;
            border-radius: 1.6rem;
        }

        .hero-float-card.secondary {
            left: 0;
            bottom: 1rem;
            width: min(100%, 14rem);
            padding: 1rem;
            border-radius: 1.35rem;
        }

        .hero-metric-row {
            position: absolute;
            right: 0.75rem;
            bottom: 0;
            display: grid;
            gap: 0.75rem;
            width: min(100%, 19rem);
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .hero-metric {
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.10);
            border-radius: 1.25rem;
            padding: 0.95rem 1rem;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .hero-chip-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
        }

        .hero-chip {
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.10);
            padding: 0.55rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: rgba(255,255,255,0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .pretty-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(124,58,237,0.42) rgba(243,232,255,0.72);
        }

        .pretty-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .pretty-scroll::-webkit-scrollbar-track {
            background: rgba(243,232,255,0.72);
            border-radius: 9999px;
        }

        .pretty-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(124,58,237,0.75), rgba(168,85,247,0.68));
            border-radius: 9999px;
            border: 2px solid rgba(243,232,255,0.72);
        }

        .pretty-scroll::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(109,40,217,0.82), rgba(168,85,247,0.82));
        }

        .section-panel {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(220, 205, 246, 0.8);
            background: linear-gradient(180deg, rgba(255,255,255,0.88), rgba(249,245,255,0.92));
            box-shadow: 0 24px 62px rgba(76, 29, 149, 0.10);
        }

        .section-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(168, 85, 247, 0.08), transparent 26%),
                radial-gradient(circle at bottom left, rgba(124, 58, 237, 0.06), transparent 22%);
            pointer-events: none;
        }

        .premium-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.32s ease, border-color 0.32s ease;
        }

        .premium-card:hover {
            transform: translateY(-8px);
            border-color: rgba(168, 85, 247, 0.28);
            box-shadow: 0 28px 72px rgba(88, 28, 135, 0.16);
        }

        .premium-card::after {
            content: "";
            position: absolute;
            inset: auto -12% 72% auto;
            width: 9rem;
            height: 9rem;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.16), transparent 70%);
            pointer-events: none;
        }

        .soft-strip {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.08), rgba(168, 85, 247, 0.04)), rgba(255,255,255,0.72);
        }

        .cta-button {
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            filter: brightness(1.03);
            box-shadow: 0 18px 44px rgba(124, 58, 237, 0.24);
        }

        .cta-button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.22) 50%, transparent 100%);
            transform: translateX(-140%) skewX(-18deg);
        }

        .cta-button:hover::after {
            animation: shimmer 0.7s ease forwards;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-1 { transition-delay: 0.08s; }
        .stagger-2 { transition-delay: 0.16s; }
        .stagger-3 { transition-delay: 0.24s; }
        .stagger-4 { transition-delay: 0.32s; }

        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #7c3aed, #a855f7, #d8b4fe);
            transition: width 0.08s linear;
        }

        @keyframes shimmer {
            0% { transform: translateX(-140%) skewX(-18deg); }
            100% { transform: translateX(220%) skewX(-18deg); }
        }

        @keyframes float-aurora {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(24px, -18px, 0); }
        }

        @media (max-width: 1024px) {
            .hero-visual {
                min-height: auto;
            }

            .hero-float-card,
            .hero-metric-row {
                position: static;
                width: 100%;
            }

            .hero-visual {
                display: grid;
                gap: 0.9rem;
            }

            .hero-showcase {
                min-height: 16rem;
            }

            .hero-center-copy {
                right: 1rem;
                width: 10rem;
            }

            .hero-ring-lg {
                right: 0.4rem;
                width: 12rem;
                height: 12rem;
            }

            .hero-ring-md {
                right: 2.3rem;
                width: 8rem;
                height: 8rem;
            }
        }
    </style>
</head>
<body class="marketing-shell font-body text-on-surface antialiased selection:bg-primary/20 {{ $bodyClass }}">
    <div id="scroll-progress"></div>
    <div class="page-aurora"></div>

    <div class="page-shell">
        <x-home.navbar />
        <main class="overflow-x-hidden pt-16">
            {{ $slot }}
        </main>
        <x-home.footer />
        <x-shared.back-to-top />
    </div>

    @guest
        <div id="marketingAuthGate" class="fixed inset-0 z-[90] hidden items-center justify-center bg-[rgba(10,6,22,0.64)] px-4 backdrop-blur-md">
            <div class="w-full max-w-lg overflow-hidden rounded-[2rem] border border-white/20 bg-[linear-gradient(180deg,rgba(255,255,255,0.98),rgba(248,243,255,0.96))] p-6 shadow-[0_30px_90px_rgba(12,18,32,0.32)] sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary">Login Required</p>
                        <h3 id="marketingAuthGateTitle" class="mt-2 font-headline text-3xl font-extrabold text-on-surface">Login or create an account</h3>
                        <p id="marketingAuthGateCopy" class="mt-3 text-sm leading-7 text-on-surface-variant">Sign in first to continue to the detailed training program or roadmap page.</p>
                    </div>
                    <button type="button" id="marketingAuthGateClose" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-surface-soft text-on-surface-variant">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <a id="marketingAuthGateLogin" href="{{ route('login') }}" class="cta-button inline-flex items-center justify-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#6d28d9_0%,#8b5cf6_56%,#c084fc_100%)] px-5 py-3.5 text-sm font-bold text-white">
                        Login
                        <span class="material-symbols-outlined text-[16px]">login</span>
                    </a>
                    <a id="marketingAuthGateSignup" href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-outline/70 bg-white px-5 py-3.5 text-sm font-bold text-on-surface">
                        Sign Up
                        <span class="material-symbols-outlined text-[16px]">person_add</span>
                    </a>
                </div>
            </div>
        </div>
    @endguest

    <script>
        // window.marketingAuthGateConfig = @json([
        //     'enabled' => auth()->guest(),
        //     'loginUrl' => route('login'),
        //     'registerUrl' => route('register'),
        // ]);

        (function () {
            var progressBar = document.getElementById('scroll-progress');
            window.addEventListener('scroll', function () {
                var doc = document.documentElement;
                var total = doc.scrollHeight - doc.clientHeight;
                var value = total > 0 ? (doc.scrollTop / total) * 100 : 0;
                if (progressBar) progressBar.style.width = value + '%';
            }, { passive: true });

            var revealEls = document.querySelectorAll('.reveal');
            if (revealEls.length && 'IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

                revealEls.forEach(function (el) {
                    observer.observe(el);
                });
            } else {
                revealEls.forEach(function (el) {
                    el.classList.add('visible');
                });
            }

            var navbar = document.querySelector('nav');
            window.addEventListener('scroll', function () {
                if (!navbar) return;
                navbar.classList.toggle('nav-scrolled', window.scrollY > 60);
            }, { passive: true });
        })();

        (function () {
            var config = window.marketingAuthGateConfig || {};

            if (!config.enabled) {
                return;
            }

            var authGate = document.getElementById('marketingAuthGate');
            if (!authGate) return;

            var title = document.getElementById('marketingAuthGateTitle');
            var copy = document.getElementById('marketingAuthGateCopy');
            var loginLink = document.getElementById('marketingAuthGateLogin');
            var signupLink = document.getElementById('marketingAuthGateSignup');
            var closeButton = document.getElementById('marketingAuthGateClose');

            function closeGate() {
                authGate.classList.add('hidden');
                authGate.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }

            function openGate(target) {
                var redirectTo = target.getAttribute('data-auth-redirect') || window.location.pathname + window.location.search;
                var gateTitle = target.getAttribute('data-auth-title') || 'Login or create an account';
                var gateCopy = target.getAttribute('data-auth-copy') || 'Sign in first to continue to the detailed training program or roadmap page.';

                title.textContent = gateTitle;
                copy.textContent = gateCopy;
                loginLink.href = config.loginUrl + '?redirect_to=' + encodeURIComponent(redirectTo);
                signupLink.href = config.registerUrl + '?redirect_to=' + encodeURIComponent(redirectTo);

                authGate.classList.remove('hidden');
                authGate.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            document.querySelectorAll('[data-auth-required]').forEach(function (trigger) {
                trigger.addEventListener('click', function (event) {
                    event.preventDefault();
                    openGate(trigger);
                });
            });

            closeButton.addEventListener('click', closeGate);
            authGate.addEventListener('click', function (event) {
                if (event.target === authGate) {
                    closeGate();
                }
            });
        })();
    </script>

    <style>
        nav.nav-scrolled {
            backdrop-filter: blur(22px) !important;
            box-shadow: 0 14px 34px rgba(10, 3, 26, 0.16);
        }
    </style>

    {{ $scripts ?? '' }}
</body>
</html>
