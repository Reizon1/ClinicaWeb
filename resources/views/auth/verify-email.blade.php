<x-guest-layout>

    <div class="mb-4">
        <h1 class="fw-bold mb-2" style="font-size:1.4rem;color:#111827;">Verifica tu correo</h1>
        <p class="text-muted" style="font-size:0.875rem;">
            Gracias por registrarte. Por favor verifica tu correo haciendo clic en el enlace que te enviamos.
            Si no lo recibiste, podemos enviarte uno nuevo.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            Se envió un nuevo enlace de verificación a tu correo.
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between gap-3 mt-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Reenviar correo de verificación</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted p-0" style="font-size:0.875rem;">
                Cerrar sesión
            </button>
        </form>
    </div>

</x-guest-layout>
