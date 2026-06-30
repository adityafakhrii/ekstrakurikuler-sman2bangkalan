<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf-token() }}">

    <title>@yield('title', 'EKSIS SMAN 2 Bangkalan')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-[#f3f4f6] text-[#1f2937] antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Header Component -->
    <x-navbar />

    <!-- Hero Banner with Background Image and Violet Overlay -->
    <section class="relative bg-brand-primary min-h-[380px] flex items-center justify-center text-center px-4 overflow-hidden">
        <!-- Hero Background Image (SMAN 2 Bangkalan) -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-40 mix-blend-overlay" style="background-image: url('/images/bg-school-hero.jpg');"></div>
        <!-- Dark overlay to ensure text contrast -->
        <div class="absolute inset-0 bg-gradient-to-b from-brand-primary/80 via-brand-primary/90 to-brand-primary z-0"></div>

        <div class="relative z-10 max-w-4xl mx-auto pb-24">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-wide text-white drop-shadow-md">
                Sistem Informasi Ekstrakurikuler
            </h1>
            <p class="text-xl sm:text-2xl md:text-3xl font-semibold text-white/95 mt-3 drop-shadow-sm">
                SMAN 2 Bangkalan
            </p>
        </div>
    </section>

    <!-- Main Content Wrapper (Overlapping Card) -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-16 relative z-20">
        <div class="card-main min-h-[500px]">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-primary text-white py-6 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm font-medium tracking-wide">
            Copyright &copy; 2025 SMAN 2 Bangkalan | Ahmad Jihaduddin Salim
        </div>
    </footer>

</body>
</html>
