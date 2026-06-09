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
                                <div class="input-group input-group-sm has-validation">
                                    <input type="password" name="password" id="pac_password" required minlength="8" placeholder="Mínimo 8 caracteres"
                                           class="form-control form-control-sm @error('password') is-invalid @enderror"
                                           oninput="checkPacPassword(this.value)">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pac_password','pacEye1')">
                                        <svg id="pacEye1" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mt-1">
                                    <div class="progress" style="height:3px;"><div id="pacStrBar" class="progress-bar" style="width:0%;transition:width 0.3s,background 0.3s;"></div></div>
                                    <div class="d-flex flex-wrap gap-2 mt-1" style="font-size:0.68rem;">
                                        <span id="pac-req-len" class="text-muted">✗ 8+ car.</span>
                                        <span id="pac-req-upper" class="text-muted">✗ Mayúscula</span>
                                        <span id="pac-req-num" class="text-muted">✗ Número</span>
                                        <span id="pac-req-special" class="text-muted">✗ Especial</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Confirmar contraseña *</label>
                                <div class="input-group input-group-sm">
                                    <input type="password" name="password_confirmation" id="pac_password_conf" required minlength="8" placeholder="Repetí la contraseña"
                                           class="form-control form-control-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pac_password_conf','pacEye2')">
                                        <svg id="pacEye2" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
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
<script>
const pacLabels = {'pac-req-len':'8+ car.','pac-req-upper':'Mayúscula','pac-req-num':'Número','pac-req-special':'Especial'};
function togglePw(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    const show  = field.type === 'password';
    field.type  = show ? 'text' : 'password';
    icon.innerHTML = show
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
}
function checkPacPassword(val) {
    const checks = {
        'pac-req-len':     val.length >= 8,
        'pac-req-upper':   /[A-Z]/.test(val),
        'pac-req-num':     /[0-9]/.test(val),
        'pac-req-special': /[^A-Za-z0-9]/.test(val),
    };
    const score  = Object.values(checks).filter(Boolean).length;
    const bar    = document.getElementById('pacStrBar');
    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    bar.style.width      = (score * 25) + '%';
    bar.style.background = score > 0 ? colors[score - 1] : '#e5e7eb';
    Object.entries(checks).forEach(([id, met]) => {
        const el = document.getElementById(id);
        el.textContent = (met ? '✓ ' : '✗ ') + pacLabels[id];
        el.className   = met ? 'text-success fw-semibold' : 'text-muted';
    });
}
</script>
</body>
</html>
