<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     * Optimasi: 7 query → 2 query + cache 15 menit.
     */
    public function index(): View
    {
        $stats = Cache::remember('admin.dashboard.stats', now()->addMinutes(15), function () {
            $entityCounts = [
                'total_ekskul' => Ekstrakurikuler::count(),
                'total_ketua'  => User::where('role', 'ketua')->count(),
            ];

            $pendaftaranCounts = Pendaftaran::selectRaw("
                COUNT(*) as total,
                SUM(status = 'menunggu') as menunggu,
                SUM(status = 'disetujui') as disetujui,
                SUM(status = 'ditolak') as ditolak
            ")->first();

            $totalAnggota = (int) $pendaftaranCounts->disetujui;

            return array_merge($entityCounts, [
                'total_anggota'         => $totalAnggota,
                'total_siswa'           => $totalAnggota,
                'total_pendaftar'       => (int) $pendaftaranCounts->total,
                'pendaftar_menunggu'    => (int) $pendaftaranCounts->menunggu,
                'pendaftar_terkonfirmasi'=> (int) $pendaftaranCounts->disetujui,
                'pendaftar_disetujui'   => (int) $pendaftaranCounts->disetujui,
                'pendaftar_ditolak'     => (int) $pendaftaranCounts->ditolak,
            ]);
        });

        return view('admin.dashboard.index', compact('stats'));
    }
}

