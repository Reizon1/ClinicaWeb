<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.medico-sidebar', ['activeSection' => 'perfil'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">Mi Perfil</h1>
                <p class="text-xs text-gray-400">Información y configuración de tu cuenta</p>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-5">

            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-700 mb-1">Corregí los siguientes errores:</p>
                        <ul class="text-sm text-red-600 space-y-0.5">
                            @foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-3 gap-5">

                {{-- Columna izquierda: tarjeta de perfil + stats --}}
                <div class="space-y-4">

                    {{-- Tarjeta principal --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="h-20" style="background:linear-gradient(135deg,#1e3a8a,#2563eb)"></div>
                        <div class="px-5 pb-5">
                            <div class="-mt-8 mb-4">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-extrabold text-2xl shadow-lg border-4 border-white"
                                     style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                            </div>
                            <h2 class="text-base font-bold text-gray-900">Dr. {{ $user->name }}</h2>
                            <p class="text-sm text-blue-600 font-medium">{{ $medico->especialidad->nombre }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>

                            <div class="mt-4 pt-4 border-t border-gray-50 space-y-2">
                                <div class="flex items-center gap-2.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Licencia: <span class="font-medium text-gray-700">{{ $medico->numero_licencia ?? 'No registrada' }}</span>
                                </div>
                                @if($medico->telefono)
                                <div class="flex items-center gap-2.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $medico->telefono }}
                                </div>
                                @endif
                                <div class="flex items-center gap-2.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Miembro desde {{ $user->created_at->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">Estadísticas</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Total de citas</span>
                                <span class="text-sm font-bold text-gray-900">{{ $totalCitas }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Citas completadas</span>
                                <span class="text-sm font-bold text-green-600">{{ $citasCompletadas }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Historiales creados</span>
                                <span class="text-sm font-bold text-blue-600">{{ $totalHistoriales }}</span>
                            </div>
                            @if($totalCitas > 0)
                            <div class="pt-2 border-t border-gray-50">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs text-gray-500">Tasa de completadas</span>
                                    <span class="text-xs font-semibold text-gray-700">{{ round($citasCompletadas / $totalCitas * 100) }}%</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full" style="width:{{ round($citasCompletadas / $totalCitas * 100) }}%"></div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Disponibilidad --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-semibold text-gray-900">Disponibilidad</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Estado actual en el sistema</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $medico->disponible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $medico->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: formulario de edición --}}
                <div class="col-span-2">
                    <form method="POST" action="{{ route('medico.perfil.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        {{-- Datos personales --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Datos Personales
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                        Nombre completo * <span class="font-normal text-gray-400">(solo letras)</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Correo electrónico *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                        Teléfono <span class="font-normal text-gray-400">(solo dígitos)</span>
                                    </label>
                                    <input type="text" name="telefono" value="{{ old('telefono', $medico->telefono) }}"
                                           placeholder="+54 9 11 0000-0000"
                                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('telefono') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    @error('telefono')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Especialidad</label>
                                    <div class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-500">
                                        {{ $medico->especialidad->nombre }}
                                        <span class="text-xs text-gray-400">(modificar desde Administración)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Cambio de contraseña --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Cambiar Contraseña
                            </h3>
                            <p class="text-xs text-gray-400 mb-4">Dejá en blanco para mantener la contraseña actual.</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nueva contraseña <span class="font-normal text-gray-400">(mín. 8 caracteres)</span></label>
                                    <input type="password" name="password" placeholder="••••••••"
                                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Confirmar contraseña</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>
                        </div>

                        {{-- Horarios --}}
                        @if($medico->horarios->count())
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Mis Horarios
                                </h3>
                                <a href="{{ route('horarios.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Gestionar →</a>
                            </div>
                            @php
                                $dias = ['lunes'=>'Lunes','martes'=>'Martes','miercoles'=>'Miércoles','jueves'=>'Jueves','viernes'=>'Viernes','sabado'=>'Sábado','domingo'=>'Domingo'];
                                $orden = array_flip(array_keys($dias));
                                $horariosOrdenados = $medico->horarios->sortBy(fn($h) => $orden[$h->dia_semana] ?? 7);
                            @endphp
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($horariosOrdenados as $h)
                                <div class="flex items-center gap-2.5 bg-blue-50 rounded-xl px-3 py-2.5">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full flex-shrink-0"></div>
                                    <div>
                                        <p class="text-xs font-semibold text-blue-800">{{ $dias[$h->dia_semana] ?? $h->dia_semana }}</p>
                                        <p class="text-xs text-blue-600">{{ substr($h->hora_inicio,0,5) }} – {{ substr($h->hora_fin,0,5) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('dashboard.medico') }}"
                               class="px-5 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
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
