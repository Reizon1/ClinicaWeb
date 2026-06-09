<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médicos – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'medicos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Gestión de Médicos</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Alta, edición, consulta y baja de médicos del sistema</p>
            </div>
            <a href="{{ route('admin.medicos.create') }}" class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Médico
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
                <div class="alert alert-danger mb-3">
                    @foreach($errors->all() as $e)<p class="mb-0">• {{ $e }}</p>@endforeach
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.medicos.index') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                        <span class="input-group-text bg-white">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o correo..." class="form-control">
                    </div>
                    <select name="especialidad_id" class="form-select form-select-sm" style="width:auto;">
                        <option value="">Todas las especialidades</option>
                        @foreach($especialidades as $e)
                            <option value="{{ $e->id }}" {{ request('especialidad_id')==$e->id?'selected':'' }}>{{ $e->nombre }}</option>
                        @endforeach
                    </select>
                    <select name="disponible" class="form-select form-select-sm" style="width:auto;">
                        <option value="">Todos los estados</option>
                        <option value="1" {{ request('disponible')==='1'?'selected':'' }}>Disponible</option>
                        <option value="0" {{ request('disponible')==='0'?'selected':'' }}>Inactivo</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Filtrar</button>
                    @if(request()->hasAny(['buscar','especialidad_id','disponible']))
                        <a href="{{ route('admin.medicos.index') }}" class="text-muted small">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Licencia</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicos as $medico)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle fw-bold flex-shrink-0" style="width:32px;height:32px;font-size:0.7rem;background:#dbeafe;color:#1d4ed8;">
                                        {{ strtoupper(substr($medico->user->name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $medico->user->name }}</div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $medico->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $medico->especialidad->nombre }}</td>
                            <td class="text-muted" style="font-family:monospace;font-size:0.75rem;">{{ $medico->numero_licencia }}</td>
                            <td>
                                <span class="badge {{ $medico->disponible ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $medico->disponible ? 'Disponible' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <a href="{{ route('admin.medicos.show', $medico) }}" class="text-muted fw-semibold" style="font-size:0.75rem;">Ver</a>
                                    <a href="{{ route('admin.medicos.edit', $medico) }}" class="text-primary fw-semibold" style="font-size:0.75rem;">Editar</a>
                                    <button onclick="abrirModalEliminar('{{ route('admin.medicos.destroy', $medico) }}', '{{ addslashes($medico->user->name) }}')"
                                            class="btn btn-link btn-sm p-0 text-danger fw-semibold" style="font-size:0.75rem;">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-5">No se encontraron médicos con los filtros aplicados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($medicos->hasPages())
                <div class="px-4 py-3 border-top">{{ $medicos->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal de eliminación --}}
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:#fee2e2;">
                        <svg width="18" height="18" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">¿Eliminar médico?</h6>
                        <p class="text-muted mb-0" style="font-size:0.75rem;">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <p class="small text-muted mb-4">Se eliminará permanentemente la cuenta y todos los datos de <strong id="nombreMedico" class="text-dark"></strong>.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="confirmarEliminar()" class="btn btn-danger flex-grow-1 btn-sm fw-semibold">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="formEliminar" method="POST">@csrf @method('DELETE')</form>

<script>
let urlEliminar = '';
function abrirModalEliminar(url, nombre) {
    urlEliminar = url;
    document.getElementById('nombreMedico').textContent = nombre;
    new BSLib.Modal(document.getElementById('modalEliminar')).show();
}
function confirmarEliminar() {
    document.getElementById('formEliminar').action = urlEliminar;
    document.getElementById('formEliminar').submit();
}
</script>
</body>
</html>
