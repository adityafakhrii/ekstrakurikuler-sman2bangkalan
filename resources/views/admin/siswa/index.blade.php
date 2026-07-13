@extends('layouts.admin')

@section('title', 'Daftar Siswa - EKSIS SMAN 2 Bangkalan')

@section('content')
    <x-cards.card title="List Siswa">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
            <x-pagination.pagination />
            <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                <x-buttons.button onclick="window.location.href='{{ route('pengguna.siswa.create') }}'" class="h-[38px] bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-6 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm cursor-pointer border-0 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah Siswa
                </x-buttons.button>
                <x-forms.search placeholder="Cari Siswa" class="h-[38px]" />
            </div>
        </div>

        <x-tables.table :headers="['#', 'NIS', 'NISN', 'Nama Siswa', 'Tanggal Ditambahkan', 'Action']">
            @foreach($siswas as $index => $siswa)
                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                    <td class="table-body-cell font-medium">{{ $index + 1 }}</td>
                    <td class="table-body-cell text-gray-700 font-medium">{{ $siswa->nis }}</td>
                    <td class="table-body-cell text-gray-700 font-medium">{{ $siswa->nisn }}</td>
                    <td class="table-body-cell font-medium text-gray-900">{{ $siswa->user->name }}</td>
                    <td class="table-body-cell text-gray-500 font-normal">{{ $siswa->created_at?->format('F d, Y H.i') }}</td>
                    <td class="table-body-cell text-center">
                        <div class="flex items-center justify-center gap-2">
                            <x-buttons.button onclick="window.location.href='{{ route('pengguna.siswa.edit', $siswa->id) }}'" variant="edit" class="shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                Ubah
                            </x-buttons.button>
                            <form method="POST" action="{{ route('pengguna.siswa.destroy', $siswa->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini? Semua data terkait akan dihapus.')" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-buttons.button type="submit" variant="delete" class="shadow-xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    Hapus
                                </x-buttons.button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-tables.table>

        <div class="flex justify-center mt-6">
            <button class="group relative flex items-center gap-3 bg-white border border-gray-200 hover:border-[#6366F1]/40 hover:bg-[#6366F1]/5 rounded-xl px-6 py-2.5 text-xs font-semibold text-gray-600 hover:text-[#6366F1] focus:outline-none transition-all duration-200 cursor-pointer shadow-sm hover:shadow-md">
                <span class="flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 group-hover:bg-[#6366F1] animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 group-hover:bg-[#6366F1] animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 group-hover:bg-[#6366F1] animate-bounce" style="animation-delay: 300ms"></span>
                </span>
                Load more
            </button>
        </div>
    </x-cards.card>
@endsection
