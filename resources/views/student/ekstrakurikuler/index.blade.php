@extends('layouts.student')

@section('title', 'Daftar Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-cards.card title="Daftar Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-12 leading-relaxed">
            Gabung ke Ekstrakurikuler yang kamu minati, masih bingung? coba rekomendasikan Ekstrakurikuler agar lebih spesifik dengan preferensi yang ada dalam dirimu.
        </p>

        @php
            // Mock dummy data exactly matching screenshot structure
            $ekskuls = [
                [
                    'name' => 'Paskibra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        @endphp

        <!-- Grid Layout: 2 Columns Desktop, 1 Column Mobile matching screenshot exactly -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
            @foreach($ekskuls as $index => $ekskul)
                <x-cards.ekskul-card 
                    name="{{ $ekskul['name'] }}"
                    description="{{ $ekskul['description'] }}"
                    image="{{ $ekskul['image'] }}"
                    route="{{ route('siswa.ekskul.show', $index + 1) }}"
                />
            @endforeach
        </div>

    </x-cards.card>
@endsection
