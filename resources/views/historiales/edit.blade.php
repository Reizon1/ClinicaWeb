<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Historial – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'historiales'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('historiales.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Editar Historial Clínico</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Paciente: {{ $historial->paciente->user->name }}</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto" style="max-width:640px;">

                @if($errors->any())
                    <div class="alert alert-danger d-flex align-items-start gap-2 mb-3">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="mb-0 ps-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                {{-- Cita vinculada --}}
                <div class="rounded-3 p-3 mb-3 d-flex align-items-start gap-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div class="avatar-circle flex-shrink-0" style="background:#dbeafe;color:#2563eb;width:36px;height:36px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size:0.75rem;color:#1d4ed8;">Cita vinculada</p>
                        <p class="mb-0" style="font-size:0.85rem;color:#1e40af;">
                            {{ $historial->cita?->fecha_hora->format('d/m/Y H:i') ?? 'Sin cita vinculada' }}
                            — {{ $historial->paciente->user->name }}
                        </p>
                        <p class="mb-0" style="font-size:0.7rem;color:#2563eb;">Fecha: {{ $historial->fecha->format('d \d\e F \d\e Y') }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('historiales.update', $historial) }}">
                    @csrf
                    @method('PUT')

                    <div class="app-card p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Diagnóstico *</label>
                            <textarea name="diagnostico" rows="4" placeholder="Describí el diagnóstico del paciente..."
                                class="form-control form-control-sm @error('diagnostico') is-invalid @enderror">{{ old('diagnostico', $historial->diagnostico) }}</textarea>
                            @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tratamiento *</label>
                            <textarea name="tratamiento" rows="4" placeholder="Detallá el tratamiento indicado..."
                                class="form-control form-control-sm @error('tratamiento') is-invalid @enderror">{{ old('tratamiento', $historial->tratamiento) }}</textarea>
                            @error('tratamiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Observaciones <span class="text-muted fw-normal">(opcional)</span></label>
                            <textarea name="observaciones" rows="3" placeholder="Notas adicionales..."
                                class="form-control form-control-sm">{{ old('observaciones', $historial->observaciones) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('historiales.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
