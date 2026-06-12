<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Paciente – Los Mollos</title>
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

    @include('partials.paciente-sidebar', ['activeSection' => 'dashboard'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        {{-- Header --}}
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#EFF6FF;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Bienvenido, {{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Hoy es {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar-circle text-white" style="background:#2563EB;width:28px;height:28px;font-size:0.65rem;">{{ $iniciales }}</div>
                <div>
                    <div class="fw-semibold" style="font-size:0.8rem;">{{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size:0.7rem;">Paciente ID: {{ $paciente->id }}</div>
                </div>
                <a href="{{ route('citas.crear') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 ms-2">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Cita
                </a>
            </div>
        </header>

        <main class="flex-grow-1" style="overflow-y:auto;">

            {{-- Hero Banner --}}
            <div class="px-4 py-4" style="background:linear-gradient(135deg,#1d4ed8,#2563EB,#0284c7);position:relative;overflow:hidden;">
                <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.08);pointer-events:none;"></div>
                <div style="position:absolute;bottom:-20px;left:-20px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,0.05);pointer-events:none;"></div>
                <p class="mb-1" style="color:rgba(191,219,254,0.8);font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;font-weight:600;">Mi Panel de Salud</p>
                <h2 class="text-white fw-bold mb-0" style="font-size:1.4rem;">{{ explode(' ', auth()->user()->name)[0] }}, aquí está tu resumen</h2>
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
                    <div class="col-md-4">
                        <div class="kpi-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="kpi-icon" style="background:#EFF6FF;">
                                    <svg width="18" height="18" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-muted" style="font-size:0.75rem;">Próxima Cita</span>
                            </div>
                            @if($proximaCita)
                                <div class="fw-bold fs-5">{{ $proximaCita->fecha_hora->format('d M, Y') }}</div>
                                <div class="text-muted small">@ {{ $proximaCita->fecha_hora->format('h:i A') }}</div>
                                <div class="fw-medium mt-1" style="font-size:0.8rem;color:#2563EB;">Dr. {{ $proximaCita->medico->user->name }}</div>
                            @else
                                <div class="text-muted small mt-1">Sin citas próximas</div>
                                <a href="{{ route('citas.crear') }}" class="btn btn-primary btn-sm mt-2">Agendar ahora</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="kpi-icon" style="background:#fef2f2;">
                                    <svg width="18" height="18" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                                </div>
                                <span class="text-muted" style="font-size:0.75rem;">Pagos Pendientes</span>
                            </div>
                            <div class="fw-bold fs-5">{{ $pagosPendientes->count() }} factura(s)</div>
                            <div class="fw-bold text-danger fs-4">${{ number_format($pagosPendientes->sum('monto'), 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-card text-white" style="background:linear-gradient(135deg,#1d4ed8,#2563EB);">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="kpi-icon" style="background:rgba(255,255,255,0.2);">
                                    <svg width="18" height="18" fill="#fde047" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span style="font-size:0.75rem;color:rgba(191,219,254,0.85);">Estado Premium</span>
                            </div>
                            @if($suscripcion && $suscripcion->estaActiva())
                                <div class="fw-bold fs-5 d-flex align-items-center gap-2">
                                    Activo
                                    <span class="badge" style="background:rgba(74,222,128,0.2);color:#4ade80;font-size:0.7rem;">✓</span>
                                </div>
                                @php
                                    $diasTotales   = $suscripcion->fecha_inicio->diffInDays($suscripcion->fecha_vencimiento);
                                    $diasRestantes = now()->diffInDays($suscripcion->fecha_vencimiento, false);
                                    $progreso      = $diasTotales > 0 ? round(($diasRestantes/$diasTotales)*100) : 0;
                                @endphp
                                <div class="progress mt-2 mb-1" style="height:4px;background:rgba(255,255,255,0.2);">
                                    <div class="progress-bar bg-warning" style="width:{{ $progreso }}%"></div>
                                </div>
                                <div style="font-size:0.7rem;color:rgba(191,219,254,0.85);">Vence: {{ $suscripcion->fecha_vencimiento->format('d M. Y') }}</div>
                            @else
                                <div class="fw-bold fs-5">Sin Plan Premium</div>
                                <div style="font-size:0.7rem;color:rgba(191,219,254,0.85);">Activa tu plan desde $99/mes</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Gráfico + Próxima consulta --}}
                <div class="row g-3 mb-4">
                    <div class="col-lg-8">
                        <div class="app-card">
                            <div class="app-card-header d-flex align-items-center justify-content-between">
                                <span>Seguimiento de Salud</span>
                                <span class="badge bg-light text-muted">Últimos 6 meses</span>
                            </div>
                            <div class="p-3">
                                <svg viewBox="0 0 500 160" class="w-100" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0" y1="40" x2="500" y2="40" stroke="#f3f4f6" stroke-width="1"/>
                                    <line x1="0" y1="80" x2="500" y2="80" stroke="#f3f4f6" stroke-width="1"/>
                                    <line x1="0" y1="120" x2="500" y2="120" stroke="#f3f4f6" stroke-width="1"/>
                                    <text x="0" y="38" font-size="10" fill="#9ca3af">120</text>
                                    <text x="0" y="78" font-size="10" fill="#9ca3af">100</text>
                                    <text x="0" y="118" font-size="10" fill="#9ca3af">80</text>
                                    <polyline points="50,100 130,90 210,95 290,80 370,85 450,78" fill="none" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="50" cy="100" r="3" fill="#2563EB"/><circle cx="130" cy="90" r="3" fill="#2563EB"/>
                                    <circle cx="210" cy="95" r="3" fill="#2563EB"/><circle cx="290" cy="80" r="3" fill="#2563EB"/>
                                    <circle cx="370" cy="85" r="3" fill="#2563EB"/><circle cx="450" cy="78" r="3" fill="#2563EB"/>
                                    <polyline points="50,60 130,70 210,55 290,65 370,50 450,60" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="50" cy="60" r="3" fill="#10b981"/><circle cx="130" cy="70" r="3" fill="#10b981"/>
                                    <circle cx="210" cy="55" r="3" fill="#10b981"/><circle cx="290" cy="65" r="3" fill="#10b981"/>
                                    <circle cx="370" cy="50" r="3" fill="#10b981"/><circle cx="450" cy="60" r="3" fill="#10b981"/>
                                    <text x="42" y="155" font-size="10" fill="#9ca3af">Ene</text>
                                    <text x="122" y="155" font-size="10" fill="#9ca3af">Feb</text>
                                    <text x="202" y="155" font-size="10" fill="#9ca3af">Mar</text>
                                    <text x="282" y="155" font-size="10" fill="#9ca3af">Abr</text>
                                    <text x="362" y="155" font-size="10" fill="#9ca3af">May</text>
                                    <text x="442" y="155" font-size="10" fill="#9ca3af">Jul</text>
                                </svg>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <div style="width:12px;height:2px;background:#2563EB;border-radius:2px;"></div> Peso (kg)
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <div style="width:12px;height:2px;background:#10b981;border-radius:2px;"></div> Presión Art.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="app-card">
                            <div class="app-card-header">Próxima Consulta</div>
                            <div class="p-3">
                                @if($proximaCita)
                                    <div class="text-center mb-3">
                                        <div class="avatar-circle text-white mx-auto mb-2" style="width:56px;height:56px;font-size:1.2rem;background:#2563EB;">
                                            {{ strtoupper(substr($proximaCita->medico->user->name,0,1)) }}
                                        </div>
                                        <div class="fw-bold" style="font-size:0.9rem;">Dr. {{ $proximaCita->medico->user->name }}</div>
                                        <div class="text-muted small">{{ $proximaCita->especialidad->nombre }}</div>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <svg width="14" height="14" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $proximaCita->fecha_hora->format('d/m/Y h:i A') }}
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <svg width="14" height="14" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            {{ $proximaCita->motivo ?? 'Sin motivo registrado' }}
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge rounded-pill fw-semibold {{ $badgeMap[$proximaCita->estado] ?? '' }}">
                                            {{ strtoupper($proximaCita->estado) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="text-center py-3 text-muted">
                                        <svg width="48" height="48" fill="none" stroke="#e5e7eb" class="mb-2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <div class="small fw-medium">No tienes citas próximas</div>
                                        <a href="{{ route('citas.crear') }}" class="btn btn-primary btn-sm mt-2">Agendar cita</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Historial de citas recientes --}}
                <div class="app-card overflow-hidden">
                    <div class="app-card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:4px;height:20px;background:#2563EB;border-radius:4px;"></div>
                            <span>Historial de Citas Recientes</span>
                        </div>
                        <a href="{{ route('paciente.citas') }}" class="btn btn-link btn-sm text-decoration-none p-0"
                           style="color:#2563EB;font-size:0.8rem;">Ver todas →</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table app-table mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Especialidad</th>
                                    <th>Fecha & Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citasRecientes as $cita)
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
                                        @if($cita->pago && $cita->pago->estado === 'pendiente')
                                            <a href="{{ route('paciente.pagos') }}" class="btn btn-primary btn-sm">Pagar</a>
                                        @elseif($cita->historialClinico)
                                            <a href="{{ route('paciente.historial') }}" class="btn btn-link btn-sm p-0" style="color:#2563EB;">Ver historial</a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="avatar-circle bg-light text-muted mx-auto mb-2" style="width:48px;height:48px;">
                                            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="fw-medium text-muted mb-1">No tienes citas registradas aún.</p>
                                        <a href="{{ route('citas.crear') }}" class="btn btn-primary btn-sm">Agendar tu primera cita</a>
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
