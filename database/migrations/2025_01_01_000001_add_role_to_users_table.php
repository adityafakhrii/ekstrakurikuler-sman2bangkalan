<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role untuk multi-role auth
            $table->enum('role', ['admin', 'ketua', 'siswa'])->default('siswa')->after('email');
            
            // Username untuk admin & ketua login
            $table->string('username')->nullable()->unique()->after('role');
            
            // NISN untuk siswa login
            $table->string('nisn')->nullable()->unique()->after('username');
            
            // No HP
            $table->string('no_hp')->nullable()->after('nisn');
        });

        // Email jadi nullable karena tidak semua user pakai email
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropUnique(['nisn']);
            $table->dropColumn(['role', 'username', 'nisn', 'no_hp']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }
};
