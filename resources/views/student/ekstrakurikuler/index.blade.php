@extends('layouts.student')

@section('title', 'Daftar Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot 1 -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Daftar Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Gabung ke Ekstrakurikuler yang kamu minati, masih bingung? coba rekomendasikan Ekstrakurikuler agar lebih spesifik dengan preferensi yang ada dalam dirimu.
            </p>
        </div>

        @php
            // Mock dummy Paskibra data exactly matching screenshot 1 (regular view before recommendation)
            $ekskuls = [
                [
                    'name' => 'Paskibra',
                    'match' => null, // No match percentage before recommendation
                    'gradient' => 'from-blue-200 via-indigo-150 to-purple-200', // Uniform soft blue gradient
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop' // Mockup website image matching screenshot 1
                ],
                [
                    'name' => 'Paskibra',
                    'match' => null,
                    'gradient' => 'from-blue-200 via-indigo-150 to-purple-200',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'match' => null,
                    'gradient' => 'from-blue-200 via-indigo-150 to-purple-200',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'match' => null,
                    'gradient' => 'from-blue-200 via-indigo-150 to-purple-200',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'match' => null,
                    'gradient' => 'from-blue-200 via-indigo-150 to-purple-200',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'match' => null,
                    'gradient' => 'from-blue-200 via-indigo-150 to-purple-200',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        @endphp

        <!-- Grid Layout: 2 Columns Desktop, 1 Column Mobile matching screenshot exactly (with wider vertical spacing) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-16 max-w-5xl mx-auto">
            @foreach($ekskuls as $index => $ekskul)
                <x-cards.ekskul-card 
                    name="{{ $ekskul['name'] }}"
                    match="{{ $ekskul['match'] }}"
                    gradient="{{ $ekskul['gradient'] }}"
                    description="{{ $ekskul['description'] }}"
                    image="{{ $ekskul['image'] }}"
                    route="{{ route('siswa.ekskul.show', $index + 1) }}"
                />
            @endforeach
        </div>
    </div>
@endsection
