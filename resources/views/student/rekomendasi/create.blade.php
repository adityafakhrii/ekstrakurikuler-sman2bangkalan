@extends('layouts.student')

@section('title', 'Rekomendasi Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-ui.card title="Rekomendasi Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-8 leading-relaxed">
            Agar mendapatkan Ekstrakurikuler yang sesuai dengan preferensimu, minta tolong nilai 6 aspek berikut yang sesuai dengan minat dan bakat kamu.
        </p>

        <!-- Form Aspek Penilaian -->
        <form method="POST" action="{{ route('siswa.rekomendasi.store') }}" class="max-w-2xl mx-auto space-y-6 bg-[#FCFBFB] border border-[#f2eaea] rounded-3xl p-6 md:p-8 shadow-xs">
            @csrf

            @php
                $criteria = [
                    ['label' => 'Fisik & Ketangkasan', 'name' => 'fisik', 'value' => 2],
                    ['label' => 'Intelektual & Strategi', 'name' => 'intelektual', 'value' => 4],
                    ['label' => 'Kreativitas & Seni', 'name' => 'kreativitas', 'value' => 1],
                    ['label' => 'Sosial & Kepemimpinan', 'name' => 'sosial', 'value' => 3],
                    ['label' => 'Mental & Kedisiplinan', 'name' => 'mental', 'value' => 4],
                    ['label' => 'Komunikasi & Bahasa', 'name' => 'komunikasi', 'value' => 2]
                ];
            @endphp

            <div class="space-y-6">
                @foreach($criteria as $criterion)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm font-semibold text-gray-800">
                            {{ $criterion['label'] }} :
                        </span>
                        
                        <!-- Reusable Keyboard-Accessible Rating Component -->
                        <x-star-rating 
                            name="{{ $criterion['name'] }}" 
                            value="{{ old($criterion['name'], $criterion['value']) }}" 
                        />
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons matching screenshot style inside the card -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Submit Button (Green) -->
                <x-ui.button type="submit" class="bg-[#22C55E] hover:bg-[#16A34A] text-white py-2.5 px-6 rounded-xl text-xs font-semibold shadow-xs cursor-pointer">
                    Submit
                </x-ui.button>

                <!-- Edit Button (Yellow) -->
                <x-ui.button variant="secondary" type="button" class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] py-2.5 px-6 rounded-xl text-xs font-semibold shadow-xs cursor-pointer border-0">
                    Edit
                </x-ui.button>
            </div>

        </form>
    </x-ui.card>
@endsection
