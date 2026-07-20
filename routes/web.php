<?php

use App\Http\Controllers\Admin\EkskulController;
use App\Http\Controllers\Admin\KetuaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Ketua\KetuaDashboardController;
use App\Http\Controllers\Student\EkskulController as StudentEkskulController;
use App\Http\Controllers\Student\PendaftaranController;
use App\Http\Controllers\Student\RekomendasiController;
use App\Http\Controllers\Student\HomeController;
use Illuminate\Support\Facades\Route;

// =======================
// RUTE AUTENTIKASI
// =======================

// Root redirect ke login admin
Route::redirect('/', '/login');

// --- Login Admin & Ketua ---
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login']);

// --- Login Siswa ---
Route::get('/siswa/login', [StudentAuthController::class, 'showLoginForm'])->name('siswa.login');
Route::post('/siswa/login', [StudentAuthController::class, 'login']);

// --- Logout ---
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// --- Entry siswa ---
Route::get('/siswa', [HomeController::class, 'index'])->name('siswa.home');

// =======================
// RUTE ADMIN (Dashboard, Ekskul, Pengguna)
// =======================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Ekstrakurikuler
    Route::get('/ekskul', [EkskulController::class, 'index'])->name('ekskul.index');
    Route::get('/ekskul/create', [EkskulController::class, 'create'])->name('ekskul.create');
    Route::get('/ekskul/{id}', [EkskulController::class, 'show'])->name('ekskul.show');
    Route::get('/ekskul/{id}/edit', [EkskulController::class, 'edit'])->name('ekskul.edit');
    Route::post('/ekskul', [EkskulController::class, 'store'])->name('ekskul.store');
    Route::put('/ekskul/{id}', [EkskulController::class, 'update'])->name('ekskul.update');
    Route::delete('/ekskul/{id}', [EkskulController::class, 'destroy'])->name('ekskul.destroy');

    // CRUD Ketua
    Route::get('/pengguna/ketua', [KetuaController::class, 'index'])->name('pengguna.ketua.index');
    Route::get('/pengguna/ketua/create', [KetuaController::class, 'create'])->name('pengguna.ketua.create');
    Route::get('/pengguna/ketua/{id}/edit', [KetuaController::class, 'edit'])->name('pengguna.ketua.edit');
    Route::post('/pengguna/ketua', [KetuaController::class, 'store'])->name('pengguna.ketua.store');
    Route::put('/pengguna/ketua/{id}', [KetuaController::class, 'update'])->name('pengguna.ketua.update');
    Route::delete('/pengguna/ketua/{id}', [KetuaController::class, 'destroy'])->name('pengguna.ketua.destroy');

    // CRUD Siswa
    Route::get('/pengguna/siswa', [SiswaController::class, 'index'])->name('pengguna.siswa.index');
    Route::get('/pengguna/siswa/create', [SiswaController::class, 'create'])->name('pengguna.siswa.create');
    Route::get('/pengguna/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('pengguna.siswa.edit');
    Route::post('/pengguna/siswa', [SiswaController::class, 'store'])->name('pengguna.siswa.store');
    Route::put('/pengguna/siswa/{id}', [SiswaController::class, 'update'])->name('pengguna.siswa.update');
    Route::delete('/pengguna/siswa/{id}', [SiswaController::class, 'destroy'])->name('pengguna.siswa.destroy');

    // CRUD Admin
    Route::get('/pengguna/admin', [UserController::class, 'index'])->name('pengguna.admin.index');
    Route::get('/pengguna/admin/create', [UserController::class, 'create'])->name('pengguna.admin.create');
    Route::get('/pengguna/admin/{id}/edit', [UserController::class, 'edit'])->name('pengguna.admin.edit');
    Route::post('/pengguna/admin', [UserController::class, 'store'])->name('pengguna.admin.store');
    Route::put('/pengguna/admin/{id}', [UserController::class, 'update'])->name('pengguna.admin.update');
    Route::delete('/pengguna/admin/{id}', [UserController::class, 'destroy'])->name('pengguna.admin.destroy');

    Route::get('/settings/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/settings/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/settings/profile/clear-recommendations', [AdminProfileController::class, 'clearRecommendations'])->name('admin.profile.clear-recommendations');

    // Export Data
    Route::get('/export/siswa', [ExportController::class, 'exportSiswa'])->name('export.siswa');
    Route::get('/export/ketua', [ExportController::class, 'exportKetua'])->name('export.ketua');
    Route::get('/export/pendaftaran', [ExportController::class, 'exportPendaftaran'])->name('export.pendaftaran');
    Route::get('/export/ekskul', [ExportController::class, 'exportEkskul'])->name('export.ekskul');
});

// =======================
// RUTE KETUA
// =======================
Route::prefix('ketua')->name('ketua.')->middleware(['auth', 'role:ketua'])->group(function () {
    Route::get('/dashboard', [KetuaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pendaftaran', [KetuaDashboardController::class, 'pendaftaran'])->name('pendaftaran.index');
    Route::post('/pendaftaran/{id}/approve', [KetuaDashboardController::class, 'approve'])->name('pendaftaran.approve');
    Route::post('/pendaftaran/{id}/reject', [KetuaDashboardController::class, 'reject'])->name('pendaftaran.reject');
    Route::patch('/pendaftaran/{id}/status', [KetuaDashboardController::class, 'updateStatus'])->name('pendaftaran.status');

    // Data Anggota
    Route::get('/anggota', [KetuaDashboardController::class, 'anggota'])->name('anggota.index');
    Route::post('/anggota/{id}/kick', [KetuaDashboardController::class, 'anggotaKick'])->name('anggota.kick');

    // Data Absensi
    Route::get('/absensi', [KetuaDashboardController::class, 'absensi'])->name('absensi.index');
    Route::post('/absensi', [KetuaDashboardController::class, 'absensiStore'])->name('absensi.store');
    Route::get('/absensi/laporan', [KetuaDashboardController::class, 'absensiReport'])->name('absensi.report');
    Route::get('/absensi/export/pdf', [KetuaDashboardController::class, 'absensiExport'])->name('absensi.export');
    Route::get('/absensi/{tanggal}', [KetuaDashboardController::class, 'absensiShow'])->name('absensi.show');
    Route::put('/absensi/{tanggal}', [KetuaDashboardController::class, 'absensiUpdate'])->name('absensi.update');
    Route::delete('/absensi/{tanggal}', [KetuaDashboardController::class, 'absensiDestroy'])->name('absensi.destroy');
});

// =======================
// RUTE SISWA
// =======================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {

    // Rekomendasi
    Route::get('/rekomendasi', [RekomendasiController::class, 'create'])->name('rekomendasi.create');
    Route::post('/rekomendasi', [RekomendasiController::class, 'store'])->name('rekomendasi.store');
    Route::get('/rekomendasi/hasil', [RekomendasiController::class, 'results'])->name('rekomendasi.results');

    // Daftar & Detail Ekskul
    Route::get('/ekskul', [StudentEkskulController::class, 'index'])->name('ekskul.index');
    Route::get('/ekskul/{id}', [StudentEkskulController::class, 'show'])->name('ekskul.show');

    // Pendaftaran
    Route::get('/ekskul/{id}/daftar', [PendaftaranController::class, 'create'])->name('register.create');
    Route::post('/ekskul/{id}/daftar', [PendaftaranController::class, 'store'])->name('register.store');

    // Riwayat
    Route::get('/riwayat', [HomeController::class, 'history'])->name('register.history');
    Route::get('/riwayat/{id}', [HomeController::class, 'historyShow'])->name('register.history.show');
});
