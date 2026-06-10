<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Los Mollos') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">

<div class="d-flex" style="min-height:100vh;">

    {{-- Panel izquierdo — Identidad de marca --}}
    <div class="d-none d-lg-flex flex-column justify-content-between p-5 auth-panel-left position-relative overflow-hidden"
         style="width: 50%; flex-shrink:0;">

        {{-- Decoraciones de fondo --}}
        <div class="position-absolute top-0 end-0 translate-middle-y"
             style="width:350px;height:350px;border-radius:50%;background:rgba(59,130,246,0.1);pointer-events:none;"></div>
        <div class="position-absolute bottom-0 start-0"
             style="width:280px;height:280px;border-radius:50%;background:rgba(96,165,250,0.08);pointer-events:none;"></div>

        {{-- Logo --}}
        <div class="position-relative" style="z-index:1;">
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                <div class="d-flex align-items-center justify-content-center rounded-3"
                     style="width:40px;height:40px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);">
                    <svg width="22" height="22" fill="currentColor" class="text-white" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <div class="text-white fw-bold" style="font-size:0.9rem;">Los Mollos</div>
                    <div style="color:#93c5fd;font-size:0.7rem;">Sistema Hospitalario</div>
                </div>
            </a>
        </div>

        {{-- Contenido central --}}
        <div class="position-relative" style="z-index:1;">
            <span class="badge fw-semibold mb-4 px-3 py-2"
                  style="background:rgba(234,179,8,0.15);border:1px solid rgba(234,179,8,0.25);color:#fde047;font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;">
                Sistema de Gestión Digital 2026
            </span>

            <h2 class="text-white fw-bold mb-3" style="font-size:2.2rem;line-height:1.2;">
                Tu salud en<br>
                <span style="color:#93c5fd;">manos expertas</span>
            </h2>
            <p style="color:#bfdbfe;font-size:0.9rem;line-height:1.7;" class="mb-4">
                Plataforma integral para la gestión hospitalaria. Citas, historiales clínicos y pagos, todo en un solo lugar.
            </p>

            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                @foreach(['Gestión de citas automatizada','Historial clínico digital seguro','Pagos con PayPal y Stripe','Soporte prioritario 24/7'] as $f)
                <li class="d-flex align-items-center gap-3" style="font-size:0.875rem;color:#bfdbfe;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                         style="width:22px;height:22px;background:rgba(74,222,128,0.2);border:1px solid rgba(74,222,128,0.3);">
                        <svg width="11" height="11" fill="none" stroke="#4ade80" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    {{ $f }}
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Estadísticas --}}
        <div class="position-relative d-grid gap-3" style="z-index:1;grid-template-columns:repeat(3,1fr);">
            @foreach(['4,592' => 'Pacientes', '128' => 'Médicos', '99.9%' => 'Uptime'] as $val => $label)
            <div class="text-center rounded-3 p-3"
                 style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);">
                <div class="text-white fw-bold" style="font-size:1.1rem;">{{ $val }}</div>
                <div style="color:#93c5fd;font-size:0.7rem;">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Panel derecho — Formulario --}}
    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center px-4 px-sm-5 py-5 bg-white">

        {{-- Logo móvil --}}
        <div class="d-lg-none mb-4">
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="d-flex align-items-center justify-content-center bg-primary rounded-3"
                     style="width:36px;height:36px;">
                    <svg width="18" height="18" fill="white" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <div class="fw-bold text-dark" style="font-size:0.875rem;">Los Mollos</div>
                    <div class="text-muted" style="font-size:0.7rem;">Sistema Hospitalario</div>
                </div>
            </a>
        </div>

        <div class="w-100" style="max-width:420px;">
            {{ $slot }}
        </div>
    </div>
</div>

</body>
</html>
