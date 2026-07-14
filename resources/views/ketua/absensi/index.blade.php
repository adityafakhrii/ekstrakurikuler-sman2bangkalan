@extends('layouts.ketua')

@section('title', 'Data Absensi - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto" x-data="{ showTambah: false, showHapus: null, hapusTopik: '' }">
        <!-- Title -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">List Kegiatan</h2>
            <div class="w-40 h-[2px] bg-gray-400 mx-auto mt-2"></div>
        </div>

        <!-- Top Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <x-pagination.pagination :paginator="$kegiatanList" />

            <!-- Buttons + Search -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Tambah Sesi Button -->
                <button @click="showTambah = true"
                    class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all cursor-pointer border-0 shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Tambah Sesi
                </button>

                <!-- Lihat Laporan Absensi Button -->
                <a href="{{ route('ketua.absensi.report') }}" class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all cursor-pointer border-0 shadow-xs no-underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Laporan Absensi
                </a>

                <!-- Search -->
                <form method="GET" action="{{ route('ketua.absensi.index') }}" class="flex flex-wrap items-center gap-2">
                    <!-- Cari Tanggal -->
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <input type="date" name="search_tanggal" value="{{ request('search_tanggal') }}"
                            class="text-xs border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-44">
                    </div>
                    <!-- Cari Topik -->
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search_topik" value="{{ request('search_topik') }}" placeholder="Cari Topik"
                            class="text-xs border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-44">
                    </div>
                    <!-- Clear Button -->
                    @if(request('search_tanggal') || request('search_topik'))
                        <a href="{{ route('ketua.absensi.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-3 py-2 rounded-lg transition-all cursor-pointer border-0">
                            Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container shadow-sm border border-[#f2eaea]">
            <table class="min-w-full divide-y divide-[#f2eaea]">
                <thead class="bg-[#FCFBFB]">
                    <tr>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">#</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Topik Pertemuan</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Tanggal Pertemuan</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2eaea] bg-white">
                    @forelse($kegiatanList as $index => $kegiatan)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="table-body-cell font-medium">{{ ($kegiatanList->currentPage() - 1) * $kegiatanList->perPage() + $index + 1 }}</td>
                            <td class="table-body-cell font-semibold text-gray-900">{{ $kegiatan->topik ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d, F Y') }}</td>
                            <td class="table-body-cell text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Lihat Button -->
                                    <a href="{{ route('ketua.absensi.show', ['tanggal' => $kegiatan->tanggal, 'topik' => $kegiatan->topik]) }}"
                                        class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs no-underline">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat
                                    </a>
                                    <!-- Hapus Button -->
                                    <button @click="showHapus = '{{ $kegiatan->tanggal }}'; hapusTopik = '{{ $kegiatan->topik }}'"
                                        class="bg-red-500 hover:bg-red-600 text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                                @if(request('search_tanggal') || request('search_topik'))
                                    Tidak ditemukan kegiatan dengan kriteria pencarian tersebut.
                                @else
                                    Belum ada sesi kegiatan yang tercatat.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Delete Confirmation Modal -->
        <div x-show="showHapus !== null" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/40 backdrop-blur-xs" @click="showHapus = null"></div>
            <!-- Modal Box -->
            <div class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full max-w-sm z-50 transform transition-all p-6 relative"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="showHapus = null">
                <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                    <h3 class="text-lg font-bold text-red-600">Hapus Kegiatan</h3>
                    <button @click="showHapus = null" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="text-sm text-gray-700 mb-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <p>Apakah Anda yakin ingin menghapus sesi kegiatan ini? Semua data absensi pada sesi ini akan dihapus.</p>
                    </div>
                </div>
                <div class="flex gap-2 justify-end">
                    <button @click="showHapus = null"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0">
                        Batal
                    </button>
                    <form method="POST" :action="'/ketua/absensi/' + showHapus">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="topik" :value="hapusTopik">
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tambah Sesi Modal -->
        <div x-show="showTambah" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/40 backdrop-blur-xs" @click="showTambah = false"></div>
            <!-- Modal Box -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-200 w-full max-w-md z-50 transform transition-all p-6 relative"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="showTambah = false">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Buat Sesi Absensi Baru</h3>
                    <button @click="showTambah = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <form method="POST" action="{{ route('ketua.absensi.store') }}">
                    @csrf

                    <!-- Tanggal Pertemuan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pertemuan :</label>
                        <div class="relative">
                            <input type="date" name="tanggal" required
                                value="{{ now()->format('Y-m-d') }}"
                                class="text-sm border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-full">
                        </div>
                    </div>

                    <!-- Topik Pertemuan -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Topik Pertemuan :</label>
                        <input type="text" name="topik" required placeholder="Contoh : Latihan Passing"
                            class="text-sm border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-full">
                    </div>

                    <!-- Footer -->
                    <div class="flex gap-3 justify-center">
                        <button type="submit"
                            class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-sm font-semibold px-6 py-2.5 rounded-lg inline-flex items-center gap-2 transition-all cursor-pointer border-0 shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Simpan
                        </button>
                        <button type="button" @click="showTambah = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-semibold px-6 py-2.5 rounded-lg transition-all cursor-pointer border-0">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
