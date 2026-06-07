<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'reportes'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Reportes del Sistema</h1>
                <p class="text-xs text-gray-400">Estadísticas y análisis de la clínica – {{ $anio }}</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            {{-- KPIs --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="text-xs font-medium text-gray-500 mb-2">Total Citas</div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($totalCitas) }}</div>
                    <div class="flex items-center gap-4 mt-2">
                        <span class="text-xs text-green-600 font-semibold">{{ $citasCompletadas }} completadas</span>
                        <span class="text-xs text-red-500 font-semibold">{{ $citasCanceladas }} canceladas</span>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="text-xs font-medium text-gray-500 mb-2">Citas Pendientes</div>
                    <div class="text-3xl font-bold text-yellow-500">{{ number_format($citasPendientes) }}</div>
                    <div class="text-xs text-gray-400 mt-2">En espera de atención</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="text-xs font-medium text-gray-500 mb-2">Total Pacientes</div>
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($totalPacientes) }}</div>
                    <div class="text-xs text-gray-400 mt-2">{{ $totalMedicos }} médicos activos</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="text-xs font-medium text-gray-500 mb-2">Ingresos Totales</div>
                    <div class="text-3xl font-bold text-green-600">${{ number_format($totalPagos, 2) }}</div>
                    <div class="text-xs text-gray-400 mt-2">Pagos completados</div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                {{-- Gráfico citas por mes --}}
                <div class="col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Citas por Mes – {{ $anio }}</h3>
                    @php $maxV = max($datosPorMes) > 0 ? max($datosPorMes) : 1; $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']; @endphp
                    <div class="flex items-end gap-1.5" style="height:160px;">
                        @foreach($meses as $i => $mes)
                        @php $val = $datosPorMes[$i+1]; @endphp
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="text-center" style="font-size:9px; color:#6b7280;">{{ $val > 0 ? $val : '' }}</div>
                            <div class="w-full rounded-t-md bg-blue-400/80 hover:bg-blue-600 transition-colors cursor-pointer"
                                 style="height:{{ $val > 0 ? round(($val/$maxV)*120) : 4 }}px"></div>
                            <span style="font-size:9px" class="text-gray-400">{{ $mes }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Top médicos --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Top Médicos por Citas</h3>
                    <div class="space-y-3">
                        @forelse($topMedicos as $i => $m)
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold {{ $i===0?'bg-yellow-100 text-yellow-600':($i===1?'bg-gray-100 text-gray-500':'bg-gray-50 text-gray-400') }}">{{ $i+1 }}</div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-gray-800 truncate">Dr. {{ $m->user->name }}</div>
                                @php $pct = $totalCitas > 0 ? round(($m->citas_count/$totalCitas)*100) : 0; @endphp
                                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                            <div class="text-xs font-bold text-gray-700 w-8 text-right">{{ $m->citas_count }}</div>
                        </div>
                        @empty
                        <p class="text-xs text-gray-400">Sin datos.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Citas por especialidad --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Citas por Especialidad</h3>
                <div class="grid grid-cols-3 gap-3">
                    @forelse($citasPorEspecialidad as $esp)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div>
                            <div class="text-xs font-semibold text-gray-800">{{ $esp->nombre }}</div>
                            @php $pct = $totalCitas > 0 ? round(($esp->citas_count/$totalCitas)*100) : 0; @endphp
                            <div class="text-xs text-gray-400 mt-0.5">{{ $pct }}% del total</div>
                        </div>
                        <div class="text-xl font-bold text-blue-600">{{ $esp->citas_count }}</div>
                    </div>
                    @empty
                    <div class="col-span-3 text-xs text-gray-400 py-4 text-center">Sin datos de especialidades.</div>
                    @endforelse
                </div>
            </div>

            {{-- Resumen tasa --}}
            @if($totalCitas > 0)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Resumen de Rendimiento</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ round(($citasCompletadas/$totalCitas)*100) }}%</div>
                        <div class="text-xs text-gray-400 mt-1">Tasa de Completadas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-500">{{ round(($citasCanceladas/$totalCitas)*100) }}%</div>
                        <div class="text-xs text-gray-400 mt-1">Tasa de Cancelación</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalUsuarios }}</div>
                        <div class="text-xs text-gray-400 mt-1">Usuarios Totales</div>
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>
</div>
</body>
</html>
