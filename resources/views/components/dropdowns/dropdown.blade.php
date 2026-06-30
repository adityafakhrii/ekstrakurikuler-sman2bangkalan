@props([
    'align' => 'right', // left, right
    'width' => '48'
])

@php
    $alignmentClass = match($align) {
        'left' => 'left-0 origin-top-left',
        'right' => 'right-0 origin-top-right',
        default => 'right-0 origin-top-right'
    };

    $widthClass = match($width) {
        '48' => 'w-48',
        '56' => 'w-56',
        '64' => 'w-64',
        default => 'w-48'
    };
@endphp

<div x-data="{ open: false }" 
     @click.away="open = false" 
     class="relative">
    
    <!-- Dropdown Trigger Button -->
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <!-- Dropdown Panel Content -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="transform opacity-0 scale-95 -translate-y-1"
         class="absolute mt-2 rounded-xl bg-white text-gray-800 shadow-xl border border-[#f2eaea] py-2 z-50 {{ $alignmentClass }} {{ $widthClass }}"
         style="display: none;">
        {{ $content }}
    </div>
</div>
