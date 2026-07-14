@extends('layouts.ketua')

@section('title', 'Data Anggota - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        <!-- Title -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">List Anggota</h2>
            <div class="w-40 h-[2px] bg-gray-400 mx-auto mt-2"></div>
        </div>

        <!-- Top Controls: Pagination Info + Search -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <x-pagination.pagination :paginator="$anggota" />

            <!-- Search -->
            <form method="GET" action="{{ route('ketua.anggota.index') }}" class="flex items-center gap-2">
                <div class="relative">
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota"
                        class="text-xs border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-48">
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container shadow-sm border border-[#f2eaea]">
            <table class="min-w-full divide-y divide-[#f2eaea]">
                <thead class="bg-[#FCFBFB]">
                    <tr>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">#</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nama Lengkap</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nisn</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Kelas-Jurusan</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Tanggal bergabung</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2eaea] bg-white">
                    @forelse($anggota as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150"
                            x-data="{ showDetail: false, showKick: false }">
                            <td class="table-body-cell font-medium">{{ ($anggota->currentPage() - 1) * $anggota->perPage() + $index + 1 }}</td>
                            <td class="table-body-cell font-semibold text-gray-900">{{ $item->siswa->user->name ?? '-' }}</td>
                            <td class="table-body-cell text-gray-700 font-medium">{{ $item->siswa->nisn ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600">{{ ($item->siswa->rombel ?? '-') }} - {{ ($item->siswa->jurusan ?? '-') }}</td>
                            <td class="table-body-cell text-gray-500 text-xs">{{ $item->disetujui_at ? $item->disetujui_at->format('F d, Y H:i') : '-' }}</td>
                            <td class="table-body-cell text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Lihat Button -->
                                    <button @click="showDetail = true"
                                        class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat
                                    </button>
                                    <!-- Hapus Button -->
                                    <button @click="showKick = true"
                                        class="bg-red-500 hover:bg-red-600 text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>

                                <!-- Detail Modal -->
                                <div x-show="showDetail" x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    <!-- Backdrop -->
                                    <div class="fixed inset-0 bg-black/40 backdrop-blur-xs" @click="showDetail = false"></div>
                                    <!-- Modal Box -->
                                    <div class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full max-w-md z-50 transform transition-all p-6 relative"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showDetail = false">
                                        <!-- Header -->
                                        <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                                            <h3 class="text-lg font-bold text-[#2A1B60]">Detail Anggota</h3>
                                            <button @click="showDetail = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Body -->
                                        <div class="space-y-3 text-sm">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-14 h-14 rounded-full bg-[#E5E3F6] flex items-center justify-center text-[#2A1B60]">
                                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-base font-bold text-gray-900">{{ $item->siswa->user->name ?? '-' }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $item->siswa->user->email ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">NISN</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->siswa->nisn ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">NIS</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->siswa->nis ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Kelas</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->siswa->rombel ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Jurusan</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->siswa->jurusan ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Jenis Kelamin</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">No. Telp</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->siswa->no_telp ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Tanggal Bergabung</span>
                                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $item->disetujui_at ? $item->disetujui_at->format('d F Y') : '-' }}</p>
                                            </div>

                                            @if($item->catatan_siswa)
                                            <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Catatan Siswa</span>
                                                <p class="text-sm text-gray-700 mt-0.5">{{ $item->catatan_siswa }}</p>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Footer -->
                                        <div class="mt-5 flex justify-end">
                                            <button @click="showDetail = false"
                                                class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-5 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kick Confirmation Modal -->
                                <div x-show="showKick" x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    <!-- Backdrop -->
                                    <div class="fixed inset-0 bg-black/40 backdrop-blur-xs" @click="showKick = false"></div>
                                    <!-- Modal Box -->
                                    <div class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full max-w-sm z-50 transform transition-all p-6 relative"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showKick = false">
                                        <!-- Header -->
                                        <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                                            <h3 class="text-lg font-bold text-red-600">Keluarkan Anggota</h3>
                                            <button @click="showKick = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Body -->
                                        <div class="text-sm text-gray-700 mb-5">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                    </svg>
                                                </div>
                                                <p>Apakah Anda yakin ingin mengeluarkan <strong>{{ $item->siswa->user->name ?? '-' }}</strong> dari ekskul <strong>{{ $ekskul->nama }}</strong>?</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Tindakan ini akan mengubah status pendaftaran siswa menjadi ditolak.</p>
                                        </div>
                                        <!-- Footer -->
                                        <div class="flex gap-2 justify-end">
                                            <button @click="showKick = false"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0">
                                                Batal
                                            </button>
                                            <form method="POST" action="{{ route('ketua.anggota.kick', $item->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                                    Ya, Keluarkan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                                @if(request('search'))
                                    Tidak ditemukan anggota dengan pencarian "{{ request('search') }}".
                                @else
                                    Belum ada anggota yang terdaftar.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
@endsection
