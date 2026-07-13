<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get('/');
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_visit_admin_dashboard()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
    }

    public function test_ketua_can_visit_ketua_dashboard()
    {
        $user = User::factory()->ketua()->create();
        $this->actingAs($user);

        $response = $this->get(route('ketua.dashboard'));
        $response->assertOk();
    }
}
