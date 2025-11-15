<x-app-layout>
    {{-- Ya no usamos el <x-slot name="header">, integramos el título --}}

    <div class="py-5">
        <div class="container-lg">
            
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                Gestión de Usuarios
            </h2>

            {{-- Contenedor principal de Bootstrap --}}
            <div class="card shadow-sm rounded-3">
                <div class="card-body p-4 p-md-5">

                    {{-- Mensajes de éxito o error (estilo Bootstrap) --}}
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

                    {{-- Botón para Crear Usuario (estilo Bootstrap, alineado a la derecha) --}}
                    <div class="mb-4 text-end">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Usuario
                        </a>
                    </div>

                    {{-- Tabla de Usuarios (estilo Bootstrap) --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" class="ps-4">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rol</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col" class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            {{-- Badge de Bootstrap --}}
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle">
                                                {{ $user->rol?->nombre_rol ?? 'Sin Rol' }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                        <td class="text-end pe-4">
                                            {{-- Botones de Bootstrap --}}
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-fill"></i> Editar
                                            </a>
                                            
                                            {{-- Formulario para Eliminar --}}
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash-fill"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-4 text-muted">
                                            No hay usuarios registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Paginación (Bootstrap la detectará automáticamente) --}}
                @if ($users->hasPages())
                    <div class="card-footer bg-body-tertiary">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
