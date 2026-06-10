<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda Semanal – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .day-col { min-height: 220px; }
        .cita-confirmada { background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe; }
        .cita-pendiente  { background:#fffbeb;color:#92400e;border-color:#fde68a; }
        .cita-completada { background:#f0fdf4;color:#14532d;border-color:#bbf7d0; }
    </style>
</head>
<body>
@php
$nombresdia = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
$hoy = \Carbon\Carbon::today()->format('Y-m-d');
@endphp

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'agenda-semanal'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#eff6ff;width:34px;height:34px;border-radius:8px;">
                    <svg width="16" height="16" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Agenda Semanal</h5>
                    <p class="text-muted mb-0" style="font-size:0.7rem;">Dr. {{ auth()->user()->name }} · {{ $medico->especialidad->nombre }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.medico') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Vista Diaria
                </a>
                <a href="{{ route('historiales.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Historial
                </a>
            </div>
        </header>

        <main class="flex-grow-1" style="overflow-y:auto;">

            {{-- Banner con navegación de semana --}}
            <div class="px-4 py-3 d-flex align-items-center justify-content-between" style="background:linear-gradient(135deg,#1d4ed8,#2563eb,#4338ca);">
                <a href="{{ route('medico.agenda.semanal', ['semana' => $semanaPrev]) }}"
                   class="btn btn-sm d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.15);color:white;border:none;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Semana anterior
                </a>
                <div class="text-center">
                    <div class="text-white fw-bold">{{ $inicioSemana->isoFormat('D [de] MMMM') }} – {{ $finSemana->isoFormat('D [de] MMMM [de] YYYY') }}</div>
                    <div style="color:rgba(191,219,254,0.9);font-size:0.72rem;">{{ $citas->flatten()->count() }} {{ $citas->flatten()->count() === 1 ? 'cita' : 'citas' }} esta semana</div>
                </div>
                <a href="{{ route('medico.agenda.semanal', ['semana' => $semanaNext]) }}"
                   class="btn btn-sm d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.15);color:white;border:none;">
                    Semana siguiente
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="p-4">

                @if($inicioSemana->format('Y-m-d') !== \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d'))
                <div class="d-flex justify-content-center mb-3">
                    <a href="{{ route('medico.agenda.semanal') }}" class="btn btn-outline-primary btn-sm">Volver a la semana actual</a>
                </div>
                @endif

                {{-- Grid semanal --}}
                <div class="row g-2">
                    @foreach($dias as $i => $dia)
                    @php
                        $fechaKey = $dia->format('Y-m-d');
                        $citasDia = $citas[$fechaKey] ?? collect();
                        $esHoy    = $fechaKey === $hoy;
                        $esFinde  = $dia->isWeekend();
                    @endphp
                    <div class="col">
                        <div class="day-col d-flex flex-column rounded-3 overflow-hidden border {{ $esHoy ? 'border-primary shadow' : '' }}" style="background:white;">

                            {{-- Cabecera del día --}}
                            <div class="text-center py-2 px-1 border-bottom"
                                 style="background:{{ $esHoy ? '#2563eb' : ($esFinde ? '#f1f5f9' : '#f9fafb') }};">
                                <div style="font-size:0.65rem;font-weight:600;letter-spacing:0.08em;color:{{ $esHoy ? 'rgba(191,219,254,0.9)' : ($esFinde ? '#94a3b8' : '#6b7280') }};text-transform:uppercase;">
                                    {{ $nombresdia[$i] }}
                                </div>
                                <div style="font-size:1.25rem;font-weight:700;color:{{ $esHoy ? 'white' : ($esFinde ? '#94a3b8' : '#1f2937') }};">
                                    {{ $dia->format('d') }}
                                </div>
                                @if($citasDia->count() > 0)
                                <span class="badge rounded-pill" style="font-size:0.6rem;background:{{ $esHoy ? 'rgba(255,255,255,0.2)' : '#dbeafe' }};color:{{ $esHoy ? 'white' : '#1d4ed8' }};">
                                    {{ $citasDia->count() }}
                                </span>
                                @endif
                            </div>

                            {{-- Citas --}}
                            <div class="flex-grow-1 p-2 d-flex flex-column gap-2 overflow-auto" style="max-height:360px;">
                                @forelse($citasDia as $cita)
                                <div class="rounded-3 border p-2 cita-{{ $cita->estado }}" style="font-size:0.72rem;">
                                    <div class="fw-bold mb-1">{{ $cita->fecha_hora->format('h:i A') }}</div>
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <span class="avatar-circle fw-bold flex-shrink-0" style="width:18px;height:18px;font-size:0.55rem;background:rgba(255,255,255,0.6);">
                                            {{ strtoupper(substr($cita->paciente->user->name,0,1)) }}
                                        </span>
                                        <span class="fw-semibold text-truncate">{{ $cita->paciente->user->name }}</span>
                                    </div>
                                    <div class="text-truncate opacity-75">{{ $cita->motivo }}</div>
                                    <div class="d-flex gap-1 mt-2 flex-wrap">
                                        @if($cita->estado === 'confirmada')
                                        <a href="{{ route('historiales.create') }}" class="btn btn-sm px-2 py-0" style="background:rgba(255,255,255,0.7);font-size:0.65rem;color:#1d4ed8;">Atender</a>
                                        @endif
                                        @if($cita->historialClinico)
                                        <a href="{{ route('historiales.show', $cita->historialClinico) }}" class="btn btn-sm px-2 py-0" style="background:rgba(255,255,255,0.7);font-size:0.65rem;">Historial</a>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="d-flex flex-column align-items-center justify-content-center py-4 text-center">
                                    <div class="avatar-circle bg-light text-muted mb-2" style="width:28px;height:28px;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-muted" style="font-size:0.65rem;">Sin citas</span>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Leyenda --}}
                <div class="d-flex align-items-center gap-4 justify-content-center mt-4">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <div style="width:10px;height:10px;border-radius:50%;background:#3b82f6;"></div><span>Confirmada</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;"></div><span>Pendiente</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <div style="width:10px;height:10px;border-radius:50%;background:#10b981;"></div><span>Completada</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <div style="width:10px;height:10px;border-radius:50%;background:#2563eb;"></div><span>Hoy</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
