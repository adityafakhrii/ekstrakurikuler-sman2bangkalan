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
        $search = request('search');
        $siswas = Siswa::select('id', 'user_id', 'nis', 'nisn', 'kelas', 'rombel', 'jurusan', 'jenis_kelamin', 'no_telp', 'tahun_masuk')
            ->with('user:id,name')
            ->when($search, function ($query, $search) {
                return $query->where('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('jurusan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($this->perPage())
            ->withQueryString();

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
                'name'     => $validated['nama_siswa'],
                'username' => $validated['nisn'],
                'password' => Hash::make(config('ekskul.password_default_siswa')),
                'role'     => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'],
                'kelas' => $validated['kelas'],
                'rombel' => $validated['rombel'],
                'jurusan' => $validated['jurusan'],
                'no_telp' => $validated['no_hp'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tahun_masuk' => $validated['tahun_masuk'],
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
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'],
                'kelas' => $validated['kelas'],
                'rombel' => $validated['rombel'],
                'jurusan' => $validated['jurusan'],
                'no_telp' => $validated['no_hp'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tahun_masuk' => $validated['tahun_masuk'],
            ]);

            $siswa->user->update([
                'name' => $validated['nama_siswa'],
                'username' => $validated['nisn'],
            ]);
        });

        return redirect()->route('pengguna.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {
            $siswa = Siswa::with('user')->findOrFail($id);
            $userId = $siswa->user_id;

            // Hapus pendaftaran siswa
            $siswa->pendaftarans()->delete();

            // Hapus data siswa
            $siswa->delete();

            // Hapus user
            User::where('id', $userId)->delete();
        });

        return redirect()->route('pengguna.siswa.index')->with('success', 'Siswa beserta data terkait berhasil dihapus.');
    }
}
