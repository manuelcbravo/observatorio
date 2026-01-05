<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Observatorio Ciudadano</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #0f766e;
            --brand-secondary: #0ea5e9;
            --surface: #ffffff;
            --muted: #6b7280;
            --border: #e5e7eb;
        }

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }

        body {
            background: radial-gradient(circle at 10% 20%, #e0f2fe 0, rgba(224, 242, 254, 0) 25%),
                        radial-gradient(circle at 90% 10%, #ccfbf1 0, rgba(204, 251, 241, 0) 28%),
                        #f8fafc;
            color: #0f172a;
        }

        header.navbar { background: transparent; }

        header .navbar-brand, header .nav-link { color: #0f172a !important; }

        header .navbar-brand {
            letter-spacing: 0.4px;
        }

        header .badge {
            background: rgba(14, 165, 233, 0.12);
            color: #0369a1;
        }

        .nav-link { transition: color 0.2s ease; }
        .nav-link:hover { color: var(--brand-secondary) !important; }

        footer {
            background: #0f172a;
            padding: 1rem 0;
            text-align: center;
            font-size: .9rem;
            color: #e2e8f0;
        }

        .form-card {
            background: var(--surface);
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: 0 20px 70px rgba(15, 118, 110, 0.08);
            border: 1px solid var(--border);
        }

        .map-container { height: 320px; border-radius: 14px; overflow: hidden; border: 1px solid var(--border); }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            border: none;
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.25);
        }

        .btn-primary:hover { filter: brightness(1.05); }

        .badge-soft {
            background: #eef2ff;
            color: #312e81;
        }

        .input-elevated {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.65rem 0.85rem;
        }

        .section-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .subtle-card {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.08), rgba(15, 118, 110, 0.08));
            border: 1px dashed rgba(14, 165, 233, 0.3);
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center fw-bold text-dark" href="#">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-dark text-white me-2" style="width: 44px; height: 44px;">
                        OC
                    </div>
                    <div>
                        <div>Observatorio Ciudadano</div>
                        <small class="text-muted fw-medium">Reportes cívicos en tiempo real</small>
                    </div>
                </a>

                <!-- Botón móvil -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú -->
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="{{ url('/') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="{{ url('/') }}#reportes">Reportes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="{{ route('dashboard.demo') }}">Tablero demo</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <span class="badge rounded-pill text-uppercase">Beta pública</span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            &copy; {{ date('Y') }} Observatorio Ciudadano. Todos los derechos reservados.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
