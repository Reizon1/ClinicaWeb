<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario – Admin Los Mollos</title>
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
                <h5 class="fw-bold mb-0">Editar Usuario</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $usuario->name }}</p>
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
                    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}" class="d-flex flex-column gap-3">
                        @csrf @method('PUT')
                        <div>
                            <label class="form-label fw-semibold small">Nombre completo * <span class="fw-normal text-muted">(solo letras)</span></label>
                            <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold small">Correo electrónico *</label>
                            <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold small">Rol del usuario *</label>
                            @if($usuario->id === auth()->id())
                                <div class="form-control form-control-sm bg-light text-muted">
                                    {{ $usuario->rol }} <span class="text-muted">(no podés cambiar tu propio rol)</span>
                                </div>
                                <input type="hidden" name="rol" value="{{ $usuario->rol }}">
                            @else
                                <select name="rol" class="form-select form-select-sm @error('rol') is-invalid @enderror">
                                    <option value="admin"         {{ old('rol', $usuario->rol)==='admin'         ?'selected':'' }}>Administrador</option>
                                    <option value="medico"        {{ old('rol', $usuario->rol)==='medico'        ?'selected':'' }}>Médico</option>
                                    <option value="recepcionista" {{ old('rol', $usuario->rol)==='recepcionista' ?'selected':'' }}>Recepcionista</option>
                                    <option value="paciente"      {{ old('rol', $usuario->rol)==='paciente'      ?'selected':'' }}>Paciente</option>
                                </select>
                                @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="border-top pt-3">
                            <p class="fw-semibold small mb-0">Nueva contraseña</p>
                            <p class="text-muted mb-3" style="font-size:0.78rem;">Dejá en blanco para mantener la contraseña actual.</p>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label small text-muted">Contraseña <span class="text-muted">(mín. 8 chars)</span></label>
                                    <input type="password" name="password" placeholder="••••••••"
                                           class="form-control form-control-sm @error('password') is-invalid @enderror">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-muted">Confirmar contraseña</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 pt-1">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
