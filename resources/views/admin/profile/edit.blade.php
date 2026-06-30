@extends('layouts.admin')

@section('title', 'Kelola Akun - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-ui.card title="Kelola Akun">
        
        <!-- Profile Form (Centered vertical layout matching screenshot) -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-6">
            @csrf
            @method('PATCH')

            <!-- Profile Image Section (Centered) -->
            <div class="flex flex-col items-center gap-3">
                <!-- Red Background Photo Container matching screenshot -->
                <div class="w-28 h-36 bg-[#E11D48] rounded-xl overflow-hidden border-2 border-[#E11D48] shadow-md flex items-center justify-center relative">
                    <!-- Pas foto dummy placeholder (Avatar SVG representing student) -->
                    <svg class="w-20 h-20 text-white/90 mt-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                
                <!-- Choose Img Button matching screenshot -->
                <div class="relative bg-white border border-gray-200 rounded-md p-1.5 flex items-center justify-start gap-2 shadow-xs scale-95 border-dashed">
                    <label class="bg-gray-100 border border-gray-300 rounded-sm px-2.5 py-1 text-[10px] font-bold text-gray-700 hover:bg-gray-200 transition-colors duration-150 cursor-pointer shadow-xs uppercase tracking-wide">
                        Choose Img
                        <input type="file" name="profile_image" class="hidden" accept="image/*" 
                               onchange="document.getElementById('img-chosen-text').textContent = this.files[0] ? this.files[0].name : 'No Img Chosen'">
                    </label>
                    <span id="img-chosen-text" class="text-[10px] text-gray-500 font-medium truncate w-24">No Img Chosen</span>
                </div>
                
                @error('profile_image')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Fields Group -->
            <div class="space-y-5">
                
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-800">
                        Nama Lengkap
                    </label>
                    <x-ui.input 
                        name="name" 
                        placeholder="Masukkan Nama Lengkap" 
                        value="{{ old('name', Auth::user()->name ?? 'Ahmad Jihaduddin Salim') }}" 
                        class="bg-gray-100/80 border-gray-200"
                        required 
                    />
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-gray-800">
                        Username
                    </label>
                    <x-ui.input 
                        name="username" 
                        placeholder="Masukkan Username" 
                        value="{{ old('username', Auth::user()->username ?? 'ahmad_jihad') }}" 
                        class="bg-gray-100/80 border-gray-200"
                        required 
                    />
                </div>

                <!-- Password Baru -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-800">
                        Password Baru
                    </label>
                    <x-ui.input 
                        type="password" 
                        name="password" 
                        placeholder="" 
                        class="bg-gray-100/80 border-gray-200"
                    />
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-800">
                        Konfirmasi Password Baru
                    </label>
                    <x-ui.input 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="" 
                        class="bg-gray-100/80 border-gray-200"
                    />
                </div>

            </div>

            <!-- Action Buttons (Right Aligned matching screenshot) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Button -->
                <x-ui.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <!-- Save Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan
                </x-ui.button>

                <!-- Batal Button (Grey) -->
                <x-ui.button variant="secondary" type="button" onclick="window.location.href='{{ route('dashboard') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-ui.button>
            </div>

        </form>

    </x-ui.card>
@endsection
