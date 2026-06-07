<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médicos — Los Mollos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">Los Mollos</a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-blue-600">Mi Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600">Ingresar</a>
                    <a href="{{ route('register') }}" class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Encabezado --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Nuestros Médicos</h1>
            <p class="text-gray-500 mt-1">Encontrá al especialista que necesitás</p>
        </div>

        {{-- Formulario de búsqueda --}}
        <form method="GET" action="{{ route('medicos.buscar') }}"
              class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- Filtro por nombre --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del médico</label>
                    <input type="text" name="nombre" value="{{ request('nombre') }}"
                           placeholder="Ej: Dr. García"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Filtro por especialidad --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                    <select name="especialidad_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todas las especialidades</option>
                        @foreach ($especialidades as $esp)
                            <option value="{{ $esp->id }}"
                                {{ request('especialidad_id') == $esp->id ? 'selected' : '' }}>
                                {{ $esp->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Botones --}}
                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Buscar
                    </button>
                    @if(request('nombre') || request('especialidad_id'))
                        <a href="{{ route('medicos.buscar') }}"
                           class="px-4 py-2 text-sm text-gray-500 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Limpiar
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Resultados --}}
        @if ($medicos->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">No se encontraron médicos con esos filtros.</p>
                <a href="{{ route('medicos.buscar') }}" class="text-blue-500 text-sm hover:underline mt-1 inline-block">Ver todos</a>
            </div>
        @else
            <p class="text-sm text-gray-400 mb-4">{{ $medicos->count() }} médico(s) encontrado(s)</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($medicos as $medico)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col gap-4">

                        {{-- Avatar + nombre --}}
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xl flex-shrink-0">
                                {{ strtoupper(substr($medico->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $medico->user->name }}</p>
                                <p class="text-sm text-blue-600">{{ $medico->especialidad->nombre }}</p>
                            </div>
                        </div>

                        {{-- Descripción --}}
                        @if ($medico->descripcion)
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $medico->descripcion }}</p>
                        @endif

                        {{-- Datos --}}
                        <div class="text-xs text-gray-400 space-y-1">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Licencia: {{ $medico->numero_licencia }}
                            </div>
                            @if ($medico->telefono)
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $medico->telefono }}
                                </div>
                            @endif
                        </div>

                        {{-- Botón agendar --}}
                        @auth
                            @if(auth()->user()->rol === 'paciente')
                                <a href="{{ route('citas.crear', ['medico_id' => $medico->id]) }}"
                                   class="mt-auto block text-center bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    Agendar Cita
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="mt-auto block text-center border border-blue-600 text-blue-600 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                                Ingresar para agendar
                            </a>
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
