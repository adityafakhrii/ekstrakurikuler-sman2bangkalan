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
            $table->dropColumn([
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
            $table->string('banner')->nullable();
            $table->string('hari_latihan')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->text('prestasi')->nullable();
        });
    }
};
