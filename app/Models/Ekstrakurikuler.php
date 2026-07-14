<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ekstrakurikuler extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'ketua_id',
        'nama',
        'slug',
        'deskripsi',
        'logo',
        'kuota',
        'kategori',
        'tahun_ajaran',
        'pembina',
        'whatsapp_group',
        'jadwal',
    ];

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }

    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'ekstrakurikuler_id');
    }
}
