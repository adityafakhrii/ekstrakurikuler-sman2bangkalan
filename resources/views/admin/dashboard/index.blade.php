@extends('layouts.admin')

@section('title', 'Dashboard - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Dashboard Stats Grid (Match screenshot layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto py-8">
        
        <!-- Card 1: Ketua Ekstrakurikuler -->
        <x-cards.stat-card 
            title="Ketua Ekstrakurikuler" 
            value="21" 
        />

        <!-- Card 2: Anggota Ekstrakurikuler -->
        <x-cards.stat-card 
            title="Anggota Ekstrakurikuler" 
            value="433" 
        />

        <!-- Card 3: Ekstrakurikuler (Centered below) -->
        <div class="md:col-span-2 md:flex md:justify-center">
            <x-cards.stat-card 
                title="Ekstrakurikuler" 
                value="21" 
                class="w-full md:w-[calc(50%-1rem)]" 
            />
        </div>

    </div>
@endsection
