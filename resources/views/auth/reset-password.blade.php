<x-guest-layout>

    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size:1.5rem;color:#111827;">Nueva contraseña</h1>
        <p class="text-muted" style="font-size:0.875rem;">Ingresa y confirma tu nueva contraseña.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <x-text-input id="email" type="email" name="email"
                          :value="old('email', $request->email)"
                          class="@error('email') is-invalid @enderror"
                          required autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña</label>
            <x-text-input id="password" type="password" name="password"
                          class="@error('password') is-invalid @enderror"
                          required autocomplete="new-password"/>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                          class="@error('password_confirmation') is-invalid @enderror"
                          required autocomplete="new-password"/>
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button class="w-100 justify-content-center py-2">
            Restablecer Contraseña
        </x-primary-button>
    </form>

</x-guest-layout>
