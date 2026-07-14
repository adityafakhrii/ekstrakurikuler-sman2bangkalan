<?php

namespace App\Services;

use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use App\Models\Rekomendasi;
use App\Models\RekomendasiHasil;
use App\Models\EkskulAspek;
use App\Models\AspekPenilaian;
use Illuminate\Support\Facades\DB;

class RekomendasiService
{
    /**
     * Generate rekomendasi ekskul berdasarkan jawaban siswa menggunakan Cosine Similarity.
     *
     * @param  array<string, int>  $jawaban
     */
    public function generate(Siswa $siswa, array $jawaban): int
    {
        return DB::transaction(function () use ($siswa, $jawaban) {
            $rekomendasiId = DB::table('rekomendasi')->insertGetId([
                'siswa_id' => $siswa->id,
                'jawaban' => json_encode($jawaban),
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $results = $this->calculateSimilarities($jawaban);

            $this->saveResults($rekomendasiId, $results);

            return $rekomendasiId;
        });
    }

    /**
     * Hitung cosine similarity antara preferensi siswa dan setiap ekskul aktif.
     *
     * @param  array<string, int>  $jawaban
     * @return array<int, array{ekstrakurikuler_id: int, skor: float}>
     */
    private function calculateSimilarities(array $jawaban): array
    {
        $studentVector = [
            $jawaban['fisik'],
            $jawaban['estetika'],
            $jawaban['komunikasi'],
            $jawaban['kreativitas'],
            $jawaban['disiplin'],
            $jawaban['kekompakan'],
        ];

        $ekskuls = Ekstrakurikuler::pluck('id');

        // Pre-load semua aspek bobot sekaligus (menghindari N+1 query)
        $allAspekBobot = DB::table('ekskul_aspek')
            ->whereIn('ekstrakurikuler_id', $ekskuls)
            ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
            ->select('ekskul_aspek.ekstrakurikuler_id', 'aspek_penilaian.kode', 'ekskul_aspek.bobot')
            ->get()
            ->groupBy('ekstrakurikuler_id');

        $results = [];

        foreach ($ekskuls as $ekskulId) {
            $aspekBobot = ($allAspekBobot[$ekskulId] ?? collect())
                ->pluck('bobot', 'kode')
                ->toArray();

            $ekskulVector = $this->buildEkskulVector($aspekBobot);

            $score = $this->cosineSimilarity($studentVector, $ekskulVector);

            $results[] = [
                'ekstrakurikuler_id' => $ekskulId,
                'skor' => round($score * 100, 2),
            ];
        }

        usort($results, fn ($a, $b) => $b['skor'] <=> $a['skor']);

        return $results;
    }

    /**
     * Bangun vektor profil ekskul dari bobot aspek.
     *
     * @param  array<string, float>  $aspekBobot
     * @return array<int, float>
     */
    private function buildEkskulVector(array $aspekBobot): array
    {
        $mapping = ['FISIK', 'ESTETIKA', 'KOMUNIKASI', 'KREATIVITAS', 'DISIPLIN', 'KEKOMPAKAN'];

        return array_map(
            fn ($kode) => isset($aspekBobot[$kode]) ? (float) $aspekBobot[$kode] : 0,
            $mapping,
        );
    }

    /**
     * Hitung Cosine Similarity: cos(θ) = (A·B) / (||A|| × ||B||)
     *
     * @param  array<int, float|int>  $vectorA
     * @param  array<int, float|int>  $vectorB
     */
    private function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        for ($i = 0, $len = count($vectorA); $i < $len; $i++) {
            $dotProduct += $vectorA[$i] * $vectorB[$i];
            $normA += $vectorA[$i] * $vectorA[$i];
            $normB += $vectorB[$i] * $vectorB[$i];
        }

        $normA = sqrt($normA);
        $normB = sqrt($normB);

        return ($normA > 0 && $normB > 0)
            ? $dotProduct / ($normA * $normB)
            : 0;
    }

    /**
     * Simpan hasil rekomendasi ke database.
     *
     * @param  array<int, array{ekstrakurikuler_id: int, skor: float}>  $results
     */
    private function saveResults(int $rekomendasiId, array $results): void
    {
        $rows = [];

        foreach ($results as $index => $res) {
            $rows[] = [
                'rekomendasi_id' => $rekomendasiId,
                'ekstrakurikuler_id' => $res['ekstrakurikuler_id'],
                'skor' => $res['skor'],
                'peringkat' => $index + 1,
            ];
        }

        RekomendasiHasil::insert($rows);
    }
}
