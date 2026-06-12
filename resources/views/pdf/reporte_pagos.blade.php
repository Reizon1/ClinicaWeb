<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1a1a2e; }
    .header { background: #1e3a8a; color: #fff; padding: 20px 28px; margin-bottom: 20px; }
    .header h1 { font-size: 18px; font-weight: 700; }
    .header p { font-size: 10px; opacity: 0.85; margin-top: 4px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    thead th { background: #2563eb; color: #fff; padding: 7px 10px; font-size: 10px; text-align: left; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody td { padding: 6px 10px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
    .badge { display: inline-block; border-radius: 9999px; padding: 2px 8px; font-size: 9px; font-weight: 600; }
    .completado { background: #dcfce7; color: #166534; }
    .pendiente  { background: #fef9c3; color: #92400e; }
    .footer { margin-top: 16px; border-top: 1px solid #e5e7eb; padding-top: 10px; text-align: center; font-size: 9px; color: #9ca3af; }
    .kpi { display: table; width: 100%; margin-bottom: 16px; }
    .kpi-cell { display: table-cell; width: 33%; text-align: center; background: #f8fafc; border: 1px solid #e5e7eb; padding: 10px; }
    .kpi-val { font-size: 18px; font-weight: 700; color: #2563eb; }
    .kpi-label { font-size: 9px; color: #6b7280; margin-top: 2px; }
    .grand-total { text-align: right; font-size: 13px; font-weight: 700; color: #1e3a8a; padding: 8px 10px; background: #eff6ff; border-radius: 4px; margin-top: 4px; }
</style>
</head>
<body>
<div class="header">
    <h1>Reporte de Pagos</h1>
    <p>Período: {{ $desde }} – {{ $hasta }} · Generado el {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="kpi">
    <div class="kpi-cell">
        <div class="kpi-val">${{ number_format($pagos->where('estado','completado')->sum('monto'), 2) }}</div>
        <div class="kpi-label">Ingresos Totales</div>
    </div>
    <div class="kpi-cell">
        <div class="kpi-val">{{ $pagos->where('estado','completado')->count() }}</div>
        <div class="kpi-label">Pagos Completados</div>
    </div>
    <div class="kpi-cell">
        <div class="kpi-val" style="color:#f59e0b;">{{ $pagos->where('estado','pendiente')->count() }}</div>
        <div class="kpi-label">Pendientes</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Factura</th>
            <th>Paciente</th>
            <th>Concepto</th>
            <th>Monto</th>
            <th>Descuento</th>
            <th>Total</th>
            <th>Método</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pagos as $p)
        <tr>
            <td>{{ $p->numero_factura ?? '—' }}</td>
            <td>{{ $p->paciente->user->name }}</td>
            <td>{{ $p->concepto }}</td>
            <td>${{ number_format($p->monto_original ?? $p->monto, 2) }}</td>
            <td>{{ $p->descuento_porcentaje > 0 ? $p->descuento_porcentaje.'%' : '—' }}</td>
            <td>${{ number_format($p->monto, 2) }}</td>
            <td>{{ strtoupper($p->metodo_pago) }}</td>
            <td>{{ $p->fecha_pago ? $p->fecha_pago->format('d/m/Y') : '—' }}</td>
            <td><span class="badge {{ $p->estado }}">{{ ucfirst($p->estado) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="grand-total">TOTAL INGRESOS: ${{ number_format($pagos->where('estado','completado')->sum('monto'), 2) }}</div>
<div class="footer">{{ config('app.name') }} · Reporte de Pagos · {{ now()->format('d/m/Y') }}</div>
</body>
</html>
