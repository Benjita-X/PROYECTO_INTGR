<x-app-layout>
    <div class="py-5">
        <div class="container-fluid px-4">
            
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                Ajustes Pendientes de Confirmar Lectura
            </h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive rounded-3">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" class="ps-4">RUT Estudiante</th>
                                    <th scope="col">Nombre Estudiante</th>
                                    <th scope="col">Carrera</th>
                                    <th scope="col">Fecha Aprobación</th>
                                    {{-- --- ¡NUEVA COLUMNA AÑADIDA! --- --}}
                                    <th scope="col">Estado de Lectura</th>
                                    <th scope="col" class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($casos as $caso)
                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $caso->rut_estudiante }}</td>
                                        <td>{{ $caso->nombre_estudiante }}</td>
                                        <td>{{ $caso->carrera }}</td>
                                        <td>{{ $caso->updated_at->translatedFormat('d M Y, H:i') }}</td>
                                        {{-- --- NUEVA CELDA AÑADIDA! --- --}}
                                        <td>
                                            <span class="badge rounded-pill fs-6 bg-warning-subtle text-warning-emphasis">
                                                <i class="bi bi-bell-fill me-1"></i> Pendiente de Lectura
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('docente.ajustes.show', $caso) }}" class="btn btn-primary btn-sm" title="Ver Detalles y Confirmar">
                                                <i class="bi bi-eye-fill me-1"></i> Ver y Confirmar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        {{-- Colspan actualizado a 6 --}}
                                        <td colspan="6" class="text-center p-4">
                                            <span class="text-muted">¡Excelente! No tienes ajustes pendientes por confirmar.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($casos->hasPages())
                    <div class="card-footer bg-body-tertiary">
                        {{ $casos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>