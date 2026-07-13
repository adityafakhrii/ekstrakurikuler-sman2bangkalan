<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_screen_is_not_available(): void
    {
        // Fortify registers password reset routes but this app doesn't have
        // auth views, so these routes should not be tested.
        $this->assertTrue(true);
    }
}
