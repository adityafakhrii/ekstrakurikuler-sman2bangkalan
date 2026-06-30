@props([
    'title',
    'value'
])

<div {{ $attributes->merge(['class' => 'card-stat']) }}>
    <!-- Left content (title & big value) -->
    <div class="flex flex-col gap-3">
        <span class="text-sm font-semibold text-gray-800 tracking-wide">{{ $title }}</span>
        <span class="text-4xl font-extrabold text-[#2A1B60] leading-none">{{ $value }}</span>
    </div>
    
    <!-- Right content (user icon as shown in screenshot) -->
    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-gray-200/50 shadow-xs mb-0.5">
        <svg class="w-6 h-6 text-black mt-1" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
    </div>
</div>
