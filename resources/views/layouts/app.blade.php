<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Observatorio Ciudadano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9f9f9; }
        header.navbar { background: #2f3542; }
        header .navbar-brand, header .nav-link, footer { color: #f1f2f6 !important; }
        footer { background: #2f3542; padding: 1rem 0; text-align: center; font-size: .9rem; }
        .form-card { background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .map-container { height: 300px; border-radius: 10px; overflow: hidden; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center fw-bold text-dark" href="#">
                    <img src="https://dummyimage.com/40x40/cccccc/000000.png&text=OC" 
                         alt="Logo" class="me-2 rounded-circle" width="40" height="40">
                    Observatorio Ciudadano
                </a>
    
                <!-- Botón móvil -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <!-- Menú -->
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="#">Reportes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="#">Contacto</a>
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
