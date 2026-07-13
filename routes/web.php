<?php

use App\Http\Controllers\Admin\EkskulController;
use App\Http\Controllers\Admin\KetuaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Student\PendaftaranController;
use Illuminate\Support\Facades\Route;

// =======================
// RUTE AUTENTIKASI
// =======================

// Root redirect ke login admin
Route::get('/', function () {
    return redirect()->route('login');
});

// --- Login Admin & Ketua ---
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login']);

// --- Login Siswa ---
Route::get('/siswa/login', [StudentAuthController::class, 'showLoginForm'])->name('siswa.login');
Route::post('/siswa/login', [StudentAuthController::class, 'login']);

// --- Logout ---
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// --- Entry siswa ---
Route::get('/siswa', function () {
    if (auth()->check()) {
        if (auth()->user()->isSiswa()) {
            return view('student.home.index');
        }

        $redirectRoute = auth()->user()->isAdmin() ? 'dashboard' : 'ketua.dashboard';

        return redirect()->route($redirectRoute)->with('error', 'Silakan logout terlebih dahulu untuk masuk sebagai Siswa.');
    }

    return redirect()->route('siswa.login');
})->name('siswa.home');

// =======================
// RUTE ADMIN (Dashboard, Ekskul, Pengguna)
// =======================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

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

    // CRUD Admin
    Route::get('/pengguna/admin', [UserController::class, 'index'])->name('pengguna.admin.index');
    Route::get('/pengguna/admin/create', [UserController::class, 'create'])->name('pengguna.admin.create');
    Route::get('/pengguna/admin/{id}/edit', [UserController::class, 'edit'])->name('pengguna.admin.edit');
    Route::post('/pengguna/admin', [UserController::class, 'store'])->name('pengguna.admin.store');
    Route::put('/pengguna/admin/{id}', [UserController::class, 'update'])->name('pengguna.admin.update');
    Route::delete('/pengguna/admin/{id}', [UserController::class, 'destroy'])->name('pengguna.admin.destroy');

    // Profil/Manage Akun
    Route::get('/settings/profile', function () {
        return view('admin.profile.edit');
    })->name('profile.edit');

    Route::patch('/settings/profile', function () {
        return redirect()->route('dashboard');
    })->name('profile.update');
});

// =======================
// RUTE KETUA
// =======================
Route::prefix('ketua')->name('ketua.')->middleware(['auth', 'role:ketua'])->group(function () {
    Route::get('/dashboard', function () {
        return view('ketua.dashboard.index');
    })->name('dashboard');
});

// =======================
// RUTE SISWA
// =======================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {

    // Rekomendasi
    Route::get('/rekomendasi', function () {
        return view('student.rekomendasi.create');
    })->name('rekomendasi.create');

    Route::post('/rekomendasi', function () {
        return redirect()->route('siswa.rekomendasi.results');
    })->name('rekomendasi.store');

    Route::get('/rekomendasi/hasil', function () {
        return view('student.rekomendasi.results');
    })->name('rekomendasi.results');

    // Daftar & Detail Ekskul
    Route::get('/ekskul', function () {
        return view('student.ekstrakurikuler.index');
    })->name('ekskul.index');

    Route::get('/ekskul/{id}', function () {
        return view('student.ekstrakurikuler.show');
    })->name('ekskul.show');

    // Pendaftaran
    Route::get('/ekskul/{id}/daftar', [PendaftaranController::class, 'create'])->name('register.create');

    Route::post('/ekskul/{id}/daftar', [PendaftaranController::class, 'store'])->name('register.store');

    // Riwayat
    Route::get('/riwayat', function () {
        return view('student.riwayat.index');
    })->name('register.history');

    Route::get('/riwayat/{id}', function () {
        return view('student.riwayat.show');
    })->name('register.history.show');
});
