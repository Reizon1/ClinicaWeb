<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Médico – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

@php
    $iniciales = collect(explode(' ', auth()->user()->name))
        ->map(fn($w) => strtoupper($w[0] ?? ''))
        ->take(2)->join('');
    $badgeMap = [
        'confirmada' => 'badge-confirmada',
        'pendiente'  => 'badge-pendiente',
        'completada' => 'badge-completada',
        'cancelada'  => 'badge-cancelada',
    ];
@endphp

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'dashboard'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        {{-- Top bar --}}
        <header class="app-topbar">
            <form method="GET" action="{{ route('historiales.index') }}" class="flex-grow-1" style="max-width:280px;">
                <div class="position-relative">
                    <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);" width="14" height="14" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="buscar" placeholder="Buscar pacientes..."
                           class="form-control form-control-sm ps-4" style="border-radius:0.625rem;">
                </div>
            </form>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <div class="avatar-circle bg-primary text-white" style="width:28px;height:28px;font-size:0.65rem;">{{ $iniciales }}</div>
                <div>
                    <div class="fw-semibold" style="font-size:0.8rem;">Dr. {{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size:0.7rem;">{{ $medico->especialidad->nombre }}</div>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="fw-bold mb-0">Resumen Diario</h5>
                    <p class="text-muted mb-0" style="font-size:0.8rem;">Bienvenido de nuevo, Dr. {{ auth()->user()->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('recetas.create') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Crear Receta
                    </a>
                    <a href="{{ route('medico.agenda.semanal') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Vista Semanal
                    </a>
                </div>
            </div>

            {{-- KPIs --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-xl-3">
                    <div class="kpi-card kpi-gradient-blue text-white">
                        <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="fw-bold fs-4">{{ $totalCitasHoy }}</div>
                        <div style="font-size:0.75rem;color:rgba(191,219,254,0.9);">Citas de Hoy</div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="kpi-card kpi-gradient-green text-white">
                        <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="fw-bold fs-4">{{ $citasAtendidas }}</div>
                        <div style="font-size:0.75rem;color:rgba(187,247,208,0.9);">Pacientes Atendidos</div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="kpi-card kpi-gradient-orange text-white">
                        <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="fw-bold fs-4">{{ $citasPendientes }}</div>
                        <div style="font-size:0.75rem;color:rgba(254,243,199,0.9);">Próximas pendientes</div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="kpi-card kpi-gradient-purple text-white">
                        <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        @if($proximaCita)
                            <div class="fw-bold" style="font-size:0.95rem;">{{ $proximaCita->fecha_hora->format('h:i A') }}</div>
                            <div style="font-size:0.72rem;color:rgba(221,214,254,0.9);">{{ $proximaCita->fecha_hora->format('d M Y') }}</div>
                            <div style="font-size:0.72rem;color:rgba(221,214,254,0.9);">{{ $proximaCita->paciente->user->name }}</div>
                        @else
                            <div class="fw-bold">Sin citas</div>
                            <div style="font-size:0.75rem;color:rgba(221,214,254,0.9);">Próxima cita</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Agenda del día + Pacientes recientes --}}
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="app-card overflow-hidden">
                        <div class="app-card-header d-flex align-items-center justify-content-between">
                            <span>Agenda del Día <span class="text-muted fw-normal">(Hoy, {{ now()->format('d M') }})</span></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table app-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($citasHoy as $cita)
                                    <tr>
                                        <td class="fw-semibold">{{ $cita->fecha_hora->format('h:i A') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary" style="width:28px;height:28px;font-size:0.65rem;">
                                                    {{ strtoupper(substr($cita->paciente->user->name,0,1)) }}
                                                </div>
                                                <span class="fw-medium">{{ $cita->paciente->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill fw-semibold {{ $badgeMap[$cita->estado] ?? '' }}">
                                                {{ ucfirst($cita->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($cita->estado === 'confirmada')
                                                    <a href="{{ route('historiales.create') }}" class="btn btn-primary btn-sm">Atender</a>
                                                @endif
                                                @if($cita->historialClinico)
                                                    <a href="{{ route('historiales.show', $cita->historialClinico) }}" class="btn btn-link btn-sm p-0">Ver Historial</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No tienes citas programadas para hoy.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($citasHoy->count() > 0)
                        <div class="text-center py-2 border-top">
                            <a href="{{ route('historiales.index') }}" class="small fw-semibold text-primary text-decoration-none text-uppercase">Ver Historiales / Citas</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 d-flex flex-column gap-3">
                    <div class="app-card">
                        <div class="app-card-header">Pacientes Recientes</div>
                        <div class="p-3 d-flex flex-column gap-3">
                            @forelse($pacientesRecientes as $pac)
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary" style="width:36px;height:36px;font-size:0.8rem;">
                                    {{ strtoupper(substr($pac->user->name,0,1)) }}
                                </div>
                                <div class="flex-grow-1" style="min-width:0;">
                                    <div class="fw-semibold text-truncate" style="font-size:0.8rem;">{{ $pac->user->name }}</div>
                                    <div class="text-muted" style="font-size:0.7rem;">
                                        {{ $pac->citas->where('medico_id',$medico->id)->sortByDesc('fecha_hora')->first()?->fecha_hora->diffForHumans() ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted small mb-0">Sin pacientes atendidos aún.</p>
                            @endforelse
                        </div>
                        <div class="text-center py-2 border-top">
                            <a href="{{ route('historiales.index') }}" class="small fw-semibold text-primary text-decoration-none text-uppercase">Ver Historiales</a>
                        </div>
                    </div>

                    <div class="rounded-3 p-3" style="background:#EFF6FF;border:1px solid #BFDBFE;">
                        <div class="d-flex align-items-start gap-2">
                            <div class="kpi-icon flex-shrink-0" style="background:#BFDBFE;width:28px;height:28px;border-radius:8px;">
                                <svg width="13" height="13" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.78rem;color:#1d4ed8;">Recordatorio de hoy</div>
                                <p class="mb-0" style="font-size:0.75rem;color:#2563EB;">
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
