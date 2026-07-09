@extends('layouts.admin')

@section('title', 'Edit Ekstrakurikuler - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-cards.card title="Edit Ekstrakurikuler Baru">
        
        <!-- Dummy data definitions (Exactly matching screenshot 5) -->
        @php
            $ekskul = [
                'name' => 'Pramuka',
                'pembina' => 'Ahmad Jihaduddin Salim',
                'description' => 'Pramuka adalah kegiatan ekstrakurikuler yang melatih kemandirian, disiplin, kerja sama, dan kepemimpinan melalui aktivitas seru seperti baris-berbaris, tali-temali, dan perkemahan.',
                'logo_filename' => 'Logo.jpg*',
                'fisik' => 1,
                'intelektual' => 3,
                'kreativitas' => 2,
                'sosial' => 5,
                'mental' => 2,
                'komunikasi' => 4
            ];
        @endphp

        <!-- Edit Form -->
        <form method="POST" action="{{ route('ekskul.update', 1) }}" enctype="multipart/form-data" class="max-w-4xl mx-auto space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Informasi Umum -->
            <div>
                <x-forms.section-title title="Bagian 1: Informasi Umum" />
                <div class="pl-6">
                    <x-forms.ekskul-fields 
                        :name="$ekskul['name']" 
                        :pembina="$ekskul['pembina']" 
                        :description="$ekskul['description']" 
                        :logo-filename="$ekskul['logo_filename']" 
                    />
                </div>
            </div>

            <!-- Section 2: Penilaian Aspek Pendukung -->
            <div>
                <x-forms.section-title title="Bagian 2: Penilaian Aspek Pendukung (Untuk Rekomendasi)" />
                
                <!-- Criteria List (Exactly matching screenshot values) -->
                <div class="space-y-4 pl-6">
                    @php
                        // 6 Recommendation Criteria with preset values from screenshot
                        $criteria = [
                            ['label' => 'Fisik & Ketangkasan', 'name' => 'fisik', 'value' => $ekskul['fisik']],
                            ['label' => 'Intelektual & Strategi', 'name' => 'intelektual', 'value' => $ekskul['intelektual']],
                            ['label' => 'Kreativitas & Seni', 'name' => 'kreativitas', 'value' => $ekskul['kreativitas']],
                            ['label' => 'Sosial & Kepemimpinan', 'name' => 'sosial', 'value' => $ekskul['sosial']],
                            ['label' => 'Mental & Kedisiplinan', 'name' => 'mental', 'value' => $ekskul['mental']],
                            ['label' => 'Komunikasi & Bahasa', 'name' => 'komunikasi', 'value' => $ekskul['komunikasi']]
                        ];
                    @endphp

                    @foreach($criteria as $criterion)
                        <!-- Grid Layout 12 Columns matching screenshot -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <span class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                                {{ $criterion['label'] }}
                            </span>
                            <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                            
                            <!-- Radio box container -->
                            <div class="col-span-12 md:col-span-8 flex items-center gap-4 sm:gap-8 flex-wrap bg-[#FCFBFB] border border-[#f2eaea] rounded-xl px-6 py-2.5 shadow-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <x-forms.radio 
                                        label="{{ $i }}" 
                                        name="{{ $criterion['name'] }}" 
                                        value="{{ $i }}" 
                                        checked="{{ old($criterion['name'], $criterion['value']) == $i }}" 
                                    />
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons (Right Aligned matching screenshot) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Perubahan Button -->
                <x-buttons.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <!-- Save/Disk Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Perubahan
                </x-buttons.button>

                <!-- Batal Button (Grey) -->
                <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('ekskul.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-buttons.button>
            </div>

        </form>

    </x-cards.card>
@endsection
