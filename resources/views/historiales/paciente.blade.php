<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de {{ $paciente->user->name }} – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .timeline-line {
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #bfdbfe, #e0e7ff 80%, transparent);
        }
        .timeline-entry {
            position: relative;
            padding-left: 52px;
            padding-bottom: 24px;
        }
        .timeline-entry:last-child { padding-bottom: 0; }
        .timeline-dot {
            position: absolute;
            left: 10px;
            top: 12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #2563eb;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #bfdbfe;
            z-index: 1;
        }
    </style>
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @if(auth()->user()->rol === 'admin')
        @include('partials.admin-sidebar', ['activeSection' => 'historiales'])
    @else
        @include('partials.medico-sidebar', ['activeSection' => 'historiales'])
    @endif

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('admin.historiales.index') }}" class="btn btn-light btn-sm p-2">
                @else
                    <a href="{{ route('historiales.index') }}" class="btn btn-light btn-sm p-2">
                @endif
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">Historial de {{ $paciente->user->name }}</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">
                        {{ $historiales->count() }} {{ $historiales->count() === 1 ? 'consulta registrada' : 'consultas registradas' }}
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar-circle fw-bold" style="width:36px;height:36px;font-size:0.8rem;background:#dbeafe;color:#1d4ed8;">
                    {{ strtoupper(substr($paciente->user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold small">{{ $paciente->user->name }}</div>
                    <div class="text-muted" style="font-size:0.7rem;">{{ $paciente->user->email }}</div>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto" style="max-width:720px;">

                @if($historiales->isEmpty())
                    <div class="app-card p-5 text-center text-muted">
                        <svg width="48" height="48" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" class="mb-3">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="fw-semibold mb-1">Sin historial clínico</p>
                        <p class="small mb-0">Este paciente no tiene consultas registradas todavía.</p>
                    </div>
                @else

                    {{-- Resumen del paciente --}}
                    <div class="app-card p-4 mb-4">
                        <div class="row g-3 text-center">
                            <div class="col-4">
                                <div class="rounded-3 p-3" style="background:#eff6ff;">
                                    <div class="fw-bold text-primary" style="font-size:1.5rem;">{{ $historiales->count() }}</div>
                                    <div class="text-muted small">Total consultas</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded-3 p-3" style="background:#f0fdf4;">
                                    <div class="fw-bold text-success" style="font-size:1.5rem;">
                                        {{ $historiales->pluck('medico_id')->unique()->count() }}
                                    </div>
                                    <div class="text-muted small">Médicos distintos</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="rounded-3 p-3" style="background:#fffbeb;">
                                    <div class="fw-bold text-warning" style="font-size:1.5rem;">
                                        {{ $historiales->first()->fecha->format('d/m/Y') }}
                                    </div>
                                    <div class="text-muted small">Última consulta</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="app-card p-4">
                        <h6 class="fw-semibold mb-4 text-muted" style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">
                            Cronología de consultas
                        </h6>

                        <div class="position-relative">
                            @if($historiales->count() > 1)
                                <div class="timeline-line"></div>
                            @endif

                            @foreach($historiales as $h)
                            <div class="timeline-entry">
                                <div class="timeline-dot"></div>

                                <div class="app-card p-3 border" style="border-color:#e5e7eb!important;">
                                    {{-- Header de la entrada --}}
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div>
                                            <span class="fw-bold small">{{ $h->fecha->format('d \d\e F \d\e Y') }}</span>
                                            <div class="text-muted" style="font-size:0.72rem;">
                                                Dr. {{ $h->medico->user->name }}
                                                @if($h->medico->especialidad)
                                                    · {{ $h->medico->especialidad->nombre }}
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $detailRoute = auth()->user()->rol === 'admin'
                                                ? route('admin.historiales.show', $h)
                                                : route('historiales.show', $h);
                                        @endphp
                                        <a href="{{ $detailRoute }}"
                                           class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 flex-shrink-0"
                                           style="font-size:0.75rem;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            Ver detalle
                                        </a>
                                    </div>

                                    {{-- Diagnóstico --}}
                                    <div class="mb-2">
                                        <span class="badge mb-1" style="background:#dbeafe;color:#1d4ed8;font-size:0.65rem;">Diagnóstico</span>
                                        <p class="mb-0 small text-muted" style="line-height:1.5;">
                                            {{ \Illuminate\Support\Str::limit($h->diagnostico, 160) }}
                                        </p>
                                    </div>

                                    {{-- Tratamiento --}}
                                    <div>
                                        <span class="badge mb-1" style="background:#dcfce7;color:#15803d;font-size:0.65rem;">Tratamiento</span>
                                        <p class="mb-0 small text-muted" style="line-height:1.5;">
                                            {{ \Illuminate\Support\Str::limit($h->tratamiento, 160) }}
                                        </p>
                                    </div>

                                    @if($h->observaciones)
                                    <div class="mt-2 pt-2 border-top">
                                        <span class="badge mb-1" style="background:#fef9c3;color:#854d0e;font-size:0.65rem;">Observaciones</span>
                                        <p class="mb-0 small text-muted" style="line-height:1.5;">
                                            {{ \Illuminate\Support\Str::limit($h->observaciones, 120) }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
