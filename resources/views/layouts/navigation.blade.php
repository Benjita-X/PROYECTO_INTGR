@php
    // --- Lógica de Rutas (Calculada una sola vez) ---

    // Cachear el nombre del rol para usarlo varias veces
    $userRolName = Auth::user()?->rol?->nombre_rol;

    // Determina la ruta del dashboard según el rol para el logo y el enlace principal
    $navDashboardRoute = match($userRolName) {
        'Administrador' => route('admin.dashboard'),
        'Asesoría Pedagógica' => route('asesoria.dashboard'),
        'Director de Carrera' => route('director.dashboard'),
        'Docente' => route('docente.dashboard'),
        'Estudiante' => route('estudiante.dashboard'),
        default => url('/'), // Ruta de respaldo si no hay rol
    };

    // Determina si la ruta actual es algún dashboard para el estado "active"
    $isDashboardActive = request()->routeIs('*.dashboard');
@endphp

{{-- 
  Barra de navegación de Bootstrap.
  - navbar-expand-lg: Se colapsa en pantallas medianas y grandes.
  - navbar-dark bg-dark: Tema oscuro.
  - shadow-sm: Una sombra sutil.
--}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    
    {{-- ¡CAMBIO CLAVE! 'container-lg' se reemplaza por 'container-fluid' para ocupar el 100% del ancho --}}
    <div class="container-fluid">

        {{-- ====================================================== --}}
        {{-- ¡LOGO/MARCA ACTUALIZADOS! --}}
        {{-- ====================================================== --}}
        <a class="navbar-brand fw-semibold" href="{{ $navDashboardRoute }}">
            {{-- Logo sugerido para "Gestión Inclusiva" (un libro/diario) --}}
            <i class="bi bi-journal-bookmark-fill me-2"></i>
            Gestion Inclusiva
        </a>
        {{-- ====================================================== --}}


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarContent" aria-controls="mainNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbarContent">

            {{-- Esta clase 'me-auto' (margin-end: auto) empuja todo lo demás a la derecha --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $isDashboardActive ? 'active' : '' }}" 
                       href="{{ $navDashboardRoute }}" 
                       @if($isDashboardActive) aria-current="page" @endif>
                        {{ __('Inicio') }}
                    </a>
                </li>

                {{-- Enlaces que aparecen según el Rol del usuario --}}
                @if($userRolName == 'Asesoría Pedagógica')
                    @php $isCasosActive = request()->routeIs('casos.*'); @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $isCasosActive ? 'active' : '' }}" 
                           href="{{ route('casos.index') }}" 
                           @if($isCasosActive) aria-current="page" @endif>
                            Gestionar Casos
                        </a>
                    </li>
                @endif
                
                @if($userRolName == 'Administrador')
                    @php $isUsersActive = request()->routeIs('admin.users.*'); @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $isUsersActive ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}" 
                           @if($isUsersActive) aria-current="page" @endif>
                            Gestionar Usuarios
                        </a>
                    </li>
                @endif
                
                {{-- Puedes agregar más bloques @if para otros roles aquí --}}
            </ul>

            {{-- Esta clase 'ms-auto' (margin-start: auto) empuja este bloque a la derecha --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                
                <li class="nav-item d-flex align-items-center">
                    <span class="navbar-text me-3">
                        <i class="bi bi-calendar-check me-1"></i> Hoy: {{ now()->translatedFormat('d F Y') }}
                    </span>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name }} <span class="small text-white-50">({{ $userRolName ?? 'Sin Rol' }})</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-fill-gear me-2"></i> {{ __('Profile') }}
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <button type="submit" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>