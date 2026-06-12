<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagar Consulta – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.paciente-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('paciente.pagos') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                @if($cita->fecha_hora->isFuture())
                    <h5 class="fw-bold mb-0">Pago anticipado</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Cita #{{ $cita->id }} · {{ $cita->fecha_hora->format('d/m/Y H:i') }} — aún no ocurrió</p>
                @else
                    <h5 class="fw-bold mb-0">Pagar Consulta</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Cita #{{ $cita->id }} · {{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
                @endif
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
                    <h6 class="fw-semibold mb-3 text-muted" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">Detalle de la consulta</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Médico</p>
                            <p class="fw-semibold mb-0 small">Dr. {{ $cita->medico->user->name }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Especialidad</p>
                            <p class="fw-semibold mb-0 small">{{ $cita->especialidad->nombre }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Fecha</p>
                            <p class="fw-semibold mb-0 small">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Estado</p>
                            @if($cita->fecha_hora->isFuture())
                                <span class="badge" style="background:#cffafe;color:#164e63;">Próxima · Anticipado</span>
                            @else
                                <span class="badge bg-success">Completada</span>
                            @endif
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between rounded-2 px-3 py-2"
                                 style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                <span class="small fw-semibold text-muted">Precio de consulta</span>
                                <span class="fw-bold" style="color:#15803d;font-size:1.1rem;">
                                    ${{ number_format($precioConsulta, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Formulario de pago --}}
                <form method="POST" action="{{ route('paciente.pago.store') }}" enctype="multipart/form-data" id="checkoutForm" class="d-flex flex-column gap-4">
                    @csrf
                    <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                    {{-- Monto --}}
                    <div class="app-card p-4">
                        <h6 class="fw-semibold mb-3">Monto a pagar</h6>

                        {{-- Precio destacado --}}
                        <div class="rounded-3 p-3 mb-3 d-flex align-items-center justify-content-between"
                             style="background:#f0fdf4;border:1px solid #bbf7d0;">
                            <div>
                                <div class="text-muted small">Consulta de {{ $cita->especialidad->nombre }}</div>
                                <div class="fw-bold" style="font-size:1.6rem;color:#15803d;">
                                    ${{ number_format($precioConsulta, 2) }}
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:44px;height:44px;background:#dcfce7;">
                                <svg width="20" height="20" fill="none" stroke="#15803d" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>

                        {{-- Campo oculto con precio fijo + campo visible de solo lectura --}}
                        <input type="hidden" name="monto" value="{{ number_format($precioConsulta, 2, '.', '') }}">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">$</span>
                            <input type="text" value="{{ number_format($precioConsulta, 2) }}"
                                   class="form-control fw-semibold" readonly
                                   style="background:#f9fafb;color:#15803d;cursor:default;">
                            <span class="input-group-text text-muted small">Precio fijo</span>
                        </div>
                        @error('monto')<p class="text-danger mt-1 small">{{ $message }}</p>@enderror
                    </div>

                    {{-- Método de pago (tabs) --}}
                    <div class="app-card p-4">
                        <h6 class="fw-semibold mb-3">Método de pago</h6>

                        <div class="row g-2 mb-3" id="metodosOpciones">
                            @foreach([
                                ['qr',      'QR / Transferencia', '<path d="M3 3h6v6H3zM15 3h6v6h-6zM3 15h6v6H3zM11 11h2v2h-2zM13 13h2v2h-2zM11 15h2v2h-2zM15 11h2v2h-2zM17 13h2v2h-2zM15 15h4v4h-4z"/>'],
                                ['tarjeta', 'Tarjeta de crédito', '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>'],
                                ['fisico',  'Pago en persona',    '<path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm0 0v20M2 12h20"/>'],
                            ] as [$val, $etiqueta, $svgPath])
                            <div class="col-12 col-sm-4">
                                <input type="radio" name="metodo_pago" value="{{ $val }}" id="mp_{{ $val }}"
                                       class="btn-check" {{ old('metodo_pago') === $val ? 'checked' : '' }}
                                       onchange="cambiarMetodo('{{ $val }}')">
                                <label for="mp_{{ $val }}"
                                       class="btn btn-outline-secondary w-100 d-flex flex-column align-items-center gap-1 py-3"
                                       style="font-size:0.78rem;min-height:72px;">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">{!! $svgPath !!}</svg>
                                    {{ $etiqueta }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('metodo_pago')<p class="text-danger small mt-1">{{ $message }}</p>@enderror

                        {{-- Panel QR --}}
                        <div id="panelQR" class="d-none">
                            <div class="rounded-3 p-4 text-center mb-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                <p class="fw-semibold small text-success mb-3">Escanea este código QR para transferir el pago:</p>
                                @if($qrImageUrl)
                                    <img src="{{ $qrImageUrl }}?v={{ time() }}" alt="Código QR de pago"
                                         class="img-fluid rounded mb-2" style="max-height:200px;border:1px solid #d1fae5;">
                                @else
                                    <div class="rounded-2 d-flex align-items-center justify-content-center text-muted mb-2"
                                         style="height:100px;background:#f9fafb;border:1px dashed #d1d5db;font-size:0.8rem;">
                                        El administrador aún no configuró el QR de pago.
                                    </div>
                                @endif
                                <p class="text-muted small mb-0">Una vez transferido, sube tu comprobante.</p>
                            </div>
                            <div>
                                <label class="form-label fw-semibold small">Comprobante de pago (captura del voucher)</label>
                                <input type="file" name="comprobante" accept="image/*"
                                       class="form-control @error('comprobante') is-invalid @enderror">
                                @error('comprobante')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <p class="text-muted mt-1 mb-0" style="font-size:0.72rem;">
                                    Tu pago quedará en estado <strong>Pendiente</strong> hasta que sea aprobado.
                                </p>
                            </div>
                        </div>

                        {{-- Panel Tarjeta (simulado) --}}
                        <div id="panelTarjeta" class="d-none">
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <label class="form-label fw-semibold small">Número de tarjeta</label>
                                    <input type="text" placeholder="4242 4242 4242 4242"
                                           maxlength="19" class="form-control"
                                           oninput="formatCard(this)">
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Vencimiento</label>
                                        <input type="text" placeholder="MM/AA" maxlength="5" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">CVV</label>
                                        <input type="text" placeholder="123" maxlength="4" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold small">Código de referencia</label>
                                    <input type="text" name="codigo_referencia"
                                           placeholder="Generado al confirmar (simulado)"
                                           class="form-control form-control-sm" id="refInput">
                                </div>
                                <div class="rounded-3 p-3" style="background:#fffbeb;border:1px solid #fde68a;">
                                    <p class="small mb-0" style="color:#92400e;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Pago simulado — no se realiza ningún cargo real.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Físico --}}
                        <div id="panelFisico" class="d-none">
                            <div class="rounded-3 p-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                                <p class="small mb-1 fw-semibold" style="color:#1d4ed8;">Pago en persona</p>
                                <p class="small mb-0" style="color:#1d4ed8;">
                                    Presenta el comprobante de esta cita en recepción. El personal registrará y aprobará tu pago.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Botón submit --}}
                    <div class="d-flex gap-3">
                        <a href="{{ route('paciente.pagos') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary fw-semibold flex-grow-1">Registrar pago</button>
                    </div>
                </form>

            </div>
        </main>
    </div>
</div>

<script>
function cambiarMetodo(metodo) {
    document.getElementById('panelQR').classList.add('d-none');
    document.getElementById('panelTarjeta').classList.add('d-none');
    document.getElementById('panelFisico').classList.add('d-none');
    if (metodo === 'qr')      document.getElementById('panelQR').classList.remove('d-none');
    if (metodo === 'tarjeta') {
        document.getElementById('panelTarjeta').classList.remove('d-none');
        // Simulate generating a reference code
        document.getElementById('refInput').value = 'REF-' + Date.now().toString(36).toUpperCase();
    }
    if (metodo === 'fisico')  document.getElementById('panelFisico').classList.remove('d-none');
}

function formatCard(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1 ').trim();
}

// Re-activate panel if old() has a value (validation fail)
@if(old('metodo_pago'))
    cambiarMetodo('{{ old('metodo_pago') }}');
    document.getElementById('mp_{{ old('metodo_pago') }}').checked = true;
@endif
</script>
</body>
</html>
