<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts (Solo JS de Vite) -->
        @vite(['resources/js/app.js'])

        <!-- =================================================================== -->
        <!-- AÑADIMOS BOOTSTRAP CSS y ICONS (vía CDN) -->
        <!-- =================================================================== -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- =================================================================== -->
    </head>
    <body>
        {{-- Reemplazamos clases de Tailwind por Bootstrap --}}
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4 bg-body-tertiary">
            
            {{-- Logo --}}
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            {{-- Contenedor del formulario (login, register, etc.) --}}
            {{-- Reemplazamos clases de Tailwind por Bootstrap 'card' --}}
            <div class="col-lg-4 col-md-6 col-sm-8 w-100 mx-auto mt-4">
                <div class="card shadow-sm rounded-3 border-0">
                    <div class="card-body p-4 p-md-5">
                         {{ $slot }} {{-- Aquí se carga el contenido de login.blade.php, etc. --}}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap JS (Necesario para algunas funciones de formulario si se añaden) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
