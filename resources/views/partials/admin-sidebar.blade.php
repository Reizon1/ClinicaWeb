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
                <div class="fw-bold text-white" style="font-size:0.85rem;letter-spacing:0.04em;">Los Mollos</div>
                <div style="font-size:0.65rem;color:#99f6e4;">ADMIN CLINIC</div>
            </div>
        </div>
    </div>

    <nav class="flex-grow-1 px-2 py-3 overflow-auto">
        <div class="sidebar-nav-label" style="color:#99f6e4;">Principal</div>
        <a href="{{ route('dashboard.admin') }}" class="sidebar-link {{ $s==='dashboard' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Gestión Médica</div>
        <a href="{{ route('admin.medicos.index') }}" class="sidebar-link {{ $s==='medicos' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Médicos
        </a>
        <a href="{{ route('admin.especialidades.index') }}" class="sidebar-link {{ $s==='especialidades' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Especialidades
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Premium</div>
        <a href="{{ route('admin.suscripciones.index') }}" class="sidebar-link {{ $s==='suscripciones' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            Suscripciones
        </a>

        <div class="sidebar-nav-label mt-2" style="color:#99f6e4;">Sistema</div>
        <a href="{{ route('admin.usuarios.index') }}" class="sidebar-link {{ $s==='usuarios' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Usuarios
        </a>
        <a href="{{ route('admin.reportes.index') }}" class="sidebar-link {{ $s==='reportes' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Reportes
        </a>
        <a href="{{ route('admin.configuracion.index') }}" class="sidebar-link {{ $s==='configuracion' ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Configuración
        </a>
    </nav>

    <div class="px-2 py-3" style="border-top:1px solid rgba(255,255,255,0.1);">
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start" style="color:#fca5a5;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
