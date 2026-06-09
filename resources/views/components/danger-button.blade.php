<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger fw-semibold']) }}>
    {{ $slot }}
</button>
