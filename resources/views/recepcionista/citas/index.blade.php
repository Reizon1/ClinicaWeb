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
    @include('partials.recepcionista-sidebar', ['activeSection' => 'citas'])

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
                                <div class="flex items-center gap-2">
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
                                @elseif($cita->estado === 'completada')
                                    @if(!$cita->pago)
                                    <a href="{{ route('recepcionista.pagos.crear', $cita) }}"
                                       class="inline-flex items-center gap-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Pagar
                                    </a>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-green-600 text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Pagado
                                    </span>
                                    @endif
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
