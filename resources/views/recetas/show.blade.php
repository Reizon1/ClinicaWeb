<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receta Médica – Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>body{font-family:'Inter',sans-serif;} @media print{aside,header,a{display:none!important;} .print-area{box-shadow:none!important;border:1px solid #ccc!important;}}</style>
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
            <a href="{{ route('recetas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/15 text-white text-sm font-semibold mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                Recetas
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <a href="{{ route('recetas.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-base font-bold text-gray-900">Receta Médica</h1>
                    <p class="text-xs text-gray-400">{{ $receta->paciente->user->name }} – {{ $receta->fecha_emision->format('d/m/Y') }}</p>
                </div>
            </div>
            <button onclick="window.print()" class="bg-gray-700 hover:bg-gray-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Imprimir
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-2xl mx-auto space-y-4 print-area">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                        <div>
                            <h2 class="text-lg font-bold text-blue-800">Hospital Los Mollos</h2>
                            <p class="text-xs text-gray-400">Sistema Hospitalario Digital</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">Fecha de emisión</p>
                            <p class="text-sm font-bold text-gray-700">{{ $receta->fecha_emision->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-xs text-gray-400 block">Paciente</span><span class="font-semibold">{{ $receta->paciente->user->name }}</span></div>
                        <div><span class="text-xs text-gray-400 block">Médico</span><span class="font-semibold">Dr. {{ $receta->medico->user->name }}</span></div>
                        <div><span class="text-xs text-gray-400 block">Especialidad</span><span class="font-semibold">{{ $receta->medico->especialidad->nombre }}</span></div>
                        <div>
                            <span class="text-xs text-gray-400 block">Vencimiento</span>
                            <span class="font-semibold {{ $receta->fecha_vencimiento->isPast() ? 'text-red-500' : 'text-green-600' }}">
                                {{ $receta->fecha_vencimiento->format('d/m/Y') }}
                                @if($receta->fecha_vencimiento->isPast()) (Vencida) @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-4">Medicamentos Indicados</h3>
                    <div class="space-y-3">
                        @foreach($receta->medicamentos as $i => $med)
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-5 h-5 bg-blue-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $i+1 }}</span>
                                <span class="font-semibold text-gray-800 text-sm">{{ $med['nombre'] }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-xs text-gray-600">
                                <div><span class="text-gray-400 block">Dosis</span>{{ $med['dosis'] }}</div>
                                <div><span class="text-gray-400 block">Frecuencia</span>{{ $med['frecuencia'] }}</div>
                                <div><span class="text-gray-400 block">Duración</span>{{ $med['dias'] }} día(s)</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($receta->indicaciones)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Indicaciones Generales</h3>
                    <p class="text-sm text-gray-700 leading-relaxed bg-yellow-50 rounded-xl p-4">{{ $receta->indicaciones }}</p>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>
</body>
</html>
