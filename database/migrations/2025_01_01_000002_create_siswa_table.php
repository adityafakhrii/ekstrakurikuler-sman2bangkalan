<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('nis', 20)->unique()->comment('Nomor Induk Siswa');
            $table->string('nisn', 20)->nullable()->unique()->comment('Nomor Induk Siswa Nasional');
            $table->string('kelas', 10)->comment('Contoh: X, XI, XII');
            $table->string('rombel', 20)->comment('Contoh: X MIPA 1, XI IPS 2');
            $table->enum('jurusan', [
                'MIPA',
                'IPS',
                'Bahasa',
                'Agama',
            ])->comment('Jurusan / Program studi');
            $table->string('no_telp', 20)->nullable();
            $table->string('foto')->nullable()->comment('Path foto profil');
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->string('tahun_masuk', 4)->comment('Tahun masuk sekolah');

            $table->timestamps();

            // Index untuk query umum
            $table->index('kelas');
            $table->index('jurusan');
            $table->index(['kelas', 'rombel']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
