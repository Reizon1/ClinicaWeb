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

    @if(auth()->user()->rol === 'admin')
        @include('partials.admin-sidebar', ['activeSection' => 'pagos'])
    @else
        @include('partials.recepcionista-sidebar', ['activeSection' => 'pagos'])
    @endif

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Gestión de Pagos</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Aprobación y seguimiento de todos los pagos</p>
            </div>
            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('admin.config.qr.show') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3h6v6H3zM15 3h6v6h-6zM3 15h6v6H3zM11 11h2v2h-2zM13 13h2v2h-2zM11 15h2v2h-2zM15 11h2v2h-2zM17 13h2v2h-2zM15 15h4v4h-4z"/></svg>
                Configurar QR
            </a>
            @endif
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- KPIs --}}
            <div class="row g-3 mb-4">
                @php
                    $kpis = [
                        ['label' => 'Pendientes',  'value' => $totalPendiente, 'color' => '#f59e0b', 'bg' => '#fffbeb'],
                        ['label' => 'Aprobados',   'value' => $totalAprobado,  'color' => '#22c55e', 'bg' => '#f0fdf4'],
                        ['label' => 'Rechazados',  'value' => $totalRechazado, 'color' => '#ef4444', 'bg' => '#fef2f2'],
                    ];
                @endphp
                @foreach($kpis as $k)
                <div class="col-4">
                    <div class="app-card p-3 text-center">
                        <div class="fw-bold mb-1" style="font-size:1.8rem;color:{{ $k['color'] }};">{{ $k['value'] }}</div>
                        <div class="text-muted small">{{ $k['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.pagos.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <div class="input-group input-group-sm" style="max-width:220px;">
                        <span class="input-group-text bg-white">
                            <svg width="12" height="12" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar paciente..." class="form-control">
                    </div>
                    <select name="estado" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente"  {{ request('estado') === 'pendiente'  ? 'selected':'' }}>Pendiente</option>
                        <option value="aprobado"   {{ request('estado') === 'aprobado'   ? 'selected':'' }}>Aprobado</option>
                        <option value="rechazado"  {{ request('estado') === 'rechazado'  ? 'selected':'' }}>Rechazado</option>
                        <option value="completado" {{ request('estado') === 'completado' ? 'selected':'' }}>Completado</option>
                    </select>
                    <select name="metodo_pago" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los métodos</option>
                        <option value="qr"      {{ request('metodo_pago') === 'qr'      ? 'selected':'' }}>QR</option>
                        <option value="tarjeta" {{ request('metodo_pago') === 'tarjeta' ? 'selected':'' }}>Tarjeta</option>
                        <option value="fisico"  {{ request('metodo_pago') === 'fisico'  ? 'selected':'' }}>Físico</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Filtrar</button>
                    @if(request()->hasAny(['buscar','estado','metodo_pago']))
                        <a href="{{ route('admin.pagos.index') }}" class="text-muted small">Limpiar</a>
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
                        @php
                            $metColors = [
                                'qr'       => 'background:#f0fdf4;color:#166534',
                                'tarjeta'  => 'background:#eff6ff;color:#1d4ed8',
                                'fisico'   => 'background:#f5f3ff;color:#5b21b6',
                                'efectivo' => 'background:#eff6ff;color:#2563eb',
                                'stripe'   => 'background:#eff6ff;color:#1d4ed8',
                                'paypal'   => 'background:#eef2ff;color:#4338ca',
                            ];
                            $estColors = [
                                'pendiente'  => 'background:#fffbeb;color:#92400e',
                                'aprobado'   => 'background:#f0fdf4;color:#14532d',
                                'rechazado'  => 'background:#fef2f2;color:#991b1b',
                                'completado' => 'background:#f0fdf4;color:#14532d',
                                'fallido'    => 'background:#fef2f2;color:#991b1b',
                                'reembolsado'=> 'background:#faf5ff;color:#5b21b6',
                            ];
                        @endphp
                        @forelse($pagos as $pago)
                        <tr>
                            <td style="font-family:monospace;font-size:0.72rem;">{{ $pago->numero_factura ?? '—' }}</td>
                            <td class="text-muted small text-nowrap">
                                {{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y H:i') : $pago->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle fw-bold flex-shrink-0"
                                         style="width:28px;height:28px;font-size:0.65rem;background:#dbeafe;color:#1d4ed8;">
                                        {{ strtoupper(substr($pago->paciente->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $pago->paciente->user->name }}</div>
                                        @if($pago->comprobante_path)
                                            <a href="{{ Storage::url($pago->comprobante_path) }}" target="_blank"
                                               class="d-flex align-items-center gap-1 text-success" style="font-size:0.65rem;">
                                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                                Ver comprobante
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $pago->concepto }}</td>
                            <td class="fw-bold small">${{ number_format($pago->monto, 2) }}</td>
                            <td>
                                <span class="badge" style="{{ $metColors[$pago->metodo_pago] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ strtoupper($pago->metodo_pago) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge" style="{{ $estColors[$pago->estado] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ ucfirst($pago->estado) }}
                                </span>
                            </td>
                            <td>
                                @if($pago->estado === 'pendiente')
                                <div class="d-flex gap-1">
                                    <form method="POST" action="{{ route('admin.pagos.update-status', $pago) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="accion" value="aprobado">
                                        <button type="submit" class="btn btn-success btn-sm fw-semibold d-flex align-items-center gap-1" title="Aprobar">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Aprobar
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pagos.update-status', $pago) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="accion" value="rechazado">
                                        <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold d-flex align-items-center gap-1" title="Rechazar">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18" stroke-width="2.5"/><line x1="6" y1="6" x2="18" y2="18" stroke-width="2.5"/></svg>
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No se encontraron pagos con los filtros aplicados.</td>
                        </tr>
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
