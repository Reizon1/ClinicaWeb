<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recetas Médicas – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'recetas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Recetas Médicas</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Historial de recetas emitidas · {{ $recetas->total() }} registros</p>
            </div>
            <a href="{{ route('recetas.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Receta
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('recetas.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="position-relative flex-grow-1" style="min-width:180px;">
                        <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);" width="14" height="14" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar paciente..." class="form-control form-control-sm ps-4">
                    </div>
                    <select name="estado" onchange="this.form.submit()" class="form-select form-select-sm" style="width:auto;">
                        <option value="">Todos los estados</option>
                        <option value="vigente" {{ request('estado')==='vigente'?'selected':'' }}>Vigentes</option>
                        <option value="vencida" {{ request('estado')==='vencida'?'selected':'' }}>Vencidas</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                    @if(request()->hasAny(['buscar','estado']))
                        <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
                    @endif
                </div>
            </form>

            <div class="app-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table app-table mb-0">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Medicamentos</th>
                                <th>Emisión</th>
                                <th>Vencimiento</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recetas as $r)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary text-white" style="width:32px;height:32px;font-size:0.75rem;">
                                            {{ strtoupper(substr($r->paciente->user->name,0,1)) }}
                                        </div>
                                        <span class="fw-medium">{{ $r->paciente->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted">{{ count($r->medicamentos) }} medicamento(s)</div>
                                    <div class="text-muted small">{{ collect($r->medicamentos)->pluck('nombre')->take(2)->implode(', ') }}{{ count($r->medicamentos) > 2 ? '...' : '' }}</div>
                                </td>
                                <td class="text-muted text-nowrap">{{ $r->fecha_emision->format('d/m/Y') }}</td>
                                <td class="text-nowrap">
                                    <span class="{{ $r->fecha_vencimiento->isPast() ? 'text-danger' : 'text-success' }} fw-medium">
                                        {{ $r->fecha_vencimiento->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if($r->fecha_vencimiento->isPast())
                                        <span class="badge rounded-pill fw-semibold" style="background:#fee2e2;color:#b91c1c;">Vencida</span>
                                    @else
                                        <span class="badge rounded-pill fw-semibold" style="background:#dcfce7;color:#15803d;">Vigente</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('recetas.show', $r) }}" class="btn btn-link btn-sm p-0 text-muted">Ver</a>
                                        <a href="{{ route('recetas.edit', $r) }}" class="btn btn-link btn-sm p-0 text-primary">Editar</a>
                                        <button onclick="abrirModalReceta('{{ route('recetas.destroy', $r) }}','{{ addslashes($r->paciente->user->name) }}')"
                                                class="btn btn-link btn-sm p-0 text-danger">Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">
                                @if(request()->hasAny(['buscar','estado']))
                                    No se encontraron recetas con los filtros aplicados.
                                @else
                                    No hay recetas emitidas aún.
                                @endif
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($recetas->hasPages())
                <div class="px-4 py-3 border-top">{{ $recetas->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal eliminación --}}
<div class="modal fade" id="modalReceta" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar-circle bg-danger bg-opacity-10 text-danger flex-shrink-0" style="width:44px;height:44px;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">¿Eliminar receta?</h6>
                        <p class="text-muted small mb-0">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <p class="small text-muted mb-4">Se eliminará la receta de <strong id="nombrePacReceta"></strong>.</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                    <button onclick="confirmarEliminarReceta()" class="btn btn-danger flex-grow-1">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="formReceta" method="POST">@csrf @method('DELETE')</form>

<script>
let urlReceta = '';
function abrirModalReceta(url, nombre) {
    urlReceta = url;
    document.getElementById('nombrePacReceta').textContent = nombre;
    new BSLib.Modal(document.getElementById('modalReceta')).show();
}
function confirmarEliminarReceta() {
    document.getElementById('formReceta').action = urlReceta;
    document.getElementById('formReceta').submit();
}
</script>
</body>
</html>
