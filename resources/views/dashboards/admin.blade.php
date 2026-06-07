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

@php
    $badgeEstado = [
        'confirmada' => 'bg-green-100 text-green-700',
        'pendiente'  => 'bg-yellow-100 text-yellow-700',
        'completada' => 'bg-blue-100 text-blue-700',
        'cancelada'  => 'bg-red-100 text-red-600',
    ];
    $mesesLabels = ['Ene'=>1,'Feb'=>2,'Mar'=>3,'Abr'=>4,'May'=>5,'Jun'=>6,'Jul'=>7,'Ago'=>8,'Sep'=>9,'Oct'=>10,'Nov'=>11,'Dic'=>12];
    $maxV = max($datosPorMes) > 0 ? max($datosPorMes) : 1;
@endphp

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-56 flex-shrink-0 flex flex-col bg-gray-900">
        <div class="px-5 py-5 border-b border-gray-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div class="text-white font-extrabold text-sm leading-none tracking-wide">LOS MOLLOS</div>
                    <div class="text-gray-400 text-xs leading-none mt-0.5">ADMIN CLINIC</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            <div class="px-3 py-1 mb-1"><span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Principal</span></div>
            <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Gestión Médica</span></div>
            @foreach([['Médicos','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],['Recepcionistas','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],['Especialidades','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z']] as [$label,$path])
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/></svg>
                {{ $label }}
            </a>
            @endforeach

            <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Sistema</span></div>
            @foreach([['Usuarios','M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],['Reportes','M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],['Configuración','M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z']] as [$label,$path])
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/></svg>
                {{ $label }}
            </a>
            @endforeach
        </nav>

        <div class="px-3 py-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-800 text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENIDO --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center gap-4 flex-shrink-0">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Buscar reporte o usuario..." class="w-full max-w-xs pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
            </div>
            <button class="relative p-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-400">Super Administrador</div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

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

            {{-- KPIs con datos reales --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Total Pacientes</span>
                        <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($totalPacientes) }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Médicos Activos</span>
                        <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($medicosActivos) }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Citas de Hoy</span>
                        <div class="w-8 h-8 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($citasHoy) }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Ingresos (PayPal/Stripe)</span>
                        <div class="w-8 h-8 bg-purple-50 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">${{ number_format($ingresos, 2) }}</div>
                </div>
            </div>

            {{-- Gráfico + Actividad reciente --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- Gráfico barras con datos reales --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-900">Citas por Mes ({{ date('Y') }})</h3>
                    </div>
                    <div class="flex items-end gap-1.5" style="height:140px;">
                        @foreach($mesesLabels as $label => $num)
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full rounded-t-md bg-blue-400/80 hover:bg-blue-600 transition-colors cursor-pointer"
                                 style="height:{{ $datosPorMes[$num] > 0 ? round(($datosPorMes[$num]/$maxV)*100) : 2 }}%"></div>
                            <span style="font-size:9px" class="text-gray-400">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Últimos pagos como actividad reciente --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm overflow-hidden">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Actividad Reciente</h3>
                    <div class="space-y-3">
                        @forelse($ultimosPagos as $pago)
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 {{ $pago->estado === 'completado' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }} rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800 leading-tight">{{ $pago->concepto }}</p>
                                <p class="text-xs text-gray-400 leading-tight mt-0.5">{{ $pago->paciente->user->name }} · ${{ number_format($pago->monto, 2) }}</p>
                                <p class="text-gray-300 mt-0.5" style="font-size:10px">{{ $pago->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-gray-400">Sin actividad reciente.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Últimas citas --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Últimas Citas Registradas</h3>
                </div>
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Médico</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Especialidad</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha & Hora</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($ultimasCitas as $cita)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-blue-700 font-bold" style="font-size:9px">{{ strtoupper(substr($cita->paciente->user->name, 0, 1)) }}</span>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $cita->paciente->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-500">Dr. {{ $cita->medico->user->name }}</td>
                            <td class="px-4 py-3.5 text-gray-500">{{ $cita->especialidad->nombre }}</td>
                            <td class="px-4 py-3.5 text-gray-500">{{ $cita->fecha_hora->format('d M Y · h:i A') }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold {{ $badgeEstado[$cita->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ strtoupper($cita->estado) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">Sin citas registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
