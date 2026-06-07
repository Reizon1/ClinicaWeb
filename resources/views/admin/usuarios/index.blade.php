<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'usuarios'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Gestión de Usuarios</h1>
                <p class="text-xs text-gray-400">Administrá los roles y accesos del sistema</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg">
                    {{ $usuarios->total() }} usuarios en total
                </span>
                <a href="{{ route('admin.usuarios.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Usuario
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-4">

            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.usuarios.index') }}" id="filtroForm"
                  class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="relative flex-1 min-w-48">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="Buscar por nombre o correo..."
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <select name="filtro_rol" onchange="document.getElementById('filtroForm').submit()"
                            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="">Todos los roles</option>
                        <option value="admin"         {{ request('filtro_rol')==='admin'?'selected':'' }}>Administrador</option>
                        <option value="medico"        {{ request('filtro_rol')==='medico'?'selected':'' }}>Médico</option>
                        <option value="recepcionista" {{ request('filtro_rol')==='recepcionista'?'selected':'' }}>Recepcionista</option>
                        <option value="paciente"      {{ request('filtro_rol')==='paciente'?'selected':'' }}>Paciente</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                        Filtrar
                    </button>
                    @if(request()->hasAny(['buscar','filtro_rol']))
                        <a href="{{ route('admin.usuarios.index') }}"
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
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuario</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rol Actual</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Registrado</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cambiar Rol</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $rolColors = [
                                'admin'         => 'bg-purple-100 text-purple-700',
                                'medico'        => 'bg-blue-100 text-blue-700',
                                'recepcionista' => 'bg-teal-100 text-teal-700',
                                'paciente'      => 'bg-gray-100 text-gray-600',
                            ];
                            $rolLabels = [
                                'admin'         => 'Administrador',
                                'medico'        => 'Médico',
                                'recepcionista' => 'Recepcionista',
                                'paciente'      => 'Paciente',
                            ];
                        @endphp

                        @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors {{ $usuario->id === auth()->id() ? 'bg-blue-50/40' : '' }}">
                            {{-- Usuario --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr($usuario->name,0,1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 flex items-center gap-1.5">
                                            {{ $usuario->name }}
                                            @if($usuario->id === auth()->id())
                                                <span class="text-xs text-blue-500 font-normal">(tú)</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $usuario->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Rol actual --}}
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $rolColors[$usuario->rol] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $rolLabels[$usuario->rol] ?? $usuario->rol }}
                                </span>
                            </td>

                            {{-- Fecha --}}
                            <td class="px-4 py-3.5 text-gray-500 text-xs">{{ $usuario->created_at->format('d M Y') }}</td>

                            {{-- Cambiar rol inline --}}
                            <td class="px-4 py-3.5">
                                @if($usuario->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.usuarios.rol', $usuario) }}">
                                    @csrf
                                    <div class="flex items-center gap-2">
                                        <select name="rol" class="px-2 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                            <option value="admin"         {{ $usuario->rol==='admin'?'selected':'' }}>Administrador</option>
                                            <option value="medico"        {{ $usuario->rol==='medico'?'selected':'' }}>Médico</option>
                                            <option value="recepcionista" {{ $usuario->rol==='recepcionista'?'selected':'' }}>Recepcionista</option>
                                            <option value="paciente"      {{ $usuario->rol==='paciente'?'selected':'' }}>Paciente</option>
                                        </select>
                                        <button type="submit"
                                                class="text-xs bg-blue-600 hover:bg-blue-700 text-white font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">No editable</span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.usuarios.show', $usuario) }}"
                                       class="text-xs font-semibold text-gray-500 hover:text-gray-700">Ver</a>
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                       class="text-xs font-semibold text-blue-600 hover:text-blue-800">Editar</a>
                                    @if($usuario->id !== auth()->id())
                                        <button onclick="abrirModalUsuario('{{ route('admin.usuarios.destroy', $usuario) }}', '{{ addslashes($usuario->name) }}')"
                                                class="text-xs font-semibold text-red-500 hover:text-red-700">
                                            Eliminar
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-300">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                                No se encontraron usuarios con los filtros aplicados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($usuarios->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $usuarios->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal de eliminación --}}
<div id="modalUsuario" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalUsuario()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">¿Eliminar usuario?</h3>
                <p class="text-xs text-gray-500">Esta acción no se puede deshacer.</p>
            </div>
        </div>
        <p class="text-sm text-gray-600 mb-5">
            Se eliminará permanentemente la cuenta de <strong id="nombreUsuario" class="text-gray-900"></strong>.
        </p>
        <div class="flex gap-3">
            <button onclick="cerrarModalUsuario()"
                    class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                Cancelar
            </button>
            <button onclick="confirmarEliminarUsuario()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
<form id="formUsuario" method="POST">@csrf @method('DELETE')</form>

<script>
let urlUsuario = '';
function abrirModalUsuario(url, nombre) {
    urlUsuario = url;
    document.getElementById('nombreUsuario').textContent = nombre;
    document.getElementById('modalUsuario').classList.remove('hidden');
}
function cerrarModalUsuario() {
    document.getElementById('modalUsuario').classList.add('hidden');
}
function confirmarEliminarUsuario() {
    document.getElementById('formUsuario').action = urlUsuario;
    document.getElementById('formUsuario').submit();
}
</script>
</body>
</html>
