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
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
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
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">NIS</th>
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
                            data-nis="{{ $pendaftaran->siswa->nis ?? '-' }}"
                            data-kelamin="{{ ($pendaftaran->siswa->jenis_kelamin ?? 'L') === 'L' ? 'Laki-laki' : 'Perempuan' }}"
                            data-kelas="{{ $pendaftaran->siswa->kelas ?? '-' }}"
                            data-jurusan="{{ $pendaftaran->siswa->jurusan ?? '-' }}"
                            data-kelas-jurusan="{{ ($pendaftaran->siswa->kelas ?? '-') . ' ' . ($pendaftaran->siswa->jurusan ?? '-') }}"
                            data-telp="{{ $pendaftaran->siswa->no_telp ?? '-' }}"
                            data-email="{{ $pendaftaran->siswa->user->email ?? '-' }}"
                            data-alamat="{{ $pendaftaran->alamat ?: ($pendaftaran->siswa->alamat ?? '-') }}"
                            data-status="{{ $pendaftaran->status }}"
                            data-status-label="@if($pendaftaran->status === 'menunggu')Tertunda @elseif($pendaftaran->status === 'disetujui')Disetujui @elseif($pendaftaran->status === 'ditolak')Ditolak @elseif($pendaftaran->status === 'dibatalkan')Dibatalkan @else{{ ucfirst($pendaftaran->status) }}@endif"
                            data-catatan-siswa="{{ $pendaftaran->catatan_siswa ?? '' }}"
                            data-catatan-ketua="{{ $pendaftaran->catatan_ketua ?? '' }}"
                            data-tgl="{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d F Y') : '-' }}">
                            <td class="table-body-cell font-medium text-xs">{{ ($pendaftarans->currentPage() - 1) * $pendaftarans->perPage() + $index + 1 }}</td>
                            <td class="table-body-cell font-medium text-gray-800 text-xs">{{ $pendaftaran->siswa->user->name ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600 text-xs">{{ $pendaftaran->siswa->nis ?? '-' }}</td>
                            <td class="table-body-cell text-gray-600 text-xs">{{ $pendaftaran->siswa->kelas ?? '-' }} {{ $pendaftaran->siswa->jurusan ?? '-' }}</td>
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

    <!-- Modal: Perbarui Status Pendaftar -->
    <div id="status-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="status-modal-backdrop" class="fixed inset-0 bg-black/30 backdrop-blur-[1px]"></div>
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md z-50 relative overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Perbarui Status Pendaftar</h3>
                <button type="button" id="status-modal-close" class="w-5 h-5 flex items-center justify-center rounded bg-gray-200 hover:bg-gray-300 text-gray-600 text-xs font-bold transition-colors">X</button>
            </div>
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

    <!-- Modal: Detail Pendaftar - persis seperti screenshot referensi -->
    <div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="detail-modal-backdrop" class="fixed inset-0 bg-black/30 backdrop-blur-[1px]"></div>
        <div class="bg-[#F2F2FF] rounded-2xl shadow-2xl w-full max-w-xl z-50 relative overflow-hidden p-6 sm:p-8">
            <!-- inner content sesuai screenshot: list label : value -->
            <div id="detail-content" class="space-y-3 text-[11px] sm:text-xs text-gray-800">
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">NIS</span><span>:</span><span id="d-nis" class="font-semibold">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">Nama Lengkap</span><span>:</span><span id="d-nama" class="font-semibold">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">Jenis Kelamin</span><span>:</span><span id="d-kelamin">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">Kelas-Jurusan</span><span>:</span><span id="d-kelas-jurusan" class="font-semibold">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">No.Whatsapp</span><span>:</span><span id="d-telp" class="font-semibold">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">Email</span><span>:</span><span id="d-email" class="font-semibold break-all">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">Alamat</span><span>:</span><span id="d-alamat" class="font-semibold">-</span>
                </div>
                <div class="grid grid-cols-[100px_12px_1fr] gap-1 items-start">
                    <span class="font-medium">Status</span><span>:</span><span id="d-status" class="font-bold">Tertunda</span>
                </div>
                <div class="pt-1 space-y-1.5">
                    <div class="grid grid-cols-[100px_12px_1fr] gap-1">
                        <span class="font-medium">Alasan Mengikuti</span><span>:</span><span></span>
                    </div>
                    <div id="d-alasan-box" class="ml-0 sm:ml-[112px] max-w-[360px] bg-white border border-gray-200 rounded-md px-3 py-2.5 text-[11px] leading-relaxed text-gray-700 min-h-[50px]">
                        -
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="mt-6 flex justify-end">
                <button type="button" id="detail-modal-close"
                    class="inline-flex items-center gap-1 bg-[#D8D0D0] hover:bg-[#C8BEBE] text-gray-700 text-[11px] font-medium px-4 py-1.5 rounded-md transition-colors cursor-pointer border border-[#C2B8B8]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali Ke List
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
            document.getElementById('d-nis').textContent = row.dataset.nis || '-';
            document.getElementById('d-nama').textContent = row.dataset.nama || '-';
            document.getElementById('d-kelamin').textContent = row.dataset.kelamin || '-';
            document.getElementById('d-kelas-jurusan').textContent = row.dataset.kelasJurusan || '-';
            document.getElementById('d-telp').textContent = row.dataset.telp || '-';
            document.getElementById('d-email').textContent = row.dataset.email || '-';
            document.getElementById('d-alamat').textContent = row.dataset.alamat && row.dataset.alamat.trim() !== '' && row.dataset.alamat !== '-' ? row.dataset.alamat : '-';
            document.getElementById('d-status').textContent = row.dataset.statusLabel || 'Tertunda';
            const alasan = (row.dataset.catatanSiswa && row.dataset.catatanSiswa.trim() !== '') ? row.dataset.catatanSiswa : '';
            document.getElementById('d-alasan-box').textContent = alasan || 'Tidak ada alasan.';

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
