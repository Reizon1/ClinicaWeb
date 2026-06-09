<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body style="background:#f8fafc;">
    <nav class="navbar navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">Los Mollos</a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold">← Volver al Dashboard</a>
        </div>
    </nav>

    <div class="container py-5" style="max-width:680px;">
        <h4 class="fw-bold mb-4">Mi Perfil</h4>

        <div class="d-flex flex-column gap-4">
            <div class="bg-white rounded-3 border shadow-sm p-4">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="bg-white rounded-3 border shadow-sm p-4">
                @include('profile.partials.update-password-form')
            </div>
            <div class="bg-white rounded-3 border shadow-sm p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</body>
</html>
