<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AspekPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $aspek = [
            [
                'kode' => 'KETANGKASAN',
                'nama' => 'Ketangkasan',
                'deskripsi' => 'Kemampuan fisik dan ketangkasan.',
                'urutan' => 1,
            ],
            [
                'kode' => 'INTELEKTUAL',
                'nama' => 'Intelektual',
                'deskripsi' => 'Kemampuan berfikir dan analisis intelektual.',
                'urutan' => 2,
            ],
            [
                'kode' => 'SOSIAL',
                'nama' => 'Sosial',
                'deskripsi' => 'Kemampuan bersosialisasi dan interaksi sosial.',
                'urutan' => 3,
            ],
            [
                'kode' => 'KREATIVITAS',
                'nama' => 'Kreativitas',
                'deskripsi' => 'Kemampuan kreativitas dan ide baru.',
                'urutan' => 4,
            ],
            [
                'kode' => 'KEDISIPLINAN',
                'nama' => 'Kedisiplinan',
                'deskripsi' => 'Tingkat kedisiplinan dan kepatuhan aturan.',
                'urutan' => 5,
            ],
            [
                'kode' => 'KOMUNIKASI',
                'nama' => 'Komunikasi',
                'deskripsi' => 'Kemampuan komunikasi dan kerja sama.',
                'urutan' => 6,
            ],
        ];

        foreach ($aspek as $item) {
            DB::table('aspek_penilaian')->updateOrInsert(
                ['kode' => $item['kode']],
                array_merge($item, [
                    'is_aktif' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // Setelah aspek dibuat, isi bobot aspek per ekskul
        $this->seedEkskulAspek();

        $this->command->info('✅ Aspek penilaian seeded: '.count($aspek).' aspek');
    }

    private function seedEkskulAspek(): void
    {
        // Ambil ID aspek
        $aspekIds = DB::table('aspek_penilaian')->pluck('id', 'kode');
        $ekskulIds = DB::table('ekstrakurikuler')->pluck('id', 'slug');

        // Definisi bobot per ekskul (skala 1-5)
        // Format: [ slug_ekskul => [ KODE_ASPEK => bobot ] ]
        $bobotEkskul = [
            // Paduan Suara — dominan estetika & komunikasi, fisik rendah
            'paduan-suara' => [
                'KETANGKASAN' => 2,
                'INTELEKTUAL' => 5,
                'SOSIAL'      => 4,
                'KREATIVITAS' => 3,
                'KEDISIPLINAN'=> 3,
                'KOMUNIKASI'  => 4,
            ],
            // Pramuka — fisik & disiplin tinggi, kekompakan kuat
            'pramuka' => [
                'KETANGKASAN' => 4,
                'INTELEKTUAL' => 2,
                'SOSIAL'      => 3,
                'KREATIVITAS' => 2,
                'KEDISIPLINAN'=> 5,
                'KOMUNIKASI'  => 5,
            ],
            // Basket — fisik paling tinggi, kekompakan & disiplin penting
            'basket' => [
                'KETANGKASAN' => 5,
                'INTELEKTUAL' => 2,
                'SOSIAL'      => 3,
                'KREATIVITAS' => 2,
                'KEDISIPLINAN'=> 4,
                'KOMUNIKASI'  => 4,
            ],
            // Teater — estetika, komunikasi, kreativitas sangat tinggi
            'teater' => [
                'KETANGKASAN' => 1,
                'INTELEKTUAL' => 5,
                'SOSIAL'      => 5,
                'KREATIVITAS' => 5,
                'KEDISIPLINAN'=> 3,
                'KOMUNIKASI'  => 3,
            ],
            // OSIS — komunikasi & kekompakan utama, disiplin tinggi
            'osis' => [
                'KETANGKASAN' => 1,
                'INTELEKTUAL' => 2,
                'SOSIAL'      => 5,
                'KREATIVITAS' => 3,
                'KEDISIPLINAN'=> 4,
                'KOMUNIKASI'  => 5,
            ],
            // PMR — disiplin & kekompakan tinggi, komunikasi penting
            'pmr' => [
                'KETANGKASAN' => 3,
                'INTELEKTUAL' => 1,
                'SOSIAL'      => 4,
                'KREATIVITAS' => 2,
                'KEDISIPLINAN'=> 5,
                'KOMUNIKASI'  => 5,
            ],
            // Robotik — kreativitas sangat tinggi, disiplin & komunikasi penting
            'robotik' => [
                'KETANGKASAN' => 1,
                'INTELEKTUAL' => 2,
                'SOSIAL'      => 3,
                'KREATIVITAS' => 5,
                'KEDISIPLINAN'=> 4,
                'KOMUNIKASI'  => 3,
            ],
            // English Club — komunikasi paling utama, kreativitas tinggi
            'english-club' => [
                'KETANGKASAN' => 1,
                'INTELEKTUAL' => 2,
                'SOSIAL'      => 5,
                'KREATIVITAS' => 4,
                'KEDISIPLINAN'=> 3,
                'KOMUNIKASI'  => 3,
            ],
        ];

        $inserts = [];
        foreach ($bobotEkskul as $slug => $aspekBobot) {
            if (! isset($ekskulIds[$slug])) {
                continue;
            }
            $ekskulId = $ekskulIds[$slug];

            foreach ($aspekBobot as $kode => $bobot) {
                if (! isset($aspekIds[$kode])) {
                    continue;
                }
                $inserts[] = [
                    'ekstrakurikuler_id' => $ekskulId,
                    'aspek_penilaian_id' => $aspekIds[$kode],
                    'bobot' => $bobot,
                ];
            }
        }

        // Hapus lama, masukkan baru
        DB::table('ekskul_aspek')->truncate();
        DB::table('ekskul_aspek')->insert($inserts);

        $this->command->info('✅ Bobot ekskul_aspek seeded: '.count($inserts).' entri');
    }
}
