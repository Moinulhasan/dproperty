<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Residential' => [
                'Apartment',
                'House',
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
            ]
        ];

        foreach ($categories as $parentName => $children) {
            $parent = \App\Models\PropertyCategory::create([
                'name' => $parentName,
                'slug' => \Str::slug($parentName),
                'parent_id' => null,
            ]);

            foreach ($children as $childName) {
                \App\Models\PropertyCategory::create([
                    'name' => $childName,
                    'slug' => \Str::slug($childName),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
