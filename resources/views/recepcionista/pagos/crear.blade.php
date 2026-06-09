<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Pago – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.recepcionista-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('recepcionista.citas') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Registrar Pago</h1>
                <p class="text-xs text-gray-400">Cita #{{ $cita->id }} – {{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-xl mx-auto space-y-5">

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Resumen de la cita --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Resumen de la Consulta</h2>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <div class="text-gray-400 font-medium mb-0.5">Paciente</div>
                            <div class="text-gray-800 font-semibold">{{ $cita->paciente->user->name }}</div>
                        </div>
                        <div>
                            <div class="text-gray-400 font-medium mb-0.5">Médico</div>
                            <div class="text-gray-800 font-semibold">Dr. {{ $cita->medico->user->name }}</div>
                        </div>
                        <div>
                            <div class="text-gray-400 font-medium mb-0.5">Especialidad</div>
                            <div class="text-gray-800 font-semibold">{{ $cita->especialidad->nombre }}</div>
                        </div>
                        <div>
                            <div class="text-gray-400 font-medium mb-0.5">Fecha de consulta</div>
                            <div class="text-gray-800 font-semibold">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-gray-400 font-medium mb-0.5">Motivo</div>
                            <div class="text-gray-700">{{ $cita->motivo }}</div>
                        </div>
                    </div>
                </div>

                {{-- Formulario de pago --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Datos del Pago</h2>

                    <form method="POST" action="{{ route('recepcionista.pagos.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Concepto *</label>
                            <input type="text" name="concepto"
                                value="{{ old('concepto', 'Consulta ' . $cita->especialidad->nombre) }}"
                                required maxlength="255"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('concepto') border-red-300 @enderror">
                            @error('concepto')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Monto (USD) *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">$</span>
                                <input type="number" name="monto" value="{{ old('monto') }}"
                                    required min="0.01" max="99999.99" step="0.01"
                                    placeholder="0.00"
                                    class="w-full pl-8 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('monto') border-red-300 @enderror">
                            </div>
                            @error('monto')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Método de pago *</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metodo_pago" value="efectivo" class="sr-only peer" {{ old('metodo_pago') === 'efectivo' ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:border-gray-300">
                                        <svg class="w-5 h-5 mx-auto mb-1.5 text-gray-500 peer-checked:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span class="text-xs font-semibold text-gray-700">Efectivo</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metodo_pago" value="stripe" class="sr-only peer" {{ old('metodo_pago') === 'stripe' ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                                        <svg class="w-5 h-5 mx-auto mb-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        <span class="text-xs font-semibold text-gray-700">Stripe</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metodo_pago" value="paypal" class="sr-only peer" {{ old('metodo_pago') === 'paypal' ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-gray-300">
                                        <svg class="w-5 h-5 mx-auto mb-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-xs font-semibold text-gray-700">PayPal</span>
                                    </div>
                                </label>
                            </div>
                            @error('metodo_pago')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('recepcionista.citas') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                            <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                                Registrar Pago
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
