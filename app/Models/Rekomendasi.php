<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';

    protected $fillable = [
        'siswa_id',
        'jawaban',
        'tahun_ajaran',
    ];

    protected $casts = [
        'jawaban' => 'array',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function hasil(): HasMany
    {
        return $this->hasMany(RekomendasiHasil::class, 'rekomendasi_id');
    }
}
