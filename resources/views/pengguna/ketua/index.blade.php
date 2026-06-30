@extends('layouts.app')

@section('title', 'Daftar Ketua Ekstrakurikuler - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-ui.card title="List Ketua">
        
        <!-- Table Controls -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            
            <!-- Left: Pagination Entries Controller -->
            <x-ui.pagination />

            <!-- Right: Tambah Button & Search Input -->
            <div class="flex items-center gap-3 self-end md:self-auto">
                <!-- Tambah Ketua Button (Purple styled button) -->
                <x-ui.button onclick="window.location.href='{{ route('pengguna.ketua.create') }}'" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm">
                    <!-- Plus Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Ketua
                </x-ui.button>

                <!-- Search Input Component (Cari Ekskul placeholder matching screenshot) -->
                <x-ui.search placeholder="Cari Ekskul" />
            </div>

        </div>

        <!-- Table Component -->
        <x-ui.table :headers="['#', 'Ekstrakurikuler', 'Nama Pembina', 'Tanggal Dibuat', 'Action']">
            @php
                // Dummy Data matches the provided list ketua screenshot
                $ketuas = [
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35'],
                    ['id' => 1, 'ekskul' => 'pramuka', 'pembina' => 'Ahmad Jihadudin Salim', 'created_at' => 'January 09, 2025 12.35']
                ];
            @endphp

            @foreach($ketuas as $index => $ketua)
                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                    <td class="table-body-cell font-medium">{{ $index + 1 }}</td>
                    <td class="table-body-cell font-medium text-gray-900">{{ $ketua['ekskul'] }}</td>
                    <td class="table-body-cell text-gray-700">{{ $ketua['pembina'] }}</td>
                    <td class="table-body-cell text-gray-500 font-normal">{{ $ketua['created_at'] }}</td>
                    <td class="table-body-cell text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Ubah Button (Yellow) -->
                            <x-ui.button onclick="window.location.href='{{ route('pengguna.ketua.edit', 1) }}'" variant="edit" class="shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Ubah
                            </x-ui.button>

                            <!-- Hapus Button (Red) -->
                            <x-ui.button variant="delete" class="shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                Hapus
                            </x-ui.button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-ui.table>

        <!-- Load More Button -->
        <div class="flex justify-center mt-6">
            <button class="flex items-center gap-2 border border-gray-300 rounded-lg px-4.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors duration-150 cursor-pointer bg-white shadow-xs">
                <svg class="w-4 h-4 animate-spin text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18" />
                </svg>
                Load more
            </button>
        </div>

    </x-ui.card>
@endsection
