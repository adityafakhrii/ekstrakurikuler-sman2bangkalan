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
                'name' => 'Administrator',
                'email' => 'admin@sman2bangkalan.sch.id',
                'password' => Hash::make(config('ekskul.password_default_siswa')),
                'role' => 'admin',
                'username' => 'admin',
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
                    'name' => $ketua['name'],
                    'email' => $ketua['email'],
                    'password' => Hash::make(config('ekskul.password_default_siswa')),
                    'role' => 'ketua',
                    'username' => $ketua['username'],
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
                ['username' => $data['nisn']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                    'email_verified_at' => now(),
                ]
            );

            Siswa::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => $data['nis'],
                    'nisn' => $data['nisn'],
                    'kelas' => $data['kelas'],
                    'rombel' => $data['rombel'],
                    'jurusan' => $data['jurusan'],
                    'no_telp' => $data['no_telp'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tahun_masuk' => $data['tahun_masuk'],
                ]
            );
        }

        $namaKetuaTambahan = [
            'Ketua Futsal', 'Ketua Voli', 'Ketua Badminton', 'Ketua Marching Band', 'Ketua Teater',
            'Ketua Tari Tradisional', 'Ketua Jurnalistik', 'Ketua Fotografi', 'Ketua Karya Ilmiah Remaja', 'Ketua Rohis',
            'Ketua Musik', 'Ketua Karate', 'Ketua Silat', 'Ketua Taekwondo', 'Ketua Renang',
            'Ketua Catur', 'Ketua Desain Grafis', 'Ketua Film Pendek', 'Ketua Pecinta Alam', 'Ketua Bahasa Jepang',
            'Ketua Bahasa Arab', 'Ketua Matematika Club', 'Ketua Sains Club', 'Ketua Coding Club', 'Ketua E-Sport',
            'Ketua Kewirausahaan', 'Ketua Green School', 'Ketua Debate Club', 'Ketua Public Speaking', 'Ketua Kaligrafi',
            'Ketua Hadrah', 'Ketua Drumband', 'Ketua Seni Lukis', 'Ketua Komik Digital', 'Ketua Broadcasting',
            'Ketua Literasi', 'Ketua Paskibra', 'Ketua Dokter Remaja', 'Ketua Astronomi', 'Ketua Ekonomi Club',
            'Ketua Geografi Club', 'Ketua Sejarah Club', 'Ketua Bulutangkis Putri', 'Ketua Basket Putri', 'Ketua Voli Putri',
        ];

        foreach ($namaKetuaTambahan as $index => $namaKetua) {
            $nomor = $index + 6;
            User::updateOrCreate(
                ['username' => 'ketua.dummy'.$nomor],
                [
                    'name' => $namaKetua,
                    'email' => 'ketua.dummy'.$nomor.'@sman2bangkalan.sch.id',
                    'password' => Hash::make(config('ekskul.password_default_siswa')),
                    'role' => 'ketua',
                    'email_verified_at' => now(),
                ]
            );
        }

        $namaSiswaTambahan = [
            'Bagaskara Putra Temanggu', 'Jailani Mustafa Jofi', 'Rosidiq Mas Luhutorno Erdan', 'Pratama Saifuddin Walid', 'Aisyah Syana Daru',
            'Dinda Putri Maysaroh', 'Kanato Fukudoru Mustopoh', 'Nadia Safira Ramadhani', 'Rizky Maulana Akbar', 'Putri Maharani',
            'Muhammad Farhan', 'Salsabila Nur Aini', 'Fikri Ramadhan', 'Naufal Rizqullah', 'Nabila Zahra',
            'Rafi Alfarizi', 'Aulia Fitriani', 'Dimas Aditya', 'Nadya Aprilia', 'Ilham Maulana',
            'Intan Permatasari', 'Yoga Pratama', 'Siti Nurhaliza', 'Rangga Saputra', 'Dewangga Arya',
            'Larasati Dewi', 'Bayu Nugroho', 'Anisa Rahmawati', 'Raka Wijaya', 'Citra Lestari',
            'Farel Andika', 'Dwi Anggraini', 'Maya Salsabila', 'Arif Hidayat', 'Niken Ayu',
            'Gilang Ramadhan', 'Vina Oktaviani', 'Reza Fahlevi', 'Tiara Maharani', 'Doni Saputra',
            'Febriansyah Putra', 'Silvi Nuraini', 'Aditya Prakoso', 'Riska Amelia', 'Hendra Gunawan',
            'Yuni Kartika', 'Rendi Saputra', 'Mila Karmila', 'Agus Setiawan', 'Nindy Prameswari',
        ];

        foreach ($namaSiswaTambahan as $index => $namaSiswa) {
            $nomor = $index + 4;
            $nisn = (string) (2120200 + $nomor);
            $user = User::updateOrCreate(
                ['username' => $nisn],
                [
                    'name' => $namaSiswa,
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                    'email_verified_at' => now(),
                ]
            );

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => (string) (120000 + $nomor),
                    'nisn' => $nisn,
                    'kelas' => ['X', 'XI', 'XII'][$index % 3],
                    'rombel' => ['X MIPA 1', 'XI MIPA 1', 'XII MIPA 1', 'X MIPA 1', 'XI IPS 1'][$index % 5],
                    'jurusan' => ['MIPA', 'MIPA', 'IPS', 'Bahasa'][$index % 4],
                    'no_telp' => '08123456'.str_pad((string) $nomor, 4, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => $index % 2 === 0 ? 'L' : 'P',
                    'tahun_masuk' => (string) (2024 - ($index % 3)),
                ]
            );
        }

        $siswaCount = Siswa::count();
        $ketuaCount = User::where('role', 'ketua')->count();
        $this->command->info("✅ Users seeded: 1 admin, {$ketuaCount} ketua, {$siswaCount} siswa");
    }
}
