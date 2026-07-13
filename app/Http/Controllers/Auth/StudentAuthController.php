<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginSiswaRequest;
use App\Models\Siswa;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class StudentAuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isSiswa()) {
                return redirect()->route('siswa.home');
            }
            $redirectRoute = $user->isAdmin() ? 'dashboard' : 'ketua.dashboard';

            return redirect()->route($redirectRoute)->with('error', 'Silakan logout terlebih dahulu untuk masuk sebagai Siswa.');
        }

        return view('auth.student.login');
    }

    public function login(LoginSiswaRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $nisn = $validated['nisn'];

        try {
            if (! \Schema::hasTable('siswa')) {
                return back()
                    ->withInput($request->only('nisn'))
                    ->withErrors(['nisn' => 'Gagal masuk. Terjadi gangguan pada sistem, silakan hubungi Administrator.']);
            }

            $siswa = Siswa::with('user')
                ->where('nisn', $nisn)
                ->first();

            if (! $siswa || ! $siswa->user) {
                return back()
                    ->withInput($request->only('nisn'))
                    ->withErrors(['nisn' => 'NISN tidak terdaftar. Silakan hubungi Administrator.']);
            }

            /** @var \App\Models\User $user */
            $user = $siswa->user;

            if (! $user->isSiswa()) {
                return back()
                    ->withInput($request->only('nisn'))
                    ->withErrors(['nisn' => 'Akun Anda tidak terdaftar sebagai Siswa.']);
            }

            $request->session()->regenerate();
            Auth::login($user, $request->boolean('remember'));

            session()->flash('success', 'Selamat datang, '.$user->name.'!');

            return redirect()->intended(route('siswa.home'));

        } catch (QueryException $e) {
            \Log::error('Database error during student login: '.$e->getMessage());

            return back()
                ->withInput($request->only('nisn'))
                ->withErrors(['nisn' => 'Gagal masuk. Terjadi gangguan pada sistem, silakan hubungi Administrator.']);
        }
    }
}
