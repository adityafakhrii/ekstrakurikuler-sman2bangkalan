@extends('layouts.student')

@section('title', 'Riwayat Pendaftaran - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot 1 -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Riwayat Pendaftaran
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Lihat riwayat pendaftaran anda untuk cek apakah pendaftaran sudah diterima oleh ketua atau dalam proses penerimaan
            </p>
        </div>

        @php
            $registrations = [
                [
                    'id' => 1,
                    'ekskul' => 'Pramuka',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=300&auto=format&fit=crop',
                    'status' => 'Diterima'
                ],
                [
                    'id' => 2,
                    'ekskul' => 'Voli',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=300&auto=format&fit=crop',
                    'status' => 'Proses'
                ],
                [
                    'id' => 3,
                    'ekskul' => 'Futsal Putra',
                    'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                    'image' => 'https://images.unsplash.com/photo-1579952360673-2a04154074de?q=80&w=300&auto=format&fit=crop',
                    'status' => 'Proses'
                ]
            ];
        @endphp

        <!-- Large Content Card Wrapper matching screenshot bg-color -->
        <div class="bg-[#F3F4F6]/50 rounded-[2.5rem] p-6 sm:p-12 max-w-5xl mx-auto space-y-8 shadow-2xs border border-gray-100/50">
            
            <!-- List of registrations -->
            @foreach($registrations as $reg)
                <!-- Outer Gradient Border Container -->
                <div class="bg-gradient-to-r from-[#C2D6FF] via-[#E2E6FF] to-[#DBCDC5] rounded-3xl p-5 md:p-6 shadow-sm">
                    
                    <!-- Inner White Content Card -->
                    <div class="bg-white rounded-2xl p-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                        
                        <!-- Left Info (Image, Title, Desc, Link) -->
                        <div class="flex flex-col sm:flex-row gap-5 items-center sm:items-start flex-grow">
                            <!-- Image -->
                            <div class="w-32 h-20 sm:w-36 sm:h-24 rounded-lg overflow-hidden flex-shrink-0 shadow-xs">
                                <img src="{{ $reg['image'] }}" alt="{{ $reg['ekskul'] }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Title & Desc & Link -->
                            <div class="space-y-2 text-center sm:text-left">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">
                                    {{ $reg['ekskul'] }}
                                </h3>
                                <p class="text-xs text-gray-400 font-light leading-relaxed max-w-xl line-clamp-2">
                                    {{ $reg['description'] }}
                                </p>
                                <a href="{{ route('siswa.register.history.show', $reg['id']) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-800 hover:text-black transition-colors pt-1 cursor-pointer">
                                    <span>Detail Pendaftaran</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Right Info (Status Badge) -->
                        <div class="flex-shrink-0">
                            <span class="bg-[#FCD34D] text-gray-800 text-xs font-bold px-6 py-2 rounded-full shadow-3xs border-0">
                                {{ $reg['status'] }}
                            </span>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    </div>
@endsection
