<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle Médico – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'medicos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('admin.medicos.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div class="flex-grow-1">
                <h5 class="fw-bold mb-0">Dr. {{ $medico->user->name }}</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $medico->especialidad->nombre }}</p>
            </div>
            <a href="{{ route('admin.medicos.edit', $medico) }}" class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            {{-- KPIs --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="kpi-card text-center">
                        <div class="fw-bold text-primary" style="font-size:2rem;">{{ $totalCitas }}</div>
                        <div class="text-muted small">Total Citas</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card text-center">
                        <div class="fw-bold text-success" style="font-size:2rem;">{{ $citasCompletadas }}</div>
                        <div class="text-muted small">Completadas</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card text-center">
                        <div class="fw-bold text-warning" style="font-size:2rem;">{{ $citasPendientes }}</div>
                        <div class="text-muted small">Pendientes / Confirmadas</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Info personal --}}
                <div class="col-lg-4">
                    <div class="app-card p-4">
                        <div class="text-center mb-4">
                            <div class="avatar-circle fw-bold text-white mx-auto mb-3" style="width:64px;height:64px;font-size:1.6rem;background:linear-gradient(135deg,#1d4ed8,#3b82f6);">
                                {{ strtoupper(substr($medico->user->name,0,1)) }}
                            </div>
                            <h6 class="fw-bold mb-0">Dr. {{ $medico->user->name }}</h6>
                            <p class="text-primary small mb-1">{{ $medico->especialidad->nombre }}</p>
                            <span class="badge {{ $medico->disponible ? 'bg-success' : 'bg-secondary' }}">
                                {{ $medico->disponible ? 'Disponible' : 'Inactivo' }}
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-2 pt-3 border-top">
                            <div class="d-flex align-items-start gap-2 text-muted small">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $medico->user->email }}
                            </div>
                            @if($medico->telefono)
                            <div class="d-flex align-items-start gap-2 text-muted small">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $medico->telefono }}
                            </div>
                            @endif
                            <div class="d-flex align-items-start gap-2 text-muted small">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span style="font-family:monospace;">Licencia: {{ $medico->numero_licencia }}</span>
                            </div>
                        </div>
                        @if($medico->descripcion)
                        <div class="mt-3 pt-3 border-top">
                            <p class="text-muted fw-semibold mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Descripción</p>
                            <p class="text-muted small mb-0">{{ $medico->descripcion }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Horarios + Últimas Citas --}}
                <div class="col-lg-8 d-flex flex-column gap-4">
                    @if($medico->horarios->isNotEmpty())
                    <div class="app-card p-4">
                        <h6 class="fw-semibold mb-3">Horarios de Atención</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($medico->horarios->sortBy(fn($h) => match($h->dia_semana) { 'lunes'=>1,'martes'=>2,'miércoles'=>3,'jueves'=>4,'viernes'=>5,'sábado'=>6,'domingo'=>7,default=>8 }) as $h)
                            <div class="rounded-3 px-3 py-2" style="background:#eff6ff;border:1px solid #bfdbfe;">
                                <div class="fw-semibold text-primary" style="font-size:0.72rem;text-transform:capitalize;">{{ $h->dia_semana }}</div>
                                <div class="text-primary" style="font-size:0.68rem;">{{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="app-card overflow-hidden">
                        <div class="px-4 py-3 border-bottom">
                            <h6 class="fw-semibold mb-0">Últimas Citas Atendidas</h6>
                        </div>
                        @if($ultimasCitas->isEmpty())
                            <div class="text-center text-muted py-4 small">Este médico no tiene citas registradas.</div>
                        @else
                        <table class="app-table">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimasCitas as $cita)
                                @php $badges=['confirmada'=>'badge-confirmada','pendiente'=>'badge-pendiente','completada'=>'badge-completada','cancelada'=>'badge-cancelada']; @endphp
                                <tr>
                                    <td class="fw-semibold small">{{ $cita->paciente->user->name }}</td>
                                    <td class="text-muted small">{{ $cita->fecha_hora->format('d M Y · h:i A') }}</td>
                                    <td><span class="badge {{ $badges[$cita->estado] ?? 'bg-secondary' }}">{{ ucfirst($cita->estado) }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
