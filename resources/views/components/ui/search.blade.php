@props([
    'placeholder' => 'Cari...',
    'name' => 'search',
    'value' => ''
])

<div class="relative w-full max-w-xs">
    <input type="text" 
           name="{{ $name }}" 
           value="{{ request($name, $value) }}"
           placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'w-full pl-4 pr-10 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-accent/20 focus:border-brand-accent transition-all placeholder-gray-400']) }}>
    <!-- Search Icon -->
    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
</div>
