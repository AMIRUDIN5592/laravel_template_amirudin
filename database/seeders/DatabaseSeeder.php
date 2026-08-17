<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ProductSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => config('seed.admin.email')],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make(config('seed.admin.password')),
                'role' => User::ROLE_ADMIN,
            ]
        );

        User::updateOrCreate(
            ['email' => config('seed.superadmin.email')],
            [
                'name' => 'Super Admin',
                'email_verified_at' => now(),
                'password' => Hash::make(config('seed.superadmin.password')),
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}
