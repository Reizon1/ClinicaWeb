<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Especialidades – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'especialidades'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Gestión de Especialidades</h1>
                <p class="text-xs text-gray-400">Alta, edición y baja de especialidades médicas</p>
            </div>
            <a href="{{ route('admin.especialidades.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Especialidad
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-4">

            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Médicos</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($especialidades as $esp)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5 font-semibold text-gray-800">{{ $esp->nombre }}</td>
                            <td class="px-4 py-3.5 text-gray-500 max-w-xs truncate">{{ $esp->descripcion ?? '—' }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">{{ $esp->medicos_count }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $esp->activa ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $esp->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.especialidades.edit', $esp) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Editar</a>
                                    @if($esp->medicos_count === 0)
                                        <button onclick="abrirModal('{{ route('admin.especialidades.destroy', $esp) }}', '{{ addslashes($esp->nombre) }}')"
                                            class="text-xs font-semibold text-red-500 hover:text-red-700">Eliminar</button>
                                    @else
                                        <span class="text-xs text-gray-300" title="Tiene médicos asignados">No eliminable</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">No hay especialidades registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($especialidades->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $especialidades->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal eliminación --}}
<div id="modalElim" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">¿Eliminar especialidad?</h3>
                <p class="text-xs text-gray-500">Esta acción no se puede deshacer.</p>
            </div>
        </div>
        <p class="text-sm text-gray-600 mb-5">Se eliminará permanentemente la especialidad <strong id="nombreEsp" class="text-gray-900"></strong>.</p>
        <div class="flex gap-3">
            <button onclick="cerrarModal()" class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Cancelar</button>
            <button onclick="confirmar()" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl">Sí, eliminar</button>
        </div>
    </div>
</div>
<form id="formElim" method="POST">@csrf @method('DELETE')</form>

<script>
let urlElim = '';
function abrirModal(url, nombre) { urlElim = url; document.getElementById('nombreEsp').textContent = nombre; document.getElementById('modalElim').classList.remove('hidden'); }
function cerrarModal() { document.getElementById('modalElim').classList.add('hidden'); }
function confirmar() { document.getElementById('formElim').action = urlElim; document.getElementById('formElim').submit(); }
</script>
</body>
</html>
