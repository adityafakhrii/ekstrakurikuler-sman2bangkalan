<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            // Hapus index dulu sebelum drop kolom
            $table->dropIndex('ekstrakurikuler_status_index');
            $table->dropIndex('ekstrakurikuler_status_tahun_ajaran_index');

            // Hapus semua kolom yang tidak diperlukan
            $table->dropColumn([
                'status',
                'banner',
                'hari_latihan',
                'jam_mulai',
                'jam_selesai',
                'lokasi',
                'persyaratan',
                'prestasi',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'tidak_aktif', 'penuh'])->default('aktif');
            $table->string('banner')->nullable();
            $table->enum('hari_latihan', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'])->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->text('prestasi')->nullable();
            $table->index('status');
            $table->index(['status', 'tahun_ajaran']);
        });
    }
};
