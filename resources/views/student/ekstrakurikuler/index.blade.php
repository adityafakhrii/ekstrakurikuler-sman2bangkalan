@extends('layouts.student')

@section('title', 'Daftar Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot 1 -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Daftar Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Gabung ke Ekstrakurikuler yang kamu minati, masih bingung? coba rekomendasikan Ekstrakurikuler agar lebih spesifik dengan preferensi yang ada dalam dirimu.
            </p>
        </div>

        <!-- Grid Layout: 2 Columns Desktop, 1 Column Mobile matching screenshot exactly (with wider vertical spacing) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-16 max-w-5xl mx-auto">
            @foreach($ekskuls as $ekskul)
                <x-cards.ekskul-card 
                    name="{{ $ekskul->nama }}"
                    match="{{ null }}"
                    gradient="from-blue-200 via-indigo-150 to-purple-200"
                    description="{{ $ekskul->deskripsi }}"
                    image="{{ $ekskul->logo_url }}"
                    has-logo="{{ $ekskul->logo && $ekskul->logo !== '/images/logo-sman2.png' ? 'true' : '' }}"
                    route="{{ route('siswa.ekskul.show', $ekskul->id) }}"
                />
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-8 flex justify-center">
            {{ $ekskuls->links() }}
        </div>
    </div>
@endsection
