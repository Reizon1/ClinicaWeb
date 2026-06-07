@php $s = $activeSection ?? ''; @endphp
<aside class="w-56 flex-shrink-0 flex flex-col" style="background:linear-gradient(180deg,#1e3a8a 0%,#1d4ed8 60%,#2563eb 100%);">
    <div class="px-5 py-5 border-b border-white/10">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <div class="text-white font-bold text-sm leading-none">Los Mollos</div>
                <div class="text-blue-200 text-xs leading-none mt-0.5">MEDICAL ZONE</div>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <div class="px-3 py-1 mb-1"><span class="text-xs font-semibold text-blue-300 uppercase tracking-widest">Principal</span></div>
        <a href="{{ route('dashboard.medico') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $s==='dashboard' ? 'bg-white/20 text-white font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-blue-300 uppercase tracking-widest">Gestión Médica</span></div>
        <a href="{{ route('historiales.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $s==='historiales' ? 'bg-white/20 text-white font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Historiales Clínicos
        </a>
        <a href="{{ route('recetas.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $s==='recetas' ? 'bg-white/20 text-white font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            Recetas Médicas
        </a>

        <div class="px-3 py-1 mt-3 mb-1"><span class="text-xs font-semibold text-blue-300 uppercase tracking-widest">Configuración</span></div>
        <a href="{{ route('horarios.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $s==='horarios' ? 'bg-white/20 text-white font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Mis Horarios
        </a>
        <a href="{{ route('medico.perfil') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors {{ $s==='perfil' ? 'bg-white/20 text-white font-semibold' : 'text-blue-100 hover:bg-white/10' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Perfil
        </a>
    </nav>

    <div class="px-3 py-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-red-300 hover:bg-red-500/20 text-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
