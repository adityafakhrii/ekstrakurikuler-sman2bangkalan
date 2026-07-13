<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEkskulRequest;
use App\Http\Requests\Admin\UpdateEkskulRequest;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EkskulController extends Controller
{
    public function index(): View
    {
        $ekskuls = Ekstrakurikuler::with('ketua')
            ->latest()
            ->get();

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
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'kuota' => 30,
            ]);

            $mapping = [
                'fisik' => 'FISIK',
                'intelektual' => 'AKADEMIK',
                'kreativitas' => 'SENI',
                'sosial' => 'SOSIAL',
                'mental' => 'SOSIAL_HUMANIORA',
                'komunikasi' => 'BAHASA',
            ];

            foreach ($mapping as $formField => $dbKode) {
                $aspek = DB::table('aspek_penilaian')->where('kode', $dbKode)->first();
                if ($aspek) {
                    DB::table('ekskul_aspek')->updateOrInsert(
                        [
                            'ekstrakurikuler_id' => $ekskul->id,
                            'aspek_penilaian_id' => $aspek->id,
                        ],
                        [
                            'bobot' => $validated[$formField] * 20,
                        ]
                    );
                }
            }
        });

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
            'fisik' => isset($aspekBobot['FISIK']) ? round($aspekBobot['FISIK'] / 20) : 1,
            'intelektual' => isset($aspekBobot['AKADEMIK']) ? round($aspekBobot['AKADEMIK'] / 20) : 1,
            'kreativitas' => isset($aspekBobot['SENI']) ? round($aspekBobot['SENI'] / 20) : 1,
            'sosial' => isset($aspekBobot['SOSIAL']) ? round($aspekBobot['SOSIAL'] / 20) : 1,
            'mental' => isset($aspekBobot['SOSIAL_HUMANIORA']) ? round($aspekBobot['SOSIAL_HUMANIORA'] / 20) : 1,
            'komunikasi' => isset($aspekBobot['BAHASA']) ? round($aspekBobot['BAHASA'] / 20) : 1,
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
            'fisik' => isset($aspekBobot['FISIK']) ? round($aspekBobot['FISIK'] / 20) : 1,
            'intelektual' => isset($aspekBobot['AKADEMIK']) ? round($aspekBobot['AKADEMIK'] / 20) : 1,
            'kreativitas' => isset($aspekBobot['SENI']) ? round($aspekBobot['SENI'] / 20) : 1,
            'sosial' => isset($aspekBobot['SOSIAL']) ? round($aspekBobot['SOSIAL'] / 20) : 1,
            'mental' => isset($aspekBobot['SOSIAL_HUMANIORA']) ? round($aspekBobot['SOSIAL_HUMANIORA'] / 20) : 1,
            'komunikasi' => isset($aspekBobot['BAHASA']) ? round($aspekBobot['BAHASA'] / 20) : 1,
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

            $mapping = [
                'fisik' => 'FISIK',
                'intelektual' => 'AKADEMIK',
                'kreativitas' => 'SENI',
                'sosial' => 'SOSIAL',
                'mental' => 'SOSIAL_HUMANIORA',
                'komunikasi' => 'BAHASA',
            ];

            foreach ($mapping as $formField => $dbKode) {
                $aspek = DB::table('aspek_penilaian')->where('kode', $dbKode)->first();
                if ($aspek) {
                    DB::table('ekskul_aspek')->updateOrInsert(
                        [
                            'ekstrakurikuler_id' => $ekskul->id,
                            'aspek_penilaian_id' => $aspek->id,
                        ],
                        [
                            'bobot' => $validated[$formField] * 20,
                        ]
                    );
                }
            }
        });

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
