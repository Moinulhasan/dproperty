<?php

namespace Database\Seeders;

use App\Models\PropertyDetail;
use Illuminate\Database\Seeder;

class PropertyDetailSeeder extends Seeder
{
    /**
     * The dynamic property-detail fields shown to admins on the property
     * add/edit form. Order is taken straight from the live admin panel
     * reference (10, 14, 16, …, 40 — sparsely spaced so additional fields
     * can be inserted between existing ones later).
     *
     * Icons use FontAwesome 5/6 free classes — pick a replacement in the
     * admin UI if you've swapped icon libraries.
     */
    public function run(): void
    {
        $details = [
            ['name' => 'SFT',           'icon' => 'fas fa-rss',                 'input_type' => 'text',   'sort_order' => 10],
            ['name' => 'Bedroom',       'icon' => 'fas fa-bed',                 'input_type' => 'text',   'sort_order' => 14],
            ['name' => 'Bathroom',      'icon' => 'fas fa-bath',                'input_type' => 'text',   'sort_order' => 16],
            ['name' => 'Balcony',       'icon' => 'fas fa-wallet',              'input_type' => 'text',   'sort_order' => 18],
            ['name' => 'Parking',       'icon' => 'fas fa-car',                 'input_type' => 'text',   'sort_order' => 20],
            ['name' => 'Generator',     'icon' => 'fas fa-bolt',                'input_type' => 'text',   'sort_order' => 22],
            ['name' => 'Lift',          'icon' => 'fas fa-arrow-up',            'input_type' => 'text',   'sort_order' => 24],
            ['name' => 'Gas',           'icon' => 'fas fa-fire',                'input_type' => 'text',   'sort_order' => 26],
            ['name' => 'Facing',        'icon' => 'fas fa-thumbs-up',           'input_type' => 'text',   'sort_order' => 28],
            ['name' => 'Unit',          'icon' => 'fas fa-arrows-alt',          'input_type' => 'text',   'sort_order' => 30],
            ['name' => 'Servant Bed',   'icon' => 'fas fa-bed',                 'input_type' => 'text',   'sort_order' => 32],
            ['name' => 'Servant Bath',  'icon' => 'fas fa-shower',              'input_type' => 'text',   'sort_order' => 34],
            ['name' => 'Floor No',      'icon' => 'fas fa-building',            'input_type' => 'text',   'sort_order' => 36],
            ['name' => 'Total Floor',   'icon' => 'fas fa-city',                'input_type' => 'text',   'sort_order' => 38],
            ['name' => 'HandOver Year', 'icon' => 'far fa-calendar-alt',        'input_type' => 'number', 'sort_order' => 40],
        ];

        foreach ($details as $row) {
            PropertyDetail::updateOrCreate(
                ['name' => $row['name']],
                [
                    'icon'       => $row['icon'],
                    'input_type' => $row['input_type'],
                    'options'    => null,
                    'sort_order' => $row['sort_order'],
                    'status'     => 1,
                ]
            );
        }

        $this->command?->info('Seeded ' . count($details) . ' property detail fields.');
    }
}
