<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Los Mollos') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-white text-gray-900">

    <div class="min-h-screen flex">

        {{-- ============================================================
             PANEL IZQUIERDO — Identidad de marca
        ============================================================ --}}
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative overflow-hidden"
             style="background: linear-gradient(145deg,#0f2a4a 0%,#1a3d6b 55%,#1e4a80 100%);">

            {{-- Decoraciones de fondo --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-500/10"></div>
                <div class="absolute bottom-0 -left-16 w-72 h-72 rounded-full bg-blue-400/10"></div>
                <div class="absolute top-1/2 right-8 w-40 h-40 rounded-full bg-white/5"></div>
            </div>

            {{-- Logo --}}
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/15 border border-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-white font-bold">Los Mollos</div>
                        <div class="text-blue-300 text-xs">Sistema Hospitalario</div>
                    </div>
                </a>
            </div>

            {{-- Contenido central --}}
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-yellow-400/15 border border-yellow-400/25 rounded-full px-3 py-1 mb-6">
                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs font-bold text-yellow-400 uppercase tracking-widest">Sistema de Gestión Digital 2026</span>
                </div>

                <h2 class="text-4xl font-extrabold text-white leading-tight mb-5">
                    Tu salud en<br>
                    <span class="text-blue-300">manos expertas</span>
                </h2>
                <p class="text-blue-200 text-base leading-relaxed mb-10 max-w-sm">
                    Plataforma integral para la gestión hospitalaria. Citas, historiales clínicos y pagos, todo en un solo lugar.
                </p>

                <ul class="space-y-3">
                    @foreach(['Gestión de citas automatizada','Historial clínico digital seguro','Pagos con PayPal y Stripe','Soporte prioritario 24/7'] as $f)
                    <li class="flex items-center gap-3 text-blue-100 text-sm">
                        <div class="w-5 h-5 bg-green-400/20 border border-green-400/30 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Estadísticas --}}
            <div class="relative z-10 grid grid-cols-3 gap-4">
                @foreach(['4,592' => 'Pacientes', '128' => 'Médicos', '99.9%' => 'Uptime'] as $val => $label)
                <div class="bg-white/8 border border-white/10 rounded-xl p-4 text-center">
                    <div class="text-xl font-bold text-white">{{ $val }}</div>
                    <div class="text-xs text-blue-300 mt-0.5">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ============================================================
             PANEL DERECHO — Formulario
        ============================================================ --}}
        <div class="flex-1 flex flex-col justify-center items-center px-6 sm:px-12 py-12 bg-gray-50 lg:bg-white">

            {{-- Logo móvil --}}
            <div class="lg:hidden mb-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Los Mollos</div>
                        <div class="text-xs text-gray-400">Sistema Hospitalario</div>
                    </div>
                </a>
            </div>

            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>
