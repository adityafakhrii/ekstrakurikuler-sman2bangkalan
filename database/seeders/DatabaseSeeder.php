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
            ['Akun', 'Email', 'Password'],
            [
                ['Admin',              'admin@sman2bangkalan.sch.id',     'password'],
                ['Ketua OSIS',         'ketua.osis@sman2bangkalan.sch.id','password'],
                ['Ketua Pramuka',      'ketua.pramuka@sman2bangkalan.sch.id','password'],
                ['Ketua Basket',       'ketua.basket@sman2bangkalan.sch.id','password'],
                ['Ketua PMR',          'ketua.pmr@sman2bangkalan.sch.id','password'],
                ['Ketua Paduan Suara', 'ketua.paduan@sman2bangkalan.sch.id','password'],
            ]
        );
    }
}
