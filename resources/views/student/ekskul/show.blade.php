@extends('layouts.student')

@section('title', 'Detail Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-ui.card title="Detail Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-10 leading-relaxed">
            Lihat Detail Ekstrakurikuler untuk mengenal lebih sebelum mendaftar, dan pastikan jadwal kegiatan ekstrakurikuler tidak bentrok dengan jadwal lain kamu.
        </p>

        @php
            // Mock dynamic details based on ID
            $id = request()->route('id', 1);
            
            $details = [
                1 => [
                    'name' => 'Pramuka',
                    'pembina' => 'Sugeng Priyatno',
                    'ketua' => 'Fuad Sasmita',
                    'jadwal' => 'Jum’at, Jam 12.30 - 15.30',
                    'description' => 'Pramuka adalah wadah pembinaan karakter, melatih kemandirian, tanggung jawab, dan jiwa kepemimpinan siswa. Melalui baris-berbaris, tali-temali, dan perkemahan, anggota belajar bekerja sama secara taktis menghadapi tantangan di alam bebas.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                2 => [
                    'name' => 'Paskibra',
                    'pembina' => 'Sugeng Priyatno',
                    'ketua' => 'Fuad Sasmita',
                    'jadwal' => 'Sabtu, Jam 08.00 - 11.00',
                    'description' => 'Paskibra melatih siswa dalam ketegasan, kekuatan fisik, baris-berbaris yang presisi, dan menumbuhkan rasa cinta tanah air serta jiwa nasionalisme yang kuat melalui upacara bendera dan kegiatan sosial.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                3 => [
                    'name' => 'Futsal',
                    'pembina' => 'Sugeng Priyatno',
                    'ketua' => 'Fuad Sasmita',
                    'jadwal' => 'Rabu, Jam 15.30 - 17.30',
                    'description' => 'Futsal mengasah ketangkasan fisik, koordinasi motorik, taktik permainan, dan sportivitas melalui latihan intensif dan pertandingan persahabatan tingkat daerah.',
                    'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop'
                ]
            ];

            // Default fallback if ID doesn't exist in dummy list
            $ekskul = $details[$id] ?? $details[1];
        @endphp

        <!-- Detail Box Content Grid -->
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10 bg-[#FCFBFB] border border-[#f2eaea] rounded-3xl p-6 md:p-8 shadow-xs">
            
            <!-- Left Side: Image with gradient curved border matching screenshot -->
            <div class="w-full md:w-2/5 flex items-center justify-center">
                <div class="relative w-full max-w-xs">
                    <div class="aspect-square w-full rounded-[2rem] overflow-hidden bg-white p-1.5 border-2 border-[#f2eaea] shadow-md">
                        <div class="w-full h-full rounded-[1.8rem] overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-tr from-[#6366F1]/30 via-transparent to-[#FBCFE8]/25 z-10 pointer-events-none"></div>
                            <img src="{{ $ekskul['image'] }}" alt="{{ $ekskul['name'] }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Details Information -->
            <div class="w-full md:w-3/5 space-y-6">
                <!-- Title -->
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                    {{ $ekskul['name'] }}
                </h2>
                
                <!-- Description Paragraph -->
                <p class="text-sm text-gray-500 font-light leading-relaxed">
                    {{ $ekskul['description'] }}
                </p>

                <!-- Information Table List -->
                <div class="space-y-3.5 border-t border-b border-gray-100 py-5">
                    <!-- Pembina -->
                    <div class="flex items-center text-sm">
                        <span class="w-1/3 font-semibold text-gray-800">Nama Pembina</span>
                        <span class="w-8 text-center text-gray-400">:</span>
                        <span class="w-2/3 text-gray-600 font-medium">{{ $ekskul['pembina'] }}</span>
                    </div>
                    <!-- Ketua -->
                    <div class="flex items-center text-sm">
                        <span class="w-1/3 font-semibold text-gray-800">Nama Ketua</span>
                        <span class="w-8 text-center text-gray-400">:</span>
                        <span class="w-2/3 text-gray-600 font-medium">{{ $ekskul['ketua'] }}</span>
                    </div>
                    <!-- Jadwal -->
                    <div class="flex items-center text-sm">
                        <span class="w-1/3 font-semibold text-gray-800">Jadwal Ekskul</span>
                        <span class="w-8 text-center text-gray-400">:</span>
                        <span class="w-2/3 text-gray-600 font-medium">{{ $ekskul['jadwal'] }}</span>
                    </div>
                </div>

                <!-- Action Button Actions -->
                <div class="flex items-center gap-3 pt-2">
                    <!-- Daftar Button (Yellow styled) -->
                    <x-ui.button 
                        onclick="window.location.href='{{ route('siswa.register.create', $id) }}'"
                        class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] px-8 py-3 rounded-xl text-xs font-semibold shadow-xs cursor-pointer border-0"
                    >
                        Daftar
                    </x-ui.button>

                    <!-- Kembali Button (Dark Gray/Navy with arrow) -->
                    <x-ui.button 
                        onclick="window.history.back()"
                        class="bg-[#2D3748] hover:bg-[#1A202C] text-white px-6 py-3 rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 cursor-pointer border-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Kembali
                    </x-ui.button>
                </div>
            </div>

        </div>

    </x-ui.card>
@endsection
