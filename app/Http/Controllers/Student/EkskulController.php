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
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')
            ->latest()
            ->get();

        return view('student.ekstrakurikuler.index', compact('ekskuls'));
    }

    public function show(int $id): View
    {
        $ekskul = Ekstrakurikuler::with('ketua')->findOrFail($id);

        $aspekBobot = EkskulAspek::where('ekstrakurikuler_id', $id)
            ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
            ->pluck('bobot', 'kode')
            ->toArray();

        $aspekValues = AspekHelper::convertBobotToInput($aspekBobot);

        return view('student.ekstrakurikuler.show', compact('ekskul', 'aspekValues'));
    }
}
