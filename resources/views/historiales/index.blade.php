<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historiales Clínicos – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.medico-sidebar', ['activeSection' => 'historiales'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Historiales Clínicos</h1>
                <p class="text-xs text-gray-400">Registros médicos de tus pacientes atendidos · {{ $historiales->total() }} registros</p>
            </div>
            <a href="{{ route('historiales.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Historial
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-4">

            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('historiales.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="relative flex-1 min-w-48">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="Buscar paciente..."
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-500 whitespace-nowrap">Desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                               class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-500 whitespace-nowrap">Hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                               class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                        Filtrar
                    </button>
                    @if(request()->hasAny(['buscar','fecha_desde','fecha_hasta']))
                        <a href="{{ route('historiales.index') }}"
                           class="text-sm text-gray-500 hover:text-gray-700 px-2 py-2.5 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Diagnóstico</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tratamiento</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($historiales as $h)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr($h->paciente->user->name,0,1)) }}</span>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $h->paciente->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 max-w-xs">
                                <p class="truncate">{{ $h->diagnostico }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-gray-500 max-w-xs">
                                <p class="truncate text-xs">{{ $h->tratamiento }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap">
                                {{ $h->fecha->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('historiales.show', $h) }}"
                                       class="text-xs font-semibold text-gray-500 hover:text-gray-700">Ver</a>
                                    <a href="{{ route('historiales.edit', $h) }}"
                                       class="text-xs font-semibold text-blue-600 hover:text-blue-800">Editar</a>
                                    <button onclick="abrirModalHistorial('{{ route('historiales.destroy', $h) }}', '{{ addslashes($h->paciente->user->name) }}')"
                                            class="text-xs font-semibold text-red-500 hover:text-red-700">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                                @if(request()->hasAny(['buscar','fecha_desde','fecha_hasta']))
                                    No se encontraron historiales con los filtros aplicados.
                                @else
                                    No hay historiales registrados aún.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($historiales->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $historiales->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal de eliminación --}}
<div id="modalHistorial" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalHistorial()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">¿Eliminar historial?</h3>
                <p class="text-xs text-gray-500">Esta acción no se puede deshacer.</p>
            </div>
        </div>
        <p class="text-sm text-gray-600 mb-5">
            Se eliminará el historial clínico de <strong id="nombrePacHistorial" class="text-gray-900"></strong>.
        </p>
        <div class="flex gap-3">
            <button onclick="cerrarModalHistorial()"
                    class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                Cancelar
            </button>
            <button onclick="confirmarEliminarHistorial()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
<form id="formHistorial" method="POST">@csrf @method('DELETE')</form>

<script>
let urlHistorial = '';
function abrirModalHistorial(url, nombre) {
    urlHistorial = url;
    document.getElementById('nombrePacHistorial').textContent = nombre;
    document.getElementById('modalHistorial').classList.remove('hidden');
}
function cerrarModalHistorial() { document.getElementById('modalHistorial').classList.add('hidden'); }
function confirmarEliminarHistorial() {
    document.getElementById('formHistorial').action = urlHistorial;
    document.getElementById('formHistorial').submit();
}
</script>
</body>
</html>
