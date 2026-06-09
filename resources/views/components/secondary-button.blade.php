<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-secondary fw-semibold']) }}>
    {{ $slot }}
</button>
