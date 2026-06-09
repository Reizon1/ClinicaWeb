<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Especialidad – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">
    @include('partials.admin-sidebar', ['activeSection' => 'especialidades'])
    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('admin.especialidades.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h5 class="fw-bold mb-0">Editar Especialidad: {{ $especialidad->nombre }}</h5>
        </header>
        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto app-card p-4" style="max-width:520px;">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.especialidades.update', $especialidad) }}" class="d-flex flex-column gap-3">
                    @csrf @method('PUT')
                    <div>
                        <label class="form-label fw-semibold small">Nombre de la especialidad *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $especialidad->nombre) }}" required maxlength="100"
                               class="form-control form-control-sm @error('nombre') is-invalid @enderror">
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-semibold small">Descripción</label>
                        <textarea name="descripcion" rows="3" maxlength="500"
                                  class="form-control form-control-sm">{{ old('descripcion', $especialidad->descripcion) }}</textarea>
                    </div>
                    <div class="d-flex align-items-center gap-2 rounded-3 p-3" style="background:#f9fafb;">
                        <input type="checkbox" name="activa" id="activa" value="1"
                               class="form-check-input" {{ old('activa', $especialidad->activa) ? 'checked' : '' }}>
                        <label for="activa" class="form-check-label fw-semibold small mb-0">Especialidad activa (visible para pacientes)</label>
                    </div>
                    <div class="d-flex gap-3 pt-1">
                        <a href="{{ route('admin.especialidades.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Actualizar</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
