<x-app-layout>
    <div class="py-5">
        <div class="container-fluid px-4">
            
            {{-- --- TÍTULO ACTUALIZADO --- --}}
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                Mis Ajustes Confirmados
            </h2>
            {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}

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
                                    {{-- --- COLUMNA ACTUALIZADA --- --}}
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
                                        <td>
                                            {{-- Esta vista solo muestra casos confirmados --}}
                                            <span class="badge rounded-pill fs-6 bg-success-subtle text-success-emphasis">
                                                <i class="bi bi-check-circle-fill me-1"></i> Confirmado
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('docente.ajustes.show', $caso) }}" class="btn btn-secondary btn-sm" title="Ver Detalles">
                                                    <i class="bi bi-eye-fill me-1"></i> Ver Detalle
                                                </a>
                                                {{-- Se eliminó el botón de confirmar --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        {{-- --- MENSAJE ACTUALIZADO --- --}}
                                        <td colspan="5" class="text-center p-4">
                                            <span class="text-muted">Aún no has confirmado la lectura de ningún caso.</span>
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