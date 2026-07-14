@extends('layouts.ketua')

@section('title', 'Pendaftaran - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        <!-- Title -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">List Pendaftaran</h2>
            <div class="w-40 h-[2px] bg-gray-400 mx-auto mt-2"></div>
        </div>

        <!-- Top Controls: Pagination Info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <x-pagination.pagination :paginator="$pendaftarans" />
        </div>

        <!-- Table -->
        <div class="table-container shadow-sm border border-[#f2eaea]">
            <table class="min-w-full divide-y divide-[#f2eaea]">
                <thead class="bg-[#FCFBFB]">
                    <tr>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">#</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nama Lengkap</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">NISN</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Kelas-Jurusan</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Status</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2eaea] bg-white">
                    @forelse($pendaftarans as $index => $pendaftaran)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150" x-data="{ showDetail: false, showProses: false }">
                            <td class="table-body-cell font-medium">{{ ($pendaftarans->currentPage() - 1) * $pendaftarans->perPage() + $index + 1 }}</td>
                            <td class="table-body-cell font-semibold text-gray-900">{{ $pendaftaran->siswa->user->name ?? '-' }}</td>
                            <td class="table-body-cell text-gray-700 font-medium">{{ $pendaftaran->siswa->nisn ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600">{{ ($pendaftaran->siswa->rombel ?? '-') }} - {{ ($pendaftaran->siswa->jurusan ?? '-') }}</td>
                            <td class="table-body-cell">
                                @if($pendaftaran->status === 'menunggu')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Menunggu</span>
                                @elseif($pendaftaran->status === 'disetujui')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Disetujui</span>
                                @elseif($pendaftaran->status === 'ditolak')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">{{ ucfirst($pendaftaran->status) }}</span>
                                @endif
                            </td>
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
                                    @if($pendaftaran->status === 'menunggu')
                                    <!-- Proses Button -->
                                    <button @click="showProses = true"
                                        class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Proses
                                    </button>
                                    @endif
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
                                    <div class="fixed inset-0 bg-black/40 backdrop-blur-xs" @click="showDetail = false"></div>
                                    <div class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full max-w-md z-50 transform transition-all p-6 relative"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showDetail = false">
                                        <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                                            <h3 class="text-lg font-bold text-[#2A1B60]">Detail Pendaftaran</h3>
                                            <button @click="showDetail = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="space-y-3 text-sm">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-14 h-14 rounded-full bg-[#E5E3F6] flex items-center justify-center text-[#2A1B60]">
                                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-base font-bold text-gray-900">{{ $pendaftaran->siswa->user->name ?? '-' }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $pendaftaran->siswa->user->email ?? '-' }}</p>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">NISN</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pendaftaran->siswa->nisn ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Kelas</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pendaftaran->siswa->rombel ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Jurusan</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pendaftaran->siswa->jurusan ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">No. Telp</span>
                                                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pendaftaran->siswa->no_telp ?? '-' }}</p>
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Tanggal Daftar</span>
                                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d F Y') : '-' }}</p>
                                            </div>
                                            @if($pendaftaran->catatan_siswa)
                                            <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Catatan Siswa</span>
                                                <p class="text-sm text-gray-700 mt-0.5">{{ $pendaftaran->catatan_siswa }}</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="mt-5 flex justify-end">
                                            <button @click="showDetail = false"
                                                class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-5 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proses Modal -->
                                @if($pendaftaran->status === 'menunggu')
                                <div x-show="showProses" x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    <div class="fixed inset-0 bg-black/40 backdrop-blur-xs" @click="showProses = false"></div>
                                    <div class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full max-w-sm z-50 transform transition-all p-6 relative"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         @click.away="showProses = false">
                                        <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                                            <h3 class="text-lg font-bold text-[#2A1B60]">Proses Pendaftaran</h3>
                                            <button @click="showProses = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <form method="POST" action="" x-data="{ actionUrl: '' }" :action="actionUrl" class="space-y-4">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Catatan Ketua (Opsional)</label>
                                                <textarea name="catatan_ketua" rows="3" 
                                                    class="text-sm border border-[#f2eaea] rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-full"
                                                    placeholder="Tambahkan alasan/keterangan..."></textarea>
                                            </div>
                                            <div class="flex gap-2 justify-end">
                                                <button type="button" @click="showProses = false"
                                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0">
                                                    Batal
                                                </button>
                                                <button type="submit" @click="actionUrl = '{{ route('ketua.pendaftaran.reject', $pendaftaran->id) }}'"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                                    Tolak
                                                </button>
                                                <button type="submit" @click="actionUrl = '{{ route('ketua.pendaftaran.approve', $pendaftaran->id) }}'"
                                                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                                    Setujui
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                                Belum ada siswa yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
@endsection
