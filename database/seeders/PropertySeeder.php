<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenityIds = \App\Models\Amenity::pluck('id')->toArray();
        
        $properties = [
            [
                'title' => 'Luxury Villa in Beverly Hills',
                'slug' => 'luxury-villa-beverly-hills',
                'price' => 45000000.00,
                'category' => 'Residential',
                'property_type' => 'Luxury Villa',
                'property_status' => 'For Sale',
                'route' => 'Banani',
                'sub_route' => 'Block E',
                'road' => 'Road 11',
                'lane' => 'Lane 2',
                'project_id' => 'DP-9981',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 3200,
                'is_furnished' => 'Fully Furnished',
                'images' => [
                    'https://images.unsplash.com/photo-1580587767526-d3c811e7399a?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80'
                ],
                'floor_plan' => 'https://images.unsplash.com/photo-1541888941255-081d746efdea?auto=format&fit=crop&w=800',
                'video_link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'map_link' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14604.424273874415!2d90.4072837!3d23.7963318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c70bb8e0c83d%3A0xeef609618f08a8a6!2sBanani%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1710000000000!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'is_featured' => true,
                'status' => 1,
                'link' => '#',
            ],
            [
                'title' => 'Minimalist Apartment in Manhattan',
                'slug' => 'minimalist-apartment-manhattan',
                'price' => 22000000.00,
                'category' => 'Residential',
                'property_type' => 'Apartment',
                'property_status' => 'For Sale',
                'route' => 'Gulshan',
                'sub_route' => 'Gulshan 2',
                'road' => 'Road 45',
                'lane' => null,
                'project_id' => 'DP-8872',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 1100,
                'is_furnished' => 'Semi Furnished',
                'images' => [
                    'https://images.unsplash.com/photo-1600566753190-17f0bb2a6c3e?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1600585154340-be6199fbfd0b?auto=format&fit=crop&w=800&q=80'
                ],
                'is_featured' => true,
                'status' => 1,
                'link' => '#',
            ],
            [
                'title' => 'Modern City Apartment',
                'slug' => 'modern-city-apartment',
                'price' => 45000.00,
                'category' => 'Residential',
                'property_type' => 'Apartment',
                'property_status' => 'For Rent',
                'route' => 'Uttara',
                'sub_route' => 'Sector 4',
                'road' => 'Road 12',
                'lane' => 'House 5',
                'project_id' => 'DP-4421',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 950,
                'is_furnished' => 'Semi Furnished',
                'images' => [
                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=800&q=80'
                ],
                'is_featured' => true,
                'status' => 1,
                'link' => '#',
            ],
            [
                'title' => 'Premium Office Hub',
                'slug' => 'premium-office-hub',
                'price' => 85000000.00,
                'category' => 'Commercial',
                'property_type' => 'Office Space',
                'property_status' => 'For Sale',
                'route' => 'Dhanmondi',
                'sub_route' => 'Road 27',
                'road' => 'Satmasjid Road',
                'lane' => null,
                'project_id' => 'DP-7763',
                'bedrooms' => 8,
                'bathrooms' => 2,
                'area' => 4500,
                'is_furnished' => 'Fully Furnished',
                'images' => [
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1497366754538-6b1494e7722d?auto=format&fit=crop&w=800&q=80'
                ],
                'is_featured' => false,
                'status' => 1,
                'link' => '#',
            ],
        ];

        foreach ($properties as $propertyData) {
            $property = \App\Models\Property::create($propertyData);
            
            // Randomly attach 4-6 amenities
            $randomAmenityIds = array_rand(array_flip($amenityIds), rand(4, 8));
            $property->amenities()->attach($randomAmenityIds);
        }
    }
}
