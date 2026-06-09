<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Administrador – Los Mollos</title>
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
    $mesesLabels = ['Ene'=>1,'Feb'=>2,'Mar'=>3,'Abr'=>4,'May'=>5,'Jun'=>6,'Jul'=>7,'Ago'=>8,'Sep'=>9,'Oct'=>10,'Nov'=>11,'Dic'=>12];
    $maxV = max($datosPorMes) > 0 ? max($datosPorMes) : 1;
@endphp

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'dashboard'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        {{-- Top bar --}}
        <header class="app-topbar">
            <div class="flex-grow-1 position-relative" style="max-width:300px;">
                <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);" width="14" height="14" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Buscar reporte o usuario..."
                       class="form-control form-control-sm ps-4" style="border-radius:0.625rem;">
            </div>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <div class="avatar-circle bg-primary text-white" style="width:32px;height:32px;font-size:0.75rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold" style="font-size:0.8rem;">{{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size:0.7rem;">Super Administrador</div>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">Panel de Administración</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.reportes.index') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Generar Reporte
                    </a>
                    <a href="{{ route('admin.suscripciones.index') }}" class="btn btn-warning btn-sm d-flex align-items-center gap-1 text-dark">
                        <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Gestionar Premium
                    </a>
                </div>
            </div>

            {{-- KPIs --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-xl-3">
                    <div class="kpi-card d-flex align-items-center gap-3">
                        <div class="kpi-icon" style="background:#ccfbf1;">
                            <svg width="18" height="18" fill="none" stroke="#0d9488" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.75rem;">Total Pacientes</div>
                            <div class="fw-bold fs-4">{{ number_format($totalPacientes) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="kpi-card d-flex align-items-center gap-3">
                        <div class="kpi-icon" style="background:#f0fdf4;">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.75rem;">Médicos Activos</div>
                            <div class="fw-bold fs-4">{{ number_format($medicosActivos) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="kpi-card d-flex align-items-center gap-3">
                        <div class="kpi-icon" style="background:#fff7ed;">
                            <svg width="18" height="18" fill="none" stroke="#ea580c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.75rem;">Citas de Hoy</div>
                            <div class="fw-bold fs-4">{{ number_format($citasHoy) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="kpi-card d-flex align-items-center gap-3">
                        <div class="kpi-icon" style="background:#faf5ff;">
                            <svg width="18" height="18" fill="none" stroke="#9333ea" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.75rem;">Ingresos (PayPal/Stripe)</div>
                            <div class="fw-bold fs-4">${{ number_format($ingresos, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gráfico + Actividad --}}
            <div class="row g-3 mb-4">
                <div class="col-lg-8">
                    <div class="app-card">
                        <div class="app-card-header d-flex align-items-center justify-content-between">
                            <span>Citas por Mes ({{ date('Y') }})</span>
                        </div>
                        <div class="p-4">
                            <div class="d-flex align-items-end gap-1" style="height:140px;">
                                @foreach($mesesLabels as $label => $num)
                                <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-end" style="height:100%;">
                                    <div class="w-100 rounded-top" style="background:#0d9488;height:{{ $datosPorMes[$num] > 0 ? round(($datosPorMes[$num]/$maxV)*100) : 2 }}%;transition:height 0.3s;"></div>
                                    <span class="text-muted mt-1" style="font-size:0.65rem;">{{ $label }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="app-card h-100">
                        <div class="app-card-header">Actividad Reciente</div>
                        <div class="p-3 d-flex flex-column gap-3">
                            @forelse($ultimosPagos as $pago)
                            <div class="d-flex align-items-start gap-2">
                                <div class="avatar-circle flex-shrink-0 mt-1" style="width:28px;height:28px;font-size:0.6rem;background:{{ $pago->estado==='completado' ? '#d1fae5' : '#fef3c7' }};color:{{ $pago->estado==='completado' ? '#065f46' : '#92400e' }};">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:0.78rem;">{{ $pago->concepto }}</div>
                                    <div class="text-muted" style="font-size:0.7rem;">{{ $pago->paciente->user->name }} · ${{ number_format($pago->monto,2) }}</div>
                                    <div class="text-muted" style="font-size:0.65rem;">{{ $pago->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted small mb-0">Sin actividad reciente.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Últimas citas --}}
            <div class="app-card overflow-hidden">
                <div class="app-card-header">Últimas Citas Registradas</div>
                <div class="table-responsive">
                    <table class="table app-table mb-0">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Fecha & Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimasCitas as $cita)
                            <tr>
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
                                <td class="text-muted">{{ $cita->fecha_hora->format('d M Y · h:i A') }}</td>
                                <td>
                                    <span class="badge rounded-pill fw-semibold {{ $badgeMap[$cita->estado] ?? '' }}">
                                        {{ strtoupper($cita->estado) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Sin citas registradas.</td></tr>
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
