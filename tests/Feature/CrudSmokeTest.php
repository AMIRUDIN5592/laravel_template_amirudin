<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);
    }

    public function test_users_crud_works(): void
    {
        $this->actingAs($this->admin());

        $this->get('/users')->assertOk();
        $this->get('/users/add')->assertOk();

        $this->post('/users/store', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'role' => 'admin',
        ])->assertRedirect(route('users.index'));

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('admin', $user->role);

        $this->get("/users/edit/{$user->id}")->assertOk();

        $this->post("/users/update/{$user->id}", [
            'name' => 'Updated User',
            'email' => 'testuser@example.com',
            'role' => 'superadmin',
        ])->assertRedirect(route('users.index'));
        $this->assertSame('Updated User', $user->fresh()->name);
        $this->assertSame('superadmin', $user->fresh()->role);

        $this->delete("/users/delete/{$user->id}")->assertRedirect(route('users.index'));
        $this->assertNull(User::find($user->id));
    }

    public function test_products_crud_works(): void
    {
        $this->actingAs($this->admin());

        $this->get('/product')->assertOk();
        $this->get('/product/create')->assertOk();

        $this->post('/product/store', [
            'name' => 'Test Product',
            'price' => 1000,
        ])->assertRedirect(route('product.index'));

        $product = Product::where('name', 'Test Product')->first();
        $this->assertNotNull($product);

        $this->get("/product/edit/{$product->id}")->assertOk();

        $this->post("/product/update/{$product->id}", [
            'name' => 'Updated Product',
            'price' => 2000,
        ])->assertRedirect(route('product.index'));
        $this->assertSame('Updated Product', $product->fresh()->name);

        $this->delete("/product/delete/{$product->id}")->assertRedirect(route('product.index'));
        $this->assertNull(Product::find($product->id));
    }
}
