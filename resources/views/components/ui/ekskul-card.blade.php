@props([
    'name',
    'description',
    'image' => '/images/placeholder-ekskul.jpg',
    'match' => null,
    'route' => '#'
])

<div class="bg-white border border-[#f2eaea] rounded-3xl p-5 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col gap-4">
    <!-- Image wrapper matching mockup style -->
    <div class="w-full aspect-[16/10] overflow-hidden rounded-2xl bg-gray-100 border border-gray-100">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" onerror="this.src='https://placehold.co/600x375?text={{ urlencode($name) }}'">
    </div>

    <!-- Content -->
    <div class="flex-grow flex flex-col gap-2">
        <!-- Title & Match Ratio directly beside it -->
        <h3 class="text-xl font-bold text-gray-900 leading-tight">
            {{ $name }}
            @if($match)
                <span class="text-sm font-normal text-gray-500 ml-2">
                    {{ $match }}
                </span>
            @endif
        </h3>
        
        <!-- Description -->
        <p class="text-xs text-gray-500 font-normal leading-relaxed line-clamp-3">
            {{ $description }}
        </p>
    </div>

    <!-- Action Link -->
    <div class="pt-2 border-t border-[#f8f1f1]">
        <a href="{{ $route }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-800 hover:text-brand-accent transition-colors duration-150 group">
            Detail Ekskul
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
</div>
