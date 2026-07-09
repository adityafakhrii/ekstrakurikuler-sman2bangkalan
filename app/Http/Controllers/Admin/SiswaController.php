<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(): View
    {
        $siswas = Siswa::with('user')->latest()->get();

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['nama_siswa'],
                'nisn' => $validated['nisn'],
                'no_hp' => $validated['no_hp'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $validated['nisn'],
                'nisn' => $validated['nisn'],
                'kelas' => 'X',
                'rombel' => 'X MIPA 1',
                'jurusan' => 'MIPA',
                'no_telp' => $validated['no_hp'],
                'jenis_kelamin' => 'L',
                'tahun_masuk' => now()->format('Y'),
            ]);
        });

        return redirect()->route('pengguna.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(UpdateSiswaRequest $request, int $id): RedirectResponse
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        DB::transaction(function () use ($request, $siswa) {
            $validated = $request->validated();

            $siswa->update([
                'nis' => $validated['nisn'],
                'nisn' => $validated['nisn'],
                'no_telp' => $validated['no_hp'],
            ]);

            $siswa->user->update([
                'name' => $validated['nama_siswa'],
                'nisn' => $validated['nisn'],
                'no_hp' => $validated['no_hp'],
            ]);
        });

        return redirect()->route('pengguna.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }
}
