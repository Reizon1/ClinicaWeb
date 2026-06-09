<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Usuario – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">
    @include('partials.admin-sidebar', ['activeSection' => 'usuarios'])
    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Nuevo Usuario</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Creá una cuenta de acceso al sistema</p>
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
                    <form method="POST" action="{{ route('admin.usuarios.store') }}" class="d-flex flex-column gap-3">
                        @csrf
                        <div>
                            <label class="form-label fw-semibold small">Nombre completo * <span class="fw-normal text-muted">(solo letras)</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: María González"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold small">Correo electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="usuario@clinica.com"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold small">Rol del usuario *</label>
                            <select name="rol" class="form-select form-select-sm @error('rol') is-invalid @enderror">
                                <option value="">Seleccioná un rol…</option>
                                <option value="admin"         {{ old('rol')==='admin'         ?'selected':'' }}>Administrador</option>
                                <option value="medico"        {{ old('rol')==='medico'        ?'selected':'' }}>Médico</option>
                                <option value="recepcionista" {{ old('rol')==='recepcionista' ?'selected':'' }}>Recepcionista</option>
                                <option value="paciente"      {{ old('rol')==='paciente'      ?'selected':'' }}>Paciente</option>
                            </select>
                            @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="border-top pt-3">
                            <p class="fw-semibold small mb-1">Contraseña *</p>
                            <p class="text-muted mb-3" style="font-size:0.78rem;">Mínimo 8 caracteres, una mayúscula, un número y un carácter especial.</p>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label small text-muted">Contraseña</label>
                                    <div class="input-group input-group-sm has-validation">
                                        <input type="password" name="password" id="usu_password" placeholder="••••••••"
                                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                                               oninput="checkUserPasswordStrength(this.value)">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePass('usu_password','usuEye1')">
                                            <svg id="usuEye1" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mt-1">
                                        <div class="progress" style="height:3px;"><div id="usuStrengthBar" class="progress-bar" style="width:0%;transition:width 0.3s,background 0.3s;"></div></div>
                                        <div class="d-flex flex-wrap gap-2 mt-1" style="font-size:0.68rem;">
                                            <span id="usu-req-len" class="text-muted">✗ 8+ car.</span>
                                            <span id="usu-req-upper" class="text-muted">✗ Mayúscula</span>
                                            <span id="usu-req-num" class="text-muted">✗ Número</span>
                                            <span id="usu-req-special" class="text-muted">✗ Especial</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-muted">Confirmar contraseña</label>
                                    <div class="input-group input-group-sm">
                                        <input type="password" name="password_confirmation" id="usu_password_conf" placeholder="••••••••" class="form-control form-control-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePass('usu_password_conf','usuEye2')">
                                            <svg id="usuEye2" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 pt-1">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Crear Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
const usuLabels = {'usu-req-len':'8+ car.','usu-req-upper':'Mayúscula','usu-req-num':'Número','usu-req-special':'Especial'};
function togglePass(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    const show  = field.type === 'password';
    field.type  = show ? 'text' : 'password';
    icon.innerHTML = show
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
}
function checkUserPasswordStrength(val) {
    const checks = {
        'usu-req-len':     val.length >= 8,
        'usu-req-upper':   /[A-Z]/.test(val),
        'usu-req-num':     /[0-9]/.test(val),
        'usu-req-special': /[^A-Za-z0-9]/.test(val),
    };
    const score  = Object.values(checks).filter(Boolean).length;
    const bar    = document.getElementById('usuStrengthBar');
    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    bar.style.width      = (score * 25) + '%';
    bar.style.background = score > 0 ? colors[score - 1] : '#e5e7eb';
    Object.entries(checks).forEach(([id, met]) => {
        const el = document.getElementById(id);
        el.textContent = (met ? '✓ ' : '✗ ') + usuLabels[id];
        el.className   = met ? 'text-success fw-semibold' : 'text-muted';
    });
}
</script>
</body>
</html>
