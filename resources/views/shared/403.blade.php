@extends('layouts.app')

@section('title', '403 Forbidden - EKSIS SMAN 2 Bangkalan')

@section('layout-content')
    <main class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="text-center space-y-6 max-w-md">
            <h1 class="text-9xl font-extrabold text-[#2A1B60]">403</h1>
            <p class="text-2xl font-bold text-gray-900">Akses Dilarang</p>
            <p class="text-gray-500 font-light">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <div class="pt-4">
                <a href="{{ url('/') }}" class="inline-flex items-center bg-black hover:bg-gray-900 text-white px-8 py-3 rounded-full text-xs font-bold shadow-md transition-all duration-200 cursor-pointer">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>
@endsection
