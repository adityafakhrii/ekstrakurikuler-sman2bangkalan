@props([
    'name',
    'description',
    'image' => '/images/placeholder-ekskul.jpg',
    'match' => null,
    'route' => '#',
    'gradient' => null
])

<!-- Clean layout without card wrapper border/shadow matching screenshot exactly (rounded-none borders) -->
<div class="flex flex-col gap-4">
    <!-- Image wrapper with thick gradient borders and sharp sharp siku corners (rounded-none) -->
    <div class="w-full aspect-[16/10] overflow-hidden bg-gradient-to-tr {{ $gradient ?? 'from-[#567BB3] to-[#B1C2D4]' }} p-6 sm:p-8 flex items-center justify-center">
        <div class="w-full h-full overflow-hidden shadow-2xs">
            <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/600x375?text={{ urlencode($name) }}'">
        </div>
    </div>

    <!-- Content info directly on page background -->
    <div class="flex-grow flex flex-col gap-2 text-left">
        <!-- Title & Match Ratio -->
        <h3 class="text-2xl font-bold text-gray-900 tracking-tight leading-none">
            {{ $name }}
            @if($match)
                <span class="text-sm font-normal text-gray-500 ml-2">
                    {{ $match }}
                </span>
            @endif
        </h3>
        
        <!-- Description -->
        <p class="text-xs text-gray-400 font-light leading-relaxed line-clamp-3">
            {{ $description }}
        </p>
    </div>

    <!-- Action Link without top border line -->
    <div class="pt-1">
        <a href="{{ $route }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-800 hover:text-black transition-colors duration-150 cursor-pointer">
            <span>Detail Ekskul</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
</div>
