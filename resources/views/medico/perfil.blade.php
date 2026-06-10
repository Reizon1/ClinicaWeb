<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.medico-sidebar', ['activeSection' => 'perfil'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar">
            <h5 class="fw-bold mb-0">Mi Perfil</h5>
            <p class="text-muted mb-0 ms-2" style="font-size:0.75rem;">Información y configuración de tu cuenta</p>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="row g-4">

                {{-- Columna izquierda: tarjeta + stats --}}
                <div class="col-lg-4 d-flex flex-column gap-3">

                    <div class="app-card overflow-hidden">
                        <div style="height:72px;background:linear-gradient(135deg,#1e3a8a,#2563eb);"></div>
                        <div class="px-4 pb-4">
                            <div class="mb-3" style="margin-top:-28px;">
                                <div class="avatar-circle text-white fw-bold" style="width:56px;height:56px;font-size:1.4rem;border:3px solid white;background:linear-gradient(135deg,#1d4ed8,#3b82f6);">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                            </div>
                            <h6 class="fw-bold mb-0">Dr. {{ $user->name }}</h6>
                            <p class="text-primary fw-medium mb-0 small">{{ $medico->especialidad->nombre }}</p>
                            <p class="text-muted mb-3" style="font-size:0.75rem;">{{ $user->email }}</p>

                            <div class="d-flex flex-column gap-2 pt-3 border-top">
                                <div class="d-flex align-items-center gap-2 text-muted" style="font-size:0.75rem;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Licencia: <span class="fw-medium text-dark">{{ $medico->numero_licencia ?? 'No registrada' }}</span>
                                </div>
                                @if($medico->telefono)
                                <div class="d-flex align-items-center gap-2 text-muted" style="font-size:0.75rem;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $medico->telefono }}
                                </div>
                                @endif
                                <div class="d-flex align-items-center gap-2 text-muted" style="font-size:0.75rem;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Miembro desde {{ $user->created_at->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="app-card p-4">
                        <h6 class="text-muted fw-semibold mb-3" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Estadísticas</h6>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Total de citas</span>
                                <span class="fw-bold">{{ $totalCitas }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Citas completadas</span>
                                <span class="fw-bold text-success">{{ $citasCompletadas }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Historiales creados</span>
                                <span class="fw-bold text-primary">{{ $totalHistoriales }}</span>
                            </div>
                            @if($totalCitas > 0)
                            <div class="pt-2 border-top">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted" style="font-size:0.72rem;">Tasa de completadas</span>
                                    <span class="fw-semibold" style="font-size:0.72rem;">{{ round($citasCompletadas / $totalCitas * 100) }}%</span>
                                </div>
                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar bg-success" style="width:{{ round($citasCompletadas / $totalCitas * 100) }}%"></div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Disponibilidad --}}
                    <div class="app-card p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-semibold mb-0 small">Disponibilidad</h6>
                            <p class="text-muted mb-0" style="font-size:0.72rem;">Estado actual en el sistema</p>
                        </div>
                        <span class="badge rounded-pill {{ $medico->disponible ? 'bg-success' : 'bg-secondary' }}">
                            {{ $medico->disponible ? 'Disponible' : 'No disponible' }}
                        </span>
                    </div>
                </div>

                {{-- Columna derecha: formulario --}}
                <div class="col-lg-8">
                    <form method="POST" action="{{ route('medico.perfil.update') }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <div class="app-card p-4">
                            <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Datos Personales
                            </h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Nombre completo *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                           class="form-control form-control-sm @error('name') is-invalid @enderror">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Correo electrónico *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                           class="form-control form-control-sm @error('email') is-invalid @enderror">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Teléfono</label>
                                    <input type="text" name="telefono" value="{{ old('telefono', $medico->telefono) }}" placeholder="+54 9 11 0000-0000"
                                           class="form-control form-control-sm @error('telefono') is-invalid @enderror">
                                    @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Especialidad</label>
                                    <div class="form-control form-control-sm bg-light text-muted">
                                        {{ $medico->especialidad->nombre }} <span class="text-muted small">(modificar desde Admin)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="app-card p-4">
                            <h6 class="fw-semibold mb-1 d-flex align-items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Cambiar Contraseña
                            </h6>
                            <p class="text-muted mb-3" style="font-size:0.78rem;">Dejá en blanco para mantener la contraseña actual.</p>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Nueva contraseña <span class="text-muted fw-normal">(mín. 8 chars)</span></label>
                                    <input type="password" name="password" placeholder="••••••••"
                                           class="form-control form-control-sm @error('password') is-invalid @enderror">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Confirmar contraseña</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        @if($medico->horarios->count())
                        <div class="app-card p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-semibold mb-0 d-flex align-items-center gap-2">
                                    <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Mis Horarios
                                </h6>
                                <a href="{{ route('horarios.index') }}" class="text-primary small fw-semibold">Gestionar →</a>
                            </div>
                            @php
                                $diasMap = ['lunes'=>'Lunes','martes'=>'Martes','miercoles'=>'Miércoles','jueves'=>'Jueves','viernes'=>'Viernes','sabado'=>'Sábado','domingo'=>'Domingo'];
                                $orden = array_flip(array_keys($diasMap));
                                $horariosOrdenados = $medico->horarios->sortBy(fn($h) => $orden[$h->dia_semana] ?? 7);
                            @endphp
                            <div class="row g-2">
                                @foreach($horariosOrdenados as $h)
                                <div class="col-6">
                                    <div class="d-flex align-items-center gap-2 rounded-3 px-3 py-2" style="background:#eff6ff;">
                                        <div style="width:6px;height:6px;background:#3b82f6;border-radius:50%;flex-shrink:0;"></div>
                                        <div>
                                            <p class="fw-semibold mb-0" style="font-size:0.75rem;color:#1e40af;">{{ $diasMap[$h->dia_semana] ?? $h->dia_semana }}</p>
                                            <p class="mb-0" style="font-size:0.7rem;color:#2563eb;">{{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.medico') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary fw-semibold d-flex align-items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
