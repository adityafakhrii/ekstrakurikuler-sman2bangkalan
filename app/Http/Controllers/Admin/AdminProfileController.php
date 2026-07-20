<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil admin.
     */
    public function edit(): View
    {
        $autoDeleteSetting = \Illuminate\Support\Facades\DB::table('pengaturan')
            ->where('key', 'auto_delete_rekomendasi')
            ->value('value') ?: '30';

        $recommendationResultsCount = \Illuminate\Support\Facades\DB::table('rekomendasi_hasil')->count();

        return view('admin.profile.edit', compact('autoDeleteSetting', 'recommendationResultsCount'));
    }

    /**
     * Update profil admin.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
            'auto_delete_rekomendasi' => ['required', 'in:3,7,14,30'],
        ]);

        try {
            // Update/insert setting
            \Illuminate\Support\Facades\DB::table('pengaturan')->updateOrInsert(
                ['key' => 'auto_delete_rekomendasi'],
                ['value' => $validated['auto_delete_rekomendasi'], 'updated_at' => now()]
            );

            // Clean up old history immediately (rekomendasi_hasil only)
            $days = (int) $validated['auto_delete_rekomendasi'];
            $date = now()->subDays($days);
            $expiredIds = \Illuminate\Support\Facades\DB::table('rekomendasi')
                ->where('created_at', '<', $date)
                ->pluck('id');

            \Illuminate\Support\Facades\DB::table('rekomendasi_hasil')
                ->whereIn('rekomendasi_id', $expiredIds)
                ->delete();

            $updateData = [
                'name' => $validated['name'],
                'username' => $validated['username'],
            ];

            // Update password jika diisi
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $compressionMsg = '';

            // Handle upload foto profil
            if ($request->hasFile('profile_image')) {
                // Hapus foto lama jika ada
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Kompres dan konversi ke WebP menggunakan ImageHelper
                $uploadResult = \App\Helpers\ImageHelper::convertToWebp(
                    $request->file('profile_image'),
                    'profile_images'
                );

                $updateData['foto'] = $uploadResult['path'];

                $compressionMsg = " Foto profil berhasil dikompresi sebesar {$uploadResult['percentage']}% (dari {$uploadResult['original_size_formatted']} menjadi {$uploadResult['compressed_size_formatted']}).";
            }

            $user->update($updateData);

            return redirect()
                ->route('admin.profile.edit')
                ->with('success', 'Profil berhasil diperbarui.' . $compressionMsg);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Hapus semua data hasil rekomendasi secara manual.
     */
    public function clearRecommendations(): RedirectResponse
    {
        try {
            \Illuminate\Support\Facades\DB::table('rekomendasi_hasil')->delete();

            return redirect()
                ->route('admin.profile.edit')
                ->with('success', 'Semua data hasil rekomendasi berhasil dihapus secara permanen dari database.');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus manual data hasil rekomendasi: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan sistem saat menghapus data hasil rekomendasi: ' . $e->getMessage());
        }
    }
}
