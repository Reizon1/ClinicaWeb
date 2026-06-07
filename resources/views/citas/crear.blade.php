<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendar Cita — Los Mollos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">Los Mollos</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('medicos.buscar') }}" class="text-sm text-gray-500 hover:text-blue-600">Ver médicos</a>
                <a href="{{ route('dashboard.paciente') }}" class="text-sm text-gray-500 hover:text-blue-600">Mi Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-12">

        {{-- Encabezado --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Agendar una cita</h1>
            <p class="text-gray-500 mt-1">Completá el formulario y un médico confirmará tu cita.</p>
        </div>

        {{-- Alerta de éxito (si viene desde otra pantalla) --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('citas.store') }}"
              x-data="citaForm()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
            @csrf

            {{-- Errores generales --}}
            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- 1. Especialidad --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Especialidad <span class="text-red-500">*</span>
                </label>
                <select name="especialidad_id"
                        x-model="especialidadId"
                        @change="cargarMedicos()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('especialidad_id') border-red-400 @enderror">
                    <option value="">Seleccioná una especialidad</option>
                    @foreach ($especialidades as $esp)
                        <option value="{{ $esp->id }}"
                            {{ old('especialidad_id') == $esp->id ? 'selected' : '' }}>
                            {{ $esp->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('especialidad_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 2. Médico --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Médico <span class="text-red-500">*</span>
                </label>
                <select name="medico_id"
                        x-model="medicoId"
                        :disabled="medicos.length === 0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-400 @error('medico_id') border-red-400 @enderror">
                    <option value="">
                        <span x-text="cargando ? 'Cargando...' : (medicos.length === 0 ? 'Primero elegí una especialidad' : 'Seleccioná un médico')"></span>
                    </option>
                    <template x-for="m in medicos" :key="m.id">
                        <option :value="m.id" x-text="m.nombre"></option>
                    </template>
                    {{-- Médicos pre-cargados desde el servidor (para errores de validación) --}}
                    @foreach ($medicos as $med)
                        @if(!old('especialidad_id'))
                            <option value="{{ $med->id }}" {{ old('medico_id') == $med->id ? 'selected' : '' }}>
                                {{ $med->user->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('medico_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Fecha y hora --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Fecha y hora <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local"
                       name="fecha_hora"
                       value="{{ old('fecha_hora') }}"
                       min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_hora') border-red-400 @enderror">
                @error('fecha_hora')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 4. Motivo --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Motivo de la consulta <span class="text-red-500">*</span>
                </label>
                <textarea name="motivo" rows="3" maxlength="500"
                          placeholder="Describí brevemente por qué necesitás la consulta..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none @error('motivo') border-red-400 @enderror">{{ old('motivo') }}</textarea>
                @error('motivo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 text-white text-sm font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    Confirmar Cita
                </button>
                <a href="{{ route('dashboard.paciente') }}"
                   class="px-6 py-3 text-sm text-gray-500 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        function citaForm() {
            return {
                especialidadId: '{{ old('especialidad_id') }}',
                medicoId: '{{ old('medico_id') }}',
                medicos: [],
                cargando: false,

                cargarMedicos() {
                    this.medicos = [];
                    this.medicoId = '';

                    if (!this.especialidadId) return;

                    this.cargando = true;
                    fetch(`/medicos/por-especialidad?especialidad_id=${this.especialidadId}`)
                        .then(r => r.json())
                        .then(data => {
                            this.medicos = data;
                            this.cargando = false;
                        })
                        .catch(() => { this.cargando = false; });
                }
            }
        }
    </script>

</body>
</html>
