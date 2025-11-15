<x-app-layout>
    {{-- 
      En lugar del div 'py-12 bg-gray-100', usamos 'py-5' de Bootstrap 
      El fondo 'bg-body-tertiary' ya está en app.blade.php 
    --}}
    <div class="py-5">
        {{-- ¡CAMBIO AQUÍ! De 'container-lg' a 'container-fluid px-4' para que ocupe todo el ancho --}}
        <div class="container-fluid px-4">

            {{-- Título --}}
            <h2 class="fw-semibold fs-2 mb-4">
                {{ Auth::user()->rol->nombre_rol }}
            </h2>

            {{-- Banner de Bienvenida: Usamos un div con clases de Bootstrap (color, gradiente, padding) --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow" style="background-color: #1cbebeff;"> {{-- Color Teal --}}
                <h3 class="fs-2 fw-bold">¡Bienvenido/a, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Panel principal para la gestión y seguimiento de casos de ajuste académico.</p>
            </div>

            {{-- Sección de Acciones Principales (Tarjetas) --}}
            {{-- Reemplazamos 'grid grid-cols-1...' con 'row g-4' (g-4 es el 'gap') --}}
            <div class="row g-4 mb-5">

                {{-- Tarjeta: Registrar Nuevo Caso --}}
                <div class="col-md-6">
                    {{-- Usamos el componente 'card' de Bootstrap. 'h-100' para igualar alturas. --}}
                    <div class="card shadow-sm rounded-3 h-100">
                        {{-- 'd-flex flex-column' nos permite usar 'mt-auto' en el botón --}}
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                {{-- Icono de Bootstrap (reemplaza SVG) --}}
                                <i class="bi bi-file-earmark-plus-fill fs-2 text-info me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Registrar Nuevo Caso</h4>
                                    <p class="card-text text-muted mt-1">Iniciar el proceso para un estudiante.</p>
                                </div>
                            </div>
                            <a href="{{ route('casos.create') }}"
                               class="btn btn-info mt-auto">
                                Crear Caso
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta: Ver Mis Casos --}}
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                {{-- Icono de Bootstrap --}}
                                <i class="bi bi-folder-fill fs-2 text-secondary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Ver Casos Registrados</h4>
                                    <p class="card-text text-muted mt-1">Consultar listado y estado actual.</p>
                                </div>
                            </div>
                            <a href="{{ route('casos.index') }}"
                               class="btn btn-secondary mt-auto">
                                Ver Listado
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ====================================================== --}}
            {{-- ¡SECCIÓN DE ESTADÍSTICAS ACTUALIZADA! --}}
            {{-- ====================================================== --}}
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-body-tertiary p-3">
                    <h4 class="fw-semibold fs-5 mb-0">Resumen Rápido (Mis Casos)</h4>
                </div>
                <div class="card-body p-4">
                    {{-- --- ¡INICIO DE LA MODIFICACIÓN! --- --}}
                    {{-- Cambiamos de 3 a 4 columnas (col-md-6 col-lg-3) --}}
                    <div class="row g-4 text-center">
                        
                        {{-- Tarjeta Estadística 1: Total Creados --}}
                        <div class="col-md-6 col-lg-3">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-primary">{{ $stats['creados'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Total Casos Creados</p>
                            </div>
                        </div>
                        
                        {{-- Tarjeta Estadística 2: Pendientes --}}
                        <div class="col-md-6 col-lg-3">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-warning">{{ $stats['pendientes'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Pendientes de Validación</p>
                            </div>
                        </div>
                        
                        {{-- Tarjeta Estadística 3: Aceptados --}}
                        <div class="col-md-6 col-lg-3">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-success">{{ $stats['aceptados'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Total Casos Aceptados</p>
                            </div>
                        </div>

                        {{-- Tarjeta Estadística 4: Rechazados (¡NUEVA!) --}}
                        <div class="col-md-6 col-lg-3">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-danger">{{ $stats['rechazados'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Total Casos Rechazados</p>
                            </div>
                        </div>

                    </div>
                    {{-- --- FIN DE LA MODIFICACIÓN! --- --}}
                </div>
            </div>
            {{-- ====================================================== --}}
            {{-- FIN DE ESTADÍSTICAS --}}
            {{-- ====================================================== --}}

        </div>
    </div>
</x-app-layout>