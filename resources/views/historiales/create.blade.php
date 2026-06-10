<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Historial Clínico – Los Mollos</title>
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
                <h5 class="fw-bold mb-0">Nuevo Historial Clínico</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Registrá el diagnóstico y tratamiento de la consulta</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto app-card p-4" style="max-width:640px;">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('historiales.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Cita *</label>
                        <select name="cita_id" required class="form-select form-select-sm @error('cita_id') is-invalid @enderror">
                            <option value="">Seleccioná la cita correspondiente</option>
                            @foreach($citas as $cita)
                                <option value="{{ $cita->id }}" {{ (old('cita_id') == $cita->id || ($citaSeleccionada && $citaSeleccionada->id == $cita->id)) ? 'selected' : '' }}>
                                    {{ $cita->fecha_hora->format('d/m/Y H:i') }} – {{ $cita->paciente->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cita_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Diagnóstico *</label>
                        <textarea name="diagnostico" rows="3" required maxlength="1000" placeholder="Describí el diagnóstico del paciente..."
                            class="form-control form-control-sm @error('diagnostico') is-invalid @enderror">{{ old('diagnostico') }}</textarea>
                        @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Tratamiento *</label>
                        <textarea name="tratamiento" rows="3" required maxlength="1000" placeholder="Detallá el tratamiento indicado..."
                            class="form-control form-control-sm @error('tratamiento') is-invalid @enderror">{{ old('tratamiento') }}</textarea>
                        @error('tratamiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Observaciones <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea name="observaciones" rows="2" maxlength="1000" placeholder="Notas adicionales, recomendaciones..."
                            class="form-control form-control-sm">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="alert alert-warning d-flex align-items-start gap-2 py-2 px-3 mb-4" style="font-size:0.8rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Al guardar este historial, la cita será marcada automáticamente como <strong>completada</strong>.
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('historiales.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Registrar Historial</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
