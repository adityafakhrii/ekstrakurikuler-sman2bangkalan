<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // We'll just truncate and let the seeder fill it correctly
        Schema::disableForeignKeyConstraints();
        DB::table('ekskul_aspek')->truncate();
        DB::table('aspek_penilaian')->truncate();
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Nothing to do
    }
};
