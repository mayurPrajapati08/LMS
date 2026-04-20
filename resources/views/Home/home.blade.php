<!DOCTYPE html>
<html class="scroll-smooth" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeInYourself — Build Real Skills for the AI Industry</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":          "#7c3aed",
                        "primary-light":    "#a855f7",
                        "primary-dark":     "#5b21b6",
                        "on-primary":       "#ffffff",
                        "primary-surface":  "#f5f0ff",
                        "primary-muted":    "#ede9fe",
                        "secondary":        "#7e6daf",
                        "on-surface":       "#1a1a2e",
                        "on-surface-variant":"#6b5b8a",
                        "surface":          "#fcf9ff",
                        "surface-soft":     "#f5f0ff",
                        "surface-strong":   "#ede9fe",
                        "background":       "#fcf9ff",
                        "outline":          "#d4c5f0",
                        "accent":           "#a855f7",
                    },
                    fontFamily: {
                        "headline": ["Space Grotesk", "ui-sans-serif", "system-ui", "sans-serif"],
                        "body":     ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                    },
                    boxShadow: {
                        "hero":  "0 32px 90px rgba(124,58,237,0.28)",
                        "soft":  "0 18px 40px rgba(124,58,237,0.12)",
                        "glow":  "0 0 40px rgba(168,85,247,0.4)",
                        "card":  "0 16px 48px rgba(124,58,237,0.18)",
                    },
                    borderRadius: {
                        "4xl": "2rem",
                        "5xl": "2.5rem",
                    }
                },
            },
        }
    </script>

    <style>
        /* ── Base ─────────────────────────────────── */
        * { box-sizing: border-box; }

        html {
            scrollbar-gutter: stable;
            scrollbar-width: thin;
            scrollbar-color: rgba(109, 40, 217, 0.72) rgba(243, 232, 255, 0.9);
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            width: 12px;
        }

        html::-webkit-scrollbar-track,
        body::-webkit-scrollbar-track {
            background:
                linear-gradient(180deg, rgba(250, 245, 255, 0.98), rgba(238, 228, 252, 0.98));
            border-left: 1px solid rgba(220, 205, 246, 0.72);
        }

        html::-webkit-scrollbar-thumb,
        body::-webkit-scrollbar-thumb {
            background:
                linear-gradient(180deg, rgba(91, 33, 182, 0.88), rgba(139, 92, 246, 0.88));
            border: 2px solid rgba(248, 242, 255, 0.95);
            border-radius: 9999px;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.28),
                0 6px 16px rgba(76, 29, 149, 0.18);
        }

        html::-webkit-scrollbar-thumb:hover,
        body::-webkit-scrollbar-thumb:hover {
            background:
                linear-gradient(180deg, rgba(76, 29, 149, 0.94), rgba(124, 58, 237, 0.94));
        }

        body {
            scrollbar-width: thin;
            scrollbar-color: rgba(109, 40, 217, 0.72) rgba(243, 232, 255, 0.9);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        /* ── Aurora / Mesh backgrounds ────────────── */
        .aurora-hero {
            background:
                radial-gradient(ellipse 90% 70% at 15% 5%,  rgba(124,58,237,0.55) 0%, transparent 55%),
                radial-gradient(ellipse 70% 90% at 85% 95%, rgba(168,85,247,0.40) 0%, transparent 55%),
                radial-gradient(ellipse 60% 60% at 60% 30%, rgba(109,40,217,0.30) 0%, transparent 50%),
                linear-gradient(135deg, #0e0622 0%, #2d0f55 38%, #4c1d95 70%, #5b21b6 100%);
            animation: aurora-shift 14s ease-in-out infinite alternate;
            background-size: 300% 300%;
        }

        .aurora-careers {
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%,  rgba(124,58,237,0.45) 0%, transparent 55%),
                radial-gradient(ellipse 60% 70% at 90% 80%,  rgba(168,85,247,0.35) 0%, transparent 50%),
                linear-gradient(145deg, #0e0622 0%, #2a0d4e 50%, #3b1278 100%);
        }

        .aurora-cta {
            background:
                radial-gradient(ellipse 80% 80% at 50% 0%,   rgba(168,85,247,0.40) 0%, transparent 60%),
                linear-gradient(160deg, #3b1278 0%, #5b21b6 50%, #7c3aed 100%);
        }

        @keyframes aurora-shift {
            0%   { background-position: 0% 0%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 30% 100%; }
        }

        /* ── Stars / Particle background ──────────── */
        .stars-bg {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .stars-bg::before,
        .stars-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 15% 20%, rgba(255,255,255,0.9) 0%, transparent 100%),
                radial-gradient(1px 1px at 35% 8%,  rgba(255,255,255,0.7) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 55% 35%, rgba(255,255,255,0.8) 0%, transparent 100%),
                radial-gradient(1px 1px at 72% 15%, rgba(255,255,255,0.6) 0%, transparent 100%),
                radial-gradient(1px 1px at 88% 42%, rgba(255,255,255,0.7) 0%, transparent 100%),
                radial-gradient(1px 1px at 8%  60%, rgba(255,255,255,0.5) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 27% 75%, rgba(255,255,255,0.6) 0%, transparent 100%),
                radial-gradient(1px 1px at 48% 80%, rgba(255,255,255,0.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 65% 68%, rgba(255,255,255,0.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 92% 82%, rgba(255,255,255,0.6) 0%, transparent 100%),
                radial-gradient(2px 2px at 40% 45%, rgba(196,130,255,0.8) 0%, transparent 100%),
                radial-gradient(2px 2px at 78% 28%, rgba(196,130,255,0.6) 0%, transparent 100%);
            background-size: 100% 100%;
        }

        .stars-bg::after {
            background-image:
                radial-gradient(1px 1px at 22% 12%, rgba(255,255,255,0.6) 0%, transparent 100%),
                radial-gradient(1px 1px at 44% 55%, rgba(255,255,255,0.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 60% 90%, rgba(255,255,255,0.5) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 82% 5%,  rgba(255,255,255,0.7) 0%, transparent 100%),
                radial-gradient(1px 1px at 5%  88%, rgba(255,255,255,0.5) 0%, transparent 100%),
                radial-gradient(2px 2px at 18% 48%, rgba(196,130,255,0.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 70% 55%, rgba(255,255,255,0.4) 0%, transparent 100%);
            animation: stars-twinkle 5s ease-in-out infinite alternate;
        }

        @keyframes stars-twinkle {
            0%   { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* ── Floating ─────────────────────────────── */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-14px); }
        }

        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-8px) rotate(0.8deg); }
        }

        .animate-float        { animation: float 5s ease-in-out infinite; }
        .animate-float-slow   { animation: float-gentle 7s ease-in-out infinite; }
        .animate-float-delay  { animation: float 5.5s ease-in-out 1.2s infinite; }

        /* ── Pulse glow ───────────────────────────── */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 24px rgba(168,85,247,0.3); }
            50%       { box-shadow: 0 0 56px rgba(168,85,247,0.65), 0 0 90px rgba(124,58,237,0.25); }
        }

        .animate-pulse-glow { animation: pulse-glow 3.5s ease-in-out infinite; }

        /* ── Shimmer ──────────────────────────────── */
        @keyframes shimmer {
            0%   { transform: translateX(-100%) skewX(-12deg); }
            100% { transform: translateX(300%)  skewX(-12deg); }
        }

        .btn-shimmer {
            position: relative;
            overflow: hidden;
        }

        .btn-shimmer::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.2) 50%, transparent 100%);
            transform: translateX(-100%) skewX(-12deg);
        }

        .btn-shimmer:hover::after {
            animation: shimmer 0.65s ease forwards;
        }

        /* ── Reveal on scroll ─────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16,1,0.3,1), transform 0.7s cubic-bezier(0.16,1,0.3,1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left  { opacity: 0; transform: translateX(-30px); transition: opacity 0.7s cubic-bezier(0.16,1,0.3,1), transform 0.7s cubic-bezier(0.16,1,0.3,1); }
        .reveal-right { opacity: 0; transform: translateX(30px);  transition: opacity 0.7s cubic-bezier(0.16,1,0.3,1), transform 0.7s cubic-bezier(0.16,1,0.3,1); }
        .reveal-left.visible, .reveal-right.visible { opacity: 1; transform: translateX(0); }

        .stagger-1 { transition-delay: 0.10s; }
        .stagger-2 { transition-delay: 0.20s; }
        .stagger-3 { transition-delay: 0.30s; }
        .stagger-4 { transition-delay: 0.40s; }
        .stagger-5 { transition-delay: 0.50s; }

        /* ── Glass cards ──────────────────────────── */
        .glass-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.13);
        }

        .glass-card-light {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(212,197,240,0.5);
            box-shadow: 0 18px 40px rgba(124,58,237,0.10);
        }

        .owner-showcase-card {
            background:
                radial-gradient(circle at top left, rgba(255,255,255,0.14), transparent 38%),
                linear-gradient(160deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04)),
                linear-gradient(135deg, rgba(124,58,237,0.14), rgba(168,85,247,0.06));
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(18px);
            box-shadow:
                0 22px 56px rgba(76,29,149,0.18),
                inset 0 1px 0 rgba(255,255,255,0.08);
        }

        .owner-showcase-card::before {
            content: "";
            position: absolute;
            inset: 0.85rem;
            border-radius: 1.9rem;
            border: 1px solid rgba(255,255,255,0.10);
            pointer-events: none;
        }

        .owner-photo-frame {
            position: relative;
            min-height: 27.5rem;
            overflow: hidden;
            border-radius: 2rem;
            background:
                radial-gradient(circle at top, rgba(255,255,255,0.16), transparent 46%),
                linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.01));
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.18),
                0 14px 36px rgba(37, 12, 86, 0.16);
        }

        .owner-photo-frame::after {
            content: "";
            position: absolute;
            inset: auto -14% -16% auto;
            width: 9rem;
            height: 9rem;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(244,114,182,0.12), transparent 68%);
            filter: blur(16px);
            pointer-events: none;
            z-index: 1;
        }

        .owner-photo-frame::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.10), transparent 22%, transparent 72%, rgba(13,4,28,0.20) 100%),
                radial-gradient(circle at 22% 18%, rgba(255,255,255,0.10), transparent 24%);
            pointer-events: none;
            z-index: 1;
        }

        .owner-photo-frame img,
        .owner-photo-frame video {
            position: relative;
            z-index: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            object-position: center 12%;
        }

        .owner-photo-frame img {
            transform: scale(1.16);
        }

        .owner-badge {
            position: absolute;
            left: 1.1rem;
            top: 1.1rem;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(18, 8, 35, 0.34);
            padding: 0.55rem 0.8rem;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 24px rgba(37, 12, 86, 0.12);
        }

        .owner-badge-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #f472b6, #c084fc);
            box-shadow: 0 0 18px rgba(244,114,182,0.6);
        }

        .owner-stat-chip {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(218,200,242,0.55);
            box-shadow: 0 20px 45px rgba(76,29,149,0.18);
        }

        .owner-info-card {
            border-radius: 1.5rem;
            border: 1px solid rgba(255,255,255,0.14);
            background: linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.06));
            padding: 1rem 1.05rem;
            box-shadow: 0 14px 32px rgba(37, 12, 86, 0.12);
            backdrop-filter: blur(12px);
        }

        .custom-player {
            position: relative;
            overflow: hidden;
            border-radius: 1.75rem;
            border: 1px solid rgba(255,255,255,0.14);
            background:
                linear-gradient(180deg, rgba(11, 6, 24, 0.42), rgba(11, 6, 24, 0.08));
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.10),
                0 18px 42px rgba(9, 4, 22, 0.28);
            isolation: isolate;
        }

        .custom-player-stage {
            position: relative;
            aspect-ratio: 4 / 5;
            background: #12081f;
        }

        .custom-player-stage.is-wide {
            aspect-ratio: 16 / 9;
        }

        .custom-player-stage video {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            background: #12081f;
        }

        .custom-player-stage::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(7, 4, 16, 0.08) 0%, rgba(7, 4, 16, 0.14) 44%, rgba(7, 4, 16, 0.85) 100%),
                linear-gradient(120deg, rgba(255,255,255,0.14), transparent 32%);
            pointer-events: none;
            z-index: 1;
        }

        .custom-player-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .custom-player-overlay-btn {
            pointer-events: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 4.4rem;
            height: 4.4rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.12);
            color: #fff;
            backdrop-filter: blur(16px);
            box-shadow: 0 18px 42px rgba(0,0,0,0.24);
            transition: transform 0.3s ease, background 0.3s ease, opacity 0.3s ease;
        }

        .custom-player:hover .custom-player-overlay-btn {
            transform: scale(1.05);
            background: rgba(255,255,255,0.16);
        }

        .custom-player.is-playing .custom-player-overlay-btn {
            opacity: 0;
        }

        .custom-player-meta {
            position: absolute;
            inset: auto 1rem 1rem 1rem;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .custom-player-copy {
            max-width: 34rem;
        }

        .custom-player-controls {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
            border-radius: 1.2rem;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(12, 7, 25, 0.52);
            padding: 0.8rem 0.95rem;
            backdrop-filter: blur(16px);
        }

        .custom-player-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.8rem;
            height: 2.8rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.08);
            color: #fff;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        .custom-player-icon-btn:hover {
            background: rgba(255,255,255,0.16);
            transform: translateY(-1px);
        }

        .custom-player-progress {
            flex: 1 1 10rem;
            height: 0.45rem;
            border-radius: 999px;
            background: rgba(255,255,255,0.14);
            appearance: none;
            outline: none;
            accent-color: #c084fc;
        }

        .custom-player-progress::-webkit-slider-thumb {
            appearance: none;
            width: 1rem;
            height: 1rem;
            border-radius: 999px;
            background: #fff;
            border: 2px solid #c084fc;
            box-shadow: 0 0 0 4px rgba(192,132,252,0.18);
        }

        .custom-player-progress::-moz-range-thumb {
            width: 1rem;
            height: 1rem;
            border-radius: 999px;
            background: #fff;
            border: 2px solid #c084fc;
            box-shadow: 0 0 0 4px rgba(192,132,252,0.18);
        }

        .custom-player-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.08);
            padding: 0.42rem 0.76rem;
            color: rgba(255,255,255,0.84);
        }

        .custom-player-fineprint {
            border-radius: 1rem;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.06);
            padding: 0.85rem 1rem;
            color: rgba(255,255,255,0.74);
            backdrop-filter: blur(14px);
        }

        /* ── Career card ──────────────────────────── */
        .career-card {
            background: linear-gradient(145deg, rgba(124,58,237,0.18), rgba(168,85,247,0.10));
            backdrop-filter: blur(16px);
            border: 1px solid rgba(168,85,247,0.25);
            transition: transform 0.35s cubic-bezier(0.16,1,0.3,1), box-shadow 0.35s cubic-bezier(0.16,1,0.3,1), border-color 0.35s ease;
        }

        .career-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 28px 70px rgba(124,58,237,0.35);
            border-color: rgba(168,85,247,0.5);
        }

        /* ── Course card ──────────────────────────── */
        .course-card {
            background: linear-gradient(160deg, rgba(255,255,255,0.10), rgba(168,85,247,0.08));
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
            transition: transform 0.35s cubic-bezier(0.16,1,0.3,1), box-shadow 0.35s ease;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px rgba(124,58,237,0.30);
        }

        /* ── Mini stat card ───────────────────────── */
        .stat-pill {
            background: rgba(255,255,255,0.95);
            box-shadow: 0 20px 60px rgba(124,58,237,0.14);
        }

        /* ── Why-choose item ──────────────────────── */
        .why-item {
            background: rgba(255,255,255,0.85);
            border: 1px solid rgba(212,197,240,0.5);
            box-shadow: 0 8px 24px rgba(124,58,237,0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }

        .why-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(124,58,237,0.14);
            background: rgba(255,255,255,0.98);
        }

        .promo-banner {
            position: relative;
            overflow: hidden;
            background: #12081f;
        }

        .promo-track {
            display: flex;
            width: 100%;
            align-items: stretch;
            transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            transform: translate3d(0, 0, 0);
            will-change: transform;
        }

        .promo-slide {
            flex: 0 0 100%;
            width: 100%;
            max-width: 100%;
        }

        .promo-surface {
            position: relative;
            overflow: hidden;
            min-height: 11.5rem;
        }

        .promo-meta-pill {
            border: 1px solid rgba(255,255,255,0.16);
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 16px 28px rgba(8, 4, 22, 0.14);
        }

        .promo-surface::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(10, 4, 22, 0.82) 0%, rgba(10, 4, 22, 0.48) 42%, rgba(10, 4, 22, 0.16) 100%),
                radial-gradient(circle at top right, rgba(255,255,255,0.12), transparent 24%);
            pointer-events: none;
            z-index: 1;
        }

        .promo-arrow {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .promo-arrow:hover {
            transform: translateY(-1px);
            background: rgba(255,255,255,0.18);
        }

        .promo-dot {
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 9999px;
            background: rgba(255,255,255,0.28);
            transition: width 0.25s ease, background 0.25s ease;
        }

        .promo-dot.is-active {
            width: 1.9rem;
            background: #ffffff;
        }

        /* ── Button micro-interactions ────────────── */
        .btn-primary {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(124,58,237,0.45);
        }

        .btn-primary:active {
            transform: translateY(0) scale(0.97);
        }

        .btn-outline {
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .btn-outline:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.18);
        }

        .btn-outline:active {
            transform: scale(0.97);
        }

        /* ── Section divider wave ─────────────────── */
        .soft-wave {
            position: absolute;
            inset: auto 0 0 0;
            height: 35%;
            background:
                radial-gradient(65% 120% at 20% 100%, rgba(255,255,255,0.14), transparent 58%),
                radial-gradient(55% 120% at 60% 100%, rgba(255,255,255,0.10), transparent 56%),
                radial-gradient(50% 120% at 90% 100%, rgba(255,255,255,0.12), transparent 58%);
            pointer-events: none;
        }

        /* ── Gradient text ────────────────────────── */
        .text-gradient {
            background: linear-gradient(135deg, #e9d5ff 0%, #c084fc 40%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-gradient-gold {
            background: linear-gradient(135deg, #fde68a, #f59e0b, #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Orbit ring ───────────────────────────── */
        @keyframes orbit {
            to { transform: rotate(360deg); }
        }

        .orbit-ring {
            animation: orbit 12s linear infinite;
        }

        .orbit-ring-reverse {
            animation: orbit 18s linear infinite reverse;
        }

        /* ── Number counter ───────────────────────── */
        .counter-num {
            font-variant-numeric: tabular-nums;
        }

        /* ── Achievement gallery overlay ──────────── */
        .workshop-feature-shell {
            position: relative;
            overflow: hidden;
            border-radius: 2.25rem;
            border: 1px solid rgba(212, 197, 240, 0.58);
            background:
                radial-gradient(circle at top left, rgba(168, 85, 247, 0.14), transparent 28%),
                radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.16), transparent 30%),
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(245,240,255,0.94));
            box-shadow: 0 32px 80px rgba(76, 29, 149, 0.12);
        }

        .workshop-hero-panel {
            position: relative;
            overflow: hidden;
            border-radius: 1.9rem;
            background: linear-gradient(150deg, #150726 0%, #3f1670 54%, #7c3aed 100%);
            color: #fff;
            box-shadow: 0 24px 56px rgba(76, 29, 149, 0.24);
        }

        .workshop-hero-panel::before {
            content: "";
            position: absolute;
            inset: auto auto -18% -8%;
            width: 16rem;
            height: 16rem;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(255,255,255,0.16), transparent 68%);
            filter: blur(10px);
        }

        .workshop-hero-panel::after {
            content: "";
            position: absolute;
            inset: 1rem;
            border-radius: 1.4rem;
            border: 1px solid rgba(255,255,255,0.12);
            pointer-events: none;
        }

        .workshop-meta-chip {
            border-radius: 1.5rem;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.1);
            padding: 0.7rem 0.95rem;
            backdrop-filter: blur(10px);
        }

        .workshop-side-list {
            display: grid;
            gap: 1rem;
        }

        .workshop-side-item {
            border-radius: 1.6rem;
            border: 1px solid rgba(212, 197, 240, 0.5);
            background: rgba(255,255,255,0.8);
            padding: 1.2rem;
            box-shadow: 0 16px 40px rgba(124, 58, 237, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .workshop-side-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 54px rgba(124, 58, 237, 0.14);
        }

        .workshop-highlight-pill {
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.14);
            background: rgba(255,255,255,0.92);
            padding: 0.72rem 1rem;
            font-size: 0.76rem;
            font-weight: 700;
            color: #4c1d95;
            box-shadow: 0 10px 24px rgba(124, 58, 237, 0.08);
        }

        .home-classic-bg {
            background:
                radial-gradient(circle at top left, rgba(190, 160, 255, 0.18), transparent 24%),
                radial-gradient(circle at top right, rgba(255, 214, 153, 0.12), transparent 22%),
                linear-gradient(180deg, #fdf9ff 0%, #f7f1ff 36%, #fffaf3 100%);
        }

        .gallery-grand-shell {
            position: relative;
            overflow: hidden;
            /* border-radius: 2.4rem;
            border: 1px solid rgba(214, 199, 242, 0.72);
            background:
                radial-gradient(circle at 10% 14%, rgba(168, 85, 247, 0.12), transparent 24%),
                radial-gradient(circle at 92% 12%, rgba(245, 158, 11, 0.10), transparent 20%),
                linear-gradient(160deg, rgba(255,255,255,0.96), rgba(249,244,255,0.96) 58%, rgba(255,251,245,0.98));
            box-shadow:
                0 28px 80px rgba(111, 76, 191, 0.12),
                inset 0 1px 0 rgba(255,255,255,0.88); */
        }

        .gallery-grand-shell::before {
            content: "";
            position: absolute;
            inset: 1rem;
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.65);
            pointer-events: none;
        }

        .gallery-hero-stat {
            border-radius: 1.6rem;
            border: 1px solid rgba(218, 205, 244, 0.88);
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(241,234,255,0.82));
            box-shadow: 0 16px 42px rgba(124,58,237,0.08);
        }

        .gallery-category-panel {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            border: 1px solid rgba(212,197,240,0.52);
            background:
                radial-gradient(circle at top center, rgba(168,85,247,0.08), transparent 26%),
                linear-gradient(180deg, rgba(255,255,255,0.94), rgba(248,244,255,0.92));
            box-shadow: 0 24px 60px rgba(124,58,237,0.08);
        }

        .gallery-category-frame {
            position: relative;
            /* border-radius: 1.8rem;
            border: 1px solid rgba(219, 207, 245, 0.78);
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(247,241,255,0.88));
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.72),
                0 18px 40px rgba(124,58,237,0.06); */
        }

        .gallery-collection-head {
            position: relative;
            text-align: center;
        }

        .gallery-collection-kicker {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.14);
            background: rgba(255,255,255,0.92);
            box-shadow: 0 10px 28px rgba(124,58,237,0.08);
        }

        .gallery-collection-meta {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
        }

        .gallery-ribbon {
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.12);
            background: rgba(255,255,255,0.94);
            box-shadow: 0 10px 28px rgba(124,58,237,0.08);
        }

        .gallery-media-stack {
            display: grid;
            gap: 1.6rem;
        }

        .gallery-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            align-items: stretch;
        }

        .gallery-grid-item {
            display: block;
            height: 100%;
        }

        .gallery-image-tile {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 1.55rem;
            border: 1px solid rgba(224, 212, 248, 0.86);
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(245,239,255,0.84));
            padding: 0;
            text-align: left;
            cursor: pointer;
            box-shadow:
                0 18px 42px rgba(124,58,237,0.10),
                inset 0 1px 0 rgba(255,255,255,0.82);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .gallery-image-tile:hover {
            transform: translateY(-8px);
            border-color: rgba(168,85,247,0.34);
            box-shadow:
                0 28px 56px rgba(124,58,237,0.14),
                inset 0 1px 0 rgba(255,255,255,0.88);
        }

        .gallery-image-frame {
            position: relative;
            aspect-ratio: 5 / 4;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(240,233,255,0.86), rgba(255,250,245,0.72));
        }

        .gallery-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), filter 0.35s ease;
        }

        .gallery-image-tile:hover .gallery-image-frame img {
            transform: scale(1.08);
            filter: saturate(1.04) contrast(1.02);
        }

        .gallery-image-frame::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(18,8,35,0.06)),
                linear-gradient(135deg, rgba(255,255,255,0.26), transparent 34%);
            pointer-events: none;
        }

        .gallery-image-caption {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 5.75rem;
            padding: 1rem 1.05rem 1.05rem;
        }

        .gallery-image-copy {
            min-width: 0;
            flex: 1 1 auto;
        }

        .gallery-image-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .gallery-image-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.6rem;
            height: 2.6rem;
            flex-shrink: 0;
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.12);
            background: linear-gradient(180deg, rgba(255,255,255,0.94), rgba(241,234,255,0.88));
            color: #7c3aed;
            box-shadow: 0 10px 24px rgba(124,58,237,0.10);
        }

        @media (max-width: 767px) {
            .gallery-image-caption {
                min-height: 5.25rem;
                padding: 0.9rem;
            }

            .gallery-image-icon {
                width: 2.35rem;
                height: 2.35rem;
            }
        }

        .gallery-video-showcase {
            overflow: hidden;
            border-radius: 1.9rem;
            border: 1px solid rgba(216, 204, 244, 0.84);
            background:
                radial-gradient(circle at top left, rgba(168,85,247,0.10), transparent 24%),
                radial-gradient(circle at bottom right, rgba(245,158,11,0.08), transparent 18%),
                linear-gradient(180deg, rgba(255,255,255,0.97), rgba(245,239,255,0.94));
            box-shadow: 0 24px 60px rgba(124,58,237,0.08);
        }

        .gallery-video-showcase-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            padding: 1.3rem 1.3rem 0;
        }

        .gallery-video-slider {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding: 0 1.3rem 1.35rem;
            scrollbar-width: thin;
            scrollbar-color: rgba(124,58,237,0.36) transparent;
        }

        .gallery-video-slider::-webkit-scrollbar {
            height: 8px;
        }

        .gallery-video-slider::-webkit-scrollbar-thumb {
            background: rgba(124,58,237,0.25);
            border-radius: 999px;
        }

        .gallery-video-slide {
            position: relative;
            overflow: hidden;
            min-width: min(20rem, 82vw);
            flex: 0 0 min(20rem, 82vw);
            border-radius: 1.5rem;
            border: 1px solid rgba(214, 201, 241, 0.9);
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(244,238,255,0.90));
            box-shadow: 0 16px 42px rgba(124,58,237,0.08);
            transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
        }

        .gallery-video-slide:hover,
        .gallery-video-slide:focus-visible {
            transform: translateY(-6px);
            border-color: rgba(124,58,237,0.34);
            box-shadow: 0 24px 56px rgba(124,58,237,0.14);
            outline: none;
        }

        .gallery-video-slide-preview {
            position: relative;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: linear-gradient(135deg, #180b2f, #2c1055);
        }

        .gallery-video-slide-preview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), filter 0.35s ease;
        }

        .gallery-video-slide:hover .gallery-video-slide-preview video,
        .gallery-video-slide:focus-visible .gallery-video-slide-preview video {
            transform: scale(1.08);
            filter: saturate(1.04);
        }

        .gallery-video-slide-preview::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(10, 6, 24, 0.04), rgba(10, 6, 24, 0.56)),
                linear-gradient(135deg, rgba(255,255,255,0.16), transparent 32%);
            pointer-events: none;
        }

        .gallery-video-slide-play {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.24);
            background: rgba(10, 6, 24, 0.42);
            color: #fff;
            backdrop-filter: blur(12px);
            box-shadow: 0 14px 34px rgba(10, 6, 24, 0.24);
        }

        .gallery-video-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.8rem;
            height: 2.8rem;
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.12);
            background: rgba(255,255,255,0.94);
            color: #5b21b6;
            box-shadow: 0 10px 28px rgba(124,58,237,0.08);
        }

        .gallery-video-slide-copy {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1rem 1.05rem;
            text-align: left;
        }

        .gallery-video-slide-copy > div:first-child {
            min-width: 0;
            flex: 1 1 auto;
        }

        .gallery-video-slide-title {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            overflow: hidden;
        }

        .gallery-video-slide-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.65rem;
            height: 2.65rem;
            flex-shrink: 0;
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.12);
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(241,234,255,0.88));
            color: #7c3aed;
            box-shadow: 0 10px 24px rgba(124,58,237,0.08);
        }

        .gallery-lightbox {
            position: fixed;
            inset: 0;
            z-index: 90;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: rgba(10, 6, 24, 0.84);
            backdrop-filter: blur(16px);
        }

        .gallery-lightbox[hidden] {
            display: none;
        }

        .gallery-lightbox-panel {
            position: relative;
            width: min(1000px, 100%);
            max-height: calc(100vh - 3rem);
            overflow: hidden;
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.14);
            background: linear-gradient(180deg, rgba(18, 8, 35, 0.95), rgba(10, 6, 24, 0.98));
            box-shadow: 0 32px 90px rgba(0,0,0,0.38);
        }

        .gallery-lightbox-media {
            position: relative;
            aspect-ratio: 16 / 9;
            background: #0b0717;
        }

        .gallery-lightbox-media img,
        .gallery-lightbox-media video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            background: #0b0717;
        }

        .gallery-lightbox-close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.08);
            color: #fff;
            backdrop-filter: blur(10px);
        }

        @media (min-width: 768px) {
            .gallery-grid {
                gap: 1.2rem;
            }
        }

        .showcase-stage {
            position: relative;
            overflow: hidden;
            border-radius: 2.25rem;
            border: 1px solid rgba(212, 197, 240, 0.55);
            background:
                radial-gradient(circle at 14% 18%, rgba(168, 85, 247, 0.16), transparent 26%),
                radial-gradient(circle at 86% 14%, rgba(245, 158, 11, 0.12), transparent 22%),
                linear-gradient(160deg, rgba(255,255,255,0.96), rgba(247,241,255,0.96));
            box-shadow: 0 32px 80px rgba(124, 58, 237, 0.12);
        }

        .showcase-hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            border: 1px solid rgba(212, 197, 240, 0.55);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.92), rgba(245, 240, 255, 0.9));
            backdrop-filter: blur(16px);
            box-shadow: 0 18px 44px rgba(124, 58, 237, 0.12);
        }

        .showcase-spotlight {
            position: relative;
            overflow: hidden;
            border-radius: 1.8rem;
            min-height: 420px;
            background: #efe7fb;
            box-shadow: 0 28px 64px rgba(124, 58, 237, 0.16);
        }

        .showcase-spotlight img,
        .showcase-spotlight video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .showcase-spotlight:hover img {
            transform: scale(1.06);
        }

        .showcase-safe-title {
            max-width: 10ch;
        }

        .showcase-safe-copy {
            max-width: 60ch;
        }

        .showcase-image-note {
            border-radius: 1.5rem;
            border: 1px solid rgba(212, 197, 240, 0.55);
            background: linear-gradient(180deg, rgba(255,255,255,0.94), rgba(245,240,255,0.92));
            box-shadow: 0 16px 38px rgba(124,58,237,0.1);
        }

        .showcase-grid-card {
            position: relative;
            overflow: hidden;
            border-radius: 1.7rem;
            border: 1px solid rgba(212, 197, 240, 0.55);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(247, 241, 255, 0.92));
            backdrop-filter: blur(14px);
            box-shadow: 0 22px 54px rgba(124, 58, 237, 0.1);
            transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
        }

        .showcase-grid-card:hover {
            transform: translateY(-10px);
            border-color: rgba(168, 85, 247, 0.35);
            box-shadow: 0 30px 74px rgba(124, 58, 237, 0.16);
        }

        .showcase-grid-card img,
        .showcase-grid-card video {
            transition: transform 0.65s ease;
        }

        .showcase-grid-card:hover img,
        .showcase-grid-card:hover video {
            transform: scale(1.08);
        }

        .showcase-icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.18), rgba(255, 255, 255, 0.95));
            border: 1px solid rgba(212, 197, 240, 0.55);
            color: #7c3aed;
        }

        .showcase-stat-card {
            border-radius: 1.5rem;
            border: 1px solid rgba(212, 197, 240, 0.5);
            background: rgba(255, 255, 255, 0.82);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.65);
        }

        .showcase-list-card {
            border-radius: 1.6rem;
            border: 1px solid rgba(212, 197, 240, 0.5);
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(245,240,255,0.92));
            box-shadow: 0 16px 40px rgba(124,58,237,0.1);
        }

        .placements-carousel-shell {
            position: relative;
        }

        .placements-page {
            display: none;
            opacity: 0;
            transform: translateY(14px);
        }

        .placements-page.is-active {
            display: block;
            opacity: 1;
            transform: translateY(0);
            animation: placements-page-in 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes placements-page-in {
            0% {
                opacity: 0;
                transform: translateY(18px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .placements-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.2rem;
            height: 3.2rem;
            border-radius: 999px;
            border: 1px solid rgba(217, 199, 239, 0.8);
            background: rgba(255, 255, 255, 0.9);
            color: #7c3aed;
            box-shadow: 0 16px 32px rgba(132,93,168,0.1);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease, background 0.25s ease;
        }

        .placements-nav:hover {
            transform: translateY(-2px) scale(1.02);
            border-color: rgba(124, 58, 237, 0.5);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 22px 40px rgba(132,93,168,0.16);
        }

        .placements-nav:disabled {
            opacity: 0.45;
        }

        .placements-count-pill {
            border: 1px solid rgba(217, 199, 239, 0.85);
            background: rgba(255,255,255,0.82);
            box-shadow: 0 16px 30px rgba(132,93,168,0.08);
        }

        /* ── Scroll progress bar ──────────────────── */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #7c3aed, #a855f7, #c084fc);
            z-index: 9999;
            width: 0%;
            transition: width 0.1s linear;
        }
    </style>
</head>

<body class="home-classic-bg bg-background text-on-surface font-body antialiased selection:bg-primary/20">

    <!-- Scroll progress bar -->
    <div id="scroll-progress"></div>
    <x-shared.back-to-top />

    <x-home.navbar />
    <main class="overflow-x-hidden pt-16">

        @php
            $promoSlideCount = count($promoSlides);
        @endphp
        <section class="promo-banner mt-5" >
            <div class="promo-track" id="homePromoTrack">
                @foreach ($promoSlides as $slide)
                    @php
                        $promoSurfaceStyle = 'style="background-image: '.e($slide['accent_style'] ?? $slide['accent']).';"';
                    @endphp
                    <article class="promo-slide">
                        <div class="promo-surface" {!! $promoSurfaceStyle !!}>
                            <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="absolute inset-0 h-full w-full object-cover opacity-28" loading="lazy" />
                            <div class="relative z-10 mx-auto max-w-7xl px-4 py-5 md:px-6 lg:py-6">
                                <div class="text-white">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="rounded-full bg-white/12 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/84">{{ $slide['eyebrow'] }}</span>
                                        <span class="rounded-full bg-white/12 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/84">{{ $slide['badge'] }}</span>
                                        @if ($promoSlideCount > 1)
                                            <span class="promo-meta-pill rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/84">
                                                Slide {{ $loop->iteration }} of {{ $promoSlideCount }}
                                            </span>
                                        @endif
                                    </div>
                                    <h2 class="mt-4 max-w-3xl font-headline text-2xl font-extrabold leading-[0.98] md:text-[2.35rem]">{{ $slide['title'] }}</h2>
                                    <p class="mt-2 text-sm font-semibold text-white/84 md:text-base">{{ $slide['highlight'] }}</p>
                                    <p class="mt-2 max-w-2xl text-sm leading-6 text-white/72">{{ $slide['description'] }}</p>
                                    <div class="mt-4 flex flex-wrap items-center gap-3">
                                        <div class="rounded-full bg-white/12 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-white/82">{{ $slide['stat_label'] }}: {{ $slide['stat_value'] }}</div>
                                    </div>
                                    <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                                        <a href="{{ $slide['primary_url'] }}" class="btn-shimmer inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-2.5 text-xs font-bold uppercase tracking-[0.14em] text-primary transition hover:-translate-y-0.5">
                                            {{ $slide['primary_label'] }}
                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </a>
                                        <a href="{{ $slide['secondary_url'] }}" class="btn-shimmer inline-flex items-center justify-center gap-2 rounded-full bg-white/10 px-5 py-2.5 text-xs font-bold uppercase tracking-[0.14em] text-white transition hover:-translate-y-0.5 hover:bg-white/14">
                                            {{ $slide['secondary_label'] }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($promoSlideCount > 1)
                <div class="pointer-events-none absolute inset-y-0 left-0 right-0 z-20 flex items-center justify-between px-3 md:px-6">
                    <button type="button" id="homePromoPrev" class="promo-arrow pointer-events-auto flex h-11 w-11 items-center justify-center rounded-full text-white" aria-label="Previous slide">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button type="button" id="homePromoNext" class="promo-arrow pointer-events-auto flex h-11 w-11 items-center justify-center rounded-full text-white" aria-label="Next slide">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>

                <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 items-center justify-center gap-2" id="homePromoDots">
                    @foreach ($promoSlides as $slide)
                        <button type="button" class="promo-dot {{ $loop->first ? 'is-active' : '' }}" data-slide-dot="{{ $loop->index }}" aria-label="Go to slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- ════════════════════════════════════════
             HERO SECTION
        ════════════════════════════════════════ -->
        @php
            $homeGalleryVideos = collect($achievementGallery ?? [])
                ->filter(fn ($item) => ($item['media_type'] ?? 'image') === 'video')
                ->values();
            $fallbackFounderVideo = $homeGalleryVideos->first();
            $founderFeatureVideo = array_replace([
                'eyebrow' => 'Founder Message',
                'title' => 'Hear the vision behind CodeInYourself and how we prepare learners for real technology careers.',
                'description' => 'Founder insights on mentorship, practical training, and career-focused learning.',
                'video_url' => $fallbackFounderVideo['media_url'] ?? '',
                'poster_url' => $fallbackFounderVideo['poster_url'] ?? asset('images/owner 1.0.jpeg'),
                'badge' => 'Founder',
                'meta' => 'HR managed hero video',
            ], is_array($homeFounderVideo ?? null) ? $homeFounderVideo : []);
        @endphp
        <section id="career-paths" class="relative min-h-screen overflow-hidden aurora-hero">
            <div class="stars-bg"></div>
            <div class="soft-wave"></div>

            <div class="relative z-10 mx-auto grid max-w-7xl items-center gap-12 px-4 pb-24 pt-16 md:px-6 md:pb-28 md:pt-20 lg:min-h-[calc(100vh-4rem)] lg:grid-cols-[1.05fr_0.95fr] lg:gap-20">

                <!-- Left: Text -->
                <div class="text-white">
                    <div class="reveal mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white/90 backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-[#c084fc]"></span>
                        AI-Powered Learning Platform
                    </div>

                    <h1 class="reveal stagger-1 max-w-2xl font-headline text-4xl font-extrabold leading-[1.08] tracking-tight md:text-[3.5rem] lg:text-[4rem]">
                        Build Real Skills
                        <span class="block text-gradient">for the AI Industry</span>
                        <span class="block text-white/90">and Launch with Confidence</span>
                    </h1>

                    <p class="reveal stagger-2 mt-6 max-w-xl text-[15px] leading-relaxed text-white/70">
                        Learn data, AI, analytics, and development through guided mentorship
                        <span class="mx-2 text-white/30">|</span>
                        <span class="font-medium text-white/90">online and offline learning options</span>
                    </p>

                    <div class="reveal stagger-3 mt-9 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('home.courses') }}"
                           class="btn-shimmer btn-primary inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-7 py-4 text-sm font-bold text-primary shadow-hero transition">
                            <span class="material-symbols-outlined text-[18px]">school</span>
                            Start Learning
                        </a>
                        <a href="{{ route('home.mentorship') }}#talktomentor"
                           class="btn-outline inline-flex items-center justify-center gap-2 rounded-2xl border border-white/30 bg-white/10 px-7 py-4 text-sm font-bold text-white backdrop-blur-sm">
                            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                            Book Free Mentorship
                        </a>
                    </div>

                    <!-- Trust strip -->
                    <div class="reveal stagger-4 mt-12 flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-2 text-sm text-white/60">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10">
                                <span class="material-symbols-outlined text-[16px] text-[#c084fc]">verified</span>
                            </span>
                            Placement Guidance
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/60">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10">
                                <span class="material-symbols-outlined text-[16px] text-[#c084fc]">groups</span>
                            </span>
                            Live Mentorship
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/60">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10">
                                <span class="material-symbols-outlined text-[16px] text-[#c084fc]">rocket_launch</span>
                            </span>
                            Real-World Projects
                        </div>
                    </div>
                </div>

                <!-- Right: Owner Visual -->
                <div class="reveal-right relative flex items-center justify-center">
                    <div class="relative mx-auto w-full max-w-[28rem] lg:max-w-[30rem]">

                        <!-- Floating badge top-left -->
                        <div class="hidden">
                            <div class="glass-card-light rounded-2xl p-4">
                                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">Leadership</p>
                                <div class="mt-2 flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#7c3aed] to-[#a855f7] text-white shadow-glow">
                                        <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface">Founder Driven</p>
                                        <p class="text-[10px] text-on-surface-variant">Built with real industry vision</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="animate-float-slow owner-showcase-card relative overflow-hidden rounded-[2.3rem] p-3">
                            <div class="overflow-hidden rounded-[2rem] p-2.5" style="background-image: linear-gradient(180deg, rgb(186 120 250) 0%, rgb(124 84 175 / 66%) 100%);">
                                <div class="hidden">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#ff6d7a]"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#ffcf56]"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#6ce393]"></span>
                                    </div>
                                    <span class="text-[10px] font-semibold uppercase tracking-[0.24em] text-white/40">CodeInYourself · Leadership</span>
                                    <div class="h-5 w-5 rounded-full bg-white/10"></div>
                                </div>

                                <div class="rounded-[1.7rem] p-2.5 md:p-3" style="background-image: linear-gradient(135deg, #2b0e52 0%, #4b1990 52%, #6d28d9 100%);">
                                    <div class="grid items-start gap-0">
                                        <div class="owner-photo-frame">
                                            <!-- <div class="owner-badge">
                                                <span class="owner-badge-dot"></span>
                                                <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/88">{{ $founderFeatureVideo['badge'] }}</span>
                                            </div> -->
                                            <div class="absolute inset-0 rounded-[1.5rem] border border-white/20"></div>
                                            <div class="custom-player h-full">
                                                <div class="custom-player-stage h-full overflow-hidden rounded-[1.5rem]">
                                                    <img src="{{ $founderFeatureVideo['poster_url'] }}" alt="{{ $founderFeatureVideo['title'] }}" class="h-full w-full object-cover transition duration-700 hover:scale-[1.03]" />
                                                    <div class="custom-player-overlay">
                                                        @if (! empty($founderFeatureVideo['video_url']))
                                                            <button
                                                                type="button"
                                                                class="custom-player-overlay-btn"
                                                                data-gallery-trigger
                                                                data-gallery-type="video"
                                                                data-gallery-media="{{ $founderFeatureVideo['video_url'] }}"
                                                                data-gallery-poster="{{ $founderFeatureVideo['poster_url'] }}"
                                                                data-gallery-title="{{ $founderFeatureVideo['title'] }}"
                                                                aria-label="Play founder video"
                                                            >
                                                                <span class="material-symbols-outlined text-[28px]">play_arrow</span>
                                                            </button>
                                                        @else
                                                            <span class="custom-player-overlay-btn opacity-70">
                                                                <span class="material-symbols-outlined text-[28px]">image</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <!-- <div class="custom-player-meta">
                                                         <div class="custom-player-copy">
                                                            <p class="custom-player-pill text-[10px] font-bold uppercase tracking-[0.24em] text-white/82">{{ $founderFeatureVideo['eyebrow'] }}</p>
                                                            <h3 class="mt-3 font-headline text-2xl font-extrabold leading-tight text-white">{{ $founderFeatureVideo['title'] }}</h3>
                                                            <p class="mt-3 max-w-md text-sm leading-7 text-white/72">{{ $founderFeatureVideo['description'] }}</p>
                                                        </div> 
                                                        <div class="+-fineprint text-xs leading-6">
                                                            {{ ! empty($founderFeatureVideo['video_url']) ? 'Click to open the founder message in a focused video modal.' : ($founderFeatureVideo['meta'] ?? 'Founder feature preview') }}
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating badge bottom-right -->
                        <div class="hidden">
                            <div class="glass-card-light rounded-2xl p-4">
                                <p class="text-[9px] font-bold uppercase tracking-[0.22em] text-primary">Brand Presence</p>
                                <div class="mt-2 flex items-center gap-2.5">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-[#7c3aed] to-[#f472b6] text-white shadow-soft">
                                        <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface">Owner photo slot ready</p>
                                        <p class="text-[10px] text-on-surface-variant">Swap the image source with your real portrait</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- ════════════════════════════════════════
             STATS BAR
        ════════════════════════════════════════ -->
        <section class="relative z-20 -mt-8 px-4 md:px-6">
            <div class="mx-auto max-w-5xl">
                <div class="stat-pill reveal grid grid-cols-1 divide-y divide-outline/40 overflow-hidden rounded-[1.8rem] border border-outline/50 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                    <div class="flex items-center gap-4 px-8 py-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7c3aed] to-[#a855f7] text-white shadow-soft">
                            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">groups</span>
                        </div>
                        <div>
                            <p class="font-headline text-2xl font-extrabold text-on-surface">
                                <span class="counter-num" data-target="{{ max(20, $siteStats['students']) }}">0</span>+
                            </p>
                            <p class="text-xs font-semibold text-on-surface-variant">Students Placed</p>
                            <p class="text-[10px] text-on-surface-variant/70">Across classroom and online learning formats</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-8 py-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#a855f7] to-[#c084fc] text-white shadow-soft">
                            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">verified</span>
                        </div>
                        <div>
                            <p class="font-headline text-2xl font-extrabold text-on-surface">100%</p>
                            <p class="text-xs font-semibold text-on-surface-variant">Placement Support</p>
                            <p class="text-[10px] text-on-surface-variant/70">Resume, mock interview, and guidance support</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-8 py-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#5b21b6] to-[#7c3aed] text-white shadow-soft">
                            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">rocket_launch</span>
                        </div>
                        <div>
                            <p class="font-headline text-2xl font-extrabold text-on-surface">Live</p>
                            <p class="text-xs font-semibold text-on-surface-variant">Real-World Projects</p>
                            <p class="text-[10px] text-on-surface-variant/70">Hands-on assignments built for portfolios</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ════════════════════════════════════════
             CAREER PATHS  (uses $aboutHighlights)
        ════════════════════════════════════════ -->
        <section class="relative overflow-hidden px-4 py-24 md:px-6 md:py-28">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(223,198,246,0.38),transparent_28%),radial-gradient(circle_at_bottom_right,rgba(243,232,255,0.88),transparent_34%),linear-gradient(180deg,#fffdfd_0%,#fbf6ff_48%,#f7effd_100%)]"></div>
            <div class="absolute inset-0 opacity-55" style="background-image: linear-gradient(rgba(161,131,190,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(161,131,190,0.08) 1px, transparent 1px); background-size: 5.5rem 5.5rem; mask-image: linear-gradient(180deg, rgba(0,0,0,0.7), rgba(0,0,0,0.18));"></div>

            <div class="relative z-10 mx-auto max-w-7xl">
                <div class="reveal mb-12 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-[1rem] font-bold uppercase tracking-[0.28em] text-[#8f67b8]">Popular Roadmaps & Offline Courses</p>
                        <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-[1.2rem]">
                            Explore our most in-demand learning paths & courses in AI, data, and analytics.
                        </h2>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-on-surface-variant">
                            Compare the programs learners choose most often when they want stronger technical foundations, guided projects, and clearer career direction.
                        </p>
                    </div>
                    <a href="{{ route('home.career-paths') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#281126_0%,#6d3aa7_52%,#c8a34b_100%)] px-6 py-4 text-sm font-bold uppercase tracking-[0.14em] text-white shadow-[0_18px_36px_rgba(106,51,120,0.18)] transition hover:-translate-y-0.5 hover:shadow-[0_24px_44px_rgba(106,51,120,0.22)]">
                        View All Roadmaps & Offline Courses
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($popularRoadmaps as $index => $roadmap)
                        <article class="reveal stagger-{{ ($index % 4) + 1 }} overflow-hidden rounded-[2rem] border border-[#eadcf8] bg-[linear-gradient(180deg,rgba(255,255,255,0.98),rgba(250,245,255,0.94))] shadow-[0_22px_52px_rgba(157,120,186,0.10)]">
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="{{ $roadmap['thumbnail'] }}" alt="{{ $roadmap['title'] }}" class="h-full w-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-[rgba(35,20,54,0.16)] via-transparent to-transparent"></div>
                                <div class="absolute left-5 top-5">
                                    <span class="rounded-full bg-white/90 px-3 py-1.5 text-[11px] font-bold uppercase tracking-[0.18em] text-[#6e5317] shadow-[0_10px_20px_rgba(110,83,23,0.08)]">{{ $roadmap['label'] }}</span>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">{{ $roadmap['duration'] }}</p>
                                        <h3 class="mt-3 font-headline text-2xl font-extrabold text-on-surface">{{ $roadmap['title'] }}</h3>
                                    </div>
                                </div>

                                <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $roadmap['subtitle'] }}</p>

                                <div class="mt-5 flex flex-wrap gap-2">
                                    @foreach ($roadmap['skills'] as $skill)
                                        <span class="rounded-full border border-[#e6d8f5] bg-[#f8f2fe] px-3 py-2 text-xs font-semibold text-[#6b4b88]">{{ $skill }}</span>
                                    @endforeach
                                </div>

                                <div class="mt-6 flex flex-col gap-3 border-t border-[#f0e6f8] pt-5 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#8f67b8]">Destination</p>
                                            <p class="mt-1 text-sm font-semibold text-on-surface">Detailed roadmap and curriculum</p>
                                        </div>
                                        <a href="{{ $roadmap['cta_url'] }}"
                                           @guest
                                           data-auth-required
                                           data-auth-redirect="{{ $roadmap['cta_url'] }}"
                                           data-auth-title="Login to access roadmap details"
                                           data-auth-copy="Sign in first to open the full roadmap and curriculum details."
                                           @endguest
                                           class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#281126_0%,#6d3aa7_52%,#c8a34b_100%)] px-5 py-3 text-[12px] font-bold uppercase tracking-[0.14em] text-white transition hover:-translate-y-0.5">
                                            View Roadmap
                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ════════════════════════════════════════
             WHY CHOOSE  (uses $corporateHighlights)
        ════════════════════════════════════════ -->
        <section id="corporate-training" class="relative overflow-hidden px-4 py-20 md:px-6 md:py-20">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(124,58,237,0.08),transparent_26%),radial-gradient(circle_at_bottom_right,rgba(192,132,252,0.10),transparent_28%),linear-gradient(180deg,#fffefe_0%,#faf6ff_52%,#f6effd_100%)]"></div>
            <div class="absolute inset-0 opacity-60" style="background-image: linear-gradient(rgba(124,58,237,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(124,58,237,0.05) 1px, transparent 1px); background-size: 6rem 6rem; mask-image: linear-gradient(180deg, rgba(0,0,0,0.65), rgba(0,0,0,0.2));"></div>

            <div class="relative z-10 mx-auto max-w-7xl">
                @php
                    $whyChooseVisuals = collect([
                        asset('images/home/why-choose-mentorship.svg'),
                        asset('images/home/why-choose-projects.svg'),
                        asset('images/home/why-choose-community.svg'),
                    ]);
                @endphp

                <div class="reveal mb-12 text-center md:mb-14">
                    <div class="inline-flex flex-col items-center">
                        <h2 class="mt-4 font-headline text-[2.9rem] font-extrabold uppercase leading-[0.9] tracking-[0.05em] text-[#241f44] md:text-[4.1rem] lg:text-[5rem]">
                            <span class="block">Why Choose</span>
                            <span class="block bg-[linear-gradient(180deg,#2c2451_0%,#6d4aa2_100%)] bg-clip-text text-transparent">Us</span>
                        </h2>
                    </div>
                    <p class="mx-auto mt-4 max-w-lg text-xs leading-6 text-on-surface-variant md:text-sm">
                        Discover what makes our learning experience practical, supportive, and aligned with real career outcomes.
                    </p>
                </div>

                <div class="relative mx-auto max-w-6xl px-2 md:px-4">
                    <div class="absolute left-1/2 top-0 hidden h-full w-[2px] -translate-x-1/2 bg-[linear-gradient(180deg,rgba(143,103,184,0.04),rgba(143,103,184,0.34),rgba(143,103,184,0.04))] lg:block"></div>
                    <div class="absolute left-1/2 top-0 hidden h-full w-8 -translate-x-1/2 bg-[radial-gradient(circle,rgba(143,103,184,0.08)_0%,transparent_70%)] lg:block"></div>

                    <div class="space-y-8 md:space-y-10">
                        @foreach ($corporateHighlights as $index => $item)
                            <article class="reveal stagger-{{ ($index % 4) + 1 }} relative">
                                <div class="grid gap-4 md:gap-5 lg:grid-cols-[minmax(0,1fr)_78px_minmax(0,1fr)] lg:items-center">
                                    @if ($index % 2 === 0)
                                        <div class="text-right lg:pr-6">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#8f67b8]">Why Choose Us 0{{ $index + 1 }}</p>
                                            <h3 class="mt-3 font-headline text-[1.6rem] font-extrabold leading-tight text-on-surface md:text-[1.8rem]">{{ $item['title'] }}</h3>
                                            <p class="mt-3 text-sm leading-7 text-on-surface-variant md:text-[15px]">{{ $item['description'] }}</p>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <div class="flex h-[4.35rem] w-[4.35rem] items-center justify-center rounded-[1.55rem] bg-[linear-gradient(135deg,#f3e8fc_0%,#e8daf8_100%)] text-[#7a51a6] shadow-[0_14px_24px_rgba(143,103,184,0.12)]">
                                                <span class="material-symbols-outlined text-[28px]" style="font-variation-settings:'FILL' 1;">{{ $item['icon'] }}</span>
                                            </div>
                                        </div>
                                        <div class="lg:pl-6">
                                            <div class="overflow-hidden rounded-[1.7rem] bg-white/60 shadow-[0_14px_24px_rgba(157,120,186,0.08)] backdrop-blur-[2px]">
                                                <div class="aspect-[16/10] overflow-hidden bg-[#f3ecfa]">
                                                    <img
                                                        src="{{ $whyChooseVisuals->get($index % max($whyChooseVisuals->count(), 1), asset('images/home/why-choose-mentorship.svg')) }}"
                                                        alt="{{ $item['title'] }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                <div class="px-4 py-4 md:px-5 md:py-5">
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">What You Get</p>
                                                    <p class="mt-2.5 text-[15px] font-semibold leading-6 text-on-surface">{{ $item['result'] ?? 'Practical support that helps learners build confidence and keep progressing.' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="lg:pr-6">
                                            <div class="overflow-hidden rounded-[1.7rem] bg-white/60 shadow-[0_14px_24px_rgba(157,120,186,0.08)] backdrop-blur-[2px]">
                                                <div class="aspect-[16/10] overflow-hidden bg-[#f3ecfa]">
                                                    <img
                                                        src="{{ $whyChooseVisuals->get($index % max($whyChooseVisuals->count(), 1), asset('images/home/why-choose-mentorship.svg')) }}"
                                                        alt="{{ $item['title'] }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                <div class="px-4 py-4 md:px-5 md:py-5">
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">What You Get</p>
                                                    <p class="mt-2.5 text-[15px] font-semibold leading-6 text-on-surface">{{ $item['result'] ?? 'Practical support that helps learners build confidence and keep progressing.' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <div class="flex h-[4.35rem] w-[4.35rem] items-center justify-center rounded-[1.55rem] bg-[linear-gradient(135deg,#f3e8fc_0%,#e8daf8_100%)] text-[#7a51a6] shadow-[0_14px_24px_rgba(143,103,184,0.12)]">
                                                <span class="material-symbols-outlined text-[28px]" style="font-variation-settings:'FILL' 1;">{{ $item['icon'] }}</span>
                                            </div>
                                        </div>
                                        <div class="text-left lg:pl-6">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-[#8f67b8]">Why Choose Us 0{{ $index + 1 }}</p>
                                            <h3 class="mt-3 font-headline text-[1.6rem] font-extrabold leading-tight text-on-surface md:text-[1.8rem]">{{ $item['title'] }}</h3>
                                            <p class="mt-3 text-sm leading-7 text-on-surface-variant md:text-[15px]">{{ $item['description'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        @php
            $placementSpotlights = collect($homePlacementStudents ?? [])->values();

            $placementSlides = $placementSpotlights->chunk(3)->values();
        @endphp

        <section class="relative overflow-hidden bg-[linear-gradient(180deg,#fbf8ff_0%,#f6f0ff_100%)] px-4 py-24 md:px-6 md:py-28">
            <div class="absolute inset-x-0 top-0 h-40 bg-[radial-gradient(circle_at_top,rgba(143,103,184,0.18),transparent_72%)]  "></div>
            <!-- bg-[radial-gradient(circle_at_top,rgba(143,103,184,0.18),transparent_72%)] -->
            <div class="absolute -left-20 top-24 h-56 w-56 rounded-full bg-[#eadbfb]/60 blur-3xl"></div>
            <div class="absolute -right-10 bottom-8 h-64 w-64 rounded-full bg-[#efe4ff]/80 blur-3xl"></div>

            <div class="relative z-10 mx-auto max-w-7xl">
                <div class="reveal mb-14 text-center lg:mb-16">
                    <p class="text-[1.25rem] font-bold uppercase tracking-[0.3em] text-[#8f67b8]">Top Placements</p>
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-4">
                        <h2 class="font-headline text-[1.5rem] font-extrabold leading-[1.02] text-on-surface md:text-[2.4rem]">
                            Meet the learners who turned focused training into real placement outcomes.
                        </h2>
                        <a
                            href="{{ route('home.placement') }}"
                            class="inline-flex items-center justify-center rounded-full border border-[#d9c7ef] bg-white/80 px-5 py-3 text-xs font-bold uppercase tracking-[0.18em] text-primary shadow-[0_16px_30px_rgba(132,93,168,0.08)] transition duration-500 hover:-translate-y-0.5 hover:border-primary hover:text-primary-700"
                        >
                            All Placements
                        </a>
                    </div>
                    <p class="mx-auto mt-6 max-w-3xl text-sm leading-7 text-on-surface-variant md:text-[15px]">
                        These placement stories show how mentorship, projects, and preparation support translate into stronger interviews and real career movement.
                    </p>
                </div>

                <div class="reveal pt-8">
                    @if ($placementSlides->isNotEmpty())
                        <div class="placements-carousel-shell">
                            <div id="homePlacementsPages">
                                @foreach ($placementSlides as $slideIndex => $slide)
                                    <div class="placements-page {{ $loop->first ? 'is-active' : '' }}" data-placement-page="{{ $slideIndex }}">
                                        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                                            @foreach ($slide as $index => $student)
                                            @php
                                                $studentName = trim((string) ($student['name'] ?? 'Student'));
                                                $studentCompany = trim((string) ($student['company'] ?? ''));
                                                $studentRole = trim((string) ($student['role'] ?? ''));
                                                $studentPackage = trim((string) ($student['package'] ?? ''));
                                                $studentCourse = trim((string) ($student['course'] ?? ''));
                                                $studentComment = trim((string) ($student['comment'] ?? ''));
                                                $studentAvatar = trim((string) ($student['avatar'] ?? ''));
                                                $studentRating = max(1, min(5, (int) ($student['rating'] ?? 5)));
                                                $companyBadge = $studentCompany !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($studentCompany, 0, 2)) : 'PL';
                                            @endphp
                                            <article class="group relative pt-12">
                                                <div class="absolute left-1/2 top-0 z-20 -translate-x-1/2">
                                                    <div class="rounded-full bg-[linear-gradient(135deg,#efe2ff_0%,#ffffff_100%)] p-1.5 shadow-[0_18px_40px_rgba(132,93,168,0.18)]">
                                                        @if ($studentAvatar !== '' && (($student['media_type'] ?? 'image') === 'video'))
                                                            <video class="h-24 w-24 rounded-full object-cover object-top transition duration-700 group-hover:-translate-y-1" autoplay loop muted playsinline preload="metadata">
                                                                <source src="{{ $studentAvatar }}" />
                                                            </video>
                                                        @elseif ($studentAvatar !== '')
                                                            <img
                                                                src="{{ $studentAvatar }}"
                                                                alt="{{ $studentName }}"
                                                                class="h-24 w-24 rounded-full object-cover object-top transition duration-700 group-hover:-translate-y-1"
                                                                loading="lazy"
                                                            />
                                                        @else
                                                            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[linear-gradient(135deg,#6d46a2_0%,#2f2653_100%)] text-xl font-black uppercase tracking-[0.16em] text-white">
                                                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($studentName, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="relative h-full overflow-hidden rounded-[2.2rem] border border-white/70 bg-white/88 px-7 pb-7 pt-16 shadow-[0_24px_56px_rgba(132,93,168,0.12)] backdrop-blur-sm transition duration-700 group-hover:-translate-y-2 group-hover:shadow-[0_30px_70px_rgba(132,93,168,0.16)]">
                                                    <div class="absolute inset-x-0 top-0 h-32 bg-[radial-gradient(circle_at_top,rgba(143,103,184,0.18),transparent_72%)]"></div>
                                                    <div class="relative z-10 flex h-full flex-col">
                                                        <div class="rounded-[1.8rem] bg-[linear-gradient(180deg,#fbf7ff_0%,#f3e8ff_100%)] px-6 py-7 text-center shadow-[inset_0_1px_0_rgba(255,255,255,0.85)]">
                                                            <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#8f67b8]">Placed At</p>
                                                            <div class="mt-4 flex items-center justify-center gap-3">
                                                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[linear-gradient(135deg,#2f2653_0%,#714ea4_100%)] text-sm font-black uppercase tracking-[0.12em] text-white shadow-[0_12px_28px_rgba(113,78,164,0.24)]">
                                                                    {{ $companyBadge }}
                                                                </span>
                                                                <span class="font-headline text-[1.5rem] font-extrabold tracking-tight text-[#2f2653]">
                                                                    {{ $studentCompany !== '' ? $studentCompany : 'Placement Story' }}
                                                                </span>
                                                            </div>
                                                            @if ($studentRole !== '')
                                                                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.18em] text-on-surface-variant">{{ $studentRole }}</p>
                                                            @endif
                                                        </div>

                                                        <div class="mt-6 text-center">
                                                            <h3 class="font-headline text-[1.8rem] font-extrabold text-on-surface">{{ $studentName }}</h3>
                                                            @if ($studentCourse !== '')
                                                                <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#8f67b8]">
                                                                    {{ $studentCourse }}
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <div class="mt-6 grid gap-3 {{ $studentPackage !== '' ? 'grid-cols-2' : 'grid-cols-1' }}">
                                                            @if ($studentPackage !== '')
                                                                <div class="rounded-[1.4rem] bg-[linear-gradient(180deg,#ffffff_0%,#faf5ff_100%)] px-4 py-4 text-center shadow-[0_12px_26px_rgba(132,93,168,0.08)]">
                                                                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8f67b8]">Package</p>
                                                                    <p class="mt-2 font-headline text-[1.35rem] font-extrabold text-on-surface">{{ $studentPackage }}</p>
                                                                </div>
                                                            @endif
                                                            <div class="rounded-[1.4rem] bg-[linear-gradient(180deg,#ffffff_0%,#faf5ff_100%)] px-4 py-4 text-center shadow-[0_12px_26px_rgba(132,93,168,0.08)]">
                                                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8f67b8]">Rating</p>
                                                                <div class="mt-2 flex items-center justify-center gap-1 text-[#f59e0b]">
                                                                    @for ($star = 0; $star < $studentRating; $star++)
                                                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1;">star</span>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if ($studentComment !== '')
                                                            <p class="mt-6 flex-1 text-center text-sm leading-7 text-on-surface-variant">
                                                                "{{ \Illuminate\Support\Str::limit($studentComment, 120) }}"
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </article>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($placementSlides->count() > 1)
                            <div class="mt-10 flex flex-col items-center justify-between gap-5 sm:flex-row">
                                <div class="flex items-center gap-3">
                                    <button type="button" id="homePlacementsPrev" class="placements-nav" aria-label="Previous placements">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </button>
                                    <button type="button" id="homePlacementsNext" class="placements-nav" aria-label="Next placements">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </div>

                                <div class="placements-count-pill inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8f67b8]">
                                    <span>Showing</span>
                                    <span id="homePlacementsCount">1 / {{ $placementSlides->count() }}</span>
                                    <span>Sets</span>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="rounded-[2rem] border border-dashed border-[#d9c7ef] bg-white/70 px-6 py-12 text-center text-sm font-medium leading-7 text-on-surface-variant shadow-[0_18px_40px_rgba(132,93,168,0.07)]">
                            Placement stories will appear here as soon as they are added from the admin side.
                        </div>
                    @endif
                </div>
            </div>
        </section>

        @php
            $successStoryCards = collect($homeSuccessStories ?? [])->values();
            $facultyCards = collect($homeFacultyCards ?? [])->values();
            if ($facultyCards->isEmpty()) {
                $facultyCards = collect([
                    [
                        'name' => 'Rahul Verma',
                        'avatar' => 'https://ui-avatars.com/api/?name=Rahul+Verma&background=EEE7FF&color=4C1D95&size=320',
                        'role' => 'Lead Mentor • AI & Data',
                        'bio' => 'Helps learners turn concepts into strong projects, clearer thinking, and job-ready execution.',
                    ],
                    [
                        'name' => 'Priyanka Nair',
                        'avatar' => 'https://ui-avatars.com/api/?name=Priyanka+Nair&background=EEE7FF&color=4C1D95&size=320',
                        'role' => 'Industry Mentor • Analytics',
                        'bio' => 'Brings practical workflows, project guidance, and clear feedback to every batch.',
                    ],
                    [
                        'name' => 'Aman Khanna',
                        'avatar' => 'https://ui-avatars.com/api/?name=Aman+Khanna&background=EEE7FF&color=4C1D95&size=320',
                        'role' => 'Faculty • Career Preparation',
                        'bio' => 'Supports learners with interview readiness, role clarity, and stronger portfolio presentation.',
                    ],
                    [
                        'name' => 'Sneha Das',
                        'avatar' => 'https://ui-avatars.com/api/?name=Sneha+Das&background=EEE7FF&color=4C1D95&size=320',
                        'role' => 'Faculty • Applied Projects',
                        'bio' => 'Focuses on practical output, guided reviews, and making complex topics easier to execute.',
                    ],
                ]);
            }
        @endphp

        <section class="relative overflow-hidden bg-white px-4 py-24 md:px-6 md:py-28">
            <div class="absolute inset-x-0 top-0 h-44 bg-[radial-gradient(circle_at_top,rgba(143,103,184,0.12),transparent_70%)]"></div>
            <div class="relative z-10 mx-auto max-w-7xl">
                <div class="reveal mb-14 text-center lg:mb-16">
                    <p class="text-[1.25rem] font-bold uppercase tracking-[0.3em] text-[#8f67b8]">Success Stories</p>
                    <h2 class="mt-4 font-headline text-[1.5rem] font-extrabold leading-[1.02] text-on-surface md:text-[2.4rem]">
                        Learner voices from across our growing community.
                    </h2>
                    <p class="mx-auto mt-6 max-w-3xl text-sm leading-7 text-on-surface-variant md:text-[15px]">
                        These stories highlight how students experience the classes, mentorship, project work, and support systems throughout their learning journey.
                    </p>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ($successStoryCards as $index => $story)
                        <article class="reveal stagger-{{ ($index % 4) + 1 }} overflow-hidden rounded-[2rem] border border-[#eee3fb] bg-[linear-gradient(180deg,#ffffff_0%,#fbf7ff_100%)] shadow-[0_22px_52px_rgba(132,93,168,0.10)] transition duration-500 hover:-translate-y-1.5 hover:shadow-[0_30px_66px_rgba(132,93,168,0.14)]">
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    @if (($story['media_type'] ?? 'image') === 'video')
                                        <video class="h-16 w-16 rounded-[1.4rem] object-cover shadow-[0_12px_28px_rgba(132,93,168,0.14)]" autoplay loop muted playsinline preload="metadata">
                                            <source src="{{ $story['avatar'] }}" />
                                        </video>
                                    @else
                                        <img
                                            src="{{ $story['avatar'] }}"
                                            alt="{{ $story['name'] }}"
                                            class="h-16 w-16 rounded-[1.4rem] object-cover shadow-[0_12px_28px_rgba(132,93,168,0.14)]"
                                            loading="lazy"
                                        />
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-3">
                                            <div>
                                                <h3 class="font-headline text-[1.35rem] font-extrabold leading-tight text-on-surface">{{ $story['name'] }}</h3>
                                                <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#8f67b8]">{{ $story['course'] }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex items-center gap-1 text-[#f59e0b]">
                                            @for ($star = 0; $star < max(1, min(5, (int) ($story['rating'] ?? 5))); $star++)
                                                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1;">star</span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 rounded-[1.7rem] bg-[linear-gradient(180deg,#faf5ff_0%,#f5ecff_100%)] p-5">
                                    <p class="text-sm leading-6 text-on-surface-variant">
                                        "{{ $story['comment'] }}"
                                    </p>
                                </div>

                                <div class="mt-5 flex items-center justify-between text-xs text-on-surface-variant">
                                    <span class="font-semibold text-[#8f67b8]">Shared by learner</span>
                                    <span>{{ $story['shared_at'] ?? now()->format('M Y') }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="relative overflow-hidden bg-[linear-gradient(180deg,#faf7ff_0%,#f4ecff_100%)] px-4 py-24 md:px-6 md:py-28">
            <div class="absolute -left-10 top-10 h-48 w-48 rounded-full bg-[#eadbfb]/70 blur-3xl"></div>
            <div class="absolute right-0 top-20 h-56 w-56 rounded-full bg-[#efe3ff]/80 blur-3xl"></div>

            <div class="relative z-10 mx-auto max-w-7xl">
                <div class="reveal mb-14 text-center lg:mb-16">
                    <p class="text-[1.25rem] font-bold uppercase tracking-[0.3em] text-[#8f67b8]">Our Faculty</p>
                    <h2 class="mt-4 font-headline text-[2.5rem] font-extrabold leading-[1.02] text-on-surface md:text-[2.4rem]">
                        Learn from mentors who guide with clarity and real-world direction.
                    </h2>
                    <p class="mx-auto mt-6 max-w-3xl text-sm leading-7 text-on-surface-variant md:text-[15px]">
                        Meet the mentors behind the guidance, reviews, and practical support that keep learners moving forward with confidence.
                    </p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($facultyCards as $index => $faculty)
                        <article class="reveal stagger-{{ ($index % 4) + 1 }} group overflow-hidden rounded-[2rem] bg-white/90 shadow-[0_24px_58px_rgba(132,93,168,0.12)] transition duration-500 hover:-translate-y-2 hover:shadow-[0_32px_72px_rgba(132,93,168,0.16)]">
                            <div class="relative aspect-[4/4.6] overflow-hidden bg-[linear-gradient(180deg,#f1e5ff_0%,#f9f5ff_100%)]">
                                <div class="absolute inset-x-0 top-0 h-28 bg-[radial-gradient(circle_at_top,rgba(143,103,184,0.18),transparent_72%)]"></div>
                                <img
                                    src="{{ $faculty['avatar'] }}"
                                    alt="{{ $faculty['name'] }}"
                                    class="h-full w-full object-cover object-top transition duration-700 group-hover:scale-[1.04]"
                                    loading="lazy"
                                />
                            </div>
                            <div class="p-6">
                                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#8f67b8]">{{ $faculty['role'] }}</p>
                                <h3 class="mt-3 font-headline text-[1.55rem] font-extrabold leading-tight text-on-surface">{{ $faculty['name'] }}</h3>
                                <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $faculty['bio'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- ════════════════════════════════════════
             ACHIEVEMENTS  (uses $siteStats + $achievementGallery)
        ════════════════════════════════════════ -->
        @php
            $featuredWorkshopCollection = collect($featuredWorkshops ?? [])->take(4)->values();
            $primaryWorkshop = $featuredWorkshopCollection->first();
            $secondaryWorkshops = $featuredWorkshopCollection->slice(1)->values();
            $achievementGalleryItems = collect($achievementGallery ?? [])
                ->sortBy(fn ($item) => sprintf(
                    '%05d|%s|%s',
                    (int) ($item['category_order'] ?? 0),
                    strtolower((string) ($item['category'] ?? 'General')),
                    strtolower((string) ($item['title'] ?? ''))
                ))
                ->values();
            $achievementGalleryGroups = $achievementGalleryItems->groupBy(fn ($item) => $item['category'] ?? 'General');
            $galleryCategoryCount = $achievementGalleryGroups->count();
            $studentReviewCount = $achievementGalleryItems->filter(fn ($item) => ($item['media_type'] ?? 'image') === 'video')->count();
        @endphp

        @if ($primaryWorkshop)
            <section class="relative overflow-hidden bg-[linear-gradient(180deg,#faf7ff_0%,#f5eeff_100%)] px-4 py-24 md:px-6 md:py-28">
                <div class="absolute -left-8 top-8 h-56 w-56 rounded-full bg-[#eadbfb]/70 blur-3xl"></div>
                <div class="absolute right-0 top-16 h-60 w-60 rounded-full bg-[#f3e5ff]/80 blur-3xl"></div>
                <div class="absolute bottom-0 left-1/3 h-44 w-44 rounded-full bg-[#fde7c2]/40 blur-3xl"></div>

                <div class="relative z-10 mx-auto max-w-6xl">
                    <div class="reveal mb-12 text-center">
                        <p class="mb-3 text-xl font-bold uppercase tracking-[0.28em] text-primary">Live Learning</p>
                        <h2 class="font-headline text-3xl font-extrabold text-on-surface md:text-[2.4rem]">Workshops Built for Practical Skill Development</h2>
                        <p class="mx-auto mt-4 max-w-3xl text-sm leading-8 text-on-surface-variant">Explore upcoming workshops designed to help learners practice current tools, build confidence faster, and work through guided sessions with mentor support.</p>
                    </div>

                    <div class="workshop-feature-shell p-5 md:p-7 lg:p-8">
                        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-start">
                            <article class="workshop-hero-panel reveal p-6 md:p-8">
                                <div class="relative z-10">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-white/90">{{ $primaryWorkshop['badge'] }}</span>
                                        <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-white/75">{{ $primaryWorkshop['seats'] }}</span>
                                    </div>
                                    <h3 class="mt-6 max-w-2xl font-headline text-3xl font-extrabold leading-tight md:text-[2.6rem]">{{ $primaryWorkshop['title'] }}</h3>
                                    <p class="mt-4 max-w-2xl text-sm leading-8 text-white/78 md:text-[15px]">{{ $primaryWorkshop['subtitle'] }}</p>

                                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                                        <div class="workshop-meta-chip">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/62">Date & Time</p>
                                            <p class="mt-2 text-sm font-semibold text-white">{{ $primaryWorkshop['date'] }}</p>
                                            <p class="mt-1 text-sm text-white/72">{{ $primaryWorkshop['time'] }}</p>
                                        </div>
                                        <div class="workshop-meta-chip">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/62">Format & Venue</p>
                                            <p class="mt-2 text-sm font-semibold text-white">{{ $primaryWorkshop['format'] }}</p>
                                            <p class="mt-1 text-sm text-white/72">{{ $primaryWorkshop['venue'] }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/60">Audience</p>
                                            <p class="mt-2 text-sm leading-7 text-white/80">{{ $primaryWorkshop['audience'] }}</p>
                                        </div>
                                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/60">Mentor</p>
                                            <p class="mt-2 text-sm leading-7 text-white/80">{{ $primaryWorkshop['mentor'] }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-8 flex flex-wrap gap-3">
                                        @foreach (collect($primaryWorkshop['highlights'] ?? [])->take(4) as $highlight)
                                            <span class="rounded-full border border-white/14 bg-white/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-white/85">{{ $highlight }}</span>
                                        @endforeach
                                    </div>

                                    <div class="mt-8">
                                        <a href="{{ route('home.free_workshop') }}" class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-white px-7 py-4 text-sm font-bold text-primary shadow-[0_18px_38px_rgba(255,255,255,0.18)] transition hover:-translate-y-0.5">
                                            <span class="material-symbols-outlined text-[18px]">event_available</span>
                                            Explore Workshops
                                        </a>
                                    </div>
                                </div>
                            </article>

                            <div class="workshop-side-list">
                                @foreach ($secondaryWorkshops as $index => $workshop)
                                    <article class="workshop-side-item reveal stagger-{{ ($index % 3) + 1 }}">
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <span class="rounded-full bg-primary-surface px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-primary">{{ $workshop['badge'] }}</span>
                                            <span class="text-[11px] font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ $workshop['seats'] }}</span>
                                        </div>
                                        <h3 class="mt-4 font-headline text-[1.45rem] font-extrabold leading-tight text-on-surface">{{ $workshop['title'] }}</h3>
                                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $workshop['subtitle'] }}</p>
                                        <div class="mt-4 grid gap-2 text-sm text-slate-600">
                                            <p><span class="font-semibold text-slate-900">When:</span> {{ $workshop['date'] }} / {{ $workshop['time'] }}</p>
                                            <p><span class="font-semibold text-slate-900">Mode:</span> {{ $workshop['format'] }}</p>
                                            <p><span class="font-semibold text-slate-900">Venue:</span> {{ $workshop['venue'] }}</p>
                                        </div>
                                        @if (! empty($workshop['highlights']))
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @foreach (collect($workshop['highlights'])->take(2) as $highlight)
                                                    <span class="rounded-full bg-slate-100 px-3 py-2 text-[11px] font-semibold text-slate-700">{{ $highlight }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <!-- <div class="mt-6 flex flex-wrap gap-3">
                            @foreach ($featuredWorkshopCollection->flatMap(fn ($workshop) => collect($workshop['highlights'] ?? []))->unique()->take(6) as $highlight)
                                <span class="workshop-highlight-pill">{{ $highlight }}</span>
                            @endforeach
                        </div> -->
                    </div>
                </div>
            </section>
        @endif

        <section class="relative overflow-hidden px-4 py-24 md:px-6 md:py-28">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_65%_54%_at_50%_100%,rgba(124,58,237,0.08),transparent_70%)]"></div>
            <div class="absolute inset-x-0 top-0 h-24 bg-[linear-gradient(180deg,rgba(255,255,255,0.78),transparent)]"></div>

            <div class="relative z-10 mx-auto max-w-7xl">
                <div class="reveal mb-10 text-center">
                    <p class="mb-3 text-sm font-bold uppercase tracking-[0.34em] text-primary">About Us</p>
                    <h2 class="font-headline text-3xl font-extrabold text-on-surface md:text-[2.9rem]">Achievements Gallery</h2>
                    <p class="mx-auto mt-4 max-w-3xl text-sm leading-8 text-on-surface-variant md:text-base">
                        Explore classroom moments, workshops, recognitions, and learner highlights that reflect how CodeInYourself grows with its students.
                    </p>
                </div>

                <div class="gallery-grand-shell p-5 md:p-7 lg:p-8">
                    <!-- reveal class remove from the above line to make sure aniamtions works proper -->
                    <div class="mb-8 grid gap-4 md:grid-cols-3">
                        <div class="gallery-hero-stat p-6 text-center">
                            <p class="font-headline text-4xl font-extrabold text-primary counter-num" data-target="{{ $galleryCategoryCount }}">0</p>
                            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.28em] text-primary">Categories</p>
                            <p class="mt-3 text-sm font-medium text-on-surface-variant">Grouped to make each achievement area easy to explore</p>
                        </div>
                        <div class="gallery-hero-stat p-6 text-center">
                            <p class="font-headline text-4xl font-extrabold text-primary counter-num" data-target="{{ $achievementGalleryItems->count() }}">0</p>
                            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.28em] text-primary">Media Items</p>
                            <p class="mt-3 text-sm font-medium text-on-surface-variant">Photos and videos that showcase events, learning, and milestones</p>
                        </div>
                        <div class="gallery-hero-stat p-6 text-center">
                            <p class="font-headline text-4xl font-extrabold text-primary counter-num" data-target="{{ $studentReviewCount }}">0</p>
                            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.28em] text-primary">Review Videos</p>
                            <p class="mt-3 text-sm font-medium text-on-surface-variant">Learner review clips that add real voices to the gallery</p>
                        </div>
                    </div>

                    @if ($achievementGalleryItems->isNotEmpty())
                        <div class="space-y-8">
                            @foreach ($achievementGalleryGroups as $category => $items)
                                @php
                                    $isReviewCategory = str($category)->lower()->contains('review');
                                    $galleryItems = $items->values();
                                    $imageItems = $galleryItems->filter(fn ($item) => ($item['media_type'] ?? 'image') !== 'video')->values();
                                    $videoItems = $galleryItems->filter(fn ($item) => ($item['media_type'] ?? 'image') === 'video')->values();
                                @endphp
                                <section class="gallery-category-panel p-4 md:p-5 lg:p-6">
                                    <div class="gallery-category-frame space-y-8 p-4 md:p-5 lg:p-6">
                                        <div class="gallery-collection-head reveal">
                                            <p class="gallery-collection-kicker px-5 py-2 text-[10px] font-bold uppercase tracking-[0.26em] text-primary">{{ $isReviewCategory ? 'Student Voices' : 'Achievement Collection' }}</p>
                                            <h3 class="mt-4 font-headline text-[1.9rem] font-extrabold leading-tight text-on-surface md:text-[2.2rem]">{{ $category }}</h3>
                                            <!-- <div class="gallery-collection-meta mt-5">
                                                <span class="gallery-ribbon px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">
                                                    {{ $galleryItems->count() }} {{ $galleryItems->count() === 1 ? 'Item' : 'Items' }}
                                                </span>
                                                @if ($imageItems->isNotEmpty())
                                                    <span class="gallery-ribbon px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">
                                                        {{ $imageItems->count() }} Images
                                                    </span>
                                                @endif
                                                @if ($videoItems->isNotEmpty())
                                                    <span class="gallery-ribbon px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">
                                                        {{ $videoItems->count() }} Videos
                                                    </span>
                                                @endif
                                                <span class="gallery-ribbon px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-primary">
                                                    {{ $videoItems->isNotEmpty() && $imageItems->isNotEmpty() ? 'Mixed Gallery' : ($videoItems->isNotEmpty() ? 'Video Focus' : 'Image Focus') }}
                                                </span>
                                            </div> -->
                                        </div>

                                        <div class="gallery-media-stack">
                                            @if ($imageItems->isNotEmpty())
                                                <div class="gallery-grid md:grid-cols-2 xl:grid-cols-3">
                                                    @foreach ($imageItems as $index => $item)
                                                        @php
                                                            $cardClasses = 'gallery-grid-item reveal';
                                                            $tileClasses = 'gallery-image-tile';
                                                        @endphp
                                                        <figure
                                                            class="{{ $cardClasses }}"
                                                        >
                                                            <button
                                                                type="button"
                                                                class="{{ $tileClasses }}"
                                                                data-gallery-trigger
                                                                data-gallery-media="{{ $item['media_url'] }}"
                                                                data-gallery-type="image"
                                                                data-gallery-title="{{ $item['title'] ?? 'CodeInYourself achievement' }}"
                                                                aria-label="Open {{ $item['title'] ?? 'CodeInYourself achievement' }}"
                                                            >
                                                                <div class="gallery-image-frame">
                                                                    <img
                                                                        src="{{ $item['media_url'] }}"
                                                                        alt="{{ $item['title'] ?? 'CodeInYourself achievement' }}"
                                                                        loading="lazy"
                                                                    />
                                                                </div>

                                                                <!-- <div class="gallery-image-caption text-left">
                                                                    <div class="gallery-image-copy">
                                                                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary">{{ $category }}</p>
                                                                        <p class="gallery-image-title mt-2 text-sm font-semibold leading-6 text-on-surface md:text-base">
                                                                            {{ $item['title']}}
                                                                        </p>
                                                                    </div>
                                                                    <span class="gallery-image-icon">
                                                                        <span class="material-symbols-outlined text-[18px]">open_in_full</span>
                                                                    </span>
                                                                </div> -->
                                                            </button>
                                                        </figure>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if ($videoItems->isNotEmpty())
                                                <div class="gallery-video-showcase reveal" data-video-gallery>
                                                    <div class="gallery-video-showcase-head mb-3">
                                                        <div>
                                                            <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-primary">Video Slideshow</p>
                                                            <!-- <h4 class="mt-2 font-headline text-[1.45rem] font-extrabold text-on-surface">Watch {{ $category }} videos in a popup player</h4>
                                                            <p class="mt-2 text-sm leading-7 text-on-surface-variant">Click any video card below to open the video modal and play that selected clip.</p> -->
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <button type="button" class="gallery-video-nav" data-video-nav="prev" aria-label="Previous videos">
                                                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                                            </button>
                                                            <button type="button" class="gallery-video-nav" data-video-nav="next" aria-label="Next videos">
                                                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="gallery-video-slider" data-video-track>
                                                        @foreach ($videoItems as $videoItem)
                                                            <button
                                                                type="button"
                                                                class="gallery-video-slide"
                                                                data-gallery-trigger
                                                                data-gallery-type="video"
                                                                data-gallery-media="{{ $videoItem['media_url'] }}"
                                                                data-gallery-poster="{{ $videoItem['poster_url'] ?? '' }}"
                                                                data-gallery-title="{{ $videoItem['title'] ?? ($category . ' video') }}"
                                                                aria-label="Play {{ $videoItem['title'] ?? ($category . ' video') }}"
                                                            >
                                                                <div class="gallery-video-slide-preview">
                                                                    <span class="gallery-video-slide-play">
                                                                        <span class="material-symbols-outlined text-[28px]">play_arrow</span>
                                                                    </span>
                                                                    <video muted loop playsinline preload="metadata">
                                                                        <source src="{{ $videoItem['media_url'] }}" />
                                                                    </video>
                                                                </div>
                                                                <!-- <div class="gallery-video-slide-copy">
                                                                    <div>
                                                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary">{{ $isReviewCategory ? 'Review Clip' : 'Category Clip' }}</p>
                                                                        <p class="gallery-video-slide-title mt-2 text-sm font-semibold leading-6 text-on-surface">{{ $videoItem['title'] ?? ($category . ' video') }}</p>
                                                                    </div>
                                                                    <span class="gallery-video-slide-icon">
                                                                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                                                    </span>
                                                                </div> -->
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </section>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- ════════════════════════════════════════
             CTA STRIP
        ════════════════════════════════════════ -->
        <section class="relative overflow-hidden aurora-cta px-4 py-20 md:px-6 md:py-24">
            <div class="stars-bg opacity-50"></div>
            <div class="soft-wave opacity-40"></div>

            <div class="relative z-10 mx-auto max-w-4xl text-center text-white">
                <div class="reveal">
                    <p class="mb-4 text-xs font-bold uppercase tracking-[0.28em] text-[#c084fc]">Get Started</p>
                    <h2 class="font-headline text-3xl font-extrabold leading-tight md:text-[2.8rem]">
                        Confused About Your <span class="text-gradient">Career?</span>
                    </h2>
                    <p class="mt-4 text-base text-white/70">
                        Talk to our expert mentor &amp; get free guidance for your next move in tech.
                    </p>
                    <a href="/mentorship#talktomentor"
                       class="btn-shimmer btn-primary mt-9 inline-flex items-center gap-2 rounded-full bg-white px-9 py-4 text-sm font-bold text-primary shadow-hero transition">
                        <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                        Book Free Session
                    </a>
                </div>
            </div>
        </section>

    </main>

    <div id="galleryLightbox" class="gallery-lightbox" hidden>
        <div class="gallery-lightbox-panel">
            <button id="galleryLightboxClose" type="button" class="gallery-lightbox-close" aria-label="Close gallery preview">
                <span class="material-symbols-outlined">close</span>
            </button>
            <div id="galleryLightboxMedia" class="gallery-lightbox-media"></div>
            <div class="border-t border-white/10 px-5 py-4 text-white">
                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-white/60">Gallery Preview</p>
                <p id="galleryLightboxTitle" class="mt-2 text-base font-semibold text-white md:text-lg"></p>
            </div>
        </div>
    </div>

    <x-home.footer />

    <!-- ════════════════════════════════════════
         SCRIPTS
    ════════════════════════════════════════ -->
    <script>
    (function () {
        /* ── Scroll progress ────────────────────── */
        var progressBar = document.getElementById('scroll-progress');
        window.addEventListener('scroll', function () {
            var scrolled = (document.documentElement.scrollTop / (document.documentElement.scrollHeight - document.documentElement.clientHeight)) * 100;
            if (progressBar) progressBar.style.width = scrolled + '%';
        }, { passive: true });

        /* ── Intersection Observer (reveal) ─────── */
        var revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(function (el) { observer.observe(el); });

        /* ── Counter animation ──────────────────── */
        var counters = document.querySelectorAll('.counter-num[data-target]');
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                var target = parseInt(el.dataset.target, 10);
                var duration = 1800;
                var start = null;

                function step(ts) {
                    if (!start) start = ts;
                    var progress = Math.min((ts - start) / duration, 1);
                    var ease = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.floor(ease * target);
                    if (progress < 1) requestAnimationFrame(step);
                    else el.textContent = target;
                }

                requestAnimationFrame(step);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(function (el) { counterObserver.observe(el); });

        var promoTrack = document.getElementById('homePromoTrack');
        var promoPrev = document.getElementById('homePromoPrev');
        var promoNext = document.getElementById('homePromoNext');
        var promoDots = document.querySelectorAll('[data-slide-dot]');
        var galleryLightbox = document.getElementById('galleryLightbox');
        var galleryLightboxMedia = document.getElementById('galleryLightboxMedia');
        var galleryLightboxTitle = document.getElementById('galleryLightboxTitle');
        var galleryLightboxClose = document.getElementById('galleryLightboxClose');

        if (promoTrack) {
            var promoIndex = 0;
            var promoSlides = promoTrack.querySelectorAll('.promo-slide');
            var promoCount = promoSlides.length;
            var promoTimer = null;
            var promoInterval = 3200;
            var promoStartX = 0;
            var promoSwipeThreshold = 45;

            function renderPromo(index) {
                if (!promoCount) return;
                promoIndex = (index + promoCount) % promoCount;
                promoTrack.style.transform = 'translate3d(-' + (promoIndex * 100) + '%, 0, 0)';
                promoDots.forEach(function (dot, idx) {
                    dot.classList.toggle('is-active', idx === promoIndex);
                });
            }

            function startPromoAutoplay() {
                clearInterval(promoTimer);
                if (promoCount <= 1) return;
                promoTimer = setInterval(function () {
                    renderPromo(promoIndex + 1);
                }, promoInterval);
            }

            function stopPromoAutoplay() {
                clearInterval(promoTimer);
            }

            if (promoPrev) {
                promoPrev.addEventListener('click', function () {
                    renderPromo(promoIndex - 1);
                    startPromoAutoplay();
                });
            }

            if (promoNext) {
                promoNext.addEventListener('click', function () {
                    renderPromo(promoIndex + 1);
                    startPromoAutoplay();
                });
            }

            promoDots.forEach(function (dot, idx) {
                dot.addEventListener('click', function () {
                    renderPromo(idx);
                    startPromoAutoplay();
                });
            });

            promoTrack.addEventListener('mouseenter', function () {
                stopPromoAutoplay();
            });

            promoTrack.addEventListener('mouseleave', function () {
                startPromoAutoplay();
            });

            promoTrack.addEventListener('touchstart', function (event) {
                if (!event.touches.length) return;
                promoStartX = event.touches[0].clientX;
                stopPromoAutoplay();
            }, { passive: true });

            promoTrack.addEventListener('touchend', function (event) {
                if (!event.changedTouches.length) return;
                var deltaX = event.changedTouches[0].clientX - promoStartX;
                if (Math.abs(deltaX) >= promoSwipeThreshold) {
                    renderPromo(deltaX < 0 ? promoIndex + 1 : promoIndex - 1);
                }
                startPromoAutoplay();
            }, { passive: true });

            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    stopPromoAutoplay();
                } else {
                    startPromoAutoplay();
                }
            });

            renderPromo(0);
            window.requestAnimationFrame(function () {
                startPromoAutoplay();
            });
        }

        /* ── Navbar shrink on scroll ────────────── */
        var placementPagesWrap = document.getElementById('homePlacementsPages');
        var placementPrev = document.getElementById('homePlacementsPrev');
        var placementNext = document.getElementById('homePlacementsNext');
        var placementCount = document.getElementById('homePlacementsCount');

        if (placementPagesWrap) {
            var placementIndex = 0;
            var placementPages = placementPagesWrap.querySelectorAll('[data-placement-page]');
            var placementTotal = placementPages.length;

            function renderPlacementPage(index) {
                placementIndex = (index + placementTotal) % placementTotal;
                placementPages.forEach(function (page, idx) {
                    page.classList.toggle('is-active', idx === placementIndex);
                });
                if (placementCount) {
                    placementCount.textContent = (placementIndex + 1) + ' / ' + placementTotal;
                }
            }

            if (placementPrev) {
                placementPrev.addEventListener('click', function () {
                    renderPlacementPage(placementIndex - 1);
                });
            }

            if (placementNext) {
                placementNext.addEventListener('click', function () {
                    renderPlacementPage(placementIndex + 1);
                });
            }

            renderPlacementPage(0);
        }

        if (galleryLightbox && galleryLightboxMedia && galleryLightboxTitle) {
            function closeGalleryLightbox() {
                var activeVideo = galleryLightboxMedia.querySelector('video');
                if (activeVideo) {
                    activeVideo.pause();
                    activeVideo.removeAttribute('src');
                    activeVideo.load();
                }
                galleryLightbox.setAttribute('hidden', '');
                galleryLightboxMedia.innerHTML = '';
                document.body.classList.remove('overflow-hidden');
            }

            function openGalleryLightbox(trigger) {
                var mediaUrl = trigger.getAttribute('data-gallery-media');
                var mediaTitle = trigger.getAttribute('data-gallery-title') || 'CodeInYourself achievement';
                var mediaType = trigger.getAttribute('data-gallery-type') || 'image';
                var posterUrl = trigger.getAttribute('data-gallery-poster') || '';

                if (!mediaUrl) return;

                galleryLightboxTitle.textContent = mediaTitle;

                if (mediaType === 'video') {
                    galleryLightboxMedia.innerHTML =
                        '<video controls autoplay playsinline poster="' + posterUrl.replace(/"/g, '&quot;') + '">' +
                            '<source src="' + mediaUrl.replace(/"/g, '&quot;') + '">' +
                        '</video>';
                } else {
                    galleryLightboxMedia.innerHTML = '<img src="' + mediaUrl.replace(/"/g, '&quot;') + '" alt="' + mediaTitle.replace(/"/g, '&quot;') + '">';
                }

                galleryLightbox.removeAttribute('hidden');
                document.body.classList.add('overflow-hidden');
            }

            document.querySelectorAll('[data-gallery-trigger]').forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    openGalleryLightbox(trigger);
                });

                trigger.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openGalleryLightbox(trigger);
                    }
                });
            });

            if (galleryLightboxClose) {
                galleryLightboxClose.addEventListener('click', closeGalleryLightbox);
            }

            galleryLightbox.addEventListener('click', function (event) {
                if (event.target === galleryLightbox) {
                    closeGalleryLightbox();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !galleryLightbox.hasAttribute('hidden')) {
                    closeGalleryLightbox();
                }
            });
        }

        document.querySelectorAll('[data-video-gallery]').forEach(function (gallery) {
            var track = gallery.querySelector('[data-video-track]');
            var prev = gallery.querySelector('[data-video-nav="prev"]');
            var next = gallery.querySelector('[data-video-nav="next"]');

            if (prev && track) {
                prev.addEventListener('click', function () {
                    track.scrollBy({ left: -280, behavior: 'smooth' });
                });
            }

            if (next && track) {
                next.addEventListener('click', function () {
                    track.scrollBy({ left: 280, behavior: 'smooth' });
                });
            }
        });

        var navbar = document.querySelector('nav');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 60) {
                navbar && navbar.classList.add('nav-scrolled');
            } else {
                navbar && navbar.classList.remove('nav-scrolled');
            }
        }, { passive: true });
    })();
    </script>

    <style>
        nav.nav-scrolled {
            background: rgba(14, 6, 34, 0.88) !important;
            backdrop-filter: blur(20px) !important;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .section-gradient-purple {
            background: linear-gradient(160deg, #0e0622 0%, #2d0f55 50%, #1a0533 100%);
        }
    </style>

</body>
</html>
