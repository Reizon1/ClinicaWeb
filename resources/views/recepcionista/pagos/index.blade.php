<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagos – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

@php
$badgeEstado = [
    'completado'  => 'bg-green-100 text-green-700',
    'pendiente'   => 'bg-yellow-100 text-yellow-700',
    'fallido'     => 'bg-red-100 text-red-600',
    'reembolsado' => 'bg-purple-100 text-purple-700',
];
$badgeMetodo = [
    'efectivo' => 'bg-teal-50 text-teal-700',
    'stripe'   => 'bg-blue-50 text-blue-700',
    'paypal'   => 'bg-indigo-50 text-indigo-700',
];
@endphp

<div class="flex h-screen overflow-hidden">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Gestión de Pagos</h1>
                <p class="text-xs text-gray-400">Registros de pagos por consultas médicas</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm px-4 py-3 rounded-xl">{{ session('info') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">{{ $errors->first() }}</div>
            @endif

            {{-- Tarjetas resumen --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">${{ number_format($totalCompletado, 2) }}</div>
                    <div class="text-xs text-gray-400 mt-1">Total recaudado</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalPendiente }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pagos pendientes</div>
                </div>
            </div>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('recepcionista.pagos.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <select name="estado" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Todos los estados</option>
                        <option value="completado"  {{ request('estado') === 'completado'  ? 'selected' : '' }}>Completado</option>
                        <option value="pendiente"   {{ request('estado') === 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="fallido"     {{ request('estado') === 'fallido'     ? 'selected' : '' }}>Fallido</option>
                        <option value="reembolsado" {{ request('estado') === 'reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                    <select name="metodo_pago" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Todos los métodos</option>
                        <option value="efectivo" {{ request('metodo_pago') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="stripe"   {{ request('metodo_pago') === 'stripe'   ? 'selected' : '' }}>Stripe</option>
                        <option value="paypal"   {{ request('metodo_pago') === 'paypal'   ? 'selected' : '' }}>PayPal</option>
                    </select>
                    <select name="paciente_id" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Todos los pacientes</option>
                        @foreach($pacientes as $p)
                            <option value="{{ $p->id }}" {{ request('paciente_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-teal-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl hover:bg-teal-700 transition-colors">Filtrar</button>
                    <a href="{{ route('recepcionista.pagos.index') }}" class="text-xs text-gray-500 hover:text-gray-700">Limpiar</a>
                </div>
            </form>

            {{-- Tabla --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Paciente</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Concepto</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Monto</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Método</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5 text-gray-700">
                                {{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y H:i') : $pago->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-gray-800">{{ $pago->paciente->user->name }}</td>
                            <td class="px-4 py-3.5 text-gray-600">{{ $pago->concepto }}</td>
                            <td class="px-4 py-3.5 font-bold text-gray-900">${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold {{ $badgeMetodo[$pago->metodo_pago] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($pago->metodo_pago) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-full font-semibold {{ $badgeEstado[$pago->estado] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($pago->estado) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">No se encontraron pagos con los filtros aplicados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if($pagos->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">{{ $pagos->links() }}</div>
                @endif
            </div>

        </main>
    </div>
</div>
</body>
</html>
