@props([
    'name' => null,
    'pembina' => null,
    'description' => null,
    'logoFilename' => null
])

<div class="space-y-6">
    <!-- Nama Ekstrakurikuler -->
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <label for="name" class="w-full md:w-1/4 text-sm font-semibold text-gray-800 md:text-right">
            Nama Ekstrakurikuler :
        </label>
        <div class="flex-grow">
            <x-forms.input 
                name="name" 
                placeholder="Masukkan nama Ekstrakurikuler" 
                value="{{ old('name', $name) }}" 
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
            <x-forms.input 
                name="pembina" 
                placeholder="Masukkan nama Pembina" 
                value="{{ old('pembina', $pembina) }}" 
                required 
            />
        </div>
    </div>

    <!-- Deskripsi & Upload Logo (Grid Layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        <!-- Deskripsi (Left Column) -->
        <div class="flex flex-col gap-2">
            <label for="description" class="text-sm font-semibold text-gray-800">
                Deskripsi Ekstrakurikuler :
            </label>
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
            <span class="text-sm font-semibold text-gray-800">
                Upload Logo Ekstrakurikuler :
            </span>
            
            <!-- Custom File Upload Container -->
            <div class="relative bg-[#faf5f5] border border-[#f2eaea] rounded-xl p-6 flex items-center justify-start gap-3 shadow-xs">
                <label class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors duration-150 cursor-pointer shadow-xs">
                    Choose file
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
