<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array<int, string>|null $permissions
 */
class Role extends Model
{
    protected $fillable = [
        'name',
        'label',
        'permissions',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

    /**
     * Get the list of permission names granted to this role.
     *
     * @return list<string>
     */
    public function permissionList(): array
    {
        $permissions = $this->permissions;

        if (! is_array($permissions)) {
            return [];
        }

        return array_values(array_filter($permissions, 'is_string'));
    }
}
