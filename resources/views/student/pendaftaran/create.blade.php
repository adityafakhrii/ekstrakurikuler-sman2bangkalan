@extends('layouts.student')

@section('title', 'Formulir Daftar Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-cards.card title="Formulir Daftar Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-10 leading-relaxed">
            Isi Formulir pendaftaran ini dengan benar sesuai data pribadi kamu, dan berikan alasan mengikuti Ekstrakurikuler agar membantu dalam proses konfirmasi pendaftaranmu.
        </p>

        @php
            $id = request()->route('id', 1);
            $ekskulNames = [
                1 => 'Pramuka',
                2 => 'Paskibra',
                3 => 'Futsal'
            ];
            $ekskulName = $ekskulNames[$id] ?? 'Pramuka';
        @endphp

        <!-- Form Container matching screenshot 6 style -->
        <form method="POST" action="{{ route('siswa.register.store', $id) }}" class="max-w-4xl mx-auto bg-[#FCFBFB] border border-[#f2eaea] rounded-3xl p-6 md:p-10 shadow-xs space-y-6">
            @csrf

            <!-- Target Ekskul Info (Static Alert/Badge) -->
            <div class="bg-brand-primary/5 border border-brand-primary/10 rounded-xl p-4 flex items-center justify-between text-brand-primary max-w-3xl mx-auto">
                <span class="text-xs font-semibold uppercase tracking-wider">Mendaftar ke Ekskul :</span>
                <span class="text-sm font-bold">{{ $ekskulName }}</span>
            </div>

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
            </div>

            <!-- Action Buttons matching screenshot style inside the card -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea] max-w-3xl mx-auto">
                <!-- Konfirmasi Button (Yellow, rounded-full) -->
                <x-buttons.button type="submit" class="bg-[#FCD34D] hover:bg-[#FACC15] text-[#1F2937] py-2.5 px-8 rounded-full text-xs font-bold shadow-xs cursor-pointer border-0">
                    Konfirmasi
                </x-buttons.button>

                <!-- Batal Button (Red, rounded-full) -->
                <x-buttons.button variant="secondary" type="button" onclick="window.history.back()" class="bg-[#EF4444] hover:bg-[#DC2626] text-white py-2.5 px-8 rounded-full text-xs font-bold shadow-xs cursor-pointer border-0">
                    Batal
                </x-buttons.button>
            </div>

        </form>
    </x-cards.card>
@endsection
