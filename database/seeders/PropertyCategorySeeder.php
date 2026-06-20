<?php

namespace Database\Seeders;

use App\Models\PropertyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Two top-level groups, each with its own list of types. `firstOrCreate`
        // keyed by name keeps the seeder safe to re-run — no duplicates.
        $categories = [
            'Residential' => [
                'Apartment',
                'House',
                'Villa',
                'Duplex',
                'Studio',
                'Penthouse',
                'Plot/Land',
            ],
            'Commercial' => [
                'Office',
                'Shop',
                'Warehouse',
                'Factory',
                'Showroom',
                'Commercial Land',
            ],
        ];

        $total = 0;
        foreach ($categories as $parentName => $children) {
            $parent = PropertyCategory::firstOrCreate(
                ['name' => $parentName, 'parent_id' => null],
                ['slug' => Str::slug($parentName), 'status' => 1]
            );
            $total++;

            foreach ($children as $childName) {
                PropertyCategory::firstOrCreate(
                    ['name' => $childName, 'parent_id' => $parent->id],
                    ['slug' => Str::slug($childName), 'status' => 1]
                );
                $total++;
            }
        }

        $this->command?->info("Seeded {$total} property categories (parents + children).");
    }
}
