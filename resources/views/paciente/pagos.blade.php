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
                <div class="kpi-icon" style="background:#EFF6FF;width:36px;height:36px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:0.95rem;">Mis Pagos</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">Estado de tus pagos y facturas</p>
                </div>
            </div>
        </header>

        <main class="flex-grow-1" style="overflow-y:auto;">

            {{-- Hero KPIs --}}
            <div class="px-4 py-4" style="background:linear-gradient(135deg,#1d4ed8,#2563EB,#0284c7);position:relative;overflow:hidden;">
                <div style="position:absolute;top:-30px;right:-30px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.08);pointer-events:none;"></div>
                <div class="row g-3">
                    <div class="col-sm-3">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(191,219,254,0.8);text-transform:uppercase;letter-spacing:0.08em;">Pago anticipado</div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $citasProximas->count() }}</div>
                            <div style="font-size:0.82rem;color:rgba(191,219,254,0.9);">Citas próximas</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(191,219,254,0.8);text-transform:uppercase;letter-spacing:0.08em;">Por pagar</div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $citasSinPago->count() }}</div>
                            <div style="font-size:0.82rem;color:rgba(191,219,254,0.9);">Consultas completadas</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(191,219,254,0.8);text-transform:uppercase;letter-spacing:0.08em;">En revisión</div>
                            <div class="fw-bold" style="font-size:1.75rem;">{{ $pagosEnRevision->count() }}</div>
                            <div style="font-size:0.82rem;color:rgba(191,219,254,0.9);">Pendientes de aprobación</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-white">
                            <div style="font-size:0.7rem;color:rgba(191,219,254,0.8);text-transform:uppercase;letter-spacing:0.08em;">Total pagado</div>
                            <div class="fw-bold" style="font-size:1.75rem;">${{ number_format($totalPagado, 2) }}</div>
                            <div style="font-size:0.82rem;color:rgba(191,219,254,0.9);">Historial completo</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 d-flex flex-column gap-4">

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info d-flex align-items-center gap-2">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('info') }}
                    </div>
                @endif

                {{-- ── SECCIÓN 1: Pago anticipado (citas próximas) ─────────────── --}}
                @if($citasProximas->isNotEmpty())
                <div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:4px;height:18px;background:#0891b2;border-radius:4px;"></div>
                        <h6 class="fw-bold mb-0">Pago anticipado</h6>
                        <span class="badge" style="background:#cffafe;color:#164e63;">{{ $citasProximas->count() }}</span>
                        <span class="text-muted small">· Pagá antes de tu consulta</span>
                    </div>
                    <div class="row g-3">
                        @foreach($citasProximas as $cita)
                        <div class="col-md-6 col-xl-4">
                            <div class="app-card p-3 h-100 d-flex flex-column" style="border-left:3px solid #0891b2;">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <div class="fw-semibold small">{{ $cita->especialidad->nombre }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">Dr. {{ $cita->medico->user->name }}</div>
                                    </div>
                                    @if($cita->estado === 'confirmada')
                                        <span class="badge badge-confirmada flex-shrink-0">Confirmada</span>
                                    @else
                                        <span class="badge badge-pendiente flex-shrink-0">Pendiente</span>
                                    @endif
                                </div>

                                {{-- Cuenta regresiva --}}
                                @php
                                    $diasRestantes = (int) now()->startOfDay()->diffInDays($cita->fecha_hora->startOfDay(), false);
                                @endphp
                                <div class="rounded-2 px-3 py-2 mb-3 d-flex align-items-center gap-2"
                                     style="background:#ecfeff;border:1px solid #a5f3fc;">
                                    <svg width="14" height="14" fill="none" stroke="#0891b2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.78rem;color:#0e7490;">
                                            {{ $cita->fecha_hora->format('d/m/Y H:i') }}
                                        </div>
                                        <div style="font-size:0.68rem;color:#0e7490;">
                                            @if($diasRestantes === 0)
                                                Hoy
                                            @elseif($diasRestantes === 1)
                                                Mañana
                                            @else
                                                En {{ $diasRestantes }} días
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <a href="{{ route('paciente.pago.checkout', $cita) }}"
                                       class="btn btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-2"
                                       style="background:#0891b2;color:#fff;border:none;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Pagar por adelantado
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ── SECCIÓN 2: Citas listas para pagar ──────────────────────── --}}
                @if($citasSinPago->isNotEmpty())
                <div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:4px;height:18px;background:#2563eb;border-radius:4px;"></div>
                        <h6 class="fw-bold mb-0">Consultas listas para pagar</h6>
                        <span class="badge" style="background:#dbeafe;color:#1d4ed8;">{{ $citasSinPago->count() }}</span>
                    </div>
                    <div class="row g-3">
                        @foreach($citasSinPago as $cita)
                        <div class="col-md-6 col-xl-4">
                            <div class="app-card p-3 h-100 d-flex flex-column" style="border-left:3px solid #2563eb;">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <div class="fw-semibold small">{{ $cita->especialidad->nombre }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">Dr. {{ $cita->medico->user->name }}</div>
                                    </div>
                                    <span class="badge badge-completada flex-shrink-0">Completada</span>
                                </div>
                                <div class="text-muted mb-3" style="font-size:0.75rem;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $cita->fecha_hora->format('d/m/Y H:i') }}
                                </div>
                                <div class="mt-auto">
                                    <a href="{{ route('paciente.pago.checkout', $cita) }}"
                                       class="btn btn-primary btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Pagar ahora
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ── SECCIÓN 2: Pagos en revisión ───────────────────────────── --}}
                @if($pagosEnRevision->isNotEmpty())
                <div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:4px;height:18px;background:#f59e0b;border-radius:4px;"></div>
                        <h6 class="fw-bold mb-0">En revisión</h6>
                        <span class="badge badge-pendiente">{{ $pagosEnRevision->count() }}</span>
                    </div>
                    <div class="row g-3">
                        @foreach($pagosEnRevision as $pago)
                        <div class="col-md-6 col-xl-4">
                            <div class="app-card p-3" style="border-left:3px solid #f59e0b;">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div class="fw-semibold small">{{ $pago->concepto }}</div>
                                    <span class="badge badge-pendiente flex-shrink-0">Pendiente</span>
                                </div>
                                @if($pago->cita)
                                <div class="text-muted small mb-1">Dr. {{ $pago->cita->medico->user->name }} · {{ $pago->cita->especialidad->nombre }}</div>
                                @endif
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <div class="fw-bold" style="font-size:1.2rem;">${{ number_format($pago->monto, 2) }}</div>
                                    @php
                                        $metColors = ['qr'=>'#f0fdf4;color:#166534','tarjeta'=>'#eff6ff;color:#1d4ed8','fisico'=>'#f5f3ff;color:#5b21b6'];
                                        $mc = $metColors[$pago->metodo_pago] ?? '#f3f4f6;color:#374151';
                                    @endphp
                                    <span class="badge" style="background:{{ $mc }}">
                                        {{ strtoupper($pago->metodo_pago) }}
                                    </span>
                                </div>
                                <div class="text-muted mt-1" style="font-size:0.7rem;">
                                    Enviado el {{ $pago->created_at->format('d M, Y H:i') }}
                                </div>
                                @if($pago->comprobante_path)
                                <a href="{{ Storage::url($pago->comprobante_path) }}" target="_blank"
                                   class="d-flex align-items-center gap-1 mt-1 text-success small">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    Ver comprobante subido
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Si no hay nada pendiente --}}
                @if($citasProximas->isEmpty() && $citasSinPago->isEmpty() && $pagosEnRevision->isEmpty())
                <div class="app-card p-4 text-center text-muted">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" class="mb-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="fw-semibold mb-1">Todo al día</p>
                    <p class="small mb-0">No tenés consultas pendientes de pago.</p>
                </div>
                @endif

                {{-- ── SECCIÓN 3: Historial de pagos ──────────────────────────── --}}
                <div class="app-card overflow-hidden">
                    <div class="app-card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:4px;height:20px;background:#2563EB;border-radius:4px;"></div>
                            <span class="fw-semibold">Historial de Pagos</span>
                        </div>
                        <span class="badge bg-light text-muted">{{ $pagosHistorial->total() }} registros</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table app-table mb-0">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Consulta</th>
                                    <th>Monto</th>
                                    <th>Método</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pagosHistorial as $pago)
                                <tr>
                                    <td class="fw-medium small">{{ $pago->concepto }}</td>
                                    <td class="text-muted small">
                                        @if($pago->cita)
                                            Dr. {{ $pago->cita->medico->user->name }}
                                        @else
                                            <span>—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold small">${{ number_format($pago->monto, 2) }}</td>
                                    <td>
                                        @php
                                            $metodoBadge = [
                                                'qr'       => ['bg' => '#dcfce7','color' => '#14532d'],
                                                'tarjeta'  => ['bg' => '#dbeafe','color' => '#1e40af'],
                                                'fisico'   => ['bg' => '#ede9fe','color' => '#5b21b6'],
                                                'efectivo' => ['bg' => '#d1fae5','color' => '#065f46'],
                                                'stripe'   => ['bg' => '#dbeafe','color' => '#1e40af'],
                                                'paypal'   => ['bg' => '#fef3c7','color' => '#92400e'],
                                            ];
                                            $mb = $metodoBadge[$pago->metodo_pago] ?? ['bg' => '#f3f4f6','color' => '#374151'];
                                        @endphp
                                        <span class="badge" style="background:{{ $mb['bg'] }};color:{{ $mb['color'] }};font-size:0.7rem;">
                                            {{ strtoupper($pago->metodo_pago) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : $pago->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @php
                                            $estadoBadge = [
                                                'aprobado'   => 'badge-completada',
                                                'completado' => 'badge-completada',
                                                'rechazado'  => 'badge-cancelada',
                                                'fallido'    => 'badge-cancelada',
                                                'reembolsado'=> 'badge-confirmada',
                                            ];
                                        @endphp
                                        <span class="badge {{ $estadoBadge[$pago->estado] ?? 'badge-pendiente' }}" style="font-size:0.7rem;">
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
                    @if($pagosHistorial->hasPages())
                    <div class="px-4 py-3 border-top">{{ $pagosHistorial->links('pagination::bootstrap-5') }}</div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
