<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage-users',
            'manage-properties',
            'manage-amenities',
            'manage-roles',
            'manage-permissions',
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $editorRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Editor']);
        $editorRole->syncPermissions(['manage-properties', 'manage-amenities', 'view-dashboard']);

        // Create/Update Super Admin User
        $adminUser = \App\Models\User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => \Hash::make('Password@1'),
            ]
        );
        $adminUser->assignRole($adminRole);

        // Assign Role to Test User (optional, keeping for backward compatibility if needed)
        $testUser = \App\Models\User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->assignRole($adminRole);
        }
    }
}
