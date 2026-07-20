<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus record pada `ekstrakurikuler` yang memiliki `deleted_at IS NOT NULL`
        if (Schema::hasTable('ekstrakurikuler') && Schema::hasColumn('ekstrakurikuler', 'deleted_at')) {
            DB::table('ekstrakurikuler')->whereNotNull('deleted_at')->delete();
            Schema::table('ekstrakurikuler', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }

        // 2. Ubah kode aspek pada `aspek_penilaian`
        // Urutan penting: KOMUNIKASI -> SOSIAL terlebih dahulu sebelum KEKOMPAKAN -> KOMUNIKASI
        if (Schema::hasTable('aspek_penilaian')) {
            // FISIK => KETANGKASAN
            DB::table('aspek_penilaian')
                ->where('kode', 'FISIK')
                ->update([
                    'kode' => 'KETANGKASAN',
                    'nama' => 'Ketangkasan',
                    'deskripsi' => 'Kemampuan fisik dan ketangkasan.'
                ]);

            // ESTETIKA => INTELEKTUAL
            DB::table('aspek_penilaian')
                ->where('kode', 'ESTETIKA')
                ->update([
                    'kode' => 'INTELEKTUAL',
                    'nama' => 'Intelektual',
                    'deskripsi' => 'Kemampuan berfikir dan analisis intelektual.'
                ]);

            // KOMUNIKASI => SOSIAL
            DB::table('aspek_penilaian')
                ->where('kode', 'KOMUNIKASI')
                ->update([
                    'kode' => 'SOSIAL',
                    'nama' => 'Sosial',
                    'deskripsi' => 'Kemampuan bersosialisasi dan interaksi sosial.'
                ]);

            // DISIPLIN => KEDISIPLINAN
            DB::table('aspek_penilaian')
                ->where('kode', 'DISIPLIN')
                ->update([
                    'kode' => 'KEDISIPLINAN',
                    'nama' => 'Kedisiplinan',
                    'deskripsi' => 'Tingkat kedisiplinan dan kepatuhan aturan.'
                ]);

            // KEKOMPAKAN => KOMUNIKASI
            DB::table('aspek_penilaian')
                ->where('kode', 'KEKOMPAKAN')
                ->update([
                    'kode' => 'KOMUNIKASI',
                    'nama' => 'Komunikasi',
                    'deskripsi' => 'Kemampuan komunikasi dan kerja sama.'
                ]);
        }

        // 3. Hapus kolom `nisn` dari tabel `siswa`
        if (Schema::hasTable('siswa') && Schema::hasColumn('siswa', 'nisn')) {
            Schema::table('siswa', function (Blueprint $table) {
                try {
                    $table->dropUnique('siswa_nisn_unique');
                } catch (\Exception $e) {}
                $table->dropColumn('nisn');
            });
        }

        // 4. Hapus kolom `nisn` dari tabel `users`
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'nisn')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropUnique('users_nisn_unique');
                } catch (\Exception $e) {}
                $table->dropColumn('nisn');
            });
        }
    }

    public function down(): void
    {
        // No down migration needed for this specific local database upgrade.
    }
};
