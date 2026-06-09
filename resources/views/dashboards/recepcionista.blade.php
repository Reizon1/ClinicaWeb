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
<body class="antialiased bg-slate-50 text-gray-900">

@php
    $badgeEstado = [
        'confirmada' => 'bg-blue-100 text-blue-700',
        'pendiente'  => 'bg-amber-100 text-amber-700',
        'completada' => 'bg-emerald-100 text-emerald-700',
        'cancelada'  => 'bg-red-100 text-red-600',
    ];
@endphp

<div class="flex h-screen overflow-hidden">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'dashboard'])

    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3.5 flex items-center justify-between flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-gray-900">Panel de Recepción</h1>
                    <p class="text-xs text-gray-400">{{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('recepcionista.citas.crear') }}"
                   class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-4 py-2 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Cita
                </a>
                <a href="{{ route('recepcionista.pacientes.crear') }}"
                   class="bg-white border border-gray-200 text-gray-700 text-xs font-semibold px-4 py-2 rounded-xl flex items-center gap-1.5 hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Nuevo Paciente
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto">

            {{-- Hero Banner --}}
            <div class="bg-gradient-to-r from-teal-700 via-teal-600 to-cyan-600 px-8 py-7 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="350" cy="30" r="80" fill="white"/>
                        <circle cx="50" cy="170" r="60" fill="white"/>
                    </svg>
                </div>
                <div class="relative">
                    <p class="text-teal-200 text-xs font-semibold uppercase tracking-widest mb-1">Clínica Los Mollos</p>
                    <h2 class="text-2xl font-bold text-white mb-1">
                        Bienvenida, {{ explode(' ', auth()->user()->name)[0] }}
                    </h2>
                    <p class="text-teal-100 text-sm">
                        @if($citasHoy->count() > 0)
                            Tenés <span class="font-bold text-white">{{ $citasHoy->count() }}</span> {{ $citasHoy->count() === 1 ? 'cita programada' : 'citas programadas' }} para hoy.
                        @else
                            No hay citas programadas para hoy. ¡Buen momento para organizar!
                        @endif
                    </p>
                </div>
            </div>

            <div class="p-6 space-y-6">

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tarjetas de estadísticas --}}
                <div class="grid grid-cols-4 gap-4">
                    {{-- Citas hoy --}}
                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl p-5 text-white shadow-md">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="text-3xl font-bold">{{ $citasHoy->count() }}</div>
                        <div class="text-teal-100 text-xs mt-1 font-medium">Citas hoy</div>
                    </div>

                    {{-- Pendientes --}}
                    <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-5 text-white shadow-md">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-3xl font-bold">{{ $citasPendientes }}</div>
                        <div class="text-amber-100 text-xs mt-1 font-medium">Pendientes de confirmar</div>
                    </div>

                    {{-- Pacientes --}}
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 text-white shadow-md">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="text-3xl font-bold">{{ $totalPacientes }}</div>
                        <div class="text-blue-100 text-xs mt-1 font-medium">Pacientes registrados</div>
                    </div>

                    {{-- Médicos disponibles --}}
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 text-white shadow-md">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="text-3xl font-bold">{{ $medicosDisponibles }}</div>
                        <div class="text-emerald-100 text-xs mt-1 font-medium">Médicos disponibles</div>
                    </div>
                </div>

                {{-- Agenda del día --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center gap-2.5">
                            <div class="w-2 h-5 bg-teal-500 rounded-full"></div>
                            <h3 class="text-sm font-bold text-gray-900">Agenda de Hoy</h3>
                            <span class="bg-teal-100 text-teal-700 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $citasHoy->count() }}</span>
                        </div>
                        <a href="{{ route('recepcionista.citas') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700 flex items-center gap-1">
                            Ver todas
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Hora</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Médico</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Especialidad</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($citasHoy as $cita)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900 text-sm">{{ $cita->fecha_hora->format('h:i') }}</span>
                                    <span class="text-gray-400 ml-0.5 text-xs">{{ $cita->fecha_hora->format('A') }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($cita->paciente->user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $cita->paciente->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-600">Dr. {{ $cita->medico->user->name }}</td>
                                <td class="px-4 py-4 text-gray-500">{{ $cita->especialidad->nombre }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-2.5 py-1 rounded-full font-semibold text-xs {{ $badgeEstado[$cita->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @if(!in_array($cita->estado, ['completada', 'cancelada']))
                                    <form method="POST" action="{{ route('recepcionista.citas.cancelar', $cita) }}"
                                          onsubmit="return confirm('¿Cancelar esta cita?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">Cancelar</button>
                                    </form>
                                    @else
                                    <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">Sin citas para hoy</p>
                                    <p class="text-gray-400 text-xs mt-1">Podés agendar nuevas citas desde el menú lateral.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
