<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Médico – Los Mollos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

@php
    $iniciales = collect(explode(' ', auth()->user()->name))
        ->map(fn($w) => strtoupper($w[0] ?? ''))
        ->take(2)->join('');

    $badgeEstado = [
        'confirmada' => 'bg-blue-100 text-blue-700',
        'pendiente'  => 'bg-yellow-100 text-yellow-700',
        'completada' => 'bg-green-100 text-green-700',
        'cancelada'  => 'bg-red-100 text-red-600',
    ];
@endphp

<div class="flex h-screen overflow-hidden">

    @include('partials.medico-sidebar', ['activeSection' => 'dashboard'])

    {{-- CONTENIDO --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center gap-4 flex-shrink-0">
            <form method="GET" action="{{ route('historiales.index') }}" class="flex-1">
                <div class="relative max-w-xs">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="buscar" placeholder="Buscar pacientes o expedientes..."
                           class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                </div>
            </form>
            <div class="flex items-center gap-2">
                <button class="relative p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2">
                    <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold" style="font-size:9px">{{ $iniciales }}</span>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-800 leading-none">Dr. {{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-400 leading-none mt-0.5">{{ $medico->especialidad->nombre }}</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-base font-bold text-gray-900">Resumen Diario</h1>
                    <p class="text-xs text-gray-400">Bienvenido de nuevo, Dr. {{ auth()->user()->name }}. Aquí tienes tu jornada de hoy.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('recetas.create') }}" class="bg-white border border-gray-200 text-gray-700 text-xs font-semibold px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Crear Receta
                    </a>
                    <a href="{{ route('horarios.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Mis Horarios
                    </a>
                </div>
            </div>

            {{-- Stats del día con datos reales --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">{{ $totalCitasHoy }}</div>
                    <div class="text-xs text-gray-400 mt-1">Citas de Hoy</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">{{ $citasAtendidas }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pacientes Atendidos</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="w-8 h-8 bg-orange-50 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-xl font-bold text-gray-900">{{ $citasPendientes }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pendientes</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="w-8 h-8 bg-purple-50 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    @if($proximaCita)
                        <div class="text-sm font-bold text-gray-900 leading-tight">{{ $proximaCita->fecha_hora->format('h:i A') }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $proximaCita->paciente->user->name }}</div>
                    @else
                        <div class="text-sm font-bold text-gray-400">Sin citas</div>
                        <div class="text-xs text-gray-400 mt-1">Próxima cita</div>
                    @endif
                </div>
            </div>

            {{-- Agenda del Día + Pacientes Recientes --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- Agenda con datos reales --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">
                            Agenda del Día
                            <span class="text-gray-400 font-normal">(Hoy, {{ now()->format('d M') }})</span>
                        </h3>
                    </div>
                    <table class="w-full text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Hora</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($citasHoy as $cita)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3.5 font-semibold text-gray-900">{{ $cita->fecha_hora->format('h:i A') }}</td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-blue-700 font-bold" style="font-size:9px">{{ strtoupper(substr($cita->paciente->user->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $cita->paciente->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full font-semibold {{ $badgeEstado[$cita->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-2">
                                        @if($cita->estado === 'confirmada')
                                            <a href="{{ route('historiales.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">Atender</a>
                                        @endif
                                        @if($cita->historialClinico)
                                            <a href="{{ route('historiales.show', $cita->historialClinico) }}" class="text-xs text-blue-500 hover:text-blue-700 transition-colors font-medium">Ver Historial</a>
                                        @else
                                            <span class="text-xs text-gray-300 font-medium">Sin historial</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-400">No tienes citas programadas para hoy.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if($citasHoy->count() > 0)
                    <div class="px-5 py-3 border-t border-gray-50 text-center">
                        <a href="{{ route('historiales.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">VER HISTORIALES / CITAS</a>
                    </div>
                    @endif
                </div>

                {{-- Pacientes Recientes + Recordatorio --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Pacientes Recientes</h3>
                        <div class="space-y-3">
                            @forelse($pacientesRecientes as $pac)
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-blue-700 font-bold text-xs">{{ strtoupper(substr($pac->user->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-semibold text-gray-800">{{ $pac->user->name }}</div>
                                    <div class="text-xs text-gray-400">
                                        Última consulta: {{ $pac->citas->where('medico_id', $medico->id)->sortByDesc('fecha_hora')->first()?->fecha_hora->diffForHumans() ?? 'N/A' }}
                                    </div>
                                </div>
                                <button class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            @empty
                            <p class="text-xs text-gray-400">Sin pacientes atendidos aún.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('historiales.index') }}" class="mt-4 block w-full text-xs font-semibold text-blue-600 hover:underline text-center">VER HISTORIALES DE PACIENTES</a>
                    </div>

                    {{-- Recordatorio estático (se conectará a notificaciones en siguiente etapa) --}}
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                        <div class="flex items-start gap-2.5">
                            <div class="w-7 h-7 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-blue-800 mb-1">Recordatorio de hoy</div>
                                <p class="text-xs text-blue-600 leading-relaxed">
                                    No olvides completar los informes antes del cierre del sistema a las 18:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
