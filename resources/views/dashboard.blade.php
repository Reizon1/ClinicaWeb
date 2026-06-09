<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body style="background:#f8fafc;font-family:'Inter',sans-serif;">
    <nav class="navbar navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary">Los Mollos</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm fw-semibold">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <div class="container py-5 text-center" style="max-width:480px;">
        <div class="bg-white rounded-3 border shadow-sm p-5">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width:64px;height:64px;background:#eff6ff;">
                <svg width="28" height="28" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h5 class="fw-bold mb-2">¡Sesión iniciada!</h5>
            <p class="text-muted small mb-4">Serás redirigido a tu dashboard en un momento...</p>
            <div class="d-flex flex-column gap-2">
                @php $rol = auth()->user()->rol ?? 'paciente'; @endphp
                @if($rol === 'admin')
                    <a href="{{ route('dashboard.admin') }}" class="btn btn-primary btn-sm fw-semibold">Dashboard Admin</a>
                @elseif($rol === 'medico')
                    <a href="{{ route('dashboard.medico') }}" class="btn btn-primary btn-sm fw-semibold">Dashboard Médico</a>
                @elseif($rol === 'recepcionista')
                    <a href="{{ route('dashboard.recepcionista') }}" class="btn btn-primary btn-sm fw-semibold">Dashboard Recepcionista</a>
                @else
                    <a href="{{ route('dashboard.paciente') }}" class="btn btn-primary btn-sm fw-semibold">Dashboard Paciente</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm fw-semibold">Mi Perfil</a>
            </div>
        </div>
    </div>
</body>
</html>
