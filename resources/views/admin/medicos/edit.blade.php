<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Médico – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'medicos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('admin.medicos.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Editar: {{ $medico->user->name }}</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $medico->especialidad->nombre }}</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto" style="max-width:520px;">

                @if($errors->any())
                    <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="fw-semibold mb-1">Corregí los siguientes errores:</p>
                            @foreach($errors->all() as $e)<p class="mb-0 small">• {{ $e }}</p>@endforeach
                        </div>
                    </div>
                @endif

                <div class="app-card p-4">
                    <form method="POST" action="{{ route('admin.medicos.update', $medico) }}" class="d-flex flex-column gap-3">
                        @csrf @method('PUT')

                        <div>
                            <label class="form-label fw-semibold small">Nombre completo * <span class="fw-normal text-muted">(solo letras)</span></label>
                            <input type="text" name="name" value="{{ old('name', $medico->user->name) }}" required maxlength="100"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Correo electrónico *</label>
                            <input type="email" name="email" value="{{ old('email', $medico->user->email) }}" required maxlength="150"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Especialidad *</label>
                            <select name="especialidad_id" required class="form-select form-select-sm @error('especialidad_id') is-invalid @enderror">
                                @foreach($especialidades as $e)
                                    <option value="{{ $e->id }}" {{ old('especialidad_id', $medico->especialidad_id)==$e->id?'selected':'' }}>{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                            @error('especialidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Número de licencia * <span class="fw-normal text-muted">(ej: MP-10245)</span></label>
                            <input type="text" name="numero_licencia" value="{{ old('numero_licencia', $medico->numero_licencia) }}" required maxlength="50"
                                   class="form-control form-control-sm @error('numero_licencia') is-invalid @enderror" style="font-family:monospace;">
                            @error('numero_licencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Teléfono <span class="fw-normal text-muted">(solo números)</span></label>
                            <input type="text" name="telefono" value="{{ old('telefono', $medico->telefono) }}" maxlength="20"
                                   class="form-control form-control-sm @error('telefono') is-invalid @enderror">
                            @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Descripción profesional</label>
                            <textarea name="descripcion" rows="3" maxlength="1000"
                                      class="form-control form-control-sm">{{ old('descripcion', $medico->descripcion) }}</textarea>
                        </div>

                        <div class="d-flex align-items-center gap-2 rounded-3 p-3" style="background:#f9fafb;">
                            <input type="checkbox" name="disponible" id="disponible" value="1"
                                   class="form-check-input" {{ old('disponible', $medico->disponible) ? 'checked' : '' }}>
                            <label for="disponible" class="form-check-label fw-semibold small mb-0">Médico disponible para recibir pacientes</label>
                        </div>

                        <div class="d-flex gap-3 pt-1">
                            <a href="{{ route('admin.medicos.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Actualizar Médico</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
