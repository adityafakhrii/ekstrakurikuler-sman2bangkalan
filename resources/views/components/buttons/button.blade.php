@props([
    'variant' => 'primary', // primary, secondary, edit, delete, danger, warning
    'type' => 'button'
])

@php
    $class = match($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'edit' => 'btn-edit',
        'delete' => 'btn-delete',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm inline-flex items-center gap-2 cursor-pointer transition-all duration-200',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm inline-flex items-center gap-2 cursor-pointer transition-all duration-200',
        default => 'btn-primary'
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</button>
