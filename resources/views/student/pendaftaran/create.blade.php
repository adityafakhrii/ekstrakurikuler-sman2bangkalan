@extends('layouts.student')

@section('title', 'Formulir Pendaftaran Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-ui.card title="Formulir Pendaftaran Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-8 leading-relaxed">
            Isi formulir pendaftaran di bawah ini secara lengkap untuk bergabung dengan ekstrakurikuler yang Anda pilih.
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

        <!-- Form Container -->
        <form method="POST" action="{{ route('siswa.register.store', $id) }}" class="max-w-xl mx-auto space-y-6 bg-[#FCFBFB] border border-[#f2eaea] rounded-3xl p-6 md:p-8 shadow-xs">
            @csrf

            <!-- Target Ekskul Info (Static Alert/Badge) -->
            <div class="bg-brand-primary/5 border border-brand-primary/10 rounded-xl p-4 flex items-center justify-between text-brand-primary">
                <span class="text-xs font-semibold uppercase tracking-wider">Mendaftar ke Ekskul :</span>
                <span class="text-sm font-bold">{{ $ekskulName }}</span>
            </div>

            <!-- Nama Lengkap (Dummy User terisi otomatis) -->
            <div>
                <x-ui.input 
                    label="Nama Lengkap" 
                    name="name" 
                    value="Ahmad Jihaduddin Salim" 
                    required 
                    readonly 
                    class="bg-gray-100 cursor-not-allowed"
                />
            </div>

            <!-- Kelas (Select Component) -->
            <div>
                <x-ui.input 
                    label="Kelas" 
                    name="kelas" 
                    placeholder="Contoh: XI - IPA 2" 
                    value="{{ old('kelas') }}" 
                    required 
                />
            </div>

            <!-- No. Telepon / WhatsApp -->
            <div>
                <x-ui.input 
                    label="No. Telepon / WhatsApp" 
                    name="phone" 
                    placeholder="Masukkan Nomor Telepon" 
                    value="{{ old('phone') }}" 
                    required 
                />
            </div>

            <!-- Alasan Mendaftar (Textarea) -->
            <div>
                <x-ui.textarea 
                    label="Alasan Mengikuti Ekstrakurikuler" 
                    name="reason" 
                    placeholder="Tuliskan alasan Anda..." 
                    value="{{ old('reason') }}" 
                    rows="4" 
                    required 
                />
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Button (Purple styled) -->
                <x-ui.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-xl text-xs font-semibold shadow-xs inline-flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan
                </x-ui.button>

                <!-- Batal Button (Grey) -->
                <x-ui.button variant="secondary" type="button" onclick="window.history.back()" class="text-xs font-semibold py-2.5 px-6 rounded-xl shadow-xs cursor-pointer border-0">
                    Batal
                </x-ui.button>
            </div>

        </form>
    </x-ui.card>
@endsection
