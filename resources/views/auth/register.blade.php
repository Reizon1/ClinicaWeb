<x-guest-layout>

    {{-- Encabezado --}}
    <div class="mb-7">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Crear una cuenta</h1>
        <p class="text-sm text-gray-500">Regístrate para acceder al sistema de gestión clínica</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Nombre completo --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                Nombre completo
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus autocomplete="name"
                       placeholder="Carlos Eduardo Pérez"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 transition-all">
            </div>
            @error('name')
                <span class="text-red-500 text-xs mt-1.5 block font-medium">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                Correo electrónico
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username"
                       placeholder="tu@correo.com"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 transition-all">
            </div>
            @error('email')
                <span class="text-red-500 text-xs mt-1.5 block font-medium">{{ $message }}</span>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                Contraseña
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       placeholder="Mínimo 8 caracteres"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 transition-all">
            </div>
            {{-- Indicador de fortaleza de contraseña --}}
            <div id="password-strength-container" class="mt-2 text-xs font-semibold hidden">
                <span class="text-gray-500">Seguridad:</span>
                <span id="password-strength-text" class="text-red-500 font-bold">Fácil</span>
                <div class="w-full bg-gray-200 h-1.5 rounded-full mt-1.5 overflow-hidden">
                    <div id="password-strength-bar" class="h-full bg-red-500 rounded-full transition-all duration-300" style="width: 25%"></div>
                </div>
            </div>
            @error('password')
                <span class="text-red-500 text-xs mt-1.5 block font-medium">{{ $message }}</span>
            @enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                Confirmar contraseña
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password"
                       placeholder="Repite tu contraseña"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 transition-all">
            </div>
            @error('password_confirmation')
                <span class="text-red-500 text-xs mt-1.5 block font-medium">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="pt-1">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl
                           transition-colors shadow-lg shadow-blue-100 text-sm">
                Crear mi Cuenta
            </button>
        </div>
    </form>

    {{-- Separador --}}
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="bg-white px-3 text-gray-400">¿Ya tienes cuenta?</span>
        </div>
    </div>

    {{-- Login --}}
    <a href="{{ route('login') }}"
       class="w-full flex items-center justify-center gap-2 border border-gray-200 text-gray-700
              font-medium py-3.5 rounded-xl hover:bg-gray-50 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Iniciar sesión con cuenta existente
    </a>

    {{-- Volver al inicio --}}
    <div class="mt-6 text-center">
        <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al inicio
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthContainer = document.getElementById('password-strength-container');
            const strengthText = document.getElementById('password-strength-text');
            const strengthBar = document.getElementById('password-strength-bar');

            passwordInput.addEventListener('input', function() {
                const val = passwordInput.value;
                if (val.length === 0) {
                    strengthContainer.classList.add('hidden');
                    return;
                }
                strengthContainer.classList.remove('hidden');

                // Evaluate criteria
                const lengthOk = val.length >= 8;
                const upperOk = /[A-Z]/.test(val);
                const numbersCount = (val.match(/\d/g) || []).length;
                const numbersOk = numbersCount >= 2;
                const specialOk = /[!@#$%^&*(),.?":{}|<>_+\-\[\]\\\/]/.test(val);

                let score = 0;
                if (val.length > 0) score += 1;
                if (lengthOk) score += 1;
                if (upperOk) score += 1;
                if (numbersOk) score += 1;
                if (specialOk) score += 1;

                // Determine strength level
                const isHigh = lengthOk && upperOk && numbersOk && specialOk;
                const isMedium = lengthOk && (upperOk || numbersOk || specialOk) && !isHigh;

                if (isHigh) {
                    strengthText.textContent = 'Alto';
                    strengthText.className = 'text-green-500 font-bold';
                    strengthBar.className = 'h-full bg-green-500 rounded-full transition-all duration-300';
                    strengthBar.style.width = '100%';
                } else if (isMedium) {
                    strengthText.textContent = 'Medio';
                    strengthText.className = 'text-yellow-500 font-bold';
                    strengthBar.className = 'h-full bg-yellow-500 rounded-full transition-all duration-300';
                    strengthBar.style.width = '60%';
                } else {
                    strengthText.textContent = 'Fácil';
                    strengthText.className = 'text-red-500 font-bold';
                    strengthBar.className = 'h-full bg-red-500 rounded-full transition-all duration-300';
                    strengthBar.style.width = '30%';
                }
            });
        });
    </script>

</x-guest-layout>
