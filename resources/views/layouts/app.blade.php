<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }

        body {
            background: radial-gradient(circle at 10% 20%, #e0f2fe 0, rgba(224, 242, 254, 0) 25%),
                        radial-gradient(circle at 90% 10%, #ccfbf1 0, rgba(204, 251, 241, 0) 28%),
                        #f8fafc;
            color: #0f172a;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .lightbox-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            z-index: 50;
        }

        .lightbox-overlay.active {
            display: flex;
        }

        .lightbox-image {
            max-width: min(960px, 92vw);
            max-height: 80vh;
            border-radius: 1.25rem;
            box-shadow: 0 40px 80px rgba(15, 23, 42, 0.45);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.92);
            padding: 0.5rem 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
        }

        .lightbox-nav[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-6">
            <a class="flex items-center gap-3 font-semibold text-slate-900" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logos/logo.png') }}" alt="{{ env('APP_NAME') }} logo" class="brand-logo">
                <div>
                    <div class="text-lg">{{ env('APP_NAME') }}</div>
                    <div class="text-sm text-slate-500">Reportes cívicos en tiempo real</div>
                </div>
            </a>
            <button class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm md:hidden" id="nav-toggle" type="button">
                Menú
            </button>
            <div class="hidden items-center gap-6 text-sm font-semibold text-slate-700 md:flex" id="main-nav">
                <a class="transition hover:text-sky-600" href="{{ url('/') }}">Inicio</a>
                <a class="transition hover:text-sky-600" href="{{ route('dashboard') }}">Tablero</a>
            </div>
        </nav>
    </header>

    <!-- Main -->
    <main class="mx-auto w-full max-w-6xl px-4 pb-16 pt-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 py-6 text-center text-sm text-slate-200">
        &copy; {{ date('Y') }} {{ env('APP_NAME') }}. Todos los derechos reservados.
    </footer>

    <div class="lightbox-overlay" id="lightbox-overlay" aria-hidden="true">
        <button class="absolute right-6 top-6 rounded-full bg-white/90 px-3 py-1 text-sm font-semibold text-slate-700 shadow-lg" type="button" id="lightbox-close">Cerrar</button>
        <button class="lightbox-nav left-6" type="button" id="lightbox-prev" aria-label="Anterior">‹</button>
        <button class="lightbox-nav right-6" type="button" id="lightbox-next" aria-label="Siguiente">›</button>
        <img src="" alt="Vista ampliada" class="lightbox-image" id="lightbox-image">
    </div>

    <!-- Scripts -->
    <script>
        const navToggle = document.getElementById('nav-toggle');
        const mainNav = document.getElementById('main-nav');
        if (navToggle && mainNav) {
            navToggle.addEventListener('click', () => {
                mainNav.classList.toggle('hidden');
                mainNav.classList.toggle('flex');
                mainNav.classList.toggle('flex-col');
                mainNav.classList.toggle('rounded-2xl');
                mainNav.classList.toggle('bg-white');
                mainNav.classList.toggle('p-4');
                mainNav.classList.toggle('shadow-lg');
                mainNav.classList.toggle('absolute');
                mainNav.classList.toggle('right-4');
                mainNav.classList.toggle('top-20');
                mainNav.classList.toggle('w-48');
            });
        }

        const lightboxOverlay = document.getElementById('lightbox-overlay');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxNext = document.getElementById('lightbox-next');

        let lightboxGallery = [];
        let lightboxIndex = 0;

        const renderLightbox = (src, alt) => {
            if (!lightboxOverlay || !lightboxImage) return;
            lightboxImage.src = src;
            lightboxImage.alt = alt || 'Vista ampliada';
            lightboxOverlay.classList.add('active');
            lightboxOverlay.setAttribute('aria-hidden', 'false');
            if (lightboxPrev && lightboxNext) {
                const hasGallery = lightboxGallery.length > 1;
                lightboxPrev.style.display = hasGallery ? 'block' : 'none';
                lightboxNext.style.display = hasGallery ? 'block' : 'none';
            }
        };

        const closeLightbox = () => {
            if (!lightboxOverlay) return;
            lightboxOverlay.classList.remove('active');
            lightboxOverlay.setAttribute('aria-hidden', 'true');
        };

        const openLightbox = (src, alt, gallery = [], index = 0) => {
            lightboxGallery = Array.isArray(gallery) ? gallery : [];
            lightboxIndex = index;
            const resolvedSrc = lightboxGallery[lightboxIndex] || src;
            renderLightbox(resolvedSrc, alt);
        };

        const navigateLightbox = (direction) => {
            if (!lightboxGallery.length) return;
            lightboxIndex = (lightboxIndex + direction + lightboxGallery.length) % lightboxGallery.length;
            renderLightbox(lightboxGallery[lightboxIndex], lightboxImage?.alt);
        };

        document.addEventListener('click', (event) => {
            const target = event.target.closest('[data-lightbox]');
            if (!target) return;
            event.preventDefault();
            const src = target.getAttribute('data-full') || target.getAttribute('src');
            const gallery = target.getAttribute('data-gallery');
            const index = parseInt(target.getAttribute('data-index') || '0', 10);
            openLightbox(src, target.getAttribute('alt'), gallery ? JSON.parse(gallery) : [], index);
        });

        if (lightboxOverlay) {
            lightboxOverlay.addEventListener('click', (event) => {
                if (event.target === lightboxOverlay) {
                    closeLightbox();
                }
            });
        }

        if (lightboxClose) {
            lightboxClose.addEventListener('click', closeLightbox);
        }

        if (lightboxPrev) {
            lightboxPrev.addEventListener('click', (event) => {
                event.stopPropagation();
                navigateLightbox(-1);
            });
        }

        if (lightboxNext) {
            lightboxNext.addEventListener('click', (event) => {
                event.stopPropagation();
                navigateLightbox(1);
            });
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeLightbox();
            }
            if (event.key === 'ArrowLeft') {
                navigateLightbox(-1);
            }
            if (event.key === 'ArrowRight') {
                navigateLightbox(1);
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
