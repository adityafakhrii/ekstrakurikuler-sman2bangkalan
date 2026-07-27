@props([
    'name',
    'description',
    'image' => '/images/placeholder-ekskul.jpg',
    'hasLogo' => false,
    'match' => null,
    'route' => '#',
    'gradient' => null
])

<!-- Clean layout without card wrapper border/shadow matching screenshot exactly (rounded-none borders) -->
<div class="flex flex-col gap-4">
    <!-- Image wrapper with thick gradient borders and sharp sharp siku corners (rounded-none) -->
    <div class="w-full aspect-[16/10] overflow-hidden bg-gradient-to-tr {{ $gradient ?? 'from-[#567BB3] to-[#B1C2D4]' }} p-6 sm:p-8 flex items-center justify-center">
        <div class="w-full h-full overflow-hidden shadow-2xs">
            @if($hasLogo)
                <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/600x375?text={{ urlencode($name) }}'">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#4F46E5] via-[#6366F1] to-[#3B82F6] text-white p-6 text-center select-none rounded-[1rem] shadow-xs">
                    <span class="text-[10px] font-bold tracking-widest uppercase opacity-75 mb-1.5">Ekstrakurikuler</span>
                    <span class="text-base font-extrabold tracking-tight leading-snug line-clamp-2 px-2">{{ $name }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Content info directly on page background -->
    <div class="flex-grow flex flex-col gap-2 text-left">
        <!-- Title & Match Ratio -->
        <h3 class="text-2xl font-bold text-gray-900 tracking-tight leading-none flex items-center flex-wrap gap-2">
            {{ $name }}
            @if($match)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700 border border-emerald-200/60 shadow-3xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
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
