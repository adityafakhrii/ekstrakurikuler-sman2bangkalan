<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EkskulController extends Controller
{
    public function index(): View
    {
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')
            ->latest()
            ->get();

        return view('student.ekstrakurikuler.index', compact('ekskuls'));
    }

    public function show(int $id): View
    {
        $ekskul = Ekstrakurikuler::with('ketua')->findOrFail($id);

        $aspekBobot = DB::table('ekskul_aspek')
            ->where('ekstrakurikuler_id', $id)
            ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
            ->pluck('bobot', 'kode')
            ->toArray();

        $aspekValues = [
            'fisik' => isset($aspekBobot['FISIK']) ? round($aspekBobot['FISIK'] / 20) : 1,
            'intelektual' => isset($aspekBobot['AKADEMIK']) ? round($aspekBobot['AKADEMIK'] / 20) : 1,
            'kreativitas' => isset($aspekBobot['SENI']) ? round($aspekBobot['SENI'] / 20) : 1,
            'sosial' => isset($aspekBobot['SOSIAL']) ? round($aspekBobot['SOSIAL'] / 20) : 1,
            'mental' => isset($aspekBobot['SOSIAL_HUMANIORA']) ? round($aspekBobot['SOSIAL_HUMANIORA'] / 20) : 1,
            'komunikasi' => isset($aspekBobot['BAHASA']) ? round($aspekBobot['BAHASA'] / 20) : 1,
        ];

        return view('student.ekstrakurikuler.show', compact('ekskul', 'aspekValues'));
    }
}
