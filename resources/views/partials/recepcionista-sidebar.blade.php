@php $active = $activeSection ?? ''; @endphp
<aside class="w-56 flex-shrink-0 flex flex-col bg-teal-900">
    <div class="px-5 py-5 border-b border-teal-800">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <div class="text-white font-bold text-sm">Los Mollos</div>
                <div class="text-teal-400 text-xs">RECEPCIÓN</div>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <div class="px-3 py-1 mb-1"><span class="text-xs font-semibold text-teal-400 uppercase tracking-widest">Principal</span></div>

        <a href="{{ route('dashboard.recepcionista') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $active === 'dashboard' ? 'bg-teal-700 text-white font-semibold' : 'text-teal-100 hover:bg-teal-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-teal-400 uppercase tracking-widest">Citas</span></div>

        <a href="{{ route('recepcionista.citas') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $active === 'citas' ? 'bg-teal-700 text-white font-semibold' : 'text-teal-100 hover:bg-teal-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Todas las Citas
        </a>

        <a href="{{ route('recepcionista.citas.crear') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $active === 'nueva-cita' ? 'bg-teal-700 text-white font-semibold' : 'text-teal-100 hover:bg-teal-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            Nueva Cita
        </a>

        <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-teal-400 uppercase tracking-widest">Pacientes</span></div>

        <a href="{{ route('recepcionista.pacientes.crear') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $active === 'pacientes' ? 'bg-teal-700 text-white font-semibold' : 'text-teal-100 hover:bg-teal-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Registrar Paciente
        </a>

        <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-teal-400 uppercase tracking-widest">Finanzas</span></div>

        <a href="{{ route('recepcionista.pagos.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $active === 'pagos' ? 'bg-teal-700 text-white font-semibold' : 'text-teal-100 hover:bg-teal-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Pagos
        </a>
    </nav>

    <div class="px-4 py-3 border-t border-teal-800">
        <div class="flex items-center gap-2.5 mb-3 px-1">
            <div class="w-7 h-7 bg-teal-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="text-white text-xs font-semibold truncate">{{ auth()->user()->name }}</div>
                <div class="text-teal-400 text-xs">Recepcionista</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-red-300 hover:bg-red-500/20 text-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
