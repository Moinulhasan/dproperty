<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            ['name' => 'Gym', 'icon' => 'fas fa-dumbbell'],
            ['name' => 'Swimming Pool', 'icon' => 'fas fa-swimming-pool'],
            ['name' => 'BBQ Area', 'icon' => 'fas fa-utensils'],
            ['name' => 'Mosque', 'icon' => 'fas fa-mosque'],
            ['name' => 'Community Room', 'icon' => 'fas fa-users'],
            ['name' => 'Generator', 'icon' => 'fas fa-bolt'],
            ['name' => '24*7 Security', 'icon' => 'fas fa-user-shield'],
            ['name' => 'CCTV', 'icon' => 'fas fa-video'],
            ['name' => 'Reception', 'icon' => 'fas fa-concierge-bell'],
            ['name' => 'Gardening Area', 'icon' => 'fas fa-tree'],
            ['name' => 'Broadband Internet', 'icon' => 'fas fa-wifi'],
            ['name' => 'Soundproof Glass', 'icon' => 'fas fa-volume-mute'],
        ];

        foreach ($amenities as $amenity) {
            \App\Models\Amenity::create($amenity);
        }
    }
}
