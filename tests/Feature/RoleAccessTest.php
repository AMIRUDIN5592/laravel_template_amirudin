<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_view_role_permissions_page(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('superadmin'));

        $this->get('/roles')->assertOk();
    }

    public function test_admin_cannot_view_role_permissions_page(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('admin'));

        $this->get('/roles')->assertForbidden();
    }

    public function test_regular_user_cannot_view_role_permissions_page(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user(null));

        $this->get('/roles')->assertForbidden();
    }

    public function test_superadmin_can_update_role_permissions(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('superadmin'));

        $this->post('/roles', [
            'roles' => [
                'admin' => ['manage-users', 'manage-products'],
            ],
        ])->assertRedirect(route('roles.index'));

        $this->assertSame(
            ['manage-users', 'manage-products'],
            Role::where('name', 'admin')->firstOrFail()->permissionList()
        );
    }

    public function test_superadmin_role_is_always_granted_every_permission(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('superadmin'));

        $this->post('/roles', [
            'roles' => [
                'admin' => ['manage-products'],
            ],
        ])->assertRedirect(route('roles.index'));

        $this->assertSame(['*'], Role::where('name', 'superadmin')->firstOrFail()->permissionList());
    }

    public function test_superadmin_can_view_role_create_page(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('superadmin'));

        $this->get('/roles/create')->assertOk();
    }

    public function test_superadmin_can_store_a_new_role(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('superadmin'));

        $this->post('/roles/store', [
            'name' => 'Editor',
            'label' => 'Editor',
            'permissions' => ['manage-products'],
        ])->assertRedirect(route('roles.index'));

        $role = Role::where('name', 'editor')->first();

        $this->assertNotNull($role);
        $this->assertSame('Editor', $role->label);
        $this->assertSame(['manage-products'], $role->permissionList());
    }

    public function test_duplicate_role_name_is_rejected(): void
    {
        $this->seedRoles();
        $this->actingAs($this->user('superadmin'));

        $this->post('/roles/store', [
            'name' => 'admin',
            'label' => 'Admin Duplikat',
        ])->assertSessionHasErrors('name');
    }

    private function seedRoles(): void
    {
        Role::create(['name' => 'admin', 'label' => 'Admin', 'permissions' => ['manage-products']]);
        Role::create(['name' => 'superadmin', 'label' => 'Superadmin', 'permissions' => ['*']]);
    }

    private function user(?string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'email_verified_at' => now(),
        ]);
    }
}
