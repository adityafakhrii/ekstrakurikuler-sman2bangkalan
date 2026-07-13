<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }
            if (Auth::user()->isKetua()) {
                return redirect()->route('ketua.dashboard');
            }
            if (Auth::user()->isSiswa()) {
                return redirect()->route('siswa.home')->with('error', 'Silakan logout terlebih dahulu untuk masuk sebagai Admin/Ketua.');
            }
        }

        return view('auth.admin.login');
    }

    public function login(LoginAdminRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $loginInput = $credentials['username'];

        try {

            if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Harap masukkan Username, bukan alamat Email.']);
            }

            $query = User::query();

            if (\Schema::hasColumn('users', 'username')) {
                $user = $query->where('username', $loginInput)->first();
            } else {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Gagal masuk. Terjadi gangguan pada sistem, silakan hubungi Administrator.']);
            }

            if (! $user) {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Username atau password salah.']);
            }

            if (! $user->hasRole(['admin', 'ketua'])) {
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Anda tidak memiliki akses ke halaman ini.']);
            }

            if (Auth::attempt(['username' => $loginInput, 'password' => $credentials['password']], $request->boolean('remember'))) {
                $request->session()->regenerate();

                session()->flash('success', 'Selamat datang kembali, '.$user->name.'!');

                if ($user->isAdmin()) {
                    return redirect()->intended(route('dashboard'));
                }

                return redirect()->intended(route('ketua.dashboard'));
            }

            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau password salah.']);

        } catch (QueryException $e) {
            \Log::error('Database error during login: '.$e->getMessage());

            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Gagal masuk. Terjadi gangguan pada sistem, silakan hubungi Administrator.']);
        }
    }
}
