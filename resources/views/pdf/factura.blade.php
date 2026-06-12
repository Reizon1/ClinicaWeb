<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a2e; background: #fff; }
    .header { background: linear-gradient(135deg, #1e3a8a, #2563eb); color: #fff; padding: 24px 32px; }
    .header h1 { font-size: 22px; font-weight: 700; margin-bottom: 2px; }
    .header p { font-size: 11px; opacity: 0.85; }
    .badge-factura { display: inline-block; background: rgba(255,255,255,0.2); border-radius: 4px; padding: 4px 12px; font-size: 11px; font-weight: 600; margin-top: 8px; }
    .body { padding: 24px 32px; }
    .grid-2 { display: table; width: 100%; margin-bottom: 20px; }
    .col { display: table-cell; width: 50%; vertical-align: top; padding-right: 16px; }
    .section-title { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; margin-bottom: 6px; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; }
    .info-row { margin-bottom: 4px; }
    .info-label { color: #6b7280; font-size: 10px; }
    .info-value { font-weight: 600; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    thead th { background: #1e3a8a; color: #fff; padding: 8px 12px; font-size: 10px; text-align: left; }
    tbody td { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
    .total-box { background: #f8fafc; border: 2px solid #2563eb; border-radius: 6px; padding: 16px 20px; text-align: right; }
    .total-row { display: table; width: 100%; margin-bottom: 6px; }
    .total-label { display: table-cell; text-align: left; color: #6b7280; font-size: 11px; }
    .total-value { display: table-cell; text-align: right; font-size: 11px; }
    .total-final { font-size: 16px; font-weight: 700; color: #1e3a8a; }
    .badge-estado { display: inline-block; border-radius: 9999px; padding: 3px 10px; font-size: 10px; font-weight: 600; }
    .estado-completado { background: #dcfce7; color: #166534; }
    .estado-pendiente  { background: #fef9c3; color: #92400e; }
    .footer { margin-top: 24px; border-top: 1px solid #e5e7eb; padding-top: 12px; text-align: center; color: #9ca3af; font-size: 10px; }
    .premium-badge { display: inline-block; background: #fef9c3; color: #92400e; border-radius: 4px; padding: 2px 8px; font-size: 10px; font-weight: 600; margin-left: 6px; }
</style>
</head>
<body>

<div class="header">
    <div style="display:table;width:100%;">
        <div style="display:table-cell;vertical-align:middle;">
            <h1>{{ $clinica['nombre'] }}</h1>
            <p>{{ $clinica['direccion'] }}</p>
            <p>{{ $clinica['telefono'] }} · {{ $clinica['email'] }}</p>
        </div>
        <div style="display:table-cell;vertical-align:middle;text-align:right;">
            <div style="font-size:20px;font-weight:700;">FACTURA</div>
            <div class="badge-factura">{{ $pago->numero_factura ?? 'N/A' }}</div>
        </div>
    </div>
</div>

<div class="body">

    <div class="grid-2">
        <div class="col">
            <div class="section-title">Datos del Paciente</div>
            <div class="info-row">
                <span class="info-value">
                    {{ $pago->paciente->user->name }}
                    @if($pago->beneficio_premium)
                        <span class="premium-badge">★ PREMIUM</span>
                    @endif
                </span>
            </div>
            <div class="info-row"><span class="info-label">Email: </span><span class="info-value">{{ $pago->paciente->user->email }}</span></div>
            @if($pago->paciente->telefono)
            <div class="info-row"><span class="info-label">Teléfono: </span><span class="info-value">{{ $pago->paciente->telefono }}</span></div>
            @endif
        </div>
        <div class="col">
            <div class="section-title">Datos de Factura</div>
            <div class="info-row"><span class="info-label">Número: </span><span class="info-value">{{ $pago->numero_factura }}</span></div>
            <div class="info-row"><span class="info-label">Fecha: </span><span class="info-value">{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span></div>
            <div class="info-row">
                <span class="info-label">Estado: </span>
                <span class="badge-estado {{ $pago->estado === 'completado' ? 'estado-completado' : 'estado-pendiente' }}">
                    {{ ucfirst($pago->estado) }}
                </span>
            </div>
            <div class="info-row"><span class="info-label">Método de Pago: </span><span class="info-value">{{ strtoupper($pago->metodo_pago) }}</span></div>
        </div>
    </div>

    @if($pago->cita)
    <div class="section-title" style="margin-bottom:8px;">Detalle del Servicio</div>
    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Fecha Consulta</th>
                <th style="text-align:right;">Precio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $pago->concepto }}</td>
                <td>Dr. {{ $pago->cita->medico->user->name }}</td>
                <td>{{ $pago->cita->especialidad->nombre }}</td>
                <td>{{ $pago->cita->fecha_hora->format('d/m/Y H:i') }}</td>
                <td style="text-align:right;">${{ number_format($pago->monto_original ?? $pago->monto, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="section-title" style="margin-bottom:8px;">Detalle del Servicio</div>
    <table>
        <thead><tr><th>Concepto</th><th style="text-align:right;">Monto</th></tr></thead>
        <tbody>
            <tr>
                <td>{{ $pago->concepto }}</td>
                <td style="text-align:right;">${{ number_format($pago->monto_original ?? $pago->monto, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    <div class="total-box">
        @if($pago->descuento_porcentaje > 0)
        <div class="total-row">
            <span class="total-label">Subtotal</span>
            <span class="total-value">${{ number_format($pago->monto_original, 2) }}</span>
        </div>
        <div class="total-row">
            <span class="total-label">Descuento Premium ({{ $pago->descuento_porcentaje }}%)</span>
            <span class="total-value" style="color:#16a34a;">-${{ number_format($pago->monto_original - $pago->monto, 2) }}</span>
        </div>
        <div style="border-top:1px solid #e5e7eb;margin:8px 0;"></div>
        @endif
        <div class="total-row">
            <span class="total-label total-final">TOTAL</span>
            <span class="total-value total-final">${{ number_format($pago->monto, 2) }}</span>
        </div>
        @if($pago->beneficio_premium)
        <div style="margin-top:8px;padding:6px 10px;background:#fef9c3;border-radius:4px;font-size:10px;color:#92400e;">
            ★ ¡Felicitaciones! Acumuló 3 citas premium. Se ha registrado un beneficio especial en su cuenta.
        </div>
        @endif
    </div>

    <div class="footer">
        <p>{{ $clinica['nombre'] }} — {{ $clinica['direccion'] }}</p>
        <p>Este documento es válido como comprobante de pago. Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</div>

</body>
</html>
