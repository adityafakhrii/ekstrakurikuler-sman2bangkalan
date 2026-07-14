<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ekstrakurikuler_id')
                ->constrained('ekstrakurikuler')
                ->cascadeOnDelete();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->date('tanggal')->comment('Tanggal kegiatan/latihan');

            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'alpha',
            ])->default('alpha');

            $table->text('keterangan')->nullable()->comment('Keterangan tambahan');

            $table->foreignId('dicatat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('User (ketua) yang mencatat absensi');

            $table->timestamps();

            // Constraint: satu siswa hanya boleh punya 1 absensi per tanggal per ekskul
            $table->unique(['ekstrakurikuler_id', 'siswa_id', 'tanggal'], 'unique_absensi_per_hari');

            // Indexes
            $table->index('tanggal');
            $table->index(['ekstrakurikuler_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
