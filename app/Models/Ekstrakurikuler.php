<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Ekstrakurikuler extends Model
{
    use HasFactory;

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

    /**
     * Dapatkan URL logo yang valid, baik untuk default maupun upload.
     */
    public function getLogoUrlAttribute(): string
    {
        if (!$this->logo) {
            return 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop';
        }

        if (str_starts_with($this->logo, 'http') || str_starts_with($this->logo, '/')) {
            return asset($this->logo);
        }

        if (str_starts_with($this->logo, 'images/')) {
            return asset($this->logo);
        }

        return asset('storage/' . $this->logo);
    }
}
