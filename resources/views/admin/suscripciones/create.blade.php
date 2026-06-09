<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Suscripción – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-slate-50 text-gray-900">
<div class="flex h-screen overflow-hidden">
    @include('partials.admin-sidebar', ['activeSection' => 'suscripciones'])
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0 shadow-sm">
            <a href="{{ route('admin.suscripciones.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Nueva Suscripción Premium</h1>
                <p class="text-xs text-gray-400">Asignar membresía a un paciente</p>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-lg mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.suscripciones.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Paciente *</label>
                        <select name="paciente_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none @error('paciente_id') border-red-300 @enderror">
                            <option value="">Seleccioná un paciente</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}" {{ old('paciente_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                            @endforeach
                        </select>
                        @error('paciente_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Plan *</label>
                        <select name="plan" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none">
                            <option value="premium" {{ old('plan') === 'premium' ? 'selected' : '' }}>Premium – Acceso prioritario</option>
                            <option value="premium_plus" {{ old('plan') === 'premium_plus' ? 'selected' : '' }}>Premium Plus – Acceso ilimitado</option>
                        </select>
                        @error('plan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Precio mensual (USD) *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">$</span>
                                <input type="number" name="precio" value="{{ old('precio', '29.99') }}"
                                    required min="1" step="0.01"
                                    class="w-full pl-8 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none @error('precio') border-red-300 @enderror">
                            </div>
                            @error('precio')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Duración (meses) *</label>
                            <input type="number" name="duracion_mes" value="{{ old('duracion_mes', 1) }}"
                                required min="1" max="24"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none @error('duracion_mes') border-red-300 @enderror">
                            @error('duracion_mes')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Fecha de inicio *</label>
                        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}"
                            required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none">
                        @error('fecha_inicio')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Método de pago *</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metodo_pago" value="stripe" class="sr-only peer" {{ old('metodo_pago', 'stripe') === 'stripe' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-gray-300">
                                    <span class="text-xs font-semibold text-gray-700">Stripe</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metodo_pago" value="paypal" class="sr-only peer" {{ old('metodo_pago') === 'paypal' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-gray-300">
                                    <span class="text-xs font-semibold text-gray-700">PayPal</span>
                                </div>
                            </label>
                        </div>
                        @error('metodo_pago')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="bg-purple-50 border border-purple-100 rounded-xl p-3 text-xs text-purple-700">
                        Los pacientes Premium tienen acceso prioritario al agendamiento de citas y descuentos en consultas.
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.suscripciones.index') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                        <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                            Crear Suscripción
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
