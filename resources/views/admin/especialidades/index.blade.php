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

            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Médicos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($especialidades as $esp)
                        <tr>
                            <td class="fw-semibold small">{{ $esp->nombre }}</td>
                            <td class="text-muted small" style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $esp->descripcion ?? '—' }}</td>
                            <td>
                                <span class="badge" style="background:#dbeafe;color:#1d4ed8;">{{ $esp->medicos_count }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $esp->activa ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $esp->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <a href="{{ route('admin.especialidades.edit', $esp) }}" class="text-primary fw-semibold" style="font-size:0.75rem;">Editar</a>
                                    @if($esp->medicos_count === 0)
                                        <button onclick="abrirModal('{{ route('admin.especialidades.destroy', $esp) }}', '{{ addslashes($esp->nombre) }}')"
                                                class="btn btn-link btn-sm p-0 text-danger fw-semibold" style="font-size:0.75rem;">Eliminar</button>
                                    @else
                                        <span class="text-muted" style="font-size:0.72rem;" title="Tiene médicos asignados">No eliminable</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No hay especialidades registradas.</td></tr>
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

<div class="modal fade" id="modalElim" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:#fee2e2;">
                        <svg width="18" height="18" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">¿Eliminar especialidad?</h6>
                        <p class="text-muted mb-0" style="font-size:0.75rem;">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <p class="small text-muted mb-4">Se eliminará permanentemente <strong id="nombreEsp" class="text-dark"></strong>.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1 btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="confirmar()" class="btn btn-danger flex-grow-1 btn-sm fw-semibold">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="formElim" method="POST">@csrf @method('DELETE')</form>

<script>
let urlElim = '';
function abrirModal(url, nombre) {
    urlElim = url;
    document.getElementById('nombreEsp').textContent = nombre;
    new BSLib.Modal(document.getElementById('modalElim')).show();
}
function confirmar() {
    document.getElementById('formElim').action = urlElim;
    document.getElementById('formElim').submit();
}
</script>
</body>
</html>
