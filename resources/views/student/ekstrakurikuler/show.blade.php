@extends('layouts.student')

@section('title', 'Detail Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Detail Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Lihat Detail Ekstrakurikuler untuk mengenal lebih sebelum mendaftar, dan pastikan jadwal kegiatan ekstrakurikuler tidak bentrok dengan jadwal lain kamu.
            </p>
        </div>

        @php
            // Mock dynamic details based on ID
            $id = request()->route('id', 1);
            
            $details = [
                1 => [
                    'name' => 'Pramuka',
                    'pembina' => 'Sugeng Priyatno',
                    'ketua' => 'Fuad Sasmita',
                    'jadwal' => 'Jum’at, Jam 12.30 - 15.30',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle. Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'
                ],
                2 => [
                    'name' => 'Paskibra',
                    'pembina' => 'Sugeng Priyatno',
                    'ketua' => 'Fuad Sasmita',
                    'jadwal' => 'Sabtu, Jam 08.00 - 11.00',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle. Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                3 => [
                    'name' => 'Futsal',
                    'pembina' => 'Sugeng Priyatno',
                    'ketua' => 'Fuad Sasmita',
                    'jadwal' => 'Rabu, Jam 15.30 - 17.30',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle. Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop'
                ]
            ];

            // Default fallback if ID doesn't exist in dummy list
            $ekskul = $details[$id] ?? $details[1];
        @endphp

        <!-- Large Content Card Wrapper matching screenshot bg-color -->
        <div class="bg-[#F3F4F6]/50 rounded-[2.5rem] p-6 sm:p-12 max-w-5xl mx-auto shadow-2xs border border-gray-100/50">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Left Side: Image with shadow/gradient offset box matching screenshot -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="bg-gradient-to-br from-[#86EFAC] via-[#93C5FD] to-[#A5B4FC] rounded-[2.5rem] p-5 shadow-lg max-w-sm w-full">
                        <div class="aspect-square rounded-[2rem] overflow-hidden shadow-md">
                            <img src="{{ $ekskul['image'] }}" alt="{{ $ekskul['name'] }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Right Side: Detail Info Fields with colon alignment matching screenshot -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Title & Desc -->
                    <div class="space-y-3">
                        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">
                            {{ $ekskul['name'] }}
                        </h2>
                        <p class="text-xs text-gray-500 font-light leading-relaxed">
                            {{ $ekskul['description'] }}
                        </p>
                    </div>

                    <!-- Info Grid (Rata Kiri, Titik dua sejajar vertikal) -->
                    <div class="space-y-4 text-xs font-semibold text-gray-800">
                        <!-- Pembina -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Nama Pembina</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $ekskul['pembina'] }}</span>
                        </div>
                        <!-- Ketua -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Nama Ketua</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $ekskul['ketua'] }}</span>
                        </div>
                        <!-- Jadwal -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Jadwal Ekskul</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $ekskul['jadwal'] }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons matching screenshot 2 (Right aligned bottom) -->
                    <div class="flex justify-end gap-3 pt-6">
                        <!-- Daftar Button (Yellow styled, rounded-full) -->
                        <x-buttons.button 
                            onclick="window.location.href='{{ route('siswa.register.create', $id) }}'"
                            class="bg-[#FCD34D] hover:bg-[#FACC15] text-[#1F2937] py-3 px-8 rounded-full text-xs font-bold border-0 cursor-pointer shadow-3xs"
                        >
                            Daftar
                        </x-buttons.button>

                        <!-- Kembali Button (Dark Slate matching screenshot) -->
                        <x-buttons.button 
                            onclick="window.history.back()"
                            class="bg-[#1E293B] hover:bg-[#0F172A] text-white py-3 px-8 rounded-full text-xs font-bold border-0 cursor-pointer shadow-3xs flex items-center gap-1.5"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Kembali
                        </x-buttons.button>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
