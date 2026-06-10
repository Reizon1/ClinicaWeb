<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Médico – Admin Los Mollos</title>
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
            <h5 class="fw-bold mb-0">Registrar Nuevo Médico</h5>
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
                    <form method="POST" action="{{ route('admin.medicos.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div>
                            <label class="form-label fw-semibold small">Nombre completo * <span class="fw-normal text-muted">(solo letras)</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required maxlength="100" placeholder="Ej: Carlos Alberto García"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Correo electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required maxlength="150" placeholder="medico@losmollos.com"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Contraseña * <span class="fw-normal text-muted">(mín. 8 car.)</span></label>
                                <div class="input-group input-group-sm has-validation">
                                    <input type="password" name="password" id="medico_password" required minlength="8"
                                           class="form-control form-control-sm @error('password') is-invalid @enderror"
                                           oninput="checkPasswordStrength(this.value)">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('medico_password','eyeIcon1')">
                                        <svg id="eyeIcon1" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mt-1">
                                    <div class="progress" style="height:3px;"><div id="strengthBar" class="progress-bar" style="width:0%;transition:width 0.3s,background 0.3s;"></div></div>
                                    <div class="d-flex flex-wrap gap-2 mt-1" style="font-size:0.68rem;">
                                        <span id="req-len" class="text-muted">✗ 8+ car.</span>
                                        <span id="req-upper" class="text-muted">✗ Mayúscula</span>
                                        <span id="req-num" class="text-muted">✗ Número</span>
                                        <span id="req-special" class="text-muted">✗ Especial</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Confirmar contraseña *</label>
                                <div class="input-group input-group-sm">
                                    <input type="password" name="password_confirmation" id="medico_password_conf" required minlength="8" class="form-control form-control-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('medico_password_conf','eyeIcon2')">
                                        <svg id="eyeIcon2" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Especialidad *</label>
                            <select name="especialidad_id" required class="form-select form-select-sm @error('especialidad_id') is-invalid @enderror">
                                <option value="">— Seleccioná la especialidad —</option>
                                @foreach($especialidades as $e)
                                    <option value="{{ $e->id }}" {{ old('especialidad_id')==$e->id?'selected':'' }}>{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                            @error('especialidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Número de licencia * <span class="fw-normal text-muted">(ej: MP-10245)</span></label>
                            <input type="text" name="numero_licencia" value="{{ old('numero_licencia') }}" required maxlength="50" placeholder="MP-10245"
                                   class="form-control form-control-sm @error('numero_licencia') is-invalid @enderror" style="font-family:monospace;">
                            @error('numero_licencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Teléfono <span class="fw-normal text-muted">(solo números)</span></label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" maxlength="20" placeholder="+54 9 11 0000-0000"
                                   class="form-control form-control-sm @error('telefono') is-invalid @enderror">
                            @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Descripción profesional</label>
                            <textarea name="descripcion" rows="3" maxlength="1000" placeholder="Breve descripción del médico y su experiencia..."
                                      class="form-control form-control-sm">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="d-flex gap-3 pt-1">
                            <a href="{{ route('admin.medicos.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Registrar Médico</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
const pwLabels = {'req-len':'8+ car.','req-upper':'Mayúscula','req-num':'Número','req-special':'Especial'};
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    const show  = field.type === 'password';
    field.type  = show ? 'text' : 'password';
    icon.innerHTML = show
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
}
function checkPasswordStrength(val) {
    const checks = {
        'req-len':     val.length >= 8,
        'req-upper':   /[A-Z]/.test(val),
        'req-num':     /[0-9]/.test(val),
        'req-special': /[^A-Za-z0-9]/.test(val),
    };
    const score  = Object.values(checks).filter(Boolean).length;
    const bar    = document.getElementById('strengthBar');
    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    bar.style.width      = (score * 25) + '%';
    bar.style.background = score > 0 ? colors[score - 1] : '#e5e7eb';
    Object.entries(checks).forEach(([id, met]) => {
        const el = document.getElementById(id);
        el.textContent = (met ? '✓ ' : '✗ ') + pwLabels[id];
        el.className   = met ? 'text-success fw-semibold' : 'text-muted';
    });
}
</script>
</body>
</html>
