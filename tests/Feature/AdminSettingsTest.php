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

        // Assert they both exist
        $this->assertDatabaseHas('rekomendasi', ['id' => $oldRecId]);
        $this->assertDatabaseHas('rekomendasi', ['id' => $newRecId]);

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

        // Check if old recommendation (10 days old) was deleted, and new one exists
        $this->assertDatabaseMissing('rekomendasi', ['id' => $oldRecId]);
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

        $this->assertDatabaseHas('rekomendasi', ['id' => $recId]);

        // Request manual clear
        $response = $this->post(route('admin.profile.clear-recommendations'));

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHas('success');

        // Verify database is cleared
        $this->assertDatabaseMissing('rekomendasi', ['id' => $recId]);
        $this->assertEquals(0, DB::table('rekomendasi')->count());
    }
}
