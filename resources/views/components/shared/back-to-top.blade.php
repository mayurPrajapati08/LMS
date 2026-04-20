@once
    <style>
        #globalBackToTop {
            --scroll-progress: 0;
            --ring-track: rgba(177, 144, 67, 0.24);
            --ring-fill-start: rgb(248 231 179);
            --ring-fill-mid: rgb(224 185 94);
            --ring-fill-end: rgb(154 112 33);
            position: fixed;
            right: 1.2rem;
            bottom: 1.2rem;
            z-index: 70;
            display: inline-grid;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            border: 0;
            border-radius: 9999px;
            background: transparent;
            color: #ffffff;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(14px) scale(0.94);
            transition: opacity 180ms ease, transform 180ms ease, visibility 180ms ease, filter 180ms ease;
        }

        #globalBackToTop.is-visible {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
            animation: backToTopFloat 3.2s ease-in-out infinite;
        }

        #globalBackToTop.is-scrolling {
            animation: backToTopLaunch 680ms cubic-bezier(0.16, 1, 0.3, 1);
        }

        #globalBackToTop:hover {
            filter: brightness(1.03);
            transform: translateY(-2px) scale(1.02);
            animation-play-state: paused;
        }

        #globalBackToTop svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
            overflow: visible;
            pointer-events: none;
            transition: transform 240ms ease;
        }

        #globalBackToTop:hover svg {
            transform: rotate(-90deg) scale(1.03);
        }

        #globalBackToTopTrack {
            fill: none;
            stroke: var(--ring-track);
            stroke-width: 1.7;
        }

        #globalBackToTopProgress {
            fill: none;
            stroke: url(#globalBackToTopGradient);
            stroke-width: 2.1;
            stroke-linecap: round;
            stroke-dasharray: 131.95;
            stroke-dashoffset: calc(131.95 - (131.95 * var(--scroll-progress)));
            transition: stroke-dashoffset 140ms linear, stroke 180ms ease, filter 180ms ease;
            filter: drop-shadow(0 4px 12px rgba(176, 132, 42, 0.24));
        }

        #globalBackToTop:hover #globalBackToTopProgress {
            filter: drop-shadow(0 6px 15px rgba(194, 148, 51, 0.32));
        }

        #globalBackToTopInner {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.55rem;
            height: 2.55rem;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.12);
            background:
                radial-gradient(circle at 30% 25%, rgba(255,255,255,0.14), transparent 28%),
                linear-gradient(135deg, rgba(22, 8, 51, 0.96), rgba(76, 29, 149, 0.94));
            box-shadow:
                0 12px 26px rgba(59, 26, 112, 0.13),
                inset 0 1px 0 rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: transform 220ms ease, box-shadow 220ms ease, background 220ms ease;
        }

        #globalBackToTopInner::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(255,255,255,0.26), transparent 48%, rgba(124,58,237,0.08));
            opacity: 0.8;
            pointer-events: none;
        }

        #globalBackToTop:hover #globalBackToTopInner {
            transform: scale(1.03);
            box-shadow:
                0 16px 30px rgba(129, 93, 24, 0.18),
                inset 0 1px 0 rgba(255,255,255,0.16);
        }

        #globalBackToTop .material-symbols-outlined {
            font-size: 1.25rem;
            line-height: 1;
            color: rgba(255,255,255,0.94);
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            transition: transform 220ms ease, color 220ms ease;
        }

        #globalBackToTop:hover .material-symbols-outlined {
            transform: translateY(-1px);
            color: #f7e5b2;
        }

        @keyframes backToTopFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1);
            }
        }

        @keyframes backToTopLaunch {
            0% {
                transform: translateY(0) scale(1);
            }
            30% {
                transform: translateY(-6px) scale(1.04);
            }
            55% {
                transform: translateY(-18px) scale(0.98);
            }
            100% {
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 640px) {
            #globalBackToTop {
                right: 0.9rem;
                bottom: 0.9rem;
                width: 3.2rem;
                height: 3.2rem;
            }

            #globalBackToTopInner {
                width: 2.3rem;
                height: 2.3rem;
            }

            #globalBackToTop .material-symbols-outlined {
                font-size: 1.1rem;
            }
        }
    </style>

    <button id="globalBackToTop" type="button" aria-label="Go to top">
        <svg viewBox="0 0 48 48" aria-hidden="true">
            <defs>
                <linearGradient id="globalBackToTopGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="var(--ring-fill-start)"></stop>
                    <stop offset="52%" stop-color="var(--ring-fill-mid)"></stop>
                    <stop offset="100%" stop-color="var(--ring-fill-end)"></stop>
                </linearGradient>
            </defs>
            <circle id="globalBackToTopTrack" cx="24" cy="24" r="21"></circle>
            <circle id="globalBackToTopProgress" cx="24" cy="24" r="21"></circle>
        </svg>
        <span id="globalBackToTopInner">
            <span class="material-symbols-outlined">north</span>
        </span>
    </button>

    <script>
        (function () {
            if (window.__globalBackToTopBooted) return;
            window.__globalBackToTopBooted = true;

            var button = document.getElementById('globalBackToTop');
            if (!button) return;

            function syncBackToTopVisibility() {
                var doc = document.documentElement;
                var total = doc.scrollHeight - doc.clientHeight;
                var progress = total > 0 ? Math.min(Math.max(window.scrollY / total, 0), 1) : 0;

                button.classList.toggle('is-visible', window.scrollY > 320);
                button.style.setProperty('--scroll-progress', progress.toFixed(4));
            }

            button.addEventListener('click', function () {
                button.classList.remove('is-scrolling');
                void button.offsetWidth;
                button.classList.add('is-scrolling');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            button.addEventListener('animationend', function (event) {
                if (event.animationName === 'backToTopLaunch') {
                    button.classList.remove('is-scrolling');
                }
            });

            syncBackToTopVisibility();
            window.addEventListener('scroll', syncBackToTopVisibility, { passive: true });
            window.addEventListener('pageshow', syncBackToTopVisibility);
        })();
    </script>
@endonce
