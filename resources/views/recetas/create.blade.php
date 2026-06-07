<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Receta – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    <aside class="w-56 flex-shrink-0 flex flex-col" style="background:linear-gradient(180deg,#1e3a8a 0%,#1d4ed8 60%,#2563eb 100%);">
        <div class="px-5 py-5 border-b border-white/10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">Los Mollos</div>
                    <div class="text-blue-200 text-xs">MEDICAL ZONE</div>
                </div>
            </div>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard.medico') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('recetas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/15 text-white text-sm font-semibold mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                Recetas
            </a>
        </nav>
        <div class="px-3 py-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-red-300 hover:bg-red-500/20 text-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('recetas.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Emitir Receta Médica</h1>
                <p class="text-xs text-gray-400">Registrá los medicamentos indicados al paciente</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('recetas.store') }}" class="space-y-5" id="recetaForm">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Cita *</label>
                        <select name="cita_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('cita_id') border-red-300 @enderror">
                            <option value="">Seleccioná la cita correspondiente</option>
                            @foreach($citas as $cita)
                                <option value="{{ $cita->id }}" {{ (old('cita_id') == $cita->id || ($citaSeleccionada && $citaSeleccionada->id == $cita->id)) ? 'selected' : '' }}>
                                    {{ $cita->fecha_hora->format('d/m/Y H:i') }} – {{ $cita->paciente->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cita_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Medicamentos dinámicos --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-semibold text-gray-600">Medicamentos *</label>
                            <button type="button" onclick="agregarMedicamento()" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Agregar medicamento
                            </button>
                        </div>
                        <div id="medicamentosContainer" class="space-y-3">
                            <div class="medicamento-item bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="col-span-2">
                                        <label class="text-xs text-gray-500 mb-1 block">Nombre del medicamento *</label>
                                        <input type="text" name="medicamentos[0][nombre]" required maxlength="200" placeholder="Ej: Ibuprofeno 400mg"
                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">Dosis *</label>
                                        <input type="text" name="medicamentos[0][dosis]" required maxlength="100" placeholder="Ej: 1 comprimido"
                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">Frecuencia *</label>
                                        <input type="text" name="medicamentos[0][frecuencia]" required maxlength="100" placeholder="Ej: Cada 8 horas"
                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">Duración (días) *</label>
                                        <input type="number" name="medicamentos[0][dias]" required min="1" max="365" placeholder="7"
                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Indicaciones generales <span class="text-gray-400 font-normal">(opcional)</span></label>
                        <textarea name="indicaciones" rows="2" maxlength="1000" placeholder="Indicaciones adicionales para el paciente..."
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('indicaciones') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Fecha de vencimiento *</label>
                        <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" required
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('fecha_vencimiento') border-red-300 @enderror">
                        @error('fecha_vencimiento')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('recetas.index') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">Emitir Receta</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
let medIdx = 1;
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
                <input type="text" name="medicamentos[${idx}][nombre]" required maxlength="200" placeholder="Ej: Amoxicilina 500mg"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Dosis *</label>
                <input type="text" name="medicamentos[${idx}][dosis]" required maxlength="100" placeholder="Ej: 1 cápsula"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Frecuencia *</label>
                <input type="text" name="medicamentos[${idx}][frecuencia]" required maxlength="100" placeholder="Ej: Cada 12 horas"
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
