<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial Médico – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.paciente-sidebar', ['activeSection' => 'historial'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#EFF6FF;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Historial Médico</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Tus registros clínicos</p>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if($historiales->isEmpty())
            <div class="app-card p-5 text-center">
                <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width:64px;height:64px;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h6 class="fw-bold mb-1">Sin registros clínicos</h6>
                <p class="text-muted small">Tus registros médicos aparecerán aquí después de cada consulta.</p>
            </div>
            @else
            <div class="d-flex flex-column gap-3">
                @foreach($historiales as $historial)
                <div class="app-card p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white" style="width:44px;height:44px;font-size:1rem;background:#2563EB;">
                                {{ strtoupper(substr($historial->medico->user->name,0,1)) }}
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size:0.9rem;">Dr. {{ $historial->medico->user->name }}</div>
                                <div class="text-muted small">{{ $historial->cita?->especialidad?->nombre ?? 'Consulta general' }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-semibold" style="font-size:0.85rem;color:#2563EB;">{{ $historial->fecha->format('d M, Y') }}</div>
                            <div class="text-muted" style="font-size:0.72rem;">Consulta #{{ $historial->id }}</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="rounded-2 p-3" style="background:#f9fafb;border:1px solid #f3f4f6;">
                                <div class="fw-semibold small mb-1" style="color:#2563EB;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" class="me-1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Diagnóstico
                                </div>
                                <p class="mb-0 text-muted small">{{ $historial->diagnostico }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="rounded-2 p-3" style="background:#f9fafb;border:1px solid #f3f4f6;">
                                <div class="fw-semibold small mb-1" style="color:#2563EB;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" class="me-1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    Tratamiento
                                </div>
                                <p class="mb-0 text-muted small">{{ $historial->tratamiento }}</p>
                            </div>
                        </div>
                        @if($historial->observaciones)
                        <div class="col-12">
                            <div class="rounded-2 p-3" style="background:#f9fafb;border:1px solid #f3f4f6;">
                                <div class="fw-semibold small mb-1" style="color:#2563EB;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" class="me-1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                    Observaciones
                                </div>
                                <p class="mb-0 text-muted small">{{ $historial->observaciones }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @if($historiales->hasPages())
            <div class="mt-4">
                {{ $historiales->links('pagination::bootstrap-5') }}
            </div>
            @endif
            @endif

        </main>
    </div>
</div>
</body>
</html>
