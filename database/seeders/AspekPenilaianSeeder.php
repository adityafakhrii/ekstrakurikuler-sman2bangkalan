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
                'kode' => 'FISIK',
                'nama' => 'Fisik',
                'deskripsi' => 'Kemampuan fisik dan ketangkasan.',
                'urutan' => 1,
            ],
            [
                'kode' => 'ESTETIKA',
                'nama' => 'Estetika',
                'deskripsi' => 'Kemampuan seni dan estetika.',
                'urutan' => 2,
            ],
            [
                'kode' => 'KOMUNIKASI',
                'nama' => 'Komunikasi',
                'deskripsi' => 'Kemampuan berkomunikasi.',
                'urutan' => 3,
            ],
            [
                'kode' => 'KREATIVITAS',
                'nama' => 'Kreativitas',
                'deskripsi' => 'Kemampuan kreativitas dan ide baru.',
                'urutan' => 4,
            ],
            [
                'kode' => 'DISIPLIN',
                'nama' => 'Disiplin',
                'deskripsi' => 'Kedisiplinan dan mental.',
                'urutan' => 5,
            ],
            [
                'kode' => 'KEKOMPAKAN',
                'nama' => 'Kekompakan',
                'deskripsi' => 'Kerja sama dan kekompakan tim.',
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

        // Definisi bobot per ekskul (sesuai contoh gambar, skala 1-5)
        // Format: [ slug_ekskul => [ KODE_ASPEK => bobot ] ]
        $bobotEkskul = [
            'paduan-suara' => [
                'FISIK' => 2,
                'ESTETIKA' => 5,
                'KOMUNIKASI' => 4,
                'KREATIVITAS' => 3,
                'DISIPLIN' => 3,
                'KEKOMPAKAN' => 4,
            ],
            'pramuka' => [
                'FISIK' => 4,
                'ESTETIKA' => 2,
                'KOMUNIKASI' => 3,
                'KREATIVITAS' => 2,
                'DISIPLIN' => 5,
                'KEKOMPAKAN' => 5,
            ],
            'basket' => [
                'FISIK' => 5,
                'ESTETIKA' => 2,
                'KOMUNIKASI' => 3,
                'KREATIVITAS' => 2,
                'DISIPLIN' => 4,
                'KEKOMPAKAN' => 4,
            ],
            'teater' => [
                'FISIK' => 1,
                'ESTETIKA' => 5,
                'KOMUNIKASI' => 5,
                'KREATIVITAS' => 5,
                'DISIPLIN' => 3,
                'KEKOMPAKAN' => 3,
            ],
            // Anda bisa tambahkan ekskul lain di sini
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
