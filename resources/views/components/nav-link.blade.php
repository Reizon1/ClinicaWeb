@props(['active'])

<a {{ $attributes->merge(['class' => 'nav-link' . (($active ?? false) ? ' active fw-semibold' : '')]) }}>
    {{ $slot }}
</a>
