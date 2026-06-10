<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Receta – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'recetas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('recetas.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Emitir Receta Médica</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Registrá los medicamentos indicados al paciente</p>
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

                <form method="POST" action="{{ route('recetas.store') }}" id="recetaForm">
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

                    {{-- Medicamentos dinámicos --}}
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold small mb-0">Medicamentos *</label>
                            <button type="button" onclick="agregarMedicamento()" class="btn btn-link btn-sm p-0 text-primary d-flex align-items-center gap-1">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Agregar medicamento
                            </button>
                        </div>
                        <div id="medicamentosContainer" class="d-flex flex-column gap-3">
                            <div class="medicamento-item rounded-3 p-3 border" style="background:#f9fafb;">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label small text-muted mb-1">Nombre del medicamento *</label>
                                        <input type="text" name="medicamentos[0][nombre]" required maxlength="200" placeholder="Ej: Ibuprofeno 400mg" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small text-muted mb-1">Dosis *</label>
                                        <input type="text" name="medicamentos[0][dosis]" required maxlength="100" placeholder="Ej: 1 comprimido" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small text-muted mb-1">Frecuencia *</label>
                                        <input type="text" name="medicamentos[0][frecuencia]" required maxlength="100" placeholder="Ej: Cada 8 horas" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small text-muted mb-1">Duración (días) *</label>
                                        <input type="number" name="medicamentos[0][dias]" required min="1" max="365" placeholder="7" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Indicaciones generales <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea name="indicaciones" rows="2" maxlength="1000" placeholder="Indicaciones adicionales para el paciente..."
                            class="form-control form-control-sm">{{ old('indicaciones') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Fecha de vencimiento *</label>
                        <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" required
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="form-control form-control-sm @error('fecha_vencimiento') is-invalid @enderror">
                        @error('fecha_vencimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Emitir Receta</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
let medIdx = 1;
function agregarMedicamento() {
    const container = document.getElementById('medicamentosContainer');
    const idx = medIdx++;
    const div = document.createElement('div');
    div.className = 'medicamento-item rounded-3 p-3 border';
    div.style.background = '#f9fafb';
    div.innerHTML = `
        <div class="d-flex justify-content-end mb-2">
            <button type="button" onclick="this.closest('.medicamento-item').remove()" class="btn btn-link btn-sm p-0 text-danger small">Eliminar</button>
        </div>
        <div class="row g-2">
            <div class="col-12">
                <label class="form-label small text-muted mb-1">Nombre del medicamento *</label>
                <input type="text" name="medicamentos[${idx}][nombre]" required maxlength="200" placeholder="Ej: Amoxicilina 500mg" class="form-control form-control-sm">
            </div>
            <div class="col-6">
                <label class="form-label small text-muted mb-1">Dosis *</label>
                <input type="text" name="medicamentos[${idx}][dosis]" required maxlength="100" placeholder="Ej: 1 cápsula" class="form-control form-control-sm">
            </div>
            <div class="col-6">
                <label class="form-label small text-muted mb-1">Frecuencia *</label>
                <input type="text" name="medicamentos[${idx}][frecuencia]" required maxlength="100" placeholder="Ej: Cada 12 horas" class="form-control form-control-sm">
            </div>
            <div class="col-6">
                <label class="form-label small text-muted mb-1">Duración (días) *</label>
                <input type="number" name="medicamentos[${idx}][dias]" required min="1" max="365" placeholder="7" class="form-control form-control-sm">
            </div>
        </div>`;
    container.appendChild(div);
}
</script>
</body>
</html>
