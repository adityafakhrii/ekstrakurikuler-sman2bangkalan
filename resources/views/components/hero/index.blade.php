@props([
    'title' => 'Sistem Informasi Ekstrakurikuler',
    'subtitle' => 'SMAN 2 Bangkalan',
    'backgroundImage' => '/images/background.png'
])

<section class="relative bg-[#2A1B60] min-h-[360px] md:min-h-[380px] flex items-center justify-center text-center px-4 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-cover bg-center" 
         style="background-image: url('{{ $backgroundImage }}'); opacity: 0.55;">
    </div>
    
    <!-- Dark Overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-b from-[#2A1B60]/60 via-[#2A1B60]/65 to-[#2A1B60]/80 z-0"></div>

    <!-- Centered Content -->
    <div class="relative z-10 max-w-4xl mx-auto pb-24 md:pb-28">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-wide text-white drop-shadow-md leading-tight">
            {{ $title }}
        </h1>
        <p class="text-xl sm:text-2xl md:text-3xl font-semibold text-white/95 mt-3 drop-shadow-sm">
            {{ $subtitle }}
        </p>
    </div>
</section>
