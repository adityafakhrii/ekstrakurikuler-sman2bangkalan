@props([
    'name' => null,
    'pembina' => null,
    'ketua' => null,
    'jadwal' => null,
    'whatsappGroup' => null,
    'description' => null,
    'logoFilename' => null
])

<div class="space-y-6">
    <!-- Nama Ekstrakurikuler -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="name" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
            Nama Ekstrakurikuler
        </label>
        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
        <div class="col-span-12 md:col-span-8">
            <x-forms.input 
                name="name" 
                placeholder="Masukkan nama Ekstrakurikuler" 
                value="{{ old('name', $name) }}" 
                required 
            />
        </div>
    </div>

    <!-- Nama Pembina -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="pembina" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
            Nama Pembina
        </label>
        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
        <div class="col-span-12 md:col-span-8">
            <x-forms.input 
                name="pembina" 
                placeholder="Masukkan nama Pembina" 
                value="{{ old('pembina', $pembina) }}" 
                required 
            />
        </div>
    </div>

    <!-- Nama Ketua -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="ketua" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
            Nama Ketua
        </label>
        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
        <div class="col-span-12 md:col-span-8">
            <x-forms.input 
                name="ketua" 
                placeholder="*Terisi otomatis jika admin telah menambahkan ketua" 
                value="{{ old('ketua', $ketua) }}" 
                class="placeholder-red-500 font-semibold bg-gray-50/50 cursor-not-allowed"
                readonly 
            />
        </div>
    </div>

    <!-- Jadwal Kegiatan -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="jadwal" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
            Jadwal Kegiatan
        </label>
        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
        <div class="col-span-12 md:col-span-8">
            <x-forms.input 
                name="jadwal" 
                placeholder="Masukkan Jadwal Kegiatan" 
                value="{{ old('jadwal', $jadwal) }}" 
                required 
            />
        </div>
    </div>

    <!-- Link Grup Ekskul -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="whatsapp_group" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
            Link Grup Ekskul
        </label>
        <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
        <div class="col-span-12 md:col-span-8">
            <x-forms.input 
                name="whatsapp_group" 
                placeholder="Masukkan Link Grup Ekstrakurikuler" 
                value="{{ old('whatsapp_group', $whatsappGroup) }}" 
                required 
            />
        </div>
    </div>

    <!-- Deskripsi & Upload Logo (Grid Layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start pt-4">
        
        <!-- Deskripsi (Left Column) -->
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1">
                <label for="description" class="text-sm font-semibold text-gray-800">
                    Deskripsi Ekstrakurikuler
                </label>
                <span class="text-sm font-semibold text-gray-800">:</span>
            </div>
            <x-forms.textarea 
                name="description" 
                placeholder="Masukkan Deskripsi" 
                value="{{ old('description', $description) }}" 
                rows="5" 
                required 
            />
        </div>

        <!-- Upload Gambar Ekstrakurikuler (Right Column kustom) -->
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">
                    Upload Gambar/Foto Ekstrakurikuler
                </span>
                <span class="text-sm font-semibold text-gray-800">:</span>
            </div>
            
        <!-- Custom File Upload Container (same height as textarea) -->
            <div class="relative bg-white border border-[#f2eaea] rounded-xl p-4 flex flex-col gap-3 shadow-xs" style="min-height: 132px;">
                <!-- Gambar Lama (Jika Edit) -->
                @if(!empty($logoFilename))
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[11px] font-semibold text-gray-600 uppercase tracking-wide">Gambar Lama</span>
                        <span class="text-[10px] text-gray-400">:</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <img src="{{ asset('storage/' . $logoFilename) }}" alt="Gambar Lama" class="w-16 h-16 object-cover rounded-md border border-gray-200 shadow-xs">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-700 truncate">{{ basename($logoFilename) }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Gambar yang sedang digunakan</p>
                        </div>
                    </div>
                @endif
                
                <!-- Upload Section -->
                <div class="{{ !empty($logoFilename) ? 'pt-3 border-t border-gray-200 mt-2' : '' }}">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[11px] font-semibold text-gray-600 uppercase tracking-wide">{{ !empty($logoFilename) ? 'Upload Gambar Baru' : 'Upload Gambar' }}</span>
                        <span class="text-[10px] text-gray-400">:</span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-center sm:justify-start gap-3">
                        <label class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none transition-colors duration-150 cursor-pointer shadow-3xs whitespace-nowrap text-center">
                            Pilih Gambar
                            <input type="file" name="logo" id="ekskul-image-input" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
                                   onchange="previewEkskulImage(this)">
                        </label>
                        <div class="min-w-0 space-y-1">
                            <span id="file-chosen-text" class="block text-xs text-gray-500 font-medium truncate">Belum ada gambar dipilih</span>
                            <p class="text-[11px] text-gray-400 leading-relaxed">Format JPG, PNG, GIF, atau WebP maksimal 10 MB. Gambar akan otomatis dikompres menjadi WebP agar lebih ringan.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Image Preview Container -->
                <div id="ekskul-image-preview-container" class="hidden mt-3 pt-3 border-t border-gray-200">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[11px] font-semibold text-indigo-600 uppercase tracking-wide">Preview Gambar Baru</span>
                        <span class="text-[10px] text-indigo-400">:</span>
                    </div>
                    <div class="relative inline-block">
                        <img id="ekskul-image-preview" src="" alt="Preview Gambar Baru" class="w-full max-h-48 object-cover rounded-lg border border-indigo-200 shadow-sm">
                        <button type="button" onclick="clearEkskulImagePreview()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-md transition-colors cursor-pointer" title="Hapus preview">
                            ×
                        </button>
                    </div>
                    <p class="text-[11px] text-indigo-500 mt-2 font-medium italic">Gambar baru akan menggantikan gambar lama setelah disimpan</p>
                </div>
            </div>
            
            <script>
                function previewEkskulImage(input) {
                    const preview = document.getElementById('ekskul-image-preview');
                    const container = document.getElementById('ekskul-image-preview-container');
                    const chosenText = document.getElementById('file-chosen-text');
                    
                    if (input.files && input.files[0]) {
                        const file = input.files[0];
                        chosenText.textContent = file.name;
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            container.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        clearEkskulImagePreview();
                    }
                }
                
                function clearEkskulImagePreview() {
                    const input = document.getElementById('ekskul-image-input');
                    const preview = document.getElementById('ekskul-image-preview');
                    const container = document.getElementById('ekskul-image-preview-container');
                    const chosenText = document.getElementById('file-chosen-text');
                    
                    input.value = '';
                    preview.src = '';
                    container.classList.add('hidden');
                    chosenText.textContent = 'Belum ada gambar dipilih';
                }
            </script>
            
            @error('logo')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

    </div>
</div>
