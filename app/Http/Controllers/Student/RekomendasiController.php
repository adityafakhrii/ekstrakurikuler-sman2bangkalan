<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
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

        $rekomendasiId = DB::transaction(function () use ($request, $siswa) {
            $jawaban = [
                'fisik' => (int) $request->input('fisik'),
                'intelektual' => (int) $request->input('intelektual'),
                'kreativitas' => (int) $request->input('kreativitas'),
                'sosial' => (int) $request->input('sosial'),
                'mental' => (int) $request->input('mental'),
                'komunikasi' => (int) $request->input('komunikasi'),
            ];

            $rekomendasiId = DB::table('rekomendasi')->insertGetId([
                'siswa_id' => $siswa->id,
                'jawaban' => json_encode($jawaban),
                'tahun_ajaran' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $ekskuls = DB::table('ekstrakurikuler')
                ->whereNull('deleted_at')
                ->where('status', 'aktif')
                ->get();

            $mapping = [
                'fisik' => 'FISIK',
                'intelektual' => 'AKADEMIK',
                'kreativitas' => 'SENI',
                'sosial' => 'SOSIAL',
                'mental' => 'SOSIAL_HUMANIORA',
                'komunikasi' => 'BAHASA',
            ];

            $results = [];

            foreach ($ekskuls as $ekskul) {
                $aspekBobot = DB::table('ekskul_aspek')
                    ->where('ekstrakurikuler_id', $ekskul->id)
                    ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
                    ->pluck('bobot', 'kode')
                    ->toArray();

                $totalSimilarity = 0;
                foreach ($mapping as $formField => $dbKode) {
                    $studentVal = (int) $request->input($formField) * 20; // Scale 1-5 to 0-100
                    $ekskulVal = isset($aspekBobot[$dbKode]) ? (float) $aspekBobot[$dbKode] : 0.0;
                    $diff = abs($studentVal - $ekskulVal);
                    $totalSimilarity += (100 - $diff);
                }

                $score = $totalSimilarity / 6;

                $results[] = [
                    'rekomendasi_id' => $rekomendasiId,
                    'ekstrakurikuler_id' => $ekskul->id,
                    'skor' => $score,
                ];
            }

            usort($results, function ($a, $b) {
                return $b['skor'] <=> $a['skor'];
            });

            foreach ($results as $index => $res) {
                DB::table('rekomendasi_hasil')->insert([
                    'rekomendasi_id' => $res['rekomendasi_id'],
                    'ekstrakurikuler_id' => $res['ekstrakurikuler_id'],
                    'skor' => $res['skor'],
                    'peringkat' => $index + 1,
                ]);
            }

            return $rekomendasiId;
        });

        session(['last_rekomendasi_id' => $rekomendasiId]);

        return redirect()->route('siswa.rekomendasi.results');
    }

    public function results(): View|RedirectResponse
    {
        $siswa = auth()->user()->siswa;

        if (! $siswa) {
            return redirect()->route('siswa.home')->with('error', 'Data siswa tidak ditemukan.');
        }

        $rekomendasiId = session('last_rekomendasi_id');

        if (! $rekomendasiId) {
            $latest = DB::table('rekomendasi')
                ->where('siswa_id', $siswa->id)
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
