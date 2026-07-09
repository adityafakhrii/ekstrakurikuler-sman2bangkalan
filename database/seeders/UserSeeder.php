<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // ADMIN
        // =====================
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name'              => 'Administrator',
                'email'             => 'admin@sman2bangkalan.sch.id',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'username'          => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // =====================
        // KETUA EKSKUL (contoh)
        // =====================
        $ketuaData = [
            ['name' => 'Ketua OSIS',         'username' => 'ketua.osis',         'email' => 'ketua.osis@sman2bangkalan.sch.id'],
            ['name' => 'Ketua Pramuka',      'username' => 'ketua.pramuka',      'email' => 'ketua.pramuka@sman2bangkalan.sch.id'],
            ['name' => 'Ketua Basket',       'username' => 'ketua.basket',       'email' => 'ketua.basket@sman2bangkalan.sch.id'],
            ['name' => 'Ketua PMR',          'username' => 'ketua.pmr',          'email' => 'ketua.pmr@sman2bangkalan.sch.id'],
            ['name' => 'Ketua Paduan Suara', 'username' => 'ketua.paduan',       'email' => 'ketua.paduan@sman2bangkalan.sch.id'],
        ];

        foreach ($ketuaData as $ketua) {
            User::firstOrCreate(
                ['username' => $ketua['username']],
                [
                    'name'              => $ketua['name'],
                    'email'             => $ketua['email'],
                    'password'          => Hash::make('password'),
                    'role'              => 'ketua',
                    'username'          => $ketua['username'],
                    'email_verified_at' => now(),
                ]
            );
        }

        // =====================
        // SISWA (contoh)
        // =====================
        $siswaData = [
            ['name' => 'Ahmad Jihaduddin', 'nis' => '120001', 'nisn' => '2120202', 'kelas' => 'X',   'rombel' => 'X MIPA 1',  'jurusan' => 'MIPA',   'no_telp' => '081234567890', 'jenis_kelamin' => 'L', 'tahun_masuk' => '2024'],
            ['name' => 'Saiful Bahri',     'nis' => '120002', 'nisn' => '2120203', 'kelas' => 'XI',  'rombel' => 'XI IPS 1',  'jurusan' => 'IPS',    'no_telp' => '081234567891', 'jenis_kelamin' => 'L', 'tahun_masuk' => '2023'],
            ['name' => 'Dewi Sartika',     'nis' => '120003', 'nisn' => '2120204', 'kelas' => 'XII', 'rombel' => 'XII IPA 2', 'jurusan' => 'MIPA',   'no_telp' => '081234567892', 'jenis_kelamin' => 'P', 'tahun_masuk' => '2022'],
        ];

        foreach ($siswaData as $data) {
            $user = User::firstOrCreate(
                ['nisn' => $data['nisn']],
                [
                    'name'              => $data['name'],
                    'nisn'              => $data['nisn'],
                    'no_hp'             => $data['no_telp'],
                    'password'          => Hash::make('password'),
                    'role'              => 'siswa',
                    'email_verified_at' => now(),
                ]
            );

            Siswa::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nis'           => $data['nis'],
                    'nisn'          => $data['nisn'],
                    'kelas'         => $data['kelas'],
                    'rombel'        => $data['rombel'],
                    'jurusan'       => $data['jurusan'],
                    'no_telp'       => $data['no_telp'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tahun_masuk'   => $data['tahun_masuk'],
                ]
            );
        }

        $siswaCount = count($siswaData);
        $ketuaCount = count($ketuaData);
        $this->command->info("? Users seeded: 1 admin, {$ketuaCount} ketua, {$siswaCount} siswa");
    }
}
