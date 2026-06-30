@extends('layouts.app')

@section('title', 'Pemeliharaan Sistem - EKSIS SMAN 2 Bangkalan')

@section('layout-content')
    <main class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="text-center space-y-6 max-w-md">
            <div class="flex justify-center text-[#2A1B60]">
                <!-- Wrench/Screwdriver icon -->
                <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A1.5 1.5 0 0019.4 21l2-2a1.5 1.5 0 000-2.12l-5.83-5.83M11.42 15.17l2.83-2.83m-2.83 2.83A6.5 6.5 0 1115.17 11.4M11.42 15.17l-3.54 3.54M15.17 11.4L18 8.6M15.17 11.4l-2.83 2.83m-3.54-3.54A6.5 6.5 0 0111.4 3.83m0 0L8.6 1M11.4 3.83L8.57 6.66m0 0l-3.54 3.54M8.57 6.66l2.83 2.83m-3.54-3.54L1 11.42" />
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Dalam Pemeliharaan</h1>
            <p class="text-gray-500 font-light leading-relaxed">Sistem kami sedang menjalani pemeliharaan berkala untuk meningkatkan layanan. Kami akan segera kembali online.</p>
        </div>
    </main>
@endsection
