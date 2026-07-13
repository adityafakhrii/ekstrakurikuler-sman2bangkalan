@extends('layouts.admin')

@section('title', 'Edit Admin - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-cards.card title="Edit Admin">
        
        <!-- Edit Form -->
        <form method="POST" action="{{ route('pengguna.admin.update', $user->id) }}" class="max-w-4xl mx-auto space-y-8">
            @csrf
            @method('PUT')

            <!-- Form Fields -->
            <div class="space-y-6 pl-6">

                <!-- Nama Lengkap -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="name" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Nama Lengkap
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input 
                            name="name" 
                            placeholder="Masukkan Nama Admin" 
                            value="{{ old('name', $user->name) }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Email -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="email" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Email
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input 
                            type="email"
                            name="email" 
                            placeholder="Masukkan Email Admin" 
                            value="{{ old('email', $user->email) }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Username -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="username" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Username
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input 
                            name="username" 
                            placeholder="Masukkan Username" 
                            value="{{ old('username', $user->username) }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Password Baru (opsional) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="password" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Password Baru
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input 
                            type="password"
                            name="password" 
                            placeholder="Kosongkan jika tidak ingin mengubah password" 
                        />
                    </div>
                </div>

            </div>

            <!-- Action Buttons (Right Aligned) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Perubahan Button -->
                <x-buttons.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Perubahan
                </x-buttons.button>

                <!-- Batal Button (Grey) -->
                <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('pengguna.admin.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-buttons.button>
            </div>

        </form>

    </x-cards.card>
@endsection
