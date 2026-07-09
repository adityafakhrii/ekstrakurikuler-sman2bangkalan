<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Tabel pendaftaran: siswa mendaftar ke ekskul.
         * Satu siswa bisa mendaftar ke banyak ekskul (status pending → disetujui/ditolak).
         */
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->foreignId('ekstrakurikuler_id')
                ->constrained('ekstrakurikuler')
                ->cascadeOnDelete();

            $table->enum('status', [
                'menunggu',    // Menunggu persetujuan ketua
                'disetujui',   // Diterima menjadi anggota
                'ditolak',     // Ditolak oleh ketua
                'dibatalkan',  // Dibatalkan sendiri oleh siswa
            ])->default('menunggu');

            $table->text('catatan_siswa')->nullable()->comment('Alasan / motivasi dari siswa');
            $table->text('catatan_ketua')->nullable()->comment('Keterangan dari ketua (misal: alasan ditolak)');

            // Audit trail persetujuan
            $table->timestamp('disetujui_at')->nullable();
            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('User (ketua/admin) yang menyetujui/menolak');

            $table->timestamps();

            // Constraint: satu siswa hanya boleh punya 1 pendaftaran aktif per ekskul
            $table->unique(['siswa_id', 'ekstrakurikuler_id'], 'unique_siswa_ekskul');

            // Indexes
            $table->index('status');
            $table->index(['ekstrakurikuler_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
