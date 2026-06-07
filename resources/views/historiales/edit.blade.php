<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Historial – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.medico-sidebar', ['activeSection' => 'historiales'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('historiales.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Editar Historial Clínico</h1>
                <p class="text-xs text-gray-400">Paciente: {{ $historial->paciente->user->name }}</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-2xl mx-auto space-y-4">

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-700 mb-1">Corregí los siguientes errores:</p>
                            <ul class="text-sm text-red-600 space-y-0.5">
                                @foreach($errors->all() as $e)
                                    <li>• {{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Info de la cita (solo lectura) --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-700">Cita vinculada</p>
                        <p class="text-sm text-blue-800">
                            {{ $historial->cita?->fecha_hora->format('d/m/Y H:i') ?? 'Sin cita vinculada' }}
                            — {{ $historial->paciente->user->name }}
                        </p>
                        <p class="text-xs text-blue-500 mt-0.5">Fecha del historial: {{ $historial->fecha->format('d \d\e F \d\e Y') }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('historiales.update', $historial) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Diagnóstico *</label>
                            <textarea name="diagnostico" rows="4"
                                      placeholder="Describí el diagnóstico del paciente..."
                                      class="w-full px-4 py-3 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none {{ $errors->has('diagnostico') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">{{ old('diagnostico', $historial->diagnostico) }}</textarea>
                            @error('diagnostico')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tratamiento *</label>
                            <textarea name="tratamiento" rows="4"
                                      placeholder="Detallá el tratamiento indicado..."
                                      class="w-full px-4 py-3 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none {{ $errors->has('tratamiento') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">{{ old('tratamiento', $historial->tratamiento) }}</textarea>
                            @error('tratamiento')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Observaciones <span class="font-normal text-gray-400">(opcional)</span>
                            </label>
                            <textarea name="observaciones" rows="3"
                                      placeholder="Notas adicionales, recomendaciones..."
                                      class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('observaciones', $historial->observaciones) }}</textarea>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('historiales.index') }}"
                               class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
