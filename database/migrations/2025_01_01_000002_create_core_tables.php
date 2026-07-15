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
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->nullable()->unique();
            $table->string('kelas', 10);
            $table->string('jurusan', 50);
            $table->string('no_telp', 20)->nullable();
            $table->string('alamat', 500)->nullable();
            $table->string('foto')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tahun_masuk', 4);
            $table->timestamps();

            $table->index('kelas');
            $table->index('jurusan');
        });

        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ketua_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->string('pembina')->nullable();
            $table->string('whatsapp_group')->nullable();
            $table->string('jadwal')->nullable();
            $table->unsignedInteger('kuota')->default(30);
            $table->string('kategori')->nullable();
            $table->string('tahun_ajaran', 10);
            $table->timestamps();
            $table->softDeletes();

            $table->index('kategori');
            $table->index('tahun_ajaran');
        });

        Schema::create('aspek_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode', 20)->unique();
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('ekskul_aspek', function (Blueprint $table) {
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->foreignId('aspek_penilaian_id')->constrained('aspek_penilaian')->cascadeOnDelete();
            $table->decimal('bobot', 5, 2)->default(0.00);
            $table->primary(['ekstrakurikuler_id', 'aspek_penilaian_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekskul_aspek');
        Schema::dropIfExists('aspek_penilaian');
        Schema::dropIfExists('ekstrakurikuler');
        Schema::dropIfExists('siswa');
    }
};
