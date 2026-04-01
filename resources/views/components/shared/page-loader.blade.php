@once
    <style>
        #globalPageLoader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(248, 249, 250, 0.88);
            backdrop-filter: blur(10px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 180ms ease, visibility 180ms ease;
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
            background: rgba(79, 70, 229, 0.1);
        }

        #globalPageLoaderBar::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 -35%;
            width: 35%;
            border-radius: 999px;
            background: linear-gradient(90deg, #0c4ea3, #1570d8);
            animation: global-loader-slide 1s ease-in-out infinite;
        }

        #globalPageLoaderCard {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-width: 200px;
            padding: 1rem 1.1rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 24px 60px -24px rgba(15, 23, 42, 0.3);
        }

        #globalPageLoaderSpinner {
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 999px;
            border: 3px solid rgba(79, 70, 229, 0.16);
            border-top-color: #0c4ea3;
            animation: global-loader-spin 0.9s linear infinite;
            flex-shrink: 0;
        }

        #globalPageLoaderText {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            letter-spacing: 0.01em;
        }

        @keyframes global-loader-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes global-loader-slide {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(400%);
            }
        }
    </style>

    <div id="globalPageLoader" class="is-visible" aria-hidden="true">
        <div id="globalPageLoaderBar"></div>
        <div id="globalPageLoaderCard">
            <div id="globalPageLoaderSpinner"></div>
            <div id="globalPageLoaderText">Loading your page...</div>
        </div>
    </div>

    <script>
        (function () {
            if (window.__globalPageLoaderBooted) {
                return;
            }

            window.__globalPageLoaderBooted = true;

            var loader = document.getElementById('globalPageLoader');

            function showLoader() {
                if (!loader) return;
                loader.classList.add('is-visible');
            }

            function hideLoader() {
                if (!loader) return;
                loader.classList.remove('is-visible');
            }

            function initMediaLoading() {
                document.querySelectorAll('img:not([loading])').forEach(function (image, index) {
                    if (image.hasAttribute('data-eager')) {
                        return;
                    }

                    image.setAttribute('loading', index < 2 ? 'eager' : 'lazy');
                    image.setAttribute('decoding', 'async');
                });

                document.querySelectorAll('iframe:not([loading])').forEach(function (frame) {
                    frame.setAttribute('loading', 'lazy');
                });

                document.querySelectorAll('video:not([preload])').forEach(function (video) {
                    video.setAttribute('preload', 'metadata');
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                if ('requestIdleCallback' in window) {
                    window.requestIdleCallback(initMediaLoading, { timeout: 1200 });
                } else {
                    window.setTimeout(initMediaLoading, 120);
                }
            });

            window.addEventListener('load', function () {
                window.setTimeout(hideLoader, 120);
            });

            window.addEventListener('pageshow', hideLoader);

            document.addEventListener('click', function (event) {
                var link = event.target.closest('a[href]');

                if (!link) return;
                if (link.target === '_blank' || link.hasAttribute('download')) return;

                var href = link.getAttribute('href') || '';

                if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
                    return;
                }

                if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                    return;
                }

                showLoader();
            });

            document.addEventListener('submit', function (event) {
                var form = event.target;

                if (!(form instanceof HTMLFormElement)) {
                    return;
                }

                if (form.target === '_blank') {
                    return;
                }

                showLoader();
            });
        })();
    </script>
@endonce

