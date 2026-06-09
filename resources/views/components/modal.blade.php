@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$sizeClass = match($maxWidth) {
    'sm' => 'modal-sm',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    '2xl' => 'modal-xl',
    default => '',
};
@endphp

<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-hidden="true"
     @if($show) data-bs-show="true" @endif>
    <div class="modal-dialog {{ $sizeClass }} modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg border-0">
            {{ $slot }}
        </div>
    </div>
</div>
