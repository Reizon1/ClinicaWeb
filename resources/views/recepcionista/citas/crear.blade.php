<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Cita – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'nueva-cita'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('recepcionista.citas') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Agendar Nueva Cita</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Registrá una cita para un paciente</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto app-card p-4" style="max-width:520px;">

                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('recepcionista.citas.guardar') }}" class="d-flex flex-column gap-3">
                    @csrf

                    <div>
                        <label class="form-label fw-semibold small">Paciente *</label>
                        <select name="paciente_id" required class="form-select form-select-sm @error('paciente_id') is-invalid @enderror">
                            <option value="">Seleccioná un paciente</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}" {{ old('paciente_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                            @endforeach
                        </select>
                        @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Especialidad *</label>
                        <select name="especialidad_id" id="especialidad_id" required
                                class="form-select form-select-sm @error('especialidad_id') is-invalid @enderror">
                            <option value="">Seleccioná una especialidad</option>
                            @foreach($especialidades as $e)
                                <option value="{{ $e->id }}" {{ old('especialidad_id') == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>
                            @endforeach
                        </select>
                        @error('especialidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Médico *</label>
                        <select name="medico_id" id="medico_id" required class="form-select form-select-sm @error('medico_id') is-invalid @enderror">
                            <option value="">Primero seleccioná una especialidad</option>
                        </select>
                        @error('medico_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Fecha y Hora *</label>
                        <input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora') }}" required
                               min="{{ now()->addMinutes(30)->format('Y-m-d\TH:i') }}"
                               class="form-control form-control-sm @error('fecha_hora') is-invalid @enderror">
                        @error('fecha_hora')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Motivo de consulta *</label>
                        <textarea name="motivo" rows="2" required maxlength="500" placeholder="Describí el motivo de la consulta..."
                                  class="form-control form-control-sm @error('motivo') is-invalid @enderror">{{ old('motivo') }}</textarea>
                        @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="alert alert-warning d-flex align-items-start gap-2 py-2 px-3 mb-0" style="font-size:0.78rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        El sistema validará automáticamente que no haya conflictos de horario para el médico y el paciente seleccionados.
                    </div>

                    <div class="d-flex gap-3 pt-1">
                        <a href="{{ route('recepcionista.citas') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn fw-semibold flex-grow-1 text-white" style="background:#0d9488;">Agendar Cita</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
document.getElementById('especialidad_id').addEventListener('change', function() {
    const especialidadId = this.value;
    const medicoSelect = document.getElementById('medico_id');
    medicoSelect.innerHTML = '<option value="">Cargando médicos...</option>';
    if (!especialidadId) { medicoSelect.innerHTML = '<option value="">Primero seleccioná una especialidad</option>'; return; }
    fetch(`/medicos/por-especialidad?especialidad_id=${especialidadId}`)
        .then(r => r.json())
        .then(data => {
            medicoSelect.innerHTML = '<option value="">Seleccioná un médico</option>';
            data.forEach(m => { medicoSelect.innerHTML += `<option value="${m.id}">Dr. ${m.nombre}</option>`; });
            if (data.length === 0) medicoSelect.innerHTML = '<option value="">No hay médicos disponibles</option>';
        });
});
</script>
</body>
</html>
