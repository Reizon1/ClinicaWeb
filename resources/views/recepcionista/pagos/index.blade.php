<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagos – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar">
            <h5 class="fw-bold mb-0">Gestión de Pagos</h5>
            <p class="text-muted mb-0 ms-2" style="font-size:0.75rem;">Registros de pagos por consultas médicas</p>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info mb-3">{{ session('info') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            {{-- KPI Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="kpi-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1" style="font-size:0.72rem;">Total recaudado</p>
                                <h4 class="fw-bold mb-0">${{ number_format($totalCompletado, 2) }}</h4>
                            </div>
                            <div class="kpi-icon" style="background:#f0fdf4;">
                                <svg width="18" height="18" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kpi-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1" style="font-size:0.72rem;">Pagos pendientes</p>
                                <h4 class="fw-bold mb-0">{{ $totalPendiente }}</h4>
                            </div>
                            <div class="kpi-icon" style="background:#fffbeb;">
                                <svg width="18" height="18" fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('recepcionista.pagos.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <select name="estado" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="completado"  {{ request('estado') === 'completado'  ? 'selected' : '' }}>Completado</option>
                        <option value="pendiente"   {{ request('estado') === 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="fallido"     {{ request('estado') === 'fallido'     ? 'selected' : '' }}>Fallido</option>
                        <option value="reembolsado" {{ request('estado') === 'reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                    <select name="metodo_pago" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los métodos</option>
                        <option value="efectivo" {{ request('metodo_pago') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="stripe"   {{ request('metodo_pago') === 'stripe'   ? 'selected' : '' }}>Stripe</option>
                        <option value="paypal"   {{ request('metodo_pago') === 'paypal'   ? 'selected' : '' }}>PayPal</option>
                        <option value="qr"       {{ request('metodo_pago') === 'qr'       ? 'selected' : '' }}>QR</option>
                    </select>
                    <select name="paciente_id" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los pacientes</option>
                        @foreach($pacientes as $p)
                            <option value="{{ $p->id }}" {{ request('paciente_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                        @endforeach
                    </select>
                    @if(request()->hasAny(['estado','metodo_pago','paciente_id']))
                        <a href="{{ route('recepcionista.pagos.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Factura</th>
                            <th>Fecha</th>
                            <th>Paciente</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagos as $pago)
                        <tr>
                            <td class="text-muted" style="font-family:monospace;font-size:0.72rem;">{{ $pago->numero_factura ?? '—' }}</td>
                            <td class="text-muted small">{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y H:i') : $pago->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="fw-semibold small">{{ $pago->paciente->user->name }}</div>
                                @if($pago->beneficio_premium)
                                    <span class="badge" style="background:#fef9c3;color:#92400e;font-size:0.65rem;">★ Premio</span>
                                @endif
                                @if($pago->descuento_porcentaje > 0)
                                    <span class="badge" style="background:#dcfce7;color:#166534;font-size:0.65rem;">-{{ $pago->descuento_porcentaje }}%</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $pago->concepto }}</td>
                            <td>
                                <div class="fw-bold small">${{ number_format($pago->monto, 2) }}</div>
                                @if($pago->monto_original && $pago->monto_original != $pago->monto)
                                    <div class="text-muted" style="font-size:0.68rem;text-decoration:line-through;">${{ number_format($pago->monto_original, 2) }}</div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $metStyles = ['efectivo'=>'background:#EFF6FF;color:#2563EB','stripe'=>'background:#eff6ff;color:#1d4ed8','paypal'=>'background:#eef2ff;color:#4338ca','qr'=>'background:#f0fdf4;color:#166534'];
                                @endphp
                                <span class="badge" style="{{ $metStyles[$pago->metodo_pago] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ strtoupper($pago->metodo_pago) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $estStyles = ['completado'=>'background:#f0fdf4;color:#14532d','pendiente'=>'background:#fffbeb;color:#92400e','fallido'=>'background:#fef2f2;color:#991b1b','reembolsado'=>'background:#faf5ff;color:#5b21b6'];
                                @endphp
                                <span class="badge" style="{{ $estStyles[$pago->estado] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ ucfirst($pago->estado) }}
                                </span>
                            </td>
                            <td>
                                @if($pago->numero_factura && $pago->estado === 'completado')
                                <a href="{{ route('recepcionista.pagos.factura', $pago) }}" class="crud-btn crud-btn-view" title="Descargar Factura PDF">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                                </a>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No se encontraron pagos con los filtros aplicados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($pagos->hasPages())
                <div class="px-4 py-3 border-top">{{ $pagos->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
