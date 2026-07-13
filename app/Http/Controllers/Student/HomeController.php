<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
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
    public function history(): View|RedirectResponse
    {
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            return redirect()->route('siswa.home')->with('error', 'Data siswa tidak ditemukan.');
        }

        $registrations = Pendaftaran::with('ekstrakurikuler')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('student.riwayat.index', compact('registrations'));
    }

    /**
     * Tampilkan detail riwayat pendaftaran.
     */
    public function historyShow(int $id): View|RedirectResponse
    {
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            return redirect()->route('siswa.home')->with('error', 'Data siswa tidak ditemukan.');
        }

        $pendaftaran = Pendaftaran::with(['ekstrakurikuler.ketua', 'siswa.user'])
            ->where('siswa_id', $siswa->id)
            ->findOrFail($id);

        return view('student.riwayat.show', compact('pendaftaran'));
    }
}
