<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagos QR – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'pagos-qr'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Pagos por QR</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Aprobación manual de pagos realizados por transferencia QR</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="row g-4 mb-4">
                {{-- KPIs --}}
                <div class="col-md-4">
                    <div class="kpi-card">
                        <p class="text-muted small mb-2">Pagos Pendientes QR</p>
                        <h4 class="fw-bold text-warning mb-0">{{ $pendientes }}</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card">
                        <p class="text-muted small mb-2">Pagos Aprobados QR</p>
                        <h4 class="fw-bold text-success mb-0">{{ $completados }}</h4>
                    </div>
                </div>
                {{-- QR Upload --}}
                <div class="col-md-4">
                    <div class="app-card p-3">
                        <p class="fw-semibold small mb-2">Código QR de Pago</p>
                        @if($qrImageUrl)
                            <img src="{{ $qrImageUrl }}" alt="QR Pago" class="img-fluid rounded mb-2" style="max-height:120px;border:1px solid #e5e7eb;">
                        @else
                            <div class="rounded mb-2 d-flex align-items-center justify-content-center text-muted" style="height:80px;background:#f9fafb;border:1px dashed #d1d5db;font-size:0.75rem;">Sin QR cargado</div>
                        @endif
                        <form method="POST" action="{{ route('admin.qr.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex gap-2">
                                <input type="file" name="qr_imagen" accept="image/*" class="form-control form-control-sm" required>
                                <button type="submit" class="btn btn-primary btn-sm fw-semibold text-nowrap">Subir QR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Filtro estado --}}
            <form method="GET" action="{{ route('admin.pagos.qr.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 align-items-center">
                    <select name="estado" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente"  {{ request('estado')==='pendiente'  ?'selected':'' }}>Pendientes</option>
                        <option value="completado" {{ request('estado')==='completado' ?'selected':'' }}>Aprobados</option>
                        <option value="fallido"    {{ request('estado')==='fallido'    ?'selected':'' }}>Rechazados</option>
                    </select>
                    @if(request('estado'))
                        <a href="{{ route('admin.pagos.qr.index') }}" class="text-muted small">Limpiar</a>
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
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagos as $pago)
                        <tr>
                            <td style="font-family:monospace;font-size:0.72rem;">{{ $pago->numero_factura ?? '—' }}</td>
                            <td class="text-muted small">{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="fw-semibold small">{{ $pago->paciente->user->name }}</div>
                                <div class="text-muted" style="font-size:0.68rem;">{{ $pago->paciente->user->email }}</div>
                            </td>
                            <td class="text-muted small">{{ $pago->concepto }}</td>
                            <td class="fw-bold">${{ number_format($pago->monto, 2) }}</td>
                            <td>
                                @php
                                    $estColors = [
                                        'pendiente'  => 'background:#fffbeb;color:#92400e',
                                        'completado' => 'background:#f0fdf4;color:#14532d',
                                        'fallido'    => 'background:#fef2f2;color:#991b1b',
                                    ];
                                @endphp
                                <span class="badge" style="{{ $estColors[$pago->estado] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ $pago->estado === 'completado' ? 'Aprobado' : ucfirst($pago->estado) }}
                                </span>
                            </td>
                            <td>
                                @if($pago->estado === 'pendiente')
                                <div class="d-flex gap-1">
                                    <form method="POST" action="{{ route('admin.pagos.qr.aprobar', $pago) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm fw-semibold d-flex align-items-center gap-1" title="Aprobar pago">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Aprobar
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pagos.qr.rechazar', $pago) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold d-flex align-items-center gap-1" title="Rechazar pago">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
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
                        <tr><td colspan="7" class="text-center text-muted py-5">No hay pagos QR registrados.</td></tr>
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
