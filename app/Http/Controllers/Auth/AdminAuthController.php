<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }
            if (Auth::user()->isKetua()) {
                return redirect()->route('ketua.dashboard');
            }
        }
        return view('auth.admin.login');
    }

    /**
     * Proses login admin/ketua.
     */
    public function login(LoginAdminRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $loginInput = $credentials['username'];

        try {
            // Tentukan apakah input berupa email
            if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Harap masukkan Username, bukan alamat Email.']);
            }

            // Cari user berdasarkan username
            $query = \App\Models\User::query();
            
            // Cek apakah kolom username ada di tabel
            if (\Schema::hasColumn('users', 'username')) {
                $user = $query->where('username', $loginInput)->first();
            } else {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Gagal masuk. Terjadi gangguan pada sistem, silakan hubungi Administrator.']);
            }

            // Jika user tidak ditemukan
            if (! $user) {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Username atau password salah.']);
            }

            // Jika role bukan admin/ketua
            if (! $user->hasRole(['admin', 'ketua'])) {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Anda tidak memiliki akses ke halaman ini.']);
            }

            // Coba login
            if (Auth::attempt(['username' => $loginInput, 'password' => $credentials['password']], $request->boolean('remember'))) {
                $request->session()->regenerate();

                session()->flash('success', 'Selamat datang kembali, ' . $user->name . '!');

                if ($user->isAdmin()) {
                    return redirect()->intended(route('dashboard'));
                }

                return redirect()->intended(route('ketua.dashboard'));
            }

            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau password salah.']);

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error during login: ' . $e->getMessage());
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Gagal masuk. Terjadi gangguan pada sistem, silakan hubungi Administrator.']);
        }
    }
}
