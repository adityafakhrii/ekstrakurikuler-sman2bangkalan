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
        $siswas = Siswa::with('user')->orderBy('id')->get();
        $ekskuls = Ekstrakurikuler::orderBy('id')->get();

        if ($siswas->isEmpty() || $ekskuls->isEmpty()) {
            $this->command->warn('⚠️ PendaftaranSeeder dilewati: siswa atau ekskul belum tersedia.');
            return;
        }

        $tahunAjaran = config('ekskul.tahun_ajaran');
        $statusList = ['menunggu', 'disetujui', 'ditolak', 'dibatalkan'];
        $catatanSiswa = [
            'Saya ingin mengembangkan kemampuan dan pengalaman organisasi.',
            'Saya tertarik mengikuti kegiatan ini sejak SMP.',
            'Saya ingin menambah teman, disiplin, dan keterampilan baru.',
            'Saya ingin berkontribusi aktif dalam kegiatan ekstrakurikuler.',
            'Saya ingin meningkatkan rasa percaya diri dan kerja sama tim.',
        ];

        $targetEkskul = $ekskuls->firstWhere('slug', 'pramuka') ?? $ekskuls->first();

        foreach ($siswas->take(50) as $index => $siswa) {
            $status = $statusList[$index % count($statusList)];
            $isFinal = in_array($status, ['disetujui', 'ditolak'], true);

            Pendaftaran::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'ekstrakurikuler_id' => $targetEkskul->id,
                ],
                [
                    'tahun_ajaran' => $tahunAjaran,
                    'status' => $status,
                    'catatan_siswa' => $catatanSiswa[$index % count($catatanSiswa)],
                    'catatan_ketua' => match ($status) {
                        'disetujui' => 'Diterima, silakan mengikuti latihan rutin sesuai jadwal.',
                        'ditolak' => 'Belum dapat diterima karena kuota atau kriteria belum sesuai.',
                        'dibatalkan' => 'Pendaftaran dibatalkan oleh siswa.',
                        default => null,
                    },
                    'disetujui_at' => $isFinal ? now()->subDays($index % 14) : null,
                    'disetujui_oleh' => $isFinal ? $targetEkskul->ketua_id : null,
                    'created_at' => now()->subDays(60 - $index),
                    'updated_at' => now()->subDays($index % 7),
                ]
            );
        }

        foreach ($siswas->skip(10)->take(40) as $index => $siswa) {
            $ekskul = $ekskuls->get(($index + 1) % $ekskuls->count());
            if (!$ekskul || $ekskul->id === $targetEkskul->id) {
                continue;
            }

            $status = $statusList[($index + 1) % count($statusList)];
            $isFinal = in_array($status, ['disetujui', 'ditolak'], true);

            Pendaftaran::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'ekstrakurikuler_id' => $ekskul->id,
                ],
                [
                    'tahun_ajaran' => $tahunAjaran,
                    'status' => $status,
                    'catatan_siswa' => $catatanSiswa[($index + 2) % count($catatanSiswa)],
                    'catatan_ketua' => match ($status) {
                        'disetujui' => 'Diterima sebagai anggota '.$ekskul->nama.'.',
                        'ditolak' => 'Belum dapat diterima pada periode ini.',
                        'dibatalkan' => 'Pendaftaran dibatalkan oleh siswa.',
                        default => null,
                    },
                    'disetujui_at' => $isFinal ? now()->subDays($index % 10) : null,
                    'disetujui_oleh' => $isFinal ? $ekskul->ketua_id : null,
                    'created_at' => now()->subDays(40 - $index),
                    'updated_at' => now()->subDays($index % 6),
                ]
            );
        }

        $totalPendaftaran = Pendaftaran::count();
        $this->command->info('✅ Pendaftaran seeded: '.$totalPendaftaran.' entri dengan status campuran');
    }
}
