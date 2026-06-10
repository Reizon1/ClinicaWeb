<section>
    <h6 class="fw-semibold mb-1">Información del Perfil</h6>
    <p class="text-muted small mb-4">Actualizá tu nombre y dirección de correo electrónico.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="d-flex flex-column gap-3">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="form-label fw-semibold small">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   class="form-control form-control-sm @error('name') is-invalid @enderror">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div>
            <label for="email" class="form-label fw-semibold small">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="form-control form-control-sm @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-muted mb-1">Tu dirección de correo no ha sido verificada.
                        <button form="send-verification" class="btn btn-link btn-sm p-0 fw-semibold">
                            Reenviar correo de verificación.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="small text-success">Se envió un nuevo enlace de verificación a tu correo.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 pt-1">
            <button type="submit" class="btn btn-primary btn-sm fw-semibold">Guardar</button>
            @if (session('status') === 'profile-updated')
                <span id="saved-msg" class="text-success small">Guardado.</span>
                <script>setTimeout(()=>{ const el=document.getElementById('saved-msg'); if(el) el.remove(); },2000);</script>
            @endif
        </div>
    </form>
</section>
