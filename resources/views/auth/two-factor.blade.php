<x-guest-layout>

    {{-- Encabezado --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Verificación de Dos Factores (2FA)</h1>
        <p class="text-sm text-gray-500">Hemos enviado un código de seguridad de 6 dígitos a tu correo electrónico</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2.5">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                @foreach ($errors->all() as $error)
                    <p class="font-medium">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.store') }}" class="space-y-5">
        @csrf

        {{-- Código de verificación --}}
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1.5">
                Código de Seguridad
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="code" type="text" name="code"
                       required autofocus autocomplete="one-time-code"
                       placeholder="000000" maxlength="6"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              placeholder-gray-400 text-center tracking-widest font-extrabold text-lg transition-all">
            </div>
        </div>

        {{-- Botón --}}
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl
                       transition-colors shadow-lg shadow-blue-100 text-sm">
            Verificar Código
        </button>
    </form>

    {{-- Volver al login --}}
    <div class="mt-8 text-center border-t border-gray-100 pt-6">
        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="inline">
            @csrf
            <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 transition-colors inline-flex items-center gap-1 bg-transparent border-0 cursor-pointer">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Cancelar y volver
            </button>
        </form>
    </div>

</x-guest-layout>
