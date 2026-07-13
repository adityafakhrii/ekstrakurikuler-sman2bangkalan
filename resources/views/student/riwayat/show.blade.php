@extends('layouts.student')

@section('title', 'Detail Pendaftaran - EKSIS SMAN 2 Bangkalan')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('siswa.register.history') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-gray-900 transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Riwayat
            </a>
        </div>

        <!-- Main Detail Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Ekskul Info Card -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200/85 p-6 shadow-xs flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute left-0 right-0 top-0 h-1.5 bg-[#6366F1]"></div>

                    <!-- Ekskul Logo -->
                    <div class="w-32 h-32 rounded-2xl bg-[#e5e0f5]/50 flex items-center justify-center border border-[#f2eaea] overflow-hidden mb-4 shadow-2xs">
                        @if ($pendaftaran->ekstrakurikuler->logo)
                            <img src="{{ asset('storage/' . $pendaftaran->ekstrakurikuler->logo) }}" alt="{{ $pendaftaran->ekstrakurikuler->nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center text-brand-primary/60">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <h2 class="text-xl font-extrabold text-gray-900 leading-tight">
                        {{ $pendaftaran->ekstrakurikuler->nama }}
                    </h2>
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-[10px] font-bold text-indigo-700 border border-indigo-200 mt-2 uppercase tracking-wider">
                        {{ $pendaftaran->ekstrakurikuler->kategori }}
                    </span>

                    <p class="text-xs text-gray-500 font-medium mt-4 leading-relaxed line-clamp-4">
                        {{ $pendaftaran->ekstrakurikuler->deskripsi }}
                    </p>

                    <!-- Status Badge -->
                    <div class="mt-6 pt-6 border-t border-gray-100 w-full">
                        <span class="text-xs text-gray-400 font-bold block mb-2 uppercase tracking-wide">Status</span>
                        @if ($pendaftaran->status === 'disetujui')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-6 py-2 text-xs font-bold text-emerald-700 border border-emerald-200/60 shadow-2xs uppercase tracking-wider">
                                Diterima
                            </span>
                        @elseif ($pendaftaran->status === 'ditolak')
                            <span class="inline-flex items-center rounded-full bg-rose-50 px-6 py-2 text-xs font-bold text-rose-700 border border-rose-200/60 shadow-2xs uppercase tracking-wider">
                                Ditolak
                            </span>
                        @elseif ($pendaftaran->status === 'dibatalkan')
                            <span class="inline-flex items-center rounded-full bg-gray-50 px-6 py-2 text-xs font-bold text-gray-600 border border-gray-200 shadow-2xs uppercase tracking-wider">
                                Batal
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-yellow-50 px-6 py-2 text-xs font-bold text-yellow-700 border border-yellow-200/60 shadow-2xs uppercase tracking-wider">
                                Proses
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Detail Information -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Registration & Student Profile -->
                <div class="bg-white rounded-2xl border border-gray-200/85 p-6 shadow-xs space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <!-- Profile Icon -->
                        <svg class="w-5 h-5 text-[#6366F1]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        Detail Pendaftar & Jadwal
                    </h3>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <!-- Left Details -->
                        <div class="space-y-3">
                            <div>
                                <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide">Nama Lengkap</span>
                                <span class="font-semibold text-gray-800">{{ $pendaftaran->siswa->user->name }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide">NIS / NISN</span>
                                <span class="font-semibold text-gray-800">{{ $pendaftaran->siswa->nis }} / {{ $pendaftaran->siswa->nisn }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide">Kelas & Rombel</span>
                                <span class="font-semibold text-gray-800">{{ $pendaftaran->siswa->kelas }} - {{ $pendaftaran->siswa->rombel }}</span>
                            </div>
                        </div>

                        <!-- Right Details -->
                        <div class="space-y-3">
                            <div>
                                <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide">Jadwal Latihan</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $pendaftaran->ekstrakurikuler->hari_latihan }} ({{ date('H:i', strtotime($pendaftaran->ekstrakurikuler->jam_mulai)) }} - {{ date('H:i', strtotime($pendaftaran->ekstrakurikuler->jam_selesai)) }} WIB)
                                </span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide">Lokasi Latihan</span>
                                <span class="font-semibold text-gray-800">{{ $pendaftaran->ekstrakurikuler->lokasi }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide">Ketua Ekstrakurikuler</span>
                                <span class="font-semibold text-gray-800">{{ $pendaftaran->ekstrakurikuler->ketua->name ?? 'Belum Ditentukan' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catatan & Hasil Keputusan -->
                <div class="bg-white rounded-2xl border border-gray-200/85 p-6 shadow-xs space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <!-- Chat Icon -->
                        <svg class="w-5 h-5 text-[#6366F1]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                        Catatan & Dokumen
                    </h3>

                    <div class="space-y-4 text-sm">
                        <!-- Catatan Pendaftar -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide mb-1">Catatan Pendaftar (Siswa)</span>
                            <p class="text-gray-700 italic">"{{ $pendaftaran->catatan_siswa ?? 'Tidak ada catatan khusus.' }}"</p>
                        </div>

                        <!-- Catatan Keputusan dari Ketua -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <span class="text-xs text-gray-400 font-bold block uppercase tracking-wide mb-1">Catatan Ketua Ekstrakurikuler</span>
                            <p class="text-gray-700 italic">"{{ $pendaftaran->catatan_ketua ?? 'Belum ada catatan/tanggapan.' }}"</p>
                        </div>
                    </div>

                    <!-- Action: Join Group Chat on Approved -->
                    @if ($pendaftaran->status === 'disetujui')
                        <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-100">
                            <div class="text-center sm:text-left">
                                <h4 class="font-bold text-gray-800 text-sm">Selamat, pendaftaran Anda disetujui!</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Silakan masuk ke grup koordinasi WhatsApp untuk info latihan perdana.</p>
                            </div>
                            <!-- WhatsApp Group Button -->
                            <a href="https://chat.whatsapp.com/dummy-group-{{ $pendaftaran->ekstrakurikuler->slug }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-xs transition-colors duration-150 shrink-0">
                                <!-- WhatsApp Icon -->
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.45L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.403.002 9.799-4.389 9.802-9.789.002-2.618-1.01-5.078-2.862-6.93C16.362 2.053 13.9 1.039 11.275 1.04 5.866 1.04 1.472 5.434 1.47 10.843c-.001 1.554.417 3.076 1.21 4.426l-.993 3.626 3.72-.977-.282.164z"/>
                                </svg>
                                Masuk Grup Chat
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
