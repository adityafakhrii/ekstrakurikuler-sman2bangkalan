<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Logout dan redirect ke halaman login yang sesuai.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('success', 'Anda telah berhasil keluar.');

        // Redirect sesuai role sebelumnya
        if ($user?->isSiswa()) {
            return redirect()->route('siswa.login');
        }

        return redirect()->route('login');
    }
}
