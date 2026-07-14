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
        'banner',
        'kuota',
        'status',
        'kategori',
        'hari_latihan',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'tahun_ajaran',
        'persyaratan',
        'prestasi',
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

    /**
     * Scope: hanya ekskul dengan status 'aktif'.
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }
}
