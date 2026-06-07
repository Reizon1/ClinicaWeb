<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Especialidad – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">
    @include('partials.admin-sidebar', ['activeSection' => 'especialidades'])
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('admin.especialidades.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-base font-bold text-gray-900">Nueva Especialidad</h1>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-lg mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4"><ul class="text-sm text-red-600 space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('admin.especialidades.store') }}" class="space-y-4">
                    @csrf
                    <div><label class="block text-xs font-semibold text-gray-600 mb-1.5">Nombre de la especialidad *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="100" placeholder="Ej: Cardiología" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('nombre') border-red-300 @enderror">
                    @error('nombre')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-xs font-semibold text-gray-600 mb-1.5">Descripción</label>
                    <textarea name="descripcion" rows="3" maxlength="500" placeholder="Describí brevemente la especialidad..." class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('descripcion') }}</textarea></div>
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.especialidades.index') }}" class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">Crear Especialidad</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
