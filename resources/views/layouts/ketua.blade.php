@extends('layouts.app')

@section('layout-content')
    <!-- Top Navigation Header Component -->
    <x-navigation.navbar />

    <!-- Hero Banner Component (Customized for Ketua layout reference) -->
    <section class="relative bg-[#2A1B60] min-h-[360px] md:min-h-[380px] flex items-center justify-center text-center px-4 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-40 mix-blend-overlay" 
             style="background-image: url('/images/bg-school-hero.jpg');">
        </div>
        
        <!-- Dark Violet Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#2A1B60]/75 via-[#2A1B60]/90 to-[#2A1B60] z-0"></div>

        <!-- Centered Content matching layout titles -->
        <div class="relative z-10 max-w-4xl mx-auto pb-24 md:pb-28">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-wide text-white drop-shadow-md leading-tight">
                Sistem Informasi Ekstrakurikuler
            </h1>
            <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mt-3 drop-shadow-sm">
                SMAN 2 Bangkalan
            </p>
            <p class="text-lg sm:text-xl md:text-2xl font-medium text-white/95 mt-3 drop-shadow-sm">
                Ekstrakurikuler | {{ auth()->user()->ekstrakurikuler->nama ?? 'Tidak ada Ekstrakurikuler' }}
            </p>
        </div>
    </section>

    <!-- Main Content Wrapper (With overlap margin matching Admin dashboard) -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-16 relative z-20">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <x-footer />
@endsection
