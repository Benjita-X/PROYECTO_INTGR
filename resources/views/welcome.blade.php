<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f8f9fa; /* bg-light */
            }
            
            /* --- ESTILOS PARA EL CARRUSEL --- */
            .hero-carousel .carousel-item {
                height: 60vh; /* 60% de la altura de la pantalla */
                min-height: 400px;
                background-color: #333; /* Color de fondo mientras carga la imagen */
                position: relative; /* Necesario para la superposición */
            }
            
            .hero-carousel .carousel-item img {
                object-fit: cover; /* Asegura que la imagen cubra todo */
                width: 100%;
                height: 100%;
            }
            
            /* --- ¡NUEVO Y MEJORADO! Contraste para el texto del carrusel --- */
            .hero-carousel .carousel-caption {
                background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente oscuro */
                padding: 1.5rem 2rem;
                border-radius: 0.5rem;
                bottom: 20%; /* Posicionamiento */
                left: 10%;
                right: 10%;
                max-width: 80%; /* Ancho máximo para el caption */
                margin: auto;
            }

            /* Estilos para el logo de la navbar */
            .navbar-brand .site-logo {
                height: 35px; /* Altura deseada para tu logo */
                margin-right: 0.5rem;
            }

            /* Asegura que el texto dentro del caption siempre sea blanco para mejor contraste */
            .hero-carousel .carousel-caption h1,
            .hero-carousel .carousel-caption p {
                color: white !important;
            }
            /* --- FIN ESTILOS CARRUSEL --- */

        </style>
    </head>
    <body class="antialiased">

        {{-- ====================================================== --}}
        {{-- BARRA DE NAVEGACIÓN (PREPARADA PARA TU LOGO) --}}
        {{-- ====================================================== --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold fs-4" href="/">
                    <img src="{{ asset('images/INACAP_LOGO.png') }}" alt="Logo" class="site-logo"> 
                    Gestion Inclusiva
                </a>
                
                <div class="d-flex">
                    @if (Route::has('login'))
                        @auth
                            @php
                                $userRolName = Auth::user()?->rol?->nombre_rol;
                                $navDashboardRoute = match($userRolName) {
                                    'Administrador' => route('admin.dashboard'),
                                    'Asesoría Pedagógica' => route('asesoria.dashboard'),
                                    'Director de Carrera' => route('director.dashboard'),
                                    'Docente' => route('docente.dashboard'),
                                    'Estudiante' => route('estudiante.dashboard'),
                                    default => url('/dashboard'), 
                                };
                            @endphp
                            <a href="{{ $navDashboardRoute }}" class="btn btn-primary">
                                <i class="bi bi-person-circle me-1"></i> Mi Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                    <i class="bi bi-person-plus-fill me-1"></i> Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        {{-- ====================================================== --}}
        {{-- CARRUSEL (Con Contraste Mejorado y Automático) --}}
        {{-- ====================================================== --}}
        <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            
            <div class="carousel-inner">
                
                <div class="carousel-item active">
                    <img src="{{ asset('images/slide1.jpg') }}" alt="Gestión de Casos">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-4 fw-bold">Gestión Académica Inclusiva</h1>
                        <p class="fs-4 lead">Centralizamos el proceso de ajustes académicos.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('images/slide2.jpg') }}" alt="Trazabilidad">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-4 fw-bold">Trazabilidad Completa</h1>
                        <p class="fs-4 lead">Seguimiento desde Asesoría hasta la confirmación del Docente.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('images/slide3.jpg') }}" alt="Comunicación">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-4 fw-bold">Comunicación Efectiva</h1>
                        <p class="fs-4 lead">Aseguramos que la información llegue a todos los roles involucrados.</p>
                    </div>
                </div>

            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        {{-- ====================================================== --}}
        {{-- FIN DEL CARRUSEL --}}
        {{-- ====================================================== --}}

        
        {{-- ====================================================== --}}
        {{-- SECCIÓN DE BIENVENIDA --}}
        {{-- ====================================================== --}}
        <div class="container text-center my-5 py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold lh-1 mb-3 mt-3">Sistema de Gestión Académica Inclusiva</h1>
                    <p class="lead fs-5 text-muted">
                        Bienvenido al portal de gestión de ajustes académicos. Por favor, inicie sesión o regístrese para acceder al sistema.
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        @if (Route::has('login'))
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="bi bi-person-plus-fill me-1"></i> Registrarse
                                    </a>
                                @endif
                            @endguest
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- ====================================================== --}}
        {{-- FIN DE SECCIÓN DE BIENVENIDA --}}
        {{-- ====================================================== --}}


        {{-- ====================================================== --}}
        {{-- FOOTER (Simplificado) --}}
        {{-- ====================================================== --}}
        <div class="container-fluid bg-white border-top">
             <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 my-4 px-4">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} Gestion Inclusiva</p>
             </footer>
        </div>
        {{-- ====================================================== --}}
        {{-- FIN DEL FOOTER --}}
        {{-- ====================================================== --}}

        {{-- ¡ERROR CORREGIDO! 'xintegrity' ahora es 'integrity' --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>