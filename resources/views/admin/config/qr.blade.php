<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configurar QR – Admin Los Mollos</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div class="d-flex" style="min-height:100vh;overflow:hidden;">

    @include('partials.admin-sidebar', ['activeSection' => 'pagos'])

    <div class="flex-grow-1 d-flex flex-column" style="overflow:hidden;">
        <header class="app-topbar gap-3">
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-light btn-sm p-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Configuración de Código QR</h5>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Imagen estática mostrada a los pacientes al elegir pago QR</p>
            </div>
        </header>

        <main class="flex-grow-1 p-4" style="overflow-y:auto;">
            <div class="mx-auto" style="max-width:480px;">

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
                @endif

                {{-- Admin-only badge --}}
                <div class="rounded-3 p-3 mb-4 d-flex align-items-center gap-2" style="background:#fef9c3;border:1px solid #fde68a;">
                    <svg width="16" height="16" fill="none" stroke="#92400e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p class="small mb-0" style="color:#92400e;">
                        Solo el <strong>Administrador</strong> puede modificar el código QR de pago.
                    </p>
                </div>

                {{-- QR actual --}}
                <div class="app-card p-4 mb-4">
                    <h6 class="fw-semibold mb-3">QR actual</h6>
                    @if($qrImageUrl)
                        <div class="text-center">
                            <img src="{{ $qrImageUrl }}?v={{ time() }}" alt="QR de pago"
                                 class="img-fluid rounded mb-2" style="max-height:240px;border:1px solid #e5e7eb;">
                            <p class="text-muted small mb-0">Imagen activa para pagos QR</p>
                        </div>
                    @else
                        <div class="rounded-2 d-flex align-items-center justify-content-center text-muted"
                             style="height:160px;background:#f9fafb;border:2px dashed #d1d5db;">
                            <div class="text-center">
                                <svg width="40" height="40" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" class="mb-2"><path d="M3 3h6v6H3zM15 3h6v6h-6zM3 15h6v6H3zM11 11h2v2h-2zM13 13h2v2h-2zM11 15h2v2h-2zM15 11h2v2h-2zM17 13h2v2h-2zM15 15h4v4h-4z"/></svg>
                                <p class="small mb-0">Ningún QR configurado</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Upload form --}}
                <div class="app-card p-4">
                    <h6 class="fw-semibold mb-3">{{ $qrImageUrl ? 'Reemplazar QR' : 'Subir QR' }}</h6>

                    <form method="POST" action="{{ route('admin.config.qr.store') }}" enctype="multipart/form-data" id="qrForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Imagen del código QR *</label>
                            <input type="file" name="qr_imagen" accept="image/png,image/jpeg,image/webp"
                                   class="form-control @error('qr_imagen') is-invalid @enderror"
                                   onchange="previewQR(this)" required>
                            @error('qr_imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <p class="text-muted mt-1 mb-0" style="font-size:0.72rem;">PNG, JPG o WebP · máx. 2 MB</p>
                        </div>

                        {{-- Preview --}}
                        <div id="previewBox" class="text-center mb-3 d-none">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded"
                                 style="max-height:200px;border:1px solid #e5e7eb;">
                            <p class="text-muted small mt-1 mb-0">Vista previa</p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            {{ $qrImageUrl ? 'Actualizar código QR' : 'Subir código QR' }}
                        </button>
                    </form>
                </div>

            </div>
        </main>
    </div>
</div>

<script>
function previewQR(input) {
    const box = document.getElementById('previewBox');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            box.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
