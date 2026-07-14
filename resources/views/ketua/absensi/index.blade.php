@extends('layouts.ketua')

@section('title', 'Data Absensi - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Alert Success -->
    @if(session('success'))
        <div class="max-w-5xl mx-auto mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-xs">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="max-w-5xl mx-auto mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-xs">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto" x-data="{ showTambah: false, showHapus: null }">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Data Absensi Ekstrakurikuler</h2>
                <p class="text-xs text-gray-500 font-medium mt-1">Kelola data kehadiran anggota ekskul {{ $ekskul->nama }}</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Filter Tanggal -->
                <form method="GET" action="{{ route('ketua.absensi.index') }}" class="flex items-center gap-2">
                    <select name="tanggal" onchange="this.form.submit()"
                        class="text-xs border border-[#f2eaea] rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white">
                        <option value="">Semua Tanggal</option>
                        @foreach($tanggalOptions as $tgl)
                            <option value="{{ $tgl }}" {{ $tanggalFilter == $tgl ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($tgl)->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <!-- Tambah Absensi Button -->
                @if($anggotaList->count() > 0)
                    <button @click="showTambah = true"
                        class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all cursor-pointer border-0 shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Absensi
                    </button>
                @endif
            </div>
        </div>

        <x-tables.table :headers="['#', 'Nama Siswa', 'NISN', 'Kelas', 'Tanggal', 'Status', 'Keterangan', 'Action']">
            @forelse($absensiList as $index => $absensi)
                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                    <td class="table-body-cell font-medium">{{ ($absensiList->currentPage() - 1) * $absensiList->perPage() + $index + 1 }}</td>
                    <td class="table-body-cell font-semibold text-gray-900">{{ $absensi->siswa->user->name ?? '-' }}</td>
                    <td class="table-body-cell text-gray-700 font-medium">{{ $absensi->siswa->nisn ?? '-' }}</td>
                    <td class="table-body-cell text-gray-600">{{ $absensi->siswa->rombel ?? '-' }}</td>
                    <td class="table-body-cell text-gray-600 text-xs">{{ $absensi->tanggal->format('d M Y') }}</td>
                    <td class="table-body-cell">
                        @switch($absensi->status)
                            @case('hadir')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Hadir</span>
                                @break
                            @case('izin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Izin</span>
                                @break
                            @case('sakit')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Sakit</span>
                                @break
                            @case('alpha')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Alpha</span>
                                @break
                        @endswitch
                    </td>
                    <td class="table-body-cell text-gray-500 font-normal max-w-xs truncate" title="{{ $absensi->keterangan }}">
                        {{ $absensi->keterangan ?? '-' }}
                    </td>
                    <td class="table-body-cell text-center">
                        <button @click="showHapus = {{ $absensi->id }}"
                            class="bg-red-500 hover:bg-red-600 text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all cursor-pointer border-0 shadow-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>

                        <!-- Delete Confirmation Modal -->
                        <div x-show="showHapus === {{ $absensi->id }}" x-cloak
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
                                    <h3 class="text-lg font-bold text-red-600">Hapus Absensi</h3>
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
                                        <p>Hapus data absensi <strong>{{ $absensi->siswa->user->name ?? '-' }}</strong> pada tanggal <strong>{{ $absensi->tanggal->format('d M Y') }}</strong>?</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 justify-end">
                                    <button @click="showHapus = null"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0">
                                        Batal
                                    </button>
                                    <form method="POST" action="{{ route('ketua.absensi.destroy', $absensi->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                            Ya, Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                        @if($tanggalFilter)
                            Tidak ada data absensi pada tanggal {{ \Carbon\Carbon::parse($tanggalFilter)->format('d M Y') }}.
                        @else
                            Belum ada data absensi yang tercatat.
                        @endif
                    </td>
                </tr>
            @endforelse
        </x-tables.table>

        <!-- Pagination Links -->
        <div class="mt-8 flex justify-center">
            {{ $absensiList->links() }}
        </div>

        <!-- Tambah Absensi Modal -->
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
            <div class="bg-[#FCF6F6] rounded-2xl overflow-hidden shadow-2xl border border-[#f2eaea] w-full max-w-2xl z-50 transform transition-all p-6 relative max-h-[90vh] overflow-y-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="showTambah = false">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                    <h3 class="text-lg font-bold text-[#2A1B60]">Tambah / Edit Absensi</h3>
                    <button @click="showTambah = false" class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Body: Absensi Form -->
                <form method="POST" action="{{ route('ketua.absensi.store') }}" x-data="absensiForm()">
                    @csrf

                    <!-- Tanggal -->
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal" required
                            value="{{ now()->format('Y-m-d') }}"
                            class="text-sm border border-[#f2eaea] rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-full">
                    </div>

                    <!-- Set All Status -->
                    <div class="mb-4 flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500">Set semua:</span>
                        <button type="button" @click="setAll('hadir')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer border-0">Hadir</button>
                        <button type="button" @click="setAll('izin')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer border-0">Izin</button>
                        <button type="button" @click="setAll('sakit')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer border-0">Sakit</button>
                        <button type="button" @click="setAll('alpha')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-800 hover:bg-red-200 transition-colors cursor-pointer border-0">Alpha</button>
                    </div>

                    <!-- Daftar Anggota -->
                    <div class="space-y-3 max-h-[45vh] overflow-y-auto pr-1">
                        @foreach($anggotaList as $i => $member)
                            <div class="bg-white rounded-xl p-4 border border-[#f2eaea] flex flex-col sm:flex-row sm:items-center gap-3">
                                <input type="hidden" name="absensi[{{ $i }}][siswa_id]" value="{{ $member->siswa->id }}">

                                <!-- Info Siswa -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $member->siswa->user->name ?? '-' }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $member->siswa->nisn ?? '-' }} &middot; {{ $member->siswa->rombel ?? '-' }}</p>
                                </div>

                                <!-- Status Select -->
                                <div class="flex items-center gap-2">
                                    <select name="absensi[{{ $i }}][status]" x-model="statuses[{{ $i }}]"
                                        class="text-xs border border-[#f2eaea] rounded-lg px-2.5 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white min-w-[90px]">
                                        <option value="hadir">Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="alpha">Alpha</option>
                                    </select>
                                    <input type="text" name="absensi[{{ $i }}][keterangan]" placeholder="Keterangan..."
                                        class="text-xs border border-[#f2eaea] rounded-lg px-2.5 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white w-32 sm:w-40">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($anggotaList->count() === 0)
                        <div class="text-center text-gray-400 py-6 text-sm">
                            Tidak ada anggota yang terdaftar untuk dicatat absensinya.
                        </div>
                    @endif

                    <!-- Footer -->
                    <div class="mt-5 flex gap-2 justify-end border-t border-[#f2eaea] pt-4">
                        <button type="button" @click="showTambah = false"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-5 py-2 rounded-lg transition-all cursor-pointer border-0">
                            Batal
                        </button>
                        @if($anggotaList->count() > 0)
                            <button type="submit"
                                class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-5 py-2 rounded-lg transition-all cursor-pointer border-0 shadow-xs">
                                Simpan Absensi
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function absensiForm() {
            return {
                statuses: {!! json_encode(array_fill(0, $anggotaList->count(), 'hadir')) !!},
                setAll(status) {
                    this.statuses = this.statuses.map(() => status);
                    // Also update all select elements
                    document.querySelectorAll('select[name^="absensi"][name$="[status]"]').forEach(el => {
                        el.value = status;
                    });
                }
            }
        }
    </script>
@endsection
