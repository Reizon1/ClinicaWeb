<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suscripciones Premium – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-slate-50 text-gray-900">
@php
$badgeEstado = [
    'activa'    => 'bg-emerald-100 text-emerald-700',
    'vencida'   => 'bg-gray-100 text-gray-500',
    'cancelada' => 'bg-red-100 text-red-600',
];
@endphp
<div class="flex h-screen overflow-hidden">
    @include('partials.admin-sidebar', ['activeSection' => 'suscripciones'])
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-gray-900">Suscripciones Premium</h1>
                <p class="text-xs text-gray-400">Gestión de membresías activas y vencidas</p>
            </div>
            <a href="{{ route('admin.suscripciones.create') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Suscripción
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div>
            @endif

            {{-- Tarjetas resumen --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-5 text-white shadow-md">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <div class="text-3xl font-bold">{{ $totalActivas }}</div>
                    <div class="text-purple-100 text-xs mt-1 font-medium">Suscripciones activas</div>
                </div>
                <div class="bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl p-5 text-white shadow-md">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-3xl font-bold">{{ $totalVencidas }}</div>
                    <div class="text-gray-200 text-xs mt-1 font-medium">Vencidas</div>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 text-white shadow-md">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-3xl font-bold">${{ number_format($totalRecaudado, 2) }}</div>
                    <div class="text-emerald-100 text-xs mt-1 font-medium">Ingresos activos</div>
                </div>
            </div>

            {{-- Filtro --}}
            <form method="GET" action="{{ route('admin.suscripciones.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                <select name="estado" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none">
                    <option value="">Todos los estados</option>
                    <option value="activa"    {{ request('estado') === 'activa'    ? 'selected' : '' }}>Activas</option>
                    <option value="vencida"   {{ request('estado') === 'vencida'   ? 'selected' : '' }}>Vencidas</option>
                    <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Canceladas</option>
                </select>
                <button type="submit" class="bg-purple-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl hover:bg-purple-700 transition-colors">Filtrar</button>
                <a href="{{ route('admin.suscripciones.index') }}" class="text-xs text-gray-500 hover:text-gray-700">Limpiar</a>
            </form>

            {{-- Tabla --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Inicio</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Vencimiento</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Método</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($suscripciones as $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3.5 font-medium text-gray-800">{{ $s->paciente->user->name }}</td>
                            <td class="px-4 py-3.5">
                                <span class="flex items-center gap-1 text-purple-700 font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    {{ ucfirst($s->plan) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-bold text-gray-900">${{ number_format($s->precio, 2) }}/mes</td>
                            <td class="px-4 py-3.5 text-gray-600">{{ $s->fecha_inicio->format('d/m/Y') }}</td>
                            <td class="px-4 py-3.5 text-gray-600">{{ $s->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td class="px-4 py-3.5 text-gray-600 capitalize">{{ $s->metodo_pago }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold {{ $badgeEstado[$s->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($s->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($s->estado === 'activa')
                                <form method="POST" action="{{ route('admin.suscripciones.destroy', $s) }}"
                                      onsubmit="return confirm('¿Cancelar esta suscripción?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Cancelar</button>
                                </form>
                                @else
                                <span class="text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400">No hay suscripciones registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($suscripciones->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $suscripciones->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
