<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKetuaRequest;
use App\Http\Requests\Admin\UpdateKetuaRequest;
use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class KetuaController extends Controller
{
    public function index(): View
    {
        $ketuas = User::where('role', 'ketua')
            ->with('ekstrakurikuler')
            ->latest()
            ->get();

        return view('admin.ketua.index', compact('ketuas'));
    }

    public function create(): View
    {
        $ekskuls = Ekstrakurikuler::whereNull('ketua_id')->get();

        return view('admin.ketua.create', compact('ekskuls'));
    }

    public function store(StoreKetuaRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'ketua',
            ]);

            if (! empty($validated['ekstrakurikuler_id'])) {
                Ekstrakurikuler::where('id', $validated['ekstrakurikuler_id'])
                    ->update(['ketua_id' => $user->id]);
            }
        });

        return redirect()->route('pengguna.ketua.index')->with('success', 'Ketua ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $ketua = User::where('role', 'ketua')->with('ekstrakurikuler')->findOrFail($id);

        // Ekskul yang tidak punya ketua, ditambah ekskul yang saat ini dipimpin oleh ketua ini
        $ekskuls = Ekstrakurikuler::whereNull('ketua_id')
            ->orWhere('ketua_id', $ketua->id)
            ->get();

        return view('admin.ketua.edit', compact('ketua', 'ekskuls'));
    }

    public function update(UpdateKetuaRequest $request, int $id): RedirectResponse
    {
        $ketua = User::where('role', 'ketua')->findOrFail($id);

        DB::transaction(function () use ($request, $ketua) {
            $validated = $request->validated();

            $ketua->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            if (! empty($validated['password'])) {
                $ketua->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            // Hapus asosiasi ketua_id dari ekskul lama ketua ini
            Ekstrakurikuler::where('ketua_id', $ketua->id)->update(['ketua_id' => null]);

            // Asosiasikan ke ekskul baru jika dipilih
            if (! empty($validated['ekstrakurikuler_id'])) {
                Ekstrakurikuler::where('id', $validated['ekstrakurikuler_id'])
                    ->update(['ketua_id' => $ketua->id]);
            }
        });

        return redirect()->route('pengguna.ketua.index')->with('success', 'Ketua ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $ketua = User::where('role', 'ketua')->findOrFail($id);

        DB::transaction(function () use ($ketua) {
            Ekstrakurikuler::where('ketua_id', $ketua->id)->update(['ketua_id' => null]);
            $ketua->delete();
        });

        return redirect()->route('pengguna.ketua.index')->with('success', 'Ketua ekstrakurikuler berhasil dihapus.');
    }
}
