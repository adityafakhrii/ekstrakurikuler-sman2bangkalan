<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiHasil extends Model
{
    protected $table = 'rekomendasi_hasil';

    public $timestamps = false;

    protected $fillable = [
        'rekomendasi_id',
        'ekstrakurikuler_id',
        'skor',
        'peringkat',
    ];

    protected $casts = [
        'skor' => 'float',
        'peringkat' => 'integer',
    ];

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function ekstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}
