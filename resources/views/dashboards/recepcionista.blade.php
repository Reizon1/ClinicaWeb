<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Recepcionista – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

@php
    $badgeMap = [
        'confirmada' => 'badge-confirmada',
        'pendiente'  => 'badge-pendiente',
        'completada' => 'badge-completada',
        'cancelada'  => 'badge-cancelada',
    ];
@endphp

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'dashboard'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        {{-- Header --}}
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#ccfbf1;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#0f766e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Panel de Recepción</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">{{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('recepcionista.citas.crear') }}" class="btn btn-sm d-flex align-items-center gap-1"
                   style="background:#0d9488;color:white;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Cita
                </a>
                <a href="{{ route('recepcionista.pacientes.crear') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Nuevo Paciente
                </a>
            </div>
        </header>

        <main class="flex-grow-1" style="overflow-y:auto;">

            {{-- Hero Banner --}}
            <div class="px-4 py-4" style="background:linear-gradient(135deg,#0f766e,#0d9488,#0891b2);position:relative;overflow:hidden;">
                <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.08);pointer-events:none;"></div>
                <div style="position:absolute;bottom:-20px;left:-20px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,0.05);pointer-events:none;"></div>
                <p class="mb-1" style="color:rgba(204,251,241,0.8);font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;font-weight:600;">Clínica Los Mollos</p>
                <h2 class="text-white fw-bold mb-1" style="font-size:1.4rem;">
                    Bienvenida, {{ explode(' ', auth()->user()->name)[0] }}
                </h2>
                <p style="color:rgba(204,251,241,0.9);font-size:0.875rem;" class="mb-0">
                    @if($citasHoy->count() > 0)
                        Tenés <strong class="text-white">{{ $citasHoy->count() }}</strong> {{ $citasHoy->count() === 1 ? 'cita programada' : 'citas programadas' }} para hoy.
                    @else
                        No hay citas programadas para hoy. ¡Buen momento para organizar!
                    @endif
                </p>
            </div>

            <div class="p-4">

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- KPIs --}}
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="kpi-card text-white" style="background:linear-gradient(135deg,#0d9488,#0f766e);">
                            <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $citasHoy->count() }}</div>
                            <div style="font-size:0.75rem;color:rgba(204,251,241,0.8);">Citas hoy</div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="kpi-card text-white" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                            <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $citasPendientes }}</div>
                            <div style="font-size:0.75rem;color:rgba(254,243,199,0.8);">Pendientes de confirmar</div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="kpi-card text-white" style="background:linear-gradient(135deg,#3b82f6,#4338ca);">
                            <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $totalPacientes }}</div>
                            <div style="font-size:0.75rem;color:rgba(219,234,254,0.8);">Pacientes registrados</div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="kpi-card text-white" style="background:linear-gradient(135deg,#10b981,#0d9488);">
                            <div class="kpi-icon mb-2" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $medicosDisponibles }}</div>
                            <div style="font-size:0.75rem;color:rgba(209,250,229,0.8);">Médicos disponibles</div>
                        </div>
                    </div>
                </div>

                {{-- Agenda del día --}}
                <div class="app-card overflow-hidden">
                    <div class="app-card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:4px;height:20px;background:#0d9488;border-radius:4px;"></div>
                            <span>Agenda de Hoy</span>
                            <span class="badge rounded-pill" style="background:#ccfbf1;color:#0f766e;">{{ $citasHoy->count() }}</span>
                        </div>
                        <a href="{{ route('recepcionista.citas') }}" class="btn btn-link btn-sm text-decoration-none p-0"
                           style="color:#0d9488;font-size:0.8rem;">Ver todas →</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table app-table mb-0">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Especialidad</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citasHoy as $cita)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $cita->fecha_hora->format('h:i') }}</span>
                                        <span class="text-muted" style="font-size:0.7rem;"> {{ $cita->fecha_hora->format('A') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle bg-primary bg-opacity-10 text-primary" style="width:28px;height:28px;font-size:0.65rem;">
                                                {{ strtoupper(substr($cita->paciente->user->name,0,1)) }}
                                            </div>
                                            <span class="fw-medium">{{ $cita->paciente->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">Dr. {{ $cita->medico->user->name }}</td>
                                    <td class="text-muted">{{ $cita->especialidad->nombre }}</td>
                                    <td>
                                        <span class="badge rounded-pill fw-semibold {{ $badgeMap[$cita->estado] ?? '' }}">
                                            {{ ucfirst($cita->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(!in_array($cita->estado, ['completada','cancelada']))
                                        <form method="POST" action="{{ route('recepcionista.citas.cancelar', $cita) }}"
                                              onsubmit="return confirm('¿Cancelar esta cita?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-link btn-sm text-danger p-0">Cancelar</button>
                                        </form>
                                        @else
                                        <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="avatar-circle bg-light text-muted mx-auto mb-2" style="width:48px;height:48px;">
                                            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="fw-medium text-muted mb-0">Sin citas para hoy</p>
                                        <p class="text-muted small">Podés agendar nuevas citas desde el menú lateral.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
