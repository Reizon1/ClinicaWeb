<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle Usuario – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">
    @include('partials.admin-sidebar', ['activeSection' => 'usuarios'])
    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-light btn-sm p-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">Detalle de Usuario</h5>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $usuario->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar Usuario
            </a>
        </header>
        <main class="flex-grow-1 p-4" style="overflow-y:auto;">

            @php
                $rolStyles = ['admin'=>'background:#f3e8ff;color:#6d28d9','medico'=>'background:#dbeafe;color:#1d4ed8','recepcionista'=>'background:#CFFAFE;color:#0E7490','paciente'=>'background:#f3f4f6;color:#374151'];
                $rolLabels = ['admin'=>'Administrador','medico'=>'Médico','recepcionista'=>'Recepcionista','paciente'=>'Paciente'];
            @endphp

            <div class="d-flex flex-column gap-4" style="max-width:680px;">

                <div class="app-card p-4">
                    <div class="d-flex align-items-start gap-4">
                        <div class="avatar-circle fw-bold text-white flex-shrink-0" style="width:64px;height:64px;font-size:1.6rem;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:16px;">
                            {{ strtoupper(substr($usuario->name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <h5 class="fw-bold mb-0">{{ $usuario->name }}</h5>
                                <span class="badge" style="{{ $rolStyles[$usuario->rol] ?? 'background:#f3f4f6;color:#374151' }}">
                                    {{ $rolLabels[$usuario->rol] ?? $usuario->rol }}
                                </span>
                                @if($usuario->id === auth()->id())
                                    <span class="badge" style="background:#eff6ff;color:#2563eb;">Tu cuenta</span>
                                @endif
                            </div>
                            <p class="text-muted mb-0 small">{{ $usuario->email }}</p>
                        </div>
                    </div>
                    <div class="row g-3 mt-3 pt-3 border-top">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Registrado el</p>
                            <p class="fw-medium small mb-0">{{ $usuario->created_at->format('d \d\e F \d\e Y') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Última actualización</p>
                            <p class="fw-medium small mb-0">{{ $usuario->updated_at->format('d \d\e F \d\e Y') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Email verificado</p>
                            <p class="mb-0 small {{ $usuario->email_verified_at ? 'text-success' : 'text-warning' }}">
                                {{ $usuario->email_verified_at ? 'Verificado (' . $usuario->email_verified_at->format('d/m/Y') . ')' : 'Sin verificar' }}
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">ID interno</p>
                            <p class="text-muted mb-0 small" style="font-family:monospace;">#{{ $usuario->id }}</p>
                        </div>
                    </div>
                </div>

                @if($usuario->medico)
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                        <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Perfil Médico
                    </h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Especialidad</p>
                            <p class="small mb-0">{{ $usuario->medico->especialidad->nombre ?? '—' }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">N° de Licencia</p>
                            <p class="small mb-0" style="font-family:monospace;">{{ $usuario->medico->numero_licencia ?? '—' }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Teléfono</p>
                            <p class="small mb-0">{{ $usuario->medico->telefono ?? '—' }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Disponibilidad</p>
                            <span class="badge {{ $usuario->medico->disponible ? 'bg-success' : 'bg-secondary' }}">
                                {{ $usuario->medico->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ route('admin.medicos.show', $usuario->medico) }}" class="text-primary fw-semibold small d-flex align-items-center gap-1">
                            Ver perfil médico completo
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endif

                @if($usuario->paciente)
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                        <svg width="14" height="14" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Perfil Paciente
                    </h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Fecha de nacimiento</p>
                            <p class="small mb-0">{{ $usuario->paciente->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->paciente->fecha_nacimiento)->format('d/m/Y') : '—' }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Teléfono</p>
                            <p class="small mb-0">{{ $usuario->paciente->telefono ?? '—' }}</p>
                        </div>
                        @if($usuario->paciente->direccion)
                        <div class="col-12">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;">Dirección</p>
                            <p class="small mb-0">{{ $usuario->paciente->direccion }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if(!$usuario->medico && !$usuario->paciente)
                <div class="app-card p-4 text-center text-muted small">
                    Este usuario no tiene perfil médico ni de paciente asociado.
                </div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
