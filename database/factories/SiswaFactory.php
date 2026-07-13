<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        $nis = fake()->unique()->numerify('######');
        $nisn = fake()->unique()->numerify('##########');

        return [
            'user_id' => User::factory()->siswa(),
            'nis' => $nis,
            'nisn' => $nisn,
            'kelas' => fake()->randomElement(['X', 'XI', 'XII']),
            'rombel' => fake()->randomElement(['X MIPA 1', 'XI IPS 2', 'XII MIPA 3']),
            'jurusan' => fake()->randomElement(['MIPA', 'IPS']),
            'no_telp' => fake()->phoneNumber(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tahun_masuk' => fake()->randomElement(['2023', '2024', '2025']),
        ];
    }
}
