<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class KetuaDashboardController extends Controller
{
    public function index(): View
    {
        $ekskul = auth()->user()->ekstrakurikuler;
        $userId = auth()->id();

        $stats = Cache::remember("ketua.dashboard.stats.{$userId}", now()->addMinutes(15), function () use ($ekskul) {
            $statsData = [
                'menunggu' => 0,
                'disetujui' => 0,
                'ditolak' => 0,
                'total' => 0,
            ];

            if ($ekskul) {
                $counts = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
                    ->selectRaw("count(*) as total")
                    ->selectRaw("sum(status = 'menunggu') as menunggu")
                    ->selectRaw("sum(status = 'disetujui') as disetujui")
                    ->selectRaw("sum(status = 'ditolak') as ditolak")
                    ->first();

                $statsData['menunggu'] = (int) $counts->menunggu;
                $statsData['disetujui'] = (int) $counts->disetujui;
                $statsData['ditolak'] = (int) $counts->ditolak;
                $statsData['total'] = (int) $counts->total;
            }

            return $statsData;
        });

        $ekskulNama = $ekskul ? $ekskul->nama : 'Tidak ada Ekstrakurikuler yang dipimpin';

        return view('ketua.dashboard.index', compact('stats', 'ekskulNama'));
    }

    public function pendaftaran(): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $pendaftarans = Pendaftaran::select('id', 'siswa_id', 'ekstrakurikuler_id', 'status', 'catatan_siswa', 'catatan_ketua', 'created_at')
            ->with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nisn', 'kelas', 'rombel', 'jurusan', 'no_telp'),
                'siswa.user' => fn($q) => $q->select('id', 'name', 'email')
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->latest()
            ->paginate(15);

        return view('ketua.pendaftaran.index', compact('pendaftarans', 'ekskul'));
    }

    public function approve(Request $request, int $id): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;
        $pendaftaran = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)->findOrFail($id);

        $pendaftaran->update([
            'status' => 'disetujui',
            'catatan_ketua' => $request->input('catatan_ketua'),
            'disetujui_at' => now(),
            'disetujui_oleh' => auth()->id(),
        ]);

        // Invalidate stats cache
        Cache::forget("ketua.dashboard.stats." . auth()->id());
        Cache::forget("admin.dashboard.stats");

        return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;
        $pendaftaran = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)->findOrFail($id);

        $pendaftaran->update([
            'status' => 'ditolak',
            'catatan_ketua' => $request->input('catatan_ketua'),
            'disetujui_at' => now(),
            'disetujui_oleh' => auth()->id(),
        ]);

        // Invalidate stats cache
        Cache::forget("ketua.dashboard.stats." . auth()->id());
        Cache::forget("admin.dashboard.stats");

        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
