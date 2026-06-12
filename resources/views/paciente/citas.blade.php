<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Citas – Los Mollos</title>
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

    @include('partials.paciente-sidebar', ['activeSection' => 'citas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#EFF6FF;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Mis Citas</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Gestiona tus consultas médicas</p>
                </div>
            </div>
            <a href="{{ route('citas.crear') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Agendar Cita
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Próximas citas --}}
            @if($proximasCitas->isNotEmpty())
            <div class="mb-4">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <div style="width:4px;height:18px;background:#2563EB;border-radius:4px;"></div>
                    Próximas Citas
                    <span class="badge rounded-pill" style="background:#EFF6FF;color:#1d4ed8;">{{ $proximasCitas->count() }}</span>
                </h6>
                <div class="row g-3">
                    @foreach($proximasCitas as $cita)
                    <div class="col-md-6 col-xl-4">
                        <div class="app-card p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle text-white" style="width:40px;height:40px;font-size:0.9rem;background:#2563EB;">
                                        {{ strtoupper(substr($cita->medico->user->name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.85rem;">Dr. {{ $cita->medico->user->name }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $cita->especialidad->nombre }}</div>
                                    </div>
                                </div>
                                <span class="badge rounded-pill fw-semibold {{ $badgeMap[$cita->estado] ?? '' }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </div>
                            <div class="d-flex flex-column gap-1 mb-3">
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <svg width="13" height="13" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $cita->fecha_hora->format('d/m/Y') }}
                                </div>
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <svg width="13" height="13" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $cita->fecha_hora->format('h:i A') }}
                                </div>
                                @if($cita->motivo)
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <svg width="13" height="13" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                    {{ Str::limit($cita->motivo, 40) }}
                                </div>
                                @endif
                            </div>
                            @if($cita->pago && $cita->pago->estado === 'pendiente')
                                <div class="d-flex align-items-center justify-content-between p-2 rounded-2" style="background:#fef2f2;">
                                    <span class="small text-danger fw-semibold">Pago pendiente: ${{ number_format($cita->pago->monto, 2) }}</span>
                                    <a href="{{ route('paciente.pagos') }}" class="btn btn-sm" style="background:#dc2626;color:white;font-size:0.72rem;">Pagar</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="app-card p-5 text-center mb-4">
                <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width:64px;height:64px;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h6 class="fw-bold mb-1">Sin citas próximas</h6>
                <p class="text-muted small mb-3">No tienes citas programadas para los próximos días.</p>
                <a href="{{ route('citas.crear') }}" class="btn btn-primary btn-sm">Agendar una cita</a>
            </div>
            @endif

            {{-- Historial de citas pasadas --}}
            <div class="app-card overflow-hidden">
                <div class="app-card-header d-flex align-items-center justify-content-between">
                    <span>Citas Pasadas</span>
                    <span class="badge bg-light text-muted">{{ $citasPasadas->total() }} registros</span>
                </div>
                <div class="table-responsive">
                    <table class="table app-table mb-0">
                        <thead>
                            <tr>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Pago</th>
                                <th>Historial</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($citasPasadas as $cita)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle text-white" style="width:28px;height:28px;font-size:0.65rem;background:#2563EB;">
                                            {{ strtoupper(substr($cita->medico->user->name,0,1)) }}
                                        </div>
                                        <span class="fw-medium">Dr. {{ $cita->medico->user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $cita->especialidad->nombre }}</td>
                                <td class="text-muted">{{ $cita->fecha_hora->format('d M, Y · h:i A') }}</td>
                                <td>
                                    <span class="badge rounded-pill fw-semibold {{ $badgeMap[$cita->estado] ?? '' }}">
                                        {{ strtoupper($cita->estado) }}
                                    </span>
                                </td>
                                <td>
                                    @if($cita->pago)
                                        @if($cita->pago->estado === 'completado')
                                            <span class="badge badge-confirmada">Pagado</span>
                                        @else
                                            <span class="badge badge-pendiente">{{ ucfirst($cita->pago->estado) }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cita->historialClinico)
                                        <a href="{{ route('paciente.historial') }}" class="btn btn-link btn-sm p-0" style="color:#2563EB;font-size:0.8rem;">Ver</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay citas pasadas registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($citasPasadas->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $citasPasadas->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

        </main>
    </div>
</div>
</body>
</html>
