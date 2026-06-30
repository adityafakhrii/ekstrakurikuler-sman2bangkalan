<?php

use Illuminate\Support\Facades\Route;

// Rute Root redirect ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Tampilan Login (Dummy)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Aksi Login POST (Dummy - Bypass langsung ke Dashboard)
Route::post('/login', function () {
    return redirect()->route('dashboard');
});

// Rute Dashboard (Bypass Middleware Auth sementara untuk status Dummy)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Rute Ekstrakurikuler (Dummy)
Route::get('/ekskul', function () {
    return view('ekskul.index');
})->name('ekskul.index');

Route::get('/ekskul/create', function () {
    return view('ekskul.create');
})->name('ekskul.create');

Route::get('/ekskul/{id}/edit', function () {
    return view('ekskul.edit');
})->name('ekskul.edit');

Route::post('/ekskul', function () {
    return redirect()->route('ekskul.index');
})->name('ekskul.store');

Route::put('/ekskul/{id}', function () {
    return redirect()->route('ekskul.index');
})->name('ekskul.update');

// Rute CRUD Ketua Pengguna (Dummy)
Route::get('/pengguna/ketua', function () {
    return view('pengguna.ketua.index');
})->name('pengguna.ketua.index');

Route::get('/pengguna/ketua/create', function () {
    return view('pengguna.ketua.create');
})->name('pengguna.ketua.create');

Route::get('/pengguna/ketua/{id}/edit', function () {
    return view('pengguna.ketua.edit');
})->name('pengguna.ketua.edit');

Route::post('/pengguna/ketua', function () {
    return redirect()->route('pengguna.ketua.index');
})->name('pengguna.ketua.store');

Route::put('/pengguna/ketua/{id}', function () {
    return redirect()->route('pengguna.ketua.index');
})->name('pengguna.ketua.update');

// Rute CRUD Siswa Pengguna (Dummy)
Route::get('/pengguna/siswa', function () {
    return view('pengguna.siswa.index');
})->name('pengguna.siswa.index');

Route::get('/pengguna/siswa/create', function () {
    return view('pengguna.siswa.create');
})->name('pengguna.siswa.create');

Route::get('/pengguna/siswa/{id}/edit', function () {
    return view('pengguna.siswa.edit');
})->name('pengguna.siswa.edit');

Route::post('/pengguna/siswa', function () {
    return redirect()->route('pengguna.siswa.index');
})->name('pengguna.siswa.store');

Route::put('/pengguna/siswa/{id}', function () {
    return redirect()->route('pengguna.siswa.index');
})->name('pengguna.siswa.update');

// Rute CRUD Admin Pengguna (Dummy)
Route::get('/pengguna/admin', function () {
    return view('pengguna.admin.index');
})->name('pengguna.admin.index');

Route::get('/pengguna/admin/create', function () {
    return view('pengguna.admin.create');
})->name('pengguna.admin.create');

Route::get('/pengguna/admin/{id}/edit', function () {
    return view('pengguna.admin.edit');
})->name('pengguna.admin.edit');

Route::post('/pengguna/admin', function () {
    return redirect()->route('pengguna.admin.index');
})->name('pengguna.admin.store');

Route::put('/pengguna/admin/{id}', function () {
    return redirect()->route('pengguna.admin.index');
})->name('pengguna.admin.update');

// Logout (Dummy - arahkan kembali ke Login)
Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

require __DIR__.'/settings.php';
