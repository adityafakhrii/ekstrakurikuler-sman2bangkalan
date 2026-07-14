<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->string('tahun_ajaran', 10);
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dibatalkan'])->default('menunggu');
            $table->text('catatan_siswa')->nullable();
            $table->string('alamat', 500)->nullable();
            $table->text('catatan_ketua')->nullable();
            $table->timestamp('disetujui_at')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['siswa_id', 'ekstrakurikuler_id'], 'unique_siswa_ekskul');
            $table->index('status');
            $table->index(['ekstrakurikuler_id', 'status']);
        });

        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->json('jawaban');
            $table->string('tahun_ajaran', 10);
            $table->timestamps();

            $table->index(['siswa_id', 'tahun_ajaran']);
        });

        Schema::create('rekomendasi_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekomendasi_id')->constrained('rekomendasi')->cascadeOnDelete();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->decimal('skor', 5, 2)->default(0.00);
            $table->unsignedTinyInteger('peringkat');

            $table->unique(['rekomendasi_id', 'ekstrakurikuler_id']);
            $table->index(['rekomendasi_id', 'peringkat']);
        });

        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('isi');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['ekstrakurikuler_id', 'is_published']);
            $table->index('published_at');
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('topik')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');
            $table->text('keterangan')->nullable();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['ekstrakurikuler_id', 'siswa_id', 'tanggal'], 'unique_absensi_per_hari');
            $table->index('tanggal');
            $table->index(['ekstrakurikuler_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('rekomendasi_hasil');
        Schema::dropIfExists('rekomendasi');
        Schema::dropIfExists('pendaftaran');
    }
};
