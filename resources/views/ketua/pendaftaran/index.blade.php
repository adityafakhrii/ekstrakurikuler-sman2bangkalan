@extends('layouts.ketua')

@section('title', 'Pendaftaran Siswa - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Alert Success -->
    @if(session('success'))
        <div class="max-w-5xl mx-auto mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-xs">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 h-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Pendaftar Ekstrakurikuler</h2>
                <p class="text-xs text-gray-500 font-medium mt-1">Kelola permohonan bergabung siswa untuk ekskul {{ $ekskul->nama }}</p>
            </div>
        </div>

        <x-tables.table :headers="['#', 'NISN', 'Nama Siswa', 'Catatan Siswa', 'Status', 'Catatan Ketua', 'Action']">
            @forelse($pendaftarans as $index => $pendaftaran)
                <tr class="hover:bg-gray-50/50 transition-colors duration-150" x-data="{ openAction: false }">
                    <td class="table-body-cell font-medium">{{ $index + 1 }}</td>
                    <td class="table-body-cell text-gray-700 font-medium">{{ $pendaftaran->siswa->nisn }}</td>
                    <td class="table-body-cell font-semibold text-gray-900">{{ $pendaftaran->siswa->user->name }}</td>
                    <td class="table-body-cell text-gray-500 font-normal max-w-xs truncate" title="{{ $pendaftaran->catatan_siswa }}">
                        {{ $pendaftaran->catatan_siswa ?? '-' }}
                    </td>
                    <td class="table-body-cell">
                        @if($pendaftaran->status === 'menunggu')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Menunggu
                            </span>
                        @elseif($pendaftaran->status === 'disetujui')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Disetujui
                            </span>
                        @elseif($pendaftaran->status === 'ditolak')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                {{ ucfirst($pendaftaran->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="table-body-cell text-gray-500 font-normal max-w-xs truncate" title="{{ $pendaftaran->catatan_ketua }}">
                        {{ $pendaftaran->catatan_ketua ?? '-' }}
                    </td>
                    <td class="table-body-cell text-center">
                        @if($pendaftaran->status === 'menunggu')
                            <div class="flex items-center justify-center gap-2">
                                <!-- Trigger Action Panel/Popover/Modal via AlpineJS -->
                                <button @click="openAction = !openAction" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs">
                                    Proses
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openAction ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Popover Menu Panel (Absolute or overlay layout) -->
                            <div x-show="openAction" @click.away="openAction = false" class="absolute mt-2 right-4 bg-white border border-[#f2eaea] rounded-2xl p-4 shadow-xl z-50 text-left max-w-sm" style="display: none;">
                                <h4 class="text-xs font-bold text-gray-800 mb-2">Tanggapan Pendaftaran</h4>
                                
                                <form method="POST" action="" x-data="{ actionUrl: '' }" :action="actionUrl" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-500 mb-1">Catatan Ketua (Opsional)</label>
                                        <textarea name="catatan_ketua" rows="2" class="w-full text-xs border border-[#f2eaea] rounded-lg px-2.5 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#6366F1]" placeholder="Tambahkan alasan/keterangan..."></textarea>
                                    </div>
                                    <div class="flex gap-2 justify-end">
                                        <!-- Reject Button (Red) -->
                                        <button type="submit" @click="actionUrl = '{{ route('ketua.pendaftaran.reject', $pendaftaran->id) }}'" class="bg-red-500 hover:bg-red-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg border-0 cursor-pointer shadow-3xs">
                                            Tolak
                                        </button>
                                        <!-- Approve Button (Green) -->
                                        <button type="submit" @click="actionUrl = '{{ route('ketua.pendaftaran.approve', $pendaftaran->id) }}'" class="bg-green-500 hover:bg-green-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg border-0 cursor-pointer shadow-3xs">
                                            Setujui
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <span class="text-[10px] text-gray-400 font-semibold">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                        Belum ada siswa yang mendaftar.
                    </td>
                </tr>
            @endforelse
        </x-tables.table>
    </div>
@endsection
