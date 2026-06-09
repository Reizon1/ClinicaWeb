<x-guest-layout>

    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size:1.5rem;color:#111827;">Confirmar contraseña</h1>
        <p class="text-muted" style="font-size:0.875rem;">
            Esta es una zona segura. Por favor confirma tu contraseña antes de continuar.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <x-text-input id="password" type="password" name="password"
                          class="@error('password') is-invalid @enderror"
                          required autocomplete="current-password"/>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button class="w-100 justify-content-center py-2">
            Confirmar
        </x-primary-button>
    </form>

</x-guest-layout>
