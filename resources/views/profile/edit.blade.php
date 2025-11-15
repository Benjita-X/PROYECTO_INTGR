<x-app-layout>
    {{-- Eliminamos el <x-slot name="header"> --}}

    <div class="py-5">
        <div class="container-lg">
            
            <h2 class="fw-semibold fs-2 text-body-emphasis mb-4">
                {{ __('Perfil') }}
            </h2>

            <div class="row g-4">
                {{-- Columna Izquierda (o superior en móvil) --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm rounded-3 mb-4">
                        <div class="card-body p-4 p-md-5">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="card shadow-sm rounded-3">
                        <div class="card-body p-4 p-md-5">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha (o inferior en móvil) --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm rounded-3 border-danger-subtle">
                        <div class="card-body p-4 p-md-5">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>