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
        Schema::table('rekomendasi_hasil', function (Blueprint $table) {
            $table->decimal('skor', 5, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('rekomendasi_hasil', function (Blueprint $table) {
            $table->decimal('skor', 5, 2)->default(0.00)->change();
        });
    }
};
