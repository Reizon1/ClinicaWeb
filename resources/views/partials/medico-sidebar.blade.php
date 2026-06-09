@php $s = $activeSection ?? ''; @endphp
<aside class="app-sidebar sidebar-recep" style="background:linear-gradient(180deg,#0f766e 0%,#0d9488 100%);">
    <div class="sidebar-brand" style="border-bottom:1px solid rgba(255,255,255,0.1);">
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex align-items-center justify-content-center rounded-2"
                 style="width:32px;height:32px;background:rgba(255,255,255,0.2);flex-shrink:0;">
                <svg width="16" height="16" fill="white" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <div class="fw-bold text-white" style="font-size:0.85rem;">Los Mollos</div>
                <div style="font-size:0.65rem;color:#99f6e4;">MEDICAL ZONE</div>
            </div>
        </div>
    </div>

    <nav class="flex-grow-1 px-2 py-3 overflow-auto">
        <div class="sidebar-nav-label" style="color:#99f6e4;">Principal</div>
        <a href="{{ route('dashboard.medico') }}" class="sidebar-link {{ $s==='dashboard' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Agenda</div>
        <a href="{{ route('medico.agenda.semanal') }}" class="sidebar-link {{ $s==='agenda-semanal' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Vista Semanal
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Gestión Médica</div>
        <a href="{{ route('historiales.index') }}" class="sidebar-link {{ $s==='historiales' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Historiales Clínicos
        </a>
        <a href="{{ route('recetas.index') }}" class="sidebar-link {{ $s==='recetas' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            Recetas Médicas
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Configuración</div>
        <a href="{{ route('horarios.index') }}" class="sidebar-link {{ $s==='horarios' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Mis Horarios
        </a>
        <a href="{{ route('medico.perfil') }}" class="sidebar-link {{ $s==='perfil' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Perfil
        </a>
    </nav>

    <div class="px-2 py-3" style="border-top:1px solid rgba(255,255,255,0.1);">
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start"
                    style="color:#fca5a5;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
