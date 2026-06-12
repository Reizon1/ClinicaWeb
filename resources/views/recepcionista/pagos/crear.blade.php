<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Pago – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('recepcionista.citas') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Registrar Pago</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Cita #{{ $cita->id }} – {{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto d-flex flex-column gap-4" style="max-width:560px;">

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                    </div>
                @endif

                {{-- Resumen de la cita --}}
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3">Resumen de la Consulta</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.72rem;">Paciente</p>
                            <p class="fw-semibold mb-0 small">{{ $cita->paciente->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.72rem;">Médico</p>
                            <p class="fw-semibold mb-0 small">Dr. {{ $cita->medico->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.72rem;">Especialidad</p>
                            <p class="fw-semibold mb-0 small">{{ $cita->especialidad->nombre }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.72rem;">Fecha de consulta</p>
                            <p class="fw-semibold mb-0 small">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted mb-0" style="font-size:0.72rem;">Motivo</p>
                            <p class="mb-0 small">{{ $cita->motivo }}</p>
                        </div>
                    </div>
                </div>

                {{-- Formulario de pago --}}
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3">Datos del Pago</h6>

                    <form method="POST" action="{{ route('recepcionista.pagos.store') }}" class="d-flex flex-column gap-3">
                        @csrf
                        <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                        <div>
                            <label class="form-label fw-semibold small">Concepto *</label>
                            <input type="text" name="concepto"
                                   value="{{ old('concepto', 'Consulta ' . $cita->especialidad->nombre) }}"
                                   required maxlength="255"
                                   class="form-control form-control-sm @error('concepto') is-invalid @enderror">
                            @error('concepto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Monto (USD) *</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text fw-semibold">$</span>
                                <input type="number" name="monto" value="{{ old('monto') }}"
                                       required min="0.01" max="99999.99" step="0.01" placeholder="0.00"
                                       class="form-control @error('monto') is-invalid @enderror">
                            </div>
                            @error('monto')<div class="text-danger" style="font-size:0.78rem;">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="form-label fw-semibold small">Método de pago *</label>
                            <div class="row g-2">
                                @foreach([
                                    ['efectivo','Efectivo','#1d4ed8'],
                                    ['stripe','Stripe','#1d4ed8'],
                                    ['paypal','PayPal','#4338ca'],
                                ] as [$val, $label, $color])
                                <div class="col-4">
                                    <input type="radio" name="metodo_pago" value="{{ $val }}" id="mp_{{ $val }}"
                                           class="btn-check" {{ old('metodo_pago') === $val ? 'checked' : '' }}>
                                    <label for="mp_{{ $val }}" class="btn btn-outline-secondary w-100 fw-semibold" style="font-size:0.78rem;">
                                        {{ $label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('metodo_pago')<div class="text-danger mt-1" style="font-size:0.78rem;">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-3 pt-1">
                            <a href="{{ route('recepcionista.citas') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                            <button type="submit" class="btn btn-primary fw-semibold flex-grow-1">Registrar Pago</button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
