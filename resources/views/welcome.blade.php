<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Los Mollos - Sistema Hospitalario</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-white text-gray-900">

    {{-- ============================================================
         NAVBAR
    ============================================================ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm leading-tight">Los Mollos</div>
                        <div class="text-xs text-gray-400 leading-tight">Sistema Hospitalario</div>
                    </div>
                </div>

                {{-- Nav links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#inicio"       class="text-sm font-semibold text-blue-600 border-b-2 border-blue-600 pb-0.5">Inicio</a>
                    <a href="#servicios"    class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Especialidades</a>
                    <a href="#medicos"      class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Médicos</a>
                    <a href="#ubicacion"   class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Ubicación</a>
                </div>

                {{-- Auth buttons --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors px-4 py-2 rounded-lg hover:bg-gray-50">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors px-5 py-2 rounded-lg shadow-sm">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================================
         HERO
    ============================================================ --}}
    <section id="inicio" class="pt-16 min-h-screen flex items-center"
             style="background: linear-gradient(135deg,#f0f7ff 0%,#e8f4fd 50%,#ffffff 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Texto --}}
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-4 py-1.5 mb-7">
                        <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                        <span class="text-xs font-semibold text-blue-700 tracking-wide">Sistema de Gestión Digital 2026</span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                        Tu salud en<br>
                        <span class="text-blue-600">manos expertas</span>
                    </h1>

                    <p class="text-lg text-gray-500 mb-9 leading-relaxed max-w-md">
                        Plataforma integral para la gestión hospitalaria. Optimiza citas, historiales clínicos y pagos con la tecnología más segura y eficiente del mercado.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 mb-8">
                        <a href="#" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3.5 rounded-xl transition-colors shadow-lg shadow-blue-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Agendar Cita
                        </a>
                        <a href="#" class="inline-flex items-center gap-2 text-gray-700 font-semibold px-6 py-3.5 rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors bg-white">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                            Ver Demo
                        </a>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-500">Soporte 24/7</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-500">Datos Seguros</span>
                        </div>
                    </div>
                </div>

                {{-- Imagen + estadística --}}
                <div class="relative flex justify-center">
                    <div class="relative w-full max-w-md">
                        <div class="rounded-3xl overflow-hidden h-[420px] flex items-center justify-center shadow-2xl shadow-blue-100"
                             style="background: linear-gradient(135deg,#bfdbfe,#93c5fd,#60a5fa);">
                            <svg class="w-56 h-56 text-blue-300/70" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                            <div class="absolute top-4 right-4 w-16 h-16 bg-white/20 rounded-2xl"></div>
                            <div class="absolute bottom-8 left-4 w-10 h-10 bg-white/15 rounded-xl"></div>
                        </div>

                        {{-- Card estadística --}}
                        <div class="absolute -bottom-5 -left-6 bg-white rounded-2xl shadow-xl p-4 border border-gray-100 min-w-[200px]">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400 mb-0.5">Pacientes Atendidos</div>
                                    <div class="text-2xl font-bold text-gray-900">4,592</div>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-green-500">+15.9% este mes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         SERVICIOS
    ============================================================ --}}
    <section id="servicios" class="py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Soluciones integrales para tu centro médico
                </h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    Herramientas diseñadas para optimizar el flujo de trabajo, mejorar la atención al paciente y asegurar la rentabilidad.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                {{-- Card Citas --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Gestión de Citas</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Sistema inteligente de agendamiento con recordatorios automáticos por SMS y correo electrónico para reducir el ausentismo.
                    </p>
                    <a href="#" class="text-blue-600 text-sm font-semibold inline-flex items-center gap-1 group hover:underline">
                        Conocer más
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- Card Historial --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Historial Clínico Digital</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Acceso seguro e inmediato a expedientes médicos, recetas electrónicas y resultados de laboratorio desde cualquier dispositivo.
                    </p>
                    <a href="#" class="text-teal-600 text-sm font-semibold inline-flex items-center gap-1 group hover:underline">
                        Conocer más
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- Card Pagos --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Pagos Seguros</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Integración nativa con PayPal y Stripe para cobros de consultas, procedimientos y copagos con máxima seguridad y encriptación.
                    </p>
                    <div class="flex items-center gap-1 text-gray-400">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z"/>
                            <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs font-semibold text-indigo-500 tracking-wider">stripe</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         PLAN PREMIUM
    ============================================================ --}}
    <section id="premium" class="py-28" style="background: linear-gradient(135deg,#0f2a4a 0%,#1a3d6b 60%,#1e4a80 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Texto --}}
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 bg-yellow-400/15 border border-yellow-400/25 rounded-full px-4 py-1.5 mb-7">
                        <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-xs font-bold text-yellow-400 uppercase tracking-widest">Plan Premium</span>
                    </div>

                    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-5">
                        Lleva tu clínica al<br>siguiente nivel
                    </h2>
                    <p class="text-blue-200 text-lg mb-9 leading-relaxed">
                        Desbloquea analíticas avanzadas, telemedicina integrada y soporte prioritario 24/7. Ideal para hospitales y clínicas de alto flujo.
                    </p>

                    <ul class="space-y-4 mb-10">
                        @foreach(['Usuarios médicos ilimitados','Módulo de Telemedicina HD (Zoom API)','Dashboard de analíticas predictivas','API access para integraciones externas'] as $feature)
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-green-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-blue-100">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex items-center gap-5">
                        <button class="bg-white text-gray-900 font-semibold px-7 py-3.5 rounded-xl hover:bg-gray-100 transition-colors shadow-lg">
                            Actualizar a Premium
                        </button>
                        <span class="text-blue-300 text-sm">Desde $99/mes</span>
                    </div>
                </div>

                {{-- Gráfico financiero (mockup visual) --}}
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 shadow-2xl">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <div class="text-white font-semibold">Resumen Financiero</div>
                            <div class="text-blue-300 text-xs mt-0.5">Actualizado hace 5 min</div>
                        </div>
                        <div class="bg-green-400/15 border border-green-400/25 rounded-full px-3 py-1.5">
                            <span class="text-green-400 text-xs font-semibold">+24.5% vs Mes anterior</span>
                        </div>
                    </div>

                    <div class="flex items-end gap-2" style="height:160px;">
                        @php
                            $bars = ['Lun'=>42,'Mar'=>55,'Mie'=>47,'Jue'=>65,'Vie'=>72,'Sab'=>83,'Dom'=>100];
                        @endphp
                        @foreach($bars as $day => $h)
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg"
                                 style="height:{{ $h }}%; background:{{ $day === 'Dom' ? '#3b82f6' : 'rgba(255,255,255,0.22)' }};"></div>
                            <span class="text-xs text-blue-300">{{ $day }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         UBICACIÓN
    ============================================================ --}}
    <section id="ubicacion" class="py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-14 items-start">

                {{-- Info --}}
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-4 py-1.5 mb-6">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs font-semibold text-blue-700">Nuestra Ubicación</span>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Visita nuestras instalaciones centrales</h2>
                    <p class="text-gray-400 mb-10 leading-relaxed">
                        Visita nuestras instalaciones centrales para conocer de primera mano cómo Sistema Web Hospitalario puede transformar tu gestión médica.
                    </p>

                    <div class="space-y-7">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl border border-gray-100 shadow-sm flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm mb-0.5">Sede Principal</div>
                                <div class="text-gray-400 text-sm">Av. Tecnológica 1024, Edificio Innova</div>
                                <div class="text-gray-400 text-sm">Ciudad Capital, CP 10000</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl border border-gray-100 shadow-sm flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm mb-0.5">Contacto Directo</div>
                                <div class="text-gray-400 text-sm">+1 (555) 123-4567</div>
                                <div class="text-gray-400 text-sm">soporte@losmollos.com</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl border border-gray-100 shadow-sm flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm mb-0.5">Horario de Atención</div>
                                <div class="text-gray-400 text-sm">Lunes a Viernes: 8:00 AM – 6:00 PM</div>
                                <div class="text-gray-400 text-sm">Sábados: 9:00 AM – 1:00 PM</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mapa (placeholder — Leaflet se integra en la etapa de lógica) --}}
                <div class="rounded-2xl overflow-hidden border border-gray-200 relative bg-gray-100 shadow-sm" style="height:360px;">
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
                        <svg class="w-20 h-20 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">Mapa Interactivo — Leaflet</span>
                        <span class="text-xs mt-1 text-gray-300">Se integrará en la etapa de lógica</span>
                    </div>
                    <div class="absolute top-3 right-3 flex flex-col gap-1">
                        <div class="w-7 h-7 bg-white rounded border border-gray-200 flex items-center justify-center shadow-sm text-gray-500 font-bold text-sm">+</div>
                        <div class="w-7 h-7 bg-white rounded border border-gray-200 flex items-center justify-center shadow-sm text-gray-500 font-bold text-sm">−</div>
                    </div>
                    <div class="absolute bottom-3 right-3">
                        <button class="bg-white text-gray-600 text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm hover:bg-gray-50 inline-flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Cómo llegar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         FOOTER
    ============================================================ --}}
    <footer class="bg-gray-900 text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12 pb-12 border-b border-gray-800">

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold text-sm">Sistema Web Hospitalario</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-6 max-w-xs">
                        Plataforma líder en gestión médica digital. Desarrollada como proyecto de excelencia académica para revolucionar la administración de la salud.
                    </p>
                    <div class="flex items-center gap-2">
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-widest mb-5">Producto</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Características</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Precios (Premium)</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Seguridad</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Actualizaciones</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-widest mb-5">Proyecto</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Materia: Programación Web II</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Equipo: Los Mollos</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Gestión: 2026</a></li>
                        <li><a href="#" class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors">Documentación Técnica</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs">© 2026 Los Mollos – Sistema de Gestión Clínica. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-xs hover:text-white transition-colors">Términos de Servicio</a>
                    <a href="#" class="text-xs hover:text-white transition-colors">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
