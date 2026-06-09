<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Receta – Los Mollos</title>
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
                <h5 class="fw-bold mb-0">Editar Receta Médica</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Paciente: {{ $receta->paciente->user->name }}</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto d-flex flex-column gap-3" style="max-width:640px;">

                @if($errors->any())
                    <div class="alert alert-danger mb-0">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                {{-- Info de la receta --}}
                <div class="rounded-3 p-3 d-flex align-items-start gap-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div class="avatar-circle flex-shrink-0" style="background:#dbeafe;color:#2563eb;width:36px;height:36px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size:0.75rem;color:#1d4ed8;">Receta del</p>
                        <p class="mb-0" style="font-size:0.85rem;color:#1e40af;">{{ $receta->fecha_emision->format('d \d\e F \d\e Y') }} — {{ $receta->paciente->user->name }}</p>
                        <p class="mb-0" style="font-size:0.7rem;color:#2563eb;">Cita: {{ $receta->cita?->fecha_hora->format('d/m/Y H:i') ?? 'Sin cita vinculada' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('recetas.update', $receta) }}">
                    @csrf
                    @method('PUT')

                    <div class="app-card p-4 d-flex flex-column gap-3">

                        {{-- Medicamentos --}}
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-semibold small mb-0">Medicamentos *</label>
                                <button type="button" onclick="agregarMedicamento()" class="btn btn-link btn-sm p-0 text-primary d-flex align-items-center gap-1">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Agregar medicamento
                                </button>
                            </div>
                            <div id="medicamentosContainer" class="d-flex flex-column gap-3">
                                @php $medicamentos = old('medicamentos', $receta->medicamentos); @endphp
                                @foreach($medicamentos as $i => $med)
                                <div class="medicamento-item rounded-3 p-3 border" style="background:#f9fafb;">
                                    @if($i > 0)
                                    <div class="d-flex justify-content-end mb-2">
                                        <button type="button" onclick="this.closest('.medicamento-item').remove()" class="btn btn-link btn-sm p-0 text-danger small">Eliminar</button>
                                    </div>
                                    @endif
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label small text-muted mb-1">Nombre *</label>
                                            <input type="text" name="medicamentos[{{ $i }}][nombre]" required maxlength="200" value="{{ $med['nombre'] ?? '' }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Dosis *</label>
                                            <input type="text" name="medicamentos[{{ $i }}][dosis]" required maxlength="100" value="{{ $med['dosis'] ?? '' }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Frecuencia *</label>
                                            <input type="text" name="medicamentos[{{ $i }}][frecuencia]" required maxlength="100" value="{{ $med['frecuencia'] ?? '' }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Días *</label>
                                            <input type="number" name="medicamentos[{{ $i }}][dias]" required min="1" max="365" value="{{ $med['dias'] ?? '' }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Indicaciones generales <span class="text-muted fw-normal">(opcional)</span></label>
                            <textarea name="indicaciones" rows="3" maxlength="1000" class="form-control form-control-sm">{{ old('indicaciones', $receta->indicaciones) }}</textarea>
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Fecha de vencimiento *</label>
                            <input type="date" name="fecha_vencimiento"
                                   value="{{ old('fecha_vencimiento', $receta->fecha_vencimiento->format('Y-m-d')) }}"
                                   required
                                   class="form-control form-control-sm @error('fecha_vencimiento') is-invalid @enderror">
                            @error('fecha_vencimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2 pt-1">
                            <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
let medIdx = {{ count(old('medicamentos', $receta->medicamentos)) }};
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
            <div class="col-12"><label class="form-label small text-muted mb-1">Nombre *</label><input type="text" name="medicamentos[${idx}][nombre]" required maxlength="200" class="form-control form-control-sm"></div>
            <div class="col-6"><label class="form-label small text-muted mb-1">Dosis *</label><input type="text" name="medicamentos[${idx}][dosis]" required maxlength="100" class="form-control form-control-sm"></div>
            <div class="col-6"><label class="form-label small text-muted mb-1">Frecuencia *</label><input type="text" name="medicamentos[${idx}][frecuencia]" required maxlength="100" class="form-control form-control-sm"></div>
            <div class="col-6"><label class="form-label small text-muted mb-1">Días *</label><input type="number" name="medicamentos[${idx}][dias]" required min="1" max="365" class="form-control form-control-sm"></div>
        </div>`;
    container.appendChild(div);
}
</script>
</body>
</html>
