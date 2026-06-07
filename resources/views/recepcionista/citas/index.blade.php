<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Citas – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

@php
    $badgeEstado = [
        'confirmada' => 'bg-blue-100 text-blue-700',
        'pendiente'  => 'bg-yellow-100 text-yellow-700',
        'completada' => 'bg-green-100 text-green-700',
        'cancelada'  => 'bg-red-100 text-red-600',
    ];
@endphp

<div class="flex h-screen overflow-hidden">
    <aside class="w-56 flex-shrink-0 flex flex-col bg-teal-900">
        <div class="px-5 py-5 border-b border-teal-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">Los Mollos</div>
                    <div class="text-teal-400 text-xs">RECEPCIÓN</div>
                </div>
            </div>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <a href="{{ route('dashboard.recepcionista') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-teal-100 hover:bg-teal-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('recepcionista.citas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-teal-700 text-white text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Todas las Citas
            </a>
            <a href="{{ route('recepcionista.citas.crear') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-teal-100 hover:bg-teal-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                Nueva Cita
            </a>
            <a href="{{ route('recepcionista.pacientes.crear') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-teal-100 hover:bg-teal-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Registrar Paciente
            </a>
        </nav>
        <div class="px-3 py-4 border-t border-teal-800">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-red-300 hover:bg-red-500/20 text-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Gestión de Citas</h1>
                <p class="text-xs text-gray-400">Agenda, reprogramá y cancelá citas médicas</p>
            </div>
            <a href="{{ route('recepcionista.citas.crear') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Cita
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-4">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">{{ $errors->first() }}</div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('recepcionista.citas') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex items-center gap-3">
                    <input type="date" name="fecha" value="{{ request('fecha') }}" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                    <select name="estado" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                        <option value="confirmada" {{ request('estado')=='confirmada'?'selected':'' }}>Confirmada</option>
                        <option value="completada" {{ request('estado')=='completada'?'selected':'' }}>Completada</option>
                        <option value="cancelada" {{ request('estado')=='cancelada'?'selected':'' }}>Cancelada</option>
                    </select>
                    <select name="medico_id" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Todos los médicos</option>
                        @foreach($medicos as $m)
                            <option value="{{ $m->id }}" {{ request('medico_id')==$m->id?'selected':'' }}>Dr. {{ $m->user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-teal-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl hover:bg-teal-700 transition-colors">Filtrar</button>
                    <a href="{{ route('recepcionista.citas') }}" class="text-xs text-gray-500 hover:text-gray-700">Limpiar</a>
                </div>
            </form>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha/Hora</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Médico</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($citas as $cita)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5 font-semibold text-gray-800">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3.5 text-gray-700">{{ $cita->paciente->user->name }}</td>
                            <td class="px-4 py-3.5 text-gray-600">Dr. {{ $cita->medico->user->name }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold {{ $badgeEstado[$cita->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if(!in_array($cita->estado, ['completada', 'cancelada']))
                                <div class="flex items-center gap-2" x-data="{ open: false }">
                                    <button onclick="this.closest('tr').querySelector('.reprog-form').classList.toggle('hidden')"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">Reprogramar</button>
                                    <form method="POST" action="{{ route('recepcionista.citas.cancelar', $cita) }}" onsubmit="return confirm('¿Cancelar esta cita?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Cancelar</button>
                                    </form>
                                </div>
                                <form method="POST" action="{{ route('recepcionista.citas.reprogramar', $cita) }}" class="reprog-form hidden mt-2 flex gap-2">
                                    @csrf @method('PATCH')
                                    <input type="datetime-local" name="fecha_hora" required class="px-2 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                    <button type="submit" class="bg-blue-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-700">Guardar</button>
                                </form>
                                @else
                                <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No se encontraron citas con los filtros aplicados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($citas->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $citas->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
