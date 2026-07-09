<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Tabel pengumuman: pengumuman dari ekskul untuk anggotanya.
         */
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ekstrakurikuler_id')
                ->constrained('ekstrakurikuler')
                ->cascadeOnDelete();

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete()
                ->comment('Ketua atau admin yang membuat pengumuman');

            $table->string('judul');
            $table->text('isi');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['ekstrakurikuler_id', 'is_published']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
