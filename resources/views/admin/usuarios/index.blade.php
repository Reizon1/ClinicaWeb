<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'usuarios'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Gestión de Usuarios</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Administrá los roles y accesos del sistema</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-muted border">{{ $usuarios->total() }} usuarios en total</span>
                <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Usuario
                </a>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.usuarios.index') }}" id="filtroForm" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                        <span class="input-group-text bg-white">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o correo..." class="form-control">
                    </div>
                    <select name="filtro_rol" onchange="document.getElementById('filtroForm').submit()"
                            class="form-select form-select-sm" style="width:auto;">
                        <option value="">Todos los roles</option>
                        <option value="admin"         {{ request('filtro_rol')==='admin'         ?'selected':'' }}>Administrador</option>
                        <option value="medico"        {{ request('filtro_rol')==='medico'        ?'selected':'' }}>Médico</option>
                        <option value="recepcionista" {{ request('filtro_rol')==='recepcionista' ?'selected':'' }}>Recepcionista</option>
                        <option value="paciente"      {{ request('filtro_rol')==='paciente'      ?'selected':'' }}>Paciente</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Filtrar</button>
                    @if(request()->hasAny(['buscar','filtro_rol']))
                        <a href="{{ route('admin.usuarios.index') }}" class="text-muted small">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Rol Actual</th>
                            <th>Registrado</th>
                            <th>Cambiar Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rolStyles = ['admin'=>'background:#f3e8ff;color:#6d28d9','medico'=>'background:#dbeafe;color:#1d4ed8','recepcionista'=>'background:#ccfbf1;color:#0f766e','paciente'=>'background:#f3f4f6;color:#374151'];
                            $rolLabels = ['admin'=>'Administrador','medico'=>'Médico','recepcionista'=>'Recepcionista','paciente'=>'Paciente'];
                        @endphp
                        @forelse($usuarios as $usuario)
                        <tr class="{{ $usuario->id === auth()->id() ? 'table-primary' : '' }}">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle fw-bold text-white flex-shrink-0" style="width:32px;height:32px;font-size:0.7rem;background:linear-gradient(135deg,#3b82f6,#2563eb);">
                                        {{ strtoupper(substr($usuario->name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small d-flex align-items-center gap-1">
                                            {{ $usuario->name }}
                                            @if($usuario->id === auth()->id())
                                                <span class="text-primary" style="font-size:0.7rem;">(tú)</span>
                                            @endif
                                        </div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $usuario->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="{{ $rolStyles[$usuario->rol] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ $rolLabels[$usuario->rol] ?? $usuario->rol }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $usuario->created_at->format('d M Y') }}</td>
                            <td>
                                @if($usuario->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.usuarios.rol', $usuario) }}">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="rol" class="form-select form-select-sm" style="width:auto;">
                                            <option value="admin"         {{ $usuario->rol==='admin'         ?'selected':'' }}>Administrador</option>
                                            <option value="medico"        {{ $usuario->rol==='medico'        ?'selected':'' }}>Médico</option>
                                            <option value="recepcionista" {{ $usuario->rol==='recepcionista' ?'selected':'' }}>Recepcionista</option>
                                            <option value="paciente"      {{ $usuario->rol==='paciente'      ?'selected':'' }}>Paciente</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm fw-semibold">Guardar</button>
                                    </div>
                                </form>
                                @else
                                    <span class="text-muted small fst-italic">No editable</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <a href="{{ route('admin.usuarios.show', $usuario) }}" class="text-muted fw-semibold" style="font-size:0.75rem;">Ver</a>
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="text-primary fw-semibold" style="font-size:0.75rem;">Editar</a>
                                    @if($usuario->id !== auth()->id())
                                        <button onclick="abrirModalUsuario('{{ route('admin.usuarios.destroy', $usuario) }}', '{{ addslashes($usuario->name) }}')"
                                                class="btn btn-link btn-sm p-0 text-danger fw-semibold" style="font-size:0.75rem;">Eliminar</button>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No se encontraron usuarios con los filtros aplicados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($usuarios->hasPages())
                <div class="px-4 py-3 border-top">{{ $usuarios->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:#fee2e2;">
                        <svg width="18" height="18" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">¿Eliminar usuario?</h6>
                        <p class="text-muted mb-0" style="font-size:0.75rem;">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <p class="small text-muted mb-4">Se eliminará permanentemente la cuenta de <strong id="nombreUsuario" class="text-dark"></strong>.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="confirmarEliminarUsuario()" class="btn btn-danger flex-grow-1 btn-sm fw-semibold">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="formUsuario" method="POST">@csrf @method('DELETE')</form>

<script>
let urlUsuario = '';
function abrirModalUsuario(url, nombre) {
    urlUsuario = url;
    document.getElementById('nombreUsuario').textContent = nombre;
    new BSLib.Modal(document.getElementById('modalUsuario')).show();
}
function confirmarEliminarUsuario() {
    document.getElementById('formUsuario').action = urlUsuario;
    document.getElementById('formUsuario').submit();
}
</script>
</body>
</html>
