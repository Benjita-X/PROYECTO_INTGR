<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Olvidé mi Contraseña - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa; /* bg-light */
        }
        .forgot-card {
            max-width: 500px;
        }
    </style>
</head>
<body class="antialiased">
    
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row">
            <div class="col">
                
                <div class="card shadow-lg border-0 rounded-4 forgot-card w-100">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <h1 class="fs-4 fw-semibold mt-3">¿Olvidaste tu Contraseña?</h1>
                        </div>

                        <p class="text-muted text-center mb-4">
                            No hay problema. Indícanos tu correo y te enviaremos un enlace para restablecer tu contraseña.
                        </p>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">Correo Electrónico</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                                    Enviar Enlace de Restablecimiento
                                </button>
                            </div>
                            
                            <p class="text-center text-muted mt-4 mb-0">
                                <a href="{{ route('login') }}" class="text-decoration-none fw-medium">Volver a Iniciar Sesión</a>
                            </p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>