<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Rekomendasi;
use App\Services\RekomendasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
    public function __construct(
        private readonly RekomendasiService $rekomendasiService,
    ) {}

    public function create(): View
    {
        return view('student.rekomendasi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fisik' => ['required', 'integer', 'between:1,5'],
            'intelektual' => ['required', 'integer', 'between:1,5'],
            'kreativitas' => ['required', 'integer', 'between:1,5'],
            'sosial' => ['required', 'integer', 'between:1,5'],
            'mental' => ['required', 'integer', 'between:1,5'],
            'komunikasi' => ['required', 'integer', 'between:1,5'],
        ]);

        $siswa = auth()->user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        /** @var \App\Models\Siswa $siswa */
        $siswa = $siswa;

        $jawaban = [
            'fisik' => (int) $request->input('fisik'),
            'intelektual' => (int) $request->input('intelektual'),
            'kreativitas' => (int) $request->input('kreativitas'),
            'sosial' => (int) $request->input('sosial'),
            'mental' => (int) $request->input('mental'),
            'komunikasi' => (int) $request->input('komunikasi'),
        ];

        $rekomendasiId = $this->rekomendasiService->generate($siswa, $jawaban);

        session(['last_rekomendasi_id' => $rekomendasiId]);

        return redirect()->route('siswa.rekomendasi.results');
    }

    public function results(): View|RedirectResponse
    {
        $siswa = auth()->user()->siswa;

        if (! $siswa) {
            return redirect()->route('siswa.home')->with('error', 'Data siswa tidak ditemukan.');
        }

        /** @var \App\Models\Siswa $siswa */
        $siswa = $siswa;

        $rekomendasiId = session('last_rekomendasi_id');

        if (! $rekomendasiId) {
            $latest = Rekomendasi::where('siswa_id', $siswa->id)
                ->latest()
                ->first();

            if ($latest) {
                $rekomendasiId = $latest->id;
            }
        }

        if (! $rekomendasiId) {
            return redirect()->route('siswa.rekomendasi.create');
        }

        $ekskuls = Ekstrakurikuler::join('rekomendasi_hasil', 'ekstrakurikuler.id', '=', 'rekomendasi_hasil.ekstrakurikuler_id')
            ->where('rekomendasi_hasil.rekomendasi_id', $rekomendasiId)
            ->orderBy('rekomendasi_hasil.peringkat', 'asc')
            ->select('ekstrakurikuler.*', 'rekomendasi_hasil.skor')
            ->get();

        return view('student.rekomendasi.results', compact('ekskuls'));
    }
}
