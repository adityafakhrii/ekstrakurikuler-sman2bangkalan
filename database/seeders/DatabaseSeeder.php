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
        ]);

        $this->command->newLine();
        $this->command->info('🎉 Database seeding selesai!');
        $this->command->table(
            ['Akun', 'Username / NISN', 'Role', 'Password'],
            [
                ['Administrator',    'admin',          'Admin',  'password'],
                ['Ketua OSIS',       'ketua.osis',     'Ketua',  'password'],
                ['Ketua Pramuka',    'ketua.pramuka',  'Ketua',  'password'],
                ['Ketua Basket',     'ketua.basket',   'Ketua',  'password'],
                ['Ketua PMR',        'ketua.pmr',      'Ketua',  'password'],
                ['Ketua Paduan Suara','ketua.paduan',  'Ketua',  'password'],
                ['Ahmad Jihaduddin', '2120202',        'Siswa',  'password'],
                ['Saiful Bahri',     '2120203',        'Siswa',  'password'],
                ['Dewi Sartika',     '2120204',        'Siswa',  'password'],
            ]
        );
    }
}
