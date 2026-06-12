<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Especialidades – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'especialidades'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Gestión de Especialidades</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Alta, edición y baja de especialidades médicas</p>
            </div>
            <a href="{{ route('admin.especialidades.create') }}" class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Especialidad
            </a>
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

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.especialidades.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                        <span class="input-group-text bg-white">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar especialidad..." class="form-control">
                    </div>
                    <select name="activa" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="1" {{ request('activa')==='1' ? 'selected' : '' }}>Activas</option>
                        <option value="0" {{ request('activa')==='0' ? 'selected' : '' }}>Inactivas</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Filtrar</button>
                    @if(request()->hasAny(['buscar','activa']))
                        <a href="{{ route('admin.especialidades.index') }}" class="text-muted small">Limpiar</a>
                    @endif
                </div>
            </form>

            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Médicos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($especialidades as $esp)
                        <tr>
                            <td class="fw-semibold small">{{ $esp->nombre }}</td>
                            <td class="text-muted small" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $esp->descripcion ?? '—' }}</td>
                            <td class="fw-semibold small" style="color:#15803d;">${{ number_format($esp->precio, 2) }}</td>
                            <td>
                                <span class="badge" style="background:#dbeafe;color:#1d4ed8;">{{ $esp->medicos_count }}</span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.especialidades.toggle', $esp) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="badge border-0 {{ $esp->activa ? 'bg-success' : 'bg-secondary' }}"
                                            style="cursor:pointer;font-size:0.72rem;" title="Clic para cambiar estado">
                                        {{ $esp->activa ? '✓ Activa' : '✗ Inactiva' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <a href="{{ route('admin.especialidades.show', $esp) }}" class="crud-btn crud-btn-view" title="Ver detalle">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.especialidades.edit', $esp) }}" class="crud-btn crud-btn-edit" title="Editar">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    @if($esp->medicos_count === 0)
                                        <button onclick="abrirModalEliminar('{{ route('admin.especialidades.destroy', $esp) }}', '{{ addslashes($esp->nombre) }}')"
                                                class="crud-btn crud-btn-delete" title="Eliminar especialidad">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    @else
                                        <button onclick="abrirModalBloqueado('{{ addslashes($esp->nombre) }}', {{ $esp->medicos_count }})"
                                                class="crud-btn crud-btn-delete" title="No se puede eliminar — tiene médicos">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay especialidades registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($especialidades->hasPages())
                <div class="px-4 py-3 border-top">{{ $especialidades->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal: confirmar eliminación (sin médicos) --}}
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:42px;height:42px;background:#fee2e2;">
                        <svg width="18" height="18" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">¿Eliminar especialidad?</h6>
                        <p class="text-muted mb-0" style="font-size:0.75rem;">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <p class="small text-muted mb-4">
                    Se eliminará permanentemente <strong id="nombreEspElim" class="text-dark"></strong>.
                </p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="confirmarEliminar()" class="btn btn-danger flex-grow-1 btn-sm fw-semibold">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: bloqueado (tiene médicos asignados) --}}
<div class="modal fade" id="modalBloqueado" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:42px;height:42px;background:#fef3c7;">
                        <svg width="18" height="18" fill="none" stroke="#d97706" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">No se puede eliminar</h6>
                        <p class="text-muted mb-0" style="font-size:0.75rem;">La especialidad tiene médicos registrados.</p>
                    </div>
                </div>

                <div class="rounded-3 p-3 mb-4" style="background:#fffbeb;border:1px solid #fde68a;">
                    <p class="small mb-1 fw-semibold" style="color:#92400e;">
                        <strong id="nombreEspBlq"></strong>
                    </p>
                    <p class="small mb-0" style="color:#92400e;">
                        Esta especialidad tiene <strong id="cantMedicos"></strong> médico(s) asignado(s).
                        Para eliminarla, primero reasigná o eliminá a esos médicos.
                    </p>
                </div>

                <button type="button" class="btn btn-warning w-100 btn-sm fw-semibold" data-bs-dismiss="modal">
                    Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<form id="formEliminar" method="POST">@csrf @method('DELETE')</form>

<script>
let urlEliminar = '';

function abrirModalEliminar(url, nombre) {
    urlEliminar = url;
    document.getElementById('nombreEspElim').textContent = nombre;
    new BSLib.Modal(document.getElementById('modalEliminar')).show();
}

function confirmarEliminar() {
    document.getElementById('formEliminar').action = urlEliminar;
    document.getElementById('formEliminar').submit();
}

function abrirModalBloqueado(nombre, cantMedicos) {
    document.getElementById('nombreEspBlq').textContent = nombre;
    document.getElementById('cantMedicos').textContent = cantMedicos;
    new BSLib.Modal(document.getElementById('modalBloqueado')).show();
}
</script>
</body>
</html>
