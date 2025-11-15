<x-app-layout>
    {{-- 
      Ya no usamos el <x-slot name="header">.
      El 'py-5' y 'bg-body-tertiary' ya vienen de app.blade.php 
    --}}
    <div class="py-5">
        {{-- Reemplazamos 'max-w-7xl mx-auto...' con 'container-lg' --}}
        <div class="container-lg">

            {{-- Banner de Bienvenida Mejorado --}}
            {{-- Usamos 'bg-dark' y 'bg-gradient' para el admin, 'text-white' --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow bg-dark bg-gradient">
                <h3 class="fs-2 fw-bold">¡Bienvenido/a, Administrador {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Panel de control general del Sistema de Gestión Académica Inclusiva.</p>
            </div>

            {{-- Sección de Acciones Principales (Tarjetas) --}}
            {{-- Reemplazamos 'grid grid-cols-1...' con 'row g-4' --}}
            <div class="row g-4 mb-5">

                {{-- Tarjeta: Gestión de Usuarios --}}
                {{-- 'col-lg-4' para 3 columnas en large, 'col-md-6' para 2 en medium --}}
                <div class="col-md-6 col-lg-4">
                    {{-- Usamos 'h-100' y 'd-flex' para igualar alturas y alinear botones --}}
                    <div class="card shadow-sm rounded-3 h-100 d-flex flex-column">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-people-fill fs-2 text-primary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Gestión de Usuarios</h4>
                                </div>
                            </div>
                            <p class="card-text text-muted">Acceso a la creación, edición y eliminación de usuarios del sistema.</p>
                            
                            {{-- 'mt-auto' alinea este botón al fondo de la card --}}
                            {{-- (Asumo que esta ruta 'admin.users.index' está correcta) --}}
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-auto">
                                Gestionar Usuarios <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta: Gestión de Roles --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm rounded-3 h-100 d-flex flex-column">
                        <div class="card-body p-4">
                             <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-key-fill fs-2 text-info me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Gestión de Roles</h4>
                                </div>
                            </div>
                            <p class="card-text text-muted">Configuración de los roles disponibles en el sistema y sus permisos.</p>
                            <a href="#" class="btn btn-secondary disabled mt-auto">
                                Gestionar Roles (Próx.)
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta: Configuración del Sistema --}}
                <div class="col-md-6 col-lg-4">
                     <div class="card shadow-sm rounded-3 h-100 d-flex flex-column">
                        <div class="card-body p-4">
                             <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-gear-fill fs-2 text-success me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Configuración</h4>
                                </div>
                            </div>
                            <p class="card-text text-muted">Ajustes generales del sistema, parámetros y opciones avanzadas.</p>
                            <a href="#" class="btn btn-secondary disabled mt-auto">
                                Configurar Sistema (Próx.)
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sección de Estadísticas (Placeholder) --}}
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-body-tertiary p-4">
                    <h4 class="fw-semibold fs-5 mb-0">Estadísticas Clave</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-4 rounded-3 bg-body-tertiary text-center">
                                <span class="display-5 fw-bold text-primary">--</span>
                                <p class="fs-5 text-muted mb-0 mt-1">Usuarios Totales</p>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="p-4 rounded-3 bg-body-tertiary text-center">
                                <span class="display-5 fw-bold text-success">--</span>
                                <p class="fs-5 text-muted mb-0 mt-1">Casos Activos</p>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="p-4 rounded-3 bg-body-tertiary text-center">
                                <span class="display-5 fw-bold text-warning">--</span>
                                <p class="fs-5 text-muted mb-0 mt-1">Casos Pendientes</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small mt-4 text-center mb-0">Próximamente: Datos reales del sistema.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
