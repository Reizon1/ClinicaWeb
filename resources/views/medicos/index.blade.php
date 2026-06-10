<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médicos – Los Mollos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body style="background:#f8fafc;">

    <nav class="navbar navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">Los Mollos</a>
            <div class="d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm fw-semibold">Mi Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm fw-semibold">Ingresar</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm fw-semibold">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <div class="mb-4">
            <h1 class="fw-bold h2 mb-1">Nuestros Médicos</h1>
            <p class="text-muted">Encontrá al especialista que necesitás</p>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('medicos.buscar') }}" class="bg-white rounded-3 border p-4 mb-4 shadow-sm">
            <div class="row g-3 align-items-end">
                <div class="col-sm-5">
                    <label class="form-label fw-semibold small">Nombre del médico</label>
                    <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Ej: Dr. García"
                           class="form-control form-control-sm">
                </div>
                <div class="col-sm-5">
                    <label class="form-label fw-semibold small">Especialidad</label>
                    <select name="especialidad_id" class="form-select form-select-sm">
                        <option value="">Todas las especialidades</option>
                        @foreach($especialidades as $esp)
                            <option value="{{ $esp->id }}" {{ request('especialidad_id') == $esp->id ? 'selected' : '' }}>
                                {{ $esp->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold flex-grow-1">Buscar</button>
                    @if(request('nombre') || request('especialidad_id'))
                        <a href="{{ route('medicos.buscar') }}" class="btn btn-outline-secondary btn-sm">✕</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Resultados --}}
        @if($medicos->isEmpty())
            <div class="text-center py-5 text-muted">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-3 opacity-50 d-block mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="fw-semibold mb-1">No se encontraron médicos con esos filtros.</p>
                <a href="{{ route('medicos.buscar') }}" class="text-primary small">Ver todos</a>
            </div>
        @else
            <p class="text-muted small mb-3">{{ $medicos->count() }} médico(s) encontrado(s)</p>
            <div class="row g-4">
                @foreach($medicos as $medico)
                <div class="col-sm-6 col-lg-4">
                    <div class="bg-white rounded-3 border shadow-sm p-4 h-100 d-flex flex-column gap-3">

                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle flex-shrink-0" style="width:52px;height:52px;font-size:1.2rem;">
                                {{ strtoupper(substr($medico->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="fw-semibold mb-0 small">{{ $medico->user->name }}</p>
                                <p class="mb-0 text-primary" style="font-size:0.78rem;">{{ $medico->especialidad->nombre }}</p>
                            </div>
                        </div>

                        @if($medico->descripcion)
                            <p class="text-muted small mb-0" style="overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                                {{ $medico->descripcion }}
                            </p>
                        @endif

                        <div class="d-flex flex-column gap-1" style="font-size:0.75rem;color:#9ca3af;">
                            <div class="d-flex align-items-center gap-1">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Licencia: {{ $medico->numero_licencia }}
                            </div>
                            @if($medico->telefono)
                            <div class="d-flex align-items-center gap-1">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $medico->telefono }}
                            </div>
                            @endif
                        </div>

                        <div class="mt-auto">
                            @auth
                                @if(auth()->user()->rol === 'paciente')
                                    <a href="{{ route('citas.crear', ['medico_id' => $medico->id]) }}"
                                       class="btn btn-primary btn-sm w-100 fw-semibold">Agendar Cita</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="btn btn-outline-primary btn-sm w-100 fw-semibold">Ingresar para agendar</a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
