<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AspekPenilaian extends Model
{
    use HasFactory;

    protected $table = 'aspek_penilaian';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'urutan',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function ekskulBobot(): HasMany
    {
        return $this->hasMany(EkskulAspek::class, 'aspek_penilaian_id');
    }
}
