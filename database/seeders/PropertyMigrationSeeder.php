<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyCategory;

class PropertyMigrationSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();
        foreach ($properties as $property) {
            if ($property->property_type) {
                $category = PropertyCategory::where('name', $property->property_type)->first();
                if ($category) {
                    $property->property_category_id = $category->id;
                    $property->save();
                } else {
                    // Try to find a sensible default or leave as null
                    $res = PropertyCategory::where('name', 'Residential')->first();
                    if ($res) {
                        $property->property_category_id = $res->id;
                        $property->save();
                    }
                }
            }
        }
    }
}
