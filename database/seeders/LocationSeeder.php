<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Major Dhaka and nearby neighborhoods commonly seen on real-estate
     * platforms. `order` is set explicitly so the public-site location
     * carousel renders in a predictable sequence regardless of insertion
     * order.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'Gulshan',         'image' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Banani',          'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Bashundhara R/A', 'image' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Dhanmondi',       'image' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Uttara',          'image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Mirpur',          'image' => 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Mohammadpur',     'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Bashabo',         'image' => 'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Tejgaon',         'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Khilgaon',        'image' => 'https://images.unsplash.com/photo-1497366754538-6b1494e7722d?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Purbachal',       'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Savar',           'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80'],
        ];

        foreach ($locations as $i => $row) {
            Location::updateOrCreate(
                ['name' => $row['name']],
                [
                    'image'  => $row['image'],
                    'status' => 1,
                    'order'  => $i + 1,
                ]
            );
        }

        $this->command?->info('Seeded ' . count($locations) . ' locations.');
    }
}
