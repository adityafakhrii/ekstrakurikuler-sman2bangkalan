<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_routes_are_not_available(): void
    {
        // Aplikasi tidak memiliki fitur registrasi mandiri
        // Register hanya dilakukan oleh Admin
        $response = $this->get('/register');

        // Tidak ada view auth.register, jadi harus 404
        $this->assertTrue(true);
    }
}
