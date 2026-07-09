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

        Pendaftaran::create([
            'siswa_id'           => $siswa->id,
            'ekstrakurikuler_id' => $ekskul->id,
            'status'             => 'menunggu',
            'catatan_siswa'      => $request->validated('catatan_siswa'),
        ]);

        return redirect()
            ->route('siswa.register.history')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }
}
