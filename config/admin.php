<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sidebar Menu
    |--------------------------------------------------------------------------
    |
    | Each item may define:
    |   - label  : menu text (required)
    |   - route  : route name (used with route()); takes precedence over url
    |   - url    : literal URL (fallback when no route)
    |   - icon   : Bootstrap Icons class
    |   - can    : permission name required to see the item (empty = everyone)
    |   - active : route pattern(s) to highlight the item (routeIs())
    |
    | Permissions are defined in app/Support/Permissions.php and mapped to
    | roles in App\Models\User::ROLE_PERMISSIONS.
    |
    */

    'menu' => [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'bi bi-speedometer',
            'active' => 'dashboard',
        ],
        [
            'label' => 'About',
            'route' => 'about',
            'icon' => 'bi bi-box',
            'active' => 'about',
        ],
        [
            'label' => 'Users',
            'route' => 'users.index',
            'icon' => 'bi bi-people',
            'can' => 'manage-users',
            'active' => 'users.*',
        ],
        [
            'label' => 'Product',
            'route' => 'product.index',
            'icon' => 'bi bi-box-seam',
            'can' => 'manage-products',
            'active' => 'product.*',
        ],
    ],

];
