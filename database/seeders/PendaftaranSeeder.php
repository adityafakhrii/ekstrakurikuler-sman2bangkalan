<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = Siswa::all();
        $ekskuls = Ekstrakurikuler::all();

        if ($siswas->isEmpty() || $ekskuls->isEmpty()) {
            return;
        }

        // Ahmad Jihaduddin mendaftar ke OSIS dan Basket
        $siswa1 = $siswas->first();
        $ekskulOsis = $ekskuls->where('slug', 'osis')->first();
        $ekskulBasket = $ekskuls->where('slug', 'basket')->first();

        if ($ekskulOsis) {
            Pendaftaran::firstOrCreate(
                [
                    'siswa_id' => $siswa1->id,
                    'ekstrakurikuler_id' => $ekskulOsis->id,
                    'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                ],
                [
                    'status' => 'disetujui',
                    'catatan_siswa' => 'Saya ingin belajar kepemimpinan dan berorganisasi.',
                    'catatan_ketua' => 'Selamat bergabung di OSIS!',
                    'disetujui_at' => now(),
                    'disetujui_oleh' => $ekskulOsis->ketua_id,
                ]
            );
        }

        if ($ekskulBasket) {
            Pendaftaran::firstOrCreate(
                [
                    'siswa_id' => $siswa1->id,
                    'ekstrakurikuler_id' => $ekskulBasket->id,
                    'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                ],
                [
                    'status' => 'menunggu',
                    'catatan_siswa' => 'Saya hobi bermain basket sejak SMP.',
                ]
            );
        }

        // Saiful Bahri mendaftar ke Pramuka (disetujui) dan PMR (ditolak)
        $siswa2 = $siswas->skip(1)->first();
        $ekskulPramuka = $ekskuls->where('slug', 'pramuka')->first();
        $ekskulPmr = $ekskuls->where('slug', 'pmr')->first();

        if ($siswa2) {
            if ($ekskulPramuka) {
                Pendaftaran::firstOrCreate(
                    [
                        'siswa_id' => $siswa2->id,
                        'ekstrakurikuler_id' => $ekskulPramuka->id,
                        'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                    ],
                    [
                        'status' => 'disetujui',
                        'catatan_siswa' => 'Pramuka adalah kewajiban dan hobi saya.',
                        'catatan_ketua' => 'Diterima, silakan datang latihan rutin.',
                        'disetujui_at' => now(),
                        'disetujui_oleh' => $ekskulPramuka->ketua_id,
                    ]
                );
            }

            if ($ekskulPmr) {
                Pendaftaran::firstOrCreate(
                    [
                        'siswa_id' => $siswa2->id,
                        'ekstrakurikuler_id' => $ekskulPmr->id,
                        'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                    ],
                    [
                        'status' => 'ditolak',
                        'catatan_siswa' => 'Tertarik dengan kesehatan.',
                        'catatan_ketua' => 'Kuota PMR untuk tahun ajaran ini sudah penuh.',
                        'disetujui_at' => now(),
                        'disetujui_oleh' => $ekskulPmr->ketua_id,
                    ]
                );
            }
        }

        $this->command->info('✅ Pendaftaran seeded: 4 entri');
    }
}
