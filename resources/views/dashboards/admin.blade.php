<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Administrador – Los Mollos</title>
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
    <aside class="w-56 flex-shrink-0 flex flex-col bg-gray-900">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-gray-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-extrabold text-sm leading-none tracking-wide">LOS MOLLOS</div>
                    <div class="text-gray-400 text-xs leading-none mt-0.5">ADMIN CLINIC</div>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            <div class="px-3 py-1 mb-1">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Principal</span>
            </div>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="px-3 py-1 mt-3 mb-1">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Gestión Médica</span>
            </div>
            @foreach([['Médicos','M0 9a2 2 0 110-4 2 2 0 010 4zm-2 5a2 2 0 100-4 2 2 0 000 4zm5-5a2 2 0 100-4 2 2 0 000 4zm-2 5a2 2 0 100-4 2 2 0 000 4zm4-8a2 2 0 100-4 2 2 0 000 4zm2 5a2 2 0 100-4 2 2 0 000 4z'],['Recepcionistas','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],['Especialidades','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z']] as [$label, $path])
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/></svg>
                {{ $label }}
            </a>
            @endforeach

            <div class="px-3 py-1 mt-3 mb-1">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Sistema</span>
            </div>
            @foreach([['Usuarios','M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],['Reportes','M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],['Configuración','M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z']] as [$label,$path])
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/></svg>
                {{ $label }}
            </a>
            @endforeach
        </nav>

        {{-- Ayuda --}}
        <div class="px-3 py-4 border-t border-gray-800">
            <button class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                ¿Necesitas soporte técnico?
            </button>
            <button class="mt-1 w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-xl transition-colors">
                Centro Ayuda
            </button>
        </div>
    </aside>

    {{-- ============================================================
         CONTENIDO PRINCIPAL
    ============================================================ --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center gap-4 flex-shrink-0">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Buscar reporte o usuario..."
                       class="w-full max-w-xs pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
            </div>
            <button class="relative p-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <button class="relative p-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-blue-500 rounded-full"></span>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-800">Admin Los Mollos</div>
                    <div class="text-xs text-gray-400">Super Administrador</div>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </header>

        {{-- Scroll area --}}
        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            {{-- Título + acciones --}}
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-bold text-gray-900">Panel de Administración</h1>
                <div class="flex items-center gap-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Generar Reporte
                    </button>
                    <button class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Gestionar Usuarios Premium
                    </button>
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="grid grid-cols-4 gap-4">
                @php
                $kpis = [
                    ['Total Pacientes','4,281','text-blue-600','bg-blue-50','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['Médicos Activos','128','text-green-600','bg-green-50','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    ['Citas de Hoy','54','text-orange-600','bg-orange-50','M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['Ingresos (PayPal/Stripe)','$12,480.00','text-purple-600','bg-purple-50','M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
                @endphp
                @foreach($kpis as $kpi)
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">{{ $kpi[0] }}</span>
                        <div class="w-8 h-8 {{ $kpi[3] }} rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 {{ $kpi[2] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $kpi[4] }}"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $kpi[1] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Gráfico + Actividad --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- Gráfico de barras --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-900">Citas por Mes (Anual)</h3>
                        <button class="text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                        </button>
                    </div>
                    @php
                    $meses=['Ene'=>35,'Feb'=>42,'Mar'=>38,'Abr'=>55,'May'=>48,'Jun'=>62,'Jul'=>58,'Ago'=>70,'Sep'=>65,'Oct'=>80,'Nov'=>75,'Dic'=>95];
                    $maxV=max($meses);
                    @endphp
                    <div class="flex items-end gap-1.5" style="height:140px;">
                        @foreach($meses as $m=>$v)
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full rounded-t-md bg-blue-400/80 hover:bg-blue-600 transition-colors cursor-pointer"
                                 style="height:{{ round(($v/$maxV)*100) }}%"></div>
                            <span class="text-xs text-gray-400" style="font-size:9px">{{ $m }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actividad Reciente --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm overflow-hidden">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Actividad Reciente</h3>
                    <div class="space-y-3">
                        @php
                        $actividades = [
                            ['bg-green-100 text-green-600','check','Nuevo médico registrado','Dr. Alejandro Torres se unió al equipo','Hace 10 minutos'],
                            ['bg-blue-100 text-blue-600','credit-card','Pago Premium exitoso','Usuario (8801) renovó su suscripción','Hace 2 horas'],
                            ['bg-red-100 text-red-600','exclamation','Error de sincronización','Falló en la pasarela de pago Stripe.','Hace 3 horas'],
                            ['bg-purple-100 text-purple-600','star','Nueva especialidad','Neurología HD fue habilitada.','Ayer 08:02 PM'],
                        ];
                        @endphp
                        @foreach($actividades as $a)
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 {{ $a[0] }} rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($a[1]==='check')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    @elseif($a[1]==='credit-card')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    @elseif($a[1]==='exclamation')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    @endif
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800 leading-tight">{{ $a[2] }}</p>
                                <p class="text-xs text-gray-400 leading-tight mt-0.5">{{ $a[3] }}</p>
                                <p class="text-xs text-gray-300 mt-0.5" style="font-size:10px">{{ $a[4] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="mt-4 w-full text-xs font-semibold text-blue-600 hover:underline">VER TODO EL LOG</button>
                </div>
            </div>

            {{-- Tabla de registros --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Últimos Registros de Sistema</h3>
                </div>
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Usuario / Médico</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acción Realizada</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Módulo</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha & Hora</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Detalle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                        $logs = [
                            ['Dr. Hernán Quiroga','Actualización de disponibilidad horaria','Agenda','24 Mar 2026 · 10:20 AM','Éxito','bg-green-100 text-green-700'],
                            ['Carlos Eduardo (Paciente)','Suscripción Premium activada','Finanzas','24 Mar 2026 · 09:45 AM','Éxito','bg-green-100 text-green-700'],
                            ['System Bot','Limpieza automática de temporales','Sistema','24 Mar 2026 · 04:00 AM','Éxito','bg-green-100 text-green-700'],
                        ];
                        $modColors=['Agenda'=>'bg-blue-100 text-blue-700','Finanzas'=>'bg-yellow-100 text-yellow-700','Sistema'=>'bg-gray-100 text-gray-600'];
                        @endphp
                        @foreach($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-blue-700 font-bold" style="font-size:9px">{{ substr($log[0],0,1) }}</span>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $log[0] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-500">{{ $log[1] }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2 py-1 rounded-full font-semibold {{ $modColors[$log[2]] }}">{{ $log[2] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-gray-500">{{ $log[3] }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold {{ $log[5] }}">{{ $log[4] }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <button class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
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
