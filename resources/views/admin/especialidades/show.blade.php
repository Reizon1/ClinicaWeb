<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $especialidad->nombre }} – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'especialidades'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.especialidades.index') }}" class="btn btn-light btn-sm p-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">{{ $especialidad->nombre }}</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Detalle de especialidad médica</p>
                </div>
            </div>
            <a href="{{ route('admin.especialidades.edit', $especialidad) }}" class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Editar
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto" style="max-width:720px;">

                {{-- Info card --}}
                <div class="app-card p-4 mb-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h4 class="fw-bold mb-1">{{ $especialidad->nombre }}</h4>
                            @if($especialidad->descripcion)
                                <p class="text-muted mb-0">{{ $especialidad->descripcion }}</p>
                            @endif
                        </div>
                        <span class="badge {{ $especialidad->activa ? 'bg-success' : 'bg-secondary' }}" style="font-size:0.8rem;">
                            {{ $especialidad->activa ? '✓ Activa' : '✗ Inactiva' }}
                        </span>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-4">
                            <div class="rounded-3 p-3 text-center" style="background:#eff6ff;">
                                <div class="fw-bold text-primary" style="font-size:1.6rem;">{{ $especialidad->medicos->count() }}</div>
                                <div class="text-muted small">Médicos asignados</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="rounded-3 p-3 text-center" style="background:#f0fdf4;">
                                <div class="fw-bold text-success" style="font-size:1.6rem;">{{ $totalCitas }}</div>
                                <div class="text-muted small">Citas totales</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="rounded-3 p-3 text-center" style="background:#fffbeb;">
                                <div class="fw-bold text-warning" style="font-size:1.6rem;">
                                    {{ $especialidad->medicos->where('disponible', true)->count() }}
                                </div>
                                <div class="text-muted small">Médicos disponibles</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Médicos asignados --}}
                <div class="app-card overflow-hidden">
                    <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold mb-0">Médicos de esta especialidad</h6>
                        <span class="badge" style="background:#dbeafe;color:#1d4ed8;">{{ $especialidad->medicos->count() }}</span>
                    </div>

                    @if($especialidad->medicos->isEmpty())
                        <div class="p-5 text-center text-muted">
                            <svg width="40" height="40" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" class="mb-3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="mb-0 small">No hay médicos asignados a esta especialidad.</p>
                        </div>
                    @else
                        <div class="divide-y">
                            @foreach($especialidad->medicos as $medico)
                            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle fw-bold flex-shrink-0"
                                         style="width:36px;height:36px;font-size:0.75rem;background:#dbeafe;color:#1d4ed8;">
                                        {{ strtoupper(substr($medico->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">Dr. {{ $medico->user->name }}</div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $medico->user->email }}</div>
                                        @if($medico->numero_licencia)
                                            <div class="text-muted" style="font-size:0.68rem;font-family:monospace;">Lic: {{ $medico->numero_licencia }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $medico->disponible ? 'bg-success' : 'bg-secondary' }}" style="font-size:0.7rem;">
                                        {{ $medico->disponible ? 'Disponible' : 'Inactivo' }}
                                    </span>
                                    <a href="{{ route('admin.medicos.show', $medico) }}" class="crud-btn crud-btn-view" title="Ver médico">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
