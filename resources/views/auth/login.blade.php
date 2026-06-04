<x-guest-layout>

    {{-- Encabezado --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Bienvenido de nuevo</h1>
        <p class="text-sm text-gray-500">Ingresa tus credenciales para acceder al sistema</p>
    </div>

    {{-- Estado de sesión (se activa con la lógica) --}}
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

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
                       required autofocus autocomplete="username"
                       placeholder="tu@correo.com"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 transition-all">
            </div>
            {{-- <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" /> --}}
        </div>

        {{-- Contraseña --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Contraseña
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs font-medium text-blue-600 hover:text-blue-700 transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 transition-all">
            </div>
            {{-- <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" /> --}}
        </div>

        {{-- Recuérdame --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
            <label for="remember_me" class="text-sm text-gray-600 cursor-pointer select-none">
                Recordar mi sesión
            </label>
        </div>

        {{-- Botón --}}
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl
                       transition-colors shadow-lg shadow-blue-100 text-sm">
            Ingresar al Sistema
        </button>
    </form>

    {{-- Separador --}}
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="bg-white px-3 text-gray-400">¿No tienes cuenta?</span>
        </div>
    </div>

    {{-- Registro --}}
    <a href="{{ route('register') }}"
       class="w-full flex items-center justify-center gap-2 border border-gray-200 text-gray-700
              font-medium py-3.5 rounded-xl hover:bg-gray-50 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Crear una cuenta nueva
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

</x-guest-layout>
