<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Order matters: reference data first (locations, categories,
        // companies, amenities, roles), then properties which look those
        // FKs up at runtime and assign them randomly.
        $this->call([
            RolePermissionSeeder::class,
            LocationSeeder::class,
            PropertyCategorySeeder::class,
            CompanySeeder::class,
            AmenitySeeder::class,
            PropertyDetailSeeder::class,
            ServiceSeeder::class,
            PropertySeeder::class,
        ]);
    }
}
