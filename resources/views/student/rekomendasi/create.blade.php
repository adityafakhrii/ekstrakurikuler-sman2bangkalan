@extends('layouts.student')

@section('title', 'Rekomendasi Ekstrakurikuler - EKSIS')

@section('content')
    <div class="space-y-12 pt-12 pb-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Page Titles matching screenshot 5 -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold text-[#2A1B60] tracking-tight">
                Rekomendasi Ekstrakurikuler
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Agar mendapatkan Ekstrakurikuler yang sesuai dengan preferensimu, minta tolong nilai 6 aspek berikut yang sesuai dengan minat dan bakat kamu.
            </p>
        </div>

        <!-- Form Aspek Penilaian (Gray background rounded wrapper matching others) -->
        <form method="POST" action="{{ route('siswa.rekomendasi.store') }}" class="max-w-5xl mx-auto bg-[#F3F4F6]/50 border border-gray-150/70 rounded-[2.5rem] p-6 sm:p-12 shadow-2xs space-y-8">
            @csrf

            @php
                $criteria = [
                    ['label' => 'Ketangkasan', 'name' => 'ketangkasan', 'value' => 0],
                    ['label' => 'Intelektual', 'name' => 'intelektual', 'value' => 0],
                    ['label' => 'Sosial', 'name' => 'sosial', 'value' => 0],
                    ['label' => 'Kreativitas', 'name' => 'kreativitas', 'value' => 0],
                    ['label' => 'Kedisiplinan', 'name' => 'kedisiplinan', 'value' => 0],
                    ['label' => 'Komunikasi', 'name' => 'komunikasi', 'value' => 0]
                ];
            @endphp

            <div class="space-y-6 max-w-3xl mx-auto">
                @foreach($criteria as $criterion)
                    <!-- Row Grid matching screenshot 5 with colon alignment -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                        <span class="sm:col-span-4 text-sm font-semibold text-gray-800 text-left">
                            {{ $criterion['label'] }}
                        </span>

                        <span class="hidden sm:inline sm:col-span-1 text-sm font-semibold text-gray-800 text-center">:</span>

                        <!-- Star rating inside custom white rounded box wrapper -->
                        <div class="col-span-1 sm:col-span-7 bg-white border border-gray-150/70 rounded-xl p-3 flex justify-start shadow-3xs">
                            <x-forms.star-rating
                                name="{{ $criterion['name'] }}"
                                value="{{ old($criterion['name'], $criterion['value']) }}"
                            />
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons matching screenshot style inside the card (Right aligned) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 max-w-3xl mx-auto">
                <!-- Submit Button (Green, rounded-full) -->
                <x-buttons.button type="submit" class="bg-[#22C55E] hover:bg-[#16A34A] text-white py-3 px-8 rounded-full text-xs font-bold border-0 cursor-pointer shadow-3xs">
                    Submit
                </x-buttons.button>

                <!-- Edit Button (Yellow, rounded-full) -->
                <x-buttons.button variant="secondary" type="button" class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] py-3 px-8 rounded-full text-xs font-bold border-0 cursor-pointer shadow-3xs">
                    Edit
                </x-buttons.button>
            </div>

        </form>
    </div>
@endsection
