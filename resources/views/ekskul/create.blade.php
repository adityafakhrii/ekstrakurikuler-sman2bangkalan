@extends('layouts.app')

@section('title', 'Tambah Ekstrakurikuler Baru - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-ui.card title="Tambah Ekstrakurikuler Baru">
        
        <!-- Create Form (With file upload support) -->
        <form method="POST" action="{{ route('ekskul.store') }}" enctype="multipart/form-data" class="max-w-4xl mx-auto space-y-8">
            @csrf

            <!-- Section 1: Informasi Umum -->
            <div>
                <x-ui.section-title title="Bagian 1: Informasi Umum" />
                
                <div class="space-y-6">
                    <!-- Nama Ekstrakurikuler -->
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label for="name" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                            Nama Ekstrakurikuler :
                        </label>
                        <div class="flex-grow">
                            <x-ui.input 
                                name="name" 
                                placeholder="Masukkan nama Ekstrakurikuler" 
                                value="{{ old('name') }}" 
                                required 
                            />
                        </div>
                    </div>

                    <!-- Nama Pembina -->
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label for="pembina" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                            Nama Pembina :
                        </label>
                        <div class="flex-grow">
                            <x-ui.input 
                                name="pembina" 
                                placeholder="Masukkan nama Pembina" 
                                value="{{ old('pembina') }}" 
                                required 
                            />
                        </div>
                    </div>

                    <!-- Deskripsi & Upload Logo (Grid Layout matching screenshot) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                        
                        <!-- Deskripsi (Left Column) -->
                        <div class="flex flex-col gap-2">
                            <label for="description" class="text-sm font-semibold text-gray-800">
                                Deskripsi Ekstrakurikuler :
                            </label>
                            <x-ui.textarea 
                                name="description" 
                                placeholder="Masukkan Deskripsi" 
                                value="{{ old('description') }}" 
                                rows="5" 
                                required 
                            />
                        </div>

                        <!-- Upload Logo (Right Column kustom) -->
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-semibold text-gray-800">
                                Upload Logo Ekstrakurikuler :
                            </span>
                            
                            <!-- Custom File Upload Container matching screenshot style -->
                            <div class="relative bg-[#faf5f5] border border-[#f2eaea] rounded-xl p-6 flex items-center justify-start gap-3 shadow-xs">
                                <label class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors duration-150 cursor-pointer shadow-xs">
                                    Choose file
                                    <input type="file" name="logo" class="hidden" accept="image/*" 
                                           onchange="document.getElementById('file-chosen-text').textContent = this.files[0] ? this.files[0].name : 'No File Chosen'">
                                </label>
                                <span id="file-chosen-text" class="text-xs text-gray-500 font-medium truncate">No File Chosen</span>
                            </div>
                            
                            @error('logo')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <!-- Section 2: Penilaian Aspek Pendukung -->
            <div>
                <x-ui.section-title title="Bagian 2: Penilaian Aspek Pendukung (Untuk Rekomendasi)" />
                
                <!-- Criteria List (Exactly matching screenshot) -->
                <div class="space-y-4">
                    @php
                        // 6 Recommendation Criteria from screenshot
                        $criteria = [
                            ['label' => 'Fisik & Ketangkasan', 'name' => 'fisik'],
                            ['label' => 'Intelektual & Strategi', 'name' => 'intelektual'],
                            ['label' => 'Kreativitas & Seni', 'name' => 'kreativitas'],
                            ['label' => 'Sosial & Kepemimpinan', 'name' => 'sosial'],
                            ['label' => 'Mental & Kedisiplinan', 'name' => 'mental'],
                            ['label' => 'Komunikasi & Bahasa', 'name' => 'komunikasi']
                        ];
                    @endphp

                    @foreach($criteria as $criterion)
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <span class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
                                {{ $criterion['label'] }} :
                            </span>
                            
                            <!-- Radio box container -->
                            <div class="flex items-center gap-8 bg-white border border-[#f2eaea] rounded-xl px-6 py-2.5 flex-grow shadow-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <x-ui.radio 
                                        label="{{ $i }}" 
                                        name="{{ $criterion['name'] }}" 
                                        value="{{ $i }}" 
                                        checked="{{ old($criterion['name']) == $i }}" 
                                    />
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons (Right Aligned matching screenshot) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Button (Purple color with icon) -->
                <x-ui.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <!-- Save/Disk Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan
                </x-ui.button>

                <!-- Batal Button (Grey) -->
                <x-ui.button variant="secondary" type="button" onclick="window.location.href='{{ route('ekskul.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-ui.button>
            </div>

        </form>

    </x-ui.card>
@endsection
