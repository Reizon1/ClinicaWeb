<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Horarios – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'horarios'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div>
                <h5 class="fw-bold mb-0">Gestión de Horarios</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Configurá tus horarios de atención semanales</p>
            </div>
            <a href="{{ route('horarios.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Agregar Horario
            </a>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            @if($horarios->isEmpty())
                <div class="app-card p-5 text-center">
                    <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width:56px;height:56px;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="fw-semibold text-muted mb-1">No tenés horarios configurados</p>
                    <p class="text-muted small mb-3">Agregá tus horarios de atención para que los pacientes puedan reservar citas.</p>
                    <a href="{{ route('horarios.create') }}" class="btn btn-primary btn-sm">Agregar primer horario</a>
                </div>
            @else
                <div class="row g-3">
                    @foreach(['lunes','martes','miércoles','jueves','viernes','sábado','domingo'] as $dia)
                        @if(isset($horarios[$dia]))
                        @php
                            $citasDia = $citasSemana[$dia] ?? collect();
                            $collapseId = 'citas-' . Str::slug($dia);
                        @endphp
                        <div class="col-md-6 col-xl-4">
                            <div class="app-card overflow-hidden">
                                {{-- Day header — click to expand citas --}}
                                <button type="button"
                                        class="w-100 text-start px-3 py-2 border-bottom border-0 d-flex align-items-center gap-2 justify-content-between"
                                        style="background:#EFF6FF;cursor:pointer;"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="false"
                                        aria-controls="{{ $collapseId }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:8px;height:8px;background:#2563EB;border-radius:50%;flex-shrink:0;"></div>
                                        <h6 class="fw-bold mb-0 text-capitalize">{{ $dia }}</h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($citasDia->count() > 0)
                                            <span class="badge rounded-pill" style="background:#2563EB;font-size:0.68rem;">
                                                {{ $citasDia->count() }} {{ $citasDia->count() === 1 ? 'cita' : 'citas' }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size:0.72rem;">Sin citas esta semana</span>
                                        @endif
                                        <svg class="chevron-icon" width="14" height="14" fill="none" stroke="#6b7280" viewBox="0 0 24 24" style="transition:transform 0.2s;flex-shrink:0;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                {{-- Schedule times --}}
                                <div class="p-3 d-flex flex-column gap-2">
                                    @foreach($horarios[$dia] as $h)
                                    <div class="d-flex align-items-center justify-content-between rounded-3 px-3 py-2" style="background:#eff6ff;">
                                        <div class="d-flex align-items-center gap-2">
                                            <svg width="14" height="14" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="fw-semibold text-primary">{{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}</span>
                                        </div>
                                        <button type="button"
                                                onclick="confirmarEliminarHorario('{{ route('horarios.destroy', $h) }}')"
                                                class="btn btn-link btn-sm p-1 text-danger" title="Eliminar horario">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Collapsible citas section --}}
                                <div class="collapse" id="{{ $collapseId }}">
                                    <div class="border-top px-3 py-2" style="background:#f9fafb;">
                                        <p class="text-muted fw-semibold mb-2" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">
                                            Citas esta semana
                                        </p>
                                        @if($citasDia->isEmpty())
                                            <p class="text-muted small mb-2">No hay citas programadas para este día.</p>
                                        @else
                                            <div class="d-flex flex-column gap-2">
                                                @foreach($citasDia as $cita)
                                                @php
                                                    $badgeColors = ['confirmada'=>'badge-confirmada','pendiente'=>'badge-pendiente','completada'=>'badge-completada'];
                                                @endphp
                                                <div class="d-flex align-items-center gap-2 rounded-3 px-3 py-2" style="background:#fff;border:1px solid #e5e7eb;">
                                                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary flex-shrink-0"
                                                         style="width:28px;height:28px;font-size:0.65rem;">
                                                        {{ strtoupper(substr($cita->paciente->user->name,0,1)) }}
                                                    </div>
                                                    <div class="flex-grow-1" style="min-width:0;">
                                                        <div class="fw-semibold text-truncate" style="font-size:0.78rem;">{{ $cita->paciente->user->name }}</div>
                                                        <div class="text-muted" style="font-size:0.7rem;">{{ $cita->fecha_hora->format('H:i') }}</div>
                                                    </div>
                                                    <span class="badge {{ $badgeColors[$cita->estado] ?? 'bg-secondary' }}" style="font-size:0.65rem;">
                                                        {{ ucfirst($cita->estado) }}
                                                    </span>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

{{-- Modal eliminar horario --}}
<div class="modal fade" id="modalEliminarHorario" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background:#fef2f2;">
                        <svg width="20" height="20" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">¿Eliminar horario?</h6>
                        <p class="text-muted small mb-0">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1 btn-sm fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="ejecutarEliminarHorario()" class="btn btn-danger flex-grow-1 btn-sm fw-semibold">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="formEliminarHorario" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

<script>
let urlEliminarHorario = '';
function confirmarEliminarHorario(url) {
    urlEliminarHorario = url;
    new BSLib.Modal(document.getElementById('modalEliminarHorario')).show();
}
function ejecutarEliminarHorario() {
    document.getElementById('formEliminarHorario').action = urlEliminarHorario;
    document.getElementById('formEliminarHorario').submit();
}

// Rotate chevron when collapse opens/closes
document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn => {
    const target = document.querySelector(btn.getAttribute('data-bs-target'));
    if (!target) return;
    target.addEventListener('show.bs.collapse', () => {
        btn.querySelector('.chevron-icon').style.transform = 'rotate(180deg)';
    });
    target.addEventListener('hide.bs.collapse', () => {
        btn.querySelector('.chevron-icon').style.transform = 'rotate(0deg)';
    });
});
</script>
</body>
</html>
