<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', 'admin')
            ->select('id', 'name', 'username', 'email', 'created_at')
            ->latest()
            ->paginate($this->perPage())
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('pengguna.admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $user = User::where('role', 'admin')->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        if (! empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('pengguna.admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        if (auth()->id() === $id) {
            return redirect()->route('pengguna.admin.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::where('role', 'admin')->findOrFail($id);
        $user->delete();

        return redirect()->route('pengguna.admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}
