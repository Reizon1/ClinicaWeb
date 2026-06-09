<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Paciente – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">
    @include('partials.recepcionista-sidebar', ['activeSection' => 'pacientes'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('dashboard.recepcionista') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Registrar Nuevo Paciente</h1>
                <p class="text-xs text-gray-400">Completá los datos del paciente</p>
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

                <form method="POST" action="{{ route('recepcionista.pacientes.guardar') }}" class="space-y-5">
                    @csrf

                    <div class="pb-3 border-b border-gray-100">
                        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Datos de acceso</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nombre completo *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nombre y apellido"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('name') border-red-300 @enderror">
                            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Correo electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="paciente@email.com"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('email') border-red-300 @enderror">
                            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Contraseña *</label>
                            <input type="password" name="password" required minlength="8" placeholder="Mínimo 8 caracteres"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('password') border-red-300 @enderror">
                            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Confirmar contraseña *</label>
                            <input type="password" name="password_confirmation" required minlength="8" placeholder="Repetí la contraseña"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                    </div>

                    <div class="pb-3 border-b border-gray-100 pt-2">
                        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Datos clínicos</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Fecha de nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('fecha_nacimiento') border-red-300 @enderror">
                            @error('fecha_nacimiento')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Género *</label>
                            <select name="genero" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none @error('genero') border-red-300 @enderror">
                                <option value="">Seleccioná</option>
                                <option value="masculino" {{ old('genero')=='masculino'?'selected':'' }}>Masculino</option>
                                <option value="femenino" {{ old('genero')=='femenino'?'selected':'' }}>Femenino</option>
                                <option value="otro" {{ old('genero')=='otro'?'selected':'' }}>Otro</option>
                            </select>
                            @error('genero')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" maxlength="20" placeholder="+54 9 ..."
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tipo de sangre</label>
                            <select name="tipo_sangre" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                                <option value="">No sabe / No informa</option>
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                                    <option value="{{ $ts }}" {{ old('tipo_sangre')==$ts?'selected':'' }}>{{ $ts }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" maxlength="255" placeholder="Calle y número"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Alergias conocidas</label>
                            <textarea name="alergias" rows="2" maxlength="500" placeholder="Ej: Penicilina, látex..."
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none resize-none">{{ old('alergias') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Enfermedades previas</label>
                            <textarea name="enfermedades_previas" rows="2" maxlength="500" placeholder="Ej: Diabetes tipo 2, hipertensión..."
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none resize-none">{{ old('enfermedades_previas') }}</textarea>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('dashboard.recepcionista') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                        <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">Registrar Paciente</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
