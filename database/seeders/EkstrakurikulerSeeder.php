<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EkstrakurikulerSeeder extends Seeder
{
    public function run(): void
    {
        $ketuaOsis    = User::where('email', 'ketua.osis@sman2bangkalan.sch.id')->first();
        $ketuaPramuka = User::where('email', 'ketua.pramuka@sman2bangkalan.sch.id')->first();
        $ketuaBasket  = User::where('email', 'ketua.basket@sman2bangkalan.sch.id')->first();
        $ketuaPmr     = User::where('email', 'ketua.pmr@sman2bangkalan.sch.id')->first();
        $ketuaPaduan  = User::where('email', 'ketua.paduan@sman2bangkalan.sch.id')->first();

        $ekskul = [
            [
                'ketua_id'      => $ketuaOsis?->id,
                'nama'          => 'OSIS (Organisasi Siswa Intra Sekolah)',
                'slug'          => 'osis',
                'deskripsi'     => 'Organisasi resmi siswa SMAN 2 Bangkalan yang bertugas mewadahi aspirasi dan kegiatan siswa di lingkungan sekolah.',
                'kuota'         => 40,
                'kategori'      => 'Organisasi',
                'status'        => 'aktif',
                'hari_latihan'  => 'Jumat',
                'jam_mulai'     => '14:00:00',
                'jam_selesai'   => '16:00:00',
                'lokasi'        => 'Ruang OSIS',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Siswa aktif kelas X-XII, nilai rata-rata minimal 75, tidak sedang dalam proses sanksi.',
            ],
            [
                'ketua_id'      => $ketuaPramuka?->id,
                'nama'          => 'Pramuka',
                'slug'          => 'pramuka',
                'deskripsi'     => 'Gerakan Pramuka SMAN 2 Bangkalan yang mengajarkan kepemimpinan, disiplin, dan kecakapan hidup.',
                'kuota'         => 60,
                'kategori'      => 'Kepanduan',
                'status'        => 'aktif',
                'hari_latihan'  => 'Sabtu',
                'jam_mulai'     => '07:30:00',
                'jam_selesai'   => '11:00:00',
                'lokasi'        => 'Lapangan Upacara',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Wajib bagi kelas X, terbuka untuk semua siswa.',
            ],
            [
                'ketua_id'      => $ketuaBasket?->id,
                'nama'          => 'Basket',
                'slug'          => 'basket',
                'deskripsi'     => 'Ekstrakurikuler olahraga basket yang aktif mengikuti kompetisi antar sekolah tingkat kabupaten dan provinsi.',
                'kuota'         => 25,
                'kategori'      => 'Olahraga',
                'status'        => 'aktif',
                'hari_latihan'  => 'Rabu',
                'jam_mulai'     => '15:30:00',
                'jam_selesai'   => '17:30:00',
                'lokasi'        => 'Lapangan Basket',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Tinggi badan minimal 160cm untuk putra, 155cm untuk putri. Sehat jasmani.',
            ],
            [
                'ketua_id'      => $ketuaPmr?->id,
                'nama'          => 'PMR (Palang Merah Remaja)',
                'slug'          => 'pmr',
                'deskripsi'     => 'Unit PMR Wira SMAN 2 Bangkalan yang bergerak di bidang kemanusiaan, kesehatan, dan pertolongan pertama.',
                'kuota'         => 35,
                'kategori'      => 'Kemanusiaan',
                'status'        => 'aktif',
                'hari_latihan'  => 'Kamis',
                'jam_mulai'     => '14:00:00',
                'jam_selesai'   => '16:00:00',
                'lokasi'        => 'Ruang UKS',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Tidak takut darah, bersedia mengikuti pelatihan P3K.',
            ],
            [
                'ketua_id'      => $ketuaPaduan?->id,
                'nama'          => 'Paduan Suara',
                'slug'          => 'paduan-suara',
                'deskripsi'     => 'Kelompok paduan suara SMAN 2 Bangkalan yang sering tampil di acara sekolah dan kompetisi paduan suara.',
                'kuota'         => 30,
                'kategori'      => 'Seni',
                'status'        => 'aktif',
                'hari_latihan'  => 'Selasa',
                'jam_mulai'     => '14:30:00',
                'jam_selesai'   => '16:30:00',
                'lokasi'        => 'Aula Sekolah',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Memiliki kemampuan vokal dasar, bersedia hadir rutin setiap latihan.',
            ],
            [
                'ketua_id'      => null,
                'nama'          => 'Robotik',
                'slug'          => 'robotik',
                'deskripsi'     => 'Ekstrakurikuler teknologi yang mempelajari desain, pemrograman, dan kompetisi robot.',
                'kuota'         => 20,
                'kategori'      => 'Teknologi',
                'status'        => 'aktif',
                'hari_latihan'  => 'Sabtu',
                'jam_mulai'     => '08:00:00',
                'jam_selesai'   => '11:00:00',
                'lokasi'        => 'Lab Komputer',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Minat di bidang teknologi dan pemrograman.',
            ],
            [
                'ketua_id'      => null,
                'nama'          => 'English Club',
                'slug'          => 'english-club',
                'deskripsi'     => 'Komunitas belajar bahasa Inggris dengan kegiatan debat, storytelling, dan drama berbahasa Inggris.',
                'kuota'         => 30,
                'kategori'      => 'Akademik',
                'status'        => 'aktif',
                'hari_latihan'  => 'Senin',
                'jam_mulai'     => '14:00:00',
                'jam_selesai'   => '16:00:00',
                'lokasi'        => 'Ruang Kelas XII-A',
                'tahun_ajaran'  => '2024/2025',
                'persyaratan'   => 'Nilai bahasa Inggris minimal 75, berani berbicara di depan umum.',
            ],
        ];

        foreach ($ekskul as $data) {
            DB::table('ekstrakurikuler')->updateOrInsert(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✅ Ekstrakurikuler seeded: ' . count($ekskul) . ' ekskul');
    }
}
