<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginSiswaRequest;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    /**
     * Tampilkan halaman login siswa.
     */
    public function showLoginForm()
    {
        return view('auth.student.login');
    }

    /**
     * Login siswa — hanya pakai NISN (tanpa password).
     * Siswa harus sudah terdaftar oleh admin di tabel siswa.
     */
    public function login(LoginSiswaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $siswa = Siswa::with('user')
            ->where('nisn', $validated['nisn'])
            ->first();

        if (! $siswa || ! $siswa->user || ! $siswa->user->isSiswa()) {
            return back()
                ->withInput($request->only('nisn'))
                ->withErrors(['nisn' => 'NISN tidak ditemukan. Silakan hubungi admin.']);
        }

        Auth::login($siswa->user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('siswa.home'));
    }
}
