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
        $siswas = Siswa::select('id', 'user_id', 'nis', 'kelas', 'jurusan', 'jenis_kelamin', 'no_telp', 'tahun_masuk', 'created_at')
            ->with('user:id,name')
            ->when($search, function ($query, $search) {
                return $query->where('nis', 'like', "%{$search}%")
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
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $user = User::create([
                    'name'     => $validated['nama_siswa'],
                    'username' => $validated['nis'],
                    'password' => Hash::make(config('ekskul.password_default_siswa')),
                    'role'     => 'siswa',
                ]);

                Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $validated['nis'],
                    'kelas' => $validated['kelas'],
                    'jurusan' => $validated['jurusan'],
                    'no_telp' => $validated['no_hp'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'tahun_masuk' => $validated['tahun_masuk'],
                ]);
            });
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['nis' => 'Mohon maaf, nomor NIS tersebut sudah terdaftar untuk siswa lain di sistem. Silakan periksa kembali nomor NIS yang dimasukkan.']);
        } catch (\Exception $e) {
            \Log::error('Gagal menambahkan siswa: ' . $e->getMessage());
            return back()->withInput()->withErrors(['nama_siswa' => 'Terjadi kesalahan sistem saat menyimpan data siswa. Silakan coba kembali nanti atau hubungi Administrator jika kendala berlanjut.']);
        }

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

        try {
            DB::transaction(function () use ($request, $siswa) {
                $validated = $request->validated();

                $siswa->update([
                    'nis' => $validated['nis'],
                    'kelas' => $validated['kelas'],
                    'jurusan' => $validated['jurusan'],
                    'no_telp' => $validated['no_hp'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'tahun_masuk' => $validated['tahun_masuk'],
                ]);

                $siswa->user->update([
                    'name' => $validated['nama_siswa'],
                    'username' => $validated['nis'],
                ]);
            });
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['nis' => 'Mohon maaf, nomor NIS tersebut sudah digunakan oleh siswa lain. Silakan periksa kembali nomor NIS yang dimasukkan.']);
        } catch (\Exception $e) {
            \Log::error('Gagal mengubah siswa: ' . $e->getMessage());
            return back()->withInput()->withErrors(['nama_siswa' => 'Terjadi kesalahan sistem saat memperbarui data siswa. Silakan coba kembali nanti atau hubungi Administrator jika kendala berlanjut.']);
        }

        return redirect()->route('pengguna.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
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
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus siswa: ' . $e->getMessage());
            return redirect()->route('pengguna.siswa.index')->with('error', 'Terjadi kesalahan sistem saat menghapus data siswa. Silakan coba kembali nanti.');
        }

        return redirect()->route('pengguna.siswa.index')->with('success', 'Siswa beserta data terkait berhasil dihapus.');
    }
}
