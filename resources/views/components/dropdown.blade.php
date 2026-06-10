@props(['align' => 'right', 'width' => '48'])

<div class="dropdown position-relative">
    <div data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
        {{ $trigger }}
    </div>
    <ul class="dropdown-menu shadow-sm border-0 rounded-3 {{ $align === 'left' ? '' : 'dropdown-menu-end' }}"
        style="min-width: 12rem;">
        {{ $content }}
    </ul>
</div>
