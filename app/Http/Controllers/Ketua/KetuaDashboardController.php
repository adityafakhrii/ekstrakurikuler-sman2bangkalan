<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
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

    // =====================
    // DATA ANGGOTA
    // =====================

    public function anggota(Request $request): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $query = Pendaftaran::select('id', 'siswa_id', 'ekstrakurikuler_id', 'status', 'catatan_siswa', 'catatan_ketua', 'disetujui_at', 'created_at')
            ->with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nisn', 'nis', 'kelas', 'rombel', 'jurusan', 'no_telp', 'jenis_kelamin'),
                'siswa.user' => fn($q) => $q->select('id', 'name', 'email'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui');

        // Pencarian berdasarkan nama/NISN
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nisn', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
                });
            });
        }

        $anggota = $query->latest('disetujui_at')->paginate(15)->withQueryString();

        return view('ketua.anggota.index', compact('anggota', 'ekskul'));
    }

    public function anggotaKick(int $id): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;
        $pendaftaran = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui')
            ->findOrFail($id);

        $pendaftaran->update([
            'status' => 'ditolak',
            'catatan_ketua' => 'Dikeluarkan oleh ketua.',
            'disetujui_at' => now(),
            'disetujui_oleh' => auth()->id(),
        ]);

        Cache::forget("ketua.dashboard.stats." . auth()->id());
        Cache::forget("admin.dashboard.stats");

        return redirect()->back()->with('success', 'Anggota berhasil dikeluarkan.');
    }

    // =====================
    // DATA ABSENSI
    // =====================

    public function absensi(Request $request): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        // Ambil daftar tanggal absensi yang pernah dicatat untuk ekskul ini
        $tanggalFilter = $request->input('tanggal');

        $query = Absensi::with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nisn', 'nis', 'kelas', 'rombel', 'jurusan'),
                'siswa.user' => fn($q) => $q->select('id', 'name'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id);

        if ($tanggalFilter) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        $absensiList = $query->latest('tanggal')->latest('id')->paginate(20)->withQueryString();

        // Daftar tanggal unik untuk filter dropdown
        $tanggalOptions = Absensi::where('ekstrakurikuler_id', $ekskul->id)
            ->selectRaw('DISTINCT DATE(tanggal) as tgl')
            ->orderByDesc('tgl')
            ->pluck('tgl');

        // Ambil semua anggota (status disetujui) untuk form tambah absensi
        $anggotaList = Pendaftaran::with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nisn', 'kelas', 'rombel'),
                'siswa.user' => fn($q) => $q->select('id', 'name'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui')
            ->get();

        return view('ketua.absensi.index', compact('absensiList', 'ekskul', 'tanggalOptions', 'tanggalFilter', 'anggotaList'));
    }

    public function absensiStore(Request $request): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|integer|exists:siswa,id',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);

        $tanggal = $request->input('tanggal');

        foreach ($request->input('absensi') as $item) {
            Absensi::updateOrCreate(
                [
                    'ekstrakurikuler_id' => $ekskul->id,
                    'siswa_id' => $item['siswa_id'],
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $item['status'],
                    'keterangan' => $item['keterangan'] ?? null,
                    'dicatat_oleh' => auth()->id(),
                ]
            );
        }

        return redirect()->route('ketua.absensi.index', ['tanggal' => $tanggal])
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function absensiDestroy(int $id): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;
        $absensi = Absensi::where('ekstrakurikuler_id', $ekskul->id)->findOrFail($id);
        $absensi->delete();

        return redirect()->back()->with('success', 'Data absensi berhasil dihapus.');
    }
}
