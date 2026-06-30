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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/shared/app.css', 'resources/js/shared/app.js'])

    @stack('styles')
</head>
<body class="font-sans bg-[#f3f4f6] text-[#1f2937] antialiased min-h-screen flex flex-col justify-between relative">

    @yield('layout-content')

    @stack('scripts')
</body>
</html>
