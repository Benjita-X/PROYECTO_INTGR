<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

        @vite(['resources/js/app.js'])

        {{-- ¡ERROR CORREGIDO! Decía 'xintegrity' y ahora dice 'integrity' --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        </head>
    <body> {{-- Eliminamos las clases de Tailwind 'font-sans antialiased' --}}

        {{-- Reemplazamos clases de Tailwind (min-h-screen bg-gray-100) con Bootstrap (min-vh-100 bg-body-tertiary) --}}
        <div class="min-vh-100 bg-body-tertiary">
            
            {{-- Cargamos la barra de navegación horizontal --}}
            @include('layouts.navigation')

            @if (isset($header))
                {{-- Reemplazamos clases de Tailwind (bg-white shadow) con Bootstrap (bg-body shadow-sm) --}}
                <header class="bg-body shadow-sm">
                    {{-- Reemplazamos clases de Tailwind (max-w-7xl...) con Bootstrap (container-lg py-4 px-4) --}}
                    <div class="container-lg py-4 px-4">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }} {{-- Aquí es donde se carga tu index.blade.php --}}
            </main>
        </div>

        {{-- Esto debe ir ANTES de cerrar </body> para que funcione la interactividad (como dropdowns, modales, etc.) --}}
        {{-- ¡ERROR CORREGIDO! Decía 'xintegrity' y ahora dice 'integrity' --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>