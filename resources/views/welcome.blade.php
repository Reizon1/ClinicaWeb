<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Los Mollos - Sistema Hospitalario</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .welcome-section { padding: 5rem 0; }
        .service-card { transition: box-shadow .2s, transform .2s; }
        .service-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,.1)!important; transform: translateY(-3px); }
    </style>
</head>
<body style="background:#fff;color:#111827;">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-light bg-white border-bottom shadow-sm fixed-top" style="z-index:1030;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="#">
                <div class="rounded-2 d-flex align-items-center justify-content-center bg-primary flex-shrink-0" style="width:36px;height:36px;">
                    <svg width="18" height="18" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div class="fw-bold text-dark" style="font-size:0.85rem;line-height:1.1;">Los Mollos</div>
                    <div class="text-muted" style="font-size:0.7rem;line-height:1.1;">Sistema Hospitalario</div>
                </div>
            </a>

            <div class="d-none d-md-flex align-items-center gap-4">
                <a href="#inicio" class="text-primary fw-semibold small text-decoration-none border-bottom border-primary pb-1">Inicio</a>
                <a href="#servicios" class="text-muted small text-decoration-none fw-medium">Especialidades</a>
                <a href="#medicos" class="text-muted small text-decoration-none fw-medium">Médicos</a>
                <a href="#ubicacion" class="text-muted small text-decoration-none fw-medium">Ubicación</a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('login') }}" class="btn btn-light btn-sm fw-semibold">Ingresar</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm fw-semibold shadow-sm">Registrarse</a>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section id="inicio" class="min-vh-100 d-flex align-items-center" style="padding-top:64px;background:linear-gradient(135deg,#f0f7ff 0%,#e8f4fd 50%,#fff 100%);">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2 mb-4 border" style="background:#eff6ff;border-color:#dbeafe!important;">
                        <span style="width:6px;height:6px;background:#3b82f6;border-radius:50%;display:inline-block;flex-shrink:0;"></span>
                        <span class="fw-semibold" style="font-size:0.72rem;color:#1d4ed8;letter-spacing:.04em;">Sistema de Gestión Digital 2026</span>
                    </div>

                    <h1 class="fw-bold mb-4" style="font-size:clamp(2.2rem,5vw,3.5rem);line-height:1.15;color:#111827;">
                        Tu salud en<br><span class="text-primary">manos expertas</span>
                    </h1>

                    <p class="text-muted mb-5" style="font-size:1.05rem;line-height:1.8;max-width:440px;">
                        Plataforma integral para la gestión hospitalaria. Optimiza citas, historiales clínicos y pagos con la tecnología más segura y eficiente del mercado.
                    </p>

                    <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
                        <a href="{{ route('register') }}" class="btn btn-primary fw-semibold px-4 py-3 d-flex align-items-center gap-2 shadow-sm">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Agendar Cita
                        </a>
                        <a href="#servicios" class="btn btn-outline-secondary fw-semibold px-4 py-3 d-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                            Ver Demo
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="#22c55e" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-muted small">Soporte 24/7</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="#22c55e" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-muted small">Datos Seguros</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-flex justify-content-center">
                    <div class="position-relative" style="width:100%;max-width:420px;">
                        <div class="rounded-4 overflow-hidden d-flex align-items-center justify-content-center shadow-lg" style="height:400px;background:linear-gradient(135deg,#bfdbfe,#93c5fd,#60a5fa);">
                            <svg width="180" height="180" fill="rgba(255,255,255,0.5)" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        </div>
                        <div class="position-absolute bg-white rounded-3 shadow-lg p-3 border" style="bottom:-16px;left:-20px;min-width:200px;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
                                    <svg width="18" height="18" fill="#2563eb" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                                </div>
                                <div>
                                    <div class="text-muted" style="font-size:0.7rem;">Pacientes Atendidos</div>
                                    <div class="fw-bold" style="font-size:1.4rem;">4,592</div>
                                    <div class="d-flex align-items-center gap-1 mt-1">
                                        <svg width="10" height="10" fill="#22c55e" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                        <span class="fw-semibold" style="font-size:0.7rem;color:#22c55e;">+15.9% este mes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICIOS --}}
    <section id="servicios" class="welcome-section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="font-size:clamp(1.6rem,3vw,2.2rem);">Soluciones integrales para tu centro médico</h2>
                <p class="text-muted mx-auto" style="max-width:520px;line-height:1.7;">Herramientas diseñadas para optimizar el flujo de trabajo, mejorar la atención al paciente y asegurar la rentabilidad.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card bg-white rounded-3 border p-4 h-100 shadow-sm">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-4" style="width:48px;height:48px;background:#eff6ff;">
                            <svg width="22" height="22" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h5 class="fw-semibold mb-3">Gestión de Citas</h5>
                        <p class="text-muted small mb-4" style="line-height:1.7;">Sistema inteligente de agendamiento con recordatorios automáticos por SMS y correo electrónico para reducir el ausentismo.</p>
                        <a href="#" class="text-primary fw-semibold small text-decoration-none d-flex align-items-center gap-1">
                            Conocer más
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card bg-white rounded-3 border p-4 h-100 shadow-sm">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-4" style="width:48px;height:48px;background:#EFF6FF;">
                            <svg width="22" height="22" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/></svg>
                        </div>
                        <h5 class="fw-semibold mb-3">Historial Clínico Digital</h5>
                        <p class="text-muted small mb-4" style="line-height:1.7;">Acceso seguro e inmediato a expedientes médicos, recetas electrónicas y resultados de laboratorio desde cualquier dispositivo.</p>
                        <a href="#" class="fw-semibold small text-decoration-none d-flex align-items-center gap-1" style="color:#2563EB;">
                            Conocer más
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card bg-white rounded-3 border p-4 h-100 shadow-sm">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-4" style="width:48px;height:48px;background:#faf5ff;">
                            <svg width="22" height="22" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h5 class="fw-semibold mb-3">Pagos Seguros</h5>
                        <p class="text-muted small mb-4" style="line-height:1.7;">Integración nativa con PayPal y Stripe para cobros de consultas, procedimientos y copagos con máxima seguridad y encriptación.</p>
                        <div class="d-flex align-items-center gap-1 text-muted">
                            <svg width="14" height="14" fill="#818cf8" viewBox="0 0 24 24"><path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z"/><path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd"/></svg>
                            <span class="fw-semibold" style="font-size:0.72rem;color:#6366f1;letter-spacing:.08em;">stripe</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MÉDICOS --}}
    <section id="medicos" class="welcome-section" style="background:#EFF6FF;">
        <div class="container">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2 mb-4 border" style="background:#EFF6FF;border-color:#BFDBFE!important;">
                    <span style="width:6px;height:6px;background:#2563EB;border-radius:50%;display:inline-block;flex-shrink:0;"></span>
                    <span class="fw-semibold" style="font-size:0.72rem;color:#1d4ed8;letter-spacing:.04em;">Equipo Médico</span>
                </div>
                <h2 class="fw-bold mb-3" style="font-size:clamp(1.6rem,3vw,2.2rem);">Conocé a nuestros especialistas</h2>
                <p class="text-muted mx-auto" style="max-width:520px;line-height:1.7;">Profesionales certificados y disponibles para brindarte la mejor atención médica.</p>
            </div>

            <div class="row g-4 justify-content-center">
                @forelse($medicos as $medico)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="service-card bg-white rounded-3 border p-4 text-center shadow-sm h-100">
                        <div class="mx-auto mb-3 fw-bold rounded-circle d-flex align-items-center justify-content-center"
                             style="width:64px;height:64px;font-size:1.5rem;background:linear-gradient(135deg,#1d4ed8,#2563EB);color:white;">
                            {{ strtoupper(substr($medico->user->name, 0, 1)) }}
                        </div>
                        <h6 class="fw-semibold mb-1">{{ $medico->user->name }}</h6>
                        <p class="text-muted small mb-3" style="font-size:0.8rem;">{{ $medico->especialidad->nombre ?? '—' }}</p>
                        <span class="badge rounded-pill" style="background:#EFF6FF;color:#2563EB;border:1px solid #BFDBFE;font-size:0.68rem;">
                            ✓ Disponible
                        </span>
                        @if($medico->descripcion)
                        <p class="text-muted mt-3 mb-0" style="font-size:0.75rem;line-height:1.5;">{{ Str::limit($medico->descripcion, 80) }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-4">
                    <p>No hay médicos disponibles en este momento.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="btn btn-primary fw-semibold px-4 py-2 shadow-sm">
                    Agendar con un especialista
                </a>
            </div>
        </div>
    </section>

    {{-- PLAN PREMIUM --}}
    <section id="premium" class="welcome-section" style="background:linear-gradient(135deg,#1e3a8a 0%,#2563EB 60%,#0891b2 100%);">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 text-white">
                    <div class="d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2 mb-4 border" style="background:rgba(250,204,21,.12);border-color:rgba(250,204,21,.25)!important;">
                        <svg width="12" height="12" fill="#facc15" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="fw-bold" style="font-size:0.68rem;color:#facc15;letter-spacing:.1em;text-transform:uppercase;">Plan Premium</span>
                    </div>

                    <h2 class="fw-bold mb-4" style="font-size:clamp(1.8rem,3.5vw,2.8rem);line-height:1.2;">Lleva tu clínica al<br>siguiente nivel</h2>
                    <p class="mb-5" style="color:#bfdbfe;font-size:1.05rem;line-height:1.8;">Desbloquea analíticas avanzadas, telemedicina integrada y soporte prioritario 24/7. Ideal para hospitales y clínicas de alto flujo.</p>

                    <div class="d-flex flex-column gap-3 mb-5">
                        @foreach(['Usuarios médicos ilimitados','Módulo de Telemedicina HD (Zoom API)','Dashboard de analíticas predictivas','API access para integraciones externas'] as $feature)
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:20px;height:20px;background:#4ade80;">
                                <svg width="10" height="10" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span style="color:#bfdbfe;">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex align-items-center gap-4">
                        <button class="btn btn-light fw-semibold px-4 py-3 shadow-lg">Actualizar a Premium</button>
                        <span style="color:#93c5fd;font-size:0.9rem;">Desde $99/mes</span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="rounded-3 p-4 border" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.1)!important;backdrop-filter:blur(8px);">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div>
                                <div class="fw-semibold text-white">Resumen Financiero</div>
                                <div style="font-size:0.72rem;color:#93c5fd;">Actualizado hace 5 min</div>
                            </div>
                            <div class="rounded-pill px-3 py-1 border" style="background:rgba(74,222,128,.12);border-color:rgba(74,222,128,.25)!important;">
                                <span class="fw-semibold" style="font-size:0.72rem;color:#4ade80;">+24.5% vs Mes anterior</span>
                            </div>
                        </div>
                        @php $bars = ['Lun'=>42,'Mar'=>55,'Mie'=>47,'Jue'=>65,'Vie'=>72,'Sab'=>83,'Dom'=>100]; @endphp
                        <div class="d-flex align-items-end gap-2" style="height:160px;">
                            @foreach($bars as $day => $h)
                            <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-end gap-2 h-100">
                                <div class="w-100 rounded-top"
                                     style="height:{{ $h }}%;background:{{ $day === 'Dom' ? '#3b82f6' : 'rgba(255,255,255,0.22)' }};min-height:4px;"></div>
                                <span style="font-size:0.65rem;color:#93c5fd;">{{ $day }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- UBICACIÓN --}}
    <section id="ubicacion" class="welcome-section" style="background:#f9fafb;">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-6">
                    <div class="d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2 mb-4 border" style="background:#eff6ff;border-color:#dbeafe!important;">
                        <svg width="14" height="14" fill="#2563eb" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        <span class="fw-semibold" style="font-size:0.72rem;color:#1d4ed8;">Nuestra Ubicación</span>
                    </div>

                    <h2 class="fw-bold mb-3" style="font-size:clamp(1.6rem,3vw,2.2rem);">Visita nuestras instalaciones centrales</h2>
                    <p class="text-muted mb-5" style="line-height:1.7;">Conoce de primera mano cómo Sistema Web Hospitalario puede transformar tu gestión médica.</p>

                    <div class="d-flex flex-column gap-4">
                        @php $contactItems = [
                            ['bg'=>'#eff6ff','icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','title'=>'Sede Principal','lines'=>['Av. Tecnológica 1024, Edificio Innova','Ciudad Capital, CP 10000']],
                            ['bg'=>'#eff6ff','icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z','title'=>'Contacto Directo','lines'=>['+1 (555) 123-4567','soporte@losmollos.com']],
                            ['bg'=>'#eff6ff','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','title'=>'Horario de Atención','lines'=>['Lunes a Viernes: 8:00 AM – 6:00 PM','Sábados: 9:00 AM – 1:00 PM']],
                        ] @endphp
                        @foreach($contactItems as $item)
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 border d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width:40px;height:40px;background:#fff;">
                                <svg width="18" height="18" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/></svg>
                            </div>
                            <div>
                                <div class="fw-semibold small mb-1">{{ $item['title'] }}</div>
                                @foreach($item['lines'] as $line)
                                    <div class="text-muted small">{{ $line }}</div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-6">
                    <div id="mapa-clinica" class="rounded-3 border shadow-sm overflow-hidden" style="height:360px;"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-5" style="background:#111827;color:#9ca3af;">
        <div class="container">
            <div class="row g-5 pb-5 border-bottom" style="border-color:#1f2937!important;">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-2 d-flex align-items-center justify-content-center bg-primary flex-shrink-0" style="width:36px;height:36px;">
                            <svg width="18" height="18" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm5 3a1 1 0 012 0v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0v-1H8a1 1 0 010-2h1V7z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="fw-bold text-white" style="font-size:0.85rem;">Sistema Web Hospitalario</span>
                    </div>
                    <p class="small mb-4" style="max-width:280px;line-height:1.7;">Plataforma líder en gestión médica digital. Desarrollada como proyecto de excelencia académica para revolucionar la administración de la salud.</p>
                    <div class="d-flex gap-2">
                        @foreach(['M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z', 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z', 'M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22'] as $d)
                        <a href="#" class="rounded-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:#1f2937;color:#9ca3af;text-decoration:none;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $d }}"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-semibold text-white mb-4" style="font-size:0.7rem;letter-spacing:.1em;text-transform:uppercase;">Producto</h6>
                    <ul class="list-unstyled d-flex flex-column gap-3">
                        @foreach(['Características','Precios (Premium)','Seguridad','Actualizaciones'] as $item)
                        <li><a href="#" class="small text-decoration-none" style="color:#9ca3af;">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-semibold text-white mb-4" style="font-size:0.7rem;letter-spacing:.1em;text-transform:uppercase;">Proyecto</h6>
                    <ul class="list-unstyled d-flex flex-column gap-3">
                        <li><a href="#" class="small text-decoration-none" style="color:#9ca3af;">Materia: Programación Web II</a></li>
                        <li><a href="#" class="small text-decoration-none" style="color:#9ca3af;">Equipo: Los Mollos</a></li>
                        <li><a href="#" class="small text-decoration-none" style="color:#9ca3af;">Gestión: 2026</a></li>
                        <li><a href="#" class="small text-decoration-none fw-semibold" style="color:#60a5fa;">Documentación Técnica</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <p class="mb-0" style="font-size:0.75rem;">© 2026 Los Mollos – Sistema de Gestión Clínica. Todos los derechos reservados.</p>
                <div class="d-flex gap-4">
                    <a href="#" class="small text-decoration-none" style="color:#9ca3af;">Términos de Servicio</a>
                    <a href="#" class="small text-decoration-none" style="color:#9ca3af;">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const lat = -17.3895, lng = -66.1568, zoom = 16;
        const mapa = L.map('mapa-clinica').setView([lat, lng], zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19,
        }).addTo(mapa);
        const icono = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            iconSize: [25,41], iconAnchor: [12,41], popupAnchor: [1,-34],
        });
        L.marker([lat, lng], { icon: icono }).addTo(mapa)
            .bindPopup('<b>Clínica Los Mollos</b><br>Cochabamba, Bolivia').openPopup();
    </script>

</body>
</html>
