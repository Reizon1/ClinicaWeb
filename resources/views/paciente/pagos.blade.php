<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Pagos – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.paciente-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">

        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="kpi-icon" style="background:#ccfbf1;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#0f766e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Mis Pagos</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Estado de tus pagos y facturas</p>
                </div>
            </div>
        </header>

        <main class="flex-grow-1" style="overflow-y:auto;">

            {{-- Hero KPIs --}}
            <div class="px-4 py-4" style="background:linear-gradient(135deg,#0f766e,#0d9488,#0891b2);position:relative;overflow:hidden;">
                <div style="position:absolute;top:-30px;right:-30px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.08);pointer-events:none;"></div>
                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(204,251,241,0.8);text-transform:uppercase;letter-spacing:0.08em;">Pagos Pendientes</div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $pagosPendientes->count() }}</div>
                            <div style="font-size:0.82rem;color:rgba(204,251,241,0.9);">${{ number_format($pagosPendientes->sum('monto'), 2) }} por pagar</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(204,251,241,0.8);text-transform:uppercase;letter-spacing:0.08em;">Total Pagado</div>
                            <div class="fw-bold" style="font-size:1.75rem;">${{ number_format($totalPagado, 2) }}</div>
                            <div style="font-size:0.82rem;color:rgba(204,251,241,0.9);">Historial completo</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(204,251,241,0.8);text-transform:uppercase;letter-spacing:0.08em;">Total Facturas</div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $pagosPendientes->count() + $pagosCompletados->total() }}</div>
                            <div style="font-size:0.82rem;color:rgba(204,251,241,0.9);">En tu cuenta</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4">

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Pagos pendientes --}}
                @if($pagosPendientes->isNotEmpty())
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <div style="width:4px;height:18px;background:#dc2626;border-radius:4px;"></div>
                        Pagos Pendientes
                        <span class="badge badge-pendiente">{{ $pagosPendientes->count() }}</span>
                    </h6>
                    <div class="row g-3">
                        @foreach($pagosPendientes as $pago)
                        <div class="col-md-6 col-xl-4">
                            <div class="app-card p-3" style="border-left:3px solid #f59e0b;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="fw-semibold" style="font-size:0.85rem;">{{ $pago->concepto }}</div>
                                    <span class="badge badge-pendiente">Pendiente</span>
                                </div>
                                @if($pago->cita)
                                <div class="text-muted small mb-2">
                                    Dr. {{ $pago->cita->medico->user->name }} · {{ $pago->cita->especialidad->nombre }}
                                </div>
                                @endif
                                <div class="fw-bold text-danger" style="font-size:1.3rem;">${{ number_format($pago->monto, 2) }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">Generado el {{ $pago->created_at->format('d M, Y') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Historial de pagos --}}
                <div class="app-card overflow-hidden">
                    <div class="app-card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:4px;height:20px;background:#0d9488;border-radius:4px;"></div>
                            <span>Historial de Pagos</span>
                        </div>
                        <span class="badge bg-light text-muted">{{ $pagosCompletados->total() }} registros</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table app-table mb-0">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Consulta</th>
                                    <th>Monto</th>
                                    <th>Método</th>
                                    <th>Fecha Pago</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pagosCompletados as $pago)
                                <tr>
                                    <td class="fw-medium">{{ $pago->concepto }}</td>
                                    <td class="text-muted">
                                        @if($pago->cita)
                                            Dr. {{ $pago->cita->medico->user->name }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">${{ number_format($pago->monto, 2) }}</td>
                                    <td>
                                        @php
                                            $metodoBadge = [
                                                'efectivo' => ['bg' => '#d1fae5','color' => '#065f46'],
                                                'stripe'   => ['bg' => '#dbeafe','color' => '#1e40af'],
                                                'paypal'   => ['bg' => '#fef3c7','color' => '#92400e'],
                                            ];
                                            $m = $metodoBadge[$pago->metodo_pago] ?? ['bg' => '#f3f4f6','color' => '#374151'];
                                        @endphp
                                        <span class="badge rounded-pill fw-semibold"
                                              style="background:{{ $m['bg'] }};color:{{ $m['color'] }};font-size:0.7rem;">
                                            {{ ucfirst($pago->metodo_pago) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $pago->fecha_pago ? $pago->fecha_pago->format('d M, Y') : '—' }}
                                    </td>
                                    <td>
                                        @php
                                            $estadoBadge = [
                                                'completado'  => 'badge-confirmada',
                                                'fallido'     => 'badge-cancelada',
                                                'reembolsado' => 'badge-completada',
                                            ];
                                        @endphp
                                        <span class="badge rounded-pill fw-semibold {{ $estadoBadge[$pago->estado] ?? 'badge-pendiente' }}">
                                            {{ ucfirst($pago->estado) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No hay pagos en el historial.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($pagosCompletados->hasPages())
                    <div class="px-4 py-3 border-top">
                        {{ $pagosCompletados->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
