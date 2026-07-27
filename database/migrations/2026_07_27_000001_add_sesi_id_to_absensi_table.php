<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add sesi_id column (nullable initially for backfill)
        Schema::table('absensi', function (Blueprint $table) {
            $table->string('sesi_id', 36)->after('id')->default('');
        });

        // 2. Backfill: generate a UUID for each existing session group
        $groups = DB::table('absensi')
            ->select('ekstrakurikuler_id', 'tanggal', 'topik')
            ->distinct()
            ->get();

        foreach ($groups as $group) {
            $sesiId = (string) Str::uuid();
            DB::table('absensi')
                ->where('ekstrakurikuler_id', $group->ekstrakurikuler_id)
                ->where('tanggal', $group->tanggal)
                ->where('topik', $group->topik)
                ->update(['sesi_id' => $sesiId]);
        }

        // 3. Drop old constraint, add new ones
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropUnique('unique_absensi_per_hari');
            $table->unique(['sesi_id', 'siswa_id'], 'unique_absensi_per_sesi');
            $table->index('sesi_id', 'idx_absensi_sesi_id');
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropUnique('unique_absensi_per_sesi');
            $table->dropIndex('idx_absensi_sesi_id');
            $table->dropColumn('sesi_id');
            $table->unique(['ekstrakurikuler_id', 'siswa_id', 'tanggal'], 'unique_absensi_per_hari');
        });
    }
};
