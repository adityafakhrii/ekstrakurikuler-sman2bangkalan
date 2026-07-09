<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('success', 'Anda telah berhasil keluar.');

        if ($user?->isSiswa()) {
            return redirect()->route('siswa.login');
        }

        return redirect()->route('login');
    }
}
