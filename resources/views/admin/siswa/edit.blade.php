@extends('layouts.admin')

@section('title', 'Edit Siswa - EKSIS SMAN 2 Bangkalan')

@section('content')
    <x-cards.card title="Edit Siswa">
        <form method="POST" action="{{ route('pengguna.siswa.update', $siswa->id) }}" class="max-w-4xl mx-auto space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6 pl-6">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="nama_siswa" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">Nama Siswa</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input name="nama_siswa" placeholder="Masukkan nama Siswa" value="{{ old('nama_siswa', $siswa->user->name) }}" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="nis" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">NIS</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input name="nis" placeholder="Masukkan NIS" value="{{ old('nis', $siswa->nis) }}" required />
                    </div>
                </div>



                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="no_hp" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">No Hp</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input name="no_hp" placeholder="Masukkan Nomor Hp" value="{{ old('no_hp', $siswa->no_telp) }}" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="jenis_kelamin" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">Jenis Kelamin</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8 flex items-center gap-6 py-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-[#6366F1] border-gray-300 focus:ring-[#6366F1]" 
                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'checked' : '' }} required>
                            <span class="text-sm font-semibold text-gray-700">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-[#6366F1] border-gray-300 focus:ring-[#6366F1]" 
                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'checked' : '' }} required>
                            <span class="text-sm font-semibold text-gray-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="kelas" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">Kelas</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.select name="kelas" value="{{ old('kelas', $siswa->kelas) }}" :options="['X' => 'Kelas X', 'XI' => 'Kelas XI', 'XII' => 'Kelas XII']" required />
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="jurusan" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">Jurusan</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input name="jurusan" placeholder="Contoh: MIPA, IPS, Bahasa" value="{{ old('jurusan', $siswa->jurusan) }}" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="tahun_masuk" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">Tahun Masuk</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input name="tahun_masuk" type="number" placeholder="Contoh: 2025" value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}" required />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <x-buttons.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Simpan Perubahan
                </x-buttons.button>
                <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('pengguna.siswa.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">Batal</x-buttons.button>
            </div>
        </form>
    </x-cards.card>
@endsection
