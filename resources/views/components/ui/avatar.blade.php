@props([
    'src' => null,
    'alt' => 'User avatar',
    'size' => 'md' // sm, md, lg
])

@php
    $sizeClass = match($size) {
        'sm' => 'w-8 h-8',
        'md' => 'w-10 h-10',
        'lg' => 'w-16 h-16',
        default => 'w-10 h-10'
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-full bg-white flex items-center justify-center text-brand-primary overflow-hidden border border-gray-200 shadow-xs ' . $sizeClass]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="w-full h-full object-cover">
    @else
        <!-- Fallback avatar icon -->
        <svg class="w-2/3 h-2/3 text-brand-primary mt-1" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
    @endif
</div>
