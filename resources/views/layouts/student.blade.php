@extends('layouts.app')

@section('layout-content')
    <!-- Sticky Navbar Component (Reused dynamically for Student/Admin) -->
    <x-navigation.navbar />

    <!-- Hero Section (Shown only where needed via section block) -->
    @hasSection('hero')
        @yield('hero')
    @endif

    <!-- Content Wrapper (Offsets overlap margin if Hero is present, or allows full-width if no Hero is defined) -->
    @hasSection('hero')
        <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-16 relative z-20">
            @yield('content')
        </main>
    @else
        <main class="flex-grow w-full relative z-20">
            @yield('content')
        </main>
    @endif

    <!-- Footer Component -->
    <x-footer />
@endsection
