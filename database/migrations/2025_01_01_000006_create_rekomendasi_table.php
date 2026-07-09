<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Tabel rekomendasi: menyimpan jawaban siswa dari form penilaian aspek.
         * Satu sesi pengisian = satu rekomendasi.
         */
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            // Jawaban disimpan sebagai JSON: { aspek_id: nilai, ... }
            // nilai: 1-5 (skala Likert)
            $table->json('jawaban')->comment('JSON: { "aspek_id": nilai_1_sampai_5 }');

            $table->string('tahun_ajaran', 10)->comment('Tahun ajaran saat rekomendasi dibuat');

            $table->timestamps();

            // Siswa bisa isi ulang rekomendasi (riwayat tersimpan)
            $table->index(['siswa_id', 'tahun_ajaran']);
        });

        /**
         * Tabel hasil rekomendasi: ranking ekskul yang direkomendasikan
         * berdasarkan jawaban siswa dan bobot aspek tiap ekskul.
         */
        Schema::create('rekomendasi_hasil', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rekomendasi_id')
                ->constrained('rekomendasi')
                ->cascadeOnDelete();

            $table->foreignId('ekstrakurikuler_id')
                ->constrained('ekstrakurikuler')
                ->cascadeOnDelete();

            // Skor 0.00 - 100.00 (persentase kecocokan)
            $table->decimal('skor', 5, 2)->default(0.00)
                ->comment('Persentase kecocokan siswa dengan ekskul ini');

            $table->unsignedTinyInteger('peringkat')
                ->comment('Ranking 1 = paling cocok');

            // Unique: tiap rekomendasi, tiap ekskul hanya 1 hasil
            $table->unique(['rekomendasi_id', 'ekstrakurikuler_id']);
            $table->index(['rekomendasi_id', 'peringkat']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_hasil');
        Schema::dropIfExists('rekomendasi');
    }
};
