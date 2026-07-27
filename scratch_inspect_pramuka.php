<?php

use App\Models\Absensi;
use App\Models\Ekstrakurikuler;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ekskul = Ekstrakurikuler::where('nama', 'like', '%Pramuka%')->first();
if (!$ekskul) {
    echo "Ekskul Pramuka tidak ditemukan!\n";
    $ekskul = Ekstrakurikuler::find(1); // fallback
}

echo "Ekskul ID: {$ekskul->id} ({$ekskul->nama})\n";

$latest = Absensi::where('ekstrakurikuler_id', $ekskul->id)->latest('id')->take(20)->get();
if ($latest->isEmpty()) {
    echo "Tidak ada data absensi untuk ekskul ini.\n";
}
foreach ($latest as $row) {
    echo "ID: {$row->id}, Sesi: {$row->sesi_id}, Siswa: {$row->siswa_id}, Tgl: {$row->tanggal->format('Y-m-d')}, Topik: {$row->topik}, Status: {$row->status}\n";
}
