<x-app-layout>
    <div class="py-5">
        <div class="container-lg">
            <h2 class="fw-semibold fs-2 mb-4">
                Listado de Casos Registrados
            </h2>

            <div class="card shadow-sm rounded-3">

                {{-- ====================================================== --}}
                {{-- ¡INICIO DE SECCIÓN DE FILTROS AÑADIDA! --}}
                {{-- ====================================================== --}}
                <div class="card-header bg-body-tertiary border-bottom-0 pt-4">
                    <form method="GET" action="{{ route('casos.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="search_rut" class="form-label fw-medium">RUT Estudiante</label>
                                <input type="text" class="form-control" id="search_rut" name="search_rut" placeholder="Buscar por RUT..." value="{{ request('search_rut') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="search_fecha_inicio" class="form-label fw-medium">Desde</label>
                                <input type="date" class="form-control" id="search_fecha_inicio" name="search_fecha_inicio" value="{{ request('search_fecha_inicio') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="search_fecha_fin" class="form-label fw-medium">Hasta</label>
                                <input type="date" class="form-control" id="search_fecha_fin" name="search_fecha_fin" value="{{ request('search_fecha_fin') }}">
                            </div>
                            <div class="col-md-3 d-flex justify-content-start justify-content-md-end align-self-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i> Buscar
                                </button>
                                <a href="{{ route('casos.index') }}" class="btn btn-secondary">Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- ====================================================== --}}
                {{-- FIN DE SECCIÓN DE FILTROS --}}
                {{-- ====================================================== --}}


                <div class="card-body p-4 p-md-5">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4 text-end">
                        <a href="{{ route('casos.create') }}"
                           class="btn btn-primary d-inline-flex align-items-center shadow-sm">
                            <i class="bi bi-plus-circle-fill me-2" style="font-size: 1rem; align-self: center;"></i>
                            Registrar Nuevo Caso
                        </a>
                    </div>

                    <div class="table-responsive shadow-sm rounded-3 border">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th scope="col" class="p-3 text-uppercase">RUT Estudiante</th>
                                    <th scope="col" class="p-3 text-uppercase">Nombre Estudiante</th>
                                    <th scope="col" class="p-3 text-uppercase">Carrera</th>
                                    <th scope="col" class="p-3 text-uppercase">Estado</th>
                                    <th scope="col" class="p-3 text-uppercase">Fecha Creación</th>
                                    <th scope="col" class="p-3 text-uppercase text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($casos as $caso)
                                    <tr>
                                        <td class="p-3 fw-medium text-nowrap">{{ $caso->rut_estudiante }}</td>
                                        <td class="p-3">{{ $caso->nombre_estudiante }}</td>
                                        <td class="p-3">{{ $caso->carrera }}</td>
                                        <td class="p-3">
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
                                        <td class="p-3">{{ $caso->created_at->translatedFormat('d M Y, H:i') }}</td>
                                        <td class="p-3 text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('casos.show', $caso) }}" class="btn btn-sm btn-warning text-dark" title="Ver Detalles">
                                                    <i class="bi bi-eye-fill me-1"></i> Ver
                                                </a>
                                                <a href="{{ route('casos.edit', $caso) }}" class="btn btn-sm btn-primary" title="Editar Caso">
                                                    <i class="bi bi-pencil-fill me-1"></i> Editar
                                                </a>
                                                <form action="{{ route('casos.destroy', $caso) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este caso? Es una acción irreversible.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar Caso">
                                                        <i class="bi bi-trash-fill me-1"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-4 text-center text-body-secondary">
                                            No hay casos registrados con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Paginación --}}
                @if ($casos->hasPages())
                    <div class="card-footer bg-body-tertiary">
                        {{-- Mantenemos los filtros al paginar --}}
                        {{ $casos->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>