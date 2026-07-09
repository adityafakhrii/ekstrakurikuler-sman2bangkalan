@extends('layouts.student')

@section('title', 'Detail Riwayat Pendaftaran - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot 2 -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Riwayat Pendaftaran
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-3xl mx-auto leading-relaxed">
                Lihat riwayat pendaftaran anda untuk cek apakah pendaftaran sudah diterima oleh ketua atau dalam proses penerimaan. jika status sudah diterima maka tekan tombol Masuk Grup untuk masuk ke grup ekstrakurikuler pramuka.
            </p>
        </div>

        @php
            // Mocking detail data based on ID, mapping precisely to screenshot 2
            $detail = [
                'ekskul' => 'Pramuka',
                'description' => 'Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle. Apparently we had reached a great height in the atmosphere, for the sky was a dead black, and the stars had ceased to twinkle.',
                'image' => 'https://images.unsplash.com/photo-1473163928189-364b2c4e1135?q=80&w=600&auto=format&fit=crop',
                'pembina' => 'Sugeng Priyatno',
                'ketua' => 'Fuad Sasmita',
                'jadwal' => 'Jum\'at, Jam 12.30 - 15.30',
                'nama_pendaftar' => 'Ahmad Jihadudin salim',
                'nisn' => '21082',
                'kelas_jurusan' => '10 mipa 2',
                'status' => 'Diterima'
            ];
        @endphp

        <!-- Large Content Card Wrapper matching screenshot bg-color -->
        <div class="bg-[#F3F4F6]/50 rounded-[2.5rem] p-6 sm:p-12 max-w-5xl mx-auto shadow-2xs border border-gray-100">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Left Side: Image with shadow/gradient offset box matching screenshot 2 -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="bg-gradient-to-br from-[#86EFAC] via-[#93C5FD] to-[#A5B4FC] rounded-[2.5rem] p-5 shadow-lg max-w-sm w-full">
                        <div class="aspect-square rounded-[2rem] overflow-hidden shadow-md">
                            <img src="{{ $detail['image'] }}" alt="{{ $detail['ekskul'] }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Right Side: Detail Info Fields with colon alignment matching screenshot 2 -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Title & Desc -->
                    <div class="space-y-3">
                        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">
                            {{ $detail['ekskul'] }}
                        </h2>
                        <p class="text-xs text-gray-500 font-light leading-relaxed">
                            {{ $detail['description'] }}
                        </p>
                    </div>

                    <!-- Info Grid (Rata Kiri, Titik dua sejajar vertikal) -->
                    <div class="space-y-4 text-xs font-semibold text-gray-800">
                        <!-- Pembina -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Nama Pembina</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $detail['pembina'] }}</span>
                        </div>
                        <!-- Ketua -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Nama Ketua</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $detail['ketua'] }}</span>
                        </div>
                        <!-- Jadwal -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Jadwal Ekskul</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $detail['jadwal'] }}</span>
                        </div>

                        <!-- Divider line -->
                        <div class="border-t border-gray-300/80 my-4"></div>

                        <!-- Nama Pendaftar -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Nama</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $detail['nama_pendaftar'] }}</span>
                        </div>
                        <!-- NISN -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">NISN</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $detail['nisn'] }}</span>
                        </div>
                        <!-- Kelas -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Kelas - Jurusan</span>
                            <span class="col-span-1 text-center">:</span>
                            <span class="col-span-7 text-left text-gray-600 font-medium">{{ $detail['kelas_jurusan'] }}</span>
                        </div>
                        <!-- Status with yellow badge -->
                        <div class="grid grid-cols-12 gap-1 items-center">
                            <span class="col-span-4 text-left">Status</span>
                            <span class="col-span-1 text-center">:</span>
                            <div class="col-span-7 text-left">
                                <span class="bg-[#FDE047] text-gray-800 text-[10px] font-extrabold uppercase px-6 py-1.5 rounded-full tracking-wider border-0 shadow-3xs inline-block">
                                    {{ $detail['status'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons matching screenshot 2 (Right aligned bottom) -->
                    <div class="flex justify-end gap-3 pt-6">
                        <!-- Masuk Grup (Only shown if status is Diterima / success) -->
                        @if($detail['status'] === 'Diterima')
                            <x-buttons.button type="button" class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] py-3 px-8 rounded-full text-xs font-bold shadow-2xs border-0 cursor-pointer">
                                Masuk Grup
                            </x-buttons.button>
                        @endif

                        <!-- Kembali Button (Dark Slate matching screenshot) -->
                        <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('siswa.register.history') }}'" class="bg-[#1E293B] hover:bg-[#0F172A] text-white py-3 px-8 rounded-full text-xs font-bold shadow-2xs border-0 cursor-pointer">
                            Kembali
                        </x-buttons.button>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
