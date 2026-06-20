<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Five sample real-estate companies. Idempotent on `name` so re-running
     * the seeder just updates the existing rows rather than inserting
     * duplicates.
     */
    public function run(): void
    {
        $companies = [
            [
                'name'    => 'DProperty Realty',
                'email'   => 'hello@dproperty.com.bd',
                'phone'   => '01712000001',
                'address' => 'House 12, Road 11, Banani, Dhaka 1213',
                'logo'    => 'https://images.unsplash.com/photo-1614849963640-9cc74b2a826f?auto=format&fit=crop&w=300&q=80',
                'status'  => 'active',
            ],
            [
                'name'    => 'Bashundhara Estates Ltd.',
                'email'   => 'info@bashundhara-estates.com.bd',
                'phone'   => '01712000002',
                'address' => 'Block C, Bashundhara R/A, Dhaka 1229',
                'logo'    => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?auto=format&fit=crop&w=300&q=80',
                'status'  => 'active',
            ],
            [
                'name'    => 'Gulshan Property Hub',
                'email'   => 'contact@gulshanproperty.com.bd',
                'phone'   => '01712000003',
                'address' => 'Gulshan Avenue, Gulshan 2, Dhaka 1212',
                'logo'    => 'https://images.unsplash.com/photo-1572021335469-31706a17aaef?auto=format&fit=crop&w=300&q=80',
                'status'  => 'active',
            ],
            [
                'name'    => 'Dhanmondi Homes',
                'email'   => 'sales@dhanmondihomes.com.bd',
                'phone'   => '01712000004',
                'address' => 'Road 27, Dhanmondi, Dhaka 1209',
                'logo'    => 'https://images.unsplash.com/photo-1606857521015-7f9fcf423740?auto=format&fit=crop&w=300&q=80',
                'status'  => 'active',
            ],
            [
                'name'    => 'Uttara Skyline Builders',
                'email'   => 'info@uttarakyline.com.bd',
                'phone'   => '01712000005',
                'address' => 'Sector 4, Uttara, Dhaka 1230',
                'logo'    => 'https://images.unsplash.com/photo-1611926653458-09294b3142bf?auto=format&fit=crop&w=300&q=80',
                'status'  => 'inactive',
            ],
        ];

        foreach ($companies as $row) {
            Company::updateOrCreate(['name' => $row['name']], $row);
        }

        $this->command?->info('Seeded ' . count($companies) . ' companies.');
    }
}
