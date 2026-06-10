<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Horario – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'horarios'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('horarios.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Agregar Horario</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Configurá un nuevo bloque de atención</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto app-card p-4" style="max-width:480px;">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('horarios.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Día de la semana *</label>
                        <select name="dia_semana" required class="form-select form-select-sm @error('dia_semana') is-invalid @enderror">
                            <option value="">Seleccioná un día</option>
                            @foreach($dias as $dia)
                                <option value="{{ $dia }}" {{ old('dia_semana') === $dia ? 'selected' : '' }}>{{ ucfirst($dia) }}</option>
                            @endforeach
                        </select>
                        @error('dia_semana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Hora de inicio *</label>
                            <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required
                                class="form-control form-control-sm @error('hora_inicio') is-invalid @enderror">
                            @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Hora de fin *</label>
                            <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required
                                class="form-control form-control-sm @error('hora_fin') is-invalid @enderror">
                            @error('hora_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-start gap-2 py-2 px-3 mb-4" style="font-size:0.8rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        El sistema verificará automáticamente que no exista superposición con tus horarios existentes.
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('horarios.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Guardar Horario</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
