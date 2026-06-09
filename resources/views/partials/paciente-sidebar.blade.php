@php $active = $activeSection ?? ''; @endphp
<aside class="app-sidebar sidebar-patient" style="background:linear-gradient(180deg,#0f766e 0%,#0d9488 100%);">
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
                <div style="font-size:0.65rem;color:#99f6e4;">PANEL PACIENTE</div>
            </div>
        </div>
    </div>

    <nav class="flex-grow-1 px-2 py-3 overflow-auto">
        <div class="sidebar-nav-label" style="color:#99f6e4;">Principal</div>
        <a href="{{ route('dashboard.paciente') }}" class="sidebar-link {{ $active==='dashboard' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Mis Consultas</div>
        <a href="{{ route('paciente.citas') }}" class="sidebar-link {{ $active==='citas' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Mis Citas
        </a>
        <a href="{{ route('paciente.historial') }}" class="sidebar-link {{ $active==='historial' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Historial Médico
        </a>
        <a href="{{ route('paciente.recetas') }}" class="sidebar-link {{ $active==='recetas' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            Recetas
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Finanzas</div>
        <a href="{{ route('paciente.pagos') }}" class="sidebar-link {{ $active==='pagos' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Mis Pagos
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Servicios</div>
        <a href="{{ route('citas.crear') }}" class="sidebar-link {{ $active==='nueva-cita' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            Agendar Cita
        </a>
        <a href="{{ route('dashboard.paciente') }}#premium" class="sidebar-link" style="color:#fde047;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Suscripción Premium
        </a>
    </nav>

    <div class="px-2 py-3" style="border-top:1px solid rgba(255,255,255,0.1);">
        <div class="d-flex align-items-center gap-2 px-2 mb-2">
            <div class="avatar-circle text-white" style="width:28px;height:28px;background:rgba(255,255,255,0.2);font-size:0.7rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <div class="text-white fw-semibold text-truncate" style="font-size:0.78rem;">{{ auth()->user()->name }}</div>
                <div style="font-size:0.65rem;color:#99f6e4;">Paciente</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start"
                    style="color:#fca5a5;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
