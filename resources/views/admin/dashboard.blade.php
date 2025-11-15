<x-app-layout>
    {{-- 
      Ya no usamos el <x-slot name="header">, porque lo quitamos de app.blade.php
      En lugar del div 'py-12 bg-gray-100', usamos 'py-5' de Bootstrap 
      El fondo 'bg-body-tertiary' ya está en app.blade.php 
    --}}
    <div class="py-5">
        {{-- Reemplazamos 'max-w-7xl mx-auto...' con 'container-lg' --}}
        <div class="container-lg">

            {{-- Banner de Bienvenida Mejorado --}}
            {{-- Usamos 'bg-dark' y 'bg-gradient' para el admin, 'text-white' --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow bg-dark bg-gradient">
                <h3 class="fs-2 fw-bold">¡Bienvenido/a, Administrador {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Panel de control general del Sistema de Gestión Académica Inclusiva.</p>
                {{-- <a href="#" class="btn btn-light fw-semibold mt-3">Ver Reporte General</a> --}}
            </div>

            {{-- ====================================================== --}}
            {{-- ¡SECCIÓN DE ACCIONES SIMPLIFICADA! --}}
            {{-- ====================================================== --}}
            {{-- Añadido 'justify-content-center' para centrar la tarjeta restante --}}
            <div class="row g-4 mb-5 justify-content-center">

                {{-- Tarjeta: Gestión de Usuarios --}}
                {{-- 'col-lg-6' para que ocupe un espacio razonable --}}
                <div class="col-md-8 col-lg-6">
                    {{-- 'h-100' para misma altura, 'd-flex' para alinear botón abajo --}}
                    <div class="card shadow-sm rounded-3 h-100 d-flex flex-column">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-people-fill fs-2 text-primary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Gestión de Usuarios</h4>
                                </div>
                            </div>
                            <p class="card-text text-muted">Acceso a la creación, edición y eliminación de usuarios del sistema.</p>
                        </div>
                        {{-- 'mt-auto' empuja el botón al fondo del 'flex-column' --}}
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-auto">
                                Gestionar Usuarios <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta: Gestión de Roles (ELIMINADA) --}}

                {{-- Tarjeta: Configuración del Sistema (ELIMINADA) --}}

            </div>
            {{-- ====================================================== --}}
            {{-- FIN DE SECCIÓN DE ACCIONES --}}
            {{-- ====================================================== --}}


            {{-- ====================================================== --}}
            {{-- ¡SECCIÓN DE ESTADÍSTICAS SIMPLIFICADA! --}}
            {{-- ====================================================== --}}
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-body-tertiary p-3">
                    <h4 class="fw-semibold fs-5 mb-0">Estadísticas Clave</h4>
                </div>
                <div class="card-body p-4">
                    {{-- Añadido 'justify-content-center' para centrar la estadística restante --}}
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-4">
                            <div class="card bg-body-tertiary shadow-sm border-0 text-center p-3">
                                {{-- ¡VALOR ACTUALIZADO! --}}
                                <span class="fs-1 fw-bold text-primary">{{ $totalUsuarios ?? 0 }}</span>
                                <p class="fs-6 text-muted mb-0">Usuarios Totales</p>
                            </div>
                        </div>
                        
                        {{-- Tarjeta: Casos Activos (ELIMINADA) --}}
                        
                        {{-- Tarjeta: Casos Pendientes (ELIMINADA) --}}
                        
                    </div>
                    <p class="small text-muted text-center mt-4 mb-0">Estadísticas generales del sistema.</p>
                </div>
            </div>
            {{-- ====================================================== --}}
            {{-- FIN DE SECCIÓN DE ESTADÍSTICAS --}}
            {{-- ====================================================== --}}

        </div>
    </div>
</x-app-layout>