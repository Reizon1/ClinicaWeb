<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suscripciones Premium – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">
    @include('partials.admin-sidebar', ['activeSection' => 'suscripciones'])
    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Suscripciones Premium</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Gestión de membresías activas y vencidas</p>
            </div>
            <a href="{{ route('admin.suscripciones.create') }}" class="btn btn-sm fw-semibold text-white d-flex align-items-center gap-1" style="background:#7c3aed;">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Suscripción
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            {{-- KPI Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="kpi-card text-white" style="background:linear-gradient(135deg,#7c3aed,#a855f7);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 opacity-75" style="font-size:0.72rem;">Suscripciones activas</p>
                                <h4 class="fw-bold mb-0">{{ $totalActivas }}</h4>
                            </div>
                            <div class="kpi-icon" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card text-white" style="background:linear-gradient(135deg,#6b7280,#9ca3af);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 opacity-75" style="font-size:0.72rem;">Vencidas</p>
                                <h4 class="fw-bold mb-0">{{ $totalVencidas }}</h4>
                            </div>
                            <div class="kpi-icon" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card text-white" style="background:linear-gradient(135deg,#059669,#0d9488);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 opacity-75" style="font-size:0.72rem;">Ingresos activos</p>
                                <h4 class="fw-bold mb-0">${{ number_format($totalRecaudado, 2) }}</h4>
                            </div>
                            <div class="kpi-icon" style="background:rgba(255,255,255,0.2);">
                                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtro --}}
            <form method="GET" action="{{ route('admin.suscripciones.index') }}" class="app-card p-3 mb-3 d-flex gap-2 align-items-center">
                <select name="estado" class="form-select form-select-sm" style="width:auto;">
                    <option value="">Todos los estados</option>
                    <option value="activa"    {{ request('estado') === 'activa'    ? 'selected' : '' }}>Activas</option>
                    <option value="vencida"   {{ request('estado') === 'vencida'   ? 'selected' : '' }}>Vencidas</option>
                    <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Canceladas</option>
                </select>
                <button type="submit" class="btn btn-sm fw-semibold text-white" style="background:#7c3aed;">Filtrar</button>
                <a href="{{ route('admin.suscripciones.index') }}" class="text-muted small">Limpiar</a>
            </form>

            {{-- Tabla --}}
            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Plan</th>
                            <th>Precio</th>
                            <th>Inicio</th>
                            <th>Vencimiento</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suscripciones as $s)
                        @php
                            $estStyles = ['activa'=>'background:#f0fdf4;color:#14532d','vencida'=>'background:#f3f4f6;color:#374151','cancelada'=>'background:#fef2f2;color:#991b1b'];
                        @endphp
                        <tr>
                            <td class="fw-semibold small">{{ $s->paciente->user->name }}</td>
                            <td>
                                <span class="d-flex align-items-center gap-1 fw-semibold" style="color:#7c3aed;font-size:0.75rem;">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    {{ ucfirst($s->plan) }}
                                </span>
                            </td>
                            <td class="fw-bold small">${{ number_format($s->precio, 2) }}/mes</td>
                            <td class="text-muted small">{{ $s->fecha_inicio->format('d/m/Y') }}</td>
                            <td class="text-muted small">{{ $s->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td class="text-muted small text-capitalize">{{ $s->metodo_pago }}</td>
                            <td>
                                <span class="badge" style="{{ $estStyles[$s->estado] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ ucfirst($s->estado) }}
                                </span>
                            </td>
                            <td>
                                @if($s->estado === 'activa')
                                <form method="POST" action="{{ route('admin.suscripciones.destroy', $s) }}"
                                      onsubmit="return confirm('¿Cancelar esta suscripción?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm p-0 text-danger fw-semibold" style="font-size:0.75rem;">Cancelar</button>
                                </form>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No hay suscripciones registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($suscripciones->hasPages())
                <div class="px-4 py-3 border-top">{{ $suscripciones->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
