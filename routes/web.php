<?php

use Illuminate\Support\Facades\Route;

// Rute Root redirect ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Tampilan Login Admin (Dummy)
Route::get('/login', function () {
    return view('auth.admin.login');
})->name('login');

// Aksi Login POST Admin (Dummy - Bypass ke Dashboard Admin)
Route::post('/login', function () {
    return redirect()->route('dashboard');
});

// Tampilan Login Siswa (Dummy)
Route::get('/siswa/login', function () {
    return view('auth.student.login');
})->name('siswa.login');

// Aksi Login POST Siswa (Dummy - Bypass ke Home Siswa)
Route::post('/siswa/login', function () {
    return redirect()->route('siswa.home');
});

// Rute Dashboard (Bypass Middleware Auth sementara untuk status Dummy)
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');

// Rute Ekstrakurikuler (Dummy)
Route::get('/ekskul', function () {
    return view('admin.ekstrakurikuler.index');
})->name('ekskul.index');

Route::get('/ekskul/create', function () {
    return view('admin.ekstrakurikuler.create');
})->name('ekskul.create');

Route::get('/ekskul/{id}', function () {
    return view('admin.ekstrakurikuler.show');
})->name('ekskul.show');

Route::get('/ekskul/{id}/edit', function () {
    return view('admin.ekstrakurikuler.edit');
})->name('ekskul.edit');

Route::post('/ekskul', function () {
    return redirect()->route('ekskul.index');
})->name('ekskul.store');

Route::put('/ekskul/{id}', function () {
    return redirect()->route('ekskul.index');
})->name('ekskul.update');

// Rute CRUD Ketua Pengguna (Dummy)
Route::get('/pengguna/ketua', function () {
    return view('admin.ketua.index');
})->name('pengguna.ketua.index');

Route::get('/pengguna/ketua/create', function () {
    return view('admin.ketua.create');
})->name('pengguna.ketua.create');

Route::get('/pengguna/ketua/{id}/edit', function () {
    return view('admin.ketua.edit');
})->name('pengguna.ketua.edit');

Route::post('/pengguna/ketua', function () {
    return redirect()->route('pengguna.ketua.index');
})->name('pengguna.ketua.store');

Route::put('/pengguna/ketua/{id}', function () {
    return redirect()->route('pengguna.ketua.index');
})->name('pengguna.ketua.update');

// Rute CRUD Siswa Pengguna (Dummy)
Route::get('/pengguna/siswa', function () {
    return view('admin.siswa.index');
})->name('pengguna.siswa.index');

Route::get('/pengguna/siswa/create', function () {
    return view('admin.siswa.create');
})->name('pengguna.siswa.create');

Route::get('/pengguna/siswa/{id}/edit', function () {
    return view('admin.siswa.edit');
})->name('pengguna.siswa.edit');

Route::post('/pengguna/siswa', function () {
    return redirect()->route('pengguna.siswa.index');
})->name('pengguna.siswa.store');

Route::put('/pengguna/siswa/{id}', function () {
    return redirect()->route('pengguna.siswa.index');
})->name('pengguna.siswa.update');

// Rute CRUD Admin Pengguna (Dummy)
Route::get('/pengguna/admin', function () {
    return view('admin.users.index');
})->name('pengguna.admin.index');

Route::get('/pengguna/admin/create', function () {
    return view('admin.users.create');
})->name('pengguna.admin.create');

Route::get('/pengguna/admin/{id}/edit', function () {
    return view('admin.users.edit');
})->name('pengguna.admin.edit');

Route::post('/pengguna/admin', function () {
    return redirect()->route('pengguna.admin.index');
})->name('pengguna.admin.store');

Route::put('/pengguna/admin/{id}', function () {
    return redirect()->route('pengguna.admin.index');
})->name('pengguna.admin.update');

// Rute Profil/Kelola Akun (Dummy)
Route::get('/settings/profile', function () {
    return view('admin.profile.edit');
})->name('profile.edit');

Route::patch('/settings/profile', function () {
    return redirect()->route('dashboard');
})->name('profile.update');

// Logout (Dummy - arahkan kembali ke Login)
Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

// Rute Modul Siswa (Student Frontend Rutes)
Route::prefix('siswa')->name('siswa.')->group(function () {
    
    // 1. Home Page
    Route::get('/', function () {
        return view('student.home.index');
    })->name('home');

    // 2. Rekomendasi (Form Aspek Penilaian)
    Route::get('/rekomendasi', function () {
        return view('student.rekomendasi.create');
    })->name('rekomendasi.create');

    Route::post('/rekomendasi', function () {
        return redirect()->route('siswa.rekomendasi.results');
    })->name('rekomendasi.store');

    // 3. Hasil Rekomendasi (Persentase Cocok)
    Route::get('/rekomendasi/hasil', function () {
        return view('student.rekomendasi.results');
    })->name('rekomendasi.results');

    // 4. Daftar Semua Ekskul (Umum)
    Route::get('/ekskul', function () {
        return view('student.ekstrakurikuler.index');
    })->name('ekskul.index');

    // 5. Detail Ekskul
    Route::get('/ekskul/{id}', function () {
        return view('student.ekstrakurikuler.show');
    })->name('ekskul.show');

    // 6. Formulir Pendaftaran Ekskul
    Route::get('/ekskul/{id}/daftar', function () {
        return view('student.pendaftaran.create');
    })->name('register.create');

    Route::post('/ekskul/{id}/daftar', function () {
        return redirect()->route('siswa.register.history');
    })->name('register.store');

    // 7. Riwayat Pendaftaran
    Route::get('/riwayat', function () {
        return view('student.riwayat.index');
    })->name('register.history');

    Route::get('/riwayat/{id}', function () {
        return view('student.riwayat.show');
    })->name('register.history.show');
});

// Rute Modul Ketua (Ketua Frontend Rutes)
Route::prefix('ketua')->name('ketua.')->group(function () {
    Route::get('/dashboard', function () {
        return view('ketua.dashboard.index');
    })->name('dashboard');
});
