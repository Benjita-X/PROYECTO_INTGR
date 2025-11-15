<x-app-layout>
    <div class="py-5">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">

                    <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                        Detalle del Caso #{{ $caso->id }}
                    </h2>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-body-tertiary p-4">
                            <h3 class="fs-4 fw-semibold mb-0">Información del Caso</h3>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <div class="row g-5">
                                {{-- Columna de Información del Estudiante --}}
                                <div class="col-md-6">
                                    <h4 class="fs-5 fw-semibold mb-4">Mis Datos</h4>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">RUT</label>
                                        <p class="fs-5 mb-0 fw-medium">{{ $caso->rut_estudiante }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small text-muted text-uppercase fw-semibold">Nombre</label>
                                        <p class="fs-5 mb-0">{{ $caso->nombre_estudiante }}</p>
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
                                        <label class="small text-muted text-uppercase fw-semibold">Fecha Creación</label>
                                        <p class="fs-5 mb-0">{{ $caso->created_at->translatedFormat('d F, Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="small text-muted text-uppercase fw-semibold">Asignado a (Asesor/a)</label>
                                        <p class="fs-5 mb-0">{{ $caso->asesor?->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Ajustes Propuestos (Si está aceptado) --}}
                            @if(strtolower(trim($caso->estado)) == 'aceptado')
                                <div class="border-top pt-4 mt-4">
                                    <label class="small text-muted text-uppercase fw-semibold">Ajuste(s) Aprobado(s)</label>
                                    <div class="p-3 bg-body-tertiary rounded-3 mt-2" style="white-space: pre-wrap;">{{ $caso->ajustes_propuestos }}</div>
                                </div>
                            @endif
                            
                            {{-- Comentarios del Director --}}
                            @if ($caso->motivo_decision)
                                <div class="border-top pt-4 mt-4">
                                    <label class="small text-muted text-uppercase fw-semibold">Último Comentario del Director</label>
                                    <div class="p-3 bg-body-tertiary rounded-3 mt-2" style="white-space: pre-wrap;">{{ $caso->motivo_decision }}</div>
                                </div>
                            @endif

                            {{-- Documentos Adjuntos --}}
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
                                            <span class="text-muted">No se han adjuntado documentos para este caso.</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ====================================================== --}}
                    {{-- NUEVO FORMULARIO PARA SUBIR ARCHIVOS --}}
                    {{-- ====================================================== --}}
                    <div class="card shadow-sm rounded-3">
                        <div class="card-header bg-body-tertiary p-4">
                            <h3 class="fs-4 fw-semibold mb-0">Adjuntar Nueva Evidencia</h3>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('estudiante.casos.upload', $caso) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="documento" class="form-label fw-medium">Nuevo Documento</label>
                                    <input class="form-control @error('documento') is-invalid @enderror" type="file" id="documento" name="documento" required>
                                    <div class="form-text">Puedes subir archivos PDF, JPG, PNG, DOC, DOCX (Máx 5MB).</div>
                                    @error('documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('estudiante.casos.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left-circle me-2"></i> Volver al Listado
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-cloud-upload-fill me-2"></i> Subir Documento
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- ====================================================== --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>