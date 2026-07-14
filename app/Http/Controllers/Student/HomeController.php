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

        $registrations = Pendaftaran::select('id', 'siswa_id', 'ekstrakurikuler_id', 'status', 'created_at')
            ->with(['ekstrakurikuler' => fn($q) => $q->select('id', 'nama', 'deskripsi', 'logo')])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(10);

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

        $pendaftaran = Pendaftaran::select('id', 'siswa_id', 'ekstrakurikuler_id', 'tahun_ajaran', 'status', 'catatan_siswa', 'catatan_ketua', 'disetujui_at')
            ->with([
                'ekstrakurikuler' => fn($q) => $q->select('id', 'nama', 'deskripsi', 'logo', 'pembina', 'whatsapp_group', 'jadwal', 'ketua_id'),
                'ekstrakurikuler.ketua' => fn($q) => $q->select('id', 'name'),
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nis', 'nisn', 'kelas', 'rombel', 'jurusan', 'no_telp'),
                'siswa.user' => fn($q) => $q->select('id', 'name', 'email')
            ])
            ->where('siswa_id', $siswa->id)
            ->findOrFail($id);

        return view('student.riwayat.show', compact('pendaftaran'));
    }
}
