@extends('layouts.ketua')

@section('title', 'Laporan Absensi - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <div class="w-full max-w-6xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        <!-- Title -->
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-900">Laporan Absensi</h2>
        </div>

        <!-- Semester Info with Dynamic Dropdown Select -->
        <div class="text-center mb-6">
            <form method="GET" action="{{ route('ketua.absensi.report') }}" class="inline-block">
                <label class="text-sm font-semibold text-gray-800 mr-2" for="semester-select">
                    Periode Semester :
                </label>
                <select id="semester-select" name="semester" onchange="this.form.submit()" 
                    class="text-xs border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#6366F1] bg-white font-medium text-gray-700">
                    <option value="all" {{ ($semesterFilter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Pertemuan (Full Tahun Pelajaran)</option>
                    <option value="ganjil" {{ ($semesterFilter ?? '') === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (Juli - Desember)</option>
                    <option value="genap" {{ ($semesterFilter ?? '') === 'genap' ? 'selected' : '' }}>Semester Genap (Januari - Juni)</option>
                </select>
            </form>
            <div class="text-xs text-gray-500 mt-2 font-medium">Menampilkan: {{ $semester }}</div>
            <div class="w-40 h-[2px] bg-gray-400 mx-auto mt-2"></div>
        </div>

        <!-- Meta Info -->
        <div class="bg-white rounded-xl p-5 border border-[#f2eaea] mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-gray-500 w-32">Nama Pembina</span>
                    <span class="text-gray-800">: {{ $ekskul->pembina ?: '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-gray-500 w-32">Nama Ketua</span>
                    <span class="text-gray-800">: {{ $ketua->name ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-gray-500 w-32">Jadwal Latihan</span>
                    <span class="text-gray-800">: {{ $ekskul->jadwal ?: '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-gray-500 w-32">Total Pertemuan</span>
                    <span class="text-gray-800">: {{ $totalPertemuan }} kali</span>
                </div>
            </div>
        </div>

        <!-- Top Controls -->
        <div class="flex justify-end mb-6">
            <div class="flex items-center gap-2">
                <!-- Export PDF Button (with semester filter parameter) -->
                <a href="{{ route('ketua.absensi.export', ['semester' => $semesterFilter ?? 'all']) }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all cursor-pointer border-0 shadow-xs no-underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>

                <!-- Back Button -->
                <a href="{{ route('ketua.absensi.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition-all cursor-pointer border-0 no-underline inline-flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container shadow-sm border border-[#f2eaea]">
            <table class="min-w-full divide-y divide-[#f2eaea]">
                <thead class="bg-[#FCFBFB]">
                    <tr>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">#</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">NIS</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500">Nama Lengkap</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500 text-center">TP</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500 text-center">H</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500 text-center">S</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500 text-center">I</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500 text-center">A</th>
                        <th scope="col" class="table-header-cell text-xs tracking-wider font-semibold text-gray-500 text-center">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2eaea] bg-white">
                    @forelse($rows as $index => $row)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="table-body-cell font-medium">{{ $index + 1 }}</td>
                            <td class="table-body-cell text-gray-700 font-medium">{{ $row['nis'] }}</td>
                            <td class="table-body-cell font-semibold text-gray-900">{{ $row['nama'] }}</td>
                            <td class="table-body-cell text-center text-gray-600">{{ $row['tp'] }}</td>
                            <td class="table-body-cell text-center text-green-600 font-semibold">{{ $row['hadir'] }}</td>
                            <td class="table-body-cell text-center text-yellow-600 font-semibold">{{ $row['sakit'] }}</td>
                            <td class="table-body-cell text-center text-blue-600 font-semibold">{{ $row['izin'] }}</td>
                            <td class="table-body-cell text-center text-red-600 font-semibold">{{ $row['alpha'] }}</td>
                            <td class="table-body-cell text-center">
                                <span class="font-bold {{ $row['percentage'] >= 85 ? 'text-green-600' : ($row['percentage'] >= 75 ? 'text-yellow-600' : ($row['percentage'] >= 60 ? 'text-orange-600' : 'text-red-600')) }}">
                                    {{ rtrim(rtrim(number_format($row['percentage'], 2), '0'), '.') }}%
                                </span>
                                <br>
                                <span class="text-[10px] font-semibold {{ $row['rating'] === 'Sangat Baik' ? 'text-green-500' : ($row['rating'] === 'Baik' ? 'text-green-600' : ($row['rating'] === 'Cukup' ? 'text-yellow-600' : ($row['rating'] === 'Kurang' ? 'text-orange-600' : 'text-red-500'))) }}">
                                    ({{ $row['rating'] }})
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="table-body-cell text-center text-gray-400 py-8 font-medium">
                                Belum ada data absensi yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Legend -->
        <div class="mt-6">
            <div class="bg-white rounded-xl p-4 border border-[#f2eaea] max-w-2xl">
                <h4 class="text-sm font-bold text-gray-700 mb-2">Keterangan</h4>
                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-600">
                    <div><span class="font-semibold">TP</span> : Total Pertemuan</div>
                    <div><span class="font-semibold">H</span> : Hadir</div>
                    <div><span class="font-semibold">S</span> : Sakit</div>
                    <div><span class="font-semibold">I</span> : Izin</div>
                    <div><span class="font-semibold">A</span> : Alfa</div>
                    <div><span class="font-semibold">% Kehadiran</span> : Persentase Kehadiran</div>
                </div>
            </div>
        </div>
    </div>
@endsection
