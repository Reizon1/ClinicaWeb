@php $active = $activeSection ?? ''; @endphp
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
                <div style="font-size:0.65rem;color:#99f6e4;">RECEPCIÓN</div>
            </div>
        </div>
    </div>

    <nav class="flex-grow-1 px-2 py-3 overflow-auto">
        <div class="sidebar-nav-label" style="color:#99f6e4;">Principal</div>
        <a href="{{ route('dashboard.recepcionista') }}" class="sidebar-link {{ $active==='dashboard' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Citas</div>
        <a href="{{ route('recepcionista.citas') }}" class="sidebar-link {{ $active==='citas' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Todas las Citas
        </a>
        <a href="{{ route('recepcionista.citas.crear') }}" class="sidebar-link {{ $active==='nueva-cita' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            Nueva Cita
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Pacientes</div>
        <a href="{{ route('recepcionista.pacientes.crear') }}" class="sidebar-link {{ $active==='pacientes' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Registrar Paciente
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Finanzas</div>
        <a href="{{ route('recepcionista.pagos.index') }}" class="sidebar-link {{ $active==='pagos' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Pagos
        </a>
    </nav>

    <div class="px-2 py-3" style="border-top:1px solid rgba(255,255,255,0.1);">
        <div class="d-flex align-items-center gap-2 px-2 mb-2">
            <div class="avatar-circle text-white" style="width:28px;height:28px;background:rgba(255,255,255,0.2);font-size:0.7rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <div class="text-white fw-semibold text-truncate" style="font-size:0.78rem;">{{ auth()->user()->name }}</div>
                <div style="font-size:0.65rem;color:#99f6e4;">Recepcionista</div>
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
