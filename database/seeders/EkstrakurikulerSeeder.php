<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EkstrakurikulerSeeder extends Seeder
{
    public function run(): void
    {
        $ketuaOsis = User::where('email', 'ketua.osis@sman2bangkalan.sch.id')->first();
        $ketuaPramuka = User::where('email', 'ketua.pramuka@sman2bangkalan.sch.id')->first();
        $ketuaBasket = User::where('email', 'ketua.basket@sman2bangkalan.sch.id')->first();
        $ketuaPmr = User::where('email', 'ketua.pmr@sman2bangkalan.sch.id')->first();
        $ketuaPaduan = User::where('email', 'ketua.paduan@sman2bangkalan.sch.id')->first();

        $ekskul = [
            [
                'ketua_id' => $ketuaOsis?->id,
                'nama' => 'OSIS (Organisasi Siswa Intra Sekolah)',
                'slug' => 'osis',
                'deskripsi' => 'Organisasi resmi siswa SMAN 2 Bangkalan yang bertugas mewadahi aspirasi, mengelola program kerja sekolah, dan menjadi penggerak kegiatan siswa.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Drs. Ahmad Hidayat, M.Pd.',
                'whatsapp_group' => 'https://chat.whatsapp.com/osis-sman2bangkalan',
                'jadwal' => 'Jumat, 14:00 - 16:00 WIB',
                'kuota' => 40,
                'kategori' => 'Organisasi',
                'status' => 'aktif',
                'hari_latihan' => 'Jumat',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'lokasi' => 'Ruang OSIS',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Siswa aktif kelas X-XII, nilai rata-rata minimal 75, disiplin, komunikatif, dan bersedia mengikuti seluruh program kerja OSIS.',
                'prestasi' => 'Juara 2 Lomba Tata Kelola OSIS Kabupaten Bangkalan 2024; Panitia Pelaksana SMADA Fest 2024.',
            ],
            [
                'ketua_id' => $ketuaPramuka?->id,
                'nama' => 'Pramuka',
                'slug' => 'pramuka',
                'deskripsi' => 'Gerakan Pramuka SMAN 2 Bangkalan yang mengajarkan kepemimpinan, kedisiplinan, kerja sama, dan kecakapan hidup melalui kegiatan kepanduan.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Dra. Siti Aminah, M.Pd.',
                'whatsapp_group' => 'https://chat.whatsapp.com/pramuka-sman2bangkalan',
                'jadwal' => 'Sabtu, 07:30 - 11:00 WIB',
                'kuota' => 60,
                'kategori' => 'Kepanduan',
                'status' => 'aktif',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '07:30:00',
                'jam_selesai' => '11:00:00',
                'lokasi' => 'Lapangan Upacara',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Wajib bagi kelas X, terbuka untuk semua siswa, bersedia mengikuti latihan rutin, perkemahan, dan kegiatan lapangan.',
                'prestasi' => 'Juara Umum Lomba Tingkat Penegak Bangkalan 2024; Juara 1 Pionering Putra 2023.',
            ],
            [
                'ketua_id' => $ketuaBasket?->id,
                'nama' => 'Basket',
                'slug' => 'basket',
                'deskripsi' => 'Ekstrakurikuler olahraga basket untuk mengembangkan kemampuan teknik, strategi permainan, sportivitas, dan prestasi kompetitif siswa.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Budi Santoso, S.Pd.',
                'whatsapp_group' => 'https://chat.whatsapp.com/basket-sman2bangkalan',
                'jadwal' => 'Rabu, 15:30 - 17:30 WIB',
                'kuota' => 25,
                'kategori' => 'Olahraga',
                'status' => 'aktif',
                'hari_latihan' => 'Rabu',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:30:00',
                'lokasi' => 'Lapangan Basket',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Sehat jasmani, memiliki minat olahraga basket, siap mengikuti seleksi kemampuan dasar dan latihan fisik.',
                'prestasi' => 'Juara 3 DBL Kabupaten Bangkalan 2024; Finalis SMADA Basketball Cup 2023.',
            ],
            [
                'ketua_id' => $ketuaPmr?->id,
                'nama' => 'PMR (Palang Merah Remaja)',
                'slug' => 'pmr',
                'deskripsi' => 'Unit PMR Wira SMAN 2 Bangkalan yang bergerak di bidang kemanusiaan, kesehatan sekolah, donor darah, dan pertolongan pertama.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Rina Kurniawati, S.Kep.',
                'whatsapp_group' => 'https://chat.whatsapp.com/pmr-sman2bangkalan',
                'jadwal' => 'Kamis, 14:00 - 16:00 WIB',
                'kuota' => 35,
                'kategori' => 'Kemanusiaan',
                'status' => 'aktif',
                'hari_latihan' => 'Kamis',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'lokasi' => 'Ruang UKS',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Memiliki kepedulian sosial, tidak takut darah, bersedia mengikuti pelatihan P3K dan kegiatan kesehatan sekolah.',
                'prestasi' => 'Juara 1 Lomba Pertolongan Pertama PMR Wira 2024; Relawan UKS Teraktif 2023.',
            ],
            [
                'ketua_id' => $ketuaPaduan?->id,
                'nama' => 'Paduan Suara',
                'slug' => 'paduan-suara',
                'deskripsi' => 'Kelompok paduan suara SMAN 2 Bangkalan yang melatih teknik vokal, harmoni, kepercayaan diri, dan penampilan panggung.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Melati Putri, S.Sn.',
                'whatsapp_group' => 'https://chat.whatsapp.com/paduansuara-sman2bangkalan',
                'jadwal' => 'Selasa, 14:30 - 16:30 WIB',
                'kuota' => 30,
                'kategori' => 'Seni',
                'status' => 'aktif',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '14:30:00',
                'jam_selesai' => '16:30:00',
                'lokasi' => 'Aula Sekolah',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Memiliki kemampuan vokal dasar, percaya diri, dan bersedia hadir rutin setiap latihan serta penampilan sekolah.',
                'prestasi' => 'Juara 2 Festival Paduan Suara Pelajar Madura 2024; Pengisi Acara Hari Jadi Bangkalan 2023.',
            ],
            [
                'ketua_id' => null,
                'nama' => 'Robotik',
                'slug' => 'robotik',
                'deskripsi' => 'Ekstrakurikuler teknologi yang mempelajari desain robot, elektronika dasar, pemrograman mikrokontroler, dan kompetisi robotika.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Fajar Nugroho, S.Kom.',
                'whatsapp_group' => 'https://chat.whatsapp.com/robotik-sman2bangkalan',
                'jadwal' => 'Sabtu, 08:00 - 11:00 WIB',
                'kuota' => 20,
                'kategori' => 'Teknologi',
                'status' => 'aktif',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '11:00:00',
                'lokasi' => 'Lab Komputer',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Minat di bidang teknologi, logika, pemrograman, dan bersedia mengikuti proyek tim robotika.',
                'prestasi' => 'Finalis Line Follower Competition Jawa Timur 2024; Juara Harapan 1 Robot Kreatif Pelajar 2023.',
            ],
            [
                'ketua_id' => null,
                'nama' => 'English Club',
                'slug' => 'english-club',
                'deskripsi' => 'Komunitas belajar bahasa Inggris dengan kegiatan debat, storytelling, speech, drama, dan diskusi budaya internasional.',
                'logo' => '/images/logo-sman2.png',
                'banner' => '/images/bg-school-hero.jpg',
                'pembina' => 'Nurul Fadilah, S.Pd.',
                'whatsapp_group' => 'https://chat.whatsapp.com/englishclub-sman2bangkalan',
                'jadwal' => 'Senin, 14:00 - 16:00 WIB',
                'kuota' => 30,
                'kategori' => 'Akademik',
                'status' => 'aktif',
                'hari_latihan' => 'Senin',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'lokasi' => 'Ruang Kelas XII-A',
                'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                'persyaratan' => 'Nilai bahasa Inggris minimal 75, berani berbicara di depan umum, dan aktif mengikuti sesi latihan.',
                'prestasi' => 'Juara 1 English Speech Contest Bangkalan 2024; Juara 2 Storytelling Competition 2023.',
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

        $namaEkskulTambahan = [
            'Futsal', 'Voli', 'Badminton', 'Marching Band', 'Teater', 'Tari Tradisional', 'Jurnalistik', 'Fotografi',
            'Karya Ilmiah Remaja', 'Rohis', 'Musik', 'Karate', 'Silat', 'Taekwondo', 'Renang', 'Catur',
            'Desain Grafis', 'Film Pendek', 'Pecinta Alam', 'Bahasa Jepang', 'Bahasa Arab', 'Matematika Club',
            'Sains Club', 'Coding Club', 'E-Sport', 'Kewirausahaan', 'Green School', 'Debate Club', 'Public Speaking',
            'Kaligrafi', 'Hadrah', 'Drumband', 'Seni Lukis', 'Komik Digital', 'Broadcasting', 'Literasi', 'Paskibra',
            'Dokter Remaja', 'Astronomi', 'Ekonomi Club', 'Geografi Club', 'Sejarah Club', 'Bulutangkis Putri',
            'Basket Putri', 'Voli Putri', 'Futsal Putri', 'Sinema', 'Podcast', 'Desain Produk', 'Koperasi Siswa',
        ];

        $kategoriList = ['Olahraga', 'Seni', 'Akademik', 'Teknologi', 'Organisasi', 'Kemanusiaan'];
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $lokasiList = ['Aula Sekolah', 'Lapangan Utama', 'Lab Komputer', 'Ruang Kelas XI', 'Perpustakaan', 'Ruang Seni'];
        $pembinaList = [
            'Ahmad Jihaduddin Salim, S.Pd.', 'Siti Aminah, M.Pd.', 'Budi Santoso, S.Pd.', 'Rina Kurniawati, S.Kep.',
            'Melati Putri, S.Sn.', 'Fajar Nugroho, S.Kom.', 'Nurul Fadilah, S.Pd.', 'Agus Maulana, M.Pd.',
        ];
        $ketuaTambahan = User::where('role', 'ketua')->where('username', 'like', 'ketua.dummy%')->get()->values();

        foreach ($namaEkskulTambahan as $index => $nama) {
            $slug = Str::slug($nama);
            $hari = $hariList[$index % count($hariList)];
            $jamMulai = sprintf('%02d:00:00', 13 + ($index % 4));
            $jamSelesai = sprintf('%02d:30:00', 15 + ($index % 4));
            $ketua = $ketuaTambahan->get($index);

            DB::table('ekstrakurikuler')->updateOrInsert(
                ['slug' => $slug],
                [
                    'ketua_id' => $ketua?->id,
                    'nama' => $nama,
                    'deskripsi' => 'Ekstrakurikuler '.$nama.' SMAN 2 Bangkalan sebagai wadah pengembangan minat, bakat, karakter, dan prestasi siswa secara terarah.',
                    'logo' => '/images/logo-sman2.png',
                    'banner' => '/images/bg-school-hero.jpg',
                    'pembina' => $pembinaList[$index % count($pembinaList)],
                    'whatsapp_group' => 'https://chat.whatsapp.com/'.Str::slug($nama).'-sman2bangkalan',
                    'jadwal' => $hari.', '.substr($jamMulai, 0, 5).' - '.substr($jamSelesai, 0, 5).' WIB',
                    'kuota' => 20 + ($index % 31),
                    'kategori' => $kategoriList[$index % count($kategoriList)],
                    'status' => ['aktif', 'aktif', 'aktif', 'penuh', 'tidak_aktif'][$index % 5],
                    'hari_latihan' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'lokasi' => $lokasiList[$index % count($lokasiList)],
                    'tahun_ajaran' => config('ekskul.tahun_ajaran'),
                    'persyaratan' => 'Siswa aktif SMAN 2 Bangkalan, bersedia mengikuti latihan rutin, menjaga disiplin, dan mematuhi aturan pembina.',
                    'prestasi' => 'Aktif mengikuti kegiatan sekolah dan kompetisi tingkat kabupaten/kota pada tahun ajaran berjalan.',
                    'created_at' => now()->subDays($index + 1),
                    'updated_at' => now(),
                ]
            );
        }

        $totalEkskul = DB::table('ekstrakurikuler')->count();
        $this->command->info('✅ Ekstrakurikuler seeded: '.$totalEkskul.' ekskul');
    }
}
