<x-app-layout>
    {{-- 
      El 'py-5' ahora está dentro del 'slot', 
      y el fondo gris claro lo da el 'main-content' en app.blade.php 
    --}}
    <div class="py-5">
        {{-- 
          El contenedor ahora está dentro del 'py-5' para 
          que el padding esté en el área de contenido
        --}}
        <div class="container-fluid px-4">

            {{-- ====================================================== --}}
            {{-- ¡TÍTULO ACTUALIZADO! --}}
            {{-- ====================================================== --}}
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                Dashboard: {{ Auth::user()->rol->nombre_rol }}
            </h2>
            {{-- ====================================================== --}}

            {{-- Banner de Bienvenida --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow" style="background-color: #008080;"> {{-- Color Teal --}}
                <h3 class="fs-2 fw-bold">¡Bienvenido/a, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Panel principal para la gestión y seguimiento de casos de ajuste académico.</p>
            </div>

            {{-- Tarjetas de Acción --}}
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-file-earmark-plus-fill fs-2 text-primary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Registrar Nuevo Caso</h4>
                                    <p class="card-text text-muted mt-1">Iniciar el proceso para un estudiante.</p>
                                </div>
                            </div>
                            <a href="{{ route('casos.create') }}" class="btn btn-primary mt-auto">
                                Crear Caso
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-list-task fs-2 text-secondary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Ver Casos Registrados</h4>
                                    <p class="card-text text-muted mt-1">Consultar listado y estado actual.</p>
                                </div>
                            </div>
                            <a href="{{ route('casos.index') }}" class="btn btn-secondary mt-auto">
                                Ver Listado
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección de Estadísticas --}}
            <div class="card shadow-sm rounded-3 mt-5">
                <div class="card-header bg-body-tertiary p-3">
                    <h4 class="fw-semibold fs-5 mb-0">Resumen Rápido</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 text-center">
                        <div class="col-md-4">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-primary">--</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Casos Creados (Mes)</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-warning">--</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Pendientes Validación</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-success">--</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Aceptados Recientes</p>
                            </div>
                        </div>
                    </div>
                    <p class="small text-muted text-center mt-4 mb-0">Próximamente: Datos reales de los casos.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>