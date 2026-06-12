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
            <div class="mx-auto d-flex flex-column gap-4" style="max-width:580px;">

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                    </div>
                @endif

                {{-- Premium alert --}}
                @if($esPremium)
                <div class="rounded-3 p-3 d-flex align-items-start gap-3" style="background:#fef9c3;border:1px solid #fde68a;">
                    <svg width="20" height="20" fill="none" stroke="#92400e" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <div>
                        <p class="fw-semibold mb-1" style="color:#92400e;">Paciente Premium — {{ $descuento }}% de descuento aplicado</p>
                        <p class="mb-0" style="font-size:0.8rem;color:#92400e;">
                            Citas premium completadas: {{ $citasCompletadasPremium }}.
                            @if($beneficioDisponible)
                                <strong>🎉 ¡Esta es la cita #{{ $citasCompletadasPremium + 1 }}! El paciente recibirá un beneficio especial.</strong>
                            @else
                                @php $faltanParaBeneficio = 3 - (($citasCompletadasPremium % 3 === 0 && $citasCompletadasPremium > 0) ? 3 : $citasCompletadasPremium % 3); @endphp
                                Faltan {{ $faltanParaBeneficio }} cita(s) para el próximo beneficio.
                            @endif
                        </p>
                    </div>
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

                    <form method="POST" action="{{ route('recepcionista.pagos.store') }}" class="d-flex flex-column gap-3" id="pagoForm">
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
                            <label class="form-label fw-semibold small">Monto base (USD) *</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text fw-semibold">$</span>
                                <input type="number" name="monto" id="montoInput" value="{{ old('monto') }}"
                                       required min="0.01" max="99999.99" step="0.01" placeholder="0.00"
                                       class="form-control @error('monto') is-invalid @enderror"
                                       oninput="calcularDescuento()">
                            </div>
                            @error('monto')<div class="text-danger" style="font-size:0.78rem;">{{ $message }}</div>@enderror
                        </div>

                        @if($esPremium && $descuento > 0)
                        <div class="rounded-3 p-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Subtotal</span><span id="montoOriginal">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between small text-success fw-semibold mt-1">
                                <span>Descuento Premium ({{ $descuento }}%)</span><span id="montoDescuento">-$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold mt-2 pt-2" style="border-top:1px solid #bbf7d0;">
                                <span>TOTAL A COBRAR</span><span id="montoFinal" class="text-success">$0.00</span>
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="form-label fw-semibold small">Método de pago *</label>
                            <div class="row g-2" id="metodoPagoOpciones">
                                @foreach([
                                    ['efectivo','Efectivo','💵'],
                                    ['stripe','Stripe','💳'],
                                    ['paypal','PayPal','🅿'],
                                    ['qr','QR / Transferencia','📱'],
                                ] as [$val, $label, $icon])
                                <div class="col-6">
                                    <input type="radio" name="metodo_pago" value="{{ $val }}" id="mp_{{ $val }}"
                                           class="btn-check"
                                           {{ old('metodo_pago') === $val ? 'checked' : '' }}
                                           onchange="mostrarQR('{{ $val }}')">
                                    <label for="mp_{{ $val }}" class="btn btn-outline-secondary w-100 fw-semibold" style="font-size:0.78rem;">
                                        {{ $icon }} {{ $label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('metodo_pago')<div class="text-danger mt-1" style="font-size:0.78rem;">{{ $message }}</div>@enderror
                        </div>

                        {{-- QR Code display --}}
                        <div id="qrSection" class="d-none">
                            <div class="rounded-3 p-3 text-center" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                <p class="fw-semibold small text-success mb-2">Mostrar al paciente este código QR para la transferencia:</p>
                                @if($qrImagePath)
                                    <img src="{{ $qrImagePath }}" alt="QR Pago" style="max-height:200px;border-radius:8px;border:1px solid #e5e7eb;">
                                @else
                                    <div class="text-muted" style="font-size:0.8rem;">El administrador aún no ha configurado el código QR de pago.</div>
                                @endif
                                <p class="text-muted mt-2 mb-0" style="font-size:0.72rem;">El pago quedará como <strong>Pendiente</strong> hasta que el administrador lo apruebe.</p>
                            </div>
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

<script>
const descuento = {{ $descuento }};

function calcularDescuento() {
    const base = parseFloat(document.getElementById('montoInput').value) || 0;
    const descuentoMonto = base * descuento / 100;
    const final = base - descuentoMonto;
    const el = document.getElementById('montoOriginal');
    if (el) {
        document.getElementById('montoOriginal').textContent = '$' + base.toFixed(2);
        document.getElementById('montoDescuento').textContent = '-$' + descuentoMonto.toFixed(2);
        document.getElementById('montoFinal').textContent = '$' + final.toFixed(2);
    }
}

function mostrarQR(metodo) {
    const qrSection = document.getElementById('qrSection');
    if (metodo === 'qr') {
        qrSection.classList.remove('d-none');
    } else {
        qrSection.classList.add('d-none');
    }
}
</script>
</body>
</html>
