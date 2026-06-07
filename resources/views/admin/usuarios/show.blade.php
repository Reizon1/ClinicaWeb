<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle Usuario – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
<div class="flex h-screen overflow-hidden">

    @include('partials.admin-sidebar', ['activeSection' => 'usuarios'])

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.usuarios.index') }}"
                   class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-base font-bold text-gray-900">Detalle de Usuario</h1>
                    <p class="text-xs text-gray-400">{{ $usuario->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin.usuarios.edit', $usuario) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar Usuario
            </a>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-4">

            @php
                $rolColors = [
                    'admin'         => 'bg-purple-100 text-purple-700 border-purple-200',
                    'medico'        => 'bg-blue-100 text-blue-700 border-blue-200',
                    'recepcionista' => 'bg-teal-100 text-teal-700 border-teal-200',
                    'paciente'      => 'bg-gray-100 text-gray-600 border-gray-200',
                ];
                $rolLabels = [
                    'admin'         => 'Administrador',
                    'medico'        => 'Médico',
                    'recepcionista' => 'Recepcionista',
                    'paciente'      => 'Paciente',
                ];
            @endphp

            {{-- Card principal --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-extrabold text-2xl">{{ strtoupper(substr($usuario->name,0,1)) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 flex-wrap">
                            <h2 class="text-lg font-bold text-gray-900">{{ $usuario->name }}</h2>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $rolColors[$usuario->rol] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                {{ $rolLabels[$usuario->rol] ?? $usuario->rol }}
                            </span>
                            @if($usuario->id === auth()->id())
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-500 border border-blue-200">
                                    Tu cuenta
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $usuario->email }}</p>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4 pt-5 border-t border-gray-50">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Registrado el</p>
                        <p class="text-sm text-gray-700">{{ $usuario->created_at->format('d \d\e F \d\e Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Última actualización</p>
                        <p class="text-sm text-gray-700">{{ $usuario->updated_at->format('d \d\e F \d\e Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Email verificado</p>
                        <p class="text-sm {{ $usuario->email_verified_at ? 'text-green-600' : 'text-orange-500' }}">
                            {{ $usuario->email_verified_at ? 'Verificado (' . $usuario->email_verified_at->format('d/m/Y') . ')' : 'Sin verificar' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">ID interno</p>
                        <p class="text-sm text-gray-500 font-mono">#{{ $usuario->id }}</p>
                    </div>
                </div>
            </div>

            {{-- Perfil médico --}}
            @if($usuario->medico)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Perfil Médico
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Especialidad</p>
                        <p class="text-sm text-gray-700">{{ $usuario->medico->especialidad->nombre ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">N° de Licencia</p>
                        <p class="text-sm text-gray-700 font-mono">{{ $usuario->medico->numero_licencia ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Teléfono</p>
                        <p class="text-sm text-gray-700">{{ $usuario->medico->telefono ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Disponibilidad</p>
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $usuario->medico->disponible ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $usuario->medico->disponible ? 'Disponible' : 'No disponible' }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <a href="{{ route('admin.medicos.show', $usuario->medico) }}"
                       class="text-sm text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1.5">
                        Ver perfil médico completo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            {{-- Perfil paciente --}}
            @if($usuario->paciente)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Perfil Paciente
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Fecha de nacimiento</p>
                        <p class="text-sm text-gray-700">
                            {{ $usuario->paciente->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->paciente->fecha_nacimiento)->format('d/m/Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Teléfono</p>
                        <p class="text-sm text-gray-700">{{ $usuario->paciente->telefono ?? '—' }}</p>
                    </div>
                    @if($usuario->paciente->direccion)
                    <div class="col-span-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Dirección</p>
                        <p class="text-sm text-gray-700">{{ $usuario->paciente->direccion }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Sin perfil adicional --}}
            @if(!$usuario->medico && !$usuario->paciente)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center text-gray-400 text-sm">
                Este usuario no tiene perfil médico ni de paciente asociado.
            </div>
            @endif

        </main>
    </div>
</div>
</body>
</html>
