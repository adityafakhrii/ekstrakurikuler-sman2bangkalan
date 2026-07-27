@extends('layouts.student')

@section('title', 'Riwayat Pendaftaran - EKSIS SMAN 2 Bangkalan')

@section('content')
<div class="py-12 bg-[#F9F9FB] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section matching screenshot -->
        <div class="text-center mb-10 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-[#1E1B4B] tracking-tight">
                Riwayat Pendaftaran
            </h1>
            <p class="mt-3 text-xs text-gray-500 leading-relaxed">
                Lihat riwayat pendaftaran anda untuk cek apakah pendaftaran sudah diterima oleh ketua atau dalam proses penerimaan
            </p>
        </div>

        <!-- Cards List -->
        <div class="space-y-8 max-w-3xl mx-auto">
            @forelse ($registrations as $reg)
                <!-- Outer Gradient Border Container matching screenshot -->
                <div class="bg-gradient-to-tr from-[#93C5FD] via-[#A5B4FC] to-[#FCA5A5] p-5 sm:p-6 rounded-3xl shadow-sm">

                    <!-- Inner Solid White Box -->
                    <div class="bg-white rounded-2.5xl p-5 sm:p-6 flex flex-col sm:flex-row items-center gap-5 sm:gap-6">

                        <!-- Left: Ekskul Image -->
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden bg-gray-150 shrink-0 border border-gray-100 shadow-3xs">
                            <img src="{{ $reg->ekstrakurikuler->logo_url }}" alt="{{ $reg->ekstrakurikuler->nama }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Right: Details Content -->
                        <div class="flex-grow min-w-0 w-full flex flex-col justify-between self-stretch py-1">

                            <!-- Title & Description -->
                            <div class="space-y-1 text-center sm:text-left">
                                <h2 class="text-xl sm:text-2xl font-extrabold text-[#1E1B4B] tracking-tight">
                                    {{ $reg->ekstrakurikuler->nama }}
                                </h2>
                                <p class="text-[10px] sm:text-xs text-gray-500 font-medium leading-relaxed line-clamp-2">
                                    {{ $reg->ekstrakurikuler->deskripsi }}
                                </p>
                            </div>

                            <!-- Footer Info (Link & Status Badge) matching screenshot layout -->
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 mt-auto">
                                <!-- Detail Link -->
                                <a href="{{ route('siswa.register.history.show', $reg->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1E1B4B] hover:text-[#4F46E5] transition-colors duration-150 group">
                                    <span>Detail Pendaftaran</span>
                                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform duration-150" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>

                                <!-- Status Badge matching screenshot color -->
                                <div>
                                    @if ($reg->status === 'disetujui')
                                        <span class="inline-flex items-center rounded-full bg-[#FCD34D] px-5 py-1.5 text-xs font-bold text-gray-900 shadow-3xs tracking-wide">
                                            Diterima
                                        </span>
                                    @elseif ($reg->status === 'ditolak')
                                        <span class="inline-flex items-center rounded-full bg-rose-200 px-5 py-1.5 text-xs font-bold text-rose-900 shadow-3xs tracking-wide">
                                            Ditolak
                                        </span>
                                    @elseif ($reg->status === 'dibatalkan')
                                        <span class="inline-flex items-center rounded-full bg-gray-200 px-5 py-1.5 text-xs font-bold text-gray-700 shadow-3xs tracking-wide">
                                            Batal
                                        </span>
                                    @else
                                        <!-- Yellow/Lime status badge matching screenshot "Proses" color -->
                                        <span class="inline-flex items-center rounded-full bg-[#E5F93C] px-5 py-1.5 text-xs font-bold text-gray-900 shadow-3xs tracking-wide">
                                            Proses
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-3xl border border-gray-150 p-8 shadow-xs flex flex-col items-center max-w-xl mx-auto">
                    <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center text-[#6366F1] mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Riwayat Pendaftaran</h3>
                    <p class="text-xs text-gray-500 mt-1 max-w-sm">Anda belum mendaftar ke ekstrakurikuler mana pun untuk tahun ajaran aktif ini.</p>
                    <a href="{{ route('siswa.ekskul.index') }}" class="mt-5 inline-flex items-center justify-center px-5 py-2.5 bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-bold rounded-xl transition-colors duration-150 shadow-xs">
                        Lihat Ekstrakurikuler
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="mt-8 flex justify-center">
            {{ $registrations->links() }}
        </div>

    </div>
</div>
@endsection
