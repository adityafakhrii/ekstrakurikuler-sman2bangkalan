@extends('layouts.admin')

@section('title', 'Dashboard Admin - EKSIS SMAN 2 Bangkalan')

@section('content')
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        {{-- 2 kolom di atas, 1 di tengah bawah seperti screenshot --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Ketua Ekstrakurikuler --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[90px] shadow-sm">
                <div>
                    <p class="text-[12px] font-semibold text-[#3D2B2B]">Ketua Ekstrakurikuler</p>
                    <p class="text-[18px] font-bold text-[#3D2B2B] mt-2">{{ $stats['total_ketua'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            {{-- Anggota Ekstrakurikuler --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[90px] shadow-sm">
                <div>
                    <p class="text-[12px] font-semibold text-[#3D2B2B]">Anggota Ekstrakurikuler</p>
                    <p class="text-[18px] font-bold text-[#3D2B2B] mt-2">{{ $stats['total_anggota'] ?? $stats['total_siswa'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            {{-- Ekstrakurikuler - span full tapi center di desktop seperti screenshot (baris kedua 1 kolom center) --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[90px] shadow-sm md:col-span-2 md:max-w-[calc(50%-12px)] md:mx-auto md:w-full">
                <div>
                    <p class="text-[12px] font-semibold text-[#3D2B2B]">Ekstrakurikuler</p>
                    <p class="text-[18px] font-bold text-[#3D2B2B] mt-2">{{ $stats['total_ekskul'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endsection
