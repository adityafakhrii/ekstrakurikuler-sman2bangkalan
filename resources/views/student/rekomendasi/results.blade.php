@extends('layouts.student')

@section('title', 'Hasil Rekomendasi Ekstrakurikuler - EKSIS')

@section('hero')
    <x-hero />
@endsection

@section('content')
    <x-ui.card title="Daftar Ekstrakurikuler">
        <p class="text-sm text-gray-500 font-light text-center max-w-2xl mx-auto -mt-4 mb-10 leading-relaxed">
            Kamu sudah merekomendasikan sesuai preferensimu untuk memilih Ekstrakurikuler, berikut Daftar Ekstrakurikuler yang sudah diurutkan dari yang paling cocok untukmu.
        </p>

        @php
            $ekskuls = [
                [
                    'name' => 'Pramuka',
                    'match' => '97% Cocok',
                    'description' => 'Pramuka adalah kegiatan ekstrakurikuler yang melatih kemandirian, disiplin, kerja sama, dan kepemimpinan melalui aktivitas luar ruangan yang seru.',
                    'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Futsal',
                    'match' => '92% Cocok',
                    'description' => 'Futsal mengasah ketangkasan fisik, strategi kerja sama tim, dan sportivitas tinggi melalui latihan rutin dan turnamen antar-sekolah.',
                    'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Basket',
                    'match' => '85% Cocok',
                    'description' => 'Ekskul Basket memfokuskan pengembangan stamina, keterampilan dribbling, shooting, serta kerja sama tim taktis dalam pertandingan basket.',
                    'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'PMR',
                    'match' => '78% Cocok',
                    'description' => 'Palang Merah Remaja (PMR) mengajarkan dasar-dasar pertolongan pertama, kesehatan remaja, kepedulian sosial, dan jiwa kesukarelawanan.',
                    'image' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Paskibra',
                    'match' => '71% Cocok',
                    'description' => 'Paskibra melatih ketegasan, kedisiplinan, baris-berbaris yang rapi, dan menumbuhkan rasa cinta tanah air serta jiwa nasionalisme yang kuat.',
                    'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Tari Tradisional',
                    'match' => '65% Cocok',
                    'description' => 'Melestarikan seni budaya bangsa melalui tarian tradisional Nusantara, mengasah kreativitas, keindahan estetika gerakan tubuh.',
                    'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        @endphp

        <!-- Grid of Sorted Recommended Extracurriculars -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($ekskuls as $index => $ekskul)
                <x-ui.ekskul-card 
                    name="{{ $ekskul['name'] }}"
                    match="{{ $ekskul['match'] }}"
                    description="{{ $ekskul['description'] }}"
                    image="{{ $ekskul['image'] }}"
                    route="{{ route('siswa.ekskul.show', $index + 1) }}"
                />
            @endforeach
        </div>

    </x-ui.card>
@endsection
