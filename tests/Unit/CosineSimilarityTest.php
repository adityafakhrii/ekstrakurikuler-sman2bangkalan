<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Test Cosine Similarity Algorithm
 *
 * Data dari gambar referensi:
 *
 * | Objek         | Fisik | Estetika | Komunikasi | Kreativitas | Disiplin | Kekompakan |
 * |---------------|-------|----------|------------|-------------|----------|------------|
 * | Siswa         |   3   |    4     |     5      |      2      |    4     |     3      |
 * | Paduan Suara  |   2   |    5     |     4      |      3      |    3     |     4      |
 * | Pramuka       |   4   |    2     |     3      |      2      |    5     |     5      |
 * | Basket        |   5   |    2     |     3      |      2      |    4     |     4      |
 * | Teater        |   1   |    5     |     5      |      5      |    3     |     3      |
 *
 * Expected Results (dari gambar):
 *   Dot Product :  PaduanSuara=76, Pramuka=74, Basket=70, Teater=79
 *   Magnitude   :  Siswa=8.88819, PaduanSuara=8.88819, Pramuka=9.11043, Basket=8.60233, Teater=9.69536
 *   Cosine Sim  :  PaduanSuara=0.962025, Pramuka=0.913859, Basket=0.915521, Teater=0.916747
 */
class CosineSimilarityTest extends TestCase
{
    /**
     * Helper: hitung cosine similarity dua vektor.
     * Persis sama dengan logika di RekomendasiController::store().
     */
    private function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        $count = count($vectorA);

        for ($i = 0; $i < $count; $i++) {
            $dotProduct += $vectorA[$i] * $vectorB[$i];
            $normA += $vectorA[$i] * $vectorA[$i];
            $normB += $vectorB[$i] * $vectorB[$i];
        }

        $normA = sqrt($normA);
        $normB = sqrt($normB);

        if ($normA > 0 && $normB > 0) {
            return $dotProduct / ($normA * $normB);
        }

        return 0;
    }

    /**
     * Helper: hitung dot product dua vektor.
     */
    private function dotProduct(array $vectorA, array $vectorB): int
    {
        $result = 0;
        for ($i = 0; $i < count($vectorA); $i++) {
            $result += $vectorA[$i] * $vectorB[$i];
        }
        return $result;
    }

    /**
     * Helper: hitung euclidean norm (magnitude) vektor.
     */
    private function magnitude(array $vector): float
    {
        $sum = 0;
        foreach ($vector as $val) {
            $sum += $val * $val;
        }
        return sqrt($sum);
    }

    // ========================================
    // Test Cases berdasarkan gambar referensi
    // ========================================

    public function test_dot_product_siswa_x_paduan_suara(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $paduanSuara = [2, 5, 4, 3, 3, 4];

        $result = $this->dotProduct($siswa, $paduanSuara);

        // 6+20+20+6+12+12 = 76
        $this->assertEquals(76, $result, 'Dot product Siswa × Paduan Suara harus 76');
    }

    public function test_dot_product_siswa_x_pramuka(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $pramuka = [4, 2, 3, 2, 5, 5];

        $result = $this->dotProduct($siswa, $pramuka);

        // 12+8+15+4+20+15 = 74
        $this->assertEquals(74, $result, 'Dot product Siswa × Pramuka harus 74');
    }

    public function test_dot_product_siswa_x_basket(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $basket = [5, 2, 3, 2, 4, 4];

        $result = $this->dotProduct($siswa, $basket);

        // 15+8+15+4+16+12 = 70
        $this->assertEquals(70, $result, 'Dot product Siswa × Basket harus 70');
    }

    public function test_dot_product_siswa_x_teater(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $teater = [1, 5, 5, 5, 3, 3];

        $result = $this->dotProduct($siswa, $teater);

        // 3+20+25+10+12+9 = 79
        $this->assertEquals(79, $result, 'Dot product Siswa × Teater harus 79');
    }

    public function test_magnitude_siswa(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $result = $this->magnitude($siswa);

        // sqrt(9+16+25+4+16+9) = sqrt(79) ≈ 8.88819
        $this->assertEqualsWithDelta(8.88819, $result, 0.001, 'Magnitude Siswa harus ≈ 8.88819');
    }

    public function test_magnitude_paduan_suara(): void
    {
        $paduanSuara = [2, 5, 4, 3, 3, 4];
        $result = $this->magnitude($paduanSuara);

        // sqrt(4+25+16+9+9+16) = sqrt(79) ≈ 8.88819
        $this->assertEqualsWithDelta(8.88819, $result, 0.001, 'Magnitude Paduan Suara harus ≈ 8.88819');
    }

    public function test_magnitude_pramuka(): void
    {
        $pramuka = [4, 2, 3, 2, 5, 5];
        $result = $this->magnitude($pramuka);

        // sqrt(16+4+9+4+25+25) = sqrt(83) ≈ 9.11043
        $this->assertEqualsWithDelta(9.11043, $result, 0.001, 'Magnitude Pramuka harus ≈ 9.11043');
    }

    public function test_magnitude_basket(): void
    {
        $basket = [5, 2, 3, 2, 4, 4];
        $result = $this->magnitude($basket);

        // sqrt(25+4+9+4+16+16) = sqrt(74) ≈ 8.60233
        $this->assertEqualsWithDelta(8.60233, $result, 0.001, 'Magnitude Basket harus ≈ 8.60233');
    }

    public function test_magnitude_teater(): void
    {
        $teater = [1, 5, 5, 5, 3, 3];
        $result = $this->magnitude($teater);

        // sqrt(1+25+25+25+9+9) = sqrt(94) ≈ 9.69536
        $this->assertEqualsWithDelta(9.69536, $result, 0.001, 'Magnitude Teater harus ≈ 9.69536');
    }

    public function test_cosine_similarity_siswa_x_paduan_suara(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $paduanSuara = [2, 5, 4, 3, 3, 4];

        $result = $this->cosineSimilarity($siswa, $paduanSuara);

        // 76 / (8.88819 × 8.88819) = 76 / 79.0 ≈ 0.962025
        $this->assertEqualsWithDelta(0.962025, $result, 0.001, 'Cosine Similarity Siswa × Paduan Suara harus ≈ 0.962025');
    }

    public function test_cosine_similarity_siswa_x_pramuka(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $pramuka = [4, 2, 3, 2, 5, 5];

        $result = $this->cosineSimilarity($siswa, $pramuka);

        // 74 / (8.88819 × 9.11043) = 74 / 80.964 ≈ 0.913859
        $this->assertEqualsWithDelta(0.913859, $result, 0.001, 'Cosine Similarity Siswa × Pramuka harus ≈ 0.913859');
    }

    public function test_cosine_similarity_siswa_x_basket(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $basket = [5, 2, 3, 2, 4, 4];

        $result = $this->cosineSimilarity($siswa, $basket);

        // 70 / (8.88819 × 8.60233) = 70 / 76.468 ≈ 0.915521
        $this->assertEqualsWithDelta(0.915521, $result, 0.001, 'Cosine Similarity Siswa × Basket harus ≈ 0.915521');
    }

    public function test_cosine_similarity_siswa_x_teater(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $teater = [1, 5, 5, 5, 3, 3];

        $result = $this->cosineSimilarity($siswa, $teater);

        // 79 / (8.88819 × 9.69536) = 79 / 86.175 ≈ 0.916747
        $this->assertEqualsWithDelta(0.916747, $result, 0.001, 'Cosine Similarity Siswa × Teater harus ≈ 0.916747');
    }

    public function test_ranking_hasil_rekomendasi(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];

        $ekskuls = [
            'Paduan Suara' => [2, 5, 4, 3, 3, 4],
            'Pramuka'      => [4, 2, 3, 2, 5, 5],
            'Basket'       => [5, 2, 3, 2, 4, 4],
            'Teater'       => [1, 5, 5, 5, 3, 3],
        ];

        $scores = [];
        foreach ($ekskuls as $nama => $vektor) {
            $scores[$nama] = round($this->cosineSimilarity($siswa, $vektor) * 100, 2);
        }

        // Urutkan dari tertinggi
        arsort($scores);

        $ranking = array_keys($scores);

        // Paduan Suara (96.2%) > Teater (91.7%) > Basket (91.6%) > Pramuka (91.4%)
        $this->assertEquals('Paduan Suara', $ranking[0], 'Ranking #1 harus Paduan Suara');
        $this->assertEquals('Teater', $ranking[1], 'Ranking #2 harus Teater');
        $this->assertEquals('Basket', $ranking[2], 'Ranking #3 harus Basket');
        $this->assertEquals('Pramuka', $ranking[3], 'Ranking #4 harus Pramuka');

        // Verifikasi skor
        $this->assertEqualsWithDelta(96.20, $scores['Paduan Suara'], 0.1, 'Skor Paduan Suara harus ≈ 96.20%');
        $this->assertEqualsWithDelta(91.39, $scores['Pramuka'], 0.1, 'Skor Pramuka harus ≈ 91.39%');
        $this->assertEqualsWithDelta(91.55, $scores['Basket'], 0.1, 'Skor Basket harus ≈ 91.55%');
        $this->assertEqualsWithDelta(91.67, $scores['Teater'], 0.1, 'Skor Teater harus ≈ 91.67%');
    }

    public function test_identical_vectors_give_perfect_score(): void
    {
        $vector = [3, 4, 5, 2, 4, 3];

        $result = $this->cosineSimilarity($vector, $vector);

        // Vektor identik = cosine similarity = 1.0 (100%)
        $this->assertEqualsWithDelta(1.0, $result, 0.0001, 'Vektor identik harus menghasilkan 1.0');
    }

    public function test_zero_vector_returns_zero(): void
    {
        $vectorA = [3, 4, 5, 2, 4, 3];
        $vectorB = [0, 0, 0, 0, 0, 0];

        $result = $this->cosineSimilarity($vectorA, $vectorB);

        $this->assertEquals(0, $result, 'Vektor nol harus menghasilkan 0');
    }

    public function test_opposite_vectors_give_negative(): void
    {
        $vectorA = [1, 2, 3];
        $vectorB = [-1, -2, -3];

        $result = $this->cosineSimilarity($vectorA, $vectorB);

        // Vektor berlawanan arah = -1
        $this->assertEqualsWithDelta(-1.0, $result, 0.0001, 'Vektor berlawanan harus menghasilkan -1.0');
    }

    public function test_percentage_conversion_matches_expected(): void
    {
        $siswa = [3, 4, 5, 2, 4, 3];
        $paduanSuara = [2, 5, 4, 3, 3, 4];

        $cosineSim = $this->cosineSimilarity($siswa, $paduanSuara);
        $percentage = round($cosineSim * 100, 2);

        $this->assertEqualsWithDelta(96.20, $percentage, 0.1, 'Persentase kecocokan harus ≈ 96.20%');
    }
}
