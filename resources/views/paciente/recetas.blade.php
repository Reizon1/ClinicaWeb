<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Recetas – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.paciente-sidebar', ['activeSection' => 'recetas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#ccfbf1;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#0f766e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Mis Recetas</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Recetas médicas emitidas para ti</p>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if($recetas->isEmpty())
            <div class="app-card p-5 text-center">
                <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width:64px;height:64px;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h6 class="fw-bold mb-1">Sin recetas</h6>
                <p class="text-muted small">Tus recetas médicas aparecerán aquí después de cada consulta.</p>
            </div>
            @else
            <div class="d-flex flex-column gap-3">
                @foreach($recetas as $receta)
                <div class="app-card p-4">
                    {{-- Encabezado --}}
                    <div class="d-flex align-items-start justify-content-between mb-3 pb-3" style="border-bottom:1px solid #f3f4f6;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white" style="width:44px;height:44px;font-size:1rem;background:#0d9488;">
                                {{ strtoupper(substr($receta->medico->user->name,0,1)) }}
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size:0.9rem;">Dr. {{ $receta->medico->user->name }}</div>
                                <div class="text-muted small">{{ $receta->cita?->especialidad?->nombre ?? 'Consulta general' }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-semibold" style="font-size:0.85rem;color:#0d9488;">{{ $receta->fecha_emision->format('d M, Y') }}</div>
                            @if($receta->fecha_vencimiento)
                            <div class="text-muted" style="font-size:0.72rem;">
                                Vence: {{ $receta->fecha_vencimiento->format('d M, Y') }}
                                @if(now()->gt($receta->fecha_vencimiento))
                                    <span class="badge badge-cancelada ms-1">Vencida</span>
                                @else
                                    <span class="badge badge-confirmada ms-1">Vigente</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Medicamentos --}}
                    @if($receta->medicamentos && count($receta->medicamentos) > 0)
                    <div class="mb-3">
                        <div class="fw-semibold small mb-2" style="color:#0d9488;">Medicamentos</div>
                        <div class="row g-2">
                            @foreach($receta->medicamentos as $med)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-2 p-2 rounded-2" style="background:#f9fafb;border:1px solid #f3f4f6;">
                                    <div class="kpi-icon flex-shrink-0" style="background:#ccfbf1;width:28px;height:28px;border-radius:8px;">
                                        <svg width="13" height="13" fill="none" stroke="#0d9488" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.82rem;">{{ $med['nombre'] ?? '' }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">
                                            {{ $med['dosis'] ?? '' }}
                                            @if(!empty($med['frecuencia'])) · {{ $med['frecuencia'] }} @endif
                                            @if(!empty($med['dias'])) · {{ $med['dias'] }} días @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Indicaciones --}}
                    @if($receta->indicaciones)
                    <div class="rounded-2 p-3" style="background:#f9fafb;border:1px solid #f3f4f6;">
                        <div class="fw-semibold small mb-1" style="color:#0d9488;">Indicaciones</div>
                        <p class="mb-0 text-muted small">{{ $receta->indicaciones }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            @if($recetas->hasPages())
            <div class="mt-4">
                {{ $recetas->links('pagination::bootstrap-5') }}
            </div>
            @endif
            @endif

        </main>
    </div>
</div>
</body>
</html>
