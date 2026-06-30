@extends('layouts.app')

@section('title', 'Edit Ketua - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-ui.card title="Edit Ketua Baru">
        
        <!-- Dummy data definitions (Matches Ketua context) -->
        @php
            $ketua = [
                'name' => 'Pramuka',
                'pembina' => 'Ahmad Jihaduddin Salim',
                'description' => 'Pramuka adalah kegiatan ekstrakurikuler yang melatih kemandirian, disiplin, kerja sama, dan kepemimpinan melalui aktivitas seru seperti baris-berbaris, tali-temali, dan perkemahan.',
                'logo_filename' => 'Logo.jpg*'
            ];
        @endphp

        <!-- Edit Form -->
        <form method="POST" action="{{ route('pengguna.ketua.update', 1) }}" enctype="multipart/form-data" class="max-w-4xl mx-auto space-y-8">
            @csrf
            @method('PUT')

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
                                value="{{ old('name', $ketua['name']) }}" 
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
                                value="{{ old('pembina', $ketua['pembina']) }}" 
                                required 
                            />
                        </div>
                    </div>

                    <!-- Deskripsi & Upload Logo -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                        
                        <!-- Deskripsi (Left Column) -->
                        <div class="flex flex-col gap-2">
                            <label for="description" class="text-sm font-semibold text-gray-800">
                                Deskripsi Ekstrakurikuler :
                            </label>
                            <x-ui.textarea 
                                name="description" 
                                placeholder="Masukkan Deskripsi" 
                                value="{{ old('description', $ketua['description']) }}" 
                                rows="5" 
                                required 
                            />
                        </div>

                        <!-- Upload Logo (Right Column kustom) -->
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-semibold text-gray-800">
                                Upload Logo Ekstrakurikuler :
                            </span>
                            
                            <!-- Custom File Upload Container -->
                            <div class="relative bg-[#faf5f5] border border-[#f2eaea] rounded-xl p-6 flex items-center justify-start gap-3 shadow-xs">
                                <label class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors duration-150 cursor-pointer shadow-xs">
                                    Choose file
                                    <input type="file" name="logo" class="hidden" accept="image/*" 
                                           onchange="document.getElementById('file-chosen-text').textContent = this.files[0] ? this.files[0].name : '{{ $ketua['logo_filename'] }}'">
                                </label>
                                <span id="file-chosen-text" class="text-xs text-gray-500 font-medium truncate">{{ $ketua['logo_filename'] }}</span>
                            </div>
                            
                            @error('logo')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <!-- Action Buttons (Right Aligned matching screenshot) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Perubahan Button -->
                <x-ui.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <!-- Save/Disk Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Perubahan
                </x-ui.button>

                <!-- Batal Button (Grey) -->
                <x-ui.button variant="secondary" type="button" onclick="window.location.href='{{ route('pengguna.ketua.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-ui.button>
            </div>

        </form>

    </x-ui.card>
@endsection
