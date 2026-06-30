@extends('layouts.guest')

@section('title', 'Login Siswa - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Container: Two-column layout grid -->
    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 items-center mx-auto py-12 md:py-24">
        
        <!-- Left Column: Heading & Subtitle -->
        <div class="space-y-3 text-center md:text-left">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Login Sekarang!
            </h1>
            <p class="text-base sm:text-lg text-gray-600 font-medium tracking-wide">
                Ekstrakurikuler - SMAN 2 Bangkalan
            </p>
        </div>

        <!-- Right Column: Centered Login Card -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-md bg-white border border-[#f2eaea] rounded-3xl p-8 shadow-xl shadow-[#2a1b60]/5">
                
                <!-- Session Alert / Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl mb-6 font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('siswa.login') }}" class="space-y-6">
                    @csrf

                    <!-- Nomor Induk Input Field -->
                    <div>
                        <x-forms.input 
                            label="Nomor Induk" 
                            name="nomor_induk" 
                            placeholder="Masukkan Nomor Induk" 
                            value="{{ old('nomor_induk') }}" 
                            required 
                            autofocus 
                        />
                    </div>

                    <!-- Submit Button (Solid black styled matching screenshot) -->
                    <div class="pt-2">
                        <x-buttons.button 
                            type="submit" 
                            class="w-full bg-black hover:bg-gray-900 text-white justify-center py-3.5 rounded-xl font-bold transition-all duration-200 shadow-sm border-0 cursor-pointer"
                        >
                            Login
                        </x-buttons.button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
