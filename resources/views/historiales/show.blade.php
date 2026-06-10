<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial Clínico – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'historiales'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('historiales.index') }}" class="btn btn-light btn-sm p-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">Historial Clínico</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $historial->paciente->user->name }} – {{ $historial->fecha->format('d/m/Y') }}</p>
                </div>
            </div>
            <a href="{{ route('historiales.edit', $historial) }}" class="btn btn-primary btn-sm">Editar</a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto d-flex flex-column gap-3" style="max-width:640px;">

                <div class="app-card p-4">
                    <h6 class="fw-bold text-muted border-bottom pb-2 mb-3" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Información del Paciente</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Paciente</p>
                            <p class="fw-semibold mb-0">{{ $historial->paciente->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Fecha</p>
                            <p class="fw-semibold mb-0">{{ $historial->fecha->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Médico</p>
                            <p class="fw-semibold mb-0">Dr. {{ $historial->medico->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Especialidad</p>
                            <p class="fw-semibold mb-0">{{ $historial->medico->especialidad->nombre }}</p>
                        </div>
                    </div>
                </div>

                <div class="app-card p-4">
                    <h6 class="fw-bold mb-3">Diagnóstico</h6>
                    <p class="mb-0 rounded-3 p-3" style="background:#eff6ff;font-size:0.875rem;">{{ $historial->diagnostico }}</p>
                </div>

                <div class="app-card p-4">
                    <h6 class="fw-bold mb-3">Tratamiento</h6>
                    <p class="mb-0 rounded-3 p-3" style="background:#f0fdf4;font-size:0.875rem;">{{ $historial->tratamiento }}</p>
                </div>

                @if($historial->observaciones)
                <div class="app-card p-4">
                    <h6 class="fw-bold mb-3">Observaciones</h6>
                    <p class="mb-0 rounded-3 p-3" style="background:#fffbeb;font-size:0.875rem;">{{ $historial->observaciones }}</p>
                </div>
                @endif

            </div>
        </main>
    </div>
</div>
</body>
</html>
