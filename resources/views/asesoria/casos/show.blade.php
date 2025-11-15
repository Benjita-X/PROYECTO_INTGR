<x-app-layout>
    <div class="py-5">
        {{-- Contenedor más estrecho y centrado, igual que los formularios --}}
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">

                    <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                        Detalle del Caso #{{ $caso->id }}
                    </h2>

                    {{-- Contenedor principal --}}
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body p-4 p-md-5">

                            {{-- Usamos la grilla de Bootstrap para las columnas. 'g-5' para un espaciado mayor. --}}
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
                                            {{-- Componente 'badge' de Bootstrap (ya corregido) --}}
                                            @php $estadoLimpio = strtolower(trim($caso->estado)); @endphp
                                            <span class="badge rounded-pill fs-6
                                                @if($estadoLimpio == 'sin revision') bg-info-subtle text-info-emphasis border border-info-subtle
                                                @elseif($estadoLimpio == 'pendiente') bg-warning-subtle text-warning-emphasis border border-warning-subtle
                                                @elseif($estadoLimpio == 'aceptado') bg-success-subtle text-success-emphasis border border-success-subtle
                                                @elseif($estadoLimpio == 'rechazado') bg-danger-subtle text-danger-emphasis border border-danger-subtle
                                                @else bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle @endif
                                            ">
                                                {{ ucfirst($caso->estado) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">Fecha de Creación</label>
                                        <p class="fs-5 mb-0">{{ $caso->created_at->translatedFormat('d F, Y \a \l\a\s H:i') }}</p>
                                    </div>
                                    <div>
                                        <label class="small text-muted text-uppercase fw-semibold">Creado por (Asesor/a)</label>
                                        <p class="fs-5 mb-0">{{ $caso->asesor?->name ?? 'Usuario no encontrado' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Ajustes Propuestos --}}
                            <div class="border-top pt-4 mt-4">
                                <label class="small text-muted text-uppercase fw-semibold">Ajuste(s) Propuesto(s)</label>
                                <div class="p-3 bg-body-tertiary rounded-3 mt-2" style="white-space: pre-wrap;">{{ $caso->ajustes_propuestos }}</div>
                            </div>

                            {{-- ====================================================== --}}
                            {{-- ¡NUEVA SECCIÓN DE DOCUMENTOS AÑADIDA! --}}
                            {{-- ====================================================== --}}
                            <div class="border-top pt-4 mt-4">
                                <label class="small text-muted text-uppercase fw-semibold">Documentos Adjuntos</label>
                                <div class="list-group mt-2">
                                    @forelse ($caso->documentos as $documento)
                                        <a href="{{ asset('storage/' . $documento->ruta) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="bi bi-file-earmark-text-fill me-2"></i>
                                                {{ $documento->nombre_original ?? 'Ver Documento' }}
                                            </span>
                                            <i class="bi bi-download"></i>
                                        </a>
                                    @empty
                                        <div class="list-group-item">
                                            <span class="text-muted">No se adjuntaron documentos para este caso.</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            {{-- ====================================================== --}}
                            {{-- FIN DE LA NUEVA SECCIÓN --}}
                            {{-- ====================================================== --}}

                            {{-- ====================================================== --}}
                            {{-- SECCIÓN DE REVISIÓN DEL DIRECTOR (ya la tenías) --}}
                            {{-- ====================================================== --}}
                            @if ($caso->director_id || $caso->motivo_decision)
                                <div class="border-top pt-4 mt-4">
                                    <h4 class="fs-5 fw-semibold mb-4 text-primary">Revisión del Director</h4>
                                    <div class="mb-3">
                                        <label class="small text-muted text-uppercase fw-semibold">Decisión Tomada por</label>
                                        <p class="fs-5 mb-0">{{ $caso->director?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="small text-muted text-uppercase fw-semibold">Comentarios / Razón</label>
                                        <div class="p-3 bg-body-tertiary rounded-3 mt-2" style="white-space: pre-wrap;">{{ $caso->motivo_decision ?? '(Sin comentarios)' }}</div>
                                    </div>
                                </div>
                            @endif
                            {{-- ====================================================== --}}
                            {{-- FIN DE LA SECCIÓN DE REVISIÓN --}}
                            {{-- ====================================================== --}}

                        </div>
                        
                        {{-- Footer de la tarjeta para los botones de acción --}}
                        <div class="card-footer bg-body-tertiary text-end p-3">
                            <a href="{{ route('casos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle me-2"></i>Volver al Listado
                            </a>
                            <a href="{{ route('casos.edit', $caso) }}" class="btn btn-primary">
                                <i class="bi bi-pencil-fill me-2"></i>Editar Caso
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>