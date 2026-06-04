<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Paciente – Los Mollos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <aside class="w-56 flex-shrink-0 flex flex-col"
           style="background:linear-gradient(180deg,#1e3a8a 0%,#1d4ed8 60%,#2563eb 100%);">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-white/10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-bold text-sm leading-none">Los Mollos</div>
                    <div class="text-blue-200 text-xs leading-none mt-0.5">PANEL PACIENTE</div>
                </div>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/15 text-white text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Mis Citas
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Historial Médico
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                Recetas
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Pagos
            </a>

            <div class="pt-4 pb-1">
                <span class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-widest">Servicios</span>
            </div>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-yellow-300 hover:bg-white/10 text-sm transition-colors font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Suscripción Premium
            </a>
        </nav>

        {{-- Cerrar sesión --}}
        <div class="px-3 py-4 border-t border-white/10">
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-500/20 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </a>
        </div>
    </aside>

    {{-- ============================================================
         CONTENIDO PRINCIPAL
    ============================================================ --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Bienvenido, Carlos Eduardo</h1>
                <p class="text-xs text-gray-400">Hoy es Lunes, 24 de Marzo de 2026</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="relative p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2">
                    <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">CE</span>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-800 leading-none">Carlos Eduardo</div>
                        <div class="text-xs text-gray-400 leading-none mt-0.5">Paciente ID: 12345</div>
                    </div>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5 shadow-sm shadow-blue-100">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Cita
                </button>
            </div>
        </header>

        {{-- Scroll area --}}
        <main class="flex-1 overflow-y-auto p-6 space-y-6">

            {{-- Resumen de Actividad --}}
            <div>
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Resumen de Actividad</h2>
                <div class="grid grid-cols-3 gap-4">

                    {{-- Próxima cita --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="text-xs text-gray-400 font-medium">Próxima Cita</div>
                        </div>
                        <div class="text-xl font-bold text-gray-900">28 Mar, 2026</div>
                        <div class="text-xs text-gray-400 mt-1">@ 08:30 AM</div>
                        <div class="mt-2 text-xs text-blue-600 font-medium">Dr. Quiroga</div>
                    </div>

                    {{-- Pagos Pendientes --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                            </div>
                            <div class="text-xs text-gray-400 font-medium">Pagos Pendientes</div>
                        </div>
                        <div class="text-xl font-bold text-gray-900">2 facturas</div>
                        <div class="text-2xl font-bold text-red-500 mt-0.5">$45.00</div>
                        <div class="mt-1 text-xs text-gray-400">Total pendiente</div>
                    </div>

                    {{-- Estado Premium --}}
                    <div class="rounded-2xl p-5 shadow-sm text-white" style="background:linear-gradient(135deg,#1e3a8a,#2563eb);">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <div class="text-xs text-blue-200 font-medium">Estado Premium</div>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-lg font-bold">Activo</span>
                            <span class="bg-green-400/20 border border-green-400/30 text-green-300 text-xs px-2 py-0.5 rounded-full font-medium">✓</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-1.5 mb-1">
                            <div class="bg-yellow-300 h-1.5 rounded-full" style="width:72%"></div>
                        </div>
                        <div class="text-xs text-blue-200">Vence: 15 Oct. 2026</div>
                    </div>
                </div>
            </div>

            {{-- Gráfico + Próxima Consulta --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- Seguimiento de Salud --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-900">Seguimiento de Salud</h3>
                        <span class="text-xs text-gray-400 bg-gray-50 border border-gray-100 rounded-full px-3 py-1">Últimos 6 meses</span>
                    </div>
                    {{-- Gráfico de líneas (SVG) --}}
                    <div class="relative">
                        <svg viewBox="0 0 500 160" class="w-full" xmlns="http://www.w3.org/2000/svg">
                            {{-- Grid lines --}}
                            <line x1="0" y1="40" x2="500" y2="40" stroke="#f3f4f6" stroke-width="1"/>
                            <line x1="0" y1="80" x2="500" y2="80" stroke="#f3f4f6" stroke-width="1"/>
                            <line x1="0" y1="120" x2="500" y2="120" stroke="#f3f4f6" stroke-width="1"/>
                            {{-- Y labels --}}
                            <text x="0" y="38" font-size="10" fill="#9ca3af">120</text>
                            <text x="0" y="78" font-size="10" fill="#9ca3af">100</text>
                            <text x="0" y="118" font-size="10" fill="#9ca3af">80</text>
                            {{-- Línea Peso (azul) --}}
                            <polyline points="50,100 130,90 210,95 290,80 370,85 450,78"
                                      fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            {{-- Puntos Peso --}}
                            <circle cx="50"  cy="100" r="3" fill="#2563eb"/>
                            <circle cx="130" cy="90"  r="3" fill="#2563eb"/>
                            <circle cx="210" cy="95"  r="3" fill="#2563eb"/>
                            <circle cx="290" cy="80"  r="3" fill="#2563eb"/>
                            <circle cx="370" cy="85"  r="3" fill="#2563eb"/>
                            <circle cx="450" cy="78"  r="3" fill="#2563eb"/>
                            {{-- Línea Presión (verde) --}}
                            <polyline points="50,60 130,70 210,55 290,65 370,50 450,60"
                                      fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            {{-- Puntos Presión --}}
                            <circle cx="50"  cy="60" r="3" fill="#10b981"/>
                            <circle cx="130" cy="70" r="3" fill="#10b981"/>
                            <circle cx="210" cy="55" r="3" fill="#10b981"/>
                            <circle cx="290" cy="65" r="3" fill="#10b981"/>
                            <circle cx="370" cy="50" r="3" fill="#10b981"/>
                            <circle cx="450" cy="60" r="3" fill="#10b981"/>
                            {{-- X labels --}}
                            <text x="42"  y="155" font-size="10" fill="#9ca3af">Ene</text>
                            <text x="122" y="155" font-size="10" fill="#9ca3af">Feb</text>
                            <text x="202" y="155" font-size="10" fill="#9ca3af">Mar</text>
                            <text x="282" y="155" font-size="10" fill="#9ca3af">Abr</text>
                            <text x="362" y="155" font-size="10" fill="#9ca3af">May</text>
                            <text x="442" y="155" font-size="10" fill="#9ca3af">Jul</text>
                        </svg>
                        {{-- Leyenda --}}
                        <div class="flex items-center gap-6 mt-2">
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-0.5 bg-blue-600 rounded"></div>
                                <span class="text-xs text-gray-500">Peso (kg)</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-0.5 bg-emerald-500 rounded"></div>
                                <span class="text-xs text-gray-500">Presión Art.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Próxima Consulta --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Próxima Consulta</h3>
                    <div class="flex flex-col items-center text-center mb-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        </div>
                        <div class="font-bold text-gray-900 text-sm">Dr. Hernán Quiroga</div>
                        <div class="text-xs text-gray-400 mt-0.5">Cardiología Clínica</div>
                    </div>
                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center gap-2 text-gray-500">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Pav 4 – Consultorio 402
                        </div>
                        <div class="flex items-center gap-2 text-gray-500">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Ayuno de 8 horas
                        </div>
                    </div>
                    <button class="mt-4 w-full bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        Cómo llegar
                    </button>
                </div>
            </div>

            {{-- Historial de Citas --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Historial de Citas Recientes</h3>
                        <p class="text-xs text-gray-400">Administra tus próximas consultas y pagos</p>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" placeholder="buscar doctor..." class="text-xs bg-transparent outline-none text-gray-500 w-28">
                    </div>
                </div>
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Especialidad</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha & Hora</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                        $citas = [
                            ['Dr. Hernán Quiroga','Cardiología','28 Mar, 2026 · 08:30 AM','CONFIRMADA','confirmada'],
                            ['Dra. Marta Sánchez','Medicina General','15 Mar, 2026 · 10:00 AM','PENDIENTE PAGO','pendiente'],
                            ['Dr. Luis Ramos','Traumatología','01 Mar, 2026 · 02:00 PM','COMPLETADA','completada'],
                        ];
                        $colores = ['confirmada'=>'bg-green-100 text-green-700','pendiente'=>'bg-yellow-100 text-yellow-700','completada'=>'bg-blue-100 text-blue-700'];
                        @endphp
                        @foreach($citas as $c)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-blue-700 font-bold" style="font-size:9px">{{ substr($c[0],3,2) }}</span>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $c[0] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-500">{{ $c[1] }}</td>
                            <td class="px-4 py-3.5 text-gray-500">{{ $c[2] }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold text-xs {{ $colores[$c[4]] }}">{{ $c[3] }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    <button class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    @if($c[4]==='pendiente')
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">Pagar</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
