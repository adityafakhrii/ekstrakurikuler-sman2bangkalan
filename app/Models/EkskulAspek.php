<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EkskulAspek extends Model
{
    protected $table = 'ekskul_aspek';

    public $timestamps = false;

    protected $fillable = [
        'ekstrakurikuler_id',
        'aspek_penilaian_id',
        'bobot',
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    public function ekstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }

    public function aspekPenilaian(): BelongsTo
    {
        return $this->belongsTo(AspekPenilaian::class, 'aspek_penilaian_id');
    }
}
