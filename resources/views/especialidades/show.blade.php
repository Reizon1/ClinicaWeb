<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $especialidad->nombre }} - Los Mollos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    {{-- ============================================================
         NAVBAR
    ============================================================ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 text-sm leading-tight">Los Mollos</div>
                            <div class="text-xs text-gray-400 leading-tight">Sistema Hospitalario</div>
                        </div>
                    </a>
                </div>

                {{-- Nav links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Inicio</a>
                    <a href="{{ route('especialidades.index') }}" class="text-sm font-semibold text-blue-600 border-b-2 border-blue-600 pb-0.5">Especialidades</a>
                    <a href="{{ route('medicos.buscar') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Médicos</a>
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
         HEADER
    ============================================================ --}}
    <section class="pt-20 pb-8 bg-gradient-to-b from-blue-50 via-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('especialidades.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Volver
                </a>
            </div>

            <div class="flex items-start gap-6">
                {{-- Icon --}}
                @if($especialidad->icono)
                    <div class="text-6xl">{{ $especialidad->icono }}</div>
                @else
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                @endif

                <div class="flex-1">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-3">
                        {{ $especialidad->nombre }}
                    </h1>
                    @if($especialidad->descripcion)
                        <p class="text-lg text-gray-600 mb-4">
                            {{ $especialidad->descripcion }}
                        </p>
                    @endif
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-gray-600">Disponible 24/7</span>
                        </div>
                        <div class="text-gray-600">
                            {{ $medicos->count() }} médico{{ $medicos->count() !== 1 ? 's' : '' }} disponible{{ $medicos->count() !== 1 ? 's' : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         MÉDICOS
    ============================================================ --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-12">
                Nuestros Médicos Especialistas
            </h2>

            @if($medicos->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-lg">No hay médicos disponibles en este momento</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($medicos as $medico)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg hover:border-blue-300 transition-all duration-300">
                            
                            {{-- Header --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center border-2 border-blue-200">
                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        @if($medico->activo)
                                            <div class="flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                En línea
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="px-6 py-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                    {{ $medico->user->name ?? 'Dr. ' . $medico->apellido }}
                                </h3>
                                
                                @if($medico->profesional)
                                    <p class="text-sm text-gray-500 mb-4">
                                        Lic. {{ $medico->profesional }}
                                    </p>
                                @endif

                                {{-- Rating and Reviews --}}
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="flex items-center gap-1">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="w-4 h-4 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">(24 opiniones)</span>
                                </div>

                                {{-- Info --}}
                                <div class="space-y-3 border-t border-gray-200 pt-4">
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-gray-700">Disponible hoy</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <span class="text-gray-700">Tiempo de consulta: 30 min</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                                <a href="{{ route('register') }}"
                                   class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                                    Agendar cita
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============================================================
         CALL TO ACTION
    ============================================================ --}}
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-6">
                ¿Necesitas una consulta?
            </h2>
            <p class="text-blue-100 mb-8 text-lg">
                Nuestros especialistas en {{ $especialidad->nombre }} están listos para ayudarte
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 bg-white text-blue-600 font-semibold px-8 py-4 rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                    Crear cuenta y agendar
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('especialidades.index') }}"
                   class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-8 py-4 rounded-xl transition-colors">
                    Ver otras especialidades
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
         FOOTER
    ============================================================ --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-white">Los Mollos</div>
                            <div class="text-xs text-gray-500">Sistema Hospitalario</div>
                        </div>
                    </div>
                    <p class="text-sm">Plataforma integral para la gestión hospitalaria</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Producto</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Características</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Precios</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Seguridad</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Empresa</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Sobre nosotros</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Privacidad</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Términos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 Los Mollos. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
