<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receta Médica – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>@media print{.app-sidebar,.app-topbar,a.btn{display:none!important;}.print-area{box-shadow:none!important;border:1px solid #ccc!important;}}</style>
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'recetas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('recetas.index') }}" class="btn btn-light btn-sm p-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">Receta Médica</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $receta->paciente->user->name }} – {{ $receta->fecha_emision->format('d/m/Y') }}</p>
                </div>
            </div>
            <button onclick="window.print()" class="btn btn-secondary btn-sm d-flex align-items-center gap-1">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Imprimir
            </button>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto d-flex flex-column gap-3 print-area" style="max-width:640px;">

                <div class="app-card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h5 class="fw-bold text-primary mb-0">Hospital Los Mollos</h5>
                            <p class="text-muted small mb-0">Sistema Hospitalario Digital</p>
                        </div>
                        <div class="text-end">
                            <p class="text-muted small mb-0">Fecha de emisión</p>
                            <p class="fw-bold mb-0">{{ $receta->fecha_emision->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Paciente</p>
                            <p class="fw-semibold mb-0">{{ $receta->paciente->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Médico</p>
                            <p class="fw-semibold mb-0">Dr. {{ $receta->medico->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Especialidad</p>
                            <p class="fw-semibold mb-0">{{ $receta->medico->especialidad->nombre }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Vencimiento</p>
                            <p class="fw-semibold mb-0 {{ $receta->fecha_vencimiento->isPast() ? 'text-danger' : 'text-success' }}">
                                {{ $receta->fecha_vencimiento->format('d/m/Y') }}
                                @if($receta->fecha_vencimiento->isPast()) <span class="small">(Vencida)</span> @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="app-card p-4">
                    <h6 class="fw-bold mb-3">Medicamentos Indicados</h6>
                    <div class="d-flex flex-column gap-3">
                        @foreach($receta->medicamentos as $i => $med)
                        <div class="rounded-3 p-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="avatar-circle bg-primary text-white fw-bold flex-shrink-0" style="width:22px;height:22px;font-size:0.65rem;">{{ $i+1 }}</span>
                                <span class="fw-semibold">{{ $med['nombre'] }}</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-4">
                                    <p class="text-muted mb-0" style="font-size:0.7rem;">Dosis</p>
                                    <p class="mb-0 small">{{ $med['dosis'] }}</p>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0" style="font-size:0.7rem;">Frecuencia</p>
                                    <p class="mb-0 small">{{ $med['frecuencia'] }}</p>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0" style="font-size:0.7rem;">Duración</p>
                                    <p class="mb-0 small">{{ $med['dias'] }} día(s)</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($receta->indicaciones)
                <div class="app-card p-4">
                    <h6 class="fw-bold mb-3">Indicaciones Generales</h6>
                    <p class="mb-0 rounded-3 p-3" style="background:#fffbeb;font-size:0.875rem;">{{ $receta->indicaciones }}</p>
                </div>
                @endif

            </div>
        </main>
    </div>
</div>
</body>
</html>
