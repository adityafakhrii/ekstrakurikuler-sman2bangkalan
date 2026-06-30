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
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label for="nisn" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        Nisn :
                    </label>
                    <div class="flex-grow">
                        <x-forms.input 
                            name="nisn" 
                            placeholder="Masukkan Nisn" 
                            value="{{ old('nisn', '21082') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label for="name" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        Nama Lengkap :
                    </label>
                    <div class="flex-grow">
                        <x-forms.input 
                            name="name" 
                            placeholder="Masukkan Nama Lengkap" 
                            value="{{ old('name', 'Ahmad Jihaduddin Salim') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        Jenis Kelamin :
                    </label>
                    <div class="flex-grow flex items-center gap-6">
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
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label for="class_major" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        Kelas-Jurusan :
                    </label>
                    <div class="flex-grow">
                        <x-forms.input 
                            name="class_major" 
                            placeholder="Masukkan Kelas-Jurusan" 
                            value="{{ old('class_major') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Email -->
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label for="email" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        Email :
                    </label>
                    <div class="flex-grow">
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
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label for="whatsapp" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        No.Whatsapp :
                    </label>
                    <div class="flex-grow">
                        <x-forms.input 
                            name="whatsapp" 
                            placeholder="Masukkan No.Whatsapp" 
                            value="{{ old('whatsapp') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Alamat -->
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <label for="address" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                        Alamat :
                    </label>
                    <div class="flex-grow">
                        <x-forms.input 
                            name="address" 
                            placeholder="Masukkan Alamat" 
                            value="{{ old('address') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Alasan Mengikuti (Textarea below label) -->
                <div class="flex flex-col gap-2 pt-2">
                    <span class="text-sm font-semibold text-gray-800">
                        Alasan Mengikuti :
                    </span>
                    <x-forms.textarea 
                        name="reason" 
                        placeholder="Masukkan Alasan Mengikuti Ekskul" 
                        value="{{ old('reason') }}" 
                        rows="5" 
                        required 
                    />
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
