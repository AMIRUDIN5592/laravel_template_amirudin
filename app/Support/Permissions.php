<?php

namespace App\Support;

final class Permissions
{
    public const MANAGE_USERS = 'manage-users';

    public const MANAGE_PRODUCTS = 'manage-products';

    /**
     * All available permissions.
     *
     * @return list<string>
     */
    public static function all(): array
    {
        return [
            self::MANAGE_USERS,
            self::MANAGE_PRODUCTS,
        ];
    }
}
