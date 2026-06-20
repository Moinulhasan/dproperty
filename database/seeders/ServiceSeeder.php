<?php

namespace Database\Seeders;

use App\Models\Services;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * 6 sample services covering the typical real-estate offerings.
     * Idempotent on `title` so re-running just refreshes images / order
     * instead of duplicating rows.
     */
    public function run(): void
    {
        // Owner of these seeded services — fall back to the first user when
        // there's no admin yet so the user_id NOT NULL constraint is met.
        $userId = User::query()->orderBy('id')->value('id');

        if (!$userId) {
            $this->command?->warn('ServiceSeeder skipped — no users in the database yet. Run RolePermissionSeeder first.');
            return;
        }

        $services = [
            [
                'title'       => 'Buy a Property',
                'description' => 'Looking to buy your dream home or invest in real estate? Our verified listings, transparent pricing, and end-to-end support make purchasing a property simple, safe, and rewarding.',
                'image'       => 'services/buy-property.jpg',
                'imageUrl'    => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title'       => 'Sell a Property',
                'description' => 'Get the best value for your property. We help you list, market, and sell with verified buyers, professional photography, and dedicated agent support every step of the way.',
                'image'       => 'services/sell-property.jpg',
                'imageUrl'    => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title'       => 'Rent a Property',
                'description' => 'Find the perfect rental that fits your lifestyle and budget. Browse furnished, semi-furnished, and unfurnished options across every major Dhaka neighborhood with verified landlords.',
                'image'       => 'services/rent-property.jpg',
                'imageUrl'    => 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title'       => 'Property Management',
                'description' => 'Hands-off ownership made easy. From tenant screening and rent collection to maintenance coordination, we manage your property so you can focus on what matters.',
                'image'       => 'services/property-management.jpg',
                'imageUrl'    => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title'       => 'Property Valuation',
                'description' => 'Know exactly what your property is worth. Our certified valuers provide accurate, market-driven assessments backed by recent comparable sales and neighborhood trends.',
                'image'       => 'services/valuation.jpg',
                'imageUrl'    => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'title'       => 'Legal & Documentation',
                'description' => 'Navigate property paperwork with confidence. We handle title verification, deeds, mutation, and registration so every transaction is legally watertight.',
                'image'       => 'services/legal.jpg',
                'imageUrl'    => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($services as $i => $row) {
            // Image is stored as a relative-to-storage path; the model's
            // getImageAttribute() wraps it with asset('storage/...') at read
            // time. For seed data we just store the Unsplash URL directly —
            // a quick way to demo without a real file upload. Switch to the
            // local path when you have real assets.
            Services::updateOrCreate(
                ['title' => $row['title']],
                [
                    'description' => $row['description'],
                    'image'       => $row['imageUrl'], // accessor will not re-wrap if it's already a full URL on read
                    'status'      => 1,
                    'order'       => $i + 1,
                    'user_id'     => $userId,
                ]
            );
        }

        $this->command?->info('Seeded ' . count($services) . ' services.');
    }
}
