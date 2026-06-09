<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Suscripción – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">
    @include('partials.admin-sidebar', ['activeSection' => 'suscripciones'])
    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('admin.suscripciones.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Nueva Suscripción Premium</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Asignar membresía a un paciente</p>
            </div>
        </header>
        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto app-card p-4" style="max-width:520px;">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.suscripciones.store') }}" class="d-flex flex-column gap-3">
                    @csrf

                    <div>
                        <label class="form-label fw-semibold small">Paciente *</label>
                        <select name="paciente_id" required class="form-select form-select-sm @error('paciente_id') is-invalid @enderror">
                            <option value="">Seleccioná un paciente</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}" {{ old('paciente_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                            @endforeach
                        </select>
                        @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Plan *</label>
                        <select name="plan" required class="form-select form-select-sm @error('plan') is-invalid @enderror">
                            <option value="premium" {{ old('plan') === 'premium' ? 'selected' : '' }}>Premium – Acceso prioritario</option>
                            <option value="premium_plus" {{ old('plan') === 'premium_plus' ? 'selected' : '' }}>Premium Plus – Acceso ilimitado</option>
                        </select>
                        @error('plan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Precio mensual (USD) *</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text fw-semibold">$</span>
                                <input type="number" name="precio" value="{{ old('precio', '29.99') }}" required min="1" step="0.01"
                                       class="form-control @error('precio') is-invalid @enderror">
                            </div>
                            @error('precio')<div class="text-danger" style="font-size:0.78rem;">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Duración (meses) *</label>
                            <input type="number" name="duracion_mes" value="{{ old('duracion_mes', 1) }}" required min="1" max="24"
                                   class="form-control form-control-sm @error('duracion_mes') is-invalid @enderror">
                            @error('duracion_mes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Fecha de inicio *</label>
                        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}" required
                               class="form-control form-control-sm @error('fecha_inicio') is-invalid @enderror">
                        @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold small">Método de pago *</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" name="metodo_pago" value="stripe" id="mp_stripe" class="btn-check"
                                       {{ old('metodo_pago', 'stripe') === 'stripe' ? 'checked' : '' }}>
                                <label for="mp_stripe" class="btn btn-outline-secondary w-100 fw-semibold small">Stripe</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="metodo_pago" value="paypal" id="mp_paypal" class="btn-check"
                                       {{ old('metodo_pago') === 'paypal' ? 'checked' : '' }}>
                                <label for="mp_paypal" class="btn btn-outline-secondary w-100 fw-semibold small">PayPal</label>
                            </div>
                        </div>
                        @error('metodo_pago')<div class="text-danger mt-1" style="font-size:0.78rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="rounded-3 p-3" style="background:#faf5ff;border:1px solid #e9d5ff;">
                        <p class="mb-0 small" style="color:#5b21b6;">Los pacientes Premium tienen acceso prioritario al agendamiento de citas y descuentos en consultas.</p>
                    </div>

                    <div class="d-flex gap-3 pt-1">
                        <a href="{{ route('admin.suscripciones.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn fw-semibold flex-grow-1 text-white" style="background:#7c3aed;">Crear Suscripción</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
