@props(['active'])

<a {{ $attributes->merge(['class' => 'nav-link px-3 py-2' . (($active ?? false) ? ' active fw-semibold' : '')]) }}>
    {{ $slot }}
</a>
