@extends('layouts.student')

@section('title', 'Formulir Daftar Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Formulir Daftar Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Isi Formulir pendaftaran ini dengan benar sesuai data pribadi kamu, dan berikan alasan mengikuti Ekstrakurikuler agar membantu dalam proses konfirmasi pendaftaranmu.
            </p>
        </div>

        @php
            $id = request()->route('id', 1);
        @endphp

        <!-- Form Container matching screenshot style (Gray background rounded wrapper) -->
        <form method="POST" action="{{ route('siswa.register.store', $id) }}" class="max-w-5xl mx-auto bg-[#F3F4F6]/50 border border-gray-150/70 rounded-[2.5rem] p-6 sm:p-12 shadow-2xs space-y-8">
            @csrf

            <!-- Form Row Grid Fields -->
            <div class="space-y-6 max-w-3xl mx-auto">
                <!-- Nisn -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="nisn" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Nisn
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input 
                            name="nisn" 
                            placeholder="Masukkan Nisn" 
                            value="{{ old('nisn', '21082') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="name" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Nama Lengkap
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input 
                            name="name" 
                            placeholder="Masukkan Nama Lengkap" 
                            value="{{ old('name', 'Ahmad Jihaduddin Salim') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Jenis Kelamin
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8 flex items-center gap-6">
                        <x-forms.radio 
                            label="Laki - Laki" 
                            name="gender" 
                            value="L" 
                            checked="{{ old('gender', 'L') == 'L' }}" 
                        />
                        <x-forms.radio 
                            label="Perempuan" 
                            name="gender" 
                            value="P" 
                            checked="{{ old('gender') == 'P' }}" 
                        />
                    </div>
                </div>

                <!-- Kelas-Jurusan -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="class_major" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Kelas-Jurusan
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input 
                            name="class_major" 
                            placeholder="Masukkan Kelas-Jurusan" 
                            value="{{ old('class_major') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Email -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="email" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Email
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input 
                            type="email"
                            name="email" 
                            placeholder="Masukkan Email" 
                            value="{{ old('email') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- No.Whatsapp -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="whatsapp" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        No.Whatsapp
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input 
                            type="number"
                            name="whatsapp" 
                            placeholder="Masukkan No.Whatsapp" 
                            value="{{ old('whatsapp') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Alamat -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="address" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Alamat
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.input 
                            name="address" 
                            placeholder="Masukkan Alamat" 
                            value="{{ old('address') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Alasan Mengikuti -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <label for="reason" class="md:col-span-3 text-sm font-semibold text-gray-800 text-left pt-2.5">
                        Alasan Mengikuti
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center pt-2.5">:</span>
                    <div class="col-span-1 md:col-span-8">
                        <x-forms.textarea 
                            name="reason" 
                            placeholder="Masukkan Alasan Mengikuti Ekskul" 
                            value="{{ old('reason') }}" 
                            rows="5" 
                            required 
                        />
                    </div>
                </div>
            </div>

            <!-- Action Buttons matching screenshot style inside the card -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 max-w-3xl mx-auto">
                <!-- Konfirmasi Button (Yellow, rounded-full) -->
                <x-buttons.button type="submit" class="bg-[#FCD34D] hover:bg-[#FACC15] text-[#1F2937] py-3 px-8 rounded-full text-xs font-bold shadow-3xs cursor-pointer border-0">
                    Konfirmasi
                </x-buttons.button>

                <!-- Batal Button (Red, rounded-full) -->
                <x-buttons.button variant="secondary" type="button" onclick="window.history.back()" class="bg-[#E11D48] hover:bg-[#BE123C] text-white py-3 px-8 rounded-full text-xs font-bold shadow-3xs cursor-pointer border-0">
                    Batal
                </x-buttons.button>
            </div>

        </form>
    </div>
@endsection
