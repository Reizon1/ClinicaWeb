<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Médico – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'medicos'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('admin.medicos.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Editar: {{ $medico->user->name }}</h1>
                <p class="text-xs text-gray-400">{{ $medico->especialidad->nombre }}</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-lg mx-auto">

                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-red-700 mb-1">Corregí los siguientes errores:</p>
                            <ul class="text-sm text-red-600 space-y-0.5">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <form method="POST" action="{{ route('admin.medicos.update', $medico) }}" class="space-y-4">
                        @csrf @method('PUT')

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nombre completo * <span class="font-normal text-gray-400">(solo letras)</span></label>
                            <input type="text" name="name" value="{{ old('name', $medico->user->name) }}" required maxlength="100"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('name')<p class="text-xs text-red-500 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Correo electrónico *</label>
                            <input type="email" name="email" value="{{ old('email', $medico->user->email) }}" required maxlength="150"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('email')<p class="text-xs text-red-500 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Especialidad *</label>
                            <select name="especialidad_id" required class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('especialidad_id') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                @foreach($especialidades as $e)<option value="{{ $e->id }}" {{ old('especialidad_id', $medico->especialidad_id)==$e->id?'selected':'' }}>{{ $e->nombre }}</option>@endforeach
                            </select>
                            @error('especialidad_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Número de licencia * <span class="font-normal text-gray-400">(ej: MP-10245)</span></label>
                            <input type="text" name="numero_licencia" value="{{ old('numero_licencia', $medico->numero_licencia) }}" required maxlength="50"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-mono {{ $errors->has('numero_licencia') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('numero_licencia')<p class="text-xs text-red-500 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Teléfono <span class="font-normal text-gray-400">(solo números)</span></label>
                            <input type="text" name="telefono" value="{{ old('telefono', $medico->telefono) }}" maxlength="20"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('telefono') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('telefono')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Descripción profesional</label>
                            <textarea name="descripcion" rows="3" maxlength="1000"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('descripcion', $medico->descripcion) }}</textarea>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="disponible" id="disponible" value="1" {{ old('disponible', $medico->disponible) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 w-4 h-4">
                            <label for="disponible" class="text-sm text-gray-700 font-medium">Médico disponible para recibir pacientes</label>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('admin.medicos.index') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors font-medium">Cancelar</a>
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">Actualizar Médico</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
