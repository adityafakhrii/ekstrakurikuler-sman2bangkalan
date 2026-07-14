<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEkskulRequest;
use App\Http\Requests\Admin\UpdateEkskulRequest;
use App\Helpers\AspekHelper;
use App\Models\Ekstrakurikuler;
use App\Models\AspekPenilaian;
use App\Models\EkskulAspek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EkskulController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        $ekskuls = Ekstrakurikuler::select('id', 'ketua_id', 'nama', 'slug', 'logo', 'kuota', 'kategori', 'pembina', 'created_at')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('pembina', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->with('ketua:id,name')
            ->withCount('pendaftarans')
            ->latest()
            ->paginate($this->perPage())
            ->withQueryString();

        return view('admin.ekstrakurikuler.index', compact('ekskuls'));
    }

    public function create(): View
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function store(StoreEkskulRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated) {
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('ekskul-logos', 'public');
            }

            $ekskul = Ekstrakurikuler::create([
                'nama' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'deskripsi' => $validated['description'],
                'pembina' => $validated['pembina'],
                'whatsapp_group' => $validated['whatsapp_group'],
                'jadwal' => $validated['jadwal'],
                'logo' => $logoPath,
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'kuota' => config('ekskul.kuota_default'),
            ]);

            // Pre-load semua aspek sekaligus (1 query, bukan 6 query di loop)
            $mapping = [
                'fisik' => 'FISIK',
                'estetika' => 'ESTETIKA',
                'komunikasi' => 'KOMUNIKASI',
                'kreativitas' => 'KREATIVITAS',
                'disiplin' => 'DISIPLIN',
                'kekompakan' => 'KEKOMPAKAN',
            ];

            $aspekList = AspekPenilaian::whereIn('kode', array_values($mapping))
                ->pluck('id', 'kode');

            foreach ($mapping as $formField => $dbKode) {
                if ($aspekId = $aspekList[$dbKode] ?? null) {
                    EkskulAspek::updateOrInsert(
                        [
                            'ekstrakurikuler_id' => $ekskul->id,
                            'aspek_penilaian_id' => $aspekId,
                        ],
                        [
                            'bobot' => $validated[$formField],
                        ]
                    );
                }
            }
        });

        Cache::forget('admin.dashboard.stats');

        return redirect()->route('ekskul.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $ekskul = Ekstrakurikuler::with('ketua')->findOrFail($id);

        $aspekBobot = DB::table('ekskul_aspek')
            ->where('ekstrakurikuler_id', $id)
            ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
            ->pluck('bobot', 'kode')
            ->toArray();

        $aspekValues = [
            'fisik' => isset($aspekBobot['FISIK']) ? $aspekBobot['FISIK'] : 1,
            'estetika' => isset($aspekBobot['ESTETIKA']) ? $aspekBobot['ESTETIKA'] : 1,
            'komunikasi' => isset($aspekBobot['KOMUNIKASI']) ? $aspekBobot['KOMUNIKASI'] : 1,
            'kreativitas' => isset($aspekBobot['KREATIVITAS']) ? $aspekBobot['KREATIVITAS'] : 1,
            'disiplin' => isset($aspekBobot['DISIPLIN']) ? $aspekBobot['DISIPLIN'] : 1,
            'kekompakan' => isset($aspekBobot['KEKOMPAKAN']) ? $aspekBobot['KEKOMPAKAN'] : 1,
        ];

        return view('admin.ekstrakurikuler.show', compact('ekskul', 'aspekValues'));
    }

    public function edit(int $id): View
    {
        $ekskul = Ekstrakurikuler::with('ketua')->findOrFail($id);

        $aspekBobot = DB::table('ekskul_aspek')
            ->where('ekstrakurikuler_id', $id)
            ->join('aspek_penilaian', 'ekskul_aspek.aspek_penilaian_id', '=', 'aspek_penilaian.id')
            ->pluck('bobot', 'kode')
            ->toArray();

        $aspekValues = [
            'fisik' => isset($aspekBobot['FISIK']) ? $aspekBobot['FISIK'] : 1,
            'estetika' => isset($aspekBobot['ESTETIKA']) ? $aspekBobot['ESTETIKA'] : 1,
            'komunikasi' => isset($aspekBobot['KOMUNIKASI']) ? $aspekBobot['KOMUNIKASI'] : 1,
            'kreativitas' => isset($aspekBobot['KREATIVITAS']) ? $aspekBobot['KREATIVITAS'] : 1,
            'disiplin' => isset($aspekBobot['DISIPLIN']) ? $aspekBobot['DISIPLIN'] : 1,
            'kekompakan' => isset($aspekBobot['KEKOMPAKAN']) ? $aspekBobot['KEKOMPAKAN'] : 1,
        ];

        return view('admin.ekstrakurikuler.edit', compact('ekskul', 'aspekValues'));
    }

    public function update(UpdateEkskulRequest $request, int $id): RedirectResponse
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated, $ekskul) {
            $logoPath = $ekskul->logo;
            if ($request->hasFile('logo')) {
                if ($logoPath) {
                    Storage::disk('public')->delete($logoPath);
                }
                $logoPath = $request->file('logo')->store('ekskul-logos', 'public');
            }

            $ekskul->update([
                'nama' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'deskripsi' => $validated['description'],
                'pembina' => $validated['pembina'],
                'whatsapp_group' => $validated['whatsapp_group'],
                'jadwal' => $validated['jadwal'],
                'logo' => $logoPath,
            ]);

            // Pre-load semua aspek sekaligus (1 query, bukan 6 query di loop)
            $mapping = [
                'fisik' => 'FISIK',
                'estetika' => 'ESTETIKA',
                'komunikasi' => 'KOMUNIKASI',
                'kreativitas' => 'KREATIVITAS',
                'disiplin' => 'DISIPLIN',
                'kekompakan' => 'KEKOMPAKAN',
            ];

            $aspekList = AspekPenilaian::whereIn('kode', array_values($mapping))
                ->pluck('id', 'kode');

            foreach ($mapping as $formField => $dbKode) {
                if ($aspekId = $aspekList[$dbKode] ?? null) {
                    EkskulAspek::updateOrInsert(
                        [
                            'ekstrakurikuler_id' => $ekskul->id,
                            'aspek_penilaian_id' => $aspekId,
                        ],
                        [
                            'bobot' => $validated[$formField],
                        ]
                    );
                }
            }
        });

        Cache::forget('admin.dashboard.stats');

        return redirect()->route('ekskul.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        if ($ekskul->logo) {
            Storage::disk('public')->delete($ekskul->logo);
        }

        $ekskul->delete();

        return redirect()->route('ekskul.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
