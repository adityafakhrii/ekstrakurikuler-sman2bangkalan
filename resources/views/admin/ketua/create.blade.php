@extends('layouts.admin')

@section('title', 'Tambah Ketua Baru - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-cards.card title="Tambah Ketua Baru">
        
        <!-- Create Form -->
        <form method="POST" action="{{ route('pengguna.ketua.store') }}" class="max-w-4xl mx-auto space-y-8">
            @csrf

            <!-- Form Fields -->
            <div class="space-y-6 pl-6">

                <!-- Nama Ketua -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="name" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Nama Ketua
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input 
                            name="name" 
                            placeholder="Masukkan Nama Ketua Ekstrakurikuler" 
                            value="{{ old('name') }}" 
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
                            placeholder="Masukkan Email Ketua" 
                            value="{{ old('email') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Ekstrakurikuler (Dropdown) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="ekstrakurikuler_id" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Ekstrakurikuler
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <div class="relative">
                            <select name="ekstrakurikuler_id" id="ekstrakurikuler_id"
                                class="w-full bg-white border border-[#f2eaea] rounded-xl px-4 py-2.5 pr-10 text-sm text-gray-700 font-medium shadow-xs appearance-none focus:outline-none focus:ring-2 focus:ring-[#6366F1]/30 focus:border-[#6366F1] transition-all duration-150">
                                <option value="">Pilih Ekstrakurikuler (Opsional)</option>
                                @foreach($ekskuls as $ekskul)
                                    <option value="{{ $ekskul->id }}" {{ old('ekstrakurikuler_id') == $ekskul->id ? 'selected' : '' }}>
                                        {{ $ekskul->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Chevron Icon -->
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
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
                            value="{{ old('username') }}" 
                            required 
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="password" class="col-span-12 md:col-span-3 text-sm font-semibold text-gray-800 text-left">
                        Password
                    </label>
                    <span class="hidden md:inline md:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>
                    <div class="col-span-12 md:col-span-8">
                        <x-forms.input 
                            type="password"
                            name="password" 
                            placeholder="Masukkan Password" 
                            required 
                        />
                    </div>
                </div>

            </div>

            <!-- Action Buttons (Right Aligned) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Button -->
                <x-buttons.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan
                </x-buttons.button>

                <!-- Batal Button (Grey) -->
                <x-buttons.button variant="secondary" type="button" onclick="window.location.href='{{ route('pengguna.ketua.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-buttons.button>
            </div>

        </form>

    </x-cards.card>
@endsection
