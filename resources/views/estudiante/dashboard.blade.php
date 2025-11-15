<x-app-layout>
    <div class="py-5">
        <div class="container-fluid px-4">

            {{-- Título --}}
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                Dashboard: {{ Auth::user()->rol->nombre_rol }}
            </h2>

            {{-- Banner de Bienvenida --}}
            <div class="p-4 p-md-5 mb-5 text-white rounded-3 shadow" style="background-color: #0dcaf0;"> {{-- Color Cyan/Estudiante --}}
                <h3 class="fs-2 fw-bold">¡Hola, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 fs-5" style="opacity: 0.9;">Bienvenido/a a tu espacio para gestionar tus solicitudes de ajustes académicos.</p>
            </div>

            {{-- Widgets específicos para el Estudiante --}}
            <div class="row g-4 justify-content-center">
                {{-- Widget: Estado de Mis Casos --}}
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm rounded-3 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-folder-check fs-2 text-primary me-3"></i>
                                <div>
                                    <h4 class="fw-semibold fs-5 mb-0">Estado de Mis Solicitudes</h4>
                                    <p class="card-text text-muted mt-1">Ver el estado actual de tus casos y subir nueva documentación.</p>
                                </div>
                            </div>
                            <a href="{{ route('estudiante.casos.index') }}" class="btn btn-primary mt-auto">
                                Ver mis casos
                                <i class="bi bi-arrow-right-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Widget: Subir Documentos (Eliminado, se unió con el de arriba) --}}
                
            </div>

        </div>
    </div>
</x-app-layout>