<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();

            // Ketua ekskul — FK ke users dengan role 'ketua'
            $table->foreignId('ketua_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('User dengan role ketua yang memimpin ekskul ini');

            $table->string('nama')->comment('Nama ekstrakurikuler');
            $table->string('slug')->unique()->comment('URL-friendly name');
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable()->comment('Path logo/gambar ekskul');
            $table->string('banner')->nullable()->comment('Path banner/foto kegiatan');
            $table->string('pembina')->nullable()->comment('Nama Pembina');
            $table->string('whatsapp_group')->nullable()->comment('Link grup Whatsapp');
            $table->string('jadwal')->nullable()->comment('Jadwal Latihan (string)');

            $table->unsignedInteger('kuota')->default(30)->comment('Batas maksimal anggota');
            $table->enum('status', ['aktif', 'tidak_aktif', 'penuh'])->default('aktif');
            $table->string('kategori')->nullable()->comment('Contoh: Olahraga, Seni, Akademik, dll.');

            // Jadwal latihan
            $table->enum('hari_latihan', [
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
            ])->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable()->comment('Tempat latihan, misal: Lapangan Basket, Aula');

            $table->string('tahun_ajaran', 10)->comment('Contoh: 2024/2025');
            $table->text('persyaratan')->nullable()->comment('Syarat pendaftaran');
            $table->text('prestasi')->nullable()->comment('Prestasi yang pernah diraih');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('kategori');
            $table->index('tahun_ajaran');
            $table->index(['status', 'tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler');
    }
};
