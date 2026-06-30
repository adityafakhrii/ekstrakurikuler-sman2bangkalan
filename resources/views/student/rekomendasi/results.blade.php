@extends('layouts.student')

@section('title', 'Hasil Rekomendasi Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-cards.card title="Daftar Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-12 leading-relaxed">
            Kamu sudah merekomendasikan sesuai preferensimu untuk memilih Ekstrakurikuler, berikut Daftar Ekstrakurikuler yang sudah diurutkan dari yang paling cocok untukmu.
        </p>

        @php
            // Mock recommended extracurricular list sorted from highest matching percentage to lowest
            $ekskuls = [
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#eab308] to-[#ca8a04]', // Gold/Bronze
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#10b981] to-[#047857]', // Emerald Green
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#a3e635] to-[#65a30d]', // Lime/Yellow-Green
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#84cc16] to-[#4d7c0f]', // Olive Green
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#06b6d4] to-[#0369a1]', // Cyan/Blue
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'gradient' => 'from-[#a855f7] to-[#7e22ce]', // Purple/Indigo
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        @endphp

        <!-- Grid Layout: 2 Columns Desktop, 1 Column Mobile matching screenshot exactly -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
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

    </x-cards.card>
@endsection
