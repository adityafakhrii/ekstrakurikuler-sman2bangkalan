<?php

namespace Database\Seeders;

use App\Models\Rekomendasi;
use App\Models\RekomendasiHasil;
use App\Models\Siswa;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;

class RekomendasiSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = Siswa::all();
        $ekskuls = Ekstrakurikuler::get();

        if ($siswas->isEmpty() || $ekskuls->isEmpty()) {
            return;
        }

        foreach ($siswas as $siswa) {
            // Seed jawaban simulasi
            $jawaban = [
                'fisik' => rand(1, 5),
                'intelektual' => rand(1, 5),
                'kreativitas' => rand(1, 5),
                'sosial' => rand(1, 5),
                'mental' => rand(1, 5),
                'komunikasi' => rand(1, 5),
            ];

            $rekomendasi = Rekomendasi::create([
                'siswa_id' => $siswa->id,
                'jawaban' => $jawaban,
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
            ]);

            // Buat hasil rekomendasi dummy untuk ekskul yang ada
            $peringkat = 1;
            foreach ($ekskuls as $ekskul) {
                RekomendasiHasil::create([
                    'rekomendasi_id' => $rekomendasi->id,
                    'ekstrakurikuler_id' => $ekskul->id,
                    'skor' => rand(60, 98) + (rand(0, 99) / 100),
                    'peringkat' => $peringkat++,
                ]);
            }
        }

        $this->command->info('✅ Rekomendasi & hasil seeded untuk semua siswa');
    }
}
