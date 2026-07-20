<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan penting: parent sebelum child (FK constraint).
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,            // 1. Users (admin, ketua)
            EkstrakurikulerSeeder::class, // 2. Ekskul (FK ke users)
            AspekPenilaianSeeder::class,  // 3. Aspek & bobot (FK ke ekskul)
            PendaftaranSeeder::class,
            RekomendasiSeeder::class,
            PengumumanSeeder::class,
        ]);

        \Illuminate\Support\Facades\DB::table('pengaturan')->updateOrInsert(
            ['key' => 'auto_delete_rekomendasi'],
            ['value' => '30', 'created_at' => now(), 'updated_at' => now()]
        );

        $this->command->newLine();
        $this->command->info('🎉 Database seeding selesai!');
        $this->command->table(
            ['Akun', 'Username / NIS', 'Role', 'Password'],
            [
                ['Administrator',    'admin',          'Admin',  'password'],
                ['Ketua OSIS',       'ketua.osis',     'Ketua',  'password'],
                ['Ketua Pramuka',    'ketua.pramuka',  'Ketua',  'password'],
                ['Ketua Basket',     'ketua.basket',   'Ketua',  'password'],
                ['Ketua PMR',        'ketua.pmr',      'Ketua',  'password'],
                ['Ketua Paduan Suara', 'ketua.paduan',  'Ketua',  'password'],
                ['Ahmad Jihaduddin', '120001',        'Siswa',  'password'],
                ['Saiful Bahri',     '120002',        'Siswa',  'password'],
                ['Dewi Sartika',     '120003',        'Siswa',  'password'],
            ]
        );
    }
}
