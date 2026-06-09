<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'reportes'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar">
            <h5 class="fw-bold mb-0">Reportes del Sistema</h5>
            <p class="text-muted mb-0 ms-2" style="font-size:0.75rem;">Estadísticas y análisis de la clínica – {{ $anio }}</p>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            {{-- KPIs --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="kpi-card">
                        <p class="text-muted small mb-2">Total Citas</p>
                        <h4 class="fw-bold text-dark mb-1">{{ number_format($totalCitas) }}</h4>
                        <div class="d-flex gap-3">
                            <span class="text-success fw-semibold" style="font-size:0.72rem;">{{ $citasCompletadas }} completadas</span>
                            <span class="text-danger fw-semibold" style="font-size:0.72rem;">{{ $citasCanceladas }} canceladas</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="kpi-card">
                        <p class="text-muted small mb-2">Citas Pendientes</p>
                        <h4 class="fw-bold text-warning mb-1">{{ number_format($citasPendientes) }}</h4>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">En espera de atención</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="kpi-card">
                        <p class="text-muted small mb-2">Total Pacientes</p>
                        <h4 class="fw-bold text-primary mb-1">{{ number_format($totalPacientes) }}</h4>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">{{ $totalMedicos }} médicos activos</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="kpi-card">
                        <p class="text-muted small mb-2">Ingresos Totales</p>
                        <h4 class="fw-bold text-success mb-1">${{ number_format($totalPagos, 2) }}</h4>
                        <p class="text-muted mb-0" style="font-size:0.72rem;">Pagos completados</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                {{-- Gráfico citas por mes --}}
                <div class="col-lg-8">
                    <div class="app-card p-4">
                        <h6 class="fw-semibold mb-4">Citas por Mes – {{ $anio }}</h6>
                        @php $maxV = max($datosPorMes) > 0 ? max($datosPorMes) : 1; $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']; @endphp
                        <div class="d-flex align-items-end gap-1" style="height:160px;">
                            @foreach($meses as $i => $mes)
                            @php $val = $datosPorMes[$i+1]; @endphp
                            <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-end gap-1 h-100">
                                <div class="text-muted text-center" style="font-size:9px;">{{ $val > 0 ? $val : '' }}</div>
                                <div class="w-100 rounded-top" style="background:#60a5fa;height:{{ $val > 0 ? round(($val/$maxV)*120) : 4 }}px;min-height:4px;"></div>
                                <span class="text-muted" style="font-size:9px;">{{ $mes }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Top médicos --}}
                <div class="col-lg-4">
                    <div class="app-card p-4">
                        <h6 class="fw-semibold mb-3">Top Médicos por Citas</h6>
                        <div class="d-flex flex-column gap-3">
                            @forelse($topMedicos as $i => $m)
                            @php $pct = $totalCitas > 0 ? round(($m->citas_count/$totalCitas)*100) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width:20px;height:20px;font-size:0.6rem;background:{{ $i===0?'#fef9c3':($i===1?'#f3f4f6':'#f9fafb') }};color:{{ $i===0?'#92400e':($i===1?'#374151':'#6b7280') }};">{{ $i+1 }}</div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-semibold text-truncate" style="font-size:0.72rem;">Dr. {{ $m->user->name }}</div>
                                    <div class="progress mt-1" style="height:4px;">
                                        <div class="progress-bar bg-primary" style="width:{{ $pct }}%"></div>
                                    </div>
                                </div>
                                <div class="fw-bold small flex-shrink-0">{{ $m->citas_count }}</div>
                            </div>
                            @empty
                            <p class="text-muted small">Sin datos.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Citas por especialidad --}}
            <div class="app-card p-4 mb-4">
                <h6 class="fw-semibold mb-3">Citas por Especialidad</h6>
                <div class="row g-3">
                    @forelse($citasPorEspecialidad as $esp)
                    @php $pct = $totalCitas > 0 ? round(($esp->citas_count/$totalCitas)*100) : 0; @endphp
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-between rounded-3 p-3" style="background:#f9fafb;">
                            <div>
                                <p class="fw-semibold mb-0 small">{{ $esp->nombre }}</p>
                                <p class="text-muted mb-0" style="font-size:0.7rem;">{{ $pct }}% del total</p>
                            </div>
                            <div class="fw-bold text-primary" style="font-size:1.3rem;">{{ $esp->citas_count }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted small py-3">Sin datos de especialidades.</div>
                    @endforelse
                </div>
            </div>

            @if($totalCitas > 0)
            <div class="app-card p-4">
                <h6 class="fw-semibold mb-3">Resumen de Rendimiento</h6>
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="fw-bold text-success" style="font-size:2rem;">{{ round(($citasCompletadas/$totalCitas)*100) }}%</div>
                        <p class="text-muted small mb-0">Tasa de Completadas</p>
                    </div>
                    <div class="col-md-4">
                        <div class="fw-bold text-danger" style="font-size:2rem;">{{ round(($citasCanceladas/$totalCitas)*100) }}%</div>
                        <p class="text-muted small mb-0">Tasa de Cancelación</p>
                    </div>
                    <div class="col-md-4">
                        <div class="fw-bold text-primary" style="font-size:2rem;">{{ $totalUsuarios }}</div>
                        <p class="text-muted small mb-0">Usuarios Totales</p>
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>
</div>
</body>
</html>
