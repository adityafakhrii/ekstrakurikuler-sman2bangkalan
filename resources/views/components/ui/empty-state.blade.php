@props([
    'title' => 'Tidak Ada Data Ditemukan',
    'description' => 'Silakan coba sesuaikan kata kunci pencarian Anda atau tambahkan entri data baru.',
    'icon' => null
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center p-8 border-2 border-dashed border-[#f2eaea] rounded-2xl bg-white']) }}>
    <!-- SVG Icon Fallback -->
    <div class="p-4 rounded-full bg-[#E5E0F5] text-brand-primary mb-4 shadow-sm">
        @if($icon)
            {{ $icon }}
        @else
            <!-- Search/Empty list folder vector style -->
            <svg class="w-8 h-8 text-[#2A1B60]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @endif
    </div>
    
    <h3 class="text-base font-semibold text-gray-800 tracking-wide">{{ $title }}</h3>
    <p class="text-xs text-gray-500 max-w-sm mt-1 mb-5 font-medium leading-relaxed">{{ $description }}</p>
    
    @if($slot->isNotEmpty())
        <div>
            {{ $slot }}
        </div>
    @endif
</div>
