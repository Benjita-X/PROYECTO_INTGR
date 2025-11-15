<x-app-layout>
    <div class="py-5">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">

                    <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                        Detalle de Ajuste: Caso #{{ $caso->id }}
                    </h2>

                    <div class="card shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-body-tertiary p-4">
                            <h3 class="fs-4 fw-semibold mb-0">Información del Caso</h3>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <div class="row g-5">
                                {{-- Columna de Información del Estudiante --}}
                                <div class="col-md-6">
                                    <h4 class="fs-5 fw-semibold mb-4">Información del Estudiante</h4>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">RUT Estudiante</label>
                                        <p class="fs-5 mb-0 fw-medium">{{ $caso->rut_estudiante }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">Nombre Completo</label>
                                        <p class="fs-5 mb-0">{{ $caso->nombre_estudiante }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">Correo Electrónico</label>
                                        <p class="fs-5 mb-0">{{ $caso->correo_estudiante }}</p>
                                    </div>
                                    <div>
                                        <label class="small text-muted text-uppercase fw-semibold">Carrera</label>
                                        <p class="fs-5 mb-0">{{ $caso->carrera }}</p>
                                    </div>
                                </div>

                                {{-- Columna de Información del Caso --}}
                                <div class="col-md-6">
                                    <h4 class="fs-5 fw-semibold mb-4">Datos del Caso</h4>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">Estado Actual</label>
                                        <p class="mb-0">
                                            <span class="badge rounded-pill fs-6 bg-success-subtle text-success-emphasis border border-success-subtle">
                                                <i class="bi bi-check-circle-fill me-1"></i> Aceptado
                                            </span>
                                        </p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">Fecha Aprobación</label>
                                        <p class="fs-5 mb-0">{{ $caso->updated_at->translatedFormat('d F, Y') }}</p>
                                    </div>
                                    {{-- --- SECCIÓN DE DIRECTOR ELIMINADA --- --}}
                                </div>
                            </div>

                            {{-- Ajustes Propuestos (¡Lo que el docente necesita leer!) --}}
                            <div class="border-top pt-4 mt-4">
                                <label class="small text-muted text-uppercase fw-semibold">Ajuste(s) Aprobado(s)</label>
                                <div class="p-3 bg-body-tertiary rounded-3 mt-2" style="white-space: pre-wrap;">{{ $caso->ajustes_propuestos }}</div>
                            </div>
                            
                            {{-- Comentarios (Título cambiado) --}}
                            @if ($caso->motivo_decision)
                                <div class="border-top pt-4 mt-4">
                                    <label class="small text-muted text-uppercase fw-semibold">Comentarios de Aprobación</label>
                                    <div class="p-3 bg-body-tertiary rounded-3 mt-2" style="white-space: pre-wrap;">{{ $caso->motivo_decision }}</div>
                                </div>
                            @endif

                            {{-- --- SECCIÓN DE DOCUMENTOS ELIMINADA --- --}}

                        </div>
                        
                        {{-- ====================================================== --}}
                        {{-- SECCIÓN DE CONFIRMACIÓN DE LECTURA --}}
                        {{-- ====================================================== --}}
                        <div class="card-footer bg-body-tertiary p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ url()->previous(route('docente.ajustes.pendientes')) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left-circle me-2"></i> Volver al Listado
                                </a>
                                
                                @if ($yaConfirmado)
                                    <span class="badge bg-success-subtle text-success-emphasis fs-6 p-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> Lectura Confirmada
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('docente.ajustes.confirmar', $caso) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="bi bi-check-lg me-1"></i> Confirmar Lectura
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        {{-- ====================================================== --}}
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>