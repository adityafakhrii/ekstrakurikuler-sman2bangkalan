@extends('layouts.ketua')

@section('title', 'Dashboard Ketua - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Floating Card Container matching screenshot style and admin layout structure -->
    <div class="w-full max-w-5xl bg-[#FFF5F5] rounded-[2.5rem] shadow-xl p-8 sm:p-12 mx-auto">
        
        <!-- Grid of 4 Stats: 2 columns matching screenshot layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Card 1: pendaftar Tertunda -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">pendaftar Tertunda</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">5</h3>
                </div>
                <!-- Siluet Person Icon in bottom right (Absolute positioned cleanly) -->
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2: pendaftar Terkonfirmasi -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">pendaftar Terkonfirmasi</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">12</h3>
                </div>
                <!-- Siluet Person Icon in bottom right (Absolute positioned cleanly) -->
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3: pendaftar Disetujui -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">pendaftar Disetujui</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">23</h3>
                </div>
                <!-- Siluet Person Icon in bottom right (Absolute positioned cleanly) -->
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4: Pendaftar Ditolak -->
            <div class="bg-[#E5E3F6] rounded-3xl p-6 relative flex flex-col justify-between min-h-[140px] shadow-sm">
                <div>
                    <span class="text-sm font-bold text-gray-800">Pendaftar Ditolak</span>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-2">0</h3>
                </div>
                <!-- Siluet Person Icon in bottom right (Absolute positioned cleanly) -->
                <div class="absolute bottom-4 right-4 text-black">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

        </div>

    </div>
@endsection
