@extends('layouts.app')

@section('layout-content')
    @hasSection('guest-backdrop')
        <!-- Hero Background Image (SMAN 2 Bangkalan) as Guest Backdrop -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-30 mix-blend-overlay" style="background-image: url('/images/bg-school-hero.jpg');"></div>
        <!-- Dark overlay to ensure contrast -->
        <div class="absolute inset-0 bg-gradient-to-tr from-[#2A1B60] via-[#2A1B60]/95 to-[#3b258c] z-0"></div>

        <div class="relative z-10 min-h-screen w-full flex flex-col justify-between p-4">
            <!-- Header Logo & Brand (Guest) -->
            <header class="w-full pt-10 text-center">
                <div class="inline-flex items-center gap-3">
                    <img src="/images/logo-sman2.png" alt="Logo SMAN 2 Bangkalan" class="h-16 w-auto object-contain" onerror="this.src='https://placehold.co/100x100?text=SMAN2'">
                    <span class="text-3xl font-bold tracking-wider text-white">EKSIS</span>
                </div>
            </header>

            <!-- Main Container -->
            <main class="flex-grow flex items-center justify-center p-4">
                <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border border-[#f2eaea]">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="text-white/60 py-6 text-center text-xs font-light">
                Copyright &copy; 2025 SMAN 2 Bangkalan | Ahmad Jihaduddin Salim
            </footer>
        </div>
    @else
        <!-- Fullscreen layout without backdrop (e.g. for student/ketua login) -->
        <main class="flex-grow w-full min-h-screen flex items-center justify-center p-4">
            @yield('content')
        </main>
    @endif
@endsection
