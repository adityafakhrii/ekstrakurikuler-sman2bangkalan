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
                'kode'      => 'FISIK',
                'nama'      => 'Kemampuan Fisik',
                'deskripsi' => 'Seberapa baik kemampuan fisik dan kebugaran tubuh Anda (kekuatan, kecepatan, daya tahan).',
                'urutan'    => 1,
            ],
            [
                'kode'      => 'SENI',
                'nama'      => 'Minat Seni & Kreativitas',
                'deskripsi' => 'Seberapa besar minat Anda di bidang seni, musik, suara, atau ekspresi kreatif.',
                'urutan'    => 2,
            ],
            [
                'kode'      => 'SOSIAL',
                'nama'      => 'Kemampuan Sosial & Kepemimpinan',
                'deskripsi' => 'Seberapa nyaman Anda berinteraksi dengan banyak orang, memimpin, dan berorganisasi.',
                'urutan'    => 3,
            ],
            [
                'kode'      => 'AKADEMIK',
                'nama'      => 'Kemampuan Akademik & Intelektual',
                'deskripsi' => 'Seberapa besar minat Anda terhadap ilmu pengetahuan, riset, dan belajar hal baru.',
                'urutan'    => 4,
            ],
            [
                'kode'      => 'TEKNOLOGI',
                'nama'      => 'Minat Teknologi',
                'deskripsi' => 'Seberapa besar ketertarikan Anda dengan teknologi, komputer, elektronika, atau robotika.',
                'urutan'    => 5,
            ],
            [
                'kode'      => 'BAHASA',
                'nama'      => 'Kemampuan Bahasa',
                'deskripsi' => 'Seberapa baik kemampuan berbahasa Anda, terutama bahasa asing dan komunikasi verbal.',
                'urutan'    => 6,
            ],
            [
                'kode'      => 'SOSIAL_HUMANIORA',
                'nama'      => 'Kepedulian Sosial & Kemanusiaan',
                'deskripsi' => 'Seberapa besar kepedulian Anda terhadap sesama, lingkungan, dan kegiatan sosial.',
                'urutan'    => 7,
            ],
        ];

        foreach ($aspek as $item) {
            DB::table('aspek_penilaian')->updateOrInsert(
                ['kode' => $item['kode']],
                array_merge($item, [
                    'is_aktif'   => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // Setelah aspek dibuat, isi bobot aspek per ekskul
        $this->seedEkskulAspek();

        $this->command->info('✅ Aspek penilaian seeded: ' . count($aspek) . ' aspek');
    }

    private function seedEkskulAspek(): void
    {
        // Ambil ID aspek
        $aspekIds = DB::table('aspek_penilaian')->pluck('id', 'kode');
        $ekskulIds = DB::table('ekstrakurikuler')->pluck('id', 'slug');

        // Definisi bobot per ekskul (total bobot sebaiknya = 100)
        // Format: [ slug_ekskul => [ KODE_ASPEK => bobot ] ]
        $bobotEkskul = [
            'osis' => [
                'SOSIAL'          => 40,
                'AKADEMIK'        => 25,
                'BAHASA'          => 20,
                'FISIK'           => 5,
                'SENI'            => 5,
                'TEKNOLOGI'       => 3,
                'SOSIAL_HUMANIORA'=> 2,
            ],
            'pramuka' => [
                'FISIK'           => 35,
                'SOSIAL'          => 25,
                'SOSIAL_HUMANIORA'=> 20,
                'AKADEMIK'        => 10,
                'SENI'            => 5,
                'BAHASA'          => 3,
                'TEKNOLOGI'       => 2,
            ],
            'basket' => [
                'FISIK'           => 60,
                'SOSIAL'          => 20,
                'AKADEMIK'        => 5,
                'SENI'            => 5,
                'BAHASA'          => 5,
                'TEKNOLOGI'       => 3,
                'SOSIAL_HUMANIORA'=> 2,
            ],
            'pmr' => [
                'SOSIAL_HUMANIORA'=> 35,
                'AKADEMIK'        => 25,
                'FISIK'           => 20,
                'SOSIAL'          => 10,
                'SENI'            => 5,
                'BAHASA'          => 3,
                'TEKNOLOGI'       => 2,
            ],
            'paduan-suara' => [
                'SENI'            => 60,
                'BAHASA'          => 15,
                'SOSIAL'          => 15,
                'AKADEMIK'        => 5,
                'FISIK'           => 3,
                'TEKNOLOGI'       => 1,
                'SOSIAL_HUMANIORA'=> 1,
            ],
            'robotik' => [
                'TEKNOLOGI'       => 55,
                'AKADEMIK'        => 30,
                'SOSIAL'          => 7,
                'FISIK'           => 3,
                'BAHASA'          => 3,
                'SENI'            => 1,
                'SOSIAL_HUMANIORA'=> 1,
            ],
            'english-club' => [
                'BAHASA'          => 55,
                'AKADEMIK'        => 25,
                'SOSIAL'          => 12,
                'SENI'            => 3,
                'FISIK'           => 2,
                'TEKNOLOGI'       => 2,
                'SOSIAL_HUMANIORA'=> 1,
            ],
        ];

        $inserts = [];
        foreach ($bobotEkskul as $slug => $aspekBobot) {
            if (!isset($ekskulIds[$slug])) continue;
            $ekskulId = $ekskulIds[$slug];

            foreach ($aspekBobot as $kode => $bobot) {
                if (!isset($aspekIds[$kode])) continue;
                $inserts[] = [
                    'ekstrakurikuler_id' => $ekskulId,
                    'aspek_penilaian_id' => $aspekIds[$kode],
                    'bobot'              => $bobot,
                ];
            }
        }

        // Hapus lama, masukkan baru
        DB::table('ekskul_aspek')->truncate();
        DB::table('ekskul_aspek')->insert($inserts);

        $this->command->info('✅ Bobot ekskul_aspek seeded: ' . count($inserts) . ' entri');
    }
}
