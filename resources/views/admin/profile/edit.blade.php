@extends('layouts.admin')

@section('title', 'Kelola Akun - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-cards.card title="Kelola Akun">
        
        <!-- Profile Form (Centered vertical layout matching screenshot) -->
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-6">
            @csrf
            @method('PATCH')

            <!-- Profile Image Section (Centered) -->
            <div class="flex flex-col items-center gap-3">
                <!-- Red Background Photo Container matching screenshot -->
                <div class="w-28 h-36 bg-[#E11D48] rounded-xl overflow-hidden border-2 border-[#E11D48] shadow-md flex items-center justify-center relative">
                    @if(Auth::user()->foto)
                        <img id="profile-preview" src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        <div id="profile-preview-container">
                            <svg id="profile-preview-icon" class="w-20 h-20 text-white/90 mt-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <img id="profile-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        </div>
                    @endif
                </div>
                
                <!-- Choose Img Button matching screenshot -->
                <div class="relative bg-white border border-gray-200 rounded-md p-1.5 flex items-center justify-start gap-2 shadow-xs scale-95 border-dashed">
                    <label class="bg-gray-100 border border-gray-300 rounded-sm px-2.5 py-1 text-[10px] font-bold text-gray-700 hover:bg-gray-200 transition-colors duration-150 cursor-pointer shadow-xs uppercase tracking-wide">
                        Choose Img
                        <input type="file" name="profile_image" class="hidden" accept="image/*" 
                               onchange="previewProfileImage(this)">
                    </label>
                    <span id="img-chosen-text" class="text-[10px] text-gray-500 font-medium truncate w-24">No Img Chosen</span>
                </div>
                
                @error('profile_image')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <script>
                function previewProfileImage(input) {
                    const preview = document.getElementById('profile-preview');
                    const icon = document.getElementById('profile-preview-icon');
                    const chosenText = document.getElementById('img-chosen-text');
                    
                    if (input.files && input.files[0]) {
                        const file = input.files[0];
                        chosenText.textContent = file.name;
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                            if (icon) icon.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '';
                        preview.classList.add('hidden');
                        if (icon) icon.classList.remove('hidden');
                        chosenText.textContent = 'No Img Chosen';
                    }
                }
            </script>

            <!-- Input Fields Group -->
            <div class="space-y-5">
                
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-800">
                        Nama Lengkap
                    </label>
                    <x-forms.input 
                        name="name" 
                        placeholder="Masukkan Nama Lengkap" 
                        value="{{ old('name', Auth::user()->name) }}" 
                        class="bg-gray-100/80 border-gray-200"
                        required 
                    />
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-gray-800">
                        Username
                    </label>
                    <x-forms.input 
                        name="username" 
                        placeholder="Masukkan Username" 
                        value="{{ old('username', Auth::user()->username) }}" 
                        class="bg-gray-100/80 border-gray-200"
                        required 
                    />
                </div>

                <!-- Password Baru -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-800">
                        Password Baru
                    </label>
                    <x-forms.input 
                        type="password" 
                        name="password" 
                        placeholder="Masukkan password baru jika ingin mengubah" 
                        class="bg-gray-100/80 border-gray-200"
                    />
                    <p class="text-xs text-gray-500 font-normal mt-0.5">Abaikan atau kosongkan jika tidak ingin mengubah password.</p>
                    @error('password')
                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-800">
                        Konfirmasi Password Baru
                    </label>
                    <x-forms.input 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="Masukkan kembali password baru" 
                        class="bg-gray-100/80 border-gray-200"
                    />
                </div>

                <!-- Hapus Otomatis Rekomendasi -->
                <div class="space-y-2 pt-4 border-t border-gray-150">
                    <label for="auto_delete_rekomendasi" class="block text-sm font-semibold text-gray-800">
                        Hapus Otomatis Riwayat Rekomendasi
                    </label>
                    <x-forms.select 
                        name="auto_delete_rekomendasi" 
                        value="{{ old('auto_delete_rekomendasi', $autoDeleteSetting) }}"
                        :options="[
                            '3' => '3 Hari',
                            '7' => '7 Hari',
                            '14' => '14 Hari',
                            '30' => '30 Hari'
                        ]"
                        required
                    />
                    <p class="text-xs text-gray-500 font-normal">Rekomendasi hasil preferensi siswa yang lebih tua dari batas hari yang diset akan dihapus otomatis dari database untuk menjaga kestabilan performa sistem.</p>
                </div>

                <!-- Hapus Manual Rekomendasi -->
                <div class="pt-4 border-t border-gray-150 space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">
                        Hapus Hasil Rekomendasi Secara Manual
                    </label>
                    <p class="text-xs text-gray-500 font-normal">Anda dapat menghapus seluruh data hasil rekomendasi siswa secara permanen untuk mengosongkan ruang penyimpanan database segera.</p>
                    <p class="text-xs text-rose-600 font-semibold bg-rose-50 border border-rose-150 p-2.5 rounded-lg">
                        ⚠️ Data saat ini: terdapat {{ $recommendationResultsCount }} data hasil rekomendasi di database.
                    </p>
                    <button type="button" 
                        onclick="if(confirm('Apakah Anda yakin ingin menghapus seluruh data hasil rekomendasi siswa? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.')) { document.getElementById('clear-recommendations-form').submit(); }"
                        class="bg-[#EF4444] hover:bg-[#DC2626] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors cursor-pointer border-0 shadow-sm inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Semua Hasil Sekarang
                    </button>
                </div>

            </div>

            <!-- Action Buttons (Right Aligned matching screenshot) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Button -->
                <x-buttons.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <!-- Save Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan
                </x-buttons.button>

                <!-- Batal Button (Grey) -->
                <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('dashboard') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-buttons.button>
            </div>

        </form>

        <!-- Form Tersembunyi untuk Hapus Manual -->
        <form id="clear-recommendations-form" method="POST" action="{{ route('admin.profile.clear-recommendations') }}" class="hidden">
            @csrf
        </form>

    </x-cards.card>
@endsection
