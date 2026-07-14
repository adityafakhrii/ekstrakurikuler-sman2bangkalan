@extends('layouts.ketua')

@section('title', 'Pendaftaran - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        <!-- Title -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">List Pendaftar</h2>
            <div class="w-40 h-[2px] bg-gray-400 mx-auto mt-2"></div>
        </div>

        <!-- Top Controls: Pagination + Search -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6" x-data>
            <x-pagination.pagination :paginator="$pendaftarans" />
            <form method="GET" action="{{ route('ketua.pendaftaran.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                @if(request('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif
                <div class="relative flex-1 sm:flex-none">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pendaftar"
                        class="w-full sm:w-52 pl-9 pr-3 py-2 text-xs font-medium bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#6366F1] focus:border-[#6366F1] placeholder:text-gray-400">
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container shadow-sm border border-[#f2eaea] overflow-x-auto rounded-xl">
            <table class="min-w-full divide-y divide-[#f2eaea]">
                <thead class="bg-[#FCFBFB]">
                    <tr>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">#</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nama Lengkap</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nisn</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Kelas-Jurusan</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Status</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2eaea] bg-white" id="pendaftaran-tbody">
                    @forelse($pendaftarans as $index => $pendaftaran)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150"
                            data-id="{{ $pendaftaran->id }}"
                            data-nama="{{ $pendaftaran->siswa->user->name ?? '-' }}"
                            data-nisn="{{ $pendaftaran->siswa->nisn ?? '-' }}"
                            data-kelas="{{ trim(($pendaftaran->siswa->kelas ?? '').' '.($pendaftaran->siswa->rombel ?? '').' - '.($pendaftaran->siswa->jurusan ?? ''), ' -') }}"
                            data-status="{{ $pendaftaran->status }}"
                            data-catatan-ketua="{{ $pendaftaran->catatan_ketua ?? '' }}"
                            data-catatan-siswa="{{ $pendaftaran->catatan_siswa ?? '' }}"
                            data-email="{{ $pendaftaran->siswa->user->email ?? '-' }}"
                            data-telp="{{ $pendaftaran->siswa->no_telp ?? '-' }}"
                            data-tgl="{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d F Y') : '-' }}">
                            <td class="table-body-cell font-medium text-xs">{{ ($pendaftarans->currentPage() - 1) * $pendaftarans->perPage() + $index + 1 }}</td>
                            <td class="table-body-cell font-medium text-gray-800 text-xs">{{ $pendaftaran->siswa->user->name ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600 text-xs">{{ $pendaftaran->siswa->nisn ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600 text-xs">{{ ($pendaftaran->siswa->rombel ?? '-') }} - {{ ($pendaftaran->siswa->jurusan ?? '-') }}</td>
                            <td class="table-body-cell">
                                <button type="button"
                                    class="status-trigger inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-medium border bg-white border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer"
                                    data-id="{{ $pendaftaran->id }}">
                                    <span class="status-label">
                                        @if($pendaftaran->status === 'menunggu') Tertunda
                                        @elseif($pendaftaran->status === 'disetujui') Disetujui
                                        @elseif($pendaftaran->status === 'ditolak') Ditolak
                                        @elseif($pendaftaran->status === 'dibatalkan') Dibatalkan
                                        @else {{ ucfirst($pendaftaran->status) }}
                                        @endif
                                    </span>
                                    <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5.5 7l4.5 5 4.5-5z"/>
                                    </svg>
                                </button>
                            </td>
                            <td class="table-body-cell text-center">
                                <button type="button"
                                    class="detail-trigger inline-flex items-center gap-1 bg-[#E8E0E0] hover:bg-[#DCD2D2] text-gray-700 text-[10px] font-medium px-3 py-1.5 rounded-md transition-colors cursor-pointer border border-[#D5CACA]"
                                    data-id="{{ $pendaftaran->id }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-body-cell text-center text-gray-400 py-8 font-medium text-xs">
                                Belum ada siswa yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Perbarui Status Pendaftar (sesuai referensi screenshot 3) -->
    <div id="status-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="status-modal-backdrop" class="fixed inset-0 bg-black/30 backdrop-blur-[1px]"></div>
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md z-50 relative overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Perbarui Status Pendaftar</h3>
                <button type="button" id="status-modal-close" class="w-5 h-5 flex items-center justify-center rounded bg-gray-200 hover:bg-gray-300 text-gray-600 text-xs font-bold transition-colors">X</button>
            </div>
            <!-- Body -->
            <form id="status-form" method="POST" class="px-5 py-5 space-y-4">
                @csrf
                @method('PATCH')
                <div class="flex items-start gap-3">
                    <label class="text-[11px] font-medium text-gray-700 pt-2 whitespace-nowrap">Status &nbsp; :</label>
                    <div class="flex-1 relative">
                        <select name="status" id="status-select"
                            class="w-full text-[11px] border border-gray-200 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-1 focus:ring-[#6C63FF] focus:border-[#6C63FF] appearance-none pr-8 cursor-pointer">
                            <option value="menunggu">Tertunda</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-[10px]">▼</span>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-gray-600 mb-1.5">Catatan Ketua (Opsional)</label>
                    <textarea name="catatan_ketua" id="status-catatan" rows="2"
                        class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#6C63FF] bg-white resize-y"
                        placeholder="Alasan / keterangan..."></textarea>
                </div>
                <!-- Footer buttons -->
                <div class="flex items-center gap-2 justify-end pt-1">
                    <button type="submit"
                        class="inline-flex items-center gap-1 bg-[#6C63FF] hover:bg-[#5B52E8] text-white text-xs font-medium px-4 py-2 rounded-lg transition-colors cursor-pointer border-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan
                    </button>
                    <button type="button" id="status-modal-cancel"
                        class="bg-[#E8E0E0] hover:bg-[#DCD2D2] text-gray-700 text-xs font-medium px-4 py-2 rounded-lg transition-colors cursor-pointer border border-[#D5CACA]">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Detail Pendaftar -->
    <div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="detail-modal-backdrop" class="fixed inset-0 bg-black/40 backdrop-blur-[1px]"></div>
        <div class="bg-[#FCF6F6] rounded-2xl shadow-2xl border border-[#f2eaea] w-full max-w-md z-50 relative overflow-hidden p-6">
            <div class="flex items-center justify-between border-b border-[#f2eaea] pb-4 mb-4">
                <h3 class="text-base font-bold text-[#2A1B60]">Detail Pendaftaran</h3>
                <button type="button" id="detail-modal-close" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 rounded-full bg-[#E5E3F6] flex items-center justify-center text-[#2A1B60] shrink-0">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 id="detail-nama" class="text-sm font-bold text-gray-900">-</h4>
                        <p id="detail-email" class="text-[11px] text-gray-500">-</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                        <span class="text-[9px] font-semibold text-gray-400 uppercase">NISN</span>
                        <p id="detail-nisn" class="text-xs font-semibold text-gray-800 mt-0.5">-</p>
                    </div>
                    <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                        <span class="text-[9px] font-semibold text-gray-400 uppercase">Kelas-Jurusan</span>
                        <p id="detail-kelas" class="text-xs font-semibold text-gray-800 mt-0.5">-</p>
                    </div>
                    <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                        <span class="text-[9px] font-semibold text-gray-400 uppercase">No. Telp</span>
                        <p id="detail-telp" class="text-xs font-semibold text-gray-800 mt-0.5">-</p>
                    </div>
                    <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                        <span class="text-[9px] font-semibold text-gray-400 uppercase">Status</span>
                        <p id="detail-status" class="text-xs font-semibold text-gray-800 mt-0.5">-</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-3 border border-[#f2eaea]">
                    <span class="text-[9px] font-semibold text-gray-400 uppercase">Tanggal Daftar</span>
                    <p id="detail-tgl" class="text-xs font-semibold text-gray-800 mt-0.5">-</p>
                </div>
                <div id="detail-catatan-siswa-wrap" class="bg-white rounded-xl p-3 border border-[#f2eaea] hidden">
                    <span class="text-[9px] font-semibold text-gray-400 uppercase">Catatan Siswa</span>
                    <p id="detail-catatan-siswa" class="text-xs text-gray-700 mt-0.5"></p>
                </div>
                <div id="detail-catatan-ketua-wrap" class="bg-white rounded-xl p-3 border border-[#f2eaea] hidden">
                    <span class="text-[9px] font-semibold text-gray-400 uppercase">Catatan Ketua</span>
                    <p id="detail-catatan-ketua" class="text-xs text-gray-700 mt-0.5"></p>
                </div>
            </div>
            <div class="mt-5 flex justify-end">
                <button type="button" id="detail-modal-close-2"
                    class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-5 py-2 rounded-lg transition-all cursor-pointer border-0">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function() {
        const statusModal = document.getElementById('status-modal');
        const statusForm = document.getElementById('status-form');
        const statusSelect = document.getElementById('status-select');
        const statusCatatan = document.getElementById('status-catatan');

        const detailModal = document.getElementById('detail-modal');

        function openStatusModal(pendaftaranId, currentStatus, catatanKetua) {
            statusForm.action = `{{ url('ketua/pendaftaran') }}/${pendaftaranId}/status`;
            statusSelect.value = currentStatus;
            statusCatatan.value = catatanKetua || '';
            statusModal.classList.remove('hidden');
            statusModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeStatusModal() {
            statusModal.classList.add('hidden');
            statusModal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openDetailModal(row) {
            document.getElementById('detail-nama').textContent = row.dataset.nama || '-';
            document.getElementById('detail-email').textContent = row.dataset.email || '-';
            document.getElementById('detail-nisn').textContent = row.dataset.nisn || '-';
            document.getElementById('detail-kelas').textContent = row.dataset.kelas || '-';
            document.getElementById('detail-telp').textContent = row.dataset.telp || '-';
            document.getElementById('detail-tgl').textContent = row.dataset.tgl || '-';
            const labels = { menunggu: 'Tertunda', disetujui: 'Disetujui', ditolak: 'Ditolak', dibatalkan: 'Dibatalkan' };
            document.getElementById('detail-status').textContent = labels[row.dataset.status] || row.dataset.status;

            const siswaWrap = document.getElementById('detail-catatan-siswa-wrap');
            if (row.dataset.catatanSiswa) {
                document.getElementById('detail-catatan-siswa').textContent = row.dataset.catatanSiswa;
                siswaWrap.classList.remove('hidden');
            } else {
                siswaWrap.classList.add('hidden');
            }
            const ketuaWrap = document.getElementById('detail-catatan-ketua-wrap');
            if (row.dataset.catatanKetua) {
                document.getElementById('detail-catatan-ketua').textContent = row.dataset.catatanKetua;
                ketuaWrap.classList.remove('hidden');
            } else {
                ketuaWrap.classList.add('hidden');
            }

            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            detailModal.classList.add('hidden');
            detailModal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.status-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = document.querySelector(`tr[data-id="${this.dataset.id}"]`);
                if (row) openStatusModal(row.dataset.id, row.dataset.status, row.dataset.catatanKetua);
            });
        });

        document.querySelectorAll('.detail-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = document.querySelector(`tr[data-id="${this.dataset.id}"]`);
                if (row) openDetailModal(row);
            });
        });

        document.getElementById('status-modal-close')?.addEventListener('click', closeStatusModal);
        document.getElementById('status-modal-cancel')?.addEventListener('click', closeStatusModal);
        document.getElementById('status-modal-backdrop')?.addEventListener('click', closeStatusModal);

        document.getElementById('detail-modal-close')?.addEventListener('click', closeDetailModal);
        document.getElementById('detail-modal-close-2')?.addEventListener('click', closeDetailModal);
        document.getElementById('detail-modal-backdrop')?.addEventListener('click', closeDetailModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStatusModal();
                closeDetailModal();
            }
        });
    })();
    </script>
    @endpush
@endsection
