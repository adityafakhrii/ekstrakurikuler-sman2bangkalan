<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // ADMIN
        // =====================
        User::firstOrCreate(
            ['email' => 'admin@sman2bangkalan.sch.id'],
            [
                'name'              => 'Administrator',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // =====================
        // KETUA EKSKUL (contoh)
        // =====================
        $ketuaData = [
            ['name' => 'Ketua OSIS',         'email' => 'ketua.osis@sman2bangkalan.sch.id'],
            ['name' => 'Ketua Pramuka',       'email' => 'ketua.pramuka@sman2bangkalan.sch.id'],
            ['name' => 'Ketua Basket',        'email' => 'ketua.basket@sman2bangkalan.sch.id'],
            ['name' => 'Ketua PMR',           'email' => 'ketua.pmr@sman2bangkalan.sch.id'],
            ['name' => 'Ketua Paduan Suara',  'email' => 'ketua.paduan@sman2bangkalan.sch.id'],
        ];

        foreach ($ketuaData as $ketua) {
            User::firstOrCreate(
                ['email' => $ketua['email']],
                [
                    'name'              => $ketua['name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'ketua',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Users seeded: 1 admin, ' . count($ketuaData) . ' ketua');
    }
}
