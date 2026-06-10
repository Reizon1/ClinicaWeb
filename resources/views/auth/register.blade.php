<x-guest-layout>

    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size:1.5rem;color:#111827;">Crear una cuenta</h1>
        <p class="text-muted" style="font-size:0.875rem;">Regístrate para acceder al sistema de gestión clínica</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Carlos Eduardo Pérez" required autofocus autocomplete="name">
            </div>
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="tu@correo.com" required autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Mínimo 8 caracteres" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       placeholder="Repite tu contraseña" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Crear mi Cuenta
        </button>
    </form>

    <div class="position-relative text-center my-4">
        <hr>
        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted"
              style="font-size:0.8rem;">¿Ya tienes cuenta?</span>
    </div>

    <a href="{{ route('login') }}"
       class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Iniciar sesión con cuenta existente
    </a>

    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="text-muted text-decoration-none d-inline-flex align-items-center gap-1"
           style="font-size:0.8rem;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al inicio
        </a>
    </div>

</x-guest-layout>
