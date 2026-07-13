<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan landing page atau beranda siswa.
     */
    public function index(): View|RedirectResponse
    {
        if (auth()->check()) {
            if (auth()->user()->isSiswa()) {
                return view('student.home.index');
            }

            $redirectRoute = auth()->user()->isAdmin() ? 'dashboard' : 'ketua.dashboard';

            return redirect()->route($redirectRoute)->with('error', 'Silakan logout terlebih dahulu untuk masuk sebagai Siswa.');
        }

        return redirect()->route('siswa.login');
    }

    /**
     * Tampilkan riwayat pendaftaran siswa.
     */
    public function history(): View
    {
        return view('student.riwayat.index');
    }

    /**
     * Tampilkan detail riwayat pendaftaran.
     */
    public function historyShow(int $id): View
    {
        return view('student.riwayat.show');
    }
}
