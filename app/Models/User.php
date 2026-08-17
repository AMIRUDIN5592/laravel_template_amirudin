<?php

namespace App\Models;

use App\Support\Permissions;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_SUPER_ADMIN = 'superadmin';

    /**
     * Map of roles to the permissions they are granted.
     * Use '*' to grant all permissions to a role.
     */
    public const ROLE_PERMISSIONS = [
        self::ROLE_SUPER_ADMIN => ['*'],
        self::ROLE_ADMIN => [
            Permissions::MANAGE_PRODUCTS,
        ],
    ];

    /**
     * Determine if the user has the given permission.
     */
    public function hasPermission(string $permission): bool
    {
        $allowed = self::ROLE_PERMISSIONS[$this->role] ?? [];

        return in_array('*', $allowed, true) || in_array($permission, $allowed, true);
    }

    /**
     * Determine if the user has the given role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Determine if the user has any of the given roles.
     */
    public function hasAnyRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
