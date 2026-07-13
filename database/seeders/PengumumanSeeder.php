<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $ekskulOsis = Ekstrakurikuler::where('slug', 'osis')->first();
        $ekskulPramuka = Ekstrakurikuler::where('slug', 'pramuka')->first();

        if ($ekskulOsis) {
            DB::table('pengumuman')->insert([
                [
                    'ekstrakurikuler_id' => $ekskulOsis->id,
                    'judul' => 'Rapat Koordinasi Pengurus OSIS',
                    'isi' => 'Diberitahukan kepada seluruh pengurus OSIS untuk menghadiri rapat koordinasi program kerja bulanan pada hari Jumat pukul 14:00 di ruang OSIS.',
                    'is_published' => true,
                    'dibuat_oleh' => $ekskulOsis->ketua_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'ekstrakurikuler_id' => $ekskulOsis->id,
                    'judul' => 'Pendaftaran LDKS 2026',
                    'isi' => 'Persiapan Latihan Dasar Kepemimpinan Siswa (LDKS) akan segera dimulai. Silakan persiapkan berkas dan kesehatan fisik.',
                    'is_published' => true,
                    'dibuat_oleh' => $ekskulOsis->ketua_id,
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(5),
                ]
            ]);
        }

        if ($ekskulPramuka) {
            DB::table('pengumuman')->insert([
                [
                    'ekstrakurikuler_id' => $ekskulPramuka->id,
                    'judul' => 'Kemah Bhakti Semester Genap',
                    'isi' => 'Seluruh anggota Pramuka penegak wajib mengikuti Kemah Bhakti Semester Genap yang akan dilaksanakan pada akhir bulan ini.',
                    'is_published' => true,
                    'dibuat_oleh' => $ekskulPramuka->ketua_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        $this->command->info('✅ Pengumuman seeded: 3 entri');
    }
}
