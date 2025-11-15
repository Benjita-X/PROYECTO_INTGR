<section>
    <header>
        <h2 class="fs-4 fw-semibold text-danger">
            Eliminar Cuenta
        </h2>

        <p class="mt-1 text-muted">
            Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees retener.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Eliminar Cuenta
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="confirmUserDeletionModalLabel">
                            ¿Estás seguro de que quieres eliminar tu cuenta?
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p class="text-muted">
                            Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.
                        </p>

                        <div class="mt-3">
                            <label for="password_delete" class="form-label fw-medium">Contraseña</label>
                            <input id="password_delete"
                                   name="password"
                                   type="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   placeholder="Contraseña"
                            />
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        
                        <button type="submit" class="btn btn-danger">
                            Eliminar Cuenta
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

{{-- 
  Pequeño script para abrir el modal automáticamente si hay un error de contraseña.
  (Breeze lo hacía con Alpine, nosotros lo hacemos con JS de Bootstrap).
--}}
@if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'), {});
            myModal.show();
        });
    </script>
@endif