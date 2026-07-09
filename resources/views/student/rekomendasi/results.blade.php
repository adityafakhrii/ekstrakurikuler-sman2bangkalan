@extends('layouts.student')

@section('title', 'Hasil Rekomendasi Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot 2 (After recommendation results) -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Daftar Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Kamu sudah me-rekomendasikan sesuai preferensimu untuk memilih Ekstrakurikuler, berikut Daftar Ekstrakurikuler yang sudah diurutkan dari yang paling cocok untukmu.
            </p>
        </div>

        @php
            // Mock recommended extracurricular list sorted from highest matching percentage to lowest matching screenshot 2
            $ekskuls = [
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#8A827B] to-[#C3BDB9]', // Clay/Sand
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#3B7A81] to-[#98B5B4]', // Muted Ocean/Teal
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#D6E35C] to-[#BDC199]', // Lime Green/Khaki
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#508C1B] to-[#A4B67F]', // Olive/Sage Green
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#00A3A6] to-[#81B5BD]', // Muted Cyan/Slate Blue
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#68357B] to-[#A19BA8]', // Muted Plum/Lavender
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
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
