@props([
    'title' => 'CodeInYourself | Student',
    'bodyClass' => '',
])

<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#6f4ef6",
                        "primary-light": "#9d7eff",
                        "primary-container": "#c9bcff",
                        "primary-fixed": "#ede8ff",
                        "primary-fixed-dim": "#d8ceff",
                        surface: "#f6f3ff",
                        background: "#f6f3ff",
                        "surface-bright": "#ffffff",
                        "surface-dim": "#ebe6ff",
                        "surface-container": "#f1edff",
                        "surface-container-low": "#f6f1ff",
                        "surface-container-high": "#ebe6ff",
                        "surface-container-highest": "#ddd4ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-variant": "#ece6ff",
                        "on-surface": "#17142a",
                        "on-surface-variant": "#655d81",
                        outline: "#b8addc",
                        "outline-variant": "#d9cff3",
                        secondary: "#a855f7",
                        "secondary-fixed": "#f4e8ff",
                        "secondary-fixed-dim": "#e8ccff",
                        "on-secondary-fixed": "#5f248b",
                        "on-secondary-fixed-variant": "#874ab4",
                        tertiary: "#0f766e",
                        "tertiary-fixed": "#d8fbf5",
                        "tertiary-fixed-dim": "#9ee9dc",
                        "on-tertiary-fixed": "#11413d",
                        "on-tertiary-fixed-variant": "#11615c",
                        error: "#c43d4a",
                        "error-container": "#ffe2e5",
                        "on-error-container": "#8f1024",
                        "on-primary": "#ffffff",
                        "on-background": "#17142a",
                    },
                    fontFamily: {
                        headline: ["Space Grotesk", "ui-sans-serif", "system-ui", "sans-serif"],
                        body: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                        label: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                    },
                    boxShadow: {
                        soft: "0 18px 50px rgba(81, 46, 182, 0.10)",
                        card: "0 22px 70px rgba(53, 31, 128, 0.12)",
                        glow: "0 28px 90px rgba(111, 78, 246, 0.18)",
                    },
                    borderRadius: {
                        "4xl": "2rem",
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
            scrollbar-color: rgba(111, 78, 246, 0.76) rgba(237, 232, 255, 0.94);
        }

        html::-webkit-scrollbar,
        body.student-shell::-webkit-scrollbar {
            width: 12px;
        }

        html::-webkit-scrollbar-track,
        body.student-shell::-webkit-scrollbar-track {
            background:
                linear-gradient(180deg, rgba(250, 247, 255, 0.98), rgba(232, 225, 252, 0.96));
            border-left: 1px solid rgba(206, 196, 240, 0.72);
        }

        html::-webkit-scrollbar-thumb,
        body.student-shell::-webkit-scrollbar-thumb {
            background:
                linear-gradient(180deg, rgba(111, 78, 246, 0.90), rgba(168, 85, 247, 0.86));
            border: 2px solid rgba(248, 244, 255, 0.96);
            border-radius: 9999px;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.26),
                0 6px 16px rgba(53, 31, 128, 0.16);
        }

        html::-webkit-scrollbar-thumb:hover,
        body.student-shell::-webkit-scrollbar-thumb:hover {
            background:
                linear-gradient(180deg, rgba(91, 58, 226, 0.94), rgba(145, 77, 236, 0.9));
        }

        body.student-shell {
            min-height: 100vh;
            background:
                radial-gradient(circle at 0% 0%, rgba(111, 78, 246, 0.16), transparent 22%),
                radial-gradient(circle at 100% 0%, rgba(157, 126, 255, 0.14), transparent 20%),
                radial-gradient(circle at 50% 100%, rgba(97, 67, 228, 0.10), transparent 26%),
                linear-gradient(180deg, #fcfbff 0%, #f7f3ff 38%, #f1ebff 100%);
            color: #18142b;
            scrollbar-width: thin;
            scrollbar-color: rgba(111, 78, 246, 0.76) rgba(237, 232, 255, 0.94);
        }

        .student-aurora {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .student-aurora::before,
        .student-aurora::after {
            content: "";
            position: absolute;
            border-radius: 9999px;
            filter: blur(54px);
            opacity: 0.28;
            animation: student-float 24s ease-in-out infinite alternate;
        }

        .student-aurora::before {
            top: -3rem;
            left: -5rem;
            width: 20rem;
            height: 20rem;
            background: radial-gradient(circle, rgba(111, 78, 246, 0.18), rgba(111, 78, 246, 0));
        }

        .student-aurora::after {
            right: -4rem;
            top: 16rem;
            width: 18rem;
            height: 18rem;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.15), rgba(168, 85, 247, 0));
            animation-duration: 24s;
        }

        .student-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image: radial-gradient(rgba(122, 102, 190, 0.10) 0.8px, transparent 0.8px);
            background-size: 22px 22px;
            mask-image: radial-gradient(circle at center, black 24%, transparent 85%);
            opacity: 0.2;
        }

        .student-page-shell {
            position: relative;
            z-index: 1;
        }

        .student-page-shell::before,
        .student-page-shell::after {
            content: "";
            position: fixed;
            z-index: 0;
            pointer-events: none;
            border-radius: 9999px;
            filter: blur(70px);
            opacity: 0.18;
            animation: student-pan 20s ease-in-out infinite alternate;
        }

        .student-page-shell::before {
            top: 12rem;
            right: 10%;
            width: 18rem;
            height: 18rem;
            background: radial-gradient(circle, rgba(111, 78, 246, 0.55), rgba(111, 78, 246, 0));
        }

        .student-page-shell::after {
            left: 16%;
            bottom: 10%;
            width: 15rem;
            height: 15rem;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.48), rgba(168, 85, 247, 0));
            animation-duration: 24s;
        }

        .student-shell-main {
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        body.student-shell header.fixed {
            border-bottom: 1px solid rgba(229, 223, 246, 0.92);
            background: rgba(252, 250, 255, 0.76);
            box-shadow: 0 10px 26px rgba(39, 26, 89, 0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        body.student-shell main {
            position: relative;
            z-index: 1;
        }

        body.student-shell main > * {
            animation: student-rise 720ms cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        body.student-shell main > *:nth-child(2) { animation-delay: 90ms; }
        body.student-shell main > *:nth-child(3) { animation-delay: 160ms; }
        body.student-shell main > *:nth-child(4) { animation-delay: 220ms; }

        body.student-shell .shadow-sm,
        body.student-shell .shadow-lg,
        body.student-shell .shadow-xl,
        body.student-shell .shadow-2xl {
            box-shadow: 0 10px 28px rgba(40, 24, 94, 0.06);
        }

        body.student-shell [class*="bg-surface-container-lowest"] {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(231, 226, 246, 0.96);
            background: rgba(255,255,255,0.82);
        }

        body.student-shell [class*="bg-surface-container-lowest"]::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border-top: 1px solid rgba(255,255,255,0.82);
            pointer-events: none;
        }

        body.student-shell article,
        body.student-shell section > div[class*="rounded"],
        body.student-shell aside > div[class*="rounded"] {
            transition: transform 240ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 240ms cubic-bezier(0.22, 1, 0.36, 1), border-color 220ms ease, background-color 220ms ease;
        }

        body.student-shell a,
        body.student-shell button {
            transition: transform 220ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 220ms cubic-bezier(0.22, 1, 0.36, 1), background-color 180ms ease, border-color 180ms ease, color 180ms ease, opacity 180ms ease;
        }

        body.student-shell article:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(40, 24, 94, 0.08);
        }

        body.student-shell table {
            border-collapse: separate;
            border-spacing: 0;
        }

        body.student-shell tbody tr {
            transition: background-color 220ms ease, transform 220ms ease;
        }

        body.student-shell tbody tr:hover {
            background: rgba(245, 241, 255, 0.84);
        }

        body.student-shell input,
        body.student-shell select,
        body.student-shell textarea {
            transition: box-shadow 180ms ease, border-color 180ms ease, background-color 180ms ease, transform 180ms ease;
        }

        body.student-shell input:focus,
        body.student-shell select:focus,
        body.student-shell textarea:focus {
            box-shadow: 0 0 0 4px rgba(111, 78, 246, 0.08) !important;
        }

        body.student-shell .js-progress-fill {
            position: relative;
            overflow: hidden;
        }

        body.student-shell .js-progress-fill::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.26), transparent);
            transform: translateX(-100%);
            animation: student-progress-shimmer 2.6s ease-in-out infinite;
        }

        body.student-shell .fixed.bottom-8,
        body.student-shell .fixed.bottom-10 {
            border-radius: 1.25rem;
            border: 1px solid rgba(217, 207, 243, 0.8);
            box-shadow: 0 18px 44px rgba(53, 31, 128, 0.10);
        }

        body.student-shell .rounded-full.bg-primary,
        body.student-shell a.bg-primary,
        body.student-shell button.bg-primary {
            box-shadow: 0 12px 28px rgba(111, 78, 246, 0.14);
        }

        body.student-shell .ring-slate-200\/70,
        body.student-shell .border-slate-200,
        body.student-shell .border-slate-200\/70,
        body.student-shell .border-slate-100 {
            border-color: rgba(217, 207, 243, 0.78) !important;
        }

        body.student-shell .bg-white\/80,
        body.student-shell .bg-white\/85,
        body.student-shell .bg-white\/90 {
            background-color: rgba(255, 255, 255, 0.82) !important;
        }

        .student-eyebrow {
            font-size: 0.64rem;
            font-weight: 800;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #7862c7;
        }

        .student-chip {
            border: 1px solid rgba(226, 220, 244, 0.98);
            background: rgba(255,255,255,0.7);
            padding: 0.48rem 0.8rem;
            border-radius: 0.9rem;
            box-shadow: none;
            font-size: 0.74rem;
            font-weight: 700;
            color: #514889;
        }

        .student-side-card {
            border: 1px solid rgba(231, 226, 246, 0.98);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.9), rgba(251,248,255,0.76)),
                radial-gradient(circle at top right, rgba(111, 78, 246, 0.10), transparent 34%);
            border-radius: 1.1rem;
            padding: 1rem;
            color: #17142a;
            box-shadow: 0 10px 24px rgba(40, 24, 94, 0.05);
            position: relative;
        }

        .student-side-card::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(111, 78, 246, 0.24), rgba(168, 85, 247, 0.06), rgba(255,255,255,0.18));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .student-intro {
            position: relative;
            display: grid;
            gap: 1rem;
            border-radius: 1.5rem;
            padding: 1.25rem;
        }

        .student-intro::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(145deg, rgba(255,255,255,0.98), rgba(248,244,255,0.94));
            border: 1px solid rgba(226, 218, 245, 0.96);
            box-shadow: 0 14px 36px rgba(53, 31, 128, 0.07);
            z-index: 0;
        }

        .student-intro > * {
            position: relative;
            z-index: 1;
        }

        .student-intro-grid {
            display: grid;
            gap: 0.85rem;
        }

        .student-intro-card {
            border-radius: 1.2rem;
            border: 1px solid rgba(226, 218, 245, 0.96);
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(246,241,255,0.9));
            padding: 1rem;
            box-shadow: 0 10px 28px rgba(53, 31, 128, 0.05);
        }

        .student-accent-line {
            height: 0.2rem;
            width: 3rem;
            border-radius: 9999px;
            background: linear-gradient(90deg, #6f4ef6, #a855f7);
            box-shadow: 0 6px 18px rgba(111, 78, 246, 0.14);
        }

        .student-floating-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(8px);
            opacity: 0.7;
            animation: student-float-orb 8s ease-in-out infinite alternate;
            pointer-events: none;
        }

        .student-top-search {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border: 1px solid rgba(232, 226, 247, 0.98);
            background: rgba(255,255,255,0.72);
            padding: 0.58rem 0.82rem;
            border-radius: 0.95rem;
        }

        .student-top-search input,
        .student-top-search select,
        .student-top-search textarea {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            box-shadow: none;
        }

        .student-pill-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.95rem;
            padding: 0.74rem 1rem;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .student-pill-button--primary {
            background: linear-gradient(135deg, #6f4ef6, #d16bf2);
            color: white;
            box-shadow: 0 14px 28px rgba(149, 85, 246, 0.22);
        }

        .student-pill-button--ghost {
            background: rgba(255, 255, 255, 0.72);
            color: #6b33b8;
            border: 1px solid rgba(231, 226, 246, 0.98);
        }

        .student-pill-button:hover {
            transform: translateY(-2px);
        }

        .student-chip:hover {
            transform: translateY(-1px);
            border-color: rgba(111, 78, 246, 0.28);
        }

        .student-page {
            margin-left: 0;
            padding: 6rem 1rem 3rem;
        }

        .student-page-inner {
            margin: 0 auto;
            max-width: 92rem;
        }

        .student-page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .student-page-title {
            font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
            font-size: clamp(1.35rem, 1rem + 1vw, 1.9rem);
            font-weight: 700;
            letter-spacing: -0.05em;
            color: #18142b;
        }

        .student-page-copy {
            max-width: 42rem;
            margin-top: 0.45rem;
            font-size: 0.9rem;
            line-height: 1.75;
            color: #655d81;
        }

        .student-page-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .student-section {
            border: 1px solid rgba(231, 226, 246, 0.98);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.88), rgba(251,247,255,0.78)),
                radial-gradient(circle at top left, rgba(111, 78, 246, 0.08), transparent 26%);
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: 0 8px 20px rgba(40, 24, 94, 0.05);
            position: relative;
            overflow: hidden;
        }

        .student-section::after {
            content: "";
            position: absolute;
            inset: auto 1rem 0.85rem auto;
            width: 4rem;
            height: 4rem;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(111, 78, 246, 0.12), rgba(111, 78, 246, 0));
            pointer-events: none;
        }

        .student-stats-strip {
            display: grid;
            gap: 0.75rem;
            grid-template-columns: repeat(auto-fit, minmax(165px, 1fr));
        }

        .student-stat {
            border: 1px solid rgba(233, 228, 247, 0.98);
            border-radius: 0.95rem;
            background: rgba(249, 247, 255, 0.88);
            padding: 0.9rem 0.95rem;
        }

        .student-stat-label {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #7862c7;
        }

        .student-stat-value {
            margin-top: 0.45rem;
            font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.05em;
            color: #18142b;
        }

        .student-stat-copy {
            margin-top: 0.25rem;
            font-size: 0.78rem;
            color: #6e6788;
        }

        .student-compact-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .student-compact-tab {
            border-radius: 9999px;
            padding: 0.62rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 700;
            transition: all 180ms ease;
        }

        @media (min-width: 768px) {
            .student-page {
                margin-left: 15.5rem;
                padding: 6.25rem 1.5rem 3rem;
            }
        }

        @media (min-width: 1280px) {
            .student-page {
                padding-right: 2rem;
            }
        }

        @media (max-width: 1023px) {
            .student-page-inner {
                max-width: 100%;
            }
        }

        @media (max-width: 767px) {
            .student-shell-main {
                padding-bottom: 5.5rem;
            }

            .student-page {
                padding: 5.75rem 0.95rem 2.5rem;
            }

            .student-page-header {
                margin-bottom: 1.25rem;
            }

            .student-page-copy {
                font-size: 0.84rem;
                line-height: 1.65;
            }

            .student-page-meta {
                width: 100%;
            }

            .student-page-meta > * {
                flex: 1 1 100%;
                justify-content: center;
                text-align: center;
            }

            .student-section,
            .student-side-card,
            .student-intro,
            .student-intro-card {
                padding: 0.9rem;
                border-radius: 1rem;
            }

            .student-stats-strip {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        @keyframes student-float {
            0% { transform: translate3d(0, 0, 0) scale(1); }
            100% { transform: translate3d(2rem, -1rem, 0) scale(1.08); }
        }

        @keyframes student-pan {
            0% { transform: translate3d(0, 0, 0) scale(1); }
            100% { transform: translate3d(1.5rem, -1rem, 0) scale(1.08); }
        }

        @keyframes student-rise {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes student-float-orb {
            from { transform: translate3d(0, 0, 0) scale(1); }
            to { transform: translate3d(0, -10px, 0) scale(1.04); }
        }

        @keyframes student-progress-shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(220%); }
        }
    </style>
</head>
<body class="student-shell font-body antialiased selection:bg-primary-fixed selection:text-on-surface {{ $bodyClass }}">
    <div class="student-aurora"></div>
    <div class="student-grid"></div>
    <div class="student-page-shell">
        <x-student.navbar />
        {{ $slot }}
        <x-shared.back-to-top />
    </div>
</body>
</html>
