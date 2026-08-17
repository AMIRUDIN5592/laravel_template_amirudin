<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_access_users_and_products(): void
    {
        $this->actingAs($this->user('superadmin'));

        $this->get('/users')->assertOk();
        $this->get('/product')->assertOk();
    }

    public function test_admin_can_manage_products_but_not_users(): void
    {
        $this->actingAs($this->user('admin'));

        $this->get('/product')->assertOk();
        $this->get('/users')->assertForbidden();
    }

    public function test_regular_user_cannot_access_admin_crud(): void
    {
        $this->actingAs($this->user(null));

        $this->get('/product')->assertForbidden();
        $this->get('/users')->assertForbidden();
    }

    private function user(?string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'email_verified_at' => now(),
        ]);
    }
}
