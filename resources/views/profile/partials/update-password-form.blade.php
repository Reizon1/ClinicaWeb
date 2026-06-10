<section>
    <h6 class="fw-semibold mb-1">Actualizar Contraseña</h6>
    <p class="text-muted small mb-4">Usá una contraseña larga y aleatoria para mantener tu cuenta segura.</p>

    <form method="post" action="{{ route('password.update') }}" class="d-flex flex-column gap-3">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="form-label fw-semibold small">Contraseña actual</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="form-control form-control-sm @if($errors->updatePassword->get('current_password')) is-invalid @endif">
            @if($errors->updatePassword->get('current_password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="form-label fw-semibold small">Nueva contraseña</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="form-control form-control-sm @if($errors->updatePassword->get('password')) is-invalid @endif">
            @if($errors->updatePassword->get('password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="form-label fw-semibold small">Confirmar contraseña</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="form-control form-control-sm @if($errors->updatePassword->get('password_confirmation')) is-invalid @endif">
            @if($errors->updatePassword->get('password_confirmation'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 pt-1">
            <button type="submit" class="btn btn-primary btn-sm fw-semibold">Guardar</button>
            @if (session('status') === 'password-updated')
                <span id="pw-saved-msg" class="text-success small">Contraseña actualizada.</span>
                <script>setTimeout(()=>{ const el=document.getElementById('pw-saved-msg'); if(el) el.remove(); },2000);</script>
            @endif
        </div>
    </form>
</section>
