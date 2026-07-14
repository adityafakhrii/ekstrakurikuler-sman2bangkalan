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
    public function create(int $id): View
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

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
