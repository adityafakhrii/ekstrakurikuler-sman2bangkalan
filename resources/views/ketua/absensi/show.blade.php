@extends('layouts.ketua')

@section('title', 'List Absensi - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto" x-data="{ editMode: false }">
        <!-- Title -->
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-900">List Absensi</h2>
        </div>

        <!-- Topik & Tanggal Info -->
        <div class="text-center mb-6">
            <p class="text-sm font-semibold text-gray-800">
                Topik : {{ $topik ?: '-' }} &nbsp;|&nbsp; {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}
            </p>
            <div class="w-40 h-[2px] bg-gray-400 mx-auto mt-2"></div>
        </div>

        <!-- Top Controls: Pagination Info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <x-pagination.pagination :paginator="$absensiList" />
        </div>

        <!-- Form Absensi -->
        <form method="POST" action="{{ route('ketua.absensi.update', ['tanggal' => $tanggal]) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="topik" value="{{ $topik }}">

            <!-- Table with Radio Buttons -->
            <div class="table-container shadow-sm border border-[#f2eaea]">
                <table class="min-w-full divide-y divide-[#f2eaea]">
                    <thead class="bg-[#FCFBFB]">
                        <tr>
                            <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">#</th>
                            <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">NIS</th>
                            <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nama Lengkap</th>
                            <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500" colspan="4">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f2eaea] bg-white">
                        @forelse($anggotaList as $index => $member)
                            @php
                                $currentStatus = $existingAbsensi[$member->siswa->id] ?? 'alpha';
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                <td class="table-body-cell font-medium">{{ $index + 1 }}</td>
                                <td class="table-body-cell text-gray-700 font-medium">{{ $member->siswa->nis ?? '-' }}</td>
                                <td class="table-body-cell font-semibold text-gray-900">{{ $member->siswa->user->name ?? '-' }}</td>
                                <td class="table-body-cell" colspan="4">
                                    <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $member->siswa->id }}">
                                    <div class="flex items-center gap-4 sm:gap-6 flex-wrap">
                                        <!-- Hadir -->
                                        <label class="inline-flex items-center gap-1.5 text-xs text-gray-700" :class="editMode ? 'cursor-pointer' : 'cursor-default opacity-60'">
                                            <input type="radio"
                                                name="absensi[{{ $index }}][status]"
                                                value="hadir"
                                                {{ $currentStatus === 'hadir' ? 'checked' : '' }}
                                                :disabled="!editMode"
                                                class="w-3.5 h-3.5 text-[#6366F1] border-gray-300 focus:ring-[#6366F1]"
                                                :class="editMode ? 'cursor-pointer' : 'cursor-default'">
                                            Hadir
                                        </label>
                                        <!-- Izin -->
                                        <label class="inline-flex items-center gap-1.5 text-xs text-gray-700" :class="editMode ? 'cursor-pointer' : 'cursor-default opacity-60'">
                                            <input type="radio"
                                                name="absensi[{{ $index }}][status]"
                                                value="izin"
                                                {{ $currentStatus === 'izin' ? 'checked' : '' }}
                                                :disabled="!editMode"
                                                class="w-3.5 h-3.5 text-[#6366F1] border-gray-300 focus:ring-[#6366F1]"
                                                :class="editMode ? 'cursor-pointer' : 'cursor-default'">
                                            Izin
                                        </label>
                                        <!-- Sakit -->
                                        <label class="inline-flex items-center gap-1.5 text-xs text-gray-700" :class="editMode ? 'cursor-pointer' : 'cursor-default opacity-60'">
                                            <input type="radio"
                                                name="absensi[{{ $index }}][status]"
                                                value="sakit"
                                                {{ $currentStatus === 'sakit' ? 'checked' : '' }}
                                                :disabled="!editMode"
                                                class="w-3.5 h-3.5 text-[#6366F1] border-gray-300 focus:ring-[#6366F1]"
                                                :class="editMode ? 'cursor-pointer' : 'cursor-default'">
                                            Sakit
                                        </label>
                                        <!-- Alfa -->
                                        <label class="inline-flex items-center gap-1.5 text-xs text-gray-700" :class="editMode ? 'cursor-pointer' : 'cursor-default opacity-60'">
                                            <input type="radio"
                                                name="absensi[{{ $index }}][status]"
                                                value="alpha"
                                                {{ $currentStatus === 'alpha' ? 'checked' : '' }}
                                                :disabled="!editMode"
                                                class="w-3.5 h-3.5 text-[#6366F1] border-gray-300 focus:ring-[#6366F1]"
                                                :class="editMode ? 'cursor-pointer' : 'cursor-default'">
                                            Alfa
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                                    Tidak ada anggota yang terdaftar untuk dicatat absensinya.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bottom Buttons -->
            @if($anggotaList->count() > 0)
                <div class="mt-6 flex gap-3 justify-end">
                    <!-- Lakukan Absensi Button (Yellow) — shown when NOT in edit mode -->
                    <button type="button" x-show="!editMode" @click="editMode = true"
                        class="bg-[#facc15] hover:bg-[#eab308] text-gray-900 text-sm font-semibold px-6 py-2.5 rounded-lg inline-flex items-center gap-2 transition-all cursor-pointer border-0 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Lakukan Absensi
                    </button>

                    <!-- Simpan Button (Blue) — shown when IN edit mode -->
                    <button type="submit" x-show="editMode" x-cloak
                        class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-sm font-semibold px-6 py-2.5 rounded-lg inline-flex items-center gap-2 transition-all cursor-pointer border-0 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan
                    </button>

                    <a href="{{ route('ketua.absensi.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-semibold px-6 py-2.5 rounded-lg transition-all cursor-pointer border-0 no-underline inline-flex items-center">
                        Batal
                    </a>
                </div>
            @endif
        </form>
    </div>
@endsection
