<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Seeded Default Users
    |--------------------------------------------------------------------------
    |
    | Credentials for the default admin & superadmin accounts created by the
    | database seeder. Override via the SEED_* variables in your .env file.
    |
    */

    'admin' => [
        'email' => env('SEED_ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('SEED_ADMIN_PASSWORD', 'password'),
    ],

    'superadmin' => [
        'email' => env('SEED_SUPERADMIN_EMAIL', 'superadmin@example.com'),
        'password' => env('SEED_SUPERADMIN_PASSWORD', 'password'),
    ],

];
