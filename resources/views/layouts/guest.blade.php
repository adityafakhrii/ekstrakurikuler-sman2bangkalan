<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EKSIS SMAN 2 Bangkalan')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-primary text-[#1f2937] antialiased min-h-screen flex flex-col justify-between relative">
    
    <!-- Hero Background Image (SMAN 2 Bangkalan) as Guest Backdrop -->
    <div class="absolute inset-0 z-0 bg-cover bg-center opacity-30 mix-blend-overlay" style="background-image: url('/images/bg-school-hero.jpg');"></div>
    <!-- Dark overlay to ensure contrast -->
    <div class="absolute inset-0 bg-gradient-to-tr from-brand-primary via-brand-primary/95 to-brand-primary/90 z-0"></div>

    <!-- Header Logo & Brand (Guest) -->
    <header class="relative z-10 w-full pt-10 px-4 text-center">
        <div class="inline-flex items-center gap-3">
            <img src="/images/logo-sman2.png" alt="Logo SMAN 2 Bangkalan" class="h-16 w-auto object-contain" onerror="this.src='https://placehold.co/100x100?text=SMAN2'">
            <span class="text-3xl font-bold tracking-wider text-white">EKSIS</span>
        </div>
    </header>

    <!-- Main Container -->
    <main class="relative z-10 flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border border-[#f2eaea]">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 text-white/60 py-6 text-center text-xs font-light">
        Copyright &copy; 2025 SMAN 2 Bangkalan | Ahmad Jihaduddin Salim
    </footer>

</body>
</html>
