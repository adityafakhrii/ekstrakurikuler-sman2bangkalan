<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (! Schema::hasColumn('siswa', 'alamat')) {
                $table->string('alamat', 500)->nullable()->after('no_telp');
            }
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            if (! Schema::hasColumn('pendaftaran', 'alamat')) {
                $table->string('alamat', 500)->nullable()->after('catatan_siswa');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'alamat')) {
                $table->dropColumn('alamat');
            }
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran', 'alamat')) {
                $table->dropColumn('alamat');
            }
        });
    }
};
