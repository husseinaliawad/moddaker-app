<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage roles',
            'manage categories',
            'manage courses',
            'manage lessons',
            'manage instructors',
            'manage enrollments',
            'manage certificates',
            'manage pages',
            'manage settings',
            'manage quizzes',
            'manage messages',
        ];

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);
        $instructorRole = Role::query()->firstOrCreate(['name' => 'instructor']);
        Role::query()->firstOrCreate(['name' => 'student']);

        $adminRole->syncPermissions(Permission::all());
        $instructorRole->syncPermissions([
            'manage courses',
            'manage lessons',
            'manage quizzes',
        ]);
    }
}
