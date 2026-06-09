<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Cita – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">
    @include('partials.recepcionista-sidebar', ['activeSection' => 'nueva-cita'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('recepcionista.citas') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Agendar Nueva Cita</h1>
                <p class="text-xs text-gray-400">Registrá una cita para un paciente</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-lg mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                @if(session('success'))
                    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('recepcionista.citas.guardar') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Paciente *</label>
                        <select name="paciente_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('paciente_id') border-red-300 @enderror">
                            <option value="">Seleccioná un paciente</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}" {{ old('paciente_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                            @endforeach
                        </select>
                        @error('paciente_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Especialidad *</label>
                        <select name="especialidad_id" id="especialidad_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('especialidad_id') border-red-300 @enderror">
                            <option value="">Seleccioná una especialidad</option>
                            @foreach($especialidades as $e)
                                <option value="{{ $e->id }}" {{ old('especialidad_id') == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>
                            @endforeach
                        </select>
                        @error('especialidad_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Médico *</label>
                        <select name="medico_id" id="medico_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('medico_id') border-red-300 @enderror">
                            <option value="">Primero seleccioná una especialidad</option>
                        </select>
                        @error('medico_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Fecha y Hora *</label>
                        <input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora') }}" required
                            min="{{ now()->addMinutes(30)->format('Y-m-d\TH:i') }}"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('fecha_hora') border-red-300 @enderror">
                        @error('fecha_hora')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Motivo de consulta *</label>
                        <textarea name="motivo" rows="2" required maxlength="500" placeholder="Describí el motivo de la consulta..."
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none resize-none @error('motivo') border-red-300 @enderror">{{ old('motivo') }}</textarea>
                        @error('motivo')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 text-xs text-yellow-700">
                        El sistema validará automáticamente que no haya conflictos de horario para el médico y el paciente seleccionados.
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('recepcionista.citas') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                        <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">Agendar Cita</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
document.getElementById('especialidad_id').addEventListener('change', function() {
    const especialidadId = this.value;
    const medicoSelect = document.getElementById('medico_id');
    medicoSelect.innerHTML = '<option value="">Cargando médicos...</option>';
    if (!especialidadId) { medicoSelect.innerHTML = '<option value="">Primero seleccioná una especialidad</option>'; return; }
    fetch(`/medicos/por-especialidad?especialidad_id=${especialidadId}`)
        .then(r => r.json())
        .then(data => {
            medicoSelect.innerHTML = '<option value="">Seleccioná un médico</option>';
            data.forEach(m => { medicoSelect.innerHTML += `<option value="${m.id}">Dr. ${m.nombre}</option>`; });
            if (data.length === 0) medicoSelect.innerHTML = '<option value="">No hay médicos disponibles</option>';
        });
});
</script>
</body>
</html>
