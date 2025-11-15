<x-app-layout>
    <div class="py-5">
        <div class="container-fluid px-4">

            {{-- Título --}}
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                {{ Auth::user()->rol->nombre_rol }}
            </h2>

            {{-- Banner de Bienvenida --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow" style="background-color: #007bff;"> {{-- Color Azul Director --}}
                <h3 class="fs-2 fw-bold">¡Bienvenido/a, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Panel principal para la validación y seguimiento de casos de ajuste académico.</p>
            </div>

            {{-- Tarjetas de Acción --}}
            <div class="row g-4">
                
                {{-- Tarjeta 1: Casos Pendientes --}}
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-hourglass-split fs-2 text-warning me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Casos Pendientes</h4>
                                    <p class="card-text text-muted mt-1">Casos nuevos o en revisión.</p>
                                </div>
                            </div>
                            <a href="{{ route('director.casos.pendientes') }}" class="btn btn-warning mt-auto">
                                Revisar Pendientes
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta 2: Casos Aceptados --}}
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill fs-2 text-success me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Casos Aceptados</h4>
                                    <p class="card-text text-muted mt-1">Historial de casos aceptados.</p>
                                </div>
                            </div>
                            <a href="{{ route('director.casos.aceptados') }}" class="btn btn-success mt-auto"> 
                                Ver Aceptados
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta 3: Casos Rechazados --}}
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-x-circle-fill fs-2 text-danger me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Casos Rechazados</h4>
                                    <p class="card-text text-muted mt-1">Historial de casos rechazados.</p>
                                </div>
                            </div>
                            <a href="{{ route('director.historial') }}" class="btn btn-danger mt-auto">
                                Ver Rechazados
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Tarjeta 4: Ver Todos los Casos (¡RUTA ACTUALIZADA!) --}}
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-list-task fs-2 text-secondary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Ver Todos los Casos</h4>
                                    <p class="card-text text-muted mt-1">Ver el listado completo (solo revisión).</p>
                                </div>
                            </div>
                            {{-- --- ¡INICIO DE LA MODIFICACIÓN! --- --}}
                            <a href="{{ route('director.casos.todos') }}" class="btn btn-secondary mt-auto">
                            {{-- --- FIN DE LA MODIFICACIÓN! --- --}}
                                Ver Listado Completo
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

            
            {{-- ====================================================== --}}
            {{-- ¡SECCIÓN DE ANALÍTICAS RESTAURADA! --}}
            {{-- ====================================================== --}}
            <div class="card shadow-sm rounded-3 mt-5 mb-5">
                <div class="card-header bg-body-tertiary p-3">
                    <h4 class="fw-semibold fs-5 mb-0">Estadisticas</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 text-center">
                        {{-- Casos Pendientes (usa el controller) --}}
                        <div class="col-md-4">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-warning">{{ $stats['pendientes'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Casos Pendientes (o Sin Revisión)</p>
                            </div>
                        </div>
                        {{-- Casos Aceptados (usa el controller) --}}
                        <div class="col-md-4">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-success">{{ $stats['aceptados'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Casos Aceptados</p>
                            </div>
                        </div>
                        {{-- Casos Rechazados (usa el controller) --}}
                        <div class="col-md-4">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-danger">{{ $stats['rechazados'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Casos Rechazados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ====================================================== --}}
            {{-- FIN DE SECCIÓN DE ANALÍTICAS --}}
            {{-- ====================================================== --}}



            </div>
        </div>
    </div>
</x-app-layout>