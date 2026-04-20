@once
    <style>
        #globalPageLoader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(14, 6, 34, 0.82);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 200ms ease, visibility 200ms ease;
            visibility: hidden;
        }

        #globalPageLoader.is-visible {
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
        }

        #globalPageLoaderBar {
            position: absolute;
            inset: 0 auto auto 0;
            height: 3px;
            width: 100%;
            overflow: hidden;
            background: rgba(124, 58, 237, 0.12);
        }

        #globalPageLoaderBar::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 -35%;
            width: 35%;
            border-radius: 999px;
            background: linear-gradient(90deg, #7c3aed, #a855f7, #c084fc);
            animation: global-loader-slide 1s ease-in-out infinite;
        }

        #globalPageLoaderCard {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-width: 200px;
            padding: 1rem 1.3rem;
            border-radius: 1.2rem;
            border: 1px solid rgba(168, 85, 247, 0.2);
            background: rgba(30, 8, 64, 0.9);
            box-shadow: 0 24px 60px -24px rgba(124, 58, 237, 0.5), 0 0 40px rgba(168, 85, 247, 0.1);
        }

        #globalPageLoaderSpinner {
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 999px;
            border: 3px solid rgba(168, 85, 247, 0.15);
            border-top-color: #a855f7;
            animation: global-loader-spin 0.9s linear infinite;
            flex-shrink: 0;
        }

        #globalPageLoaderText {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.01em;
        }

        @keyframes global-loader-spin {
            to { transform: rotate(360deg); }
        }

        @keyframes global-loader-slide {
            0%   { transform: translateX(0); }
            100% { transform: translateX(400%); }
        }
    </style>

    <div id="globalPageLoader" aria-hidden="true">
        <div id="globalPageLoaderBar"></div>
        <div id="globalPageLoaderCard">
            <div id="globalPageLoaderSpinner"></div>
            <div id="globalPageLoaderText">Loading your page...</div>
        </div>
    </div>

    <script>
        (function () {
            if (window.__globalPageLoaderBooted) return;
            window.__globalPageLoaderBooted = true;

            var loader = document.getElementById('globalPageLoader');

            function showLoader() { loader && loader.classList.add('is-visible'); }
            function hideLoader() { loader && loader.classList.remove('is-visible'); }

            function initMediaLoading() {
                document.querySelectorAll('img:not([loading])').forEach(function (img, i) {
                    if (img.hasAttribute('data-eager')) return;
                    img.setAttribute('loading', i < 2 ? 'eager' : 'lazy');
                    img.setAttribute('decoding', 'async');
                });
                document.querySelectorAll('iframe:not([loading])').forEach(function (f) { f.setAttribute('loading', 'lazy'); });
                document.querySelectorAll('video:not([preload])').forEach(function (v) { v.setAttribute('preload', 'metadata'); });
            }

            document.addEventListener('DOMContentLoaded', function () {
                hideLoader();
                if ('requestIdleCallback' in window) {
                    window.requestIdleCallback(initMediaLoading, { timeout: 1200 });
                } else {
                    window.setTimeout(initMediaLoading, 120);
                }
            });

            window.addEventListener('load', function () { window.setTimeout(hideLoader, 120); });
            window.addEventListener('pageshow', hideLoader);
            window.setTimeout(hideLoader, 1200);

            document.addEventListener('click', function (e) {
                var link = e.target.closest('a[href]');
                if (!link) return;
                if (link.target === '_blank' || link.hasAttribute('download')) return;
                var href = link.getAttribute('href') || '';
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                showLoader();
            });

            document.addEventListener('submit', function (e) {
                var form = e.target;
                if (!(form instanceof HTMLFormElement)) return;
                if (form.target === '_blank') return;
                showLoader();
            });
        })();
    </script>
@endonce
