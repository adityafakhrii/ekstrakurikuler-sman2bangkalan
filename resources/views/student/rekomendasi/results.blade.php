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

        <!-- Grid Layout: 2 Columns Desktop, 1 Column Mobile -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-16 max-w-5xl mx-auto">
            @foreach($ekskuls as $index => $ekskul)
                @php
                    $matchLabel = is_null($ekskul->skor)
                        ? null
                        : round($ekskul->skor) . '% Cocok';
                @endphp

                <div class="flex flex-col gap-4">
                    <!-- Gambar -->
                    <div class="w-full aspect-[16/10] overflow-hidden bg-gradient-to-tr {{ $gradients[$index % count($gradients)] }} p-6 sm:p-8 flex items-center justify-center">
                        <div class="w-full h-full overflow-hidden shadow-2xs">
                            <img src="{{ $ekskul->logo ? asset('storage/' . $ekskul->logo) : 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop' }}"
                                 alt="{{ $ekskul->nama }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x375?text={{ urlencode($ekskul->nama) }}'">
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-grow flex flex-col gap-2 text-left">
                        <h3 class="text-2xl font-bold text-gray-900 tracking-tight leading-none flex items-center flex-wrap gap-2">
                            {{ $ekskul->nama }}
                            @if($matchLabel)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700 border border-emerald-200/60 shadow-3xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $matchLabel }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500 border border-gray-200 shadow-3xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Bobot belum ditentukan
                                </span>
                            @endif
                        </h3>

                        <p class="text-xs text-gray-400 font-light leading-relaxed line-clamp-3">
                            {{ $ekskul->deskripsi }}
                        </p>
                    </div>

                    <!-- Link -->
                    <div class="pt-1">
                        <a href="{{ route('siswa.ekskul.show', $ekskul->id) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-800 hover:text-black transition-colors duration-150 cursor-pointer">
                            <span>Detail Ekskul</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
