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

    <!-- Hero Banner Component -->
    <x-hero />

    <!-- Main Content Wrapper (Overlapping Card) -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-16 relative z-20">
        <div class="card-main min-h-[500px]">
            @yield('content')
        </div>
    </main>

    <!-- Footer Component -->
    <x-footer />

</body>
</html>
