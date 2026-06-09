<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda Semanal – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .day-col { min-height: 200px; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-gray-900">

@php
$nombresdia = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
$badgeEstado = [
    'confirmada' => 'bg-blue-100 text-blue-700 border-blue-200',
    'pendiente'  => 'bg-amber-100 text-amber-700 border-amber-200',
    'completada' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
];
$hoy = \Carbon\Carbon::today()->format('Y-m-d');
@endphp

<div class="flex h-screen overflow-hidden">

    @include('partials.medico-sidebar', ['activeSection' => 'agenda-semanal'])

    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3.5 flex items-center justify-between flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-gray-900">Agenda Semanal</h1>
                    <p class="text-xs text-gray-400">Dr. {{ auth()->user()->name }} · {{ $medico->especialidad->nombre }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.medico') }}"
                   class="bg-white border border-gray-200 text-gray-600 text-xs font-semibold px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Vista Diaria
                </a>
                <a href="{{ route('historiales.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Historial
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto">

            {{-- Banner degradado con navegación de semana --}}
            <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 px-8 py-5 flex items-center justify-between">
                {{-- Semana anterior --}}
                <a href="{{ route('medico.agenda.semanal', ['semana' => $semanaPrev]) }}"
                   class="flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Semana anterior
                </a>

                {{-- Rango de la semana --}}
                <div class="text-center">
                    <div class="text-white font-bold text-lg">
                        {{ $inicioSemana->isoFormat('D [de] MMMM') }} – {{ $finSemana->isoFormat('D [de] MMMM [de] YYYY') }}
                    </div>
                    <div class="text-blue-200 text-xs mt-0.5">
                        {{ $citas->flatten()->count() }} {{ $citas->flatten()->count() === 1 ? 'cita' : 'citas' }} esta semana
                    </div>
                </div>

                {{-- Semana siguiente --}}
                <a href="{{ route('medico.agenda.semanal', ['semana' => $semanaNext]) }}"
                   class="flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors">
                    Semana siguiente
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="p-6">

                {{-- Ir a la semana actual --}}
                @if($inicioSemana->format('Y-m-d') !== \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d'))
                <div class="mb-4 flex justify-center">
                    <a href="{{ route('medico.agenda.semanal') }}"
                       class="bg-white border border-blue-200 text-blue-600 text-xs font-semibold px-4 py-2 rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                        Volver a la semana actual
                    </a>
                </div>
                @endif

                {{-- Grid semanal --}}
                <div class="grid grid-cols-7 gap-3">
                    @foreach($dias as $i => $dia)
                    @php
                        $fechaKey  = $dia->format('Y-m-d');
                        $citasDia  = $citas[$fechaKey] ?? collect();
                        $esHoy     = $fechaKey === $hoy;
                        $esFinde   = $dia->isWeekend();
                    @endphp

                    <div class="day-col flex flex-col rounded-2xl overflow-hidden border {{ $esHoy ? 'border-blue-400 shadow-blue-100 shadow-md' : 'border-gray-100' }} bg-white">

                        {{-- Cabecera del día --}}
                        <div class="px-3 py-3 text-center border-b {{ $esHoy ? 'bg-blue-600' : ($esFinde ? 'bg-slate-100' : 'bg-gray-50') }} {{ $esHoy ? 'border-blue-500' : 'border-gray-100' }}">
                            <div class="text-xs font-semibold {{ $esHoy ? 'text-blue-100' : ($esFinde ? 'text-slate-500' : 'text-gray-500') }} uppercase tracking-widest">
                                {{ $nombresdia[$i] }}
                            </div>
                            <div class="text-xl font-bold mt-0.5 {{ $esHoy ? 'text-white' : ($esFinde ? 'text-slate-400' : 'text-gray-800') }}">
                                {{ $dia->format('d') }}
                            </div>
                            @if($citasDia->count() > 0)
                            <div class="mt-1">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $esHoy ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $citasDia->count() }} {{ $citasDia->count() === 1 ? 'cita' : 'citas' }}
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Citas del día --}}
                        <div class="flex-1 p-2 space-y-2 overflow-y-auto" style="max-height:400px">
                            @forelse($citasDia as $cita)
                            <div class="rounded-xl border p-2.5 {{ $badgeEstado[$cita->estado] ?? 'bg-gray-50 text-gray-600 border-gray-200' }} text-xs">
                                <div class="font-bold text-sm mb-1">{{ $cita->fecha_hora->format('h:i A') }}</div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <div class="w-5 h-5 rounded-full bg-white/60 flex items-center justify-center font-bold flex-shrink-0" style="font-size:9px">
                                        {{ strtoupper(substr($cita->paciente->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold truncate">{{ $cita->paciente->user->name }}</span>
                                </div>
                                <div class="opacity-70 truncate">{{ $cita->motivo }}</div>
                                <div class="mt-2 flex gap-1 flex-wrap">
                                    @if($cita->estado === 'confirmada')
                                    <a href="{{ route('historiales.create') }}"
                                       class="bg-white/70 hover:bg-white text-blue-700 font-semibold px-2 py-0.5 rounded-lg transition-colors">
                                        Atender
                                    </a>
                                    @endif
                                    @if($cita->historialClinico)
                                    <a href="{{ route('historiales.show', $cita->historialClinico) }}"
                                       class="bg-white/70 hover:bg-white font-semibold px-2 py-0.5 rounded-lg transition-colors">
                                        Historial
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-gray-300 text-xs">Sin citas</span>
                            </div>
                            @endforelse
                        </div>

                    </div>
                    @endforeach
                </div>

                {{-- Leyenda --}}
                <div class="mt-5 flex items-center gap-6 justify-center">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                        <span>Confirmada</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <span>Pendiente</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        <span>Completada</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                        <span>Hoy</span>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
