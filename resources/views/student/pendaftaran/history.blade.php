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

        @php
            $registrations = [
                [
                    'id' => 1,
                    'ekskul' => 'Pramuka',
                    'date' => '2026-06-28',
                    'kelas' => 'XI - IPA 2',
                    'phone' => '08123456789',
                    'status' => 'success', // Disetujui
                    'status_label' => 'Disetujui'
                ],
                [
                    'id' => 2,
                    'ekskul' => 'Futsal',
                    'date' => '2026-06-30',
                    'kelas' => 'XI - IPA 2',
                    'phone' => '08123456789',
                    'status' => 'info', // Pending
                    'status_label' => 'Pending'
                ]
            ];
        @endphp

        <div class="max-w-5xl mx-auto">
            <!-- Table Component -->
            <x-ui.table :headers="['No', 'Nama Ekstrakurikuler', 'Tanggal Daftar', 'Kelas', 'No. WhatsApp', 'Status', 'Aksi']">
                @foreach($registrations as $index => $reg)
                    <tr>
                        <td class="table-body-cell font-semibold text-gray-700">
                            {{ $index + 1 }}
                        </td>
                        <td class="table-body-cell font-bold text-[#2A1B60]">
                            {{ $reg['ekskul'] }}
                        </td>
                        <td class="table-body-cell text-gray-500 font-medium">
                            {{ \Carbon\Carbon::parse($reg['date'])->format('d M Y') }}
                        </td>
                        <td class="table-body-cell text-gray-600 font-medium">
                            {{ $reg['kelas'] }}
                        </td>
                        <td class="table-body-cell text-gray-600 font-medium">
                            {{ $reg['phone'] }}
                        </td>
                        <td class="table-body-cell">
                            <x-ui.badge :variant="$reg['status']">
                                {{ $reg['status_label'] }}
                            </x-ui.badge>
                        </td>
                        <td class="table-body-cell">
                            <div class="flex items-center gap-2">
                                @if($reg['status'] == 'info')
                                    <!-- Edit Action -->
                                    <button class="bg-[#FCD34D] hover:bg-[#FACC15] text-[#1F2937] text-xs font-semibold py-1.5 px-3 rounded-lg transition shadow-xs flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                        Ubah
                                    </button>

                                    <!-- Delete Action -->
                                    <button class="bg-[#EF4444] hover:bg-[#DC2626] text-white text-xs font-semibold py-1.5 px-3 rounded-lg transition shadow-xs flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Hapus
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 font-medium italic">Tidak ada aksi</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>
        </div>
    </x-ui.card>
@endsection
