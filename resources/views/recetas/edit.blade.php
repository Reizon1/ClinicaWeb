<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Receta – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.medico-sidebar', ['activeSection' => 'recetas'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('recetas.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Editar Receta Médica</h1>
                <p class="text-xs text-gray-400">Paciente: {{ $receta->paciente->user->name }}</p>
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

                {{-- Info de la cita --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-700">Receta del</p>
                        <p class="text-sm text-blue-800">
                            {{ $receta->fecha_emision->format('d \d\e F \d\e Y') }}
                            — {{ $receta->paciente->user->name }}
                        </p>
                        <p class="text-xs text-blue-500 mt-0.5">
                            Cita: {{ $receta->cita?->fecha_hora->format('d/m/Y H:i') ?? 'Sin cita vinculada' }}
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('recetas.update', $receta) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">

                        {{-- Medicamentos --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="text-xs font-semibold text-gray-600">Medicamentos *</label>
                                <button type="button" onclick="agregarMedicamento()"
                                        class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Agregar medicamento
                                </button>
                            </div>
                            <div id="medicamentosContainer" class="space-y-3">
                                @php $medicamentos = old('medicamentos', $receta->medicamentos); @endphp
                                @foreach($medicamentos as $i => $med)
                                <div class="medicamento-item bg-gray-50 rounded-xl p-4 border border-gray-200">
                                    @if($i > 0)
                                    <div class="flex justify-end mb-2">
                                        <button type="button" onclick="this.closest('.medicamento-item').remove()"
                                                class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                                    </div>
                                    @endif
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="col-span-2">
                                            <label class="text-xs text-gray-500 mb-1 block">Nombre del medicamento *</label>
                                            <input type="text" name="medicamentos[{{ $i }}][nombre]" required maxlength="200"
                                                   value="{{ $med['nombre'] ?? '' }}"
                                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500 mb-1 block">Dosis *</label>
                                            <input type="text" name="medicamentos[{{ $i }}][dosis]" required maxlength="100"
                                                   value="{{ $med['dosis'] ?? '' }}"
                                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500 mb-1 block">Frecuencia *</label>
                                            <input type="text" name="medicamentos[{{ $i }}][frecuencia]" required maxlength="100"
                                                   value="{{ $med['frecuencia'] ?? '' }}"
                                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500 mb-1 block">Duración (días) *</label>
                                            <input type="number" name="medicamentos[{{ $i }}][dias]" required min="1" max="365"
                                                   value="{{ $med['dias'] ?? '' }}"
                                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Indicaciones --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Indicaciones generales <span class="font-normal text-gray-400">(opcional)</span>
                            </label>
                            <textarea name="indicaciones" rows="3" maxlength="1000"
                                      placeholder="Indicaciones adicionales para el paciente..."
                                      class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('indicaciones', $receta->indicaciones) }}</textarea>
                        </div>

                        {{-- Fecha vencimiento --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Fecha de vencimiento *</label>
                            <input type="date" name="fecha_vencimiento"
                                   value="{{ old('fecha_vencimiento', $receta->fecha_vencimiento->format('Y-m-d')) }}"
                                   required
                                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('fecha_vencimiento') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('fecha_vencimiento')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('recetas.index') }}"
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

<script>
let medIdx = {{ count(old('medicamentos', $receta->medicamentos)) }};
function agregarMedicamento() {
    const container = document.getElementById('medicamentosContainer');
    const idx = medIdx++;
    const div = document.createElement('div');
    div.className = 'medicamento-item bg-gray-50 rounded-xl p-4 border border-gray-200';
    div.innerHTML = `
        <div class="flex justify-end mb-2">
            <button type="button" onclick="this.closest('.medicamento-item').remove()" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div class="col-span-2">
                <label class="text-xs text-gray-500 mb-1 block">Nombre del medicamento *</label>
                <input type="text" name="medicamentos[${idx}][nombre]" required maxlength="200" placeholder="Nombre del medicamento"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Dosis *</label>
                <input type="text" name="medicamentos[${idx}][dosis]" required maxlength="100" placeholder="Ej: 1 comprimido"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Frecuencia *</label>
                <input type="text" name="medicamentos[${idx}][frecuencia]" required maxlength="100" placeholder="Ej: Cada 8 horas"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Duración (días) *</label>
                <input type="number" name="medicamentos[${idx}][dias]" required min="1" max="365" placeholder="7"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>`;
    container.appendChild(div);
}
</script>
</body>
</html>
