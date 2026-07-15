<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Helpers\AspekHelper;
use App\Models\Ekstrakurikuler;
use App\Models\EkskulAspek;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EkskulController extends Controller
{
    public function index(): View
    {
        $ekskuls = Ekstrakurikuler::select('id', 'nama', 'slug', 'logo', 'kuota', 'kategori', 'jadwal', 'pembina')
            ->withCount(['pendaftarans as anggota_count' => fn($q) => $q->where('status', 'disetujui')])
            ->latest()
            ->paginate(12);

        return view('student.ekstrakurikuler.index', compact('ekskuls'));
    }

    public function show(int $id): View
    {
        $ekskul = Ekstrakurikuler::with('ketua:id,name')->findOrFail($id);

        $aspekBobot = EkskulAspek::where('ekstrakurikuler_id', $id)
            ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
            ->pluck('bobot', 'kode')
            ->toArray();

        $aspekValues = AspekHelper::convertBobotToInput($aspekBobot);

        $siswa = auth()->user()->siswa;
        $canRegister = $siswa ? true : false;
        $registerMessage = $siswa ? '' : 'Data siswa tidak ditemukan';

        if ($siswa) {
            $activeCount = \App\Models\Pendaftaran::where('siswa_id', $siswa->id)
                ->whereIn('status', ['menunggu', 'disetujui'])
                ->count();

            if ($activeCount >= 2) {
                $canRegister = false;
                $registerMessage = 'Maksimal 2 ekskul diikuti';
            } else {
                $alreadyRegistered = \App\Models\Pendaftaran::where('siswa_id', $siswa->id)
                    ->where('ekstrakurikuler_id', $id)
                    ->exists();

                if ($alreadyRegistered) {
                    $canRegister = false;
                    $registerMessage = 'Sudah terdaftar di ekskul ini';
                }
            }
        }

        return view('student.ekstrakurikuler.show', compact('ekskul', 'aspekValues', 'canRegister', 'registerMessage'));
    }
}
