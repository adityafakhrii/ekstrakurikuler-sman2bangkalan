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
            $gradients = [
                'from-[#8A827B] to-[#C3BDB9]',
                'from-[#3B7A81] to-[#98B5B4]',
                'from-[#D6E35C] to-[#BDC199]',
                'from-[#508C1B] to-[#A4B67F]',
                'from-[#00A3A6] to-[#81B5BD]',
                'from-[#68357B] to-[#A19BA8]'
            ];
        @endphp

        <!-- Grid Layout: 2 Columns Desktop, 1 Column Mobile matching screenshot exactly (with wider vertical spacing) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-16 max-w-5xl mx-auto">
            @foreach($ekskuls as $index => $ekskul)
                <x-cards.ekskul-card 
                    name="{{ $ekskul->nama }}"
                    match="{{ round($ekskul->skor) }}% Cocok"
                    gradient="{{ $gradients[$index % count($gradients)] }}"
                    description="{{ $ekskul->deskripsi }}"
                    image="{{ $ekskul->logo ? asset('storage/' . $ekskul->logo) : 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop' }}"
                    route="{{ route('siswa.ekskul.show', $ekskul->id) }}"
                />
            @endforeach
        </div>
    </div>
@endsection
