@props([
    'name', // Unique identifier untuk mendengarkan custom events
    'title' => 'Modal Title',
    'maxWidth' => 'md'
])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        default => 'max-w-md'
    };
@endphp

<div x-data="{ open: false }"
     x-show="open"
     @open-modal.window="if ($event.detail.name === '{{ $name }}') open = true"
     @close-modal.window="if ($event.detail.name === '{{ $name }}') open = false"
     @keydown.escape.window="open = false"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display: none;">
     
    <!-- Backdrop Overlay with Blur -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity"
         @click="open = false"></div>

    <!-- Modal Box -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full {{ $maxWidthClass }} z-50 transform transition-all p-6 relative">
         
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
            <h3 class="text-lg font-bold text-brand-primary">{{ $title }}</h3>
            <!-- Close Button -->
            <button @click="open = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="text-sm text-gray-700">
            {{ $slot }}
        </div>
    </div>
</div>
