@extends('layouts.student')

@section('title', 'Riwayat Pendaftaran - EKSIS SMAN 2 Bangkalan')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-brand-primary sm:text-4xl">
                Riwayat Pendaftaran
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-sm text-gray-500">
                Lihat riwayat pendaftaran anda untuk cek apakah pendaftaran sudah diterima oleh ketua atau dalam proses penerimaan.
            </p>
        </div>

        <!-- Cards List -->
        <div class="space-y-6">
            @forelse ($registrations as $reg)
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col md:flex-row items-center p-6 gap-6 relative">
                    <!-- Subtle brand highlight border -->
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-[#6366F1] to-[#2A1B60]"></div>

                    <!-- Ekskul Image / Logo placeholder -->
                    <div class="w-full md:w-44 h-28 rounded-xl overflow-hidden bg-[#e5e0f5]/50 flex items-center justify-center shrink-0 border border-[#f2eaea]">
                        @if ($reg->ekstrakurikuler->logo)
                            <img src="{{ asset('storage/' . $reg->ekstrakurikuler->logo) }}" alt="{{ $reg->ekstrakurikuler->nama }}" class="w-full h-full object-cover">
                        @else
                            <!-- Generic fallback image representing student activities -->
                            <div class="flex flex-col items-center justify-center text-brand-primary/60">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                                <span class="text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $reg->ekstrakurikuler->kategori }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Ekskul Details -->
                    <div class="flex-grow space-y-2 text-center md:text-left min-w-0">
                        <h2 class="text-xl font-extrabold text-gray-900 truncate">
                            {{ $reg->ekstrakurikuler->nama }}
                        </h2>
                        <p class="text-xs text-gray-500 font-medium line-clamp-2 leading-relaxed">
                            {{ $reg->ekstrakurikuler->deskripsi }}
                        </p>
                        
                        <div class="pt-2">
                            <a href="{{ route('siswa.register.history.show', $reg->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#6366F1] hover:text-[#4F46E5] transition-colors duration-150 group">
                                Detail Pendaftaran 
                                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform duration-150" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="shrink-0 flex items-center justify-center md:pl-4">
                        @if ($reg->status === 'disetujui')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-5 py-2 text-xs font-bold text-emerald-700 border border-emerald-200/60 shadow-xs uppercase tracking-wide">
                                Diterima
                            </span>
                        @elseif ($reg->status === 'ditolak')
                            <span class="inline-flex items-center rounded-full bg-rose-50 px-5 py-2 text-xs font-bold text-rose-700 border border-rose-200/60 shadow-xs uppercase tracking-wide">
                                Ditolak
                            </span>
                        @elseif ($reg->status === 'dibatalkan')
                            <span class="inline-flex items-center rounded-full bg-gray-50 px-5 py-2 text-xs font-bold text-gray-600 border border-gray-200 shadow-xs uppercase tracking-wide">
                                Batal
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-yellow-50 px-5 py-2 text-xs font-bold text-yellow-700 border border-yellow-200/60 shadow-xs uppercase tracking-wide">
                                Proses
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-2xl border border-gray-200/80 p-8 shadow-xs flex flex-col items-center">
                    <div class="w-16 h-16 bg-[#e5e0f5]/60 rounded-full flex items-center justify-center text-brand-primary/50 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Riwayat Pendaftaran</h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-sm">Anda belum mendaftar ke ekstrakurikuler mana pun untuk tahun ajaran aktif ini.</p>
                    <a href="{{ route('siswa.ekskul.index') }}" class="mt-5 inline-flex items-center justify-center px-4 py-2 bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-bold rounded-lg transition-colors duration-150 shadow-xs">
                        Lihat Ekstrakurikuler
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
