<x-guest-layout>

    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size:1.5rem;color:#111827;">Bienvenido de nuevo</h1>
        <p class="text-muted" style="font-size:0.875rem;">Ingresa tus credenciales para acceder al sistema</p>
    </div>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="tu@correo.com" required autofocus autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        {{-- Contraseña --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label mb-0">Contraseña</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-primary text-decoration-none"
                       style="font-size:0.8rem;">¿Olvidaste tu contraseña?</a>
                @endif
            </div>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••" required autocomplete="current-password">
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        {{-- Recuérdame --}}
        <div class="mb-4 form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label for="remember_me" class="form-check-label" style="font-size:0.875rem;">
                Recordar mi sesión
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Ingresar al Sistema
        </button>
    </form>

    <div class="position-relative text-center my-4">
        <hr>
        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted"
              style="font-size:0.8rem;">¿No tienes cuenta?</span>
    </div>

    <a href="{{ route('register') }}"
       class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Crear una cuenta nueva
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
