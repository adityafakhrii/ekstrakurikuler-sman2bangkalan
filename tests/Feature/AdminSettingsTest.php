<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default settings config
        DB::table('pengaturan')->updateOrInsert(
            ['key' => 'auto_delete_rekomendasi'],
            ['value' => '30', 'created_at' => now(), 'updated_at' => now()]
        );
    }

    public function test_admin_can_view_auto_delete_setting_on_profile_page()
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $response = $this->get(route('admin.profile.edit'));
        $response->assertOk();
        $response->assertSee('Hapus Otomatis Riwayat Rekomendasi');
        $response->assertSee('auto_delete_rekomendasi');
    }

    public function test_admin_can_update_auto_delete_setting_and_trigger_automatic_cleanup()
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        // Create some recommendations with old dates and new dates
        $siswa = User::factory()->siswa()->create();
        $siswaId = DB::table('siswa')->insertGetId([
            'user_id' => $siswa->id,
            'nis' => '999999',
            'kelas' => 'X',
            'jurusan' => 'MIPA',
            'no_telp' => '081234567890',
            'jenis_kelamin' => 'L',
            'tahun_masuk' => 2025,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Rekomendasi berusia 10 hari
        $oldRecId = DB::table('rekomendasi')->insertGetId([
            'siswa_id' => $siswaId,
            'jawaban' => json_encode(['ketangkasan' => 5]),
            'tahun_ajaran' => '2025/2026',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        // Rekomendasi baru
        $newRecId = DB::table('rekomendasi')->insertGetId([
            'siswa_id' => $siswaId,
            'jawaban' => json_encode(['ketangkasan' => 5]),
            'tahun_ajaran' => '2025/2026',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Ekskul dummy
        $ekskulId = DB::table('ekstrakurikuler')->insertGetId([
            'nama' => 'Pramuka',
            'slug' => 'pramuka',
            'deskripsi' => 'Pramuka',
            'pembina' => 'Pembina',
            'whatsapp_group' => 'wa',
            'jadwal' => 'Senin',
            'tahun_ajaran' => '2025/2026',
            'kuota' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Hasil lama
        DB::table('rekomendasi_hasil')->insert([
            'rekomendasi_id' => $oldRecId,
            'ekstrakurikuler_id' => $ekskulId,
            'skor' => 4.5,
            'peringkat' => 1,
        ]);

        // Hasil baru
        DB::table('rekomendasi_hasil')->insert([
            'rekomendasi_id' => $newRecId,
            'ekstrakurikuler_id' => $ekskulId,
            'skor' => 4.5,
            'peringkat' => 1,
        ]);

        // Assert they all exist
        $this->assertDatabaseHas('rekomendasi_hasil', ['rekomendasi_id' => $oldRecId]);
        $this->assertDatabaseHas('rekomendasi_hasil', ['rekomendasi_id' => $newRecId]);

        // Update auto-delete to 7 days
        $response = $this->patch(route('admin.profile.update'), [
            'name' => $admin->name,
            'username' => $admin->username,
            'auto_delete_rekomendasi' => '7',
        ]);

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHas('success');

        // Check if settings table updated
        $this->assertEquals('7', DB::table('pengaturan')->where('key', 'auto_delete_rekomendasi')->value('value'));

        // Check that old rekomendasi_hasil is deleted, but new one exists
        $this->assertDatabaseMissing('rekomendasi_hasil', ['rekomendasi_id' => $oldRecId]);
        $this->assertDatabaseHas('rekomendasi_hasil', ['rekomendasi_id' => $newRecId]);

        // Check that the rekomendasi sessions themselves are NOT deleted
        $this->assertDatabaseHas('rekomendasi', ['id' => $oldRecId]);
        $this->assertDatabaseHas('rekomendasi', ['id' => $newRecId]);
    }

    public function test_admin_can_manually_clear_all_recommendations()
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        // Create a recommendation
        $siswa = User::factory()->siswa()->create();
        $siswaId = DB::table('siswa')->insertGetId([
            'user_id' => $siswa->id,
            'nis' => '999999',
            'kelas' => 'X',
            'jurusan' => 'MIPA',
            'no_telp' => '081234567890',
            'jenis_kelamin' => 'L',
            'tahun_masuk' => 2025,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $recId = DB::table('rekomendasi')->insertGetId([
            'siswa_id' => $siswaId,
            'jawaban' => json_encode(['ketangkasan' => 5]),
            'tahun_ajaran' => '2025/2026',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Ekskul dummy
        $ekskulId = DB::table('ekstrakurikuler')->insertGetId([
            'nama' => 'Pramuka',
            'slug' => 'pramuka',
            'deskripsi' => 'Pramuka',
            'pembina' => 'Pembina',
            'whatsapp_group' => 'wa',
            'jadwal' => 'Senin',
            'tahun_ajaran' => '2025/2026',
            'kuota' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Hasil
        DB::table('rekomendasi_hasil')->insert([
            'rekomendasi_id' => $recId,
            'ekstrakurikuler_id' => $ekskulId,
            'skor' => 4.5,
            'peringkat' => 1,
        ]);

        $this->assertDatabaseHas('rekomendasi_hasil', ['rekomendasi_id' => $recId]);

        // Request manual clear
        $response = $this->post(route('admin.profile.clear-recommendations'));

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHas('success');

        // Verify rekomendasi_hasil is cleared
        $this->assertDatabaseMissing('rekomendasi_hasil', ['rekomendasi_id' => $recId]);
        $this->assertEquals(0, DB::table('rekomendasi_hasil')->count());

        // Verify rekomendasi (history/preference session) is NOT deleted
        $this->assertDatabaseHas('rekomendasi', ['id' => $recId]);
    }

    public function test_admin_can_upload_profile_image_which_is_compressed_to_webp()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        // Buat file gambar palsu dengan format png berukuran 1MB
        $file = \Illuminate\Http\UploadedFile::fake()->image('profile.png', 800, 600)->size(1024);

        $response = $this->patch(route('admin.profile.update'), [
            'name' => 'Admin Baru',
            'username' => 'admin_baru',
            'profile_image' => $file,
            'auto_delete_rekomendasi' => '30',
        ]);

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHas('success');
        
        // Assert success message contains compression stats
        $successMsg = session('success');
        $this->assertStringContainsString('Foto profil berhasil dikompresi sebesar', $successMsg);

        // Assert file exists in public storage with webp extension
        $admin->refresh();
        $this->assertNotNull($admin->foto);
        $this->assertStringEndsWith('.webp', $admin->foto);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($admin->foto);
    }
}
