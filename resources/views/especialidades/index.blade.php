<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Especialidades - Los Mollos</title>
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
                    <a href="/"                     class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Inicio</a>
                    <a href="{{ route('especialidades.index') }}" class="text-sm font-semibold text-blue-600 border-b-2 border-blue-600 pb-0.5">Especialidades</a>
                    <a href="{{ route('medicos.buscar') }}"      class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Médicos</a>
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
    <section class="pt-20 pb-12 bg-gradient-to-b from-blue-50 via-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-4">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">
                    Nuestras Especialidades
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Contamos con especialistas en diversas áreas de la medicina para brindarte la mejor atención
                </p>
            </div>
        </div>
    </section>

    {{-- ============================================================
         ESPECIALIDADES GRID
    ============================================================ --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($especialidades->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No hay especialidades disponibles en este momento</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($especialidades as $especialidad)
                        <a href="{{ route('especialidades.show', $especialidad) }}"
                           class="group bg-white rounded-2xl border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-300 overflow-hidden">
                            
                            {{-- Header --}}
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 px-6 py-8 group-hover:from-blue-100 group-hover:to-indigo-100 transition-colors">
                                @if($especialidad->icono)
                                    <div class="text-5xl mb-3">{{ $especialidad->icono }}</div>
                                @else
                                    <svg class="w-12 h-12 text-blue-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="px-6 py-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                                    {{ $especialidad->nombre }}
                                </h3>
                                
                                @if($especialidad->descripcion)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ $especialidad->descripcion }}
                                    </p>
                                @endif

                                {{-- Médicos count --}}
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.5 1.5H4.75A2.25 2.25 0 002.5 3.75v12.5A2.25 2.25 0 004.75 18.5h10.5a2.25 2.25 0 002.25-2.25V3.75a2.25 2.25 0 00-2.25-2.25z"/>
                                    </svg>
                                    <span>{{ $especialidad->medicos->count() }} médico{{ $especialidad->medicos->count() !== 1 ? 's' : '' }}</span>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 group-hover:bg-blue-50 transition-colors">
                                <span class="text-blue-600 font-semibold text-sm flex items-center gap-2">
                                    Ver más
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
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
                ¿Listo para agendar una cita?
            </h2>
            <p class="text-blue-100 mb-8 text-lg">
                Selecciona una especialidad y encuentra el médico perfecto para ti
            </p>
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 bg-white text-blue-600 font-semibold px-8 py-4 rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                Crear cuenta
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
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
