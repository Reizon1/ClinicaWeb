<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médicos – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'medicos'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Gestión de Médicos</h1>
                <p class="text-xs text-gray-400">Alta, edición, consulta y baja de médicos del sistema</p>
            </div>
            <a href="{{ route('admin.medicos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Médico
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-4">

            {{-- Alertas de sesión --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="text-sm text-red-700 space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
                    </div>
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.medicos.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="relative flex-1 min-w-48">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o correo..." class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <select name="especialidad_id" class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Todas las especialidades</option>
                        @foreach($especialidades as $e)
                            <option value="{{ $e->id }}" {{ request('especialidad_id')==$e->id?'selected':'' }}>{{ $e->nombre }}</option>
                        @endforeach
                    </select>
                    <select name="disponible" class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Todos los estados</option>
                        <option value="1" {{ request('disponible')==='1'?'selected':'' }}>Disponible</option>
                        <option value="0" {{ request('disponible')==='0'?'selected':'' }}>Inactivo</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">Filtrar</button>
                    @if(request()->hasAny(['buscar','especialidad_id','disponible']))
                        <a href="{{ route('admin.medicos.index') }}" class="text-sm text-gray-500 hover:text-gray-700 px-2 py-2.5">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Especialidad</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Licencia</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($medicos as $medico)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-blue-700 font-bold text-xs">{{ strtoupper(substr($medico->user->name,0,1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $medico->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $medico->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600">{{ $medico->especialidad->nombre }}</td>
                            <td class="px-4 py-3.5 text-gray-500 font-mono text-xs">{{ $medico->numero_licencia }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $medico->disponible ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $medico->disponible ? 'Disponible' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.medicos.show', $medico) }}" class="text-xs font-semibold text-gray-500 hover:text-gray-700 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.medicos.edit', $medico) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Editar</a>
                                    <button onclick="abrirModalEliminar('{{ route('admin.medicos.destroy', $medico) }}', '{{ addslashes($medico->user->name) }}')"
                                        class="text-xs font-semibold text-red-500 hover:text-red-700">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            No se encontraron médicos con los filtros aplicados.
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($medicos->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $medicos->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal de eliminación --}}
<div id="modalEliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalEliminar()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 animate-in">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">¿Eliminar médico?</h3>
                <p class="text-xs text-gray-500">Esta acción no se puede deshacer.</p>
            </div>
        </div>
        <p class="text-sm text-gray-600 mb-5">Se eliminará permanentemente la cuenta y todos los datos asociados de <strong id="nombreMedico" class="text-gray-900"></strong>.</p>
        <div class="flex gap-3">
            <button onclick="cerrarModalEliminar()" class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors font-medium">
                Cancelar
            </button>
            <button onclick="confirmarEliminar()" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
<form id="formEliminar" method="POST">@csrf @method('DELETE')</form>

<script>
let urlEliminar = '';
function abrirModalEliminar(url, nombre) {
    urlEliminar = url;
    document.getElementById('nombreMedico').textContent = nombre;
    document.getElementById('modalEliminar').classList.remove('hidden');
}
function cerrarModalEliminar() {
    document.getElementById('modalEliminar').classList.add('hidden');
}
function confirmarEliminar() {
    document.getElementById('formEliminar').action = urlEliminar;
    document.getElementById('formEliminar').submit();
}
</script>
</body>
</html>
