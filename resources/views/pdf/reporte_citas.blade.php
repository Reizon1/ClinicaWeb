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
    .confirmada { background: #dbeafe; color: #1d4ed8; }
    .completada { background: #dcfce7; color: #166534; }
    .pendiente  { background: #fef9c3; color: #92400e; }
    .cancelada  { background: #fee2e2; color: #991b1b; }
    .footer { margin-top: 16px; border-top: 1px solid #e5e7eb; padding-top: 10px; text-align: center; font-size: 9px; color: #9ca3af; }
    .kpi { display: table; width: 100%; margin-bottom: 16px; }
    .kpi-cell { display: table-cell; width: 25%; text-align: center; background: #f8fafc; border: 1px solid #e5e7eb; padding: 10px; }
    .kpi-val { font-size: 20px; font-weight: 700; color: #2563eb; }
    .kpi-label { font-size: 9px; color: #6b7280; margin-top: 2px; }
</style>
</head>
<body>
<div class="header">
    <h1>Reporte de Citas</h1>
    <p>Período: {{ $desde }} – {{ $hasta }} · Generado el {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="kpi">
    <div class="kpi-cell"><div class="kpi-val">{{ $citas->count() }}</div><div class="kpi-label">Total Citas</div></div>
    <div class="kpi-cell"><div class="kpi-val" style="color:#16a34a;">{{ $citas->where('estado','completada')->count() }}</div><div class="kpi-label">Completadas</div></div>
    <div class="kpi-cell"><div class="kpi-val" style="color:#f59e0b;">{{ $citas->whereIn('estado',['pendiente','confirmada'])->count() }}</div><div class="kpi-label">Pendientes</div></div>
    <div class="kpi-cell"><div class="kpi-val" style="color:#ef4444;">{{ $citas->where('estado','cancelada')->count() }}</div><div class="kpi-label">Canceladas</div></div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Especialidad</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($citas as $i => $c)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $c->paciente->user->name }}</td>
            <td>Dr. {{ $c->medico->user->name }}</td>
            <td>{{ $c->especialidad->nombre }}</td>
            <td>{{ $c->fecha_hora->format('d/m/Y') }}</td>
            <td>{{ $c->fecha_hora->format('H:i') }}</td>
            <td><span class="badge {{ $c->estado }}">{{ ucfirst($c->estado) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="footer">{{ config('app.name') }} · Reporte de Citas · {{ now()->format('d/m/Y') }}</div>
</body>
</html>
