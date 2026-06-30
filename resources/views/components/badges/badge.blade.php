@props([
    'variant' => 'info' // success, danger, info
])

@php
    $class = match($variant) {
        'success' => 'badge-success',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        default => 'badge-info'
    };
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</span>
