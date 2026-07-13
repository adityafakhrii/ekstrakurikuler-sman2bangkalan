@extends('layouts.admin')

@section('title', 'Dashboard Admin - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Floating Card Container matching screenshot style and ketua layout structure -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Overview data ekstrakurikuler SMAN 2 Bangkalan</p>
        </div>

        <!-- Grid of Stats Cards matching screenshot layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Card 1: Ketua Ekstrakurikuler -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">Ketua Ekstrakurikuler</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $stats['total_ketua'] }}</h3>
                </div>
                <!-- Siluet Person Icon in bottom right -->
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2: Total Siswa -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">Total Siswa</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $stats['total_siswa'] }}</h3>
                </div>
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3: Ekstrakurikuler -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">Ekstrakurikuler</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $stats['total_ekskul'] }}</h3>
                </div>
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4: Total Pendaftar -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">Total Pendaftar</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $stats['total_pendaftar'] }}</h3>
                </div>
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

        </div>

        <!-- Row 2: Status Pendaftaran Cards -->
        <div class="mt-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Status Pendaftaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Menunggu -->
                <div class="bg-yellow-50 rounded-3xl p-6 relative flex flex-col justify-between min-h-[120px] shadow-sm border border-yellow-100">
                    <div>
                        <span class="text-sm font-bold text-yellow-800">Menunggu</span>
                        <h3 class="text-3xl font-extrabold text-yellow-900 mt-2">{{ $stats['pendaftar_menunggu'] }}</h3>
                    </div>
                </div>
                <!-- Disetujui -->
                <div class="bg-green-50 rounded-3xl p-6 relative flex flex-col justify-between min-h-[120px] shadow-sm border border-green-100">
                    <div>
                        <span class="text-sm font-bold text-green-800">Disetujui</span>
                        <h3 class="text-3xl font-extrabold text-green-900 mt-2">{{ $stats['pendaftar_disetujui'] }}</h3>
                    </div>
                </div>
                <!-- Ditolak -->
                <div class="bg-red-50 rounded-3xl p-6 relative flex flex-col justify-between min-h-[120px] shadow-sm border border-red-100">
                    <div>
                        <span class="text-sm font-bold text-red-800">Ditolak</span>
                        <h3 class="text-3xl font-extrabold text-red-900 mt-2">{{ $stats['pendaftar_ditolak'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Button Row -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-gray-800">Export Data</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('export.siswa') }}" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Export Siswa
                    </a>
                    <a href="{{ route('export.ketua') }}" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Export Ketua
                    </a>
                    <a href="{{ route('export.pendaftaran') }}" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Export Pendaftaran
                    </a>
                    <a href="{{ route('export.ekskul') }}" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white text-xs font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Export Ekskul
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
