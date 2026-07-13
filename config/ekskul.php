<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Ekstrakurikuler
    |--------------------------------------------------------------------------
    */

    // Tahun ajaran aktif default
    'tahun_ajaran' => env('EKSKUL_TAHUN_AJARAN', '2024/2025'),

    // Kuota default per ekstrakurikuler
    'kuota_default' => (int) env('EKSKUL_KUOTA_DEFAULT', 30),

    // Password default untuk siswa baru
    'password_default_siswa' => env('EKSKUL_PASSWORD_DEFAULT_SISWA', 'password'),
];
