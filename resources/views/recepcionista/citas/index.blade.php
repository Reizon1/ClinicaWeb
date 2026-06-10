<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Citas – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'citas'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Gestión de Citas</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Agenda, reprogramá y cancelá citas médicas</p>
            </div>
            <a href="{{ route('recepcionista.citas.crear') }}" class="btn btn-sm fw-semibold text-white d-flex align-items-center gap-1" style="background:#0d9488;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Cita
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('recepcionista.citas') }}" class="app-card p-3 mb-3">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <div class="input-group input-group-sm" style="max-width:220px;">
                        <span class="input-group-text bg-white">
                            <svg width="12" height="12" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar paciente..." class="form-control">
                    </div>
                    <select name="estado" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente"  {{ request('estado')=='pendiente'  ?'selected':'' }}>Pendiente</option>
                        <option value="confirmada" {{ request('estado')=='confirmada' ?'selected':'' }}>Confirmada</option>
                        <option value="completada" {{ request('estado')=='completada' ?'selected':'' }}>Completada</option>
                        <option value="cancelada"  {{ request('estado')=='cancelada'  ?'selected':'' }}>Cancelada</option>
                    </select>
                    <select name="medico_id" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Todos los médicos</option>
                        @foreach($medicos as $m)
                            <option value="{{ $m->id }}" {{ request('medico_id')==$m->id?'selected':'' }}>Dr. {{ $m->user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm fw-semibold text-white" style="background:#0d9488;">Buscar</button>
                    @if(request()->hasAny(['buscar','estado','medico_id']))
                        <a href="{{ route('recepcionista.citas') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- Tabla --}}
            <div class="app-card overflow-hidden">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td class="fw-semibold">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                            <td>{{ $cita->paciente->user->name }}</td>
                            <td class="text-muted">Dr. {{ $cita->medico->user->name }}</td>
                            <td>
                                @php
                                    $badges = ['confirmada'=>'badge-confirmada','pendiente'=>'badge-pendiente','completada'=>'badge-completada','cancelada'=>'badge-cancelada'];
                                @endphp
                                <span class="badge {{ $badges[$cita->estado] ?? 'bg-secondary' }}">{{ ucfirst($cita->estado) }}</span>
                            </td>
                            <td>
                                @if(!in_array($cita->estado, ['completada', 'cancelada']))
                                <div class="d-flex gap-2 align-items-center">
                                    <button onclick="toggleReprog(this)" class="btn btn-link btn-sm p-0 text-primary fw-semibold" style="font-size:0.75rem;">Reprogramar</button>
                                    <button type="button"
                                            onclick="confirmarCancelarCita('{{ route('recepcionista.citas.cancelar', $cita) }}')"
                                            class="btn btn-link btn-sm p-0 text-danger fw-semibold" style="font-size:0.75rem;">Cancelar</button>
                                </div>
                                <form method="POST" action="{{ route('recepcionista.citas.reprogramar', $cita) }}" class="reprog-form d-none mt-2 d-flex gap-2">
                                    @csrf @method('PATCH')
                                    <input type="datetime-local" name="fecha_hora" required class="form-control form-control-sm" style="width:auto;">
                                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Guardar</button>
                                </form>
                                @elseif($cita->estado === 'completada')
                                    @if(!$cita->pago)
                                    <a href="{{ route('recepcionista.pagos.crear', $cita) }}"
                                       class="btn btn-sm fw-semibold text-white d-flex align-items-center gap-1" style="background:#0d9488;font-size:0.72rem;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Pagar
                                    </a>
                                    @else
                                    <span class="text-success fw-semibold d-flex align-items-center gap-1" style="font-size:0.75rem;">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Pagado
                                    </span>
                                    @endif
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No se encontraron citas con los filtros aplicados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($citas->hasPages())
                <div class="px-4 py-3 border-top">{{ $citas->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal cancelar cita --}}
<div class="modal fade" id="modalCancelarCita" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background:#fef2f2;">
                        <svg width="20" height="20" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">¿Cancelar esta cita?</h6>
                        <p class="text-muted small mb-0">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1 btn-sm fw-semibold" data-bs-dismiss="modal">No, mantener</button>
                    <button type="button" onclick="ejecutarCancelarCita()" class="btn btn-danger flex-grow-1 btn-sm fw-semibold">Sí, cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="formCancelarCita" method="POST" style="display:none;">
    @csrf @method('PATCH')
</form>

<script>
function toggleReprog(btn) {
    const form = btn.closest('td').querySelector('.reprog-form');
    form.classList.toggle('d-none');
    form.classList.toggle('d-flex');
}
let urlCancelarCita = '';
function confirmarCancelarCita(url) {
    urlCancelarCita = url;
    new BSLib.Modal(document.getElementById('modalCancelarCita')).show();
}
function ejecutarCancelarCita() {
    document.getElementById('formCancelarCita').action = urlCancelarCita;
    document.getElementById('formCancelarCita').submit();
}
</script>
</body>
</html>
