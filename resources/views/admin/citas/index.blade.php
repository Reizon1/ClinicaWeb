<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citas – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'citas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Citas — Visión Global</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Monitoreo de todas las citas de todos los médicos</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            {{-- KPIs --}}
            <div class="row g-3 mb-4">
                @php
                    $kpis = [
                        ['label'=>'Total Citas',    'value'=>$totalCitas,       'color'=>'#2563eb','bg'=>'#eff6ff'],
                        ['label'=>'Pendientes',     'value'=>$citasPendientes,  'color'=>'#f59e0b','bg'=>'#fffbeb'],
                        ['label'=>'Completadas',    'value'=>$citasCompletadas, 'color'=>'#22c55e','bg'=>'#f0fdf4'],
                        ['label'=>'Canceladas',     'value'=>$citasCanceladas,  'color'=>'#ef4444','bg'=>'#fef2f2'],
                    ];
                @endphp
                @foreach($kpis as $kpi)
                <div class="col-6 col-md-3">
                    <div class="app-card p-3 text-center">
                        <div class="fw-bold mb-1" style="font-size:1.8rem;color:{{ $kpi['color'] }};">{{ $kpi['value'] }}</div>
                        <div class="text-muted small">{{ $kpi['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.citas.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <div class="input-group input-group-sm" style="max-width:240px;">
                        <span class="input-group-text bg-white">
                            <svg width="12" height="12" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar paciente..." class="form-control">
                    </div>
                    <select name="medico_id" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los médicos</option>
                        @foreach($medicos as $m)
                            <option value="{{ $m->id }}" {{ request('medico_id')==$m->id ? 'selected' : '' }}>
                                Dr. {{ $m->user->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="estado" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente"  {{ request('estado')=='pendiente'  ?'selected':'' }}>Pendiente</option>
                        <option value="confirmada" {{ request('estado')=='confirmada' ?'selected':'' }}>Confirmada</option>
                        <option value="completada" {{ request('estado')=='completada' ?'selected':'' }}>Completada</option>
                        <option value="cancelada"  {{ request('estado')=='cancelada'  ?'selected':'' }}>Cancelada</option>
                    </select>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control form-control-sm" style="width:auto;" placeholder="Desde">
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control form-control-sm" style="width:auto;" placeholder="Hasta">
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Filtrar</button>
                    @if(request()->hasAny(['buscar','medico_id','estado','fecha_desde','fecha_hasta']))
                        <a href="{{ route('admin.citas.index') }}" class="text-muted small">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Fecha / Hora</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $badges = [
                                'confirmada' => 'badge-confirmada',
                                'pendiente'  => 'badge-pendiente',
                                'completada' => 'badge-completada',
                                'cancelada'  => 'badge-cancelada',
                            ];
                        @endphp
                        @forelse($citas as $cita)
                        <tr>
                            <td class="fw-semibold text-nowrap">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle fw-bold flex-shrink-0"
                                         style="width:28px;height:28px;font-size:0.65rem;background:#dbeafe;color:#1d4ed8;">
                                        {{ strtoupper(substr($cita->paciente->user->name,0,1)) }}
                                    </div>
                                    <span class="small fw-medium">{{ $cita->paciente->user->name }}</span>
                                </div>
                            </td>
                            <td class="small text-muted">Dr. {{ $cita->medico->user->name }}</td>
                            <td class="small text-muted">{{ $cita->especialidad->nombre }}</td>
                            <td>
                                <span class="badge {{ $badges[$cita->estado] ?? 'bg-secondary' }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td class="text-muted small" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $cita->motivo ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">No se encontraron citas con los filtros aplicados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($citas->hasPages())
                <div class="px-4 py-3 border-top">{{ $citas->links() }}</div>
                @endif
            </div>

        </main>
    </div>
</div>
</body>
</html>
