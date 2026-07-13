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

            $results = [];

            foreach ($ekskuls as $ekskul) {
                $aspekBobot = DB::table('ekskul_aspek')
                    ->where('ekstrakurikuler_id', $ekskul->id)
                    ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
                    ->pluck('bobot', 'kode')
                    ->toArray();

                // Vektor preferensi siswa (skala 1-5)
                $studentVector = [
                    (int) $request->input('fisik'),
                    (int) $request->input('intelektual'),
                    (int) $request->input('kreativitas'),
                    (int) $request->input('sosial'),
                    (int) $request->input('mental'),
                    (int) $request->input('komunikasi'),
                ];

                // Vektor profil ekskul (konversi bobot 0-100 → 1-5)
                $ekskulVector = [
                    isset($aspekBobot['FISIK']) ? (float) $aspekBobot['FISIK'] / 20 : 0,
                    isset($aspekBobot['AKADEMIK']) ? (float) $aspekBobot['AKADEMIK'] / 20 : 0,
                    isset($aspekBobot['SENI']) ? (float) $aspekBobot['SENI'] / 20 : 0,
                    isset($aspekBobot['SOSIAL']) ? (float) $aspekBobot['SOSIAL'] / 20 : 0,
                    isset($aspekBobot['SOSIAL_HUMANIORA']) ? (float) $aspekBobot['SOSIAL_HUMANIORA'] / 20 : 0,
                    isset($aspekBobot['BAHASA']) ? (float) $aspekBobot['BAHASA'] / 20 : 0,
                ];

                // Cosine Similarity: cos(θ) = (A·B) / (||A|| × ||B||)
                $dotProduct = 0;
                $normStudent = 0;
                $normEkskul = 0;

                for ($i = 0; $i < 6; $i++) {
                    $dotProduct += $studentVector[$i] * $ekskulVector[$i];
                    $normStudent += $studentVector[$i] * $studentVector[$i];
                    $normEkskul += $ekskulVector[$i] * $ekskulVector[$i];
                }

                $normStudent = sqrt($normStudent);
                $normEkskul = sqrt($normEkskul);

                // Hindari pembagian dengan nol
                $cosineSimilarity = ($normStudent > 0 && $normEkskul > 0)
                    ? $dotProduct / ($normStudent * $normEkskul)
                    : 0;

                // Konversi ke persentase (0 - 100)
                $score = round($cosineSimilarity * 100, 2);

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
