@extends('layouts.admin')

@section('title', 'Dashboard Admin - EKSIS SMAN 2 Bangkalan')

@section('content')
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- pendaftar Tertunda --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[120px] shadow-sm">
                <div>
                    <p class="text-[13px] font-semibold text-[#3D2B2B]">pendaftar Tertunda</p>
                    <p class="text-2xl font-bold text-[#3D2B2B] mt-3">{{ $stats['pendaftar_menunggu'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-9 h-9 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            {{-- pendaftar Terkonfirmasi --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[120px] shadow-sm">
                <div>
                    <p class="text-[13px] font-semibold text-[#3D2B2B]">pendaftar Terkonfirmasi</p>
                    <p class="text-2xl font-bold text-[#3D2B2B] mt-3">{{ $stats['pendaftar_terkonfirmasi'] ?? $stats['pendaftar_disetujui'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-9 h-9 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            {{-- pendaftar Disetujui --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[120px] shadow-sm">
                <div>
                    <p class="text-[13px] font-semibold text-[#3D2B2B]">pendaftar Disetujui</p>
                    <p class="text-2xl font-bold text-[#3D2B2B] mt-3">{{ $stats['pendaftar_disetujui'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-9 h-9 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            {{-- Pendaftar Ditolak --}}
            <div class="bg-[#E9E9FF] rounded-lg p-5 relative flex flex-col justify-between min-h-[120px] shadow-sm">
                <div>
                    <p class="text-[13px] font-semibold text-[#3D2B2B]">Pendaftar Ditolak</p>
                    <p class="text-2xl font-bold text-[#3D2B2B] mt-3">{{ $stats['pendaftar_ditolak'] ?? 0 }}</p>
                </div>
                <div class="absolute bottom-4 right-4 w-9 h-9 rounded-full bg-[#E8E6DF] flex items-center justify-center">
                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endsection
