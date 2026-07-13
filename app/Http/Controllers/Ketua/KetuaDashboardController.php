<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KetuaDashboardController extends Controller
{
    public function index(): View
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        $stats = [
            'menunggu' => 0,
            'disetujui' => 0,
            'ditolak' => 0,
            'total' => 0,
        ];

        $ekskulNama = 'Tidak ada Ekstrakurikuler yang dipimpin';

        if ($ekskul) {
            $ekskulNama = $ekskul->nama;
            $counts = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
                ->selectRaw("count(*) as total")
                ->selectRaw("sum(status = 'menunggu') as menunggu")
                ->selectRaw("sum(status = 'disetujui') as disetujui")
                ->selectRaw("sum(status = 'ditolak') as ditolak")
                ->first();

            $stats['menunggu'] = (int) $counts->menunggu;
            $stats['disetujui'] = (int) $counts->disetujui;
            $stats['ditolak'] = (int) $counts->ditolak;
            $stats['total'] = (int) $counts->total;
        }

        return view('ketua.dashboard.index', compact('stats', 'ekskulNama'));
    }

    public function pendaftaran(): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $pendaftarans = Pendaftaran::with('siswa.user')
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->latest()
            ->get();

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

        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
