<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Company;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        // --- Reference data lookups -------------------------------------------------
        // Everything is pulled at runtime so the seeder degrades gracefully on a
        // partially-seeded install. Missing relations just become null on the
        // resulting property rows.
        $amenityIds   = Amenity::pluck('id')->all();
        $locations    = Location::pluck('id', 'name')->all();             // name => id
        $categories   = PropertyCategory::pluck('id', 'name')->all();     // name => id
        $companyIds   = Company::pluck('id')->all();
        // Fall back to the first user if no Super Admin exists.
        $creator      = User::query()->orderBy('id')->first();
        $createdById  = $creator?->id;

        // Stock photos grouped by category — picked at random per property so
        // a re-run produces a different-looking gallery each time.
        $photoBuckets = [
            'apartment' => [
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80',
            ],
            'villa' => [
                'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80',
            ],
            'house' => [
                'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?auto=format&fit=crop&w=1200&q=80',
            ],
            'office' => [
                'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1497366754538-6b1494e7722d?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
            ],
        ];
        $floorPlans = [
            'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80',
        ];

        // --- Property templates -----------------------------------------------------
        // Each entry is a "base" property. The seeder fills in foreign keys,
        // images, slug, and timestamps. property_status uses only Rent/Sell
        // (Buy was removed from the admin panel).
        $templates = [
            // Bashundhara
            ['title' => '3400 SFT Luxurious Full Furnished South Face Apartment 9th Floor',         'category_key' => 'apartment', 'status' => 'Sell', 'location' => 'Bashundhara R/A', 'price' => 41000000, 'bedrooms' => 4, 'bathrooms' => 4, 'area' => 3400, 'furnished' => 'Fully Furnished'],
            ['title' => '1800 SFT 3-Bed Family Apartment with Roof Access',                         'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Bashundhara R/A', 'price' => 55000,    'bedrooms' => 3, 'bathrooms' => 3, 'area' => 1800, 'furnished' => 'Semi Furnished'],

            // Gulshan
            ['title' => 'Premium 2-Bedroom Apartment near Gulshan-2 Circle',                        'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Gulshan',         'price' => 75000,    'bedrooms' => 2, 'bathrooms' => 2, 'area' => 1500, 'furnished' => 'Fully Furnished'],
            ['title' => '4-Bed Penthouse with Panoramic City Views in Gulshan',                     'category_key' => 'villa',     'status' => 'Sell', 'location' => 'Gulshan',         'price' => 95000000, 'bedrooms' => 4, 'bathrooms' => 5, 'area' => 4200, 'furnished' => 'Fully Furnished'],
            ['title' => 'Commercial Office Floor — 3000 SFT in Gulshan Avenue',                     'category_key' => 'office',    'status' => 'Rent', 'location' => 'Gulshan',         'price' => 180000,   'bedrooms' => 0, 'bathrooms' => 2, 'area' => 3000, 'furnished' => 'Semi Furnished'],

            // Banani
            ['title' => 'Stylish 2-Bed Apartment in Banani Block-B',                                'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Banani',          'price' => 45000,    'bedrooms' => 2, 'bathrooms' => 2, 'area' => 1200, 'furnished' => 'Semi Furnished'],
            ['title' => 'Brand New 3-Bed Apartment with Lake View in Banani',                      'category_key' => 'apartment', 'status' => 'Sell', 'location' => 'Banani',          'price' => 28500000, 'bedrooms' => 3, 'bathrooms' => 3, 'area' => 2100, 'furnished' => 'Non Furnished'],

            // Dhanmondi
            ['title' => 'Spacious 4-Bedroom Family Apartment in Dhanmondi',                        'category_key' => 'apartment', 'status' => 'Sell', 'location' => 'Dhanmondi',       'price' => 32000000, 'bedrooms' => 4, 'bathrooms' => 4, 'area' => 2500, 'furnished' => 'Semi Furnished'],
            ['title' => 'Cozy 2-Bedroom near Dhanmondi Lake',                                      'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Dhanmondi',       'price' => 35000,    'bedrooms' => 2, 'bathrooms' => 2, 'area' => 1150, 'furnished' => 'Semi Furnished'],

            // Uttara
            ['title' => 'Modern 3-Bed Apartment in Uttara Sector 4',                                'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Uttara',          'price' => 38000,    'bedrooms' => 3, 'bathrooms' => 2, 'area' => 1400, 'furnished' => 'Non Furnished'],
            ['title' => 'Independent Duplex House in Uttara — 4500 SFT',                           'category_key' => 'house',     'status' => 'Sell', 'location' => 'Uttara',          'price' => 65000000, 'bedrooms' => 5, 'bathrooms' => 5, 'area' => 4500, 'furnished' => 'Non Furnished'],
            ['title' => 'Compact 1-Bed Studio Apartment near Uttara University',                   'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Uttara',          'price' => 18000,    'bedrooms' => 1, 'bathrooms' => 1, 'area' => 650,  'furnished' => 'Fully Furnished'],

            // Mirpur
            ['title' => 'Family 3-Bed Apartment in Mirpur DOHS',                                    'category_key' => 'apartment', 'status' => 'Sell', 'location' => 'Mirpur',          'price' => 18500000, 'bedrooms' => 3, 'bathrooms' => 3, 'area' => 1750, 'furnished' => 'Non Furnished'],
            ['title' => '2-Bed Apartment Walking Distance to Mirpur Metro Station',                'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Mirpur',          'price' => 22000,    'bedrooms' => 2, 'bathrooms' => 2, 'area' => 1000, 'furnished' => 'Semi Furnished'],

            // Mohammadpur
            ['title' => 'Affordable 3-Bedroom Family Apartment in Mohammadpur',                    'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Mohammadpur',     'price' => 24000,    'bedrooms' => 3, 'bathrooms' => 2, 'area' => 1250, 'furnished' => 'Non Furnished'],

            // Bashundhara commercial
            ['title' => '1200 SFT Commercial Office in Bashundhara Block-C',                        'category_key' => 'office',    'status' => 'Rent', 'location' => 'Bashundhara R/A', 'price' => 65000,    'bedrooms' => 0, 'bathrooms' => 1, 'area' => 1200, 'furnished' => 'Semi Furnished'],

            // Misc luxury
            ['title' => 'Luxury 5-Bed Independent Villa with Pool — Purbachal',                    'category_key' => 'villa',     'status' => 'Sell', 'location' => 'Purbachal',       'price' => 125000000,'bedrooms' => 5, 'bathrooms' => 6, 'area' => 5500, 'furnished' => 'Fully Furnished'],

            // Rent extras
            ['title' => 'Bright South-Facing 3-Bed Apartment with Backup Generator',               'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Banani',          'price' => 60000,    'bedrooms' => 3, 'bathrooms' => 3, 'area' => 1850, 'furnished' => 'Semi Furnished'],
            ['title' => 'Quiet 2-Bed Family Apartment in Dhanmondi Lakeside',                      'category_key' => 'apartment', 'status' => 'Rent', 'location' => 'Dhanmondi',       'price' => 42000,    'bedrooms' => 2, 'bathrooms' => 2, 'area' => 1280, 'furnished' => 'Fully Furnished'],
        ];

        $now = now();

        foreach ($templates as $i => $tpl) {
            // Pick photos for the gallery — first one becomes feature_image,
            // the rest go into the images[] array.
            $bucket  = $photoBuckets[$tpl['category_key']] ?? $photoBuckets['apartment'];
            $shuffle = collect($bucket)->shuffle()->all();
            $feature = $shuffle[0];
            $gallery = array_slice($shuffle, 1, 4);

            // Foreign-key resolution with graceful fallbacks.
            $locationId = $locations[$tpl['location']] ?? null;
            $categoryId = null;
            if (isset($categories['Apartment'])      && $tpl['category_key'] === 'apartment') $categoryId = $categories['Apartment'];
            if (isset($categories['Villa'])          && $tpl['category_key'] === 'villa')     $categoryId = $categories['Villa'];
            if (isset($categories['House'])          && $tpl['category_key'] === 'house')     $categoryId = $categories['House'];
            if (isset($categories['Office'])         && $tpl['category_key'] === 'office')    $categoryId = $categories['Office'];
            // Fall back to any random category if the named ones don't exist.
            if (!$categoryId && !empty($categories)) {
                $categoryId = collect($categories)->random();
            }

            $companyId = !empty($companyIds) ? $companyIds[array_rand($companyIds)] : null;

            // ~30% chance home-featured, ~50% chance general-featured.
            $isHomeFeatured     = (mt_rand(1, 100) <= 30) ? 1 : 0;
            $isFeatured         = (mt_rand(1, 100) <= 50) ? 1 : 0;
            $isLocationFeatured = (mt_rand(1, 100) <= 20) ? 1 : 0;

            $title = $tpl['title'];
            $slug  = Str::slug($title) . '-' . ($now->timestamp + $i);

            $property = Property::create([
                'title'                 => $title,
                'slug'                  => $slug,
                'price'                 => $tpl['price'],
                'property_category_id'  => $categoryId,
                'property_type'         => ucfirst($tpl['category_key']),
                'category'              => in_array($tpl['category_key'], ['office']) ? 'Commercial' : 'Residential',
                'property_status'       => $tpl['status'], // Rent | Sell
                'description'           => "<p>{$title}.</p><p>A well-maintained property featuring "
                    . "{$tpl['bedrooms']} bedrooms, {$tpl['bathrooms']} bathrooms, and a total "
                    . "area of {$tpl['area']} sqft. Located in {$tpl['location']}, this property offers a "
                    . "balance of comfort and accessibility.</p>",
                'project_id'            => 'DP-' . str_pad((string)($i + 100), 4, '0', STR_PAD_LEFT),
                'bedrooms'              => $tpl['bedrooms'],
                'bathrooms'             => $tpl['bathrooms'],
                'area'                  => $tpl['area'],
                'is_furnished'          => $tpl['furnished'],

                'location_id'           => $locationId,
                'route'                 => $tpl['location'],
                'sub_route'             => null,
                'road'                  => 'Road ' . mt_rand(1, 32),
                'lane'                  => null,

                'images'                => $gallery,
                'feature_image'         => $feature,
                'floor_plan'            => $floorPlans[array_rand($floorPlans)],
                'video_link'            => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'map_link'              => null,

                'is_featured'           => $isFeatured,
                'is_home_featured'      => $isHomeFeatured,
                'is_location_featured'  => $isLocationFeatured,
                'apply_watermark'       => 1,

                'company_id'            => $companyId,
                'created_by'            => $createdById,
                'status'                => 1,
                'link'                  => '#',
            ]);

            // Attach 3-6 random amenities (no-op when amenities table is empty).
            if (!empty($amenityIds)) {
                $count = min(count($amenityIds), mt_rand(3, 6));
                $picks = collect($amenityIds)->shuffle()->take($count)->all();
                $property->amenities()->attach($picks);
            }
        }

        $this->command?->info('Seeded ' . count($templates) . ' dummy properties.');
    }
}
