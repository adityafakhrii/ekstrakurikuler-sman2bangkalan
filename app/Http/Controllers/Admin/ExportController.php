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
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-siswa-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'NIS', 'NISN', 'Nama Siswa', 'Kelas', 'Rombel', 'Jurusan', 'JK', 'No HP', 'Tahun Masuk']);

            // Data — lazy() stream per record, hemat memory
            $index = 0;
            Siswa::select('id', 'user_id', 'nis', 'nisn', 'kelas', 'rombel', 'jurusan', 'jenis_kelamin', 'no_telp', 'tahun_masuk')
                ->with('user:id,name')
                ->latest()
                ->lazy()
                ->each(function ($siswa) use ($file, &$index) {
                    fputcsv($file, [
                        ++$index,
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
                });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export data ketua ke CSV.
     */
    public function exportKetua(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-ketua-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'Nama', 'Email', 'Username', 'Ekskul', 'Terdaftar']);

            // Data — lazy() stream per record
            $index = 0;
            User::where('role', 'ketua')
                ->select('id', 'name', 'email', 'username', 'created_at')
                ->with('ekstrakurikuler:id,ketua_id,nama')
                ->latest()
                ->lazy()
                ->each(function ($ketua) use ($file, &$index) {
                    fputcsv($file, [
                        ++$index,
                        $ketua->name,
                        $ketua->email,
                        $ketua->username,
                        $ketua->ekstrakurikuler?->nama ?? '-',
                        $ketua->created_at->format('d/m/Y'),
                    ]);
                });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export data pendaftaran ke CSV.
     */
    public function exportPendaftaran(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-pendaftaran-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'Nama Siswa', 'NISN', 'Ekskul', 'Tanggal Daftar', 'Status', 'Catatan Ketua']);

            // Data — lazy() stream per record
            $index = 0;
            Pendaftaran::select('id', 'siswa_id', 'ekstrakurikuler_id', 'status', 'catatan_ketua', 'created_at')
                ->with(['siswa:id,user_id,nisn' => ['user:id,name'], 'ekstrakurikuler:id,nama'])
                ->latest()
                ->lazy()
                ->each(function ($p) use ($file, &$index) {
                    fputcsv($file, [
                        ++$index,
                        $p->siswa?->user?->name ?? '-',
                        $p->siswa?->nisn ?? '-',
                        $p->ekstrakurikuler?->nama ?? '-',
                        $p->created_at->format('d/m/Y H:i'),
                        ucfirst($p->status),
                        $p->catatan_ketua ?? '-',
                    ]);
                });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export data ekskul ke CSV.
     */
    public function exportEkskul(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-ekskul-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['No', 'Nama Ekskul', 'Kategori', 'Ketua', 'Kuota', 'Hari', 'Jam', 'Lokasi', 'Status']);

            // Data — lazy() stream per record
            $index = 0;
            Ekstrakurikuler::select('id', 'ketua_id', 'nama', 'kategori', 'kuota', 'hari_latihan', 'jam_mulai', 'jam_selesai', 'lokasi', 'status')
                ->with('ketua:id,name')
                ->latest()
                ->lazy()
                ->each(function ($e) use ($file, &$index) {
                    fputcsv($file, [
                        ++$index,
                        $e->nama,
                        $e->kategori,
                        $e->ketua?->name ?? '-',
                        $e->kuota,
                        $e->hari_latihan,
                        ($e->jam_mulai ? substr($e->jam_mulai, 0, 5) : '-') . ' - ' . ($e->jam_selesai ? substr($e->jam_selesai, 0, 5) : '-'),
                        $e->lokasi,
                        ucfirst($e->status),
                    ]);
                });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
