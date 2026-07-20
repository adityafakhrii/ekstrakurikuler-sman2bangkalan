<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;

Schedule::call(function () {
    $days = DB::table('pengaturan')->where('key', 'auto_delete_rekomendasi')->value('value') ?: 30;
    $date = now()->subDays((int) $days);
    $expiredIds = DB::table('rekomendasi')
        ->where('created_at', '<', $date)
        ->pluck('id');
    DB::table('rekomendasi_hasil')->whereIn('rekomendasi_id', $expiredIds)->delete();
})->daily()->name('cleanup-expired-recommendations');
