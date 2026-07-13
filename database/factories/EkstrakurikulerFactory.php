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
            'status' => 'aktif',
            'hari_latihan' => fake()->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']),
            'jam_mulai' => '14:30:00',
            'jam_selesai' => '16:30:00',
            'lokasi' => 'Aula Sekolah',
            'tahun_ajaran' => config('ekskul.tahun_ajaran'),
            'persyaratan' => fake()->sentence(),
        ];
    }
}
