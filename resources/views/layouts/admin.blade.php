@extends('layouts.app')

@section('layout-content')
    <!-- Top Navigation Header Component -->
    <x-navigation.navbar />

    <!-- Hero Banner Component -->
    <x-hero />

    <!-- Main Content Wrapper (With overlap margin) -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-16 relative z-20">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <x-footer />
@endsection
