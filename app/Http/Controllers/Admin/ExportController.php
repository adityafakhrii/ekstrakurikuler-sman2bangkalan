<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Export data siswa ke CSV.
     */
    public function exportSiswa(): StreamedResponse
    {
        $siswas = Siswa::with('user')->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-siswa-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($siswas) {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'NIS', 'NISN', 'Nama Siswa', 'Kelas', 'Rombel', 'Jurusan', 'JK', 'No HP', 'Tahun Masuk']);

            // Data
            foreach ($siswas as $index => $siswa) {
                fputcsv($file, [
                    $index + 1,
                    $siswa->nis,
                    $siswa->nisn,
                    $siswa->user->name,
                    $siswa->kelas,
                    $siswa->rombel,
                    $siswa->jurusan,
                    $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                    $siswa->no_telp,
                    $siswa->tahun_masuk,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export data ketua ke CSV.
     */
    public function exportKetua(): StreamedResponse
    {
        $ketuas = User::where('role', 'ketua')
            ->with('ekstrakurikuler')
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-ketua-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($ketuas) {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'Nama', 'Email', 'Username', 'Ekskul', 'Terdaftar']);

            // Data
            foreach ($ketuas as $index => $ketua) {
                fputcsv($file, [
                    $index + 1,
                    $ketua->name,
                    $ketua->email,
                    $ketua->username,
                    $ketua->ekstrakurikuler?->nama ?? '-',
                    $ketua->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export data pendaftaran ke CSV.
     */
    public function exportPendaftaran(): StreamedResponse
    {
        $pendaftarans = Pendaftaran::with(['siswa.user', 'ekstrakurikuler'])
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-pendaftaran-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($pendaftarans) {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'Nama Siswa', 'NISN', 'Ekskul', 'Tanggal Daftar', 'Status', 'Catatan Ketua']);

            // Data
            foreach ($pendaftarans as $index => $p) {
                fputcsv($file, [
                    $index + 1,
                    $p->siswa?->user?->name ?? '-',
                    $p->siswa?->nisn ?? '-',
                    $p->ekstrakurikuler?->nama ?? '-',
                    $p->created_at->format('d/m/Y H:i'),
                    ucfirst($p->status),
                    $p->catatan_ketua ?? '-',
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export data ekskul ke CSV.
     */
    public function exportEkskul(): StreamedResponse
    {
        $ekskuls = Ekstrakurikuler::with('ketua')->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-ekskul-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($ekskuls) {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'Nama Ekskul', 'Kategori', 'Ketua', 'Kuota', 'Hari', 'Jam', 'Lokasi', 'Status']);

            // Data
            foreach ($ekskuls as $index => $e) {
                fputcsv($file, [
                    $index + 1,
                    $e->nama,
                    $e->kategori,
                    $e->ketua?->name ?? '-',
                    $e->kuota,
                    $e->hari_latihan,
                    ($e->jam_mulai ? substr($e->jam_mulai, 0, 5) : '-') . ' - ' . ($e->jam_selesai ? substr($e->jam_selesai, 0, 5) : '-'),
                    $e->lokasi,
                    ucfirst($e->status),
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
