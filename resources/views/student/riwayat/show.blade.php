@extends('layouts.student')

@section('title', 'Detail Riwayat Pendaftaran - EKSIS SMAN 2 Bangkalan')

@section('content')
<div class="py-12 bg-[#F9F9FB] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section matching screenshot -->
        <div class="text-center mb-10 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-[#1E1B4B] tracking-tight">
                Riwayat Pendaftaran
            </h1>
            <p class="mt-3 text-xs text-gray-500 leading-relaxed">
                Lihat riwayat pendaftaran anda untuk cek apakah pendaftaran sudah diterima oleh ketua atau dalam proses penerimaan. jika status sudah diterima maka tekan tombol Masuk Grup untuk masuk ke grup ekstrakurikuler {{ strtolower($pendaftaran->ekstrakurikuler->nama) }}.
            </p>
        </div>

        <!-- Box Container matching screenshot -->
        <div class="bg-white rounded-3xl border border-gray-150 shadow-xs p-8 sm:p-12 max-w-4xl mx-auto">

            <div class="flex flex-col lg:flex-row gap-10 items-start">

                <!-- Left: Image Container with beautiful gradient border and drop shadow -->
                <div class="w-full lg:w-80 shrink-0 flex justify-center">
                    <div class="w-64 h-64 sm:w-72 sm:h-72 p-1.5 bg-gradient-to-tr from-[#34D399] via-[#6366F1] to-[#EC4899] rounded-3xl shadow-lg relative">
                        <div class="w-full h-full rounded-2.5xl overflow-hidden bg-white">
                            @if ($pendaftaran->ekstrakurikuler->logo)
                                <img src="{{ asset('storage/' . $pendaftaran->ekstrakurikuler->logo) }}" alt="{{ $pendaftaran->ekstrakurikuler->nama }}" class="w-full h-full object-cover">
                            @else
                                <!-- School-style fallback image if logo is missing -->
                                <img src="/images/bg-school-hero.jpg" onerror="this.src='https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=school%20gate%20sma%20indonesia%20building%20realistic&image_size=square'" alt="{{ $pendaftaran->ekstrakurikuler->nama }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: Information Details -->
                <div class="flex-grow space-y-5 min-w-0 w-full">

                    <!-- Title & Description -->
                    <div class="space-y-2">
                        <h2 class="text-3xl font-extrabold text-[#1E1B4B]">
                            {{ $pendaftaran->ekstrakurikuler->nama }}
                        </h2>
                        <p class="text-xs text-gray-500 font-medium leading-relaxed">
                            {{ $pendaftaran->ekstrakurikuler->deskripsi }}
                        </p>
                    </div>

                    <!-- Details List styled exactly matching screenshot layout -->
                    <div class="space-y-3.5 pt-4 text-xs font-semibold text-gray-800">

                        <!-- Top Section -->
                        <div class="grid grid-cols-12 gap-x-2 items-center">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">Nama Pembina</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8 font-bold text-gray-900">Sugeng Priyatno</span>
                        </div>

                        <div class="grid grid-cols-12 gap-x-2 items-center">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">Nama Ketua</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8 font-bold text-gray-900">{{ $pendaftaran->ekstrakurikuler->ketua->name ?? 'Belum Ditentukan' }}</span>
                        </div>

                        <div class="grid grid-cols-12 gap-x-2 items-center">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">Jadwal Ekskul</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8 font-bold text-gray-900">
                                {{ $pendaftaran->ekstrakurikuler->jadwal ?: '-' }}
                            </span>
                        </div>

                        <!-- Horizontal Divider Line matching screenshot -->
                        <hr class="border-t border-gray-300 my-4">

                        <!-- Bottom Section (Student Profile) -->
                        <div class="grid grid-cols-12 gap-x-2 items-center">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">Nama</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8 font-bold text-gray-900">{{ strtolower($pendaftaran->siswa->user->name) }}</span>
                        </div>

                        <div class="grid grid-cols-12 gap-x-2 items-center">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">NISN</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8 font-bold text-gray-900">{{ $pendaftaran->siswa->nisn }}</span>
                        </div>

                        <div class="grid grid-cols-12 gap-x-2 items-center">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">Kelas - Jurusan</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8 font-bold text-gray-900">{{ strtolower($pendaftaran->siswa->kelas) }} {{ strtolower($pendaftaran->siswa->rombel) }}</span>
                        </div>

                        <!-- Status Badge matching screenshot color -->
                        <div class="grid grid-cols-12 gap-x-2 items-center pt-1.5">
                            <span class="col-span-4 sm:col-span-3 text-gray-800">Status</span>
                            <span class="col-span-1 text-center text-gray-800">:</span>
                            <span class="col-span-7 sm:col-span-8">
                                @if ($pendaftaran->status === 'disetujui')
                                    <span class="inline-flex items-center rounded-full bg-[#FCD34D] px-4 py-1 text-[11px] font-bold text-gray-900 shadow-2xs">
                                        Diterima
                                    </span>
                                @elseif ($pendaftaran->status === 'ditolak')
                                    <span class="inline-flex items-center rounded-full bg-rose-200 px-4 py-1 text-[11px] font-bold text-rose-900 shadow-2xs">
                                        Ditolak
                                    </span>
                                @elseif ($pendaftaran->status === 'dibatalkan')
                                    <span class="inline-flex items-center rounded-full bg-gray-200 px-4 py-1 text-[11px] font-bold text-gray-700 shadow-2xs">
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-yellow-200 px-4 py-1 text-[11px] font-bold text-yellow-900 shadow-2xs">
                                        Proses
                                    </span>
                                @endif
                            </span>
                        </div>

                    </div>

                    <!-- Action Buttons at bottom right matching screenshot -->
                    <div class="flex justify-end gap-3 pt-8 items-center">
                        @if ($pendaftaran->status === 'disetujui')
                            <!-- Yellow "Masuk Grup" button matching screenshot -->
                            <a href="https://chat.whatsapp.com/dummy-group-{{ $pendaftaran->ekstrakurikuler->slug }}"
                               target="_blank"
                               class="bg-[#FCD34D] hover:bg-[#FBBF24] text-gray-900 font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition-colors duration-150 flex items-center gap-1.5">
                                Masuk Grup
                            </a>
                        @endif

                        <!-- Dark/Black "< Kembali" button matching screenshot -->
                        <button type="button"
                                onclick="window.location.href='{{ route('siswa.register.history') }}'"
                                class="bg-[#1E293B] hover:bg-[#0F172A] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition-colors duration-150 flex items-center gap-1">
                                &lt; Kembali
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
