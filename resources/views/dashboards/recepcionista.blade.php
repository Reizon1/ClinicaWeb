<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Recepcionista – Los Mollos</title>
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
            <div class="px-3 py-1 mb-1"><span class="text-xs font-semibold text-teal-400 uppercase tracking-widest">Principal</span></div>
            <a href="{{ route('dashboard.recepcionista') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-teal-700 text-white text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-teal-400 uppercase tracking-widest">Gestión</span></div>
            <a href="{{ route('recepcionista.citas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-teal-100 hover:bg-teal-800 text-sm transition-colors">
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
        <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Recepción – Resumen del día</h1>
                <p class="text-xs text-gray-400">{{ now()->format('d \d\e F \d\e Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('recepcionista.citas.crear') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Cita
                </a>
                <a href="{{ route('recepcionista.pacientes.crear') }}" class="bg-white border border-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 hover:bg-gray-50 transition-colors">
                    Registrar Paciente
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="w-9 h-9 bg-teal-50 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $citasHoy->count() }}</div>
                    <div class="text-xs text-gray-400 mt-1">Citas de hoy</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $citasPendientes }}</div>
                    <div class="text-xs text-gray-400 mt-1">Citas pendientes (total)</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalPacientes }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pacientes registrados</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Agenda de Hoy</h3>
                    <a href="{{ route('recepcionista.citas') }}" class="text-xs font-semibold text-teal-600 hover:underline">Ver todas</a>
                </div>
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Hora</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Médico</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($citasHoy as $cita)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5 font-semibold text-gray-900">{{ $cita->fecha_hora->format('h:i A') }}</td>
                            <td class="px-4 py-3.5 font-medium text-gray-800">{{ $cita->paciente->user->name }}</td>
                            <td class="px-4 py-3.5 text-gray-600">Dr. {{ $cita->medico->user->name }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold text-xs {{ $badgeEstado[$cita->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if(!in_array($cita->estado, ['completada', 'cancelada']))
                                <div class="flex items-center gap-3">
                                    <form method="POST" action="{{ route('recepcionista.citas.cancelar', $cita) }}" onsubmit="return confirm('¿Cancelar esta cita?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Cancelar</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">No hay citas programadas para hoy.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
