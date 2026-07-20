@extends('layouts.student')

@section('title', 'Formulir Daftar Ekstrakurikuler - EKSIS SMAN 2 Bangkalan')

@section('content')
<div class="py-12 bg-[#F9F9FB] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-[#1E1B4B] tracking-tight">
                Formulir Daftar Ekstrakurikuler
            </h1>
            <p class="mt-3 text-xs text-gray-500 leading-relaxed">
                Isi Formulir pendaftaran ini dengan benar sesuai data pribadi kamu, dan berikan alasan mengikuti Ekstrakurikuler agar membantu dalam proses konfirmasi pendaftaranmu.
            </p>
        </div>

        <div class="bg-white rounded-3xl border border-gray-150 shadow-xs p-8 sm:p-12 max-w-4xl mx-auto">
            
            <form method="POST" action="{{ route('siswa.register.store', $ekskul->id) }}" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs px-4 py-3 rounded-xl font-semibold mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="space-y-5 text-xs font-semibold text-gray-800">
                    
                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">NIS</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.input name="nis" value="{{ auth()->user()->siswa->nis }}" class="bg-gray-50 border-gray-200 text-gray-600 font-semibold" readonly />
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">Nama Lengkap</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.input name="nama" value="{{ auth()->user()->name }}" class="bg-gray-50 border-gray-200 text-gray-600 font-semibold" readonly />
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">Jenis Kelamin</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5 flex items-center gap-6 py-2">
                            <label class="inline-flex items-center gap-2 cursor-not-allowed">
                                <input type="radio" name="jk_dummy" value="L" class="w-4 h-4 text-gray-800 border-gray-300 focus:ring-0 cursor-not-allowed" 
                                    {{ auth()->user()->siswa->jenis_kelamin === 'L' ? 'checked' : '' }} disabled>
                                <span class="text-sm font-semibold text-gray-700">Laki - Laki</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-not-allowed">
                                <input type="radio" name="jk_dummy" value="P" class="w-4 h-4 text-gray-800 border-gray-300 focus:ring-0 cursor-not-allowed" 
                                    {{ auth()->user()->siswa->jenis_kelamin === 'P' ? 'checked' : '' }} disabled>
                                <span class="text-sm font-semibold text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label for="kelas_jurusan" class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">Kelas-Jurusan</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.input name="kelas_jurusan" value="{{ auth()->user()->siswa->kelas . ' ' . auth()->user()->siswa->jurusan }}" class="bg-gray-50 border-gray-200 text-gray-600 font-semibold" readonly />
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label for="email" class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">Email</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Masukkan Email" class="bg-white border-gray-200" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label for="no_whatsapp" class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">No.Whatsapp</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.input name="no_whatsapp" value="{{ auth()->user()->siswa->no_telp }}" class="bg-gray-50 border-gray-200 text-gray-600 font-semibold" readonly />
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-center">
                        <label for="alamat" class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm">Alamat</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.input name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan Alamat" class="bg-white border-gray-200" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-x-2 items-start pt-2">
                        <label for="catatan_siswa" class="col-span-3 sm:col-span-2.5 text-gray-800 font-bold text-sm pt-2">Alasan Mengikuti</label>
                        <span class="col-span-1 text-center text-gray-800 text-sm pt-2">:</span>
                        <div class="col-span-8 sm:col-span-8.5">
                            <x-forms.textarea name="catatan_siswa" placeholder="Masukkan Alasan Mengikuti Ekskul" rows="4" class="bg-white border-gray-200" required>{{ old('catatan_siswa') }}</x-forms.textarea>
                        </div>
                    </div>

                </div>

                <div class="flex justify-end text-[11px] text-gray-400 font-normal mt-6">
                    * Apabila terdapat ketidaksesuaian data diri di atas, silakan hubungi admin sekolah.
                </div>

                <div class="flex justify-end gap-3 pt-3 items-center">
                    <x-buttons.button type="submit" class="bg-[#FCD34D] hover:bg-[#FBBF24] text-gray-900 font-bold text-xs px-8 py-2.5 rounded-xl shadow-xs border-0 cursor-pointer">
                        Konfirmasi
                    </x-buttons.button>

                    <x-buttons.button variant="secondary" type="button" onclick="window.history.back()" class="bg-[#B91C1C] hover:bg-[#991B1B] text-white font-bold text-xs px-8 py-2.5 rounded-xl shadow-xs border-0 cursor-pointer">
                        Batal
                    </x-buttons.button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection
