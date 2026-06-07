<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'usuarios'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('admin.usuarios.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-gray-900">Editar Usuario</h1>
                <p class="text-xs text-gray-400">{{ $usuario->name }}</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-lg mx-auto">

                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
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

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        {{-- Nombre --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Nombre completo *
                                <span class="font-normal text-gray-400">(solo letras)</span>
                            </label>
                            <input type="text" name="name"
                                   value="{{ old('name', $usuario->name) }}"
                                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Correo electrónico *</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $usuario->email) }}"
                                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Rol --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Rol del usuario *</label>
                            @if($usuario->id === auth()->id())
                                <div class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-500">
                                    {{ $usuario->rol }} <span class="text-xs text-gray-400">(no podés cambiar tu propio rol)</span>
                                </div>
                                <input type="hidden" name="rol" value="{{ $usuario->rol }}">
                            @else
                                <select name="rol" class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white {{ $errors->has('rol') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    <option value="admin"         {{ old('rol', $usuario->rol)==='admin'?'selected':'' }}>Administrador</option>
                                    <option value="medico"        {{ old('rol', $usuario->rol)==='medico'?'selected':'' }}>Médico</option>
                                    <option value="recepcionista" {{ old('rol', $usuario->rol)==='recepcionista'?'selected':'' }}>Recepcionista</option>
                                    <option value="paciente"      {{ old('rol', $usuario->rol)==='paciente'?'selected':'' }}>Paciente</option>
                                </select>
                                @error('rol')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                        {{-- Contraseña --}}
                        <div class="border-t border-gray-100 pt-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Nueva contraseña</p>
                            <p class="text-xs text-gray-400 mb-3">Dejá en blanco para mantener la contraseña actual.</p>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Contraseña <span class="text-gray-400">(mín. 8 caracteres)</span></label>
                                    <input type="password" name="password"
                                           placeholder="••••••••"
                                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    @error('password')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Confirmar contraseña</label>
                                    <input type="password" name="password_confirmation"
                                           placeholder="••••••••"
                                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('admin.usuarios.index') }}"
                               class="flex-1 text-center px-4 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors font-medium">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                                Guardar Cambios
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
