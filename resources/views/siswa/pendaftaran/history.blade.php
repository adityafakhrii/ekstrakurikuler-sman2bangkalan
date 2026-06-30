@extends('layouts.student')

@section('title', 'Riwayat Pendaftaran - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-ui.card title="Riwayat Pendaftaran Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-8 leading-relaxed">
            Pantau status pendaftaran ekstrakurikuler yang telah Anda ajukan di bawah ini. Status akan diperbarui oleh Admin setelah melalui proses verifikasi.
        </p>

        <!-- AlpineJS Container for Interactive Search, Filter, Pagination, and Detail Modal -->
        <div class="max-w-5xl mx-auto space-y-6"
             x-data="{
                search: '',
                statusFilter: 'all',
                currentPage: 1,
                pageSize: 3,
                selectedReg: null,
                showModal: false,
                registrations: [
                    { id: 1, ekskul: 'Pramuka', date: '28 Jun 2026', nisn: '21082', name: 'Ahmad Jihaduddin Salim', class: 'XI - IPA 2', phone: '08123456789', status: 'success', status_label: 'Disetujui', address: 'Jl. Soekarno Hatta No 18, Mlajah, Bangkalan', gender: 'Laki-Laki', email: 'salim@gmail.com', reason: 'Ingin melatih kemandirian, kedisiplinan, tanggung jawab, dan jiwa kepemimpinan siswa melalui aktivitas kepramukaan.' },
                    { id: 2, ekskul: 'Futsal', date: '30 Jun 2026', nisn: '21082', name: 'Ahmad Jihaduddin Salim', class: 'XI - IPA 2', phone: '08123456789', status: 'info', status_label: 'Pending', address: 'Jl. Soekarno Hatta No 18, Mlajah, Bangkalan', gender: 'Laki-Laki', email: 'salim@gmail.com', reason: 'Sangat menyukai olahraga futsal, ingin mengasah fisik, dan berkontribusi meraih piala kejuaraan untuk sekolah.' },
                    { id: 3, ekskul: 'Basket', date: '25 Jun 2026', nisn: '21082', name: 'Ahmad Jihaduddin Salim', class: 'XI - IPA 2', phone: '08123456789', status: 'danger', status_label: 'Ditolak', address: 'Jl. Soekarno Hatta No 18, Mlajah, Bangkalan', gender: 'Laki-Laki', email: 'salim@gmail.com', reason: 'Ingin mengisi waktu luang dengan olahraga basket dan memperbanyak jaringan relasi pertemanan.' },
                    { id: 4, ekskul: 'PMR', date: '20 Jun 2026', nisn: '21082', name: 'Ahmad Jihaduddin Salim', class: 'XI - IPA 1', phone: '08234567890', status: 'success', status_label: 'Disetujui', address: 'Jl. Melati No 12, Bangkalan', gender: 'Laki-Laki', email: 'salim@gmail.com', reason: 'Tertarik mempelajari dasar pertolongan pertama untuk membantu sesama teman yang terluka.' },
                    { id: 5, ekskul: 'Paskibra', date: '18 Jun 2026', nisn: '21082', name: 'Ahmad Jihaduddin Salim', class: 'XI - IPA 2', phone: '08123456789', status: 'info', status_label: 'Pending', address: 'Jl. Soekarno Hatta No 18, Mlajah, Bangkalan', gender: 'Laki-Laki', email: 'salim@gmail.com', reason: 'Ingin melatih baris-berbaris yang presisi dan menjadi bagian dari tim pengibar bendera sekolah.' }
                ],
                get filteredRegistrations() {
                    return this.registrations.filter(r => {
                        const matchesSearch = r.ekskul.toLowerCase().includes(this.search.toLowerCase());
                        const matchesStatus = this.statusFilter === 'all' || r.status === this.statusFilter;
                        return matchesSearch && matchesStatus;
                    });
                },
                get pagedRegistrations() {
                    const start = (this.currentPage - 1) * this.pageSize;
                    return this.filteredRegistrations.slice(start, start + this.pageSize);
                },
                get totalPages() {
                    return Math.ceil(this.filteredRegistrations.length / this.pageSize) || 1;
                },
                openDetail(reg) {
                    this.selectedReg = reg;
                    this.showModal = true;
                }
             }">

            <!-- Search, Filter & Controls Panel -->
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white border border-[#f2eaea] rounded-2xl p-4 shadow-2xs">
                <!-- Search Box -->
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" 
                           x-model="search" 
                           @input="currentPage = 1"
                           placeholder="Cari ekstrakurikuler..." 
                           class="w-full bg-[#FCFBFB] border border-gray-200 rounded-xl py-2 pl-9 pr-4 text-xs font-medium placeholder-gray-400 focus:outline-none focus:border-brand-primary transition">
                </div>

                <!-- Status Filter Dropdown -->
                <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                    <span class="text-xs font-semibold text-gray-500">Status :</span>
                    <select x-model="statusFilter" 
                            @change="currentPage = 1"
                            class="bg-[#FCFBFB] border border-gray-200 rounded-xl py-2 px-4 text-xs font-medium focus:outline-none focus:border-brand-primary transition text-gray-700">
                        <option value="all">Semua Status</option>
                        <option value="success">Disetujui</option>
                        <option value="info">Pending</option>
                        <option value="danger">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- Table Component -->
            <div class="bg-white border border-[#f2eaea] rounded-3xl overflow-hidden shadow-2xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#FCFBFB] border-b border-[#f2eaea]">
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Ekstrakurikuler</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop Paged Data in AlpineJS -->
                            <template x-for="(reg, index) in pagedRegistrations" :key="reg.id">
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition duration-150">
                                    <td class="py-4.5 px-6 text-sm font-semibold text-gray-600" x-text="((currentPage - 1) * pageSize) + index + 1"></td>
                                    <td class="py-4.5 px-6 text-sm font-bold text-[#2A1B60]" x-text="reg.ekskul"></td>
                                    <td class="py-4.5 px-6 text-sm text-gray-500 font-medium" x-text="reg.date"></td>
                                    <td class="py-4.5 px-6 text-sm text-gray-600 font-medium" x-text="reg.class"></td>
                                    <td class="py-4.5 px-6 text-sm">
                                        <!-- Custom Badges based on status -->
                                        <span :class="{
                                            'bg-emerald-50 text-emerald-700 border-emerald-200': reg.status === 'success',
                                            'bg-sky-50 text-sky-700 border-sky-200': reg.status === 'info',
                                            'bg-rose-50 text-rose-700 border-rose-200': reg.status === 'danger'
                                        }" class="px-2.5 py-1 rounded-lg text-xs font-semibold border inline-block" x-text="reg.status_label"></span>
                                    </td>
                                    <td class="py-4.5 px-6 text-sm text-right">
                                        <!-- Detail Button (Standard custom styled, rounded-full) -->
                                        <button @click="openDetail(reg)" 
                                                class="bg-[#FCD34D] hover:bg-[#FACC15] text-[#1F2937] text-xs font-bold py-2 px-4 rounded-full transition shadow-2xs cursor-pointer inline-flex items-center gap-1.5 border-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            
                            <!-- Empty State -->
                            <template x-if="filteredRegistrations.length === 0">
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-sm font-medium text-gray-400 italic">
                                        Tidak ditemukan riwayat pendaftaran yang cocok.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Panel -->
                <div class="bg-[#FCFBFB] border-t border-[#f2eaea] py-4 px-6 flex items-center justify-between gap-4">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Menampilkan ' + pagedRegistrations.length + ' dari ' + filteredRegistrations.length + ' riwayat'"></span>
                    
                    <div class="flex items-center gap-2">
                        <!-- Prev Button -->
                        <button @click="if(currentPage > 1) currentPage--" 
                                :disabled="currentPage === 1" 
                                :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 cursor-pointer'"
                                class="border border-gray-200 bg-white rounded-lg p-1.5 text-gray-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        
                        <!-- Next Button -->
                        <button @click="if(currentPage < totalPages) currentPage++" 
                                :disabled="currentPage === totalPages" 
                                :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 cursor-pointer'"
                                class="border border-gray-200 bg-white rounded-lg p-1.5 text-gray-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Detail Modal Container using AlpineJS (A11y & Premium experience) -->
            <div class="fixed inset-0 z-50 overflow-y-auto" 
                 x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;">
                
                <!-- Black Backdrop Overlay -->
                <div class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="showModal = false"></div>

                <!-- Modal Box Wrapper -->
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div class="relative w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white p-6 md:p-8 text-left shadow-2xl transition-all"
                         x-show="showModal"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 scale-95">
                        
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2A1B60]" x-text="'Detail Pendaftaran - ' + selectedReg?.ekskul"></h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Content Table List -->
                        <div class="py-6 space-y-4 text-sm">
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">NISN</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-medium" x-text="selectedReg?.nisn"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">Nama Lengkap</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-bold" x-text="selectedReg?.name"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">Jenis Kelamin</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-medium" x-text="selectedReg?.gender"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">Kelas-Jurusan</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-medium" x-text="selectedReg?.class"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">Email</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-medium" x-text="selectedReg?.email"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">No. WhatsApp</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-medium" x-text="selectedReg?.phone"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row border-b border-gray-50 pb-2">
                                <span class="w-1/3 font-semibold text-gray-500">Alamat Lengkap</span>
                                <span class="hidden sm:inline w-8 text-center text-gray-400">:</span>
                                <span class="w-full sm:w-2/3 text-gray-800 font-medium" x-text="selectedReg?.address"></span>
                            </div>
                            <div class="flex flex-col pt-2">
                                <span class="font-semibold text-gray-500 pb-1">Alasan Mengikuti :</span>
                                <p class="text-gray-600 bg-gray-50 p-4 rounded-xl leading-relaxed italic" x-text="selectedReg?.reason"></p>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button @click="showModal = false" class="bg-[#2D3748] hover:bg-[#1A202C] text-white px-6 py-2.5 rounded-full text-xs font-bold transition shadow-xs cursor-pointer border-0">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </x-ui.card>
@endsection
