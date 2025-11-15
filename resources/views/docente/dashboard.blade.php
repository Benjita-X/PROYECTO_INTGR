<x-app-layout>
    <div class="py-5">
        <div class="container-fluid px-4">

            {{-- Título del Dashboard --}}
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                {{ Auth::user()->rol->nombre_rol }}
            </h2>

            {{-- Banner de Bienvenida --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow" style="background-color: #c52b2bff;"> {{-- Color Morado/Índigo para Docente --}}
                <h3 class="fs-2 fw-bold">¡Bienvenido/a, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Aquí encontrará los ajustes académicos aprobados para sus estudiantes.</p>
            </div>

            {{-- Sección de Acciones (Widgets) --}}
            <div class="row g-4 mb-5">

                {{-- Widget: Ajustes Pendientes de Confirmar Lectura --}}
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-3 h-100 border-warning-subtle bg-warning-subtle">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-bell-fill fs-2 text-warning-emphasis me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0 text-warning-emphasis">Ajustes Pendientes de Confirmar</h4>
                                    <p class="card-text text-warning-emphasis mt-1" style="opacity: 0.8;">Casos que han sido aceptados pero que aún no ha confirmado como leídos.</p>
                                </div>
                            </div>
                            <a href="{{ route('docente.ajustes.pendientes') }}" class="btn btn-warning mt-auto">
                                Ver Pendientes de Lectura
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Widget: Todos los Ajustes Aprobados --}}
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-card-checklist fs-2 text-secondary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Mis Ajustes Confirmados</h4>
                                    <p class="card-text text-muted mt-1">Historial de todos los ajustes cuya lectura ya ha confirmado.</p>
                                </div>
                            </div>
                            <a href="{{ route('docente.ajustes.todos') }}" class="btn btn-secondary mt-auto">
                                Ver Historial de Confirmaciones
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- ¡NUEVA SECCIÓN DE ESTADÍSTICAS AÑADIDA! --}}
            {{-- ====================================================== --}}
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-body-tertiary p-3">
                    <h4 class="fw-semibold fs-5 mb-0">Resumen Rápido (Mis Casos)</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 text-center">
                        
                        {{-- Tarjeta Estadística 1: Pendientes de Lectura --}}
                        <div class="col-md-6">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-warning">{{ $stats['pendientes'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Pendientes de Lectura</p>
                            </div>
                        </div>
                        
                        {{-- Tarjeta Estadística 2: Ajustes Confirmados --}}
                        <div class="col-md-6">
                            <div class="bg-body-tertiary p-3 rounded-3">
                                <span class="fs-1 fw-bold text-success">{{ $stats['confirmados'] ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0 mt-1">Ajustes Confirmados</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- ====================================================== --}}
            {{-- FIN DE ESTADÍSTICAS --}}
            {{-- ====================================================== --}}

        </div>
    </div>
</x-app-layout>