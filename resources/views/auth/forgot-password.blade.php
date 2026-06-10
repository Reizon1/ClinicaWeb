<x-guest-layout>

    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size:1.5rem;color:#111827;">¿Olvidaste tu contraseña?</h1>
        <p class="text-muted" style="font-size:0.875rem;">
            Sin problema. Ingresa tu correo y te enviaremos un enlace para restablecerla.
        </p>
    </div>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Correo electrónico</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="tu@correo.com" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            Enviar enlace de restablecimiento
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-muted text-decoration-none d-inline-flex align-items-center gap-1"
           style="font-size:0.8rem;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al inicio de sesión
        </a>
    </div>

</x-guest-layout>
