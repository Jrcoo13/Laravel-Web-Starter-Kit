<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'access' => [
                    'users' => ['view', 'create', 'edit', 'delete'],
                    'dashboard' => ['view'],
                    'settings' => ['view', 'edit'],
                ],
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'access' => [
                    'dashboard' => ['view'],
                    'profile' => ['view', 'edit'],
                ],
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
