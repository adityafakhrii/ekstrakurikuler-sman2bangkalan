<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StorePendaftaranRequest;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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

        try {
            DB::transaction(function () use ($request, $siswa, $ekskul) {
                $kelasJurusan = $request->validated('kelas_jurusan');
                $parts = explode(' ', $kelasJurusan, 2);
                $kelas = $parts[0] ?? 'X';
                $jurusan = $parts[1] ?? '';

                $siswa->user->update([
                    'email' => $request->validated('email')
                ]);

                $siswa->update([
                    'no_telp' => $request->validated('no_whatsapp'),
                    'alamat' => $request->validated('alamat'),
                    'kelas' => $kelas,
                    'jurusan' => $jurusan,
                ]);

                Pendaftaran::create([
                    'siswa_id' => $siswa->id,
                    'ekstrakurikuler_id' => $ekskul->id,
                    'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                    'status' => 'menunggu',
                    'alamat' => $request->validated('alamat'),
                    'catatan_siswa' => $request->validated('catatan_siswa'),
                ]);
            });
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return redirect()->route('siswa.ekskul.show', $id)->with('error', 'Mohon maaf, Anda sudah pernah mendaftar di ekstrakurikuler ini. Silakan periksa kembali riwayat pendaftaran Anda.');
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim pendaftaran: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses pendaftaran Anda. Silakan coba kembali nanti atau hubungi Administrator jika kendala berlanjut.');
        }

        return redirect()
            ->route('siswa.register.history')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }
}
