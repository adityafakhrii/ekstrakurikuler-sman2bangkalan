@extends('layouts.admin')

@section('title', 'Detail Ekstrakurikuler - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-cards.card title="Detail Ekstrakurikuler">

        @php
            $ekskul = [
                'name'          => 'Pramuka',
                'pembina'       => 'Ahmad Jihaduddin Salim',
                'ketua'         => 'Saiful Bahri',
                'jadwal'        => 'Kamis, 15.00 WIB & Sabtu, 08.00 WIB',
                'whatsapp'      => 'https://chat.whatsapp.com/Cm2ile4U2epHafu5Aklt1gh',
                'description'   => 'Pramuka adalah kegiatan ekstrakurikuler yang melatih kemandirian, disiplin, kerja sama, dan kepemimpinan melalui aktivitas seru seperti baris-berbaris, tali-temali, dan perkemahan.',
                'logo_filename' => 'Logo.jpg*',
                'fisik'         => 1,
                'intelektual'   => 3,
                'kreativitas'   => 2,
                'sosial'        => 5,
                'mental'        => 2,
                'komunikasi'    => 4,
            ];
            $criteria = [
                ['label' => 'Fisik & Ketangkasan',    'key' => 'fisik'],
                ['label' => 'Intelektual & Strategi', 'key' => 'intelektual'],
                ['label' => 'Kreativitas & Seni',     'key' => 'kreativitas'],
                ['label' => 'Sosial & Kepemimpinan',  'key' => 'sosial'],
                ['label' => 'Mental & Kedisiplinan',  'key' => 'mental'],
                ['label' => 'Komunikasi & Bahasa',    'key' => 'komunikasi'],
            ];
        @endphp

        <div class="max-w-4xl mx-auto space-y-8">

            <!-- Section 1: Informasi Umum -->
            <div>
                <x-forms.section-title title="Bagian 1: Informasi Umum" />
                <div class="space-y-5 pl-6">

                    <!-- Nama Ekstrakurikuler -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800">Nama Ekstrakurikuler</span>
                        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                        <div class="col-span-12 md:col-span-8">
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-2.5 text-sm text-gray-800 font-medium shadow-xs">
                                {{ $ekskul['name'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Nama Pembina -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800">Nama Pembina</span>
                        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                        <div class="col-span-12 md:col-span-8">
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-2.5 text-sm text-gray-800 font-medium shadow-xs">
                                {{ $ekskul['pembina'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Nama Ketua -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                        <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 pt-2.5">Nama Ketua</span>
                        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center pt-2.5">:</span>
                        <div class="col-span-12 md:col-span-8 space-y-1">
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-2.5 text-sm text-gray-800 font-medium shadow-xs">
                                {{ $ekskul['ketua'] }}
                            </div>
                            <p class="text-xs text-red-500 font-medium pl-1">*Terisi otomatis jika admin telah menambahkan ketua</p>
                        </div>
                    </div>

                    <!-- Jadwal Kegiatan -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800">Jadwal Kegiatan</span>
                        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                        <div class="col-span-12 md:col-span-8">
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-2.5 text-sm text-gray-800 font-medium shadow-xs">
                                {{ $ekskul['jadwal'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Link Grup Ekskul -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800">Link Grup Ekskul</span>
                        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                        <div class="col-span-12 md:col-span-8">
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-2.5 text-sm text-[#6366F1] font-medium shadow-xs break-all">
                                {{ $ekskul['whatsapp'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi & Logo (Grid 2 Kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start pt-2">

                        <!-- Deskripsi -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-800">Deskripsi Ekstrakurikuler</span>
                                <span class="text-sm font-semibold text-gray-800">:</span>
                            </div>
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-3 text-sm text-gray-700 font-normal shadow-xs leading-relaxed" style="min-height: 132px;">
                                {{ $ekskul['description'] }}
                            </div>
                        </div>

                        <!-- Upload Logo -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-800">Upload Logo Ekstrakurikuler</span>
                                <span class="text-sm font-semibold text-gray-800">:</span>
                            </div>
                            <div class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-3 flex items-center gap-3 shadow-xs" style="min-height: 132px;">
                                <!-- Logo Preview -->
                                <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600 font-medium">{{ $ekskul['logo_filename'] }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Section 2: Penilaian Aspek Pendukung -->
            <div>
                <x-forms.section-title title="Bagian 2: Penilaian Aspek Pendukung (Untuk Rekomendasi)" />
                <div class="space-y-4 pl-6">
                    @foreach($criteria as $criterion)
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                                {{ $criterion['label'] }}
                            </span>
                            <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                            <!-- Radio box container (read-only display) -->
                            <div class="col-span-12 md:col-span-8 flex items-center gap-4 sm:gap-8 flex-wrap bg-[#FCFBFB] border border-[#f2eaea] rounded-xl px-6 py-2.5 shadow-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <x-forms.radio
                                        label="{{ $i }}"
                                        name="{{ $criterion['key'] }}_display"
                                        value="{{ $i }}"
                                        checked="{{ $ekskul[$criterion['key']] == $i }}"
                                        disabled="true"
                                    />
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Ubah Button (Yellow) -->
                <x-buttons.button onclick="window.location.href='{{ route('ekskul.edit', 1) }}'" variant="edit" class="shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Ubah
                </x-buttons.button>

                <!-- Batal Button -->
                <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('ekskul.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-buttons.button>
            </div>

        </div>

    </x-cards.card>
@endsection
