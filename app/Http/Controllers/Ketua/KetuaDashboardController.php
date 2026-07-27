<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class KetuaDashboardController extends Controller
{
    public function index(): View
    {
        $ekskul = auth()->user()->ekstrakurikuler;
        $stats = [
            'menunggu' => 0,
            'terkonfirmasi' => 0,
            'disetujui' => 0,
            'ditolak' => 0,
            'dibatalkan' => 0,
            'total' => 0,
        ];

        if ($ekskul) {
            $counts = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw("SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) as menunggu")
                ->selectRaw("SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui")
                ->selectRaw("SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak")
                ->selectRaw("SUM(CASE WHEN status = 'dibatalkan' THEN 1 ELSE 0 END) as dibatalkan")
                ->first();

            $stats['menunggu'] = (int) ($counts->menunggu ?? 0);
            $stats['terkonfirmasi'] = (int) (($counts->disetujui ?? 0) + ($counts->ditolak ?? 0) + ($counts->dibatalkan ?? 0));
            $stats['disetujui'] = (int) ($counts->disetujui ?? 0);
            $stats['ditolak'] = (int) ($counts->ditolak ?? 0);
            $stats['dibatalkan'] = (int) ($counts->dibatalkan ?? 0);
            $stats['total'] = (int) ($counts->total ?? 0);
        }

        $ekskulNama = $ekskul ? $ekskul->nama : 'Tidak ada Ekstrakurikuler yang dipimpin';

        return view('ketua.dashboard.index', compact('stats', 'ekskulNama'));
    }

    public function pendaftaran(Request $request): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $query = Pendaftaran::select('id', 'siswa_id', 'ekstrakurikuler_id', 'status', 'catatan_siswa', 'alamat', 'catatan_ketua', 'created_at')
            ->with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nis', 'kelas', 'jurusan', 'no_telp', 'alamat', 'jenis_kelamin'),
                'siswa.user' => fn($q) => $q->select('id', 'name', 'email')
            ])
            ->where('ekstrakurikuler_id', $ekskul->id);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nis', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
                });
            });
        }

        $pendaftarans = $query->latest()->paginate($this->perPage())->withQueryString();

        return view('ketua.pendaftaran.index', compact('pendaftarans', 'ekskul'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak,dibatalkan',
            'catatan_ketua' => 'nullable|string|max:1000',
        ]);

        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $pendaftaran = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)->findOrFail($id);

        $pendaftaran->update([
            'status' => $request->input('status'),
            'catatan_ketua' => $request->input('catatan_ketua'),
            'disetujui_at' => now(),
            'disetujui_oleh' => auth()->id(),
        ]);

        Cache::forget("ketua.dashboard.stats.".auth()->id());
        Cache::forget("admin.dashboard.stats");

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
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
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nis', 'kelas', 'jurusan', 'no_telp', 'jenis_kelamin'),
                'siswa.user' => fn($q) => $q->select('id', 'name', 'email'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui');

        // Pencarian berdasarkan nama/NIS
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nis', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
                });
            });
        }

        $anggota = $query->latest('disetujui_at')->paginate($this->perPage())->withQueryString();

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

        $searchTanggal = $request->input('search_tanggal');
        $searchTopik = $request->input('search_topik');

        // Ambil daftar sesi kegiatan (grouped by sesi_id)
        $query = Absensi::where('ekstrakurikuler_id', $ekskul->id)
            ->selectRaw('sesi_id, MIN(id) as id, tanggal, topik, COUNT(*) as jumlah_siswa')
            ->groupBy('sesi_id', 'tanggal', 'topik');

        if ($searchTanggal) {
            $query->whereDate('tanggal', $searchTanggal);
        }

        if ($searchTopik) {
            $query->where('topik', 'like', "%{$searchTopik}%");
        }

        $kegiatanList = $query->orderByDesc('tanggal')->paginate($this->perPage(10))->withQueryString();

        return view('ketua.absensi.index', compact('kegiatanList', 'ekskul'));
    }

    public function absensiShow(Request $request, string $sesiId): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        // Cari tahu detail sesi dari salah satu absensi dengan sesi_id ini
        $sesi = Absensi::where('ekstrakurikuler_id', $ekskul->id)
            ->where('sesi_id', $sesiId)
            ->first();

        if (! $sesi) {
            return redirect()->route('ketua.absensi.index')->with('error', 'Sesi absensi tidak ditemukan.');
        }

        $tanggal = $sesi->tanggal->format('Y-m-d');
        $topik = $sesi->topik;

        // Ambil data absensi untuk sesi ini
        $absensiList = Absensi::with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nis', 'kelas', 'jurusan'),
                'siswa.user' => fn($q) => $q->select('id', 'name'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('sesi_id', $sesiId)
            ->latest('id')
            ->get();

        // Ambil semua anggota (status disetujui) untuk form absensi
        $anggotaList = Pendaftaran::with([
                'siswa' => fn($q) => $q->select('id', 'user_id', 'nis', 'kelas', 'jurusan'),
                'siswa.user' => fn($q) => $q->select('id', 'name'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui')
            ->get();

        // Cek apakah sudah ada data absensi untuk sesi ini
        $existingAbsensi = Absensi::where('ekstrakurikuler_id', $ekskul->id)
            ->where('sesi_id', $sesiId)
            ->pluck('status', 'siswa_id')
            ->toArray();

        return view('ketua.absensi.show', compact(
            'absensiList', 'ekskul', 'tanggal', 'topik', 'anggotaList', 'existingAbsensi', 'sesiId'
        ));
    }

    public function absensiStore(Request $request): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'topik' => 'required|string|max:255',
        ]);

        $tanggal = $request->input('tanggal');
        $topik = $request->input('topik');

        // Ketua bebas membuat kegiatan dengan tanggal dan topik yang sama.
        // Hapus limitasi unik di tingkat aplikasi.
        $sesiId = (string) \Illuminate\Support\Str::uuid();

        // Ambil semua anggota dan buat record absensi default (alpha)
        $anggotaList = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui')
            ->with('siswa')
            ->get();

        if ($anggotaList->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada anggota yang terdaftar.');
        }

        foreach ($anggotaList as $member) {
            Absensi::create([
                'sesi_id' => $sesiId,
                'ekstrakurikuler_id' => $ekskul->id,
                'siswa_id' => $member->siswa->id,
                'tanggal' => $tanggal,
                'topik' => $topik,
                'status' => 'alpha',
                'dicatat_oleh' => auth()->id(),
            ]);
        }

        return redirect()->route('ketua.absensi.show', [
            'sesi_id' => $sesiId,
        ])->with('success', 'Sesi absensi baru berhasil dibuat.');
    }

    public function absensiUpdate(Request $request, string $sesiId): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $request->validate([
            'topik' => 'required|string|max:255',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|integer|exists:siswa,id',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $topik = $request->input('topik');

        foreach ($request->input('absensi') as $item) {
            Absensi::updateOrCreate(
                [
                    'sesi_id' => $sesiId,
                    'ekstrakurikuler_id' => $ekskul->id,
                    'siswa_id' => $item['siswa_id'],
                ],
                [
                    'topik' => $topik,
                    'status' => $item['status'],
                    'dicatat_oleh' => auth()->id(),
                ]
            );
        }

        return redirect()->route('ketua.absensi.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function absensiReport(Request $request): View|RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $semesterFilter = $request->input('semester', 'all');
        $tahunAjaran = $ekskul->tahun_ajaran ?? '2025/2026';
        $parts = explode('/', $tahunAjaran);
        $tahunAwal = isset($parts[0]) ? (int)$parts[0] : (int)date('Y');
        $tahunAkhir = isset($parts[1]) ? (int)$parts[1] : $tahunAwal + 1;

        $queryAbsensi = Absensi::where('ekstrakurikuler_id', $ekskul->id);

        if ($semesterFilter === 'ganjil') {
            $queryAbsensi->whereBetween('tanggal', ["{$tahunAwal}-07-01", "{$tahunAwal}-12-31"]);
            $semesterLabel = "Semester Ganjil {$tahunAjaran} (Juli {$tahunAwal} - Desember {$tahunAwal})";
        } elseif ($semesterFilter === 'genap') {
            $queryAbsensi->whereBetween('tanggal', ["{$tahunAkhir}-01-01", "{$tahunAkhir}-06-30"]);
            $semesterLabel = "Semester Genap {$tahunAjaran} (Januari {$tahunAkhir} - Juni {$tahunAkhir})";
        } else {
            $semesterLabel = "Tahun Pelajaran {$tahunAjaran}";
        }

        $absensi = $queryAbsensi->get(['siswa_id', 'tanggal', 'topik', 'status']);
        $totalPertemuan = $absensi->map(fn ($item) => $item->tanggal->format('Y-m-d').'|'.($item->topik ?? ''))->unique()->count();

        $anggota = Pendaftaran::with([
                'siswa' => fn ($query) => $query->select('id', 'user_id', 'nis', 'kelas', 'jurusan'),
                'siswa.user' => fn ($query) => $query->select('id', 'name'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui')
            ->get();

        $rows = $anggota->map(function ($member) use ($absensi, $totalPertemuan) {
            $records = $absensi->where('siswa_id', $member->siswa_id);
            $hadir = $records->where('status', 'hadir')->count();
            $sakit = $records->where('status', 'sakit')->count();
            $izin = $records->where('status', 'izin')->count();
            $alpha = $records->where('status', 'alpha')->count();
            $percentage = $totalPertemuan > 0 ? (($hadir + ($sakit * 0.5) + ($izin * 0.5)) / $totalPertemuan) * 100 : 0;
            $rating = match (true) {
                $percentage >= 90 => 'Sangat Baik',
                $percentage >= 85 => 'Baik',
                $percentage >= 75 => 'Cukup',
                $percentage >= 60 => 'Kurang',
                default => 'Sangat Kurang',
            };

            return [
                'nis' => $member->siswa->nis ?? '-',
                'nama' => $member->siswa->user->name ?? '-',
                'tp' => $totalPertemuan,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpha' => $alpha,
                'percentage' => round($percentage, 2),
                'rating' => $rating,
            ];
        });

        return view('ketua.absensi.report', [
            'rows' => $rows,
            'ekskul' => $ekskul,
            'ketua' => $ekskul->ketua,
            'totalPertemuan' => $totalPertemuan,
            'semester' => $semesterLabel,
            'semesterFilter' => $semesterFilter,
        ]);
    }

    public function absensiExport(Request $request)
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        if (! $ekskul) {
            return redirect()->route('ketua.dashboard')->with('error', 'Anda tidak memimpin ekstrakurikuler apa pun.');
        }

        $semesterFilter = $request->input('semester', 'all');
        $tahunAjaran = $ekskul->tahun_ajaran ?? '2025/2026';
        $parts = explode('/', $tahunAjaran);
        $tahunAwal = isset($parts[0]) ? (int)$parts[0] : (int)date('Y');
        $tahunAkhir = isset($parts[1]) ? (int)$parts[1] : $tahunAwal + 1;

        $queryAbsensi = Absensi::where('ekstrakurikuler_id', $ekskul->id);

        if ($semesterFilter === 'ganjil') {
            $queryAbsensi->whereBetween('tanggal', ["{$tahunAwal}-07-01", "{$tahunAwal}-12-31"]);
            $semesterLabel = "Semester Ganjil {$tahunAjaran} (Juli {$tahunAwal} - Desember {$tahunAwal})";
        } elseif ($semesterFilter === 'genap') {
            $queryAbsensi->whereBetween('tanggal', ["{$tahunAkhir}-01-01", "{$tahunAkhir}-06-30"]);
            $semesterLabel = "Semester Genap {$tahunAjaran} (Januari {$tahunAkhir} - Juni {$tahunAkhir})";
        } else {
            $semesterLabel = "Tahun Pelajaran {$tahunAjaran}";
        }

        $absensi = $queryAbsensi->get(['siswa_id', 'tanggal', 'topik', 'status']);

        $totalPertemuan = $absensi
            ->map(fn ($item) => $item->tanggal->format('Y-m-d').'|'.($item->topik ?? ''))
            ->unique()
            ->count();

        $anggota = Pendaftaran::with([
                'siswa' => fn ($query) => $query->select('id', 'user_id', 'nis', 'kelas', 'jurusan'),
                'siswa.user' => fn ($query) => $query->select('id', 'name'),
            ])
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->where('status', 'disetujui')
            ->get();

        $rows = $anggota->map(function ($member, $index) use ($absensi, $totalPertemuan) {
            $records = $absensi->where('siswa_id', $member->siswa_id);
            $hadir = $records->where('status', 'hadir')->count();
            $sakit = $records->where('status', 'sakit')->count();
            $izin = $records->where('status', 'izin')->count();
            $alpha = $records->where('status', 'alpha')->count();
            $percentage = $totalPertemuan > 0
                ? (($hadir + ($sakit * 0.5) + ($izin * 0.5)) / $totalPertemuan) * 100
                : 0;

            $rating = match (true) {
                $percentage >= 90 => 'Sangat Baik',
                $percentage >= 85 => 'Baik',
                $percentage >= 75 => 'Cukup',
                $percentage >= 60 => 'Kurang',
                default => 'Sangat Kurang',
            };

            return [
                'index' => $index + 1,
                'nis' => $member->siswa->nis ?? '-',
                'nama' => $member->siswa->user->name ?? '-',
                'kelas_jurusan' => trim(($member->siswa->kelas ?? '').' '.($member->siswa->jurusan ?? ''), ' '),
                'tp' => $totalPertemuan,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpha' => $alpha,
                'percentage' => round($percentage, 2),
                'rating' => $rating,
            ];
        });

        $pages = $rows->chunk(15);

        $pdf = Pdf::loadView('ketua.absensi.pdf', [
            'pages' => $pages,
            'ekskul' => $ekskul,
            'ketua' => $ekskul->ketua,
            'totalPertemuan' => $totalPertemuan,
            'semester' => $semesterLabel,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-absensi-'.str($ekskul->nama)->slug().'.pdf');
    }

    public function absensiDestroy(Request $request, string $sesiId): RedirectResponse
    {
        $ekskul = auth()->user()->ekstrakurikuler;

        // Hapus semua record absensi untuk sesi ini
        Absensi::where('ekstrakurikuler_id', $ekskul->id)
            ->where('sesi_id', $sesiId)
            ->delete();

        return redirect()->route('ketua.absensi.index')->with('success', 'Sesi kegiatan berhasil dihapus.');
    }
}
