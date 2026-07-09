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

        <!-- Upload Logo (Right Column kustom) -->
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">
                    Upload Logo Ekstrakurikuler
                </span>
                <span class="text-sm font-semibold text-gray-800">:</span>
            </div>
            
            <!-- Custom File Upload Container (same height as textarea) -->
            <div class="relative bg-white border border-[#f2eaea] rounded-xl p-4 flex items-center justify-start gap-3 shadow-xs" style="min-height: 132px;">
                <label class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none transition-colors duration-150 cursor-pointer shadow-3xs whitespace-nowrap">
                    Choose File
                    <input type="file" name="logo" class="hidden" accept="image/*" 
                           onchange="document.getElementById('file-chosen-text').textContent = this.files[0] ? this.files[0].name : '{{ $logoFilename ?? 'No File Chosen' }}'">
                </label>
                <span id="file-chosen-text" class="text-xs text-gray-500 font-medium truncate">{{ $logoFilename ?? 'No File Chosen' }}</span>
            </div>
            
            @error('logo')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

    </div>
</div>
