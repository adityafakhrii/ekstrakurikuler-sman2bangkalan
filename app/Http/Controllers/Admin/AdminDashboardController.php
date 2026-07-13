<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function index(): View
    {
        $stats = [
            'total_ekskul' => Ekstrakurikuler::count(),
            'total_siswa' => Siswa::count(),
            'total_ketua' => User::where('role', 'ketua')->count(),
            'total_pendaftar' => Pendaftaran::count(),
            'pendaftar_menunggu' => Pendaftaran::where('status', 'menunggu')->count(),
            'pendaftar_disetujui' => Pendaftaran::where('status', 'disetujui')->count(),
            'pendaftar_ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
