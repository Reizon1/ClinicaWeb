<nav class="navbar navbar-expand-md bg-white border-bottom shadow-sm px-4">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('dashboard') }}">
            <div class="d-flex align-items-center justify-content-center bg-primary rounded-2"
                 style="width:32px;height:32px;">
                <svg width="16" height="16" fill="white" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="fw-bold text-dark">Los Mollos</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}"
                       href="{{ route('dashboard') }}">Dashboard</a>
                </li>
            </ul>

            <div class="dropdown">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2 dropdown-toggle"
                        data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle text-white"
                         style="width:28px;height:28px;font-size:0.7rem;font-weight:700;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <svg width="14" height="14" fill="none" stroke="currentColor" class="me-2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Perfil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <svg width="14" height="14" fill="none" stroke="currentColor" class="me-2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
