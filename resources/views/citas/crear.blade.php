<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendar Cita – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container-lg">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">Los Mollos</a>
            <div class="d-flex gap-3">
                <a href="{{ route('medicos.buscar') }}" class="nav-link text-muted small">Ver médicos</a>
                <a href="{{ route('dashboard.paciente') }}" class="nav-link text-muted small">Mi Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width:640px;padding-top:3rem;padding-bottom:3rem;">

        <div class="mb-4">
            <h3 class="fw-bold mb-1">Agendar una cita</h3>
            <p class="text-muted">Completá el formulario y un médico confirmará tu cita.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('citas.store') }}" class="app-card p-4 d-flex flex-column gap-4">
            @csrf

            @if($errors->any())
                <div class="alert alert-danger mb-0">
                    @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                </div>
            @endif

            <div>
                <label class="form-label fw-semibold">Especialidad <span class="text-danger">*</span></label>
                <select name="especialidad_id" id="especialidad_id" onchange="cargarMedicos()"
                        class="form-select @error('especialidad_id') is-invalid @enderror">
                    <option value="">Seleccioná una especialidad</option>
                    @foreach($especialidades as $esp)
                        <option value="{{ $esp->id }}" {{ old('especialidad_id') == $esp->id ? 'selected' : '' }}>{{ $esp->nombre }}</option>
                    @endforeach
                </select>
                @error('especialidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label fw-semibold">Médico <span class="text-danger">*</span></label>
                <select name="medico_id" id="medico_id" class="form-select @error('medico_id') is-invalid @enderror">
                    <option value="">Primero elegí una especialidad</option>
                    @foreach($medicos as $med)
                        @if(!old('especialidad_id'))
                            <option value="{{ $med->id }}" {{ old('medico_id') == $med->id ? 'selected' : '' }}>{{ $med->user->name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('medico_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label fw-semibold">Fecha y hora <span class="text-danger">*</span></label>
                <input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora') }}"
                       min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                       class="form-control @error('fecha_hora') is-invalid @enderror">
                @error('fecha_hora')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label fw-semibold">Motivo de la consulta <span class="text-danger">*</span></label>
                <textarea name="motivo" rows="3" maxlength="500" placeholder="Describí brevemente por qué necesitás la consulta..."
                          class="form-control @error('motivo') is-invalid @enderror">{{ old('motivo') }}</textarea>
                @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold py-2">Confirmar Cita</button>
                <a href="{{ route('dashboard.paciente') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
    function cargarMedicos() {
        const especialidadId = document.getElementById('especialidad_id').value;
        const medicoSelect = document.getElementById('medico_id');
        medicoSelect.innerHTML = '<option value="">Cargando médicos...</option>';
        if (!especialidadId) {
            medicoSelect.innerHTML = '<option value="">Primero elegí una especialidad</option>';
            return;
        }
        fetch(`/medicos/por-especialidad?especialidad_id=${especialidadId}`)
            .then(r => r.json())
            .then(data => {
                medicoSelect.innerHTML = '<option value="">Seleccioná un médico</option>';
                data.forEach(m => { medicoSelect.innerHTML += `<option value="${m.id}">${m.nombre}</option>`; });
                if (data.length === 0) medicoSelect.innerHTML = '<option value="">No hay médicos disponibles</option>';
            })
            .catch(() => { medicoSelect.innerHTML = '<option value="">Error al cargar médicos</option>'; });
    }
    </script>
</body>
</html>
