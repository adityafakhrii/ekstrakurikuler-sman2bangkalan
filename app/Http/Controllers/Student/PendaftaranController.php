<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StorePendaftaranRequest;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    public function create(int $id): View|RedirectResponse
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            return redirect()->route('siswa.ekskul.show', $id)->with('error', 'Data siswa tidak ditemukan.');
        }

        $activeCount = Pendaftaran::where('siswa_id', $siswa->id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        if ($activeCount >= 2) {
            return redirect()->route('siswa.ekskul.show', $id)->with('error', 'Siswa hanya dapat mendaftar maksimal 2 ekstrakurikuler.');
        }

        $alreadyRegistered = Pendaftaran::where('siswa_id', $siswa->id)
            ->where('ekstrakurikuler_id', $id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('siswa.ekskul.show', $id)->with('error', 'Anda sudah pernah mendaftar pada ekstrakurikuler ini.');
        }

        return view('student.pendaftaran.create', compact('ekskul'));
    }

    public function store(StorePendaftaranRequest $request, int $id): RedirectResponse
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $siswa = $request->user()->siswa;

        // Update profil siswa secara dinamis dari input form
        $kelasJurusan = $request->validated('kelas_jurusan');
        $parts = explode(' ', $kelasJurusan, 2);
        $kelas = $parts[0] ?? 'X';
        $rombel = $parts[1] ?? $kelasJurusan;

        $siswa->user->update([
            'email' => $request->validated('email')
        ]);

        $siswa->update([
            'no_telp' => $request->validated('no_whatsapp'),
            'alamat' => $request->validated('alamat'),
            'kelas' => $kelas,
            'rombel' => $rombel,
        ]);

        Pendaftaran::create([
            'siswa_id' => $siswa->id,
            'ekstrakurikuler_id' => $ekskul->id,
            'tahun_ajaran' => config('ekskul.tahun_ajaran'),
            'status' => 'menunggu',
            'alamat' => $request->validated('alamat'),
            'catatan_siswa' => $request->validated('catatan_siswa'),
        ]);

        return redirect()
            ->route('siswa.register.history')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }
}
