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
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@begawi.id',
                'role' => User::ROLE_SUPER_ADMIN,
                'password' => 'password',
            ],
            [
                'name' => 'Admin Desa',
                'email' => 'admin.desa@begawi.id',
                'role' => User::ROLE_ADMIN_DESA,
                'password' => 'password',
            ],
            [
                'name' => 'Admin UMKM',
                'email' => 'admin.umkm@begawi.id',
                'role' => User::ROLE_ADMIN_UMKM,
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make($user['password']),
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
