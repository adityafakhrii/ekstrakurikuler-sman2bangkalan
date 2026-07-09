@extends('layouts.student')

@section('title', 'Formulir Daftar Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Formulir Daftar Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Periksa data dirimu dan isi alasan mengikuti ekstrakurikuler sebelum mengirim pendaftaran.
            </p>
        </div>

        <form method="POST" action="{{ route('siswa.register.store', $ekskul->id) }}" class="max-w-5xl mx-auto bg-[#F3F4F6]/50 border border-gray-150/70 rounded-[2.5rem] p-6 sm:p-12 shadow-2xs space-y-8">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl font-medium max-w-3xl mx-auto">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-6 max-w-3xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">NISN</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input name="nisn_display" value="{{ auth()->user()->siswa->nisn }}" readonly />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">Nama Lengkap</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input name="name_display" value="{{ auth()->user()->name }}" readonly />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">Ekstrakurikuler</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input name="ekskul_display" value="{{ $ekskul->nama }}" readonly />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <label for="catatan_siswa" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left pt-2.5">Alasan Mengikuti</label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center pt-2.5">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.textarea name="catatan_siswa" placeholder="Masukkan alasan mengikuti ekskul" value="{{ old('catatan_siswa') }}" rows="5" required />
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800 font-medium">
                    Setiap siswa hanya dapat mendaftar maksimal <strong>2 ekstrakurikuler</strong> aktif.
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 max-w-3xl mx-auto">
                <x-buttons.button type="submit" class="bg-[#FCD34D] hover:bg-[#FACC15] text-[#1F2937] py-3 px-8 rounded-full text-xs font-bold shadow-3xs cursor-pointer border-0">
                    Konfirmasi
                </x-buttons.button>

                <x-buttons.button variant="secondary" type="button" onclick="window.history.back()" class="bg-[#E11D48] hover:bg-[#BE123C] text-white py-3 px-8 rounded-full text-xs font-bold shadow-3xs cursor-pointer border-0">
                    Batal
                </x-buttons.button>
            </div>
        </form>
    </div>
@endsection
