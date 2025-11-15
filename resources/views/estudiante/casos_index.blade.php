<x-app-layout>
    <div class="py-5">
        <div class="container-lg">
            
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                Mis Solicitudes de Ajuste
            </h2>

            <div class="card shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive rounded-3">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" class="ps-4">N° Caso</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col" class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($casos as $caso)
                                    <tr>
                                        <td class="ps-4 fw-medium">#{{ $caso->id }}</td>
                                        <td>{{ $caso->created_at->translatedFormat('d M Y, H:i') }}</td>
                                        <td>
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
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('estudiante.casos.show', $caso) }}" class="btn btn-secondary btn-sm" title="Ver Detalles y Subir Archivos">
                                                <i class="bi bi-eye-fill me-1"></i> Ver Detalle / Subir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-4">
                                            <span class="text-muted">No tienes casos registrados a tu nombre.</span>
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