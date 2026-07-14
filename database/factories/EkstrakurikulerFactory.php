<?php

namespace Database\Factories;

use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EkstrakurikulerFactory extends Factory
{
    protected $model = Ekstrakurikuler::class;

    public function definition(): array
    {
        $nama = fake()->unique()->words(2, true);

        return [
            'ketua_id' => User::factory()->ketua(),
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'deskripsi' => fake()->paragraph(),
            'logo' => null,
            'kuota' => config('ekskul.kuota_default'),
            'kategori' => fake()->randomElement(['Olahraga', 'Seni', 'Akademik', 'Kemanusiaan']),
            'pembina' => fake()->name(),
            'whatsapp_group' => null,
            'jadwal' => fake()->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']) . ', 14:30 - 16:30 WIB',
            'tahun_ajaran' => config('ekskul.tahun_ajaran'),
        ];
    }
}
