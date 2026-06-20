<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permission catalog — every gate string used anywhere in the codebase,
     * grouped by feature area. When you add a new admin section, append
     * its permission here and re-run `php artisan db:seed --class=RolePermissionSeeder`
     * — Super Admin will inherit it automatically because the seeder syncs
     * ALL permissions to that role on every run.
     */
    protected array $permissionGroups = [
        'Dashboard' => [
            'view-dashboard',
        ],
        'Access Control' => [
            'manage-users',
            'manage-roles',
            'manage-permissions',
        ],
        'Multi-Tenancy' => [
            'manage-company',
            'manage-company-requests',
        ],
        'Property Management' => [
            'manage-properties',
            'manage-amenities',
            'manage-locations',
            'manage-property-categories',
            'manage-property-details',
            'manage-property-requests',
            'manage-terms-conditions',
            'manage-contact-inquiries',
            'manage-tags',
        ],
        'Content Management' => [
            'manage-slider',
            'manage-service',
            'manage-client-review',
            'manage-about-us',
            'manage-article',
        ],
        'System Settings' => [
            'manage-app-settings',
        ],
    ];

    /**
     * Editor role — limited subset suitable for someone who maintains
     * listings without touching access control or app settings.
     */
    protected array $editorPermissions = [
        'view-dashboard',
        'manage-properties',
        'manage-amenities',
        'manage-locations',
        'manage-property-categories',
        'manage-property-details',
        'manage-property-requests',
        'manage-terms-conditions',
        'manage-contact-inquiries',
        'manage-slider',
        'manage-service',
        'manage-client-review',
        'manage-about-us',
        'manage-article',
    ];

    public function run(): void
    {
        // Clear the permission registrar's cache so changes are visible
        // immediately on the next request without `php artisan optimize:clear`.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // --- Permissions ---------------------------------------------------
        $allPermissionNames = collect($this->permissionGroups)
            ->flatten()
            ->unique()
            ->values()
            ->all();

        foreach ($allPermissionNames as $name) {
            Permission::firstOrCreate([
                'name'       => $name,
                'guard_name' => 'web',
            ]);
        }

        // --- Roles ---------------------------------------------------------

        // Super Admin always gets every permission, including any added in
        // future migrations of this catalog.
        $superAdmin = Role::firstOrCreate([
            'name'       => 'Super Admin',
            'guard_name' => 'web',
        ]);
        $superAdmin->syncPermissions(Permission::all());

        // Editor gets a curated subset.
        $editor = Role::firstOrCreate([
            'name'       => 'Editor',
            'guard_name' => 'web',
        ]);
        $editor->syncPermissions(
            Permission::whereIn('name', $this->editorPermissions)->get()
        );

        // Property Admin — typically a company's primary admin, can manage
        // their own listings but not access control or system settings.
        $propertyAdmin = Role::firstOrCreate([
            'name'       => 'Property Admin',
            'guard_name' => 'web',
        ]);
        $propertyAdmin->syncPermissions(
            Permission::whereIn('name', [
                'view-dashboard',
                'manage-properties',
                'manage-property-requests',
                'manage-amenities',
                'manage-locations',
            ])->get()
        );

        // Agent — bare-minimum role for individual sales agents.
        $agent = Role::firstOrCreate([
            'name'       => 'Agent',
            'guard_name' => 'web',
        ]);
        $agent->syncPermissions(
            Permission::whereIn('name', [
                'view-dashboard',
                'manage-properties',
            ])->get()
        );

        // --- Users ---------------------------------------------------------

        // Default Super Admin login. updateOrCreate means re-running the
        // seeder will reset the password to the known value — safe in dev,
        // do NOT run this seeder in production without changing the password.
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('Password@1'),
                'status'    => 'active',
                'is_verified' => true,
            ]
        );
        $admin->syncRoles([$superAdmin->name]);

        // Re-attach role to the optional test user if it exists.
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->syncRoles([$superAdmin->name]);
        }

        $this->command?->info(sprintf(
            'Seeded %d permissions across %d roles. Super Admin has full access.',
            count($allPermissionNames),
            4
        ));
    }
}
