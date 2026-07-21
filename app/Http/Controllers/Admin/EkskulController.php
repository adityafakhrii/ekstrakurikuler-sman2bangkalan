<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEkskulRequest;
use App\Http\Requests\Admin\UpdateEkskulRequest;
use App\Helpers\AspekHelper;
use App\Helpers\ImageHelper;
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

        $compressionInfo = null;

        try {
            DB::transaction(function () use ($request, $validated, &$compressionInfo) {
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    $compressionInfo = ImageHelper::convertToWebp($request->file('logo'), 'ekskul-images');
                    $logoPath = $compressionInfo['path'];
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
                    'ketangkasan' => 'KETANGKASAN',
                    'intelektual' => 'INTELEKTUAL',
                    'sosial'      => 'SOSIAL',
                    'kreativitas' => 'KREATIVITAS',
                    'kedisiplinan'=> 'KEDISIPLINAN',
                    'komunikasi'  => 'KOMUNIKASI',
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
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['name' => 'Mohon maaf, ekstrakurikuler dengan nama tersebut sudah terdaftar di sistem. Silakan pilih nama lain yang berbeda.']);
        } catch (\Exception $e) {
            \Log::error('Gagal menambahkan ekskul: ' . $e->getMessage());
            return back()->withInput()->withErrors(['name' => 'Terjadi kesalahan sistem saat menyimpan data ekstrakurikuler. Silakan coba kembali nanti atau hubungi Administrator jika kendala berlanjut.']);
        }

        Cache::forget('admin.dashboard.stats');

        $message = 'Ekstrakurikuler berhasil ditambahkan.';
        if ($compressionInfo) {
            $message .= " Gambar berhasil dikompres dari {$compressionInfo['original_size_formatted']} menjadi {$compressionInfo['compressed_size_formatted']} ({$compressionInfo['percentage']}% lebih ringan).";
        }

        return redirect()->route('ekskul.index')->with('success', $message);
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
            'ketangkasan' => isset($aspekBobot['KETANGKASAN']) ? $aspekBobot['KETANGKASAN'] : 1,
            'intelektual' => isset($aspekBobot['INTELEKTUAL']) ? $aspekBobot['INTELEKTUAL'] : 1,
            'sosial'      => isset($aspekBobot['SOSIAL']) ? $aspekBobot['SOSIAL'] : 1,
            'kreativitas' => isset($aspekBobot['KREATIVITAS']) ? $aspekBobot['KREATIVITAS'] : 1,
            'kedisiplinan'=> isset($aspekBobot['KEDISIPLINAN']) ? $aspekBobot['KEDISIPLINAN'] : 1,
            'komunikasi'  => isset($aspekBobot['KOMUNIKASI']) ? $aspekBobot['KOMUNIKASI'] : 1,
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
            'ketangkasan' => isset($aspekBobot['KETANGKASAN']) ? $aspekBobot['KETANGKASAN'] : 1,
            'intelektual' => isset($aspekBobot['INTELEKTUAL']) ? $aspekBobot['INTELEKTUAL'] : 1,
            'sosial'      => isset($aspekBobot['SOSIAL']) ? $aspekBobot['SOSIAL'] : 1,
            'kreativitas' => isset($aspekBobot['KREATIVITAS']) ? $aspekBobot['KREATIVITAS'] : 1,
            'kedisiplinan'=> isset($aspekBobot['KEDISIPLINAN']) ? $aspekBobot['KEDISIPLINAN'] : 1,
            'komunikasi'  => isset($aspekBobot['KOMUNIKASI']) ? $aspekBobot['KOMUNIKASI'] : 1,
        ];

        return view('admin.ekstrakurikuler.edit', compact('ekskul', 'aspekValues'));
    }

    public function update(UpdateEkskulRequest $request, int $id): RedirectResponse
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $validated = $request->validated();

        $compressionInfo = null;

        try {
            DB::transaction(function () use ($request, $validated, $ekskul, &$compressionInfo) {
                $logoPath = $ekskul->logo;
                if ($request->hasFile('logo')) {
                    if ($logoPath) {
                        Storage::disk('public')->delete($logoPath);
                    }
                    $compressionInfo = ImageHelper::convertToWebp($request->file('logo'), 'ekskul-images');
                    $logoPath = $compressionInfo['path'];
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
                    'ketangkasan' => 'KETANGKASAN',
                    'intelektual' => 'INTELEKTUAL',
                    'sosial'      => 'SOSIAL',
                    'kreativitas' => 'KREATIVITAS',
                    'kedisiplinan'=> 'KEDISIPLINAN',
                    'komunikasi'  => 'KOMUNIKASI',
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
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['name' => 'Mohon maaf, nama ekstrakurikuler tersebut sudah digunakan oleh ekskul lain. Silakan periksa kembali daftar ekskul atau pilih nama lain.']);
        } catch (\Exception $e) {
            \Log::error('Gagal mengubah ekskul: ' . $e->getMessage());
            return back()->withInput()->withErrors(['name' => 'Terjadi kesalahan sistem saat memperbarui data ekstrakurikuler. Silakan coba kembali nanti atau hubungi Administrator jika kendala berlanjut.']);
        }

        Cache::forget('admin.dashboard.stats');

        $message = 'Ekstrakurikuler berhasil diperbarui.';
        if ($compressionInfo) {
            $message .= " Gambar berhasil dikompres dari {$compressionInfo['original_size_formatted']} menjadi {$compressionInfo['compressed_size_formatted']} ({$compressionInfo['percentage']}% lebih ringan).";
        }

        return redirect()->route('ekskul.index')->with('success', $message);
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
