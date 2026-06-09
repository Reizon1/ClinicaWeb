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
                        <div class="col-md-6 col-xl-4">
                            <div class="app-card overflow-hidden">
                                <div class="px-3 py-2 border-bottom d-flex align-items-center gap-2" style="background:#f9fafb;">
                                    <div style="width:8px;height:8px;background:#3b82f6;border-radius:50%;flex-shrink:0;"></div>
                                    <h6 class="fw-bold mb-0 text-capitalize">{{ $dia }}</h6>
                                </div>
                                <div class="p-3 d-flex flex-column gap-2">
                                    @foreach($horarios[$dia] as $h)
                                    <div class="d-flex align-items-center justify-content-between rounded-3 px-3 py-2" style="background:#eff6ff;">
                                        <div class="d-flex align-items-center gap-2">
                                            <svg width="14" height="14" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="fw-semibold text-primary">{{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('horarios.destroy', $h) }}" onsubmit="return confirm('¿Eliminar este horario?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-sm p-1 text-danger">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                    @endforeach
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
</body>
</html>
