<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle Médico – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'medicos'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('admin.medicos.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div class="flex-1">
                <h1 class="text-base font-bold text-gray-900">Dr. {{ $medico->user->name }}</h1>
                <p class="text-xs text-gray-400">{{ $medico->especialidad->nombre }}</p>
            </div>
            <a href="{{ route('admin.medicos.edit', $medico) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            {{-- KPIs --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $totalCitas }}</div>
                    <div class="text-xs text-gray-400 mt-1">Total Citas</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $citasCompletadas }}</div>
                    <div class="text-xs text-gray-400 mt-1">Completadas</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm text-center">
                    <div class="text-3xl font-bold text-yellow-500">{{ $citasPendientes }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pendientes / Confirmadas</div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                {{-- Información personal --}}
                <div class="col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex flex-col items-center text-center mb-5">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                            <span class="text-blue-700 font-extrabold text-2xl">{{ strtoupper(substr($medico->user->name,0,1)) }}</span>
                        </div>
                        <h2 class="font-bold text-gray-900">Dr. {{ $medico->user->name }}</h2>
                        <p class="text-xs text-blue-600 mt-0.5">{{ $medico->especialidad->nombre }}</p>
                        <span class="mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $medico->disponible ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $medico->disponible ? 'Disponible' : 'Inactivo' }}
                        </span>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="text-gray-600 text-xs">{{ $medico->user->email }}</span>
                        </div>
                        @if($medico->telefono)
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="text-gray-600 text-xs">{{ $medico->telefono }}</span>
                        </div>
                        @endif
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="text-gray-600 text-xs font-mono">Licencia: {{ $medico->numero_licencia }}</span>
                        </div>
                    </div>
                    @if($medico->descripcion)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Descripción</p>
                        <p class="text-xs text-gray-600 leading-relaxed">{{ $medico->descripcion }}</p>
                    </div>
                    @endif
                </div>

                {{-- Horarios + Últimas Citas --}}
                <div class="col-span-2 space-y-4">
                    {{-- Horarios --}}
                    @if($medico->horarios->isNotEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Horarios de Atención</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($medico->horarios->sortBy(fn($h) => match($h->dia_semana) { 'lunes'=>1,'martes'=>2,'miércoles'=>3,'jueves'=>4,'viernes'=>5,'sábado'=>6,'domingo'=>7,default=>8 }) as $h)
                            <div class="bg-blue-50 border border-blue-100 rounded-xl px-3 py-2">
                                <div class="text-xs font-semibold text-blue-700 capitalize">{{ $h->dia_semana }}</div>
                                <div class="text-xs text-blue-600">{{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Últimas citas --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900">Últimas Citas Atendidas</h3>
                        </div>
                        @if($ultimasCitas->isEmpty())
                            <div class="px-5 py-10 text-center text-gray-400 text-xs">Este médico no tiene citas registradas.</div>
                        @else
                        <table class="w-full text-xs">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($ultimasCitas as $cita)
                                @php
                                    $badge = ['confirmada'=>'bg-blue-100 text-blue-700','pendiente'=>'bg-yellow-100 text-yellow-700','completada'=>'bg-green-100 text-green-700','cancelada'=>'bg-red-100 text-red-600'];
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3.5 font-medium text-gray-800">{{ $cita->paciente->user->name }}</td>
                                    <td class="px-4 py-3.5 text-gray-500">{{ $cita->fecha_hora->format('d M Y · h:i A') }}</td>
                                    <td class="px-4 py-3.5">
                                        <span class="px-2.5 py-1 rounded-full font-semibold {{ $badge[$cita->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($cita->estado) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
