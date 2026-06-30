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

// Logout (Dummy - arahkan kembali ke Login)
Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

require __DIR__.'/settings.php';
