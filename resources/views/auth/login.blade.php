@extends('layouts.guest')

@section('title', 'Login - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Form Title -->
    <h2 class="text-xl font-bold text-center text-gray-900 tracking-wide uppercase mb-8">
        SMA NEGERI 2 BANGKALAN
    </h2>

    <!-- Session Alert (Status/Error messages from backend) -->
    @if (session('status'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs px-4 py-3 rounded-xl mb-4 font-medium">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any() && !$errors->has('username') && !$errors->has('password'))
        <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl mb-4 font-medium">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Username Input Field -->
        <div>
            <x-ui.input 
                label="Username" 
                name="username" 
                placeholder="Masukkan Username" 
                value="{{ old('username') }}" 
                required 
                autofocus 
            />
        </div>

        <!-- Password Input Field -->
        <div>
            <x-ui.input 
                label="Password" 
                name="password" 
                type="password" 
                placeholder="Masukkan Password" 
                required 
            />
        </div>

        <!-- Submit Button (Black styled button matching screenshot) -->
        <div class="pt-2">
            <x-ui.button 
                type="submit" 
                class="w-full bg-black hover:bg-gray-900 text-white justify-center py-3 rounded-xl font-semibold transition-all duration-200 shadow-sm"
            >
                Login
            </x-ui.button>
        </div>
    </form>
@endsection
