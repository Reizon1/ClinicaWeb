<section>
    <h6 class="fw-semibold mb-1">Eliminar Cuenta</h6>
    <p class="text-muted small mb-4">Una vez eliminada tu cuenta, todos los datos serán borrados permanentemente. Descargá cualquier información que quieras conservar antes de continuar.</p>

    <button type="button" class="btn btn-danger btn-sm fw-semibold"
            data-bs-toggle="modal" data-bs-target="#modalEliminarCuenta">
        Eliminar Cuenta
    </button>

    <div class="modal fade" id="modalEliminarCuenta" tabindex="-1" aria-labelledby="modalEliminarCuentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-2">¿Estás seguro de que querés eliminar tu cuenta?</h5>
                    <p class="text-muted small mb-4">Esta acción es irreversible. Ingresá tu contraseña para confirmar.</p>

                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-4">
                            <label for="del_password" class="form-label fw-semibold small">Contraseña</label>
                            <input id="del_password" name="password" type="password" placeholder="••••••••"
                                   class="form-control form-control-sm @if($errors->userDeletion->get('password')) is-invalid @endif">
                            @if($errors->userDeletion->get('password'))
                                <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-outline-secondary btn-sm fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger btn-sm fw-semibold">Eliminar Cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    @if($errors->userDeletion->isNotEmpty())
    document.addEventListener('DOMContentLoaded', function() {
        new BSLib.Modal(document.getElementById('modalEliminarCuenta')).show();
    });
    @endif
</script>
