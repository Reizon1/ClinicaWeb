<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Paciente – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'pacientes'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('dashboard.recepcionista') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Registrar Nuevo Paciente</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Completá los datos del paciente</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto app-card p-4" style="max-width:640px;">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('recepcionista.pacientes.guardar') }}" class="d-flex flex-column gap-4">
                    @csrf

                    <div>
                        <h6 class="text-muted fw-bold mb-3 pb-2 border-bottom" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.06em;">Datos de acceso</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Nombre completo *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nombre y apellido"
                                       class="form-control form-control-sm @error('name') is-invalid @enderror">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Correo electrónico *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="paciente@email.com"
                                       class="form-control form-control-sm @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Contraseña *</label>
                                <input type="password" name="password" required minlength="8" placeholder="Mínimo 8 caracteres"
                                       class="form-control form-control-sm @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Confirmar contraseña *</label>
                                <input type="password" name="password_confirmation" required minlength="8" placeholder="Repetí la contraseña"
                                       class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="text-muted fw-bold mb-3 pb-2 border-bottom" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.06em;">Datos clínicos</h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Fecha de nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required max="{{ date('Y-m-d') }}"
                                       class="form-control form-control-sm @error('fecha_nacimiento') is-invalid @enderror">
                                @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Género *</label>
                                <select name="genero" required class="form-select form-select-sm @error('genero') is-invalid @enderror">
                                    <option value="">Seleccioná</option>
                                    <option value="masculino" {{ old('genero')=='masculino'?'selected':'' }}>Masculino</option>
                                    <option value="femenino"  {{ old('genero')=='femenino' ?'selected':'' }}>Femenino</option>
                                    <option value="otro"      {{ old('genero')=='otro'     ?'selected':'' }}>Otro</option>
                                </select>
                                @error('genero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Teléfono</label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}" maxlength="20" placeholder="+54 9 ..."
                                       class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Tipo de sangre</label>
                                <select name="tipo_sangre" class="form-select form-select-sm">
                                    <option value="">No sabe / No informa</option>
                                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                                        <option value="{{ $ts }}" {{ old('tipo_sangre')==$ts?'selected':'' }}>{{ $ts }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Dirección</label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}" maxlength="255" placeholder="Calle y número"
                                       class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Alergias conocidas</label>
                                <textarea name="alergias" rows="2" maxlength="500" placeholder="Ej: Penicilina, látex..."
                                          class="form-control form-control-sm">{{ old('alergias') }}</textarea>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Enfermedades previas</label>
                                <textarea name="enfermedades_previas" rows="2" maxlength="500" placeholder="Ej: Diabetes tipo 2..."
                                          class="form-control form-control-sm">{{ old('enfermedades_previas') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="{{ route('dashboard.recepcionista') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn fw-semibold flex-grow-1 text-white" style="background:#0d9488;">Registrar Paciente</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
