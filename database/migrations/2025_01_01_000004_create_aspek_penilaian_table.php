<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Aspek penilaian untuk sistem rekomendasi ekskul.
         * Misal: Kemampuan fisik, Minat seni, Kemampuan akademik, dll.
         */
        Schema::create('aspek_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment('Nama aspek, misal: Kemampuan Fisik');
            $table->string('kode', 20)->unique()->comment('Kode singkat, misal: FISIK, SENI');
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('urutan')->default(0)->comment('Urutan tampil di form');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        /**
         * Tabel pivot: bobot tiap aspek penilaian untuk setiap ekskul.
         * Digunakan oleh algoritma rekomendasi.
         */
        Schema::create('ekskul_aspek', function (Blueprint $table) {
            $table->foreignId('ekstrakurikuler_id')
                ->constrained('ekstrakurikuler')
                ->cascadeOnDelete();
            $table->foreignId('aspek_penilaian_id')
                ->constrained('aspek_penilaian')
                ->cascadeOnDelete();

            // Bobot 0.00 - 1.00 (persentase kontribusi aspek ini ke ekskul)
            $table->decimal('bobot', 5, 2)->default(0.00)
                ->comment('Bobot aspek untuk ekskul ini (0-100)');

            $table->primary(['ekstrakurikuler_id', 'aspek_penilaian_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekskul_aspek');
        Schema::dropIfExists('aspek_penilaian');
    }
};
