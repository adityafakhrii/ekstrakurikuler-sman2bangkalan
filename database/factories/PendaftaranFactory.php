<?php

namespace Database\Factories;

use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendaftaranFactory extends Factory
{
    protected $model = Pendaftaran::class;

    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'ekstrakurikuler_id' => Ekstrakurikuler::factory(),
            'tahun_ajaran' => config('ekskul.tahun_ajaran'),
            'status' => fake()->randomElement(['menunggu', 'disetujui', 'ditolak', 'dibatalkan']),
            'catatan_siswa' => fake()->sentence(),
            'catatan_ketua' => fake()->sentence(),
            'disetujui_by' => User::factory()->admin(),
            'disetujui_at' => now(),
        ];
    }
}
