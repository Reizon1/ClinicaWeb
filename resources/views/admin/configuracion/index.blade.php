<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">
    @include('partials.admin-sidebar', ['activeSection' => 'configuracion'])
    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar">
            <h5 class="fw-bold mb-0">Configuración del Sistema</h5>
            <p class="text-muted mb-0 ms-2" style="font-size:0.75rem;">Parámetros generales de la clínica</p>
        </header>
        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="flex-shrink-0 mt-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="fw-semibold mb-1">Corregí los siguientes errores:</p>
                        @foreach($errors->all() as $e)<p class="mb-0 small">• {{ $e }}</p>@endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.configuracion.update') }}" class="d-flex flex-column gap-4">
                @csrf

                {{-- Información de la clínica --}}
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                        <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Información de la Clínica
                    </h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Nombre de la Clínica *</label>
                            <input type="text" name="clinica_nombre" value="{{ old('clinica_nombre', $config['clinica_nombre']) }}" required maxlength="100"
                                   class="form-control form-control-sm @error('clinica_nombre') is-invalid @enderror">
                            @error('clinica_nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Correo de Contacto</label>
                            <input type="email" name="clinica_email" value="{{ old('clinica_email', $config['clinica_email']) }}" maxlength="100" placeholder="contacto@clinica.com"
                                   class="form-control form-control-sm @error('clinica_email') is-invalid @enderror">
                            @error('clinica_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Teléfono <span class="fw-normal text-muted">(solo números)</span></label>
                            <input type="text" name="clinica_telefono" value="{{ old('clinica_telefono', $config['clinica_telefono']) }}" maxlength="30" placeholder="+54 9 11 0000-0000"
                                   class="form-control form-control-sm @error('clinica_telefono') is-invalid @enderror">
                            @error('clinica_telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Dirección</label>
                            <input type="text" name="clinica_direccion" value="{{ old('clinica_direccion', $config['clinica_direccion']) }}" maxlength="255"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Horario de Atención</label>
                            <input type="text" name="clinica_horario" value="{{ old('clinica_horario', $config['clinica_horario']) }}" maxlength="100" placeholder="Lunes a Viernes 08:00 – 18:00"
                                   class="form-control form-control-sm">
                        </div>
                    </div>
                </div>

                {{-- Parámetros operativos --}}
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                        <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Parámetros Operativos
                    </h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Máximo de citas por día <span class="fw-normal text-muted">(por médico)</span></label>
                            <input type="number" name="max_citas_dia" value="{{ old('max_citas_dia', $config['max_citas_dia']) }}" min="1" max="100"
                                   class="form-control form-control-sm @error('max_citas_dia') is-invalid @enderror">
                            @error('max_citas_dia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Duración de consulta <span class="fw-normal text-muted">(minutos)</span></label>
                            <input type="number" name="tiempo_consulta" value="{{ old('tiempo_consulta', $config['tiempo_consulta']) }}" min="10" max="120"
                                   class="form-control form-control-sm @error('tiempo_consulta') is-invalid @enderror">
                            @error('tiempo_consulta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('dashboard.admin') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary fw-semibold px-5 d-flex align-items-center gap-2">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>
</body>
</html>
